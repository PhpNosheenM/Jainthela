<?php
namespace App\Controller\Api;
use Cake\Event\Event;
use Cake\Network\Exception\UnauthorizedException;
use Cake\Utility\Security;
use Firebase\JWT\JWT;


class CartsController extends AppController
{

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
				->values([
					  'city_id' =>$city_id,
								'customer_id' => $customer_id,
								'item_variation_id' => $item_variation_id,
								'unit_id' => $item_add_unit_id,
								'quantity' => $item_add_quantity,
								'rate' => $sale_rate,
								'amount' => $amount,
								'cart_count' => 1
					])->execute();
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
		// addCartCommon for code reuseabilty in both function plusAddtoCart and fetchCart
		$this->addCartCommon($customer_id,$city_id,$item_variation_id);

		$current_item = $this->Carts->find()->where(['Carts.city_id'=>$city_id,'Carts.customer_id' => $customer_id, 'Carts.item_variation_id' =>$item_variation_id])->contain(['ItemVariations'=>['Items','UnitVariations'=>['Units']]])->first();
		if(empty($current_item)) { $current_item = []; }
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
	 // addCartCommon for code reuseabilty in both function removeFromCart and fetchCart
		$this->removeCartCommon($customer_id,$city_id,$item_variation_id);
	$current_item = $this->Carts->find()->where(['Carts.city_id'=>$city_id,'Carts.customer_id' => $customer_id, 'Carts.item_variation_id' =>$item_variation_id])->contain(['ItemVariations'=>['Items','UnitVariations'=>['Units']]])->first();
	  if(empty($current_item)) { $current_item = []; }
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
				$tag=$this->request->data('tag');

				if($tag=='add')
				{
					// addCartCommon for code reuseabilty in both function plusAddToCart and fetchCart
					$this->addCartCommon($customer_id,$city_id,$item_variation_id);
				}
				else if($tag=='minus')
				{
					// removeCartCommon for code reuseabilty in both function removeFromCart and fetchCart
					$this->removeCartCommon($customer_id,$city_id,$item_variation_id);
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


					$carts=$this->Carts->find()
						->where(['customer_id' => $customer_id])
						->contain(['ItemVariations'=>['Items','UnitVariations'=>['Units']]])
						->group('Carts.item_variation_id')->autoFields(true);

					if(empty($carts->toArray())){ $carts=[]; }
						$grand_total1=0;
						foreach($carts as $cart_data)
						{
							$grand_total1+=$cart_data->amount;
						}

						$grand_total=number_format(round($grand_total1), 2);


					$Customers = $this->Carts->Customers->get($customer_id, [
						'contain' => ['Wallets'=>function($query){
							return $query->select([
								'total_add_amount' => $query->func()->sum('add_amount'),
								'total_used_amount' => $query->func()->sum('used_amount'),'customer_id',
							]);
						},'Orders'=>function($query){
							return $query->select([
								'total_order' => $query->func()->count('customer_id'),'customer_id',
							]);
						}
							]
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

				$delivery_charges=$this->Carts->DeliveryCharges->find()->where(['city_id'=>$city_id]);

			 if(empty($carts))
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
					$this->set(compact('success', 'message','address_available','grand_total', 'remaining_wallet_amount', 'carts','item_in_cart','delivery_charges'));
					$this->set('_serialize', ['success', 'message','address_available','item_in_cart','grand_total', 'remaining_wallet_amount','carts','delivery_charges']);
	    }
	}

}
