<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Ledgers Controller
 *
 * @property \App\Model\Table\LedgersTable $Ledgers
 *
 * @method \App\Model\Entity\Ledger[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LedgersController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id'); 
		$location_id=$this->Auth->User('location_id'); 
		$this->viewBuilder()->layout('admin_portal');
		$ledger = $this->Ledgers->newEntity();
        $this->paginate = [
            'contain' => ['AccountingGroups'],
			'limit' => 20
        ];
		
		if ($this->request->is(['post','put'])) 
		{
            $ledger->name = $this->request->getData()['name'];
            $ledger->accounting_group_id = $this->request->getData()['accounting_group_id'];
            $ledger->opening_balance_value = $this->request->getData()['opening_balance_value'];
            $ledger->debit_credit = $this->request->getData()['debit_credit'];
			$data=$this->Ledgers->Locations->get($location_id);
			$ledger->location_id = $location_id;
			//pr($data->books_beginning_from); exit;
			//pr($ledger); exit;
            if ($this->Ledgers->save($ledger)) 
			{
				if($ledger->opening_balance_value > 0){
					$transaction_date=$data->books_beginning_from;
					$AccountingEntry = $this->Ledgers->AccountingEntries->newEntity();
					$AccountingEntry->ledger_id = $ledger->id;
					if($ledger->debit_credit=="Dr")
					{
						$AccountingEntry->debit = $ledger->opening_balance_value;
					}
					if($ledger->debit_credit=="Cr")
					{
						$AccountingEntry->credit = $ledger->opening_balance_value;
					}
					$AccountingEntry->transaction_date      = date("Y-m-d",strtotime($transaction_date));
					$AccountingEntry->company_id            = $company_id;
					$AccountingEntry->is_opening_balance    = 'yes';
					$this->Ledgers->AccountingEntries->save($AccountingEntry);
				}
				
                $this->Flash->success(__('The ledger has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The ledger could not be saved. Please, try again.'));
        }
		
		$SundryDebtor = $this->Ledgers->AccountingGroups->find('all')->where(['customer'=>1])->first();
		$accountingGroupdebitors = $this->Ledgers->AccountingGroups
							->find('children', ['for' => $SundryDebtor->id])
							->find('all');
		$debtorArray=[];
		foreach($accountingGroupdebitors as $accountingGroupdebitor)
		{ 
			$debtorArray[]= $accountingGroupdebitor->id;
		}
		$datadebtor[]=$SundryDebtor->id;
		$SundryCredior = $this->Ledgers->AccountingGroups->find('all')->where(['seller'=>1])->first();
		$accountingGroupcreditors = $this->Ledgers->AccountingGroups
							->find('children', ['for' => $SundryCredior->id])
							->find('all');
		$creditorArray=[];
		foreach($accountingGroupcreditors as $accountingGroupcreditor)
		{ 
			$creditorArray[]= $accountingGroupcreditor->id;
		}
		$datacreditor[]=$SundryCredior->id;
		$alldebtors=array_merge($datadebtor,$debtorArray,$datacreditor,$creditorArray);
		$accountingGroups = $this->Ledgers->AccountingGroups->find('list')->where(['id NOT IN'=>$alldebtors]);
        $ledgers = $this->paginate($this->Ledgers);
		
		$paginate_limit=$this->paginate['limit'];
        $this->set(compact('ledgers','paginate_limit','accountingGroups'));
    }

    /**
     * View method
     *
     * @param string|null $id Ledger id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $ledger = $this->Ledgers->get($id, [
            'contain' => ['AccountingGroups', 'Locations', 'Suppliers', 'Customers', 'GstFigures', 'AccountingEntries', 'CreditNoteRows', 'DebitNoteRows', 'JournalVoucherRows', 'PaymentRows', 'PurchaseVoucherRows', 'ReceiptRows', 'ReferenceDetails', 'SalesVoucherRows']
        ]);

        $this->set('ledger', $ledger);
    }
	
	public function trialBalance($id = null)
    {
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id'); 
		$location_id=$this->Auth->User('location_id'); 
		$this->viewBuilder()->layout('admin_portal');
		$from_date = $this->request->query('from_date');
		$to_date   = $this->request->query('to_date');
		$from_date = date("Y-m-d",strtotime($from_date));
		$to_date   = date("Y-m-d",strtotime($to_date));
		
		$AccountingGroups=$this->Ledgers->AccountingGroups->find()->where(['AccountingGroups.nature_of_group_id IN'=>[1,2,3,4]]);
		
		$Groups=[]; $ledgerData=[];
		foreach($AccountingGroups as $AccountingGroup){
			$Groups[$AccountingGroup->id]['ids'][]=$AccountingGroup->id;
			$Groups[$AccountingGroup->id]['name']=$AccountingGroup->name;
			$Groups[$AccountingGroup->id]['nature']=$AccountingGroup->nature_of_group_id;
			$accountingChildGroups = $this->Ledgers->AccountingEntries->Ledgers->AccountingGroups->find('children', ['for' => $AccountingGroup->id]);
			foreach($accountingChildGroups as $accountingChildGroup){
				$Groups[$AccountingGroup->id]['ids'][]=$accountingChildGroup->id;
				//$ledgerData[$AccountingGroup->id]=$AccountingGroup->name;
			}
		}
		
		$AllGroups=[];
		foreach($Groups as $mainGroups){
			foreach($mainGroups['ids'] as $subGroup){
				$AllGroups[]=$subGroup;
			}
		}
		
		$query=$this->Ledgers->AccountingEntries->find();
		
		$query->select(['ledger_id','totalDebit' => $query->func()->sum('AccountingEntries.debit'),'totalCredit' => $query->func()->sum('AccountingEntries.credit')])
				->group('AccountingEntries.ledger_id')
				->where(['AccountingEntries.location_id'=>$location_id, 'AccountingEntries.transaction_date <='=>$to_date])
				->contain(['Ledgers'=>function($q){
					return $q->select(['Ledgers.accounting_group_id','Ledgers.id']);
				}]);
		$query->matching('Ledgers', function ($q) use($AllGroups){
			return $q->where(['Ledgers.accounting_group_id IN' => $AllGroups]);
		});
		$balanceOfLedgers=$query;
		$ClosingBalanceForPrint=[];
		foreach($balanceOfLedgers as $balanceOfLedger){
			foreach($Groups as $primaryGroup=>$Group){
				if(in_array($balanceOfLedger->ledger->accounting_group_id,$Group['ids'])){
					@$ClosingBalanceForPrint[$primaryGroup]['balance']+=$balanceOfLedger->totalDebit-abs($balanceOfLedger->totalCredit);
				}else{
					@$ClosingBalanceForPrint[$primaryGroup]['balance']+=0;
				}
				@$ClosingBalanceForPrint[$primaryGroup]['name']=$Group['name'];
				@$ClosingBalanceForPrint[$primaryGroup]['nature']=$Group['nature'];
			}
		} 
		
		$query1=$this->Ledgers->AccountingEntries->find();
		$query1->select(['ledger_id','totalDebit' => $query1->func()->sum('AccountingEntries.debit'),'totalCredit' => $query1->func()->sum('AccountingEntries.credit')])
				->group('AccountingEntries.ledger_id')
				->where(['AccountingEntries.location_id'=>$location_id, 'AccountingEntries.transaction_date <='=>$from_date])
				->contain(['Ledgers'=>function($q){
					return $q->select(['Ledgers.accounting_group_id','Ledgers.id']);
				}]);
		$query1->matching('Ledgers', function ($q) use($AllGroups){
			return $q->where(['Ledgers.accounting_group_id IN' => $AllGroups]);
		});
		$balanceOfLedgers=$query1;
		$OpeningBalanceForPrint=[];
		foreach($balanceOfLedgers as $balanceOfLedger){
			foreach($Groups as $primaryGroup=>$Group){
				if(in_array($balanceOfLedger->ledger->accounting_group_id,$Group['ids'])){
					@$OpeningBalanceForPrint[$primaryGroup]['balance']+=$balanceOfLedger->totalDebit-$balanceOfLedger->totalCredit;
				}else{
					@$OpeningBalanceForPrint[$primaryGroup]['balance']+=0;
				}
			}
		}
		
		$query2=$this->Ledgers->AccountingEntries->find();
		$query2->select(['ledger_id','totalDebit' => $query2->func()->sum('AccountingEntries.debit'),'totalCredit' => $query2->func()->sum('AccountingEntries.credit')])
				->group('AccountingEntries.ledger_id')
				->where(['AccountingEntries.location_id'=>$location_id, 'AccountingEntries.transaction_date >'=>$from_date, 'AccountingEntries.transaction_date <='=>$to_date])
				->contain(['Ledgers'=>function($q){
					return $q->select(['Ledgers.accounting_group_id','Ledgers.id']);
				}]);
		$query2->matching('Ledgers', function ($q) use($AllGroups){
			return $q->where(['Ledgers.accounting_group_id IN' => $AllGroups]);
		});
		$balanceOfLedgers=$query2;
		$TransactionsDr=[];
		$TransactionsCr=[];
		foreach($balanceOfLedgers as $balanceOfLedger){
			foreach($Groups as $primaryGroup=>$Group){
				if(in_array($balanceOfLedger->ledger->accounting_group_id,$Group['ids'])){
					@$TransactionsDr[$primaryGroup]['balance']+=$balanceOfLedger->totalDebit;
					@$TransactionsCr[$primaryGroup]['balance']+=$balanceOfLedger->totalCredit;
				}else{
					@$OpeningBalanceForPrint[$primaryGroup]['balance']+=0;
				}
			}
		}
		
		//pr($TransactionsDr); exit;
		//pr($query->toArray()); exit;
		//	$openingValue= $this->StockValuationWithDate($from_date);
		$openingValue= 0;
		$this->set(compact('companies','ledger','from_date','to_date','TrialBalances','totalDebit','status','url','ClosingBalanceForPrint','OpeningBalanceForPrint','TransactionsCr','TransactionsDr','openingValue'));
		//pr	($AccountingGroups->toArray()); exit;
		
	}

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $ledger = $this->Ledgers->newEntity();
        if ($this->request->is('post')) {
            $ledger = $this->Ledgers->patchEntity($ledger, $this->request->getData());
            if ($this->Ledgers->save($ledger)) {
                $this->Flash->success(__('The ledger has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The ledger could not be saved. Please, try again.'));
        }
        $accountingGroups = $this->Ledgers->AccountingGroups->find('list', ['limit' => 200]);
        $locations = $this->Ledgers->Locations->find('list', ['limit' => 200]);
        $suppliers = $this->Ledgers->Suppliers->find('list', ['limit' => 200]);
        $customers = $this->Ledgers->Customers->find('list', ['limit' => 200]);
        $gstFigures = $this->Ledgers->GstFigures->find('list', ['limit' => 200]);
        $this->set(compact('ledger', 'accountingGroups', 'locations', 'suppliers', 'customers', 'gstFigures'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Ledger id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $ledger = $this->Ledgers->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $ledger = $this->Ledgers->patchEntity($ledger, $this->request->getData());
            if ($this->Ledgers->save($ledger)) {
                $this->Flash->success(__('The ledger has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The ledger could not be saved. Please, try again.'));
        }
        $accountingGroups = $this->Ledgers->AccountingGroups->find('list', ['limit' => 200]);
        $locations = $this->Ledgers->Locations->find('list', ['limit' => 200]);
        $suppliers = $this->Ledgers->Suppliers->find('list', ['limit' => 200]);
        $customers = $this->Ledgers->Customers->find('list', ['limit' => 200]);
        $gstFigures = $this->Ledgers->GstFigures->find('list', ['limit' => 200]);
        $this->set(compact('ledger', 'accountingGroups', 'locations', 'suppliers', 'customers', 'gstFigures'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Ledger id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $ledger = $this->Ledgers->get($id);
        if ($this->Ledgers->delete($ledger)) {
            $this->Flash->success(__('The ledger has been deleted.'));
        } else {
            $this->Flash->error(__('The ledger could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
