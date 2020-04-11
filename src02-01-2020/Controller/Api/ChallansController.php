<?php
namespace App\Controller\Api;
use Cake\Event\Event;
use Cake\Network\Exception\UnauthorizedException;
use Cake\Utility\Security;
use Firebase\JWT\JWT;
use Cake\ORM\TableRegistry;

class ChallansController extends AppController
{
	public function initialize()
	{
		parent::initialize();
		$this->Auth->allow(['DriverOrderList','CustomerVerify','DriverOrderStatus','DriverChallanDetail','ItemWiseCancelOrder','CustomerItemWiseCancel','quntityUpdate','updateChallanStatus','groceryQuntityUpdate']);
	}	


	public function groceryQuntityUpdate()
	{

		$response = json_decode($this->request->data('response'));
		$promo_free_shipping = '';	
		
		$discount_amount = 0.00;
		$pay_amount = 0.00;
		$total_gst = 0.00;
		$total_GST = 0.00;			
		$total_amount = 0.00;
		$total_membershipDsicount = 0.00;
		$total_promoDiscount = 0.00;	
		$net_amount = 0.00;
		$amount = 0.00;	
		$taxAbleAmount_Total  = 0.00;

		//$response = $this->request->data('response');
		
		$city_id = $response->city_id;
		
		
		$this->Orders = TableRegistry::get('Orders');
		if(!empty($response))
		{	
			$city_id = $response->city_id;
			$originalQty = 0.00;
		
			
			foreach($response->challan_rows as $challanAsCategory)
			{
				foreach($challanAsCategory->category as $cateWiseData)
				{
					$update_quantity=$cateWiseData->quantity;
					$updateRows = $this->Challans->ChallanRows->query();
					$Updateamount = $update_quantity * $cateWiseData->rate;
					//pr($Updateamount); 
					$challanRowUpdate = $updateRows->update()
					->set(['item_variation_id' => $cateWiseData->item_variation_id,'amount' => $Updateamount,'quantity' => $update_quantity])
					->where(['id'=> $cateWiseData->id])->execute();

					$updateOrderRows = $this->Challans->Orders->OrderDetails->query();
					$orderRowUpdate = $updateOrderRows->update()
					->set(['item_variation_id' =>$cateWiseData->item_variation_id,'amount' => $Updateamount,'quantity' => $update_quantity])
					->where(['id'=> $cateWiseData->order_detail_id])->execute();
					//taxable_value					
				}
			}
			$order_id = $response->order_id;	
			$customer_id = $response->customer_id;	
			$isPromoCode = 'false';
			$promo_detail_id = $response->promotion_detail_id;	
			if(!empty($promo_detail_id) && $promo_detail_id != 0) 
			{ 
				$isPromoCode = 'true';				
			}		
			else { 
					$isPromoCode = 'false'; 
			}
			$OrderDetails = $this->Challans->Orders->find()->contain(['OrderDetails' =>function($q){
				return $q->where(['is_item_cancel' =>'No'])->contain(['Items']);
			}])->where(['id'=>$order_id])->first();

			$memberShipDiscount = $this->Challans->Customers->find()
			->select(['membership_discount'])
			->where(['Customers.id' => $customer_id])
			->where(['Customers.start_date <='=> date('Y-m-d'),'Customers.end_date >='=> date('Y-m-d')])
			->first();			

			if(!empty($OrderDetails))
			{				
				$taxAbleAmount_Total = 0.00;
				foreach($OrderDetails->order_details as $order_detail)
				{

					$amount = $order_detail->rate * $order_detail->quantity;
					$order_detail->amount = $amount;
					if(!empty($memberShipDiscount) && $memberShipDiscount->membership_discount > 0)
					{
						if($order_detail->item->is_discount_enable == 'Yes')
						{
							$memberShipDiscount_Amount = $amount * $memberShipDiscount->membership_discount/100;
							$order_detail->memberShipDiscount_Percent = $memberShipDiscount->membership_discount;
							$order_detail->memberShipDiscount_Amount = number_format($memberShipDiscount_Amount,2,".","");
							$memberShipDiscount_Amount = number_format($memberShipDiscount_Amount,2,".","");
							$amountAfter_Membership = $amount - $memberShipDiscount_Amount;
							$order_detail->amountAfter_Membership = number_format($amountAfter_Membership,2,".","");
							$order_detail->taxAbleAmount = number_format($amountAfter_Membership,2,".","");							
						}else{
						   $order_detail->memberShipDiscount_Percent = 0.00;
						   $order_detail->memberShipDiscount_Amount = 0.00;
						   $order_detail->amountAfter_Membership = $amount;
						   $order_detail->taxAbleAmount = number_format($amount,2,".","");								
					}
												
					}
					else{
						   $order_detail->memberShipDiscount_Percent = 0.00;
						   $order_detail->memberShipDiscount_Amount = 0.00;
						   $order_detail->amountAfter_Membership = $amount;
						   $order_detail->taxAbleAmount = number_format($amount,2,".","");								
					}
					$order_detail->discount_percent = $order_detail->memberShipDiscount_Percent;
					$order_detail->discount_amount = $order_detail->memberShipDiscount_Amount;


				   if($isPromoCode == 'true'){
					$promotionDetails = $this->Orders->Carts->Promotions->PromotionDetails->find()
							->where(['id' =>$promo_detail_id])->first();
							$item_id = $order_detail->item_id;
							
							$categories = $this->Orders->OrderDetails->Items->find()->select(['category_id'])
							->where(['id'=>$item_id])->first();
							
							$cate_id = $categories->category_id;
							$promo_item_id = $promotionDetails->item_id;
							$promo_category_id = $promotionDetails->category_id;
							$promo_free_shipping = $promotionDetails->is_free_shipping;
							$payableAmount = number_format(0, 2);
							$promo_amount = 0.00;	
							$discount_in_percentage = $promotionDetails->discount_in_percentage;
							$discount_of_max_amount = $promotionDetails->discount_of_max_amount;
							$cash_back = $promotionDetails->cash_back;
							
							
								if(!empty($promo_item_id) && $promo_item_id > 0)
									{
									  if($item_id == $promo_item_id)
										{				
											if($order_detail->item->is_discount_enable == 'Yes')
											{
												$taxAbleAmount_Total = $taxAbleAmount_Total + $order_detail->amount - $order_detail->discount_amount;
											}
										}		
									} else if(!empty($promo_category_id) && $promo_category_id > 0 && $promo_item_id == 0)
									{
										
										if($cate_id == $promo_category_id)
										{
											if($order_detail->item->is_discount_enable == 'Yes')
											{  
												$taxAbleAmount_Total = $taxAbleAmount_Total + $order_detail->amount - $order_detail->discount_amount;
											}
										}											
									}else {
										if($order_detail->item->is_discount_enable == 'Yes')
										{
											$taxAbleAmount_Total = $taxAbleAmount_Total + $order_detail->amount - $order_detail->discount_amount;
										}
									}
				   }					
				}
				//echo 'taxAbleAmount_Total  '.$taxAbleAmount_Total.'<br>'; exit;
				foreach($OrderDetails->order_details as $order_detail)
				{
					$amount = $order_detail->rate * $order_detail->quantity;
					$order_detail->amount = $amount;
						if($isPromoCode == 'true')
						{
							$promotionDetails = $this->Orders->Carts->Promotions->PromotionDetails->find()
							->where(['id' =>$promo_detail_id])->first();
							$item_id = $order_detail->item_id;
							
							$categories = $this->Orders->OrderDetails->Items->find()->select(['category_id'])
							->where(['id'=>$item_id])->first();
							
							$cate_id = $categories->category_id;
							$promo_item_id = $promotionDetails->item_id;
							$promo_category_id = $promotionDetails->category_id;
							$promo_free_shipping = $promotionDetails->is_free_shipping;
							$payableAmount = number_format(0, 2);
							$promo_amount = 0.00;	
							$discount_in_percentage = $promotionDetails->discount_in_percentage;
							$discount_of_max_amount = $promotionDetails->discount_of_max_amount;
							$cash_back = $promotionDetails->cash_back;
							
							if($order_detail->item->is_discount_enable == 'Yes')
							{
								if($cash_back == 0){
									if($discount_in_percentage == 0)
									{
										if($promo_category_id > 0 && $promo_category_id == $cate_id && $promo_item_id == 0 && $discount_of_max_amount ==0)
										{
											$promoDiscount_Amount =  $order_detail->taxAbleAmount / $taxAbleAmount_Total * $promotionDetails->discount_in_amount;
											$order_detail->promoDiscount_Percent = $promotionDetails->discount_in_percentage;
											$order_detail->promoDiscount_in_Amount = $promotionDetails->discount_in_amount;
											$order_detail->promoDiscount_Amount =  number_format($promoDiscount_Amount,2,".",""); 
											$promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
											$amountAfter_Promocode = $order_detail->taxAbleAmount - $promoDiscount_Amount;
											$order_detail->amountAfter_Promocode = number_format($amountAfter_Promocode,2,".","");
											$order_detail->taxAbleAmount = number_format($amountAfter_Promocode,2,".","");										
										}
										else if($promo_item_id > 0  && $promo_item_id == $item_id && $discount_of_max_amount == 0){
											$promoDiscount_Amount =  $order_detail->taxAbleAmount / $taxAbleAmount_Total * $promotionDetails->discount_in_amount;
											$order_detail->promoDiscount_Percent = $promotionDetails->discount_in_percentage;
											$order_detail->promoDiscount_in_Amount = $promotionDetails->discount_in_amount;
											$order_detail->promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
											$promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
											$amountAfter_Promocode = $order_detail->taxAbleAmount - $promoDiscount_Amount;
											$order_detail->amountAfter_Promocode = number_format($amountAfter_Promocode,2,".","");
											$order_detail->taxAbleAmount = number_format($amountAfter_Promocode,2,".","");																				
										}
										else if($discount_of_max_amount > 0 && $BothTaxableCmboItem >= $discount_of_max_amount && $promo_item_id == 0 && $promo_category_id ==0){
											$promoDiscount_Amount =  $order_detail->taxAbleAmount / $taxAbleAmount_Total * $promotionDetails->discount_in_amount;
											$order_detail->promoDiscount_Percent = $promotionDetails->discount_in_percentage;
											$order_detail->promoDiscount_in_Amount = $promotionDetails->discount_in_amount;
											$order_detail->promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
											$promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
											$amountAfter_Promocode = $order_detail->taxAbleAmount - $promoDiscount_Amount;
											$order_detail->amountAfter_Promocode = number_format($amountAfter_Promocode,2,".","");
											$order_detail->taxAbleAmount = number_format($amountAfter_Promocode,2,".","");																				
										}
										else if($promo_category_id == 0 && $promo_item_id == 0 && $discount_of_max_amount ==0){
										
											$promoDiscount_Amount =  $order_detail->taxAbleAmount / $taxAbleAmount_Total * $promotionDetails->discount_in_amount;
											$order_detail->promoDiscount_Percent = $promotionDetails->discount_in_percentage;
											$order_detail->promoDiscount_in_Amount = $promotionDetails->discount_in_amount;
											$order_detail->promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
											$promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
											$amountAfter_Promocode = $order_detail->taxAbleAmount - $promoDiscount_Amount;
											$order_detail->amountAfter_Promocode = number_format($amountAfter_Promocode,2,".","");
											$order_detail->taxAbleAmount = number_format($amountAfter_Promocode,2,".","");																															
										}else{
											$order_detail->promoDiscount_Percent = 0.00;
											$order_detail->promoDiscount_in_Amount = 0.00;
											$order_detail->promoDiscount_Amount = 0.00;
											$order_detail->amountAfter_Promocode = $order_detail->taxAbleAmount;
											$order_detail->taxAbleAmount = $order_detail->taxAbleAmount;										
										}
									}else{
										if($promo_category_id > 0 && $promo_category_id == $cate_id && $promo_item_id == 0 && $discount_of_max_amount ==0)
										{
											$promoDiscount_Amount =  $order_detail->taxAbleAmount * $promotionDetails->discount_in_percentage / 100;
											$order_detail->promoDiscount_Percent = $promotionDetails->discount_in_percentage;
											$order_detail->promoDiscount_in_Amount = $promotionDetails->discount_in_amount;
											$order_detail->promoDiscount_Amount =  number_format($promoDiscount_Amount,2,".",""); 
											$promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
											$amountAfter_Promocode = $order_detail->taxAbleAmount - $promoDiscount_Amount;
											$order_detail->amountAfter_Promocode = number_format($amountAfter_Promocode,2,".","");
											$order_detail->taxAbleAmount = number_format($amountAfter_Promocode,2,".","");																						
										}
										else if($promo_item_id > 0  && $promo_item_id == $item_id && $discount_of_max_amount == 0){
											$promoDiscount_Amount =  $order_detail->taxAbleAmount * $promotionDetails->discount_in_percentage / 100;
											$order_detail->promoDiscount_Percent = $promotionDetails->discount_in_percentage;
											$order_detail->promoDiscount_in_Amount = $promotionDetails->discount_in_amount;
											$order_detail->promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
											$promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
											$amountAfter_Promocode = $order_detail->taxAbleAmount - $promoDiscount_Amount;
											$order_detail->amountAfter_Promocode = number_format($amountAfter_Promocode,2,".","");
											$order_detail->taxAbleAmount = number_format($amountAfter_Promocode,2,".","");																	
										}
										else if($discount_of_max_amount > 0 && $BothTaxableCmboItem >= $discount_of_max_amount && $promo_item_id == 0 && $promo_category_id ==0){
											$promoDiscount_Amount =  $order_detail->taxAbleAmount * $promotionDetails->discount_in_percentage / 100;
											$order_detail->promoDiscount_Percent = $promotionDetails->discount_in_percentage;
											$order_detail->promoDiscount_in_Amount = $promotionDetails->discount_in_amount;
											$order_detail->promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
											$promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
											$amountAfter_Promocode = $order_detail->taxAbleAmount - $promoDiscount_Amount;
											$order_detail->amountAfter_Promocode = number_format($amountAfter_Promocode,2,".","");
											$order_detail->taxAbleAmount = number_format($amountAfter_Promocode,2,".","");											
										}
										else if($promo_category_id == 0 && $promo_item_id == 0 && $discount_of_max_amount ==0){
											$promoDiscount_Amount =  $order_detail->taxAbleAmount * $promotionDetails->discount_in_percentage / 100;
											$order_detail->promoDiscount_Percent = $promotionDetails->discount_in_percentage;
											$order_detail->promoDiscount_in_Amount = $promotionDetails->discount_in_amount;
											$order_detail->promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
											$promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
											$amountAfter_Promocode = $order_detail->taxAbleAmount - $promoDiscount_Amount;
											$order_detail->amountAfter_Promocode = number_format($amountAfter_Promocode,2,".","");
											$order_detail->taxAbleAmount = number_format($amountAfter_Promocode,2,".","");															
										}else{
											$order_detail->promoDiscount_Percent = 0.00;
											$order_detail->promoDiscount_in_Amount = 0.00;
											$order_detail->promoDiscount_Amount = 0.00;
											$order_detail->amountAfter_Promocode = $order_detail->taxAbleAmount;
											$order_detail->taxAbleAmount = $order_detail->taxAbleAmount;																			
										}
									}
								}								
							}else {
									$order_detail->promoDiscount_Percent = 0.00;
									$order_detail->promoDiscount_in_Amount = 0.00;
									$order_detail->promoDiscount_Amount = 0.00;
									$order_detail->amountAfter_Promocode = $order_detail->taxAbleAmount;
									$order_detail->taxAbleAmount = $order_detail->taxAbleAmount;
							}
						}else{
								$order_detail->promoDiscount_Percent = 0.00;
								$order_detail->promoDiscount_in_Amount = 0.00;
								$order_detail->promoDiscount_Amount = 0.00;
								$order_detail->amountAfter_Promocode = $order_detail->taxAbleAmount;
								$order_detail->taxAbleAmount = $order_detail->taxAbleAmount;
							}

						$order_detail->promo_percent=$order_detail->promoDiscount_Percent;
						$order_detail->promo_amount=$order_detail->promoDiscount_Amount;						
						
						

						$order_detail->total_GST = $order_detail->taxAbleAmount * $order_detail->gst_percentage / 100; 
						$order_detail->total_GST_division = round($order_detail->total_GST / 2,2);
						$order_detail->total_GST = $order_detail->total_GST_division * 2;
						$order_detail->taxAbleAmount = $order_detail->taxAbleAmount-$order_detail->total_GST;	
						$order_detail->total_with_GST = $order_detail->taxAbleAmount + $order_detail->total_GST; 
						$order_detail->total_GST = number_format($order_detail->total_GST,2,".","");
						$order_detail->total_with_GST = number_format($order_detail->total_with_GST,2,".","");
						$order_detail->taxable_value =$order_detail->taxAbleAmount;
						$order_detail->gst_percentage = $order_detail->gst_percentage;
						$order_detail->gst_value=$order_detail->total_GST;
						$order_detail->net_amount=$order_detail->total_with_GST;		

						$query = $this->Challans->Orders->OrderDetails->query();
						$query->update()
						->set(['amount'=>$amount,'discount_percent' => $order_detail->discount_percent,'discount_amount' => $order_detail->discount_amount,
						'promo_percent' => $order_detail->promo_percent,'promo_amount' => $order_detail->promo_amount,'taxable_value' => $order_detail->taxable_value,
						'gst_percentage'=> $order_detail->gst_percentage,'gst_value'=>$order_detail->gst_value,'net_amount'=>$order_detail->net_amount])
						->where(['id'=>$order_detail->id])->execute();						
				}

				foreach($OrderDetails->order_details as $order_detail)
				{
					if($order_detail->is_item_cancel == 'No')
					{
						
						$total_amount = $total_amount + $order_detail->taxAbleAmount;
						$total_membershipDsicount = $total_membershipDsicount + $order_detail->discount_amount;
						$total_promoDiscount = $total_promoDiscount + $order_detail->promo_amount;
						$total_GST = $total_GST + $order_detail->total_GST;
					}
				}
				
/* 				$delivery_charge_amount=$OrderDetails->delivery_charge_amount;
				$total_delivery_charge_amount=0;
				if($delivery_charge_amount=="free"){
					$total_delivery_charge_amount=0;
				}else{
					$total_delivery_charge_amount=$delivery_charge_amount;
				} */

				//$OrderDetails->total_amount = $total_amount;
				$discount_amount=$total_membershipDsicount + $total_promoDiscount;			
				//$OrderDetails->total_gst = $total_GST;
				$pay_amount	= $pay_amount + $total_amount + $total_GST;
				//echo $pay_amount;exit;

						$customers = $this->Orders->Customers->find()->where(['Customers.id'=>$customer_id])->first();
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
									$delivery_charges=$this->Orders->DeliveryCharges->find()->where(['city_id'=>$city_id,'status'=>'Active'])->first();
									if($delivery_charge->amount >= $pay_amount)
									{
									 $delivery_charge_amount = "$shipping_price";
									$pay_amount = number_format($pay_amount + $shipping_price,2,".","");									
									}else{
										$delivery_charge_amount = "free";
									}
								}
							}
							else
							{		
								$delivery_charges=$this->Orders->DeliveryCharges->find()->where(['city_id'=>$city_id,'status'=>'Active']);

								if(!empty($delivery_charges->toArray()))
								{		
									foreach($delivery_charges as $delivery_charge) {
											if($delivery_charge->amount >= $pay_amount)
											{		
												 $delivery_charge_amount = "$delivery_charge->charge";
												 $pay_amount = number_format($pay_amount + $delivery_charge->charge,2,".","");
												 
											}else
											{		
												$delivery_charge_amount = "free";
											}
									}
								}										
							}

				
				if($delivery_charge_amount == "free"){
					$query = $this->Challans->query();
					$query->update()
					->set(['delivery_charge_amount'=>0])
					->where(['Challans.order_id'=>$OrderDetails->id])->execute();		
				}
				
				$p=$pay_amount;
				$q=round($pay_amount);
				$Round_off_amt=round(($q-$p),2);
				$grand_total = $pay_amount;
				$pay_amount=round($pay_amount);	
				
				$query = $this->Orders->query();
				$query->update()
				->set(['total_amount'=>$total_amount,'discount_amount'=>$discount_amount,'grand_total'=>$grand_total,'round_off'=>$Round_off_amt,'total_gst' =>$total_GST,'pay_amount' =>$pay_amount,'delivery_charge_amount'=>$delivery_charge_amount])
				->where(['id'=>$OrderDetails->id])->execute();				
				$status = '';
				$this->UpdateOrderChallan->QuntityChallanOrderUpdate($OrderDetails->id,$status);

				$message='Quantity update Successfully';
        		$success=true;				
				
			}
			else
			{
				$message='Something went wrong !';
        		$success=false;
			}
			
