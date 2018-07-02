<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Routing\Router;
use Cake\Mailer\Email;
use Cake\Event\Event;
use Cake\View\View;
/**
 * Admins Controller
 *
 * @property \App\Model\Table\AdminsTable $Admins
 *
 * @method \App\Model\Entity\Admin[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AdminsController extends AppController
{
	public function initialize()
	{
		parent::initialize();
      
		$this->Security->setConfig('blackHoleCallback', 'blackhole');		
	}
	
	public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        // Allow users to register and logout.
        // You should not add the "login" action to allow list. Doing so would
        // cause problems with normal functioning of AuthComponent.
        $this->Auth->allow(['logout', 'login', 'add', 'changePassword', 'forgotPassword', 'resetPassword']);
    }
	public function blackhole($type)
	{
		// Handle errors.
	}
	
	public function forgotPassword()
    {
		$this->viewBuilder()->layout('admin_login');
        if ($this->request->is('post')) {
			
            $query = $this->Admins->findByEmail($this->request->data['email']);
            $user = $query->first();
			
            if (is_null($user)) {
                $this->Flash->error('Email address does not exist. Please try again');
            } else {
				
                $passkey = uniqid();
                //$url = $this->Url->build(['controller' => 'Admins', 'action' => 'reset_password'], true) . '/' . $passkey;
				//$url =$this->Html->link(['controller'=>'Admins','action' => 'reset_password/'.$passkey],['target'=>'_blank']);
				 $url = Router::Url(['controller' => 'Admins', 'action' => 'reset_password'], true) . '/' . $passkey;
                $timeout = time() + DAY;
                 if ($this->Admins->updateAll(['passkey' => $passkey, 'timeout' => $timeout], ['id' => $user->id])){
					
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
            $query = $this->Admins->find('all')->where(['passkey' => $passkey, 'timeout >' => time()]);
            $user = $query->first();
			
			
            if ($user) {
                if (!empty($this->request->data)) {
                    // Clear passkey and timeout
                    $this->request->data['passkey'] = null;
                    $this->request->data['timeout'] = null;
                    $user = $this->Admins->patchEntity($user, $this->request->data);
                    if ($this->Admins->save($user)) {
                        $this->Flash->success(__('Your password has been updated.'));
                        $this->Auth->setUser($user);
						return $this->redirect(['controller'=>'Admins','action' => 'index']);
						
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
		$sub="Password reset instructions for EntryHires account";
		$from_name="JAINTHELA";
 		$email_to=$user->email;
		if(!empty($email_to)){
		try {
			$email->from(['hello@entryhires.com' => $from_name])
				->to($email_to, $user->name)
				->subject($sub)
				->profile('default')
				->template('resetpw')
				->emailFormat('html')
				->viewVars(['url' => $url, 'email' => $user->email,'user_name'=>$user->username]);
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
	
	public function changePassword()
	{
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id');
		$this->viewBuilder()->layout('admin_portal');
		$Admin = $this->Admins->get($user_id);
		 
			if ($this->request->is(['post','put'])) {
				$Admin = $this->Admins->patchEntity($Admin, [
						'old_password'  => $this->request->data['old_password'],
						'password'      => $this->request->data['password'],
						'confirm_password' => $this->request->data['confirm_password']
					],
					['validate' => 'password']);
			 
				if ($this->Admins->save($Admin)) {
					
					 $this->Flash->success(__('The Admin Password has been saved.'));
					 return $this->redirect(['action' => 'index']);
				}
				$this->Flash->error(__('The Password could not be change. Please, try again.'));
				 
			}
		
		$this->set(compact('Admin', 'cities', 'roles','Admins','paginate_limit'));
	}
	
	
	public function logout()
	{
		//$this->Flash->success('You are now logged out.');
		return $this->redirect($this->Auth->logout());
	}
	
	public function login()
    {
		$this->viewBuilder()->layout('admin_login');
        if ($this->request->is('post')) 
		{
			$user = $this->Auth->identify();
			if ($user) 
			{
				$location = $this->Admins->Locations->get($user['location_id']);
				$user['city_id']=$location->city_id;
				$city = $this->Admins->Locations->Cities->get($location->city_id);
                $user['state_id']=$city->state_id;
				$user['user_type']='Admin';
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
				return $this->redirect(['controller'=>'Admins','action' => 'index']);
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
		$this->viewBuilder()->layout('admin_portal');
		
		$this->set(compact(''));
	}
	
    public function user_view()
    {
		//$this->request->unlockedFields(['password']);
        $this->paginate = [
            'contain' => ['Locations', 'Roles']
        ];
        $admins = $this->paginate($this->Admins);

        $this->set(compact('admins'));
    }

    /**
     * View method
     *
     * @param string|null $id Admin id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $admin = $this->Admins->get($id, [
            'contain' => ['Locations', 'Roles', 'ComboOffers', 'Feedbacks', 'Items', 'Plans', 'Promotions', 'Units']
        ]);

        $this->set('admin', $admin);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($id=null)
    {
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id'); 
		$location_id=$this->Auth->User('location_id'); 
		$this->viewBuilder()->layout('admin_portal');
		 $this->paginate = [
            'limit' => 20
        ];
		
		$admins =$this->Admins->find()->contain(['Locations','Roles']);
		
		if($id)
		{
			$admin = $this->Admins->get($id);
		}
		else{
			$admin = $this->Admins->newEntity();
		}
		 
        if ($this->request->is(['post','put'])) {
			
            $admin = $this->Admins->patchEntity($admin, $this->request->getData());
			$admin->created_by=$user_id;
		 
            if ($this->Admins->save($admin)) {
                $this->Flash->success(__('The admin has been saved.'));

                return $this->redirect(['action' => 'add']);
            }
            $this->Flash->error(__('The admin could not be saved. Please, try again.'));
        }
		else if ($this->request->is(['get'])){
			$search=$this->request->getQuery('search');
			$admins->where([
							'OR' => [
									'Admins.name LIKE' => $search.'%',
									'Admins.email LIKE' => $search.'%',
									'Admins.mobile_no LIKE' => $search.'%',
									'Admins.username LIKE' => $search.'%',
									'Admins.status LIKE' => $search.'%',
									'Locations.name LIKE' => $search.'%',
									'Roles.name LIKE' => $search.'%'
							]
			]);
		}
		
		$admins = $this->paginate($admins);
		$paginate_limit=$this->paginate['limit'];
		
        $locations = $this->Admins->Locations->find('list', ['limit' => 200])->where(['Locations.city_id'=>$city_id]);
        $roles = $this->Admins->Roles->find('list', ['limit' => 200]);
        $this->set(compact('admin', 'locations', 'roles','admins','paginate_limit'));
    }

    /**
     * Edit method
     * 
     * @param string|null $id Admin id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $admin = $this->Admins->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $admin = $this->Admins->patchEntity($admin, $this->request->getData());
			
            if ($this->Admins->save($admin)) {
                $this->Flash->success(__('The admin has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The admin could not be saved. Please, try again.'));
        }
		
        $locations = $this->Admins->Locations->find('list', ['limit' => 200]);
        $roles = $this->Admins->Roles->find('list', ['limit' => 200]);
        $this->set(compact('admin', 'locations', 'roles'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Admin id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $admin = $this->Admins->get($id);
        if ($this->Admins->delete($admin)) {
            $this->Flash->success(__('The admin has been deleted.'));
        } else {
            $this->Flash->error(__('The admin could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

}
