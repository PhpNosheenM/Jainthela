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
			// pr($this->request->data()); exit;
			$item_id=$this->request->data('item_id');
			$item_variation_master_ids=$this->request->data('item_variation_master_id');
			$statuss=$this->request->data('status');
			$unit_variation_ids=$this->request->data('unit_variation_id');
			$maximum_quantity_purchases=$this->request->data('maximum_quantity_purchase');
			$current_stocks=$this->request->data('current_stock');
			$print_rates=$this->request->data('print_rate');
			$discount_pers=$this->request->data('discount_per');
			$virtual_stocks=$this->request->data('virtual_stock');
			//$add_stocks=$this->request->data('add_stock');
			$mrps=$this->request->data('mrp');
			$sales_rates=$this->request->data('sales_rate');
			$commissionss=$this->request->data('commissions');
			$purchase_rates=$this->request->data('purchase_rate');
			$ready_to_sales=$this->request->data('ready_to_sale');
			$out_of_stock=$this->request->data('out_of_stock');
			//$Itemstatus=$this->request->data('Itemstatus');
			$t=0;
			
			 foreach($statuss as $status){
				
				$itemVariation1 = $this->ItemVariationMasters->ItemVariations->newEntity();
				$itemVariation1->city_id=$city_id;
				$itemVariation1->item_id=$item_id;
				$itemVariation1->section_show='No';
				$itemVariation1->unit_variation_id=$unit_variation_ids[$t];
				
				if($status=='Yes'){
					 $check_count1=$this->ItemVariationMasters->ItemVariations->find()->where(['ItemVariations.city_id'=>$city_id,'ItemVariations.item_id'=>$item_id,'ItemVariations.id'=>$item_variation_master_ids[$t],'ItemVariations.seller_id IS NULL'])->count();
						
				
					$check_values=$this->ItemVariationMasters->ItemVariations->find()->where(['ItemVariations.city_id'=>$city_id,'ItemVariations.item_id'=>$item_id,'ItemVariations.id'=>$item_variation_master_ids[$t],'ItemVariations.seller_id IS NULL'])->contain(['ItemVariationMasters'])->first();
				//	pr($check_values); exit;
					 @$updated_id=$check_values->id;
					   
						if(empty($check_count1)){ 
							$itemVariation1->item_variation_master_id=$check_values->item_variation_master_id;
							if ($this->ItemVariationMasters->ItemVariations->save($itemVariation1)) {
							
							}
						}else{ 
							$locationItem2=$this->ItemVariationMasters->ItemVariations->get($updated_id);
							//pr($virtual_stocks[$t]); exit;
							
							$locationItem2->item_id=$item_id;
							$locationItem2->maximum_quantity_purchase=$maximum_quantity_purchases[$t];
							$locationItem2->current_stock=$current_stocks[$t];
							$locationItem2->virtual_stock=$virtual_stocks[$t];
							$locationItem2->print_rate=$print_rates[$t];
							$locationItem2->discount_per=$discount_pers[$t];
							//$locationItem2->add_stock=$add_stocks[$t];
							$locationItem2->mrp=$mrps[$t];
							$locationItem2->sales_rate=$sales_rates[$t];
							$locationItem2->commissions=$commissionss[$t];
							$locationItem2->purchase_rate=$purchase_rates[$t];
							$locationItem2->ready_to_sale=$ready_to_sales[$t];
							$locationItem2->out_of_stock=$out_of_stock[$t];
							if($ready_to_sales[$t]=="No"){
								$locationItem2->status="Deactive";
							}else{
								$locationItem2->status="Active";
							}
							//$locationItem2->status=$Itemstatus[$t];
							$locationItem2->section_show=$status;
							$locationItem2->unit_variation_id=$unit_variation_ids[$t];
							$itemVariation1->item_variation_master_id=$check_values->item_variation_master_id;
							//$locationItem2->item_variation_master_id=$item_variation_master_ids[$t];
							/* if($locationItem2->current_stock > 0 || $locationItem2->virtual_stock > 0){
								$locationItem2->out_of_stock="No";
							} */
							$this->ItemVariationMasters->ItemVariations->save($locationItem2);
							$ItemVariationExist=$this->ItemVariationMasters->ItemVariations->find()->where(['item_variation_master_id'=>$check_values->item_variation_master_id,'ready_to_sale'=>'Yes','status' =>'Active'])->toArray();
							$arrSize=sizeof($ItemVariationExist);
							if($arrSize > 0){ 
								$query1 = $this->ItemVariationMasters->query();
								$query1->update()
								->set(['status' =>'Active'])
								->where(['id'=>$check_values->item_variation_master_id])
								->execute();
							}
							
							if($ready_to_sales[$t]=="No"){
								$ItemVariationExist1=$this->ItemVariationMasters->ItemVariations->find()->where(['item_variation_master_id'=>$check_values->item_variation_master_id,'ready_to_sale'=>'Yes','ready_to_sale'=>'Active'])->toArray();
								$arrSize1=sizeof($ItemVariationExist1);
								if($arrSize1 == 0){ 
									$query1 = $this->ItemVariationMasters->query();
									$query1->update()
									->set(['status' =>'Deactive'])
									->where(['id'=>$check_values->item_variation_master_id])
									->execute();
								}
								$query1 = $this->ItemVariationMasters->ItemVariations->query();
								$query1->update()
								->set(['status' =>'Deactive'])
								->where(['id'=>$updated_id])
								->execute();
							}
							
							$ItemVariationExist2=$this->ItemVariationMasters->ItemVariations->find()->where(['item_id'=>$item_id,'ready_to_sale'=>'Yes','status'=>'Active'])->toArray();
							$totSize=sizeof($ItemVariationExist2);
								if($totSize == 0){ 
									$query1 = $this->ItemVariationMasters->SellerItems->query();
									$query1->update()
									->set(['status' =>'Deactive'])
									->where(['item_id'=>$item_id])
									->execute();
								}else{
									$query1 = $this->ItemVariationMasters->SellerItems->query();
									$query1->update()
									->set(['status' =>'Active'])
									->where(['item_id'=>$item_id])
									->execute();
								}
							
							
							 
						}
						
						
				}
				$t++;
			 }
			  
			$ItemAvail=$this->ItemVariationMasters->ItemVariations->find()->where(['ready_to_sale'=>'Yes','item_id'=>$item_id])->toArray();
			$itemSize=sizeof($ItemAvail);
			
			if($itemSize==0){
				$query1 = $this->ItemVariationMasters->Items->query();
				$query1->update()
				->set(['status' =>'Deactive'])
				->where(['id'=>$item_id])
				->execute();
				$query1 = $this->ItemVariationMasters->SellerItems->query();
				$query1->update()
				->set(['status' =>'Deactive'])
				->where(['seller_id IS NULL','item_id'=>@$main_item_id])
				->execute();
			}else{
				$query1 = $this->ItemVariationMasters->Items->query();
				$query1->update()
				->set(['status' =>'Active'])
				->where(['id'=>$item_id])
				->execute();
				$query1 = $this->ItemVariationMasters->SellerItems->query();
				$query1->update()
				->set(['status' =>'Active'])
				->where(['seller_id IS NULL','item_id'=>@$main_item_id])
				->execute();
			}
			
			  //$this->Flash->success(__('The item variation master has been added.'));
    		return $this->redirect(['action' => 'index1']);
			 
		}
		

		$Items=$this->ItemVariationMasters->Items->find('list')
		->where(['Items.city_id'=>$city_id])
		->order(['Items.name' => 'ASC']);

		//$Items=$this->ItemVariationMasters->ItemVariations->find()->where(['ItemVariations.city_id'=>$city_id,'ItemVariations.seller_id IS'=>'NULL']);
		//pr($Items->toArray()); exit;
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
			if(empty($SellerItems))
			{ 
				/* $query = $this->ItemVariationMasters->SellerItems->query();
					$query->insert(['category_id', 'item_id','city_id','brand_id','created_by']);
					$query->values([
						'category_id' => $item_data->category_id,
						'item_id' => $item_id,
						'city_id' => $city_id,
						'brand_id' => $item_data->brand_id,
						'created_by' => $user_id
					]);
					$query->execute(); */
					
				$SellerItems1 = $this->ItemVariationMasters->SellerItems->newEntity();
				$SellerItems1->category_id=$item_data->category_id;
				$SellerItems1->item_id=$item_id;
				$SellerItems1->city_id=$city_id;
				$SellerItems1->brand_id=$item_data->brand_id;
				$SellerItems1->created_by=$user_id;
				$SellerItems1->status='Deactive';
				
				$dtta=$this->ItemVariationMasters->SellerItems->save($SellerItems1);
				
				$seller_item_id=$dtta->id;
			}
			else{ 
				$SellerItems=$this->ItemVariationMasters->SellerItems->find()->where(['item_id'=>$item_id,'city_id'=>$city_id,'seller_id IS NULL'])->first();
				$seller_item_id=$SellerItems->id;
			}
			$t=0;
			 foreach($statuss as $status){
				
				$itemVariation1 = $this->ItemVariationMasters->ItemVariations->newEntity();
				$itemVariation1->city_id=$city_id;
				$itemVariation1->item_id=$item_id;
				$itemVariation1->section_show='Yes';
				$itemVariation1->item_variation_master_id=$item_variation_master_ids[$t];
				$itemVariation1->unit_variation_id=$unit_variation_ids[$t];
				
				
				if($status=='Yes'){
					$check_count1=$this->ItemVariationMasters->ItemVariations->find()->where(['ItemVariations.city_id'=>$city_id,'ItemVariations.item_id'=>$item_id,'ItemVariations.item_variation_master_id'=>$item_variation_master_ids[$t],'seller_id IS NULL'])->count();
					$check_values=$this->ItemVariationMasters->ItemVariations->find()->where(['ItemVariations.city_id'=>$city_id,'ItemVariations.item_id'=>$item_id,'ItemVariations.item_variation_master_id'=>$item_variation_master_ids[$t],'seller_id IS NULL'])->contain(['ItemVariationMasters'])->first();
					@$updated_id=$check_values->id;
					 
						if(empty($check_count1)){ 
						 	$itemVariation1->seller_item_id=$seller_item_id;
							if ($this->ItemVariationMasters->ItemVariations->save($itemVariation1)) {
							
							}
						}else{ 

							$locationItem2=$this->ItemVariationMasters->ItemVariations->get($updated_id);

							 
							$locationItem2->item_id=$item_id;
							$locationItem2->section_show='Yes';
							$locationItem2->unit_variation_id=$unit_variation_ids[$t];
							$locationItem2->item_variation_master_id=$item_variation_master_ids[$t];
							
							$this->ItemVariationMasters->ItemVariations->save($locationItem2);
							 
						}
						
				}
				$t++;
			 }
			
			 
			 
		    $this->Flash->success(__('The item variation master has been added.'));
    		return $this->redirect(['action' => 'index1']);
			 
		}
		

		$ItemsData=$this->ItemVariationMasters->Items->find()->where(['Items.city_id'=>$city_id])
			->where(['Items.category_id !=' =>1])
			->where(['Items.category_id !=' =>2])
			->where(['Items.category_id !=' =>6])
			->where(['Items.category_id !=' =>7])
			->where(['Items.category_id !=' =>9])
			->where(['Items.category_id !=' =>55]);
			
		$Items=[];
		foreach($ItemsData as $data){
			$query1 = $this->ItemVariationMasters->find()->where(['item_id'=>$data->id]);
			$query1->select([
				'count1' => $query1->func()->count('id')
			]);
			
			$query2 = $this->ItemVariationMasters->ItemVariations->find()->where(['item_id'=>$data->id,'seller_id IS NULL']);
			$query2->select([
				'count2' => $query2->func()->count('id')
			]);
			
			$ItemVariationMastersQty=$query1->toArray()[0]->count1;
			$ItemVariationsQty=$query2->toArray()[0]->count2;
			if($ItemVariationMastersQty > $ItemVariationsQty){
				$Items[]=['text'=>$data->name,'value'=>$data->id];
			}
			
			
		}//pr($Items); exit;
		
		$paginate_limit=$this->paginate['limit'];
		$this->set(compact('itemVariation','paginate_limit','Items'));
		 
    }
	public function checking($item_id,$item_variation_master_id){
		 
		$city_id=$this->Auth->User('city_id');
		$check_master_count=$this->ItemVariationMasters->ItemVariations->find()->where(['item_id'=>$item_id,'city_id'=>$city_id,'item_variation_master_id'=>$item_variation_master_id,'seller_id IS NULL'])->count();
		 
		$final1=$check_master_count; 
		   
		$this->response->body($final1);
		return $this->response;
	}
	
	
	public function getItemInfo()
	{
		$city_id=$this->Auth->User('city_id');
		$item_id = $this->request->query('item_id');
		$item = $this->ItemVariationMasters->Items->find()->where(['Items.id'=>@$item_id])->contain(['ItemVariationMasters'=>['ItemVariations','UnitVariations'=>['Units']]])->first();
		//pr($item); exit;
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