			/* $challanAmount = $this->Challans->query();
			$challanAmountUpdate = $challanAmount->update()
			->set(['old_pay_amount' => $response->pay_amount])
			->where(['id'=> $response->id])->execute();	 */
			
			
		}			
		else
		{
			$message='Something went wrong !';
			$success=false;
		}

      $this->set(compact('success','message'));
      $this->set('_serialize', ['success','message']);		
		
			
	}

	
		
	public function quntityUpdate()
	{
		$response = json_decode($this->request->data('response'));
		$promo_free_shipping = '';	
		
		$discount_amount = 0.00;
		$pay_amount = 0.00;
		$total_gst = 0.00;
		$total_GST = 0.00;			
		$total_amount = 0.00;
		$total_membershipDsicount = 0.00;
		$total_promoDiscount = 0.00;	
		$net_amount = 0.00;
		$amount = 0.00;	
		$taxAbleAmount_Total  = 0.00;

		//$response = $this->request->data('response');
		
		$city_id = $response->city_id;
		
		
		$this->Orders = TableRegistry::get('Orders');
		if(!empty($response))
		{	
			$city_id = $response->city_id;
			$originalQty = 0.00;
		
			
			foreach($response->challan_rows as $challanAsCategory)
			{
				foreach($challanAsCategory->category as $cateWiseData)
				{   
					if($cateWiseData->item_variation->unit_variation->unit_id==313 || $cateWiseData->item_variation->unit_variation->unit_id==1){
					//$updateQty=$cateWiseData->quantity;
					$updateQty=(round($cateWiseData->quantity,2));
					$UnitVarData=$this->Challans->ChallanRows->ItemVariations->UnitVariations->find()->where(['unit_id'=>1,'quantity_variation'=>$updateQty])->first();
					if(empty($UnitVarData)){
						$unitVariation=$this->Challans->ChallanRows->ItemVariations->UnitVariations->newEntity();
						$unitVariation->unit_id=1;
						$unitVariation->city_id=$city_id;
						$unitVariation->quantity_variation=$updateQty;
						$unitVariation->convert_unit_qty=$updateQty;
						$unitVariation->created_by=1;
						$unitVariation->status='Deactive';
						$unitVariation->add_from='App';
						$unitVariation->visible_variation=$updateQty.' Kg'; 
						$UnitVariationDt=$this->Challans->ChallanRows->ItemVariations->UnitVariations->save($unitVariation);
						$NewUnitVarId=$UnitVariationDt->id;
						
					}else{
						$NewUnitVarId=$UnitVarData->id;
					}
					$ItemVariationData=$this->Challans->ChallanRows->ItemVariations->find()->where(['item_id'=>$cateWiseData->item_id,'unit_variation_id'=>$NewUnitVarId])->first();
					
					if(empty($ItemVariationData)){
						$ItemVariationMasters=$this->Challans->ChallanRows->Items->ItemVariationMasters->newEntity();
						$ItemVariationMasters->item_id=$cateWiseData->item_id;
						$ItemVariationMasters->unit_variation_id=$NewUnitVarId;
						$ItemVariationMasters->created_by=1;
						$ItemVariationMasters->status='Deactive';
						$ItemVariationMasters->add_from='App';
						$ItemVariationMasterDt=$this->Challans->ChallanRows->Items->ItemVariationMasters->save($ItemVariationMasters);
						$NewItemVariationMasterId=$ItemVariationMasterDt->id;
						
						$SellerItem=$this->Challans->ChallanRows->ItemVariations->find()->where(['item_id'=>$cateWiseData->item_id])->first();
						//
						$ItemVariations=$this->Challans->ChallanRows->ItemVariations->newEntity();
						$ItemVariations->item_id=$cateWiseData->item_id;
						$ItemVariations->unit_variation_id=$NewUnitVarId;
						$ItemVariations->city_id=$city_id;
						$ItemVariations->seller_id=3;
						$ItemVariations->seller_item_id=$SellerItem->seller_item_id;
						$ItemVariations->current_stock=0;
						$ItemVariations->virtual_stock=0;
						$ItemVariations->demand_stock=0;
						$ItemVariations->item_variation_master_id=$NewItemVariationMasterId;
						$ItemVariations->out_of_stock='Yes';
						$ItemVariations->ready_to_sale='No';
						$ItemVariations->status='Deactive'; 
						$ItemVariations->add_from='App'; 
						$ItemVariationDt=$this->Challans->ChallanRows->ItemVariations->save($ItemVariations);
						$NewItemVariationDataId=$ItemVariationDt->id;
						
						
					}else{
						$NewItemVariationDataId=$ItemVariationData->id;
					}
					
					$ChallanRow=$this->Challans->ChallanRows->get($cateWiseData->id,['contain'=>['ItemVariations'=>['UnitVariations']]]);
					
					$originalQty = $ChallanRow->item_variation->unit_variation->convert_unit_qty;
					
					$updateRows = $this->Challans->ChallanRows->query();
					$Updateamount = $updateQty/$originalQty * $ChallanRow->rate;
					//pr($Updateamount); 
					$challanRowUpdate = $updateRows->update()
					->set(['item_variation_id' => $NewItemVariationDataId,'rate' => $Updateamount,'amount' => $Updateamount,'quantity' => 1])
					->where(['id'=> $cateWiseData->id])->execute();

					$updateOrderRows = $this->Challans->Orders->OrderDetails->query();
					$orderRowUpdate = $updateOrderRows->update()
					->set(['item_variation_id' => $NewItemVariationDataId,'rate' => $Updateamount,'amount' => $Updateamount,'quantity' => 1])
					->where(['id'=> $cateWiseData->order_detail_id])->execute(); 
				}else{
					$update_quantity=$cateWiseData->quantity;
					$updateRows = $this->Challans->ChallanRows->query();
					$Updateamount = $update_quantity * $cateWiseData->rate;
					//pr($Updateamount); 
					$challanRowUpdate = $updateRows->update()
					->set(['item_variation_id' => $cateWiseData->item_variation_id,'amount' => $Updateamount,'quantity' => $update_quantity])
					->where(['id'=> $cateWiseData->id])->execute();

					$updateOrderRows = $this->Challans->Orders->OrderDetails->query();
					$orderRowUpdate = $updateOrderRows->update()
					->set(['item_variation_id' =>$cateWiseData->item_variation_id,'amount' => $Updateamount,'quantity' => $update_quantity])
					->where(['id'=> $cateWiseData->order_detail_id])->execute();
					//taxable_value
				}
					
				}
			}
			$order_id = $response->order_id;	
			$customer_id = $response->customer_id;	
			$isPromoCode = 'false';
			$promo_detail_id = $response->promotion_detail_id;	
			if(!empty($promo_detail_id) && $promo_detail_id != 0) 
			{ 
				$isPromoCode = 'true';				
			}		
			else { 
					$isPromoCode = 'false'; 
			}
			$OrderDetails = $this->Challans->Orders->find()->contain(['OrderDetails' =>function($q){
				return $q->where(['is_item_cancel' =>'No'])->contain(['Items']);
			}])->where(['id'=>$order_id])->first();

			$memberShipDiscount = $this->Challans->Customers->find()
			->select(['membership_discount'])
			->where(['Customers.id' => $customer_id])
			->where(['Customers.start_date <='=> date('Y-m-d'),'Customers.end_date >='=> date('Y-m-d')])
			->first();			

			if(!empty($OrderDetails))
			{				
				$taxAbleAmount_Total = 0.00;
				foreach($OrderDetails->order_details as $order_detail)
				{

					$amount = $order_detail->rate * $order_detail->quantity;
					$order_detail->amount = $amount;
					if(!empty($memberShipDiscount) && $memberShipDiscount->membership_discount > 0)
					{
						if($order_detail->item->is_discount_enable == 'Yes')
						{
							$memberShipDiscount_Amount = $amount * $memberShipDiscount->membership_discount/100;
							$order_detail->memberShipDiscount_Percent = $memberShipDiscount->membership_discount;
							$order_detail->memberShipDiscount_Amount = number_format($memberShipDiscount_Amount,2,".","");
							$memberShipDiscount_Amount = number_format($memberShipDiscount_Amount,2,".","");
							$amountAfter_Membership = $amount - $memberShipDiscount_Amount;
							$order_detail->amountAfter_Membership = number_format($amountAfter_Membership,2,".","");
							$order_detail->taxAbleAmount = number_format($amountAfter_Membership,2,".","");							
						}else{
						   $order_detail->memberShipDiscount_Percent = 0.00;
						   $order_detail->memberShipDiscount_Amount = 0.00;
						   $order_detail->amountAfter_Membership = $amount;
						   $order_detail->taxAbleAmount = number_format($amount,2,".","");								
					}
												
					}
					else{
						   $order_detail->memberShipDiscount_Percent = 0.00;
						   $order_detail->memberShipDiscount_Amount = 0.00;
						   $order_detail->amountAfter_Membership = $amount;
						   $order_detail->taxAbleAmount = number_format($amount,2,".","");								
					}
					$order_detail->discount_percent = $order_detail->memberShipDiscount_Percent;
					$order_detail->discount_amount = $order_detail->memberShipDiscount_Amount;


				   if($isPromoCode == 'true'){
					$promotionDetails = $this->Orders->Carts->Promotions->PromotionDetails->find()
							->where(['id' =>$promo_detail_id])->first();
							$item_id = $order_detail->item_id;
							
							$categories = $this->Orders->OrderDetails->Items->find()->select(['category_id'])
							->where(['id'=>$item_id])->first();
							
							$cate_id = $categories->category_id;
							$promo_item_id = $promotionDetails->item_id;
							$promo_category_id = $promotionDetails->category_id;
							$promo_free_shipping = $promotionDetails->is_free_shipping;
							$payableAmount = number_format(0, 2);
							$promo_amount = 0.00;	
							$discount_in_percentage = $promotionDetails->discount_in_percentage;
							$discount_of_max_amount = $promotionDetails->discount_of_max_amount;
							$cash_back = $promotionDetails->cash_back;
							
							
								if(!empty($promo_item_id) && $promo_item_id > 0)
									{
									  if($item_id == $promo_item_id)
										{				
											if($order_detail->item->is_discount_enable == 'Yes')
											{
												$taxAbleAmount_Total = $taxAbleAmount_Total + $order_detail->amount - $order_detail->discount_amount;
											}
										}		
									} else if(!empty($promo_category_id) && $promo_category_id > 0 && $promo_item_id == 0)
									{
										
										if($cate_id == $promo_category_id)
										{
											if($order_detail->item->is_discount_enable == 'Yes')
											{  
												$taxAbleAmount_Total = $taxAbleAmount_Total + $order_detail->amount - $order_detail->discount_amount;
											}
										}											
									}else {
										if($order_detail->item->is_discount_enable == 'Yes')
										{
											$taxAbleAmount_Total = $taxAbleAmount_Total + $order_detail->amount - $order_detail->discount_amount;
										}
									}
				   }					
				}
				//echo 'taxAbleAmount_Total  '.$taxAbleAmount_Total.'<br>'; exit;
				foreach($OrderDetails->order_details as $order_detail)
				{
					$amount = $order_detail->rate * $order_detail->quantity;
					$order_detail->amount = $amount;
						if($isPromoCode == 'true')
						{
							$promotionDetails = $this->Orders->Carts->Promotions->PromotionDetails->find()
							->where(['id' =>$promo_detail_id])->first();
							$item_id = $order_detail->item_id;
							
							$categories = $this->Orders->OrderDetails->Items->find()->select(['category_id'])
							->where(['id'=>$item_id])->first();
							
							$cate_id = $categories->category_id;
							$promo_item_id = $promotionDetails->item_id;
							$promo_category_id = $promotionDetails->category_id;
							$promo_free_shipping = $promotionDetails->is_free_shipping;
							$payableAmount = number_format(0, 2);
							$promo_amount = 0.00;	
							$discount_in_percentage = $promotionDetails->discount_in_percentage;
							$discount_of_max_amount = $promotionDetails->discount_of_max_amount;
							$cash_back = $promotionDetails->cash_back;
							
							if($order_detail->item->is_discount_enable == 'Yes')
							{
								if($cash_back == 0){
									if($discount_in_percentage == 0)
									{
										if($promo_category_id > 0 && $promo_category_id == $cate_id && $promo_item_id == 0 && $discount_of_max_amount ==0)
										{
											$promoDiscount_Amount =  $order_detail->taxAbleAmount / $taxAbleAmount_Total * $promotionDetails->discount_in_amount;
											$order_detail->promoDiscount_Percent = $promotionDetails->discount_in_percentage;
											$order_detail->promoDiscount_in_Amount = $promotionDetails->discount_in_amount;
											$order_detail->promoDiscount_Amount =  number_format($promoDiscount_Amount,2,".",""); 
											$promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
											$amountAfter_Promocode = $order_detail->taxAbleAmount - $promoDiscount_Amount;
											$order_detail->amountAfter_Promocode = number_format($amountAfter_Promocode,2,".","");
											$order_detail->taxAbleAmount = number_format($amountAfter_Promocode,2,".","");										
										}
										else if($promo_item_id > 0  && $promo_item_id == $item_id && $discount_of_max_amount == 0){
											$promoDiscount_Amount =  $order_detail->taxAbleAmount / $taxAbleAmount_Total * $promotionDetails->discount_in_amount;
											$order_detail->promoDiscount_Percent = $promotionDetails->discount_in_percentage;
											$order_detail->promoDiscount_in_Amount = $promotionDetails->discount_in_amount;
											$order_detail->promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
											$promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
											$amountAfter_Promocode = $order_detail->taxAbleAmount - $promoDiscount_Amount;
											$order_detail->amountAfter_Promocode = number_format($amountAfter_Promocode,2,".","");
											$order_detail->taxAbleAmount = number_format($amountAfter_Promocode,2,".","");																				
										}
										else if($discount_of_max_amount > 0 && $BothTaxableCmboItem >= $discount_of_max_amount && $promo_item_id == 0 && $promo_category_id ==0){
											$promoDiscount_Amount =  $order_detail->taxAbleAmount / $taxAbleAmount_Total * $promotionDetails->discount_in_amount;
											$order_detail->promoDiscount_Percent = $promotionDetails->discount_in_percentage;
											$order_detail->promoDiscount_in_Amount = $promotionDetails->discount_in_amount;
											$order_detail->promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
											$promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
											$amountAfter_Promocode = $order_detail->taxAbleAmount - $promoDiscount_Amount;
											$order_detail->amountAfter_Promocode = number_format($amountAfter_Promocode,2,".","");
											$order_detail->taxAbleAmount = number_format($amountAfter_Promocode,2,".","");																				
										}
										else if($promo_category_id == 0 && $promo_item_id == 0 && $discount_of_max_amount ==0){
										
											$promoDiscount_Amount =  $order_detail->taxAbleAmount / $taxAbleAmount_Total * $promotionDetails->discount_in_amount;
											$order_detail->promoDiscount_Percent = $promotionDetails->discount_in_percentage;
											$order_detail->promoDiscount_in_Amount = $promotionDetails->discount_in_amount;
											$order_detail->promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
											$promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
											$amountAfter_Promocode = $order_detail->taxAbleAmount - $promoDiscount_Amount;
											$order_detail->amountAfter_Promocode = number_format($amountAfter_Promocode,2,".","");
											$order_detail->taxAbleAmount = number_format($amountAfter_Promocode,2,".","");																															
										}else{
											$order_detail->promoDiscount_Percent = 0.00;
											$order_detail->promoDiscount_in_Amount = 0.00;
											$order_detail->promoDiscount_Amount = 0.00;
											$order_detail->amountAfter_Promocode = $order_detail->taxAbleAmount;
											$order_detail->taxAbleAmount = $order_detail->taxAbleAmount;										
										}
									}else{
										if($promo_category_id > 0 && $promo_category_id == $cate_id && $promo_item_id == 0 && $discount_of_max_amount ==0)
										{
											$promoDiscount_Amount =  $order_detail->taxAbleAmount * $promotionDetails->discount_in_percentage / 100;
											$order_detail->promoDiscount_Percent = $promotionDetails->discount_in_percentage;
											$order_detail->promoDiscount_in_Amount = $promotionDetails->discount_in_amount;
											$order_detail->promoDiscount_Amount =  number_format($promoDiscount_Amount,2,".",""); 
											$promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
											$amountAfter_Promocode = $order_detail->taxAbleAmount - $promoDiscount_Amount;
											$order_detail->amountAfter_Promocode = number_format($amountAfter_Promocode,2,".","");
											$order_detail->taxAbleAmount = number_format($amountAfter_Promocode,2,".","");																						
										}
										else if($promo_item_id > 0  && $promo_item_id == $item_id && $discount_of_max_amount == 0){
											$promoDiscount_Amount =  $order_detail->taxAbleAmount * $promotionDetails->discount_in_percentage / 100;
											$order_detail->promoDiscount_Percent = $promotionDetails->discount_in_percentage;
											$order_detail->promoDiscount_in_Amount = $promotionDetails->discount_in_amount;
											$order_detail->promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
											$promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
											$amountAfter_Promocode = $order_detail->taxAbleAmount - $promoDiscount_Amount;
											$order_detail->amountAfter_Promocode = number_format($amountAfter_Promocode,2,".","");
											$order_detail->taxAbleAmount = number_format($amountAfter_Promocode,2,".","");																	
										}
										else if($discount_of_max_amount > 0 && $BothTaxableCmboItem >= $discount_of_max_amount && $promo_item_id == 0 && $promo_category_id ==0){
											$promoDiscount_Amount =  $order_detail->taxAbleAmount * $promotionDetails->discount_in_percentage / 100;
											$order_detail->promoDiscount_Percent = $promotionDetails->discount_in_percentage;
											$order_detail->promoDiscount_in_Amount = $promotionDetails->discount_in_amount;
											$order_detail->promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
											$promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
											$amountAfter_Promocode = $order_detail->taxAbleAmount - $promoDiscount_Amount;
											$order_detail->amountAfter_Promocode = number_format($amountAfter_Promocode,2,".","");
											$order_detail->taxAbleAmount = number_format($amountAfter_Promocode,2,".","");											
										}
										else if($promo_category_id == 0 && $promo_item_id == 0 && $discount_of_max_amount ==0){
											$promoDiscount_Amount =  $order_detail->taxAbleAmount * $promotionDetails->discount_in_percentage / 100;
											$order_detail->promoDiscount_Percent = $promotionDetails->discount_in_percentage;
											$order_detail->promoDiscount_in_Amount = $promotionDetails->discount_in_amount;
											$order_detail->promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
											$promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
											$amountAfter_Promocode = $order_detail->taxAbleAmount - $promoDiscount_Amount;
											$order_detail->amountAfter_Promocode = number_format($amountAfter_Promocode,2,".","");
											$order_detail->taxAbleAmount = number_format($amountAfter_Promocode,2,".","");															
										}else{
											$order_detail->promoDiscount_Percent = 0.00;
											$order_detail->promoDiscount_in_Amount = 0.00;
											$order_detail->promoDiscount_Amount = 0.00;
											$order_detail->amountAfter_Promocode = $order_detail->taxAbleAmount;
											$order_detail->taxAbleAmount = $order_detail->taxAbleAmount;																			
										}
									}
								}								
							}else {
									$order_detail->promoDiscount_Percent = 0.00;
									$order_detail->promoDiscount_in_Amount = 0.00;
									$order_detail->promoDiscount_Amount = 0.00;
									$order_detail->amountAfter_Promocode = $order_detail->taxAbleAmount;
									$order_detail->taxAbleAmount = $order_detail->taxAbleAmount;
							}
						}else{
								$order_detail->promoDiscount_Percent = 0.00;
								$order_detail->promoDiscount_in_Amount = 0.00;
								$order_detail->promoDiscount_Amount = 0.00;
								$order_detail->amountAfter_Promocode = $order_detail->taxAbleAmount;
								$order_detail->taxAbleAmount = $order_detail->taxAbleAmount;
							}

						$order_detail->promo_percent=$order_detail->promoDiscount_Percent;
						$order_detail->promo_amount=$order_detail->promoDiscount_Amount;						
						
						

						$order_detail->total_GST = $order_detail->taxAbleAmount * $order_detail->gst_percentage / 100; 
						$order_detail->total_GST_division = round($order_detail->total_GST / 2,2);
						$order_detail->total_GST = $order_detail->total_GST_division * 2;
						$order_detail->taxAbleAmount = $order_detail->taxAbleAmount-$order_detail->total_GST;	
						$order_detail->total_with_GST = $order_detail->taxAbleAmount + $order_detail->total_GST; 
						$order_detail->total_GST = number_format($order_detail->total_GST,2,".","");
						$order_detail->total_with_GST = number_format($order_detail->total_with_GST,2,".","");
						$order_detail->taxable_value =$order_detail->taxAbleAmount;
						$order_detail->gst_percentage = $order_detail->gst_percentage;
						$order_detail->gst_value=$order_detail->total_GST;
						$order_detail->net_amount=$order_detail->total_with_GST;		

						$query = $this->Challans->Orders->OrderDetails->query();
						$query->update()
						->set(['amount'=>$amount,'discount_percent' => $order_detail->discount_percent,'discount_amount' => $order_detail->discount_amount,
						'promo_percent' => $order_detail->promo_percent,'promo_amount' => $order_detail->promo_amount,'taxable_value' => $order_detail->taxable_value,
						'gst_percentage'=> $order_detail->gst_percentage,'gst_value'=>$order_detail->gst_value,'net_amount'=>$order_detail->net_amount])
						->where(['id'=>$order_detail->id])->execute();						
				}

				foreach($OrderDetails->order_details as $order_detail)
				{
					if($order_detail->is_item_cancel == 'No')
					{
						
						$total_amount = $total_amount + $order_detail->taxAbleAmount;
						$total_membershipDsicount = $total_membershipDsicount + $order_detail->discount_amount;
						$total_promoDiscount = $total_promoDiscount + $order_detail->promo_amount;
						$total_GST = $total_GST + $order_detail->total_GST;
					}
				}
				
/* 				$delivery_charge_amount=$OrderDetails->delivery_charge_amount;
				$total_delivery_charge_amount=0;
				if($delivery_charge_amount=="free"){
					$total_delivery_charge_amount=0;
				}else{
					$total_delivery_charge_amount=$delivery_charge_amount;
				} */

				//$OrderDetails->total_amount = $total_amount;
				$discount_amount=$total_membershipDsicount + $total_promoDiscount;			
				//$OrderDetails->total_gst = $total_GST;
				$pay_amount	= $pay_amount + $total_amount + $total_GST;
				//echo $pay_amount;exit;

						$customers = $this->Orders->Customers->find()->where(['Customers.id'=>$customer_id])->first();
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
									$delivery_charges=$this->Orders->DeliveryCharges->find()->where(['city_id'=>$city_id,'status'=>'Active']);
									if($delivery_charge->amount >= $pay_amount)
											{
									 $delivery_charge_amount = "$shipping_price";
										$pay_amount = number_format($pay_amount + $shipping_price,2,".","");	
									}else{
										$delivery_charge_amount = "free";
									}								
								}
							}
							else
							{		
								$delivery_charges=$this->Orders->DeliveryCharges->find()->where(['city_id'=>$city_id,'status'=>'Active']);

								if(!empty($delivery_charges->toArray()))
								{		
									foreach($delivery_charges as $delivery_charge) {
											if($delivery_charge->amount >= $pay_amount)
											{		
												 $delivery_charge_amount = "$delivery_charge->charge";
												 $pay_amount = number_format($pay_amount + $delivery_charge->charge,2,".","");
												 
											}else
											{		
												$delivery_charge_amount = "free";
											}
									}
								}										
							}

				if($delivery_charge_amount == "free"){
					$query = $this->Challans->query();
					$query->update()
					->set(['delivery_charge_amount'=>0])
					->where(['Challans.order_id'=>$OrderDetails->id])->execute();		
				}
				
				
				$p=$pay_amount;
				$q=round($pay_amount);
				$Round_off_amt=round(($q-$p),2);
				$grand_total = $pay_amount;
				$pay_amount=round($pay_amount);	
				
				$query = $this->Orders->query();
				$query->update()
				->set(['total_amount'=>$total_amount,'discount_amount'=>$discount_amount,'grand_total'=>$grand_total,'round_off'=>$Round_off_amt,'total_gst' =>$total_GST,'pay_amount' =>$pay_amount,'delivery_charge_amount'=>$delivery_charge_amount])
				->where(['id'=>$OrderDetails->id])->execute();				
				$status = '';
				$this->UpdateOrderChallan->QuntityChallanOrderUpdate($OrderDetails->id,$status);

				$message='Quantity update Successfully';
        		$success=true;				
				
			}
			else
			{
				$message='Something went wrong !';
        		$success=false;
			}
			
			/* $challanAmount = $this->Challans->query();
			$challanAmountUpdate = $challanAmount->update()
			->set(['old_pay_amount' => $response->pay_amount])
			->where(['id'=> $response->id])->execute();	 */
			
			
		}			
		else
		{
			$message='Something went wrong !';
			$success=false;
		}

      $this->set(compact('success','message'));
      $this->set('_serialize', ['success','message']);		
		
	}
	
	public function DriverOrderList()
	{
		$driver_id=$this->request->query('driver_id');
		$delivery_date=$this->request->query('delivery_date');
		$city_id=$this->request->query('city_id');
		$order_status=$this->request->query('order_status');
		if(!empty($city_id))
		{
			$cancel_order_limit = $this->Challans->Orders->MasterSetups->find()->select(['cancel_order_limit'])->where(['city_id' => $city_id])->first();
		
		$OrderCancelLimit = $cancel_order_limit->cancel_order_limit;
		
		if(!empty($delivery_date))
		{
			$dateFilter = ['Challans.delivery_date'=>$delivery_date];
		}
		else { $dateFilter = ''; }
		//pr($dateFilter);exit;
		
		if($driver_id == 3 && $order_status == 'All Orders')
		{
			  $orders_data = $this->Challans->find()
			  ->where(['Challans.order_status'=>'placed'])
			   ->orWhere(['Challans.order_status'=>'Packed'])
			   ->orWhere(['Challans.order_status'=>'Dispatched'])
			   ->where($dateFilter)
			  ->contain(['CustomerAddresses','Customers'])
			  ->order(['Challans.voucher_no' => 'DESC'])
			  ->autoFields(true);	
			$orders_data=$orders_data->toArray();		  
		}else
		{
			$orders_datass = $this->Challans->find()
			->where(['Challans.driver_id'=>$driver_id])
			->where(['Challans.order_status'=>$order_status])
			->where($dateFilter)
			->contain(['CustomerAddresses','Customers','Drivers'=>['Routes'=>'RouteDetails']])
			->order(['Challans.voucher_no' => 'DESC'])
			->autoFields(true);
			$orders_data_by_priority=[];
			foreach($orders_datass as $data){
				$RouteDetails=$this->Challans->Drivers->Routes->RouteDetails->find()->where(['landmark_id'=>$data->customer_address->landmark_id,'route_id'=>$data->driver->route_id])->first();
				$orders_data_by_priority[$RouteDetails->priority][]=$data;
			}
			
			 ksort($orders_data_by_priority);
			 $orders_data=[];
			 foreach($orders_data_by_priority as $data1){  
				 foreach($data1 as $data){  
					$orders_data[]=$data;
				 }
			 }
		
		}
		
		// pr($orders_data); exit;

		  
		  if(!empty($orders_data))
		  {
			$success = true;
			$message = 'Data found successfully';
		  }else{
			$success = false;
			$message = 'No data found';
		  }			
		}else{
			$success = false;
			$message = 'City id empty';
		  }
	
      $this->set(compact('success','message','orders_data','OrderCancelLimit'));
      $this->set('_serialize', ['success','message','OrderCancelLimit','orders_data']);		
		
	}


	public function updateChallanStatus()
	{
        $customer_id=$this->request->query('customer_id');
    	$order_id=$this->request->query('order_id');
		$challan_id=$this->request->query('challan_id');
		$status = 'Dispatched';	
		$count = 0;

		$challan_data = $this->Challans->find();
		$result = $challan_data->update()
				->set(['order_status' => $status,'packing_flag'=>'Active','dispatch_flag'=>'Active'])
				->where(['id' => $challan_id])->execute(); 


		$chlnData = $this->Challans->find()->where(['order_id' =>$order_id]);

		if(!empty($chlnData->toArray()))
		{
			foreach($chlnData as $data)
			{
				if($data->order_status == 'placed')
				{
					$count++;
				}
			}			
		}
		//
		$challan_row_datas = $this->Challans->ChallanRows->find()->where(['challan_id'=>$challan_id]);
		foreach($challan_row_datas as $challan_row_data){
			$OrderDetails_data = $this->Challans->Orders->OrderDetails->find();
			$OrderDetails_data->update()
					->set(['item_status' => $status])
					->where(['id' => $challan_row_data->order_detail_id])->execute();	
		}
		//
		if($count > 0)
		{
			$success = false;
			$message = 'Not Updated !';				
		}else
		{
			$challan_data = $this->Challans->Orders->find();
			$result = $challan_data->update()
					->set(['order_status' => $status])
					->where(['id' => $order_id])->execute();		
			$success = true;
			$message = 'Status Updated Successfully !';			
		}
	
		$this->set(compact('success','message'));
		$this->set('_serialize', ['success','message']);	
	}


    public function DriverChallanDetail()
    {
        $customer_id=$this->request->query('customer_id');
    	$challan_id=$this->request->query('challan_id');
        $city_id=$this->request->query('city_id');
		$is_item_cancel=$this->request->query('is_item_cancel');
        $orders_details_data = $this->Challans->find()
          ->contain(['Orders' => function($q) {
			  return $q->select(['Orders.order_comment']);
		  },'ChallanRows'=> function($q) use($is_item_cancel){
			  return $q->where(['combo_offer_id' =>0,'is_item_cancel'=>$is_item_cancel])
			  ->contain(['ItemVariations'=>['ItemVariationMasters','Items','UnitVariations'=>['Units']]]);
		  }])
          ->where(['Challans.id'=>$challan_id,'Challans.customer_id'=>$customer_id])
		  ->order(['Challans.id'=>'DESC']);
			$delivery_charge_amount = "0";
          $payableAmount = number_format(0, 2);
          $grand_total1=0;
			$order_details = [];
		
        if(!empty($orders_details_data->toArray()))
        { 
          
          foreach ($orders_details_data as  $orders_detail) {
              $customer_address_id = $orders_detail->customer_address_id;
              foreach ($orders_detail->challan_rows as $data) {
                  $count_cart = $this->Challans->Orders->Carts->find()->select(['Carts.cart_count'])->where(['Carts.item_variation_id'=>$data->item_variation->id,'Carts.customer_id'=>$customer_id]);
                    $data->item_variation->cart_count = 0;
                    $count_value = 0;
                    foreach ($count_cart as $count) {
                      $count_value = $count->cart_count;
                    }
                    $data->item_variation->cart_count = $count_value;
              }
          }

          $customer_addresses=$this->Challans->CustomerAddresses->find()
            ->where(['CustomerAddresses.customer_id' => $customer_id, 'CustomerAddresses.id'=>$customer_address_id])->first();


          $categories = $this->Challans->find()
          ->where(['customer_id' => $customer_id, 'id' =>$challan_id])
          ->contain(['ChallanRows'=>['ItemVariations'=>['ItemVariationMasters','Items'=>['Categories']]]]);
			$category = [];
		
          if(!empty($categories->toArray()))
          {		
              $category_arr = [];
			  $cat_name = '';
			  $cat_id = 0;
			  foreach ($categories as $cat_date) {
                foreach($cat_date->challan_rows as $order_data) {
					$cat_name = @$order_data->item_variation->item->category->name;
					$cat_id = @$order_data->item_variation->item->category->id;
					
					$category_arr[$cat_id] = $cat_name;
                }
              }
					
              foreach ($category_arr as $cat_key => $cat_value) {
                foreach ($orders_details_data as $order_data) {
                    foreach ($order_data->challan_rows as $data) {
                        $order_category_id = $data->item_variation->item->category_id;
                        if($cat_key == $order_category_id)
                        {
                          $category[$cat_key][] = $data;
                        }
                    }
                }
              }

              foreach ($category as $key => $value) {
                $order_details[] = ['category_name'=>$category_arr[$key],'category'=>$value];
              }

/* 			  $comboTotal = 0.00;
			  $comboDataCounts = $this->Orders->OrderDetails->find()
                ->innerJoinWith('ComboOffers')
                ->where(['order_id' => $order_id])
                ->where(['combo_offer_id !=' =>0])->toArray();;
				
					if(!empty($comboDataCounts))
					{	$comboTotal = 0.00;
						foreach($comboDataCounts as $comboDataCount)
						{
							$comboDataCount->comboTotal = $comboDataCount->comboTotal + $comboDataCount->net_amount;
						}
					}	 */		  
			  
			  
			  
              $comboData =[];
              $comboData = $this->Challans->ChallanRows->find()
                ->innerJoinWith('ComboOffers')
                ->where(['challan_id' => $challan_id,'is_item_cancel'=>$is_item_cancel])
                ->contain(['ComboOffers'=>['ComboOfferDetails']])
                ->group('ChallanRows.combo_offer_id')->autoFields(true)->toArray();

              if(empty($comboData)) { $comboData = []; }
			  else { 
					foreach($comboData as $comboDataValue)
					{
					  $comboDataValue->combo_item_count = sizeof($comboDataValue->combo_offer->combo_offer_details);
					  //$comboDataValue->comboTotal = number_format(round($comboTotal),2,".","");  	
					}
			  }
            //  pr($comboData);exit;
              foreach($orders_details_data as $order_data) {
                $order_data->comboData = $comboData;
                $order_data->challan_rows = $order_details;
                $orders_details_data = $order_data;
                $grand_total1 += $order_data->total_amount;
              }

			 // pr($orders_details_data);exit; //array_replace($order_data->order_details,$order_details)

          			$grand_total=number_format(round($grand_total1), 2);
          			$payableAmount = $payableAmount + $grand_total1;

/*                 $delivery_charges=$this->Orders->DeliveryCharges->find()->where(['city_id'=>$city_id]);
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
          			$payableAmount = number_format($payableAmount,2); */
			
         }
          $success = true;
          $message = 'data found successfully';

        }else{
          $success = false;
          $message = 'No data found';
          $orders_details_data = [];
          $customer_addresses = [];
        }
        $cancellation_reasons=$this->Challans->Orders->CancelReasons->find();
        $this->set(compact('success', 'message','grand_total','delivery_charge_amount','payableAmount','orders_details_data','customer_addresses','cancellation_reasons'));
        $this->set('_serialize', ['success', 'message','grand_total','delivery_charge_amount','payableAmount','orders_details_data','customer_addresses','cancellation_reasons']);
    }

	public function DriverOrderStatus()
	{
        $customer_id=$this->request->query('customer_id');
        $order_id=$this->request->query('order_id');
        $cancel_reason_id=$this->request->query('cancel_reason_id');
		$other_reason =  $this->request->query('other_reason');
		$status =  $this->request->query('status');
		$cancel_date = date('Y-m-d');		
		$orders_data = $this->Orders->find()->where(['Orders.id'=>$order_id])
		->contain(['CustomerAddresses'])->first();		
		$mobile = $orders_data->customer_address->mobile_no;
		$order_no = $orders_data->order_no;
		$order_cancel = $this->Orders->query();
		$sms = '';
		
		if($status == 'Cancel')
		{
			$odrer_datas=$this->Orders->get($order_id);	
			$amount_from_wallet=$odrer_datas->amount_from_wallet;
			$amount_from_promo_code=$odrer_datas->amount_from_promo_code;
			$online_amount=$odrer_datas->online_amount;
			$return_amount=$amount_from_wallet+$amount_from_promo_code+$online_amount;
			$order_type = $odrer_datas->order_type;
			//$other_reason = $odrer_datas->other_reason;
			$city_id = $odrer_datas->city_id;		
			$result = $order_cancel->update()
				->set(['order_status' => $status,'cancel_reason_id' => $cancel_reason_id, 'cancel_date' => $cancel_date,'cancel_reason_other'=>$other_reason])
				->where(['id' => $order_id])->execute();

			if($order_type == 'Online')
			{
				$query = $this->Orders->Wallets->query();
				$query->insert(['city_id','customer_id', 'add_amount', 'narration','amount_type','return_order_id','transaction_type'])
				->values([
					'city_id' =>$city_id,
					'customer_id' => $customer_id,
					'add_amount' => $return_amount,
					'amount_type' =>'Cancel Order',
					'narration' => 'Amount Return form Order',
					'return_order_id' => $order_id,
					'transaction_type' => 'Added'
				])->execute();
			}
			
			$cancelOrderCount = $this->Orders->Customers->find()->select(['cancel_order_count'])->where(['id' => $customer_id])->first();
			$CountCancelOrder = $cancelOrderCount->cancel_order_count;
			$CountCancelOrder = $CountCancelOrder + 1;
			$customers = $this->Orders->Customers->query();
			$customers->update()->set(['cancel_order_count' => $CountCancelOrder])
			->where(['id' => $customer_id])->execute(); 				
			
				$sms="Your order no ".$order_no." has been cancelled. Thank you !";
				$success=true;			
				$message='Thank you, your order has been cancelled.';
				
		}
		if($status == 'Return')
		{
			$odrer_datas=$this->Orders->get($order_id);	
			$amount_from_wallet=$odrer_datas->amount_from_wallet;
			$amount_from_promo_code=$odrer_datas->amount_from_promo_code;
			$online_amount=$odrer_datas->online_amount;
			$return_amount=$amount_from_wallet+$amount_from_promo_code+$online_amount;
			$order_type = $odrer_datas->order_type;
			//$other_reason = $odrer_datas->other_reason;
			$city_id = $odrer_datas->city_id;		
			$result = $order_cancel->update()
				->set(['order_status' => $status,'cancel_date' => $cancel_date,'cancel_reason_other'=>$other_reason])
				->where(['id' => $order_id])->execute();

			if($order_type == 'COD')
			{
				$query = $this->Orders->Wallets->query();
				$query->insert(['city_id','customer_id', 'add_amount', 'narration','amount_type','return_order_id','transaction_type'])
				->values([
					'city_id' =>$city_id,
					'customer_id' => $customer_id,
					'add_amount' => $return_amount,
					'amount_type' =>'Return Order',
					'narration' => 'Amount Return form Order',
					'return_order_id' => $order_id,
					'transaction_type' => 'Added'
				])->execute();
			}
			
			$cancelOrderCount = $this->Orders->Customers->find()->select(['cancel_order_count'])->where(['id' => $customer_id])->first();
			$CountCancelOrder = $cancelOrderCount->cancel_order_count;
			$CountCancelOrder = $CountCancelOrder + 1;
			$customers = $this->Orders->Customers->query();
			$customers->update()->set(['cancel_order_count' => $CountCancelOrder])
			->where(['id' => $customer_id])->execute(); 				
			
				$sms="Your order no ".$order_no." has been cancelled. Thank you !";
				$success=true;			
				$message='Thank you, your order has been cancelled.';
				
		}		
		else{
			$result = $order_cancel->update()
				->set(['order_status' => $status,'delivery_date' => $cancel_date])
				->where(['id' => $order_id])->execute();

				$customers = $this->Orders->Customers->query();
				$customers->update()->set(['cancel_order_count' => 0])
				->where(['id' => $customer_id])->execute(); 				
				
				$sms="Your order no ".$order_no." has been delivered. Thank you !";
				$success=true;			
				$message='Thank you, your order has been delivered.';
				
		}
		
		//$this->Sms->sendSms($mobile,$sms);	
		
        $this->set(compact('success', 'message'));
        $this->set('_serialize', ['success', 'message']);		
	}


	
}
