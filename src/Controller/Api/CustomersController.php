<?php
namespace App\Controller\Api;
use Cake\Event\Event;
use Cake\Network\Exception\UnauthorizedException;
use Cake\Utility\Security;
use Firebase\JWT\JWT;
/**
 * Customers Controller
 *
 * @property \App\Model\Table\CustomersTable $Customers
 *
 * @method \App\Model\Entity\Customer[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CustomersController extends AppController
{
  public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['add', 'login','send_otp','verify']);
    }

	public function my_account(){

		$customer_id=@$this->request->query['customer_id'];
		$city_id=@$this->request->query['city_id'];
		$token=@$this->request->query['token'];
		$profiles=[];$wallet_balance=number_format(0, 2);
		if(!empty($customer_id) and !empty($token) and !empty($city_id)){


			$isValidToken = $this->checkToken($token);
            if($isValidToken == 0){

			$isValidCity = $this->CheckAvabiltyOfCity($city_id);
			if($isValidCity == 0){



			$profiles=$this->Customers->get($customer_id);

				if($profiles){

					 $query = $this->Customers->Wallets->find();
                  		$totalInCase = $query->newExpr()
                  			->addCase(
                  				$query->newExpr()->add(['transaction_type' => 'Added']),
                  				$query->newExpr()->add(['add_amount']),
                  				'integer'
                  			);
                    	$totalOutCase = $query->newExpr()
                    			->addCase(
                    				$query->newExpr()->add(['transaction_type' => 'Deduct']),
                    				$query->newExpr()->add(['used_amount']),
                    				'integer'
                    			);
                  			$query->select([
                  			'total_in' => $query->func()->sum($totalInCase),
                  			'total_out' => $query->func()->sum($totalOutCase),'id','customer_id'
                  		])
                		->where(['Wallets.customer_id' => $customer_id])
                		->group('customer_id')
                		->autoFields(true);

					  foreach($query as $fetch_query)
                		    {
                      			$advance=$fetch_query->total_in;
                      			$consumed=$fetch_query->total_out;
                      		  $wallet_balance= number_format($advance-$consumed, 2);
                		    }


					$success = true;
					$message = 'Data Found successfully';



				}else{

					$success = false;
					$message = 'No Data Found';
				}
			}else{
				$success = false;
				$message = 'Invalid City';

			}
			}else{
				$success = false;
				$message = 'Invalid Token';

			}
		}else{

			 $success = false;
			 $message = 'customer id or token or city id is not empty';

		}

		$this->set(['success' => $success,'message'=>$message,'wallet_balance'=>$wallet_balance,'profiles'=>$profiles,'_serialize' => ['success','message','wallet_balance','profiles']]);
	}

	public function send_otp(){

		$mobile=@$this->request->query['mobile'];

		if(!empty($mobile)){
			$exists_mobile = $this->Customers->exists(['Customers.username'=>$mobile]);
			$opt=0;
			if($exists_mobile==0){
				$VerifyOtps = $this->Customers->VerifyOtps->newEntity();
				$VerifyOtps->mobile=$mobile;
				$VerifyOtps->status=0;
				$opt=(mt_rand(1111,9999));
				$VerifyOtps->otp=$opt;
				if($this->Customers->VerifyOtps->save($VerifyOtps)){
					  $content="Your one time password for jainthela is ".$opt;
					  $this->Sms->sendSms($mobile,$content);
					 $success = true;

					$message = 'send otp successfully';
				}else{
					$success = false;
					$message = 'otp is not send';

				}
			}else{
					$success = false;
					$message = 'mobile already taken';

				}

		}else{

			$success = false;
		    $message = 'empty mobile no';
		}
		$this->set(['success' => $success,'otp'=>$opt,'message'=>$message,'_serialize' => ['success','otp','message']]);

	}

	public function verify(){
		$customer = $this->Customers->newEntity();
		if($this->request->is(['patch', 'post', 'put'])){

/* 			foreach(getallheaders() as $key => $value) {
				if($key == 'Authorization')
				{
					 $token = $value;
				}
			}
			$token = str_replace("Bearer ","",$token);
			$isValidToken = $this->checkToken($token); */
			$mobile=$this->request->data['mobile'];
			$otp=$this->request->data['otp'];

				 if(!empty($mobile) and (!empty($otp))){
						$VerifyOtps=$this->Customers->VerifyOtps->find()->where(['mobile'=>$mobile,'otp'=>$otp]);
						if($VerifyOtps->toArray()){

							/* 	$query = $this->Customers->query();
							$result = $query->update()->set(['status' => 'Active'])->where(['id' => $id])->execute();
							$Customers=$this->Customers->find()->where(['id'=>$id,'otp'=>$otp]);
							foreach ($Customers as $Customer) {
							$accounting_group = $this->Customers->Ledgers->AccountingGroups->find()->where(['customer'=>1])->first();
							$ledger = $this->Customers->Ledgers->newEntity();
							$ledger->name = $Customer->name;
							$ledger->accounting_group_id = $accounting_group->id;
							$ledger->customer_id=$Customer->id;
							$ledger->bill_to_bill_accounting='yes';
							$this->Customers->Ledgers->save($ledger);
							}
							*/
							$success = true;
							$message = 'verify Successfully';
						}else{

							$success = false;
							$message = 'Not Verify';
						}
				 }else{
					  $success = false;
					  $message = 'mobile or Otp empty';
				 }

		}
		$this->set(['success' => $success,'message'=>$message,'_serialize' => ['success','message']]);
	}

	public function add()
	{
		/* $this->Crud->on('afterSave', function(Event $event) {
			if ($event->subject->created) {
				$this->set('data', [
					'id' => $event->subject->entity->id,
					'token' => JWT::encode(
						[
							'sub' => $event->subject->entity->id,
							'exp' =>  time() + 604800
						],
					Security::salt())
				]);
				$this->Crud->action()->config('serialize.data', 'data');
			}
		});
		return $this->Crud->execute(); */

		//pr($this->request->data['email']);
	//	echo $exists_email = $this->Customers->exists(['Customers.email'=>$this->request->data['email']]); exit;
	 $customer = $this->Customers->newEntity();
		if($this->request->is(['patch', 'post', 'put'])){

				$exists_email = $this->Customers->exists(['Customers.email'=>$this->request->data['email']]);
				 $exists_mobile = $this->Customers->exists(['Customers.username'=>$this->request->data['username']]);


				if(($exists_email==0) and ($exists_mobile==0)){

					$mobile=$this->request->data['username'];

					$this->request->data['status']='Active';
					$customer = $this->Customers->patchEntity($customer, $this->request->getData());

					 if ($customers=$this->Customers->save($customer)) {


							$arr = JWT::encode(['sub' => $customers->id,'exp' =>  time() + 604800],Security::salt());
							$query = $this->Customers->query();
							$result = $query->update()->set(['token' => $arr])->where(['id' => $customers->id])->execute();
						    $customer_data = $this->Customers->get($customers->id);

							$accounting_group = $this->Customers->Ledgers->AccountingGroups->find()->where(['customer'=>1])->first();
							$ledger = $this->Customers->Ledgers->newEntity();
							$ledger->name = $customer_data->name;
							$ledger->accounting_group_id = $accounting_group->id;
							$ledger->customer_id=$customer_data->id;
							$ledger->bill_to_bill_accounting='yes';
							$this->Customers->Ledgers->save($ledger);

						$success=true;
						$message="data has been saved successfully";
						$data=$customer_data;
					 }else{
						 $data=[];
						 $success=false;
						 $message="data has not been saved";

					 }

				}else{
					$data=[];
					$success=false;
					$message="Email or  Mobile already taken";
				}

		}
		$this->set(['success' => $success,'message'=>$message,'data'=>$data,'_serialize' => ['success','message','data']]);



	}

	public function login()
	{  // pr($this->Auth);
	  //pr($this->request->data); exit;
		$user = $this->Auth->identify();
    if (!$user) {
  			//throw new UnauthorizedException();
          $this->set([
            'success' => false,
            'message' => 'Invalid username or password',
            'users' => [],
            '_serialize' => ['success', 'users','message']
          ]);
  		}else {
        $arr = JWT::encode(['sub' => $user['id'],'exp' =>  time() + 604800],Security::salt());
        $query = $this->Customers->query();
        $result = $query->update()->set(['token' => $arr])->where(['id' => $user['id']])->execute();
        $user['token'] = $arr;
        $this->set(['users' => $user,'success' => true,'message' => 'Login Successfully',
        '_serialize' => ['success','message','users']]);
      }
	 }

   public function editProfile($id=null)
   {
      $id = $this->request->getData('id');
      $token ='';
       $customer = $this->Customers->get($id);
       if ($this->request->is(['patch', 'post', 'put'])) {
         foreach(getallheaders() as $key => $value) {
            if($key == 'Authorization')
            {
              $token = $value;
            }
         }
         // checkToken function is avaliable in app controller for checking token in customer table
        $token = str_replace("Bearer ","",$token);
         $isValidToken = $this->checkToken($token);
           if($isValidToken == 0)
             {
               $customer_error = 1;
               $customer_image = @$this->request->data['customer_image'];
         			 $customer_error = $customer_image['error'];

               $customer = $this->Customers->patchEntity($customer, $this->request->getData());

              if($customer_error == '0')
         			{
         				$customer_ext=explode('/',$customer_image['type']);
         				$customer->customer_image='customer'.time().'.'.$customer_ext[1];
         			}

               $customer->edited_by = $id;
               $exists = $this->Customers->exists(['Customers.email'=>$customer->email,'Customers.id !='=>$id]);

               if($exists == 0)
               {
                 if ($customer_data = $this->Customers->save($customer)) {
                     ///////////////// S3 Upload //////////////
             				if($customer_error ==0)
             				{
                        $deletekeyname = 'customer/'.$customer_data->id;
               					$this->AwsFile->deleteMatchingObjects($deletekeyname);
               					$keyname = 'customer/'.$customer_data->id.'/'.$customer_data->customer_image;
               					$this->AwsFile->putObjectFile($keyname,$customer_image['tmp_name'],$customer_image['type']);
                     }
                     $success = true;
                     $message = 'Update Successfully';
                   }else {

                     $success = false;
                     $message = 'Update Failed';
                   }
                $users = $this->Customers->get($id);
               }
               else {
                 $success = false;
                 $message = 'Provided email value is invalid';
               }

             }
             else {
               $success = false;
               $message = 'Invalid Token';
             }
        }
        $this->set(['success' => $success,'message'=>$message,'users'=>$users,'_serialize' => ['success','message','users']]);
   }

   public function viewProfile($id=null,$token=null)
   {
     $id = @$this->request->query['id'];
     $token = @$this->request->query['token'];
     $customer = [];
     if(!empty($id) && !empty($token))
     {
       // checkToken function is avaliable in app controller for checking token in customer table
       $isValidToken = $this->checkToken($token);
         if($isValidToken == 0)
           {
           $customer = $this->Customers->find()
              ->contain(['Cities','CustomerAddresses'])->where(['Customers.id'=>$id,'Customers.token'=>$token]);
              if(!empty($customer->toArray()))
              {
                $success = true;
                $message = 'Data Found Successfully';
              }
              else {
                    $success = false;
                    $message = 'Record not found';
              }
         }else {
           $success = false;
           $message = 'Invalid Token';
         }
     }
     else {
       $success = false;
       $message = 'Empty Customer Id or Token';
     }
     $this->set(['success' => $success,'message'=>$message,'customer' => $customer,'_serialize' => ['success','message','customer']]);
   }

   public function customerAddresses($customer_id=null,$token=null)
   {
       $customer_id = @$this->request->query['customer_id'];
       $token = @$this->request->query['token'];
       if(!empty($customer_id) && !empty($token))
       {
         // checkToken function is avaliable in app controller for checking token in customer table
         $isValidToken = $this->checkToken($token);
         if($isValidToken == 0)
          {
            $customerAddress = $this->Customers->CustomerAddresses->find()
            ->contain(['Cities'])->where(['customer_id'=>$customer_id,'is_deleted'=>0]);

               if(!empty($customerAddress->toArray()))
               {
                 $success = true;
                 $message = 'Data Found Successfully';
               }
               else {
                     $success = false;
                     $message = 'Record not found';
               }
          }
         else
          {
             $success = false;
             $message = 'Invalid Token';
          }
      }
      else
      {
         $success = false;
         $message = 'Empty Customer Id or Token';
      }
        $this->set(['success' => $success,'message'=>$message,'customerAddress' => $customerAddress,'_serialize' => ['success','message','customerAddress']]);
   }

   public function addAddress()
   {
     $customer_id = $this->request->data['customer_id'];
     $default_address_value = $this->request->data['default_address'];
     $customer_address_id = $this->request->data['id'];
     if(!empty($customer_id))
       {
          $exists = $this->Customers->CustomerAddresses->exists(['id'=>$customer_address_id,'customer_id'=>$customer_id]);
            if($exists == 0)
            {
                if($default_address_value == 1)
                {
                  $query = $this->Customers->CustomerAddresses->query();
                  $result = $query->update()->set(['default_address' => 0])
                            ->where(['customer_id' =>$customer_id])->execute();
                }


              $customerAddress = $this->Customers->CustomerAddresses->newEntity();
              $customerAddress = $this->Customers->CustomerAddresses->patchEntity($customerAddress, $this->request->getData());
            //  $customerAddress->default_address = 1;
              if ($this->Customers->CustomerAddresses->save($customerAddress)) {
                  $success=true;
                  $message="Inserted Successfully";
                }else {
                    $success = false;
                    $message = 'something wrong while inserting address';
                }
            }
            else {
                  if($default_address_value == 1)
                  {
                    $query = $this->Customers->CustomerAddresses->query();
                    $result = $query->update()->set(['default_address' => 0])
                              ->where(['customer_id' =>$customer_id])->execute();
                  }
                  $customerAddress =  $this->Customers->CustomerAddresses->get($customer_address_id);
                if ($this->request->is(['patch', 'post', 'put'])) {
                    $customerAddress = $this->Customers->CustomerAddresses->patchEntity($customerAddress, $this->request->getData());
                    if ($this->Customers->CustomerAddresses->save($customerAddress)) {
                      $success=true;
                      $message="Update Successfully";
                    }else{
                      $success = false;
                      $message = 'something wrong while updating address';
                    }
                }
             }
      }
      else
      {
         $success = false;
         $message = 'Empty Customer Id';
      }
        $this->set(['success' => $success,'message'=>$message,'_serialize' => ['success','message']]);
   }

   public function removeAddress($id=null)
   {
      $id = $this->request->query['id'];
      $query = $this->Customers->CustomerAddresses->query();
      $result = $query->update()->set(['is_deleted' => 1])->where(['id' =>$id])->execute();
      $success = true;
      $message = 'Removed Successfully';
      $this->set(['success' => $success,'message'=>$message,'_serialize' => ['success','message']]);
   }

}
