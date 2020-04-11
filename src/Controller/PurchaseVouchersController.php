<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\View\View;
/**
 * PurchaseVouchers Controller
 *
 * @property \App\Model\Table\PurchaseVouchersTable $PurchaseVouchers
 *
 * @method \App\Model\Entity\PurchaseVoucher[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PurchaseVouchersController extends AppController
{

	public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Security->setConfig('unlockedActions', ['add', 'index', 'view']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id');
		$this->viewBuilder()->layout('super_admin_layout');
		
        $this->paginate = [
            'contain' => ['Cities'],
			'limit' => 100
        ];
		
		$purchaseVoucher = $this->PurchaseVouchers->find()->where(['PurchaseVouchers.city_id'=>$city_id])->contain(['PurchaseVoucherRows','Cities']);
		
        $purchaseVoucher=$this->paginate($purchaseVoucher);
		$paginate_limit=$this->paginate['limit'];
        $this->set(compact('purchaseVoucher','paginate_limit'));
    }

    /**
     * View method
     *
     * @param string|null $id Purchase Voucher id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($ids = null)
    {
		if($ids)
		{
		  $id = $this->EncryptingDecrypting->decryptData($ids);
		}
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id');
		$this->viewBuilder()->layout('super_admin_layout');
		
		$purchaseVoucher = $this->PurchaseVouchers->get($id, [
            'contain' => ['AccountingEntries', 'PurchaseVoucherRows'=>['ReferenceDetails','Ledgers']]
        ]); 

        $this->set('purchaseVoucher', $purchaseVoucher);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
		$financial_year_id=$this->Auth->User('financial_year_id'); 
		$city_id=$this->Auth->User('city_id'); 
		$location_id=$this->Auth->User('location_id'); 
		$user_id=$this->Auth->User('id');
		$this->viewBuilder()->layout('super_admin_layout');
		
        $purchaseVoucher = $this->PurchaseVouchers->newEntity();
		
        if ($this->request->is('post')) {
			
			$Voucher_no = $this->PurchaseVouchers->find()->select(['voucher_no'])->where(['city_id'=>$city_id,'financial_year_id'=>$financial_year_id])->order(['voucher_no' => 'DESC'])->first();
			if($Voucher_no)
			{
				$voucher_no=$Voucher_no->voucher_no+1;
			}
			else
			{
				$voucher_no=1;
			}
			
            $purchaseVoucher = $this->PurchaseVouchers->patchEntity($purchaseVoucher, $this->request->getData());
			$tdate=$this->request->data('transaction_date');
			$purchaseVoucher->transaction_date=date('Y-m-d',strtotime($tdate));
			$seller_invoice_date=$this->request->data('seller_invoice_date');
			$purchaseVoucher->seller_invoice_date=date('Y-m-d',strtotime($seller_invoice_date));
			$purchaseVoucher->city_id = $city_id;
			$purchaseVoucher->financial_year_id = $financial_year_id;
			$purchaseVoucher->created_by = $user_id;
			$purchaseVoucher->voucher_no = $voucher_no;
			$purchaseVoucher->status = 'Active';
			
            if ($data=$this->PurchaseVouchers->save($purchaseVoucher)) {
			
			foreach($purchaseVoucher->purchase_voucher_rows as $purchase_voucher_row)
			{
				if(!empty($purchase_voucher_row->reference_details))
				{
					foreach($purchase_voucher_row->reference_details as $reference_detail1)
					{
						//pr($reference_detail1['ledger_id']); exit;
						$reference_detail = $this->PurchaseVouchers->ReferenceDetails->newEntity();
						$reference_detail->transaction_date = date('Y-m-d',strtotime($tdate));
						$reference_detail->purchase_voucher_id =  $data->id;
						$reference_detail->purchase_voucher_row_id =  $purchase_voucher_row->id;
						$reference_detail->ref_name =  $reference_detail1['ref_name'];
						$reference_detail->type =  $reference_detail1['type'];
						$reference_detail->ledger_id =  $reference_detail1['ledger_id'];
						$reference_detail->city_id =  $city_id;
						$test_cr_dr=$purchase_voucher_row->cr_dr;
						if($test_cr_dr=='Cr'){
							$reference_detail->credit =  $reference_detail1['credit'];
						}
						if($test_cr_dr=='Dr'){
							$reference_detail->debit =  $reference_detail1['debit'];
						}
						
						$this->PurchaseVouchers->ReferenceDetails->save($reference_detail);
					}
				}
			}
			
			foreach($purchaseVoucher->purchase_voucher_rows as $purchase_voucher_row)
				{
					$accountEntry = $this->PurchaseVouchers->AccountingEntries->newEntity();
					$accountEntry->ledger_id                  = $purchase_voucher_row->ledger_id;
					$accountEntry->debit                      = @$purchase_voucher_row->debit;
					$accountEntry->credit                     = @$purchase_voucher_row->credit;
					$accountEntry->transaction_date           = date('Y-m-d',strtotime($tdate));
					//$accountEntry->location_id                = $location_id;
					$accountEntry->city_id                 	  = $city_id;
					$accountEntry->purchase_voucher_id                 = $purchaseVoucher->id;
					$accountEntry->purchase_voucher_row_id             = $purchase_voucher_row->id;
					$accountEntry->entry_from                 = 'web';
					$this->PurchaseVouchers->AccountingEntries->save($accountEntry);
				}
                $this->Flash->success(__('The purchaseVoucher has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The purchase voucher could not be saved. Please, try again.'));
        }
		$Voucher_no = $this->PurchaseVouchers->find()->select(['voucher_no'])->where(['city_id'=>$city_id,'financial_year_id'=>$financial_year_id])->order(['voucher_no' => 'DESC'])->first();
		if($Voucher_no)
		{
			$voucher_no=$Voucher_no->voucher_no+1;
		}
		else
		{
			$voucher_no=1;
		}
		
		//bank group
		$bankParentGroups = $this->PurchaseVouchers->PurchaseVoucherRows->Ledgers->AccountingGroups->find()
						->where(['AccountingGroups.bank'=>'1']);
						
		$bankGroups=[];
		
		foreach($bankParentGroups as $bankParentGroup)
		{
			$accountingGroups = $this->PurchaseVouchers->PurchaseVoucherRows->Ledgers->AccountingGroups
			->find('children', ['for' => $bankParentGroup->id])->toArray();
			$bankGroups[]=$bankParentGroup->id;
			foreach($accountingGroups as $accountingGroup){
				$bankGroups[]=$accountingGroup->id;
			}
		}
		
		$partyParentGroups = $this->PurchaseVouchers->PurchaseVoucherRows->Ledgers->AccountingGroups->find()
							->where(['AccountingGroups.purchase_voucher_purchase_ledger'=>1,'AccountingGroups.city_id'=>$city_id]);

		$partyGroups=[];
		//pr($partyParentGroups->toArray()); exit;
		foreach($partyParentGroups as $partyParentGroup)
		{
			
			$partyChildGroups = $this->PurchaseVouchers->PurchaseVoucherRows->Ledgers->AccountingGroups->find('children', ['for' => $partyParentGroup->id]);
			$partyGroups[]=$partyParentGroup->id;
			foreach($partyChildGroups as $partyChildGroup){
				$partyGroups[]=$partyChildGroup->id;
			}
		}
	
		$partyLedgers = $this->PurchaseVouchers->PurchaseVoucherRows->Ledgers->find()
		->where(['Ledgers.accounting_group_id IN' =>$partyGroups,'Ledgers.city_id'=>$city_id]);
		
		//$ledgers = $this->Receipts->PaymentRows->Ledgers->find()->where(['company_id'=>$company_id]);
		foreach($partyLedgers as $ledger){
			$ledgerOptionSecond[]=['text' =>$ledger->name, 'value' => $ledger->id,'open_window' => 'efew','bank_and_cash' => 'no','default_days'=>$ledger->default_credit_days];
			}
			
		$partyParentGroups = $this->PurchaseVouchers->PurchaseVoucherRows->Ledgers->AccountingGroups->find()
							->where(['AccountingGroups.purchase_voucher_first_ledger'=>1,'AccountingGroups.city_id'=>$city_id]);

		$partyGroups=[];
		
		foreach($partyParentGroups as $partyParentGroup)
		{
			
			$partyChildGroups = $this->PurchaseVouchers->PurchaseVoucherRows->Ledgers->AccountingGroups->find('children', ['for' => $partyParentGroup->id]);
			$partyGroups[]=$partyParentGroup->id;
			foreach($partyChildGroups as $partyChildGroup){
				$partyGroups[]=$partyChildGroup->id;
			}
		}
	
		$partyLedgers = $this->PurchaseVouchers->PurchaseVoucherRows->Ledgers->find()
		->where(['Ledgers.accounting_group_id IN' =>$partyGroups,'Ledgers.city_id'=>$city_id]);
		
		//$ledgers = $this->Receipts->PaymentRows->Ledgers->find()->where(['company_id'=>$company_id]);
		foreach($partyLedgers as $ledger){
			if($ledger->bill_to_bill_accounting == 'yes'){
			$ledgerOptionFirst[]=['text' =>$ledger->name, 'value' => $ledger->id,'open_window' => 'party','bank_and_cash' => 'no','default_days'=>$ledger->default_credit_days];
			}else{
				$ledgerOptionFirst[]=['text' =>$ledger->name, 'value' => $ledger->id,'open_window' => 'no','bank_and_cash' => 'no','default_days'=>$ledger->default_credit_days];
			}
		}
		
		//pr($ledgerOptionSecond); exit;
		//pr($ledgerOptionFirst); exit;
		$referenceDetails=$this->PurchaseVouchers->PurchaseVoucherRows->ReferenceDetails->find('list');
        $salesInvoices = $this->PurchaseVouchers->SalesInvoices->find('list', ['limit' => 200]);
		
		
        $financialYears = $this->PurchaseVouchers->FinancialYears->find('list', ['limit' => 200]);
        $cities = $this->PurchaseVouchers->Cities->find('list', ['limit' => 200]);
		
		$this->set(compact('purchaseVoucher', 'location_id', 'city_id','salesInvoices','voucher_no','ledgerOptions','company_id','referenceDetails','ledgerOptionSecond','ledgerOptionFirst'));
		
        //$this->set(compact('purchaseVoucher', 'financialYears', 'cities'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Purchase Voucher id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($ids = null)
    {
		if($ids)
		{
		  $id = $this->EncryptingDecrypting->decryptData($ids);
		}
		$financial_year_id=$this->Auth->User('financial_year_id'); 
		$city_id=$this->Auth->User('city_id');
		$location_id=$this->Auth->User('location_id');
		$user_id=$this->Auth->User('id');
		$this->viewBuilder()->layout('super_admin_layout');
        $purchaseVoucher = $this->PurchaseVouchers->get($id, [
            'contain' => ['PurchaseVoucherRows'=>['ReferenceDetails']]
        ]);
		
        if ($this->request->is(['patch', 'post', 'put'])) {
            $purchaseVoucher = $this->PurchaseVouchers->patchEntity($purchaseVoucher, $this->request->getData(), [
					'associated' => ['PurchaseVoucherRows']
			]);
			 
			//$payment->location_id = $location_id;
			$purchaseVoucher->city_id = $city_id;
			$purchaseVoucher->created_by = $user_id;
			$traans_date= date('Y-m-d', strtotime($this->request->data['transaction_date']));
			$purchaseVoucher->transaction_date =$traans_date;
			
			//transaction date for purchaseVoucher code start here--
			/* foreach($purchaseVoucher->payment_rows as $payment_row)
			{
				if(!empty($payment_row->reference_details))
				{
					foreach($payment_row->reference_details as $reference_detail)
					{
						$reference_detail->transaction_date = date('Y-m-d', strtotime($purchaseVoucher->transaction_date));
						$reference_detail->city_id = $city_id;
					}
				}
			}
			 */
			 
            if ($this->PurchaseVouchers->save($purchaseVoucher))
			/* if ($this->Payments->save($payment, [
							'associated' => ['PaymentRows','PaymentRows.ReferenceDetails']
						])) */
				{
			$this->PurchaseVouchers->ReferenceDetails->deleteAll(['ReferenceDetails.payment_id'=>$id]);
			
			$this->PurchaseVouchers->AccountingEntries->deleteAll(['AccountingEntries.payment_id'=>$id]);
			
			foreach($purchaseVoucher->purchase_voucher_rows as $payment_row)
			{
				if(!empty($payment_row->reference_details))
				{
					foreach($payment_row->reference_details as $reference_detail1)
					{
						$reference_detail = $this->Payments->ReferenceDetails->newEntity();
						$reference_detail->transaction_date = $traans_date;
						$reference_detail->location_id = 0;
						$reference_detail->purchase_voucher_id =  $payment_row->purchase_voucher_id;
						$reference_detail->purchase_voucher_row_id =  $payment_row->id;
						$reference_detail->ref_name =  $reference_detail1['ref_name'];
						$reference_detail->type =  $reference_detail1['type'];
						$reference_detail->ledger_id =  $reference_detail1['ledger_id'];
						$reference_detail->city_id =  $city_id;
						$test_cr_dr=$payment_row->cr_dr;
						if($test_cr_dr=='Cr'){
							$reference_detail->credit =  $reference_detail1['credit'];
						}
						if($test_cr_dr=='Dr'){
							$reference_detail->debit =  $reference_detail1['debit'];
						}
						
						$this->Payments->ReferenceDetails->save($reference_detail);
					}
				}
			}
			
				
				foreach($purchaseVoucher->purchase_voucher_rows as $payment_row)
				{
					$accountEntry = $this->Payments->AccountingEntries->newEntity();
					$accountEntry->ledger_id                  = $payment_row->ledger_id;
					$accountEntry->debit                      = @$payment_row->debit;
					$accountEntry->credit                     = @$payment_row->credit;
					$accountEntry->transaction_date           = date('Y-m-d', strtotime($purchaseVoucher->transaction_date));
					$accountEntry->city_id                    = $city_id;
					$accountEntry->purchase_voucher_id        = $purchaseVoucher->id;
					$accountEntry->purchase_voucher_row_id    = $payment_row->id;
					$accountEntry->entry_from                 = 'web';
					$this->Payments->AccountingEntries->save($accountEntry);
				}
				$this->Flash->success(__('The purchaseVoucher has been saved.'));

				return $this->redirect(['action' => 'index']);
                $this->Flash->success(__('The purchaseVoucher has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The purchaseVoucher could not be saved. Please, try again.'));
        }
		
		
		
		
       $Voucher_no = $this->PurchaseVouchers->find()->select(['voucher_no'])->where(['city_id'=>$city_id,'financial_year_id'=>$financial_year_id])->order(['voucher_no' => 'DESC'])->first();
		if($Voucher_no)
		{
			$voucher_no=$Voucher_no->voucher_no+1;
		}
		else
		{
			$voucher_no=1;
		}
		
		//bank group
		$bankParentGroups = $this->PurchaseVouchers->PurchaseVoucherRows->Ledgers->AccountingGroups->find()
						->where(['AccountingGroups.bank'=>'1']);
						
		$bankGroups=[];
		
		foreach($bankParentGroups as $bankParentGroup)
		{
			$accountingGroups = $this->PurchaseVouchers->PurchaseVoucherRows->Ledgers->AccountingGroups
			->find('children', ['for' => $bankParentGroup->id])->toArray();
			$bankGroups[]=$bankParentGroup->id;
			foreach($accountingGroups as $accountingGroup){
				$bankGroups[]=$accountingGroup->id;
			}
		}
		
		$partyParentGroups = $this->PurchaseVouchers->PurchaseVoucherRows->Ledgers->AccountingGroups->find()
							->where(['AccountingGroups.purchase_voucher_purchase_ledger'=>1,'AccountingGroups.city_id'=>$city_id]);

		$partyGroups=[];
		//pr($partyParentGroups->toArray()); exit;
		foreach($partyParentGroups as $partyParentGroup)
		{
			
			$partyChildGroups = $this->PurchaseVouchers->PurchaseVoucherRows->Ledgers->AccountingGroups->find('children', ['for' => $partyParentGroup->id]);
			$partyGroups[]=$partyParentGroup->id;
			foreach($partyChildGroups as $partyChildGroup){
				$partyGroups[]=$partyChildGroup->id;
			}
		}
	
		$partyLedgers = $this->PurchaseVouchers->PurchaseVoucherRows->Ledgers->find()
		->where(['Ledgers.accounting_group_id IN' =>$partyGroups,'Ledgers.city_id'=>$city_id]);
		
		//$ledgers = $this->Receipts->PaymentRows->Ledgers->find()->where(['company_id'=>$company_id]);
		foreach($partyLedgers as $ledger){
			$ledgerOptionSecond[]=['text' =>$ledger->name, 'value' => $ledger->id,'open_window' => 'efew','bank_and_cash' => 'no','default_days'=>$ledger->default_credit_days];
			}
			
		$partyParentGroups = $this->PurchaseVouchers->PurchaseVoucherRows->Ledgers->AccountingGroups->find()
							->where(['AccountingGroups.purchase_voucher_first_ledger'=>1,'AccountingGroups.city_id'=>$city_id]);

		$partyGroups=[];
		
		foreach($partyParentGroups as $partyParentGroup)
		{
			
			$partyChildGroups = $this->PurchaseVouchers->PurchaseVoucherRows->Ledgers->AccountingGroups->find('children', ['for' => $partyParentGroup->id]);
			$partyGroups[]=$partyParentGroup->id;
			foreach($partyChildGroups as $partyChildGroup){
				$partyGroups[]=$partyChildGroup->id;
			}
		}
	
		$partyLedgers = $this->PurchaseVouchers->PurchaseVoucherRows->Ledgers->find()
		->where(['Ledgers.accounting_group_id IN' =>$partyGroups,'Ledgers.city_id'=>$city_id]);
		
		//$ledgers = $this->Receipts->PaymentRows->Ledgers->find()->where(['company_id'=>$company_id]);
		foreach($partyLedgers as $ledger){
			if($ledger->bill_to_bill_accounting == 'yes'){
			$ledgerOptionFirst[]=['text' =>$ledger->name, 'value' => $ledger->id,'open_window' => 'party','bank_and_cash' => 'no','default_days'=>$ledger->default_credit_days];
			}else{
				$ledgerOptionFirst[]=['text' =>$ledger->name, 'value' => $ledger->id,'open_window' => 'no','bank_and_cash' => 'no','default_days'=>$ledger->default_credit_days];
			}
		}
		
		//pr($ledgerOptionSecond); exit;
		//pr($ledgerOptionFirst); exit;
		$referenceDetails=$this->PurchaseVouchers->PurchaseVoucherRows->ReferenceDetails->find('list');
        $salesInvoices = $this->PurchaseVouchers->SalesInvoices->find('list', ['limit' => 200]);
		
		
        $financialYears = $this->PurchaseVouchers->FinancialYears->find('list', ['limit' => 200]);
        $cities = $this->PurchaseVouchers->Cities->find('list', ['limit' => 200]);
		
		$this->set(compact('purchaseVoucher', 'location_id', 'city_id','salesInvoices','voucher_no','ledgerOptions','company_id','referenceDetails','ledgerOptionSecond','ledgerOptionFirst'));
	}

    /**
     * Delete method
     *
     * @param string|null $id Purchase Voucher id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $purchaseVoucher = $this->PurchaseVouchers->get($id);
        if ($this->PurchaseVouchers->delete($purchaseVoucher)) {
            $this->Flash->success(__('The purchase voucher has been deleted.'));
        } else {
            $this->Flash->error(__('The purchase voucher could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
