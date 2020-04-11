<?php
namespace App\Controller;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\View\View;

/**
 * Items Controller
 *
 * @property \App\Model\Table\ItemsTable $Items
 *
 * @method \App\Model\Entity\Item[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ItemsController extends AppController
{
	public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
         $this->Security->setConfig('unlockedActions', ['add','edit','stockReport','wastageReport','mangeItem','manageOutOfStockItem','itemManageScreens','brandWiseDiscount','categoryWiseDiscount','itemWiseRate']);

    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
	 public function index1()
    {
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id');
		$this->viewBuilder()->layout('super_admin_layout');
        $this->paginate = [
            'contain' => ['Categories', 'Brands']
        ];

		$items = $this->Items->find()->where(['Items.city_id'=>$city_id]);
		$status=$this->request->query('status');
		if ($this->request->is(['get'])){
			$search=$this->request->getQuery('search');
			$items->where([
							'OR' => [
									'Items.name LIKE' => $search.'%',
									'Items.alias_name LIKE' => $search.'%',
									'Categories.name LIKE' => $search.'%',
									'Brands.name LIKE' => $search.'%',
									'Items.status LIKE' => $search.'%',
									'Items.minimum_stock ' => $search.'%'
							]
			]);
		}
        $items = $this->paginate($items);

		$paginate_limit=$this->paginate['limit'];
        $this->set(compact('items','paginate_limit'));
    }
	
	 public function DefaultUnitUpdate(){
		$Sellertem=$this->Items->find()->contain(['ItemVariations'=>['UnitVariations']]);
		foreach($Sellertem as $data){
			if(@$defUnit=$data->item_variations[0]){
				$defUnit=$data->item_variations[0]->unit_variation->unit_id;
				$query1 = $this->Items->query();
				$query1->update()
				->set(['default_unit_id' =>$defUnit])
				->where(['id'=>$data->id])
				->execute();
			}
		}
		exit;
	 }
	
    public function SelectItemVariation($id = null,$unit_variation_id = null){
			$Sellertem=$this->Items->ItemVariations->find()->contain(['Items','UnitVariations'=>['Units']])->where(['ItemVariations.item_id'=>$id,'ItemVariations.seller_id IS NULL','ItemVariations.ready_to_sale'=>'Yes']);
			$items=array();
			foreach($Sellertem as $data){
				//pr(@$data); 
				$merge=@$data->unit_variation->quantity_variation.'.'.@$data->unit_variation->unit->shortname.'('.@$data->sales_rate.'.'.'Rs'.')';
				$merge=@$data->unit_variation->visible_variation;
				$selected=($unit_variation_id==$data->unit_variation->id)?'selected':'';
				$items[]=['text' => $merge,'value' => $data->unit_variation->id,'item_id'=>$data->item->id,'unit'=>@$data->item->item_variations[0]->unit_variation->unit->shortname,'gst_figure_id'=>$data->item->gst_figure_id,$selected];
			}
			$this->set(compact('items'));
			//pr($items); exit;
	}
    public function itemManageScreens(){
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id');
		$user_type=$this->Auth->User('user_type');
		$this->viewBuilder()->layout('super_admin_layout');
		
		$this->set(compact('items','paginate_limit','itemList'));
	}
	
    public function materialIndentReport(){
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id');
		$user_type=$this->Auth->User('user_type');
		if($user_type=="Super Admin"){
			$this->viewBuilder()->layout('super_admin_layout');
		}else{
			$this->viewBuilder()->layout('seller_layout');
		}
		$itemList=$this->Items->ItemVariations->find()->where(['ItemVariations.city_id '=>$city_id,'ItemVariations.seller_id IS NULL','demand_stock > ' =>0])->contain(['Items','UnitVariations'=>['Units']]);
		$showItem=[];
		foreach($itemList as $data){
			if($data->item->item_maintain_by == "itemwise"){
				$allItemVariations= $this->Items->ItemVariations->find()->where(['ItemVariations.item_id'=>$data->item_id,'ItemVariations.city_id'=>@$city_id])->contain(['UnitVariations'=>['Units']])->first();
				//$p=($allItemVariations->unit_variation->convert_unit_qty*$data->demand_stock); 
				//pr($data->unit_variation->unit->unit_name); exit;
				$addQty=($data->unit_variation->convert_unit_qty*$data->demand_stock)/$allItemVariations->unit_variation->unit->division_factor;$showItem[$data->item_id]=['qt'=>$addQty,'name'=>$data->item->name,'unit'=>$data->unit_variation->unit->unit_name];
			}else{
				$showItem[$data->item_id]=['qt'=>$data->demand_stock,'name'=>$data->item->name,'unit'=>$data->unit_variation->unit->unit_name];
			}
		}
		$this->set(compact('items','paginate_limit','itemList','showItem'));
	}
    public function itemWiseRate()
    {
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id');
		$user_type=$this->Auth->User('user_type');
		if($user_type=="Super Admin"){
			$this->viewBuilder()->layout('super_admin_layout');
		}else{
			$this->viewBuilder()->layout('seller_layout');
		} 
		$category = $this->request->query('category');
		$itemid = $this->request->query('item');
		//$category=$this->request->qwery('category');
		
		if($itemid > 0){
		$itemList=$this->Items->ItemVariations->find()
			->innerJoinWith('UnitVariations')
			->innerJoinWith('ItemVariationMasters')
			->innerJoinWith('Items')
			->order(['Items.name'=>'ASC'])
			->select([
				'item_name'=>'Items.name',
				'item_var_id'=>'ItemVariations.id',
				'mrp'=>'ItemVariations.mrp',
				'print_rate'=>'ItemVariations.print_rate',
				'discount_per'=>'ItemVariations.discount_per',
				'sales_rate'=>'ItemVariations.sales_rate',
				'ready_to_sale'=>'ItemVariations.ready_to_sale',
				'visible_variation'=>'UnitVariations.visible_variation',
			])
			->where(['ItemVariations.city_id'=>$city_id,'Items.id'=>$itemid,'ItemVariationMasters.status'=>'Active']);
			
		}else{
			$itemList=$this->Items->ItemVariations->find()
			->innerJoinWith('UnitVariations')
			->innerJoinWith('ItemVariationMasters')
			->innerJoinWith('Items')
			->order(['Items.name'=>'ASC'])
			->select([
				'item_name'=>'Items.name',
				'item_var_id'=>'ItemVariations.id',
				'mrp'=>'ItemVariations.mrp',
				'print_rate'=>'ItemVariations.print_rate',
				'discount_per'=>'ItemVariations.discount_per',
				'sales_rate'=>'ItemVariations.sales_rate',
				'ready_to_sale'=>'ItemVariations.ready_to_sale',
				'visible_variation'=>'UnitVariations.visible_variation',
			])
			->where(['ItemVariations.city_id'=>$city_id,'Items.category_id'=>$category,'ItemVariationMasters.status'=>'Active']);
		}
		//pr($itemList->toArray()); exit;
		
	/* 	$itemList=$this->Items->ItemVariations->find()->where(['ItemVariations.city_id '=>$city_id])->contain(['UnitVariations'=>['Units'],'Items' => function($q) use($category) {
			return $q->where(['category_id'=>$category]);
		}
		]); */
		
		if ($this->request->is(['get'])){
			$category=$this->request->getQuery('category');
			$itemList->where([
							'OR' => [
									'Items.category_id LIKE' => $category.'%',
									'Items.id LIKE' => $itemid.'%'
							]
			]);
		}
		
		 if ($this->request->is(['patch', 'post', 'put'])) { 
			 $item = $this->request->getData()['item_variations'];
			 foreach($item as $data){ 
				if($data['ready_to_sale']=="Yes"){
					$status="Active";
					$outOfStock="No";
				}else{
					$status="Deactive";
					$outOfStock="Yes";
				}
				$IV=$this->Items->ItemVariations->get($data['id']);
				
				$pr=0;
				if($data['print_rate']==$data['sales_rate']){
					$pr=0;
				}else{
					$pr=$data['print_rate'];
				}
				
				$query1 = $this->Items->ItemVariations->query();
							  $query1->update()
							  ->set(['mrp' =>$data['mrp'],'print_rate' =>$pr,'discount_per' =>$data['discount_per'],'sales_rate' =>$data['sales_rate'],'ready_to_sale' =>$data['ready_to_sale'],'status' =>$status,'out_of_stock' =>$outOfStock])
							  ->where(['id'=>$data['id']])
				->execute();
				
				$itemData=$this->Items->ItemVariations->find()->where(['ItemVariations.item_id'=>$IV->item_id,'ItemVariations.ready_to_sale'=>"Yes",'ItemVariations.status'=>'Active'])->toArray();
				
				
				if(sizeof($itemData)==0){
					$query2 = $this->Items->SellerItems->query();
							  $query2->update()
							  ->set(['status' =>"Deactive"])
							  ->where(['SellerItems.item_id'=>$IV->item_id])
					->execute();
					$this->Items->ItemVariations->Carts->deleteAll(['Carts.item_variation_id'=>$data['id']]);
				}else{
					$query2 = $this->Items->SellerItems->query();
							  $query2->update()
							  ->set(['status' =>"Active"])
							  ->where(['SellerItems.item_id'=>$IV->item_id])
					->execute();
				}
				
			}
		 }
		
		$Categories=$this->Items->Categories->find()->order(['name'=>'ASC']);
		$Allcategory=[];
		foreach($Categories as $data){
			$AccountGroupsexists = $this->Items->Categories->exists(['Categories.parent_id' => $data->id]);
		
			if(!$AccountGroupsexists){
				$Allcategory[]=['text'=>$data->name,'value'=>$data->id];
			}
		}
		$ItemsData=$this->Items->find('list')->order(['name'=>'ASC']);
		
		
		
		$this->set(compact('items','paginate_limit','itemList','Allcategory','category','ItemsData','itemid'));
	}
		public function mangeItem()
    {
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id');
		$user_type=$this->Auth->User('user_type');
		if($user_type=="Super Admin"){
			$this->viewBuilder()->layout('super_admin_layout');
		}else{
			$this->viewBuilder()->layout('seller_layout');
		} 
	//	$this->viewBuilder()->layout('super_admin_layout');
        $this->paginate = [
            'contain' => ['Categories', 'Brands'],
			'limit' => 20
        ];
		//exit;
        if ($this->request->is(['patch', 'post', 'put'])) { 
			 $item = $this->request->getData()['item_variations'];
			 foreach($item as $data){ 
				$query1 = $this->Items->ItemVariations->query();
							  $query1->update()
							  ->set(['print_rate' =>$data['print_rate'],'discount_per' =>$data['discount_per'],'sales_rate' =>$data['sales_rate'],'ready_to_sale' =>$data['ready_to_sale'],])
							  ->where(['id'=>$data['id']])
							  ->execute();
				
				$itemVarData=$this->Items->ItemVariations->get($data['id']);
				if($itemVarData->seller_id > 0){
					$sellerAllItem=$this->Items->ItemVariations->find()->where(['seller_id'=>$itemVarData->seller_id,'seller_item_id'=>$itemVarData->seller_item_id,'ItemVariations.ready_to_sale'=>'Yes'])->first();
					if($sellerAllItem){
						$query1 = $this->Items->SellerItems->query();
						$query1->update()
							->set(['status' =>'Active'])
							->where(['id'=>$itemVarData->seller_item_id])
							->execute();
					}else{
						$query1 = $this->Items->SellerItems->query();
						$query1->update()
							->set(['status' =>'Deactive'])
							->where(['id'=>$itemVarData->seller_item_id])
							->execute();
					}
				}else{
					$sellerAllItem=$this->Items->ItemVariations->find()->where(['seller_id IS NULL','seller_item_id'=>$itemVarData->seller_item_id,'ItemVariations.ready_to_sale'=>'Yes'])->first();
					if($sellerAllItem){
						$query1 = $this->Items->SellerItems->query();
						$query1->update()
							->set(['status' =>'Active'])
							->where(['id'=>$itemVarData->seller_item_id])
							->execute();
					}else{
						$query1 = $this->Items->SellerItems->query();
						$query1->update()
							->set(['status' =>'Deactive'])
							->where(['id'=>$itemVarData->seller_item_id])
							->execute();
					}
				}
				//
			 }
			 return $this->redirect(['action' => 'mangeItem']);
		}
		
		if($user_type=="Seller"){
			
			$itemList=$this->Items->ItemVariations->find()->where(['ItemVariations.status'=>'Active','ItemVariations.city_id '=>$city_id,'ItemVariations.seller_id'=>$user_id])->contain(['Items','UnitVariations'=>['Units']]);

		}else{
			$itemList=$this->Items->ItemVariations->find()->where(['ItemVariations.city_id '=>$city_id,'ItemVariations.seller_id IS NULL'])->contain(['Items','UnitVariations'=>['Units']]);
			}
		//pr($itemList->toArray()); exit;
      //  $items = $this->paginate($items);
		//$paginate_limit=$this->paginate['limit'];
        $this->set(compact('items','paginate_limit','itemList'));
    }	
	
	 public function brandWiseDiscount(){
		 
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id');
		$user_type=$this->Auth->User('user_type');
		$this->viewBuilder()->layout('super_admin_layout');
		if ($this->request->is(['patch', 'post', 'put'])) { 
			$brands = $this->request->getData()['brands'];
			//pr($brands); exit;
			foreach($brands as $brand){	
				$Items = $this->Items->find()->where(['Items.brand_id'=>$brand['id'],'city_id'=>$city_id,'status'=>'Active','is_discount_enable'=>'Yes'])->contain(['ItemVariations']);
				foreach($Items as $item){
					foreach($item->item_variations as $item_variation){
						if($brand['discount']==0){
								$query1 = $this->Items->ItemVariations->query();
								$query1->update()
								->set(['print_rate' =>0,'sales_rate' =>$item_variation->mrp,'discount_per' =>$brand['discount']])
								->where(['id'=>$item_variation->id])
								->execute();
						}else{
							$discount_amount=($item_variation->mrp*$brand['discount'])/100;
								$query1 = $this->Items->ItemVariations->query();
								$query1->update()
								->set(['print_rate' =>$item_variation->mrp,'sales_rate' =>round($item_variation->mrp-$discount_amount),'discount_per' =>$brand['discount']])
								->where(['id'=>$item_variation->id])
								->execute();
							}
						}
					}
					$query2 = $this->Items->Brands->query();
					$query2->update()
					->set(['discount' =>$brand['discount']])
					->where(['id'=>$brand['id']])
					->execute();
						
			}
			 return $this->redirect(['action' => 'itemManageScreens']);
		}
		
			$brands=$this->Items->Brands->find()->where(['Brands.city_id '=>$city_id,'Brands.status'=>'Active']);
		
			//pr($brands->toArray()); exit;
			$this->set(compact('items','paginate_limit','brands'));
		 
	 }
	 public function categoryWiseDiscount(){
		 
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id');
		$user_type=$this->Auth->User('user_type');
		$this->viewBuilder()->layout('super_admin_layout');
		if ($this->request->is(['patch', 'post', 'put'])) { 
			$Categories = $this->request->getData()['Categories'];
		//	pr($Categories); exit;
			foreach($Categories as $Category){	
				$CategoriesDatas = $this->Items->Categories->find('threaded')->where(['Categories.id'=>$Category['id'],'Categories.city_id'=>$city_id]);
				
				foreach($CategoriesDatas as $CategoriesData){ 
					$Items = $this->Items->find()->where(['Items.category_id'=>$CategoriesData->id,'city_id'=>$city_id,'status'=>'Active','is_discount_enable'=>'Yes'])->contain(['ItemVariations']);
					foreach($Items as $item){ 
						foreach($item->item_variations as $item_variation){
							if($Category['discount']==0){
									$query1 = $this->Items->ItemVariations->query();
									$query1->update()
									->set(['print_rate' =>0,'sales_rate' =>$item_variation->mrp,'discount_per' =>$Category['discount']])
									->where(['id'=>$item_variation->id])
									->execute();
							}else{
								$discount_amount=($item_variation->mrp*$Category['discount'])/100;
									$query1 = $this->Items->ItemVariations->query();
									$query1->update()
									->set(['print_rate' =>$item_variation->mrp,'sales_rate' =>round($item_variation->mrp-$discount_amount),'discount_per' =>$Category['discount']])
									->where(['id'=>$item_variation->id])
									->execute();
							}
						}
					}
					$query2 = $this->Items->Categories->query();
					$query2->update()
					->set(['discount' =>$Category['discount']])
					->where(['id'=>$CategoriesData->id])
					->execute();
				}		
			}
			 return $this->redirect(['action' => 'itemManageScreens']);
		}
		
			$Categories=$this->Items->Categories->find()->where(['Categories.city_id '=>$city_id,'Categories.status'=>'Active','parent_id IS NOT NULL']);
		
			//pr($Categories->toArray()); exit;
			$this->set(compact('items','paginate_limit','Categories'));
		 
	 }
	 
	public function demandStock(){
		$url=$this->request->here();
		$url=parse_url($url,PHP_URL_QUERY);
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id');
		$user_type=$this->Auth->User('user_type');
		$category_id=$this->request->query('category_id');
		$brand_id=$this->request->query('brand_id');
		if($user_type=="Super Admin"){
			$this->viewBuilder()->layout('super_admin_layout');
		}
		$AllCondition=[];
		if($category_id){
			$AllCondition['category_id']=$category_id;
		}
		if($brand_id){
			$AllCondition['brand_id']=$brand_id;
		}
		$DemandStocks=$this->Items->ItemVariations->find()->where(['ItemVariations.city_id '=>$city_id,'ItemVariations.seller_id IS NULL','ItemVariations.demand_stock > '=>0])->contain(['UnitVariations'=>['Units'],'Items'=>function($q) use($AllCondition){
				return $q->where($AllCondition);
			}]);
		$Categories=$this->Items->Categories->find('list')->where(['Categories.city_id '=>$city_id,'Categories.status'=>'Active','parent_id IS NOT NULL'])->order(['Categories.name'=>'ASC']);
		
		$Brands=$this->Items->Brands->find('list')->where(['Brands.city_id '=>$city_id,'Brands.status'=>'Active'])->order(['Brands.name'=>'ASC']);
		
		$this->set(compact('items','paginate_limit','DemandStocks','url','Categories','category_id','Brands','category_id','brand_id'));
	}
	public function demandStockExcel(){
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id');
		$location_id=$this->Auth->User('location_id');
		$status = $this->request->query('status');
		$user_type =$this->Auth->User('user_type');
		$category_id=$this->request->query('category-id');
		$brand_id=$this->request->query('brand-id');
		$this->viewBuilder()->layout('');
		//pr($brand_id); exit;
		$AllCondition=[];
		if($category_id){
			$AllCondition['category_id']=$category_id;
		}
		if($brand_id){
			$AllCondition['brand_id']=$brand_id;
		}
		
		$DemandStocks=$this->Items->ItemVariations->find()->where(['ItemVariations.city_id '=>$city_id,'ItemVariations.seller_id IS NULL','ItemVariations.demand_stock > '=>0])->contain(['UnitVariations'=>['Units'],'Items'=>function($q) use($AllCondition){
				return $q->where($AllCondition);
			}]);
		
		/* $DemandStocks=$this->Items->ItemVariations->find()->where(['ItemVariations.city_id '=>$city_id,'ItemVariations.seller_id IS NULL','ItemVariations.demand_stock > '=>0])->contain(['Items','UnitVariations'=>['Units']]); */
	//	pr($itemList->toArray()); exit;
		$this->set(compact('items','paginate_limit','DemandStocks','url'));
	}
	 
	 public function manageOutOfStockItem()
    {
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id');
		$user_type=$this->Auth->User('user_type');
		if($user_type=="Super Admin"){
			$this->viewBuilder()->layout('super_admin_layout');
		}else{
			$this->viewBuilder()->layout('seller_layout');
		} 
	//	$this->viewBuilder()->layout('super_admin_layout');
        $this->paginate = [
            'contain' => ['Categories', 'Brands'],
			'limit' => 20
        ];
		//exit;
        if ($this->request->is(['patch', 'post', 'put'])) { 
			 $item = $this->request->getData()['item_variations'];
			// pr($item); exit;
			 foreach($item as $data){ 
				 $query1 = $this->Items->ItemVariations->query();
							  $query1->update()
							  ->set(['sales_rate' =>$data['sales_rate'],'status' =>$data['status'],])
							  ->where(['id'=>$data['id']])
							  ->execute();
			 }
			 return $this->redirect(['action' => 'manageOutOfStockItem']);
		}
		
			$itemList=$this->Items->ItemVariations->find()->where(['ItemVariations.city_id '=>$city_id,'ItemVariations.seller_id IS NULL','ItemVariations.out_of_stock'=>'Yes','ItemVariations.status'=>'Active'])->contain(['Items','UnitVariations'=>['Units']]);
		
		//pr($itemList->toArray()); exit;
      //  $items = $this->paginate($items);
		//$paginate_limit=$this->paginate['limit'];
        $this->set(compact('items','paginate_limit','itemList'));
    }
	
    public function ItemHistory()
    {
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id');
		$this->viewBuilder()->layout('super_admin_layout');
		$item_id=$this->request->query('item_id');
		$from_date = $this->request->query('from_date');
		$to_date   = $this->request->query('to_date');
		$from_date = date("Y-m-d",strtotime($from_date));
		$to_date   = date("Y-m-d",strtotime($to_date));
		if($from_date=="1970-01-01"){
			$from_date = date("Y-m-d");
			$to_date   = date("Y-m-d");
		}
		$items=$this->Items->find('list');
		//pr($itemList->toArray()); exit;
		/* $items=array();
		foreach($itemList as $data1){ 
			foreach($data1->item_variations as $data){
				if(empty($data->seller_id)){
					$merge=$data1->name.'('.@$data->unit_variation->visible_variation.')';
					$items[]=['text' => $merge,'value' => $data->id,'seller_id'=>$data->seller_id];
				}
			}
		} */
		$where1=[];
		if($from_date){
			$where1['ItemHistories.created_on >=']=$from_date;
			$where1['ItemHistories.created_on <=']=$to_date;
		}
		if($item_id){
			$where1['ItemHistories.item_id ']=$item_id;
		}
		
		$ItemHistories=$this->Items->ItemHistories->find()->contain(['Items'])->where($where1);
		$this->set(compact('ItemHistories','item_id','from_date','to_date','items'));
		
		
		
	} 
	
	public function ItemAlert()
    {
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id');
		$this->viewBuilder()->layout('super_admin_layout');
		
		$ItemVariations=$this->Items->ItemVariations->find()->contain(['Items'])->where(['ItemVariations.current_stock <='=>3,'ItemVariations.seller_id IS NULL']);
		//pr($ItemVariations->toArray()); exit;
		$this->set(compact('ItemVariations'));
		
	} 
	
	public function ItemRateDetail()
    {
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id');
		$this->viewBuilder()->layout('super_admin_layout');
		
		$ItemVariations=$this->Items->ItemVariations->find()->contain(['Items','UnitVariations']);
	//	pr($ItemVariations->toArray()); exit;
		$this->set(compact('ItemVariations'));
		
		
	}
    public function index()
    {
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id');
		$this->viewBuilder()->layout('super_admin_layout');
        $this->paginate = [
            'contain' => ['Categories', 'Brands'],
			'limit' => 10000
        ];
		$status=$this->request->query('status');
		$items = $this->Items->find()->where(['Items.city_id'=>$city_id]);
		
		if(!empty($status)){
			 $items = $this->Items->find()->contain(['Categories', 'Brands'])->where(['Items.city_id'=>$city_id,'Items.status'=>$status]);
			// $brands = $this->Brands->find()->where(['city_id'=>$city_id,'status'=>$status]);
		 }else{ //exit;
			 $items = $this->Items->find()->contain(['Categories', 'Brands'])->where(['Items.city_id'=>$city_id,'Items.status'=>'Active']);
			
		 }

		/* if ($this->request->is(['get'])){
			$search=$this->request->getQuery('search');
			$items->where([
							'OR' => [
									'Items.name LIKE' => $search.'%',
									'Items.alias_name LIKE' => $search.'%',
									'Categories.name LIKE' => $search.'%',
									'Brands.name LIKE' => $search.'%',
									'Items.status LIKE' => $search.'%',
									'Items.minimum_stock ' => $search.'%'
							]
			]);
		} */ 
        $items = $items;
		//pr($items->toArray()); exit; 
		$paginate_limit=$this->paginate['limit'];
        $this->set(compact('items','paginate_limit','status'));
    }

    /**
     * View method
     *
     * @param string|null $id Item id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $item = $this->Items->get($id, [
            'contain' => ['Categories', 'Brands', 'Admins', 'Sellers', 'Cities', 'AppNotifications', 'Carts', 'ComboOfferDetails', 'GrnRows', 'ItemVariations', 'PromotionDetails', 'PurchaseInvoiceRows', 'PurchaseReturnRows', 'SaleReturnRows', 'SalesInvoiceRows', 'SellerItems']
        ]);

        $this->set('item', $item);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */ 
    public function add()
    {
		$city_id=$this->Auth->User('city_id');
		$user_id=$this->Auth->User('id');
		$this->viewBuilder()->layout('super_admin_layout');
        $item = $this->Items->newEntity();


        if ($this->request->is('post')) {
			
            $item = $this->Items->patchEntity($item, $this->request->getData());
			$item->city_id=$city_id;
			$item->created_by=$user_id;
			//pr($this->request->getData()); exit;
			$sold_by=$this->request->getData()['sold_by'];
			$virtual_stock=$this->request->getData()['virtual_stock'];
			$item_for=$this->request->getData()['item_for'];
			@$max_qty=$this->request->getData()['max_qty'];
			if($item_for=="NULL"){
				$item_for=null;
			}
			//pr($item_for); exit;
			$image_type=$this->request->data('image_type');
			if ($item_data=$this->Items->save($item)) { 
				/* $seller_item = $this->Items->SellerItems->query();
				$seller_item->update()
					->set(['brand_id' => $item_data->brand_id,'category_id'=>$item_data->category_id])
					->where(['item_id' => $item_data->id])
					->execute(); */
				
            	$dir_name=[];
				$g=0;
				foreach ($this->request->getData('item_variation_row') as $value) {
						$g++;
        			if(!empty($value['unit_variation_id']))
        			{
						
						if($image_type=='Single'){
							
							if($g==1){
								$item_image_set=$value['item_image_web'];
								$item_image_set1=$value['item_image_web'];
							}else{
								$item_image_set=$item_image_set1;
							}
							
						}else if($image_type=='Multiple'){
							$item_image_set=$value['item_image_web'];
						}
						
						$item_image=$item_image_set;
						$item_error=$item_image['error'];
						if(empty($item_error))
						{
							$item_ext=explode('/',$item_image['type']);
							$item_item_image='item'.time().'.'.$item_ext[1];
						}

						$item_data_variation=$this->Items->ItemVariationMasters->newEntity();
				        $item_data_variation->item_id=$item_data->id;
				        $item_data_variation->unit_variation_id=$value['unit_variation_id'];
				        $item_data_variation->created_by= $user_id;
				        $item_data_variation->status= 'Active';
				        $item_data_variation=$this->Items->ItemVariationMasters->save($item_data_variation);
        				$lastInsertId=$item_data_variation->id;

					   

						if(empty($item_error))
						{
							/* For Web Image */
							$deletekeyname = 'item/'.$lastInsertId.'/web';
							$this->AwsFile->deleteMatchingObjects($deletekeyname);
							$keyname = 'item/'.$lastInsertId.'/web/'.$item_item_image;
							$this->AwsFile->putObjectFile($keyname,$item_image['tmp_name'],$item_image['type']);

							/* Resize Image */
							$destination_url = WWW_ROOT . 'img/temp/'.$item_item_image;
							if($item_ext[1]=='png'){
								$image = imagecreatefrompng($item_image['tmp_name']);
							}else{
								$image = imagecreatefromjpeg($item_image['tmp_name']); 
							}
							imagejpeg($image, $destination_url, 10);

							/* For App Image */
							$deletekeyname = 'item/'.$lastInsertId.'/app';
							$this->AwsFile->deleteMatchingObjects($deletekeyname);
							$keyname1 = 'item/'.$lastInsertId.'/app/'.$item_item_image;
							$this->AwsFile->putObjectFile($keyname1,$destination_url,$item_image['type']);

							 $query = $this->Items->ItemVariationMasters->query();
					    	$query->update()
						   	->set([
						   		'item_image' => $keyname1,
						   		'item_image_web' => $keyname
						   		])
						    ->where(['id' => $lastInsertId])
						    ->execute();

							$dir  = WWW_ROOT .  'img'.DS.'temp'.DS.$item_item_image;
							$dir_name[] = $this->EncryptingDecrypting->encryptData($dir);
						}
					}

				}
				//
					$item=$this->Items->get($item_data->id,['contain'=>['ItemVariationMasters']]);
			
					//Seller Item Entry
					$SellerItem=$this->Items->SellerItems->newEntity();
					$SellerItem->category_id= $item->category_id;
					$SellerItem->item_id= $item->id;
					$SellerItem->seller_id= $item_for;
					$SellerItem->city_id= $city_id;
					$SellerItem->brand_id= $item->brand_id;
					$SellerItem->created_on= date('Y-m-d');
					$SellerItem->status= 'Active'; 
					$SellerItemData=$this->Items->SellerItems->save($SellerItem);
				
					foreach($item->item_variation_masters as $item_variation_master){
						
						$ItemVariation=$this->Items->ItemVariations->newEntity();
						$ItemVariation->unit_variation_id= $item_variation_master->unit_variation_id;
						$ItemVariation->item_id= $item->id;
						$ItemVariation->seller_id= $item_for;
						$ItemVariation->seller_item_id= $SellerItemData->id;
						$ItemVariation->item_variation_master_id= $item_variation_master->id;
						$ItemVariation->city_id= $city_id;
						$ItemVariation->virtual_stock= $virtual_stock;
						$ItemVariation->created_on= date('Y-m-d');
						$ItemVariation->out_of_stock= 'Yes';
						$ItemVariation->ready_to_sale= 'Yes';
						$ItemVariation->status= 'Active';
						$ItemVariation->maximum_quantity_purchase= $sold_by;
						$ItemVariation->sold_by= $sold_by;
						//$ItemVariation->maximum_quantity_purchase=5; 
						$ItemVariation->maximum_quantity_purchase= @$max_qty; 
						$ItemVariationData=$this->Items->ItemVariations->save($ItemVariation);
						
					}
				
				
                $this->Flash->success(__('The item has been saved.'));
                if(empty($dir_name))
                { 
					
					return $this->redirect(['controller'=>'Items','action' => 'itemWiseRate']);
					
                }
                else
                { 	
					return $this->redirect(['controller'=>'Items','action' => 'itemWiseRate']);
                	//$url = urlencode(serialize($dir_name));
                	//return $this->redirect(['action' => 'delete_file',$url]);
                }
                
            }

            $this->Flash->error(__('The item could not be saved. Please, try again.'));
        }
		
		$units1 = $this->Items->ItemVariationMasters->UnitVariations->Units->find()->where(['Units.city_id'=>$city_id]);
		foreach($units1 as $data){
			$unitsdata[]=['value'=>$data->id,'text'=>$data->shortname];
			
		}
		
		
		$unitVariations = $this->Items->ItemVariationMasters->UnitVariations->find()->where(['UnitVariations.city_id'=>$city_id,'UnitVariations.status'=>"Active"])->contain(['Units']);
		$unit_option=[];
		$i=0; foreach($unitVariations as $unitVariation){
			//$show=$unitVariation->quantity_variation .' (' .$unitVariation->unit->shortname.')';
			if($unitVariation->id==1 || $unitVariation->id==2 ||$unitVariation->id==3){
				$unitVariation->visible_variation=$unitVariation->visible_variation.' (Fruit & Vegetable)';
			}
			$unit_option[]=['text'=>$unitVariation->visible_variation ,'value'=>$unitVariation->id ];
		}
		
		$Sellers[]=['text'=>'JainThela(Grocery)','value'=>'NULL'];
		$AllSellers = $this->Items->ItemVariations->Sellers->find()->where(['status'=>'Active']);
		foreach($AllSellers as $data){ 
			$Sellers[]=['text'=>$data->name,'value'=>$data->id];
		} //pr($Sellers);exit;
		
        $categories = $this->Items->Categories->find('list')->where(['Categories.city_id'=>$city_id]);
        $brands = $this->Items->Brands->find('list')->where(['Brands.city_id'=>$city_id])->order(['Brands.name' => 'ASC']);
		$categoryData = $this->Items->Categories->newEntity();
		$brandData = $this->Items->Brands->newEntity();
		$UnitVariationdata = $this->Items->ItemVariationMasters->UnitVariations->newEntity();
		 $parentCategories = $this->Items->Categories->ParentCategories->find('list')->where(['ParentCategories.city_id'=>$city_id])->order(['ParentCategories.name' => 'ASC']);
		$gstFigures =  $this->Items->GstFigures->find('list')->where(['city_id'=>$city_id]);
		//pr($unitVariations->toArray());exit;
		$this->set(compact('item', 'categories', 'brands', 'admins', 'sellers', 'cities','unitVariations','gstFigures','unit_option','parentCategories','categoryData','brandData','unitsdata','UnitVariationdata','Sellers'));
    }
    public function deleteFile($dir_name)
    {
    	$dir_name = unserialize(urldecode($dir_name));
    	foreach ($dir_name as  $dir) {
    		
	    	$dir = $this->EncryptingDecrypting->decryptData($dir);
	    	$dir  = new File($dir);				
			if ($dir->exists()) 
			{
				$dir->delete();	
			}
		}

		return $this->redirect(['action' => 'index']);
    	exit;
    }
	public function expiryReport($id = null){
		$city_id=$this->Auth->User('city_id');
		$location_id=$this->request->query('location_id');
		$day_no=$this->request->query('day_no');
		$this->viewBuilder()->layout('super_admin_layout');
		$item_variation_id=$this->request->query('item_variation_id');
		$ItemsVariationsForJainthela1=$this->Items->ItemsVariationsData->find()->contain(['Items','UnitVariations'=>['Units']])->where(['ItemsVariationsData.seller_id IS NULL','ItemsVariationsData.city_id'=>$city_id])->toArray();
		
		$listItems=[];
		foreach($ItemsVariationsForJainthela1 as $data){
			$merge=@$data->item->name.'('.@$data->unit_variation->quantity_variation.'.'.@$data->unit_variation->unit->shortname.')';
			$listItems[$data->id]=['text'=>$merge,'value'=>$data->id]; 
		}
		
		$where1=[];
		if(!empty($item_variation_id))
		{
			$where1['ItemsVariationsData.id']=$item_variation_id;
		}
		
		
		$ItemsVariationsForJainthela=$this->Items->ItemsVariationsData->find()->contain(['Items','UnitVariations'=>['Units']])->where(['ItemsVariationsData.seller_id IS NULL','ItemsVariationsData.city_id'=>$city_id])->where($where1)->toArray();
		//pr($ItemsVariationsForJainthela); exit;
		$itemStock=[];
		$itemName=[];
		foreach($ItemsVariationsForJainthela as $data){
			$ItemLedgersexists = $this->Items->ItemLedgers->exists(['item_variation_id' => $data->id]);
			if($ItemLedgersexists){
				$transaction_date=date('d-m-Y');
				//$location_id=4;
				$Itemdata=$this->Items->get($data->item_id);
				$dateWiseItem = $this->itemVariationWiseReportForExpiryReport($data->id,$transaction_date,$location_id);
				
				$itemStock[$data->id]=($dateWiseItem);
				//$itemName[$data->id]=($Itemdata->name);
				$merge=@$data->item->name.'('.@$data->unit_variation->quantity_variation.'.'.@$data->unit_variation->unit->shortname.')';
				//pr($merge); exit;
				$itemName[$data->id]=$merge; 
			}
		} 
		if(empty($day_no))
		{
			$day_no=7;
		}
		$Locations = $this->Items->Locations->find('list')->where(['city_id'=>$city_id]);
		$this->set(compact('itemStock','itemName','listItems','item_variation_id','location_id','Locations','day_no'));
	}
	
	public function zeroItemRate($id = null){
		
		$city_id=$this->Auth->User('city_id');
		$this->viewBuilder()->layout('super_admin_layout');
		
		
		$ItemsVariationsForJainthela=$this->Items->ItemsVariationsData->find()
			->leftJoinWith('Items.Brands')
			->innerJoinWith('UnitVariations.Units')
			->innerJoinWith('Items',function($q){
				return $q->where(['Items.status'=>"Active"]);
			})
			->order(['Items.name'=>'ASC'])
			->select([
				'item_id',
				'item_name'=>'Items.name',
				'brand'=>'Brands.name',
				'visible_variation'=>'UnitVariations.visible_variation',
				'sales_rate'=>'ItemsVariationsData.sales_rate',
				'current_stock'=>'ItemsVariationsData.current_stock',
				'ready_to_sale'=>'ItemsVariationsData.ready_to_sale',
				'status'=>'ItemsVariationsData.status',
			])
			->where(['ItemsVariationsData.sales_rate'=>0,'ItemsVariationsData.out_of_stock'=>'No','ItemsVariationsData.status'=>"Active"])->toArray();
		//pr($ItemsVariations); exit;
		
		$this->set(compact('ItemsVariations','ItemsVariationsForJainthela'));
	}
	
