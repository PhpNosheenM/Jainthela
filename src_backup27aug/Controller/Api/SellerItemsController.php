<?php
namespace App\Controller\Api;
use Cake\Event\Event;
use Cake\Network\Exception\UnauthorizedException;
use Cake\Utility\Security;
use Firebase\JWT\JWT;


class SellerItemsController extends AppController
{

 public function initialize()
  {
    parent::initialize();
	$this->Auth->allow(['searchSuggestionweb','brandCategory','productDetail','itemList','addItemRating','ratingList','searchSuggestion','searchResult','sellerItem','popularItem']);
  }
  
  
	public function popularItem()
	{
      $page=@$this->request->query['page'];
	  $city_id=$this->request->query('city_id');
      $customer_id=$this->request->query('customer_id');
	  $popularItems = $this->SellerItems->Items->Orders->OrderDetails->find();
      $popularItems->select(['item_id','count' => $popularItems->func()->count('item_id')])->group('item_id');
	  $cart_item_count = 0;
	  $total_items = 0;
	  $limit=20;
		$item_ids = [];
	  if(!empty($popularItems->toArray())){
			foreach($popularItems as $popularItem)
			{
				$item_ids[] = $popularItem->item_id; 
			}
			
			if(empty($item_ids))
			{
				$whereItemIds = '';
			}
			else { $whereItemIds =  ['SellerItems.item_id IN' =>$item_ids];  }	

		
	  $isValidCity = $this->CheckAvabiltyOfCity($city_id);
      if($isValidCity == 0)
      {
        $cart_item_count = $this->SellerItems->Items->Carts->find('All')
		->where(['Carts.customer_id'=>$customer_id])->count();

        $total_items = $this->SellerItems->find()->contain(['Sellers','Items' => function($q){
					return $q->where(['Items.status'=>'Active'])->order(['Items.name'=>'ASC']);
				}])->where(['SellerItems.city_id' => $city_id,'SellerItems.status'=>'Active'])
		->where($whereItemIds)->count();


        $sellerItem = $this->SellerItems->find();
         $sellerItem->contain(['Sellers','ItemRating' => function($q) use($sellerItem) {
					return $q->select(['ItemRating.item_id','ItemRating.id','AverageReviewRatings.item_id','ItemAverageRating' => $sellerItem->func()->avg('AverageReviewRatings.rating')])
					->leftJoinWith('AverageReviewRatings');
				},'Items' => function($q){
					return $q->where(['Items.status'=>'Active'])->order(['Items.name'=>'ASC']);
				} ,'ItemVariations' => function($q){
					return $q->contain(['UnitVariations'=>['Units'],'ItemVariationMasters'])->where(['ItemVariations.ready_to_sale'=>'Yes']);
				} ])
		->select(['sellerItemCount'=>$sellerItem->func()->count('ItemVariations.seller_item_id')])
		->innerJoinWith('ItemVariations')
		->having(['sellerItemCount' > 0])	
		->where(['SellerItems.city_id' => $city_id,'SellerItems.status'=>'Active'])
		->where($whereItemIds)
		->group(['SellerItems.id'])
		->limit($limit)
		->page($page)
		->order(['Items.name'=>'ASC'])
		->autoFields(true);
		//pr($sellerItem->toArray());exit;
        if(!empty($sellerItem->toArray()))
        {
			foreach($sellerItem as $item){
			  $item->ItemAverageRating = number_format($item->ItemAverageRating,1);
			  foreach ($item->item_variations as $items_variation_data) {
              $item_id=$item->item->id;
              $items_variation_id = $items_variation_data->id;

				// start maximum_quantity_purchase update
				$items_variation_data->maximum_quantity_purchase = round($items_variation_data->maximum_quantity_purchase);
				$cs = $items_variation_data->current_stock;
				$vs = $items_variation_data->virtual_stock;
				$ds = $items_variation_data->demand_stock;
				$mqp = $items_variation_data->maximum_quantity_purchase;
				
				$stock = 0.00;
				
				$stock = $cs + $vs - $ds;
				
				if($stock > $mqp)
				{
					$items_variation_data->maximum_quantity_purchase = $mqp;
				}
				else if($mqp > $stock)
				{
					$items_variation_data->maximum_quantity_purchase = $stock;
				}
				else {
					$items_variation_data->maximum_quantity_purchase = $mqp;
				}
				
				// end maximum_quantity_purchase update


			  
			   $inWishList = 0;
              $inWishList = $this->SellerItems->Items->WishListItems->find()->where(['item_id'=>$item_id,'item_variation_id'=>$items_variation_id])
              ->contain(['WishLists'=>function($q) use($customer_id){
                return $q->select(['WishLists.customer_id'])->where(['customer_id'=>$customer_id]);}])->count();
                $items_variation_data->inWishList = false;
                if($inWishList  >= 1)
                { $items_variation_data->inWishList = true; }
                else { $items_variation_data->inWishList = false; }
				
				
				$inNotifylist = 0;
				$inNotifylist = $this->SellerItems->Items->Notifies->find()
				    ->where(['item_id'=>$item_id,'item_variation_id'=>$items_variation_id])
			        ->where(['customer_id'=>$customer_id])->count();
                $items_variation_data->inNotifylist = false;
                if($inNotifylist  >= 1)
                { $items_variation_data->inNotifylist = true; }
                else { $items_variation_data->inNotifylist = false; }
				

                $count_cart = $this->SellerItems->Items->Carts->find()->select(['Carts.cart_count'])->where(['Carts.item_variation_id'=>$items_variation_data->id,'Carts.customer_id'=>$customer_id]);
				 $count_value = 0;
                foreach ($count_cart as $count) {
                  $count_value = $count->cart_count;
                }
                $items_variation_data->cart_count = $count_value;
              }
            }
            $success = true;
            $message = 'Data Found Successfully';
          }
          else {
            $success = false;
            $message = 'Record not found';
          }
        }else {
          $success = false;
          $message = 'Invalid City';
        }
		
		}else {
          $success = false;
		  $sellerItem =[];
          $message = 'No Item Found';
        }
	  $this->set(compact('success','message','cart_item_count','total_items','sellerItem'));
      $this->set('_serialize', ['success','message','total_items','cart_item_count','sellerItem']);
	  
	}

