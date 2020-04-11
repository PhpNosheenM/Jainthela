<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\View\View;
/**
 * CreditNotes Controller
 *
 * @property \App\Model\Table\CreditNotesTable $CreditNotes
 *
 * @method \App\Model\Entity\CreditNote[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CreditNotesController extends AppController
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
			'limit' => 100
        ];
		
		$creditNotes = $this->CreditNotes->find()->where(['CreditNotes.city_id'=>$city_id])->contain(['CreditNoteRows','Cities']);
		
		if ($this->request->is(['get'])){
			$search=$this->request->getQuery('search');
			$creditNotes->where([
							'OR' => [
									'CreditNotes.voucher_no LIKE' => $search.'%',
									'Cities.name LIKE' => $search.'%',
									'CreditNotes.narration LIKE' => $search.'%',
									'CreditNotes.created_on LIKE' => $search.'%'
									
							]
			]);
		}
		
		$creditNotes=$this->paginate($creditNotes);
		$paginate_limit=$this->paginate['limit'];
        $this->set(compact('creditNotes','paginate_limit'));
    }

    /**
     * View method
     *
     * @param string|null $id Credit Note id.
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
        $creditNote = $this->CreditNotes->get($id, [
            'contain' => ['Cities', 'AccountingEntries', 'CreditNoteRows'=>['Ledgers', 'ReferenceDetails']]
        ]);

		$this->loadmodel('Companies');
		$companies=$this->Companies->find()->where(['Companies.city_id'=>$city_id])->first();
		$this->set(compact('creditNote', 'companies'));
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
        $creditNote = $this->CreditNotes->newEntity();
       if ($this->request->is('post')) {
		   
		   $Voucher_no = $this->CreditNotes->find()->select(['voucher_no'])->where(['city_id'=>$city_id,'financial_year_id'=>$financial_year_id])->order(['voucher_no' => 'DESC'])->first();
			  if($Voucher_no)
			{
				$creditVoucher_no=$Voucher_no->voucher_no+1;
			}
			else
			{
				$creditVoucher_no=1;
			} 
			
		$creditNote = $this->CreditNotes->patchEntity($creditNote, $this->request->getData());
		
			$tdate=$this->request->data('transaction_date');
			$creditNote->transaction_date=date('Y-m-d',strtotime($tdate));
			$creditNote->financial_year_id = $financial_year_id;
			$creditNote->city_id = $city_id;
			$creditNote->voucher_no=$creditVoucher_no;
			$creditNote->created_by = $user_id;
			
		//pr($creditNote);exit;
		//transaction date for credit note code start here--
			
			//pr($creditNote);exit;
			//transaction date for credit note code close here--
		 //pr($this->request->getData()); exit;
            if ($data=$this->CreditNotes->save($creditNote)) {
				
			foreach($creditNote->credit_note_rows as $credit_note_row)
			{
				if(!empty($credit_note_row->reference_details))
				{
					foreach($credit_note_row->reference_details as $reference_detail1)
					{
						$reference_detail = $this->CreditNotes->ReferenceDetails->newEntity();
						$reference_detail->transaction_date = date('Y-m-d',strtotime($tdate));
						$reference_detail->credit_note_id =  $creditNote->id;
						$reference_detail->credit_note_row_id =  $credit_note_row->id;
						$reference_detail->ref_name =  $reference_detail1['ref_name'];
						$reference_detail->type =  $reference_detail1['type'];
						$reference_detail->ledger_id =  $reference_detail1['ledger_id'];
						$reference_detail->city_id =  $city_id;
						$test_cr_dr=$credit_note_row->cr_dr;
						if($test_cr_dr=='Cr'){
							$reference_detail->credit =  $reference_detail1['credit'];
						}
						if($test_cr_dr=='Dr'){
							$reference_detail->debit =  $reference_detail1['debit'];
						}
						
						$this->CreditNotes->ReferenceDetails->save($reference_detail);
					}
				}
			}
			
			
			foreach($creditNote->credit_note_rows as $credit_note_row)
				{
					$accountEntry = $this->CreditNotes->AccountingEntries->newEntity();
					$accountEntry->ledger_id                  = $credit_note_row->ledger_id;
					$accountEntry->debit                      = @$credit_note_row->debit;
					$accountEntry->credit                     = @$credit_note_row->credit;
					$accountEntry->transaction_date           = $creditNote->transaction_date;
					$accountEntry->city_id                 	  = $city_id;
					$accountEntry->entry_from                 ='Web';
					$accountEntry->credit_note_id             = $creditNote->id;
					$accountEntry->credit_note_row_id         = $credit_note_row->id;
					$this->CreditNotes->AccountingEntries->save($accountEntry);
				}
			
                $this->Flash->success(__('The Credit Note has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
			
            $this->Flash->error(__('The Credit Note could not be saved. Please, try again.'));
        }
		$Voucher_no = $this->CreditNotes->find()->select(['voucher_no'])->where(['city_id'=>$city_id,'financial_year_id'=>$financial_year_id])->order(['voucher_no' => 'DESC'])->first();
		if($Voucher_no)
		{
			$voucher_no=$Voucher_no->voucher_no+1;
		}
		else
		{
			$voucher_no=1;
		}
		
		//frst row options
		$bankParentGroups = $this->CreditNotes->CreditNoteRows->Ledgers->AccountingGroups->find()
						->where(['AccountingGroups.city_id'=>$city_id, 'AccountingGroups.bank'=>'1']);
						
		$bankGroups=[];
		
		foreach($bankParentGroups as $bankParentGroup)
		{
			$accountingGroups = $this->CreditNotes->CreditNoteRows->Ledgers->AccountingGroups
			->find('children', ['for' => $bankParentGroup->id])->toArray();
			$bankGroups[]=$bankParentGroup->id;
			foreach($accountingGroups as $accountingGroup){
				$bankGroups[]=$accountingGroup->id;
			}
		}
		
		//cash-in-hand group
		$cashParentGroups = $this->CreditNotes->CreditNoteRows->Ledgers->AccountingGroups->find()
						->where(['AccountingGroups.city_id'=>$city_id, 'AccountingGroups.cash'=>'1']);
						
		$cashGroups=[];
		
		foreach($cashParentGroups as $cashParentGroup)
		{
			$cashChildGroups = $this->CreditNotes->CreditNoteRows->Ledgers->AccountingGroups
			->find('children', ['for' => $cashParentGroup->id])->toArray();
			$cashGroups[]=$cashParentGroup->id;
			foreach($cashChildGroups as $cashChildGroup){
				$cashGroups[]=$cashChildGroup->id;
			}
		}
		
		$partyParentGroups = $this->CreditNotes->CreditNoteRows->Ledgers->AccountingGroups->find()
							->where(['AccountingGroups.city_id'=>$city_id, 'AccountingGroups.credit_note_first_row'=>1]);

		$partyGroups=[];
		
		foreach($partyParentGroups as $partyParentGroup)
		{
			
			$partyChildGroups = $this->CreditNotes->CreditNoteRows->Ledgers->AccountingGroups->find('children', ['for' => $partyParentGroup->id]);
			$partyGroups[]=$partyParentGroup->id;
			foreach($partyChildGroups as $partyChildGroup){
				$partyGroups[]=$partyChildGroup->id;
			}
		}
	
		$partyLedgers = $this->CreditNotes->CreditNoteRows->Ledgers->find()
		->where(['Ledgers.accounting_group_id IN' =>$partyGroups,'Ledgers.city_id'=>$city_id]);
		
		//$ledgers = $this->Payments->PaymentRows->Ledgers->find()->where(['city_id'=>$city_id]);
		foreach($partyLedgers as $ledger){
			if(in_array($ledger->accounting_group_id,$bankGroups)){
				$ledgerFirstOptions[]=['text' =>$ledger->name, 'value' => $ledger->id ,'open_window' => 'bank','bank_and_cash' => 'yes'];
			}
			else if($ledger->bill_to_bill_accounting == 'yes'){
				$ledgerFirstOptions[]=['text' =>$ledger->name, 'value' => $ledger->id,'open_window' => 'party','bank_and_cash' => 'no','default_days'=>$ledger->default_credit_days ];
			}
			else if(in_array($ledger->accounting_group_id,$cashGroups)){
				$ledgerFirstOptions[]=['text' =>$ledger->name, 'value' => $ledger->id ,'open_window' => 'no','bank_and_cash' => 'yes'];
			}
			else{
				$ledgerFirstOptions[]=['text' =>$ledger->name, 'value' => $ledger->id,'open_window' => 'no','bank_and_cash' => 'no' ];
			}
		}
		
		
		//2nd bank group
		$bankParentGroups = $this->CreditNotes->CreditNoteRows->Ledgers->AccountingGroups->find()
						->where(['AccountingGroups.city_id'=>$city_id, 'AccountingGroups.bank'=>'1']);
						
		$bankGroups=[];
		
		foreach($bankParentGroups as $bankParentGroup)
		{
			$accountingGroups = $this->CreditNotes->CreditNoteRows->Ledgers->AccountingGroups
			->find('children', ['for' => $bankParentGroup->id])->toArray();
			$bankGroups[]=$bankParentGroup->id;
			foreach($accountingGroups as $accountingGroup){
				$bankGroups[]=$accountingGroup->id;
			}
		}
		
		//cash-in-hand group
		$cashParentGroups = $this->CreditNotes->CreditNoteRows->Ledgers->AccountingGroups->find()
						->where(['AccountingGroups.city_id'=>$city_id, 'AccountingGroups.cash'=>'1']);
						
		$cashGroups=[];
		
		foreach($cashParentGroups as $cashParentGroup)
		{
			$cashChildGroups = $this->CreditNotes->CreditNoteRows->Ledgers->AccountingGroups
			->find('children', ['for' => $cashParentGroup->id])->toArray();
			$cashGroups[]=$cashParentGroup->id;
			foreach($cashChildGroups as $cashChildGroup){
				$cashGroups[]=$cashChildGroup->id;
			}
		}
		
		$partyParentGroups = $this->CreditNotes->CreditNoteRows->Ledgers->AccountingGroups->find()
							->where(['AccountingGroups.city_id'=>$city_id, 'AccountingGroups.credit_note_all_row'=>1]);

		$partyGroups=[];
		
		foreach($partyParentGroups as $partyParentGroup)
		{
			
			$partyChildGroups = $this->CreditNotes->CreditNoteRows->Ledgers->AccountingGroups->find('children', ['for' => $partyParentGroup->id]);
			$partyGroups[]=$partyParentGroup->id;
			foreach($partyChildGroups as $partyChildGroup){
				$partyGroups[]=$partyChildGroup->id;
			}
		}
	
		$partyLedgers = $this->CreditNotes->CreditNoteRows->Ledgers->find()
		->where(['Ledgers.accounting_group_id IN' =>$partyGroups,'Ledgers.city_id'=>$city_id]);
		
		//$ledgers = $this->Payments->PaymentRows->Ledgers->find()->where(['city_id'=>$city_id]);
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
		
		
		$referenceDetails=$this->CreditNotes->CreditNoteRows->ReferenceDetails->find('list');
        $this->set(compact('creditNote', 'companies','voucher_no','ledgerOptions','city_id','referenceDetails','ledgerFirstOptions'));
        $this->set('_serialize', ['creditNote']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Credit Note id.
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
        $creditNote = $this->CreditNotes->get($id, [
            'contain' => ['CreditNoteRows'=>['ReferenceDetails']]
        ]);
		
		
        if ($this->request->is(['patch', 'post', 'put'])) {
            
		   $creditNote = $this->CreditNotes->patchEntity($creditNote, $this->request->getData(), [
							'associated' => ['CreditNoteRows']
						]);
			
			//$creditNote->location_id = $location_id;
			$creditNote->financial_year_id = $financial_year_id;
			$creditNote->city_id = $city_id;
			$creditNote->created_by = $user_id;
			$traans_date= date('Y-m-d', strtotime($this->request->data['transaction_date']));
			$creditNote->transaction_date =$traans_date;
			$creditNote->total_credit_amount =$this->request->data['totalMainCr'];
			$creditNote->total_debit_amount =$this->request->data['totalMainDr'];
			
			//transaction date for creditNote code start here--
			/* foreach($creditNote->credit_note_rows as $credit_note_row)
			{
				if(!empty($credit_note_row->reference_details))
				{
					foreach($credit_note_row->reference_details as $reference_detail)
					{
						$reference_detail->transaction_date = date('Y-m-d', strtotime($creditNote->transaction_date));
						$reference_detail->city_id = $city_id;
					}
				}
			}
			 */
			// pr($creditNote); exit;
            if ($this->CreditNotes->save($creditNote))
			/* if ($this->CreditNotes->save($creditNote, [
							'associated' => ['PaymentRows','PaymentRows.ReferenceDetails']
						])) */
				{
			$this->CreditNotes->ReferenceDetails->deleteAll(['ReferenceDetails.credit_note_id'=>$id]);
			
			$this->CreditNotes->AccountingEntries->deleteAll(['AccountingEntries.credit_note_id'=>$id]);
			
			foreach($creditNote->credit_note_rows as $credit_note_row)
			{
				if(!empty($credit_note_row->reference_details))
				{
					foreach($credit_note_row->reference_details as $reference_detail1)
					{
						$reference_detail = $this->CreditNotes->ReferenceDetails->newEntity();
						$reference_detail->transaction_date = $traans_date;
						$reference_detail->location_id = 0;
						$reference_detail->credit_note_id =  $credit_note_row->credit_note_id;
						$reference_detail->credit_note_row_id =  $credit_note_row->id;
						$reference_detail->ref_name =  $reference_detail1['ref_name'];
						$reference_detail->type =  $reference_detail1['type'];
						$reference_detail->ledger_id =  $reference_detail1['ledger_id'];
						$reference_detail->city_id =  $city_id;
						$test_cr_dr=$credit_note_row->cr_dr;
						if($test_cr_dr=='Cr'){
							$reference_detail->credit =  $reference_detail1['credit'];
						}
						if($test_cr_dr=='Dr'){
							$reference_detail->debit =  $reference_detail1['debit'];
						}
						
						$this->CreditNotes->ReferenceDetails->save($reference_detail);
					}
				}
			}
			
				
				foreach($creditNote->credit_note_rows as $credit_note_row)
				{
					$accountEntry = $this->CreditNotes->AccountingEntries->newEntity();
					$accountEntry->ledger_id                  = $credit_note_row->ledger_id;
					$accountEntry->debit                      = @$credit_note_row->debit;
					$accountEntry->credit                     = @$credit_note_row->credit;
					$accountEntry->transaction_date           = date('Y-m-d', strtotime($creditNote->transaction_date));
					$accountEntry->city_id                    = $city_id;
					$accountEntry->credit_note_id             = $creditNote->id;
					$accountEntry->credit_note_row_id         = $credit_note_row->id;
					$accountEntry->entry_from                 = 'web';
					$this->CreditNotes->AccountingEntries->save($accountEntry);
				}
				$this->Flash->success(__('The creditNote has been saved.'));

				return $this->redirect(['action' => 'index']);
                $this->Flash->success(__('The creditNote has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The creditNote could not be saved. Please, try again.'));

        }
		
		
		$voucher_no=$creditNote->voucher_no;
		// pr($creditNote); exit;
		//bank group
		$bankParentGroups = $this->CreditNotes->CreditNoteRows->Ledgers->AccountingGroups->find()
						->where(['AccountingGroups.bank'=>'1']);
		
		$bankGroups=[];
		
		foreach($bankParentGroups as $bankParentGroup)
		{
			$accountingGroups = $this->CreditNotes->CreditNoteRows->Ledgers->AccountingGroups
			->find('children', ['for' => $bankParentGroup->id])->toArray();
			$bankGroups[]=$bankParentGroup->id;
			foreach($accountingGroups as $accountingGroup){
				$bankGroups[]=$accountingGroup->id;
			}
		}
		
		//cash-in-hand group
		$cashParentGroups = $this->CreditNotes->CreditNoteRows->Ledgers->AccountingGroups->find()
						->where(['AccountingGroups.cash'=>'1']);
						
		$cashGroups=[];
		
		foreach($cashParentGroups as $cashParentGroup)
		{
			$cashChildGroups = $this->CreditNotes->CreditNoteRows->Ledgers->AccountingGroups
			->find('children', ['for' => $cashParentGroup->id])->toArray();
			$cashGroups[]=$cashParentGroup->id;
			foreach($cashChildGroups as $cashChildGroup){
				$cashGroups[]=$cashChildGroup->id;
			}
		}
		
		$partyParentGroups = $this->CreditNotes->CreditNoteRows->Ledgers->AccountingGroups->find()
							->where(['AccountingGroups.credit_note_all_row'=>1]);

		$partyGroups=[];
		
		foreach($partyParentGroups as $partyParentGroup)
		{
			
			$partyChildGroups = $this->CreditNotes->CreditNoteRows->Ledgers->AccountingGroups->find('children', ['for' => $partyParentGroup->id]);
			$partyGroups[]=$partyParentGroup->id;
			foreach($partyChildGroups as $partyChildGroup){
				$partyGroups[]=$partyChildGroup->id;
			}
		}
	//pr($partyGroups->toArray()); exit;
		$partyLedgers = $this->CreditNotes->CreditNoteRows->Ledgers->find()
		->where(['Ledgers.accounting_group_id IN' =>$partyGroups,'Ledgers.city_id'=>$city_id]);
		
		//$ledgers = $this->CreditNotes->CreditNoteRows->Ledgers->find()->where(['company_id'=>$company_id]);
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
		
		$this->set(compact('creditNote', 'location_id','voucher_no','ledgerOptions', 'referenceDetails','city_id'));
		 
    }

    /**
     * Delete method
     *
     * @param string|null $id Credit Note id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $creditNote = $this->CreditNotes->get($id);
        if ($this->CreditNotes->delete($creditNote)) {
            $this->Flash->success(__('The credit note has been deleted.'));
        } else {
            $this->Flash->error(__('The credit note could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
