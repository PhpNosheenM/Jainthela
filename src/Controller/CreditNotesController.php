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
            'contain' => ['Locations', 'Cities']
        ];
        $creditNotes = $this->paginate($this->CreditNotes);

        $this->set(compact('creditNotes'));
    }

    /**
     * View method
     *
     * @param string|null $id Credit Note id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $creditNote = $this->CreditNotes->get($id, [
            'contain' => ['Locations', 'Cities', 'AccountingEntries', 'CreditNoteRows', 'ItemLedgers', 'ReferenceDetails']
        ]);

        $this->set('creditNote', $creditNote);
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
        $creditNote = $this->CreditNotes->newEntity();
       if ($this->request->is('post')) {
		   
		   $Voucher_no = $this->CreditNotes->find()->select(['voucher_no'])->where(['city_id'=>$city_id])->order(['voucher_no' => 'DESC'])->first();
			  if($Voucher_no)
			{
				$creditVoucher_no=$Voucher_no->voucher_no+1;
			}
			else
			{
				$creditVoucher_no=1;
			} 
			
		$creditNote = $this->CreditNotes->patchEntity($creditNote, $this->request->getData(),['associated' => ['CreditNoteRows','CreditNoteRows.ReferenceDetails']]);
		
			$tdate=$this->request->data('transaction_date');
			$creditNote->transaction_date=date('Y-m-d',strtotime($tdate));
			$creditNote->city_id = $city_id;
			$creditNote->voucher_no=$creditVoucher_no;
			$creditNote->created_by = $user_id;
			
		//pr($creditNote);exit;
		//transaction date for credit note code start here--
			foreach($creditNote->credit_note_rows as $credit_note_row)
			{
				if(!empty($credit_note_row->reference_details))
				{
					foreach($credit_note_row->reference_details as $reference_detail)
					{
						$reference_detail->transaction_date = $creditNote->transaction_date;
					}
				}
			}
			//pr($creditNote);exit;
			//transaction date for credit note code close here--
		 //pr($this->request->getData()); exit;
            if ($this->CreditNotes->save($creditNote)) {
			
			foreach($creditNote->credit_note_rows as $credit_note_row)
				{
					$accountEntry = $this->CreditNotes->AccountingEntries->newEntity();
					$accountEntry->ledger_id                  = $credit_note_row->ledger_id;
					$accountEntry->debit                      = @$credit_note_row->debit;
					$accountEntry->credit                     = @$credit_note_row->credit;
					$accountEntry->transaction_date           = $creditNote->transaction_date;
					$accountEntry->city_id                 = $city_id;
					$accountEntry->credit_note_id                 = $creditNote->id;
					$accountEntry->credit_note_row_id             = $credit_note_row->id;
					$this->CreditNotes->AccountingEntries->save($accountEntry);
				}
			
                $this->Flash->success(__('The Credit Note has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
			 
            $this->Flash->error(__('The Credit Note could not be saved. Please, try again.'));
        }
		$Voucher_no = $this->CreditNotes->find()->select(['voucher_no'])->where(['city_id'=>$city_id])->order(['voucher_no' => 'DESC'])->first();
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
    public function edit($id = null)
    {
        $creditNote = $this->CreditNotes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $creditNote = $this->CreditNotes->patchEntity($creditNote, $this->request->getData());
            if ($this->CreditNotes->save($creditNote)) {
                $this->Flash->success(__('The credit note has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The credit note could not be saved. Please, try again.'));
        }
        $locations = $this->CreditNotes->Locations->find('list', ['limit' => 200]);
        $cities = $this->CreditNotes->Cities->find('list', ['limit' => 200]);
        $this->set(compact('creditNote', 'locations', 'cities'));
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