  public function itemList($category_id=null,$city_id=null,$brand_id=null,$seller_id=null,$page=null)
  {
    $city_id = @$this->request->query['city_id'];
    $category_id = @$this->request->query['category_id'];
    $brand_id = @$this->request->query['brand_id'];
    $customer_id = @$this->request->query['customer_id'];
    $page=@$this->request->query['page'];
    $seller_id = @$this->request->query['seller_id'];
    $cart_item_count = 0;
	$total_items = 0;
    if(!empty($seller_id)) { $sellerWhere = ['seller_id' =>$seller_id]; } else {$sellerWhere ='';}
    $limit=20;
    $sellerItem = [];
    $filters = [];
    if(!empty($city_id) && (!empty($page)))
    {
      // CheckAvabiltyOfCity function is avaliable in app controller for checking city_id in cities table
      $isValidCity = $this->CheckAvabiltyOfCity($city_id);
      if($isValidCity == 0)
      {
        $cart_item_count = $this->SellerItems->Items->Carts->find('All')->where(['Carts.customer_id'=>$customer_id])->count();
        if(!empty($brand_id))
        {
          $brand_id = explode(',',$brand_id);
          $brandWhere = ['SellerItems.brand_id IN'=>$brand_id];
        }
        else { $brandWhere = ''; }

        if(!empty($category_id))
        {
          $category_id = explode(',',$category_id);
          $categoryWhere = ['Items.category_id IN'=>$category_id];
		  $sellerItems_category = ['SellerItems.category_id IN'=>$category_id];
        }else { $categoryWhere =''; $sellerItems_category = ''; $category_id = ''; }

		
		$total_items = $this->SellerItems->find()->contain(['Sellers','Items' => function($q) use($city_id,$categoryWhere) {
			return $q->where($categoryWhere)->where(['Items.status'=>'Active']);
		}])	
		->where(['SellerItems.city_id' => $city_id,'SellerItems.status'=>'Active'])
		->where($sellerWhere)
		->where($brandWhere) 
		->where($sellerItems_category)->count();		
	
	
        $sellerItem = $this->SellerItems->find();
         $sellerItem->contain(['Sellers','ItemRating' => function($q) use($sellerItem) {
					return $q->select(['ItemRating.item_id','ItemRating.id','AverageReviewRatings.item_id','ItemAverageRating' => $sellerItem->func()->avg('AverageReviewRatings.rating')])
					->leftJoinWith('AverageReviewRatings');
				},'Items' => function($q) use($city_id,$categoryWhere,$limit,$page) {
			return $q->where($categoryWhere)->where(['Items.status'=>'Active']);
		},'ItemVariations' => function($q){
			return $q->contain(['UnitVariations'=>['Units'],'ItemVariationMasters'])
			->where(['ItemVariations.ready_to_sale'=>'Yes'])->where(['ItemVariations.status'=>'Active']);
		}  ])
		->select(['sellerItemCount'=>$sellerItem->func()->count('ItemVariations.seller_item_id')])
		->innerJoinWith('ItemVariations')
		->having(['sellerItemCount' > 0])	
		->where(['SellerItems.city_id' => $city_id,'SellerItems.status'=>'Active'])
		->where($sellerWhere)
		->where($brandWhere) 
		->where($sellerItems_category)
		->group(['SellerItems.id'])
		->limit($limit)
		->page($page)
		->order(['Items.name'=>'ASC'])
		->autoFields(true);
        if(!empty($sellerItem->toArray()))
        {
		  foreach($sellerItem as $item){
			  $item->ItemAverageRating = number_format($item->ItemAverageRating,1);
			  foreach ($item->item_variations as $items_variation_data) {
              $item_id=$item->item->id;
              $items_variation_id = $items_variation_data->id;
			  $inWishList = 0;
              $items_variation_data->inWishList = false;
			  $inWishList = $this->SellerItems->Items->WishListItems->find()->where(['item_id'=>$item_id,'item_variation_id'=>$items_variation_id])
              ->contain(['WishLists'=>function($q) use($customer_id){
                return $q->select(['WishLists.customer_id'])->where(['customer_id'=>$customer_id]);}])->count();
                
                if($inWishList  >= 1)
                { $items_variation_data->inWishList = true; }
                else { $items_variation_data->inWishList = false; }

				$inNotifylist = 0;
				$inNotifylist = $this->SellerItems->Items->Notifies->find()
				    ->where(['item_id'=>$item_id,'item_variation_id'=>$items_variation_id])
			        ->where(['customer_id'=>$customer_id])->count();
                $items_variation_data->inNotifylist = false;
                if($inNotifylist  >= 1)
                { $items_variation_data->inNotifylist = true; }
                else { $items_variation_data->inNotifylist = false; }				
				
				// start maximum_quantity_purchase update
				$items_variation_data->maximum_quantity_purchase = round($items_variation_data->maximum_quantity_purchase);
				$cs = $items_variation_data->current_stock;
				$vs = $items_variation_data->virtual_stock;
				$ds = $items_variation_data->demand_stock;
				$mqp = $items_variation_data->maximum_quantity_purchase;
				
				$stock = 0.00;
				
				$stock = $cs + $vs - $ds;
				
				if($stock > $mqp)
				{
					$items_variation_data->maximum_quantity_purchase = $mqp;
				}
				else if($mqp > $stock)
				{
					$items_variation_data->maximum_quantity_purchase = $stock;
				}
				else {
					$items_variation_data->maximum_quantity_purchase = $mqp;
				}
				$items_variation_data->maximum_quantity_purchase = round($items_variation_data->maximum_quantity_purchase);
				// end maximum_quantity_purchase update				
				
                $count_cart = $this->SellerItems->Items->Carts->find()->select(['Carts.cart_count'])->where(['Carts.item_variation_id'=>$items_variation_data->id,'Carts.customer_id'=>$customer_id]);
				 $count_value = 0;
                foreach ($count_cart as $count) {
                  $count_value = $count->cart_count;
                }
                $items_variation_data->cart_count = $count_value;
              }
            }
            $success = true;
            $message = 'Data Found Successfully';
          }
          else {
            $success = false;
            $message = 'Record not found';
          }

          $brandArr = [];
          $Brands = $this->SellerItems->Items->find()->contain(['Brands'])->where($categoryWhere)
		  ->order(['Items.name'=>'ASC'])->toArray();
		  
		 
		  
          if(!empty($Brands))
          {
            $i = 0;
            foreach ($Brands as $brand) {
              if(!empty($brand->brand))
              {
                $brandArr[$i] = ['id'=>$brand->brand->id,'name'=>$brand->brand->name];
                $i++;
              }
            }
          }

          $Discounts = $this->SellerItems->Items->find()
          ->contain(['ItemsVariations'=>function($q) {
            return $q->select(['ItemsVariations.item_id','min_discount'=>$q->func()->min('discount_per'),
            'max_discount'=>$q->func()->max('discount_per')])->where(['ItemsVariations.status'=>'Active','ItemsVariations.ready_to_sale'=>'Yes']);
          }])->where([$categoryWhere])->order(['Items.name'=>'ASC']);

          if(!empty($Discounts->toArray()))
          {
            foreach ($Discounts as $Discount) {
                if(!empty($Discount->items_variations))
                {
                  foreach ($Discount->items_variations as $items_variation) {
                      $min_discount =  $items_variation->min_discount;
                      $max_discount =  $items_variation->max_discount;
                  }
                }
              }
          }


          $brandData = [];
          $brandArr = array_map("unserialize", array_unique(array_map("serialize",$brandArr)));

          foreach ($brandArr as $value) {
            $brandData[] = ['id'=>$value['id'],'name'=>$value['name']];
          }
 
          $filters['0'] = ['filter_name' => 'Categories','filter' =>$this->SellerItems->Items->Categories->find()->select(['id','name'])->where(['parent_id IN'=>$category_id])->where(['status' => 'Active'])->toArray()];
          $filters['1'] = ['filter_name'=>'Brands','filter' =>$brandData];

        }else {
          $success = false;
          $message = 'Invalid City';
        }
      }else {
        $success = false;
        $message = 'Empty city or page';
      }
      $this->set(['success' => $success,'message'=>$message,'filters'=>$filters,'sellerItem' => $sellerItem,'cart_item_count'=>$cart_item_count,'total_items' => $total_items,  '_serialize' => ['success','message','total_items','cart_item_count','filters','sellerItem']]);
    }  
  
