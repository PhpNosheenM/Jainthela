<?php
namespace App\Controller;

use App\Controller\AppController;
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
		$this->loadComponent('Security');
        $this->loadComponent('Csrf');
		$this->Security->setConfig('blackHoleCallback', 'blackhole');		
	}
	
	public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        // Allow users to register and logout.
        // You should not add the "login" action to allow list. Doing so would
        // cause problems with normal functioning of AuthComponent.
        $this->Auth->allow(['logout', 'login']);
    }
	public function blackhole($type)
	{
		// Handle errors.
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
			$city = $this->Admins->Locations->get($user['location_id']);
			if ($user) 
			{
				$user['city_id']=$city->id;
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
    public function add()
    {
        $admin = $this->Admins->newEntity();
        if ($this->request->is('post')) {
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
