<?php
namespace App\Controller\Api;
use Cake\Event\Event;
use Cake\Network\Exception\UnauthorizedException;
use Cake\Utility\Security;
use Firebase\JWT\JWT;


class WishListsController extends AppController
{
    public function initialize()
     {
         parent::initialize();
         $this->Auth->allow(['addWishList','wishList','CustomerWishList']);
     }

     public function addWishList()
     {
       $wishList = $this->WishLists->newEntity();
       if ($this->request->is('post')) {
          $isCombo  = $this->request->getData('isCombo');
           $wishList = $this->WishLists->patchEntity($wishList, $this->request->getData());
           $exists = $this->WishLists->exists(['WishLists.customer_id'=>$wishList->customer_id]);
            if($exists != 1)
            {   $wishList->wish_list_items = [];
                $WishListItems = $this->WishLists->WishListItems->newEntity();
                $WishListItems->item_id = $this->request->getData('item_id');
                $WishListItems->item_variation_id = $this->request->getData('item_variation_id');
                $WishListItems->combo_offer_id = $this->request->getData('combo_offer_id');

                if(empty($WishListItems->item_id)) { $WishListItems->item_id = 0;  }
                if(empty($WishListItems->item_variation_id)) { $WishListItems->item_variation_id = 0;  }
                if(empty($WishListItems->combo_offer_id)) { $WishListItems->combo_offer_id = 0;  }


                $wishList->wish_list_items[0] =$WishListItems;
                if ($this->WishLists->save($wishList)) {
                  $success = true;
				          $isAdded = true;
                  $message = 'Item added to wish list';
                }
                else {
                  $success = false;
				          $isAdded = false;
                  $message = 'not successfully added';
                }
            }else {
                    if($isCombo == true)
                    {
                      if(!empty($this->request->getData('combo_offer_id')))
                        {
                          $wishListIds = $this->WishLists->find()->select(['id'])->where(['customer_id' => $wishList->customer_id]);
                            foreach ($wishListIds as $wishListId) {  $wishListId = $wishListId->id;  }
                            $exists = $this->WishLists->WishListItems->exists(['WishListItems.wish_list_id'=>$wishListId,'WishListItems.combo_offer_id'=>$this->request->getData('combo_offer_id')]);
                                if($exists != 1)
                                {
                                    $wishListIds = $this->WishLists->find()->select(['id'])->where(['customer_id' => $wishList->customer_id]);

                                      $query = $this->WishLists->WishListItems->query();
                                      $query->insert(['wish_list_id','combo_offer_id'])
                                          ->values([
                                            'wish_list_id' => $wishListId,
                                            'combo_offer_id' => $this->request->getData('combo_offer_id')
                                          ])
                                          ->execute();
                                          $success = true;
        							                    $isAdded = true;
                                          $message = 'combo offer added to wish list';
                                }
                                else {
                                    $query = $this->WishLists->WishListItems->query();
                                    $query->delete()->where(['WishListItems.wish_list_id'=>$wishListId,'WishListItems.combo_offer_id'=>$this->request->getData('combo_offer_id')])
                                    ->execute();
                                       $success = true;
        						                   $isAdded = false;
                                       $message = 'removed from wish list';
                                }
                        }else
                        {
                          $success = false;
                          $message = 'empty details';
                          $isAdded = false;
                        }
                    }
                    else {
                      if(!empty($this->request->getData('item_id')) and  !empty($this->request->getData('item_variation_id')))
                        {
                          $wishListIds = $this->WishLists->find()->select(['id'])->where(['customer_id' => $wishList->customer_id]);
                            foreach ($wishListIds as $wishListId) {  $wishListId = $wishListId->id;  }
                            $exists = $this->WishLists->WishListItems->exists(['WishListItems.wish_list_id'=>$wishListId,'WishListItems.item_id'=>$this->request->getData('item_id'),'WishListItems.item_variation_id'=>$this->request->getData('item_variation_id')]);
                                if($exists != 1)
                                {
                                    $wishListIds = $this->WishLists->find()->select(['id'])->where(['customer_id' => $wishList->customer_id]);

                                      $query = $this->WishLists->WishListItems->query();
                                      $query->insert(['wish_list_id','item_id','item_variation_id'])
                                          ->values([
                                            'wish_list_id' => $wishListId,
                                            'item_id' => $this->request->getData('item_id'),
                                            'item_variation_id' => $this->request->getData('item_variation_id')
                                          ])
                                          ->execute();
                                          $success = true;
        							                    $isAdded = true;
                                          $message = 'Item added to wish list';
                                }
                                else {
                                    $query = $this->WishLists->WishListItems->query();
                                    $query->delete()->where(['WishListItems.wish_list_id'=>$wishListId,'WishListItems.item_id'=>$this->request->getData('item_id'),'WishListItems.item_variation_id'=>$this->request->getData('item_variation_id')])
                                    ->execute();
                                       $success = true;
        						                   $isAdded = false;
                                       $message = 'removed from wish list';
                                }
                        }else
                        {
                          $success = false;
                          $message = 'empty item details';
                          $isAdded = false;
                        }
                    }
            }
       }
          $this->set(['isAdded'=>$isAdded,'success' => $success,'message'=>$message,'_serialize' => ['success','message','isAdded']]);
     }


