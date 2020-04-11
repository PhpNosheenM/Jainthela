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
        $this->Security->setConfig('unlockedActions', ['add', 'index', 'view', 'ccavenueAdd']);


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
            'contain' => ['CIties'],
			'limit' => 100
        ];
		
		$receipts = $this->Receipts->find()->where(['Receipts.city_id'=>$city_id])->contain(['ReceiptRows','Cities']);
	 
		if ($this->request->is(['get'])){
			$search=$this->request->getQuery('search');
			$receipts->where([
							'OR' => [
									'Receipts.voucher_no LIKE' => $search.'%',
									'Cities.name LIKE' => $search.'%',
									'Receipts.narration LIKE' => $search.'%',
									'Receipts.created_on LIKE' => $search.'%'
									
							]
			]);
		}
		
		$receipts=$this->paginate($receipts);
		$paginate_limit=$this->paginate['limit'];
        $this->set(compact('receipts','paginate_limit'));
    }

    /**
     * View method
     *
     * @param string|null $id Receipt id.
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
        $receipt = $this->Receipts->get($id, [
            'contain' => ['AccountingEntries', 'ReceiptRows'=>['ReferenceDetails','Ledgers']]
        ]);
		
		$this->loadmodel('Companies');
		$companies=$this->Companies->find()->where(['Companies.city_id'=>$city_id])->first();
		$this->set(compact('receipt', 'companies'));
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
		
        $receipt = $this->Receipts->newEntity();
		
        if ($this->request->is('post')) {
			$Voucher_no = $this->Receipts->find()->select(['voucher_no'])->where(['city_id'=>$city_id,'financial_year_id'=>$financial_year_id])->order(['voucher_no' => 'DESC'])->first();
			if($Voucher_no)
			{
				$voucher_no=$Voucher_no->voucher_no+1;
			}
			else
			{
				$voucher_no=1;
			}
            $receipt = $this->Receipts->patchEntity($receipt, $this->request->getData());
			$tdate=$this->request->data('transaction_date');
			$receipt->transaction_date=date('Y-m-d',strtotime($tdate));
			$receipt->city_id = $city_id;
			$receipt->financial_year_id = $financial_year_id;
			$receipt->created_by = $user_id;
			$receipt->voucher_no = $voucher_no;
		    //transaction date for receipt code start here--
			
            if ($data=$this->Receipts->save($receipt)) {
			
			foreach($receipt->receipt_rows as $receipt_row)
			{
				if(!empty($receipt_row->reference_details))
				{
					foreach($receipt_row->reference_details as $reference_detail1)
					{
						//pr($reference_detail1['ledger_id']); exit;
						$reference_detail = $this->Receipts->ReferenceDetails->newEntity();
						$reference_detail->transaction_date = date('Y-m-d',strtotime($tdate));
						$reference_detail->receipt_id =  $data->id;
						$reference_detail->receipt_row_id =  $receipt_row->id;
						$reference_detail->ref_name =  $reference_detail1['ref_name'];
						$reference_detail->type =  $reference_detail1['type'];
						$reference_detail->ledger_id =  $reference_detail1['ledger_id'];
						$reference_detail->city_id =  $city_id;
						$test_cr_dr=$receipt_row->cr_dr;
						if($test_cr_dr=='Cr'){
							$reference_detail->credit =  $reference_detail1['credit'];
						}
						if($test_cr_dr=='Dr'){
							$reference_detail->debit =  $reference_detail1['debit'];
						}
						
						$this->Receipts->ReferenceDetails->save($reference_detail);
					}
				}
			}
			
			foreach($receipt->receipt_rows as $receipt_row)
				{
					$accountEntry = $this->Receipts->AccountingEntries->newEntity();
					$accountEntry->ledger_id                  = $receipt_row->ledger_id;
					$accountEntry->debit                      = @$receipt_row->debit;
					$accountEntry->credit                     = @$receipt_row->credit;
					$accountEntry->transaction_date           = date('Y-m-d',strtotime($tdate));
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
			 
            $this->Flash->error(__('The receipt could not be saved. Please, try again.'));
        }
		$Voucher_no = $this->Receipts->find()->select(['voucher_no'])->where(['city_id'=>$city_id,'financial_year_id'=>$financial_year_id])->order(['voucher_no' => 'DESC'])->first();
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
		
		//$ledgers = $this->Receipts->PaymentRows->Ledgers->find()->where(['company_id'=>$company_id]);
		foreach($partyLedgers as $ledger){
			if(in_array($ledger->accounting_group_id,$bankGroups)){
				if($ledger->ccavenue=="yes"){
					$ledgerOptions[]=['text' =>$ledger->name, 'value' => $ledger->id ,'open_window' => 'party','bank_and_cash' => 'no'];
				}else{
					$ledgerOptions[]=['text' =>$ledger->name, 'value' => $ledger->id ,'open_window' => 'bank','bank_and_cash' => 'yes'];
				}
				//$ledgerOptions[]=['text' =>$ledger->name, 'value' => $ledger->id ,'open_window' => 'bank','bank_and_cash' => 'yes'];
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

	
	 public function ccavenueAdd()
    {
		$city_id=$this->Auth->User('city_id'); 
		$location_id=$this->Auth->User('location_id'); 
		$user_id=$this->Auth->User('id');
		$this->viewBuilder()->layout('super_admin_layout');
        $receipt = $this->Receipts->newEntity();
        if ($this->request->is('post')) {
			$Voucher_no = $this->Receipts->find()->select(['voucher_no'])->where(['city_id'=>$city_id])->order(['voucher_no' => 'DESC'])->first();
			if($Voucher_no)
			{
				$voucher_no=$Voucher_no->voucher_no+1;
			}
			else
			{
				$voucher_no=1;
			}
            $receipt = $this->Receipts->patchEntity($receipt, $this->request->getData());
			$tdate=$this->request->data('transaction_date');
			$receipt->transaction_date=date('Y-m-d',strtotime($tdate));
			$receipt->city_id = $city_id;
			$receipt->created_by = $user_id;
			$receipt->voucher_no = $voucher_no;
			//pr($receipt); exit;
		    //transaction date for receipt code start here--
            if ($data=$this->Receipts->save($receipt)) {
			
			foreach($receipt->receipt_rows as $receipt_row)
			{
				if(!empty($receipt_row->reference_details))
				{
					foreach($receipt_row->reference_details as $reference_detail1)
					{
						//pr($reference_detail1['ledger_id']); exit;
						$reference_detail = $this->Receipts->ReferenceDetails->newEntity();
						$reference_detail->transaction_date = date('Y-m-d',strtotime($tdate));
						$reference_detail->receipt_id =  $data->id;
						$reference_detail->receipt_row_id =  $receipt_row->id;
						$reference_detail->ref_name =  $reference_detail1['ref_name'];
						$reference_detail->type =  $reference_detail1['type'];
						$reference_detail->ledger_id =  $reference_detail1['ledger_id'];
						$reference_detail->city_id =  $city_id;
						$test_cr_dr=$receipt_row->cr_dr;
						if($test_cr_dr=='Cr'){
							$reference_detail->credit =  $reference_detail1['credit'];
						}
						if($test_cr_dr=='Dr'){
							$reference_detail->debit =  $reference_detail1['debit'];
						}
						
						$this->Receipts->ReferenceDetails->save($reference_detail);
					}
				}
			}
			
			foreach($receipt->receipt_rows as $receipt_row)
				{
					$accountEntry = $this->Receipts->AccountingEntries->newEntity();
					$accountEntry->ledger_id                  = $receipt_row->ledger_id;
					$accountEntry->debit                      = @$receipt_row->debit;
					$accountEntry->credit                     = @$receipt_row->credit;
					$accountEntry->transaction_date           = date('Y-m-d',strtotime($tdate));
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
			 
            $this->Flash->error(__('The receipt could not be saved. Please, try again.'));
        }
		
		$Voucher_no = $this->Receipts->find()->select(['voucher_no'])->where(['city_id'=>$city_id])->order(['voucher_no' => 'DESC'])->first();
		if($Voucher_no)
		{
			$voucher_no=$Voucher_no->voucher_no+1;
		}
		else
		{
			$voucher_no=1;
		}
		
		$partyParentGroups = $this->Receipts->ReceiptRows->Ledgers->AccountingGroups->find()
							->where(['AccountingGroups.bank'=>1]);

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
		->where(['Ledgers.accounting_group_id IN' =>$partyGroups,'Ledgers.city_id'=>$city_id,'Ledgers.ccavenue'=>'no']);
		//pr($partyLedgers->toArray()); exit;
		$ccavenueLedgers = $this->Receipts->ReceiptRows->Ledgers->find()
		->where(['Ledgers.ccavenue' =>'yes','Ledgers.city_id'=>$city_id])->first();
		
		$tdsLedgers = $this->Receipts->ReceiptRows->Ledgers->find()
		->where(['Ledgers.tds_account' =>'yes','Ledgers.city_id'=>$city_id])->first();
		
		$ccavenuechargeLedgers = $this->Receipts->ReceiptRows->Ledgers->find()
		->where(['Ledgers.ccavenue_charges' =>'yes','Ledgers.city_id'=>$city_id])->first();
		
		
		
		//$ledgers = $this->Payments->PaymentRows->Ledgers->find()->where(['company_id'=>$company_id]);
		
		if($ccavenueLedgers->ccavenue=="yes"){
			$ledgerOptions[]=['text' =>$ccavenueLedgers->name, 'value' => $ccavenueLedgers->id ,'open_window' => 'party','bank_and_cash' => 'no'];
		}
		if($tdsLedgers->tds_account=="yes"){
			$tdsLedgerOptions[]=['text' =>$tdsLedgers->name, 'value' => $tdsLedgers->id ,'open_window' => 'bank','bank_and_cash' => 'no'];
		}
		if($ccavenuechargeLedgers->ccavenue_charges=="yes"){
			$ccLedgerOptions[]=['text' =>$ccavenuechargeLedgers->name, 'value' => $ccavenuechargeLedgers->id ,'open_window' => 'party1','bank_and_cash' => 'no'];
		}
		if($partyLedgers){
			foreach($partyLedgers as $data){
				$bankOptions[]=['text' =>$data->name, 'value' => $data->id ,'open_window' => 'party1','bank_and_cash' => 'no'];
			}
		}
		//pr($ledgerOptions); exit;
		$referenceDetails=$this->Receipts->ReceiptRows->ReferenceDetails->find('list');
        $salesInvoices = $this->Receipts->SalesInvoices->find('list', ['limit' => 200]);
        $this->set(compact('receipt', 'location_id', 'city_id','salesInvoices','voucher_no','ledgerOptions','company_id','referenceDetails','tdsLedgerOptions','ccLedgerOptions','bankOptions'));
    }
    /**
     * Edit method
     *
     * @param string|null $id Receipt id.
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
        $receipt = $this->Receipts->get($id, [
            'contain' => ['ReceiptRows'=>['ReferenceDetails']]
        ]);
		
        if ($this->request->is(['patch', 'post', 'put'])) {
			 
			$receipt = $this->Receipts->patchEntity($receipt, $this->request->getData(), [
							'associated' => ['ReceiptRows']
						]);
			 
			//$receipt->location_id = $location_id;
			$receipt->financial_year_id = $financial_year_id;
			$receipt->city_id = $city_id;
			$receipt->created_by = $user_id;
			$traans_date= date('Y-m-d', strtotime($this->request->data['transaction_date']));
			$receipt->transaction_date =$traans_date;
			
			//transaction date for receipt code start here--
			/* foreach($receipt->receipt_rows as $receipt_row)
			{
				if(!empty($receipt_row->reference_details))
				{
					foreach($receipt_row->reference_details as $reference_detail)
					{
						$reference_detail->transaction_date = date('Y-m-d', strtotime($receipt->transaction_date));
						$reference_detail->city_id = $city_id;
					}
				}
			}
			 */
			 
            if ($this->Receipts->save($receipt))
			/* if ($this->Receipts->save($receipt, [
							'associated' => ['PaymentRows','PaymentRows.ReferenceDetails']
						])) */
				{
			$this->Receipts->ReferenceDetails->deleteAll(['ReferenceDetails.receipt_id'=>$id]);
			
			$this->Receipts->AccountingEntries->deleteAll(['AccountingEntries.receipt_id'=>$id]);
			
			foreach($receipt->receipt_rows as $receipt_row)
			{
				if(!empty($receipt_row->reference_details))
				{
					foreach($receipt_row->reference_details as $reference_detail1)
					{
						$reference_detail = $this->Receipts->ReferenceDetails->newEntity();
						$reference_detail->transaction_date = $traans_date;
						$reference_detail->location_id = 0;
						$reference_detail->receipt_id =  $receipt_row->receipt_id;
						$reference_detail->receipt_row_id =  $receipt_row->id;
						$reference_detail->ref_name =  $reference_detail1['ref_name'];
						$reference_detail->type =  $reference_detail1['type'];
						$reference_detail->ledger_id =  $reference_detail1['ledger_id'];
						$reference_detail->city_id =  $city_id;
						$test_cr_dr=$receipt_row->cr_dr;
						if($test_cr_dr=='Cr'){
							$reference_detail->credit =  $reference_detail1['credit'];
						}
						if($test_cr_dr=='Dr'){
							$reference_detail->debit =  $reference_detail1['debit'];
						}
						
						$this->Receipts->ReferenceDetails->save($reference_detail);
					}
				}
			}
			
				
				foreach($receipt->receipt_rows as $receipt_row)
				{
					$accountEntry = $this->Receipts->AccountingEntries->newEntity();
					$accountEntry->ledger_id                  = $receipt_row->ledger_id;
					$accountEntry->debit                      = @$receipt_row->debit;
					$accountEntry->credit                     = @$receipt_row->credit;
					$accountEntry->transaction_date           = date('Y-m-d', strtotime($receipt->transaction_date));
					$accountEntry->city_id                    = $city_id;
					$accountEntry->receipt_id                 = $receipt->id;
					$accountEntry->receipt_row_id             = $receipt_row->id;
					$accountEntry->entry_from                 = 'web';
					$this->Receipts->AccountingEntries->save($accountEntry);
				}
				$this->Flash->success(__('The receipt has been saved.'));

				return $this->redirect(['action' => 'index']);
                $this->Flash->success(__('The receipt has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The receipt could not be saved. Please, try again.'));
        }
		
		
		$voucher_no=$receipt->voucher_no;
		// pr($receipt); exit;
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
	//pr($partyGroups->toArray()); exit;
		$partyLedgers = $this->Receipts->ReceiptRows->Ledgers->find()
		->where(['Ledgers.accounting_group_id IN' =>$partyGroups,'Ledgers.city_id'=>$city_id]);
		
		//$ledgers = $this->Receipts->ReceiptRows->Ledgers->find()->where(['company_id'=>$company_id]);
		foreach($partyLedgers as $ledger){
			if(in_array($ledger->accounting_group_id,$bankGroups)){
				if($ledger->ccavenue=="yes"){
					$ledgerOptions[]=['text' =>$ledger->name, 'value' => $ledger->id ,'open_window' => 'party','bank_and_cash' => 'no'];
				}else{
					$ledgerOptions[]=['text' =>$ledger->name, 'value' => $ledger->id ,'open_window' => 'bank','bank_and_cash' => 'yes'];
				}
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
		
		//$referenceDetails=$this->Receipts->ReceiptRows->ReferenceDetails->find('list');
		
		$this->set(compact('receipt', 'location_id','voucher_no','ledgerOptions', 'referenceDetails','city_id'));
		 
    }
	public function codeUpdate()
    {
		$financial_year_id=$this->Auth->User('financial_year_id');
		$city_id=$this->Auth->User('city_id');
		$datee="2019-04-01";
		//$partyLedgers = $this->Receipts->Wallets->find()->where(['Wallets.city_id'=>$city_id,'Wallets.payment_status'=>'Success','Wallets.transaction_date >='=>$datee]);
		$partyLedgers = $this->Receipts->Wallets->find()->where(['Wallets.id'=>740]);
		
		foreach($partyLedgers as $data){  
			$transaction_date=date('Y-m-d',strtotime($data->transaction_date));
			$receipt = $this->Receipts->find()->where(['Receipts.city_id'=>8,'Receipts.transaction_date'=>$transaction_date])->first();
			//pr($receipt); exit;
			$ccavenueLedger = $this->Receipts->AccountingEntries->Ledgers->find()->where(['Ledgers.ccavenue' =>'yes','Ledgers.city_id'=>$data->city_id])->first();
			//$ReferenceDetail = $this->Receipts->ReferenceDetails->newEntity();
					//pr($ReferenceDetail); exit;
					$ReceiptRow1 = $this->Receipts->ReceiptRows->newEntity();
					$ReceiptRow1->receipt_id = $receipt->id;
					$ReceiptRow1->ledger_id = $ccavenueLedger->id;
					$ReceiptRow1->cr_dr = "Dr";
					$ReceiptRow1->debit = $data->add_amount;
					$ReceiptRow1->credit ='';
					$this->Receipts->ReceiptRows->save($ReceiptRow1);
					
					$AccountingEntries1 = $this->Receipts->AccountingEntries->newEntity();
					$AccountingEntries1->receipt_id = $receipt->id;
					$AccountingEntries1->ledger_id = $ccavenueLedger->id;
					$AccountingEntries1->city_id = $data->city_id;
					$AccountingEntries1->transaction_date = $transaction_date;
					$AccountingEntries1->debit = $data->add_amount;
					$AccountingEntries1->credit ='';
					$AccountingEntries1->receipt_id = $receipt->id;
					$AccountingEntries1->receipt_row_id = $ReceiptRow1->id;
					$this->Receipts->AccountingEntries->save($AccountingEntries1);
					
					$customerLedger = $this->Receipts->AccountingEntries->Ledgers->find()->where(['Ledgers.customer_id' =>$data->customer_id,'Ledgers.city_id'=>$data->city_id])->first();
					$ReceiptRow1 = $this->Receipts->ReceiptRows->newEntity();
					$ReceiptRow1->receipt_id = $receipt->id;
					$ReceiptRow1->ledger_id = $customerLedger->id;
					$ReceiptRow1->cr_dr = "Cr";
					$ReceiptRow1->credit = $data->add_amount;
					$ReceiptRow1->debit ='';
					$this->Receipts->ReceiptRows->save($ReceiptRow1);
					
					$AccountingEntries2 = $this->Receipts->AccountingEntries->newEntity();
					$AccountingEntries2->receipt_id = $receipt->id;
					$AccountingEntries2->city_id = $data->city_id;
					$AccountingEntries2->ledger_id = $customerLedger->id;
					$AccountingEntries2->transaction_date =$transaction_date;
					$AccountingEntries2->credit = $data->add_amount;
					$AccountingEntries2->debit ='';
					$AccountingEntries2->receipt_id = $receipt->id;
					$AccountingEntries2->receipt_row_id = $ReceiptRow1->id;
					$this->Receipts->AccountingEntries->save($AccountingEntries2);
					
					$ReferenceDetail = $this->Receipts->ReferenceDetails->newEntity(); 
					$ReferenceDetail->ledger_id=$ccavenueLedger->id;
					$ReferenceDetail->city_id = $data->city_id;
					$ReferenceDetail->debit=$data->add_amount;
					$ReferenceDetail->credit=0;
					$ReferenceDetail->transaction_date=$transaction_date;
					$ReferenceDetail->city_id=$data->city_id;
					$ReferenceDetail->entry_from="App";
					$ReferenceDetail->type='New Ref';
					$ReferenceDetail->ref_name=$data->ccavvenue_tracking_no;
					$ReferenceDetail->receipt_id = $receipt->id;
					$this->Receipts->ReferenceDetails->save($ReferenceDetail);
				} exit;
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
