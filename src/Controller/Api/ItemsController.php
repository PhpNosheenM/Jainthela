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
    $this->Auth->allow(['productDetail','itemList','addItemRating','ratingList']);
  }

  public function itemList($category_id=null,$city_id=null,$page=null)
  {
    $city_id = @$this->request->query['city_id'];
    $category_id = @$this->request->query['category_id'];
    $customer_id = @$this->request->query['customer_id'];
    $page=@$this->request->query['page'];
    $limit=10;
    $items = [];
    if(!empty($city_id) && !empty($category_id) && (!empty($page)))
    {
      // CheckAvabiltyOfCity function is avaliable in app controller for checking city_id in cities table
      $isValidCity = $this->CheckAvabiltyOfCity($city_id);
      if($isValidCity == 0)
      {
        $cart_item_count = $this->Items->Carts->find('All')->where(['Carts.customer_id'=>$customer_id])->count();
        $items = $this->Items->find()
        ->contain(['ItemsVariations'=>['UnitVariations'=>['Units']]])
        ->where(['Items.status'=>'Active','Items.approve'=>'Approved','Items.ready_to_sale'=>'Yes','Items.section_show'=>'Yes','Items.city_id'=>$city_id,'Items.category_id'=>$category_id])
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
        }else {
          $success = false;
          $message = 'Invalid City';
        }
      }else {
        $success = false;
        $message = 'Empty city or category id';
      }
      $this->set(['success' => $success,'message'=>$message,'items' => $items,'cart_item_count'=>$cart_item_count,'_serialize' => ['success','message','cart_item_count','items']]);
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
            ->contain(['Categories','Brands','Cities','ItemsVariations'=>['UnitVariations'=>['Units'],'Sellers'],'LeftItemReviewRatings'])
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
                  $reletedItem = $this->Items->find()->contain(['ItemsVariations'=>['UnitVariations']])
                  ->where(['Items.status'=>'Active','Items.approve'=>'Approved','Items.ready_to_sale'=>'Yes','Items.category_id'=>$category_id,'Items.city_id'=>$city_id,'Items.id !='=>$item_id]);

                  if(!empty($reletedItem->toArray()))
                  {
                    $reletedItems = array("layout"=>$HomeScreen->layout,"title"=>$HomeScreen->title,"reletedItem"=>$reletedItem);
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

        $this->set(['success' => $success,'message'=>$message,'cart_item_count'=>$cart_item_count,'items' => $items,'reletedItems'=>$reletedItems,'_serialize' => ['success','message','cart_item_count','items','reletedItems']]);
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
                ->where(['ItemReviewRatings.item_id'=>$item_id,'ItemReviewRatings.status'=>0]);
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
            }
            else {
                  $success = false;
                  $message = 'Invalid City';
                }
          }else {
            $success = false;
            $message = 'Empty City Id';
          }
        $this->set(['success' => $success,'message'=>$message,'averageRating'=>$averageRating,'ratingLists' => $ratingLists,'_serialize' => ['success','message','averageRating','ratingLists']]);
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





    }
