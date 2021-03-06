<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Routing\Router;
use Cake\Mailer\Email;
use Cake\Event\Event;
use Cake\View\View;
/**
 * Sellers Controller
 *
 * @property \App\Model\Table\SellersTable $Sellers
 *
 * @method \App\Model\Entity\Seller[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SellersController extends AppController
{

	 public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Security->setConfig('unlockedActions', ['add','edit','index','forgotPassword', 'resetPassword','dashboard']);

    }
	
	public function initialize()
	{
		parent::initialize();
		 $this->Auth->allow(['logout', 'login']);		
	}
	
	public function forgotPassword()
    {
		$this->viewBuilder()->layout('admin_login');
        if ($this->request->is('post')) {
			
            $query = $this->Sellers->findByFirmEmail($this->request->data['firm_email']);
            $user = $query->first();
			
            if (is_null($user)) {
                $this->Flash->error('Email address does not exist. Please try again');
            } else {
			
                $passkey = uniqid();
                //$url = $this->Url->build(['controller' => 'Sellers', 'action' => 'reset_password'], true) . '/' . $passkey;
				//$url =$this->Html->link(['controller'=>'Sellers','action' => 'reset_password/'.$passkey],['target'=>'_blank']);
				 $url = Router::Url(['controller' => 'Sellers', 'action' => 'reset_password'], true) . '/' . $passkey;
                $timeout = time() + DAY;
                 if ($this->Sellers->updateAll(['passkey' => $passkey, 'timeout' => $timeout], ['id' => $user->id])){
					
                    $this->sendResetEmail($url, $user);
					
                    $this->redirect(['action' => 'login']);
                } else {
                    $this->Flash->error('Error saving reset passkey/timeout');
                }
            }
        }
    }
	
	 public function resetPassword($passkey = null) {
		$this->viewBuilder()->layout('admin_login');
        if ($passkey) {
            $query = $this->Sellers->find('all')->where(['passkey' => $passkey, 'timeout >' => time()]);
            $user = $query->first();
			
			
            if ($user) {
                if (!empty($this->request->data)) {
                    // Clear passkey and timeout
                    $this->request->data['passkey'] = null;
                    $this->request->data['timeout'] = null;
                    $user = $this->Sellers->patchEntity($user, $this->request->data);
                    if ($this->Sellers->save($user)) {
                        $this->Flash->success(__('Your password has been updated.'));
                        $this->Auth->setUser($user);
						return $this->redirect(['controller'=>'Sellers','action' => 'index']);
						
                    } else {
                        $this->Flash->error(__('The password could not be updated right now. Please, try again.'));
                    }
                }
            } else {
                $this->Flash->error('Invalid or expired passkey. Please check your email or try again');
                $this->redirect(['action' => 'forgot_password']);
            }
            unset($user->password);
            $this->set(compact('user'));
        } else {
            $this->redirect('/');
        }
    }
	
	
	private function sendResetEmail($url, $user) {
		
		/*
			$email = new Email();
			$email->profile('default')
			->template('resetpw')
			->emailFormat('html');

			$email->from(['hello@entryhires.com' => 'Entry Hires'])
			->to($user->email, $user->full_name)
			->subject('Entry Hires - Reset your password')
			->viewVars(['url' => $url, 'email' => $user->email]);
		*/
		//-- Send Grid By Dsu Menaria
		$email = new Email();
		$email->transport('SendGrid');
		$sub="Password reset instructions for jainthela Sellers account";
		$from_name="JAINTHELA";
 		$email_to=$user->firm_email;
		if(!empty($email_to)){
		try {
			$email->from(['hello@entryhires.com' => $from_name])
				->to($email_to, $user->name)
				->subject($sub)
				->profile('default')
				->template('resetpw')
				->emailFormat('html')
				->viewVars(['url' => $url, 'email' => $user->firm_email,'user_name'=>$user->username]);
 			} catch (Exception $e) {
				
				echo 'Exception : ',  $e->getMessage(), "\n";

			} 
		}
		//-- End Of Send Grid
		if ($email->send()) {
		  
            $this->Flash->success(__('Check your email for your reset password link'));
        } else {
            $this->Flash->error(__('Error sending email: ') . $email->smtpError);
        }  
    }
	
	
	public function login()
    {
		$this->viewBuilder()->layout('seller_login');
        if ($this->request->is('post')) 
		{
			$user = $this->Auth->identify();
			if ($user) 
			{
				//$city = $this->Sellers->Locations->get($user['location_id']);
				//$user['city_id']=$city->id;
				$user['user_type']='Seller';
				$characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
				$charactersLength = strlen($characters);
				$randomString = '';
				$randomStrings = '';
				$length = 2;
				for ($i = 0; $i < $length; $i++) {
					$randomString .= $characters[rand(0, $charactersLength - 1)];
				}
				for ($i = 0; $i < $length; $i++) {
					$randomStrings .= $characters[rand(0, $charactersLength - 1)];
				}
				$user['pass_key']='wt1U5MA'.$randomString.'JFTXGenFoZoiLwQGrLgdb'.$randomString;
				
				$this->Auth->setUser($user);
				return $this->redirect(['controller'=>'Sellers','action' => 'index']);
            }
            $this->Flash->error(__('Invalid Username or Password'));
        }	
    }
	
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    { 
		$this->Flash->success(__('The seller has been saved.'));
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id'); 
		$location_id=$this->Auth->User('location_id'); 
		$user_type=$this->Auth->User('user_type'); 
		if($user_type=="Super Admin"){
		$this->viewBuilder()->layout('super_admin_layout');
		}else{
		$this->viewBuilder()->layout('seller_layout');
		}
        $this->paginate = [
			'limit' => 100
        ];
        $sellers = $this->Sellers->find()->where(['Sellers.city_id'=>$city_id,'id'=>$user_id]);
		if ($this->request->is(['get'])){
			$search=$this->request->getQuery('search');
			$sellers->where([
							'OR' => [
									'Sellers.name LIKE' => $search.'%',
									'Sellers.status LIKE' => $search.'%',
									'Sellers.firm_name LIKE' => $search.'%',
									'Sellers.firm_address LIKE' => $search.'%',
									'Sellers.firm_email LIKE' => $search.'%',
									'Sellers.firm_contact LIKE' => $search.'%',
									'Sellers.firm_pincode LIKE' => $search.'%',
									'Sellers.gstin LIKE' => $search.'%',
									'Sellers.gstin_holder_name LIKE' => $search.'%',
									'Sellers.registration_date' => $search.'%'
							]
			]);
		}
		$sellers= $this->paginate($sellers);
		$paginate_limit=$this->paginate['limit'];
        $this->set(compact('sellers','paginate_limit'));
    }
     /**
     * View method
     *
     * @param string|null $id Seller id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $seller = $this->Sellers->get($id, [
            'contain' => ['Cities', 'Categories', 'Ledgers', 'Locations', 'Items', 'SellerItems', 'SellerRatings', 'ReferenceDetails']
        ]);

        $this->set('seller', $seller);
    }
	
	
	public function dashboard($id = null)
    {
        $user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id'); 
		$user_type=$this->Auth->User('user_type'); 
		if($user_type=="Super Admin"){
		$this->viewBuilder()->layout('super_admin_layout');
		}else{
		$this->viewBuilder()->layout('seller_layout');
		}
		
		$this->loadmodel('Locations');
		$locations=$this->Locations->find()->where(['Locations.city_id'=>$city_id,'Locations.status'=>'Active']);
		
		$this->loadmodel('Orders');
		/* $orders=$this->Orders->find()->where(['Orders.city_id'=>$city_id,'Orders.order_status'=>'placed'])->contain(['OrderDetails'=>['ItemVariations']]);
		 */
		//pr($orders->toArray()); exit;
		/* 
		 $orders=$this->Orders->find()
		 ->contain(['OrderDetails'=> function($q) use($q){
			return $q->select(['item_variation_id','count'=>$orders->func()->count('item_variation_id')])
			->group('item_variation_id')
		}])->where(['Orders.city_id'=>$city_id,'Orders.order_status'=>'placed']);  */
		
		$orders=$this->Orders->find()->where(['Orders.city_id'=>$city_id,'Orders.order_status'=>'placed'])
			->contain(['OrderDetails'=> function ($q)  use($user_id) {
				return $q->select(['item_variation_id','order_id','total_qty'=>$this->Orders->OrderDetails->find()->func()->sum('OrderDetails.quantity')])->contain(['ItemVariations'=> function ($q)  use($user_id){
								return $q 
								->where(['ItemVariations.seller_id '=>$user_id])->contain(['Items','SellersData','UnitVariations'=>['Units']]);
								}])->group('OrderDetails.item_variation_id')->autoFields(true);
			}])
			->autoFields(true);

		//pr($orders->toArray()); exit; 
		 
		/*

		 $orders=$this->Orders->find()
		 ->contain(['OrderDetails'=> function() use($q){
			return $q->select('item_variation_id','count'=>$orders->func()->count('item_variation_id'))
			->group('item_variation_id');	
			->contain['ItemVariations'=>function ($q) use($user_id) {
				return $q->where(['ItemVariations.seller_id'=>$user_id])->contain(['Sellers','Items','UnitVariations']);
			}] 
		 }])->where(['Orders.city_id'=>$city_id,'Orders.order_status'=>'placed']); 

		 
		 

		$query = $this->Orders->OrderDetails->find()->where(['Orders.city_id'=>$city_id,'Orders.order_status'=>'placed']); 
			$query
				->select(['sum' => $query->func()->sum('OrderDetails.quantity')])
				->group(['item_variation_id'])
				->toArray(); */
			 
			//pr($orders->toArray()); exit;		
        $this->set(compact('locations','paginate_limit','orders'));
    }
	

	 public function changePassword()
	{
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id');
		$this->viewBuilder()->layout('seller_layout');
		$seller = $this->Sellers->get($user_id);
		 
			if ($this->request->is(['post','put'])) {		
				$seller = $this->Sellers->patchEntity($seller, [
						'old_password'  => $this->request->data['old_password'],
						'password'      => $this->request->data['password'],
						'confirm_password' => $this->request->data['confirm_password']
					],
					['validate' => 'password']);
			 
				if ($this->Sellers->save($seller)) {
					
					 $this->Flash->success(__('The seller Password has been saved.'));
					 return $this->redirect(['action' => 'index']);
				}
				$this->Flash->error(__('The Password could not be change. Please, try again.'));
				 
			}
		
		$this->set(compact('seller', 'cities', 'roles','Sellers','paginate_limit'));
	}
	
    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id'); 
		$location_id=$this->Auth->User('location_id'); 
		$user_type=$this->Auth->User('user_type'); 
		if($user_type=="Super Admin"){
		$this->viewBuilder()->layout('super_admin_layout');
		}else{
		$this->viewBuilder()->layout('seller_layout');
		}
        $seller = $this->Sellers->newEntity();
        if ($this->request->is('post')) {
			//pr($this->request->getData()); exit;
            $seller = $this->Sellers->patchEntity($seller, $this->request->getData());
			$seller->city_id=$city_id;
			$seller->created_by=$user_id;
			$registration_date=$this->request->data['registration_date'];
			$seller->registration_date=date('Y-m-d', strtotime($registration_date));
			$bill_to_bill_accounting=$seller->bill_to_bill_accounting;
			$data=$this->Sellers->Cities->get($city_id);
			$d_password= md5($seller->drivers[0]['password']);
			$seller->drivers[0]['password']=$d_password;
			//pr($seller); exit;
			$reference_details=$this->request->getData()['reference_details']; 
			 if ($this->Sellers->save($seller)) {
				pr($seller); exit;
				$accounting_group = $this->Sellers->Ledgers->AccountingGroups->find()->where(['AccountingGroups.seller'=>1,'AccountingGroups.city_id'=>$city_id])->first();
				$ledger = $this->Sellers->Ledgers->newEntity();
				$ledger->name = $seller->firm_name;
				$ledger->accounting_group_id = $accounting_group->id;
				$ledger->seller_id=$seller->id;
				$ledger->city_id=$city_id;
				$ledger->bill_to_bill_accounting=$bill_to_bill_accounting;
				
				if($this->Sellers->Ledgers->save($ledger))
				{
					
					//Create Accounting Entry//
			        $transaction_date=$data->books_beginning_from;
					$AccountingEntry = $this->Sellers->Ledgers->AccountingEntries->newEntity();
					$AccountingEntry->ledger_id        = $ledger->id;
					if($seller->debit_credit=="Dr")
					{
						$AccountingEntry->debit        = $seller->opening_balance_value;
					}
					if($seller->debit_credit=="Cr")
					{
						$AccountingEntry->credit       = $seller->opening_balance_value;
					}
					$AccountingEntry->transaction_date = date("Y-m-d",strtotime($transaction_date));
					//$AccountingEntry->location_id       = $location_id;
					$AccountingEntry->city_id       = $city_id;
					$AccountingEntry->is_opening_balance = 'yes';
					if($seller->opening_balance_value){
					$this->Sellers->Ledgers->AccountingEntries->save($AccountingEntry);

					//Refrence Entry//
					if($reference_details){
					foreach($reference_details as $reference_detail){
							$ReferenceDetail = $this->Sellers->ReferenceDetails->newEntity();
							$ReferenceDetail->ref_name        = $reference_detail['ref_name'];
							$ReferenceDetail->seller_id        = $seller->id;
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
							$ReferenceDetail = $this->Sellers->ReferenceDetails->save($ReferenceDetail);
							}
						}
					}
				} 
                $this->Flash->success(__('The seller has been saved.'));

                return $this->redirect(['action' => 'add']);
            }else{ pr($seller); exit;
            $this->Flash->error(__('The seller could not be saved. Please, try again.'));
			}
        }
		//$categories = $this->Sellers->Categories->find('threaded')->contain(['Items']);
		
		$locations = $this->Sellers->Locations->find('list');
        
        $this->set(compact('seller','locations'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Seller id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id'); 
		$this->viewBuilder()->layout('super_admin_layout');
        $seller = $this->Sellers->get($id, [
            'contain' => ['SellerDetails']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $seller = $this->Sellers->patchEntity($seller, $this->request->getData());
			$seller->city_id=$city_id;
			$seller->created_by=$user_id;
			$registration_date=$this->request->data['registration_date'];
			$seller->registration_date=date('Y-m-d', strtotime($registration_date));
            if ($this->Sellers->save($seller)) {
                $this->Flash->success(__('The seller has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The seller could not be saved. Please, try again.'));
        }
     
        $this->set(compact('seller'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Seller id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
   public function sellerItem($id = null)
    {
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id'); 
		$this->viewBuilder()->layout('super_admin_layout');
		//$id=6;
		$seller = $this->Sellers->get($id);
		$Categories = $this->Sellers->Categories->find()->where(['city_id'=>$city_id,'parent_id IS NULL']);
		
		if ($this->request->is(['patch', 'post', 'put'])) {
			$seller = $this->Sellers->patchEntity($seller, $this->request->getData());
			foreach($seller->seller_items as $seller_item){
				if($seller_item->check==1){
					$SellerItem = $this->Sellers->SellerItems->newEntity();
					$SellerItem->category_id = $seller_item->category_id;
					$SellerItem->commission_percentage = $seller_item->commission_percentage;
					$SellerItem->seller_id = $id;
					$SellerItem->created_by = $user_id;
					$SellerItem->created_on = date("Y-m-d");
					$SellerItem->commission_created_on = date("Y-m-d");
					$SellerItem->status ="Active";
					$this->Sellers->SellerItems->save($SellerItem);
					//pr($SellerItem); exit;
				}
			} // exit;
			$this->Flash->success(__('The seller has been saved.'));
			return $this->redirect(['action' => 'sellerItem']);
            
          
			//
		}
		
		
		$childrens = $this->Sellers->Categories
			 ->find('threaded')
			->toArray();
		//pr($children); exit;
		$this->set(compact('seller','Categories','childrens'));
		//exit;
	}

    /**
     * Delete method
     *
     * @param string|null $id Seller id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
		$this->request->allowMethod(['patch', 'post', 'put']);
        $seller = $this->Sellers->get($id);
		$seller->status='Deactive';
        if ($this->Sellers->save($seller)) {
			
            $this->Flash->success(__('The seller has been deleted.'));
        } else {
            $this->Flash->error(__('The seller could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