	public function brandCategory($brand_id=null,$city_id=null){
	
		$brand_id = @$this->request->query['brand_id'];
		$city_id = @$this->request->query['city_id'];
		$category = [];
		$categories = [];
		$total_items = 0;
		if(empty($brand_id) || empty($city_id))
		{
		  $success = false;
		  $message = 'Brand or City id empty';
		}
		else
		{
			$items = $this->SellerItems->find()
			->contain(['Categories' => function($q) { return $q->where(['Categories.status' => 'Active'])->order(['Categories.name'=>'ASC']); }])
			->where(['SellerItems.city_id'=>$city_id])
			->where(['SellerItems.brand_id' =>$brand_id])->where(['SellerItems.status' => 'Active']);

			
			
		  if(!empty($items->toArray()))
		  {
			 
			  foreach ($items as $key=>$item_data) {
				  
				$categories[$item_data->category->name] =['category_id' =>$item_data->category->id,'name'=>$item_data->category->name,'category_image_web'=>$item_data->category->category_image_web,'category_image'=>$item_data->category->category_image];
			  }
			 // pr($categories);exit;
			  foreach($categories as $key => $value)
			  {	
					$categoryWhere = ['Items.category_id'=>$value['category_id']];
					$brandWhere = ['SellerItems.brand_id'=>$brand_id];
					$total_items_count = $this->SellerItems->find()->contain(['Sellers','Items' => function($q) use($city_id,$categoryWhere) {
						return $q->where($categoryWhere)->where(['Items.status'=>'Active']);
					}])	
					->where(['SellerItems.city_id' => $city_id,'SellerItems.status'=>'Active'])
					->where($brandWhere)->count();			  
					//pr($total_items_count);
				if($total_items_count != 0)
				{
					$total_items = $total_items + 1;
					$category[]= $value; 					
				}		

			  }
			
			//$category =   array_map("unserialize", array_unique(array_map("serialize",$categories)));
			$success = true;
			$message = 'Data Found Successfully';
		  }
		  else {
			$success = false;
			$message = 'Data Not Found';
		  }
		}
		$this->set(['success' => $success,'message'=>$message,'total_items'=>$total_items,'category' => $category,'_serialize' => ['success','message','category','total_items']]);
	}  
  
