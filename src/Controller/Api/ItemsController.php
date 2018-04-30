<?php
namespace App\Controller\Api;
use Cake\Event\Event;
use Cake\Network\Exception\UnauthorizedException;
use Cake\Utility\Security;
use Firebase\JWT\JWT;

/**
* Items Controller
*
* @property \App\Model\Table\ItemsTable $Items
*
* @method \App\Model\Entity\Item[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
*/
class ItemsController extends AppController
{

  public function initialize()
  {
    parent::initialize();
    $this->Auth->allow(['brandCategory','productDetail','itemList','addItemRating','ratingList','searchSuggestion','searchResult','sellerItem']);
  }


  public function brandCategory($brand_id=null,$city_id=null){
    $brand_id = @$this->request->query['brand_id'];
    $city_id = @$this->request->query['city_id'];
    $category =[];
    $categories = [];
    if(empty($brand_id) || empty($city_id))
    {
      $success = false;
      $message = 'Brand or City id empty';
    }
    else
    {
      $items = $this->Items->find()
      ->contain(['Categories'])
      ->where(['Items.status'=>'Active','Items.approve'=>'Approved','Items.ready_to_sale'=>'Yes','Items.section_show'=>'Yes','Items.city_id'=>$city_id])
      ->where(['brand_id' =>$brand_id]);

      if(!empty($items))
      {
          $i = 0;
          foreach ($items as $item_data) {
            $categories[$item_data->category->id] = ['category_id' =>$item_data->category->id,'name'=>$item_data->category->name,'category_image_web'=>$item_data->category->category_image_web,'category_image'=>$item_data->category->category_image];
            $i++;
          }
        $success = true;
        $message = 'Data Found Successfully';
      }
      else {
        $success = false;
        $message = 'Data Not Found';
      }
    }
    $this->set(['success' => $success,'message'=>$message,'category' => $categories,'_serialize' => ['success','message','category']]);
  }

