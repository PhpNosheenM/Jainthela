<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\View\View;
use Cake\Network\Exception\InvalidCsrfTokenException;
/**
 * Challans Controller
 *
 * @property \App\Model\Table\ChallansTable $Challans
 *
 * @method \App\Model\Entity\Challan[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
 
class ChallansController extends AppController
{
	public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Security->setConfig('unlockedActions', ['add', 'index', 'view', 'manageOrder', 'ajaxDeliver','invoiceManageOrder','dispatch','packing','cancelChallan']);
		if (in_array($this->request->action, ['manageOrder'])) {
			 $this->eventManager()->off($this->Csrf);
		 }
    }

	public function driverAssign($challan_id=null,$driver_id=null)
    {
	$challan_id;
	$driver_id;
	$challan = $this->Challans->get($challan_id);
	$challan->driver_id=$driver_id;
	$this->Challans->save($challan);
	exit;
	}
	
	
	public function ajaxDeliver($id = null)
    {
		$user_type =$this->Auth->User('user_type');
		$financial_year_id=$this->Auth->User('financial_year_id');

		
		//$this->viewBuilder()->layout('');
		$city_id=$this->Auth->User('city_id');
         $Orders = $this->Challans->get($id, [
            'contain' => ['SellerLedgers','PartyLedgers','Locations','Customers','CustomerAddresses', 'ChallanRows'=>['ItemVariations'=>['UnitVariations','Items'], 'ComboOffers']]
        ]);
		//pr($Orders); exit;
		$customer_id=$Orders->customer->id;
		
		if ($this->request->is('post')) { exit;
			
			pr($this->request-data());
			exit;	
		}	
		$this->loadmodel('DeliveryCharges');
		$deliveryCharges=$this->DeliveryCharges->find()->where(['DeliveryCharges.city_id'=>$city_id, 'DeliveryCharges.status'=>'Active'])->first();
		
		$this->set(compact('Orders','user_type'));
      //  $this->set('Orders', $Orders);
        $this->set('deliveryCharges', $deliveryCharges);
        $this->set('_serialize', ['Orders']);
    }
	
	public function cancelChallan($challan_id=null,$cancel_reason_id=null,$customer_id=null)
    {
		
		
	$cancel_reason_id;
	$customer_id;
	$challan_id;
	$city_id=$this->Auth->User('city_id');
	$challan = $this->Challans->get($challan_id);
	$order_id=$challan->order_id;
	$amount_from_wallet=$challan->amount_from_wallet;
	$online_amount=$challan->online_amount;
	//$wallet_refund_amount=$amount_from_wallet+$online_amount;
	$challan->order_status='Cancel';
	$challan->cancel_reason_id=$cancel_reason_id;
	$challan->cancel_time=date('H:i:s');
	$data=$this->Challans->save($challan);
	if($challan->order_type=="Wallet" || $challan->order_type=="Online" || $challan->order_type=="Wallet/Online"){
		$wallet_refund_amount=$challan->pay_amount;
	}
	
	/* $query3 = $this->Challans->query();
	$query3->update()
			->set(['order_status' => 'Cancel', 'cancel_reason_id' => $cancel_reason_id])
			->where(['Challans.id'=>$challan_id])
			->execute();  */
	
	$challan_rows=$this->Challans->ChallanRows->find()->where(['ChallanRows.challan_id'=>$challan_id]);
	
	foreach($challan_rows as $data){
		$item_variation_data=$this->Challans->ChallanRows->ItemVariations->get($data->item_variation_id);
		$item= $this->Challans->ChallanRows->ItemVariations->Items->get($data->item_id);
		if($item->item_maintain_by=="itemwise"){
			if($item_variation_data->seller_id > 0){
				$allItemVariations= $this->Challans->ChallanRows->ItemVariations->find()->where(['ItemVariations.item_id'=>$data->item_id,'ItemVariations.city_id'=>@$city_id,'ItemVariations.seller_id'=>$item_variation_data->seller_id])->contain(['UnitVariations'=>['Units']]);
			}else{ 
				$allItemVariations= $this->Challans->ChallanRows->ItemVariations->find()->where(['ItemVariations.item_id'=>$data->item_id,'ItemVariations.city_id'=>@$city_id,'ItemVariations.seller_id IS NULL'])->contain(['UnitVariations'=>['Units']]);
			}
			$UnitVariation= $this->Challans->ChallanRows->ItemVariations->UnitVariations->get($item_variation_data->unit_variation_id);
			foreach($allItemVariations as $iv){ 
				$p=($UnitVariation->convert_unit_qty*$data->quantity); 
				$addQty=($p/$iv->unit_variation->convert_unit_qty);  
				$addQty=round($addQty,2);
				$item_variation_data = $this->Challans->ChallanRows->ItemVariations->get($iv->id);
				
				//$current_stock=$item_variation_data->current_stock+$addQty;
				$cs=$item_variation_data->current_stock;
				$vs=$item_variation_data->virtual_stock;
				$demand_stock=$item_variation_data->demand_stock;
				$actual_quantity=$addQty;
				$final_current_stock=0;
				$final_demand_stock=0;
				//pr($addQty); exit;
				if($demand_stock==0){
					$final_current_stock=$cs+$addQty;
					$final_demand_stock=$demand_stock;
				}elseif($demand_stock > $actual_quantity){
					$final_current_stock=0;
					$final_demand_stock=$demand_stock-$addQty;
				}elseif($demand_stock < $actual_quantity){
					$final_current_stock=$actual_quantity-$demand_stock;
					$final_demand_stock=0;
				}
				
				$out_of_stock="No";
				$ready_to_sale="Yes";
				if(($final_current_stock==0) && ($vs==$final_demand_stock)){
					$ready_to_sale="No";
					$out_of_stock="Yes";
				}
				
				$query = $this->Challans->ChallanRows->ItemVariations->query();
				$query->update()
				->set(['current_stock'=>$final_current_stock,'demand_stock'=>$final_demand_stock,'out_of_stock'=>$out_of_stock,'ready_to_sale'=>$ready_to_sale])
				->where(['id'=>$iv->id])
				->execute(); 
			}
			
		}else{
			$ItemVariationData = $this->Challans->ChallanRows->ItemVariations->get($data->item_variation_id);
				//$current_stock=$ItemVariationData->current_stock;
				$cs=$ItemVariationData->current_stock;
				$vs=$ItemVariationData->virtual_stock;
				$demand_stock=$ItemVariationData->demand_stock;
				$actual_quantity=$data->quantity;
				$final_current_stock=0;
				$final_demand_stock=0;
				//pr($addQty); exit;
				if($demand_stock==0){
					$final_current_stock=$cs+$data->quantity;
					$final_demand_stock=$demand_stock;
				}elseif($demand_stock > $actual_quantity){
					$final_current_stock=0;
					$final_demand_stock=$demand_stock-$data->quantity;
				}elseif($demand_stock < $actual_quantity){
					$final_current_stock=$actual_quantity-$demand_stock;
					$final_demand_stock=0;
				}
				
				$out_of_stock="No";
				$ready_to_sale="Yes";
				if(($final_current_stock==0) && ($vs==$final_demand_stock)){
					$ready_to_sale="No";
					$out_of_stock="Yes";
				}
				//pr($current_stock); exit;
				$query = $this->Challans->ChallanRows->ItemVariations->query();
				$query->update()
				->set(['current_stock'=>$final_current_stock,'demand_stock'=>$final_demand_stock,'out_of_stock'=>$out_of_stock,'ready_to_sale'=>$ready_to_sale])
				->where(['id'=>$data->item_variation_id])
				->execute();
				}
		//Change Status
		$query4 = $this->Challans->ChallanRows->query();
		$query4->update()
			->set(['is_item_cancel' => 'Yes'])
			->where(['ChallanRows.id'=>$data->id])
			->execute();
		
		$query5 = $this->Challans->ChallanRows->OrderDetails->query();
		$query5->update()
			->set(['is_item_cancel' => 'Yes','item_status'=>'Cancel'])
			->where(['OrderDetails.id'=>$data->order_detail_id])
			->execute();
		
	}
	
	$status="Cancel";
	//pr($order_id);exit;
	$this->UpdateOrderChallan->UpdateChallanOrder($order_id,$status);
