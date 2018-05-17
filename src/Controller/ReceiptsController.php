<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\View\View;

/**
 * Receipts Controller
 *
 * @property \App\Model\Table\ReceiptsTable $Receipts
 *
 * @method \App\Model\Entity\Receipt[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ReceiptsController extends AppController
{

	 public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Security->setConfig('unlockedActions', ['add','index']);

    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Locations', 'SalesInvoices']
        ];
        $receipts = $this->paginate($this->Receipts);

        $this->set(compact('receipts'));
    }

    /**
     * View method
     *
     * @param string|null $id Receipt id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $receipt = $this->Receipts->get($id, [
            'contain' => ['Locations', 'SalesInvoices', 'AccountingEntries', 'ReceiptRows', 'ReferenceDetails']
        ]);

        $this->set('receipt', $receipt);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
		$city_id=$this->Auth->User('city_id'); 
		$location_id=$this->Auth->User('location_id'); 
		$user_id=$this->Auth->User('id');
		$this->viewBuilder()->layout('admin_portal');
        $receipt = $this->Receipts->newEntity();
        if ($this->request->is('post')) {
			$Voucher_no = $this->Receipts->find()->select(['voucher_no'])->where(['location_id'=>$location_id])->order(['voucher_no' => 'DESC'])->first();
			if($Voucher_no)
			{
				$voucher_no=$Voucher_no->voucher_no+1;
			}
			else
			{
				$voucher_no=1;
			}
            $receipt = $this->Receipts->patchEntity($receipt, $this->request->getData(),['associated' => ['ReceiptRows','ReceiptRows.ReferenceDetails']]);
			$tdate=$this->request->data('transaction_date');
			$receipt->transaction_date=date('Y-m-d',strtotime($tdate));
			$receipt->city_id = $city_id;
			$receipt->created_by = $user_id;
			$receipt->voucher_no = $voucher_no;
		   //transaction date for receipt code start here--
			foreach($receipt->receipt_rows as $receipt_row)
			{
				if(!empty($receipt_row->reference_details))
				{
					foreach($receipt_row->reference_details as $reference_detail)
					{
						$reference_detail->transaction_date = $receipt->transaction_date;
					}
				}
			}
            if ($this->Receipts->save($receipt)) {
			
			foreach($receipt->receipt_rows as $receipt_row)
				{
					$accountEntry = $this->Receipts->AccountingEntries->newEntity();
					$accountEntry->ledger_id                  = $receipt_row->ledger_id;
					$accountEntry->debit                      = @$receipt_row->debit;
					$accountEntry->credit                     = @$receipt_row->credit;
					$accountEntry->transaction_date           = $receipt->transaction_date;
					//$accountEntry->location_id                = $location_id;
					$accountEntry->city_id                 	  = $city_id;
					$accountEntry->receipt_id                 = $receipt->id;
					$accountEntry->receipt_row_id             = $receipt_row->id;
					$accountEntry->entry_from                 = 'web';
					$this->Receipts->AccountingEntries->save($accountEntry);
				}
                $this->Flash->success(__('The receipt has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
			pr($receipt); exit;
            $this->Flash->error(__('The receipt could not be saved. Please, try again.'));
        }
		$Voucher_no = $this->Receipts->find()->select(['voucher_no'])->where(['location_id'=>$location_id])->order(['voucher_no' => 'DESC'])->first();
		if($Voucher_no)
		{
			$voucher_no=$Voucher_no->voucher_no+1;
		}
		else
		{
			$voucher_no=1;
		}
		
		//bank group
		$bankParentGroups = $this->Receipts->ReceiptRows->Ledgers->AccountingGroups->find()
						->where(['AccountingGroups.bank'=>'1']);
						
		$bankGroups=[];
		
		foreach($bankParentGroups as $bankParentGroup)
		{
			$accountingGroups = $this->Receipts->ReceiptRows->Ledgers->AccountingGroups
			->find('children', ['for' => $bankParentGroup->id])->toArray();
			$bankGroups[]=$bankParentGroup->id;
			foreach($accountingGroups as $accountingGroup){
				$bankGroups[]=$accountingGroup->id;
			}
		}
		
		//cash-in-hand group
		$cashParentGroups = $this->Receipts->ReceiptRows->Ledgers->AccountingGroups->find()
						->where(['AccountingGroups.cash'=>'1']);
						
		$cashGroups=[];
		
		foreach($cashParentGroups as $cashParentGroup)
		{
			$cashChildGroups = $this->Receipts->ReceiptRows->Ledgers->AccountingGroups
			->find('children', ['for' => $cashParentGroup->id])->toArray();
			$cashGroups[]=$cashParentGroup->id;
			foreach($cashChildGroups as $cashChildGroup){
				$cashGroups[]=$cashChildGroup->id;
			}
		}
		
		$partyParentGroups = $this->Receipts->ReceiptRows->Ledgers->AccountingGroups->find()
							->where(['AccountingGroups.receipt_ledger'=>1]);

		$partyGroups=[];
		
		foreach($partyParentGroups as $partyParentGroup)
		{
			
			$partyChildGroups = $this->Receipts->ReceiptRows->Ledgers->AccountingGroups->find('children', ['for' => $partyParentGroup->id]);
			$partyGroups[]=$partyParentGroup->id;
			foreach($partyChildGroups as $partyChildGroup){
				$partyGroups[]=$partyChildGroup->id;
			}
		}
	
		$partyLedgers = $this->Receipts->ReceiptRows->Ledgers->find()
		->where(['Ledgers.accounting_group_id IN' =>$partyGroups,'Ledgers.city_id'=>$city_id]);
		
		//$ledgers = $this->Payments->PaymentRows->Ledgers->find()->where(['company_id'=>$company_id]);
		foreach($partyLedgers as $ledger){
			if(in_array($ledger->accounting_group_id,$bankGroups)){
				$ledgerOptions[]=['text' =>$ledger->name, 'value' => $ledger->id ,'open_window' => 'bank','bank_and_cash' => 'yes'];
			}
			else if($ledger->bill_to_bill_accounting == 'yes'){
				$ledgerOptions[]=['text' =>$ledger->name, 'value' => $ledger->id,'open_window' => 'party','bank_and_cash' => 'no','default_days'=>$ledger->default_credit_days];
			}
			else if(in_array($ledger->accounting_group_id,$cashGroups)){
				$ledgerOptions[]=['text' =>$ledger->name, 'value' => $ledger->id ,'open_window' => 'no','bank_and_cash' => 'yes'];
			}
			else{
				$ledgerOptions[]=['text' =>$ledger->name, 'value' => $ledger->id,'open_window' => 'no','bank_and_cash' => 'no' ];
			}
		}
		$referenceDetails=$this->Receipts->ReceiptRows->ReferenceDetails->find('list');
        $salesInvoices = $this->Receipts->SalesInvoices->find('list', ['limit' => 200]);
        $this->set(compact('receipt', 'location_id', 'city_id','salesInvoices','voucher_no','ledgerOptions','company_id','referenceDetails'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Receipt id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $receipt = $this->Receipts->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $receipt = $this->Receipts->patchEntity($receipt, $this->request->getData());
            if ($this->Receipts->save($receipt)) {
                $this->Flash->success(__('The receipt has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The receipt could not be saved. Please, try again.'));
        }
        $locations = $this->Receipts->Locations->find('list', ['limit' => 200]);
        $salesInvoices = $this->Receipts->SalesInvoices->find('list', ['limit' => 200]);
        $this->set(compact('receipt', 'locations', 'salesInvoices'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Receipt id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $receipt = $this->Receipts->get($id);
        if ($this->Receipts->delete($receipt)) {
            $this->Flash->success(__('The receipt has been deleted.'));
        } else {
            $this->Flash->error(__('The receipt could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
