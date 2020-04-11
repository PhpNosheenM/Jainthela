<?php
namespace App\Controller\Api;
use Cake\Event\Event;
use Cake\Network\Exception\UnauthorizedException;
use Cake\Utility\Security;
use Firebase\JWT\JWT;


class CartsController extends AppController
{

	public function initialize()
	 {
			 parent::initialize();
			 $this->Auth->allow(['getCount','addToCartCombo','addCartCommon','removeCartCommon','removeCartCombo','updateAmount','fetchCart','plusAddToCart','removeFromCart','reviewOrder','moveToBag','removefetchCart','removeOutOfStockItem']);
	 }

	public function getCount($customer_id=null)
	{
		$customer_id=$this->request->query('customer_id');
		$item_in_cart = $this->Carts->find('All')->where(['Carts.customer_id'=>$customer_id])->count();
		$success=true;
		$message="Item Added Successfully";
		$this->set(compact('success','message','item_in_cart'));
		$this->set('_serialize',['success','message','item_in_cart']);
	}



	public function addToCartCombo($customer_id,$city_id,$combo_offer_id)
	{
		 // get combo Data
		 $comboData = $this->Carts->ComboOffers->get($combo_offer_id);
		 $sale_rate = $comboData->sales_rate;
		 //$quantity = $comboData->print_quantity;
		 $quantity = 1;

		 // check avaliable item in cart
  		$checkCartData = $this->Carts->find()->where(['city_id'=>$city_id,'customer_id' => $customer_id,'combo_offer_id' =>$combo_offer_id]);
			if(empty($checkCartData->toArray()))
			{
				$amount = $sale_rate * $quantity;
				$query = $this->Carts->query();
				$query->insert(['city_id','customer_id','combo_offer_id','quantity','rate','amount','cart_count'])
				->values(['city_id' =>$city_id,'customer_id' => $customer_id,'combo_offer_id' => $combo_offer_id,'quantity' => $quantity,'rate' => $sale_rate,'amount' => $amount,'cart_count' => 1])->execute();
			}
			else
			{
					foreach($checkCartData as $checkCart)
					{
						$update_id = $checkCart->id;
						$exist_quantity = $checkCart->quantity;
						$exist_count = $checkCart->cart_count;
					}
					$update_quantity = $quantity + $exist_quantity;
					$update_count = $exist_count + 1;
					$amount = $sale_rate * $update_quantity;
					$query = $this->Carts->query();
					$result = $query->update()
					->set(['quantity' =>$update_quantity,'rate'=>$sale_rate,'amount' => $amount,'cart_count' => $update_count])
					->where(['id' => $update_id])->execute();
			}
	}

	public function addCartCommon($customer_id,$city_id,$item_variation_id)
	{
		// get item variations id
		$itemVariationData = $this->Carts->ItemVariations->get($item_variation_id);
		$sale_rate = $itemVariationData->sales_rate;
		$unit_Variation = $itemVariationData->unit_variation_id;
		// get quantity and unit id
		$unit_VariationData = $this->Carts->ItemVariations->UnitVariations->get($unit_Variation);
		//$item_add_quantity =  $unit_VariationData->convert_unit_qty;
		$item_add_quantity =  1;
		$item_add_unit_id = $unit_VariationData->unit_id;
		// check avaliable item in cart
		$checkCartData = $this->Carts->find()->where(['city_id'=>$city_id,'customer_id' => $customer_id, 'item_variation_id' =>$item_variation_id]);
		if(empty($checkCartData->toArray()))
		{
				if($sale_rate == '0.00')
				{
					$item_add_quantity = 1;
				}
				$amount = $sale_rate * $item_add_quantity;
				$query = $this->Carts->query();
				$query->insert(['city_id','customer_id', 'item_variation_id','unit_id','quantity','rate','amount','cart_count'])
				->values(['city_id' =>$city_id,'customer_id' => $customer_id,'item_variation_id' => $item_variation_id,'unit_id' => $item_add_unit_id,'quantity' => $item_add_quantity,'rate' => $sale_rate,'amount' => $amount,'cart_count' => 1])->execute();
			}else{
					foreach($checkCartData as $checkCart)
					{
						$update_id = $checkCart->id;
						$exist_quantity = $checkCart->quantity;
						$exist_count = $checkCart->cart_count;
					}
						
					$update_quantity = $item_add_quantity + $exist_quantity;
					$update_count = $exist_count + 1;
					$amount = $sale_rate * $update_quantity;
					if($sale_rate == '0.00')
					{
						$update_quantity = 1;
						$update_count = 1;
					}
					$query = $this->Carts->query();
					$result = $query->update()
					->set(['quantity' =>$update_quantity,'rate'=>$sale_rate,'amount' => $amount,'cart_count' => $update_count])
					->where(['id' => $update_id])->execute();
			}
		}

		public function removeCartCombo($customer_id,$city_id,$combo_offer_id)
		{
				// get combo Data
	 		 $comboData = $this->Carts->ComboOffers->get($combo_offer_id);
	 		 $sale_rate = $comboData->sales_rate;
	 		 //$quantity = $comboData->print_quantity;
			 $quantity = 1;
	 		 // check avaliable item in cart
	   		$checkCartData = $this->Carts->find()->where(['city_id'=>$city_id,'customer_id' => $customer_id,'combo_offer_id' =>$combo_offer_id]);
				if(!empty($checkCartData->toArray()))
	 			{
						foreach($checkCartData as $checkCart)
						{
							$update_id = $checkCart->id;
							$exist_quantity = $checkCart->quantity;
							$exist_count = $checkCart->cart_count;
						}

						$update_quantity = $exist_quantity - $quantity;
						$update_count = $exist_count - 1;

						if($exist_count == 1)
						{
							$query = $this->Carts->query();
							$result = $query->delete()
							->where(['id' => $update_id])
							->execute();
						}else if($exist_count > 1){
							$amount = $sale_rate * $update_quantity;
							$query = $this->Carts->query();
							$result = $query->update()
							->set(['quantity' =>$update_quantity,'rate'=>$sale_rate,'amount' => $amount,'cart_count' => $update_count])
							->where(['id' => $update_id])->execute();
						}
				}
		}

		public function removeCartCommon($customer_id,$city_id,$item_variation_id)
		{
			// get item variations id
			$itemVariationData = $this->Carts->ItemVariations->get($item_variation_id);
			$sale_rate = $itemVariationData->sales_rate;
			$unit_Variation = $itemVariationData->unit_variation_id;
			// get quantity and unit id
			$unit_VariationData = $this->Carts->ItemVariations->UnitVariations->get($unit_Variation);
			//$item_add_quantity =  $unit_VariationData->convert_unit_qty;
			$item_add_quantity =  1;
			$item_add_unit_id = $unit_VariationData->unit_id;
			// check avaliable item in cart
			$checkCartData = $this->Carts->find()->where(['city_id'=>$city_id,'customer_id' => $customer_id, 'item_variation_id' =>$item_variation_id]);
			if(!empty($checkCartData->toArray()))
			{
				foreach($checkCartData as $checkCart)
				{
					$update_id = $checkCart->id;
					$exist_quantity = $checkCart->quantity;
					$exist_count = $checkCart->cart_count;
				}
				$update_quantity = $exist_quantity - $item_add_quantity;
				$update_count = $exist_count - 1;

				if($exist_count == 1)
				{
					$query = $this->Carts->query();
					$result = $query->delete()
					->where(['id' => $update_id])
					->execute();
				}else if($exist_count > 1){
					$amount = $sale_rate * $update_quantity;
					$query = $this->Carts->query();
					$result = $query->update()
					->set(['quantity' =>$update_quantity,'rate'=>$sale_rate,'amount' => $amount,'cart_count' => $update_count])
					->where(['id' => $update_id])->execute();
				}
			}
		}
		public function plusAddToCart()
		{
			$customer_id=$this->request->data('customer_id');
			$city_id=$this->request->data('city_id');
			$item_variation_id=$this->request->data('item_variation_id');
			$combo_offer_id = $this->request->data('combo_offer_id');
			$isCombo = $this->request->data('isCombo');

				// addToCartCombo (while adding combo offer) for code reuseabilty in both function plusAddtoCart and fetchCart
				if($isCombo == 'true')
				{
				$this->addToCartCombo($customer_id,$city_id,$combo_offer_id);
				$current_item = $this->Carts->find()->where(['Carts.city_id'=>$city_id,'Carts.customer_id' => $customer_id, 'Carts.combo_offer_id' =>$combo_offer_id])->contain(['ComboOffers'=>['ComboOfferDetails'=>['ItemVariations'=>['Items','ItemVariationMasters','UnitVariations'=>['Units']]]]])->first();
				if(empty($current_item)) { $current_item = []; }
			}else{
				// addCartCommon (while adding items) for code reuseabilty in both function plusAddtoCart and fetchCart
				$this->addCartCommon($customer_id,$city_id,$item_variation_id,$combo_offer_id,$isCombo);
				$current_item = $this->Carts->find()->where(['Carts.city_id'=>$city_id,'Carts.customer_id' => $customer_id, 'Carts.item_variation_id' =>$item_variation_id])->contain(['ItemVariations'=>['Items','ItemVariationMasters','UnitVariations'=>['Units']]])->first();
				if(empty($current_item)) { $current_item = []; }

			}
			$item_in_cart = $this->Carts->find('All')->where(['Carts.customer_id'=>$customer_id])->count();
			$success=true;
			$message="Item Added Successfully";
			$this->set(compact('success','message','item_in_cart','current_item'));
			$this->set('_serialize',['success','message','item_in_cart','current_item']);
		}

		public function removeFromCart()
		{
			$customer_id=$this->request->data('customer_id');
			$city_id=$this->request->data('city_id');
			$item_variation_id=$this->request->data('item_variation_id');
			$combo_offer_id = $this->request->data('combo_offer_id');
			$isCombo = $this->request->data('isCombo');
			if($isCombo == 'true')
			{
				// removeCartCombo for code reuseabilty in both function removeFromCart and fetchCart
				$this->removeCartCombo($customer_id,$city_id,$combo_offer_id);
				$current_item = $this->Carts->find()->where(['Carts.city_id'=>$city_id,'Carts.customer_id' => $customer_id, 'Carts.combo_offer_id' =>$combo_offer_id])->contain(['ComboOffers'=>['ComboOfferDetails'=>['ItemVariations'=>['Items','ItemVariationMasters','UnitVariations'=>['Units']]]]])->first();
				if(empty($current_item)) { $current_item = (object)[]; }
			}
			else{
				// removeCartCommon for code reuseabilty in both function removeFromCart and fetchCart
				$this->removeCartCommon($customer_id,$city_id,$item_variation_id);
				$current_item = $this->Carts->find()->where(['Carts.city_id'=>$city_id,'Carts.customer_id' => $customer_id, 'Carts.item_variation_id' =>$item_variation_id])->contain(['ItemVariations'=>['Items','ItemVariationMasters','UnitVariations'=>['Units']]])->first();
				if(empty($current_item)) { $current_item = (object)[]; }
			}
			$item_in_cart = $this->Carts->find('All')->where(['Carts.customer_id'=>$customer_id])->count();
			$success=true;
			$message="Item Remove Successfully";
			$this->set(compact('success','message','item_in_cart','current_item'));
			$this->set('_serialize',['success','message','item_in_cart','current_item']);
		}

		public function moveToBag()
		{
				$id = $this->request->data('wish_list_item_id');
				$customer_id=$this->request->data('customer_id');
				$city_id=$this->request->data('city_id');
				$item_variation_id=$this->request->data('item_variation_id');
				$combo_offer_id = $this->request->data('combo_offer_id');
				$isCombo = $this->request->data('isCombo');

				$exists = $this->Carts->WishLists->WishListItems->exists(['WishListItems.id'=>$id]);
				if($exists==1){
					$WishListItems= $this->Carts->WishLists->WishListItems->get($id);
					$this->Carts->WishLists->WishListItems->delete($WishListItems);
					$success = true;
					$message = 'removed from wish list';
					$this->plusAddToCart();
				 }else{
					 $success = false;
					 $message = 'No record found in wish list item';
					 $this->set(compact('success','message','item_in_cart','current_item'));
					 $this->set('_serialize',['success','message','item_in_cart','current_item']);
				 }
		}


