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
	public function ProfitLossStatement()
    {
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id'); 
		$location_id=$this->Auth->User('location_id'); 
		$this->viewBuilder()->layout('admin_portal');
		$from_date = $this->request->query('from_date');
		$to_date   = $this->request->query('to_date');
		$from_date = date("Y-m-d",strtotime($from_date));
		$to_date   = date("Y-m-d",strtotime($to_date));
		
		$AccountingGroups=$this->AccountingEntries->Ledgers->AccountingGroups->find()
		->where(['AccountingGroups.nature_of_group_id IN'=>[3,4]]);
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
				->where(['AccountingEntries.location_id'=>$location_id,'AccountingEntries.transaction_date >='=>$from_date, 'AccountingEntries.transaction_date <='=>$to_date])
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
		$closingValue= $this->stockReport($city_id,$from_date,$to_date);
		$this->set(compact('from_date','to_date', 'groupForPrint', 'closingValue', 'openingValue'));
		
	}
}
