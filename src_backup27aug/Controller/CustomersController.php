<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\View\View;

/**
 * Customers Controller
 *
 * @property \App\Model\Table\CustomersTable $Customers
 *
 * @method \App\Model\Entity\Customer[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CustomersController extends AppController
{

	public function beforeFilter(Event $event)
	{
		parent::beforeFilter($event);
		 $this->Security->setConfig('unlockedActions', ['add','index','edit','delete','view']);
	}

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
	 
/* 	 public function updatealltoken()
	 {
		$customers = $this->Customers->find();
		
		foreach($customers as $customer)
		{
		 	$query = $this->Customers->AppNotificationTokens->query();
			$query->insert(['city_id', 'app_token'])
				->values([
					'city_id' => $customer->city_id,
					'app_token' => $customer->device_token
				])->execute();			
		}		
exit;
	 } */
	 
	 
	 
	 public function rating()
    {
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id');
		$this->viewBuilder()->layout('admin_portal');
        $this->paginate = [
			'limit' => 100
        ];
		$ratings = $this->Customers->ItemReviewRatings->find()->contain(['Items','Customers','Sellers']);
		
		if ($this->request->is(['get'])){
			$search=$this->request->getQuery('search');
			$ratings->where([
							'OR' => [
									'Customers.name LIKE' => $search.'%',
									'Sellers.name LIKE' => $search.'%',
									'Items.name LIKE' => $search.'%',
									'ItemReviewRatings.rating LIKE' => $search.'%',
									'ItemReviewRatings.comment LIKE' => $search.'%',
									'ItemReviewRatings.created_on LIKE' => $search.'%'
							]
			]);
		}
		
		$ratings = $this->paginate($ratings);
		$paginate_limit=$this->paginate['limit'];
        $this->set(compact('ratings','paginate_limit'));
	
	}
    public function index()
    {
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id');
		$user_type=$this->Auth->User('user_type');
		if($user_type=='Super Admin'){
			$this->viewBuilder()->layout('super_admin_layout');
		}else if($user_type=='Admin'){
			$this->viewBuilder()->layout('admin_portal');
		}
        $this->paginate = [
            'contain' => ['Cities'],
			'limit' => 10000
        ];
		
		$customers = $this->Customers->find()->where(['Customers.city_id'=>$city_id]);

		/* if ($this->request->is(['get'])){
			$search=$this->request->getQuery('search');
			$customers->where([
							'OR' => [
									'Customers.name LIKE' => $search.'%',
									'Customers.status LIKE' => $search.'%',
									'Customers.firm_name LIKE' => $search.'%',
									'Customers.email LIKE' => $search.'%',
									'Customers.username LIKE' => $search.'%',
									'Customers.gstin LIKE' => $search.'%',
									'Customers.gstin_holder_name LIKE' => $search.'%'
							]
			]);
		} */
		$customers = $customers;
		$paginate_limit=$this->paginate['limit'];
        $this->set(compact('customers','paginate_limit'));
    }

    /**
     * View method
     *
     * @param string|null $id Customer id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($ids = null)
    {
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id');
		$location_id=$this->Auth->User('location_id');
		$user_type=$this->Auth->User('user_type');
		if($user_type=='Super Admin'){
			$this->viewBuilder()->layout('super_admin_layout');
		}else if($user_type=='Admin'){
			$this->viewBuilder()->layout('admin_portal');
		}
		
		if($ids)
		{
		   $customer_id = $this->EncryptingDecrypting->decryptData($ids);
		}
		 
        $customer = $this->Customers->get($customer_id, [
            'contain' => ['Cities', 'AppNotificationCustomers', 'BulkBookingLeads', 'Carts', 'CustomerAddresses', 'Feedbacks', 'Ledgers', 'Orders', 'ReferenceDetails', 'SaleReturns', 'SalesInvoices', 'SellerRatings', 'Wallets']
        ]);
			
		$this->loadmodel('Wallets');
		$query1 = $this->Wallets->find();
		$totalInCase = $query1->newExpr()
			->addCase(
				$query1->newExpr()->add(['add_amount > ' => 0]),
				$query1->newExpr()->add(['add_amount']),
				'integer'
			); 
		$totalOutCase = $query1->newExpr()
			->addCase(
				$query1->newExpr()->add(['used_amount > ' => 0]),
				$query1->newExpr()->add(['used_amount']),
				'integer'
			);
			$query1->select([
			'total_advanced' => $query1->func()->sum($totalInCase),
			'total_consumed' => $query1->func()->sum($totalOutCase),'id','customer_id'
		])
		->where(['Wallets.customer_id' => $customer_id])
		->autoFields(true);
		$wallets = ($query1);
		foreach($wallets as $wallet){
			
			$total_advanced=$wallet->total_advanced;
			$total_consumed=$wallet->total_consumed;
			$wallet_remaining=$total_advanced-$total_consumed;
		}
		
		$order_count=$this->Customers->Orders->find()->where(['Orders.customer_id'=>$customer_id])->count();
		
		$wallet_advances=$this->Customers->Wallets->find()->where(['Wallets.customer_id'=>$customer_id,'Wallets.transaction_type'=> 'Added'])->contain(['Customers', 'PlansLeft']);
		
		$wallet_consumes=$this->Customers->Wallets->find()->where(['Wallets.customer_id'=>$customer_id,'Wallets.transaction_type'=> 'Deduct'])->contain(['Customers', 'OrdersLeft']);
		
		$Orders=$this->Customers->Orders->find()->where(['Orders.customer_id'=>$customer_id])->contain(['PromotionDetailsLeft']);
		
		$memberships=$this->Customers->CustomerMemberships->find()->where(['CustomerMemberships.customer_id'=>$customer_id])->contain(['Plans']);
		
		$customeraddresses=$this->Customers->CustomerAddresses->find()->where(['CustomerAddresses.customer_id'=>$customer_id])->contain(['Locations']);
		//pr($wallet_consumes->toArray()); exit;
		$this->set(compact('customer', 'wallet_remaining','order_count','wallet_consumes', 'wallet_advances','Orders','memberships','customeraddresses'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
	 
	 
	    public function oldDataMigrate(){
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id');
		$location_id=$this->Auth->User('location_id');
		$OldCustomers = $this->Customers->OldCustomers->find()->contain(['OldCustomer']);
		
		foreach($OldCustomers as $data){
			
			$checkMobNo=$this->Customers->find()->where(['Customers.username'=>$data->mobile])->first();
			
			if(empty($checkMobNo)){
				$Voucher_no = $this->Customers->find()->select(['city_count'])->where(['Customers.city_id'=>$city_id])->order(['city_count' => 'DESC'])->first();
				if($Voucher_no){$voucher_no=$Voucher_no->city_count+1;}
				else{$voucher_no=1;}
				$customer = $this->Customers->newEntity();
				$customer->name=$data->name;
				$customer->customer_no='JNTUDR'.$voucher_no;
				$customer->city_count=$voucher_no;
				$customer->city_id=$city_id;
				$customer->email=$data->email;
				$customer->username=$data->mobile;
				$ps='123456';
				$customer->password=$ps;
				$customer->status='Active';
				$customer->membership_discount_status='Deactive';
				$customer->is_shipping_price='No'; 
				$customerData=$this->Customers->save($customer);
				
				$random=(string)mt_rand(10000,99999);
				$set_name="JAIN";
				$cus_id=$customerData->id;
				$referral_code=$set_name.$random.$cus_id;
				
				$query1 = $this->Customers->query();
				$query1->update()
						->set(['referral_code' => $referral_code])
						->where(['Customers.id'=>$cus_id])
						->execute();
				
				$CustomerAddresses = $this->Customers->CustomerAddresses->newEntity();
				$CustomerAddresses->customer_id=@$customerData->id;
				$CustomerAddresses->receiver_name=@$data->old_customer[0]->name;
				$CustomerAddresses->mobile_no=@$data->old_customer[0]->mobile;
				$CustomerAddresses->address=@$data->old_customer[0]->address;
				$CustomerAddresses->city_id=@$city_id;
				$CustomerAddresses->location_id=1;
				$CustomerAddresses->landmark_id=1;
				$CustomerAddresses->pincode=313201;
				$CustomerAddresses->latitude=24.5838222;
				$CustomerAddresses->longitude=73.6973346;
				$CustomerAddresses->default_address=1;
				$customerAddress=$this->Customers->CustomerAddresses->save($CustomerAddresses);
				
				$accounting_group = $this->Customers->Ledgers->AccountingGroups->find()->where(['AccountingGroups.customer'=>1,'AccountingGroups.city_id'=>$city_id])->first();
				$ledger = $this->Customers->Ledgers->newEntity();
				$ledger->name = $data->name;
				$ledger->city_id = $city_id;
				//$ledger->default_credit_days = $customer->default_credit_days;
				$ledger->accounting_group_id = $accounting_group->id;
				$ledger->customer_id=@$customerData->id;
				$ledger->bill_to_bill_accounting="No";
				$this->Customers->Ledgers->save($ledger);
			}
			
		}
		exit;
	}
    public function add()
    {
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id');
		$location_id=$this->Auth->User('location_id');
		$user_type=$this->Auth->User('user_type');
		if($user_type=='Super Admin'){
			$this->viewBuilder()->layout('super_admin_layout');
		}else if($user_type=='Admin'){
			$this->viewBuilder()->layout('admin_portal');
		}
		
        $customer = $this->Customers->newEntity();
        if ($this->request->is('post')) {
            $customer = $this->Customers->patchEntity($customer, $this->request->getData());
			$customer->city_id=$city_id;
			$customer->created_by=$user_id;
			$data=$this->Customers->Cities->get($city_id);
			$city_name=strtoupper($data->alise_name);
			$city_count_olds=$this->Customers->find()->select(['city_count'])->where(['city_id'=>$city_id])->order(['city_count'=>'DESC'])->limit(1)->first();
			
			@$city_count_old=$city_count_olds->city_count;
			$new_city_count=$city_count_old+1;
			$customer_no='JNT'.$city_name.$new_city_count;
			$customer->customer_no=$customer_no;
			$customer->city_count=$new_city_count;
			$customer->start_date = date('Y-m-d',strtotime($customer->start_date));
			$customer->end_date = date('Y-m-d',strtotime($customer->end_date));
				
			$reference_details=[];
			if(@$this->request->getData()['reference_details']){
				$reference_details=$this->request->getData()['reference_details'];
			}
			//pr($customer->default_credit_days); exit;
            if ($cus_data=$this->Customers->save($customer)) {
				$random=(string)mt_rand(10000,99999);
				$set_name="JAIN";
				$cus_id=$cus_data->id;
				$referral_code=$set_name.$random.$cus_id;
				 
				$query = $this->Customers->query();
				$query->update()
						->set(['referral_code' => $referral_code])
						->where(['Customers.id'=>$cus_id])
						->execute();	
				//if(!empty($customer->gstin)){
				$accounting_group = $this->Customers->Ledgers->AccountingGroups->find()->where(['AccountingGroups.customer'=>1,'AccountingGroups.city_id'=>$city_id])->first();
				$ledger = $this->Customers->Ledgers->newEntity();
				$ledger->name = $customer->name;
				$ledger->city_id = $city_id;
				$ledger->default_credit_days = $customer->default_credit_days;
				$ledger->accounting_group_id = $accounting_group->id;
				$ledger->customer_id=$customer->id;
				$ledger->bill_to_bill_accounting=$customer->bill_to_bill_accounting;
				//pr($ledger); exit;
				if($this->Customers->Ledgers->save($ledger))
				{ 
					//Create Accounting Entry//
					$transaction_date=$data->books_beginning_from;
					$AccountingEntry = $this->Customers->Ledgers->AccountingEntries->newEntity();
					$AccountingEntry->ledger_id        = $ledger->id;
					if($customer->debit_credit=="Dr")
					{
						$AccountingEntry->debit        = $customer->opening_balance_value;
					}
					if($customer->debit_credit=="Cr")
					{
						$AccountingEntry->credit       = $customer->opening_balance_value;
					}
					$AccountingEntry->transaction_date = date("Y-m-d",strtotime($transaction_date));
					//$AccountingEntry->location_id       = $location_id;
					$AccountingEntry->city_id       = $city_id;
					$AccountingEntry->is_opening_balance = 'yes';
					if($customer->opening_balance_value > 0){
						$this->Customers->Ledgers->AccountingEntries->save($AccountingEntry);
						//Refrence Entry//
						if($reference_details){
							foreach($reference_details as $reference_detail){
								$ReferenceDetail = $this->Customers->ReferenceDetails->newEntity();
								$ReferenceDetail->ref_name        = $reference_detail['ref_name'];
								$ReferenceDetail->customer_id        = $customer->id;
								$ReferenceDetail->city_id        = $city_id;
								$ReferenceDetail->opening_balance        = "Yes";
								$ReferenceDetail->ledger_id        = $ledger->id;
								if($reference_detail['debit'] > 0)
								{
									$ReferenceDetail->debit        = $reference_detail['debit'];
								}
								else
								{
									$ReferenceDetail->credit       = $reference_detail['credit'];
								}
								$ReferenceDetail->transaction_date = date("Y-m-d",strtotime($data->books_beginning_from));
								$ReferenceDetail = $this->Customers->ReferenceDetails->save($ReferenceDetail);
							}
						}
					}
				}
			
				$this->Flash->success(__('The customer has been saved.'));
				return $this->redirect(['action' => 'index']);
            }
			  
            $this->Flash->error(__('The customer could not be saved. Please, try again.'));
        }
		$this->loadmodel('Locations');
		$locations=$this->Locations->find('list')->where(['Locations.city_id'=>$city_id,'Locations.Status'=>'Active']);
		$Landmarks=$this->Customers->Landmarks->find('list')->where(['Landmarks.city_id'=>$city_id,'Landmarks.Status'=>'Active']);
		$this->set(compact('customer', 'city_id','location_id','locations','Landmarks'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Customer id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($ids = null)
    {
		if($ids)
		{
		   $id = $this->EncryptingDecrypting->decryptData($ids);
		}
		
  		$user_id=$this->Auth->User('id');
  		$city_id=$this->Auth->User('city_id');
  		$location_id=$this->Auth->User('location_id');
  		$user_type=$this->Auth->User('user_type');
		if($user_type=='Super Admin'){
			$this->viewBuilder()->layout('super_admin_layout');
		}else if($user_type=='Admin'){
			$this->viewBuilder()->layout('admin_portal');
		}
		
        $customer = $this->Customers->get($id, [
            'contain' => ['CustomerAddresses']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {

            $customer = $this->Customers->patchEntity($customer, $this->request->getData());
			$customer->edited_by = $user_id;
			$customer->start_date = date('Y-m-d',strtotime($customer->start_date));
			$customer->end_date = date('Y-m-d',strtotime($customer->end_date));
			
			//pr($customer); exit;
					 
            if ($this->Customers->save($customer)) {
				
				$query = $this->Customers->Ledgers->query();
				$query->update()
						->set(['name' => $customer->name, 'default_credit_days' => $customer->default_credit_days])
						->where(['Ledgers.customer_id'=>$id])
						->execute();
							
                $this->Flash->success(__('The customer has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The customer could not be saved. Please, try again.'));
        }
		$locations=$this->Customers->Locations->find('list')->where(['Locations.city_id'=>$city_id,'Locations.Status'=>'Active']);
		$Landmarks=$this->Customers->Landmarks->find('list')->where(['Landmarks.city_id'=>$city_id,'Landmarks.Status'=>'Active']);
        $this->set(compact('customer', 'city_id','location_id','Landmarks','locations'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Customer id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($dir)
    {
        $this->request->allowMethod(['patch', 'post', 'put']);
		$id = $this->EncryptingDecrypting->decryptData($dir);
        $customer = $this->Customers->get($id);
		$customer->status='Deactive';
        if ($this->Customers->save($customer)) {
            $this->Flash->success(__('The customer has been deleted.'));
        } else {
            $this->Flash->error(__('The customer could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