		public function removefetchCart()
		{
			$item_variation_id=$this->request->data('item_variation_id');
			$customer_id=$this->request->data('customer_id');
			$city_id=$this->request->data('city_id');
			$combo_offer_id = $this->request->data('combo_offer_id');
			$isCombo = $this->request->data('isCombo');
			
			$comboData = [];
			$carts=[];
			$remaining_wallet_amount = 0.00;
			$grand_total = 0.00;
			$payableAmount = 0.00;
			$Combototal = 0.00;
			$delivery_charge_amount = '0.00';
			$tag='cart';
			if(!empty($city_id) && !empty($customer_id))
			{
					$exists = $this->Carts->Customers->exists(['id'=>$customer_id]);
				if($exists == 1)
				{
					if($isCombo == 'true')
					{
					  $item_in_cart_deletes = $this->Carts->find()->where(['Carts.customer_id'=>$customer_id,'city_id'=>$city_id,'combo_offer_id'=>$combo_offer_id])->toArray();
						$this->Carts->delete($item_in_cart_deletes[0]);	
						
					}else{
					     $item_in_cart_deletes = $this->Carts->find()->where(['Carts.customer_id'=>$customer_id,'city_id'=>$city_id,'item_variation_id'=>$item_variation_id])->toArray();
						$this->Carts->delete($item_in_cart_deletes[0]);	
					}
					  	
				
							$item_in_cart = $this->Carts->find('All')->where(['Carts.customer_id'=>$customer_id])->count();
							$address_availablity = $this->Carts->Customers->CustomerAddresses->find()
							->where(['CustomerAddresses.customer_id'=>$customer_id]);
							if(empty($address_availablity->toArray()))
							{
							  $address_available=false;
							}
							else
							{
							  $address_available=true;
							}

							$categories = $this->Carts->find()
							->where(['customer_id' => $customer_id])
							->contain(['ItemVariations'=>['ItemVariationMasters','Items'=>['Categories']]]);

							$comboData = $this->Carts->find()
							->where(['customer_id' => $customer_id])
							->contain(['ComboOffers'=>['ComboOfferDetails']])
							->group('Carts.combo_offer_id')->autoFields(true)->toArray();

							if(empty($comboData)) { $comboData = []; }
							else {  $Combototal = number_format(0.00, 2);
									foreach($comboData as $combo)
									{
										$Combototal = number_format($Combototal + $combo->amount, 2);
									}
								}
							if(!empty($categories->toArray()))
							{
									$category_arr = [];

									foreach ($categories as $cat_date) {
									    $cat_name = $cat_date->item_variation->item->category->name;
									    $cat_id = $cat_date->item_variation->item->category->id;
									    $category_arr[$cat_id] = $cat_name;
									}

									$carts_data=$this->Carts->find()
									->where(['customer_id' => $customer_id])
									->contain(['ItemVariations'=>['ItemVariationMasters','Items','UnitVariations'=>['Units']]])
									->group('Carts.item_variation_id')->autoFields(true)->toArray();

									foreach ($category_arr as $cat_key => $cat_value) {
									  foreach ($carts_data as $cart) {
									      $cart_category_id = $cart->item_variation->item->category_id;
									      if($cat_key == $cart_category_id)
									      {
									        $category[$cat_key][] = $cart;
									      }
									  }
									}

									foreach ($category as $key => $value) {
									    $carts[] = ['category_name'=>$category_arr[$key],'category'=>$value];
									}

									if(empty($carts_data))
									{ $carts=[]; }
							}

									$Customers = $this->Carts->Customers->get($customer_id, [
									  'contain' => ['Wallets'=>function($query){
									    return $query->select([
									      'total_add_amount' => $query->func()->sum('add_amount'),
									      'total_used_amount' => $query->func()->sum('used_amount'),'customer_id',
									    ]);
									  }]
									]);

									if(empty($Customers->wallets))
									{
									  $remaining_wallet_amount= number_format(0, 2);
									}
									else{
									  foreach($Customers->wallets as $Customer_data_wallet){
									    $wallet_total_add_amount = $Customer_data_wallet->total_add_amount;
									    $wallet_total_used_amount = $Customer_data_wallet->total_used_amount;
									    $remaining_wallet_amount= number_format(round($wallet_total_add_amount-$wallet_total_used_amount), 2);
									  }
									}


									// Calculation
									$payableAmount = number_format(0, 2);
									$grand_total1=0;
									if(!empty($carts_data))
									{
										foreach($carts_data as $cart_data)
										{
										  $grand_total1+=$cart_data->amount;
										}
									}

									if(!empty($comboData))
									{
										foreach($comboData as $combo)
										{
											$grand_total1+=$combo->amount;
										}
									}


									$grand_total=number_format(round($grand_total1), 2);
									$payableAmount = $payableAmount + $grand_total1;

									$delivery_charges=$this->Carts->DeliveryCharges->find()->where(['city_id'=>$city_id,'status'=>'Active']);

									if(!empty($delivery_charges->toArray()))
									{
											foreach ($delivery_charges as $delivery_charge) {
													if($delivery_charge->amount >= $grand_total)
													{
														 $delivery_charge_amount = "$delivery_charge->charge";
														 $payableAmount = $payableAmount + $delivery_charge->charge;
													}else
													{
														$delivery_charge_amount = "free";
													}
											}
									}
									$payableAmount = number_format($payableAmount,2);

							//pr($grand_total);exit;

							if(empty($carts_data) && empty($comboData))
							{
							  $success = false;
							  $message ='Empty Cart';
							  $this->set(compact('success', 'message'));
							  $this->set('_serialize', ['success', 'message']);
							}
							else
							{
							  $success = true;
							  $message = 'Cart Data found';
							  $this->set(compact('success', 'message','address_available','grand_total','delivery_charge_amount','payableAmount','remaining_wallet_amount','carts','item_in_cart','comboData','Combototal'));
							  $this->set('_serialize', ['success', 'message','remaining_wallet_amount','grand_total','delivery_charge_amount', 'payableAmount','item_in_cart','address_available','carts','comboData','Combototal']);
							}

				}
				else
				{
						$success = false;
						$message ='Invalid Customer id';
						$this->set(compact('success', 'message'));
						$this->set('_serialize', ['success', 'message']);
				}
			}else
			{
				$success = false;
				$message ='Empty City or Customer_id';
				$this->set(compact('success', 'message'));
				$this->set('_serialize', ['success', 'message']);
			}

		}
		

		
public function fetchCart()
{		
	$item_variation_id=$this->request->data('item_variation_id');
	$customer_id=$this->request->data('customer_id');
	$city_id=$this->request->data('city_id');
	$combo_offer_id = $this->request->data('combo_offer_id');
	$isCombo = $this->request->data('isCombo');
	$isPromoCode = $this->request->data('isPromoCode');
	$promo_detail_id = $this->request->data('promo_detail_id');  
	$promo_free_shipping = '';
	$comboData = [];
	$carts=[];
	$remaining_wallet_amount = 0.00;
	$delivery_charge_message = 'free';
	$customer_membership_discount = 0;
	$payableAmount = 0.00;
	$Combototal = 0.00;
	$promo_amount = 0;	
	$delivery_charge_amount = '0.00';
	$tag=$this->request->data('tag');
	
	if(!empty($city_id) && !empty($customer_id))
	{
			$exists = $this->Carts->Customers->exists(['id'=>$customer_id]);
		if($exists == 1)
		{
				if($tag=='add')
					{
					  // addCartCommon for code reuseabilty in both function plusAddToCart and fetchCart
						//echo var_dump($isCombo);exit;

						if($isCombo == 'true')
						{
							$this->addToCartCombo($customer_id,$city_id,$combo_offer_id);
						}else{
							// addCartCommon (while adding items) for code reuseabilty in both function plusAddtoCart and fetchCart
							$this->addCartCommon($customer_id,$city_id,$item_variation_id);
						}
					}
					else if($tag=='minus')
					{
					  // removeCartCommon for code reuseabilty in both function removeFromCart and fetchCart
						if($isCombo == 'true')
						{
							// removeCartCombo for code reuseabilty in both function removeFromCart and fetchCart
							$this->removeCartCombo($customer_id,$city_id,$combo_offer_id);
						}
						else{
							// removeCartCommon for code reuseabilty in both function removeFromCart and fetchCart
							$this->removeCartCommon($customer_id,$city_id,$item_variation_id);
						}
					}
					else if($tag=='remove')
					{
						if($isCombo == 'true')
						{
							$this->removefetchCart($customer_id,$city_id,$combo_offer_id);
						}else{
							$this->removefetchCart($customer_id,$city_id,$item_variation_id);
						}
					}

					$item_in_cart = $this->Carts->find('All')->where(['Carts.customer_id'=>$customer_id])
					->where(['Carts.city_id' =>$city_id])
					->count();
					
					$address_availablity = $this->Carts->Customers->CustomerAddresses->find()
					->where(['CustomerAddresses.customer_id'=>$customer_id]);
					if(empty($address_availablity->toArray()))
					{
					  $address_available=false;
					}
					else
					{
					  $address_available=true;
					}

				$carts_data_update=$this->Carts->find()
				->where(['Carts.customer_id' => $customer_id])
				->where(['Carts.city_id' =>$city_id])
				->contain(['ItemVariations'=> function($q){
						return $q->where(['ItemVariations.ready_to_sale'=>'Yes'])->where(['ItemVariations.status'=>'Active']);
					}])
				->group('Carts.item_variation_id')->autoFields(true)->toArray();
				
				if(!empty($carts_data_update))
				{
					foreach($carts_data_update as $data)
					{	
						if($data->combo_offer_id == 0)
						{
							$sales_rate=$data->item_variation->sales_rate;
							$qty = $data->cart_count;
							$amount = $sales_rate * $qty;
							$query = $this->Carts->query();		
							$result = $query->update()
							->set(['rate'=>$sales_rate,'amount' => $amount])
							->where(['id' => $data->id])->execute();					
						}
					}
				}					
					
					
					
					$categories = $this->Carts->find()
					->where(['Carts.customer_id' => $customer_id])
					->where(['Carts.city_id' =>$city_id])
					->contain(['ItemVariations'=>['ItemVariationMasters','Items'=>['Categories']]]);

					//pr($categories->toArray());exit;
					
					
					$comboData = $this->Carts->find()
					->where(['Carts.customer_id' => $customer_id])
					->where(['Carts.city_id' =>$city_id])
					->contain(['ComboOffers'=>['ComboOfferDetails']])
					->group('Carts.combo_offer_id')->toArray();

					
					//pr($comboData);exit;
					
						
						if(!empty($categories->toArray()))
						{
							$category_arr = [];

							foreach ($categories as $cat_date) {
								$cat_name = $cat_date->item_variation->item->category->name;
								$cat_id = $cat_date->item_variation->item->category->id;
								$category_arr[$cat_id] = $cat_name;
								
							}

							$carts_data=$this->Carts->find()
							->where(['Carts.customer_id' => $customer_id])
							->where(['Carts.city_id' =>$city_id])
							->contain(['ItemVariations'=>
								function($q){
									return $q->where(['ItemVariations.ready_to_sale'=>'Yes'])->where(['ItemVariations.status'=>'Active'])
									->contain(['ItemVariationMasters','Items' =>['GstFigures','Categories'] ,'UnitVariations'=>['Units']]);
							}])
							->group('Carts.item_variation_id')->autoFields(true)->toArray();
							
							
							if(!empty($carts_data))
							{
								foreach($carts_data as $data)
								{
									$item_id=$data->item_variation->item->id;
									$items_variation_id = $data->item_variation->id;
									$inNotifylist = 0;
									$inNotifylist = $this->Carts->ItemVariations->Items->Notifies->find()
										->where(['item_id'=>$item_id,'item_variation_id'=>$items_variation_id])
										->where(['customer_id'=>$customer_id])->count();
									$data->inNotifylist = false;
									if($inNotifylist  >= 1)
									{ $data->inNotifylist = true; }
									else { $data->inNotifylist = false; }


									// start maximum_quantity_purchase update
									$data->item_variation->maximum_quantity_purchase = round($data->item_variation->maximum_quantity_purchase);
									$cs = $data->item_variation->current_stock;
									$vs = $data->item_variation->virtual_stock;
									$ds = $data->item_variation->demand_stock;
									$mqp = $data->item_variation->maximum_quantity_purchase;
									
									$stock = 0.00;
									
									$stock = $cs + $vs - $ds;
									
									if($stock > $mqp)
									{
										$data->item_variation->maximum_quantity_purchase = $mqp;
									}
									else if($mqp > $stock)
									{
										$data->item_variation->maximum_quantity_purchase = $stock;
									}
									else {
										$data->item_variation->maximum_quantity_purchase = $mqp;
									}
									
									$data->item_variation->maximum_quantity_purchase = round($data->item_variation->maximum_quantity_purchase);
									
									// end maximum_quantity_purchase update									
								}
							}
							foreach ($category_arr as $cat_key => $cat_value) {
								foreach ($carts_data as $cart) {
								  $cart_category_id = $cart->item_variation->item->category_id;
								  if($cat_key == $cart_category_id)
								  {
									$category[$cat_key][] = $cart;
								  }
								}
							}									
						}

/* 							$Customers = $this->Carts->Customers->get($customer_id, [
							  'contain' => ['Wallets'=>function($query){
								return $query->select([
								  'total_add_amount' => $query->func()->sum('add_amount'),
								  'total_used_amount' => $query->func()->sum('used_amount'),'customer_id',
								]);
							  }]
							]);

							if(empty($Customers->wallets))
							{
							  $remaining_wallet_amount= number_format(0, 2);
							}
							else{
							  foreach($Customers->wallets as $Customer_data_wallet){
								$wallet_total_add_amount = $Customer_data_wallet->total_add_amount;
								$wallet_total_used_amount = $Customer_data_wallet->total_used_amount;
								$remaining_wallet_amount= number_format(round($wallet_total_add_amount-$wallet_total_used_amount),2,".","");
							  }
							} */
							
							$Customers = $this->Carts->Customers->get($customer_id, [
									  'contain' => ['Wallets'=>function($query) use($customer_id){
										  $totalInCase = $query->newExpr()
											  ->addCase(
												$query->newExpr()->add(['transaction_type' => 'Added']),
												$query->newExpr()->add(['add_amount']),
												'integer'
											  );
											  $totalOutCase = $query->newExpr()
											  ->addCase(
												$query->newExpr()->add(['transaction_type' => 'Deduct']),
												$query->newExpr()->add(['used_amount']),
												'integer'
											  );
											  return $query->select([
												'total_add_amount' => $query->func()->sum($totalInCase),
												'total_used_amount' => $query->func()->sum($totalOutCase),'id','customer_id'
											  ])
											  ->where(['Wallets.customer_id' => $customer_id])
											  ->group('customer_id')
											  ->autoFields(true); 
									  }]
									]);
								$remainingWalletAmount = 0;
								if(empty($Customers->wallets))
								{
									$remaining_wallet_amount = number_format(0,2,".","");
								}
								else{
									foreach($Customers->wallets as $Customer_data_wallet){
										$wallet_total_add_amount = $Customer_data_wallet->total_add_amount;
										$wallet_total_used_amount = $Customer_data_wallet->total_used_amount;
										$remainingWalletAmount = $wallet_total_add_amount-$wallet_total_used_amount;
										if($remainingWalletAmount > 0)
										{
											$remaining_wallet_amount = number_format(round($remainingWalletAmount),0,".","");
										}else
										{
											$remaining_wallet_amount = number_format(0,2,".","");
										}

									}
								}							
							
							
							

							// Total without any discount						
							$CartItem_Total = 0.00;
							$ComboItem_Total = 0.00;
							$TotalBeforeDiscount = 0.00;
							if(!empty($carts_data))
							{
								foreach($carts_data as $cart_data)
								{
									$CartItem_Total = $CartItem_Total + $cart_data->amount;
								}										
							}					
							if(!empty($comboData))
							{
								foreach($comboData as $combo)
								{
									foreach($combo->combo_offer->combo_offer_details as $combo_offer_detail)
									{
										$combo_offer_detail->amount = $combo_offer_detail->rate * $combo_offer_detail->quantity * $combo->quantity;
										$combo_offer_detail->amount = $combo_offer_detail->amount;
										$ComboItem_Total = $ComboItem_Total + $combo_offer_detail->amount;
									}
								}
							}
							//pr($comboData);exit;
							$TotalBeforeDiscount =  number_format(round($CartItem_Total + $ComboItem_Total),2,".","");  
							
					// Membership discount start			

						$memberShipDiscount = $this->Carts->Customers->find()
						->select(['membership_discount'])
						->where(['id' => $customer_id])
						->where(['Customers.start_date <='=> date('Y-m-d'),'Customers.end_date >='=> date('Y-m-d')])
						->first();
						if(!empty($memberShipDiscount))
						{
							$customer_membership_discount = $memberShipDiscount->membership_discount;							
						}

						//pr($memberShipDiscount->membership_discount);exit;
						
						if(!empty($memberShipDiscount) && $memberShipDiscount->membership_discount > 0)
						{
							// membership item wise discount 
							if(!empty($carts_data))
							{
								foreach($carts_data as $cart_data)
								{
									if($cart_data->item_variation->item->is_discount_enable == 'Yes')
									{
										$memberShipDiscount_Amount =  $cart_data->amount * $memberShipDiscount->membership_discount / 100 ;
										$cart_data->memberShipDiscount_Percent = $memberShipDiscount->membership_discount;
										$cart_data->memberShipDiscount_Amount = number_format($memberShipDiscount_Amount,2,".","");
										$memberShipDiscount_Amount = number_format($memberShipDiscount_Amount,2,".","");
										$amountAfter_Membership = $cart_data->amount - $memberShipDiscount_Amount;
										$cart_data->amountAfter_Membership = number_format($amountAfter_Membership,2,".","");
										$cart_data->taxAbleAmount = number_format($amountAfter_Membership,2,".","");
									}
									else{
										$cart_data->memberShipDiscount_Percent = 0.00;
										$cart_data->memberShipDiscount_Amount = 0.00;
										$cart_data->amountAfter_Membership = $cart_data->amount;
										$cart_data->taxAbleAmount = number_format($cart_data->amount,2,".","");
									}
								}										
							}
							
							// membership combo offer discount item wise 
							if(!empty($comboData))
							{
								foreach($comboData as $combo)
								{
									foreach($combo->combo_offer->combo_offer_details as $combo_offer_detail)
									{
										$combo_offer_detail->amount = $combo_offer_detail->rate * $combo_offer_detail->quantity * $combo->quantity; 
										$combo_offer_detail->amount = $combo_offer_detail->amount;
										$memberShipDiscount_Amount = $combo_offer_detail->amount * $memberShipDiscount->membership_discount/100;
										$combo_offer_detail->memberShipDiscount_Percent = $memberShipDiscount->membership_discount;
										$combo_offer_detail->memberShipDiscount_Amount = number_format($memberShipDiscount_Amount,2,".","");
										$memberShipDiscount_Amount = number_format($memberShipDiscount_Amount,2,".","");
										$amountAfter_Membership = $combo_offer_detail->amount - $memberShipDiscount_Amount;
										$combo_offer_detail->amountAfter_Membership = number_format($amountAfter_Membership,2,".","");
										$combo_offer_detail->taxAbleAmount = number_format($amountAfter_Membership,2,".","");														
									}
								}
							}
							
						}else{
							// membership item wise discount 
							if(!empty($carts_data))
							{
								foreach($carts_data as $cart_data)
								{
								   $cart_data->memberShipDiscount_Percent = 0.00;
								   $cart_data->memberShipDiscount_Amount = 0.00;
								   $cart_data->amountAfter_Membership = $cart_data->amount;
								   $cart_data->taxAbleAmount = number_format($cart_data->amount,2,".","");
								}										
							}
							// membership combo offer discount item wise 
							if(!empty($comboData))
							{
								foreach($comboData as $combo)
								{
									foreach($combo->combo_offer->combo_offer_details as $combo_offer_detail)
									{
										$combo_offer_detail->amount = $combo_offer_detail->rate * $combo_offer_detail->quantity * $combo->quantity; 
										$combo_offer_detail->amount = $combo_offer_detail->amount;
										$combo_offer_detail->memberShipDiscount_Percent = 0.00;
										$combo_offer_detail->memberShipDiscount_Amount = 0.00;
										$combo_offer_detail->amountAfter_Membership = 0.00;
										$combo_offer_detail->taxAbleAmount = number_format($combo_offer_detail->amount,2,".","");														
									}
								}
							}
							//pr($comboData);exit;
						}

						//pr($memberShipDiscount->toArray());exit;
						//pr($carts_data);exit;
						// Calculation
						
						$isPromoValidForAll = false;
						$isPromoValidForAllMsg = 'NO PromoCode Applied';
						$PromoComboValid = false;
						if($isPromoCode == 'true')
						{
							$promotionDetails = $this->Carts->Promotions->PromotionDetails->find()
							->where(['id' =>$promo_detail_id])->first();
							$discount_in_percentage = $promotionDetails->discount_in_percentage;
							$discount_of_max_amount = $promotionDetails->discount_of_max_amount;
							$promo_item_id = $promotionDetails->item_id;
							$promo_category_id = $promotionDetails->category_id;
							$promo_free_shipping = $promotionDetails->is_free_shipping;
							$cash_back = $promotionDetails->cash_back;
							$payableAmount = number_format(0, 2);
							$Combo_taxAbleAmount_Total = 0.00;
							$promo_amount = 0;
							$promoCount = 0;	
							if(!empty($comboData))
							{  $Combo_taxAbleAmount_Total = 0.00;
								foreach($comboData as $combo)
								{
								  foreach($combo->combo_offer->combo_offer_details as $combo_offer_detail)
								  {
									$comboItemDetails = $this->Carts->ItemVariations->find()->contain(['Items'])
										->where(['ItemVariations.id' =>$combo_offer_detail->item_variation_id])->first();	
									if(!empty($promo_item_id) && $promo_item_id > 0)
									{
									  $item_id = $comboItemDetails->item->id;
									   if($item_id == $promo_item_id)
										{				
											$Combo_taxAbleAmount_Total = $Combo_taxAbleAmount_Total + $combo_offer_detail->taxAbleAmount;
										}		
									} 
									else if(!empty($promo_category_id) && $promo_category_id > 0 && $promo_item_id == 0)
									{   $cate_id = $comboItemDetails->item->category_id;
										if($cate_id == $promo_category_id)
										{
											$Combo_taxAbleAmount_Total = $Combo_taxAbleAmount_Total + $combo_offer_detail->taxAbleAmount;
										}											
									}else{
										$Combo_taxAbleAmount_Total = $Combo_taxAbleAmount_Total + $combo_offer_detail->taxAbleAmount;
									}											
								  }	
								}
							}
							$BothTaxableCmboItem = 0.00;
							$taxAbleAmount_Total = 0.00;
							if(!empty($carts_data)){
								
								foreach($carts_data as $cart_data)
								{
									if(!empty($promo_item_id) && $promo_item_id > 0)
									{
									  $item_id = $cart_data->item_variation->item->id;
									   if($item_id == $promo_item_id)
										{				
											if($cart_data->item_variation->item->is_discount_enable == 'Yes')
											{
												$taxAbleAmount_Total = $taxAbleAmount_Total + $cart_data->taxAbleAmount;
											}
										}		
									} else if(!empty($promo_category_id) && $promo_category_id > 0 && $promo_item_id == 0)
									{
										$cate_id = $cart_data->item_variation->item->category_id;
										if($cate_id == $promo_category_id)
										{
											if($cart_data->item_variation->item->is_discount_enable == 'Yes')
											{  
												$taxAbleAmount_Total = $taxAbleAmount_Total + $cart_data->taxAbleAmount;
											}
										}											
									}else {
										if($cart_data->item_variation->item->is_discount_enable == 'Yes')
										{
											$taxAbleAmount_Total = $taxAbleAmount_Total + $cart_data->taxAbleAmount;
										}
									}											
								 }	
								 
								$BothTaxableCmboItem = $Combo_taxAbleAmount_Total + $taxAbleAmount_Total;
								
								/* echo $Combo_taxAbleAmount_Total . '<br>';
								echo $taxAbleAmount_Total.'<br>';
								pr($BothTaxableCmboItem);exit;  */
								foreach($carts_data as $cart_data){
								$item_id = $cart_data->item_variation->item->id;
								$cart_data->gst_percentage = $cart_data->item_variation->item->gst_figure->tax_percentage;
								$cate_id = $cart_data->item_variation->item->category_id;
								
									if($cart_data->item_variation->item->is_discount_enable == 'Yes')
									{
										if($cash_back == 0){
											if($discount_in_percentage == 0)
											{
												if($promo_category_id > 0 && $BothTaxableCmboItem > 0 && $promo_category_id == $cate_id && $promo_item_id == 0 && $discount_of_max_amount ==0 && $BothTaxableCmboItem > $promotionDetails->discount_in_amount)
												{	$promoCount++; 
													$isPromoValidForAll = true;
													$isPromoValidForAllMsg = 'PromoCode Applied Successfully';
													$promoDiscount_Amount =  $cart_data->taxAbleAmount / $BothTaxableCmboItem * $promotionDetails->discount_in_amount;
													$cart_data->promoDiscount_Percent = $promotionDetails->discount_in_percentage;
													$cart_data->promoDiscount_in_Amount = $promotionDetails->discount_in_amount;
													$cart_data->promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
													$promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
													$amountAfter_Promocode = $cart_data->taxAbleAmount - $promoDiscount_Amount;
													$cart_data->amountAfter_Promocode = number_format($amountAfter_Promocode,2,".","");
													$cart_data->taxAbleAmount = number_format($amountAfter_Promocode,2,".","");
													$cart_data->gstPercentageAdd = $cart_data->gst_percentage + 100;
													$cart_data->total_GST = $cart_data->taxAbleAmount * $cart_data->gst_percentage / $cart_data->gstPercentageAdd; 
													$cart_data->total_GST_division = round($cart_data->total_GST / 2,2);
													$cart_data->total_GST = $cart_data->total_GST_division * 2;
													$cart_data->taxAbleAmount = $cart_data->taxAbleAmount-$cart_data->total_GST;
													$cart_data->total_with_GST = $cart_data->taxAbleAmount + $cart_data->total_GST; 
													$cart_data->total_GST = number_format($cart_data->total_GST,2,".","");
													$cart_data->total_with_GST = number_format($cart_data->total_with_GST,2,".","");
													$cart_data->isPromoValid = true;
												}
												else if($promo_item_id > 0 && $BothTaxableCmboItem > 0  && $promo_item_id == $item_id && $discount_of_max_amount == 0){ 
													$promoCount++;
													$isPromoValidForAll = true;
													$isPromoValidForAllMsg = 'PromoCode Applied Successfully';
													$promoDiscount_Amount =  $cart_data->taxAbleAmount / $BothTaxableCmboItem * $promotionDetails->discount_in_amount;
													$cart_data->promoDiscount_Percent = $promotionDetails->discount_in_percentage;
													$cart_data->promoDiscount_in_Amount = $promotionDetails->discount_in_amount;
													$cart_data->promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
													$promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
													$amountAfter_Promocode = $cart_data->taxAbleAmount - $promoDiscount_Amount;
													$cart_data->amountAfter_Promocode = number_format($amountAfter_Promocode,2,".","");
													$cart_data->taxAbleAmount = number_format($amountAfter_Promocode,2,".","");
													$cart_data->gstPercentageAdd = $cart_data->gst_percentage + 100;
													$cart_data->total_GST = $cart_data->taxAbleAmount * $cart_data->gst_percentage / $cart_data->gstPercentageAdd; 
													$cart_data->total_GST_division = round($cart_data->total_GST / 2,2);
													$cart_data->total_GST = $cart_data->total_GST_division * 2;
													$cart_data->taxAbleAmount = $cart_data->taxAbleAmount-$cart_data->total_GST;
													$cart_data->total_with_GST = $cart_data->taxAbleAmount + $cart_data->total_GST; 
													$cart_data->total_GST = number_format($cart_data->total_GST,2,".","");
													$cart_data->total_with_GST = number_format($cart_data->total_with_GST,2,".","");
													$cart_data->isPromoValid = true;
												}

												
												else if($promo_item_id > 0 && $BothTaxableCmboItem > 0  && $promo_item_id == $item_id && $discount_of_max_amount > 0 && $BothTaxableCmboItem >= $discount_of_max_amount){
													$promoCount++;
													$isPromoValidForAll = true;
													$isPromoValidForAllMsg = 'PromoCode Applied Successfully';
													$promoDiscount_Amount =  $cart_data->taxAbleAmount / $BothTaxableCmboItem * $promotionDetails->discount_in_amount;
													$cart_data->promoDiscount_Percent = $promotionDetails->discount_in_percentage;
													$cart_data->promoDiscount_in_Amount = $promotionDetails->discount_in_amount;
													$cart_data->promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
													$promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
													$amountAfter_Promocode = $cart_data->taxAbleAmount - $promoDiscount_Amount;
													$cart_data->amountAfter_Promocode = number_format($amountAfter_Promocode,2,".","");
													$cart_data->taxAbleAmount = number_format($amountAfter_Promocode,2,".","");
													$cart_data->gstPercentageAdd = $cart_data->gst_percentage + 100;
													$cart_data->total_GST = $cart_data->taxAbleAmount * $cart_data->gst_percentage / $cart_data->gstPercentageAdd; 
													$cart_data->total_GST_division = round($cart_data->total_GST / 2,2);
													$cart_data->total_GST = $cart_data->total_GST_division * 2;
													$cart_data->taxAbleAmount = $cart_data->taxAbleAmount-$cart_data->total_GST;
													$cart_data->total_with_GST = $cart_data->taxAbleAmount + $cart_data->total_GST; 
													$cart_data->total_GST = number_format($cart_data->total_GST,2,".","");
													$cart_data->total_with_GST = number_format($cart_data->total_with_GST,2,".","");
													$cart_data->isPromoValid = true;
												}												
												
												else if($discount_of_max_amount > 0 && $BothTaxableCmboItem >= $discount_of_max_amount && $promo_category_id > 0 && $promo_category_id == $cate_id){ 
													$promoCount++;
													$isPromoValidForAll = true;
													$isPromoValidForAllMsg = 'PromoCode Applied Successfully';
													$promoDiscount_Amount =  $cart_data->taxAbleAmount / $BothTaxableCmboItem * $promotionDetails->discount_in_amount;
													$cart_data->promoDiscount_Percent = $promotionDetails->discount_in_percentage;
													$cart_data->promoDiscount_in_Amount = $promotionDetails->discount_in_amount;
													$cart_data->promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
													$promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
													$amountAfter_Promocode = $cart_data->taxAbleAmount - $promoDiscount_Amount;
													$cart_data->amountAfter_Promocode = number_format($amountAfter_Promocode,2,".","");
													$cart_data->taxAbleAmount = number_format($amountAfter_Promocode,2,".","");
													$cart_data->gstPercentageAdd = $cart_data->gst_percentage + 100;
													$cart_data->total_GST = $cart_data->taxAbleAmount * $cart_data->gst_percentage / $cart_data->gstPercentageAdd; 
													$cart_data->total_GST_division = round($cart_data->total_GST / 2,2);
													$cart_data->total_GST = $cart_data->total_GST_division * 2;
													$cart_data->taxAbleAmount = $cart_data->taxAbleAmount-$cart_data->total_GST;
													$cart_data->total_with_GST = $cart_data->taxAbleAmount + $cart_data->total_GST; 
													$cart_data->total_GST = number_format($cart_data->total_GST,2,".","");
													$cart_data->total_with_GST = number_format($cart_data->total_with_GST,2,".","");
													$cart_data->isPromoValid = true;
												}






												else if($discount_of_max_amount > 0 && $BothTaxableCmboItem > 0 && $BothTaxableCmboItem >= $discount_of_max_amount && $promo_item_id == 0 && $promo_category_id ==0){
													$promoCount++;
													$isPromoValidForAll = true;
													$isPromoValidForAllMsg = 'PromoCode Applied Successfully';
													$promoDiscount_Amount =  $cart_data->taxAbleAmount / $BothTaxableCmboItem * $promotionDetails->discount_in_amount;
													$cart_data->promoDiscount_Percent = $promotionDetails->discount_in_percentage;
													$cart_data->promoDiscount_in_Amount = $promotionDetails->discount_in_amount;
													$cart_data->promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
													$promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
													$amountAfter_Promocode = $cart_data->taxAbleAmount - $promoDiscount_Amount;
													$cart_data->amountAfter_Promocode = number_format($amountAfter_Promocode,2,".","");
													$cart_data->taxAbleAmount = number_format($amountAfter_Promocode,2,".","");
													$cart_data->gstPercentageAdd = $cart_data->gst_percentage + 100;
													$cart_data->total_GST = $cart_data->taxAbleAmount * $cart_data->gst_percentage / $cart_data->gstPercentageAdd; 
													$cart_data->total_GST_division = round($cart_data->total_GST / 2,2);
													$cart_data->total_GST = $cart_data->total_GST_division * 2;
													$cart_data->taxAbleAmount = $cart_data->taxAbleAmount-$cart_data->total_GST;
													$cart_data->total_with_GST = $cart_data->taxAbleAmount + $cart_data->total_GST; 
													$cart_data->total_GST = number_format($cart_data->total_GST,2,".","");
													$cart_data->total_with_GST = number_format($cart_data->total_with_GST,2,".","");
													$cart_data->isPromoValid = true;
												}
												else if($promo_category_id == 0 && $BothTaxableCmboItem > 0 && $promo_item_id == 0 && $discount_of_max_amount ==0){
													$promoCount++;
													$isPromoValidForAll = true;
													$isPromoValidForAllMsg = 'PromoCode Applied Successfully';
													$promoDiscount_Amount =  $cart_data->taxAbleAmount / $BothTaxableCmboItem * $promotionDetails->discount_in_amount;
													$cart_data->promoDiscount_Percent = $promotionDetails->discount_in_percentage;
													$cart_data->promoDiscount_in_Amount = $promotionDetails->discount_in_amount;
													$cart_data->promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
													$promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
													$amountAfter_Promocode = $cart_data->taxAbleAmount - $promoDiscount_Amount;
													$cart_data->amountAfter_Promocode = number_format($amountAfter_Promocode,2,".","");
													$cart_data->taxAbleAmount = number_format($amountAfter_Promocode,2,".","");
													$cart_data->gstPercentageAdd = $cart_data->gst_percentage + 100;
													$cart_data->total_GST = $cart_data->taxAbleAmount * $cart_data->gst_percentage / $cart_data->gstPercentageAdd; 
													$cart_data->total_GST_division = round($cart_data->total_GST / 2,2);
													$cart_data->total_GST = $cart_data->total_GST_division * 2;
													$cart_data->taxAbleAmount = $cart_data->taxAbleAmount-$cart_data->total_GST;
													$cart_data->total_with_GST = $cart_data->taxAbleAmount + $cart_data->total_GST; 
													$cart_data->total_GST = number_format($cart_data->total_GST,2,".","");
													$cart_data->total_with_GST = number_format($cart_data->total_with_GST,2,".","");													
													$cart_data->isPromoValid = true;
												}else{
													if($promoCount == 0)
													{
														$isPromoValidForAll = false;
														$isPromoValidForAllMsg = 'Invalid PromoCode';
													}else
													{
														$isPromoValidForAll = true;
														$isPromoValidForAllMsg = 'PromoCode Applied Successfully';
													}

													$cart_data->promoDiscount_Percent = 0.00;
													$cart_data->promoDiscount_in_Amount = 0.00;
													$cart_data->promoDiscount_Amount = 0.00;
													$cart_data->amountAfter_Promocode = $cart_data->taxAbleAmount;
													$cart_data->taxAbleAmount = $cart_data->taxAbleAmount;
													$cart_data->gstPercentageAdd = $cart_data->gst_percentage + 100;
													$cart_data->total_GST = $cart_data->taxAbleAmount * $cart_data->gst_percentage / $cart_data->gstPercentageAdd; 
													$cart_data->total_GST_division = round($cart_data->total_GST / 2,2);
													$cart_data->total_GST = $cart_data->total_GST_division * 2;
													$cart_data->taxAbleAmount = $cart_data->taxAbleAmount-$cart_data->total_GST;
													$cart_data->total_with_GST = $cart_data->taxAbleAmount + $cart_data->total_GST; 
													$cart_data->total_GST = number_format($cart_data->total_GST,2,".","");
													$cart_data->total_with_GST = number_format($cart_data->total_with_GST,2,".","");													
													$cart_data->isPromoValid = true;
												}
											}else{
												if($promo_category_id > 0 && $promo_category_id == $cate_id && $promo_item_id == 0 && $discount_of_max_amount ==0)
												{	$promoCount++;
													$isPromoValidForAll = true;
													$isPromoValidForAllMsg = 'PromoCode Applied Successfully';
													$promoDiscount_Amount =  $cart_data->taxAbleAmount * $promotionDetails->discount_in_percentage / 100;
													$cart_data->promoDiscount_Percent = $promotionDetails->discount_in_percentage;
													$cart_data->promoDiscount_in_Amount = $promotionDetails->discount_in_amount;
													$cart_data->promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
													$promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
													$amountAfter_Promocode = $cart_data->taxAbleAmount - $promoDiscount_Amount;
													$cart_data->amountAfter_Promocode = number_format($amountAfter_Promocode,2,".","");
													$cart_data->taxAbleAmount = number_format($amountAfter_Promocode,2,".","");
													$cart_data->gstPercentageAdd = $cart_data->gst_percentage + 100;
													$cart_data->total_GST = $cart_data->taxAbleAmount * $cart_data->gst_percentage / $cart_data->gstPercentageAdd; 
													$cart_data->total_GST_division = round($cart_data->total_GST / 2,2);
													$cart_data->total_GST = $cart_data->total_GST_division * 2;
													$cart_data->taxAbleAmount = $cart_data->taxAbleAmount-$cart_data->total_GST;
													$cart_data->total_with_GST = $cart_data->taxAbleAmount + $cart_data->total_GST; 
													$cart_data->total_GST = number_format($cart_data->total_GST,2,".","");
													$cart_data->total_with_GST = number_format($cart_data->total_with_GST,2,".","");
													$cart_data->isPromoValid = true;
												}
												else if($promo_item_id > 0  && $promo_item_id == $item_id && $discount_of_max_amount == 0){
													$promoCount++;
													$isPromoValidForAll = true;
													$isPromoValidForAllMsg = 'PromoCode Applied Successfully';
													$promoDiscount_Amount =  $cart_data->taxAbleAmount * $promotionDetails->discount_in_percentage / 100;
													$cart_data->promoDiscount_Percent = $promotionDetails->discount_in_percentage;
													$cart_data->promoDiscount_in_Amount = $promotionDetails->discount_in_amount;
													$cart_data->promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
													$promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
													$amountAfter_Promocode = $cart_data->taxAbleAmount - $promoDiscount_Amount;
													$cart_data->amountAfter_Promocode = number_format($amountAfter_Promocode,2,".","");
													$cart_data->taxAbleAmount = number_format($amountAfter_Promocode,2,".","");
													$cart_data->gstPercentageAdd = $cart_data->gst_percentage + 100;
													$cart_data->total_GST = $cart_data->taxAbleAmount * $cart_data->gst_percentage / $cart_data->gstPercentageAdd; 
													$cart_data->total_GST_division = round($cart_data->total_GST / 2,2);
													$cart_data->total_GST = $cart_data->total_GST_division * 2;
													$cart_data->taxAbleAmount = $cart_data->taxAbleAmount-$cart_data->total_GST;
													$cart_data->total_with_GST = $cart_data->taxAbleAmount + $cart_data->total_GST; 
													$cart_data->total_GST = number_format($cart_data->total_GST,2,".","");
													$cart_data->total_with_GST = number_format($cart_data->total_with_GST,2,".","");
													$cart_data->isPromoValid = true;
												}

												else if($discount_of_max_amount > 0 && $BothTaxableCmboItem >= $discount_of_max_amount && $promo_category_id > 0 && $promo_category_id == $cate_id){
													$promoCount++;
													$isPromoValidForAll = true;
													$isPromoValidForAllMsg = 'PromoCode Applied Successfully';
													$promoDiscount_Amount =  $cart_data->taxAbleAmount * $promotionDetails->discount_in_percentage / 100;
													$cart_data->promoDiscount_Percent = $promotionDetails->discount_in_percentage;
													$cart_data->promoDiscount_in_Amount = $promotionDetails->discount_in_amount;
													$cart_data->promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
													$promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
													$amountAfter_Promocode = $cart_data->taxAbleAmount - $promoDiscount_Amount;
													$cart_data->amountAfter_Promocode = number_format($amountAfter_Promocode,2,".","");
													$cart_data->taxAbleAmount = number_format($amountAfter_Promocode,2,".","");
													$cart_data->gstPercentageAdd = $cart_data->gst_percentage + 100;
													$cart_data->total_GST = $cart_data->taxAbleAmount * $cart_data->gst_percentage / $cart_data->gstPercentageAdd; 
													$cart_data->total_GST_division = round($cart_data->total_GST / 2,2);
													$cart_data->total_GST = $cart_data->total_GST_division * 2;
													$cart_data->taxAbleAmount = $cart_data->taxAbleAmount-$cart_data->total_GST;
													$cart_data->total_with_GST = $cart_data->taxAbleAmount + $cart_data->total_GST; 
													$cart_data->total_GST = number_format($cart_data->total_GST,2,".","");
													$cart_data->total_with_GST = number_format($cart_data->total_with_GST,2,".","");
													$cart_data->isPromoValid = true;
												}

												else if($promo_item_id > 0 && $BothTaxableCmboItem > 0  && $promo_item_id == $item_id && $discount_of_max_amount > 0 && $BothTaxableCmboItem >= $discount_of_max_amount){
													$promoCount++;
													$isPromoValidForAll = true;
													$isPromoValidForAllMsg = 'PromoCode Applied Successfully';
													$promoDiscount_Amount =  $cart_data->taxAbleAmount * $promotionDetails->discount_in_percentage / 100;
													$cart_data->promoDiscount_Percent = $promotionDetails->discount_in_percentage;
													$cart_data->promoDiscount_in_Amount = $promotionDetails->discount_in_amount;
													$cart_data->promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
													$promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
													$amountAfter_Promocode = $cart_data->taxAbleAmount - $promoDiscount_Amount;
													$cart_data->amountAfter_Promocode = number_format($amountAfter_Promocode,2,".","");
													$cart_data->taxAbleAmount = number_format($amountAfter_Promocode,2,".","");
													$cart_data->gstPercentageAdd = $cart_data->gst_percentage + 100;
													$cart_data->total_GST = $cart_data->taxAbleAmount * $cart_data->gst_percentage / $cart_data->gstPercentageAdd; 
													$cart_data->total_GST_division = round($cart_data->total_GST / 2,2);
													$cart_data->total_GST = $cart_data->total_GST_division * 2;
													$cart_data->taxAbleAmount = $cart_data->taxAbleAmount-$cart_data->total_GST;
													$cart_data->total_with_GST = $cart_data->taxAbleAmount + $cart_data->total_GST; 
													$cart_data->total_GST = number_format($cart_data->total_GST,2,".","");
													$cart_data->total_with_GST = number_format($cart_data->total_with_GST,2,".","");
													$cart_data->isPromoValid = true;
												}												
												
												
												
												else if($discount_of_max_amount > 0 && $BothTaxableCmboItem >= $discount_of_max_amount && $promo_item_id == 0 && $promo_category_id ==0){
													$promoCount++;
													$isPromoValidForAll = true;
													$isPromoValidForAllMsg = 'PromoCode Applied Successfully';
													$promoDiscount_Amount =  $cart_data->taxAbleAmount * $promotionDetails->discount_in_percentage / 100;
													$cart_data->promoDiscount_Percent = $promotionDetails->discount_in_percentage;
													$cart_data->promoDiscount_in_Amount = $promotionDetails->discount_in_amount;
													$cart_data->promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
													$promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
													$amountAfter_Promocode = $cart_data->taxAbleAmount - $promoDiscount_Amount;
													$cart_data->amountAfter_Promocode = number_format($amountAfter_Promocode,2,".","");
													$cart_data->taxAbleAmount = number_format($amountAfter_Promocode,2,".","");
													$cart_data->gstPercentageAdd = $cart_data->gst_percentage + 100;
													$cart_data->total_GST = $cart_data->taxAbleAmount * $cart_data->gst_percentage / $cart_data->gstPercentageAdd; 
													$cart_data->total_GST_division = round($cart_data->total_GST / 2,2);
													$cart_data->total_GST = $cart_data->total_GST_division * 2;
													$cart_data->taxAbleAmount = $cart_data->taxAbleAmount-$cart_data->total_GST;
													$cart_data->total_with_GST = $cart_data->taxAbleAmount + $cart_data->total_GST; 
													$cart_data->total_GST = number_format($cart_data->total_GST,2,".","");
													$cart_data->total_with_GST = number_format($cart_data->total_with_GST,2,".","");
													$cart_data->isPromoValid = true;
												}
												else if($promo_category_id == 0 && $promo_item_id == 0 && $discount_of_max_amount ==0){
													$promoCount++;
													$isPromoValidForAll = true;
													$isPromoValidForAllMsg = 'PromoCode Applied Successfully';
													$promoDiscount_Amount =  $cart_data->taxAbleAmount * $promotionDetails->discount_in_percentage / 100;
													$cart_data->promoDiscount_Percent = $promotionDetails->discount_in_percentage;
													$cart_data->promoDiscount_in_Amount = $promotionDetails->discount_in_amount;
													$cart_data->promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
													$promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
													$amountAfter_Promocode = $cart_data->taxAbleAmount - $promoDiscount_Amount;
													$cart_data->amountAfter_Promocode = number_format($amountAfter_Promocode,2,".","");
													$cart_data->taxAbleAmount = number_format($amountAfter_Promocode,2,".","");
													$cart_data->gstPercentageAdd = $cart_data->gst_percentage + 100;
													$cart_data->total_GST = $cart_data->taxAbleAmount * $cart_data->gst_percentage / $cart_data->gstPercentageAdd; 
													$cart_data->total_GST_division = round($cart_data->total_GST / 2,2);
													$cart_data->total_GST = $cart_data->total_GST_division * 2;
													$cart_data->taxAbleAmount = $cart_data->taxAbleAmount-$cart_data->total_GST;
													$cart_data->total_with_GST = $cart_data->taxAbleAmount + $cart_data->total_GST; 
													$cart_data->total_GST = number_format($cart_data->total_GST,2,".","");
													$cart_data->total_with_GST = number_format($cart_data->total_with_GST,2,".","");													
													$cart_data->isPromoValid = true;
												}else{
													if($promoCount==0)
													{
														$isPromoValidForAll = false;
														$isPromoValidForAllMsg = 'Invalid PromoCode';
													}else
													{
														$isPromoValidForAll = true;
														$isPromoValidForAllMsg = 'PromoCode Applied Successfully';
													}

													$cart_data->promoDiscount_Percent = 0.00;
													$cart_data->promoDiscount_in_Amount = 0.00;
													$cart_data->promoDiscount_Amount = 0.00;
													$cart_data->amountAfter_Promocode = $cart_data->taxAbleAmount;
													$cart_data->taxAbleAmount = $cart_data->taxAbleAmount;
													$cart_data->gstPercentageAdd = $cart_data->gst_percentage + 100;
													$cart_data->total_GST = $cart_data->taxAbleAmount * $cart_data->gst_percentage / $cart_data->gstPercentageAdd; 
													$cart_data->total_GST_division = round($cart_data->total_GST / 2,2);
													$cart_data->total_GST = $cart_data->total_GST_division * 2;
													$cart_data->taxAbleAmount = $cart_data->taxAbleAmount-$cart_data->total_GST;
													$cart_data->total_with_GST = $cart_data->taxAbleAmount + $cart_data->total_GST; 
													$cart_data->total_GST = number_format($cart_data->total_GST,2,".","");
													$cart_data->total_with_GST = number_format($cart_data->total_with_GST,2,".","");													
													$cart_data->isPromoValid = false;
												}
											}
										}										
									}else{ 
													if($promoCount==0)
													{
														$isPromoValidForAll = false;
														$isPromoValidForAllMsg = 'Invalid PromoCode';
													}else
													{
														$isPromoValidForAll = true;
														$isPromoValidForAllMsg = 'PromoCode Applied Successfully';
													}
											$cart_data->promoDiscount_Percent = 0.00;
											$cart_data->promoDiscount_in_Amount = 0.00;
											$cart_data->promoDiscount_Amount = 0.00;
											$cart_data->amountAfter_Promocode = $cart_data->taxAbleAmount;
											$cart_data->taxAbleAmount = $cart_data->taxAbleAmount;
											$cart_data->gstPercentageAdd = $cart_data->gst_percentage + 100;
											$cart_data->total_GST = $cart_data->taxAbleAmount * $cart_data->gst_percentage / $cart_data->gstPercentageAdd; 
											$cart_data->total_GST_division = round($cart_data->total_GST / 2,2);
											$cart_data->total_GST = $cart_data->total_GST_division * 2;
											$cart_data->taxAbleAmount = $cart_data->taxAbleAmount-$cart_data->total_GST;
											$cart_data->total_with_GST = $cart_data->taxAbleAmount + $cart_data->total_GST; 
											$cart_data->total_GST = number_format($cart_data->total_GST,2,".","");
											$cart_data->total_with_GST = number_format($cart_data->total_with_GST,2,".","");										
											$cart_data->isPromoValid = false;
									}		
								
								}								
							}
							
							if(!empty($comboData))
							{  						
									
								foreach($comboData as $combo)
								{
									$promoDiscount_Amount = 0.00;
									$promoTotal_Amount = 0.00;
									//$taxAbleAmount_Total = 0.00;
									$combowith_GST_Amount = 0.00;
									$comboTotal_Amount = 0.00;
									$memberShipDiscount_Amount = 0.00;

									foreach($combo->combo_offer->combo_offer_details as $combo_offer_detail)
									{
										$comboItemDetails = $this->Carts->ItemVariations->find()
										->contain(['Items'])
										->where(['ItemVariations.id' =>$combo_offer_detail->item_variation_id])
										->first();
									   $item_id = $comboItemDetails->item->id;
									   //$combo_offer_detail->gst_percentage = $combo_offer_detail->gst_percentage;
									   $cate_id = $comboItemDetails->item->category_id;
										if($cash_back == 0){
											if($discount_in_percentage == 0)
											{
												if($promo_category_id > 0 && $BothTaxableCmboItem > 0 && $promo_category_id == $cate_id && $promo_item_id == 0 && $discount_of_max_amount ==0)
												{
														$promoCount++;
														$isPromoValidForAll = true;
														$isPromoValidForAllMsg = 'PromoCode Applied Successfully';
														$promoDiscount_Amount =  $combo_offer_detail->taxAbleAmount / $BothTaxableCmboItem * $promotionDetails->discount_in_amount;
														$combo_offer_detail->promoDiscount_Percent = $promotionDetails->discount_in_percentage;
														$combo_offer_detail->promoDiscount_in_Amount = $promotionDetails->discount_in_amount;
														$combo_offer_detail->promoDiscount_Amount =  number_format($promoDiscount_Amount,2,".",""); 
														$promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
														$amountAfter_Promocode = $combo_offer_detail->taxAbleAmount - $promoDiscount_Amount;
														$combo_offer_detail->amountAfter_Promocode = number_format($amountAfter_Promocode,2,".","");
														$combo_offer_detail->taxAbleAmount = number_format($amountAfter_Promocode,2,".","");
														$combo_offer_detail->gstPercentageAdd = $combo_offer_detail->gst_percentage + 100;
														$combo_offer_detail->total_GST = $combo_offer_detail->taxAbleAmount * $combo_offer_detail->gst_percentage / $combo_offer_detail->gstPercentageAdd; 
														$combo_offer_detail->total_GST_division = round($combo_offer_detail->total_GST / 2,2);
														$combo_offer_detail->total_GST = $combo_offer_detail->total_GST_division * 2;
														$combo_offer_detail->taxAbleAmount = $combo_offer_detail->taxAbleAmount-$combo_offer_detail->total_GST;
														$combo_offer_detail->total_with_GST = $combo_offer_detail->taxAbleAmount + $combo_offer_detail->total_GST; 
														$combo_offer_detail->total_GST = number_format($combo_offer_detail->total_GST,2,".","");
														$combo_offer_detail->total_with_GST = number_format($combo_offer_detail->total_with_GST,2,".","");
														$combo_offer_detail->isPromoValid = true;
														$PromoComboValid = true;
												}

												else if($discount_of_max_amount > 0 && $BothTaxableCmboItem >= $discount_of_max_amount && $promo_category_id > 0 && $promo_category_id == $cate_id){												
														$promoCount++;
														$isPromoValidForAll = true;
														$isPromoValidForAllMsg = 'PromoCode Applied Successfully';
														$promoDiscount_Amount =  $combo_offer_detail->taxAbleAmount / $BothTaxableCmboItem * $promotionDetails->discount_in_amount;
														$combo_offer_detail->promoDiscount_Percent = $promotionDetails->discount_in_percentage;
														$combo_offer_detail->promoDiscount_in_Amount = $promotionDetails->discount_in_amount;
														$combo_offer_detail->promoDiscount_Amount =  number_format($promoDiscount_Amount,2,".",""); 
														$promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
														$amountAfter_Promocode = $combo_offer_detail->taxAbleAmount - $promoDiscount_Amount;
														$combo_offer_detail->amountAfter_Promocode = number_format($amountAfter_Promocode,2,".","");
														$combo_offer_detail->taxAbleAmount = number_format($amountAfter_Promocode,2,".","");
														$combo_offer_detail->gstPercentageAdd = $combo_offer_detail->gst_percentage + 100;
														$combo_offer_detail->total_GST = $combo_offer_detail->taxAbleAmount * $combo_offer_detail->gst_percentage / $combo_offer_detail->gstPercentageAdd; 
														$combo_offer_detail->total_GST_division = round($combo_offer_detail->total_GST / 2,2);
														$combo_offer_detail->total_GST = $combo_offer_detail->total_GST_division * 2;
														$combo_offer_detail->taxAbleAmount = $combo_offer_detail->taxAbleAmount-$combo_offer_detail->total_GST;
														$combo_offer_detail->total_with_GST = $combo_offer_detail->taxAbleAmount + $combo_offer_detail->total_GST; 
														$combo_offer_detail->total_GST = number_format($combo_offer_detail->total_GST,2,".","");
														$combo_offer_detail->total_with_GST = number_format($combo_offer_detail->total_with_GST,2,".","");
														$combo_offer_detail->isPromoValid = true;
														$PromoComboValid = true;
												}

												else if($promo_item_id > 0 && $BothTaxableCmboItem > 0  && $promo_item_id == $item_id && $discount_of_max_amount > 0 && $BothTaxableCmboItem >= $discount_of_max_amount){												
														$promoCount++;
														$isPromoValidForAll = true;
														$isPromoValidForAllMsg = 'PromoCode Applied Successfully';
														$promoDiscount_Amount =  $combo_offer_detail->taxAbleAmount / $BothTaxableCmboItem * $promotionDetails->discount_in_amount;
														$combo_offer_detail->promoDiscount_Percent = $promotionDetails->discount_in_percentage;
														$combo_offer_detail->promoDiscount_in_Amount = $promotionDetails->discount_in_amount;
														$combo_offer_detail->promoDiscount_Amount =  number_format($promoDiscount_Amount,2,".",""); 
														$promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
														$amountAfter_Promocode = $combo_offer_detail->taxAbleAmount - $promoDiscount_Amount;
														$combo_offer_detail->amountAfter_Promocode = number_format($amountAfter_Promocode,2,".","");
														$combo_offer_detail->taxAbleAmount = number_format($amountAfter_Promocode,2,".","");
														$combo_offer_detail->gstPercentageAdd = $combo_offer_detail->gst_percentage + 100;
														$combo_offer_detail->total_GST = $combo_offer_detail->taxAbleAmount * $combo_offer_detail->gst_percentage / $combo_offer_detail->gstPercentageAdd; 
														$combo_offer_detail->total_GST_division = round($combo_offer_detail->total_GST / 2,2);
														$combo_offer_detail->total_GST = $combo_offer_detail->total_GST_division * 2;
														$combo_offer_detail->taxAbleAmount = $combo_offer_detail->taxAbleAmount-$combo_offer_detail->total_GST;
														$combo_offer_detail->total_with_GST = $combo_offer_detail->taxAbleAmount + $combo_offer_detail->total_GST; 
														$combo_offer_detail->total_GST = number_format($combo_offer_detail->total_GST,2,".","");
														$combo_offer_detail->total_with_GST = number_format($combo_offer_detail->total_with_GST,2,".","");
														$combo_offer_detail->isPromoValid = true;
														$PromoComboValid = true;
												}												
												


												
												else if($promo_item_id > 0 && $BothTaxableCmboItem > 0  && $promo_item_id == $item_id && $discount_of_max_amount == 0){
														$promoCount++;
														$isPromoValidForAll = true;
														$isPromoValidForAllMsg = 'PromoCode Applied Successfully';
														$promoDiscount_Amount =  $combo_offer_detail->taxAbleAmount / $BothTaxableCmboItem * $promotionDetails->discount_in_amount;
														$combo_offer_detail->promoDiscount_Percent = $promotionDetails->discount_in_percentage;
														$combo_offer_detail->promoDiscount_in_Amount = $promotionDetails->discount_in_amount;
														$combo_offer_detail->promoDiscount_Amount =  number_format($promoDiscount_Amount,2,".",""); 
														$promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
														$amountAfter_Promocode = $combo_offer_detail->taxAbleAmount - $promoDiscount_Amount;
														$combo_offer_detail->amountAfter_Promocode = number_format($amountAfter_Promocode,2,".","");
														$combo_offer_detail->taxAbleAmount = number_format($amountAfter_Promocode,2,".","");
														$combo_offer_detail->gstPercentageAdd = $combo_offer_detail->gst_percentage + 100;
														$combo_offer_detail->total_GST = $combo_offer_detail->taxAbleAmount * $combo_offer_detail->gst_percentage / $combo_offer_detail->gstPercentageAdd; 
														$combo_offer_detail->total_GST_division = round($combo_offer_detail->total_GST / 2,2);
														$combo_offer_detail->total_GST = $combo_offer_detail->total_GST_division * 2;
														$combo_offer_detail->taxAbleAmount = $combo_offer_detail->taxAbleAmount-$combo_offer_detail->total_GST;
														$combo_offer_detail->total_with_GST = $combo_offer_detail->taxAbleAmount + $combo_offer_detail->total_GST; 
														$combo_offer_detail->total_GST = number_format($combo_offer_detail->total_GST,2,".","");
														$combo_offer_detail->total_with_GST = number_format($combo_offer_detail->total_with_GST,2,".","");
														$combo_offer_detail->isPromoValid = true;
														$PromoComboValid = true;
												}
												else if($discount_of_max_amount > 0 && $BothTaxableCmboItem > 0 && $BothTaxableCmboItem >= $discount_of_max_amount && $promo_item_id == 0 && $promo_category_id ==0){
														$promoCount++;
														$isPromoValidForAll = true;
														$isPromoValidForAllMsg = 'PromoCode Applied Successfully';
														$promoDiscount_Amount =  $combo_offer_detail->taxAbleAmount / $BothTaxableCmboItem * $promotionDetails->discount_in_amount;
														$combo_offer_detail->promoDiscount_Percent = $promotionDetails->discount_in_percentage;
														$combo_offer_detail->promoDiscount_in_Amount = $promotionDetails->discount_in_amount;
														$combo_offer_detail->promoDiscount_Amount =  number_format($promoDiscount_Amount,2,".",""); 
														$promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
														$amountAfter_Promocode = $combo_offer_detail->taxAbleAmount - $promoDiscount_Amount;
														$combo_offer_detail->amountAfter_Promocode = number_format($amountAfter_Promocode,2,".","");
														$combo_offer_detail->taxAbleAmount = number_format($amountAfter_Promocode,2,".","");
														$combo_offer_detail->gstPercentageAdd = $combo_offer_detail->gst_percentage + 100;
														$combo_offer_detail->total_GST = $combo_offer_detail->taxAbleAmount * $combo_offer_detail->gst_percentage / $combo_offer_detail->gstPercentageAdd; 
														$combo_offer_detail->total_GST_division = round($combo_offer_detail->total_GST / 2,2);
														$combo_offer_detail->total_GST = $combo_offer_detail->total_GST_division * 2;
														$combo_offer_detail->taxAbleAmount = $combo_offer_detail->taxAbleAmount-$combo_offer_detail->total_GST;
														$combo_offer_detail->total_with_GST = $combo_offer_detail->taxAbleAmount + $combo_offer_detail->total_GST; 
														$combo_offer_detail->total_GST = number_format($combo_offer_detail->total_GST,2,".","");
														$combo_offer_detail->total_with_GST = number_format($combo_offer_detail->total_with_GST,2,".","");
														$combo_offer_detail->isPromoValid = true;
														$PromoComboValid = true;
												}
												else if($promo_category_id == 0 && $BothTaxableCmboItem > 0 && $promo_item_id == 0 && $discount_of_max_amount ==0){
														$promoCount++;
														$isPromoValidForAll = true;
														$isPromoValidForAllMsg = 'PromoCode Applied Successfully';
														$promoDiscount_Amount =  $combo_offer_detail->taxAbleAmount / $BothTaxableCmboItem * $promotionDetails->discount_in_amount;
														$combo_offer_detail->promoDiscount_Percent = $promotionDetails->discount_in_percentage;
														$combo_offer_detail->promoDiscount_in_Amount = $promotionDetails->discount_in_amount;
														$combo_offer_detail->promoDiscount_Amount =  number_format($promoDiscount_Amount,2,".",""); 
														$promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
														$amountAfter_Promocode = $combo_offer_detail->taxAbleAmount - $promoDiscount_Amount;
														$combo_offer_detail->amountAfter_Promocode = number_format($amountAfter_Promocode,2,".","");
														$combo_offer_detail->taxAbleAmount = number_format($amountAfter_Promocode,2,".","");
														$combo_offer_detail->gstPercentageAdd = $combo_offer_detail->gst_percentage + 100;
														$combo_offer_detail->total_GST = $combo_offer_detail->taxAbleAmount * $combo_offer_detail->gst_percentage / $combo_offer_detail->gstPercentageAdd; 
														$combo_offer_detail->total_GST_division = round($combo_offer_detail->total_GST / 2,2);
														$combo_offer_detail->total_GST = $combo_offer_detail->total_GST_division * 2;
														$combo_offer_detail->taxAbleAmount = $combo_offer_detail->taxAbleAmount-$combo_offer_detail->total_GST;
														$combo_offer_detail->total_with_GST = $combo_offer_detail->taxAbleAmount + $combo_offer_detail->total_GST; 
														$combo_offer_detail->total_GST = number_format($combo_offer_detail->total_GST,2,".","");
														$combo_offer_detail->total_with_GST = number_format($combo_offer_detail->total_with_GST,2,".","");													
														$combo_offer_detail->isPromoValid = true;
														$PromoComboValid = true;
												}else{
													if($promoCount==0)
													{
														$isPromoValidForAll = false;
														$isPromoValidForAllMsg = 'Invalid PromoCode';
													}else
													{
														$isPromoValidForAll = true;
														$isPromoValidForAllMsg = 'PromoCode Applied Successfully';
													}
														$combo_offer_detail->promoDiscount_Percent = 0.00;
														$combo_offer_detail->promoDiscount_in_Amount = 0.00;
														$combo_offer_detail->promoDiscount_Amount = 0.00;
														$combo_offer_detail->amountAfter_Promocode = $combo_offer_detail->taxAbleAmount;
														$combo_offer_detail->taxAbleAmount = $combo_offer_detail->taxAbleAmount;
														$combo_offer_detail->gstPercentageAdd = $combo_offer_detail->gst_percentage + 100;
														$combo_offer_detail->total_GST = $combo_offer_detail->taxAbleAmount * $combo_offer_detail->gst_percentage / $combo_offer_detail->gstPercentageAdd; 
														$combo_offer_detail->total_GST_division = round($combo_offer_detail->total_GST / 2,2);
														$combo_offer_detail->total_GST = $combo_offer_detail->total_GST_division * 2;
														$combo_offer_detail->taxAbleAmount = $combo_offer_detail->taxAbleAmount-$combo_offer_detail->total_GST;
														$combo_offer_detail->total_with_GST = $combo_offer_detail->taxAbleAmount + $combo_offer_detail->total_GST; 
														$combo_offer_detail->total_GST = number_format($combo_offer_detail->total_GST,2,".","");
														$combo_offer_detail->total_with_GST = number_format($combo_offer_detail->total_with_GST,2,".","");													
														$combo_offer_detail->isPromoValid = false;
														$PromoComboValid = false;
												}
											}else{
												if($promo_category_id > 0 && $promo_category_id == $cate_id && $promo_item_id == 0 && $discount_of_max_amount ==0)
												{
														$promoCount++;
														$isPromoValidForAll = true;
														$isPromoValidForAllMsg = 'PromoCode Applied Successfully';
														$promoDiscount_Amount =  $combo_offer_detail->taxAbleAmount * $promotionDetails->discount_in_percentage / 100;
														$combo_offer_detail->promoDiscount_Percent = $promotionDetails->discount_in_percentage;
														$combo_offer_detail->promoDiscount_in_Amount = $promotionDetails->discount_in_amount;
														$combo_offer_detail->promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
														$promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
														$amountAfter_Promocode = $combo_offer_detail->taxAbleAmount - $promoDiscount_Amount;
														$combo_offer_detail->amountAfter_Promocode = number_format($amountAfter_Promocode,2,".","");
														$combo_offer_detail->taxAbleAmount = number_format($amountAfter_Promocode,2,".","");
														$combo_offer_detail->gstPercentageAdd = $combo_offer_detail->gst_percentage + 100;
														$combo_offer_detail->total_GST = $combo_offer_detail->taxAbleAmount * $combo_offer_detail->gst_percentage / $combo_offer_detail->gstPercentageAdd; 
														$combo_offer_detail->total_GST_division = round($combo_offer_detail->total_GST / 2,2);
														$combo_offer_detail->total_GST = $combo_offer_detail->total_GST_division * 2;
														$combo_offer_detail->taxAbleAmount = $combo_offer_detail->taxAbleAmount-$combo_offer_detail->total_GST;
														$combo_offer_detail->total_with_GST = $combo_offer_detail->taxAbleAmount + $combo_offer_detail->total_GST; 
														$combo_offer_detail->total_GST = number_format($combo_offer_detail->total_GST,2,".","");
														$combo_offer_detail->total_with_GST = number_format($combo_offer_detail->total_with_GST,2,".","");
														$combo_offer_detail->isPromoValid = true;
														$PromoComboValid = true;
												}
												else if($promo_item_id > 0  && $promo_item_id == $item_id && $discount_of_max_amount == 0){
														$promoCount++;
														$isPromoValidForAll = true;
														$isPromoValidForAllMsg = 'PromoCode Applied Successfully';
														$promoDiscount_Amount =  $combo_offer_detail->taxAbleAmount * $promotionDetails->discount_in_percentage / 100;
														$combo_offer_detail->promoDiscount_Percent = $promotionDetails->discount_in_percentage;
														$combo_offer_detail->promoDiscount_in_Amount = $promotionDetails->discount_in_amount;
														$combo_offer_detail->promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
														$promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
														$amountAfter_Promocode = $combo_offer_detail->taxAbleAmount - $promoDiscount_Amount;
														$combo_offer_detail->amountAfter_Promocode = number_format($amountAfter_Promocode,2,".","");
														$combo_offer_detail->taxAbleAmount = number_format($amountAfter_Promocode,2,".","");
														$combo_offer_detail->gstPercentageAdd = $combo_offer_detail->gst_percentage + 100;
														$combo_offer_detail->total_GST = $combo_offer_detail->taxAbleAmount * $combo_offer_detail->gst_percentage / $combo_offer_detail->gstPercentageAdd; 
														$combo_offer_detail->total_GST_division = round($combo_offer_detail->total_GST / 2,2);
														$combo_offer_detail->total_GST = $combo_offer_detail->total_GST_division * 2;
														$combo_offer_detail->taxAbleAmount = $combo_offer_detail->taxAbleAmount-$combo_offer_detail->total_GST;
														$combo_offer_detail->total_with_GST = $combo_offer_detail->taxAbleAmount + $combo_offer_detail->total_GST; 
														$combo_offer_detail->total_GST = number_format($combo_offer_detail->total_GST,2,".","");
														$combo_offer_detail->total_with_GST = number_format($combo_offer_detail->total_with_GST,2,".","");
														$combo_offer_detail->isPromoValid = true;
														$PromoComboValid = true;
												}
												
												
												else if($promo_item_id > 0 && $BothTaxableCmboItem > 0  && $promo_item_id == $item_id && $discount_of_max_amount > 0 && $BothTaxableCmboItem >= $discount_of_max_amount){
														$promoCount++;
														$isPromoValidForAll = true;
														$isPromoValidForAllMsg = 'PromoCode Applied Successfully';
														$promoDiscount_Amount =  $combo_offer_detail->taxAbleAmount * $promotionDetails->discount_in_percentage / 100;
														$combo_offer_detail->promoDiscount_Percent = $promotionDetails->discount_in_percentage;
														$combo_offer_detail->promoDiscount_in_Amount = $promotionDetails->discount_in_amount;
														$combo_offer_detail->promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
														$promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
														$amountAfter_Promocode = $combo_offer_detail->taxAbleAmount - $promoDiscount_Amount;
														$combo_offer_detail->amountAfter_Promocode = number_format($amountAfter_Promocode,2,".","");
														$combo_offer_detail->taxAbleAmount = number_format($amountAfter_Promocode,2,".","");
														$combo_offer_detail->gstPercentageAdd = $combo_offer_detail->gst_percentage + 100;
														$combo_offer_detail->total_GST = $combo_offer_detail->taxAbleAmount * $combo_offer_detail->gst_percentage / $combo_offer_detail->gstPercentageAdd; 
														$combo_offer_detail->total_GST_division = round($combo_offer_detail->total_GST / 2,2);
														$combo_offer_detail->total_GST = $combo_offer_detail->total_GST_division * 2;
														$combo_offer_detail->taxAbleAmount = $combo_offer_detail->taxAbleAmount-$combo_offer_detail->total_GST;
														$combo_offer_detail->total_with_GST = $combo_offer_detail->taxAbleAmount + $combo_offer_detail->total_GST; 
														$combo_offer_detail->total_GST = number_format($combo_offer_detail->total_GST,2,".","");
														$combo_offer_detail->total_with_GST = number_format($combo_offer_detail->total_with_GST,2,".","");
														$combo_offer_detail->isPromoValid = true;
														$PromoComboValid = true;
												}												
												
												else if($discount_of_max_amount > 0 && $BothTaxableCmboItem >= $discount_of_max_amount && $promo_category_id > 0 && $promo_category_id == $cate_id){
														$promoCount++;
														$isPromoValidForAll = true;
														$isPromoValidForAllMsg = 'PromoCode Applied Successfully';
														$promoDiscount_Amount =  $combo_offer_detail->taxAbleAmount * $promotionDetails->discount_in_percentage / 100;
														$combo_offer_detail->promoDiscount_Percent = $promotionDetails->discount_in_percentage;
														$combo_offer_detail->promoDiscount_in_Amount = $promotionDetails->discount_in_amount;
														$combo_offer_detail->promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
														$promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
														$amountAfter_Promocode = $combo_offer_detail->taxAbleAmount - $promoDiscount_Amount;
														$combo_offer_detail->amountAfter_Promocode = number_format($amountAfter_Promocode,2,".","");
														$combo_offer_detail->taxAbleAmount = number_format($amountAfter_Promocode,2,".","");
														$combo_offer_detail->gstPercentageAdd = $combo_offer_detail->gst_percentage + 100;
														$combo_offer_detail->total_GST = $combo_offer_detail->taxAbleAmount * $combo_offer_detail->gst_percentage / $combo_offer_detail->gstPercentageAdd; 
														$combo_offer_detail->total_GST_division = round($combo_offer_detail->total_GST / 2,2);
														$combo_offer_detail->total_GST = $combo_offer_detail->total_GST_division * 2;
														$combo_offer_detail->taxAbleAmount = $combo_offer_detail->taxAbleAmount-$combo_offer_detail->total_GST;
														$combo_offer_detail->total_with_GST = $combo_offer_detail->taxAbleAmount + $combo_offer_detail->total_GST; 
														$combo_offer_detail->total_GST = number_format($combo_offer_detail->total_GST,2,".","");
														$combo_offer_detail->total_with_GST = number_format($combo_offer_detail->total_with_GST,2,".","");
														$combo_offer_detail->isPromoValid = true;
														$PromoComboValid = true;
												}												
												
												else if($discount_of_max_amount > 0 && $BothTaxableCmboItem >= $discount_of_max_amount && $promo_item_id == 0 && $promo_category_id ==0){
														$promoCount++;
														$isPromoValidForAll = true;
														$isPromoValidForAllMsg = 'PromoCode Applied Successfully';
														$promoDiscount_Amount =  $combo_offer_detail->taxAbleAmount * $promotionDetails->discount_in_percentage / 100;
														$combo_offer_detail->promoDiscount_Percent = $promotionDetails->discount_in_percentage;
														$combo_offer_detail->promoDiscount_in_Amount = $promotionDetails->discount_in_amount;
														$combo_offer_detail->promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
														$promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
														$amountAfter_Promocode = $combo_offer_detail->taxAbleAmount - $promoDiscount_Amount;
														$combo_offer_detail->amountAfter_Promocode = number_format($amountAfter_Promocode,2,".","");
														$combo_offer_detail->taxAbleAmount = number_format($amountAfter_Promocode,2,".","");
														$combo_offer_detail->gstPercentageAdd = $combo_offer_detail->gst_percentage + 100;
														$combo_offer_detail->total_GST = $combo_offer_detail->taxAbleAmount * $combo_offer_detail->gst_percentage / $combo_offer_detail->gstPercentageAdd; 
														$combo_offer_detail->total_GST_division = round($combo_offer_detail->total_GST / 2,2);
														$combo_offer_detail->total_GST = $combo_offer_detail->total_GST_division * 2;
														$combo_offer_detail->taxAbleAmount = $combo_offer_detail->taxAbleAmount-$combo_offer_detail->total_GST;
														$combo_offer_detail->total_with_GST = $combo_offer_detail->taxAbleAmount + $combo_offer_detail->total_GST; 
														$combo_offer_detail->total_GST = number_format($combo_offer_detail->total_GST,2,".","");
														$combo_offer_detail->total_with_GST = number_format($combo_offer_detail->total_with_GST,2,".","");
														$combo_offer_detail->isPromoValid = true;
														$PromoComboValid = true;
												}
												else if($promo_category_id == 0 && $promo_item_id == 0 && $discount_of_max_amount ==0){
														$promoCount++;
														$isPromoValidForAll = true;
														$isPromoValidForAllMsg = 'PromoCode Applied Successfully';
														$promoDiscount_Amount =  $combo_offer_detail->taxAbleAmount * $promotionDetails->discount_in_percentage / 100;
														$combo_offer_detail->promoDiscount_Percent = $promotionDetails->discount_in_percentage;
														$combo_offer_detail->promoDiscount_in_Amount = $promotionDetails->discount_in_amount;
														$combo_offer_detail->promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
														$promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
														$amountAfter_Promocode = $combo_offer_detail->taxAbleAmount - $promoDiscount_Amount;
														$combo_offer_detail->amountAfter_Promocode = number_format($amountAfter_Promocode,2,".","");
														$combo_offer_detail->taxAbleAmount = number_format($amountAfter_Promocode,2,".","");
														$combo_offer_detail->gstPercentageAdd = $combo_offer_detail->gst_percentage + 100;
														$combo_offer_detail->total_GST = $combo_offer_detail->taxAbleAmount * $combo_offer_detail->gst_percentage / $combo_offer_detail->gstPercentageAdd; 
														$combo_offer_detail->total_GST_division = round($combo_offer_detail->total_GST / 2,2);
														$combo_offer_detail->total_GST = $combo_offer_detail->total_GST_division * 2;
														$combo_offer_detail->taxAbleAmount = $combo_offer_detail->taxAbleAmount-$combo_offer_detail->total_GST;
														$combo_offer_detail->total_with_GST = $combo_offer_detail->taxAbleAmount + $combo_offer_detail->total_GST; 
														$combo_offer_detail->total_GST = number_format($combo_offer_detail->total_GST,2,".","");
														$combo_offer_detail->total_with_GST = number_format($combo_offer_detail->total_with_GST,2,".","");													
														$combo_offer_detail->isPromoValid = true;
														$PromoComboValid = true;
												}else{
													if($promoCount==0)
													{
														$isPromoValidForAll = false;
														$isPromoValidForAllMsg = 'Invalid PromoCode';
													}else
													{
														$isPromoValidForAll = true;
														$isPromoValidForAllMsg = 'PromoCode Applied Successfully';
													}													
													
														$combo_offer_detail->promoDiscount_Percent = 0.00;
														$combo_offer_detail->promoDiscount_in_Amount = 0.00;
														$combo_offer_detail->promoDiscount_Amount = 0.00;
														$combo_offer_detail->amountAfter_Promocode = $combo_offer_detail->taxAbleAmount;
														$combo_offer_detail->taxAbleAmount = $combo_offer_detail->taxAbleAmount;
														$combo_offer_detail->gstPercentageAdd = $combo_offer_detail->gst_percentage + 100;
														$combo_offer_detail->total_GST = $combo_offer_detail->taxAbleAmount * $combo_offer_detail->gst_percentage / $combo_offer_detail->gstPercentageAdd; 
														$combo_offer_detail->total_GST_division = round($combo_offer_detail->total_GST / 2,2);
														$combo_offer_detail->total_GST = $combo_offer_detail->total_GST_division * 2;
														$combo_offer_detail->taxAbleAmount = $combo_offer_detail->taxAbleAmount-$combo_offer_detail->total_GST;
														$combo_offer_detail->total_with_GST = $combo_offer_detail->taxAbleAmount + $combo_offer_detail->total_GST; 
														$combo_offer_detail->total_GST = number_format($combo_offer_detail->total_GST,2,".","");
														$combo_offer_detail->total_with_GST = number_format($combo_offer_detail->total_with_GST,2,".","");													
														$combo_offer_detail->isPromoValid = false;
														$PromoComboValid = false;
												}
												
											}
										}
										
											//echo '<br> Cuurent '. $promoTotal_Amount;
											//echo '<br> promoDiscount_Amount '. $combo_offer_detail->promoDiscount_Amount;
											//echo '<br> Total '. $promoTotal_Amount .'+'. $combo_offer_detail->promoDiscount_Amount;
											$memberShipDiscount_Amount = $memberShipDiscount_Amount + $combo_offer_detail->memberShipDiscount_Amount;
											$promoTotal_Amount = $promoTotal_Amount + $combo_offer_detail->promoDiscount_Amount;
											//echo '<br>main total'.$promoTotal_Amount;
											$comboTotal_Amount = $comboTotal_Amount + $combo_offer_detail->taxAbleAmount;
											$combowith_GST_Amount = $combowith_GST_Amount + $combo_offer_detail->total_with_GST;										
									
									}	 //echo '<br>loop out total'.$promoTotal_Amount;
										$combo->memberShipDiscount_Amount = number_format($memberShipDiscount_Amount,2,".","");
										$combo->promoDiscount_Amount = number_format($promoTotal_Amount,2,".","");
										$combo->comboTotal_Amount = number_format($comboTotal_Amount,2,".","");
										$combo->combowith_GST_Amount = number_format($combowith_GST_Amount,2,".","");	
										$combo->PromoComboValid = $PromoComboValid;											
								}
								
							}

							if($cash_back > 0)
							{
								if($BothTaxableCmboItem >= $discount_of_max_amount){
									$isPromoValidForAll = true;
									$isPromoValidForAllMsg = 'PromoCode Applied Successfully';									
								}else{
									if($promoCount==0)
									{
										$isPromoValidForAll = false;
										$isPromoValidForAllMsg = 'Invalid PromoCode';
									}else
									{
										$isPromoValidForAll = true;
										$isPromoValidForAllMsg = 'PromoCode Applied Successfully';
									}
								}
							}
						}else{
							
							if(!empty($carts_data))
							{	
									foreach($carts_data as $cart_data)
									{
										$item_id = $cart_data->item_variation->item->id;
										$cart_data->gst_percentage = $cart_data->item_variation->item->gst_figure->tax_percentage;
										$cate_id = $cart_data->item_variation->item->category_id;
										$cart_data->promoDiscount_Percent = 0.00;
										$cart_data->promoDiscount_in_Amount = 0.00;
										$cart_data->promoDiscount_Amount = 0.00;
										$cart_data->amountAfter_Promocode = $cart_data->taxAbleAmount;
										$cart_data->taxAbleAmount = $cart_data->taxAbleAmount;
										$cart_data->gstPercentageAdd = $cart_data->gst_percentage + 100;
										$cart_data->total_GST = $cart_data->taxAbleAmount * $cart_data->gst_percentage / $cart_data->gstPercentageAdd; 
										$cart_data->total_GST_division = round($cart_data->total_GST / 2,2);
										$cart_data->total_GST = $cart_data->total_GST_division * 2;
										$cart_data->taxAbleAmount = $cart_data->taxAbleAmount - $cart_data->total_GST;
										$cart_data->total_with_GST = $cart_data->taxAbleAmount + $cart_data->total_GST; 
										$cart_data->total_GST = number_format($cart_data->total_GST,2,".","");
										$cart_data->total_with_GST = number_format($cart_data->total_with_GST,2,".","");								
										$cart_data->isPromoValid = false;
									}
							}		
								if(!empty($comboData))
								{
									foreach($comboData as $combo)
									{
									$taxAbleAmount_Total = 0.00;
									$combowith_GST_Amount = 0.00;
									$comboTotal_Amount = 0.00;
									$memberShipDiscount_Amount = 0.00;
									$promoDiscount_Amount = 0.00;
									$promoTotal_Amount = 0.00;
									
									foreach($combo->combo_offer->combo_offer_details as $combo_offer_detail)
										{
											$comboItemDetails = $this->Carts->ItemVariations->find()
											->contain(['Items'])
											->where(['ItemVariations.id' =>$combo_offer_detail->item_variation_id])
											->first();
											   $item_id = $comboItemDetails->item->id;
											   //$combo_offer_detail->gst_percentage = $combo_offer_detail->gst_percentage;
											   $cate_id = $comboItemDetails->item->category_id;
											
												$combo_offer_detail->promoDiscount_Percent = 0.00;
												$combo_offer_detail->promoDiscount_in_Amount = 0.00;
												$combo_offer_detail->promoDiscount_Amount = 0.00;
												$combo_offer_detail->amountAfter_Promocode = $combo_offer_detail->taxAbleAmount;
												$combo_offer_detail->taxAbleAmount = $combo_offer_detail->taxAbleAmount;
												$combo_offer_detail->gstPercentageAdd = $combo_offer_detail->gst_percentage + 100;
												$combo_offer_detail->total_GST = $combo_offer_detail->taxAbleAmount * $combo_offer_detail->gst_percentage / $combo_offer_detail->gstPercentageAdd; 
												$combo_offer_detail->total_GST_division = round($combo_offer_detail->total_GST / 2,2);
												$combo_offer_detail->total_GST = $combo_offer_detail->total_GST_division * 2;
												$combo_offer_detail->taxAbleAmount = $combo_offer_detail->taxAbleAmount -$combo_offer_detail->total_GST;
												$combo_offer_detail->total_with_GST = $combo_offer_detail->taxAbleAmount + $combo_offer_detail->total_GST; 
												$combo_offer_detail->total_GST = number_format($combo_offer_detail->total_GST,2,".","");
												$combo_offer_detail->total_with_GST = number_format($combo_offer_detail->total_with_GST,2,".","");														
												$combo_offer_detail->isPromoValid = false;
												$PromoComboValid = false;
											$memberShipDiscount_Amount = $memberShipDiscount_Amount + $combo_offer_detail->memberShipDiscount_Amount;
											$promoTotal_Amount = $promoTotal_Amount + $combo_offer_detail->promoDiscount_Amount;
											$comboTotal_Amount = $comboTotal_Amount + $combo_offer_detail->taxAbleAmount;
											$combowith_GST_Amount = $combowith_GST_Amount + $combo_offer_detail->total_with_GST;
										}
										$combo->memberShipDiscount_Amount = number_format($memberShipDiscount_Amount,2,".","");
										$combo->promoDiscount_Amount = number_format($promoTotal_Amount,2,".","");
										$combo->comboTotal_Amount = number_format($comboTotal_Amount,2,".","");
										$combo->combowith_GST_Amount = number_format($combowith_GST_Amount,2,".","");
										$combo->PromoComboValid = $PromoComboValid;	
									}
								}												
					}
				
						if(!empty($category)){
							foreach ($category as $key => $value) {
								$total_cat_wise = 0.00;			
								foreach($value as $arrData)
								{
									$total_cat_wise = number_format($total_cat_wise + $arrData->total_with_GST,2,".","");
								}
								$carts[] = ['category_name'=>$category_arr[$key],'total_cat_wise'=>$total_cat_wise,'category'=>$value];
							}
							
							if(empty($carts_data)){ $carts=[]; }								
						}
							$Combototal = 0.00;
							$Combototal_with_GST = 0.00;
							$Combo_Sub_Total = 0.00;
							$Combo_Promo_Total = 0.00;
							$Combo_memberShipTotal = 0.00;
							$combo_GST = 0.00;
						if(empty($comboData)) 
						{ 
							$comboData = []; 
						}
						else 
						{  
							foreach($comboData as $combo)
							{
								$Combo_Sub_Total = number_format($Combo_Sub_Total + $combo->comboTotal_Amount,2,".","");
								$Combototal = number_format($Combototal + $combo->comboTotal_Amount,2,".","");
								$Combototal_with_GST = number_format($Combototal_with_GST + $combo->combowith_GST_Amount,2,".","");
							
								foreach($combo->combo_offer->combo_offer_details as $combo_offer_detail)
								{
									$Combo_Promo_Total = number_format($Combo_Promo_Total + $combo_offer_detail->promoDiscount_Amount,2,".","");
									$Combo_memberShipTotal = number_format($Combo_memberShipTotal + $combo_offer_detail->memberShipDiscount_Amount,2,".","");
									$combo_GST = number_format($combo_GST + $combo_offer_detail->total_GST,2,".","");
								}
							
							}
						}
						$ItemWiseTotal_taxable = 0.00;
							$ItemWiseTotal_With_GST = 0.00;
							$Item_Sub_Total = 0.00;
							$Item_Promo_total = 0.00;
							$Item_MembershipDiscount = 0.00;
							$Item_Total_GST = 0.00;
						if(empty($carts_data))
						{
							$carts_data = [];
						}else{
							
							foreach($carts_data as $cart_data)
							{
								$Item_Sub_Total = number_format($Item_Sub_Total + $cart_data->amount,2,".","");
								$Item_Promo_total = number_format($Item_Promo_total + $cart_data->promoDiscount_Amount,2,".","");
								$ItemWiseTotal_taxable = number_format($ItemWiseTotal_taxable + $cart_data->taxAbleAmount,2,".","");
								$ItemWiseTotal_With_GST = number_format($ItemWiseTotal_With_GST + $cart_data->total_with_GST,2,".","");	$Item_MembershipDiscount = number_format($Item_MembershipDiscount + $cart_data->memberShipDiscount_Amount,2,".","");
								$Item_Total_GST = number_format($Item_Total_GST + $cart_data->total_GST,2,".","");
							}
						}
					
						
						$PromoTotal = 0.00;
						$PromoTotal = number_format(round($Item_Promo_total + $Combo_Promo_Total),2,".","");
						
						$Sub_Total = 0.00;
						$Sub_Total = number_format($Item_Sub_Total + $Combo_Sub_Total,2,".","");
						$Sub_Total = number_format($Sub_Total - $PromoTotal,2,".","");
						//$Sub_Total = number_format($Combototal_with_GST + $ItemWiseTotal_With_GST,2,".","");
						
						$MembershipTotal = 0.00;
						$MembershipTotal = number_format($Item_MembershipDiscount + $Combo_memberShipTotal,2,".","");
						$Total_GST = 0.00;
						$Total_GST = number_format($Item_Total_GST + $combo_GST,2,".","");
						$payableAmount = number_format($payableAmount + $Combototal_with_GST + $ItemWiseTotal_With_GST,2,".","");
		
						$p = $payableAmount;
						$q = round($payableAmount);
						$Round_off_amt = round(($q-$p),2);
						$payableAmount = number_format(round($payableAmount),2,".","");	
		
						$customers = $this->Carts->Customers->find()->where(['Customers.id'=>$customer_id])->first();
						$is_shipping_price = $customers->is_shipping_price;
						$shipping_price = $customers->shipping_price;
						
						
							if($promo_free_shipping == 'Yes')
							{
								$delivery_charge_amount = "free";
							}
							else if($is_shipping_price == 'Yes')
							{
								if($shipping_price == 0)
								{
									$delivery_charge_amount = "free";
								}else
								{
									 $delivery_charge_amount = "$shipping_price";
									 $payableAmount = number_format($payableAmount + $shipping_price,2,".","");									
								}
							}
							else
							{
								$delivery_charges=$this->Carts->DeliveryCharges->find()->where(['city_id'=>$city_id,'status'=>'Active']);

								if(!empty($delivery_charges->toArray()))
								{
									foreach($delivery_charges as $delivery_charge) {
											if($delivery_charge->amount >= $payableAmount)
											{
												$delivery_charge_message = 'Shop more then '.$delivery_charge->amount.' rupess and get free home delivery !';
												 $delivery_charge_amount = "$delivery_charge->charge";
												 $payableAmount = number_format($payableAmount + $delivery_charge->charge,2,".","");
											}else
											{
												$delivery_charge_amount = "free";
											}
									}
								}										
							}			
					//pr($carts_data);
					//pr($comboData);exit;		
					if(empty($carts_data) && empty($comboData))
					{
					  $success = false;
					  $message ='Empty Cart';
					  $this->set(compact('success', 'message'));
					  $this->set('_serialize', ['success', 'message']);
					}
					else
					{
					  $success = true;
					  $message = 'Cart Data found'; 
					  $this->set(compact('success', 'message','customer_membership_discount','isPromoValidForAll','isPromoValidForAllMsg','Round_off_amt','address_available','delivery_charge_amount','payableAmount','remaining_wallet_amount','carts','item_in_cart','comboData','Combototal','promo_detail_id','ItemWiseTotal_taxable','ItemWiseTotal_With_GST','Combototal_with_GST','TotalBeforeDiscount','Sub_Total','PromoTotal','MembershipTotal','Total_GST','delivery_charge_message'));
					  $this->set('_serialize', ['success','message','customer_membership_discount','isPromoValidForAll','isPromoValidForAllMsg','promo_detail_id','remaining_wallet_amount','item_in_cart','address_available','carts','ItemWiseTotal_taxable','ItemWiseTotal_With_GST','comboData','Combototal','Combototal_with_GST','TotalBeforeDiscount','Sub_Total','PromoTotal','MembershipTotal','Total_GST','delivery_charge_amount','Round_off_amt','payableAmount','delivery_charge_message']);
					}

		}
		else
		{
				$success = false;
				$message ='Invalid Customer id';
				$this->set(compact('success', 'message'));
				$this->set('_serialize', ['success', 'message']);
		}
	}else
	{
		$success = false;
		$message ='Empty City or Customer_id';
		$this->set(compact('success', 'message'));
		$this->set('_serialize', ['success', 'message']);
	}

}	
	
public function reviewOrder()
{
	
	$customer_id=$this->request->query('customer_id');
	$city_id=$this->request->query('city_id');
	$combo_offer_id = $this->request->query('combo_offer_id');
	$isCombo = $this->request->query('isCombo');
	$isPromoCode = $this->request->query('isPromoCode');
	$promo_detail_id = $this->request->query('promo_detail_id');  
	$promo_free_shipping = '';
	$comboData = [];
	$carts=[];
	$remaining_wallet_amount = 0;
	$payableAmount = 0.00;
	$Combototal = 0.00;
	$promo_amount = 0;	
	$delivery_charge_amount = '0.00';
	$holidy = [];

	$carts_data_update=$this->Carts->find()
	->where(['Carts.customer_id' => $customer_id])
	->where(['Carts.city_id' =>$city_id])
	->contain(['ItemVariations' => function($q){
			return $q->where(['ready_to_sale'=>'Yes','status'=>'Active','out_of_stock'=>'No']);
		}])
	->group('Carts.item_variation_id')->autoFields(true)->toArray();
	
	if(!empty($carts_data_update))
	{
		foreach($carts_data_update as $data)
		{	
			if($data->combo_offer_id == 0)
			{
				$sales_rate=$data->item_variation->sales_rate;
				$qty = $data->cart_count;
				$amount = $sales_rate * $qty;
				$query = $this->Carts->query();		
				$result = $query->update()
				->set(['rate'=>$sales_rate,'amount' => $amount])
				->where(['id' => $data->id])->execute();					
			}
		}
	}
	
	$cancel_order_limit = $this->Carts->MasterSetups->find()->select(['cancel_order_limit','online_amount_limit','delivery_message'])->where(['city_id' => $city_id])->first();
	$deliveryString = $cancel_order_limit->delivery_message;
	$OrderCancelLimit = $cancel_order_limit->cancel_order_limit;			
	$online_amount_limit = $cancel_order_limit->online_amount_limit;			
	$customer_order_limit = $this->Carts->Customers->find()->select(['cancel_order_count'])->where(['id' => $customer_id])->first();
	$CustomerOrderCount = $customer_order_limit->cancel_order_count;
	
	$item_in_cart = $this->Carts->find('All')->where(['Carts.customer_id'=>$customer_id])
					->where(['Carts.city_id' =>$city_id])->count();		
					
	// time and date slot 				
	date_default_timezone_set("Asia/Calcutta");
			  
	$delivery_date = $this->Carts->DeliveryDates->find()->where(['city_id'=>$city_id])->first();
	$sameDay = 0;
	$next_day=$delivery_date->next_day;
	if($delivery_date->same_day == 'Active')
	{
			$sameDay = $delivery_date->next_day;
			$same_day_count=0;
	}else{
			$sameDay = $delivery_date->next_day;
			$same_day_count=1;
	}
			
	$start_date1=date('Y-m-d', strtotime("+".$same_day_count."days"));
	$last_date1=date('Y-m-d', strtotime("+".$next_day."days"));
	$this->loadmodel('Holidays');
	$holidays=$this->Holidays->find()->where(['Holidays.city_id'=>$city_id]);
	$holiday_count=$this->Holidays->find()->where(['Holidays.city_id'=>$city_id,'Holidays.date >='=>$start_date1,'Holidays.date <='=>$last_date1])->count();
	foreach($holidays as $holy_data){
		$holidy[]=date('d-m-Y', strtotime($holy_data->date));  
	}
	$final_count_date=$holiday_count+$sameDay;
	$j=0;
	for($t=$same_day_count;$t<=$final_count_date;$t++)
	{
		$j++;
		$m=0; 
		 if(($same_day_count==0) && ($j==1)){
			 $m=1;
		 }
		$date_days=date('d-m-Y', strtotime("+".$t."days"));
		if(in_array($date_days,$holidy)){
			$holidays_date[]=$date_days;
			continue;
		}else
		{
			$options1[$date_days] = $date_days;
			$del_time = [];			
			$time_deliveries=$this->Carts->DeliveryTimes->find()->where(['DeliveryTimes.city_id'=>$city_id,'DeliveryTimes.status'=>'Active']);
			if(!empty($time_deliveries->toArray()))
			{
			foreach($time_deliveries as $time_data)
						{
							$current_time =  strtotime(date('h:i a'));
							$test_time_to = strtotime($time_data->time_to);
							$time_from=$time_data->time_from;
							$time_to=$time_data->time_to;
							$time_data->delivery_time=$time_from.'-'.$time_to;
							if(($test_time_to<$current_time) && ($m==1)){
									continue;
							}else{
								 $del_time[]=$time_data;
							}
						}
						$all_dates[] = ['date' =>$date_days,'delivery_time'=>$del_time];
						unset($del_time);				
			}
			
		}
	}

			$categories = $this->Carts->find()
			->where(['Carts.customer_id' => $customer_id])
			->where(['Carts.city_id' =>$city_id])
			->contain(['ItemVariations'=>['ItemVariationMasters','Items'=>['Categories']]]);

			$comboData = $this->Carts->find()
			->where(['Carts.city_id' =>$city_id])
			->where(['Carts.customer_id' => $customer_id])
			->contain(['ComboOffers'=> function($q){ return $q->where(['out_of_stock'=>'No'])->contain(['ComboOfferDetails']);}])
			->group('Carts.combo_offer_id')->autoFields(true)->toArray();
			
			if(empty($comboData)) { $comboData = []; }

			if(!empty($categories->toArray()))
			{
				$category_arr = [];

				foreach ($categories as $cat_date) {
					$cat_name = $cat_date->item_variation->item->category->name;
					$cat_id = $cat_date->item_variation->item->category->id;
					$category_arr[$cat_id] = $cat_name;
					
				}
				
				$carts_data=$this->Carts->find()
				->where(['Carts.customer_id' => $customer_id])
				->where(['Carts.city_id' =>$city_id])
				->contain(['ItemVariations'=> function($q){
					return $q->where(['ready_to_sale'=>'Yes','status'=>'Active','out_of_stock'=>'No'])->contain(['Sellers','ItemVariationMasters','Items' =>['GstFigures','Categories'] ,'UnitVariations'=>['Units']]);
				}])
				->group('Carts.item_variation_id')->autoFields(true)->toArray();
				
				foreach ($category_arr as $cat_key => $cat_value) {
					foreach ($carts_data as $cart) {
					  $cart_category_id = $cart->item_variation->item->category_id;
					  if($cat_key == $cart_category_id)
					  {
						$category[$cat_key][] = $cart;
					  }
					}
				}									
			}

			// Total without any discount						
			$CartItem_Total = 0.00;
			$ComboItem_Total = 0.00;
			$TotalBeforeDiscount = 0.00;
			if(!empty($carts_data))
			{
				foreach($carts_data as $cart_data)
				{
					$CartItem_Total = $CartItem_Total + $cart_data->amount;
				}										
			}					
			if(!empty($comboData))
			{
				foreach($comboData as $combo)
				{
					foreach($combo->combo_offer->combo_offer_details as $combo_offer_detail)
					{
						$combo_offer_detail->amount = $combo_offer_detail->rate * $combo_offer_detail->quantity * $combo->quantity;$combo_offer_detail->amount = $combo_offer_detail->amount + $combo->quantity * $combo_offer_detail->gst_value; 																								
						$ComboItem_Total = $ComboItem_Total + $combo_offer_detail->amount;
					}
				}
			}
			
			$TotalBeforeDiscount =  number_format(round($CartItem_Total + $ComboItem_Total),2,".","");			
						
		// Membership discount start			

			$memberShipDiscount = $this->Carts->Customers->find()
			->select(['membership_discount'])
			->where(['id' => $customer_id])
			->where(['start_date <='=> date('Y-m-d'),'end_date >= '=> date('Y-m-d')])
			->first();			
			if(!empty($memberShipDiscount) && $memberShipDiscount->membership_discount > 0)
			{
				// membership item wise discount 
				if(!empty($carts_data))
				{
					foreach($carts_data as $cart_data)
					{
						if($cart_data->item_variation->item->is_discount_enable == 'Yes')
						{
							$memberShipDiscount_Amount =  $cart_data->amount * $memberShipDiscount->membership_discount / 100 ;
							$cart_data->memberShipDiscount_Percent = $memberShipDiscount->membership_discount;
							$cart_data->memberShipDiscount_Amount = number_format($memberShipDiscount_Amount,2,".","");
							$memberShipDiscount_Amount = number_format($memberShipDiscount_Amount,2,".","");
							$amountAfter_Membership = $cart_data->amount - $memberShipDiscount_Amount;
							$cart_data->amountAfter_Membership = number_format($amountAfter_Membership,2,".","");
							$cart_data->taxAbleAmount = number_format($amountAfter_Membership,2,".","");
						}
						else{
							$cart_data->memberShipDiscount_Percent = 0.00;
							$cart_data->memberShipDiscount_Amount = 0.00;
							$cart_data->amountAfter_Membership = $cart_data->amount;
							$cart_data->taxAbleAmount = number_format($cart_data->amount,2,".","");
						}
					}										
				}
				
				// membership combo offer discount item wise 
				if(!empty($comboData))
				{
					foreach($comboData as $combo)
					{
						foreach($combo->combo_offer->combo_offer_details as $combo_offer_detail)
						{   $combo_offer_detail->amount = $combo_offer_detail->rate * $combo_offer_detail->quantity * $combo->quantity; 
							$combo_offer_detail->amount = $combo_offer_detail->amount + $combo->quantity * $combo_offer_detail->gst_value;
							$memberShipDiscount_Amount = $combo_offer_detail->amount * $memberShipDiscount->membership_discount/100;
							$combo_offer_detail->memberShipDiscount_Percent = $memberShipDiscount->membership_discount;
							$combo_offer_detail->memberShipDiscount_Amount = number_format($memberShipDiscount_Amount,2,".","");
							$memberShipDiscount_Amount = number_format($memberShipDiscount_Amount,2,".","");
							$amountAfter_Membership = $combo_offer_detail->amount - $memberShipDiscount_Amount;
							$combo_offer_detail->amountAfter_Membership = number_format($amountAfter_Membership,2,".","");
							$combo_offer_detail->taxAbleAmount = number_format($amountAfter_Membership,2,".","");														
						}
					}
				}
			}else{
				// membership item wise discount 
				if(!empty($carts_data))
				{
					foreach($carts_data as $cart_data)
					{
					   $cart_data->memberShipDiscount_Percent = 0.00;
					   $cart_data->memberShipDiscount_Amount = 0.00;
					   $cart_data->amountAfter_Membership = $cart_data->amount;
					   $cart_data->taxAbleAmount = number_format($cart_data->amount,2,".","");
					}										
				}
				// membership combo offer discount item wise 
				if(!empty($comboData))
				{
					foreach($comboData as $combo)
					{
						foreach($combo->combo_offer->combo_offer_details as $combo_offer_detail)
						{
							$combo_offer_detail->amount = $combo_offer_detail->rate * $combo_offer_detail->quantity * $combo->quantity; 
							$combo_offer_detail->amount = $combo_offer_detail->amount + $combo->quantity * $combo_offer_detail->gst_value;
							$combo_offer_detail->memberShipDiscount_Percent = 0.00;
							$combo_offer_detail->memberShipDiscount_Amount = 0.00;
							$combo_offer_detail->amountAfter_Membership = 0.00;
							$combo_offer_detail->taxAbleAmount = number_format($combo_offer_detail->amount,2,".","");														
						}
					}
				}
			}

				// Calculation
						$PromoComboValid = false;
						$isPromoValidForAll = false;
						$isPromoValidForAllMsg = 'NO PromoCode Applied';
						if($isPromoCode == 'true')
						{
							$promotionDetails = $this->Carts->Promotions->PromotionDetails->find()
							->where(['id' =>$promo_detail_id])->first();
							$discount_in_percentage = $promotionDetails->discount_in_percentage;
							$discount_of_max_amount = $promotionDetails->discount_of_max_amount;
							$promo_item_id = $promotionDetails->item_id;
							$promo_category_id = $promotionDetails->category_id;
							$promo_free_shipping = $promotionDetails->is_free_shipping;
							$cash_back = $promotionDetails->cash_back;
							$payableAmount = number_format(0, 2);
							$promo_amount = 0;
							$BothTaxableCmboItem = 0.00;
							$taxAbleAmount_Total = 0.00;
							$Combo_taxAbleAmount_Total = 0.00;
							$promoCount = 0;
							if(!empty($comboData))
							{  
								foreach($comboData as $combo)
								{
								  foreach($combo->combo_offer->combo_offer_details as $combo_offer_detail)
								  {
									$comboItemDetails = $this->Carts->ItemVariations->find()->contain(['Items'])
										->where(['ItemVariations.id' =>$combo_offer_detail->item_variation_id])->first();	
									if(!empty($promo_item_id) && $promo_item_id > 0)
									{
									  $item_id = $comboItemDetails->item->id;
									   if($item_id == $promo_item_id)
										{				
											$Combo_taxAbleAmount_Total = $Combo_taxAbleAmount_Total + $combo_offer_detail->taxAbleAmount;
										}		
									} 
									else if(!empty($promo_category_id) && $promo_category_id > 0 && $promo_item_id == 0)
									{   $cate_id = $comboItemDetails->item->category_id;
										if($cate_id == $promo_category_id)
										{
											$Combo_taxAbleAmount_Total = $Combo_taxAbleAmount_Total + $combo_offer_detail->taxAbleAmount;
										}											
									}else{
										$Combo_taxAbleAmount_Total = $Combo_taxAbleAmount_Total + $combo_offer_detail->taxAbleAmount;
									}											
								  }	
								}
							}
							
							if(!empty($carts_data)){
								
								foreach($carts_data as $cart_data)
								{
									if(!empty($promo_item_id) && $promo_item_id > 0)
									{
									  $item_id = $cart_data->item_variation->item->id;
									   if($item_id == $promo_item_id)
										{				
											if($cart_data->item_variation->item->is_discount_enable == 'Yes')
											{
												$taxAbleAmount_Total = $taxAbleAmount_Total + $cart_data->taxAbleAmount;
											}
										}		
									} else if(!empty($promo_category_id) && $promo_category_id > 0 && $promo_item_id == 0)
									{
										$cate_id = $cart_data->item_variation->item->category_id;
										if($cate_id == $promo_category_id)
										{
											if($cart_data->item_variation->item->is_discount_enable == 'Yes')
											{  
												$taxAbleAmount_Total = $taxAbleAmount_Total + $cart_data->taxAbleAmount;
											}
										}											
									}else {
										if($cart_data->item_variation->item->is_discount_enable == 'Yes')
										{
											$taxAbleAmount_Total = $taxAbleAmount_Total + $cart_data->taxAbleAmount;
										}
									}											
								 }	
								 
								$BothTaxableCmboItem = $Combo_taxAbleAmount_Total + $taxAbleAmount_Total;
								
								
								foreach($carts_data as $cart_data){
								$item_id = $cart_data->item_variation->item->id;
								$cart_data->gst_percentage = $cart_data->item_variation->item->gst_figure->tax_percentage;
								$cate_id = $cart_data->item_variation->item->category_id;
									if($cart_data->item_variation->item->is_discount_enable == 'Yes')
									{
										if($cash_back == 0){
											if($discount_in_percentage == 0)
											{
												if($promo_category_id > 0 && $promo_category_id == $cate_id && $promo_item_id == 0 && $discount_of_max_amount ==0 && $BothTaxableCmboItem >0 && $BothTaxableCmboItem > $promotionDetails->discount_in_amount)
												{
													$promoCount++;
													$isPromoValidForAll = true;
													$isPromoValidForAllMsg = 'PromoCode Applied Successfully';
													$promoDiscount_Amount =  $cart_data->taxAbleAmount / $BothTaxableCmboItem * $promotionDetails->discount_in_amount;
													$cart_data->promoDiscount_Percent = $promotionDetails->discount_in_percentage;
													$cart_data->promoDiscount_in_Amount = $promotionDetails->discount_in_amount;
													$cart_data->promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
													$promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
													$amountAfter_Promocode = $cart_data->taxAbleAmount - $promoDiscount_Amount;
													$cart_data->amountAfter_Promocode = number_format($amountAfter_Promocode,2,".","");
													$cart_data->taxAbleAmount = number_format($amountAfter_Promocode,2,".","");
													$cart_data->gstPercentageAdd = $cart_data->gst_percentage + 100;
													$cart_data->total_GST = $cart_data->taxAbleAmount * $cart_data->gst_percentage / $cart_data->gstPercentageAdd; 
													$cart_data->total_GST_division = round($cart_data->total_GST / 2,2);
													$cart_data->total_GST = $cart_data->total_GST_division * 2;
													$cart_data->taxAbleAmount = $cart_data->taxAbleAmount-$cart_data->total_GST;
													$cart_data->total_with_GST = $cart_data->taxAbleAmount + $cart_data->total_GST; 
													$cart_data->total_GST = number_format($cart_data->total_GST,2,".","");
													$cart_data->total_with_GST = number_format($cart_data->total_with_GST,2,".","");
													$cart_data->isPromoValid = true;
												}

												else if($discount_of_max_amount > 0 && $BothTaxableCmboItem >= $discount_of_max_amount && $promo_category_id > 0 && $promo_category_id == $cate_id){
													$promoCount++;
													$isPromoValidForAll = true;
													$isPromoValidForAllMsg = 'PromoCode Applied Successfully';
													$promoDiscount_Amount =  $cart_data->taxAbleAmount / $BothTaxableCmboItem * $promotionDetails->discount_in_amount;
													$cart_data->promoDiscount_Percent = $promotionDetails->discount_in_percentage;
													$cart_data->promoDiscount_in_Amount = $promotionDetails->discount_in_amount;
													$cart_data->promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
													$promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
													$amountAfter_Promocode = $cart_data->taxAbleAmount - $promoDiscount_Amount;
													$cart_data->amountAfter_Promocode = number_format($amountAfter_Promocode,2,".","");
													$cart_data->taxAbleAmount = number_format($amountAfter_Promocode,2,".","");
													$cart_data->gstPercentageAdd = $cart_data->gst_percentage + 100;
													$cart_data->total_GST = $cart_data->taxAbleAmount * $cart_data->gst_percentage / $cart_data->gstPercentageAdd; 
													$cart_data->total_GST_division = round($cart_data->total_GST / 2,2);
													$cart_data->total_GST = $cart_data->total_GST_division * 2;
													$cart_data->taxAbleAmount = $cart_data->taxAbleAmount-$cart_data->total_GST;
													$cart_data->total_with_GST = $cart_data->taxAbleAmount + $cart_data->total_GST; 
													$cart_data->total_GST = number_format($cart_data->total_GST,2,".","");
													$cart_data->total_with_GST = number_format($cart_data->total_with_GST,2,".","");
													$cart_data->isPromoValid = true;
												}

												else if($promo_item_id > 0 && $BothTaxableCmboItem > 0  && $promo_item_id == $item_id && $discount_of_max_amount > 0 && $BothTaxableCmboItem >= $discount_of_max_amount){
													
													$promoCount++;
													$isPromoValidForAll = true;
													$isPromoValidForAllMsg = 'PromoCode Applied Successfully';
													$promoDiscount_Amount =  $cart_data->taxAbleAmount / $BothTaxableCmboItem * $promotionDetails->discount_in_amount;
													$cart_data->promoDiscount_Percent = $promotionDetails->discount_in_percentage;
													$cart_data->promoDiscount_in_Amount = $promotionDetails->discount_in_amount;
													$cart_data->promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
													$promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
													$amountAfter_Promocode = $cart_data->taxAbleAmount - $promoDiscount_Amount;
													$cart_data->amountAfter_Promocode = number_format($amountAfter_Promocode,2,".","");
													$cart_data->taxAbleAmount = number_format($amountAfter_Promocode,2,".","");
													$cart_data->gstPercentageAdd = $cart_data->gst_percentage + 100;
													$cart_data->total_GST = $cart_data->taxAbleAmount * $cart_data->gst_percentage / $cart_data->gstPercentageAdd; 
													$cart_data->total_GST_division = round($cart_data->total_GST / 2,2);
													$cart_data->total_GST = $cart_data->total_GST_division * 2;
													$cart_data->taxAbleAmount = $cart_data->taxAbleAmount-$cart_data->total_GST;
													$cart_data->total_with_GST = $cart_data->taxAbleAmount + $cart_data->total_GST; 
													$cart_data->total_GST = number_format($cart_data->total_GST,2,".","");
													$cart_data->total_with_GST = number_format($cart_data->total_with_GST,2,".","");
													$cart_data->isPromoValid = true;												
												}
												
											
												else if($promo_item_id > 0  && $promo_item_id == $item_id && $discount_of_max_amount == 0){
													$promoCount++;
													$isPromoValidForAll = true;
													$isPromoValidForAllMsg = 'PromoCode Applied Successfully';
													$promoDiscount_Amount =  $cart_data->taxAbleAmount / $BothTaxableCmboItem * $promotionDetails->discount_in_amount;
													$cart_data->promoDiscount_Percent = $promotionDetails->discount_in_percentage;
													$cart_data->promoDiscount_in_Amount = $promotionDetails->discount_in_amount;
													$cart_data->promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
													$promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
													$amountAfter_Promocode = $cart_data->taxAbleAmount - $promoDiscount_Amount;
													$cart_data->amountAfter_Promocode = number_format($amountAfter_Promocode,2,".","");
													$cart_data->taxAbleAmount = number_format($amountAfter_Promocode,2,".","");
													$cart_data->gstPercentageAdd = $cart_data->gst_percentage + 100;
													$cart_data->total_GST = $cart_data->taxAbleAmount * $cart_data->gst_percentage / $cart_data->gstPercentageAdd; 
													$cart_data->total_GST_division = round($cart_data->total_GST / 2,2);
													$cart_data->total_GST = $cart_data->total_GST_division * 2;
													$cart_data->taxAbleAmount = $cart_data->taxAbleAmount-$cart_data->total_GST;
													$cart_data->total_with_GST = $cart_data->taxAbleAmount + $cart_data->total_GST; 
													$cart_data->total_GST = number_format($cart_data->total_GST,2,".","");
													$cart_data->total_with_GST = number_format($cart_data->total_with_GST,2,".","");
													$cart_data->isPromoValid = true;
												}
												else if($discount_of_max_amount > 0 && $BothTaxableCmboItem >= $discount_of_max_amount && $promo_item_id == 0 && $promo_category_id ==0){
													$promoCount++;
													$isPromoValidForAll = true;
													$isPromoValidForAllMsg = 'PromoCode Applied Successfully';
													$promoDiscount_Amount =  $cart_data->taxAbleAmount / $BothTaxableCmboItem * $promotionDetails->discount_in_amount;
													$cart_data->promoDiscount_Percent = $promotionDetails->discount_in_percentage;
													$cart_data->promoDiscount_in_Amount = $promotionDetails->discount_in_amount;
													$cart_data->promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
													$promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
													$amountAfter_Promocode = $cart_data->taxAbleAmount - $promoDiscount_Amount;
													$cart_data->amountAfter_Promocode = number_format($amountAfter_Promocode,2,".","");
													$cart_data->taxAbleAmount = number_format($amountAfter_Promocode,2,".","");
													$cart_data->gstPercentageAdd = $cart_data->gst_percentage + 100;
													$cart_data->total_GST = $cart_data->taxAbleAmount * $cart_data->gst_percentage / $cart_data->gstPercentageAdd; 
													$cart_data->total_GST_division = round($cart_data->total_GST / 2,2);
													$cart_data->total_GST = $cart_data->total_GST_division * 2;
													$cart_data->taxAbleAmount = $cart_data->taxAbleAmount-$cart_data->total_GST;
													$cart_data->total_with_GST = $cart_data->taxAbleAmount + $cart_data->total_GST; 
													$cart_data->total_GST = number_format($cart_data->total_GST,2,".","");
													$cart_data->total_with_GST = number_format($cart_data->total_with_GST,2,".","");
													$cart_data->isPromoValid = true;
												}
												else if($promo_category_id == 0 && $promo_item_id == 0 && $discount_of_max_amount ==0){
													$promoCount++;
													$isPromoValidForAll = true;
													$isPromoValidForAllMsg = 'PromoCode Applied Successfully';
													$promoDiscount_Amount =  $cart_data->taxAbleAmount / $BothTaxableCmboItem * $promotionDetails->discount_in_amount;
													$cart_data->promoDiscount_Percent = $promotionDetails->discount_in_percentage;
													$cart_data->promoDiscount_in_Amount = $promotionDetails->discount_in_amount;
													$cart_data->promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
													$promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
													$amountAfter_Promocode = $cart_data->taxAbleAmount - $promoDiscount_Amount;
													$cart_data->amountAfter_Promocode = number_format($amountAfter_Promocode,2,".","");
													$cart_data->taxAbleAmount = number_format($amountAfter_Promocode,2,".","");
													$cart_data->gstPercentageAdd = $cart_data->gst_percentage + 100;
													$cart_data->total_GST = $cart_data->taxAbleAmount * $cart_data->gst_percentage / $cart_data->gstPercentageAdd; 
													$cart_data->total_GST_division = round($cart_data->total_GST / 2,2);
													$cart_data->total_GST = $cart_data->total_GST_division * 2;
													$cart_data->taxAbleAmount = $cart_data->taxAbleAmount-$cart_data->total_GST;
													$cart_data->total_with_GST = $cart_data->taxAbleAmount + $cart_data->total_GST; 
													$cart_data->total_GST = number_format($cart_data->total_GST,2,".","");
													$cart_data->total_with_GST = number_format($cart_data->total_with_GST,2,".","");													
													$cart_data->isPromoValid = true;
												}else{
													if($promoCount==0)
													{
														$isPromoValidForAll = false;
														$isPromoValidForAllMsg = 'Invalid PromoCode';
													}else
													{
														$isPromoValidForAll = true;
														$isPromoValidForAllMsg = 'PromoCode Applied Successfully';
													}
													$cart_data->promoDiscount_Percent = 0.00;
													$cart_data->promoDiscount_in_Amount = 0.00;
													$cart_data->promoDiscount_Amount = 0.00;
													$cart_data->amountAfter_Promocode = $cart_data->taxAbleAmount;
													$cart_data->taxAbleAmount = $cart_data->taxAbleAmount;
													$cart_data->gstPercentageAdd = $cart_data->gst_percentage + 100;
													$cart_data->total_GST = $cart_data->taxAbleAmount * $cart_data->gst_percentage / $cart_data->gstPercentageAdd; 
													$cart_data->total_GST_division = round($cart_data->total_GST / 2,2);
													$cart_data->total_GST = $cart_data->total_GST_division * 2;
													$cart_data->taxAbleAmount = $cart_data->taxAbleAmount-$cart_data->total_GST;
													$cart_data->total_with_GST = $cart_data->taxAbleAmount + $cart_data->total_GST; 
													$cart_data->total_GST = number_format($cart_data->total_GST,2,".","");
													$cart_data->total_with_GST = number_format($cart_data->total_with_GST,2,".","");													
													$cart_data->isPromoValid = true;
												}
											}else{
												if($promo_category_id > 0 && $promo_category_id == $cate_id && $promo_item_id == 0 && $discount_of_max_amount ==0)
												{	$promoCount++;
													$isPromoValidForAll = true;
													$isPromoValidForAllMsg = 'PromoCode Applied Successfully';
													$promoDiscount_Amount =  $cart_data->taxAbleAmount * $promotionDetails->discount_in_percentage / 100;
													$cart_data->promoDiscount_Percent = $promotionDetails->discount_in_percentage;
													$cart_data->promoDiscount_in_Amount = $promotionDetails->discount_in_amount;
													$cart_data->promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
													$promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
													$amountAfter_Promocode = $cart_data->taxAbleAmount - $promoDiscount_Amount;
													$cart_data->amountAfter_Promocode = number_format($amountAfter_Promocode,2,".","");
													$cart_data->taxAbleAmount = number_format($amountAfter_Promocode,2,".","");
													$cart_data->gstPercentageAdd = $cart_data->gst_percentage + 100;
													$cart_data->total_GST = $cart_data->taxAbleAmount * $cart_data->gst_percentage / $cart_data->gstPercentageAdd; 
													$cart_data->total_GST_division = round($cart_data->total_GST / 2,2);
													$cart_data->total_GST = $cart_data->total_GST_division * 2;
													$cart_data->taxAbleAmount = $cart_data->taxAbleAmount-$cart_data->total_GST;
													$cart_data->total_with_GST = $cart_data->taxAbleAmount + $cart_data->total_GST; 
													$cart_data->total_GST = number_format($cart_data->total_GST,2,".","");
													$cart_data->total_with_GST = number_format($cart_data->total_with_GST,2,".","");
													$cart_data->isPromoValid = true;
												}
												else if($promo_item_id > 0  && $promo_item_id == $item_id && $discount_of_max_amount == 0){
													$promoCount++;
													$isPromoValidForAll = true;
													$isPromoValidForAllMsg = 'PromoCode Applied Successfully';
													$promoDiscount_Amount =  $cart_data->taxAbleAmount * $promotionDetails->discount_in_percentage / 100;
													$cart_data->promoDiscount_Percent = $promotionDetails->discount_in_percentage;
													$cart_data->promoDiscount_in_Amount = $promotionDetails->discount_in_amount;
													$cart_data->promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
													$promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
													$amountAfter_Promocode = $cart_data->taxAbleAmount - $promoDiscount_Amount;
													$cart_data->amountAfter_Promocode = number_format($amountAfter_Promocode,2,".","");
													$cart_data->taxAbleAmount = number_format($amountAfter_Promocode,2,".","");
													$cart_data->gstPercentageAdd = $cart_data->gst_percentage + 100;
													$cart_data->total_GST = $cart_data->taxAbleAmount * $cart_data->gst_percentage / $cart_data->gstPercentageAdd; 
													$cart_data->total_GST_division = round($cart_data->total_GST / 2,2);
													$cart_data->total_GST = $cart_data->total_GST_division * 2;
													$cart_data->taxAbleAmount = $cart_data->taxAbleAmount-$cart_data->total_GST;
													$cart_data->total_with_GST = $cart_data->taxAbleAmount + $cart_data->total_GST; 
													$cart_data->total_GST = number_format($cart_data->total_GST,2,".","");
													$cart_data->total_with_GST = number_format($cart_data->total_with_GST,2,".","");
													$cart_data->isPromoValid = true;
												}

												
												else if($promo_item_id > 0 && $BothTaxableCmboItem > 0  && $promo_item_id == $item_id && $discount_of_max_amount > 0 && $BothTaxableCmboItem >= $discount_of_max_amount){
													$promoCount++;
													$isPromoValidForAll = true;
													$isPromoValidForAllMsg = 'PromoCode Applied Successfully';
													$promoDiscount_Amount =  $cart_data->taxAbleAmount * $promotionDetails->discount_in_percentage / 100;
													$cart_data->promoDiscount_Percent = $promotionDetails->discount_in_percentage;
													$cart_data->promoDiscount_in_Amount = $promotionDetails->discount_in_amount;
													$cart_data->promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
													$promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
													$amountAfter_Promocode = $cart_data->taxAbleAmount - $promoDiscount_Amount;
													$cart_data->amountAfter_Promocode = number_format($amountAfter_Promocode,2,".","");
													$cart_data->taxAbleAmount = number_format($amountAfter_Promocode,2,".","");
													$cart_data->gstPercentageAdd = $cart_data->gst_percentage + 100;
													$cart_data->total_GST = $cart_data->taxAbleAmount * $cart_data->gst_percentage / $cart_data->gstPercentageAdd; 
													$cart_data->total_GST_division = round($cart_data->total_GST / 2,2);
													$cart_data->total_GST = $cart_data->total_GST_division * 2;
													$cart_data->taxAbleAmount = $cart_data->taxAbleAmount-$cart_data->total_GST;
													$cart_data->total_with_GST = $cart_data->taxAbleAmount + $cart_data->total_GST; 
													$cart_data->total_GST = number_format($cart_data->total_GST,2,".","");
													$cart_data->total_with_GST = number_format($cart_data->total_with_GST,2,".","");
													$cart_data->isPromoValid = true;
												}												
												
												
												
												else if($discount_of_max_amount > 0 && $BothTaxableCmboItem >= $discount_of_max_amount && $promo_category_id > 0 && $promo_category_id == $cate_id){
													$promoCount++;
													$isPromoValidForAll = true;
													$isPromoValidForAllMsg = 'PromoCode Applied Successfully';
													$promoDiscount_Amount =  $cart_data->taxAbleAmount * $promotionDetails->discount_in_percentage / 100;
													$cart_data->promoDiscount_Percent = $promotionDetails->discount_in_percentage;
													$cart_data->promoDiscount_in_Amount = $promotionDetails->discount_in_amount;
													$cart_data->promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
													$promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
													$amountAfter_Promocode = $cart_data->taxAbleAmount - $promoDiscount_Amount;
													$cart_data->amountAfter_Promocode = number_format($amountAfter_Promocode,2,".","");
													$cart_data->taxAbleAmount = number_format($amountAfter_Promocode,2,".","");
													$cart_data->gstPercentageAdd = $cart_data->gst_percentage + 100;
													$cart_data->total_GST = $cart_data->taxAbleAmount * $cart_data->gst_percentage / $cart_data->gstPercentageAdd; 
													$cart_data->total_GST_division = round($cart_data->total_GST / 2,2);
													$cart_data->total_GST = $cart_data->total_GST_division * 2;
													$cart_data->taxAbleAmount = $cart_data->taxAbleAmount-$cart_data->total_GST;
													$cart_data->total_with_GST = $cart_data->taxAbleAmount + $cart_data->total_GST; 
													$cart_data->total_GST = number_format($cart_data->total_GST,2,".","");
													$cart_data->total_with_GST = number_format($cart_data->total_with_GST,2,".","");
													$cart_data->isPromoValid = true;
												}



												
												else if($discount_of_max_amount > 0 && $BothTaxableCmboItem >= $discount_of_max_amount && $promo_item_id == 0 && $promo_category_id ==0){
													$promoCount++;
													$isPromoValidForAll = true;
													$isPromoValidForAllMsg = 'PromoCode Applied Successfully';
													$promoDiscount_Amount =  $cart_data->taxAbleAmount * $promotionDetails->discount_in_percentage / 100;
													$cart_data->promoDiscount_Percent = $promotionDetails->discount_in_percentage;
													$cart_data->promoDiscount_in_Amount = $promotionDetails->discount_in_amount;
													$cart_data->promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
													$promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
													$amountAfter_Promocode = $cart_data->taxAbleAmount - $promoDiscount_Amount;
													$cart_data->amountAfter_Promocode = number_format($amountAfter_Promocode,2,".","");
													$cart_data->taxAbleAmount = number_format($amountAfter_Promocode,2,".","");
													$cart_data->gstPercentageAdd = $cart_data->gst_percentage + 100;
													$cart_data->total_GST = $cart_data->taxAbleAmount * $cart_data->gst_percentage / $cart_data->gstPercentageAdd; 
													$cart_data->total_GST_division = round($cart_data->total_GST / 2,2);
													$cart_data->total_GST = $cart_data->total_GST_division * 2;
													$cart_data->taxAbleAmount = $cart_data->taxAbleAmount-$cart_data->total_GST;
													$cart_data->total_with_GST = $cart_data->taxAbleAmount + $cart_data->total_GST; 
													$cart_data->total_GST = number_format($cart_data->total_GST,2,".","");
													$cart_data->total_with_GST = number_format($cart_data->total_with_GST,2,".","");
													$cart_data->isPromoValid = true;
												}
												else if($promo_category_id == 0 && $promo_item_id == 0 && $discount_of_max_amount ==0){
													$promoCount++;
													$isPromoValidForAll = true;
													$isPromoValidForAllMsg = 'PromoCode Applied Successfully';
													$promoDiscount_Amount =  $cart_data->taxAbleAmount * $promotionDetails->discount_in_percentage / 100;
													$cart_data->promoDiscount_Percent = $promotionDetails->discount_in_percentage;
													$cart_data->promoDiscount_in_Amount = $promotionDetails->discount_in_amount;
													$cart_data->promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
													$promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
													$amountAfter_Promocode = $cart_data->taxAbleAmount - $promoDiscount_Amount;
													$cart_data->amountAfter_Promocode = number_format($amountAfter_Promocode,2,".","");
													$cart_data->taxAbleAmount = number_format($amountAfter_Promocode,2,".","");
													$cart_data->gstPercentageAdd = $cart_data->gst_percentage + 100;
													$cart_data->total_GST = $cart_data->taxAbleAmount * $cart_data->gst_percentage / $cart_data->gstPercentageAdd; 
													$cart_data->total_GST_division = round($cart_data->total_GST / 2,2);
													$cart_data->total_GST = $cart_data->total_GST_division * 2;
													$cart_data->taxAbleAmount = $cart_data->taxAbleAmount-$cart_data->total_GST;
													$cart_data->total_with_GST = $cart_data->taxAbleAmount + $cart_data->total_GST; 
													$cart_data->total_GST = number_format($cart_data->total_GST,2,".","");
													$cart_data->total_with_GST = number_format($cart_data->total_with_GST,2,".","");													
													$cart_data->isPromoValid = true;
												}else{
													if($promoCount==0)
													{
														$isPromoValidForAll = false;
														$isPromoValidForAllMsg = 'Invalid PromoCode';
													}else
													{
														$isPromoValidForAll = true;
														$isPromoValidForAllMsg = 'PromoCode Applied Successfully';
													}
													$cart_data->promoDiscount_Percent = 0.00;
													$cart_data->promoDiscount_in_Amount = 0.00;
													$cart_data->promoDiscount_Amount = 0.00;
													$cart_data->amountAfter_Promocode = $cart_data->taxAbleAmount;
													$cart_data->taxAbleAmount = $cart_data->taxAbleAmount;
													$cart_data->gstPercentageAdd = $cart_data->gst_percentage + 100;
													$cart_data->total_GST = $cart_data->taxAbleAmount * $cart_data->gst_percentage / $cart_data->gstPercentageAdd; 
													$cart_data->total_GST_division = round($cart_data->total_GST / 2,2);
													$cart_data->total_GST = $cart_data->total_GST_division * 2;
													$cart_data->taxAbleAmount = $cart_data->taxAbleAmount-$cart_data->total_GST;
													$cart_data->total_with_GST = $cart_data->taxAbleAmount + $cart_data->total_GST; 
													$cart_data->total_GST = number_format($cart_data->total_GST,2,".","");
													$cart_data->total_with_GST = number_format($cart_data->total_with_GST,2,".","");													
													$cart_data->isPromoValid = true;
												}
											}
										}										
									}else{
											if($promoCount==0)
											{
												$isPromoValidForAll = false;
												$isPromoValidForAllMsg = 'Invalid PromoCode';
											}else
											{
												$isPromoValidForAll = true;
												$isPromoValidForAllMsg = 'PromoCode Applied Successfully';
											}
											$cart_data->promoDiscount_Percent = 0.00;
											$cart_data->promoDiscount_in_Amount = 0.00;
											$cart_data->promoDiscount_Amount = 0.00;
											$cart_data->amountAfter_Promocode = $cart_data->taxAbleAmount;
											$cart_data->taxAbleAmount = $cart_data->taxAbleAmount;
											$cart_data->gstPercentageAdd = $cart_data->gst_percentage + 100;
											$cart_data->total_GST = $cart_data->taxAbleAmount * $cart_data->gst_percentage / $cart_data->gstPercentageAdd; 
											$cart_data->total_GST_division = round($cart_data->total_GST / 2,2);
											$cart_data->total_GST = $cart_data->total_GST_division * 2;
											$cart_data->taxAbleAmount = $cart_data->taxAbleAmount-$cart_data->total_GST;
											$cart_data->total_with_GST = $cart_data->taxAbleAmount + $cart_data->total_GST; 
											$cart_data->total_GST = number_format($cart_data->total_GST,2,".","");
											$cart_data->total_with_GST = number_format($cart_data->total_with_GST,2,".","");										
											$cart_data->isPromoValid = true;
									}		
								
								}								
							}
							
							if(!empty($comboData))
							{  						
								foreach($comboData as $combo)
								{
									//$taxAbleAmount_Total = 0.00;
									$combowith_GST_Amount = 0.00;
									$comboTotal_Amount = 0.00;	
									$memberShipDiscount_Amount = 0.00;
									$promoDiscount_Amount = 0.00;
									$promoTotal_Amount = 0.00;									
									foreach($combo->combo_offer->combo_offer_details as $combo_offer_detail)
									{
										$comboItemDetails = $this->Carts->ItemVariations->find()
										->contain(['Items'])
										->where(['ItemVariations.id' =>$combo_offer_detail->item_variation_id])
										->first();
									   $item_id = $comboItemDetails->item->id;
									   //$combo_offer_detail->gst_percentage = $combo_offer_detail->gst_percentage;
									   $cate_id = $comboItemDetails->item->category_id;
										if($cash_back == 0){
											if($discount_in_percentage == 0)
											{
												if($promo_category_id > 0 && $promo_category_id == $cate_id && $promo_item_id == 0 && $discount_of_max_amount ==0)
												{
														$promoCount++;
														$isPromoValidForAll = true;
														$isPromoValidForAllMsg = 'PromoCode Applied Successfully';
														$promoDiscount_Amount =  $combo_offer_detail->taxAbleAmount / $BothTaxableCmboItem * $promotionDetails->discount_in_amount;
														$combo_offer_detail->promoDiscount_Percent = $promotionDetails->discount_in_percentage;
														$combo_offer_detail->promoDiscount_in_Amount = $promotionDetails->discount_in_amount;
														$combo_offer_detail->promoDiscount_Amount =  number_format($promoDiscount_Amount,2,".",""); 
														$promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
														$amountAfter_Promocode = $combo_offer_detail->taxAbleAmount - $promoDiscount_Amount;
														$combo_offer_detail->amountAfter_Promocode = number_format($amountAfter_Promocode,2,".","");
														$combo_offer_detail->taxAbleAmount = number_format($amountAfter_Promocode,2,".","");
														$combo_offer_detail->gstPercentageAdd = $combo_offer_detail->gst_percentage + 100;
														$combo_offer_detail->total_GST = $combo_offer_detail->taxAbleAmount * $combo_offer_detail->gst_percentage / $combo_offer_detail->gstPercentageAdd; 
														$combo_offer_detail->total_GST_division = round($combo_offer_detail->total_GST / 2,2);
														$combo_offer_detail->total_GST = $combo_offer_detail->total_GST_division * 2;
														$combo_offer_detail->taxAbleAmount = $combo_offer_detail->taxAbleAmount-$combo_offer_detail->total_GST;
														$combo_offer_detail->total_with_GST = $combo_offer_detail->taxAbleAmount + $combo_offer_detail->total_GST; 
														$combo_offer_detail->total_GST = number_format($combo_offer_detail->total_GST,2,".","");
														$combo_offer_detail->total_with_GST = number_format($combo_offer_detail->total_with_GST,2,".","");
														$combo_offer_detail->isPromoValid = true;
														$PromoComboValid = true;
												}
												else if($promo_item_id > 0  && $promo_item_id == $item_id && $discount_of_max_amount == 0){
														$promoCount++;
														$isPromoValidForAll = true;
														$isPromoValidForAllMsg = 'PromoCode Applied Successfully';
														$promoDiscount_Amount =  $combo_offer_detail->taxAbleAmount / $BothTaxableCmboItem * $promotionDetails->discount_in_amount;
														$combo_offer_detail->promoDiscount_Percent = $promotionDetails->discount_in_percentage;
														$combo_offer_detail->promoDiscount_in_Amount = $promotionDetails->discount_in_amount;
														$combo_offer_detail->promoDiscount_Amount =  number_format($promoDiscount_Amount,2,".",""); 
														$promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
														$amountAfter_Promocode = $combo_offer_detail->taxAbleAmount - $promoDiscount_Amount;
														$combo_offer_detail->amountAfter_Promocode = number_format($amountAfter_Promocode,2,".","");
														$combo_offer_detail->taxAbleAmount = number_format($amountAfter_Promocode,2,".","");
														$combo_offer_detail->gstPercentageAdd = $combo_offer_detail->gst_percentage + 100;
														$combo_offer_detail->total_GST = $combo_offer_detail->taxAbleAmount * $combo_offer_detail->gst_percentage / $combo_offer_detail->gstPercentageAdd; 
														$combo_offer_detail->total_GST_division = round($combo_offer_detail->total_GST / 2,2);
														$combo_offer_detail->total_GST = $combo_offer_detail->total_GST_division * 2;
														$combo_offer_detail->taxAbleAmount = $combo_offer_detail->taxAbleAmount-$combo_offer_detail->total_GST;
														$combo_offer_detail->total_with_GST = $combo_offer_detail->taxAbleAmount + $combo_offer_detail->total_GST; 
														$combo_offer_detail->total_GST = number_format($combo_offer_detail->total_GST,2,".","");
														$combo_offer_detail->total_with_GST = number_format($combo_offer_detail->total_with_GST,2,".","");
														$combo_offer_detail->isPromoValid = true;
														$PromoComboValid = true;
												}


												else if($discount_of_max_amount > 0 && $BothTaxableCmboItem >= $discount_of_max_amount && $promo_category_id > 0 && $promo_category_id == $cate_id){
														$promoCount++;
														$isPromoValidForAll = true;
														$isPromoValidForAllMsg = 'PromoCode Applied Successfully';
														$promoDiscount_Amount =  $combo_offer_detail->taxAbleAmount / $BothTaxableCmboItem * $promotionDetails->discount_in_amount;
														$combo_offer_detail->promoDiscount_Percent = $promotionDetails->discount_in_percentage;
														$combo_offer_detail->promoDiscount_in_Amount = $promotionDetails->discount_in_amount;
														$combo_offer_detail->promoDiscount_Amount =  number_format($promoDiscount_Amount,2,".",""); 
														$promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
														$amountAfter_Promocode = $combo_offer_detail->taxAbleAmount - $promoDiscount_Amount;
														$combo_offer_detail->amountAfter_Promocode = number_format($amountAfter_Promocode,2,".","");
														$combo_offer_detail->taxAbleAmount = number_format($amountAfter_Promocode,2,".","");
														$combo_offer_detail->gstPercentageAdd = $combo_offer_detail->gst_percentage + 100;
														$combo_offer_detail->total_GST = $combo_offer_detail->taxAbleAmount * $combo_offer_detail->gst_percentage / $combo_offer_detail->gstPercentageAdd; 
														$combo_offer_detail->total_GST_division = round($combo_offer_detail->total_GST / 2,2);
														$combo_offer_detail->total_GST = $combo_offer_detail->total_GST_division * 2;
														$combo_offer_detail->taxAbleAmount = $combo_offer_detail->taxAbleAmount-$combo_offer_detail->total_GST;
														$combo_offer_detail->total_with_GST = $combo_offer_detail->taxAbleAmount + $combo_offer_detail->total_GST; 
														$combo_offer_detail->total_GST = number_format($combo_offer_detail->total_GST,2,".","");
														$combo_offer_detail->total_with_GST = number_format($combo_offer_detail->total_with_GST,2,".","");
														$combo_offer_detail->isPromoValid = true;
														$PromoComboValid = true;
												}

												else if($promo_item_id > 0 && $BothTaxableCmboItem > 0  && $promo_item_id == $item_id && $discount_of_max_amount > 0 && $BothTaxableCmboItem >= $discount_of_max_amount){
														$promoCount++;
														$isPromoValidForAll = true;
														$isPromoValidForAllMsg = 'PromoCode Applied Successfully';
														$promoDiscount_Amount =  $combo_offer_detail->taxAbleAmount / $BothTaxableCmboItem * $promotionDetails->discount_in_amount;
														$combo_offer_detail->promoDiscount_Percent = $promotionDetails->discount_in_percentage;
														$combo_offer_detail->promoDiscount_in_Amount = $promotionDetails->discount_in_amount;
														$combo_offer_detail->promoDiscount_Amount =  number_format($promoDiscount_Amount,2,".",""); 
														$promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
														$amountAfter_Promocode = $combo_offer_detail->taxAbleAmount - $promoDiscount_Amount;
														$combo_offer_detail->amountAfter_Promocode = number_format($amountAfter_Promocode,2,".","");
														$combo_offer_detail->taxAbleAmount = number_format($amountAfter_Promocode,2,".","");
														$combo_offer_detail->gstPercentageAdd = $combo_offer_detail->gst_percentage + 100;
														$combo_offer_detail->total_GST = $combo_offer_detail->taxAbleAmount * $combo_offer_detail->gst_percentage / $combo_offer_detail->gstPercentageAdd; 
														$combo_offer_detail->total_GST_division = round($combo_offer_detail->total_GST / 2,2);
														$combo_offer_detail->total_GST = $combo_offer_detail->total_GST_division * 2;
														$combo_offer_detail->taxAbleAmount = $combo_offer_detail->taxAbleAmount-$combo_offer_detail->total_GST;
														$combo_offer_detail->total_with_GST = $combo_offer_detail->taxAbleAmount + $combo_offer_detail->total_GST; 
														$combo_offer_detail->total_GST = number_format($combo_offer_detail->total_GST,2,".","");
														$combo_offer_detail->total_with_GST = number_format($combo_offer_detail->total_with_GST,2,".","");
														$combo_offer_detail->isPromoValid = true;
														$PromoComboValid = true;
												}

												
												else if($discount_of_max_amount > 0 && $BothTaxableCmboItem >= $discount_of_max_amount && $promo_item_id == 0 && $promo_category_id ==0){
														$promoCount++;
														$isPromoValidForAll = true;
														$isPromoValidForAllMsg = 'PromoCode Applied Successfully';
														$promoDiscount_Amount =  $combo_offer_detail->taxAbleAmount / $BothTaxableCmboItem * $promotionDetails->discount_in_amount;
														$combo_offer_detail->promoDiscount_Percent = $promotionDetails->discount_in_percentage;
														$combo_offer_detail->promoDiscount_in_Amount = $promotionDetails->discount_in_amount;
														$combo_offer_detail->promoDiscount_Amount =  number_format($promoDiscount_Amount,2,".",""); 
														$promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
														$amountAfter_Promocode = $combo_offer_detail->taxAbleAmount - $promoDiscount_Amount;
														$combo_offer_detail->amountAfter_Promocode = number_format($amountAfter_Promocode,2,".","");
														$combo_offer_detail->taxAbleAmount = number_format($amountAfter_Promocode,2,".","");
														$combo_offer_detail->gstPercentageAdd = $combo_offer_detail->gst_percentage + 100;
														$combo_offer_detail->total_GST = $combo_offer_detail->taxAbleAmount * $combo_offer_detail->gst_percentage / $combo_offer_detail->gstPercentageAdd; 
														$combo_offer_detail->total_GST_division = round($combo_offer_detail->total_GST / 2,2);
														$combo_offer_detail->total_GST = $combo_offer_detail->total_GST_division * 2;
														$combo_offer_detail->taxAbleAmount = $combo_offer_detail->taxAbleAmount-$combo_offer_detail->total_GST;
														$combo_offer_detail->total_with_GST = $combo_offer_detail->taxAbleAmount + $combo_offer_detail->total_GST; 
														$combo_offer_detail->total_GST = number_format($combo_offer_detail->total_GST,2,".","");
														$combo_offer_detail->total_with_GST = number_format($combo_offer_detail->total_with_GST,2,".","");
														$combo_offer_detail->isPromoValid = true;
														$PromoComboValid = true;
												}
												else if($promo_category_id == 0 && $promo_item_id == 0 && $discount_of_max_amount ==0){
														$promoCount++;
														$isPromoValidForAll = true;
														$isPromoValidForAllMsg = 'PromoCode Applied Successfully';
														$promoDiscount_Amount =  $combo_offer_detail->taxAbleAmount / $BothTaxableCmboItem * $promotionDetails->discount_in_amount;
														$combo_offer_detail->promoDiscount_Percent = $promotionDetails->discount_in_percentage;
														$combo_offer_detail->promoDiscount_in_Amount = $promotionDetails->discount_in_amount;
														$combo_offer_detail->promoDiscount_Amount =  number_format($promoDiscount_Amount,2,".",""); 
														$promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
														$amountAfter_Promocode = $combo_offer_detail->taxAbleAmount - $promoDiscount_Amount;
														$combo_offer_detail->amountAfter_Promocode = number_format($amountAfter_Promocode,2,".","");
														$combo_offer_detail->taxAbleAmount = number_format($amountAfter_Promocode,2,".","");
														$combo_offer_detail->gstPercentageAdd = $combo_offer_detail->gst_percentage + 100;
														$combo_offer_detail->total_GST = $combo_offer_detail->taxAbleAmount * $combo_offer_detail->gst_percentage / $combo_offer_detail->gstPercentageAdd; 
														$combo_offer_detail->total_GST_division = round($combo_offer_detail->total_GST / 2,2);
														$combo_offer_detail->total_GST = $combo_offer_detail->total_GST_division * 2;
														$combo_offer_detail->taxAbleAmount = $combo_offer_detail->taxAbleAmount-$combo_offer_detail->total_GST;
														$combo_offer_detail->total_with_GST = $combo_offer_detail->taxAbleAmount + $combo_offer_detail->total_GST; 
														$combo_offer_detail->total_GST = number_format($combo_offer_detail->total_GST,2,".","");
														$combo_offer_detail->total_with_GST = number_format($combo_offer_detail->total_with_GST,2,".","");													
														$combo_offer_detail->isPromoValid = true;
														$PromoComboValid = true;
												}else{
														if($promoCount==0)
														{
															$isPromoValidForAll = false;
															$isPromoValidForAllMsg = 'Invalid PromoCode';
														}else
														{
															$isPromoValidForAll = true;
															$isPromoValidForAllMsg = 'PromoCode Applied Successfully';
														}
														$combo_offer_detail->promoDiscount_Percent = 0.00;
														$combo_offer_detail->promoDiscount_in_Amount = 0.00;
														$combo_offer_detail->promoDiscount_Amount = 0.00;
														$combo_offer_detail->amountAfter_Promocode = $combo_offer_detail->taxAbleAmount;
														$combo_offer_detail->taxAbleAmount = $combo_offer_detail->taxAbleAmount;
														$combo_offer_detail->gstPercentageAdd = $combo_offer_detail->gst_percentage + 100;
														$combo_offer_detail->total_GST = $combo_offer_detail->taxAbleAmount * $combo_offer_detail->gst_percentage / $combo_offer_detail->gstPercentageAdd; 
														$combo_offer_detail->total_GST_division = round($combo_offer_detail->total_GST / 2,2);
														$combo_offer_detail->total_GST = $combo_offer_detail->total_GST_division * 2;
														$combo_offer_detail->taxAbleAmount = $combo_offer_detail->taxAbleAmount-$combo_offer_detail->total_GST;
														$combo_offer_detail->total_with_GST = $combo_offer_detail->taxAbleAmount + $combo_offer_detail->total_GST; 
														$combo_offer_detail->total_GST = number_format($combo_offer_detail->total_GST,2,".","");
														$combo_offer_detail->total_with_GST = number_format($combo_offer_detail->total_with_GST,2,".","");													
														$combo_offer_detail->isPromoValid = false;
														$PromoComboValid = false;
												}
											}else{
												if($promo_category_id > 0 && $promo_category_id == $cate_id && $promo_item_id == 0 && $discount_of_max_amount ==0)
												{
														$promoCount++;
														$isPromoValidForAll = true;
														$isPromoValidForAllMsg = 'PromoCode Applied Successfully';
														$promoDiscount_Amount =  $combo_offer_detail->taxAbleAmount * $promotionDetails->discount_in_percentage / 100;
														$combo_offer_detail->promoDiscount_Percent = $promotionDetails->discount_in_percentage;
														$combo_offer_detail->promoDiscount_in_Amount = $promotionDetails->discount_in_amount;
														$combo_offer_detail->promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
														$promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
														$amountAfter_Promocode = $combo_offer_detail->taxAbleAmount - $promoDiscount_Amount;
														$combo_offer_detail->amountAfter_Promocode = number_format($amountAfter_Promocode,2,".","");
														$combo_offer_detail->taxAbleAmount = number_format($amountAfter_Promocode,2,".","");
														$combo_offer_detail->gstPercentageAdd = $combo_offer_detail->gst_percentage + 100;
														$combo_offer_detail->total_GST = $combo_offer_detail->taxAbleAmount * $combo_offer_detail->gst_percentage / $combo_offer_detail->gstPercentageAdd; 
														$combo_offer_detail->total_GST_division = round($combo_offer_detail->total_GST / 2,2);
														$combo_offer_detail->total_GST = $combo_offer_detail->total_GST_division * 2;
														$combo_offer_detail->taxAbleAmount = $combo_offer_detail->taxAbleAmount-$combo_offer_detail->total_GST;
														$combo_offer_detail->total_with_GST = $combo_offer_detail->taxAbleAmount + $combo_offer_detail->total_GST; 
														$combo_offer_detail->total_GST = number_format($combo_offer_detail->total_GST,2,".","");
														$combo_offer_detail->total_with_GST = number_format($combo_offer_detail->total_with_GST,2,".","");
														$combo_offer_detail->isPromoValid = true;
														$PromoComboValid = true;
												}
												else if($promo_item_id > 0  && $promo_item_id == $item_id && $discount_of_max_amount == 0){
														$promoCount++;
														$isPromoValidForAll = true;
														$isPromoValidForAllMsg = 'PromoCode Applied Successfully';
														$promoDiscount_Amount =  $combo_offer_detail->taxAbleAmount * $promotionDetails->discount_in_percentage / 100;
														$combo_offer_detail->promoDiscount_Percent = $promotionDetails->discount_in_percentage;
														$combo_offer_detail->promoDiscount_in_Amount = $promotionDetails->discount_in_amount;
														$combo_offer_detail->promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
														$promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
														$amountAfter_Promocode = $combo_offer_detail->taxAbleAmount - $promoDiscount_Amount;
														$combo_offer_detail->amountAfter_Promocode = number_format($amountAfter_Promocode,2,".","");
														$combo_offer_detail->taxAbleAmount = number_format($amountAfter_Promocode,2,".","");
														$combo_offer_detail->gstPercentageAdd = $combo_offer_detail->gst_percentage + 100;
														$combo_offer_detail->total_GST = $combo_offer_detail->taxAbleAmount * $combo_offer_detail->gst_percentage / $combo_offer_detail->gstPercentageAdd; 
														$combo_offer_detail->total_GST_division = round($combo_offer_detail->total_GST / 2,2);
														$combo_offer_detail->total_GST = $combo_offer_detail->total_GST_division * 2;
														$combo_offer_detail->taxAbleAmount = $combo_offer_detail->taxAbleAmount-$combo_offer_detail->total_GST;
														$combo_offer_detail->total_with_GST = $combo_offer_detail->taxAbleAmount + $combo_offer_detail->total_GST; 
														$combo_offer_detail->total_GST = number_format($combo_offer_detail->total_GST,2,".","");
														$combo_offer_detail->total_with_GST = number_format($combo_offer_detail->total_with_GST,2,".","");
														$combo_offer_detail->isPromoValid = true;
														$PromoComboValid = true;
												}

												else if($discount_of_max_amount > 0 && $BothTaxableCmboItem >= $discount_of_max_amount && $promo_category_id > 0 && $promo_category_id == $cate_id){
														$promoCount++;
														$isPromoValidForAll = true;
														$isPromoValidForAllMsg = 'PromoCode Applied Successfully';
														$promoDiscount_Amount =  $combo_offer_detail->taxAbleAmount * $promotionDetails->discount_in_percentage / 100;
														$combo_offer_detail->promoDiscount_Percent = $promotionDetails->discount_in_percentage;
														$combo_offer_detail->promoDiscount_in_Amount = $promotionDetails->discount_in_amount;
														$combo_offer_detail->promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
														$promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
														$amountAfter_Promocode = $combo_offer_detail->taxAbleAmount - $promoDiscount_Amount;
														$combo_offer_detail->amountAfter_Promocode = number_format($amountAfter_Promocode,2,".","");
														$combo_offer_detail->taxAbleAmount = number_format($amountAfter_Promocode,2,".","");
														$combo_offer_detail->gstPercentageAdd = $combo_offer_detail->gst_percentage + 100;
														$combo_offer_detail->total_GST = $combo_offer_detail->taxAbleAmount * $combo_offer_detail->gst_percentage / $combo_offer_detail->gstPercentageAdd; 
														$combo_offer_detail->total_GST_division = round($combo_offer_detail->total_GST / 2,2);
														$combo_offer_detail->total_GST = $combo_offer_detail->total_GST_division * 2;
														$combo_offer_detail->taxAbleAmount = $combo_offer_detail->taxAbleAmount-$combo_offer_detail->total_GST;
														$combo_offer_detail->total_with_GST = $combo_offer_detail->taxAbleAmount + $combo_offer_detail->total_GST; 
														$combo_offer_detail->total_GST = number_format($combo_offer_detail->total_GST,2,".","");
														$combo_offer_detail->total_with_GST = number_format($combo_offer_detail->total_with_GST,2,".","");
														$combo_offer_detail->isPromoValid = true;
														$PromoComboValid = true;
												}


												else if($promo_item_id > 0 && $BothTaxableCmboItem > 0  && $promo_item_id == $item_id && $discount_of_max_amount > 0 && $BothTaxableCmboItem >= $discount_of_max_amount){
														$promoCount++;
														$isPromoValidForAll = true;
														$isPromoValidForAllMsg = 'PromoCode Applied Successfully';
														$promoDiscount_Amount =  $combo_offer_detail->taxAbleAmount * $promotionDetails->discount_in_percentage / 100;
														$combo_offer_detail->promoDiscount_Percent = $promotionDetails->discount_in_percentage;
														$combo_offer_detail->promoDiscount_in_Amount = $promotionDetails->discount_in_amount;
														$combo_offer_detail->promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
														$promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
														$amountAfter_Promocode = $combo_offer_detail->taxAbleAmount - $promoDiscount_Amount;
														$combo_offer_detail->amountAfter_Promocode = number_format($amountAfter_Promocode,2,".","");
														$combo_offer_detail->taxAbleAmount = number_format($amountAfter_Promocode,2,".","");
														$combo_offer_detail->gstPercentageAdd = $combo_offer_detail->gst_percentage + 100;
														$combo_offer_detail->total_GST = $combo_offer_detail->taxAbleAmount * $combo_offer_detail->gst_percentage / $combo_offer_detail->gstPercentageAdd; 
														$combo_offer_detail->total_GST_division = round($combo_offer_detail->total_GST / 2,2);
														$combo_offer_detail->total_GST = $combo_offer_detail->total_GST_division * 2;
														$combo_offer_detail->taxAbleAmount = $combo_offer_detail->taxAbleAmount-$combo_offer_detail->total_GST;
														$combo_offer_detail->total_with_GST = $combo_offer_detail->taxAbleAmount + $combo_offer_detail->total_GST; 
														$combo_offer_detail->total_GST = number_format($combo_offer_detail->total_GST,2,".","");
														$combo_offer_detail->total_with_GST = number_format($combo_offer_detail->total_with_GST,2,".","");
														$combo_offer_detail->isPromoValid = true;
														$PromoComboValid = true;
												}



												
												else if($discount_of_max_amount > 0 && $BothTaxableCmboItem >= $discount_of_max_amount && $promo_item_id == 0 && $promo_category_id ==0){
														$promoCount++;
														$isPromoValidForAll = true;
														$isPromoValidForAllMsg = 'PromoCode Applied Successfully';
														$promoDiscount_Amount =  $combo_offer_detail->taxAbleAmount * $promotionDetails->discount_in_percentage / 100;
														$combo_offer_detail->promoDiscount_Percent = $promotionDetails->discount_in_percentage;
														$combo_offer_detail->promoDiscount_in_Amount = $promotionDetails->discount_in_amount;
														$combo_offer_detail->promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
														$promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
														$amountAfter_Promocode = $combo_offer_detail->taxAbleAmount - $promoDiscount_Amount;
														$combo_offer_detail->amountAfter_Promocode = number_format($amountAfter_Promocode,2,".","");
														$combo_offer_detail->taxAbleAmount = number_format($amountAfter_Promocode,2,".","");
														$combo_offer_detail->gstPercentageAdd = $combo_offer_detail->gst_percentage + 100;
														$combo_offer_detail->total_GST = $combo_offer_detail->taxAbleAmount * $combo_offer_detail->gst_percentage / $combo_offer_detail->gstPercentageAdd; 
														$combo_offer_detail->total_GST_division = round($combo_offer_detail->total_GST / 2,2);
														$combo_offer_detail->total_GST = $combo_offer_detail->total_GST_division * 2;
														$combo_offer_detail->taxAbleAmount = $combo_offer_detail->taxAbleAmount-$combo_offer_detail->total_GST;
														$combo_offer_detail->total_with_GST = $combo_offer_detail->taxAbleAmount + $combo_offer_detail->total_GST; 
														$combo_offer_detail->total_GST = number_format($combo_offer_detail->total_GST,2,".","");
														$combo_offer_detail->total_with_GST = number_format($combo_offer_detail->total_with_GST,2,".","");
														$combo_offer_detail->isPromoValid = true;
														$PromoComboValid = true;
												}
												else if($promo_category_id == 0 && $promo_item_id == 0 && $discount_of_max_amount ==0){
														$promoCount++;
														$isPromoValidForAll = true;
														$isPromoValidForAllMsg = 'PromoCode Applied Successfully';
														$promoDiscount_Amount =  $combo_offer_detail->taxAbleAmount * $promotionDetails->discount_in_percentage / 100;
														$combo_offer_detail->promoDiscount_Percent = $promotionDetails->discount_in_percentage;
														$combo_offer_detail->promoDiscount_in_Amount = $promotionDetails->discount_in_amount;
														$combo_offer_detail->promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
														$promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
														$amountAfter_Promocode = $combo_offer_detail->taxAbleAmount - $promoDiscount_Amount;
														$combo_offer_detail->amountAfter_Promocode = number_format($amountAfter_Promocode,2,".","");
														$combo_offer_detail->taxAbleAmount = number_format($amountAfter_Promocode,2,".","");
														$combo_offer_detail->gstPercentageAdd = $combo_offer_detail->gst_percentage + 100;
														$combo_offer_detail->total_GST = $combo_offer_detail->taxAbleAmount * $combo_offer_detail->gst_percentage / $combo_offer_detail->gstPercentageAdd; 
														$combo_offer_detail->total_GST_division = round($combo_offer_detail->total_GST / 2,2);
														$combo_offer_detail->total_GST = $combo_offer_detail->total_GST_division * 2;
														$combo_offer_detail->taxAbleAmount = $combo_offer_detail->taxAbleAmount-$combo_offer_detail->total_GST;
														$combo_offer_detail->total_with_GST = $combo_offer_detail->taxAbleAmount + $combo_offer_detail->total_GST; 
														$combo_offer_detail->total_GST = number_format($combo_offer_detail->total_GST,2,".","");
														$combo_offer_detail->total_with_GST = number_format($combo_offer_detail->total_with_GST,2,".","");													
														$combo_offer_detail->isPromoValid = true;
														$PromoComboValid = true;
												}else{
														if($promoCount==0)
														{
															$isPromoValidForAll = false;
															$isPromoValidForAllMsg = 'Invalid PromoCode';
														}else
														{
															$isPromoValidForAll = true;
															$isPromoValidForAllMsg = 'PromoCode Applied Successfully';
														}
														$combo_offer_detail->promoDiscount_Percent = 0.00;
														$combo_offer_detail->promoDiscount_in_Amount = 0.00;
														$combo_offer_detail->promoDiscount_Amount = 0.00;
														$combo_offer_detail->amountAfter_Promocode = $combo_offer_detail->taxAbleAmount;
														$combo_offer_detail->taxAbleAmount = $combo_offer_detail->taxAbleAmount;
														$combo_offer_detail->gstPercentageAdd = $combo_offer_detail->gst_percentage + 100;
														$combo_offer_detail->total_GST = $combo_offer_detail->taxAbleAmount * $combo_offer_detail->gst_percentage / $combo_offer_detail->gstPercentageAdd; 
														$combo_offer_detail->total_GST_division = round($combo_offer_detail->total_GST / 2,2);
														$combo_offer_detail->total_GST = $combo_offer_detail->total_GST_division * 2;
														$combo_offer_detail->taxAbleAmount = $combo_offer_detail->taxAbleAmount-$combo_offer_detail->total_GST;
														$combo_offer_detail->total_with_GST = $combo_offer_detail->taxAbleAmount + $combo_offer_detail->total_GST; 
														$combo_offer_detail->total_GST = number_format($combo_offer_detail->total_GST,2,".","");
														$combo_offer_detail->total_with_GST = number_format($combo_offer_detail->total_with_GST,2,".","");													
														$combo_offer_detail->isPromoValid = false;
														$PromoComboValid = false;
												}
											}
										}
										$memberShipDiscount_Amount = $memberShipDiscount_Amount + $combo_offer_detail->memberShipDiscount_Amount;
										$promoTotal_Amount = $promoTotal_Amount + $combo_offer_detail->promoDiscount_Amount;
										$comboTotal_Amount = $comboTotal_Amount + $combo_offer_detail->taxAbleAmount;
										$combowith_GST_Amount = $combowith_GST_Amount + $combo_offer_detail->total_with_GST;										
									}
										$combo->memberShipDiscount_Amount = number_format($memberShipDiscount_Amount,2,".","");
										$combo->promoDiscount_Amount = number_format($promoTotal_Amount,2,".","");
										$combo->comboTotal_Amount = number_format($comboTotal_Amount,2,".","");
										$combo->combowith_GST_Amount = number_format($combowith_GST_Amount,2,".","");									
										$combo->PromoComboValid =  $PromoComboValid;
								}
							}
							
							if($cash_back > 0)
							{
								if($BothTaxableCmboItem >= $discount_of_max_amount){
									$isPromoValidForAll = true;
									$isPromoValidForAllMsg = 'PromoCode Applied Successfully';									
								}else{
									if($promoCount==0)
									{
										$isPromoValidForAll = false;
										$isPromoValidForAllMsg = 'Invalid PromoCode';
									}else
									{
										$isPromoValidForAll = true;
										$isPromoValidForAllMsg = 'PromoCode Applied Successfully';
									}
								}
							}															
								}else{

									if(!empty($carts_data))
									{
											foreach($carts_data as $cart_data)
											{
/* 												$item_id = $cart_data->item_variation->item->id;
												$cart_data->gst_percentage = $cart_data->item_variation->item->gst_figure->tax_percentage;
												$cate_id = $cart_data->item_variation->item->category_id;
												$cart_data->promoDiscount_Percent = 0.00;
												$cart_data->promoDiscount_in_Amount = 0.00;
												$cart_data->promoDiscount_Amount = 0.00;
												$cart_data->amountAfter_Promocode = $cart_data->taxAbleAmount;
												$cart_data->taxAbleAmount = $cart_data->taxAbleAmount;
												$cart_data->total_GST = $cart_data->taxAbleAmount * $cart_data->gst_percentage / 100; 
												$cart_data->total_with_GST = $cart_data->taxAbleAmount + $cart_data->total_GST;
												$cart_data->total_GST = number_format($cart_data->total_GST,2,".","");
												$cart_data->total_with_GST = number_format($cart_data->total_with_GST,2,".","");
												$cart_data->isPromoValid = false; */

												$item_id = $cart_data->item_variation->item->id;
												$cart_data->gst_percentage = $cart_data->item_variation->item->gst_figure->tax_percentage;
												$cate_id = $cart_data->item_variation->item->category_id;
												$cart_data->promoDiscount_Percent = 0.00;
												$cart_data->promoDiscount_in_Amount = 0.00;
												$cart_data->promoDiscount_Amount = 0.00;
												$cart_data->amountAfter_Promocode = $cart_data->taxAbleAmount;
												$cart_data->taxAbleAmount = $cart_data->taxAbleAmount;
												$cart_data->gstPercentageAdd = $cart_data->gst_percentage + 100;
												$cart_data->total_GST = $cart_data->taxAbleAmount * $cart_data->gst_percentage / $cart_data->gstPercentageAdd; 
												$cart_data->total_GST_division = round($cart_data->total_GST / 2,2);
												$cart_data->total_GST = $cart_data->total_GST_division * 2;
												$cart_data->taxAbleAmount = $cart_data->taxAbleAmount-$cart_data->total_GST;
												$cart_data->total_with_GST = $cart_data->taxAbleAmount + $cart_data->total_GST; 
												$cart_data->total_GST = number_format($cart_data->total_GST,2,".","");
												$cart_data->total_with_GST = number_format($cart_data->total_with_GST,2,".","");								
												$cart_data->isPromoValid = false;
											}
										}		
										if(!empty($comboData))
										{
											foreach($comboData as $combo)
											{
											$taxAbleAmount_Total = 0.00;
											$combowith_GST_Amount = 0.00;
											$comboTotal_Amount = 0.00;
											$memberShipDiscount_Amount = 0.00;
											$promoDiscount_Amount = 0.00;
											$promoTotal_Amount = 0.00;		
											foreach($combo->combo_offer->combo_offer_details as $combo_offer_detail)
												{
													$comboItemDetails = $this->Carts->ItemVariations->find()
													->contain(['Items'])
													->where(['ItemVariations.id' =>$combo_offer_detail->item_variation_id])
													->first();
													   $item_id = $comboItemDetails->item->id;
													   //$combo_offer_detail->gst_percentage = $combo_offer_detail->gst_percentage;
													   $cate_id = $comboItemDetails->item->category_id;
													
														/* $combo_offer_detail->promoDiscount_Percent = 0.00;
														$combo_offer_detail->promoDiscount_in_Amount = 0.00;
														$combo_offer_detail->promoDiscount_Amount = 0.00;
														$combo_offer_detail->amountAfter_Promocode = $combo_offer_detail->taxAbleAmount;
														$combo_offer_detail->taxAbleAmount = $combo_offer_detail->taxAbleAmount;
														$combo_offer_detail->total_GST = $combo_offer_detail->taxAbleAmount * $combo_offer_detail->gst_percentage / 100; 
														$combo_offer_detail->total_with_GST = $combo_offer_detail->taxAbleAmount + $combo_offer_detail->total_GST; 
														$combo_offer_detail->total_GST = number_format($combo_offer_detail->total_GST,2,".","");
														$combo_offer_detail->total_with_GST = number_format($combo_offer_detail->total_with_GST,2,".","");
														$combo_offer_detail->isPromoValid = false;
														 */
														
														$isPromoValidForAll = false;
														$isPromoValidForAllMsg = 'Invalid PromoCode';
														$combo_offer_detail->promoDiscount_Percent = 0.00;
														$combo_offer_detail->promoDiscount_in_Amount = 0.00;
														$combo_offer_detail->promoDiscount_Amount = 0.00;
														$combo_offer_detail->amountAfter_Promocode = $combo_offer_detail->taxAbleAmount;
														$combo_offer_detail->taxAbleAmount = $combo_offer_detail->taxAbleAmount;
														$combo_offer_detail->gstPercentageAdd = $combo_offer_detail->gst_percentage + 100;
														$combo_offer_detail->total_GST = $combo_offer_detail->taxAbleAmount * $combo_offer_detail->gst_percentage / $combo_offer_detail->gstPercentageAdd; 
														$combo_offer_detail->total_GST_division = round($combo_offer_detail->total_GST / 2,2);
														$combo_offer_detail->total_GST = $combo_offer_detail->total_GST_division * 2;
														$combo_offer_detail->taxAbleAmount = $combo_offer_detail->taxAbleAmount-$combo_offer_detail->total_GST;
														$combo_offer_detail->total_with_GST = $combo_offer_detail->taxAbleAmount + $combo_offer_detail->total_GST; 
														$combo_offer_detail->total_GST = number_format($combo_offer_detail->total_GST,2,".","");
														$combo_offer_detail->total_with_GST = number_format($combo_offer_detail->total_with_GST,2,".","");													
														$combo_offer_detail->isPromoValid = false;	
														$PromoComboValid = false;	
													
													$memberShipDiscount_Amount = $memberShipDiscount_Amount + $combo_offer_detail->memberShipDiscount_Amount;
													$promoTotal_Amount = $promoTotal_Amount + $combo_offer_detail->promoDiscount_Amount;
													$comboTotal_Amount = $comboTotal_Amount + $combo_offer_detail->taxAbleAmount;
													$combowith_GST_Amount = $combowith_GST_Amount + $combo_offer_detail->total_with_GST;
												}
												$combo->memberShipDiscount_Amount = number_format($memberShipDiscount_Amount,2,".","");
												$combo->promoDiscount_Amount = number_format($promoTotal_Amount,2,".","");
												$combo->comboTotal_Amount = number_format($comboTotal_Amount,2,".","");
												$combo->combowith_GST_Amount = number_format($combowith_GST_Amount,2,".","");
												$combo->PromoComboValid = $PromoComboValid;
											}
										}												
							}

								if(!empty($category)){
									foreach ($category as $key => $value) {
										$total_cat_wise = 0.00;			
										foreach($value as $arrData)
										{
											$total_cat_wise = number_format($total_cat_wise + $arrData->total_with_GST,2,".","");
										}
										$carts[] = ['category_name'=>$category_arr[$key],'total_cat_wise'=>$total_cat_wise,'category'=>$value];
									}
									
									if(empty($carts_data)){ $carts=[]; }								
								}
									$Combototal = 0.00;
									$Combototal_with_GST = 0.00;
									$Combo_Sub_Total = 0.00;
									$Combo_Promo_Total = 0.00;
									$Combo_memberShipTotal = 0.00;
									$combo_GST = 0.00;
								if(empty($comboData)) 
								{ 
									$comboData = []; 
								}
								else 
								{  
									foreach($comboData as $combo)
									{
										$Combo_Sub_Total = number_format($Combo_Sub_Total + $combo->comboTotal_Amount,2,".","");
										$Combototal = number_format($Combototal + $combo->comboTotal_Amount,2,".","");
										$Combototal_with_GST = number_format($Combototal_with_GST + $combo->combowith_GST_Amount,2,".","");
									
										foreach($combo->combo_offer->combo_offer_details as $combo_offer_detail)
										{
											$Combo_Promo_Total = number_format($Combo_Promo_Total + $combo_offer_detail->promoDiscount_Amount,2,".","");
											$Combo_memberShipTotal = number_format($Combo_memberShipTotal + $combo_offer_detail->memberShipDiscount_Amount,2,".","");
											$combo_GST = number_format($combo_GST + $combo_offer_detail->total_GST,2,".","");
										}
									
									}
								}
						$ItemWiseTotal_taxable = 0.00;
						$ItemWiseTotal_With_GST = 0.00;
						$Item_Sub_Total = 0.00;
						$Item_Promo_total = 0.00;
						$Item_MembershipDiscount = 0.00;
						$Item_Total_GST = 0.00;								
								if(empty($carts_data))
								{
									$carts_data = [];
								}else{

									foreach($carts_data as $cart_data)
									{
										$Item_Sub_Total = number_format($Item_Sub_Total + $cart_data->amount,2,".","");
										$Item_Promo_total = number_format($Item_Promo_total + $cart_data->promoDiscount_Amount,2,".","");
										$ItemWiseTotal_taxable = number_format($ItemWiseTotal_taxable + $cart_data->taxAbleAmount,2,".","");
										$ItemWiseTotal_With_GST = number_format($ItemWiseTotal_With_GST + $cart_data->total_with_GST,2,".","");										
										$Item_MembershipDiscount = number_format($Item_MembershipDiscount + $cart_data->memberShipDiscount_Amount,2,".","");
										$Item_Total_GST = number_format($Item_Total_GST + $cart_data->total_GST,2,".","");
									}
								}
								
								$PromoTotal = 0.00;
								$PromoTotal = number_format(round($Item_Promo_total + $Combo_Promo_Total),2,".","");
								
								$Sub_Total = 0.00;
								$Sub_Total = number_format($Item_Sub_Total + $Combo_Sub_Total,2,".","");
								$Sub_Total = number_format($Sub_Total - $PromoTotal,2,".","");
								$MembershipTotal = 0.00;
								$MembershipTotal = number_format($Item_MembershipDiscount + $Combo_memberShipTotal,2,".","");
								$Total_GST = 0.00;
								$Total_GST = number_format($Item_Total_GST + $combo_GST,2,".","");
								$payableAmount = number_format($payableAmount + $Combototal_with_GST + $ItemWiseTotal_With_GST,2,".","");
								
						$customers = $this->Carts->Customers->find()->where(['Customers.id'=>$customer_id])->first();
						$is_shipping_price = $customers->is_shipping_price;
						$shipping_price = $customers->shipping_price;
						
						
							if($promo_free_shipping == 'Yes')
							{
								$delivery_charge_amount = "free";
							}
							else if($is_shipping_price == 'Yes')
							{
								if($shipping_price == 0)
								{
									$delivery_charge_amount = "free";
								}else
								{
									 $delivery_charge_amount = "$shipping_price";
									 $payableAmount = number_format($payableAmount + $shipping_price,2,".","");									
								}
							}
							else
							{
								$delivery_charges=$this->Carts->DeliveryCharges->find()->where(['city_id'=>$city_id,'status'=>'Active']);

								if(!empty($delivery_charges->toArray()))
								{
									foreach($delivery_charges as $delivery_charge) {
											if($delivery_charge->amount >= $payableAmount)
											{
												 $delivery_charge_amount = "$delivery_charge->charge";
												 $payableAmount = number_format($payableAmount + $delivery_charge->charge,2,".","");
											}else
											{
												$delivery_charge_amount = "free";
											}
									}
								}										
							}								

								$p = $payableAmount;
								$q = round($payableAmount);
								$Round_off_amt = round(($p-$q),2);
								$payableAmount = number_format(round($payableAmount),2,".","");		
								$Customers = $this->Carts->Customers->get($customer_id, [
									  'contain' => ['Wallets'=>function($query) use($customer_id){
										  $totalInCase = $query->newExpr()
											  ->addCase(
												$query->newExpr()->add(['transaction_type' => 'Added']),
												$query->newExpr()->add(['add_amount']),
												'integer'
											  );
											  $totalOutCase = $query->newExpr()
											  ->addCase(
												$query->newExpr()->add(['transaction_type' => 'Deduct']),
												$query->newExpr()->add(['used_amount']),
												'integer'
											  );
											  return $query->select([
												'total_add_amount' => $query->func()->sum($totalInCase),
												'total_used_amount' => $query->func()->sum($totalOutCase),'id','customer_id'
											  ])
											  ->where(['Wallets.customer_id' => $customer_id])
											  ->group('customer_id')
											  ->autoFields(true); 
									    /* return $query->select([
									      'total_add_amount' => $query->func()->sum('add_amount'),
									      'total_used_amount' => $query->func()->sum('used_amount'),'customer_id',
									    ]); */
									  }]
									]);
									
								// pr($Customers->toArray());exit;	
								 
								$remainingWalletAmount = 0;
								if(empty($Customers->wallets))
								{
									$remaining_wallet_amount= 0;
								}
								else{
									foreach($Customers->wallets as $Customer_data_wallet){
										$wallet_total_add_amount = $Customer_data_wallet->total_add_amount;
										$wallet_total_used_amount = $Customer_data_wallet->total_used_amount;
										
										$remainingWalletAmount = $wallet_total_add_amount-$wallet_total_used_amount;
										
										
										$remaining_wallet_amount= number_format(round($remainingWalletAmount),2,".","");	
									}
								}

								$customer_addresses=$this->Carts->Customers->CustomerAddresses->find()
								->contain(['Cities'])
								->where(['city_id' =>$city_id])
								->where(['CustomerAddresses.customer_id' => $customer_id, 'CustomerAddresses.default_address'=>'1'])->first();													

			$order_no = '';
			$CityData = $this->Carts->Cities->get($city_id); 
			$StateData = $this->Carts->Cities->States->get($CityData->state_id);
        	$Voucher_no = $this->Carts->Orders->find()->select(['voucher_no'])->where(['Orders.city_id'=>$city_id])->order(['voucher_no' => 'DESC'])->first();
			if($Voucher_no){
				$voucher_no=$Voucher_no->voucher_no+1;
			}
			else
			{
				$voucher_no=1;
			}
			$order_no=$CityData->alise_name.'/'.$voucher_no;
			$order_no=$StateData->alias_name.'/'.$order_no;

			// Check for out of stock

			if(empty($carts_data) && empty($comboData))
			{
				$success = false;
				$message ='No data found';
			}else {
				$success = true;
				$message ='Data found';				
			}

	    
		$this->set(compact('success', 'message','order_no','isPromoValidForAll','isPromoValidForAllMsg','online_amount_limit','item_in_cart','OrderCancelLimit','CustomerOrderCount','customer_addresses','all_dates',
		'remaining_wallet_amount','delivery_charge_amount','promo_detail_id','holidays_date',
		'carts','ItemWiseTotal_taxable','ItemWiseTotal_With_GST','comboData','Combototal','Combototal_with_GST','TotalBeforeDiscount','Sub_Total','PromoTotal','MembershipTotal','Total_GST','Round_off_amt','payableAmount','deliveryString'));
	   
		$this->set('_serialize', ['success', 'message','order_no','isPromoValidForAll','isPromoValidForAllMsg','online_amount_limit','item_in_cart','OrderCancelLimit','CustomerOrderCount','customer_addresses','all_dates',
		'remaining_wallet_amount','delivery_charge_amount','promo_detail_id','holidays_date',
		'carts','ItemWiseTotal_taxable','ItemWiseTotal_With_GST','comboData','Combototal','Combototal_with_GST','TotalBeforeDiscount','Sub_Total','PromoTotal','MembershipTotal','Total_GST','Round_off_amt','payableAmount','deliveryString']);	  
	}
	
	
	public function removeOutOfStockItem()
	{
	$customer_id=$this->request->query('customer_id');
	$city_id=$this->request->query('city_id');
	$OutofStock_comboData =[]; $OutofStock_carts_data =[];
			$OutofStock_comboData = $this->Carts->find()			
			->where(['Carts.city_id' =>$city_id])
			->where(['Carts.customer_id' => $customer_id])
			->contain(['ComboOffers'=> function($q){ return $q->where(['out_of_stock'=>'Yes']);}])
			->group('Carts.combo_offer_id')->autoFields(true)->toArray();			

			$OutofStock_carts_data=$this->Carts->find()
			->where(['Carts.customer_id' => $customer_id])
			->where(['Carts.city_id' =>$city_id])
			->contain(['ItemVariations'=> function($q){
				return $q->where(['out_of_stock'=>'Yes','ItemVariations.ready_to_sale'=>'Yes','ItemVariations.status'=>'Active']);}])
			->group('Carts.item_variation_id')->autoFields(true)->toArray();		

		//pr($OutofStock_comboData);exit;
			
		if(!empty($OutofStock_comboData))
		{
			foreach($OutofStock_comboData as $CartCombo)
			{
			  $this->removeCartCombo($customer_id,$city_id,$CartCombo->combo_offer->id);
			}
		}

		if(!empty($OutofStock_carts_data))
		{
			foreach($OutofStock_carts_data as $Cartdata)
			{
				$this->removeCartCommon($customer_id,$city_id,$Cartdata->item_variation->id);
			}
		}

		$success = true;
		$message ='Successfully removed !';	
		$this->set(compact('success', 'message'));
		$this->set('_serialize', ['success', 'message']);					
	}
	
	
	
} ?>