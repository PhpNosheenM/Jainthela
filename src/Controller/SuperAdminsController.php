<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Routing\Router;
use Cake\Mailer\Email;
use Cake\Event\Event;
use Cake\View\View;
/**
 * SuperAdmins Controller
 *
 * @property \App\Model\Table\SuperAdminsTable $SuperAdmins
 *
 * @method \App\Model\Entity\SuperAdmin[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SuperAdminsController extends AppController
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
        $this->Auth->allow(['logout', 'login', 'add','index', 'changePassword', 'forgotPassword', 'resetPassword']);
    }
	public function blackhole($type)
	{
		// Handle errors.
	}
	
	public function forgotPassword()
    {
		$this->viewBuilder()->layout('admin_login');
        if ($this->request->is('post')) {
			
            $query = $this->SuperAdmins->findByEmail($this->request->data['email']);
            $user = $query->first();
			
            if (is_null($user)) {
                $this->Flash->error('Email address does not exist. Please try again');
            } else {
				
                $passkey = uniqid();
                //$url = $this->Url->build(['controller' => 'SuperAdmins', 'action' => 'reset_password'], true) . '/' . $passkey;
				//$url =$this->Html->link(['controller'=>'SuperAdmins','action' => 'reset_password/'.$passkey],['target'=>'_blank']);
				 $url = Router::Url(['controller' => 'SuperAdmins', 'action' => 'reset_password'], true) . '/' . $passkey;
                $timeout = time() + DAY;
                 if ($this->SuperAdmins->updateAll(['passkey' => $passkey, 'timeout' => $timeout], ['id' => $user->id])){
					
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
            $query = $this->SuperAdmins->find('all')->where(['passkey' => $passkey, 'timeout >' => time()]);
            $user = $query->first();
			
			
            if ($user) {
                if (!empty($this->request->data)) {
                    // Clear passkey and timeout
                    $this->request->data['passkey'] = null;
                    $this->request->data['timeout'] = null;
                    $user = $this->SuperAdmins->patchEntity($user, $this->request->data);
                    if ($this->SuperAdmins->save($user)) {
                        $this->Flash->success(__('Your password has been updated.'));
                        $this->Auth->setUser($user);
						return $this->redirect(['controller'=>'SuperAdmins','action' => 'index']);
						
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
		$sub="Password reset instructions for Jainthela Super Admin account";
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
	
	
	public function logout()
	{
		//$this->Flash->success('You are now logged out.');
		return $this->redirect($this->Auth->logout());
	}
	
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function changePassword()
	{
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id');
		$this->viewBuilder()->layout('super_admin_layout');
		$superAdmin = $this->SuperAdmins->get($user_id);
		 
			if ($this->request->is(['post','put'])) {		
				$superAdmin = $this->SuperAdmins->patchEntity($superAdmin, [
						'old_password'  => $this->request->data['old_password'],
						'password'      => $this->request->data['password'],
						'confirm_password' => $this->request->data['confirm_password']
					],
					['validate' => 'password']);
			 
				if ($this->SuperAdmins->save($superAdmin)) {
					
					 $this->Flash->success(__('The superAdmin Password has been saved.'));
					 return $this->redirect(['action' => 'index']);
				}
				$this->Flash->error(__('The Password could not be change. Please, try again.'));
				 
			}
		
		$this->set(compact('superAdmin', 'cities', 'roles','superAdmins','paginate_limit'));
	}

	
	

    public function index()
    {
        $this->viewBuilder()->layout('super_admin_layout');
		
		$this->set(compact(''));
    }

	
	public function login()
    {
		$this->viewBuilder()->layout('admin_login');
        if ($this->request->is('post')) 
		{
			$user = $this->Auth->identify();
			  
			if ($user) 
			{ //pr($user); exit;
				$Cities = $this->SuperAdmins->Cities->get($user['city_id']);
                $user['state_id']=$Cities->state_id;
                $companies = $this->SuperAdmins->Companies->find('all')->where(['state_id'=>$Cities->state_id])->first();
				//pr($state); 
				//pr($companies); exit;
                $user['company_id']=$companies->id;
				$user['user_type']='Super Admin';
				$user['financial_year_id']=1;
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
				return $this->redirect(['controller'=>'SuperAdmins','action' => 'index']);
            }
            $this->Flash->error(__('Invalid Username or Password'));
        }	
    }
	
	
    /**
     * View method
     *
     * @param string|null $id Super Admin id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $superAdmin = $this->SuperAdmins->get($id, [
            'contain' => ['Cities', 'Roles']
        ]);

        $this->set('superAdmin', $superAdmin);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($id = null)
    {
		
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id');
		$this->viewBuilder()->layout('super_admin_layout');
		 $this->paginate = [
            'limit' => 20
        ];
		
		$superAdmins =$this->SuperAdmins->find()->where(['SuperAdmins.City_id'=>$city_id])->contain(['Cities','Roles']);
		
		if($id)
		{
			$superAdmin = $this->SuperAdmins->get($id);
		}
		else{
			$superAdmin = $this->SuperAdmins->newEntity();
		}
		
        if ($this->request->is(['post','put'])) {
			
            $superAdmin = $this->SuperAdmins->patchEntity($superAdmin, $this->request->getData());
			$superAdmin->created_by=$user_id;
			
            if ($this->SuperAdmins->save($superAdmin)) {
                $this->Flash->success(__('The superAdmin has been saved.'));

                return $this->redirect(['action' => 'add']);
            }
            $this->Flash->error(__('The superAdmin could not be saved. Please, try again.'));
        }
		else if ($this->request->is(['get'])){
			$search=$this->request->getQuery('search');
			$superAdmins->where([
							'OR' => [
									'SuperAdmins.name LIKE' => $search.'%',
									'SuperAdmins.email LIKE' => $search.'%',
									'SuperAdmins.mobile_no LIKE' => $search.'%',
									'SuperAdmins.username LIKE' => $search.'%',
									'SuperAdmins.status LIKE' => $search.'%',
									'Cities.name LIKE' => $search.'%',
									'Roles.name LIKE' => $search.'%'
							]
			]);
		}
		
		$superAdmins = $this->paginate($superAdmins);
		$paginate_limit=$this->paginate['limit'];
		
        $cities = $this->SuperAdmins->Cities->find('list', ['limit' => 200]);
        $roles = $this->SuperAdmins->Roles->find('list', ['limit' => 200]);
        $this->set(compact('superAdmin', 'cities', 'roles','superAdmins','paginate_limit'));
		
	/* 	
        $superAdmin = $this->SuperAdmins->newEntity();
        if ($this->request->is('post')) {
            $superAdmin = $this->SuperAdmins->patchEntity($superAdmin, $this->request->getData());
            if ($this->SuperAdmins->save($superAdmin)) {
                $this->Flash->success(__('The super admin has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The super admin could not be saved. Please, try again.'));
        }
        $cities = $this->SuperAdmins->Cities->find('list', ['limit' => 200]);
        $roles = $this->SuperAdmins->Roles->find('list', ['limit' => 200]);
        $this->set(compact('superAdmin', 'cities', 'roles')); */
    }

    /**
     * Edit method
     *
     * @param string|null $id Super Admin id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $superAdmin = $this->SuperAdmins->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $superAdmin = $this->SuperAdmins->patchEntity($superAdmin, $this->request->getData());
            if ($this->SuperAdmins->save($superAdmin)) {
                $this->Flash->success(__('The super admin has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The super admin could not be saved. Please, try again.'));
        }
        $cities = $this->SuperAdmins->Cities->find('list', ['limit' => 200]);
        $roles = $this->SuperAdmins->Roles->find('list', ['limit' => 200]);
        $this->set(compact('superAdmin', 'cities', 'roles'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Super Admin id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['patch', 'post', 'put']);
        $superAdmin = $this->SuperAdmins->get($id);
		$superAdmin->status='Deactive';
        if ($this->SuperAdmins->save($superAdmin)) {
            $this->Flash->success(__('The super admin has been deleted.'));
        } else {
            $this->Flash->error(__('The super admin could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'add']);
    }
}
