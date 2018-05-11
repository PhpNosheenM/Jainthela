<?php
namespace App\Controller;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\View\View;
/**
 * LocationItems Controller
 *
 * @property \App\Model\Table\LocationItemsTable $LocationItems
 *
 * @method \App\Model\Entity\LocationItem[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LocationItemsController extends AppController
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
    public function index($id = null)
    {
		$location_id=$this->Auth->User('location_id');
		$user_id=$this->Auth->User('id');
		$this->viewBuilder()->layout('admin_portal');
        $this->paginate = [
            'limit' => 20
        ];
		 
		$locationItem = $this->LocationItems->newEntity();
		if ($this->request->is('post')) 
		{
			$item_id=$this->request->data('item_id');
			$item_variation_master_ids=$this->request->data('item_variation_master_id');
			$statuss=$this->request->data('status');
			 $t=0;
			 foreach($statuss as $status){
				 
				$locationItem = $this->LocationItems->newEntity();
				$locationItem->location_id=$location_id;
				$locationItem->item_id=$item_id;
				$locationItem->item_variation_master_id=$item_variation_master_ids[$t];
				$locationItem->status=$status;
				
				if ($this->LocationItems->save($locationItem)) {
					
				}
				$t++;
			 }
			 
		}	
		$Items=$this->LocationItems->ItemVariationMasters->Items->find('list');
		 
        
		$paginate_limit=$this->paginate['limit'];
		$this->set(compact('locationItems','locationItem','paginate_limit','Items'));
    }
 
	public function getItemInfo()
	{
		$location_id=$this->Auth->User('location_id');
		$item_id = $this->request->query('item_id'); 
		$item = $this->LocationItems->ItemVariationMasters->Items->find()->where(['Items.id'=>@$item_id])->contain(['ItemVariationMasters'=>['ItemVariations','UnitVariations'=>['Units']]])->first();
		 $check_master=$this->LocationItems->find()->where(['item_id'=>$item_id,'location_id'=>$location_id]);
		$this->set(compact('item','check_master'));
	}

    /**
     * View method
     *
     * @param string|null $id Location Item id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $locationItem = $this->LocationItems->get($id, [
            'contain' => ['Items', 'ItemVariations', 'Locations']
        ]);

        $this->set('locationItem', $locationItem);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
		
        $locationItem = $this->LocationItems->newEntity();
        if ($this->request->is('post')) {
            $locationItem = $this->LocationItems->patchEntity($locationItem, $this->request->getData());
            if ($this->LocationItems->save($locationItem)) {
                $this->Flash->success(__('The location item has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The location item could not be saved. Please, try again.'));
        }
        $items = $this->LocationItems->Items->find('list', ['limit' => 200]);
        $itemVariations = $this->LocationItems->ItemVariations->find('list', ['limit' => 200]);
        $locations = $this->LocationItems->Locations->find('list', ['limit' => 200]);
        $this->set(compact('locationItem', 'items', 'itemVariations', 'locations'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Location Item id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $locationItem = $this->LocationItems->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $locationItem = $this->LocationItems->patchEntity($locationItem, $this->request->getData());
            if ($this->LocationItems->save($locationItem)) {
                $this->Flash->success(__('The location item has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The location item could not be saved. Please, try again.'));
        }
        $items = $this->LocationItems->Items->find('list', ['limit' => 200]);
        $itemVariations = $this->LocationItems->ItemVariations->find('list', ['limit' => 200]);
        $locations = $this->LocationItems->Locations->find('list', ['limit' => 200]);
        $this->set(compact('locationItem', 'items', 'itemVariations', 'locations'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Location Item id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $locationItem = $this->LocationItems->get($id);
        if ($this->LocationItems->delete($locationItem)) {
            $this->Flash->success(__('The location item has been deleted.'));
        } else {
            $this->Flash->error(__('The location item could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