	 public function removewishlist(){

		  $id = @$this->request->query['id'];
		  if(!empty($id)){

			 $exists = $this->WishLists->WishListItems->exists(['WishListItems.id'=>$id]);
			 if($exists==1){
				  $WishListItems= $this->WishLists->WishListItems->get($id);
				  $this->WishLists->WishListItems->delete($WishListItems);
				  $success = true;
				  $message = 'removed from wish list';
			 }else{
				 $success = false;
				 $message = 'No record found';
			 }
		  }else{
			  $success = false;
        $message = 'empty id';

		  }
		$this->set(['success' => $success,'message'=>$message,'_serialize' => ['success','message']]);
	 }

    public function CustomerWishList($customer_id=null)
    {
        $customer_id = @$this->request->query['customer_id'];
        if(!empty($customer_id))
        {
            $wishlist = $this->WishLists->find()
                      ->contain(['WishListItems'=>['ItemVariations'=>['ItemVariationMasters','UnitVariations'=>['Units'],'Items']]])
                      ->where(['customer_id'=>$customer_id]);
            $wishlistCombo = $this->WishLists->find()
                        ->contain(['WishListItems'=>['ComboOffers'=>['ComboOfferDetails']]])
                        ->where(['customer_id'=>$customer_id]);
            if(!empty($wishlist->toArray()) || !empty($wishlistCombo->toArray()))
            {
				
				if(!empty($wishlistCombo))
				{	$total_item = 0;
					foreach($wishlistCombo as $wishListData) { 
						foreach($wishListData->wish_list_items as $wish_list_item){
								$total_item = sizeof($wish_list_item->combo_offer->combo_offer_details);
								$wish_list_item->combo_offer->quantity = $total_item;
								
								// start maximum_quantity_purchase update
								$wish_list_item->item_variation->maximum_quantity_purchase = round($wish_list_item->item_variation->maximum_quantity_purchase);
								$cs = $wish_list_item->item_variation->current_stock;
								$vs = $wish_list_item->item_variation->virtual_stock;
								$ds = $wish_list_item->item_variation->demand_stock;
								$mqp = $wish_list_item->item_variation->maximum_quantity_purchase;
								
								$stock = 0.00;
								
								$stock = $cs + $vs - $ds;
								
								if($stock > $mqp)
								{
								$wish_list_item->item_variation->maximum_quantity_purchase = $mqp;
								}
								else if($mqp > $stock)
								{
									$wish_list_item->item_variation->maximum_quantity_purchase = $stock;
								}
								else {
									$wish_list_item->item_variation->maximum_quantity_purchase = $mqp;
								}
								
								// end maximum_quantity_purchase update								
						}
					}
				}		
				
				
				
              $success = true;
              $message = 'wish list found';
            } else
            {
              $wishlist = [];
              $success = false;
              $message = 'empty wish list';
            }
        }else {
          $wishlist =[];
          $success = false;
          $message = 'customer id empty';
        }
        $this->set(['success' => $success,'message'=>$message,'wishlist'=>$wishlist,'wishlistcombo'=>$wishlistCombo,'_serialize' => ['success','message','wishlist','wishlistcombo']]);
    }
}
