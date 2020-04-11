<?php
namespace App\Controller;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\View\View;
/**
 * Routes Controller
 *
 * @property \App\Model\Table\RoutesTable $Routes
 *
 * @method \App\Model\Entity\Route[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RoutesController extends AppController
{
	public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Security->setConfig('unlockedActions', ['add','index','delete','edit']);

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
		$user_type=$this->Auth->User('user_type');
		if($user_type=="Super Admin"){
			$this->viewBuilder()->layout('super_admin_layout');	
		}else{
			$this->viewBuilder()->layout('admin_portal');
		}
        $this->paginate = [
            'limit' => 100
        ];
		$routes=$this->Routes->find()->where(['Routes.city_id'=>$city_id])->contain(['Cities','Locations','RouteDetails'=>['Landmarks']]);
		if ($this->request->is(['get'])){
			$search=$this->request->getQuery('search');
			$routes->where([
							'OR' => [
									'Routes.name LIKE' => $search.'%',
									'Routes.narration LIKE' => $search.'%',
									'Routes.created_on LIKE' => $search.'%',
									'Routes.status LIKE' => $search.'%',
									'Cities.name LIKE' => $search.'%',
									'Locations.name LIKE' => $search.'%'
							]
			]);
		}
		
		//pr($routes->toArray()); exit;
        $routes = $this->paginate($routes);

        $paginate_limit=$this->paginate['limit'];
        $this->set(compact('routes','paginate_limit'));
    }

    /**
     * View method
     *
     * @param string|null $id Route id.
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
		$user_type=$this->Auth->User('user_type');
		if($user_type=="Super Admin"){
			$this->viewBuilder()->layout('super_admin_layout');	
		}else{
			$this->viewBuilder()->layout('admin_portal');
		}
		
        $routes = $this->Routes->get($id, [
            'contain' => ['Cities', 'Locations', 'RouteDetails'=> function ($q){
				return $q->order(['RouteDetails.priority'=>'ASC'])->contain(['Landmarks']);
			}]
        ]);
		//pr($routes); exit;
        $this->set('routes', $routes);
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
		$user_type=$this->Auth->User('user_type');
		if($user_type=="Super Admin"){
			$this->viewBuilder()->layout('super_admin_layout');	
		}else{
			$this->viewBuilder()->layout('admin_portal');
		}
		
        $route = $this->Routes->newEntity();
        if ($this->request->is('post')) {
            $route = $this->Routes->patchEntity($route, $this->request->getData());
			$route->city_id=$city_id;
			
			
            if ($this->Routes->save($route)) {
                $this->Flash->success(__('The route has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The route could not be saved. Please, try again.'));
        }
        $cities = $this->Routes->Cities->find('list', ['limit' => 200]);
        $locations = $this->Routes->Locations->find('list')->where(['Locations.status'=>'Active','Locations.city_id'=>$city_id]);
		$this->loadmodel('Landmarks');
		$landmarks=$this->Landmarks->find('list')->where(['city_id'=>$city_id,'status'=>'Active']);
        $this->set(compact('route', 'cities', 'locations', 'landmarks'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Route id.
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
		$user_type=$this->Auth->User('user_type');
		if($user_type=="Super Admin"){
			$this->viewBuilder()->layout('super_admin_layout');	
		}else{
			$this->viewBuilder()->layout('admin_portal');
		}
		
        $route = $this->Routes->get($id, [
            'contain' => ['Cities','Locations','RouteDetails'=>['Landmarks']]
        ]);
		
        if ($this->request->is(['patch', 'post', 'put'])) {
			
            $route = $this->Routes->patchEntity($route, $this->request->getData());
            if ($this->Routes->save($route)) {
                $this->Flash->success(__('The route has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The route could not be saved. Please, try again.'));
        }
        $cities = $this->Routes->Cities->find('list', ['limit' => 200]);
        $locations = $this->Routes->Locations->find('list')->where(['Locations.status'=>'Active','Locations.city_id'=>$city_id]);
		$this->loadmodel('Landmarks');
		$landmarks=$this->Landmarks->find('list')->where(['city_id'=>$city_id,'status'=>'Active']);
        $this->set(compact('route', 'cities', 'locations', 'landmarks'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Route id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($dir)
    {
        $this->request->allowMethod(['patch', 'post', 'put']);
		$id = $this->EncryptingDecrypting->decryptData($dir);
        $route = $this->Routes->get($id);
		$route->status='Deactive';
        if ($this->Routes->save($route)) {
            $this->Flash->success(__('The route has been deleted.'));
        } else {
            $this->Flash->error(__('The route could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
