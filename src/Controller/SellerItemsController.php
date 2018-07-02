<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\View\View;
/**
 * SellerItems Controller
 *
 * @property \App\Model\Table\SellerItemsTable $SellerItems
 *
 * @method \App\Model\Entity\SellerItem[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SellerItemsController extends AppController
{

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Security->setConfig('unlockedActions', ['add','itemVariation','sellerItemApproval']);

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
		$location_id=$this->Auth->User('location_id'); 
		$this->viewBuilder()->layout('admin_portal');
        $this->paginate = [
			'contain' => ['Items', 'Sellers','Categories'],
			'limit' => 20
        ];
		
	/* 	if ($this->request->is(['get'])){
			$search=$this->request->getQuery('search');
			$SellerItems->where([
							'OR' => [
									'Categories.name LIKE' => $search.'%',
									'Items.link_name LIKE' => $search.'%',
									'commission_percentage.link_name LIKE' => $search.'%',
									'commission_created_on.link_name LIKE' => $search.'%',
									'expiry_on_date.link_name LIKE' => $search.'%',
									'Sellers.status LIKE' => $search.'%'
							]
			]);
		} */
		
        $SellerItems = $this->SellerItems->find();
        $SellerItems = $this->paginate($this->SellerItems);
		$paginate_limit=$this->paginate['limit'];
        $this->set(compact('SellerItems','paginate_limit'));
    }

    /**
     * View method
     *
     * @param string|null $id Seller Item id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $sellerItem = $this->SellerItems->get($id, [
            'contain' => ['Items', 'Sellers', 'SellerItemVariations']
        ]);

        $this->set('sellerItem', $sellerItem);
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
		//$location_id=$this->Auth->User('location_id');
		$this->viewBuilder()->layout('super_admin_layout');
        $sellerItem = $this->SellerItems->newEntity();
        if ($this->request->is('post')) {
			//pr($this->request->getData()); exit;
			$commissions=$this->request->getData('commissions');
			$brand_id=$this->request->getData('brand_id');
			$item_ids=$this->request->getData('item_ids'); 
			$category_ids=$this->request->getData('category_ids'); 
			$ids=$this->request->getData('ids'); 
			$seller_id=$this->request->getData('seller_id');
			//pr($this->request->getData());
			//exit;
			$total_rows = sizeof($item_ids);
			$seller_records = $this->SellerItems->find()->where(['seller_id'=>$seller_id]);
			
			if(sizeof($seller_records)>0)
			{ 
				if(!empty($item_ids))
				{   
					foreach($seller_records as $seller_record)
					{
						
						if(!in_array(@$seller_record->item_id,@$item_ids))
						{
							//$sr=$this->SellerItems->get($seller_record->id);
							//$this->SellerItems->delete($sr);
							$query1 = $this->SellerItems->query();
							  $query1->update()
							  ->set(['status' =>'Deactive'])
							  ->where(['seller_id'=>$seller_id,'item_id'=>$seller_record->id])
							  ->execute();
						}
						
					}
				}
			}
			
			for($i=0; $i<$total_rows; $i++)
			{
				
				$isExist = $this->SellerItems->find()->where(['seller_id'=>$seller_id,'item_id'=>$item_ids[$i]])->count();
				
				if($isExist>0)
				{
					$query1 = $this->SellerItems->query();
					  $query1->update()
					  ->set(['commission_percentage' =>$commissions[$i], 'brand_id' => $brand_id[$i]])
					  ->where(['seller_id'=>$seller_id,'item_id'=>$item_ids[$i]])
					  ->execute();
					  
				}
				else
				{ 
					$query = $this->SellerItems->query();
					$query->insert(['seller_id','category_id', 'item_id','commission_percentage','city_id','brand_id']);
					$query->values([
						'seller_id' => $seller_id,
						'category_id' => $category_ids[$i],
						'item_id' => $item_ids[$i],
						'commission_percentage' => $commissions[$i],
						'city_id' => $city_id,
						'brand_id' => @$brand_id[$i]
					]);
					$query->execute();
					
				}
				
			}
            if($i!=0)
			{
				$this->Flash->success(__('The seller item has been saved.'));
				return $this->redirect(['action' => 'add']);
			}
			
        }
        $categories = $this->SellerItems->Categories->find('threaded')->where(['Categories.city_id'=>$city_id])->contain(['Items']);
		
        $sellers = $this->SellerItems->Sellers->find('list');
        $this->set(compact('sellerItem', 'categories', 'sellers'));
    }
	public function itemVariation()
    {
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id'); 
		$user_type=$this->Auth->User('user_type');
		//$location_id=$this->Auth->User('location_id');
		$this->viewBuilder()->layout('seller_layout');
        $itemVariation = $this->SellerItems->ItemVariations->newEntity();
        if ($this->request->is('post')) 
		{
			$masterIds=[];$ItemIds=[];
			$arr=$this->request->getData(); $i=1; 
         	
			foreach($arr as $key => $csm)
			{
				
				$SellerItemdata=$this->SellerItems->find()->where(['seller_id'=>$user_id, 'item_id'=>$arr[$key]['item_id']])->toArray();
				//$masterIds[$arr[$key]['item_id']][]=$csm['item_variation_master_id'];
				//$ItemIds[]=$arr[$key]['item_id'];
				
				$is_exist = $this->SellerItems->ItemVariations->find()->where(['seller_id'=>$user_id, 'item_id'=>@$arr[@$key]['item_id'],'item_variation_master_id'=>$arr[$key]['item_variation_master_id']])->count();
				if($is_exist>0)
				{ 
					$query1 = $this->SellerItems->ItemVariations->query();
					  $query1->update()
					  ->set(['maximum_quantity_purchase' =>$csm['maximum_quantity_purchase'],'current_stock'=>$csm['current_stock'],'add_stock'=>$csm['add_stock'],'purchase_rate'=>$csm['purchase_rate'],'sales_rate'=>$csm['sales_rate'],'mrp'=>$csm['mrp'],'ready_to_sale'=>$csm['ready_to_sale']])
					  ->where(['seller_id'=>$user_id,'item_id'=>$arr[$key]['item_id'],'item_variation_master_id'=>$csm['item_variation_master_id']])
					  ->execute();
					  unset($arr[$key]);
				}
				else{
					$arr[$key]['seller_id']  = $user_id;
					$arr[$key]['city_id']  = $city_id;
					$arr[$key]['commission'] = $SellerItemdata[0]->commission_percentage;
					$arr[$key]['seller_item_id'] = $SellerItemdata[0]->id;
				}
				
				$i++;
			}

			/* $is_exist_items = $this->SellerItems->ItemVariations->find()->where(['seller_id'=>$user_id]);
			if(sizeof($is_exist_items)>0)
			{
					foreach($is_exist_items as $is_exist_item)
					{
						if(!in_array($is_exist_item->item_id,$ItemIds))
						{
							$query1 = $this->SellerItems->ItemVariations->query();
							  $query1->update()
							  ->set(['status' =>'Deactive'])
							  ->where(['seller_id'=>$user_id,'item_id'=>$is_exist_item->item_id])
							  ->execute();
						}
					}
			} */
			
			//pr($masterIds);exit;
			/* foreach($masterIds as $key => $masterId)
			{
				$Item_variations = $this->SellerItems->ItemVariations->find()->where(['seller_id'=>$user_id, 'item_id'=>$key]);
				if(sizeof($Item_variations)>0)
				{
					foreach($Item_variations as $Item_variation)
					{
						if(!in_array($Item_variation->item_variation_master_id,$masterId))
						{
							$query1 = $this->SellerItems->ItemVariations->query();
							  $query1->update()
							  ->set(['status' =>'Deactive'])
							  ->where(['seller_id'=>$user_id,'item_variation_master_id'=>$Item_variation->item_variation_master_id])
							  ->execute();
						}
						
					}
				}
			} */
			if(sizeof($arr)>0)
			{ 
			$itemVariation = $this->SellerItems->ItemVariations->newEntities(array_values($arr));
			
				if ($this->SellerItems->ItemVariations->saveMany($itemVariation)) {
					$this->Flash->success(__('The seller item has been saved.'));

					return $this->redirect(['action' => 'itemVariation']);
				} 
				
				$this->Flash->error(__('The seller item could not be saved. Please, try again.'));
			}
        }
		
		$sellerItems = $this->SellerItems->find()
							->where(['SellerItems.seller_id'=>$user_id]);
		$sellerItemCommision=[];						
		$seller_item=[];						
		foreach($sellerItems as $sellerItem)
		{
			$seller_item[] = $sellerItem->item_id;
			$sellerItemCommision[$sellerItem->item_id]  = $sellerItem->commission_percentage;
		}
		
		/*$categories = $this->SellerItems->Categories->find('threaded');
							$categories->select(['total_item'=>$categories->func()->count('Items.id')])
							->innerJoinWith('Items',function($q) use($user_id,$seller_item){
									return $q->where(['Items.id IN'=>$seller_item]);
							})
							->contain(['Items'=>function($q) use($user_id,$seller_item){
								return $q->where(['Items.id IN'=>$seller_item])->contain(['ItemVariationMasters'=>['ItemVariations','UnitVariations'=>['Units']]]);
							}
							])
							->group(['Categories.id'])
							->autoFields(true);*/
		if(empty(!$seller_item))	
		{			
		$categories = $this->SellerItems->Categories->find('threaded');
						$categories->innerJoinWith('Items',function($q) use($seller_item){
								return $q->where(['Items.id IN'=>$seller_item]);

							})
						->contain(['Items'=>function($q) use($seller_item){
							return $q->where(['Items.id IN'=>$seller_item]);
						}
						])
						->group(['Categories.id'])
						->autoFields(true);
		}
		else
		{
			$categories=[];
		}
        $this->set(compact('itemVariation', 'categories','sellerItemCommision'));
    }
    /**
     * Edit method
     *
     * @param string|null $id Seller Item id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $sellerItem = $this->SellerItems->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $sellerItem = $this->SellerItems->patchEntity($sellerItem, $this->request->getData());
            if ($this->SellerItems->save($sellerItem)) {
                $this->Flash->success(__('The seller item has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The seller item could not be saved. Please, try again.'));
        }
        $items = $this->SellerItems->Items->find('list', ['limit' => 200]);
        $categories = $this->SellerItems->Categories->find('list', ['limit' => 200]);
        $sellers = $this->SellerItems->Sellers->find('list', ['limit' => 200]);
        $this->set(compact('sellerItem', 'items', 'categories', 'sellers'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Seller Item id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $sellerItem = $this->SellerItems->get($id);
        if ($this->SellerItems->delete($sellerItem)) {
            $this->Flash->success(__('The seller item has been deleted.'));
        } else {
            $this->Flash->error(__('The seller item could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
	
	public function getSellerItems()
	{
		$seller_id= $this->request->query('id');
		$categories = $this->SellerItems->Categories->find('threaded')->contain(['Items'=>['SellerItems'=>function ($q) use($seller_id){return $q->where(['SellerItems.seller_id'=>@$seller_id]);}]]);
		
		$this->set(compact('getSellerItems','categories'));
	}
	public function sellerItemApproval()
	{
		$sellerItemApproval = $this->SellerItems->newEntity();
		$user_type=$this->Auth->User('user_type'); 
		if($user_type=="Super Admin"){
		$this->viewBuilder()->layout('super_admin_layout');
		}else{
		$this->viewBuilder()->layout('admin_portal');
		}
		//$this->viewBuilder()->layout('admin_portal');
		$sellers = $this->SellerItems->Sellers->find('list')->where(['Sellers.status'=>'Active']);
		if ($this->request->is('post')) {
			$seller_id=$this->request->getData('seller_id'); 
			$ids=$this->request->getData('ids'); 
			$status=$this->request->getData('status');
			$i=0;
			foreach($ids as $id)
			{
				$query = $this->SellerItems->ItemVariations->query();
						  $query->update()
						  ->set(['status' => @$status[@$id]])
						  ->where(['seller_id'=>$seller_id,'id'=>$id])
						  ->execute();
				$i++;
			}
			
			if($i>0)
			{
				$this->Flash->success(__('The seller item has been approved.'));	
				return $this->redirect(['action' => 'sellerItemApproval']);
			}
        }
		$this->set(compact('sellers','sellerItemApproval'));
	}
	public function getItemInfo()
	{
		$user_id=$this->Auth->User('id');
		$item_id = $this->request->query('item_id');
		$item = $this->SellerItems->Items->find()->where(['Items.id'=>@$item_id])->contain(['SellerItems'=>function($q) use($user_id,$item_id){
				return $q->where(['SellerItems.seller_id'=>$user_id,'SellerItems.item_id'=>@$item_id]);
		},'ItemVariationMasters'=>['ItemVariations'=>function($q) use($user_id,$item_id){
				return $q->where(['ItemVariations.seller_id'=>$user_id,'ItemVariations.item_id'=>@$item_id]);
		},'UnitVariations'=>['Units']]])->first();
		
		$this->set(compact('item'));
	}
	public function getItemVariationDetail()
	{
		$seller_id= $this->request->query('seller_id');
		$itemVariations = $this->SellerItems->ItemVariations->find()->contain(['Items','UnitVariations'=>['Units']])->where(['ItemVariations.seller_id'=>$seller_id]);
		
		$this->set(compact('itemVariations'));
	}
}
