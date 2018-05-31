<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\View\View;
/**
 * DebitNotes Controller
 *
 * @property \App\Model\Table\DebitNotesTable $DebitNotes
 *
 * @method \App\Model\Entity\DebitNote[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DebitNotesController extends AppController
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

		$debitNotes = $this->DebitNotes->find()->where(['DebitNotes.city_id'=>$city_id])->contain(['DebitNoteRows','Cities']);

		if ($this->request->is(['get'])){
			$search=$this->request->getQuery('search');
			$debitNotes->where([
							'OR' => [
									'DebitNotes.voucher_no LIKE' => $search.'%',
									'Cities.name LIKE' => $search.'%',
									'DebitNotes.narration LIKE' => $search.'%',
									'DebitNotes.created_on LIKE' => $search.'%'
									
							]
			]);
		}
		
		$debitNotes=$this->paginate($debitNotes);
		$paginate_limit=$this->paginate['limit'];
        $this->set(compact('debitNotes','paginate_limit'));
    }

    /**
     * View method
     *
     * @param string|null $id Debit Note id.
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
        $debitNote = $this->DebitNotes->get($id, [
            'contain' => ['Cities', 'AccountingEntries', 'DebitNoteRows'=>['Ledgers', 'ReferenceDetails']]
        ]);
		
		$this->loadmodel('Companies');
		$companies=$this->Companies->find()->where(['Companies.city_id'=>$city_id])->first();
		$this->set(compact('debitNote', 'companies'));
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
        $debitNote = $this->DebitNotes->newEntity();
		
        if ($this->request->is('post')) {
            $debitNote = $this->DebitNotes->patchEntity($debitNote, $this->request->getData());
            if ($this->DebitNotes->save($debitNote)) {
                $this->Flash->success(__('The debit note has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The debit note could not be saved. Please, try again.'));
        }
		
		
		
		 if ($this->request->is('post')) {
		   
		   $Voucher_no = $this->DebitNotes->find()->select(['voucher_no'])->where(['city_id'=>$city_id])->order(['voucher_no' => 'DESC'])->first();
			  if($Voucher_no)
			{
				$creditVoucher_no=$Voucher_no->voucher_no+1;
			}
			else
			{
				$creditVoucher_no=1;
			} 
			
		$debitNote = $this->DebitNotes->patchEntity($debitNote, $this->request->getData());
		
			$tdate=$this->request->data('transaction_date');
			$debitNote->transaction_date=date('Y-m-d',strtotime($tdate));
			$debitNote->city_id = $city_id;
			$debitNote->voucher_no=$creditVoucher_no;
			$debitNote->created_by = $user_id;
			
		//pr($this->request->getData());exit;
		//transaction date for credit note code start here--
			
			 
			//transaction date for credit note code close here--
            if ($data=$this->DebitNotes->save($debitNote)) {
				
			foreach($debitNote->debit_note_rows as $debit_note_row)
			{
				if(!empty($debit_note_row->reference_details))
				{
					foreach($debit_note_row->reference_details as $reference_detail1)
					{
						$reference_detail = $this->DebitNotes->ReferenceDetails->newEntity();
						$reference_detail->transaction_date = date('Y-m-d',strtotime($tdate));
						$reference_detail->debit_note_id =  $debitNote->id;
						$reference_detail->debit_note_row_id =  $debit_note_row->id;
						$reference_detail->ref_name =  $reference_detail1['ref_name'];
						$reference_detail->type =  $reference_detail1['type'];
						$reference_detail->ledger_id =  $reference_detail1['ledger_id'];
						$reference_detail->city_id =  $city_id;
						$test_cr_dr=$debit_note_row->cr_dr;
						if($test_cr_dr=='Cr'){
							$reference_detail->credit =  $reference_detail1['credit'];
						}
						if($test_cr_dr=='Dr'){
							$reference_detail->debit =  $reference_detail1['debit'];
						}
						 
						$this->DebitNotes->ReferenceDetails->save($reference_detail);
					}
				}
			}
			
			
			foreach($debitNote->debit_note_rows as $debit_note_row)
				{
					$accountEntry = $this->DebitNotes->AccountingEntries->newEntity();
					$accountEntry->ledger_id                  = $debit_note_row->ledger_id;
					$accountEntry->debit                      = @$debit_note_row->debit;
					$accountEntry->credit                     = @$debit_note_row->credit;
					$accountEntry->transaction_date           = $debitNote->transaction_date;
					$accountEntry->city_id                 	  = $city_id;
					$accountEntry->entry_from                 ='Web';
					$accountEntry->debit_note_id             = $debitNote->id;
					$accountEntry->debit_note_row_id         = $debit_note_row->id;
					$this->DebitNotes->AccountingEntries->save($accountEntry);
				}
			
                $this->Flash->success(__('The Credit Note has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
			
            $this->Flash->error(__('The Credit Note could not be saved. Please, try again.'));
        }
		$Voucher_no = $this->DebitNotes->find()->select(['voucher_no'])->where(['city_id'=>$city_id])->order(['voucher_no' => 'DESC'])->first();
		if($Voucher_no)
		{
			$voucher_no=$Voucher_no->voucher_no+1;
		}
		else
		{
			$voucher_no=1;
		}
		
		//frst row options
		$bankParentGroups = $this->DebitNotes->DebitNoteRows->Ledgers->AccountingGroups->find()
						->where(['AccountingGroups.city_id'=>$city_id, 'AccountingGroups.bank'=>'1']);
						
		$bankGroups=[];
		
		foreach($bankParentGroups as $bankParentGroup)
		{
			$accountingGroups = $this->DebitNotes->DebitNoteRows->Ledgers->AccountingGroups
			->find('children', ['for' => $bankParentGroup->id])->toArray();
			$bankGroups[]=$bankParentGroup->id;
			foreach($accountingGroups as $accountingGroup){
				$bankGroups[]=$accountingGroup->id;
			}
		}
		
		//cash-in-hand group
		$cashParentGroups = $this->DebitNotes->DebitNoteRows->Ledgers->AccountingGroups->find()
						->where(['AccountingGroups.city_id'=>$city_id, 'AccountingGroups.cash'=>'1']);
						
		$cashGroups=[];
		
		foreach($cashParentGroups as $cashParentGroup)
		{
			$cashChildGroups = $this->DebitNotes->DebitNoteRows->Ledgers->AccountingGroups
			->find('children', ['for' => $cashParentGroup->id])->toArray();
			$cashGroups[]=$cashParentGroup->id;
			foreach($cashChildGroups as $cashChildGroup){
				$cashGroups[]=$cashChildGroup->id;
			}
		}
		
		$partyParentGroups = $this->DebitNotes->DebitNoteRows->Ledgers->AccountingGroups->find()
							->where(['AccountingGroups.city_id'=>$city_id, 'AccountingGroups.credit_note_first_row'=>1]);

		$partyGroups=[];
		
		foreach($partyParentGroups as $partyParentGroup)
		{
			
			$partyChildGroups = $this->DebitNotes->DebitNoteRows->Ledgers->AccountingGroups->find('children', ['for' => $partyParentGroup->id]);
			$partyGroups[]=$partyParentGroup->id;
			foreach($partyChildGroups as $partyChildGroup){
				$partyGroups[]=$partyChildGroup->id;
			}
		}
	
		$partyLedgers = $this->DebitNotes->DebitNoteRows->Ledgers->find()
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
		$bankParentGroups = $this->DebitNotes->DebitNoteRows->Ledgers->AccountingGroups->find()
						->where(['AccountingGroups.city_id'=>$city_id, 'AccountingGroups.bank'=>'1']);
						
		$bankGroups=[];
		
		foreach($bankParentGroups as $bankParentGroup)
		{
			$accountingGroups = $this->DebitNotes->DebitNoteRows->Ledgers->AccountingGroups
			->find('children', ['for' => $bankParentGroup->id])->toArray();
			$bankGroups[]=$bankParentGroup->id;
			foreach($accountingGroups as $accountingGroup){
				$bankGroups[]=$accountingGroup->id;
			}
		}
		
		//cash-in-hand group
		$cashParentGroups = $this->DebitNotes->DebitNoteRows->Ledgers->AccountingGroups->find()
						->where(['AccountingGroups.city_id'=>$city_id, 'AccountingGroups.cash'=>'1']);
						
		$cashGroups=[];
		
		foreach($cashParentGroups as $cashParentGroup)
		{
			$cashChildGroups = $this->DebitNotes->DebitNoteRows->Ledgers->AccountingGroups
			->find('children', ['for' => $cashParentGroup->id])->toArray();
			$cashGroups[]=$cashParentGroup->id;
			foreach($cashChildGroups as $cashChildGroup){
				$cashGroups[]=$cashChildGroup->id;
			}
		}
		
		$partyParentGroups = $this->DebitNotes->DebitNoteRows->Ledgers->AccountingGroups->find()
							->where(['AccountingGroups.city_id'=>$city_id, 'AccountingGroups.debit_note_all_row'=>1]);

		$partyGroups=[];
		
		foreach($partyParentGroups as $partyParentGroup)
		{
			
			$partyChildGroups = $this->DebitNotes->DebitNoteRows->Ledgers->AccountingGroups->find('children', ['for' => $partyParentGroup->id]);
			$partyGroups[]=$partyParentGroup->id;
			foreach($partyChildGroups as $partyChildGroup){
				$partyGroups[]=$partyChildGroup->id;
			}
		}
	
		$partyLedgers = $this->DebitNotes->DebitNoteRows->Ledgers->find()
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
		
		
		$referenceDetails=$this->DebitNotes->DebitNoteRows->ReferenceDetails->find('list');
        $this->set(compact('debitNote', 'companies','voucher_no','ledgerOptions','city_id','referenceDetails','ledgerFirstOptions'));
        $this->set('_serialize', ['debitNote']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Debit Note id.
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
        $debitNote = $this->DebitNotes->get($id, [
            'contain' => ['DebitNoteRows'=>['ReferenceDetails']]
        ]);
		
        if ($this->request->is(['patch', 'post', 'put'])) {
             
			 $debitNote = $this->DebitNotes->patchEntity($debitNote, $this->request->getData(), [
							'associated' => ['DebitNoteRows']
						]);
			
			//$debitNote->location_id = $location_id;
			$debitNote->city_id = $city_id;
			$debitNote->created_by = $user_id;
			$traans_date= date('Y-m-d', strtotime($this->request->data['transaction_date']));
			$debitNote->transaction_date =$traans_date;
			$debitNote->total_credit_amount =$this->request->data['totalMainCr'];
			$debitNote->total_debit_amount =$this->request->data['totalMainDr'];
			
			//transaction date for debitNote code start here--
			/* foreach($debitNote->debit_note_rows as $debit_note_row)
			{
				if(!empty($debit_note_row->reference_details))
				{
					foreach($debit_note_row->reference_details as $reference_detail)
					{
						$reference_detail->transaction_date = date('Y-m-d', strtotime($debitNote->transaction_date));
						$reference_detail->city_id = $city_id;
					}
				}
			}
			 */
			// pr($debitNote); exit;
            if ($this->DebitNotes->save($debitNote))
			/* if ($this->DebitNotes->save($debitNote, [
							'associated' => ['PaymentRows','PaymentRows.ReferenceDetails']
						])) */
				{
			$this->DebitNotes->ReferenceDetails->deleteAll(['ReferenceDetails.debit_note_id'=>$id]);
			
			$this->DebitNotes->AccountingEntries->deleteAll(['AccountingEntries.debit_note_id'=>$id]);
			
			foreach($debitNote->debit_note_rows as $debit_note_row)
			{
				if(!empty($debit_note_row->reference_details))
				{
					foreach($debit_note_row->reference_details as $reference_detail1)
					{
						$reference_detail = $this->DebitNotes->ReferenceDetails->newEntity();
						$reference_detail->transaction_date = $traans_date;
						$reference_detail->location_id = 0;
						$reference_detail->debit_note_id =  $debit_note_row->debit_note_id;
						$reference_detail->debit_note_row_id =  $debit_note_row->id;
						$reference_detail->ref_name =  $reference_detail1['ref_name'];
						$reference_detail->type =  $reference_detail1['type'];
						$reference_detail->ledger_id =  $reference_detail1['ledger_id'];
						$reference_detail->city_id =  $city_id;
						$test_cr_dr=$debit_note_row->cr_dr;
						if($test_cr_dr=='Cr'){
							$reference_detail->credit =  $reference_detail1['credit'];
						}
						if($test_cr_dr=='Dr'){
							$reference_detail->debit =  $reference_detail1['debit'];
						}
						
						$this->DebitNotes->ReferenceDetails->save($reference_detail);
					}
				}
			}
			
				
				foreach($debitNote->debit_note_rows as $debit_note_row)
				{
					$accountEntry = $this->DebitNotes->AccountingEntries->newEntity();
					$accountEntry->ledger_id                  = $debit_note_row->ledger_id;
					$accountEntry->debit                      = @$debit_note_row->debit;
					$accountEntry->credit                     = @$debit_note_row->credit;
					$accountEntry->transaction_date           = date('Y-m-d', strtotime($debitNote->transaction_date));
					$accountEntry->city_id                    = $city_id;
					$accountEntry->debit_note_id              = $debitNote->id;
					$accountEntry->debit_note_row_id	      = $debit_note_row->id;
					$accountEntry->entry_from                 = 'web';
					$this->DebitNotes->AccountingEntries->save($accountEntry);
				}
				$this->Flash->success(__('The debitNote has been saved.'));

				return $this->redirect(['action' => 'index']);
                $this->Flash->success(__('The debitNote has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The debitNote could not be saved. Please, try again.'));

        }
		
		$voucher_no=$debitNote->voucher_no;
		// pr($debitNote); exit;
		//bank group
		$bankParentGroups = $this->DebitNotes->DebitNoteRows->Ledgers->AccountingGroups->find()
						->where(['AccountingGroups.bank'=>'1']);
		
		$bankGroups=[];
		
		foreach($bankParentGroups as $bankParentGroup)
		{
			$accountingGroups = $this->DebitNotes->DebitNoteRows->Ledgers->AccountingGroups
			->find('children', ['for' => $bankParentGroup->id])->toArray();
			$bankGroups[]=$bankParentGroup->id;
			foreach($accountingGroups as $accountingGroup){
				$bankGroups[]=$accountingGroup->id;
			}
		}
		
		//cash-in-hand group
		$cashParentGroups = $this->DebitNotes->DebitNoteRows->Ledgers->AccountingGroups->find()
						->where(['AccountingGroups.cash'=>'1']);
						
		$cashGroups=[];
		
		foreach($cashParentGroups as $cashParentGroup)
		{
			$cashChildGroups = $this->DebitNotes->DebitNoteRows->Ledgers->AccountingGroups
			->find('children', ['for' => $cashParentGroup->id])->toArray();
			$cashGroups[]=$cashParentGroup->id;
			foreach($cashChildGroups as $cashChildGroup){
				$cashGroups[]=$cashChildGroup->id;
			}
		}
		
		$partyParentGroups = $this->DebitNotes->DebitNoteRows->Ledgers->AccountingGroups->find()
							->where(['AccountingGroups.debit_note_all_row'=>1]);

		$partyGroups=[];
		
		foreach($partyParentGroups as $partyParentGroup)
		{
			
			$partyChildGroups = $this->DebitNotes->DebitNoteRows->Ledgers->AccountingGroups->find('children', ['for' => $partyParentGroup->id]);
			$partyGroups[]=$partyParentGroup->id;
			foreach($partyChildGroups as $partyChildGroup){
				$partyGroups[]=$partyChildGroup->id;
			}
		}
	//pr($partyGroups->toArray()); exit;
		$partyLedgers = $this->DebitNotes->DebitNoteRows->Ledgers->find()
		->where(['Ledgers.accounting_group_id IN' =>$partyGroups,'Ledgers.city_id'=>$city_id]);
		
		//$ledgers = $this->DebitNotes->DebitNoteRows->Ledgers->find()->where(['company_id'=>$company_id]);
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
		
		$this->set(compact('debitNote', 'location_id','voucher_no','ledgerOptions', 'referenceDetails','city_id'));
		 
    }

    /**
     * Delete method
     *
     * @param string|null $id Debit Note id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $debitNote = $this->DebitNotes->get($id);
        if ($this->DebitNotes->delete($debitNote)) {
            $this->Flash->success(__('The debit note has been deleted.'));
        } else {
            $this->Flash->error(__('The debit note could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