  public function itemList($category_id=null,$city_id=null,$page=null,$brand_id=null,$seller_id=null)
  {
    $city_id = @$this->request->query['city_id'];
    $category_id = @$this->request->query['category_id'];
    $brand_id = @$this->request->query['brand_id'];
    $customer_id = @$this->request->query['customer_id'];
    $page=@$this->request->query['page'];
    $seller_id = @$this->request->query['seller_id'];
    $cart_item_count = 0;
    if(!empty($seller_id)) { $sellerWhere = ['seller_id' =>$seller_id]; } else {$sellerWhere ='';}
    $limit=10;
    $items = [];
    $filters = [];
    if(!empty($city_id) && !empty($category_id) && (!empty($page)))
    {
      // CheckAvabiltyOfCity function is avaliable in app controller for checking city_id in cities table
      $isValidCity = $this->CheckAvabiltyOfCity($city_id);
      if($isValidCity == 0)
      {
        $cart_item_count = $this->Items->Carts->find('All')->where(['Carts.customer_id'=>$customer_id])->count();
        if(!empty($brand_id))
        {
          $brand_id = explode(',',$brand_id);
          $brandWhere = ['brand_id IN'=>$brand_id];
        }
        else { $brandWhere = ''; }

        if(!empty($category_id))
        {
          $category_id = explode(',',$category_id);
          $categoryWhere = ['Items.category_id IN'=>$category_id];
        }else { $categoryWhere =''; }

        $items = $this->Items->find()
        ->contain(['ItemsVariations' => function ($q) use($sellerWhere){ return $q->where($sellerWhere)->contain(['UnitVariations'=>['Units'],'Sellers','ItemVariationMasters']); } ])
        ->where(['Items.status'=>'Active','Items.approve'=>'Approved','Items.ready_to_sale'=>'Yes','Items.section_show'=>'Yes','Items.city_id'=>$city_id])
        ->where($categoryWhere)
        ->where($brandWhere)
        ->limit($limit)->page($page);
        if(!empty($items->toArray()))
        {
          $count_value = 0;
          $inWishList = 0;
          foreach($items as $item){
            foreach ($item->items_variations as $items_variation_data) {
              $item_id=$item->id;
              $inWishList = $this->Items->WishListItems->find()->where(['item_id'=>$item_id])->contain(['WishLists'=>function($q) use($customer_id){
                return $q->select(['WishLists.customer_id'])->where(['customer_id'=>$customer_id]);}])->count();
                if($inWishList  == 1)
                { $items_variation_data->inWishList = true; }
                else { $items_variation_data->inWishList = false; }

                $count_cart = $this->Items->Carts->find()->select(['Carts.cart_count'])->where(['Carts.item_variation_id'=>$items_variation_data->id,'Carts.customer_id'=>$customer_id]);

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
          $Brands = $this->Items->find()->contain(['Brands'])->where($categoryWhere)->toArray();
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

          $Discounts = $this->Items->find()
          ->contain(['ItemsVariations'=>function($q) {
            return $q->select(['ItemsVariations.item_id','min_discount'=>$q->func()->min('discount_per'),
            'max_discount'=>$q->func()->max('discount_per')]);
          }])->where([$categoryWhere]);

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

          $filters['0'] = ['filter_name' => 'Categories','filter' =>$this->Items->Categories->find()->select(['id','name'])->where(['parent_id IN'=>$category_id])->toArray()];
          $filters['1'] = ['filter_name'=>'Brands','filter' =>$brandData];

        }else {
          $success = false;
          $message = 'Invalid City';
        }
      }else {
        $success = false;
        $message = 'Empty city or category id';
      }
      $this->set(['success' => $success,'message'=>$message,'filters'=>$filters,'items' => $items,'cart_item_count'=>$cart_item_count,'_serialize' => ['success','message','cart_item_count','filters','items']]);
    }

    public function productDetail($item_id = null,$city_id =null,$category_id=null,$customer_id=null)
    {
      $item_id = @$this->request->query['item_id'];
      $city_id = @$this->request->query['city_id'];
      $category_id = @$this->request->query['category_id'];
      $customer_id = @$this->request->query['customer_id'];
      $items = [];
      $reletedItems = [];
      if(!empty($city_id))
      {

        // CheckAvabiltyOfCity function is avaliable in app controller for checking city_id in cities table
        $isValidCity = $this->CheckAvabiltyOfCity($city_id);
        if($isValidCity == 0)
        {
          $cart_item_count = $this->Items->Carts->find('All')->where(['Carts.customer_id'=>$customer_id])->count();
          if(!empty($item_id) && !empty($category_id))
          {
            $items = $this->Items->find();
            $items->select(['AverageReviewRatings.item_id','ItemAverageRating' => $items->func()->avg('AverageReviewRatings.rating')])
            ->contain(['Categories','Brands','Cities','ItemsVariations'=>['UnitVariations'=>['Units'],'Sellers','ItemVariationMasters'],'LeftItemReviewRatings'=>['Customers']])
            ->leftJoinWith('AverageReviewRatings')
            ->where(['Items.status'=>'Active','Items.approve'=>'Approved','Items.ready_to_sale'=>'Yes','Items.id'=>$item_id,'Items.city_id'=>$city_id,'Items.category_id'=>$category_id])
            ->autoFields(true);

            if(!empty($items->toArray()))
            { $count_value = 0;
              $inWishList = 0;
              foreach($items as $item){
                $item->ItemAverageRating = number_format($item->ItemAverageRating,1);
                foreach ($item->items_variations as $items_variation_data) {
                  $item_id=$item->id;
                  $inWishList = $this->Items->WishListItems->find()->where(['item_id'=>$item_id])->contain(['WishLists'=>function($q) use($customer_id){
                    return $q->select(['WishLists.customer_id'])->where(['customer_id'=>$customer_id]);}])->count();
                    if($inWishList  == 1)
                    { $items_variation_data->inWishList = true; }
                    else { $items_variation_data->inWishList = false; }

                    $count_cart = $this->Items->Carts->find()->select(['Carts.cart_count'])->where(['Carts.item_variation_id'=>$items_variation_data->id,'Carts.customer_id'=>$customer_id]);
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

              $HomeScreens=$this->Items->HomeScreens->find()->where(['screen_type'=>'Product Detail','section_show'=>'Yes','city_id'=>$city_id]);
              foreach($HomeScreens as $HomeScreen){
                if($HomeScreen->model_name=='Items'){
                  /*    $reletedItem = $this->Items->find()->contain(['ItemsVariations'=>['UnitVariations']])
                  ->where(['Items.status'=>'Active','Items.approve'=>'Approved','Items.ready_to_sale'=>'Yes','Items.category_id'=>$category_id,'Items.city_id'=>$city_id,'Items.id !='=>$item_id]);
                  */

                  $dynamic = [];
                  $Itemc = [];
                  $reletedItem = $this->Items->Categories->find()->where(['status'=>'Active','city_id'=>$city_id,'id'=>$category_id])->contain(['ItemActive'=>['ItemsVariations'=>['ItemVariationMasters','UnitVariations'=>['Units']]]]);
                  if(!empty($reletedItem->toArray()))
                  {
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


      public function ratingList($item_id = null,$city_id =null)
      {
        $item_id = @$this->request->query['item_id'];
        $city_id = @$this->request->query['city_id'];
        $averageRating = number_format(0,1);
        if(!empty($city_id))
        {
          // CheckAvabiltyOfCity function is avaliable in app controller for checking city_id in cities table
          $isValidCity = $this->CheckAvabiltyOfCity($city_id);
          if($isValidCity == 0)
          {
            $ratingLists = $this->Items->ItemReviewRatings->find()
            ->contain(['Customers'=>function($q){ return $q->select(['name']);  } ])
            ->where(['ItemReviewRatings.item_id'=>$item_id,'ItemReviewRatings.status'=>0,'ItemReviewRatings.comment !='=>'']);
            if(!empty($ratingLists->toArray()))
            {
              $rating = $this->Items->ItemReviewRatings->find();
              $rating->select(['averageRating' => $rating->func()->avg('rating')])
              ->where(['ItemReviewRatings.item_id'=>$item_id,'ItemReviewRatings.status'=>0]);

              foreach ($rating as $ratingarr) {
                $averageRating = number_format($ratingarr->averageRating,1);
              }

              $success = true;
              $message = 'Data Found Successfully';
            } else {
              $success = true;
              $message = 'No data found';
            }

            $star1 = $this->Items->ItemReviewRatings->find()->where(['ItemReviewRatings.item_id'=>$item_id,'ItemReviewRatings.status'=>0,'rating >='=>1,'rating <'=>1.9])->all();
            $star1count = $star1->count();
            $star2 = $this->Items->ItemReviewRatings->find()->where(['ItemReviewRatings.item_id'=>$item_id,'ItemReviewRatings.status'=>0,'rating >='=>2,'rating <'=>2.9])->all();
            $star2count = $star2->count();
            $star3 = $this->Items->ItemReviewRatings->find()->where(['ItemReviewRatings.item_id'=>$item_id,'ItemReviewRatings.status'=>0,'rating >='=>3,'rating <'=>3.9])->all();
            $star3count = $star3->count();
            $star4 = $this->Items->ItemReviewRatings->find()->where(['ItemReviewRatings.item_id'=>$item_id,'ItemReviewRatings.status'=>0,'rating >='=>4,'rating <'=>4.9])->all();
            $star4count = $star4->count();
            $star5 = $this->Items->ItemReviewRatings->find()->where(['ItemReviewRatings.item_id'=>$item_id,'ItemReviewRatings.status'=>0,'rating'=>5])->all();
            $star5count = $star5->count();
            $star1 = $star1count;
            $star2 = $star2count;
            $star3 = $star3count;
            $star4 = $star4count;
            $star5 = $star5count;
            $tot_stars = $star1count + $star2count + $star3count + $star4count + $star5count;
            $allpercentage =array();

            for ($i=5;$i >=1; --$i) {
              $var = "star$i";
              $count = $$var;
              if($count>0){
                $percent = $count * 100 / $tot_stars;
              }
              else
              {
                $percent=0;
              }
              $percentage = round($percent,2);
              $allpercentage[] = array("rating"=>$i,"percentage"=>$percentage);
              $percentage = '';
            }


          }
          else {
            $success = false;
            $message = 'Invalid City';
          }
        }else {
          $success = false;
          $message = 'Empty City Id';
        }
        $this->set(['success' => $success,'message'=>$message,'averageRating'=>$averageRating,'ratingLists' => $ratingLists,'percentage'=>$allpercentage,'_serialize' => ['success','message','averageRating','ratingLists','percentage']]);
      }

      public function addItemRating()
      {
        $addItemRating = $this->Items->ItemReviewRatings->newEntity();
        if($this->request->is(['patch', 'post', 'put'])){
          $addItemRating = $this->Items->ItemReviewRatings->patchEntity($addItemRating, $this->request->getData());
          if(!empty($addItemRating->item_id) and (!empty($addItemRating->customer_id))){

            $exists = $this->Items->ItemReviewRatings->exists(['ItemReviewRatings.item_id'=>$addItemRating->item_id,'ItemReviewRatings.customer_id'=>$addItemRating->customer_id]);
            if($exists == 1) {
              $success = false;
              $message = 'rating already given';
            }
            else {
              if ($this->Items->ItemReviewRatings->save($addItemRating)) {
                $success=true;
                $message="rating n review has been saved successfully";
              }else{
                $success=false;
                $message="rating n review has not been saved";
              }
            }
          }else{
            $success = false;
            $message = 'Invalid Item id or customer id';
          }
        }
        $this->set(['success' => $success,'message'=>$message,'_serialize' => ['success','message']]);
      }

      public function searchSuggestion($city_id=null,$item_name=null)
      {

        $city_id = $this->request->query('city_id');
        $item_name = $this->request->query('item_name');
        $customer_id = $this->request->query('customer_id');
        $ItemData = [];
        $cart_item_count = $this->Items->Carts->find('All')->where(['Carts.customer_id'=>$customer_id])->count();
        if(!empty($item_name))
        {
            $items = $this->Items->find()
            ->contain(['Categories'])
            ->where(['Items.status'=>'Active','Items.approve'=>'Approved','Items.ready_to_sale'=>'Yes','Items.section_show'=>'Yes','Items.city_id'=>$city_id])
            ->where(['Items.name'=>$item_name]);
            if(empty($items->toArray()))
            {
              $items = $this->Items->find()
              ->contain(['Categories'])
              ->where(['Items.status'=>'Active','Items.approve'=>'Approved','Items.ready_to_sale'=>'Yes','Items.section_show'=>'Yes','Items.city_id'=>$city_id])
              ->where(['Items.name Like' =>'%'.$item_name.'%']);
            }

            if(!empty($items->toArray())){
              foreach ($items as $item) {
                $ItemData[] = ['category_id' =>$item->id,'name'=>$item->name .' in '. $item->category->name,'image' => $item->item_image,'item_name'=>$item->name,'category_name'=>$item->category->name];
              }
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
          if(!empty($category_id))
          { $where = ['category_id' => $category_id]; }

          $cart_item_count = $this->Items->Carts->find('All')->where(['Carts.customer_id'=>$customer_id])->count();
          if(!empty($item_name))
          {
              $items = $this->Items->find()
              ->contain(['Categories','ItemsVariations'=>['ItemVariationMasters','UnitVariations'=>['Units']]])
              ->where(['Items.status'=>'Active','Items.approve'=>'Approved','Items.ready_to_sale'=>'Yes','Items.section_show'=>'Yes','Items.city_id'=>$city_id])
              ->where(['Items.name'=>$item_name])
              ->where($where);
              if(empty($items->toArray()))
              {
                $items = $this->Items->find()
                ->contain(['Categories','ItemsVariations'=>['ItemVariationMasters','UnitVariations'=>['Units']]])
                ->where(['Items.status'=>'Active','Items.approve'=>'Approved','Items.ready_to_sale'=>'Yes','Items.section_show'=>'Yes','Items.city_id'=>$city_id])
                ->where(['Items.name Like' =>'%'.$item_name.'%'])
                ->where($where);
              }

              if(!empty($items->toArray())){

                $inWishList = 0;
                foreach ($items as $item) {
                    $Category[] = ['id' =>$item->category->id,'name'=> $item->category->name];
                    foreach ($item->items_variations as $items_variation_data) {

                      $item_id=$item->id;
                    /*  $inWishList = $this->Items->WishListItems->find()->where(['item_id'=>$item_id])->contain(['WishLists'=>function($q) use($customer_id){
                        return $q->select(['WishLists.customer_id'])->where(['customer_id'=>$customer_id]);}])->count();
                        if($inWishList  == 1)
                        { $items_variation_data->inWishList = true; }
                        else { $items_variation_data->inWishList = false; }
                        */
                        $count_cart = $this->Items->Carts->find()->select(['Carts.cart_count'])->where(['Carts.item_variation_id'=>$items_variation_data->id,'Carts.customer_id'=>$customer_id]);
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
          $this->set(['success' => $success,'message'=>$message,'cart_item_count'=>$cart_item_count,'category'=>$Category,'searchResult'=>$items,'_serialize' => ['success','message','cart_item_count','category','searchResult']]);
      }

      public function sellerItem($city_id=null,$page=null,$seller_id=null,$customer_id=null)
      {
        $city_id = @$this->request->query['city_id'];
        $customer_id = @$this->request->query['customer_id'];
        $page=@$this->request->query['page'];
        $seller_id = @$this->request->query['seller_id'];
        $cart_item_count = 0;
        if(!empty($seller_id)) { $sellerWhere = ['ItemsVariations.seller_id' =>$seller_id]; } else {$sellerWhere ='';}
        $limit=10;
        $items = [];
        $filters = [];
        if(!empty($city_id) && (!empty($seller_id)) && (!empty($page)))
        {
          // CheckAvabiltyOfCity function is avaliable in app controller for checking city_id in cities table
          $isValidCity = $this->CheckAvabiltyOfCity($city_id);
          if($isValidCity == 0)
          {
            $cart_item_count = $this->Items->Carts->find('All')->where(['Carts.customer_id'=>$customer_id])->count();
            $items = $this->Items->find()
            ->matching('ItemsVariations', function ($q) use($sellerWhere) {
               return $q->where($sellerWhere);
            })
            ->contain(['ItemsVariations'=>['ItemVariationMasters']])
            ->where(['Items.status'=>'Active','Items.approve'=>'Approved','Items.ready_to_sale'=>'Yes','Items.section_show'=>'Yes','Items.city_id'=>$city_id])
            ->limit($limit)->page($page);
            if(!empty($items->toArray()))
            {
              $count_value = 0;
              $inWishList = 0;
              foreach($items as $key => $item){
                  if(!empty($item->items_variations))
                  {
                      foreach ($item->items_variations as $items_variation_data) {
                        $item_id=$item->id;
                        $inWishList = $this->Items->WishListItems->find()->where(['item_id'=>$item_id])->contain(['WishLists'=>function($q) use($customer_id){
                          return $q->select(['WishLists.customer_id'])->where(['customer_id'=>$customer_id]);}])->count();
                          if($inWishList  == 1)
                          { $items_variation_data->inWishList = true; }
                          else { $items_variation_data->inWishList = false; }

                          $count_cart = $this->Items->Carts->find()->select(['Carts.cart_count'])->where(['Carts.item_variation_id'=>$items_variation_data->id,'Carts.customer_id'=>$customer_id]);

                          foreach ($count_cart as $count) {
                            $count_value = $count->cart_count;
                          }
                          $items_variation_data->cart_count = $count_value;
                        }
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
            $message = 'Empty city or seller id';
          }
          $this->set(['success' => $success,'message'=>$message,'items' => $items,'cart_item_count'=>$cart_item_count,'_serialize' => ['success','message','cart_item_count','items']]);
        }



}
