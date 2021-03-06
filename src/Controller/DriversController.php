<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\View\View;

/**
 * Drivers Controller
 *
 * @property \App\Model\Table\DriversTable $Drivers
 *
 * @method \App\Model\Entity\Driver[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DriversController extends AppController
{

	public function beforeFilter(Event $event)
	{
		parent::beforeFilter($event);
		$this->Security->setConfig('unlockedActions', ['index']);
	}
	
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index($id=null)
    {
		$city_id=$this->Auth->User('city_id'); 
		$user_id=$this->Auth->User('id');
		$user_type =$this->Auth->User('user_type');
		if($user_type=="Super Admin"){
		$this->viewBuilder()->layout('super_admin_layout');	
		}else if($user_type=="Admin"){ 
		$this->viewBuilder()->layout('admin_portal');
		}
        $this->paginate = [
			'contain' => ['Locations'],
            'limit' => 20
        ];
		
		if($id)
		{
		   $id = $this->EncryptingDecrypting->decryptData($id);
		}
		
        $drivers =$this->Drivers->find()->contain(['Routes']);
	 
		if($id)
		{
			$driver = $this->Drivers->get($id);
		}
		else{
			$driver = $this->Drivers->newEntity();
		}
	
        if ($this->request->is(['post','put'])) {
		 
            $driver = $this->Drivers->patchEntity($driver, $this->request->getData());
		  
			echo $password= $this->request->data['password'];
			//exit;
			$driver->route_id=$this->request->getData('route_id');
            if ($banner_data=$this->Drivers->save($driver)) {
			  
                $this->Flash->success(__('The driver has been saved.')); 
            }
		 
            $this->Flash->error(__('The driver could not be saved. Please, try again.'));
			 return $this->redirect(['action' => 'index']);
        }
	/* 	else if ($this->request->is(['get'])){
			$search=$this->request->getQuery('search');
			$homeScreens->where([
							'OR' => [
									'Drivers.name LIKE' => $search.'%',
									'Drivers.link_name LIKE' => $search.'%',
									'Drivers.status LIKE' => $search.'%'
							]
			]);
		} */
		$locations=$this->Drivers->Locations->find('List')->where(['Locations.city_id'=>$city_id]);
		$Routes=$this->Drivers->Routes->find('List')->where(['Routes.status'=>"Active"]);
        $drivers = $this->paginate($drivers);
		$paginate_limit=$this->paginate['limit'];
		$this->set(compact('drivers','driver','paginate_limit','locations','Routes'));
		 
    }

    /**
     * View method
     *
     * @param string|null $id Driver id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $driver = $this->Drivers->get($id, [
            'contain' => ['Locations', 'Orders']
        ]);

        $this->set('driver', $driver);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $driver = $this->Drivers->newEntity();
        if ($this->request->is('post')) {
            $driver = $this->Drivers->patchEntity($driver, $this->request->getData());
            if ($this->Drivers->save($driver)) {
                $this->Flash->success(__('The driver has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The driver could not be saved. Please, try again.'));
        }
        $locations = $this->Drivers->Locations->find('list', ['limit' => 200]);
        $this->set(compact('driver', 'locations'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Driver id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $driver = $this->Drivers->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $driver = $this->Drivers->patchEntity($driver, $this->request->getData());
            if ($this->Drivers->save($driver)) {
                $this->Flash->success(__('The driver has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The driver could not be saved. Please, try again.'));
        }
        $locations = $this->Drivers->Locations->find('list', ['limit' => 200]);
        $this->set(compact('driver', 'locations'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Driver id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($dir)
    {
        $this->request->allowMethod(['patch', 'post', 'put']);
		$id = $this->EncryptingDecrypting->decryptData($dir);
        $driver = $this->Drivers->get($id);
		$driver->status='Deactive';
        if ($this->Drivers->save($driver)) {
            $this->Flash->success(__('The driver has been deleted.'));
        } else {
            $this->Flash->error(__('The driver could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