    public function productDetail($item_id = null,$city_id =null,$category_id=null,$customer_id=null,$seller_id=null)
    {
      $item_id = @$this->request->query['item_id'];
      $city_id = @$this->request->query['city_id'];
      $category_id = @$this->request->query['category_id'];
      $customer_id = @$this->request->query['customer_id'];
	  $seller_id = @$this->request->query['seller_id'];
      $items = [];
	   $dynamic = [];
      $reletedItems = [];
      if(!empty($city_id))
      {

        // CheckAvabiltyOfCity function is avaliable in app controller for checking city_id in cities table
        $isValidCity = $this->CheckAvabiltyOfCity($city_id);
        if($isValidCity == 0 || $seller_id=0)
        {
          $cart_item_count = $this->SellerItems->Items->Carts->find('All')
		  ->where(['Carts.customer_id'=>$customer_id])->count();
          if(!empty($item_id) && !empty($category_id))
          {
			  
			if(empty($seller_id) || $seller_id == 'nil')
			{
				$sellerWhere = '';
				// $sellerWhere = ['SellerItems.seller_id IS NULL'];	
			}else {
			  $sellerWhere = ['SellerItems.seller_id' =>$seller_id];
			}
			
            $items = $this->SellerItems->find();
			$items->contain(['Categories','Brands','Sellers','Cities','ItemVariations'=>function($q){
			return $q->contain(['UnitVariations'=>['Units'],'ItemVariationMasters'])
			->where(['ItemVariations.ready_to_sale'=>'Yes'])->where(['ItemVariations.status'=>'Active']);
			}])
			->contain(['Items' => function ($q) use($item_id,$items) {			
				return $q->where(['Items.status'=>'Active'])->select(['Items.id','Items.category_id','Items.name','Items.alias_name','Items.description','Items.minimum_stock','AverageReviewRatings.item_id','ItemAverageRating' => $items->func()->avg('AverageReviewRatings.rating')])
				 ->contain(['LeftItemReviewRatings'=>['Customers']])
            ->leftJoinWith('AverageReviewRatings')
			->where(['Items.id'=>$item_id]);	
			}])->autoFields(true)
			->where(['SellerItems.city_id' =>$city_id])
			->where($sellerWhere)
			->where(['SellerItems.category_id'=>$category_id]);

//			pr($items->toArray());exit;
			
            if(!empty($items->toArray()))
            { 
              $inWishList = 0;
              foreach($items as $item){
                $item->ItemAverageRating = number_format($item->ItemAverageRating,1);
                foreach ($item->item_variations as $items_variation_data) {
                  $item_id=$item->item->id;
                  $items_variation_id = $items_variation_data->id;
                  $inWishList = $this->SellerItems->Items->WishListItems->find()->where(['item_id'=>$item_id,'item_variation_id'=>$items_variation_id])->contain(['WishLists'=>function($q) use($customer_id){
                    return $q->select(['WishLists.customer_id'])->where(['customer_id'=>$customer_id]);}])->count();
                    $items_variation_data->inWishList = false;
                    if($inWishList  >= 1)
                    { $items_variation_data->inWishList = true; }
                    else { $items_variation_data->inWishList = false; }
						$items_variation_data->maximum_quantity_purchase = round($items_variation_data->maximum_quantity_purchase);
						// start maximum_quantity_purchase update								
						$cs = $items_variation_data->current_stock;
						$vs = $items_variation_data->virtual_stock;
						$ds = $items_variation_data->demand_stock;
						$mqp = $items_variation_data->maximum_quantity_purchase;
						
						$stock = 0.00;
						
						$stock = $cs + $vs - $ds;
						
						if($stock > $mqp)
						{
							$items_variation_data->maximum_quantity_purchase = $mqp;
						}
						else if($mqp > $stock)
						{
							$items_variation_data->maximum_quantity_purchase = $stock;
						}
						else {
							$items_variation_data->maximum_quantity_purchase = $mqp;
						}
						// end maximum_quantity_purchase update	
					
					
					$inNotifylist = 0;
					$inNotifylist = $this->SellerItems->Items->Notifies->find()
						->where(['item_id'=>$item_id,'item_variation_id'=>$items_variation_id])
						->where(['customer_id'=>$customer_id])->count();
					$items_variation_data->inNotifylist = false;
					if($inNotifylist  >= 1)
					{ $items_variation_data->inNotifylist = true; }
					else { $items_variation_data->inNotifylist = false; }					
					
					
                    $count_cart = $this->SellerItems->Items->Carts->find()->select(['Carts.cart_count'])->where(['Carts.item_variation_id'=>$items_variation_data->id,'Carts.customer_id'=>$customer_id]);
					$count_value = 0;
                    foreach ($count_cart as $count) {
                      $count_value = $count->cart_count;
                    }
                    $items_variation_data->cart_count = $count_value;
                  }
                }
                $success = true;
                $message = 'Data Found Successfully';
              }
              else {
                $success = false;
                $message = 'Record not found';
              }

              $HomeScreens=$this->SellerItems->Items->HomeScreens->find()->where(['screen_type'=>'Product Detail','section_show'=>'Yes','city_id'=>$city_id]);
              foreach($HomeScreens as $HomeScreen){
                if($HomeScreen->model_name=='Items'){
                  /*    $reletedItem = $this->Items->find()->contain(['ItemsVariations'=>['UnitVariations']])
                  ->where(['Items.status'=>'Active','Items.approve'=>'Approved','Items.ready_to_sale'=>'Yes','Items.category_id'=>$category_id,'Items.city_id'=>$city_id,'Items.id !='=>$item_id]);
                  */

                  $dynamic = [];
                  $Itemc = [];
                  $reletedItem = $this->SellerItems->Items->Categories->find()->where(['status'=>'Active','city_id'=>$city_id,'id'=>$category_id])->contain(['SellerItems'=> function($q) use($item_id) {
						return $q->contain(['Items' => function($q) {
								return $q->where(['Items.status'=>'Active'])->order(['Items.name'=>'ASC']);
						}  ,'ItemVariations'=>function($q){
							return $q->where(['ItemVariations.ready_to_sale'=>'Yes'])->where(['ItemVariations.status'=>'Active'])
								->contain(['ItemVariationMasters','UnitVariations'=>['Units']]);
						}])->where(['item_id !=' =>$item_id])->where(['SellerItems.status'=>'Active']);
						}
					]);
				
				
				  
				  if(!empty($reletedItem->toArray()))
                  {

                    $count_value = 0;
                      $inWishList = 0;
                      foreach($reletedItem as $item_detail){
                        foreach ($item_detail->seller_items as $item) {
                        foreach ($item->item_variations as $items_variation_data) {
                          $item_id=$item->id;
                          $items_variation_id = $items_variation_data->id;
                          $inWishList = $this->SellerItems->Items->WishListItems->find()->where(['item_id'=>$item_id,'item_variation_id'=>$items_variation_id])
                          ->contain(['WishLists'=>function($q) use($customer_id){
                            return $q->select(['WishLists.customer_id'])->where(['customer_id'=>$customer_id]);}])->count();
                            if($inWishList  >= 1)
                            { $items_variation_data->inWishList = true; }
                            else { $items_variation_data->inWishList = false; }

                            $count_cart = $this->SellerItems->Items->Carts->find()->select(['Carts.cart_count'])->where(['Carts.item_variation_id'=>$items_variation_data->id,'Carts.customer_id'=>$customer_id]);
                            foreach ($count_cart as $count) {
                              $count_value = $count->cart_count;
                            }
                            $items_variation_data->cart_count = $count_value;
                          }
                        }
                      }

                    $Itemc = array("layout"=>$HomeScreen->layout,"title"=>$HomeScreen->title,"HomeScreens"=>$reletedItem);
                    array_push($dynamic,$Itemc);

                    $success = true;
                    $message = 'Data Found Successfully';
                  } else {
                    $success = true;
                    $message = 'Empty Releted Items';
                  }

                }
              }
            }else {
              $success = false;
              $message = 'Empty Item Id or Category Id';
            }
          }else {
            $success = false;
            $message = 'Invalid City';
          }
        }else {
          $success = false;
          $message = 'Empty City Id';
        }

        $this->set(['success' => $success,'message'=>$message,'cart_item_count'=>$cart_item_count,'items' => $items,'dynamic'=>$dynamic,'_serialize' => ['success','message','cart_item_count','items','dynamic']]);
      }  

	  
      public function searchSuggestion($city_id=null,$item_name=null)
      {
        $city_id = $this->request->query('city_id');
        $item_name = $this->request->query('item_name');
        $customer_id = $this->request->query('customer_id');
        $ItemData = [];
		$items = [];
        $cart_item_count = $this->SellerItems->Items->Carts->find('All')->where(['Carts.customer_id'=>$customer_id])->count();
        if(!empty($item_name))
        {
			$brandData = $this->SellerItems->Items->Brands->find()->select(['id'])->where(['name' =>$item_name])
			->where(['status'=>'Active'])->limit(1);
			if(!empty($brandData->toArray()))
			{	
				foreach($brandData as $brand)
				{
					$brandDataID = $brand->id;	
				}	
				$items = $this->SellerItems->find()
					->contain(['Items'=> function($q) use($brandDataID)
						{	
							return $q->where(['Items.brand_id'=>$brandDataID])->contain(['Categories','ItemVariationMasters'])
							->where(['Items.section_show'=>'Yes'])
							->where(['Items.status'=>'Active'])
							->order(['Items.name'=>'ASC']);
						}
					])->where(['SellerItems.city_id'=>$city_id])->where(['SellerItems.status' => 'Active'])->order(['SellerItems.id'=>'ASC']);								
			}

            if(empty($items))
            {			
				$items = $this->SellerItems->find()
				->contain(['Items'=> function($q) use($item_name)
					{	
						return 
						$q->where(['Items.name Like'=>'%'.$item_name.'%'])
						->orWhere(['Items.description Like' =>'%'.$item_name.'%'])
						->where(['Items.status'=>'Active','Items.section_show'=>'Yes'])
						->order(['Items.name'=>'ASC'])
						->contain(['Categories','ItemVariationMasters']);
					}
				])->where(['SellerItems.city_id'=>$city_id,'SellerItems.status' => 'Active'])->order(['SellerItems.id'=>'ASC']);		
				 //pr($items->toArray()); exit;
			}

				
            if(empty($items->toArray()))
            {
              $items = $this->SellerItems->find()
				->contain(['Items' => function($q) use($item_name) {
					return $q->where(['Items.name Like' =>'%'.$item_name.'%'])
					->contain(['Categories','ItemVariationMasters'])
					->where(['Items.description Like' =>'%'.$item_name.'%'])
					->where(['Items.status'=>'Active'])
					->where(['Items.section_show'=>'Yes']);
				}])
              ->where(['SellerItems.city_id'=>$city_id])->where(['SellerItems.status'=>'Active']);
			}
			
			if(empty($items->toArray()))
            {
              $items = $this->SellerItems->find()
				->contain(['Items' => function($q) use($item_name) {
					return $q->contain(['Categories','ItemVariationMasters'])
					->where(['Items.status'=>'Active'])
					->where(['Items.description Like' =>'%'.$item_name.'%'])
					->where(['Items.status'=>'Active'])
					->where(['Items.section_show'=>'Yes']);
				}])
              ->where(['SellerItems.city_id'=>$city_id])->where(['SellerItems.status'=>'Active']);			  
            }

            if(!empty($items)){
				
              foreach ($items as $item) { 
                $ItemData[] = ['category_id' =>$item->item->category_id,'name'=>$item->item->name .' in '. $item->item->category->name,'image' => $item->item->item_variation_masters[0]->item_image,'item_name'=>$item->item->name,'category_name'=>$item->item->category->name];
					
			}
			 
				/* $_data = array();
				pr($ItemData);exit;
				foreach ($ItemData as $v) { 
				  if (isset($_data[$v['category_id']])) {
					// found duplicate
					continue;
				  }
				  // remember unique item
				  $_data[$v['category_id']] = $v;
				}
			
				// if you need a zero-based array, otheriwse work with $_data
				$ItemData = array_values($_data); */	 			  
			}
		
            $success = true;
            $message = 'Data found';
        }
        else {
          $success = false;
          $message = 'Enter Item name';
        }
        $this->set(['success' => $success,'message'=>$message,'cart_item_count'=>$cart_item_count,'suggestion'=>$ItemData,'_serialize' => ['success','message','cart_item_count','suggestion']]);
      }	  
	  
