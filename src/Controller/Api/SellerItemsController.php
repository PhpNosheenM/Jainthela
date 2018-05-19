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
    $this->Auth->allow(['items','itemList']);
  }
  
  
/*   public function items($city_id=null)
  {
	$city_id = @$this->request->query['city_id'];
	$items = $this->SellerItems->find()->contain(['Categories','Items','ItemVariations','Sellers'])
	->where(['SellerItems.city_id'=>$city_id]);
	$this->set(['items' =>$items ,'_serialize' => ['items']]);
  } */

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
        $cart_item_count = $this->SellerItems->Items->Carts->find('All')->where(['Carts.customer_id'=>$customer_id])->count();
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
		  $sellerItems_category = ['SellerItems.category_id IN'=>$category_id];
        }else { $categoryWhere =''; }

        $items = $this->SellerItems->find();
         $items->contain(['Sellers','Items' => function($q) use($city_id,$categoryWhere,$brandWhere,$limit,$page) {
			return $q->where(['Items.status'=>'Active','Items.approve'=>'Approved','Items.ready_to_sale'=>'Yes','Items.section_show'=>'Yes','Items.city_id'=>$city_id])
			->where($categoryWhere)
			->where($brandWhere) 
			->limit($limit)
			->page($page);
		},'ItemVariations' => ['UnitVariations'=>['Units'],'ItemVariationMasters']])
		->select(['total'=>$items->func()->count('ItemVariations.seller_item_id')])
		->innerJoinWith('ItemVariations')
		->having(['total' > 0])	
		->where(['SellerItems.city_id' => $city_id])
		->where($sellerWhere)
		->where($sellerItems_category)
    ->group(['SellerItems.id'])
		->autoFields(true);
	
        if(!empty($items->toArray()))
        {
          $count_value = 0;
          $inWishList = 0;
          foreach($items as $item){
            foreach ($item->item_variations as $items_variation_data) {
              $item_id=$item->id;
              $items_variation_id = $items_variation_data->id;
              $inWishList = $this->SellerItems->Items->WishListItems->find()->where(['item_id'=>$item_id,'item_variation_id'=>$items_variation_id])
              ->contain(['WishLists'=>function($q) use($customer_id){
                return $q->select(['WishLists.customer_id'])->where(['customer_id'=>$customer_id]);}])->count();
                $items_variation_data->inWishList = false;
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
            $success = true;
            $message = 'Data Found Successfully';
          }
          else {
            $success = false;
            $message = 'Record not found';
          }

          $brandArr = [];
          $Brands = $this->SellerItems->Items->find()->contain(['Brands'])->where($categoryWhere)->toArray();
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

          $filters['0'] = ['filter_name' => 'Categories','filter' =>$this->SellerItems->Items->Categories->find()->select(['id','name'])->where(['parent_id IN'=>$category_id])->toArray()];
          $filters['1'] = ['filter_name'=>'Brands','filter' =>$brandData];

        }else {
          $success = false;
          $message = 'Invalid City';
        }
      }else {
        $success = false;
        $message = 'Empty city or category id or page';
      }
      $this->set(['success' => $success,'message'=>$message,'filters'=>$filters,'items' => $items,'cart_item_count'=>$cart_item_count,'_serialize' => ['success','message','cart_item_count','filters','items']]);
    }  
  
  
  
  

}

?>