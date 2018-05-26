<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\View\View;

/**
 * ContraVouchers Controller
 *
 * @property \App\Model\Table\ContraVouchersTable $ContraVouchers
 *
 * @method \App\Model\Entity\ContraVoucher[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ContraVouchersController extends AppController
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
			'limit' => 20
        ];
		$contraVouchers = $this->ContraVouchers->find()->where(['ContraVouchers.city_id'=>$city_id])->contain(['ContraVoucherRows','Cities']);
		if ($this->request->is(['get'])){
			$search=$this->request->getQuery('search');
			$contraVouchers->where([
							'OR' => [
									'ContraVouchers.voucher_no LIKE' => $search.'%',
									'Cities.name LIKE' => $search.'%',
									'ContraVouchers.narration LIKE' => $search.'%',
									'ContraVouchers.created_on LIKE' => $search.'%'
									
							]
			]);
		}
       // pr($contraVouchers->toArray()); exit;
		$contraVouchers=$this->paginate($contraVouchers);
		$paginate_limit=$this->paginate['limit'];
        $this->set(compact('contraVouchers','paginate_limit'));
    }

    /**
     * View method
     *
     * @param string|null $id Contra Voucher id.
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
        $contraVoucher = $this->ContraVouchers->get($id, [
            'contain' => ['AccountingEntries', 'ContraVoucherRows'=>['ReferenceDetails','Ledgers']]
        ]);
		$this->loadmodel('Companies');
		$companies=$this->Companies->find()->where(['Companies.city_id'=>$city_id])->first();
		$this->set(compact('contraVoucher', 'companies'));
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
        $contraVoucher = $this->ContraVouchers->newEntity();
		if ($this->request->is('post')) {
			
			$traans_date = date("Y-m-d",strtotime($this->request->getData()['transaction_date']));
			 
			$Voucher = $this->ContraVouchers->find()->select(['voucher_no'])->where(['city_id'=>$city_id])->order(['voucher_no' => 'DESC'])->first();
			if($Voucher)
			{
				$contraVoucher->voucher_no = $Voucher->voucher_no+1;
			}
			else
			{
				$contraVoucher->voucher_no = 1;
			}
			//$contraVoucher->location_id = $location_id;
			$contraVoucher->city_id = $city_id;
			$contraVoucher->created_by = $user_id;
			
			
			$contraVoucher = $this->ContraVouchers->patchEntity($contraVoucher, $this->request->getData(), [
							'associated' => ['ContraVoucherRows']
						]);
						$contraVoucher->transaction_date = $traans_date;
						$vendor_id=$contraVoucher->vendor_id;
					//pr($contraVoucher->contra_voucher_rows); exit;
			//transaction date for contraVoucher code start here--
			/* foreach($contraVoucher->contra_voucher_rows as $payment_row)
			{
				if(!empty($payment_row->reference_details))
				{
					foreach($payment_row->reference_details as $reference_detail)
					{
						$reference_detail->transaction_date = $traans_date;
						$reference_detail->city_id = $city_id;
						//$reference_detail->vendor_id = $contraVoucher->vendor_id;
					}
				}
			} */
			//transaction date for contraVoucher code close here-- 
			//pr($contraVoucher); exit;
			if ($data=$this->ContraVouchers->save($contraVoucher)) {
				
			foreach($contraVoucher->contra_voucher_rows as $contra_voucher_row)
			{
				if(!empty($contra_voucher_row->reference_details))
				{
					foreach($contra_voucher_row->reference_details as $reference_detail1)
					{
						$reference_detail = $this->ContraVouchers->ReferenceDetails->newEntity();
						$reference_detail->transaction_date = $traans_date;
						$reference_detail->contra_voucher_id =  $contra_voucher_row->contra_voucher_id;
						$reference_detail->contra_voucher_row_id =  $contra_voucher_row->id;
						$reference_detail->ref_name =  $reference_detail1['ref_name'];
						$reference_detail->type =  $reference_detail1['type'];
						$reference_detail->ledger_id =  $reference_detail1['ledger_id'];
						$reference_detail->city_id =  $city_id;
						$test_cr_dr=$contra_voucher_row->cr_dr;
						if($test_cr_dr=='Cr'){
							$reference_detail->credit =  $reference_detail1['credit'];
						}
						if($test_cr_dr=='Dr'){
							$reference_detail->debit =  $reference_detail1['debit'];
						}
						
						$this->ContraVouchers->ReferenceDetails->save($reference_detail);
					}
				}
			}
			
				
			foreach($contraVoucher->contra_voucher_rows as $payment_row)
				{
					$accountEntry = $this->ContraVouchers->AccountingEntries->newEntity();
					$accountEntry->ledger_id                  = $payment_row->ledger_id;
					$accountEntry->debit                      = @$payment_row->debit;
					$accountEntry->credit                     = @$payment_row->credit;
					$accountEntry->transaction_date           = $traans_date;
					$accountEntry->city_id                    = $city_id;
					$accountEntry->contra_voucher_id                 = $contraVoucher->id;
					$accountEntry->contra_voucher_row_id             = $payment_row->id;
					$accountEntry->entry_from                 = 'web';
					$this->ContraVouchers->AccountingEntries->save($accountEntry);
				}
				$this->Flash->success(__('The contraVoucher has been saved.'));

				return $this->redirect(['action' => 'index']);
			}
			
			$this->Flash->error(__('The contraVoucher could not be saved. Please, try again.'));
		}
		 
		
		$Voucher = $this->ContraVouchers->find()->select(['voucher_no'])->where(['city_id'=>$city_id])->order(['voucher_no' => 'DESC'])->first();
		if($Voucher)
		{
			$voucher_no=$Voucher->voucher_no+1;
		}
		else
		{
			$voucher_no=1;
		}
		
		$bankParentGroups = $this->ContraVouchers->ContraVoucherRows->Ledgers->AccountingGroups->find()
						->where(['AccountingGroups.bank'=>'1']);
		
		$bankGroups=[];
		
		foreach($bankParentGroups as $bankParentGroup)
		{
			$accountingGroups = $this->ContraVouchers->ContraVoucherRows->Ledgers->AccountingGroups
			->find('children', ['for' => $bankParentGroup->id])->toArray();
			$bankGroups[]=$bankParentGroup->id;
			foreach($accountingGroups as $accountingGroup){
				$bankGroups[]=$accountingGroup->id;
			}
		}
		
		
		$cashParentGroups = $this->ContraVouchers->ContraVoucherRows->Ledgers->AccountingGroups->find()
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
		
		$partyParentGroups = $this->ContraVouchers->ContraVoucherRows->Ledgers->AccountingGroups->find()
							->where(['AccountingGroups.contra_voucher_ledger'=>1]);

		$partyGroups=[];
		
		foreach($partyParentGroups as $partyParentGroup)
		{
			
			$partyChildGroups = $this->ContraVouchers->ContraVoucherRows->Ledgers->AccountingGroups->find('children', ['for' => $partyParentGroup->id]);
			$partyGroups[]=$partyParentGroup->id;
			foreach($partyChildGroups as $partyChildGroup){
				$partyGroups[]=$partyChildGroup->id;
			}
		}
	
		$partyLedgers = $this->ContraVouchers->ContraVoucherRows->Ledgers->find()
		->where(['Ledgers.accounting_group_id IN' =>$partyGroups,'Ledgers.city_id'=>$city_id]);
		
		//$ledgers = $this->Payments->ContraVoucherRows->Ledgers->find()->where(['company_id'=>$company_id]);
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
		
		
        $locations = $this->ContraVouchers->Locations->find('list', ['limit' => 200]);
        $this->set(compact('voucher_no','contraVoucher', 'locations', 'voucher_no','ledgerOptions','city_id'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Contra Voucher id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $contraVoucher = $this->ContraVouchers->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $contraVoucher = $this->ContraVouchers->patchEntity($contraVoucher, $this->request->getData());
            if ($this->ContraVouchers->save($contraVoucher)) {
                $this->Flash->success(__('The contra voucher has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The contra voucher could not be saved. Please, try again.'));
        }
        $locations = $this->ContraVouchers->Locations->find('list', ['limit' => 200]);
        $this->set(compact('contraVoucher', 'locations'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Contra Voucher id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $contraVoucher = $this->ContraVouchers->get($id);
        if ($this->ContraVouchers->delete($contraVoucher)) {
            $this->Flash->success(__('The contra voucher has been deleted.'));
        } else {
            $this->Flash->error(__('The contra voucher could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
