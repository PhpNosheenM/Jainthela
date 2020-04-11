<?php
namespace App\Controller;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\View\View;
/**
 * Landmarks Controller
 *
 * @property \App\Model\Table\LandmarksTable $Landmarks
 *
 * @method \App\Model\Entity\Landmark[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LandmarksController extends AppController
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
    public function index($ids=null)
    {
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id');
		$location_id=$this->Auth->User('location_id');
		$status = $this->request->query('status');
		$user_type =$this->Auth->User('user_type');
		if($user_type=="Super Admin"){
		$this->viewBuilder()->layout('super_admin_layout');
		}else if($user_type=="Admin"){ 
		$this->viewBuilder()->layout('admin_portal');
		}
		$this->paginate = [
			'limit' => 100
        ];
		
		if($ids)
		{
		   $id = $this->EncryptingDecrypting->decryptData($ids);
		}
		
		$landmarks =$this->Landmarks->find()->where(['Landmarks.city_id'=>$city_id])->contain(['Cities','Locations']);
		if($ids)
		{
			$landmark = $this->Landmarks->get($id);
		}
		else{
			$landmark = $this->Landmarks->newEntity();
		}
		
		if ($this->request->is(['post','put'])) {
			  
            $landmark = $this->Landmarks->patchEntity($landmark, $this->request->getData());
			$route_id=$this->request->getData()['route_id'];
			$landmark->city_id=$city_id;
			
            if ($landmark_data=$this->Landmarks->save($landmark)) {

				$RouteDetail = $this->Landmarks->Routes->RouteDetails->newEntity();
				$Voucher_no = $this->Landmarks->Routes->RouteDetails->find()->select(['priority'])->where(['RouteDetails.route_id'=>$route_id])->order(['RouteDetails.priority' => 'DESC'])->first();
				$RouteDetail->route_id= $route_id;
				$RouteDetail->landmark_id= $landmark->id;
				$RouteDetail->priority=$Voucher_no->priority+1;
				$RouteDetail->status= 'Active';
				$this->Landmarks->Routes->RouteDetails->save($RouteDetail);
			
				
				$this->Flash->success(__('The Landmark has been saved.'));
				return $this->redirect(['action' => 'index']);
               
            }
            $this->Flash->error(__('The Landmark could not be saved. Please, try again.'));
        }
		else if ($this->request->is(['get'])){
			$search=$this->request->getQuery('search');
			$landmarks->where([
							'OR' => [
									'Landmarks.name LIKE' => $search.'%',
									'Locations.name LIKE' => $search.'%',
									'Landmarks.status LIKE' => $search.'%'
							]
			]);
		}
		
        $landmarks = $this->paginate($landmarks);
		$locations=$this->Landmarks->Locations->find('list')->where(['Locations.city_id'=>$city_id,'Locations.status'=>'Active']);
		$Routes=$this->Landmarks->Routes->find('list')->where(['Routes.city_id'=>$city_id])->toArray();
		//pr($Routes); exit;
		$paginate_limit=$this->paginate['limit'];
        $this->set(compact('landmarks','landmark','paginate_limit','locations','Routes'));
    }

    /**
     * View method
     *
     * @param string|null $id Landmark id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $landmark = $this->Landmarks->get($id, [
            'contain' => ['Cities', 'Locations', 'RouteRows']
        ]);

        $this->set('landmark', $landmark);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $landmark = $this->Landmarks->newEntity();
        if ($this->request->is('post')) {
            $landmark = $this->Landmarks->patchEntity($landmark, $this->request->getData());
            if ($this->Landmarks->save($landmark)) {
                $this->Flash->success(__('The landmark has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The landmark could not be saved. Please, try again.'));
        }
        $cities = $this->Landmarks->Cities->find('list', ['limit' => 200]);
        $locations = $this->Landmarks->Locations->find('list', ['limit' => 200]);
        $this->set(compact('landmark', 'cities', 'locations'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Landmark id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $landmark = $this->Landmarks->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $landmark = $this->Landmarks->patchEntity($landmark, $this->request->getData());
            if ($this->Landmarks->save($landmark)) {
                $this->Flash->success(__('The landmark has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The landmark could not be saved. Please, try again.'));
        }
        $cities = $this->Landmarks->Cities->find('list', ['limit' => 200]);
        $locations = $this->Landmarks->Locations->find('list', ['limit' => 200]);
        $this->set(compact('landmark', 'cities', 'locations'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Landmark id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($dir)
    {
        $this->request->allowMethod(['post', 'delete']);
		$id = $this->EncryptingDecrypting->decryptData($dir);
        $landmark = $this->Landmarks->get($id);
		$landmark->status='Deactive';
        if ($this->Landmarks->save($landmark)) {
            $this->Flash->success(__('The landmark has been deleted.'));
        } else {
            $this->Flash->error(__('The landmark could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
