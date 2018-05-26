<?php
namespace App\Controller;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\View\View;


/**
 * ItemVariationMasters Controller
 *
 * @property \App\Model\Table\ItemVariationMastersTable $ItemVariationMasters
 *
 * @method \App\Model\Entity\ItemVariationMaster[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ItemVariationMastersController extends AppController
{

	public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Security->setConfig('unlockedActions', ['index','index1']);

    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
	 
	public function index1()
    {
		$city_id=$this->Auth->User('city_id');
		$user_id=$this->Auth->User('id');
		$this->viewBuilder()->layout('super_admin_layout');
        $this->paginate = [
            'limit' => 20
        ];

		$itemVariation = $this->ItemVariationMasters->newEntity();
		if ($this->request->is('post'))
		{
			 
			$item_id=$this->request->data('item_id');
			$item_variation_master_ids=$this->request->data('item_variation_master_id');
			$statuss=$this->request->data('status');
			$unit_variation_ids=$this->request->data('unit_variation_id');
			$maximum_quantity_purchases=$this->request->data('maximum_quantity_purchase');
			$current_stocks=$this->request->data('current_stock');
			//$add_stocks=$this->request->data('add_stock');
			$mrps=$this->request->data('mrp');
			$sales_rates=$this->request->data('sales_rate');
			$commissionss=$this->request->data('commissions');
			$purchase_rates=$this->request->data('purchase_rate');
			$ready_to_sales=$this->request->data('ready_to_sale');
			$t=0;
	// pr($this->request->data('status')); exit;
			 foreach($statuss as $status){
				
				$itemVariation1 = $this->ItemVariationMasters->ItemVariations->newEntity();
				$itemVariation1->city_id=$city_id;
				$itemVariation1->item_id=$item_id;
				$itemVariation1->section_show='No';
				$itemVariation1->item_variation_master_id=$item_variation_master_ids[$t];
				$itemVariation1->unit_variation_id=$unit_variation_ids[$t];

				
				if($status=='Yes'){
					 $check_count1=$this->ItemVariationMasters->ItemVariations->find()->where(['ItemVariations.city_id'=>$city_id,'ItemVariations.item_id'=>$item_id,'ItemVariations.id'=>$item_variation_master_ids[$t],'ItemVariations.seller_id IS NULL'])->count();

				
					$check_values=$this->ItemVariationMasters->ItemVariations->find()->where(['ItemVariations.city_id'=>$city_id,'ItemVariations.item_id'=>$item_id,'ItemVariations.id'=>$item_variation_master_ids[$t],'ItemVariations.seller_id IS NULL'])->contain(['ItemVariationMasters'])->first();

					 @$updated_id=$check_values->id;
					   
						if(empty($check_count1)){
							if ($this->ItemVariationMasters->ItemVariations->save($itemVariation1)) {
							
							}
						}else{
							$locationItem2=$this->ItemVariationMasters->ItemVariations->get($updated_id);

							
							$locationItem2->item_id=$item_id;
							$locationItem2->maximum_quantity_purchase=$maximum_quantity_purchases[$t];
							$locationItem2->current_stock=$current_stocks[$t];
							//$locationItem2->add_stock=$add_stocks[$t];
							$locationItem2->mrp=$mrps[$t];
							$locationItem2->sales_rate=$sales_rates[$t];
							$locationItem2->commissions=$commissionss[$t];
							$locationItem2->purchase_rate=$purchase_rates[$t];
							$locationItem2->ready_to_sale=$ready_to_sales[$t];
							$locationItem2->section_show=$status;
							$locationItem2->unit_variation_id=$unit_variation_ids[$t];
							$locationItem2->item_variation_master_id=$item_variation_master_ids[$t];
							  
							$this->ItemVariationMasters->ItemVariations->save($locationItem2);
							 
						}
						
						
				}
				$t++;
			 }
			  //$this->Flash->success(__('The item variation master has been added.'));
    		return $this->redirect(['action' => 'index1']);
			 
		}
		$Items=$this->ItemVariationMasters->Items->find('list')->where(['Items.status'=>'Active']);

	
		$paginate_limit=$this->paginate['limit'];
		$this->set(compact('itemVariation','paginate_limit','Items'));
		 
    }
	
    public function index()
    {
		$city_id=$this->Auth->User('city_id');
		$user_id=$this->Auth->User('id');
		$this->viewBuilder()->layout('super_admin_layout');
        $this->paginate = [
            'limit' => 20
        ];
		$itemVariation = $this->ItemVariationMasters->newEntity();
		if ($this->request->is('post')) 
		{
			$item_id=$this->request->data('item_id');
			$item_variation_master_ids=$this->request->data('item_variation_master_id');
			$statuss=$this->request->data('status');
			$unit_variation_ids=$this->request->data('unit_variation_id');
			$SellerItems=$this->ItemVariationMasters->SellerItems->find()->where(['item_id'=>$item_id,'city_id'=>$city_id,'seller_id IS NULL'])->count();
			$item_data=$this->ItemVariationMasters->Items->get($item_id);
			
			
			/*if($SellerItems > 0)
			{
				$query1 = $this->ItemVariationMasters->SellerItems->query();
					  $query1->update()
					  ->set(['category_id' => $item_data->category_id, 'brand_id' => $item_data->brand_id, 'city_id' => $city_id])
					  ->where(['seller_id IS NULL','item_id'=>$item_id,'city_id' => $city_id])
					  ->execute();
			}*/
			echo $item_id.'-'.$SellerItems; exit;
			if(empty($SellerItems))
			{
				$SellerItems1 = $this->ItemVariationMasters->SellerItems->newEntity();
				$SellerItems1->category_id=$item_data->category_id;
				$SellerItems1->item_id=$item_id;
				$SellerItems1->city_id=$city_id;
				$SellerItems1->brand_id=$item_data->brand_id;
				$SellerItems1->created_by=$user_id;
				pr($SellerItems1); exit;
				$dtta=$this->ItemVariationMasters->SellerItems->save($SellerItems1);
				echo $seller_id=$dtta->id;
				exit;
				/* 
				$query = $this->ItemVariationMasters->SellerItems->query();
					$query->insert(['category_id', 'item_id','city_id','brand_id','created_by']);
					$query->values([
						'category_id' => $item_data->category_id,
						'item_id' => $item_id,
						'city_id' => $city_id,
						'brand_id' => $item_data->brand_id,
						'created_by' => $user_id
					]);
					$query->execute(); */
			}
			$t=0;
			 foreach($statuss as $status){
				
				$itemVariation1 = $this->ItemVariationMasters->ItemVariations->newEntity();
				$itemVariation1->city_id=$city_id;
				$itemVariation1->item_id=$item_id;
				$itemVariation1->section_show='No';
				$itemVariation1->item_variation_master_id=$item_variation_master_ids[$t];
				$itemVariation1->unit_variation_id=$unit_variation_ids[$t];
				
				
				if($status=='Yes'){
					$check_count1=$this->ItemVariationMasters->ItemVariations->find()->where(['ItemVariations.city_id'=>$city_id,'ItemVariations.item_id'=>$item_id,'ItemVariations.item_variation_master_id'=>$item_variation_master_ids[$t]])->count();
					$check_values=$this->ItemVariationMasters->ItemVariations->find()->where(['ItemVariations.city_id'=>$city_id,'ItemVariations.item_id'=>$item_id,'ItemVariations.item_variation_master_id'=>$item_variation_master_ids[$t]])->contain(['ItemVariationMasters'])->first();
					@$updated_id=$check_values->id;
					 
						if(empty($check_count1)){  
							if ($this->ItemVariationMasters->ItemVariations->save($itemVariation1)) {
							
							}
						}else{ 

							$locationItem2=$this->ItemVariationMasters->ItemVariations->get($updated_id);

							 
							$locationItem2->item_id=$item_id;
							$locationItem2->section_show='No';
							$locationItem2->unit_variation_id=$unit_variation_ids[$t];
							$locationItem2->item_variation_master_id=$item_variation_master_ids[$t];
							
							$this->ItemVariationMasters->ItemVariations->save($locationItem2);
							 
						}
						
				}
				$t++;
			 }
		    $this->Flash->success(__('The item variation master has been added.'));
    		return $this->redirect(['action' => 'index']);
			 
		}
		$Items=$this->ItemVariationMasters->Items->find('list')->where(['Items.status'=>'Active']);

		$paginate_limit=$this->paginate['limit'];
		$this->set(compact('itemVariation','paginate_limit','Items'));
		 
    }
	public function checking($item_id,$item_variation_master_id){
		 
		$city_id=$this->Auth->User('city_id');
		$check_master_count=$this->ItemVariationMasters->ItemVariations->find()->where(['item_id'=>$item_id,'city_id'=>$city_id,'item_variation_master_id'=>$item_variation_master_id])->count();
		 
		$final1=$check_master_count; 
		   
		$this->response->body($final1);
		return $this->response;
	}
	
	
	public function getItemInfo()
	{
		$city_id=$this->Auth->User('city_id');
		$item_id = $this->request->query('item_id');
		$item = $this->ItemVariationMasters->Items->find()->where(['Items.id'=>@$item_id,'status'=>'Active'])->contain(['ItemVariationMasters'=>['ItemVariations','UnitVariations'=>['Units']]])->first();
		$this->set(compact('item','check_master'));
	}
	
	public function getItemInfo1()
	{
		$city_id=$this->Auth->User('city_id');
		$item_id = $this->request->query('item_id');
		$item = $this->ItemVariationMasters->ItemVariations->find()->where(['ItemVariations.item_id'=>@$item_id,'ItemVariations.seller_id IS NULL','ItemVariations.city_id'=>$city_id])->contain(['Items','UnitVariations'=>['Units']]);

		$this->set(compact('item','check_master'));
	}
    /**
     * View method
     *
     * @param string|null $id Item Variation Master id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $itemVariationMaster = $this->ItemVariationMasters->get($id, [
            'contain' => ['Items', 'UnitVariations']
        ]);

        $this->set('itemVariationMaster', $itemVariationMaster);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $itemVariationMaster = $this->ItemVariationMasters->newEntity();
        if ($this->request->is('post')) {
            $itemVariationMaster = $this->ItemVariationMasters->patchEntity($itemVariationMaster, $this->request->getData());
            if ($this->ItemVariationMasters->save($itemVariationMaster)) {
                $this->Flash->success(__('The item variation master has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The item variation master could not be saved. Please, try again.'));
        }
        $items = $this->ItemVariationMasters->Items->find('list', ['limit' => 200]);
        $unitVariations = $this->ItemVariationMasters->UnitVariations->find('list', ['limit' => 200]);
        $this->set(compact('itemVariationMaster', 'items', 'unitVariations'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Item Variation Master id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $itemVariationMaster = $this->ItemVariationMasters->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $itemVariationMaster = $this->ItemVariationMasters->patchEntity($itemVariationMaster, $this->request->getData());
            if ($this->ItemVariationMasters->save($itemVariationMaster)) {
                $this->Flash->success(__('The item variation master has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The item variation master could not be saved. Please, try again.'));
        }
        $items = $this->ItemVariationMasters->Items->find('list', ['limit' => 200]);
        $unitVariations = $this->ItemVariationMasters->UnitVariations->find('list', ['limit' => 200]);
        $this->set(compact('itemVariationMaster', 'items', 'unitVariations'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Item Variation Master id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $itemVariationMaster = $this->ItemVariationMasters->get($id);
        if ($this->ItemVariationMasters->delete($itemVariationMaster)) {
            $this->Flash->success(__('The item variation master has been deleted.'));
        } else {
            $this->Flash->error(__('The item variation master could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