//	pr($order_id);exit;
	$order_detail_datas=$this->Challans->ChallanRows->OrderDetails->find()->where(['OrderDetails.order_id'=>$order_id,'OrderDetails.is_item_cancel'=>'No'])->contain(['Items','Orders'=>['PromotionDetailsLeft']]);
	
	$proms=$this->Challans->Orders->find()->where(['Orders.id'=>$order_id])->contain(['PromotionDetailsLeft'])->first();
	//pr($proms->toArray()); exit;
	@$promo_category_id=$proms->promotion_details_left->category_id;
	@$promo_item_id=$proms->promotion_details_left->item_id;
	@$promo_percent=$proms->promotion_details_left->discount_in_percentage;
	@$discount_of_max_amount=$proms->order->promotion_details_left->discount_of_max_amount;
	@$promo_amount=$proms->promotion_details_left->discount_in_amount;
	@$cash_back=$proms->promotion_details_left->cash_back;
	@$promo_in_wallet=$proms->promotion_details_left->in_wallet;
	@$promo_is_free_shipping=$proms->promotion_details_left->is_free_shipping;
	
	@$delivery_charge_amount=$proms->delivery_charge_amount;
	
	//pr($order_detail_datas->toArray()); exit;
	$find_dummy_total=0;
	$tot_txbl=0;
	foreach($order_detail_datas as $order_detail_data){
	
	$applicable=$order_detail_data->item->is_discount_enable;
	$item_category_id=$order_detail_data->item->category_id;
	$item_id=$order_detail_data->item_id;
	$find_order_detail_id=$order_detail_data->id;
	$find_amount=$order_detail_data->amount;
	$find_discount_amount=$order_detail_data->discount_amount;
	$find_promo_percent=$order_detail_data->promo_percent;
	$find_promo_amount=$order_detail_data->promo_amount;
	$after_lcd_discount_main_amount=$find_amount-$find_discount_amount;
	$find_dummy_total+=$after_lcd_discount_main_amount;
	
	////////////////////////////
	if($applicable=='Yes'){
						
						if(($promo_percent==0) && ($cash_back==0)){
							
							if(($promo_category_id>0) && ($promo_category_id==$item_category_id) && ($promo_item_id==0) && ($discount_of_max_amount==0)){
								$apply_get_txbl=$after_lcd_discount_main_amount;
								$tot_txbl+=($apply_get_txbl);
							}
							else if(($promo_item_id>0) && ($promo_item_id==$item_id) && ($discount_of_max_amount==0)){
								$apply_get_txbl=$after_lcd_discount_main_amount;
								$tot_txbl+=($apply_get_txbl);
							}
							else if(($discount_of_max_amount>0) && ($promo_item_id==0) && ($promo_category_id==0)){
								$apply_get_txbl=$after_lcd_discount_main_amount;
								$tot_txbl+=($apply_get_txbl);
							}
							else if(($promo_category_id==0) && ($promo_item_id==0) && ($discount_of_max_amount==0)){
								$apply_get_txbl=$after_lcd_discount_main_amount;
								$tot_txbl+=($apply_get_txbl);
							}
							
						}
						
						else if(($promo_percent==0) && ($promo_amount==0) && ($discount_of_max_amount>0) && ($cash_back>0)){
							
							
							
						}
						
						else{
							if(($promo_category_id>0) && ($promo_category_id==$item_category_id) && ($promo_item_id==0) && ($discount_of_max_amount==0)){
								$apply_get_txbl=$after_lcd_discount_main_amount;
								$tot_txbl+=($apply_get_txbl);
							}
							else if(($promo_item_id>0) && ($promo_item_id==$item_id) && ($discount_of_max_amount==0)){
								$apply_get_txbl=$after_lcd_discount_main_amount;
								$tot_txbl+=($apply_get_txbl);
							}
							else if(($discount_of_max_amount>0) && ($promo_item_id==0) && ($promo_category_id==0)){
								$apply_get_txbl=$after_lcd_discount_main_amount;
								$tot_txbl+=($apply_get_txbl);
							}
							else if(($promo_category_id==0) && ($promo_item_id==0) && ($discount_of_max_amount==0)){
								$apply_get_txbl=$after_lcd_discount_main_amount;
								$tot_txbl+=($apply_get_txbl);
							}

						}	
						
						
					}
	////////////////////////////
		
	}
						$grand_taxable=0;
						$grand_gst=0;
						$grand_net_amount=0;
						$grand_promo_amount=0;
	 
	foreach($order_detail_datas as $order_detail_data)
	{
		$update_id=$order_detail_data->id;
		$is_discount_enable=$order_detail_data->item->is_discount_enable;
		$find_item_category_id=$order_detail_data->item->category_id;
		$test_amount=$order_detail_data->amount;
		$test_discount_amount=$order_detail_data->discount_amount;	
		$gst_percentage=$order_detail_data->gst_percentage;	
		$after_lcd_discount=$test_amount-$test_discount_amount;
		
		@$grand_promo_amount+=$test_discount_amount;
		
		//////////////JS//COde//Start//////////////////////
		
		if(($applicable=='Yes') && ($cash_back==0)){
						//alert(promo_category_id);
					//alert(item_category_id);
						if($promo_percent==0){
							//$(this).find('.promo_amount').val(0);
							if(($promo_category_id>0) && ($promo_category_id==$item_category_id) && ($promo_item_id==0) && ($discount_of_max_amount==0)){
						$seprate_promo=(($after_lcd_discount/$tot_txbl)*$promo_amount);
						if(!$seprate_promo){ $seprate_promo=0; }
						//apply_get_txbl=$(this).find('.txbal').val();
						$main_seprate_promo=round($seprate_promo,2);
						$set_promo_amount=$main_seprate_promo;
						$set_promo_percent=0;
						$taxable_value_after_dis=$after_lcd_discount-$main_seprate_promo;
							}
						else if(($promo_item_id>0) && ($promo_item_id==$item_id) && ($discount_of_max_amount==0)){
						$seprate_promo=(($after_lcd_discount/$tot_txbl)*$promo_amount);
						if(!$seprate_promo){ $seprate_promo=0; }
						$main_seprate_promo=round($seprate_promo,2);
						//var apply_get_txbl=$(this).find('.txbal').val();
						$set_promo_amount=$main_seprate_promo;
						$set_promo_percent=0;
						$taxable_value_after_dis=$after_lcd_discount-$main_seprate_promo;
							}
						else if(($discount_of_max_amount>0) && ($promo_item_id==0) && ($promo_category_id==0)){
						
						if($discount_of_max_amount<=$appliacble_taxable_total){
						$seprate_promo=(($after_lcd_discount/$tot_txbl)*$promo_amount);
						if(!$seprate_promo){ $seprate_promo=0; }
						$main_seprate_promo=round($seprate_promo,2);
						//var apply_get_txbl=$(this).find('.txbal').val();
						$set_promo_amount=$main_seprate_promo;
						$set_promo_percent=0;
						$taxable_value_after_dis=$after_lcd_discount-$main_seprate_promo;
						}
						else{
							
							//alert('Promo Code is not Applicable');
							//$('.promo').val('');
							//calculation();
						}
							}	
						else if(($promo_category_id==0) && ($promo_item_id==0) && ($discount_of_max_amount==0)){
						$seprate_promo=(($after_lcd_discount/$tot_txbl)*$promo_amount);
						if(!$seprate_promo){ $seprate_promo=0; }
						$main_seprate_promo=round($seprate_promo,2);
						//var apply_get_txbl=$(this).find('.txbal').val();
						$set_promo_amount=$main_seprate_promo;
						$set_promo_percent=0;
						$taxable_value_after_dis=$after_lcd_discount-$main_seprate_promo;
							}
							else{
								//alert('Promo is not Valid try Another');
								//$('.promo').val('');
								//calculation();
							}
						}
						 
						else{
							
							if(($promo_category_id>0) && ($promo_category_id==$item_category_id) && ($promo_item_id==0) && ($discount_of_max_amount==0)){
							
							$promo_seprate_amount=(($after_lcd_discount*$promo_percent/100));
							$set_promo_amount=number_format($promo_seprate_amount,2);
							$taxable_value_after_dis=$after_lcd_discount-$promo_seprate_amount;
							$set_promo_percent=$promo_percent;
							
							}
							else if(($promo_item_id>0) && ($promo_item_id==$item_id) && ($discount_of_max_amount==0)){
							
							$promo_seprate_amount=(($after_lcd_discount*$promo_percent/100));
							$set_promo_amount=number_format($promo_seprate_amount,2);
							$taxable_value_after_dis=$after_lcd_discount-$promo_seprate_amount;
							$set_promo_percent=$promo_percent;
							
							}
							else if(($discount_of_max_amount>0) && ($promo_item_id==0) && ($promo_category_id==0)){
								if($discount_of_max_amount<=$appliacble_taxable_total){
								$promo_seprate_amount=(($after_lcd_discount*$promo_percent/100));
								$set_promo_amount=number_format($promo_seprate_amount,2);
								$taxable_value_after_dis=$after_lcd_discount-$promo_seprate_amount;
								$set_promo_percent=$promo_percent;
								}
								else{
									
									//alert('Promo Code is not Applicable');
									//$('.promo').val('');
									//calculation();
								}
							}
							else if(($promo_category_id==0) && ($promo_item_id==0) && ($discount_of_max_amount==0)){
							
							$promo_seprate_amount=(($after_lcd_discount*$promo_percent/100));
							$set_promo_amount=number_format($promo_seprate_amount,2);
							$taxable_value_after_dis=$after_lcd_discount-$promo_seprate_amount;
							$set_promo_percent=$promo_percent;
							}
						}
						
						
						$gsst_amnt=(($taxable_value_after_dis*$gst_percentage)/($gst_percentage+100));
						$gst_amount=number_format($gsst_amnt,2);
						$taxable_value=$taxable_value_after_dis-$gst_amount;
						$net_amount=$taxable_value_after_dis;
						
						
						$set_promo_amount;
						$set_promo_percent;
						$taxable_value;
						$gst_amount;
						$net_amount;
						
						
						
						$query = $this->Challans->Orders->OrderDetails->query();
						$query->update()
							->set(['promo_amount'=>$set_promo_amount,
									'promo_percent'=>$set_promo_percent,
									'taxable_value'=>$taxable_value,
									'gst_value'=>$gst_amount,
									'net_amount'=>$net_amount
								])
							->where(['OrderDetails.id'=>$update_id])
							->execute();
							
							
						
						$query1 = $this->Challans->ChallanRows->query();
						$query1->update()
							->set(['promo_amount'=>$set_promo_amount,
									'promo_percent'=>$set_promo_percent,
									'taxable_value'=>$taxable_value,
									'gst_value'=>$gst_amount,
									'net_amount'=>$net_amount
								])
							->where(['ChallanRows.order_detail_id'=>$update_id])
							->execute();

							
					}
		
		
		//////////////JS//COde//End///////////////////////
		$grand_taxable+=$taxable_value;
		$grand_gst+=$gst_amount;
		$grand_net_amount+=$net_amount;
		$grand_promo_amount+=$set_promo_amount;
						
		 
	}
	
	
	$pay_amount1=number_format($grand_net_amount+$delivery_charge_amount,2);
	$grand_taxable;
	$grand_gst;
	$grand_net_amount;
	$grand_promo_amount;
	
	$p=$pay_amount1;
	$q=round($pay_amount1);
	$Round_off_amt=round(($p-$q),2);
	$pay_amount=round($pay_amount1);	
	$round_off=$Round_off_amt;
	
	/* $querys = $this->Challans->Orders->query();
	$querys->update()
		->set(['total_amount'=>$grand_taxable,
				'discount_amount'=>$grand_promo_amount,
				'total_gst'=>$grand_gst,
				'grand_total'=>$pay_amount,
				'pay_amount'=>$pay_amount,
				'round_off'=>$round_off
			])
		->where(['Orders.id'=>$order_id])
		->execute(); */
	
	
	if($wallet_refund_amount>0){
		$today=date('Y-m-d');
		$wallet_no = $this->Challans->Wallets->find()->select(['order_no'])->where(['Wallets.city_id'=>$city_id])->order(['order_no' => 'DESC'])->first();
		if($wallet_no){
			$seq_wallet=$wallet_no->order_no+1;
		}else{
			$seq_wallet=1;
		}
		
		$query = $this->Challans->Wallets->query();
		$query->insert(['customer_id', 'order_id', 'order_no', 'challan_id', 'return_order_id', 'amount_type', 'transaction_type', 'transaction_date', 'add_amount', 'city_id', 'created_on'])
				->values([
				'customer_id' => $customer_id,
				'order_id' => $order_id,
				'order_no' => $seq_wallet,
				'challan_id' => $challan_id,
				'return_order_id' => $order_id,
				'amount_type' => 'order',
				'transaction_type' => 'Added',
				'transaction_date' => $today,
				'add_amount' => $wallet_refund_amount,
				'city_id' => $city_id,
				'created_on' => date('Y-m-d h:i:s a')
				])
		->execute();
	}
	
	$customer = $this->Challans->Customers->get($customer_id);
	$mob=$customer->username;
	$cancel_count=$customer->cancel_order_count;
	$customer->cancel_order_count=$cancel_count+1;
	$this->Challans->Customers->save($customer);
	
	
	//////////////Notification//Code///Start//////////////////
	@$mobile=$customer->mobile;
	$main_device_token1=$customer->device_token;
		 
		if((!empty($main_device_token1))){
		
			$device_token=$main_device_token1;
		}
	
	if(!empty($main_device_token1)){
			$tokens = array($device_token);
			$random=(string)mt_rand(1000,9999);
			$header = [
				'Content-Type:application/json',
				'Authorization: Key=AAAAXmNqxY4:APA91bG0X6RHVhwJKXUQGNSSCas44hruFdR6_CFd6WHPwx9abUr-WsrfEzsFInJawElgrp24QzaE4ksfmXu6kmIL6JG3yP487fierMys5byv-I1agRtMPIoSqdgCZf8R0iqsnds-u4CU'
			];

			$msg = [
				'title'=> 'Challan Cancel',
				'message' => 'Your Challan has Been Cancelled',
				'image' => '',
				'link' => 'jainthela://order?id='.$order_id,
				'notification_id'    => $random,
			];
			
			$payload = array(
				'registration_ids' => $tokens,
				'data' => $msg
			);
			
			$curl = curl_init();
			curl_setopt_array($curl, array(
			  CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS => json_encode($payload),
			  CURLOPT_HTTPHEADER => $header
			));
			$response = curl_exec($curl);
			$err = curl_error($curl);
			curl_close($curl);
			$final_result=json_decode($response);
			$sms_flag=$final_result->success; 	
			if ($err) {
			  //echo "cURL Error #:" . $err;
			} else {
			  //$response;
			}	


				
			$orderLink = 'jainthela://order?id='.$order_id;			
			$url = 'https://fcm.googleapis.com/fcm/send';
			
			$fcmRegIds = array();
			$fields = [
				"notification" => ["title" => "Challan Cancel", "text" => "Your Challan has Been Cancelled","sound" => "default",'notification_id'=>$random,"link" =>$orderLink],
				"content_available" => true,
				"priority" => "high",
				"data" => ["link" => $orderLink],
				"to" => $device_token,
			];


			define('GOOGLE_API_KEY', 'AAAAXmNqxY4:APA91bG0X6RHVhwJKXUQGNSSCas44hruFdR6_CFd6WHPwx9abUr-WsrfEzsFInJawElgrp24QzaE4ksfmXu6kmIL6JG3yP487fierMys5byv-I1agRtMPIoSqdgCZf8R0iqsnds-u4CU');

				$headers = array(
					'Authorization:key='.GOOGLE_API_KEY,
					'Content-Type: application/json'
				);
 			
			$curl = curl_init();
			curl_setopt_array($curl, array(
			  CURLOPT_URL => $url,
			  CURLOPT_SSL_VERIFYPEER => false,
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS => json_encode($fields),
			  CURLOPT_HTTPHEADER => $headers
			));
			curl_exec($curl);
			$err = curl_error($curl);
			curl_close($curl);
			
					  
		}
	//////////////Notification//Code///end../////////////////
	
	$sms=str_replace(' ', '+', 'Your order has been canceled');
	$sms_sender='JAINTE';
	$sms=str_replace(' ', '+', $sms);
	//file_get_contents('http://103.39.134.40/api/mt/SendSMS?user=phppoetsit&password=9829041695&senderid='.$sms_sender.'&channel=Trans&DCS=0&flashsms=0&number='.$mob.'&text='.$sms.'&route=7');
	echo 'Canceled';
	exit;
	}
	
	public function orderIntoCod($order_id=null){
		
		$order = $this->Challans->Orders->get($order_id);
		$LedgerData = $this->Challans->Invoices->Ledgers->find()->where(['Ledgers.cash' =>'1','Ledgers.city_id'=>$order->city_id])->first();
		
		$querys = $this->Challans->Orders->query();
		$querys->update()
		->set(['party_ledger_id'=>$LedgerData->id,
				'order_type'=>'COD',
				'payment_status'=>''
			])
		->where(['Orders.id'=>$order_id])
		->execute();
		
		$querys1 = $this->Challans->query();
		$querys1->update()
		->set(['party_ledger_id'=>$LedgerData->id,
				'order_type'=>'COD',
				'payment_status'=>''
			])
		->where(['Challans.order_id'=>$order_id])
		->execute();
		exit;
		
	}
	
	public function dispatch($challan_id=null)
    {

	$challan_id;
	$challan = $this->Challans->get($challan_id,['contain'=>['ChallanRows']]);
	$customer_id=$challan->customer_id;
	$order_id=$challan->order_id;
	$challan->dispatch_flag='Active';
	$challan->order_status='Dispatched';
	$challan->dispatch_on= date('Y-m-d h:i:s a');
	$this->Challans->save($challan);
	
	$customer = $this->Challans->Customers->get($customer_id);
	$mob=$customer->username;
	
	//Updating in order
	$Orders=$this->Challans->find()->where(['Challans.order_id'=>$challan->order_id]);
	$totalOrder=(sizeof($Orders->toArray()));
	
	if($totalOrder==1){
		$query = $this->Challans->Orders->query();
		$query->update()
			->set(['order_status'=>'Dispatched','is_applicable_for_cancel'=>'No'])
			->where(['id'=>$challan->order_id])
			->execute();
		$query = $this->Challans->Orders->OrderDetails->query();
		$query->update()
			->set(['item_status'=>'Dispatched'])
			->where(['order_id'=>$challan->order_id,'is_item_cancel'=>'No'])
			->execute();
	}else{
		foreach($challan->challan_rows as $data){
			$query = $this->Challans->Orders->OrderDetails->query();
			$query->update()
				->set(['item_status'=>'Dispatched'])
				->where(['id'=>$data->order_detail_id])
				->execute();
			$query = $this->Challans->Orders->query();
			$query->update()
				->set(['order_status'=>'Dispatched','is_applicable_for_cancel'=>'No'])
				->where(['id'=>$challan->order_id])
				->execute();
			
		}
	}
	
	//////////////Notification//Code///Start//////////////////
	$customer=$this->Challans->Customers->get($customer_id);
	$mobile=$customer->username;
	$main_device_token1=$customer->device_token;
		 
		if((!empty($main_device_token1))){
		
			$device_token=$main_device_token1;
		}
		
	if(!empty($main_device_token1)){
			$tokens = array($device_token);
			$random=(string)mt_rand(1000,9999);
			$header = [
				'Content-Type:application/json',
				'Authorization: Key=AAAAXmNqxY4:APA91bG0X6RHVhwJKXUQGNSSCas44hruFdR6_CFd6WHPwx9abUr-WsrfEzsFInJawElgrp24QzaE4ksfmXu6kmIL6JG3yP487fierMys5byv-I1agRtMPIoSqdgCZf8R0iqsnds-u4CU'
			];

			$msg = [
				'title'=> 'Challan Dispatch',
				'message' => 'Your Challan has Been Dispatched',
				'image' => '',
				'link' => 'jainthela://order?id='.$order_id,
				'notification_id'    => $random,
			];
			
			$payload = array(
				'registration_ids' => $tokens,
				'data' => $msg
			);
			
			$curl = curl_init();
			curl_setopt_array($curl, array(
			  CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS => json_encode($payload),
			  CURLOPT_HTTPHEADER => $header
			));
			$response = curl_exec($curl);
			$err = curl_error($curl);
			curl_close($curl);
			$final_result=json_decode($response);
			$sms_flag=$final_result->success; 	
			if ($err) {
			  //echo "cURL Error #:" . $err;
			} else {
			  $response;
			}	

				
			$orderLink = 'jainthela://order?id='.$order_id;			
			$url = 'https://fcm.googleapis.com/fcm/send';
			
			$fcmRegIds = array();
			$fields = [
				"notification" => ["title" => "Challan Dispatch", "text" => "Your Challan has Been Dispatched","sound" => "default",'notification_id'=>$random,"link" =>$orderLink],
				"content_available" => true,
				"priority" => "high",
				"data" => ["link" => $orderLink],
				"to" => $device_token,
			];


			define('GOOGLE_API_KEY', 'AAAAXmNqxY4:APA91bG0X6RHVhwJKXUQGNSSCas44hruFdR6_CFd6WHPwx9abUr-WsrfEzsFInJawElgrp24QzaE4ksfmXu6kmIL6JG3yP487fierMys5byv-I1agRtMPIoSqdgCZf8R0iqsnds-u4CU');

				$headers = array(
					'Authorization:key='.GOOGLE_API_KEY,
					'Content-Type: application/json'
				);
 			
			$curl = curl_init();
			curl_setopt_array($curl, array(
			  CURLOPT_URL => $url,
			  CURLOPT_SSL_VERIFYPEER => false,
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS => json_encode($fields),
			  CURLOPT_HTTPHEADER => $headers
			));
			curl_exec($curl);
			$err = curl_error($curl);
			curl_close($curl);
			
		
		}
	//////////////Notification//Code///end../////////////////
	
	$sms=str_replace(' ', '+', 'Your Challan has Been Dispatched');
	$sms_sender='JAINTE';
	$sms=str_replace(' ', '+', $sms);
	//file_get_contents('http://103.39.134.40/api/mt/SendSMS?user=phppoetsit&password=9829041695&senderid='.$sms_sender.'&channel=Trans&DCS=0&flashsms=0&number='.$mob.'&text='.$sms.'&route=7');
	
	echo '<a class="btn btn-primary dlvr btn-condensed btn-sm" > Deliver</a>';
	exit;
	}
	
	
	public function packing($challan_id=null)
    {
	$challan_id;
	$challan = $this->Challans->get($challan_id,['contain'=>['ChallanRows']]);
	$customer_id=$challan->customer_id;
	$order_id=$challan->order_id;
	$challan->packing_flag='Active';
	$challan->order_status='Packed';
	$challan->packing_on= date('Y-m-d h:i:s a');
	$this->Challans->save($challan);
	
	//Updating in order
	$Orders=$this->Challans->find()->where(['Challans.order_id'=>$challan->order_id]);
	$totalOrder=(sizeof($Orders->toArray()));
	//pr($totalOrder); exit;
	if($totalOrder==1){
		$query = $this->Challans->Orders->query();
		$query->update()
			->set(['order_status'=>'Packed'])
			->where(['id'=>$challan->order_id])
			->execute();
		$query = $this->Challans->Orders->OrderDetails->query();
		$query->update()
			->set(['item_status'=>'Packed'])
			->where(['order_id'=>$challan->order_id,'is_item_cancel'=>'No'])
			->execute();
	}else{
		foreach($challan->challan_rows as $data){
			$query = $this->Challans->Orders->OrderDetails->query();
			$query->update()
				->set(['item_status'=>'Packed'])
				->where(['id'=>$data->order_detail_id,'is_item_cancel'=>'No'])
				->execute();
		}
	}
	
	//////////////Notification//Code///Start//////////////////
	$customer=$this->Challans->Customers->get($customer_id);
	$mob=$customer->username;
	$main_device_token1=$customer->device_token;
		 
		if((!empty($main_device_token1))){
		
			$device_token=$main_device_token1;
		}
		
	if(!empty($main_device_token1)){
			$tokens = array($device_token);
			$random=(string)mt_rand(1000,9999);
			$header = [
				'Content-Type:application/json',
				'Authorization: Key=AAAAXmNqxY4:APA91bG0X6RHVhwJKXUQGNSSCas44hruFdR6_CFd6WHPwx9abUr-WsrfEzsFInJawElgrp24QzaE4ksfmXu6kmIL6JG3yP487fierMys5byv-I1agRtMPIoSqdgCZf8R0iqsnds-u4CU'
			];

			$msg = [
				'title'=> 'Challan Packed',
				'message' => 'Your Challan has Been Packed',
				'image' => '',
				'link' => 'jainthela://order?id='.$order_id,
				'notification_id'    => $random,
			];
			
			$payload = array(
				'registration_ids' => $tokens,
				'data' => $msg
			);
			
			$curl = curl_init();
			curl_setopt_array($curl, array(
			  CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS => json_encode($payload),
			  CURLOPT_HTTPHEADER => $header
			));
			$response = curl_exec($curl);
			$err = curl_error($curl);
			curl_close($curl);
			$final_result=json_decode($response);
			$sms_flag=$final_result->success; 	
			if ($err) {
			  //echo "cURL Error #:" . $err;
			} else {
			  //$response;
			}	


			$orderLink = 'jainthela://order?id='.$order_id;			
			$url = 'https://fcm.googleapis.com/fcm/send';
			
			$fcmRegIds = array();
			$fields = [
				"notification" => ["title" => "Challan Packed", "text" => "Your Challan has Been Packed","sound" => "default",'notification_id'=>$random,"link" =>$orderLink],
				"content_available" => true,
				"priority" => "high",
				"data" => ["link" => $orderLink,"sound" => "default",'notification_id'=>$random],
				"to" => $device_token,
			];


			define('GOOGLE_API_KEY', 'AAAAXmNqxY4:APA91bG0X6RHVhwJKXUQGNSSCas44hruFdR6_CFd6WHPwx9abUr-WsrfEzsFInJawElgrp24QzaE4ksfmXu6kmIL6JG3yP487fierMys5byv-I1agRtMPIoSqdgCZf8R0iqsnds-u4CU');

				$headers = array(
					'Authorization:key='.GOOGLE_API_KEY,
					'Content-Type: application/json'
				);
 			
			$curl = curl_init();
			curl_setopt_array($curl, array(
			  CURLOPT_URL => $url,
			  CURLOPT_SSL_VERIFYPEER => false,
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS => json_encode($fields),
			  CURLOPT_HTTPHEADER => $headers
			));
			curl_exec($curl);
			$err = curl_error($curl);
			curl_close($curl);
			
		
		}
	//////////////Notification//Code///end../////////////////
	
	$sms=str_replace(' ', '+', 'Your Challan has been Packed and ready to Dispatch');
	$sms_sender='JAINTE';
	$sms=str_replace(' ', '+', $sms);
	//file_get_contents('http://103.39.134.40/api/mt/SendSMS?user=phppoetsit&password=9829041695&senderid='.$sms_sender.'&channel=Trans&DCS=0&flashsms=0&number='.$mob.'&text='.$sms.'&route=7');
	echo '<button class="btn btn-warning  btn-condensed btn-sm dsptch" type="submit">Dispatch</button>';
	exit;
	}
	
	
	public function routeWiseOrder($status=null){
				
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id');
		$location_id=$this->Auth->User('location_id');
		$status = $this->request->query('status');
		$user_type =$this->Auth->User('user_type');
		$financial_year_id=$this->Auth->User('financial_year_id');
		if($user_type=="Super Admin"){
		$this->viewBuilder()->layout('super_admin_layout');
		}else if($user_type=="Admin"){ 
		$this->viewBuilder()->layout('admin_portal');
		}
		
        $this->paginate = [
			'limit' => 100 
        ];
		$CityData = $this->Challans->Cities->get($city_id);
		$StateData = $this->Challans->Cities->States->get($CityData->state_id);
		
		
		$where=[];
		if($status=="delivered" || $status=="cancel" || $status=="return"){
			$where['Challans.order_status']='%'.$status.'%';
		}else{
			$status='';
		}
		if(!empty($status)){
			$order_data=$this->Challans->find()->where(['Challans.order_status'=>$status])->order(['Challans.id'=>'DESC'])->contain(['SellerLedgers','PartyLedgers','Locations','Customers','CustomerAddressesLeft','Drivers','ChallanRows'=>['Items'=>'Categories']])->where(['Challans.city_id'=>$city_id]);
		}else{
			//exit;
			$order_data=$this->Challans->find()->order(['Challans.id'=>'DESC'])->contain(['SellerLedgers','PartyLedgers','Locations','Customers','Drivers','ChallanRows'=>['Items'=>'Categories'],'CustomerAddressesLeft'])->where(['Challans.city_id'=>$city_id,'Challans.order_status !='=>'Cancel'])->where(['Challans.order_status !='=>'Delivered']);
		}
		pr($order_data->toArray()); exit;
		$drivers=$this->Challans->Drivers->find('list')->where(['Drivers.status'=>'Active'])->contain(['Locations'=>function ($q) use($city_id){
							return $q->where(['Locations.city_id'=>$city_id]);
						}]);
		$cancelReasons=$this->Challans->CancelReasons->find('list')->where(['CancelReasons.city_id'=>$city_id,'CancelReasons.status'=>'Active']);
		 
		// pr($order_data->toArray()); exit;
        $orders = $this->paginate($order_data);
		//pr( $orders->toArray()); exit;
		$paginate_limit=$this->paginate['limit'];
        $this->set(compact('orders','paginate_limit','status','status1','drivers','cancelReasons'));
	}
	public function manageOrder($status=null)
    {
		
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id');
		$location_id=$this->Auth->User('location_id');
		$status = $this->request->query('status');
		$user_type =$this->Auth->User('user_type');
		$financial_year_id=$this->Auth->User('financial_year_id');
		
		if($user_type=="Super Admin"){
			$this->viewBuilder()->layout('super_admin_layout');
		}else if($user_type=="Admin"){ 
			$this->viewBuilder()->layout('admin_portal');
		}else{
			$this->viewBuilder()->layout('seller_layout');
		}
		
		$from_date = $this->request->query('from_date');
		$to_date = $this->request->query('to_date');

		if(empty($from_date) || empty($to_date))
		{
			$from_date = '';
			$to_date   = '';
		}else{
			$from_date = date("Y-m-d",strtotime($from_date));
			$to_date= date("Y-m-d",strtotime($to_date));
		}

		if(!empty($from_date))
		{
			$from_date = date("Y-m-d",strtotime($from_date));
			$where_get['Challans.order_date >=']=$from_date;
		}
		else
		{
			$where_get = '';
		}
		if(!empty($to_date))
		{
			$to_date   = date("Y-m-d",strtotime($to_date));
			$where_get['Challans.order_date <=']=$to_date;
		}
		else
		{
			$where_get = '';
		}
		if($user_type=="Seller"){
			$where_get['Challans.seller_id']=$user_id;
		}
		
        $this->paginate = [
			'limit' => 100 
        ];
		$CityData = $this->Challans->Cities->get($city_id);
		$StateData = $this->Challans->Cities->States->get($CityData->state_id);
		
		if ($this->request->is('post')) { 
			
			//pr($this->request->is('post')); exit;
			$ChallanData=$this->request->data;
			$Challan = $this->Challans->get($ChallanData['challan_id']	, [
            'contain' => ['SellerLedgers','PartyLedgers','Locations','Customers'=>['Cities'],'CustomerAddresses', 'ChallanRows'=>['ItemVariations'=>['Items'], 'ComboOffers']]
			]);
			$deliver_by="Jainthela";
			if(@$ChallanData['deliver_by']){
				$deliver_by=@$ChallanData['deliver_by'];
			}
			//pr($deliver_by); exit;
			//Genrate Invoice
			$Voucher_no = $this->Challans->Invoices->find()->select(['voucher_no'])->where(['Invoices.city_id'=>$Challan->city_id,'Invoices.financial_year_id'=>$financial_year_id])->order(['voucher_no' => 'DESC'])->first();
			if($Voucher_no){$voucher_no=$Voucher_no->voucher_no+1;}
			else{$voucher_no=1;}
			$order_no=$CityData->alise_name.'/IN/'.$voucher_no;
			$order_no=$StateData->alias_name.'/'.$order_no;
			
			$Invoice = $this->Challans->Invoices->newEntity(); 
			$Invoice->seller_id=$Challan->seller_id;
			$Invoice->seller_name=$Challan->seller_name;
			$Invoice->challan_id=$Challan->id;
			$Invoice->order_id=$Challan->order_id;
			$Invoice->location_id=$Challan->location_id;
			$Invoice->delivery_date=date('Y-m-d');
			$Invoice->delivery_time_id=$Challan->delivery_time_id;
			$Invoice->delivery_time_sloat=$Challan->delivery_time_sloat;
			$Invoice->customer_address_id=$Challan->customer_address_id;
			$Invoice->voucher_no=$voucher_no;
			$Invoice->invoice_no=$order_no;
			//$Invoice->seller_name=$sellerLedgerData->name;
			$Invoice->order_type=$Challan->order_type;
			$Invoice->financial_year_id=$financial_year_id;
			$Invoice->city_id=$Challan->city_id;
			$Invoice->sales_ledger_id=$Challan->sales_ledger_id;
			$Invoice->party_ledger_id=$Challan->party_ledger_id;
			$Invoice->customer_id=$Challan->customer_id;
			$Invoice->pay_amount=$Challan->pay_amount;
			//$Invoice->driver_id=$order->driver_id;
			$Invoice->address=$Challan->address;
			$Invoice->promotion_detail_id=$Challan->promotion_detail_id;
			$Invoice->ccavvenue_tracking_no=$Challan->ccavvenue_tracking_no;
			$Invoice->order_type=$Challan->order_type;
			$Invoice->order_date=$Challan->order_date;
			$Invoice->transaction_date=date('Y-m-d');
			$Invoice->round_off=$Challan->round_off; 
			$Invoice->order_status="Delivered";
			$Invoice->delivery_charge_amount=@$Challan->delivery_charge_amount;  
			$Invoice->grand_total=@$Challan->grand_total;  
			$Invoice->discount_amount=@$Challan->discount_amount;  
			$Invoice->total_gst=@$Challan->total_gst;  
			$Invoice->total_amount=@$Challan->total_amount;  
			$Invoice->deliver_by=@$deliver_by;  
			//$Invoice->total_amount=@$Challan->round_off;  
			if($this->Challans->Invoices->save($Invoice)){
			//if(($Invoice)){
				foreach($Challan->challan_rows as $data){
					if($data->is_item_cancel=="No"){
						$InvoiceRow = $this->Challans->Invoices->InvoiceRows->newEntity(); 
						$InvoiceRow->invoice_id=$Invoice->id;
						$InvoiceRow->order_detail_id=$data->order_detail_id;
						$InvoiceRow->item_id=$data->item_id;
						$InvoiceRow->item_variation_id=$data->item_variation_id;
						$InvoiceRow->combo_offer_id=$data->combo_offer_id;
						$InvoiceRow->quantity=$data->quantity;
						$InvoiceRow->rate=$data->rate;
						$InvoiceRow->amount=$data->amount;
						$InvoiceRow->discount_percent=$data->discount_percent;
						$InvoiceRow->discount_amount=$data->discount_amount;
						$InvoiceRow->promo_percent=$data->promo_percent;
						$InvoiceRow->promo_amount=$data->promo_amount;
						$InvoiceRow->taxable_value=$data->taxable_value;
						$InvoiceRow->gst_percentage=$data->gst_percentage;
						$InvoiceRow->gst_figure_id=$data->gst_figure_id;
						$InvoiceRow->gst_value=$data->gst_value;
						$InvoiceRow->net_amount=$data->net_amount; 
						$this->Challans->Invoices->InvoiceRows->save($InvoiceRow);
					}
				}
			}

	
			//Accounting Entry
			//$Invoice->id=2;
			$InvoiceData = $this->Challans->Invoices->get($Invoice->id, [
            'contain' => ['SellerLedgers','PartyLedgers','Locations','Customers','CustomerAddresses', 'InvoiceRows'=>['ItemVariations'=>['Items'], 'ComboOffers']]
			]);
			
			
		
			if($InvoiceData->order_type ==  "Wallet"){
				// Ledger entry for Customer
				$LedgerData = $this->Challans->Invoices->Ledgers->find()->where(['Ledgers.customer_id'=>$InvoiceData->customer_id,'Ledgers.city_id'=>$InvoiceData->city_id])->first();
				$customer_ledger_id=$LedgerData->id; 
				$AccountingEntrie = $this->Challans->Invoices->Ledgers->AccountingEntries->newEntity(); 
				$AccountingEntrie->ledger_id=$customer_ledger_id;
				$AccountingEntrie->debit=$InvoiceData->pay_amount;
				$AccountingEntrie->credit=0;
				$AccountingEntrie->transaction_date=date('Y-m-d');
				$AccountingEntrie->city_id=$InvoiceData->city_id;
				$AccountingEntrie->entry_from="Web";
				$AccountingEntrie->invoice_id=$InvoiceData->id; 
				$this->Challans->Invoices->Ledgers->AccountingEntries->save($AccountingEntrie);
				
				//	Payment History
				$OrderPaymentHistory = $this->Challans->Invoices->OrderPaymentHistories->newEntity();
				$OrderPaymentHistory->order_id=$InvoiceData->order_id;
				$OrderPaymentHistory->invoice_id=$InvoiceData->id;
				$OrderPaymentHistory->wallet_amount=$InvoiceData->pay_amount;
				$OrderPaymentHistory->total=$InvoiceData->pay_amount;
				$OrderPaymentHistory->entry_from="Invoice"; 
				$this->Challans->Invoices->OrderPaymentHistories->save( $OrderPaymentHistory);
			}else if($InvoiceData->order_type == "Online"){ 
				//$LedgerData = $this->Challans->Invoices->Ledgers->find()->where(['Ledgers.ccavenue' =>'yes','Ledgers.city_id'=>$InvoiceData->city_id])->first();
				
				$LedgerData = $this->Challans->Invoices->Ledgers->find()->where(['Ledgers.customer_id'=>$InvoiceData->customer_id,'Ledgers.city_id'=>$InvoiceData->city_id])->first();
				
				// Ledger entry for Customer
				$AccountingEntrie = $this->Challans->Invoices->Ledgers->AccountingEntries->newEntity(); 
				$AccountingEntrie->ledger_id=$LedgerData->id; 
				$AccountingEntrie->debit=$InvoiceData->pay_amount;
				$AccountingEntrie->credit=0;
				$AccountingEntrie->transaction_date=date('Y-m-d');
				$AccountingEntrie->city_id=$InvoiceData->city_id;
				$AccountingEntrie->entry_from="Web";
				$AccountingEntrie->invoice_id=$InvoiceData->id;  
				$this->Challans->Invoices->Ledgers->AccountingEntries->save($AccountingEntrie);
				
				//	Payment History
				 $OrderPaymentHistory = $this->Challans->Invoices->OrderPaymentHistories->newEntity();
				 $OrderPaymentHistory->order_id=$InvoiceData->order_id;
				 $OrderPaymentHistory->invoice_id=$InvoiceData->id;
				 //$OrderPaymentHistory->online_amount=$order->online_amount;
				 $OrderPaymentHistory->online_amount=$InvoiceData->pay_amount;
				 $OrderPaymentHistory->total=$InvoiceData->pay_amount;
				 //$OrderPaymentHistory->wallet_return=;
				 $OrderPaymentHistory->entry_from="Invoice";
				 $this->Challans->Invoices->OrderPaymentHistories->save( $OrderPaymentHistory); 
				
				
			}else if($InvoiceData->order_type == "COD"){
					
					if($InvoiceData->deliver_by=="Seller"){
						$LedgerData= $this->Challans->Invoices->Ledgers->find()->where(['Ledgers.seller_id' =>$InvoiceData->seller_id,'Ledgers.city_id'=>$InvoiceData->city_id])->first();
						
					}else{
						$LedgerData = $this->Challans->Invoices->Ledgers->find()->where(['Ledgers.cash' =>'1','Ledgers.city_id'=>$InvoiceData->city_id])->first();
					} 
					
					//$LedgerData = $this->Challans->Invoices->Ledgers->find()->where(['Ledgers.cash' =>'1','Ledgers.city_id'=>$InvoiceData->city_id])->first();
					
					$cash_acc_ledger_id=$LedgerData->id; 
					$AccountingEntrie = $this->Challans->Invoices->Ledgers->AccountingEntries->newEntity(); 
					$AccountingEntrie->ledger_id=$cash_acc_ledger_id;
					$AccountingEntrie->debit=$InvoiceData->pay_amount;
					$AccountingEntrie->credit=0;
					$AccountingEntrie->transaction_date=date('Y-m-d');
					$AccountingEntrie->city_id=$InvoiceData->city_id;
					$AccountingEntrie->entry_from="Web";
					$AccountingEntrie->invoice_id=$InvoiceData->id; 
					$this->Challans->Invoices->Ledgers->AccountingEntries->save($AccountingEntrie);
					
			}else if($InvoiceData->order_type == "Wallet/Online"){
				// Ledger entry for Customer
				$LedgerData = $this->Challans->Invoices->Ledgers->find()->where(['Ledgers.customer_id'=>$InvoiceData->customer_id,'Ledgers.city_id'=>$InvoiceData->city_id])->first();
				
				$AccountingEntrie = $this->Challans->Invoices->Ledgers->AccountingEntries->newEntity(); 
				$AccountingEntrie->ledger_id=$LedgerData->id; 
				$AccountingEntrie->debit=$InvoiceData->pay_amount;
				$AccountingEntrie->credit=0;
				$AccountingEntrie->transaction_date=date('Y-m-d');
				$AccountingEntrie->city_id=$InvoiceData->city_id;
				$AccountingEntrie->entry_from="Web";
				$AccountingEntrie->invoice_id=$InvoiceData->id;  
				$this->Challans->Invoices->Ledgers->AccountingEntries->save($AccountingEntrie);
					
			}else if($InvoiceData->order_type == "Credit"){
				// Ledger entry for Customer
				$LedgerData = $this->Challans->Invoices->Ledgers->find()->where(['Ledgers.customer_id'=>$InvoiceData->customer_id,'Ledgers.city_id'=>$InvoiceData->city_id])->first();
				$customer_ledger_id=$LedgerData->id; 
				$AccountingEntrie = $this->Challans->Invoices->Ledgers->AccountingEntries->newEntity(); 
				$AccountingEntrie->ledger_id=$customer_ledger_id;
				$AccountingEntrie->debit=$InvoiceData->pay_amount;
				$AccountingEntrie->credit=0;
				$AccountingEntrie->transaction_date=date('Y-m-d');
				$AccountingEntrie->city_id=$InvoiceData->city_id;
				$AccountingEntrie->entry_from="Web";
				$AccountingEntrie->invoice_id=$InvoiceData->id; 
				$this->Challans->Invoices->Ledgers->AccountingEntries->save($AccountingEntrie);
				
				if($LedgerData->bill_to_bill_accounting=="yes"){
					$ReferenceDetail = $this->Challans->JournalVouchers->ReferenceDetails->newEntity(); 
					$ReferenceDetail->ledger_id=$LedgerData->id;
					$ReferenceDetail->debit=$InvoiceData->pay_amount;
					$ReferenceDetail->credit=0;
					$ReferenceDetail->transaction_date=date('Y-m-d');
					$ReferenceDetail->city_id=$InvoiceData->city_id;
					$ReferenceDetail->entry_from="Web";
					$ReferenceDetail->type='New Ref';
					$ReferenceDetail->ref_name=$InvoiceData->invoice_no;
					$ReferenceDetail->invoice_id=$InvoiceData->id; //pr($ReferenceDetail); exit;
					$this->Challans->JournalVouchers->ReferenceDetails->save($ReferenceDetail);
				}
				
			}
			
			// Sales Account Entry 
			$AccountingEntrie = $this->Challans->Invoices->Ledgers->AccountingEntries->newEntity(); 
			$AccountingEntrie->ledger_id=$InvoiceData->sales_ledger_id;
			$AccountingEntrie->credit=$InvoiceData->total_amount;
			$AccountingEntrie->debit=0;
			$AccountingEntrie->transaction_date=date('Y-m-d');
			$AccountingEntrie->city_id=$InvoiceData->city_id;
			$AccountingEntrie->entry_from="Web";
			$AccountingEntrie->invoice_id=$InvoiceData->id;
			$this->Challans->Invoices->Ledgers->AccountingEntries->save($AccountingEntrie);
			
			//Delivery Charges Entry
			if($InvoiceData->delivery_charge_amount > 0){
				$TransportLedger = $this->Challans->Invoices->Ledgers->find()->where(['Ledgers.transport' =>'Receive','Ledgers.city_id'=>$InvoiceData->city_id])->first();
					$AccountingEntrie1 = $this->Challans->Invoices->Ledgers->AccountingEntries->newEntity();
					$AccountingEntrie1->ledger_id=$TransportLedger->id;
					$AccountingEntrie1->credit=$InvoiceData->delivery_charge_amount;
					$AccountingEntrie1->debit=0;
					$AccountingEntrie1->transaction_date=date('Y-m-d');
					$AccountingEntrie1->city_id=$InvoiceData->city_id;
					$AccountingEntrie1->entry_from="Web";
					$AccountingEntrie1->invoice_id=$InvoiceData->id; 
					$this->Challans->Invoices->Ledgers->AccountingEntries->save($AccountingEntrie1);
				}
			
			
			//round Off Entry
			$roundOffLedger = $this->Challans->Invoices->Ledgers->find()->where(['Ledgers.round_off' =>'1','Ledgers.city_id'=>$InvoiceData->city_id])->first(); 
			$AccountingEntrie = $this->Challans->Invoices->Ledgers->AccountingEntries->newEntity(); 
			$AccountingEntrie->ledger_id=$roundOffLedger->id;
			if($InvoiceData->round_off < 0){
				$AccountingEntrie->debit=abs(@$InvoiceData->round_off);
				$AccountingEntrie->credit=0;
			}else{
				$AccountingEntrie->credit=@$InvoiceData->round_off;
				$AccountingEntrie->debit=0;
			}
			$AccountingEntrie->transaction_date=date('Y-m-d');
			$AccountingEntrie->city_id=$InvoiceData->city_id;
			$AccountingEntrie->entry_from="Web";
			$AccountingEntrie->invoice_id=$InvoiceData->id; 
			if(@$InvoiceData->round_off != 0){
				$this->Challans->Invoices->Ledgers->AccountingEntries->save($AccountingEntrie);
			}
			
			$totalPurchaseAmount=0;
			//GST Accounting Entry
			foreach($InvoiceData->invoice_rows as $invoice_row){ 

				if($CityData->state_id==$Challan->customer->city->state_id){
				
					$ItemData = $this->Challans->Invoices->InvoiceRows->Items->find()->where(['Items.id'=>$invoice_row->item_id])->first();
					
					$gstAmtdata=$invoice_row->gst_value/2;
					$gstAmtInsert=round($gstAmtdata,2);
					
					//$gstLedgerCGST = $this->Challans->Invoices->Ledgers->find()->where(['Ledgers.gst_figure_id' =>$ItemData->gst_figure_id, 'Ledgers.input_output'=>'output', 'Ledgers.gst_type'=>'CGST','city_id'=>$InvoiceData->city_id])->first();
						
					//Accounting Entries for CGST//
					$gstLedgerCGST = $this->Challans->Invoices->Ledgers->find()
					->where(['Ledgers.gst_figure_id' =>$ItemData->gst_figure_id, 'Ledgers.input_output'=>'output', 'Ledgers.gst_type'=>'CGST','city_id'=>$InvoiceData->city_id])->first();
					$AccountingEntrieCGST = $this->Challans->Invoices->Ledgers->AccountingEntries->newEntity();
					$AccountingEntrieCGST->ledger_id=$gstLedgerCGST->id;
					$AccountingEntrieCGST->credit=$gstAmtInsert;
					$AccountingEntrieCGST->debit=0;
					$AccountingEntrieCGST->transaction_date=date('Y-m-d');
					$AccountingEntrieCGST->city_id=$InvoiceData->city_id;
					$AccountingEntrieCGST->entry_from="Web";
					$AccountingEntrieCGST->invoice_id=$InvoiceData->id; 
					if($gstAmtInsert > 0){
						$this->Challans->Invoices->Ledgers->AccountingEntries->save($AccountingEntrieCGST);
					}
					
					//Accounting Entries for SGST//
					 $gstLedgerSGST = $this->Challans->Invoices->Ledgers->find()
					->where(['Ledgers.gst_figure_id' =>$ItemData->gst_figure_id, 'Ledgers.input_output'=>'output', 'Ledgers.gst_type'=>'SGST','city_id'=>$InvoiceData->city_id])->first();
					$AccountingEntrieSGST = $this->Challans->Invoices->Ledgers->AccountingEntries->newEntity();
					$AccountingEntrieSGST->ledger_id=$gstLedgerSGST->id;
					$AccountingEntrieSGST->credit=$gstAmtInsert;
					$AccountingEntrieSGST->debit=0;
					$AccountingEntrieSGST->transaction_date=date('Y-m-d');
					$AccountingEntrieSGST->city_id=$InvoiceData->city_id;
					$AccountingEntrieSGST->entry_from="Web";
					$AccountingEntrieSGST->invoice_id=$InvoiceData->id;  
					if($gstAmtInsert > 0){
						$this->Challans->Invoices->Ledgers->AccountingEntries->save($AccountingEntrieSGST);
					}
				}else{
					$ItemData = $this->Challans->Invoices->InvoiceRows->Items->find()->where(['Items.id'=>$invoice_row->item_id])->first();
					$gstAmtInsert=round($invoice_row->gst_value,2);
					//Accounting Entries for IGST//
					 $gstLedgerIGST = $this->Challans->Invoices->Ledgers->find()
					->where(['Ledgers.gst_figure_id' =>$ItemData->gst_figure_id, 'Ledgers.input_output'=>'output', 'Ledgers.gst_type'=>'IGST','city_id'=>$InvoiceData->city_id])->first();
					$AccountingEntrieIGST = $this->Challans->Invoices->Ledgers->AccountingEntries->newEntity();
					$AccountingEntrieIGST->ledger_id=$gstLedgerIGST->id;
					$AccountingEntrieIGST->credit=$gstAmtInsert;
					$AccountingEntrieIGST->debit=0;
					$AccountingEntrieIGST->transaction_date=date('Y-m-d');
					$AccountingEntrieIGST->city_id=$InvoiceData->city_id;
					$AccountingEntrieIGST->entry_from="Web";
					$AccountingEntrieIGST->invoice_id=$InvoiceData->id;  
					if($gstAmtInsert > 0){
						$this->Challans->Invoices->Ledgers->AccountingEntries->save($AccountingEntrieIGST);
					}
				}
				
				//Stock Entry in Item Ledgers
				$orderDetailsData = $this->Challans->Invoices->InvoiceRows->get($invoice_row->id, [
					'contain' => ['ItemVariations']
				]);
				$totalPurchaseAmount+=$orderDetailsData->item_variation->purchase_rate;
				if(empty($InvoiceData->seller_id)){
					$ItemLedger = $this->Challans->Invoices->InvoiceRows->ItemLedgers->newEntity(); 
					$ItemLedger->item_id=$orderDetailsData->item_id; 
					$ItemLedger->unit_variation_id=$orderDetailsData->item_variation->unit_variation_id;
					$ItemLedger->item_variation_id=$orderDetailsData->item_variation_id;
					$ItemLedger->transaction_date=date('Y-m-d');  
					$ItemLedger->quantity=$invoice_row->quantity;
					$ItemLedger->rate=$invoice_row->net_amount/$invoice_row->quantity;
					$ItemLedger->amount=$invoice_row->quantity*$ItemLedger->rate;
					$ItemLedger->sale_rate=$invoice_row->rate;
					$ItemLedger->status="Out";
					$ItemLedger->city_id=$InvoiceData->city_id;
					$ItemLedger->location_id=$InvoiceData->location_id;
					$ItemLedger->invoice_id=$InvoiceData->id;
					$ItemLedger->invoice_row_id=$invoice_row->id; 
					$this->Challans->Invoices->InvoiceRows->ItemLedgers->save($ItemLedger);
				}
			}
			
			//Purchase Voucher
			if($InvoiceData->seller_id==2){
						$Voucher_no = $this->Challans->PurchaseVouchers->find()->select(['voucher_no'])->where(['city_id'=>$InvoiceData->city_id,'financial_year_id'=>$financial_year_id])->order(['voucher_no' => 'DESC'])->first();
						
						if($Voucher_no){
							$voucher_no=$Voucher_no->voucher_no+1;
						}else{
							$voucher_no=1;
						}
						
						$JournalVoucher = $this->Challans->PurchaseVouchers->newEntity();
						$JournalVoucher->voucher_no = $voucher_no;
						$JournalVoucher->city_id = $InvoiceData->city_id;
						$JournalVoucher->financial_year_id = $financial_year_id;
						$JournalVoucher->transaction_date = date('Y-m-d');
						$JournalVoucher->created_on = date('Y-m-d');
						$JournalVoucher->created_by =$user_id;
						$JournalVoucher->narration ="Customer COD Amount";
						$this->Challans->PurchaseVouchers->save($JournalVoucher);
							
						
						
						$SellerLedgerData = $this->Challans->Invoices->Ledgers->find()->where(['Ledgers.seller_id' =>$InvoiceData->seller_id,'Ledgers.city_id'=>$InvoiceData->city_id])->first();
						
						
						//Seller Accounting
						$JournalVoucherRow = $this->Challans->PurchaseVouchers->PurchaseVoucherRows->newEntity();
						$JournalVoucherRow->purchase_voucher_id = $JournalVoucher->id;
						$JournalVoucherRow->ledger_id = $SellerLedgerData->id;
						$JournalVoucherRow->cr_dr ="Cr";
						$JournalVoucherRow->credit = $totalPurchaseAmount;
						$JournalVoucherRow->debit =0;
						$this->Challans->PurchaseVouchers->PurchaseVoucherRows->save($JournalVoucherRow);
						$AccountingEntries1 = $this->Challans->PurchaseVouchers->AccountingEntries->newEntity();
						$AccountingEntries1->ledger_id = $SellerLedgerData->id;
						$AccountingEntries1->city_id = $InvoiceData->city_id;
						$AccountingEntries1->transaction_date = date('Y-m-d');
						$AccountingEntries1->credit = $totalPurchaseAmount;
						$AccountingEntries1->debit =0;
						$AccountingEntries1->purchase_voucher_id = $JournalVoucher->id;
						$this->Challans->PurchaseVouchers->AccountingEntries->save($AccountingEntries1);
						
						//Purchase Accounting
						$accountLedgers = $this->Challans->AccountingGroups->find()->where(['AccountingGroups.name'=>"Purchase Accounts",'AccountingGroups.city_id'=>$city_id])->first();
						
						$purchaseLedger= $this->Challans->Invoices->Ledgers->find()->where(['Ledgers.accounting_group_id' =>$accountLedgers->id])->first();
						
						$JournalVoucherRow = $this->Challans->PurchaseVouchers->PurchaseVoucherRows->newEntity();
						$JournalVoucherRow->purchase_voucher_id = $JournalVoucher->id;
						$JournalVoucherRow->ledger_id = $purchaseLedger->id;
						$JournalVoucherRow->cr_dr ="Dr";
						$JournalVoucherRow->debit = $totalPurchaseAmount;
						$JournalVoucherRow->credit =0;
						$this->Challans->PurchaseVouchers->PurchaseVoucherRows->save($JournalVoucherRow);
						$AccountingEntries1 = $this->Challans->PurchaseVouchers->AccountingEntries->newEntity();
						$AccountingEntries1->ledger_id = $purchaseLedger->id;
						$AccountingEntries1->city_id = $InvoiceData->city_id;
						$AccountingEntries1->transaction_date = date('Y-m-d');
						$AccountingEntries1->debit = $totalPurchaseAmount;
						$AccountingEntries1->credit =0;
						$AccountingEntries1->purchase_voucher_id = $JournalVoucher->id;
						$this->Challans->PurchaseVouchers->AccountingEntries->save($AccountingEntries1);
						
						
						if($SellerLedgerData->bill_to_bill_accounting=="yes"){
							$ReferenceDetail = $this->Challans->PurchaseVouchers->ReferenceDetails->newEntity(); 
							$ReferenceDetail->ledger_id=$SellerLedgerData->id;
							$ReferenceDetail->debit=0;
							$ReferenceDetail->credit=$totalPurchaseAmount;
							$ReferenceDetail->transaction_date=date('Y-m-d');
							$ReferenceDetail->city_id=$InvoiceData->city_id;
							$ReferenceDetail->entry_from="Web";
							$ReferenceDetail->type='New Ref';
							$ReferenceDetail->ref_name=$InvoiceData->invoice_no;
							$ReferenceDetail->purchase_voucher_id=$JournalVoucher->id;//pr($ReferenceDetail); exit;
							$this->Challans->PurchaseVouchers->ReferenceDetails->save($ReferenceDetail);
						}
					//	pr($JournalVoucher); exit;
					}
			
			$query = $this->Challans->query();
			$query->update()
					->set(['order_status'=>'Delivered','delivery_date'=>date('Y-m-d')])
					->where(['id'=>$InvoiceData->challan_id])
					->execute(); 
			
			$query = $this->Challans->Orders->query();
			$query->update()
					->set(['is_applicable_for_cancel'=>'No','delivery_date'=>date('Y-m-d')])
					->where(['id'=>$InvoiceData->order_id])
					->execute(); 
			
			
			//Updating in order
			$Challans=$this->Challans->find()->where(['Challans.order_id'=>$InvoiceData->order_id]);
			$totalOrder=(sizeof($Challans->toArray()));
			
			if($totalOrder==1){
				$query = $this->Challans->Orders->query();
				$query->update()
					->set(['order_status'=>'Delivered'])
					->where(['id'=>$InvoiceData->order_id])
					->execute();
					
				$InvoiceRows=$this->Challans->Invoices->InvoiceRows->find()->where(['InvoiceRows.invoice_id'=>$InvoiceData->id]);
				foreach($InvoiceRows as $dt){ 
					$query = $this->Challans->Orders->OrderDetails->query();
					$query->update()
						->set(['item_status'=>'Delivered'])
						->where(['id'=>$dt->order_detail_id])
						->execute();
				}
			}else{
				$order_status="Delivered";
				foreach($Challans as $data){
					if($data->order_status =="placed" || $data->order_status =="Packed" || $data->order_status =="Dispatched"){
						$order_status="Dispatched";
					}
				}
				$InvoiceRows=$this->Challans->Invoices->InvoiceRows->find()->where(['InvoiceRows.invoice_id'=>$InvoiceData->id]);
				foreach($InvoiceRows as $dt){ 
					$query = $this->Challans->Orders->OrderDetails->query();
					$query->update()
						->set(['item_status'=>'Delivered'])
						->where(['id'=>$dt->order_detail_id])
						->execute();
				}
				
				if($order_status=="Delivered"){
					$query = $this->Challans->Orders->query();
					$query->update()
						->set(['order_status'=>'Delivered'])
						->where(['id'=>$InvoiceData->order_id])
						->execute();
				}
			}
			
						
//////////////Notification//Code///Start//////////////////
	$customer=$this->Challans->Customers->get($Challan->customer_id);
	$mob=$customer->username;
	$main_device_token1=$customer->device_token;
		 
		if((!empty($main_device_token1))){
		
			$device_token=$main_device_token1;
		}
		
	if(!empty($main_device_token1)){
			$tokens = array($device_token);
			$random=(string)mt_rand(1000,9999);
			$header = [
				'Content-Type:application/json',
				'Authorization: Key=AAAAXmNqxY4:APA91bG0X6RHVhwJKXUQGNSSCas44hruFdR6_CFd6WHPwx9abUr-WsrfEzsFInJawElgrp24QzaE4ksfmXu6kmIL6JG3yP487fierMys5byv-I1agRtMPIoSqdgCZf8R0iqsnds-u4CU'
			];

			$msg = [
				'title'=> 'Challan Deliver',
				'message' => 'Your Challan has Been Delivered',
				'image' => '',
				'link' => 'jainthela://order?id='.$InvoiceData->order_id,
				'notification_id'    => $random,
			];
			
			$payload = array(
				'registration_ids' => $tokens,
				'data' => $msg
			);
			
			$curl = curl_init();
			curl_setopt_array($curl, array(
			  CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS => json_encode($payload),
			  CURLOPT_HTTPHEADER => $header
			));
			$response = curl_exec($curl);
			$err = curl_error($curl);
			curl_close($curl);
			$final_result=json_decode($response);
			$sms_flag=$final_result->success; 	
			if ($err) {
			  //echo "cURL Error #:" . $err;
			} else {
			  //$response;
			}	


			$orderLink = 'jainthela://order?id='.$InvoiceData->order_id;			
			$url = 'https://fcm.googleapis.com/fcm/send';
			
			$fcmRegIds = array();
			$fields = [
				"notification" => ["title" => "Challan Deliver", "text" => "Your Challan has Been Delivered","sound" => "default",'notification_id'=>$random,"link" =>$orderLink],
				"content_available" => true,
				"priority" => "high",
				"data" => ["link" => $orderLink,"sound" => "default",'notification_id'=>$random],
				"to" => $device_token,
			];


			define('GOOGLE_API_KEY', 'AAAAXmNqxY4:APA91bG0X6RHVhwJKXUQGNSSCas44hruFdR6_CFd6WHPwx9abUr-WsrfEzsFInJawElgrp24QzaE4ksfmXu6kmIL6JG3yP487fierMys5byv-I1agRtMPIoSqdgCZf8R0iqsnds-u4CU');

				$headers = array(
					'Authorization:key='.GOOGLE_API_KEY,
					'Content-Type: application/json'
				);
 			
			$curl = curl_init();
			curl_setopt_array($curl, array(
			  CURLOPT_URL => $url,
			  CURLOPT_SSL_VERIFYPEER => false,
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS => json_encode($fields),
			  CURLOPT_HTTPHEADER => $headers
			));
			curl_exec($curl);
			$err = curl_error($curl);
			curl_close($curl);
			
		
		}
	//////////////Notification//Code///end../////////////////
	
	$sms=str_replace(' ', '+', 'Your Challan has been Delivered');
	$sms_sender='JAINTE';
	$sms=str_replace(' ', '+', $sms);
	//file_get_contents('http://103.39.134.40/api/mt/SendSMS?user=phppoetsit&password=9829041695&senderid='.$sms_sender.'&channel=Trans&DCS=0&flashsms=0&number='.$mob.'&text='.$sms.'&route=7');	
			
			 return $this->redirect(['action' => 'manageOrder']);
			
		}
		$where=[];
		if($status=="delivered" || $status=="cancel" || $status=="return"){
			$where['Challans.order_status']='%'.$status.'%';
		}else{
			$status='';
		}
		
		if(!empty($status)){
			$order_data=$this->Challans->find()->where(['Challans.order_status'=>$status])->order(['Challans.id'=>'DESC'])->contain(['Orders','SellerLedgers','PartyLedgers','Locations','Customers','CustomerAddressesLeft','Drivers','ChallanRows'=>['Items'=>'Categories']])->where(['Challans.city_id'=>$city_id])->where($where_get);
		}else{
			//exit;
			$order_data=$this->Challans->find()->order(['Challans.id'=>'DESC'])->contain(['Orders','SellerLedgers','PartyLedgers','Locations','Customers','CustomerAddressesLeft','Drivers','ChallanRows'=>['Items'=>'Categories']])->where(['Challans.city_id'=>$city_id,'Challans.order_status !='=>'Cancel'])->where(['Challans.order_status !='=>'Delivered'])->where($where_get);
		}
		
		if(empty($status) || $status=="pending"){
			$TotalChallanQty=$this->Challans->find()
			->select(['order_id','total_challan'=>$this->Challans->find()->func()->count('Challans.id')])
			->group(['Challans.order_id'])
			->where(['Challans.city_id'=>$city_id,'Challans.order_status !='=>'Delivered'])
			->andWhere(['Challans.city_id'=>$city_id,'Challans.order_status !='=>'Cancel'])
			->toArray();
		}else if($status==$status){
			$TotalChallanQty=$this->Challans->find()
			->select(['order_id','total_challan'=>$this->Challans->find()->func()->count('Challans.id')])
			->group(['Challans.order_id'])
			->where(['Challans.city_id'=>$city_id,'Challans.order_status'=>$status])
			->toArray();
		}
		
		$TotalChallans=[];
		foreach($TotalChallanQty as $data){
				$TotalChallans[$data->order_id]=$data->total_challan;
		}
		
		//filter
		if ($this->request->is(['get'])){
			$search=$this->request->getQuery('search');
			$status1=$this->request->getQuery('status1');
			$order_data->where([
							'OR' => [
									'Challans.order_type LIKE' => $search.'%',
									'Orders.order_no LIKE' =>'%'.$search.'%',
									'Challans.invoice_no LIKE' =>'%'.$search.'%',
									'Challans.pay_amount LIKE' =>'%'.$search.'%',
									'Customers.name LIKE' => '%'.$search.'%'
									
							]
			]);
			
		}

		$Fruits="Fruits";
		$Vegetables="Vegetables";
		$fruitId=$this->Challans->ChallanRows->Items->Categories->find()->where(['name LIKE' =>'%'. $Fruits.'%','city_id'=>$city_id])->first();
		$VegetableId=$this->Challans->ChallanRows->Items->Categories->find()->where(['name LIKE' =>'%'. $Vegetables.'%','city_id'=>$city_id])->first();
		$Fruits = $this->Challans->ChallanRows->Items->Categories
				->find('children', ['for' =>$fruitId->id])->select(['id'])
				->toArray();
		$Vegetables = $this->Challans->ChallanRows->Items->Categories
				->find('children', ['for' =>$VegetableId->id])->select(['id'])
				->toArray();
		$FruitsVegetables=array_merge($Fruits,$Vegetables);
		$AllCategories=[];
		$AllCategories=[$fruitId->id,$VegetableId->id];
		foreach($FruitsVegetables as $data){
			$AllCategories[]=$data->id;
		}

		//pr($AllCategories);exit;	
		
		//pr($order_data->toArray()); exit;
		$drivers=$this->Challans->Drivers->find('list')->where(['Drivers.status'=>'Active'])->contain(['Locations'=>function ($q) use($city_id){
							return $q->where(['Locations.city_id'=>$city_id]);
						}]);
		$cancelReasons=$this->Challans->CancelReasons->find('list')->where(['CancelReasons.city_id'=>$city_id,'CancelReasons.status'=>'Active']);		
		 //pr($order_data->toArray()); exit;
        $orders = $this->paginate($order_data);
		//pr( $orders->toArray()); exit;
		
		if(empty($from_date) || empty($to_date))
		{
			$from_date = date("Y-m-d");
			$to_date   = date("Y-m-d");
		}else{
			$from_date = date("Y-m-d",strtotime($from_date));
			$to_date= date("Y-m-d",strtotime($to_date));
		}
		//pr($status); exit;
		$paginate_limit=$this->paginate['limit'];
        $this->set(compact('orders','paginate_limit','status','status1','drivers','cancelReasons','AllCategories','TotalChallans','Routes','RouteWiseChallan','ChallanWiseRoute','from_date','to_date','user_type'));
    }
	
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Orders', 'Locations', 'Sellers', 'FinancialYears', 'Cities', 'SalesLedgers', 'PartyLedgers', 'Customers', 'Drivers', 'CustomerAddresses', 'PromotionDetails', 'DeliveryCharges', 'DeliveryTimes', 'CancelReasons']
        ];
        $challans = $this->paginate($this->Challans);
		
        $this->set(compact('challans'));
    }

    /**
     * View method
     *
     * @param string|null $id Challan id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
		$ids = $this->EncryptingDecrypting->decryptData($id);
		
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id'); 
		$user_type =$this->Auth->User('user_type');
		$state_id=$this->Auth->User('state_id'); 
		if($user_type=="Super Admin"){
			$this->viewBuilder()->layout('super_admin_layout');	
		}else if($user_type=="Admin"){ 
			$this->viewBuilder()->layout('admin_portal');
		}
		 
		$CityData = $this->Challans->Cities->get($city_id);
		$StateData = $this->Challans->Cities->States->get($CityData->state_id);
	 
		$this->loadmodel('SalesOrders');
		$sales_orders=$this->Challans->find()->where(['Challans.id'=>$ids])->contain(['Orders','Drivers','ChallanRows'=>['ItemVariations'=>['ItemVariationMasters','Items','UnitVariations'=>['Units']]], 'Customers'=>['CustomerAddresses']])->first();
		 
		//pr($sales_orders->toArray());
		$company_details=$this->Challans->Companies->find()->where(['Companies.city_id'=>$city_id])->first();
        $this->set(compact('ids', 'sales_orders', 'order', 'locations', 'customers', 'drivers', 'customerAddresses', 'promotionDetails', 'deliveryCharges', 'deliveryTimes', 'cancelReasons','order_no','partyOptions','Accountledgers','items','company_details'));
    }
	
	 public function challanView($id = null)
    {
		$ids = $this->EncryptingDecrypting->decryptData($id);
		
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id'); 
		$user_type =$this->Auth->User('user_type');
		$state_id=$this->Auth->User('state_id'); 
		if($user_type=="Super Admin"){
			$this->viewBuilder()->layout('super_admin_layout');
		}else if($user_type=="Admin"){ 
			$this->viewBuilder()->layout('admin_portal');
		}else{
			$this->viewBuilder()->layout('seller_layout');
		}
		 
		$CityData = $this->Challans->Cities->get($city_id);
		$StateData = $this->Challans->Cities->States->get($CityData->state_id);


		$sales_orders=$this->Challans->find()->where(['Challans.id'=>$ids])->contain(['Orders','Drivers', 'Customers'=>['CustomerAddresses'],'ChallanRows'=> function ($q) {
			return $q->where(['is_item_cancel' => 'No'])->contain(['ItemVariations'=>['ItemVariationMasters','Items','UnitVariations'=>['Units']]]);
		} ])->first();

	 
		$this->loadmodel('SalesOrders');
		$challan=$this->Challans->find()->where(['Challans.id'=>$ids])->contain(['Orders','Drivers','Customers'=>['CustomerAddresses'],'CustomerAddresses','ChallanRows'=>
		function($q) {
			return $q->contain(['ItemVariations'=>['ItemVariationMasters','Items','UnitVariations'=>['Units']]]);
		}])->first();
		 
		 //pr($challan); exit;
		
		$company_details=$this->Challans->Companies->find()->where(['Companies.city_id'=>$city_id])->first();
        $this->set(compact('ids', 'challan', 'order', 'locations', 'customers', 'drivers', 'customerAddresses', 'promotionDetails', 'deliveryCharges', 'deliveryTimes', 'cancelReasons','order_no','partyOptions','Accountledgers','items','company_details'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $challan = $this->Challans->newEntity();
        if ($this->request->is('post')) {
            $challan = $this->Challans->patchEntity($challan, $this->request->getData());
            if ($this->Challans->save($challan)) {
                $this->Flash->success(__('The challan has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The challan could not be saved. Please, try again.'));
        }
        $orders = $this->Challans->Orders->find('list', ['limit' => 200]);
        $locations = $this->Challans->Locations->find('list', ['limit' => 200]);
        $sellers = $this->Challans->Sellers->find('list', ['limit' => 200]);
        $financialYears = $this->Challans->FinancialYears->find('list', ['limit' => 200]);
        $cities = $this->Challans->Cities->find('list', ['limit' => 200]);
        $salesLedgers = $this->Challans->SalesLedgers->find('list', ['limit' => 200]);
        $partyLedgers = $this->Challans->PartyLedgers->find('list', ['limit' => 200]);
        $customers = $this->Challans->Customers->find('list', ['limit' => 200]);
        $drivers = $this->Challans->Drivers->find('list', ['limit' => 200]);
        $customerAddresses = $this->Challans->CustomerAddresses->find('list', ['limit' => 200]);
        $promotionDetails = $this->Challans->PromotionDetails->find('list', ['limit' => 200]);
        $deliveryCharges = $this->Challans->DeliveryCharges->find('list', ['limit' => 200]);
        $deliveryTimes = $this->Challans->DeliveryTimes->find('list', ['limit' => 200]);
        $cancelReasons = $this->Challans->CancelReasons->find('list', ['limit' => 200]);
        $this->set(compact('challan', 'orders', 'locations', 'sellers', 'financialYears', 'cities', 'salesLedgers', 'partyLedgers', 'customers', 'drivers', 'customerAddresses', 'promotionDetails', 'deliveryCharges', 'deliveryTimes', 'cancelReasons'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Challan id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $challan = $this->Challans->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $challan = $this->Challans->patchEntity($challan, $this->request->getData());
            if ($this->Challans->save($challan)) {
                $this->Flash->success(__('The challan has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The challan could not be saved. Please, try again.'));
        }
        $orders = $this->Challans->Orders->find('list', ['limit' => 200]);
        $locations = $this->Challans->Locations->find('list', ['limit' => 200]);
        $sellers = $this->Challans->Sellers->find('list', ['limit' => 200]);
        $financialYears = $this->Challans->FinancialYears->find('list', ['limit' => 200]);
        $cities = $this->Challans->Cities->find('list', ['limit' => 200]);
        $salesLedgers = $this->Challans->SalesLedgers->find('list', ['limit' => 200]);
        $partyLedgers = $this->Challans->PartyLedgers->find('list', ['limit' => 200]);
        $customers = $this->Challans->Customers->find('list', ['limit' => 200]);
        $drivers = $this->Challans->Drivers->find('list', ['limit' => 200]);
        $customerAddresses = $this->Challans->CustomerAddresses->find('list', ['limit' => 200]);
        $promotionDetails = $this->Challans->PromotionDetails->find('list', ['limit' => 200]);
        $deliveryCharges = $this->Challans->DeliveryCharges->find('list', ['limit' => 200]);
        $deliveryTimes = $this->Challans->DeliveryTimes->find('list', ['limit' => 200]);
        $cancelReasons = $this->Challans->CancelReasons->find('list', ['limit' => 200]);
        $this->set(compact('challan', 'orders', 'locations', 'sellers', 'financialYears', 'cities', 'salesLedgers', 'partyLedgers', 'customers', 'drivers', 'customerAddresses', 'promotionDetails', 'deliveryCharges', 'deliveryTimes', 'cancelReasons'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Challan id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $challan = $this->Challans->get($id);
        if ($this->Challans->delete($challan)) {
            $this->Flash->success(__('The challan has been deleted.'));
        } else {
            $this->Flash->error(__('The challan could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
	
		
	 public function itemRecive($id = null){
		 
		$this->request->allowMethod(['post', 'delete']);
        $ChallanRows = $this->Challans->ChallanRows->get($id);
		
		$ItemVariationData = $this->Challans->ChallanRows->ItemVariations->get($ChallanRows->item_variation_id);
		
		$current_stock=$ItemVariationData->current_stock-$ChallanRows->quantity;
		$cs=$ItemVariationData->current_stock;
		$vs=$ItemVariationData->virtual_stock;
		$demand_stock=$ItemVariationData->demand_stock;
		$actual_quantity=$ChallanRows->quantity;
		$final_current_stock=0;
		$final_demand_stock=0;
		//pr($addQty); exit;
		if($demand_stock==0){
			$final_current_stock=$cs+$ChallanRows->quantity;
			$final_demand_stock=$demand_stock;
		}elseif($demand_stock > $actual_quantity){
			$final_current_stock=0;
			$final_demand_stock=$demand_stock-$ChallanRows->quantity;
		}elseif($demand_stock < $actual_quantity){
			$final_current_stock=$actual_quantity-$demand_stock;
			$final_demand_stock=0;
		}
		
		$out_of_stock="No";
		$ready_to_sale="Yes";
		if(($final_current_stock==0) && ($vs==$final_demand_stock)){
			$ready_to_sale="No";
			$out_of_stock="Yes";
		}
		
		$query = $this->Challans->ChallanRows->ItemVariations->query();
		$query->update()
		->set(['current_stock'=>$final_current_stock,'demand_stock'=>$final_demand_stock,'out_of_stock'=>$out_of_stock,'ready_to_sale'=>$ready_to_sale])
		->where(['id'=>$ChallanRows->item_variation_id])
		->execute();
						
		$query1 = $this->Challans->ChallanRows->query();
		$query1->update()
		->set(['item_cancle_recive'=>'Yes'])
		->where(['ChallanRows.id'=>$id])
		->execute();	
		
		return $this->redirect(['action' => 'cancelItem']);
		 
	 }
	 public function cancelItem()
    {
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id');
		$location_id=$this->Auth->User('location_id');
		$status = $this->request->query('status');
		$user_type =$this->Auth->User('user_type');
		$financial_year_id=$this->Auth->User('financial_year_id');

		if($user_type=="Super Admin"){
		$this->viewBuilder()->layout('super_admin_layout');
		}else if($user_type=="Admin"){ 
		$this->viewBuilder()->layout('admin_portal');
		}
		
		$challanRows = $this->Challans->ChallanRows->find()->where(['item_cancle_recive'=>'No'])->contain(['ItemVariations'=>['UnitVariations'],'Items','Challans'=>['Drivers']])->toArray();
		//pr($challanRows); exit;
		$this->set(compact('challanRows'));
	}
}
