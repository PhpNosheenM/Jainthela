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
        $this->Auth->allow(['add', 'login']);
    }

	
	public function verify(){
		$customer = $this->Customers->newEntity();
		if($this->request->is(['patch', 'post', 'put'])){
			
			foreach(getallheaders() as $key => $value) {
				if($key == 'Authorization')
				{
					echo $token = $value;
				}
			}
			$token = str_replace("Bearer ","",$token);
			$isValidToken = $this->checkToken($token);
			$id=$this->request->data['id'];
			$otp=$this->request->data['otp'];
			if($isValidToken == 0)
             {
				 if(!empty($id) and (!empty($otp))){
						$Customers=$this->Customers->find()->where(['id'=>$id,'otp'=>$otp]);
						if($Customers->toArray()){
							
							$query = $this->Customers->query();
							$result = $query->update()->set(['status' => 'Active'])->where(['id' => $id])->execute();
							$Customers=$this->Customers->find()->where(['id'=>$id,'otp'=>$otp]);
							$data=$Customers;
							$success = true;
							$message = 'Register Successfully';
						}else{
							$data=[];
							$success = false;
							$message = 'otp is not match';
						}
				 }else{
					  $data=[];
					  $success = false;
					  $message = 'Id or Otp is not empty';	
				 }
				 
			 }
             else{
				$data=[];
               $success = false;
               $message = 'Invalid Token';
             }
		}
		

		$this->set(['success' => $success,'message'=>$message,'data'=>$data,'_serialize' => ['success','message','data']]);
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
					$opt=(mt_rand(1,10000)); 
					$mobile=$this->request->data['username'];
					
					
					$this->request->data['otp']=$opt;
					$this->request->data['status']='Deactive';
					$customer = $this->Customers->patchEntity($customer, $this->request->getData());
					
					 if ($customers=$this->Customers->save($customer)) {
						 $content="Your one time password for jainthela is ".$opt;
						// $this->Sms->sendSms($mobile,$content);
						
							$arr = JWT::encode(['sub' => $customers->id,'exp' =>  time() + 604800],Security::salt());
							$query = $this->Customers->query();
							$result = $query->update()->set(['token' => $arr])->where(['id' => $customers->id])->execute();
						 $customer_data = $this->Customers->get($customers->id);
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
               $exists = $this->Customers->exists(['Customers.email'=>$customer->email]);

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
        $this->set(['success' => $success,'message'=>$message,'_serialize' => ['success','message']]);
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


}
