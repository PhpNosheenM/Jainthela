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
		$SundryCredior = $this->Ledgers->AccountingGroups->find('all')->where(['supplier'=>1])->first();
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
