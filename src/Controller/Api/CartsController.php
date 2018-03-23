<?php
namespace App\Controller\Api;
use Cake\Event\Event;
use Cake\Network\Exception\UnauthorizedException;
use Cake\Utility\Security;
use Firebase\JWT\JWT;


class CartsController extends AppController
{
    public function plusAddToCart()
    {
        $customer_id=$this->request->data('customer_id');
        $city_id=$this->request->data('city_id');
    		$item_variation_id=$this->request->data('item_variation_id');
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
		$current_item = $this->Carts->find()->where(['Carts.city_id'=>$city_id,'Carts.customer_id' => $customer_id, 'Carts.item_variation_id' =>$item_variation_id])->contain(['ItemVariations'=>['Items','UnitVariations'=>['Units']]])->first(); 
		if(empty($current_item)) { $current_item = []; }	
       $item_in_cart = $this->Carts->find('All')->where(['Carts.customer_id'=>$customer_id])->count();
       $success=true;
       $message="Item Remove Successfully";
       $this->set(compact('success','message','item_in_cart','current_item'));
       $this->set('_serialize',['success','message','item_in_cart','current_item']);     
   }

}
