<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * AccountingEntries Controller
 *
 * @property \App\Model\Table\AccountingEntriesTable $AccountingEntries
 *
 * @method \App\Model\Entity\AccountingEntry[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AccountingEntriesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Ledgers', 'Locations', 'Cities', 'PurchaseVouchers', 'PurchaseVoucherRows', 'SalesInvoices', 'SaleReturns', 'PurchaseInvoices', 'PurchaseReturns', 'Receipts', 'ReceiptRows', 'Payments', 'PaymentRows', 'CreditNotes', 'CreditNoteRows', 'DebitNotes', 'DebitNoteRows', 'SalesVouchers', 'SalesVoucherRows', 'JournalVouchers', 'JournalVoucherRows', 'ContraVouchers', 'ContraVoucherRows']
        ];
        $accountingEntries = $this->paginate($this->AccountingEntries);

        $this->set(compact('accountingEntries'));
    }

    /**
     * View method
     *
     * @param string|null $id Accounting Entry id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $accountingEntry = $this->AccountingEntries->get($id, [
            'contain' => ['Ledgers', 'Locations', 'Cities', 'PurchaseVouchers', 'PurchaseVoucherRows', 'SalesInvoices', 'SaleReturns', 'PurchaseInvoices', 'PurchaseReturns', 'Receipts', 'ReceiptRows', 'Payments', 'PaymentRows', 'CreditNotes', 'CreditNoteRows', 'DebitNotes', 'DebitNoteRows', 'SalesVouchers', 'SalesVoucherRows', 'JournalVouchers', 'JournalVoucherRows', 'ContraVouchers', 'ContraVoucherRows']
        ]);

        $this->set('accountingEntry', $accountingEntry);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $accountingEntry = $this->AccountingEntries->newEntity();
        if ($this->request->is('post')) {
            $accountingEntry = $this->AccountingEntries->patchEntity($accountingEntry, $this->request->getData());
            if ($this->AccountingEntries->save($accountingEntry)) {
                $this->Flash->success(__('The accounting entry has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The accounting entry could not be saved. Please, try again.'));
        }
        $ledgers = $this->AccountingEntries->Ledgers->find('list', ['limit' => 200]);
        $locations = $this->AccountingEntries->Locations->find('list', ['limit' => 200]);
        $cities = $this->AccountingEntries->Cities->find('list', ['limit' => 200]);
        $purchaseVouchers = $this->AccountingEntries->PurchaseVouchers->find('list', ['limit' => 200]);
        $purchaseVoucherRows = $this->AccountingEntries->PurchaseVoucherRows->find('list', ['limit' => 200]);
        $salesInvoices = $this->AccountingEntries->SalesInvoices->find('list', ['limit' => 200]);
        $saleReturns = $this->AccountingEntries->SaleReturns->find('list', ['limit' => 200]);
        $purchaseInvoices = $this->AccountingEntries->PurchaseInvoices->find('list', ['limit' => 200]);
        $purchaseReturns = $this->AccountingEntries->PurchaseReturns->find('list', ['limit' => 200]);
        $receipts = $this->AccountingEntries->Receipts->find('list', ['limit' => 200]);
        $receiptRows = $this->AccountingEntries->ReceiptRows->find('list', ['limit' => 200]);
        $payments = $this->AccountingEntries->Payments->find('list', ['limit' => 200]);
        $paymentRows = $this->AccountingEntries->PaymentRows->find('list', ['limit' => 200]);
        $creditNotes = $this->AccountingEntries->CreditNotes->find('list', ['limit' => 200]);
        $creditNoteRows = $this->AccountingEntries->CreditNoteRows->find('list', ['limit' => 200]);
        $debitNotes = $this->AccountingEntries->DebitNotes->find('list', ['limit' => 200]);
        $debitNoteRows = $this->AccountingEntries->DebitNoteRows->find('list', ['limit' => 200]);
        $salesVouchers = $this->AccountingEntries->SalesVouchers->find('list', ['limit' => 200]);
        $salesVoucherRows = $this->AccountingEntries->SalesVoucherRows->find('list', ['limit' => 200]);
        $journalVouchers = $this->AccountingEntries->JournalVouchers->find('list', ['limit' => 200]);
        $journalVoucherRows = $this->AccountingEntries->JournalVoucherRows->find('list', ['limit' => 200]);
        $contraVouchers = $this->AccountingEntries->ContraVouchers->find('list', ['limit' => 200]);
        $contraVoucherRows = $this->AccountingEntries->ContraVoucherRows->find('list', ['limit' => 200]);
        $this->set(compact('accountingEntry', 'ledgers', 'locations', 'cities', 'purchaseVouchers', 'purchaseVoucherRows', 'salesInvoices', 'saleReturns', 'purchaseInvoices', 'purchaseReturns', 'receipts', 'receiptRows', 'payments', 'paymentRows', 'creditNotes', 'creditNoteRows', 'debitNotes', 'debitNoteRows', 'salesVouchers', 'salesVoucherRows', 'journalVouchers', 'journalVoucherRows', 'contraVouchers', 'contraVoucherRows'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Accounting Entry id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $accountingEntry = $this->AccountingEntries->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $accountingEntry = $this->AccountingEntries->patchEntity($accountingEntry, $this->request->getData());
            if ($this->AccountingEntries->save($accountingEntry)) {
                $this->Flash->success(__('The accounting entry has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The accounting entry could not be saved. Please, try again.'));
        }
        $ledgers = $this->AccountingEntries->Ledgers->find('list', ['limit' => 200]);
        $locations = $this->AccountingEntries->Locations->find('list', ['limit' => 200]);
        $cities = $this->AccountingEntries->Cities->find('list', ['limit' => 200]);
        $purchaseVouchers = $this->AccountingEntries->PurchaseVouchers->find('list', ['limit' => 200]);
        $purchaseVoucherRows = $this->AccountingEntries->PurchaseVoucherRows->find('list', ['limit' => 200]);
        $salesInvoices = $this->AccountingEntries->SalesInvoices->find('list', ['limit' => 200]);
        $saleReturns = $this->AccountingEntries->SaleReturns->find('list', ['limit' => 200]);
        $purchaseInvoices = $this->AccountingEntries->PurchaseInvoices->find('list', ['limit' => 200]);
        $purchaseReturns = $this->AccountingEntries->PurchaseReturns->find('list', ['limit' => 200]);
        $receipts = $this->AccountingEntries->Receipts->find('list', ['limit' => 200]);
        $receiptRows = $this->AccountingEntries->ReceiptRows->find('list', ['limit' => 200]);
        $payments = $this->AccountingEntries->Payments->find('list', ['limit' => 200]);
        $paymentRows = $this->AccountingEntries->PaymentRows->find('list', ['limit' => 200]);
        $creditNotes = $this->AccountingEntries->CreditNotes->find('list', ['limit' => 200]);
        $creditNoteRows = $this->AccountingEntries->CreditNoteRows->find('list', ['limit' => 200]);
        $debitNotes = $this->AccountingEntries->DebitNotes->find('list', ['limit' => 200]);
        $debitNoteRows = $this->AccountingEntries->DebitNoteRows->find('list', ['limit' => 200]);
        $salesVouchers = $this->AccountingEntries->SalesVouchers->find('list', ['limit' => 200]);
        $salesVoucherRows = $this->AccountingEntries->SalesVoucherRows->find('list', ['limit' => 200]);
        $journalVouchers = $this->AccountingEntries->JournalVouchers->find('list', ['limit' => 200]);
        $journalVoucherRows = $this->AccountingEntries->JournalVoucherRows->find('list', ['limit' => 200]);
        $contraVouchers = $this->AccountingEntries->ContraVouchers->find('list', ['limit' => 200]);
        $contraVoucherRows = $this->AccountingEntries->ContraVoucherRows->find('list', ['limit' => 200]);
        $this->set(compact('accountingEntry', 'ledgers', 'locations', 'cities', 'purchaseVouchers', 'purchaseVoucherRows', 'salesInvoices', 'saleReturns', 'purchaseInvoices', 'purchaseReturns', 'receipts', 'receiptRows', 'payments', 'paymentRows', 'creditNotes', 'creditNoteRows', 'debitNotes', 'debitNoteRows', 'salesVouchers', 'salesVoucherRows', 'journalVouchers', 'journalVoucherRows', 'contraVouchers', 'contraVoucherRows'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Accounting Entry id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $accountingEntry = $this->AccountingEntries->get($id);
        if ($this->AccountingEntries->delete($accountingEntry)) {
            $this->Flash->success(__('The accounting entry has been deleted.'));
        } else {
            $this->Flash->error(__('The accounting entry could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
	
	public function BalanceSheet()
    {
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id'); 
		$location_id=$this->Auth->User('location_id'); 
		$this->viewBuilder()->layout('super_admin_layout');
		$from_date = $this->request->query('from_date');
		$to_date   = $this->request->query('to_date');
		$from_date = date("Y-m-d",strtotime($from_date));
		$to_date   = date("Y-m-d",strtotime($to_date));
		if($from_date=="1970-01-01"){
			$from_date = date("Y-m-d");
			$to_date   = date("Y-m-d");
		}
		$AccountingGroups=$this->AccountingEntries->Ledgers->AccountingGroups->find()
		->where(['AccountingGroups.nature_of_group_id IN'=>[1,2],'AccountingGroups.city_id'=>$city_id]);
		$Groups=[];
		foreach($AccountingGroups as $AccountingGroup){
			$Groups[$AccountingGroup->id]['ids'][]=$AccountingGroup->id;
			$Groups[$AccountingGroup->id]['name']=$AccountingGroup->name;
			$Groups[$AccountingGroup->id]['nature']=$AccountingGroup->nature_of_group_id;
			$accountingChildGroups = $this->AccountingEntries->Ledgers->AccountingGroups->find('children', ['for' => $AccountingGroup->id]);
			foreach($accountingChildGroups as $accountingChildGroup){
				$Groups[$AccountingGroup->id]['ids'][]=$accountingChildGroup->id;
			}
		}
		$AllGroups=[];
		foreach($Groups as $mainGroups){
			foreach($mainGroups['ids'] as $subGroup){
				$AllGroups[]=$subGroup;
			}
		}
		
		$query=$this->AccountingEntries->find();
		$query->select(['ledger_id','totalDebit' => $query->func()->sum('AccountingEntries.debit'),'totalCredit' => $query->func()->sum('AccountingEntries.credit')])
				->group('AccountingEntries.ledger_id')
				->where(['AccountingEntries.city_id'=>$city_id,'AccountingEntries.transaction_date >='=>$from_date, 'AccountingEntries.transaction_date <='=>$to_date])
				->contain(['Ledgers'=>function($q){
					return $q->select(['Ledgers.accounting_group_id','Ledgers.id']);
				}]);
		$query->matching('Ledgers', function ($q) use($AllGroups){
			return $q->where(['Ledgers.accounting_group_id IN' => $AllGroups]);
		});
		//pr($query->toArray()); exit;
		$balanceOfLedgers=$query;
		$groupForPrint=[]; $d=[]; $c=[]; 
		foreach($balanceOfLedgers as $balanceOfLedger){
			foreach($Groups as $primaryGroup=>$Group){
				if(in_array($balanceOfLedger->ledger->accounting_group_id,$Group['ids'])){
					@$groupForPrint[$primaryGroup]['balance']+=$balanceOfLedger->totalDebit-abs($balanceOfLedger->totalCredit);
					
				}else{
					@$groupForPrint[$primaryGroup]['balance']+=0;
				}
				@$groupForPrint[$primaryGroup]['name']=$Group['name'];
				@$groupForPrint[$primaryGroup]['nature']=$Group['nature'];
			}
		}
		//pr($city_id); exit;
		$GrossProfit= $this->GrossProfit($from_date,$to_date,$city_id,$location_id);
		$closingValue= $this->stockReportApp($city_id,$from_date,$to_date); 
		$differenceInOpeningBalance= $this->differenceInOpeningBalance($city_id,$location_id);
		$this->set(compact('from_date','to_date', 'groupForPrint', 'closingValue', 'openingValue','GrossProfit','differenceInOpeningBalance'));
		
	}
	
	public function ProfitLossStatement()
    {
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id'); 
		$location_id=$this->Auth->User('location_id'); 
		$this->viewBuilder()->layout('super_admin_layout');
		$from_date = $this->request->query('from_date');
		$to_date   = $this->request->query('to_date');
		$from_date = date("Y-m-d",strtotime($from_date));
		$to_date   = date("Y-m-d",strtotime($to_date));
		if($from_date=="1970-01-01"){
			$from_date = date("Y-m-d");
			$to_date   = date("Y-m-d");
		}
		$AccountingGroups=$this->AccountingEntries->Ledgers->AccountingGroups->find()
		->where(['AccountingGroups.nature_of_group_id IN'=>[3,4],'AccountingGroups.city_id'=>$city_id]);
		$Groups=[];
		foreach($AccountingGroups as $AccountingGroup){
			$Groups[$AccountingGroup->id]['ids'][]=$AccountingGroup->id;
			$Groups[$AccountingGroup->id]['name']=$AccountingGroup->name;
			$Groups[$AccountingGroup->id]['nature']=$AccountingGroup->nature_of_group_id;
			$accountingChildGroups = $this->AccountingEntries->Ledgers->AccountingGroups->find('children', ['for' => $AccountingGroup->id]);
			foreach($accountingChildGroups as $accountingChildGroup){
				$Groups[$AccountingGroup->id]['ids'][]=$accountingChildGroup->id;
			}
		}
		$AllGroups=[];
		foreach($Groups as $mainGroups){
			foreach($mainGroups['ids'] as $subGroup){
				$AllGroups[]=$subGroup;
			}
		}
		
		$query=$this->AccountingEntries->find();
		$query->select(['ledger_id','totalDebit' => $query->func()->sum('AccountingEntries.debit'),'totalCredit' => $query->func()->sum('AccountingEntries.credit')])
				->group('AccountingEntries.ledger_id')
				->where(['AccountingEntries.city_id'=>$city_id,'AccountingEntries.transaction_date >='=>$from_date, 'AccountingEntries.transaction_date <='=>$to_date])
				->contain(['Ledgers'=>function($q){
					return $q->select(['Ledgers.accounting_group_id','Ledgers.id']);
				}]);
		$query->matching('Ledgers', function ($q) use($AllGroups){
			return $q->where(['Ledgers.accounting_group_id IN' => $AllGroups]);
		});
		//pr($query->toArray()); exit;
		$balanceOfLedgers=$query;
		$groupForPrint=[]; $d=[]; $c=[]; 
		foreach($balanceOfLedgers as $balanceOfLedger){
			foreach($Groups as $primaryGroup=>$Group){
				if(in_array($balanceOfLedger->ledger->accounting_group_id,$Group['ids'])){
					@$groupForPrint[$primaryGroup]['balance']+=$balanceOfLedger->totalDebit-abs($balanceOfLedger->totalCredit);
					
				}else{
					@$groupForPrint[$primaryGroup]['balance']+=0;
				}
				@$groupForPrint[$primaryGroup]['name']=$Group['name'];
				@$groupForPrint[$primaryGroup]['nature']=$Group['nature'];
			}
		}
		//pr($groupForPrint); exit;
		$openingValue= 0;
		$closingValue= $this->stockReportApp($city_id,$from_date,$to_date);
		$this->set(compact('from_date','to_date', 'groupForPrint', 'closingValue', 'openingValue'));
		
	}
	public function AccountStatement()
    {
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id'); 
		$location_id=$this->Auth->User('location_id'); 
		$this->viewBuilder()->layout('super_admin_layout');
		$ledger_id = $this->request->query('ledger_id');
		$from_date = $this->request->query('from_date');
		$to_date   = $this->request->query('to_date');
		if(empty($from_date) || empty($to_date))
		{
			$from_date = date("Y-m-01");
			$to_date   = date("Y-m-d");
		}else{
			$from_date = date("Y-m-d",strtotime($from_date));
			$to_date= date("Y-m-d",strtotime($to_date));
		}
		
		if(!empty($from_date))
		{
			$from_date = date("Y-m-d",strtotime($from_date));
			$where['AccountingEntries.transaction_date >=']=$from_date;
		}
		if(!empty($to_date))
		{
			$to_date   = date("Y-m-d",strtotime($to_date));
			$where['AccountingEntries.transaction_date <=']=$to_date;
		}
		
		if(!empty($ledger_id))
		{
			$where['AccountingEntries.ledger_id']=$ledger_id;
		}
		
		if(!empty($ledger_id)){
			$query = $this->AccountingEntries->find()->where(['AccountingEntries.ledger_id'=>$ledger_id]);
			
			$CaseCreditOpeningBalance = $query->newExpr()
						->addCase(
							$query->newExpr()->add(['ledger_id']),
							$query->newExpr()->add(['credit']),
							'decimal'
						);
			$CaseDebitOpeningBalance = $query->newExpr()
						->addCase(
							$query->newExpr()->add(['ledger_id']),
							$query->newExpr()->add(['debit']),
							'decimal'
						); 
			$query->select([
					'debit_opening_balance' => $query->func()->sum($CaseDebitOpeningBalance),
					'credit_opening_balance' => $query->func()->sum($CaseCreditOpeningBalance),
					'id','ledger_id'
				])
				->where(['AccountingEntries.transaction_date <'=>$from_date])
				->group('ledger_id')
				->autoFields(true);
			
			$AccountLedgersOpeningBalance=($query);
			$total_debit=0;
			$total_credit=0;
			foreach($AccountLedgersOpeningBalance as $AccountLedgersOpeningBalance){
				$total_debit=$AccountLedgersOpeningBalance->debit_opening_balance;
				$total_credit=$AccountLedgersOpeningBalance->credit_opening_balance;
			}
			@$opening_balance=$total_debit-$total_credit;
				if($opening_balance>0){
				@$opening_balance_type='Dr';	
				}
				else if($opening_balance<0){
				$opening_balance=abs($opening_balance);
				@$opening_balance_type='Cr';	
				}
				else{
				@$opening_balance_type='';	
				}
			$opening_balance=round($opening_balance,2);
			//pr($opening_balance); exit;
			 $AccountingLedgers=$this->AccountingEntries->find()->select(['total_credit_sum'=>'SUM(AccountingEntries.credit)','total_debit_sum'=>'SUM(AccountingEntries.debit)'])->contain(['Ledgers','PurchaseInvoices','Payments','Orders','Receipts'])->where($where)->group(['AccountingEntries.payment_id','AccountingEntries.purchase_invoice_id','AccountingEntries.payment_id','AccountingEntries.order_id'])->autoFields(true); 
			}
			
			
			//pr($AccountingLedgers->toArray()); exit;	
			$Ledgers=$this->AccountingEntries->Ledgers->find('List')->where(['city_id'=>$city_id]);
			
			$this->set(compact('from_date','to_date', 'groupForPrint', 'closingValue', 'openingValue','Ledgers','AccountingLedgers','ledger_id','opening_balance','opening_balance_type'));
	}
	
	public function gstReport()
    {
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id'); 
		$location_id=$this->Auth->User('location_id'); 
		$this->viewBuilder()->layout('super_admin_layout');
		$ledger_id = $this->request->query('ledger_id');
		$from_date = $this->request->query('from_date');
		$to_date   = $this->request->query('to_date');
		//$from_date   ="2018-04-01";
		//$to_date   ="2019-04-31";
		if(empty($from_date) || empty($to_date))
		{
			$from_date = date("Y-m-01");
			$to_date   = date("Y-m-d");
		}else{
			$from_date = date("Y-m-d",strtotime($from_date));
			$to_date= date("Y-m-d",strtotime($to_date));
		}
		
		// OutPut GST Code
		$AccountingGroupOutputGst=$this->AccountingEntries->Ledgers->AccountingGroups->find()
		->where(['AccountingGroups.input_output_gst'=>'Output','AccountingGroups.city_id'=>$city_id])->first();
		$query=$this->AccountingEntries->find();
		$query->select(['ledger_id','totalDebit' => $query->func()->sum('AccountingEntries.debit'),'totalCredit' => $query->func()->sum('AccountingEntries.credit')])
				->group('AccountingEntries.ledger_id')
				->where(['AccountingEntries.city_id'=>$city_id,'AccountingEntries.transaction_date >='=>$from_date, 'AccountingEntries.transaction_date <='=>$to_date])
				->contain(['Ledgers'=>function($q){
					return $q->select(['Ledgers.accounting_group_id','Ledgers.id','Ledgers.gst_figure_id']);
				}]);
		$query->matching('Ledgers', function ($q) use($AccountingGroupOutputGst){
			return $q->where(['Ledgers.accounting_group_id IN' => $AccountingGroupOutputGst->id,'gst_type !='=>'IGST']);
		});
		$balanceOfLedgers=$query;
		$outputgst=[];
		foreach($balanceOfLedgers as $balanceOfLedger){ 
			if($balanceOfLedger->totalCredit > 0){ 
				@$outputgst[@$balanceOfLedger->ledger->gst_figure_id]+=@$balanceOfLedger->totalCredit;
			}
		} 
		
		
		//OutPut IGST Code
		$AccountingGroupOutputGst=$this->AccountingEntries->Ledgers->AccountingGroups->find()
		->where(['AccountingGroups.input_output_gst'=>'Output','AccountingGroups.city_id'=>$city_id])->first();
		$query=$this->AccountingEntries->find();
		$query->select(['ledger_id','totalDebit' => $query->func()->sum('AccountingEntries.debit'),'totalCredit' => $query->func()->sum('AccountingEntries.credit')])
				->group('AccountingEntries.ledger_id')
				->where(['AccountingEntries.city_id'=>$city_id,'AccountingEntries.transaction_date >='=>$from_date, 'AccountingEntries.transaction_date <='=>$to_date])
				->contain(['Ledgers'=>function($q){
					return $q->select(['Ledgers.accounting_group_id','Ledgers.id','Ledgers.gst_figure_id']);
				}]);
		$query->matching('Ledgers', function ($q) use($AccountingGroupOutputGst){
			return $q->where(['Ledgers.accounting_group_id IN' => $AccountingGroupOutputGst->id,'gst_type'=>'IGST']);
		});
		$balanceOfLedgers=$query;
		$outputIgst=[]; 
		foreach($balanceOfLedgers as $balanceOfLedger){ 
			if($balanceOfLedger->totalCredit > 0){
				@$outputIgst[@$balanceOfLedger->ledger->gst_figure_id]+=@$balanceOfLedger->totalCredit;
			}
		} 
		
		
		// InPut GST Code
		$AccountingGroupOutputGst=$this->AccountingEntries->Ledgers->AccountingGroups->find()
		->where(['AccountingGroups.input_output_gst'=>'Input','AccountingGroups.city_id'=>$city_id])->first();
		
		$query=$this->AccountingEntries->find();
		$query->select(['ledger_id','totalDebit' => $query->func()->sum('AccountingEntries.debit'),'totalCredit' => $query->func()->sum('AccountingEntries.credit')])
				->group('AccountingEntries.ledger_id')
				->where(['AccountingEntries.city_id'=>$city_id,'AccountingEntries.transaction_date >='=>$from_date, 'AccountingEntries.transaction_date <='=>$to_date])
				->contain(['Ledgers'=>function($q){
					return $q->select(['Ledgers.accounting_group_id','Ledgers.id','Ledgers.gst_figure_id']);
				}]);
		$query->matching('Ledgers', function ($q) use($AccountingGroupOutputGst){
			return $q->where(['Ledgers.accounting_group_id IN' => $AccountingGroupOutputGst->id,'gst_type !='=>'IGST']);
		});
		$balanceOfLedgers=$query; //pr($balanceOfLedgers->toArray()); exit;
		$inputgst=[];
		foreach($balanceOfLedgers as $balanceOfLedger){ 
			if($balanceOfLedger->totalDebit > 0){
				@$inputgst[@$balanceOfLedger->ledger->gst_figure_id]+=@$balanceOfLedger->totalDebit;
			}
		} 
		
		//InPut IGST Code
		$AccountingGroupOutputGst=$this->AccountingEntries->Ledgers->AccountingGroups->find()
		->where(['AccountingGroups.input_output_gst'=>'Input','AccountingGroups.city_id'=>$city_id])->first();
		$query=$this->AccountingEntries->find();
		$query->select(['ledger_id','totalDebit' => $query->func()->sum('AccountingEntries.debit'),'totalCredit' => $query->func()->sum('AccountingEntries.credit')])
				->group('AccountingEntries.ledger_id')
				->where(['AccountingEntries.city_id'=>$city_id,'AccountingEntries.transaction_date >='=>$from_date, 'AccountingEntries.transaction_date <='=>$to_date])
				->contain(['Ledgers'=>function($q){
					return $q->select(['Ledgers.accounting_group_id','Ledgers.id','Ledgers.gst_figure_id']);
				}]);
		$query->matching('Ledgers', function ($q) use($AccountingGroupOutputGst){
			return $q->where(['Ledgers.accounting_group_id IN' => $AccountingGroupOutputGst->id,'gst_type'=>'IGST']);
		});
		$balanceOfLedgers=$query;
		$inputIgst=[]; 
		foreach($balanceOfLedgers as $balanceOfLedger){ 
			if($balanceOfLedger->totalCredit > 0){
				@$inputIgst[@$balanceOfLedger->ledger->gst_figure_id]+=@$balanceOfLedger->totalCredit;
			}
		} 
		
		
		
		
		$GstFigures=$this->AccountingEntries->Ledgers->GstFigures->find()->where(['city_id'=>$city_id]);
		$this->set(compact('GstFigures','outputgst','outputIgst','inputgst','inputIgst','from_date','to_date'));
	}
}
