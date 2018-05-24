<?php
namespace App\Controller;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\View\View;
/**
 * Payments Controller
 *
 * @property \App\Model\Table\PaymentsTable $Payments
 *
 * @method \App\Model\Entity\Payment[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PaymentsController extends AppController
{
	public function beforeFilter(Event $event)
	{
		parent::beforeFilter($event);
		 $this->Security->setConfig('unlockedActions', ['add','index','view']);
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
		$paymentVouchers = $this->Payments->find()->where(['Payments.city_id'=>$city_id])->contain(['PaymentRows','Cities']);
		
		if ($this->request->is(['get'])){
			$search=$this->request->getQuery('search');
			$paymentVouchers->where([
							'OR' => [
									'Payments.voucher_no LIKE' => $search.'%',
									'Cities.name LIKE' => $search.'%',
									'Payments.narration LIKE' => $search.'%',
									'Payments.created_on LIKE' => $search.'%'
									
							]
			]);
		}
        
		$paymentVouchers=$this->paginate($paymentVouchers);
		$paginate_limit=$this->paginate['limit'];
        $this->set(compact('paymentVouchers','paginate_limit'));
    }

    /**
     * View method
     *
     * @param string|null $id Payment id.
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
        $payment = $this->Payments->get($id, [
            'contain' => ['AccountingEntries', 'PaymentRows'=>['ReferenceDetails','Ledgers']]
        ]);
		$this->loadmodel('Companies');
		$companies=$this->Companies->find()->where(['Companies.city_id'=>$city_id])->first();
        //$this->set('payment', $payment, 'companies');
		$this->set(compact('payment', 'companies'));
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
        $payment = $this->Payments->newEntity();
		
		if ($this->request->is('post')) {
		
			//$this->request->data['transaction_date'] = date("Y-m-d",strtotime($this->request->getData()['transaction_date']));
			$Voucher = $this->Payments->find()->select(['voucher_no'])->where(['city_id'=>$city_id])->order(['voucher_no' => 'DESC'])->first();
			if($Voucher)
			{
				$payment->voucher_no = $Voucher->voucher_no+1;
			}
			else
			{
				$payment->voucher_no = 1;
			}
			//$payment->location_id = $location_id;
			$payment->city_id = $city_id;
			$payment->created_by = $user_id;
			$payment->transaction_date = date('Y-m-d', strtotime($this->request->data['transaction_date']));
			
			$payment = $this->Payments->patchEntity($payment, $this->request->getData(), [
							'associated' => ['PaymentRows','PaymentRows.ReferenceDetails']
						]);
			
			//transaction date for payment code start here--
			foreach($payment->payment_rows as $payment_row)
			{
				if(!empty($payment_row->reference_details))
				{
					foreach($payment_row->reference_details as $reference_detail)
					{
						$reference_detail->transaction_date = date('Y-m-d', strtotime($payment->transaction_date));
						$reference_detail->city_id = $city_id;
					}
				}
			}
			//transaction date for payment code close here-- 
			
			if ($this->Payments->save($payment)) {
				
			foreach($payment->payment_rows as $payment_row)
				{
					$accountEntry = $this->Payments->AccountingEntries->newEntity();
					$accountEntry->ledger_id                  = $payment_row->ledger_id;
					$accountEntry->debit                      = @$payment_row->debit;
					$accountEntry->credit                     = @$payment_row->credit;
					$accountEntry->transaction_date           = date('Y-m-d', strtotime($payment->transaction_date));
					$accountEntry->city_id                    = $city_id;
					$accountEntry->payment_id                 = $payment->id;
					$accountEntry->payment_row_id             = $payment_row->id;
					$accountEntry->entry_from                 = 'web';
					$this->Payments->AccountingEntries->save($accountEntry);
				}
				$this->Flash->success(__('The payment has been saved.'));

				return $this->redirect(['action' => 'index']);
			}
			
			$this->Flash->error(__('The payment could not be saved. Please, try again.'));
		}
		$Voucher = $this->Payments->find()->select(['voucher_no'])->where(['city_id'=>$city_id])->order(['voucher_no' => 'DESC'])->first();
		if($Voucher)
		{
			$voucher_no=$Voucher->voucher_no+1;
		}
		else
		{
			$voucher_no=1;
		}
		//bank group
		$bankParentGroups = $this->Payments->PaymentRows->Ledgers->AccountingGroups->find()
						->where(['AccountingGroups.bank'=>'1']);
		
		$bankGroups=[];
		
		foreach($bankParentGroups as $bankParentGroup)
		{
			$accountingGroups = $this->Payments->PaymentRows->Ledgers->AccountingGroups
			->find('children', ['for' => $bankParentGroup->id])->toArray();
			$bankGroups[]=$bankParentGroup->id;
			foreach($accountingGroups as $accountingGroup){
				$bankGroups[]=$accountingGroup->id;
			}
		}
		
		//cash-in-hand group
		$cashParentGroups = $this->Payments->PaymentRows->Ledgers->AccountingGroups->find()
						->where(['AccountingGroups.cash'=>'1']);
						
		$cashGroups=[];
		
		foreach($cashParentGroups as $cashParentGroup)
		{
			$cashChildGroups = $this->Payments->PaymentRows->Ledgers->AccountingGroups
			->find('children', ['for' => $cashParentGroup->id])->toArray();
			$cashGroups[]=$cashParentGroup->id;
			foreach($cashChildGroups as $cashChildGroup){
				$cashGroups[]=$cashChildGroup->id;
			}
		}
		
		$partyParentGroups = $this->Payments->PaymentRows->Ledgers->AccountingGroups->find()
							->where(['AccountingGroups.payment_ledger'=>1]);

		$partyGroups=[];
		
		foreach($partyParentGroups as $partyParentGroup)
		{
			
			$partyChildGroups = $this->Payments->PaymentRows->Ledgers->AccountingGroups->find('children', ['for' => $partyParentGroup->id]);
			$partyGroups[]=$partyParentGroup->id;
			foreach($partyChildGroups as $partyChildGroup){
				$partyGroups[]=$partyChildGroup->id;
			}
		}
	//pr($partyGroups->toArray()); exit;
		$partyLedgers = $this->Payments->PaymentRows->Ledgers->find()
		->where(['Ledgers.accounting_group_id IN' =>$partyGroups,'Ledgers.city_id'=>$city_id]);
		
		//$ledgers = $this->Payments->PaymentRows->Ledgers->find()->where(['company_id'=>$company_id]);
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
		
		//$referenceDetails=$this->Payments->PaymentRows->ReferenceDetails->find('list');
		
		$this->set(compact('payment', 'location_id','voucher_no','ledgerOptions', 'referenceDetails','city_id'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Payment id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
		$city_id=$this->Auth->User('city_id');
		$location_id=$this->Auth->User('location_id');
		$user_id=$this->Auth->User('id');
		$this->viewBuilder()->layout('super_admin_layout');
        $payment = $this->Payments->get($id, [
            'contain' => ['PaymentRows'=>['ReferenceDetails']]
        ]);
		
        if ($this->request->is(['patch', 'post', 'put'])) {
			
            $payment = $this->Payments->patchEntity($payment, $this->request->getData());
			
            if ($this->Payments->save($payment)) {
                $this->Flash->success(__('The payment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The payment could not be saved. Please, try again.'));
        }
        
		 $voucher_no=$payment->voucher_no;
		 
		//bank group
		$bankParentGroups = $this->Payments->PaymentRows->Ledgers->AccountingGroups->find()
						->where(['AccountingGroups.bank'=>'1']);
		
		$bankGroups=[];
		
		foreach($bankParentGroups as $bankParentGroup)
		{
			$accountingGroups = $this->Payments->PaymentRows->Ledgers->AccountingGroups
			->find('children', ['for' => $bankParentGroup->id])->toArray();
			$bankGroups[]=$bankParentGroup->id;
			foreach($accountingGroups as $accountingGroup){
				$bankGroups[]=$accountingGroup->id;
			}
		}
		
		//cash-in-hand group
		$cashParentGroups = $this->Payments->PaymentRows->Ledgers->AccountingGroups->find()
						->where(['AccountingGroups.cash'=>'1']);
						
		$cashGroups=[];
		
		foreach($cashParentGroups as $cashParentGroup)
		{
			$cashChildGroups = $this->Payments->PaymentRows->Ledgers->AccountingGroups
			->find('children', ['for' => $cashParentGroup->id])->toArray();
			$cashGroups[]=$cashParentGroup->id;
			foreach($cashChildGroups as $cashChildGroup){
				$cashGroups[]=$cashChildGroup->id;
			}
		}
		
		$partyParentGroups = $this->Payments->PaymentRows->Ledgers->AccountingGroups->find()
							->where(['AccountingGroups.payment_ledger'=>1]);

		$partyGroups=[];
		
		foreach($partyParentGroups as $partyParentGroup)
		{
			
			$partyChildGroups = $this->Payments->PaymentRows->Ledgers->AccountingGroups->find('children', ['for' => $partyParentGroup->id]);
			$partyGroups[]=$partyParentGroup->id;
			foreach($partyChildGroups as $partyChildGroup){
				$partyGroups[]=$partyChildGroup->id;
			}
		}
	//pr($partyGroups->toArray()); exit;
		$partyLedgers = $this->Payments->PaymentRows->Ledgers->find()
		->where(['Ledgers.accounting_group_id IN' =>$partyGroups,'Ledgers.city_id'=>$city_id]);
		
		//$ledgers = $this->Payments->PaymentRows->Ledgers->find()->where(['company_id'=>$company_id]);
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
		
		//$referenceDetails=$this->Payments->PaymentRows->ReferenceDetails->find('list');
		
		$this->set(compact('payment', 'location_id','voucher_no','ledgerOptions', 'referenceDetails','city_id'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Payment id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $payment = $this->Payments->get($id);
        if ($this->Payments->delete($payment)) {
            $this->Flash->success(__('The payment has been deleted.'));
        } else {
            $this->Flash->error(__('The payment could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