public function todayStockReport($id = null){
		
		$city_id=$this->Auth->User('city_id');
		$this->viewBuilder()->layout('super_admin_layout');
		
		$ItemsVariationsForJainthela=$this->Items->ItemsVariationsData->find()
			->innerJoinWith('Items.Brands')
			->innerJoinWith('Items.GstFigures')
			->innerJoinWith('UnitVariations.Units')
			->order(['Items.name'=>'ASC'])
			->select([
				'item_name'=>'Items.name',
				'brand'=>'Brands.name',
				'visible_variation'=>'UnitVariations.visible_variation',
				'convert_unit_qty'=>'UnitVariations.convert_unit_qty',
				'tax_percentage'=>'GstFigures.tax_percentage',
				'purchase_rate'=>'ItemsVariationsData.purchase_rate',
				'mrp'=>'ItemsVariationsData.mrp',
				'sales_rate'=>'ItemsVariationsData.sales_rate',
				'current_stock'=>'ItemsVariationsData.current_stock',
				'ready_to_sale'=>'ItemsVariationsData.ready_to_sale',
			])
			->where(['ItemsVariationsData.seller_id IS NULL','ItemsVariationsData.city_id'=>$city_id])->toArray();
		//pr($ItemsVariationsForJainthela); exit;
		
		$ItemsVariations=$this->Items->ItemsVariationsData->find()
			->leftJoinWith('Items.Brands')
			->innerJoinWith('Sellers')
			->innerJoinWith('UnitVariations.Units')
			->order(['Items.name'=>'ASC'])
			->select([
				'item_name'=>'Items.name',
				'Seller_name'=>'Sellers.name',
				'brand'=>'Brands.name',
				'visible_variation'=>'UnitVariations.visible_variation',
				'sales_rate'=>'ItemsVariationsData.sales_rate',
				'current_stock'=>'ItemsVariationsData.current_stock',
				'ready_to_sale'=>'ItemsVariationsData.ready_to_sale',
			])
			->where(['ItemsVariationsData.seller_id IS NOT NULL','ItemsVariationsData.city_id'=>$city_id])->toArray();
		
		
		$this->set(compact('ItemsVariations','ItemsVariationsForJainthela'));
	}
	public function wastageVoucher($id = null){
		$city_id=$this->Auth->User('city_id');
		$user_id=$this->Auth->User('id');
		$this->viewBuilder()->layout('super_admin_layout');
		//$city_id=$this->request->query('city_id');
		$location_id=$this->request->query('location_id');
		$from_date =  date("Y-m-d",strtotime($this->request->query('from_date')));
		$to_date   =  date("Y-m-d",strtotime($this->request->query('to_date')));
		
		
		if($from_date=="1970-01-01")
		{
			$from_date=date("d-m-Y");
		}
		if($to_date=="1970-01-01")
		{
			$to_date=date("d-m-Y");;
		}
		
		$where1=[];
		$status="No";
		if(empty($location_id))
		{
			$status="Yes";
		}
		$item = $this->Items->ItemLedgers->newEntity();
        if ($this->request->is(['patch', 'post', 'put'])) { 
				$item_ledgers=$this->request->getData()['item_ledgers'];
				foreach($item_ledgers as $item_ledger){ 
					$to_date   =  date("Y-m-d");
					$ItemLedger = $this->Items->ItemLedgers->newEntity(); 
					$ItemLedger->item_id=$item_ledger['item_id']; 
					$ItemLedger->item_variation_id=$item_ledger['item_variation_id'];
					$ItemLedger->transaction_date=$to_date;  
					$ItemLedger->quantity=$item_ledger['quantity'];
					$ItemLedger->rate=$item_ledger['rate'];
					$ItemLedger->purchase_rate=$item_ledger['rate'];
					$ItemLedger->status="Out";
					$ItemLedger->city_id=$city_id;
					$ItemLedger->location_id=$location_id;
					$ItemLedger->wastage="Yes";
					$this->Items->ItemLedgers->save($ItemLedger);
				}
				return $this->redirect(['action' => 'wastageVoucher']);
			//pr($item_ledgers); exit;
		}
		
		
		$showItems=[];
		if($status=="No"){
			$to_date   =  date("Y-m-d");
			$transaction_date=$to_date;
			$LocationData=$this->Items->Locations->get($location_id);
			$ItemsVariations=$this->Items->ItemsVariationsData->find()->toArray();
			foreach($ItemsVariations as  $ItemsVariation){ 
				$ItemLedgers =  $this->Items->ItemLedgers->find()->where(['ItemLedgers.item_variation_id'=>$ItemsVariation->id,'ItemLedgers.city_id'=>$LocationData->city_id,'ItemLedgers.location_id'=>$location_id,'ItemLedgers.seller_id IS NULL'])->where($where1)->contain(['Items','UnitVariations'=>['Units']])->first();
				$merge=@$ItemLedgers->item->name.'('.@$ItemLedgers->unit_variation->quantity_variation.'.'.@$ItemLedgers->unit_variation->unit->shortname.')';
				if($ItemLedgers){ 
				$UnitRateSerialItem = $this->itemVariationWiseReport($ItemsVariation->id,$transaction_date,$LocationData->city_id,$where1);
				$showItems[]=['item_id'=>$ItemLedgers->item->id,'item_variation_name'=>$merge,'item_variation_id'=>$ItemsVariation->id,'stock'=>$UnitRateSerialItem['stock'],'unit_rate'=>$UnitRateSerialItem['unit_rate']];
				}
			}
		}
			
		$Locations = $this->Items->Locations->find('list')->where(['city_id'=>$city_id]);
		$this->set(compact('ItemsVariations','Locations','Cities','from_date','to_date','city_id','location_id','showItems','item'));
	}
	public function wastageReport($id = null)
    {
		$city_id=$this->Auth->User('city_id');
		$user_id=$this->Auth->User('id');
		$this->viewBuilder()->layout('super_admin_layout');
		//$city_id=$this->request->query('city_id');
		$location_id=$this->request->query('location_id');
		$from_date =  date("Y-m-d",strtotime($this->request->query('from_date')));
		$to_date   =  date("Y-m-d",strtotime($this->request->query('to_date')));
		
		
		if($from_date=="1970-01-01")
		{
			$from_date=date("d-m-Y");
		}
		if($to_date=="1970-01-01")
		{
			$to_date=date("d-m-Y");;
		}
		
		$where1=[];
		$status="No";
		if(empty($location_id))
		{
			$status="Yes";
		}
		
		$showItems=[];
		if($status=="No"){
			
			//$to_date   =  date("Y-m-d");
			$transaction_date=date("Y-m-d",strtotime($to_date));
			$LocationData=$this->Items->Locations->get($location_id);
			/* $ItemsVariations=$this->Items->ItemsVariationsData->find()->where(['city_id'=>$city_id,'ItemsVariationsData.seller_id IS NULL']);
			
			foreach($ItemsVariations as  $ItemsVariation){ 
					$ItemLedgerssexists = $this->Items->ItemLedgers->exists(['item_variation_id' => $ItemsVariation->id]);
					if($ItemLedgerssexists){
						$ItemLedgers =  $this->Items->ItemLedgers->find()->where(['ItemLedgers.item_variation_id'=>$ItemsVariation->id,'ItemLedgers.city_id'=>$LocationData->city_id,'ItemLedgers.location_id'=>$location_id,'ItemLedgers.seller_id IS NULL','ItemLedgers.wastage'=>'Yes','transaction_date >='=>$from_date,'transaction_date <='=>$to_date])->contain(['Items']);
						//pr($ItemsVariation->id);
						 $itemVarData = $this->Items->ItemVariations->get($ItemsVariation->id, [
							'contain' => ['UnitVariations'=>['Units']]
						]);
								
						$merge=@$ItemLedgers->toArray()[0]['item']['name'].'('.@$itemVarData->unit_variation->quantity_variation.'.'.@$itemVarData->unit_variation->unit->shortname.')';
						//pr(@$merge); exit;
						$ItemLedgers->select(['ItemLedgers.item_id','total_quantity'=>$ItemLedgers->func()->sum('ItemLedgers.quantity')])->group('ItemLedgers.item_variation_id');
						
						if(@$ItemLedgers->toArray()[0]['total_quantity'] > 0){
								//pr(@$ItemLedgers->toArray()); exit;
						$showItems[]=['item_id'=>$itemVarData->item_id,'item_variation_name'=>$merge,'item_variation_id'=>$ItemsVariation->id,'stock'=>$ItemLedgers->toArray()[0]['total_quantity']];
						}
				}
			} */
			
			$ItemsVariations=$this->Items->WastageVouchers->find()
			->contain(['WastageVoucherRows' => function($q) {
				return $q->select(['wastage_voucher_id','quantity','item_id','item_variation_id'
				,'total_quantity' => $q->func()->sum('WastageVoucherRows.quantity'),'total_amount' => $q->func()->sum('WastageVoucherRows.quantity*WastageVoucherRows.rate')
				])->group('WastageVoucherRows.item_variation_id')->contain(['Items','ItemVariations'=>['UnitVariations']])->autoFields(true);
			}
			])
			->where(['city_id'=>$city_id,'created_on >='=>$from_date,'created_on <='=>$to_date]);
			
			foreach($ItemsVariations as $datas){
				foreach($datas->wastage_voucher_rows as $data){
					//pr($data); exit;
					$merge=@$data->item->name.' ('.@$data->item_variation->unit_variation->visible_variation.')';
					$showItems[]=['item_id'=>$data->item_id,'item_variation_name'=>$merge,'item_variation_id'=>$data->item_variation_id,'stock'=>$data->total_quantity,'total_amount'=>$data->total_amount];
				}
			}
			
		}
		
	//	
			
		$Locations = $this->Items->Locations->find('list')->where(['city_id'=>$city_id]);
		$this->set(compact('ItemsVariations','Locations','Cities','from_date','to_date','city_id','location_id','showItems','item'));
	}
		
	public function stockReport($id = null)
    {
		$url=$this->request->here();
		$url=parse_url($url,PHP_URL_QUERY);
		$city_id=$this->Auth->User('city_id');
		$user_id=$this->Auth->User('id');
		$this->viewBuilder()->layout('super_admin_layout');
	
		$city_id=$this->request->query('city_id');
		$item_id=$this->request->query('item_id');
		$location_id=$this->request->query('location_id');
		$brand_id=$this->request->query('brand_id');
		$seller_id=$this->request->query('seller_id');
		$from_date =  date("Y-m-d",strtotime($this->request->query('from_date')));
		$to_date   =  date("Y-m-d",strtotime($this->request->query('to_date')));
		$transaction_date=$to_date;
		$where1=[];
		
		if(!empty($brand_id))
		{
			$where1['Items.brand_id']=$brand_id;
		}
		
		if(!empty($item_id))
		{
			$where1['Items.id']=$item_id;
		}
		
		
		//pr($where); exit;
		$showItems=[];
		$showVaritions=[];
		if($location_id){ 
		 $Items = $this->Items->find()->where(['city_id'=>$city_id,'item_maintain_by !=' => "itemwise"])->where($where1);
		 //pr($Items->toArray()); exit;
				foreach($Items as  $Item){ 
					$ItemLedgerssexists = $this->Items->ItemLedgers->exists(['item_id' => $Item->id,'location_id' => $location_id]);
					if($ItemLedgerssexists){
							$stock_count = $this->itemWiseStock($Item->id,$transaction_date,$location_id);
							/* if($stock_count['stock'] != 0){
								$showItems[$Item->id]=['item_name'=>$Item->name,'stock'=>$stock_count['stock'],'amount'=>$stock_count['amount'],'var_name'=>$UnitVar->visible_variation];
							} */
							
							foreach($stock_count as $key=>$data){
								//@$showItems[$Item->id]=['item_name'=>$Item->name];
								if($data['stock'] > 0){
									//$itemVarData = $this->Items->ItemVariations->get($ItemsVariation->id);
									
									$itemVarData = $this->Items->ItemVariations->find()->where(['unit_variation_id'=>$key,'item_id'=>$Item->id])->select(['mrp'])->first();
									
									$UnitVar=$this->Items->UnitVariations->get($key);
									$showItems[]=['item_name'=>$Item->name,'var_name'=>$UnitVar->visible_variation,'stock'=>$data['stock'],'amount'=>$data['amount'],'mrp'=>$itemVarData->mrp];
									
								}
							}
						
						
					}
				}
			
		}else if($city_id){ 
			 $Items = $this->Items->find()->where(['city_id'=>$city_id])->where($where1);
			 
				foreach($Items as  $Item){ 
					$ItemLedgerssexists = $this->Items->ItemLedgers->exists(['item_id' => $Item->id,'city_id' => $city_id]);
					if($ItemLedgerssexists){
						//pr($Item); exit;
						if($Item->item_maintain_by=="itemwise"){
							/* $stock_count = $this->itemWiseStockForCity($Item->id,$transaction_date,$city_id,$Item->item_maintain_by);
							$Unit =  $this->Items->UnitVariations->Units->get($Item->default_unit_id);
							//pr($Unit); exit;
							if($stock_count['stock'] > 0){
								$showItems[$Item->id]=['item_name'=>$Item->name,'var_name'=>$Unit->unit_name,'stock'=>$stock_count['stock'],'amount'=>$stock_count['amount']];
							} */
						}
						else{
							$stock_count = $this->itemWiseStockForCity($Item->id,$transaction_date,$city_id,$Item->item_maintain_by);
							foreach($stock_count as $key=>$data){
								//@$showItems[$Item->id]=['item_name'=>$Item->name];
								if($data['stock'] > 0){
									
									$itemVarData = $this->Items->ItemVariations->find()->where(['unit_variation_id'=>$key,'item_id'=>$Item->id])->select(['mrp'])->first();
									
									$UnitVar=$this->Items->UnitVariations->get($key);
									$showItems[]=['item_name'=>$Item->name,'var_name'=>$UnitVar->visible_variation,'stock'=>$data['stock'],'amount'=>$data['amount'],'mrp'=>$itemVarData->mrp];
									
								}
							}
						}
						
					}
				}
			}
			//pr($showItems); exit;
		
		if($from_date=="1970-01-01")
		{
			$from_date=date("d-m-Y");
		}
		if($to_date=="1970-01-01")
		{
			$to_date=date("d-m-Y");;
		}
		$Locations = $this->Items->Locations->find('list');
		$Cities = $this->Items->Cities->find('list');
		$Brands = $this->Items->Brands->find('list');
		$Sellers = $this->Items->Sellers->find('list');
		$unit_variation=$this->Items->UnitVariations->find()->contain(['Units']);
		$unit_variation_data=[];
		foreach($unit_variation as $data){
			$unit_variation_data[$data->id]=@$data->visible_variation;
		}
		$Itemdatas = $this->Items->find('list')->where(['item_maintain_by !=' => "itemwise"]);
		// pr($unit_variation_data); exit;
		$this->set(compact('Locations','Cities','showItems','city_id','location_id','Sellers','seller_id','from_date','to_date','unit_variation_data','Brands','brand_id','url','Itemdatas','item_id'));
	}
	
	public function stockReportExcel($id = null)
    {
		$city_id=$this->Auth->User('city_id');
		$user_id=$this->Auth->User('id');
		
	
		$city_id=$this->request->query('city-id');
		$item_id=$this->request->query('item-id');
		$location_id=$this->request->query('location-id');
		$brand_id=$this->request->query('brand-id');
		$seller_id=$this->request->query('seller_id');
		$from_date =  date("Y-m-d",strtotime($this->request->query('from_date')));
		$to_date   =  date("Y-m-d",strtotime($this->request->query('to-date')));
		$transaction_date=$to_date;
		$where1=[];
		$this->viewBuilder()->layout('');
		if(!empty($brand_id))
		{
			$where1['Items.brand_id']=$brand_id;
		}
		
		if(!empty($item_id))
		{
			$where1['Items.id']=$item_id;
		}
		
		//echo "ertgertre"; exit;
		//pr($location_id); exit;
		$showItems=[];
		$showVaritions=[];
		if($location_id){ 
		 $Items = $this->Items->find()->where(['city_id'=>$city_id,'item_maintain_by !=' => "itemwise"])->where($where1);
		 //pr($Items->toArray()); exit;
				foreach($Items as  $Item){ 
					$ItemLedgerssexists = $this->Items->ItemLedgers->exists(['item_id' => $Item->id,'location_id' => $location_id]);
					if($ItemLedgerssexists){
							$stock_count = $this->itemWiseStock($Item->id,$transaction_date,$location_id);
							/* if($stock_count['stock'] != 0){
								$showItems[$Item->id]=['item_name'=>$Item->name,'stock'=>$stock_count['stock'],'amount'=>$stock_count['amount'],'var_name'=>$UnitVar->visible_variation];
							} */
							
							foreach($stock_count as $key=>$data){
								//@$showItems[$Item->id]=['item_name'=>$Item->name];
								if($data['stock'] > 0){
									//$itemVarData = $this->Items->ItemVariations->get($ItemsVariation->id);
									
									$itemVarData = $this->Items->ItemVariations->find()->where(['unit_variation_id'=>$key,'item_id'=>$Item->id])->select(['mrp'])->first();
									
									$UnitVar=$this->Items->UnitVariations->get($key);
									$showItems[]=['item_name'=>$Item->name,'var_name'=>$UnitVar->visible_variation,'stock'=>$data['stock'],'amount'=>$data['amount'],'mrp'=>$itemVarData->mrp];
									
								}
							}
						
						
					}
				}
			
		}else if($city_id){ 
			 $Items = $this->Items->find()->where(['city_id'=>$city_id])->where($where1);
			 
				foreach($Items as  $Item){ 
					$ItemLedgerssexists = $this->Items->ItemLedgers->exists(['item_id' => $Item->id,'city_id' => $city_id]);
					if($ItemLedgerssexists){
						//pr($Item); exit;
						if($Item->item_maintain_by=="itemwise"){
							/* $stock_count = $this->itemWiseStockForCity($Item->id,$transaction_date,$city_id,$Item->item_maintain_by);
							$Unit =  $this->Items->UnitVariations->Units->get($Item->default_unit_id);
							//pr($Unit); exit;
							if($stock_count['stock'] > 0){
								$showItems[$Item->id]=['item_name'=>$Item->name,'var_name'=>$Unit->unit_name,'stock'=>$stock_count['stock'],'amount'=>$stock_count['amount']];
							} */
						}
						else{
							$stock_count = $this->itemWiseStockForCity($Item->id,$transaction_date,$city_id,$Item->item_maintain_by);
							foreach($stock_count as $key=>$data){
								//@$showItems[$Item->id]=['item_name'=>$Item->name];
								if($data['stock'] > 0){
									
									$itemVarData = $this->Items->ItemVariations->find()->where(['unit_variation_id'=>$key,'item_id'=>$Item->id])->select(['mrp'])->first();
									
									$UnitVar=$this->Items->UnitVariations->get($key);
									$showItems[]=['item_name'=>$Item->name,'var_name'=>$UnitVar->visible_variation,'stock'=>$data['stock'],'amount'=>$data['amount'],'mrp'=>$itemVarData->mrp];
									
								}
							}
						}
						
					}
				}
			}
			//pr($showItems); exit;
		
		if($from_date=="1970-01-01")
		{
			$from_date=date("d-m-Y");
		}
		if($to_date=="1970-01-01")
		{
			$to_date=date("d-m-Y");;
		}
		$Locations = $this->Items->Locations->find('list');
		$Cities = $this->Items->Cities->find('list');
		$Brands = $this->Items->Brands->find('list');
		$Sellers = $this->Items->Sellers->find('list');
		$unit_variation=$this->Items->UnitVariations->find()->contain(['Units']);
		$unit_variation_data=[];
		foreach($unit_variation as $data){
			$unit_variation_data[$data->id]=@$data->visible_variation;
		}
		// pr($unit_variation_data); exit;
		$this->set(compact('Locations','Cities','showItems','city_id','location_id','Sellers','seller_id','from_date','to_date','unit_variation_data','Brands','brand_id'));
	}

	/* public function itemWiseReport($item_id=null,$transaction_date,$city_id){
		pr($item_id); exit;
		
	} */
	
	public function itemWiseStockForCity($item_id=null,$transaction_date,$city_id,$manage_by){
		///$this->viewBuilder()->layout('super_admin_layout');
		$ItemLedgers =  $this->Items->ItemLedgers->find()->where(['item_id'=>$item_id,'seller_id IS NULL','city_id'=>$city_id,'transaction_date <='=>$transaction_date])->order(['ItemLedgers.id'=>'ASC']);
		//pr($ItemLedgers->toArray()); exit;
		$stock=[];
		if($manage_by=="itemwise"){ 
			foreach($ItemLedgers as $data){
				if($data->status=="In" && $data->location_id == 0){
 					for($inc=1;$inc <= $data->quantity*20;$inc+=1){
						$stock[$data->item_id][]=$data->rate/20;
					}
				}else if($data->status=="Out" && $data->location_id == 0){
 					$UnitVariation =  $this->Items->ItemLedgers->UnitVariations->get($data->unit_variation_id);
					$data->quantity=($UnitVariation->convert_unit_qty*$data->quantity);
					$stock[$data->item_id]= array_slice($stock[$data->item_id], $data->quantity*20); 
				}  
			} 
			$unitData=[];
 			$rate=array_sum(@$stock[@$data->item_id]);
			$qty=count(@$stock[@$data->item_id])/20;
			$unitData=['stock'=>$qty,'amount'=>$rate];
			//pr($Data); exit;
 		}else{
			foreach(@$ItemLedgers as $data){ 
				if($data->status=="In" && $data->location_id == 0){
  					for($inc=1;$inc <= $data->quantity;$inc+=1){
						@$stock[$data->unit_variation_id][]=@$data->rate;
					}
				}else if(@$data->status=="Out" && @$data->location_id == 0){ 
					@$stock[$data->unit_variation_id]= array_slice(@$stock[$data->unit_variation_id], @$data->quantity); 
				} 
				
			} 
			$StockData=0;
			$unitData=[];
			if(!empty(@$stock)){
				foreach(@$stock as $key=>$datas){
					$qty=0;$rate=0;
					foreach(@$datas as $data){
						++$qty;
						$rate+=$data;
					}
					$unitData[$key]=['stock'=>$qty,'amount'=>$rate];
				}
			}
		}
		
		//pr($unitData); exit;
 		///$Data=['stock'=>$qty,'amount'=>$rate];
		return $unitData;
 	}
	
	public function itemWiseStock($item_id=null,$transaction_date,$location_id){
	//	$this->viewBuilder()->layout('super_admin_layout');
		
		$ItemLedgers =  $this->Items->ItemLedgers->find()->where(['item_id'=>$item_id,'seller_id IS NULL','location_id'=>$location_id,'transaction_date <='=>$transaction_date])->order(['ItemLedgers.status'=>'ASC']);
		//$ItemLedgers->select(['ItemLedgers.item_id','unit_variation_id','status','rate','total_quantity'=>$ItemLedgers->func()->sum('ItemLedgers.quantity')])->group('ItemLedgers.unit_variation_id');
	
		$stock=[];
		$outStock=[];
		$ItemIn="No";
			/* foreach($ItemLedgers as $data){
				if($data->status=="In"){
					//echo $data->quantity;
					for($inc=1;$inc <= $data->quantity;$inc+=1){
						$stock[$data->item_id][]=$data->rate;
					}
					$ItemIn="Yes";
				}else if($data->status=="Out"){
					$q=(sizeof(@$stock[$data->item_id]));
					if($q > 0){
						$stock[$data->item_id]= array_slice($stock[$data->item_id], $data->quantity); 
					}else{ 
						@$outStock[$data->item_id][0]-=@$data->quantity;
					}
				}  
			}  */
			
			foreach($ItemLedgers as $data){ 
				if($data->status=="In"){
  					for($inc=1;$inc <= $data->quantity;$inc+=1){
						$stock[$data->unit_variation_id][]=$data->rate;
					}
					$ItemIn="Yes";
				}else if($data->status=="Out"){ 
					$q=(sizeof(@$stock[$data->unit_variation_id]));
					@$stock[$data->unit_variation_id]= array_slice(@$stock[$data->unit_variation_id], $data->quantity);
					
				} 
			} 
			
			$StockData=0;
			$unitData=[];
			foreach($stock as $key=>$datas){
				$qty=0;$rate=0;
				if(!empty(@$datas)){
					foreach(@$datas as $data){
						++$qty;
						$rate+=$data;
					}
				$unitData[@$key]=['stock'=>$qty,'amount'=>$rate];
				}
			}
			
			
			
			/* if($ItemIn=="Yes"){
				$rate=array_sum($stock[$data->item_id]);
				$qty=count($stock[$data->item_id]);
			}else{
				$rate=0;
				$qty=$outStock[$data->item_id][0];
			}
			$Data=['stock'=>$qty,'amount'=>$rate]; */
		return $unitData;
		
	}
	
	public function itemVariationWiseReportForExpiryReport($item_variation_id=null,$transaction_date,$location_id){
		$this->viewBuilder()->layout('super_admin_layout');
		$transaction_date=date('Y-m-d',strtotime($transaction_date));
		$StockLedgers =  $this->Items->ItemLedgers->find()->where(['item_variation_id'=>$item_variation_id,'transaction_date <='=>$transaction_date,'location_id'=>$location_id])->order(['ItemLedgers.expiry_date'=>'ASC'])->toArray();
		//pr($item_variation_id);  
		//pr($transaction_date);  
		
		$stockNew=[];
		foreach($StockLedgers as $StockLedger){
			if($StockLedger->status=='In'){
				$stockNew[]=['qty'=>$StockLedger->quantity,'rate'=>$StockLedger->rate,'expiry_date'=>date('Y-m-d',strtotime($StockLedger->expiry_date))];
			}
		}
		//pr($stockNew);   exit;
		
		foreach($StockLedgers as $StockLedger){
			if($StockLedger->status=='Out'){
				/* if(sizeof(@$stock) > 0){
					$stock= array_slice($stock, $StockLedger->quantity*100);
				} */

				if(sizeof(@$stockNew)==0){
				break;
				}

				$outQty=$StockLedger->quantity;
				a:
				if(sizeof(@$stockNew)==0){
					break;
				}
				$R=@$stockNew[0]['qty']-$outQty;
				if($R>0){
					$stockNew[0]['qty']=$R;
				}
				else if($R<0){
					unset($stockNew[0]);
					@$stockNew=array_values(@$stockNew);
					$outQty=abs($R);
					goto a;
				}
				else{
					unset($stockNew[0]);
					$stockNew=array_values($stockNew);
				}
			}
		}
/* pr($stockNew); exit;
		$closingValue=0;
		$total_stock=0;
		$total_amt=0;
		$unit_rate=0;
		foreach($stockNew as $qw){
			$total_stock+=$qw['qty'];
			$total_amt+=$qw['rate']*$qw['qty'];
		}
		if($total_amt > 0 && $total_stock > 0){
			 $unit_rate = $total_amt/$total_stock;
		}

		$Data=['stock'=>$total_stock,'unit_rate'=>$unit_rate]; */
		return $stockNew;
		exit;
	}
	
	
	
	public function itemVariationWiseReport($item_variation_id=null,$transaction_date,$location_id,$where1){
		$this->viewBuilder()->layout('super_admin_layout');
		//$city_id=$this->Auth->User('city_id');
		//$location_id=$this->Auth->User('location_id');

		$StockLedgers =  $this->Items->ItemLedgers->find()->where(['item_variation_id'=>$item_variation_id,'transaction_date <='=>$transaction_date,'location_id'=>$location_id])->order(['ItemLedgers.transaction_date'=>'ASC'])->toArray();
		
		 $stockNew=[];
		foreach($StockLedgers as $StockLedger){
			if($StockLedger->status=='In'){
				$stockNew[]=['qty'=>$StockLedger->quantity,'rate'=>$StockLedger->rate];
			}
		}

		foreach($StockLedgers as $StockLedger){
			if($StockLedger->status=='Out'){
				/* if(sizeof(@$stock) > 0){
					$stock= array_slice($stock, $StockLedger->quantity*100);
				} */

				if(sizeof(@$stockNew)==0){
				break;
				}

				$outQty=$StockLedger->quantity;
				a:
				if(sizeof(@$stockNew)==0){
					break;
				}
				$R=@$stockNew[0]['qty']-$outQty;
				if($R>0){
					$stockNew[0]['qty']=$R;
				}
				else if($R<0){
					unset($stockNew[0]);
					@$stockNew=array_values(@$stockNew);
					$outQty=abs($R);
					goto a;
				}
				else{
					unset($stockNew[0]);
					$stockNew=array_values($stockNew);
				}
			}
		}

		$closingValue=0;
		$total_stock=0;
		$total_amt=0;
		$unit_rate=0;
		foreach($stockNew as $qw){
			$total_stock+=$qw['qty'];
			$total_amt+=$qw['rate']*$qw['qty'];
		}
		if($total_amt > 0 && $total_stock > 0){
			 $unit_rate = $total_amt/$total_stock;
		}

		$Data=['stock'=>$total_stock,'unit_rate'=>$unit_rate];
		return $Data;
		exit;
	}
	public function itemWiseReport($item_id,$transaction_date,$city_id,$where){
	
		$this->viewBuilder()->layout('super_admin_layout');
		$location_id=$this->Auth->User('location_id');
		$stock=[];
		$ItemLedgers =  $this->Items->ItemLedgers->find()->where(['item_id'=>$item_id,'seller_id IS NULL','location_id'=>0,'transaction_date <='=>$transaction_date])->order(['ItemLedgers.transaction_date'=>'ASC'])->toArray(); 
		foreach($ItemLedgers as $ItemLedger){
				
				if($ItemLedger->status=="In"){
					for($inc=0;$inc<$ItemLedger->quantity;$inc++){
					$stock[$ItemLedger->unit_variation_id][]=$ItemLedger->rate;
					}
				}
			}
		
		foreach($ItemLedgers as $ItemLedger){ 
			if($ItemLedger->status=='Out'){ 
				if(sizeof(@$stock[$ItemLedger->unit_variation_id])>0){ 
					$stock[$ItemLedger->unit_variation_id] = array_slice($stock[$ItemLedger->unit_variation_id], $ItemLedger->quantity); 
					
				}
			}
		}
		
		$closingValue=0;
		
		$item_var_val=[];
		$item_stock=[];
		foreach($stock  as $key=>$stockRow){ $remaining=0;
			$rate=0;  
			foreach($stockRow as $data){ 
				$remaining=count($stock[$key]); 
				$rate+=$data;
			}
			if($remaining > 0){
				$item_var_val[$key]=$rate/$remaining;
				$item_stock[$key]=$remaining;
			}
		} 
		//pr($item_stock); 
	//	pr($item_var_val); exit;
	/* $query = $this->Items->ItemLedgers->find()->where(['ItemLedgers.city_id'=>$city_id]);
        $totalInCase = $query->newExpr()
            ->addCase(
                $query->newExpr()->add(['status' => 'In']),
                $query->newExpr()->add(['quantity']),
                'integer'
            );
        $totalOutCase = $query->newExpr()
            ->addCase(
                $query->newExpr()->add(['status' => 'out']),
                $query->newExpr()->add(['quantity']),
                'integer'
            );
        $query->select([
            'total_in' => $query->func()->sum($totalInCase),
            'total_out' => $query->func()->sum($totalOutCase),'id','item_id'
        ])
        ->where(['item_id'=>$item_id,'seller_id IS NULL','location_id'=>0,'transaction_date <='=>$transaction_date])
        ->group('unit_variation_id')
        ->autoFields(true); */
		
		
		
		
		/*  $stockNew=[]; 
		 $stockNew1=[]; 
		foreach($StockLedgers as $StockLedger){  
			if($StockLedger->status=='In'){ 
				//$stockNew[$StockLedger->unit_variation_id]=['qty'=>$StockLedger->quantity,'rate'=>$StockLedger->rate];
				$stockNew[$StockLedger->unit_variation_id]+=$StockLedger->quantity;
				$stockNew1[$StockLedger->unit_variation_id]+=$StockLedger->rate;
			}
		}
		pr($stockNew); 
		pr($stockNew1); 
		exit;
		//pr($stockNew); exit;
		foreach($StockLedgers as $StockLedger){
			if($StockLedger->status=='Out'){
				 if(sizeof(@$stock) > 0){
					$stock= array_slice($stock, $StockLedger->quantity*100);
				} 

				if(sizeof(@$stockNew)==0){
				break;
				}

				$outQty=$StockLedger->quantity;
				a:
				if(sizeof(@$stockNew)==0){
					break;
				}
				$R=@$stockNew[0]['qty']-$outQty;
				if($R>0){
					$stockNew[0]['qty']=$R;
				}
				else if($R<0){
					unset($stockNew[0]);
					@$stockNew=array_values(@$stockNew);
					$outQty=abs($R);
					goto a;
				}
				else{
					unset($stockNew[0]);
					$stockNew=array_values($stockNew);
				}
			}
		}

		$closingValue=0;
		$total_stock=0;
		$total_amt=0;
		foreach($stockNew as $qw){
			$total_stock+=$qw['qty'];
			$total_amt+=$qw['rate']*$qw['qty'];
		}
		if($total_amt > 0 && $total_stock > 0){
			 $unit_rate = $total_amt/$total_stock;
		} */

		$Data=['stock'=>$item_stock,'unit_rate'=>$item_var_val]; //pr($Data); exit;
		return $Data;
		exit;
	}
    /**
     * Edit method
     *
     * @param string|null $id Item id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
		if($id)
		{
		   $id = $this->EncryptingDecrypting->decryptData($id);
		}
		
		$city_id=$this->Auth->User('city_id');
		$user_id=$this->Auth->User('id');
		$this->viewBuilder()->layout('super_admin_layout');
        $item = $this->Items->get($id, [
            'contain' => ['ItemVariations','ItemVariationMasters'=>function ($q){
				return $q->where(['ItemVariationMasters.status'=>'Active'])->contain(['UnitVariations']);
			}]
        ]);
		$item_old_status=$item->status;
		
		if(sizeof($item->item_variation_masters)>0)
		{
			$VariationMasterArr = [];
			$ItemVariationArr = [];
			$img = [];
			foreach($item->item_variation_masters as $item_variation_master)
			{ 
				$VariationMasterArr[$item_variation_master->unit_variation_id]='exist';
				$img[$item_variation_master->unit_variation_id]=$item_variation_master->item_image_web; 
			}
		}
		

              if ($this->request->is(['patch', 'post', 'put'])) {
			$item = $this->Items->patchEntity($item, $this->request->getData());
			
			$sold_by=$this->request->getData()['sold_by'];
			$virtual_stock=$this->request->getData()['virtual_stock'];
			$item_for=$this->request->getData()['item_for'];
			@$max_qty=$this->request->getData()['max_qty'];
			if($item_for=="NULL"){
				$item_for=null;
			}
			
			//exit;
			$item->seller_id=$item_for;
			
			//pr($this->request->getData('item_variation_row')); exit;
			
			
			if ($item_data=$this->Items->save($item)) { 
			
				//Item History
				if($item->status !=$item_old_status){
					$ItemHistory=$this->Items->ItemHistories->newEntity();
					$ItemHistory->status=$item->status;
					$ItemHistory->item_id=$id;
					$t=date('H:i:s'); 
					$cr=(date("Y-m-d"));
					$ItemHistory->created_on=$cr;
					$ItemHistory->created_time=$t;
					$this->Items->ItemHistories->save($ItemHistory);
				}
				// END
			
				$dir_name=[];
				$unitVariationIds=[];
				$seller_item = $this->Items->SellerItems->query();
				$seller_item->update()
					->set(['brand_id' => $item_data->brand_id,'category_id'=>$item_data->category_id])
					->where(['item_id' => $item_data->id])
					->execute();
				$tempActive=0;
				foreach ($this->request->getData('item_variation_row') as $value) {
					$unitVariationIds[]=$value['unit_variation_id'];
        			if(!empty($value['unit_variation_id']))
        			{

						$item_image=$value['item_image_web'];
						$item_error=$item_image['error'];
						if(empty($item_error))
						{
							$item_ext=explode('/',$item_image['type']);
							$item_item_image='item'.time().'.'.$item_ext[1];
						}
						$is_exist = $this->Items->ItemVariationMasters->find()->where(['ItemVariationMasters.item_id'=>$item_data->id,'ItemVariationMasters.unit_variation_id'=>$value['unit_variation_id']])->first(); 
						if(sizeof($is_exist)<1)
						{ 
							$item_data_variation=$this->Items->ItemVariationMasters->newEntity();
							$item_data_variation->item_id=$item_data->id;
							$item_data_variation->unit_variation_id=$value['unit_variation_id'];
							$item_data_variation->created_by= $user_id;
							$item_data_variation->status=$value['status'];
							$item_data_variation=$this->Items->ItemVariationMasters->save($item_data_variation);
							$lastInsertId=$item_data_variation->id;
							
							$SellerItemData=$this->Items->SellerItems->find()->where(['item_id'=>$item_data->id])->first();
							//pr($SellerItemData); exit;
							$ItemVariation=$this->Items->ItemVariations->newEntity();
							$ItemVariation->unit_variation_id= $value['unit_variation_id'];
							$ItemVariation->item_id= $item_data->id;
							$ItemVariation->seller_id= $item_for;
							$ItemVariation->seller_item_id= $SellerItemData->id;
							$ItemVariation->item_variation_master_id= $item_data_variation->id;
							$ItemVariation->city_id= $city_id;
							$ItemVariation->virtual_stock= $virtual_stock;
							$ItemVariation->created_on= date('Y-m-d');
							$ItemVariation->out_of_stock= 'Yes';
							$ItemVariation->ready_to_sale= 'Yes';
							$ItemVariation->status= $value['status'];
							$ItemVariation->sold_by= $sold_by;
							$ItemVariation->maximum_quantity_purchase= @$max_qty; 
							$ItemVariationData=$this->Items->ItemVariations->save($ItemVariation);
							
							if($value['status']=="Active"){
								$tempActive=1;
							}
							
						}else
						{
							$query2 = $this->Items->ItemVariationMasters->query();
							  $query2->update()
							  ->set(['status' =>$value['status']])
							  ->where(['ItemVariationMasters.unit_variation_id'=>$value['unit_variation_id'],'ItemVariationMasters.item_id'=>$item_data->id])
							  ->execute();
							  //exit;
							  
							$lastInsertId=$is_exist->id; 
							$ready_to_sale="No";
							if($value['status']=="Active"){
								$ready_to_sale="Yes";
								$tempActive=1;
							}
							
							$query1 = $this->Items->ItemVariations->query();
							  $query1->update()
							  ->set(['virtual_stock'=>$virtual_stock,'status' =>$value['status'],'ready_to_sale'=>$ready_to_sale])
							  ->where(['unit_variation_id'=>$value['unit_variation_id'],'item_id'=>$item_data->id])
							  ->execute();
							  
							
							 // echo $query2; exit;
						}
						
					
						if(empty($item_error))
						{
							/* For Web Image */
							$deletekeyname = 'item/'.$lastInsertId.'/web';
							$this->AwsFile->deleteMatchingObjects($deletekeyname);
							$keyname = 'item/'.$lastInsertId.'/web/'.$item_item_image;
							$this->AwsFile->putObjectFile($keyname,$item_image['tmp_name'],$item_image['type']);

							/* Resize Image */
							$destination_url = WWW_ROOT . 'img/temp/'.$item_item_image;
							if($item_ext[1]=='png'){
								$image = imagecreatefrompng($item_image['tmp_name']);
							}else{
								$image = imagecreatefromjpeg($item_image['tmp_name']); 
							}
							imagejpeg($image, $destination_url, 10);

							/* For App Image */
							$deletekeyname = 'item/'.$lastInsertId.'/app';
							$this->AwsFile->deleteMatchingObjects($deletekeyname);
							$keyname1 = 'item/'.$lastInsertId.'/app/'.$item_item_image;
							$this->AwsFile->putObjectFile($keyname1,$destination_url,$item_image['type']);

							 $query = $this->Items->ItemVariationMasters->query();
					    	$query->update()
						   	->set([
						   		'item_image' => $keyname1,
						   		'item_image_web' => $keyname
						   		])
						    ->where(['id' => $lastInsertId])
						    ->execute();

							$dir  = WWW_ROOT .  'img'.DS.'temp'.DS.$item_item_image;
							$dir_name[] = $this->EncryptingDecrypting->encryptData($dir);
							/* Delete Temp File */
							
						}
					}

				} 
				
				if($item_data->status=="Deactive"){
					$query = $this->Items->ItemVariationMasters->ItemVariations->query(); //pr($query); exit;
					$query->update()
							->set(['ready_to_sale' => 'No','status'=>'Deactive'])
							->where(['item_id'=>$item_data->id,'add_from'=>'Web'])
							->execute(); 

					$query = $this->Items->ItemVariationMasters->query(); //pr($query); exit;
					$query->update()
							->set(['status'=>'Deactive'])
							->where(['item_id'=>$item_data->id,'add_from'=>'Web'])
							->execute();
				}
				if($tempActive==0){
					$query = $this->Items->query(); //pr($query); exit;
					$query->update()
							->set(['status'=>'Deactive'])
							->where(['Items.id'=>$item_data->id])
							->execute();
				}
				/* $checkUnitVaritations= $this->Items->ItemVariationMasters->find()->where(['ItemVariationMasters.item_id'=>$item_data->id]);
				if(sizeof($checkUnitVaritations)>0)
				{
					foreach($checkUnitVaritations as $checkUnitVaritation)
					{
						if(!in_array($checkUnitVaritation->unit_variation_id,$unitVariationIds))
						{
							$query1 = $this->Items->ItemVariationMasters->query();
							  $query1->update()
							  ->set(['status' =>'Deactive'])
							  ->where(['unit_variation_id'=>$checkUnitVaritation->unit_variation_id,'item_id'=>$item_data->id])
							  ->execute();
							 
							 $query1 = $this->Items->ItemVariations->query();
							  $query1->update()
							  ->set(['status' =>'Deactive','ready_to_sale'=>'No'])
							  ->where(['unit_variation_id'=>$checkUnitVaritation->unit_variation_id,'item_id'=>$item_data->id])
							  ->execute();
						}else{
							
							$query1 = $this->Items->ItemVariationMasters->query();
							  $query1->update()
							  ->set(['status' =>'Active'])
							  ->where(['unit_variation_id'=>$checkUnitVaritation->unit_variation_id,'item_id'=>$item_data->id])
							  ->execute();
						}
					}
				} */
                $this->Flash->success(__('The item has been saved.'));
                if(empty($dir_name))
                {// echo "save";  exit;
                	return $this->redirect(['controller'=>'Items','action' => 'index']);
                }
                else
                {
					return $this->redirect(['controller'=>'Items','action' => 'index']);
                	//$url = urlencode(serialize($dir_name));
                	//return $this->redirect(['action' => 'delete_file',$url]);
                }
               

                
            } //echo "No save";  exit;
			//pr($item); exit;
            $this->Flash->error(__('The item could not be saved. Please, try again.'));
        }
		$unitVariations = $this->Items->ItemVariationMasters->UnitVariations->find()->where(['UnitVariations.city_id'=>$city_id])->contain(['Units']);
		$unit_option=[];
		$i=0; foreach($unitVariations as $unitVariation){
			$unit_option[]=['text'=>$unitVariation->visible_variation ,'value'=>$unitVariation->id ];
		}
		//pr($unit_option); exit;
        $categories = $this->Items->Categories->find('list')->where(['Categories.city_id'=>$city_id]);
        $brands = $this->Items->Brands->find('list')->where(['Brands.city_id'=>$city_id]);
		
		$item_variation_masters=$this->Items->ItemVariationMasters->find()->where(['ItemVariationMasters.add_from'=>'Web','ItemVariationMasters.item_id'=>$id])->contain(['UnitVariations'=>['Units']]);
		
		
		$units1 = $this->Items->ItemVariationMasters->UnitVariations->Units->find()->where(['Units.city_id'=>$city_id]);
		foreach($units1 as $data){
			$unitsdata[]=['value'=>$data->id,'text'=>$data->shortname];
			
		}
		
		
		$unitVariations = $this->Items->ItemVariationMasters->UnitVariations->find()->where(['UnitVariations.city_id'=>$city_id])->contain(['Units']);
		$unit_option=[];
		$i=0; foreach($unitVariations as $unitVariation){
			//$show=$unitVariation->quantity_variation .' (' .$unitVariation->unit->shortname.')';
			if($unitVariation->id==1 || $unitVariation->id==2 ||$unitVariation->id==3){
				$unitVariation->visible_variation=$unitVariation->visible_variation.' (Fruit & Vegetable)';
			}
			$unit_option[]=['text'=>$unitVariation->visible_variation ,'value'=>$unitVariation->id ];
		}
		
		$Sellers[]=['text'=>'JainThela(Grocery)','value'=>'NULL'];
		$AllSellers = $this->Items->ItemVariations->Sellers->find()->where(['status'=>'Active']);
		foreach($AllSellers as $data){ 
			$Sellers[]=['text'=>$data->name,'value'=>$data->id];
		} //pr($Sellers);exit;
		
        $categories = $this->Items->Categories->find('list')->where(['Categories.city_id'=>$city_id]);
        $brands = $this->Items->Brands->find('list')->where(['Brands.city_id'=>$city_id])->order(['Brands.name' => 'ASC']);
		$categoryData = $this->Items->Categories->newEntity();
		$brandData = $this->Items->Brands->newEntity();
		$UnitVariationdata = $this->Items->ItemVariationMasters->UnitVariations->newEntity();
		 $parentCategories = $this->Items->Categories->ParentCategories->find('list')->where(['ParentCategories.city_id'=>$city_id])->order(['ParentCategories.name' => 'ASC']);
		$gstFigures =  $this->Items->GstFigures->find('list')->where(['city_id'=>$city_id]);
		
		//pr($item_variation_masters->toArray()); exit;
		$gstFigures =  $this->Items->GstFigures->find('list');
        $this->set(compact('item', 'categories', 'brands', 'admins', 'sellers', 'cities','unit_option','gstFigures','id','VariationMasterArr','img','item_variation_masters','Sellers','unitsdata','UnitVariationdata','brandData','parentCategories','categoryData','unit_option'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Item id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($dir)
    {
        $this->request->allowMethod(['post', 'delete']);
		$id = $this->EncryptingDecrypting->decryptData($dir);
        $item = $this->Items->get($id);
		$item->status='Deactive';
		
		
		$query = $this->Items->ItemVariationMasters->ItemVariations->query(); //pr($query); exit;
		$query->update()
				->set(['ready_to_sale' => 'No','status'=>'Deactive'])
				->where(['item_id'=>$id,'add_from'=>'Web'])
				->execute(); 

		$query = $this->Items->ItemVariationMasters->query(); //pr($query); exit;
		$query->update()
				->set(['status'=>'Deactive'])
				->where(['item_id'=>$id,'add_from'=>'Web'])
				->execute(); 
		//pr($item); exit;
		$ItemHistory=$this->Items->ItemHistories->newEntity();
		$ItemHistory->status='Deactive';
		$ItemHistory->item_id=$id;
		$t=date('H:i:s'); 
		$cr=(date("Y-m-d"));
		$ItemHistory->created_on=$cr;
		$ItemHistory->created_time=$t;
		$this->Items->ItemHistories->save($ItemHistory);
		//pr($ItemHistory); exit;
		
        if ($this->Items->save($item)) {
			
            $this->Flash->success(__('The item has been deleted.'));
        } else {
            $this->Flash->error(__('The item could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
	
	public function zeroRateItemDeactive($dir)
    {
        $this->request->allowMethod(['post', 'delete']);
		
		$id = $this->EncryptingDecrypting->decryptData($dir);
		//pr($id);exit;
        $item = $this->Items->get($id);
		$item->status='Deactive';
		
		
		$query = $this->Items->ItemVariationMasters->ItemVariations->query(); //pr($query); exit;
		$query->update()
				->set(['ready_to_sale' => 'No','status'=>'Deactive'])
				->where(['item_id'=>$id,'add_from'=>'Web'])
				->execute(); 

		$query = $this->Items->ItemVariationMasters->query(); //pr($query); exit;
		$query->update()
				->set(['status'=>'Deactive'])
				->where(['item_id'=>$id,'add_from'=>'Web'])
				->execute(); 
				
		//pr($item); exit;
		$ItemHistory=$this->Items->ItemHistories->newEntity();
		$ItemHistory->status='Deactive';
		$ItemHistory->item_id=$id;
		$t=date('H:i:s'); 
		$cr=(date("Y-m-d"));
		$ItemHistory->created_on=$cr;
		$ItemHistory->created_time=$t;
		$this->Items->ItemHistories->save($ItemHistory);
		//pr($ItemHistory); exit;
		
        if ($this->Items->save($item)) {
			
            $this->Flash->success(__('The item has been deleted.'));
        } else {
            $this->Flash->error(__('The item could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'ZeroItemRate']);
    }
	public function deleteParmanent($dir)
    {
        $this->request->allowMethod(['post', 'delete']);
		$id = $this->EncryptingDecrypting->decryptData($dir);
        $item = $this->Items->get($id);
		$item->status='Permanent';
        if ($this->Items->save($item)) {
            $this->Flash->success(__('The item has been deleted Permanent.'));
        } else {
            $this->Flash->error(__('The item could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
	
	public function deleteItemVariation(){
		$varId= $this->request->query('var_id');
		$ItemVariationMasters = $this->Items->ItemVariationMasters->get($varId);
		$ItemVariationMasters->status='Deactive';
        $this->Items->ItemVariationMasters->save($ItemVariationMasters);
		
		$query = $this->Items->ItemVariationMasters->ItemVariations->query(); //pr($query); exit;
		$query->update()
				->set(['ready_to_sale' => 'No'])
				->where(['item_variation_master_id'=>$varId])
				->execute();
		echo 'success'; exit;
		
	}
	public function checkItemExistance()
	{
		$itemName= $this->request->query('itemName');
		$category= $this->request->query('category');
		$edit_id = $this->request->query('edit_id');
		if(!empty($itemName))
		{
			$where['Items.name LIKE']='%'.$itemName.'%';
		}
		if(!empty($category))
		{
			$where['Items.category_id']=$category;
		}
		if(!empty($edit_id))
		{
			$where['Items.id !=']=$edit_id;
		}
		$isExist = $this->Items->find()->where(@$where)->count();
		if($isExist>0)
		{
			echo 'exist'; 
		}
		else
		{
			echo 'not_exist';
		}
		exit;
	}
		
		
	public function SalesReport()
    { 
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id'); 
		//$location_id=$this->Auth->User('location_id'); 
		$this->viewBuilder()->layout('super_admin_layout');
		$location_id = $this->request->query('location_id');
		$seller_id = $this->request->query('seller_id');
		$gst_figure_id = $this->request->query('gst_figure_id');
		$from_date = $this->request->query('from_date');
		$to_date   = $this->request->query('to_date');
		$CityData = $this->Items->Cities->get($city_id);
		
		if(empty($from_date) || empty($to_date))
		{
			$from_date = date("Y-m-01");
			$to_date   = date("Y-m-d");
		}else{
			$from_date = date("Y-m-d",strtotime($from_date));
			$to_date= date("Y-m-d",strtotime($to_date));
		}
		if(!empty($from_date))
		{
			$from_date = date("Y-m-d",strtotime($from_date));
			$where['Invoices.transaction_date >=']=$from_date;
		}
		if(!empty($to_date))
		{
			$to_date   = date("Y-m-d",strtotime($to_date));
			$where['Invoices.transaction_date <=']=$to_date;
		}
		if(!empty($location_id))
		{
			//$to_date   = date("Y-m-d",strtotime($to_date));
			$where['Invoices.location_id']=$location_id;
			$where['Invoices.invoice_status']='Done';
			
		}
		if($gst_figure_id){ 
			 $orders=$this->Items->Invoices->find()->contain(['Orders','Locations','PartyLedgers'=>['CustomerData'],'InvoiceRows'=>function ($q) use($gst_figure_id) {
							return $q->where(['InvoiceRows.gst_figure_id'=>$gst_figure_id])->contain(['GstFigures','Items']);
						}])->where($where);
						
			 $orders->innerJoinWith('InvoiceRows',function ($q) use($gst_figure_id) {
							return $q->where(['InvoiceRows.gst_figure_id'=>$gst_figure_id])->contain(['GstFigures']);
						})->group('InvoiceRows.invoice_id')
					->autoFields(true);

			//pr($orders->toArray()); exit;
		}else{
			$orders = $this->Items->Invoices->find()->contain(['Orders','InvoiceRows','Locations','PartyLedgers'=>['CustomerData']])->where($where)->where(['Invoices.location_id'=>$location_id]);
		}
		
		$Invoices=$this->Items->Invoices->find()->contain(['InvoiceRows'=>function ($query) use($gst_figure_id) {
							return $query->select(['invoice_id','gst_value','taxable_value','gst_figure_id',
				'TotalGSTAmount' => $query->func()->sum('InvoiceRows.gst_value'),
				'Totaltaxable_value' => $query->func()->sum('InvoiceRows.taxable_value'),
			])->group('InvoiceRows.gst_figure_id');
						},'Customers'=>['Cities'=>function ($q) use($CityData) {
									return $q->where(['Cities.state_id'=>$CityData->state_id]);
								}]])->where($where);
								
		$InvoicesIgst=$this->Items->Invoices->find()->contain(['InvoiceRows'=>function ($query) use($gst_figure_id) {
							return $query->select(['invoice_id','gst_value','taxable_value','gst_figure_id',
				'TotalIGSTAmount' => $query->func()->sum('InvoiceRows.gst_value'),
				'TotalIGSTtaxable_value' => $query->func()->sum('InvoiceRows.taxable_value'),
			])->group('InvoiceRows.gst_figure_id');
						},'Customers'=>['Cities'=>function ($q) use($CityData) {
									return $q->where(['Cities.state_id != '=>$CityData->state_id]);
								}]])->where($where);
		$TotalgstTaxable=[];
		$TotalgstTax=[];
		foreach($Invoices as $data1){ 
			foreach($data1->invoice_rows as $data2){
				@$TotalgstTaxable[$data2->gst_figure_id]+=@$data2->Totaltaxable_value;
				@$TotalgstTax[$data2->gst_figure_id]+=@$data2->TotalGSTAmount;
			}
		}
		
		$TotalIgstTaxable=[];
		$TotalIgstTax=[];
		foreach($InvoicesIgst as $data3){ 
			foreach($data3->invoice_rows as $data4){
				@$TotalIgstTaxable[$data4->gst_figure_id]+=@$data4->TotalIGSTtaxable_value;
				@$TotalIgstTax[$data4->gst_figure_id]+=@$data4->TotalIGSTAmount;
			}
		}
	
		
		$Locations = $this->Items->Orders->Locations->find('list')->where(['city_id'=>$city_id]);
		//$Sellers = $this->Items->Sellers->find('list')->where(['city_id'=>$city_id]);
		$GstFigures = $this->Items->GstFigures->find('list')->where(['city_id'=>$city_id]);
		$GstFiguresData = $this->Items->GstFigures->find()->where(['city_id'=>$city_id]);
		
		$this->set(compact('from_date','to_date','orders','Locations','location_id','gst_figure_id','Sellers','GstFigures','GstFiguresData','TotalgstTaxable','TotalgstTax','TotalIgstTaxable','TotalIgstTax','CityData'));
	}		
	public function SalesReturnReport()
    { 
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id'); 
		//$location_id=$this->Auth->User('location_id'); 
		$this->viewBuilder()->layout('super_admin_layout');
		$location_id = $this->request->query('location_id');
		$seller_id = $this->request->query('seller_id');
		$gst_figure_id = $this->request->query('gst_figure_id');
		$from_date = $this->request->query('from_date');
		$to_date   = $this->request->query('to_date');
		$CityData = $this->Items->Cities->get($city_id);
		
		if(empty($from_date) || empty($to_date))
		{
			$from_date = date("Y-m-01");
			$to_date   = date("Y-m-d");
		}else{
			$from_date = date("Y-m-d",strtotime($from_date));
			$to_date= date("Y-m-d",strtotime($to_date));
		}
		if(!empty($from_date))
		{
			$from_date = date("Y-m-d",strtotime($from_date));
			$where['SaleReturns.transaction_date >=']=$from_date;
		}
		if(!empty($to_date))
		{
			$to_date   = date("Y-m-d",strtotime($to_date));
			$where['SaleReturns.transaction_date <=']=$to_date;
		}
		if(!empty($location_id))
		{
			//$to_date   = date("Y-m-d",strtotime($to_date));
			//$where['SaleReturns.location_id']=$location_id;
			//$where['SaleReturns.invoice_status']='Done';
			
		}
		if($gst_figure_id){ 
			 $orders=$this->Items->SaleReturns->find()->contain(['Locations','PartyLedgers'=>['CustomerData'],'SaleReturnRows'=>function ($q) use($gst_figure_id) {
							return $q->where(['SaleReturnRows.gst_figure_id'=>$gst_figure_id])->contain(['GstFigures','Items']);
						}])->where($where);
						
			 $orders->innerJoinWith('SaleReturnRows',function ($q) use($gst_figure_id) {
							return $q->where(['SaleReturnRows.gst_figure_id'=>$gst_figure_id])->contain(['GstFigures']);
						})->group('SaleReturnRows.sale_return_id')
					->autoFields(true);

			//
		}else{
			$orders = $this->Items->SaleReturns->find()->contain(['Invoices','SaleReturnRows','PartyLedgers'=>['CustomerData']])->where($where);
		}
		
		$Invoices=$this->Items->SaleReturns->find()
			->contain(['SaleReturnRows'=>function ($query) use($gst_figure_id) {
							return $query->select(['sale_return_id','gst_value','taxable_value','gst_figure_id',
				'TotalGSTAmount' => $query->func()->sum('SaleReturnRows.gst_value'),
				'Totaltaxable_value' => $query->func()->sum('SaleReturnRows.taxable_value'),
			])->group('SaleReturnRows.gst_figure_id');
						},'Customers'=>['Cities'=>function ($q) use($CityData) {
									return $q->where(['Cities.state_id'=>$CityData->state_id]);
								}]])->where($where);
						
		$InvoicesIgst=$this->Items->SaleReturns->find()->contain(['SaleReturnRows'=>function ($query) use($gst_figure_id) {
							return $query->select(['sale_return_id','gst_value','taxable_value','gst_figure_id',
				'TotalIGSTAmount' => $query->func()->sum('SaleReturnRows.gst_value'),
				'TotalIGSTtaxable_value' => $query->func()->sum('SaleReturnRows.taxable_value'),
			])->group('SaleReturnRows.gst_figure_id');
						},'Customers'=>['Cities'=>function ($q) use($CityData) {
									return $q->where(['Cities.state_id != '=>$CityData->state_id]);
								}]])->where($where);
		
		$TotalgstTaxable=[];
		$TotalgstTax=[];
		foreach($Invoices as $data1){ 
			foreach($data1->sale_return_rows as $data2){
				@$TotalgstTaxable[$data2->gst_figure_id]+=@$data2->Totaltaxable_value;
				@$TotalgstTax[$data2->gst_figure_id]+=@$data2->TotalGSTAmount;
			}
		}
		
		$TotalIgstTaxable=[];
		$TotalIgstTax=[];
		foreach($InvoicesIgst as $data3){ 
			foreach($data3->sale_return_rows as $data4){
				@$TotalIgstTaxable[$data4->gst_figure_id]+=@$data4->TotalIGSTtaxable_value;
				@$TotalIgstTax[$data4->gst_figure_id]+=@$data4->TotalIGSTAmount;
			}
		}
	
		
		$Locations = $this->Items->Orders->Locations->find('list')->where(['city_id'=>$city_id]);
		//$Sellers = $this->Items->Sellers->find('list')->where(['city_id'=>$city_id]);
		$GstFigures = $this->Items->GstFigures->find('list')->where(['city_id'=>$city_id]);
		$GstFiguresData = $this->Items->GstFigures->find()->where(['city_id'=>$city_id]);
		
		$this->set(compact('from_date','to_date','orders','Locations','location_id','gst_figure_id','Sellers','GstFigures','GstFiguresData','TotalgstTaxable','TotalgstTax','TotalIgstTaxable','TotalIgstTax','CityData'));
	}
	
		public function PurchaseReport()
    { 
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id'); 
		$location_id=$this->Auth->User('location_id'); 
		$this->viewBuilder()->layout('super_admin_layout');
		$location_id = $this->request->query('location_id');
		$gst_figure_id = $this->request->query('gst_figure_id');
		$from_date = $this->request->query('from_date');
		$to_date   = $this->request->query('to_date');
		if(empty($from_date) || empty($to_date))
		{
			$from_date = date("Y-m-01");
			$to_date   = date("Y-m-d");
		}else{
			$from_date = date("Y-m-d",strtotime($from_date));
			$to_date= date("Y-m-d",strtotime($to_date));
		}
		if(!empty($from_date))
		{
			$from_date = date("Y-m-d",strtotime($from_date));
			$where['PurchaseInvoices.transaction_date >=']=$from_date;
		}
		if(!empty($to_date))
		{
			$to_date   = date("Y-m-d",strtotime($to_date));
			$where['PurchaseInvoices.transaction_date <=']=$to_date;
			$where['PurchaseInvoices.city_id ']=$city_id;
		}
		
		if($gst_figure_id){ 
			 $PurchaseInvoices=$this->Items->PurchaseInvoices->find()->contain(['SellerLedgers'=>['SellerData'],'PurchaseInvoiceRows'=>function ($q) use($gst_figure_id) {
							return $q->where(['PurchaseInvoiceRows.gst_figure_id'=>$gst_figure_id])->contain(['GstFigures','Items']);
						}])->where($where);
						
			 $PurchaseInvoices->innerJoinWith('PurchaseInvoiceRows',function ($q) use($gst_figure_id) {
							return $q->where(['PurchaseInvoiceRows.gst_figure_id'=>$gst_figure_id])->contain(['GstFigures']);
						})->group('PurchaseInvoiceRows.purchase_invoice_id')
					->autoFields(true);

			//pr($PurchaseInvoices->toArray()); exit;
		}else{
			$PurchaseInvoices = $this->Items->PurchaseInvoices->find()->contain(['SellerLedgers'=>['SellerData']])->where($where)->where(['PurchaseInvoices.city_id'=>$city_id]);
			//pr($orders->toArray()); exit;
		}
		
		//pr($PurchaseInvoices->toArray()); exit;
		//pr($from_date); exit;
		//$PurchaseInvoices = $this->Items->PurchaseInvoices->find()->contain(['Cities','SellerLedgers'=>['SellerData']])->where($where);
		//$Locations = $this->Items->Orders->Locations->find('list');
		$GstFigures = $this->Items->GstFigures->find('list')->where(['city_id'=>$city_id]);
		$this->set(compact('from_date','to_date','PurchaseInvoices','Locations','gst_figure_id','location_id','GstFigures'));
	}
		
		public function PurchaseReturnReport()
    { 
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id'); 
		$location_id=$this->Auth->User('location_id'); 
		$this->viewBuilder()->layout('super_admin_layout');
		$location_id = $this->request->query('location_id');
		$gst_figure_id = $this->request->query('gst_figure_id');
		$from_date = $this->request->query('from_date');
		$to_date   = $this->request->query('to_date');
		if(empty($from_date) || empty($to_date))
		{
			$from_date = date("Y-m-01");
			$to_date   = date("Y-m-d");
		}else{
			$from_date = date("Y-m-d",strtotime($from_date));
			$to_date= date("Y-m-d",strtotime($to_date));
		}
		if(!empty($from_date))
		{
			$from_date = date("Y-m-d",strtotime($from_date));
			$where['PurchaseReturns.transaction_date >=']=$from_date;
		}
		if(!empty($to_date))
		{
			$to_date   = date("Y-m-d",strtotime($to_date));
			$where['PurchaseReturns.transaction_date <=']=$to_date;
			$where['PurchaseReturns.city_id ']=$city_id;
		}
		
		if($gst_figure_id){ 
			 $PurchaseInvoices=$this->Items->PurchaseReturns->find()->contain(['SellerLedgers'=>['SellerData'],'PurchaseInvoiceRows'=>function ($q) use($gst_figure_id) {
							return $q->where(['PurchaseReturnRows.gst_figure_id'=>$gst_figure_id])->contain(['GstFigures','Items']);
						}])->where($where);
						
			 $PurchaseInvoices->innerJoinWith('PurchaseReturnRows',function ($q) use($gst_figure_id) {
							return $q->where(['PurchaseReturnRows.gst_figure_id'=>$gst_figure_id])->contain(['GstFigures']);
						})->group('PurchaseReturnRows.purchase_return_id')
					->autoFields(true);

			//pr($PurchaseInvoices->toArray()); exit;
		}else{
			$PurchaseInvoices = $this->Items->PurchaseReturns->find()->contain(['SellerLedgers'=>['SellerData']])->where($where)->where(['PurchaseReturns.city_id'=>$city_id]);
			//pr($orders->toArray()); exit;
		}
		
		//pr($PurchaseInvoices->toArray()); exit;
		//pr($from_date); exit;
		//$PurchaseInvoices = $this->Items->PurchaseInvoices->find()->contain(['Cities','SellerLedgers'=>['SellerData']])->where($where);
		//$Locations = $this->Items->Orders->Locations->find('list');
		$GstFigures = $this->Items->GstFigures->find('list')->where(['city_id'=>$city_id]);
		$this->set(compact('from_date','to_date','PurchaseInvoices','Locations','gst_figure_id','location_id','GstFigures'));
	}
	
		public function consolidateReport()
    {
		$city_id=$this->Auth->User('city_id');
		$user_id=$this->Auth->User('id');
		$this->viewBuilder()->layout('super_admin_layout');
	
		$city_id=$this->request->query('city_id');
		$location_id=$this->request->query('location_id');
		$item_id=$this->request->query('item_id');
		$category_id=$this->request->query('category_id');
		$seller_id=$this->request->query('seller_id');
		$from_date = $this->request->query('from_date');
		$to_date   = $this->request->query('to_date');
		$from_date = date("Y-m-d",strtotime($from_date));
		$to_date   = date("Y-m-d",strtotime($to_date));
		if($from_date=="1970-01-01"){
			$from_date = date("Y-m-d");
			$to_date   = date("Y-m-d");
		}
		$transaction_date=$to_date;
		$where1=[];
		$where2=[];
		
		if(!empty($item_id))
		{
			$where1['InvoiceRows.item_variation_id']=$item_id;
			
			$ItemVarData = $this->Items->ItemVariations->get($item_id);
			$where2['GrnRows.unit_variation_id']=$ItemVarData->unit_variation_id;
			$where2['GrnRows.item_id']=$ItemVarData->item_id;
			//pr($ItemVarData); exit;
		}
		if(!empty($category_id))
		{
			$where1['Items.category_id']=$category_id;
		}
		
		$itemList=$this->Items->find()->contain(['ItemVariations'=>['UnitVariations']]);
		//pr($itemList->toArray()); exit;
		$items=array();
		foreach($itemList as $data1){ 
			foreach($data1->item_variations as $data){
				if(empty($data->seller_id)){
					$merge=$data1->name.'('.@$data->unit_variation->visible_variation.')';
					$items[]=['text' => $merge,'value' => $data->id,'seller_id'=>$data->seller_id];
				}
			}
		}
		 //pr($items); exit; 
		$OrderDetails=$this->Items->Invoices->InvoiceRows->find()
			->innerJoinWith('ItemVariations.UnitVariations')
			->innerJoinWith('ItemVariations.Items')
			->innerJoinWith('ItemVariations')
			->innerJoinWith('Invoices',function($q) use($from_date,$to_date){
				return $q->where(['Invoices.invoice_status'=>'Done','Invoices.transaction_date >='=>$from_date, 'Invoices.transaction_date <='=>$to_date,'Invoices.seller_id IS NULL']);
			})
			->order(['Items.name'=>'ASC'])
			->select([
				'item_name'=>'Items.name',
				'item_id'=>'Items.id',
				'item_variation_id'=>'ItemVariations.id',
				'unit_variation_id'=>'UnitVariations.id',
				'unit_variation_name'=>'UnitVariations.visible_variation',
				'convert_unit_qty'=>'UnitVariations.convert_unit_qty',
				'order_quantity'=>'InvoiceRows.quantity',
				'net_amount'=>'InvoiceRows.net_amount',
			])->where($where1);
		
		$QRdatas=[]; 
		$unit_variation_datas=[];
		$QRitemName=[];
		$OrderCount=[];
		$QRrate=[];
		$QRqty=[];
		$GrnQty=[];
		$GrnRate=[];
		$QRrate1=0;
		foreach($OrderDetails as $OrderDetail){ 
			@$QRdatas[$OrderDetail->item_variation_id]=$OrderDetail->item_variation_id;
			@$unit_variation_names[$OrderDetail->item_variation_id]=@$OrderDetail->unit_variation_name;
			$QRitemName[$OrderDetail->item_variation_id]=$OrderDetail->item_name;
			@$QRrate[$OrderDetail->item_variation_id]+=$OrderDetail->net_amount;
			@$QRrate1+=$OrderDetail->net_amount;
			@$QRqty[$OrderDetail->item_variation_id]+=$OrderDetail->order_quantity;
		}
		
		//pr($QRrate1); exit; 
		
		
		$GrnDetails=$this->Items->Grns->GrnRows->find()
			->innerJoinWith('UnitVariations')
			->innerJoinWith('Items')
			->innerJoinWith('Grns',function($q) use($from_date,$to_date){
				return $q->where(['Grns.transaction_date >='=>$from_date, 'Grns.transaction_date <='=>$to_date]);
			})
			->order(['Items.name'=>'ASC'])
			->select([
				'item_name'=>'Items.name',
				'item_id'=>'Items.id',
				'unit_variation_id'=>'UnitVariations.id',
				'unit_variation_name'=>'UnitVariations.visible_variation',
				'convert_unit_qty'=>'UnitVariations.convert_unit_qty',
				'order_quantity'=>'GrnRows.quantity',
				'net_amount'=>'GrnRows.net_amount',
			])->where($where2);
		
		
		foreach($GrnDetails as $GrnDetail){
			$Iv=$this->Items->ItemVariations->find()->where(['item_id'=>$GrnDetail->item_id,'unit_variation_id'=>$GrnDetail->unit_variation_id])->first();
			@$QRdatas[$Iv->id]=$Iv->id;
			$QRitemName[$Iv->id]=$GrnDetail->item_name;
			@$unit_variation_names[$Iv->id]=@$GrnDetail->unit_variation_name; 
			@$GrnRate[$Iv->id]+=$GrnDetail->net_amount;
			@$GrnQty[$Iv->id]+=$GrnDetail->order_quantity;
		} 
		
		
		
		$Brands = $this->Items->Brands->find('list');
		$Categories = $this->Items->Categories->find('list')->where(['parent_id IS NOT NULL']);
		$this->set(compact('Locations','Cities','showItems','city_id','location_id','Sellers','seller_id','from_date','to_date','Categories','Brands','brand_id','QRdatas','unit_variation_datas','unit_variation_names','QRitemName','QRrate','QRqty','GrnRate','GrnQty','category_id','brand_id','items','item_id'));
	}
	
	public function consolidateReportNew()
    { 
		$city_id=$this->Auth->User('city_id');
		$user_id=$this->Auth->User('id');
		$this->viewBuilder()->layout('super_admin_layout');
	
		$city_id=$this->request->query('city_id');
		$location_id=$this->request->query('location_id');
		$item_id=$this->request->query('item_id');
		$category_id=$this->request->query('category_id');
		$seller_id=$this->request->query('seller_id');
		$from_date = $this->request->query('from_date');
		$to_date   = $this->request->query('to_date');
		$from_date = date("Y-m-d",strtotime($from_date));
		$to_date   = date("Y-m-d",strtotime($to_date));
		if($from_date=="1970-01-01"){
			$from_date = date("Y-m-d");
			$to_date   = date("Y-m-d");
		}
		$transaction_date=$to_date;
		$where1=[];
		$where2=[];
		
		if(!empty($item_id))
		{
			$where1['InvoiceRows.item_variation_id']=$item_id;
			
			$ItemVarData = $this->Items->ItemVariations->get($item_id);
			$where2['GrnRows.unit_variation_id']=$ItemVarData->unit_variation_id;
			$where2['GrnRows.item_id']=$ItemVarData->item_id;
			//pr($ItemVarData); exit;
		}
		if(!empty($category_id))
		{
			$where1['Items.category_id']=$category_id;
		}
		
		$itemList=$this->Items->find()->contain(['ItemVariations'=>['UnitVariations']]);
		//pr($from_date); exit;
		$items=array();
		foreach($itemList as $data1){ 
			foreach($data1->item_variations as $data){
				if(($data->seller_id)){
					$merge=$data1->name.'('.@$data->unit_variation->visible_variation.')';
					$items[]=['text' => $merge,'value' => $data->id,'seller_id'=>$data->seller_id];
				}
			}
		}
		//pr($items); exit;
		$OrderDetails=$this->Items->Invoices->InvoiceRows->find()
			->innerJoinWith('ItemVariations.UnitVariations')
			->innerJoinWith('ItemVariations.Items')
			->innerJoinWith('ItemVariations')
			->innerJoinWith('Invoices',function($q) use($from_date,$to_date){
				return $q->where(['Invoices.invoice_status'=>'Done','Invoices.transaction_date >='=>$from_date, 'Invoices.transaction_date <='=>$to_date,'Invoices.seller_id'=>3]);
			})
			->order(['Items.name'=>'ASC'])
			->select([
				'item_name'=>'Items.name',
				'item_id'=>'Items.id',
				'item_variation_id'=>'ItemVariations.id',
				'unit_variation_id'=>'UnitVariations.id',
				'unit_variation_name'=>'UnitVariations.visible_variation',
				'convert_unit_qty'=>'UnitVariations.convert_unit_qty',
				'order_quantity'=>'InvoiceRows.quantity',
				'net_amount'=>'InvoiceRows.net_amount',
			])->where($where1);
		
		$QRdatas=[]; 
		$unit_variation_datas=[];
		$QRitemName=[];
		$OrderCount=[];
		$QRrate=[];
		$QRqty=[];
		$GrnQty=[];
		$GrnRate=[];
		foreach($OrderDetails as $OrderDetail){ 
			@$QRdatas[$OrderDetail->item_variation_id]=$OrderDetail->item_variation_id;
			@$unit_variation_names[$OrderDetail->item_variation_id]=@$OrderDetail->unit_variation_name;
			$QRitemName[$OrderDetail->item_variation_id]=$OrderDetail->item_name;
			@$QRrate[$OrderDetail->item_variation_id]+=$OrderDetail->net_amount;
			@$QRqty[$OrderDetail->item_variation_id]+=$OrderDetail->order_quantity;
		}
		
		/* 
		
		
		$GrnDetails=$this->Items->Grns->GrnRows->find()
			->innerJoinWith('UnitVariations')
			->innerJoinWith('Items')
			->order(['Items.name'=>'ASC'])
			->select([
				'item_name'=>'Items.name',
				'item_id'=>'Items.id',
				'unit_variation_id'=>'UnitVariations.id',
				'unit_variation_name'=>'UnitVariations.visible_variation',
				'convert_unit_qty'=>'UnitVariations.convert_unit_qty',
				'order_quantity'=>'GrnRows.quantity',
				'net_amount'=>'GrnRows.net_amount',
			])->where($where2);
		
		
		foreach($GrnDetails as $GrnDetail){
			$Iv=$this->Items->ItemVariations->find()->where(['item_id'=>$GrnDetail->item_id,'unit_variation_id'=>$GrnDetail->unit_variation_id])->first();
			@$QRdatas[$Iv->id]=$Iv->id;
			$QRitemName[$Iv->id]=$GrnDetail->item_name;
			@$unit_variation_names[$Iv->id]=@$GrnDetail->unit_variation_name; 
			@$GrnRate[$Iv->id]+=$GrnDetail->net_amount;
			@$GrnQty[$Iv->id]+=$GrnDetail->order_quantity;
		} 
		 */
		
		
		$Brands = $this->Items->Brands->find('list');
		$Categories = $this->Items->Categories->find('list')->where(['parent_id IS NOT NULL']);
		$this->set(compact('Locations','Cities','showItems','city_id','location_id','Sellers','seller_id','from_date','to_date','Categories','Brands','brand_id','QRdatas','unit_variation_datas','unit_variation_names','QRitemName','QRrate','QRqty','GrnRate','GrnQty','category_id','brand_id','items','item_id'));
	}
	
	public function fetchLedger($item_id=null)
    { 
		$city_id=$this->Auth->User('city_id');
		$user_id=$this->Auth->User('id');
		$this->viewBuilder()->layout('');
	
		$city_id=$this->request->query('city_id');
		$location_id=$this->request->query('location_id');
		$brand_id=$this->request->query('brand_id');
		$category_id=$this->request->query('category_id');
		$seller_id=$this->request->query('seller_id');
		//$item_id=$this->request->query('item_id');
		
		$from_date =  date("Y-m-d",strtotime($this->request->query('from_date')));
		$to_date   =  date("Y-m-d",strtotime($this->request->query('to_date')));
		$transaction_date=$to_date;
		
		
		if(!empty($item_id))
		{
			$where['ItemLedgers.item_variation_id']=$item_id;
			//$where2['GrnRows.item_variation_id']=$item_id;
		}
		 $itemLedgers = $this->Items->ItemLedgers->find()->where($where)->order(['ItemLedgers.transaction_date'=>'DESC'])->contain(['Invoices'=>['Challans']]);
		//pr($itemLedgers2->toArray()); exit;
		
		
		$Brands = $this->Items->Brands->find('list');
		$Categories = $this->Items->Categories->find('list')->where(['parent_id IS NOT NULL']);
		$this->set(compact('Locations','Cities','showItems','city_id','location_id','Sellers','seller_id','from_date','to_date','Categories','Brands','brand_id','QRdatas','unit_variation_datas','unit_variation_names','itemLedgers'));
	}	
	public function ItemVariationWiseReoprt(){
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id'); 
		$this->viewBuilder()->layout('super_admin_layout');
		
		//$Items=$this->Items->find()->contain(['ItemVariations'])->toArray();
		$Items=$this->Items->find()
			->contain(['ItemVariations'=>function($q) {
				return $q->where(['ItemVariations.status'=>'Active','seller_id'=>3])->contain(['UnitVariations'=>['Units']]);
			}])->order(['Items.name'=>'ASC']);
		$this->set(compact('Items'));
	}
	
	public function fetchLedgerFruits($item_id,$from_date,$to_date)
    { 
		$city_id=$this->Auth->User('city_id');
		$user_id=$this->Auth->User('id');
		$this->viewBuilder()->layout('');
	
		$city_id=$this->request->query('city_id');
		$location_id=$this->request->query('location_id');
		$brand_id=$this->request->query('brand_id');
		$category_id=$this->request->query('category_id');
		$seller_id=$this->request->query('seller_id');
		//$item_id=$this->request->query('item_id');
		
		//$from_date =  date("Y-m-d",strtotime($this->request->query('from_date')));
		//$to_date   =  date("Y-m-d",strtotime($this->request->query('to_date')));
		$transaction_date=$to_date;
		$where=[];
		$where2=[];
		
		
		if(!empty($item_id))
		{
			$where['InvoiceRows.item_variation_id']=$item_id;
			//$where2['GrnRows.item_variation_id']=$item_id;
		}
		if(!empty($from_date))
		{
			$from_date = date("Y-m-d",strtotime($from_date));
			$where2['Invoices.transaction_date >=']=$from_date;
		}
		if(!empty($to_date))
		{
			$to_date   = date("Y-m-d",strtotime($to_date));
			$where2['Invoices.transaction_date <=']=$to_date;
			
		}
		 $itemLedgers = $this->Items->Invoices->InvoiceRows
		 ->find()->contain(['Invoices'=>function ($q)use($where2) {
							return $q->where($where2)->contain(['Challans']);
						}])
		 ->where($where)->order(['InvoiceRows.id'=>'DESC']);
		//pr($where2);
		//pr($itemLedgers->toArray()); exit;
		
		
		$Brands = $this->Items->Brands->find('list');
		$Categories = $this->Items->Categories->find('list')->where(['parent_id IS NOT NULL']);
		$this->set(compact('Locations','Cities','showItems','city_id','location_id','Sellers','seller_id','from_date','to_date','Categories','Brands','brand_id','QRdatas','unit_variation_datas','unit_variation_names','itemLedgers'));
	}
}