      public function searchResult()
      { 
          $city_id = $this->request->query('city_id');
          $item_name = $this->request->query('item_name');
		 
          $Category = [];
          $category_id = $this->request->query('category_id');
          $customer_id = $this->request->query('customer_id');
          $where = '';
		  $items = [];
		  $page=@$this->request->query['page'];
		  $limit = 20;
          $cart_item_count = $this->SellerItems->Items->Carts->find('All')
		  ->where(['Carts.customer_id'=>$customer_id])->count();
		 
		  if(!empty($page))
		 {
          if(!empty($category_id) && $category_id != 0)
          { $where = ['SellerItems.category_id' => $category_id]; }
		  else { $where = '';  }

          if(!empty($item_name))
          {
			  
			  $items = $this->SellerItems->find()
			  ->contain(['Sellers','ItemVariations'=>function($q){
					return $q->contain(['UnitVariations'=>['Units'],'ItemVariationMasters'])
					->where(['ItemVariations.ready_to_sale'=>'Yes','ItemVariations.status'=>'Active']);
				}])
			  ->contain(['Items' => function($q) use($item_name) {
					return $q->where(['Items.name'=>$item_name])
					->where(['Items.status'=>'Active'])->contain(['Categories'])
					->where(['Items.section_show'=>'Yes']);
				}])->where(['SellerItems.city_id'=>$city_id])
               ->where($where)
			   ->where(['SellerItems.status' => 'Active'])
			    ->limit($limit)
				->page($page);
			  
              if(empty($items->toArray()))
              {
				  $items = $this->SellerItems->find()
				  ->contain(['Sellers','ItemVariations'=>function($q){
						return $q->contain(['UnitVariations'=>['Units'],'ItemVariationMasters'])
						->where(['ItemVariations.ready_to_sale'=>'Yes'])->where(['ItemVariations.status'=>'Active']);
					}])
				  ->contain(['Items' => function($q) use($item_name) {
						return $q->where(['Items.name Like' =>'%'.$item_name.'%'])
						->where(['Items.status'=>'Active'])
						->where(['Items.section_show'=>'Yes'])
						->contain(['Categories']);
					}])->where(['SellerItems.city_id'=>$city_id])
				  ->where($where)
				  ->where(['SellerItems.status' => 'Active'])
					->limit($limit)
					->page($page);
              }

			 // pr($items->toArray());exit;
			  
			  
              if(!empty($items->toArray())){

                $inWishList = 0;
                foreach ($items as $item) {
                    $Category[] = ['id' =>$item->item->category->id,'name'=> $item->item->category->name];
                    
					
					$_data = array();
					if(!empty($Category))
					{
						foreach ($Category as $v) { 
						  if (isset($_data[$v['id']])) {
							// found duplicate
							continue;
						  }
						  // remember unique item
						  $_data[$v['id']] = $v;
						}
					
						// if you need a zero-based array, otheriwse work with $_data
						$Category = array_values($_data);							
					}

					
				
					foreach ($item->item_variations as $items_variation_data) {

                      $item_id=$item->item->id;
                    /*  $inWishList = $this->Items->WishListItems->find()->where(['item_id'=>$item_id])->contain(['WishLists'=>function($q) use($customer_id){
                        return $q->select(['WishLists.customer_id'])->where(['customer_id'=>$customer_id]);}])->count();
                        if($inWishList  == 1)
                        { $items_variation_data->inWishList = true; }
                        else { $items_variation_data->inWishList = false; }
                        */
						$items_variation_data->maximum_quantity_purchase = round($items_variation_data->maximum_quantity_purchase);
						$cs = $items_variation_data->current_stock;
						$vs = $items_variation_data->virtual_stock;
						$ds = $items_variation_data->demand_stock;
						$mqp = $items_variation_data->maximum_quantity_purchase;
						
						$stock = 0.00;
						
						$stock = $cs + $vs - $ds;
						
						if($stock > $mqp)
						{
							$items_variation_data->maximum_quantity_purchase = $mqp;
						}
						else if($mqp > $stock)
						{
							$items_variation_data->maximum_quantity_purchase = $stock;
						}
						else {
							$items_variation_data->maximum_quantity_purchase = $mqp;
						}		
						
						$items_variation_data->maximum_quantity_purchase = round($items_variation_data->maximum_quantity_purchase);
						
						
                        $count_cart = $this->SellerItems->Items->Carts->find()->select(['Carts.cart_count'])->where(['Carts.item_variation_id'=>$items_variation_data->id,'Carts.customer_id'=>$customer_id]);
                          $items_variation_data->cart_count = 0;
                            $count_value = 0;
                        foreach ($count_cart as $count) {
                          $count_value = $count->cart_count;
                        }
                        $items_variation_data->cart_count = $count_value;
                      }
                }					
					
              }
              else { $items = []; }

              $success = true;
              $message = 'Data found';
          }
          else {
            $success = false;
            $message = 'Enter Item name';
          }			 
		 }else {
            $success = false;
            $message = 'Page No Missing';
          }

          $this->set(['success' => $success,'message'=>$message,'cart_item_count'=>$cart_item_count,'category'=>$Category,'searchResult'=>$items,'_serialize' => ['success','message','cart_item_count','category','searchResult']]);
      }


