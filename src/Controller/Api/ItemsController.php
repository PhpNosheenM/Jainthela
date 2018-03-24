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
         $this->Auth->allow(['productDetail','itemList','addItemRating']);
     }

     public function itemList($category_id=null,$city_id=null,$page=null)
     {
       $city_id = @$this->request->query['city_id'];
       $category_id = @$this->request->query['category_id'];
	   $customer_id = @$this->request->query['customer_id'];
       $page=@$this->request->query['page'];
   		 $limit=10;
       $items = [];
       if(!empty($city_id) && !empty($category_id) && (!empty($page)) && !empty($customer_id))
       {
         // CheckAvabiltyOfCity function is avaliable in app controller for checking city_id in cities table
         $isValidCity = $this->CheckAvabiltyOfCity($city_id);
         if($isValidCity == 0)
         {
          					 
					  $items = $this->Items->find()
                     ->contain(['ItemsVariations'=>['UnitVariations'=>['Units']]])
                     ->where(['Items.status'=>'Active','Items.approve'=>'Approved','Items.ready_to_sale'=>'Yes','Items.section_show'=>'Yes','Items.city_id'=>$city_id,'Items.category_id'=>$category_id])
                     ->limit($limit)->page($page);
               if(!empty($items->toArray()))
               {
				   $inWishList = 0;
				   foreach($items as $item){
					   
					   $item_id=$item->id;
					   
					   $inWishList = $this->Items->WishListItems->find()->where(['item_id'=>$item_id])->contain(['WishLists'=>function($q) use($customer_id){
						   return $q->select(['WishLists.customer_id'])->where(['customer_id'=>$customer_id]);
					   }])->count();
					   
					   $item->inWishList =$inWishList;
					 
					
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
         $message = 'Empty city or category id or Customer Id';
       }
       $this->set(['success' => $success,'message'=>$message,'items' => $items,'_serialize' => ['success','message','items']]);
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
            if(!empty($item_id) && !empty($category_id) && !empty($customer_id))
            {
                $items = $this->Items->find();
                          $items->select(['AverageReviewRatings.item_id','ItemAverageRating' => $items->func()->avg('AverageReviewRatings.rating')])
                          ->contain(['Categories','Brands','Cities','ItemsVariations'=>['UnitVariations','Sellers'],'LeftItemReviewRatings'])
                          ->leftJoinWith('AverageReviewRatings')
                          ->where(['Items.status'=>'Active','Items.approve'=>'Approved','Items.ready_to_sale'=>'Yes','Items.id'=>$item_id,'Items.city_id'=>$city_id,'Items.category_id'=>$category_id])
                          ->autoFields(true);

                if(!empty($items->toArray()))
                {
				  $inWishList=0;
                  foreach ($items as $Item) {
                    $Item->ItemAverageRating = number_format($Item->ItemAverageRating,1);
                    $item_id = $Item->id;
                   $inWishList = $this->Items->WishListItems->find()->where(['item_id'=>$item_id])->contain(['WishLists'=>function($q) use($customer_id){
						   return $q->select(['WishLists.customer_id'])->where(['customer_id'=>$customer_id]);
					   }])->count();
					   
					   $item->inWishList =$inWishList;

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
                              $success = false;
                              $message = 'Empty Releted Items';
                            }

                        }
                    }
            }else {
                    $success = false;
                    $message = 'Empty Item Id or Category Id or Customer Id';
            }
        }else {
                $success = false;
                $message = 'Invalid City';
        }
      }else {
            $success = false;
            $message = 'Empty City Id';
      }

      $this->set(['success' => $success,'message'=>$message,'items' => $items,'reletedItems'=>$reletedItems,'_serialize' => ['success','message','items','reletedItems']]);
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
