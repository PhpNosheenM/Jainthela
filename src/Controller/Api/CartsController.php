<?php
namespace App\Controller\Api;
use Cake\Event\Event;
use Cake\Network\Exception\UnauthorizedException;
use Cake\Utility\Security;
use Firebase\JWT\JWT;


class CartsController extends AppController
{

	public function addToCartCombo($customer_id,$city_id,$combo_offer_id)
	{
		 // get combo Data
		 $comboData = $this->Carts->ComboOffers->get($combo_offer_id);
		 $sale_rate = $comboData->print_rate;
		 $quantity = $comboData->print_quantity;

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
		$item_add_quantity =  $unit_VariationData->convert_unit_qty;
		$item_add_unit_id = $unit_VariationData->unit_id;
		// check avaliable item in cart
		$checkCartData = $this->Carts->find()->where(['city_id'=>$city_id,'customer_id' => $customer_id, 'item_variation_id' =>$item_variation_id]);
		if(empty($checkCartData->toArray()))
		{
				$amount = $sale_rate * $item_add_quantity;
				$query = $this->Carts->query();
				$query->insert(['city_id','customer_id', 'item_variation_id','unit_id','quantity','rate','amount','cart_count'])
				->values(['city_id' =>$city_id,'customer_id' => $customer_id,'item_variation_id' => $item_variation_id,'unit_id' => $item_add_unit_id,
					'quantity' => $item_add_quantity,'rate' => $sale_rate,'amount' => $amount,'cart_count' => 1])->execute();
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
	 		 $sale_rate = $comboData->print_rate;
	 		 $quantity = $comboData->print_quantity;
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
			$item_add_quantity =  $unit_VariationData->convert_unit_qty;
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
				if(empty($current_item)) { $current_item = []; }
			}
			else{
				// removeCartCommon for code reuseabilty in both function removeFromCart and fetchCart
				$this->removeCartCommon($customer_id,$city_id,$item_variation_id);
				$current_item = $this->Carts->find()->where(['Carts.city_id'=>$city_id,'Carts.customer_id' => $customer_id, 'Carts.item_variation_id' =>$item_variation_id])->contain(['ItemVariations'=>['Items','ItemVariationMasters','UnitVariations'=>['Units']]])->first();
				if(empty($current_item)) { $current_item = []; }
			}
			$item_in_cart = $this->Carts->find('All')->where(['Carts.customer_id'=>$customer_id])->count();
			$success=true;
			$message="Item Remove Successfully";
			$this->set(compact('success','message','item_in_cart','current_item'));
			$this->set('_serialize',['success','message','item_in_cart','current_item']);
		}


