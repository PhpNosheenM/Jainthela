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
        $this->Auth->allow(['add', 'token1']);
    }

	public function add()
	{
		$this->Crud->on('afterSave', function(Event $event) {
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
		return $this->Crud->execute();
	}

	public function token1()
	{  // pr($this->Auth);
	  //pr($this->request->data); exit;
		$user = $this->Auth->identify();

  		if (!$user) {
  			throw new UnauthorizedException('Invalid username or password');
  		}
  		$this->set([
  			'success' => true,
  			'data' => [
  				'token' => JWT::encode([
  					'sub' => $user['id'],
  					'exp' =>  time() + 604800
  				],
  				Security::salt())
  			],
  			'_serialize' => ['success', 'data']
  		]);
	 }

   public function editProfile()
   {
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
