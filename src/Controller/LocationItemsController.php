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
		$city_id=$this->Auth->User('city_id');
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
				
				$check_count=$this->LocationItems->ItemVariationMasters->ItemVariations->find()->where(['ItemVariations.city_id'=>$city_id,'ItemVariations.item_id'=>$item_id,'ItemVariations.item_variation_master_id'=>$item_variation_master_ids[$t]])->count();
				$check_count1=$this->LocationItems->find()->where(['LocationItems.location_id'=>$location_id,'LocationItems.item_id'=>$item_id,'LocationItems.item_variation_master_id'=>$item_variation_master_ids[$t]])->count();
				$check_values=$this->LocationItems->find()->where(['LocationItems.location_id'=>$location_id,'LocationItems.item_id'=>$item_id,'LocationItems.item_variation_master_id'=>$item_variation_master_ids[$t]])->contain(['ItemVariationMasters'])->first();
				@$updated_id=$check_values->id;
				@$unit_variation_id=$check_values->item_variation_master->unit_variation_id;
			
					if(empty($check_count)){
						 $item_variations = $this->LocationItems->ItemVariationMasters->ItemVariations->newEntity();
						 $item_variations->item_id=$item_id;
						 $item_variations->city_id=$city_id;
						 $item_variations->unit_variation_id=$unit_variation_id;
						 $item_variations->item_variation_master_id=$item_variation_master_ids[$t];
						
						$this->LocationItems->ItemVariationMasters->ItemVariations->save($item_variations);
						pr($item_variations); exit;
						
					}
					
					if(empty($check_count1)){
						if ($this->LocationItems->save($locationItem)) {
						
						}
					}else{
						$locationItem1=$this->LocationItems->get($updated_id);

						$locationItem1->location_id=$location_id;
						$locationItem1->item_id=$item_id;
						$locationItem1->item_variation_master_id=$item_variation_master_ids[$t];
						$locationItem1->status=$status;
						
						$this->LocationItems->save($locationItem1);
						pr($locationItem1);
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
	public function checking($item_id,$item_variation_master_id){
		 
		$location_id=$this->Auth->User('location_id');
		$check_master_count=$this->LocationItems->find()->where(['item_id'=>$item_id,'location_id'=>$location_id,'item_variation_master_id'=>$item_variation_master_id])->count();
		$check_master=$this->LocationItems->find()->where(['item_id'=>$item_id,'location_id'=>$location_id,'item_variation_master_id'=>$item_variation_master_id])->first();
		$status=$check_master->status;
		$final=['check_master_count'=>$check_master_count,'status'=>$status]; 
		
		$this->response->body($final);
		return $this->response;
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