		public function fetchCart()
		{
			$item_variation_id=$this->request->data('item_variation_id');
			$customer_id=$this->request->data('customer_id');
			$city_id=$this->request->data('city_id');
			$combo_offer_id = $this->request->data('combo_offer_id');
			$isCombo = $this->request->data('isCombo');

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

							if(!empty($categories->toArray()))
							{
								$comboData = $this->Carts->find()
									->where(['customer_id' => $customer_id])
									->contain(['ComboOffers'=>['ComboOfferDetails']])
									->group('Carts.combo_offer_id')->autoFields(true)->toArray();

								if(empty($comboData)) { $comboData = []; }

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
									foreach($carts_data as $cart_data)
									{
									  $grand_total1+=$cart_data->amount;
									}

									$grand_total=number_format(round($grand_total1), 2);
									$payableAmount = $payableAmount + $grand_total1;

									$delivery_charges=$this->Carts->DeliveryCharges->find()->where(['city_id'=>$city_id]);
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
							}

							if(empty($carts_data))
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
							  $this->set(compact('success', 'message','address_available','grand_total','delivery_charge_amount','payableAmount','remaining_wallet_amount','carts','item_in_cart','comboData'));
							  $this->set('_serialize', ['success', 'message','remaining_wallet_amount','grand_total','delivery_charge_amount', 'payableAmount','item_in_cart','address_available','carts','comboData']);
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
			$customer_id = $this->request->query('customer_id');
			$city_id = $this->request->query('city_id');
			$categories = $this->Carts->find()
			->where(['customer_id' => $customer_id])
			->contain(['ItemVariations'=>['ItemVariationMasters','Items'=>['Categories']]]);

			if(!empty($categories->toArray()))
			{
					$comboData = $this->Carts->find()
						->where(['customer_id' => $customer_id])
						->contain(['ComboOffers'=>['ComboOfferDetails']])
						->group('Carts.combo_offer_id')->autoFields(true)->toArray();

					if(empty($comboData)) { $comboData = []; }

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
//pr($category);exit;
					foreach ($category as $key => $value) {
							$carts[] = ['category_name'=>$category_arr[$key],'category'=>$value];
					}

					if(empty($carts_data))
					{ $carts=[]; }

					$payableAmount = number_format(0, 2);
					$grand_total1=0;
					foreach($carts_data as $cart_data)
					{
						$grand_total1+=$cart_data->amount;
					}

					$grand_total=number_format(round($grand_total1), 2);
					$payableAmount = $payableAmount + $grand_total1;

					$delivery_charges=$this->Carts->DeliveryCharges->find()->where(['city_id'=>$city_id]);
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


			}

			$delivery_dates = $this->Carts->DeliveryDates->find()->where(['city_id'=>$city_id]);
			$sameDay = 0;
			if(!empty($delivery_dates->toArray()))
			{
					foreach ($delivery_dates as $delivery_date) {
						if($delivery_date->same_day == 'Active')
						{
								$sameDay = $delivery_date->next_day;
						}else{
								$sameDay = $delivery_date->next_day;
						}
					}
			}
			$current_date = date('Y-m-d');
			date_default_timezone_set("Asia/Calcutta");
			$current_time =  strtotime(date('h:i a'));
			 $first_time = strtotime('10:00 am');
			 $last_time = strtotime('01:00 pm');
			 $first_time1 = strtotime('04:00 pm');
			 $last_time1 = strtotime('07:00 pm');
			if(($current_time >= $first_time) && ($current_time < $last_time) )
			{
				$where = ['DeliveryTimes.id !=' =>1];
			}
			else if(($current_time >= $last_time) && ($current_time < $first_time1) )
			{
				$where = ['DeliveryTimes.id' =>3];
			}
			else if(($current_time >= $first_time1) && ($current_time <= $last_time1) )
			{
				$where = ['DeliveryTimes.id !=' =>3];
			}
			else{
				$where ='';
			}
			//pr($where);exit;
			$delivery_time=$this->Carts->DeliveryTimes->find()
			->select(['delivery_time' => $this->Carts->DeliveryTimes->find()->func()->concat(['time_from' => 'identifier','-','time_to' => 'identifier' ])])
			->where($where)
			->autoFields(true);

			for($i=0;$i<=$sameDay;$i++)
			{
				$all_dates[$i] = ['date' =>date('d-m-Y', strtotime("+".$i." days")),'delivery_time'=>$delivery_time->toArray()];
			}

			$generate_order_no=uniqid();
			$customer_addresses=$this->Carts->Customers->CustomerAddresses->find()
			->contain(['Cities'])
			->where(['CustomerAddresses.customer_id' => $customer_id, 'CustomerAddresses.default_address'=>'1'])->first();

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
			$order_no = uniqid();
			$success = true;
			$message ='Data found';

	    $this->set(compact('success', 'message','order_no','remaining_wallet_amount','generate_order_no','grand_total','delivery_charge_amount','payableAmount','customer_addresses','all_dates','carts','comboData'));
	    $this->set('_serialize', ['success', 'message','order_no','remaining_wallet_amount','generate_order_no','grand_total','delivery_charge_amount','payableAmount','customer_addresses','all_dates','carts','comboData']);
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



}
