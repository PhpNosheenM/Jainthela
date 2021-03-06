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
		 $this->Security->setConfig('unlockedActions', ['add','index','view','edit']);
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
		$financial_year_id=$this->Auth->User('financial_year_id');
		$location_id=$this->Auth->User('location_id');
		$user_id=$this->Auth->User('id');
		$this->viewBuilder()->layout('super_admin_layout');
        $payment = $this->Payments->newEntity();
		
		if ($this->request->is('post')) {
		
			//$this->request->data['transaction_date'] = date("Y-m-d",strtotime($this->request->getData()['transaction_date']));
			$Voucher = $this->Payments->find()->select(['voucher_no'])->where(['city_id'=>$city_id,'financial_year_id'=>$financial_year_id])->order(['voucher_no' => 'DESC'])->first();
			if($Voucher)
			{
				$payment->voucher_no = $Voucher->voucher_no+1;
			}
			else
			{
				$payment->voucher_no = 1;
			}
			//$payment->location_id = $location_id;
			
			
			$payment = $this->Payments->patchEntity($payment, $this->request->getData(), [
							'associated' => ['PaymentRows']
						]);
						
			$payment->city_id = $city_id;
			$payment->financial_year_id = $financial_year_id;
			$payment->created_by = $user_id;
			$traans_date= date('Y-m-d', strtotime($this->request->data['transaction_date']));			
			$payment->transaction_date=$traans_date; 
			
			//transaction date for payment code start here--
			/* foreach($payment->payment_rows as $payment_row)
			{
				if(!empty($payment_row->reference_details))
				{
					foreach($payment_row->reference_details as $reference_detail)
					{
						$reference_detail->transaction_date = date('Y-m-d', strtotime($payment->transaction_date));
						$reference_detail->city_id = $city_id;
					}
				}
			} */
			//transaction date for payment code close here-- 
			
			if ($this->Payments->save($payment)) {
				
				foreach($payment->payment_rows as $payment_row)
			{
				if(!empty($payment_row->reference_details))
				{
					foreach($payment_row->reference_details as $reference_detail1)
					{
						$reference_detail = $this->Payments->ReferenceDetails->newEntity();
						$reference_detail->transaction_date = $traans_date;
						$reference_detail->payment_id =  $payment_row->payment_id;
						$reference_detail->payment_row_id =  $payment_row->id;
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
		$Voucher = $this->Payments->find()->select(['voucher_no'])->where(['city_id'=>$city_id,'financial_year_id'=>$financial_year_id])->order(['voucher_no' => 'DESC'])->first();
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
        $payment = $this->Payments->get($id, [
            'contain' => ['PaymentRows'=>['ReferenceDetails']]
        ]);
		
        if ($this->request->is(['patch', 'post', 'put'])) {
			$payment = $this->Payments->patchEntity($payment, $this->request->getData(), [
							'associated' => ['PaymentRows']
						]);
			 
			//$payment->location_id = $location_id;
			$payment->city_id = $city_id;
			$payment->created_by = $user_id;
			$traans_date= date('Y-m-d', strtotime($this->request->data['transaction_date']));
			$payment->transaction_date =$traans_date;
			
			//transaction date for payment code start here--
			/* foreach($payment->payment_rows as $payment_row)
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
			 */
			 
            if ($this->Payments->save($payment))
			/* if ($this->Payments->save($payment, [
							'associated' => ['PaymentRows','PaymentRows.ReferenceDetails']
						])) */
				{
			$this->Payments->ReferenceDetails->deleteAll(['ReferenceDetails.payment_id'=>$id]);
			
			$this->Payments->AccountingEntries->deleteAll(['AccountingEntries.payment_id'=>$id]);
			
			foreach($payment->payment_rows as $payment_row)
			{
				if(!empty($payment_row->reference_details))
				{
					foreach($payment_row->reference_details as $reference_detail1)
					{
						$reference_detail = $this->Payments->ReferenceDetails->newEntity();
						$reference_detail->transaction_date = $traans_date;
						$reference_detail->location_id = 0;
						$reference_detail->payment_id =  $payment_row->payment_id;
						$reference_detail->payment_row_id =  $payment_row->id;
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
		
		$refDropDown =[];
		foreach($payment->payment_rows as $payment_row)
		{
			if(!empty($payment_row->reference_details))
			{
				foreach($payment_row->reference_details as $referenceDetailRows)
				{
					@$ref_details_name[]=$referenceDetailRows->ref_name;
				}
				$query = $this->Payments->PaymentRows->ReferenceDetails->find();
				$query->select(['total_debit' => $query->func()->sum('ReferenceDetails.debit'),'total_credit' => $query->func()->sum('ReferenceDetails.credit')])
				->where(['ReferenceDetails.ledger_id'=>$payment_row->ledger_id,'ReferenceDetails.type !='=>'On Account'])
				->group(['ReferenceDetails.ref_name'])
				->autoFields(true);
				$referenceDetails=$query;
				$option=[];
				foreach($referenceDetails as $referenceDetail){
					$remider=$referenceDetail->total_debit-$referenceDetail->total_credit;
					if($remider>0){
						$bal=abs($remider).' Dr';
					}else if($remider<0){
						$bal=abs($remider).' Cr';
					}
					if($referenceDetail->total_debit!=$referenceDetail->total_credit  || in_array($referenceDetail->ref_name,$ref_details_name)){
						$option[] =['text' =>$referenceDetail->ref_name.' ('.$bal.')', 'value' => $referenceDetail->ref_name];
					}
				}
				$refDropDown[$payment_row->id] = $option;
			}
		}
		//pr($option); exit;
		
		//$referenceDetails=$this->Payments->PaymentRows->ReferenceDetails->find('list');
		
		$this->set(compact('payment', 'location_id','voucher_no','ledgerOptions', 'referenceDetails','city_id','refDropDown'));
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