      public function sellerItem($city_id=null,$page=null,$seller_id=null,$customer_id=null)
      {
        $city_id = @$this->request->query['city_id'];
        $customer_id = @$this->request->query['customer_id'];
        $page=@$this->request->query['page'];
        $seller_id = @$this->request->query['seller_id'];
        $cart_item_count = 0;
		$total_items = 0;
        if(!empty($seller_id)) 
		{ $sellerWhere = ['ItemVariations.seller_id' =>$seller_id]; } 
		else {$sellerWhere ='';}
        $limit=20;
        $items = [];
        $filters = [];
        $shopes = [];
        if(!empty($city_id) && (!empty($seller_id)) && (!empty($page)))
        {
          // CheckAvabiltyOfCity function is avaliable in app controller for checking city_id in cities table
          $isValidCity = $this->CheckAvabiltyOfCity($city_id);
          if($isValidCity == 0)
          {
            $cart_item_count = $this->SellerItems->Items->Carts->find('All')->where(['Carts.customer_id'=>$customer_id])->count();

            $total_items = $this->SellerItems->find()
            ->contain(['Items'=>function($q) use($sellerWhere){
				return $q->where(['Items.status'=>'Active']);
				}
			])->where(['SellerItems.status' => 'Active'])
            ->where(['SellerItems.seller_id'=>$seller_id])->count();			
			
			
			
            $sellerItems = $this->SellerItems->find()
            ->contain(['Items'=>function($q) use($sellerWhere){
				
				return $q->where(['Items.status'=>'Active'])->contain(['ItemVariations' => function ($q) use($sellerWhere){
					return $q->where(['ItemVariations.ready_to_sale'=>'Yes'])->where(['ItemVariations.status'=>'Active'])->where($sellerWhere)->contain(['ItemVariationMasters','UnitVariations'=>['Units']]);
				}]);
				}
			])->where(['SellerItems.status' => 'Active'])
            ->where(['SellerItems.seller_id'=>$seller_id])->limit($limit)->page($page);

            $shopes = $this->SellerItems->Sellers->find()
						->select(['id','firm_name','firm_address','saller_image'])
						->where(['id'=>$seller_id,'status'=>'Active']);
			
            /* pr($items->toArray());exit;

            $items = $this->Items->find()
            ->matching('ItemsVariations', function ($q) use($sellerWhere) {
               return $q->where($sellerWhere);
            })
            ->contain([])
            ->where(['Items.status'=>'Active','Items.approve'=>'Approved','Items.ready_to_sale'=>'Yes','Items.section_show'=>'Yes','Items.city_id'=>$city_id])
            ; */

            if(!empty($sellerItems->toArray()))
            {
              $count_value = 0;
              $inWishList = 0;
              foreach($sellerItems as $sellerItem) {
					
                    if(!empty($sellerItem->item->item_variations))
                    {
                        foreach ($sellerItem->item->item_variations as $items_variation_data) {
                          $item_id=$sellerItem->item->id;
                          $items_variation_id = $items_variation_data->id;
                          $inWishList = $this->SellerItems->Items->WishListItems->find()->where(['item_id'=>$item_id,'item_variation_id'=>$items_variation_id])->contain(['WishLists'=>function($q) use($customer_id){
                            return $q->select(['WishLists.customer_id'])->where(['customer_id'=>$customer_id]);}])->count();
                            $items_variation_data->inWishList = false;
                            if($inWishList  >= 1)
                            { $items_variation_data->inWishList = true; }
                            else { $items_variation_data->inWishList = false; }
							
							// start maximum_quantity_purchase update								
							$cs = $items_variation_data->current_stock;
							$vs = $items_variation_data->virtual_stock;
							$ds = $items_variation_data->demand_stock;
							$mqp = $items_variation_data->maximum_quantity_purchase;
							
							$stock = 0.00;
							
							$stock = $cs + $vs - $ds;
							
							if($stock > $mqp)
							{
								$items_variation_data->maximum_quantity_purchase = $mqp;
							}
							else if($mqp > $stock)
							{
								$items_variation_data->maximum_quantity_purchase = $stock;
							}
							else {
								$items_variation_data->maximum_quantity_purchase = $mqp;
							}
							// end maximum_quantity_purchase update								
							
							$items_variation_data->maximum_quantity_purchase = round($items_variation_data->maximum_quantity_purchase);
							
							$inNotifylist = 0;
							$inNotifylist = $this->SellerItems->Items->Notifies->find()
								->where(['item_id'=>$item_id,'item_variation_id'=>$items_variation_id])
								->where(['customer_id'=>$customer_id])->count();
							$items_variation_data->inNotifylist = false;
							if($inNotifylist  >= 1)
							{ $items_variation_data->inNotifylist = true; }
							else { $items_variation_data->inNotifylist = false; }							
							
							
                            $count_cart = $this->SellerItems->Items->Carts->find()->select(['Carts.cart_count'])->where(['Carts.item_variation_id'=>$items_variation_data->id,'Carts.customer_id'=>$customer_id]);

                            foreach ($count_cart as $count) {
                              $count_value = $count->cart_count;
                            }
                           $items_variation_data->cart_count = $count_value;
                          }
                    }
                    $items[] = $sellerItem->item;
				}
				
                $success = true;
                $message = 'Data Found Successfully';
              }
              else {
                $success = false;
                $message = 'Record not found';
              }
            }else {
              $success = false;
              $message = 'Invalid City';
            }
          }else {
            $success = false;
            $message = 'Empty city or seller id';
          }
          $this->set(['success' => $success,'message'=>$message,'items' => $items,'shopes'=>$shopes,'total_items'=>$total_items,'cart_item_count'=>$cart_item_count,'_serialize' => ['success','message','total_items','cart_item_count','items','shopes']]);
        }

		
	public function searchSuggestionweb($city_id=null)
      {
        $city_id = $this->request->query('city_id');
       
		if(!empty($city_id)){
            $success = true;
            $message = 'Data found';
			$itemsdatas=$this->SellerItems->Items->find()->select(['Items.name'])->where(['Items.city_id'=>$city_id]);
			foreach($itemsdatas as $data){
				$itemsdata[]=$data->name;
			}
			$itemsdata=json_encode($itemsdata);
        }
        else{
          $success = false;
          $message = 'Empty City Id';
        }
        $this->set(['success' => $success,'message'=>$message,'itemdata'=>$itemsdata,'_serialize' => ['success','message','itemdata']]);
      }			
}

?>