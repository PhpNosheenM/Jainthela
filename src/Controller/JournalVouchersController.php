<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\View\View;
/**
 * JournalVouchers Controller
 *
 * @property \App\Model\Table\JournalVouchersTable $JournalVouchers
 *
 * @method \App\Model\Entity\JournalVoucher[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class JournalVouchersController extends AppController
{
	public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Security->setConfig('unlockedActions', ['add', 'index', 'view', 'edit']);

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
			'limit' => 20
        ];
		
		$journalVouchers = $this->JournalVouchers->find()->where(['JournalVouchers.city_id'=>$city_id])->contain(['JournalVoucherRows','Cities']);
		
		if ($this->request->is(['get'])){
			$search=$this->request->getQuery('search');
			$journalVouchers->where([
							'OR' => [
									'JournalVouchers.voucher_no LIKE' => $search.'%',
									'Cities.name LIKE' => $search.'%',
									'JournalVouchers.narration LIKE' => $search.'%',
									'JournalVouchers.created_on LIKE' => $search.'%'
									
							]
			]);
		}
		$journalVouchers=$this->paginate($journalVouchers);
		$paginate_limit=$this->paginate['limit'];
        $this->set(compact('journalVouchers','paginate_limit'));
    }

    /**
     * View method
     *
     * @param string|null $id Journal Voucher id.
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
        $journalVoucher = $this->JournalVouchers->get($id, [
            'contain' => ['AccountingEntries', 'JournalVoucherRows'=>['ReferenceDetails','Ledgers']]]);

		$this->loadmodel('Companies');
		$companies=$this->Companies->find()->where(['Companies.city_id'=>$city_id])->first();
		$this->set(compact('journalVoucher', 'companies'));
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
		$this->viewBuilder()->layout('super_admin_layout');
        $journalVoucher = $this->JournalVouchers->newEntity();
		
		if ($this->request->is('post')) {
			
			//$this->request->data['transaction_date'] = date("Y-m-d",strtotime($this->request->getData()['transaction_date']));
			$Voucher_no = $this->JournalVouchers->find()->select(['voucher_no'])->where(['city_id'=>$city_id])->order(['voucher_no' => 'DESC'])->first();
			  if($Voucher_no)
			{
				$journalVoucher_no=$Voucher_no->voucher_no+1;
			}
			else
			{
				$journalVoucher_no=1;
			}  
			
			//$contraVoucher->location_id = $location_id;
			$tdate=$this->request->data('transaction_date');
			 //$this->request->data['transaction_date']= date('Y-m-d', strtotime($this->request->data['transaction_date']));		
				//	pr($this->request->getData());pr($journalVoucher); exit;	
			$journalVoucher = $this->JournalVouchers->patchEntity($journalVoucher, $this->request->getData()); 	
			
			//$vendor_id=$journalVoucher->vendor_id;
			$journalVoucher->city_id = $city_id;
			$journalVoucher->voucher_no=$journalVoucher_no;
			$journalVoucher->created_by = $user_id;
			$journalVoucher->transaction_date = date('Y-m-d', strtotime($tdate));
			 //	pr($journalVoucher);  
			//pr($journalVoucher->journal_voucher_rows); exit;
			//transaction date for contraVoucher code start here--
			
			//transaction date for journalVoucher code close here-- 
		
			
			if ($this->JournalVouchers->save($journalVoucher)) {
				
				foreach($journalVoucher->journal_voucher_rows as $journal_row)
			{
				
				if(!empty($journal_row->reference_details))
				{
					foreach($journal_row->reference_details as $reference_detail1)
					{ 
						$reference_detail = $this->JournalVouchers->ReferenceDetails->newEntity();
						$reference_detail->transaction_date = date('Y-m-d',strtotime($tdate));
						$reference_detail->journal_voucher_id =  $journal_row->id;
						$reference_detail->journal_voucher_row_id =  $journal_row->id;
						$reference_detail->ref_name =  $reference_detail1['ref_name'];
						$reference_detail->type =  $reference_detail1['type'];
						$reference_detail->ledger_id =  $reference_detail1['ledger_id'];
						$reference_detail->city_id =  $city_id;
						$test_cr_dr=$journal_row->cr_dr;
						if($test_cr_dr=='Cr'){
							$reference_detail->credit =  $reference_detail1['credit'];
						}
						if($test_cr_dr=='Dr'){
							$reference_detail->debit =  $reference_detail1['debit'];
						}
						
						$this->JournalVouchers->ReferenceDetails->save($reference_detail);
					}
				}
			}
		 
			foreach($journalVoucher->journal_voucher_rows as $journal_row)
				{
					$accountEntry = $this->JournalVouchers->AccountingEntries->newEntity();
					$accountEntry->ledger_id                  = $journal_row->ledger_id;
					$accountEntry->debit                      = @$journal_row->debit;
					$accountEntry->credit                     = @$journal_row->credit;
					$accountEntry->transaction_date           = date('Y-m-d', strtotime($tdate));
					$accountEntry->city_id                    = $city_id;
					$accountEntry->journal_voucher_id         = $journalVoucher->id;
					$accountEntry->journal_voucher_row_id     = $journal_row->id;
					$accountEntry->entry_from                 = 'web';
					$this->JournalVouchers->AccountingEntries->save($accountEntry);
				}
				$this->Flash->success(__('The journalVoucher has been saved.'));

				return $this->redirect(['action' => 'index']);
			}
			//pr($journalVoucher); exit;
			
			$this->Flash->error(__('The journalVoucher could not be saved. Please, try again.'));
		}
		/* 
        if ($this->request->is('post')) {
            $journalVoucher = $this->JournalVouchers->patchEntity($journalVoucher, $this->request->getData());
            if ($this->JournalVouchers->save($journalVoucher)) {
                $this->Flash->success(__('The journal voucher has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The journal voucher could not be saved. Please, try again.'));
        } */
		$Voucher_no = $this->JournalVouchers->find()->select(['voucher_no'])->where(['city_id'=>$city_id])->order(['voucher_no' => 'DESC'])->first();
		if($Voucher_no)
		{
			$voucher_no=$Voucher_no->voucher_no+1;
		}
		else
		{
			$voucher_no=1;
		}
		
		
		//bank group
		$bankParentGroups = $this->JournalVouchers->JournalVoucherRows->Ledgers->AccountingGroups->find()
						->where(['AccountingGroups.bank'=>'1']);
						
		$bankGroups=[];
		
		foreach($bankParentGroups as $bankParentGroup)
		{
			$accountingGroups = $this->JournalVouchers->JournalVoucherRows->Ledgers->AccountingGroups
			->find('children', ['for' => $bankParentGroup->id])->toArray();
			$bankGroups[]=$bankParentGroup->id;
			foreach($accountingGroups as $accountingGroup){
				$bankGroups[]=$accountingGroup->id;
			}
		}
		
		//cash-in-hand group
		$cashParentGroups = $this->JournalVouchers->JournalVoucherRows->Ledgers->AccountingGroups->find()
						->where(['AccountingGroups.cash'=>'1']);
						
		$cashGroups=[];
		
		foreach($cashParentGroups as $cashParentGroup)
		{
			$cashChildGroups = $this->JournalVouchers->JournalVoucherRows->Ledgers->AccountingGroups
			->find('children', ['for' => $cashParentGroup->id])->toArray();
			$cashGroups[]=$cashParentGroup->id;
			foreach($cashChildGroups as $cashChildGroup){
				$cashGroups[]=$cashChildGroup->id;
			}
		}
		
		$partyParentGroups = $this->JournalVouchers->JournalVoucherRows->Ledgers->AccountingGroups->find()
							->where(['AccountingGroups.journal_voucher_ledger'=>1]);

		$partyGroups=[];
		
		foreach($partyParentGroups as $partyParentGroup)
		{
			
			$partyChildGroups = $this->JournalVouchers->JournalVoucherRows->Ledgers->AccountingGroups->find('children', ['for' => $partyParentGroup->id]);
			$partyGroups[]=$partyParentGroup->id;
			foreach($partyChildGroups as $partyChildGroup){
				$partyGroups[]=$partyChildGroup->id;
			}
		}
	
		$partyLedgers = $this->JournalVouchers->JournalVoucherRows->Ledgers->find()
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
		$referenceDetails=$this->JournalVouchers->ReferenceDetails->find('list');
		
		
		
        $locations = $this->JournalVouchers->Locations->find('list', ['limit' => 200]);
        $cities = $this->JournalVouchers->Cities->find('list', ['limit' => 200]);
        $this->set(compact('journalVoucher', 'voucher_no', 'ledgerOptions', 'locations', 'city_id'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Journal Voucher id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($ids = null)
    {
		if($ids)
		{
		  $id = $this->EncryptingDecrypting->decryptData($ids);
		}
		
		$city_id=$this->Auth->User('city_id');
		$location_id=$this->Auth->User('location_id');
		$user_id=$this->Auth->User('id');
		$this->viewBuilder()->layout('super_admin_layout');
		
        $journalVoucher = $this->JournalVouchers->get($id, [
            'contain' => ['JournalVoucherRows'=>['ReferenceDetails']]
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
              
			$journalVoucher = $this->JournalVouchers->patchEntity($journalVoucher, $this->request->getData(), [
							'associated' => ['JournalVoucherRows']
						]);
			
			//$journalVoucher->location_id = $location_id;
			$journalVoucher->city_id = $city_id;
			$journalVoucher->created_by = $user_id;
			$traans_date= date('Y-m-d', strtotime($this->request->data['transaction_date']));
			$journalVoucher->transaction_date =$traans_date;
			
			//transaction date for journalVoucher code start here--
			/* foreach($journalVoucher->journal_voucher_rows as $journal_voucher_row)
			{
				if(!empty($journal_voucher_row->reference_details))
				{
					foreach($journal_voucher_row->reference_details as $reference_detail)
					{
						$reference_detail->transaction_date = date('Y-m-d', strtotime($journalVoucher->transaction_date));
						$reference_detail->city_id = $city_id;
					}
				}
			}
			 */
			 
            if ($this->JournalVouchers->save($journalVoucher))
			/* if ($this->JournalVouchers->save($journalVoucher, [
							'associated' => ['PaymentRows','PaymentRows.ReferenceDetails']
						])) */
				{
			$this->JournalVouchers->ReferenceDetails->deleteAll(['ReferenceDetails.journal_voucher_id'=>$id]);
			
			$this->JournalVouchers->AccountingEntries->deleteAll(['AccountingEntries.journal_voucher_id'=>$id]);
			
			foreach($journalVoucher->journal_voucher_rows as $journal_voucher_row)
			{
				if(!empty($journal_voucher_row->reference_details))
				{
					foreach($journal_voucher_row->reference_details as $reference_detail1)
					{
						$reference_detail = $this->JournalVouchers->ReferenceDetails->newEntity();
						$reference_detail->transaction_date = $traans_date;
						$reference_detail->location_id = 0;
						$reference_detail->journal_voucher_id =  $journal_voucher_row->journal_voucher_id;
						$reference_detail->journal_voucher_row_id =  $journal_voucher_row->id;
						$reference_detail->ref_name =  $reference_detail1['ref_name'];
						$reference_detail->type =  $reference_detail1['type'];
						$reference_detail->ledger_id =  $reference_detail1['ledger_id'];
						$reference_detail->city_id =  $city_id;
						$test_cr_dr=$journal_voucher_row->cr_dr;
						if($test_cr_dr=='Cr'){
							$reference_detail->credit =  $reference_detail1['credit'];
						}
						if($test_cr_dr=='Dr'){
							$reference_detail->debit =  $reference_detail1['debit'];
						}
						
						$this->JournalVouchers->ReferenceDetails->save($reference_detail);
					}
				}
			}
			
				
				foreach($journalVoucher->journal_voucher_rows as $journal_voucher_row)
				{
					$accountEntry = $this->JournalVouchers->AccountingEntries->newEntity();
					$accountEntry->ledger_id                  = $journal_voucher_row->ledger_id;
					$accountEntry->debit                      = @$journal_voucher_row->debit;
					$accountEntry->credit                     = @$journal_voucher_row->credit;
					$accountEntry->transaction_date           = date('Y-m-d', strtotime($journalVoucher->transaction_date));
					$accountEntry->city_id                    = $city_id;
					$accountEntry->journal_voucher_id          = $journalVoucher->id;
					$accountEntry->journal_voucher_row_id      = $journal_voucher_row->id;
					$accountEntry->entry_from                 = 'web';
					$this->JournalVouchers->AccountingEntries->save($accountEntry);
				}
				$this->Flash->success(__('The journalVoucher has been saved.'));

				return $this->redirect(['action' => 'index']);
                $this->Flash->success(__('The journalVoucher has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The journalVoucher could not be saved. Please, try again.'));


			}
		 
		$voucher_no=$journalVoucher->voucher_no;
		// pr($journalVoucher); exit;
		//bank group
		$bankParentGroups = $this->JournalVouchers->JournalVoucherRows->Ledgers->AccountingGroups->find()
						->where(['AccountingGroups.bank'=>'1']);
		
		$bankGroups=[];
		
		foreach($bankParentGroups as $bankParentGroup)
		{
			$accountingGroups = $this->JournalVouchers->JournalVoucherRows->Ledgers->AccountingGroups
			->find('children', ['for' => $bankParentGroup->id])->toArray();
			$bankGroups[]=$bankParentGroup->id;
			foreach($accountingGroups as $accountingGroup){
				$bankGroups[]=$accountingGroup->id;
			}
		}
		
		//cash-in-hand group
		$cashParentGroups = $this->JournalVouchers->JournalVoucherRows->Ledgers->AccountingGroups->find()
						->where(['AccountingGroups.cash'=>'1']);
						
		$cashGroups=[];
		
		foreach($cashParentGroups as $cashParentGroup)
		{
			$cashChildGroups = $this->JournalVouchers->JournalVoucherRows->Ledgers->AccountingGroups
			->find('children', ['for' => $cashParentGroup->id])->toArray();
			$cashGroups[]=$cashParentGroup->id;
			foreach($cashChildGroups as $cashChildGroup){
				$cashGroups[]=$cashChildGroup->id;
			}
		}
		
		$partyParentGroups = $this->JournalVouchers->JournalVoucherRows->Ledgers->AccountingGroups->find()
							->where(['AccountingGroups.journal_voucher_ledger'=>1]);

		$partyGroups=[];
		
		foreach($partyParentGroups as $partyParentGroup)
		{
			
			$partyChildGroups = $this->JournalVouchers->JournalVoucherRows->Ledgers->AccountingGroups->find('children', ['for' => $partyParentGroup->id]);
			$partyGroups[]=$partyParentGroup->id;
			foreach($partyChildGroups as $partyChildGroup){
				$partyGroups[]=$partyChildGroup->id;
			}
		}
	//pr($partyGroups->toArray()); exit;
		$partyLedgers = $this->JournalVouchers->JournalVoucherRows->Ledgers->find()
		->where(['Ledgers.accounting_group_id IN' =>$partyGroups,'Ledgers.city_id'=>$city_id]);
		
		//$ledgers = $this->JournalVouchers->JournalVoucherRows->Ledgers->find()->where(['company_id'=>$company_id]);
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
		
		$this->set(compact('journalVoucher', 'location_id','voucher_no','ledgerOptions', 'referenceDetails','city_id'));
	  
    }

    /**
     * Delete method
     *
     * @param string|null $id Journal Voucher id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $journalVoucher = $this->JournalVouchers->get($id);
        if ($this->JournalVouchers->delete($journalVoucher)) {
            $this->Flash->success(__('The journal voucher has been deleted.'));
        } else {
            $this->Flash->error(__('The journal voucher could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
