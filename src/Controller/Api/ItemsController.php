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
         $this->Auth->allow(['productDetail','itemList']);
     }

     public function itemList($category_id=null,$city_id=null)
     {
       $city_id = @$this->request->query['city_id'];
       $category_id = @$this->request->query['category_id'];

       if(!empty($city_id) && !empty($category_id))
       {
         // CheckAvabiltyOfCity function is avaliable in app controller for checking city_id in cities table
         $isValidCity = $this->CheckAvabiltyOfCity($city_id);
         if($isValidCity == 0)
         {
           $items = $this->Items->find()
                     ->contain(['Categories','ItemVariations'=>['Units']])
                     ->where(['Items.status'=>'Active','Items.approve'=>'Approved','Items.ready_to_sale'=>'Yes','Items.section_show'=>'Yes','Items.city_id'=>$city_id,'Items.category_id'=>$category_id]);
               if(!empty($items->toArray()))
               {
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
         $message = 'Record not found';
       }
       $this->set(['success' => $success,'message'=>$message,'items' => $items,'_serialize' => ['success','message','items']]);       
     }

    public function productDetail($item_id = null,$city_id =null,$category_id=null)
    {
      $item_id = @$this->request->query['item_id'];
      $city_id = @$this->request->query['city_id'];
      $category_id = @$this->request->query['category_id'];
      $items = [];
      $reletedItems = [];
      if(!empty($city_id))
      {

        // CheckAvabiltyOfCity function is avaliable in app controller for checking city_id in cities table
        $isValidCity = $this->CheckAvabiltyOfCity($city_id);
        if($isValidCity == 0)
        {
            if(!empty($item_id) && !empty($category_id))
            {
                $items = $this->Items->find()
                          ->contain(['Categories','Brands','Sellers','Cities','ItemVariations'=>['Units']])
                          ->where(['Items.status'=>'Active','Items.approve'=>'Approved','Items.ready_to_sale'=>'Yes','Items.id'=>$item_id,'Items.city_id'=>$city_id,'Items.category_id'=>$category_id]);

                if(!empty($items->toArray()))
                {
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
                           $reletedItem = $this->Items->find()->contain(['ItemVariations'=>['Units']])
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

      $this->set(['success' => $success,'message'=>$message,'items' => $items,'reletedItems'=>$reletedItems,'_serialize' => ['success','message','items','reletedItems']]);
    }
}
