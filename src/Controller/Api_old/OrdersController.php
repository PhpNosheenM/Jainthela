<?php
namespace App\Controller\Api;
use Cake\Event\Event;
use Cake\Network\Exception\UnauthorizedException;
use Cake\Utility\Security;
use Firebase\JWT\JWT;
use Cake\Routing\Router;

class OrdersController extends AppController
{
	
	public function initialize()
	{
		parent::initialize();
		$this->Auth->allow(['DriverOrderList','CustomerVerify','DriverOrderStatus','DriverOrderDetail','ItemWiseCancelOrder','CustomerItemWiseCancel']);
	}	
	
    public function CustomerOrder()
    {
      $city_id=$this->request->query('city_id');
      $customer_id=$this->request->query('customer_id');
      $orders_data = $this->Orders->find()
      ->where(['Orders.customer_id' => $customer_id,'Orders.city_id'=>$city_id])
      ->order(['Orders.id' => 'DESC'])
      ->autoFields(true);

      
      $grand_total1=0;
		//pr($orders_data->toArray());exit;
      if(!empty($orders_data->toArray()))
      {	
  			foreach($orders_data as $order)
  			{
				$order->total_amount = round($order->total_amount);
				$payableAmount = number_format(0, 2);
  				$grand_total1 =$order->grand_total;
				$grand_total=number_format(round($grand_total1), 2);
				$payableAmount = $payableAmount + $grand_total1;

				
				$payableAmount = number_format($payableAmount,2);

					if(empty($order->delivery_charge_amount))
					{
						$order->delivery_charge_amount = 'Free';
					}
				
				  //$order->delivery_charge_amount = $delivery_charge_amount;
				 // $order->grand_total = $grand_total;
				  $order->payableAmount = $payableAmount;

			}

        $success = true;
        $message = 'Data found successfully';
      }else{
        $success = false;
        $message = 'No data found';
      }
      $this->set(compact('success','message','orders_data'));
      $this->set('_serialize', ['success','message','orders_data']);
    }

    public function OrderDetail()
    {
		$first_url=Router::url('/', true);
        $customer_id=$this->request->query('customer_id');
    	$order_id=$this->request->query('order_id');
        $city_id=$this->request->query('city_id');
		$final_url=$first_url.'orders/pdf_order?id='.$order_id;
		
        $orders_details_data = $this->Orders->find()
          ->contain(['OrderDetails'=> function($q) {
			  return $q->where(['combo_offer_id' =>0])
			  ->contain(['ItemVariations'=> function ($q){
				 return $q->contain(['ItemVariationMasters','Items','UnitVariations'=>['Units']]);
			  } ]);
		  }])->where(['Orders.id'=>$order_id,'Orders.customer_id'=>$customer_id]);

          $payableAmount = number_format(0, 2);
          $grand_total1=0;
		  $order_details = [];
        if(!empty($orders_details_data->toArray()))
        {
          //pr($orders_details_data->toArray());exit;
          foreach ($orders_details_data as  $orders_detail) {
              $customer_address_id = $orders_detail->customer_address_id;
              foreach ($orders_detail->order_details as $data) {
                  $count_cart = $this->Orders->Carts->find()->select(['Carts.cart_count'])->where(['Carts.item_variation_id'=>$data->item_variation->id,'Carts.customer_id'=>$customer_id]);
                    $data->item_variation->cart_count = 0;
                    $count_value = 0;
                    foreach ($count_cart as $count) {
                      $count_value = $count->cart_count;
                    }
                    $data->item_variation->cart_count = $count_value;
              }
          }

          $customer_addresses=$this->Orders->CustomerAddresses->find()
            ->where(['CustomerAddresses.customer_id' => $customer_id, 'CustomerAddresses.id'=>$customer_address_id])->first();

          $categories = $this->Orders->find()
          ->where(['customer_id' => $customer_id])
          ->contain(['OrderDetails'=>['ItemVariations'=>['ItemVariationMasters','Items'=>['Categories']]]]);
			$category = [];
          if(!empty($categories->toArray()))
          {
              $category_arr = [];
              foreach ($categories as $cat_date) {
                foreach ($cat_date->order_details as $order_data) {
                  $cat_name = $order_data->item_variation->item->category->name;
                  $cat_id = $order_data->item_variation->item->category->id;
                  $category_arr[$cat_id] = $cat_name;
                }
              }

              foreach ($category_arr as $cat_key => $cat_value) {
                foreach ($orders_details_data as $order_data) {
                    foreach ($order_data->order_details as $data) {
                        $order_category_id = $data->item_variation->item->category_id;
                        if($cat_key == $order_category_id)
                        {
                          $category[$cat_key][] = $data;
                        }
                    }
                }
              }

              foreach ($category as $key => $value) {
				$total_cat_wise = 0.00;			
				foreach($value as $arrData)
				{
					$total_cat_wise = $total_cat_wise + $arrData->net_amount;	
				}				  
                $order_details[] = ['category_name'=>$category_arr[$key],'total_cat_wise'=>$total_cat_wise,'category'=>$value];
              }
			
              $getAmounts = $this->Orders->OrderDetails->find()->select(['combo_offer_id','quantity','rate','amount','net_amount'])
                ->innerJoinWith('ComboOffers')
                ->where(['order_id' => $order_id])
                ->where(['combo_offer_id !=' =>0])->toArray();
			  
			  //pr($getAmounts);exit;
			  
			  $comboData =[];
              $comboData = $this->Orders->OrderDetails->find()
                ->innerJoinWith('ComboOffers')
                ->where(['order_id' => $order_id])
                ->where(['combo_offer_id !=' =>0])
				->contain(['ComboOffers'=>['ComboOfferDetails']])
                ->group('OrderDetails.combo_offer_id')->autoFields(true)->toArray();
				if(empty($comboData)) 
				{ $comboData = []; }
				else 
				{ 
					foreach($comboData as $comboDataValue)
					{	
					  $comboDataValue->combo_item_count = sizeof($comboDataValue->combo_offer->combo_offer_details);
					  $comboDataValue->combo_Price = 0.00;
					  
					  if(!empty($getAmounts))
					  {
						  foreach($getAmounts as $getAmount)
						  {
							if($getAmount->combo_offer_id == $comboDataValue->combo_offer_id)
							{
							  // $comboDataValue->combo_Price =  $comboDataValue->combo_Price + $getAmount->amount; 
							  $comboDataValue->combo_Price =  $comboDataValue->combo_Price + $getAmount->net_amount;
							}								
						  }
					  }
					} 
				}
            
              foreach($orders_details_data as $order_data) {
                $order_data->comboData = $comboData;
                $order_data->order_details = $order_details;
                $orders_details_data = $order_data;
				$order_data->total_amount = round($order_data->total_amount);
                $grand_total1 += $order_data->total_amount;
				$order_data->url=$final_url;
				if(empty($order_data->delivery_charge_amount)){
					$delivery_charge_amount = "free";
				}else {
				  $delivery_charge_amount =	$order_data->delivery_charge_amount;
				}
				
              }
				$grand_total=number_format(round($order_data->grand_total), 2);
          		$payableAmount = $payableAmount + $grand_total1;
				$payableAmount = $order_data->pay_amount;
				
         }
          $success = true;
          $message = 'Data found successfully';

        }else{
          $success = false;
          $message = 'No data found';
          $orders_details_data = [];
          $customer_addresses = [];
        }
        $cancellation_reasons=$this->Orders->CancelReasons->find();
        $this->set(compact('success', 'message','grand_total','delivery_charge_amount','payableAmount','orders_details_data','customer_addresses','cancellation_reasons'));
        $this->set('_serialize', ['success', 'message','grand_total','delivery_charge_amount','payableAmount','orders_details_data','customer_addresses','cancellation_reasons']);
    }

    public function CancelOrder()
    {
        $customer_id=$this->request->query('customer_id');
        $order_id=$this->request->query('order_id');
        $cancel_reason_id=$this->request->query('cancel_reason_id');
		$odrer_datas=$this->Orders->get($order_id);
		$amount_from_wallet=$odrer_datas->amount_from_wallet;
		$online_amount=$odrer_datas->online_amount;
		$return_amount=$amount_from_wallet+$online_amount;
        $order_type = $odrer_datas->order_type;
        $other_reason = $odrer_datas->other_reason;
        $city_id = $odrer_datas->city_id;
        $cancel_date = date('Y-m-d');
        $order_cancel = $this->Orders->query();

        $result = $order_cancel->update()
					->set(['order_status' => 'Cancel','cancel_reason_id' => $cancel_reason_id, 'cancel_date' => $cancel_date,'cancel_reason_other'=>$other_reason])
					->where(['id' => $order_id])->execute();

		
		
		//////////////////Stock///UP////////////////
		$order_details=$this->Orders->OrderDetails->find()->where(['OrderDetails.order_id'=>$order_id]);
	
		foreach($order_details as $order_detail){
			if($order_detail->is_item_cancel == 'No'){
			$item= $this->Orders->OrderDetails->ItemVariations->Items->get($order_detail->item_id);
				if($item->item_maintain_by=="itemwise"){
					$allItemVariations= $this->Orders->OrderDetails->ItemVariations->find()->where(['ItemVariations.item_id'=>$order_detail->item_id,'ItemVariations.city_id'=>@$city_id,'ItemVariations.seller_id IS NULL'])->contain(['UnitVariations'=>['Units']]);
					$ItemVariationData= $this->Orders->OrderDetails->ItemVariations->get($order_detail->item_variation_id);
					$UnitVariation= $this->Orders->OrderDetails->ItemVariations->UnitVariations->get($ItemVariationData->unit_variation_id);
					
					foreach($allItemVariations as $iv){ 
						$p=($UnitVariation->convert_unit_qty*$order_detail->quantity); 
						$addQty=($p/$iv->unit_variation->convert_unit_qty); 
						$addQty=round($addQty,2);
						$item_variation_data = $this->Orders->OrderDetails->ItemVariations->get($iv->id);
						
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
						$query = $this->Orders->OrderDetails->ItemVariations->query();
						$query->update()
						->set(['current_stock'=>$final_current_stock,'demand_stock'=>$final_demand_stock,'out_of_stock'=>$out_of_stock,'ready_to_sale'=>$ready_to_sale])
						->where(['id'=>$iv->id])
						->execute(); 
					}
				}else{
					$ItemVariationData = $this->Orders->OrderDetails->ItemVariations->get($order_detail->item_variation_id);
					$current_stock=$ItemVariationData->current_stock-$order_detail->quantity;
					$cs=$ItemVariationData->current_stock;
					$vs=$ItemVariationData->virtual_stock;
					$demand_stock=$ItemVariationData->demand_stock;
					$actual_quantity=$order_detail->quantity;
					$final_current_stock=0;
					$final_demand_stock=0;
					//pr($addQty); exit;
					if($demand_stock==0){
						$final_current_stock=$cs+$order_detail->quantity;
						$final_demand_stock=$demand_stock;
					}elseif($demand_stock > $actual_quantity){
						$final_current_stock=0;
						$final_demand_stock=$demand_stock-$order_detail->quantity;
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
					$query = $this->Orders->OrderDetails->ItemVariations->query();
					$query->update()
					->set(['current_stock'=>$final_current_stock,'demand_stock'=>$final_demand_stock,'out_of_stock'=>$out_of_stock,'ready_to_sale'=>$ready_to_sale])
					->where(['id'=>$order_detail->item_variation_id])
					->execute();
					}
			}
		}
		//////////////////Stock////////////////////
		
		
							
		$orderDetail = $this->Orders->OrderDetails->query();			
		$orderDetails  = $orderDetail->update()
					->set(['is_item_cancel' => 'Yes','item_status'=>'Cancel'])
					->where(['order_id' => $order_id])->execute();
					
        $challan_cancel = $this->Orders->Challans->query();

        $result_challan = $challan_cancel->update()
					->set(['order_status' => 'Cancel','cancel_reason_id' => $cancel_reason_id, 'cancel_date' => $cancel_date,'cancel_reason_other'=>$other_reason])
					->where(['order_id' => $order_id])->execute();					
		
		$challenRows = $this->Orders->Challans->find()->where(['order_id' => $order_id,'order_status' => 'Cancel']);
		
		if(!empty($challenRows->toArray()))
		{
			foreach($challenRows as $challenRow)
			{
				$challanDetail = $this->Orders->Challans->ChallanRows->query();			
				$challanDetails  = $challanDetail->update()->set(['is_item_cancel' => 'Yes'])
							->where(['challan_id' => $challenRow->id])->execute();				
			}
		}
		
        if($order_type != 'COD')
        {
            $query = $this->Orders->Wallets->query();
  					$query->insert(['city_id','customer_id', 'add_amount', 'narration','amount_type','return_order_id','transaction_type'])
  							->values(['city_id' =>$city_id,'customer_id' => $customer_id,'add_amount' => $return_amount,
							'amount_type' =>'Cancel Order','narration' => 'Amount Return form Order',
							'return_order_id' => $order_id,'transaction_type' => 'Added'])->execute();
        }

        $customer_details=$this->Orders->Customers->find()
  			->where(['Customers.id' => $customer_id])->first();

  			$mobile=$customer_details->username;
  			$sms=str_replace(' ', '+', 'Your order has been cancelled.' );
  			$sms_sender='JAINTE';
  			$sms=str_replace(' ', '+', $sms);
			//file_get_contents('http://103.39.134.40/api/mt/SendSMS?user=phppoetsit&password=9829041695&senderid='.$sms_sender.'&channel=Trans&DCS=0&flashsms=0&number='.$mobile.'&text='.$sms.'&route=7');

			$this->Sms->sendSms($mobile,$sms);

			
			/////////////////Notification////AND////////////////////////
		$customer_details=$this->Orders->Customers->find()
		->where(['Customers.id' => $customer_id])->first();
		$main_device_token1=$customer_details->device_token;
				 
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
				'title'=> 'Order Placed',
				'message' => 'Thank You, your order placed successfully',
				'image' => 'img/jain.png',
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
			//pr($payload);
			$final_result=json_decode($response);
			$sms_flag=$final_result->success; 	
			if ($err) {
			 // echo "cURL Error #:" . $err;
			} else {
			//	$response;
			}

			$orderLink = 'jainthela://order?id='.$order_id;			
			$url = 'https://fcm.googleapis.com/fcm/send';
			
			
			$fcmRegIds = array();
			$fields = [
				"notification" => ["title" => "Order Cancel", "text" => "Your order has been Cancelled successfully","sound" => "default",'notification_id'=>$random,"link" =>$orderLink],
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
			/////////////////Notification////END////////////////////////	
			
			//////////////////////SMS///Start//////////////////
	  
					$sms=str_replace(' ', '+', 'Your order has been cancelled');
					$sms_sender='JAINTE';
					$sms=str_replace(' ', '+', $sms);
					//file_get_contents('http://103.39.134.40/api/mt/SendSMS?user=phppoetsit&password=9829041695&senderid='.$sms_sender.'&channel=Trans&DCS=0&flashsms=0&number='.$mob.'&text='.$sms.'&route=7');
			//////////////////////SMS///ENd//////////////////
			
			$cancelOrderCount = $this->Orders->Customers->find()->select(['cancel_order_count'])
			->where(['id' => $customer_id])->first();
			$CountCancelOrder = $cancelOrderCount->cancel_order_count;
			$CountCancelOrder = $CountCancelOrder + 1;
			$customers = $this->Orders->Customers->query();
			$customers->update()->set(['cancel_order_count' => $CountCancelOrder])
			->where(['id' => $customer_id])->execute(); 

			
        $message='Thank you, your order has been cancelled.';
  		$success=true;
        $this->set(compact('success', 'message'));
        $this->set('_serialize', ['success', 'message']);

    }
	
	public function DriverOrderList()
	{
		$driver_id=$this->request->query('driver_id');
		$delivery_date=$this->request->query('delivery_date');
		$city_id=$this->request->query('city_id');
		$order_status=$this->request->query('order_status');
		if(!empty($city_id))
		{
			$cancel_order_limit = $this->Orders->MasterSetups->find()->select(['cancel_order_limit'])->where(['city_id' => $city_id])->first();
		
		$OrderCancelLimit = $cancel_order_limit->cancel_order_limit;
		
		if(!empty($delivery_date))
		{
			$dateFilter = ['Orders.delivery_date'=>$delivery_date];
		}
		else { $dateFilter = ''; }
		
		
		//pr($dateFilter);exit;
		
		
		  $orders_data = $this->Orders->find()
		  ->where(['Orders.driver_id'=>$driver_id])
		   ->where(['Orders.order_status'=>$order_status])
		   ->where($dateFilter)
		  ->contain(['CustomerAddresses','Customers'])
		  ->order(['Orders.order_date' => 'DESC'])
		  ->autoFields(true);
		  
		  

		  if(!empty($orders_data->toArray()))
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


	public function CustomerVerify()
	{

		$address_Mobile_no = $this->request->query('mobile_no');
		if(!empty($address_Mobile_no)){
			//$opt=(mt_rand(1111,9999));
			$opt= 1234;
			$content="Your one time password for order verification is ".$opt;
			//$this->Sms->sendSms($address_Mobile_no,$content);
			$success = true;
			$message = 'send otp successfully';
		}else{
			$success = false;
			$message = 'otp is not send';
			$opt = '';
		}

		$this->set(['success' => $success,'otp'=>$opt,'message'=>$message,'_serialize' => ['success','otp','message']]);	
	}

/* 	public function DriverOrderStatus()
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
		
		$this->Sms->sendSms($mobile,$sms);	
		
        $this->set(compact('success', 'message'));
        $this->set('_serialize', ['success', 'message']);		
	} */

	
    public function DriverOrderDetail()
    {
        $customer_id=$this->request->query('customer_id');
    		$order_id=$this->request->query('order_id');
        $city_id=$this->request->query('city_id');
        $orders_details_data = $this->Orders->find()
          ->contain(['OrderDetails'=> function($q){
			  return $q->where(['combo_offer_id' =>0,'is_item_cancel'=>'No'])
			  ->contain(['ItemVariations'=>['ItemVariationMasters','Items','UnitVariations'=>['Units']]]);
		  }])
          ->where(['Orders.id'=>$order_id,'Orders.customer_id'=>$customer_id]);
			$delivery_charge_amount = "0";
          $payableAmount = number_format(0, 2);
          $grand_total1=0;
			$order_details = [];
			
        if(!empty($orders_details_data->toArray()))
        { 
          
          foreach ($orders_details_data as  $orders_detail) {
              $customer_address_id = $orders_detail->customer_address_id;
              foreach ($orders_detail->order_details as $data) {
                  $count_cart = $this->Orders->Carts->find()->select(['Carts.cart_count'])->where(['Carts.item_variation_id'=>$data->item_variation->id,'Carts.customer_id'=>$customer_id]);
                    $data->item_variation->cart_count = 0;
                    $count_value = 0;
                    foreach ($count_cart as $count) {
                      $count_value = $count->cart_count;
                    }
                    $data->item_variation->cart_count = $count_value;
              }
          }

          $customer_addresses=$this->Orders->CustomerAddresses->find()
            ->where(['CustomerAddresses.customer_id' => $customer_id, 'CustomerAddresses.id'=>$customer_address_id])->first();


          $categories = $this->Orders->find()
          ->where(['customer_id' => $customer_id])
          ->contain(['OrderDetails'=>['ItemVariations'=>['ItemVariationMasters','Items'=>['Categories']]]]);
			$category = [];
          if(!empty($categories->toArray()))
          {
              $category_arr = [];
              foreach ($categories as $cat_date) {
                foreach ($cat_date->order_details as $order_data) {
                  $cat_name = $order_data->item_variation->item->category->name;
                  $cat_id = $order_data->item_variation->item->category->id;
                  $category_arr[$cat_id] = $cat_name;
                }
              }

              foreach ($category_arr as $cat_key => $cat_value) {
                foreach ($orders_details_data as $order_data) {
                    foreach ($order_data->order_details as $data) {
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

			/* $comboTotal = 0.00;
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
				} 
			*/		  
			  
			  
			  
              $comboData =[];
              $comboData = $this->Orders->OrderDetails->find()
                ->innerJoinWith('ComboOffers')
                ->where(['order_id' => $order_id,'is_item_cancel'=>'No'])
                ->contain(['ComboOffers'=>['ComboOfferDetails']])
                ->group('OrderDetails.combo_offer_id')->autoFields(true)->toArray();

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
                $order_data->order_details = $order_details;
                $orders_details_data = $order_data;
                $grand_total1 += $order_data->total_amount;
              }

			 // pr($orders_details_data);exit; array_replace($order_data->order_details,$order_details)

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
        $cancellation_reasons=$this->Orders->CancelReasons->find();
        $this->set(compact('success', 'message','grand_total','delivery_charge_amount','payableAmount','orders_details_data','customer_addresses','cancellation_reasons'));
        $this->set('_serialize', ['success', 'message','grand_total','delivery_charge_amount','payableAmount','orders_details_data','customer_addresses','cancellation_reasons']);
    }	

	public function placeOrder()
    {
      if ($this->request->is('post')) {
          $customer_address_id = $this->request->data['customer_address_id'];
          $customer_id = $this->request->data['customer_id'];
		  $delivery_date = date('Y-m-d',strtotime("+2 days"));
		  $isPromoCode = $this->request->data['isPromoCode'];
		  $promo_detail_id = $this->request->data['promotion_detail_id'];
          $location_data = $this->Orders->CustomerAddresses->find()
          ->select(['location_id'])->where(['id'=>$customer_address_id]);
            if(!empty($location_data->toArray()))
            {
              foreach ($location_data as $value) {
                $location_id = $value->location_id;
              }
            }
		
			$order = $this->Orders->newEntity();
        	$this->loadModel('Carts');
            $carts_data=$this->Carts->find()->where(['customer_id'=>$customer_id])
			->contain(['ItemVariationsData'=>['ItemsDatas'=>['GstFiguresData']],'ComboOffersData'=>['ComboOfferDetails'=>['ItemVariations'=>['Items'=>['GstFigures']]]]]);
			
            $i=0;
			//pr($carts_data->toArray());exit;
			if(!empty($carts_data->toArray()))
			{
				
			// Membership discount start			

				$memberShipDiscount = $this->Carts->Customers->find()
				->select(['membership_discount'])
				->where(['Customers.id' => $customer_id])
				->where(['Customers.start_date <='=> date('Y-m-d'),'Customers.end_date >='=> date('Y-m-d')])
				->first();
				
				$total_amount = 0.00;
				$total_membershipDsicount = 0.00;
				$total_promoDiscount = 0.00;
				$total_GST = 0.00;
				$net_amount = 0.00;
				$BothTaxableCmboItem = 0.00;
				$taxAbleAmount_Total = 0.00;
				$i=0;
				foreach($carts_data as $carts_data_fetch)
				{
					if(!empty($carts_data_fetch->combo_offers_data))
					{  $Combo_taxAbleAmount_Total = 0.00;
						foreach($carts_data_fetch->combo_offers_data->combo_offer_details as $combo_offer_detail)
						  {
							$comboItemDetails = $this->Carts->ItemVariations->find()->contain(['Items'])
								->where(['ItemVariations.id' =>$combo_offer_detail->item_variation_id])->first();	
								$amount = $combo_offer_detail->quantity * $combo_offer_detail->rate * $carts_data_fetch->quantity;								
								
								if(!empty($memberShipDiscount) && $memberShipDiscount->membership_discount > 0)
								{
									$combo_offer_detail->amount = $amount;
									$memberShipDiscount_Amount = $amount * $memberShipDiscount->membership_discount/100;
									$combo_offer_detail->memberShipDiscount_Percent = $memberShipDiscount->membership_discount;
									$combo_offer_detail->memberShipDiscount_Amount = number_format($memberShipDiscount_Amount,2,".","");
									$memberShipDiscount_Amount = number_format($memberShipDiscount_Amount,2,".","");
									$amountAfter_Membership = $amount - $memberShipDiscount_Amount;
									$combo_offer_detail->amountAfter_Membership = number_format($amountAfter_Membership,2,".","");
									$combo_offer_detail->taxAbleAmount = number_format($amountAfter_Membership,2,".","");												
								}
								else{
									   $combo_offer_detail->amount = $amount;	
									   $combo_offer_detail->memberShipDiscount_Percent = 0.00;
									   $combo_offer_detail->memberShipDiscount_Amount = 0.00;
									   $combo_offer_detail->amountAfter_Membership = $amount;
									   $combo_offer_detail->taxAbleAmount = number_format($amount,2,".","");								
								}																		
						  }	
					}else{
							$amount=$carts_data_fetch->cart_count * $carts_data_fetch->item_variations_data->sales_rate;
							if(!empty($memberShipDiscount) && $memberShipDiscount->membership_discount > 0)
							{
								if($carts_data_fetch->item_variations_data->items_data->is_discount_enable == 'Yes')
								{
									$carts_data_fetch->amount = $amount;
									$memberShipDiscount_Amount =  $amount * $memberShipDiscount->membership_discount / 100 ;
									$carts_data_fetch->memberShipDiscount_Percent = $memberShipDiscount->membership_discount;
									$carts_data_fetch->memberShipDiscount_Amount = number_format($memberShipDiscount_Amount,2,".","");
									$memberShipDiscount_Amount = number_format($memberShipDiscount_Amount,2,".","");
									$amountAfter_Membership = $amount - $memberShipDiscount_Amount;
									$carts_data_fetch->amountAfter_Membership = number_format($amountAfter_Membership,2,".","");
									$carts_data_fetch->taxAbleAmount = number_format($amountAfter_Membership,2,".","");
								}
								else{
									$carts_data_fetch->amount = $amount;
									$carts_data_fetch->memberShipDiscount_Percent = 0.00;
									$carts_data_fetch->memberShipDiscount_Amount = 0.00;
									$carts_data_fetch->amountAfter_Membership = $amount;
									$carts_data_fetch->taxAbleAmount = number_format($amount,2,".","");
								}						
							}
							else{
								$carts_data_fetch->amount = $amount;
								$carts_data_fetch->memberShipDiscount_Percent = 0.00;
								$carts_data_fetch->memberShipDiscount_Amount = 0.00;
								$carts_data_fetch->amountAfter_Membership = $amount;
								$carts_data_fetch->taxAbleAmount = number_format($amount,2,".","");
							}													
					} $i++;					
				}


				//pr($this->request->data['order_details']);exit;
				//pr($carts_data->toArray());exit;
				//echo $taxAbleAmount_Total;exit;
				
				if($isPromoCode == 'true'){
							$promotionDetails = $this->Carts->Promotions->PromotionDetails->find()
							->where(['id' =>$promo_detail_id])->first();
							//pr($promotionDetails);exit;
							//$taxAbleAmount_Total = 0.00;
							$discount_in_percentage = $promotionDetails->discount_in_percentage;
							$discount_of_max_amount = $promotionDetails->discount_of_max_amount;
							$promo_item_id = $promotionDetails->item_id;
							$promo_category_id = $promotionDetails->category_id;
							$promo_free_shipping = $promotionDetails->is_free_shipping;
							$cash_back = $promotionDetails->cash_back;
							$payableAmount = number_format(0, 2);
							//$Combo_taxAbleAmount_Total = 0.00;
							$promo_amount = 0;
							$Combo_taxAbleAmount_Total = 0.00;
								foreach($carts_data as $carts_data_fetch)
								{
									if(!empty($carts_data_fetch->combo_offers_data))
									{  
										foreach($carts_data_fetch->combo_offers_data->combo_offer_details as $combo_offer_detail)
										  {
											$comboItemDetails = $this->Carts->ItemVariations->find()->contain(['Items'])
												->where(['ItemVariations.id' =>$combo_offer_detail->item_variation_id])->first();	
											$cate_id = $comboItemDetails->item->category_id;
											$item_id = $comboItemDetails->item->id;
											if(!empty($promo_item_id) && $promo_item_id > 0)
											{
											  
											   if($item_id == $promo_item_id)
												{				
													$Combo_taxAbleAmount_Total = $Combo_taxAbleAmount_Total + $combo_offer_detail->taxAbleAmount;
												}		
											} 
											else if(!empty($promo_category_id) && $promo_category_id > 0 && $promo_item_id == 0)
											{   
												if($cate_id == $promo_category_id)
												{
													$Combo_taxAbleAmount_Total = $Combo_taxAbleAmount_Total + $combo_offer_detail->taxAbleAmount;
												}											
											}else{
												$Combo_taxAbleAmount_Total = $Combo_taxAbleAmount_Total + $combo_offer_detail->taxAbleAmount;
											}											
										  }	
									}else{
										if(!empty($promo_item_id) && $promo_item_id > 0)
										{
										  $item_id = $carts_data_fetch->item_variations_data->items_data->id;
										   if($item_id == $promo_item_id)
											{				
												if($carts_data_fetch->item_variations_data->items_data->is_discount_enable == 'Yes')
												{
													$taxAbleAmount_Total = $taxAbleAmount_Total + $carts_data_fetch->taxAbleAmount;
												}
											}		
										} else if(!empty($promo_category_id) && $promo_category_id > 0 && $promo_item_id == 0)
										{
											$cate_id = $carts_data_fetch->item_variations_data->items_data->category_id;
											if($cate_id == $promo_category_id)
											{
												if($carts_data_fetch->item_variations_data->items_data->is_discount_enable == 'Yes')
												{  
													$taxAbleAmount_Total = $taxAbleAmount_Total + $carts_data_fetch->taxAbleAmount;
												}
											}											
										}else {
											if($carts_data_fetch->item_variations_data->items_data->is_discount_enable == 'Yes')
											{
												$taxAbleAmount_Total = $taxAbleAmount_Total + $carts_data_fetch->taxAbleAmount;
											}
										}						
									}					
								}
								
								 $BothTaxableCmboItem = $Combo_taxAbleAmount_Total + $taxAbleAmount_Total;					
				}
				
				
				
				foreach($carts_data as $carts_data_fetch)
				{
					if(!empty($carts_data_fetch->combo_offers_data)){ 
					// $total_combo_qty=$carts_data_fetch->cart_count;
					 foreach($carts_data_fetch->combo_offers_data->combo_offer_details as $combo_offer_detail){
						 
						$comboItemDetails = $this->Carts->ItemVariations->find()
						->contain(['Items'])
						->where(['ItemVariations.id' =>$combo_offer_detail->item_variation_id])
						->first();
						   $item_id = $comboItemDetails->item->id;
						   //$combo_offer_detail->gst_percentage = $combo_offer_detail->gst_percentage;
						   $cate_id = $comboItemDetails->item->category_id;	
						   $quantity = $carts_data_fetch->quantity * $combo_offer_detail->quantity;	
								$this->request->data['order_details'][$i]['item_id']=$combo_offer_detail->item_variation->item_id;
								$this->request->data['order_details'][$i]['item_variation_id']=$combo_offer_detail->item_variation_id;
								$this->request->data['order_details'][$i]['combo_offer_id']=$carts_data_fetch->combo_offer_id;
								$this->request->data['order_details'][$i]['quantity']= $quantity; 
								$this->request->data['order_details'][$i]['rate']=$combo_offer_detail->rate;
								$this->request->data['order_details'][$i]['amount']=$combo_offer_detail->amount;												
								$this->request->data['order_details'][$i]['discount_percent']=$combo_offer_detail->memberShipDiscount_Percent;
								$this->request->data['order_details'][$i]['discount_amount']=$combo_offer_detail->memberShipDiscount_Amount;
						if($isPromoCode == 'true')
						{	
							$promotionDetails = $this->Carts->Promotions->PromotionDetails->find()
							->where(['id' =>$promo_detail_id])->first();
							//pr($promotionDetails);exit;
							//$taxAbleAmount_Total = 0.00;
							$discount_in_percentage = $promotionDetails->discount_in_percentage;
							$discount_of_max_amount = $promotionDetails->discount_of_max_amount;
							$promo_item_id = $promotionDetails->item_id;
							$promo_category_id = $promotionDetails->category_id;
							$promo_free_shipping = $promotionDetails->is_free_shipping;
							$cash_back = $promotionDetails->cash_back;
							$payableAmount = number_format(0, 2);
							//$Combo_taxAbleAmount_Total = 0.00;
							$promo_amount = 0;
							
									if($cash_back == 0){
										if($discount_in_percentage == 0)
										{
											if($promo_category_id > 0 && $promo_category_id == $cate_id && $promo_item_id == 0 && $discount_of_max_amount ==0)
											{												
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
											}
											else if($promo_item_id > 0  && $promo_item_id == $item_id && $discount_of_max_amount == 0){
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
											}
											else if($discount_of_max_amount > 0 && $BothTaxableCmboItem >= $discount_of_max_amount && $promo_item_id == 0 && $promo_category_id ==0){
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
											}
											else if($promo_category_id == 0 && $promo_item_id == 0 && $discount_of_max_amount ==0){
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
											}else{
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
											}
										}else{
											if($promo_category_id > 0 && $promo_category_id == $cate_id && $promo_item_id == 0 && $discount_of_max_amount ==0)
											{
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
											}
											else if($promo_item_id > 0  && $promo_item_id == $item_id && $discount_of_max_amount == 0){
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
											}
											else if($discount_of_max_amount > 0 && $BothTaxableCmboItem >= $discount_of_max_amount && $promo_item_id == 0 && $promo_category_id ==0){
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
											}
											else if($promo_category_id == 0 && $promo_item_id == 0 && $discount_of_max_amount ==0){
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
											}else{
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
											}
										}
									}						
						}else{
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
							}	
						
						$this->request->data['order_details'][$i]['promo_percent']=$combo_offer_detail->promoDiscount_Percent;
						$this->request->data['order_details'][$i]['promo_amount']=$combo_offer_detail->promoDiscount_Amount;						
						$this->request->data['order_details'][$i]['taxable_value']=$combo_offer_detail->taxAbleAmount;
						$this->request->data['order_details'][$i]['gst_figure_id']=$combo_offer_detail->item_variation->item->gst_figure_id;

						$combo_offer_detail->total_GST = $combo_offer_detail->taxAbleAmount * $combo_offer_detail->gst_percentage / 100; 
						$combo_offer_detail->total_with_GST = $combo_offer_detail->taxAbleAmount + $combo_offer_detail->total_GST; 
						$combo_offer_detail->total_GST = number_format($combo_offer_detail->total_GST,2,".","");
						$combo_offer_detail->total_with_GST = number_format($combo_offer_detail->total_with_GST,2,".","");
						
						$this->request->data['order_details'][$i]['gst_percentage'] = $combo_offer_detail->gst_percentage;
						$this->request->data['order_details'][$i]['gst_value']=$combo_offer_detail->total_GST;
						$this->request->data['order_details'][$i]['net_amount']=$combo_offer_detail->total_with_GST;
												
						$i++;					 
					} 
					  
				  } else{		
							$amount=$carts_data_fetch->cart_count * $carts_data_fetch->item_variations_data->sales_rate;
							$this->request->data['order_details'][$i]['item_id']=$carts_data_fetch->item_variations_data->item_id;
							$this->request->data['order_details'][$i]['item_variation_id']=$carts_data_fetch->item_variation_id;
							$this->request->data['order_details'][$i]['combo_offer_id']=$carts_data_fetch->combo_offer_id;
							$this->request->data['order_details'][$i]['quantity']= $carts_data_fetch->quantity;
							$this->request->data['order_details'][$i]['rate']=$carts_data_fetch->item_variations_data->sales_rate;
							$this->request->data['order_details'][$i]['amount']=$amount;							
							$this->request->data['order_details'][$i]['discount_percent']=$carts_data_fetch->memberShipDiscount_Percent;
							$this->request->data['order_details'][$i]['discount_amount']=$carts_data_fetch->memberShipDiscount_Amount;
							$carts_data_fetch->gst_percentage = $carts_data_fetch->item_variations_data->items_data->gst_figures_data->tax_percentage;
				  
					if($isPromoCode == 'true')
					{
						$promotionDetails = $this->Carts->Promotions->PromotionDetails->find()
						->where(['id' =>$promo_detail_id])->first();
							$discount_of_max_amount = $promotionDetails->discount_of_max_amount;
							$promo_item_id = $promotionDetails->item_id;
							$promo_category_id = $promotionDetails->category_id;
							$promo_free_shipping = $promotionDetails->is_free_shipping;
							$payableAmount = number_format(0, 2);
							//$taxAbleAmount_Total = 0.00;
							$promo_amount = 0;

						//echo $taxAbleAmount_Total;exit;
						$item_id = $carts_data_fetch->item_variations_data->items_data->id;
						//$carts_data_fetch->gst_percentage = $carts_data_fetch->item_variations_data->items_data->gst_figure->tax_percentage;
						$cate_id = $carts_data_fetch->item_variations_data->items_data->category_id;						
						
									if($cash_back == 0){
										if($discount_in_percentage == 0)
										{
											if($promo_category_id > 0 && $promo_category_id == $cate_id && $promo_item_id == 0 && $discount_of_max_amount ==0)
											{
												$isPromoValidForAll = true;
												$isPromoValidForAllMsg = 'PromoCode Applied Successfully';
												$promoDiscount_Amount =  $carts_data_fetch->taxAbleAmount / $BothTaxableCmboItem * $promotionDetails->discount_in_amount;
												$carts_data_fetch->promoDiscount_Percent = $promotionDetails->discount_in_percentage;
												$carts_data_fetch->promoDiscount_in_Amount = $promotionDetails->discount_in_amount;
												$carts_data_fetch->promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
												$promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
												$amountAfter_Promocode = $carts_data_fetch->taxAbleAmount - $promoDiscount_Amount;
												$carts_data_fetch->amountAfter_Promocode = number_format($amountAfter_Promocode,2,".","");
												$carts_data_fetch->taxAbleAmount = number_format($amountAfter_Promocode,2,".","");
												$carts_data_fetch->gstPercentageAdd = $carts_data_fetch->gst_percentage + 100;
												$carts_data_fetch->total_GST = $carts_data_fetch->taxAbleAmount * $carts_data_fetch->gst_percentage / $carts_data_fetch->gstPercentageAdd; 
												$carts_data_fetch->total_GST_division = round($carts_data_fetch->total_GST / 2,2);
												$carts_data_fetch->total_GST = $carts_data_fetch->total_GST_division * 2;
												$carts_data_fetch->taxAbleAmount = $carts_data_fetch->taxAbleAmount-$carts_data_fetch->total_GST;
												$carts_data_fetch->total_with_GST = $carts_data_fetch->taxAbleAmount + $carts_data_fetch->total_GST; 
												$carts_data_fetch->total_GST = number_format($carts_data_fetch->total_GST,2,".","");
												$carts_data_fetch->total_with_GST = number_format($carts_data_fetch->total_with_GST,2,".","");																								
											}
											else if($promo_item_id > 0  && $promo_item_id == $item_id && $discount_of_max_amount == 0){
												$isPromoValidForAll = true;
												$isPromoValidForAllMsg = 'PromoCode Applied Successfully';
												$promoDiscount_Amount =  $carts_data_fetch->taxAbleAmount / $BothTaxableCmboItem * $promotionDetails->discount_in_amount;
												$carts_data_fetch->promoDiscount_Percent = $promotionDetails->discount_in_percentage;
												$carts_data_fetch->promoDiscount_in_Amount = $promotionDetails->discount_in_amount;
												$carts_data_fetch->promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
												$promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
												$amountAfter_Promocode = $carts_data_fetch->taxAbleAmount - $promoDiscount_Amount;
												$carts_data_fetch->amountAfter_Promocode = number_format($amountAfter_Promocode,2,".","");
												$carts_data_fetch->taxAbleAmount = number_format($amountAfter_Promocode,2,".","");
												$carts_data_fetch->gstPercentageAdd = $carts_data_fetch->gst_percentage + 100;
												$carts_data_fetch->total_GST = $carts_data_fetch->taxAbleAmount * $carts_data_fetch->gst_percentage / $carts_data_fetch->gstPercentageAdd; 
												$carts_data_fetch->total_GST_division = round($carts_data_fetch->total_GST / 2,2);
												$carts_data_fetch->total_GST = $carts_data_fetch->total_GST_division * 2;
												$carts_data_fetch->taxAbleAmount = $carts_data_fetch->taxAbleAmount-$carts_data_fetch->total_GST;
												$carts_data_fetch->total_with_GST = $carts_data_fetch->taxAbleAmount + $carts_data_fetch->total_GST; 
												$carts_data_fetch->total_GST = number_format($carts_data_fetch->total_GST,2,".","");
												$carts_data_fetch->total_with_GST = number_format($carts_data_fetch->total_with_GST,2,".","");												

											}
											else if($discount_of_max_amount > 0 && $BothTaxableCmboItem >= $discount_of_max_amount && $promo_item_id == 0 && $promo_category_id ==0){
												$isPromoValidForAll = true;
												$isPromoValidForAllMsg = 'PromoCode Applied Successfully';
												$promoDiscount_Amount =  $carts_data_fetch->taxAbleAmount / $BothTaxableCmboItem * $promotionDetails->discount_in_amount;
												$carts_data_fetch->promoDiscount_Percent = $promotionDetails->discount_in_percentage;
												$carts_data_fetch->promoDiscount_in_Amount = $promotionDetails->discount_in_amount;
												$carts_data_fetch->promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
												$promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
												$amountAfter_Promocode = $carts_data_fetch->taxAbleAmount - $promoDiscount_Amount;
												$carts_data_fetch->amountAfter_Promocode = number_format($amountAfter_Promocode,2,".","");
												$carts_data_fetch->taxAbleAmount = number_format($amountAfter_Promocode,2,".","");
												$carts_data_fetch->gstPercentageAdd = $carts_data_fetch->gst_percentage + 100;
												$carts_data_fetch->total_GST = $carts_data_fetch->taxAbleAmount * $carts_data_fetch->gst_percentage / $carts_data_fetch->gstPercentageAdd; 
												$carts_data_fetch->total_GST_division = round($carts_data_fetch->total_GST / 2,2);
												$carts_data_fetch->total_GST = $carts_data_fetch->total_GST_division * 2;
												$carts_data_fetch->taxAbleAmount = $carts_data_fetch->taxAbleAmount-$carts_data_fetch->total_GST;
												$carts_data_fetch->total_with_GST = $carts_data_fetch->taxAbleAmount + $carts_data_fetch->total_GST; 
												$carts_data_fetch->total_GST = number_format($carts_data_fetch->total_GST,2,".","");
												$carts_data_fetch->total_with_GST = number_format($carts_data_fetch->total_with_GST,2,".","");												

											}
											else if($promo_category_id == 0 && $promo_item_id == 0 && $discount_of_max_amount ==0){
												$isPromoValidForAll = true;
												$isPromoValidForAllMsg = 'PromoCode Applied Successfully';
												$promoDiscount_Amount =  $carts_data_fetch->taxAbleAmount / $BothTaxableCmboItem * $promotionDetails->discount_in_amount;
												$carts_data_fetch->promoDiscount_Percent = $promotionDetails->discount_in_percentage;
												$carts_data_fetch->promoDiscount_in_Amount = $promotionDetails->discount_in_amount;
												$carts_data_fetch->promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
												$promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
												$amountAfter_Promocode = $carts_data_fetch->taxAbleAmount - $promoDiscount_Amount;
												$carts_data_fetch->amountAfter_Promocode = number_format($amountAfter_Promocode,2,".","");
												$carts_data_fetch->taxAbleAmount = number_format($amountAfter_Promocode,2,".","");
												$carts_data_fetch->gstPercentageAdd = $carts_data_fetch->gst_percentage + 100;
												$carts_data_fetch->total_GST = $carts_data_fetch->taxAbleAmount * $carts_data_fetch->gst_percentage / $carts_data_fetch->gstPercentageAdd; 
												$carts_data_fetch->total_GST_division = round($carts_data_fetch->total_GST / 2,2);
												$carts_data_fetch->total_GST = $carts_data_fetch->total_GST_division * 2;
												$carts_data_fetch->taxAbleAmount = $carts_data_fetch->taxAbleAmount-$carts_data_fetch->total_GST;
												$carts_data_fetch->total_with_GST = $carts_data_fetch->taxAbleAmount + $carts_data_fetch->total_GST; 
												$carts_data_fetch->total_GST = number_format($carts_data_fetch->total_GST,2,".","");
												$carts_data_fetch->total_with_GST = number_format($carts_data_fetch->total_with_GST,2,".","");												
											
											}else{
													$isPromoValidForAll = false;
													$isPromoValidForAllMsg = 'Invalid PromoCode';
													$carts_data_fetch->promoDiscount_Percent = 0.00;
													$carts_data_fetch->promoDiscount_in_Amount = 0.00;
													$carts_data_fetch->promoDiscount_Amount = 0.00;
													$carts_data_fetch->amountAfter_Promocode = $carts_data_fetch->taxAbleAmount;
													$carts_data_fetch->taxAbleAmount = $carts_data_fetch->taxAbleAmount;
													$carts_data_fetch->gstPercentageAdd = $carts_data_fetch->gst_percentage + 100;
													$carts_data_fetch->total_GST = $carts_data_fetch->taxAbleAmount * $carts_data_fetch->gst_percentage / $carts_data_fetch->gstPercentageAdd; 
													$carts_data_fetch->total_GST_division = round($carts_data_fetch->total_GST / 2,2);
													$carts_data_fetch->total_GST = $carts_data_fetch->total_GST_division * 2;
													$carts_data_fetch->taxAbleAmount = $carts_data_fetch->taxAbleAmount-$carts_data_fetch->total_GST;
													$carts_data_fetch->total_with_GST = $carts_data_fetch->taxAbleAmount + $carts_data_fetch->total_GST; 
													$carts_data_fetch->total_GST = number_format($carts_data_fetch->total_GST,2,".","");
													$carts_data_fetch->total_with_GST = number_format($carts_data_fetch->total_with_GST,2,".","");												
											}
										}else{
											if($promo_category_id > 0 && $promo_category_id == $cate_id && $promo_item_id == 0 && $discount_of_max_amount ==0)
											{
													$isPromoValidForAll = true;
													$isPromoValidForAllMsg = 'PromoCode Applied Successfully';
													$promoDiscount_Amount =  $carts_data_fetch->taxAbleAmount * $promotionDetails->discount_in_percentage / 100;
													$carts_data_fetch->promoDiscount_Percent = $promotionDetails->discount_in_percentage;
													$carts_data_fetch->promoDiscount_in_Amount = $promotionDetails->discount_in_amount;
													$carts_data_fetch->promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
													$promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
													$amountAfter_Promocode = $carts_data_fetch->taxAbleAmount - $promoDiscount_Amount;
													$carts_data_fetch->amountAfter_Promocode = number_format($amountAfter_Promocode,2,".","");
													$carts_data_fetch->taxAbleAmount = number_format($amountAfter_Promocode,2,".","");
													$carts_data_fetch->gstPercentageAdd = $carts_data_fetch->gst_percentage + 100;
													$carts_data_fetch->total_GST = $carts_data_fetch->taxAbleAmount * $carts_data_fetch->gst_percentage / $carts_data_fetch->gstPercentageAdd; 
													$carts_data_fetch->total_GST_division = round($carts_data_fetch->total_GST / 2,2);
													$carts_data_fetch->total_GST = $carts_data_fetch->total_GST_division * 2;
													$carts_data_fetch->taxAbleAmount = $carts_data_fetch->taxAbleAmount-$carts_data_fetch->total_GST;
													$carts_data_fetch->total_with_GST = $carts_data_fetch->taxAbleAmount + $carts_data_fetch->total_GST; 
													$carts_data_fetch->total_GST = number_format($carts_data_fetch->total_GST,2,".","");
													$carts_data_fetch->total_with_GST = number_format($carts_data_fetch->total_with_GST,2,".","");
											}
											else if($promo_item_id > 0  && $promo_item_id == $item_id && $discount_of_max_amount == 0){
													$isPromoValidForAll = true;
													$isPromoValidForAllMsg = 'PromoCode Applied Successfully';
													$promoDiscount_Amount =  $carts_data_fetch->taxAbleAmount * $promotionDetails->discount_in_percentage / 100;
													$carts_data_fetch->promoDiscount_Percent = $promotionDetails->discount_in_percentage;
													$carts_data_fetch->promoDiscount_in_Amount = $promotionDetails->discount_in_amount;
													$carts_data_fetch->promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
													$promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
													$amountAfter_Promocode = $carts_data_fetch->taxAbleAmount - $promoDiscount_Amount;
													$carts_data_fetch->amountAfter_Promocode = number_format($amountAfter_Promocode,2,".","");
													$carts_data_fetch->taxAbleAmount = number_format($amountAfter_Promocode,2,".","");
													$carts_data_fetch->gstPercentageAdd = $carts_data_fetch->gst_percentage + 100;
													$carts_data_fetch->total_GST = $carts_data_fetch->taxAbleAmount * $carts_data_fetch->gst_percentage / $carts_data_fetch->gstPercentageAdd; 
													$carts_data_fetch->total_GST_division = round($carts_data_fetch->total_GST / 2,2);
													$carts_data_fetch->total_GST = $carts_data_fetch->total_GST_division * 2;
													$carts_data_fetch->taxAbleAmount = $carts_data_fetch->taxAbleAmount-$carts_data_fetch->total_GST;
													$carts_data_fetch->total_with_GST = $carts_data_fetch->taxAbleAmount + $carts_data_fetch->total_GST; 
													$carts_data_fetch->total_GST = number_format($carts_data_fetch->total_GST,2,".","");
													$carts_data_fetch->total_with_GST = number_format($carts_data_fetch->total_with_GST,2,".","");
											}
											else if($discount_of_max_amount > 0 && $promo_item_id == 0 && $promo_category_id ==0){
													$isPromoValidForAll = true;
													$isPromoValidForAllMsg = 'PromoCode Applied Successfully';
													$promoDiscount_Amount =  $carts_data_fetch->taxAbleAmount * $promotionDetails->discount_in_percentage / 100;
													$carts_data_fetch->promoDiscount_Percent = $promotionDetails->discount_in_percentage;
													$carts_data_fetch->promoDiscount_in_Amount = $promotionDetails->discount_in_amount;
													$carts_data_fetch->promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
													$promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
													$amountAfter_Promocode = $carts_data_fetch->taxAbleAmount - $promoDiscount_Amount;
													$carts_data_fetch->amountAfter_Promocode = number_format($amountAfter_Promocode,2,".","");
													$carts_data_fetch->taxAbleAmount = number_format($amountAfter_Promocode,2,".","");
													$carts_data_fetch->gstPercentageAdd = $carts_data_fetch->gst_percentage + 100;
													$carts_data_fetch->total_GST = $carts_data_fetch->taxAbleAmount * $carts_data_fetch->gst_percentage / $carts_data_fetch->gstPercentageAdd; 
													$carts_data_fetch->total_GST_division = round($carts_data_fetch->total_GST / 2,2);
													$carts_data_fetch->total_GST = $carts_data_fetch->total_GST_division * 2;
													$carts_data_fetch->taxAbleAmount = $carts_data_fetch->taxAbleAmount-$carts_data_fetch->total_GST;
													$carts_data_fetch->total_with_GST = $carts_data_fetch->taxAbleAmount + $carts_data_fetch->total_GST; 
													$carts_data_fetch->total_GST = number_format($carts_data_fetch->total_GST,2,".","");
													$carts_data_fetch->total_with_GST = number_format($carts_data_fetch->total_with_GST,2,".","");
											}
											else if($promo_category_id == 0 && $promo_item_id == 0 && $discount_of_max_amount ==0){
													$isPromoValidForAll = true;
													$isPromoValidForAllMsg = 'PromoCode Applied Successfully';
													$promoDiscount_Amount =  $carts_data_fetch->taxAbleAmount * $promotionDetails->discount_in_percentage / 100;
													$carts_data_fetch->promoDiscount_Percent = $promotionDetails->discount_in_percentage;
													$carts_data_fetch->promoDiscount_in_Amount = $promotionDetails->discount_in_amount;
													$carts_data_fetch->promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
													$promoDiscount_Amount = number_format($promoDiscount_Amount,2,".","");
													$amountAfter_Promocode = $carts_data_fetch->taxAbleAmount - $promoDiscount_Amount;
													$carts_data_fetch->amountAfter_Promocode = number_format($amountAfter_Promocode,2,".","");
													$carts_data_fetch->taxAbleAmount = number_format($amountAfter_Promocode,2,".","");
													$carts_data_fetch->gstPercentageAdd = $carts_data_fetch->gst_percentage + 100;
													$carts_data_fetch->total_GST = $carts_data_fetch->taxAbleAmount * $carts_data_fetch->gst_percentage / $carts_data_fetch->gstPercentageAdd; 
													$carts_data_fetch->total_GST_division = round($carts_data_fetch->total_GST / 2,2);
													$carts_data_fetch->total_GST = $carts_data_fetch->total_GST_division * 2;
													$carts_data_fetch->taxAbleAmount = $carts_data_fetch->taxAbleAmount-$carts_data_fetch->total_GST;
													$carts_data_fetch->total_with_GST = $carts_data_fetch->taxAbleAmount + $carts_data_fetch->total_GST; 
													$carts_data_fetch->total_GST = number_format($carts_data_fetch->total_GST,2,".","");
													$carts_data_fetch->total_with_GST = number_format($carts_data_fetch->total_with_GST,2,".","");												
											}else{
													$isPromoValidForAll = false;
													$isPromoValidForAllMsg = 'Invalid PromoCode';
													$carts_data_fetch->promoDiscount_Percent = 0.00;
													$carts_data_fetch->promoDiscount_in_Amount = 0.00;
													$carts_data_fetch->promoDiscount_Amount = 0.00;
													$carts_data_fetch->amountAfter_Promocode = $carts_data_fetch->taxAbleAmount;
													$carts_data_fetch->taxAbleAmount = $carts_data_fetch->taxAbleAmount;
													$carts_data_fetch->gstPercentageAdd = $carts_data_fetch->gst_percentage + 100;
													$carts_data_fetch->total_GST = $carts_data_fetch->taxAbleAmount * $carts_data_fetch->gst_percentage / $carts_data_fetch->gstPercentageAdd; 
													$carts_data_fetch->total_GST_division = round($carts_data_fetch->total_GST / 2,2);
													$carts_data_fetch->total_GST = $carts_data_fetch->total_GST_division * 2;
													$carts_data_fetch->taxAbleAmount = $carts_data_fetch->taxAbleAmount-$carts_data_fetch->total_GST;
													$carts_data_fetch->total_with_GST = $carts_data_fetch->taxAbleAmount + $carts_data_fetch->total_GST; 
													$carts_data_fetch->total_GST = number_format($carts_data_fetch->total_GST,2,".","");
													$carts_data_fetch->total_with_GST = number_format($carts_data_fetch->total_with_GST,2,".","");												
											}
										}
									}						
						
												
					}else{
							$isPromoValidForAll = false;
							$isPromoValidForAllMsg = 'Invalid PromoCode';
							$carts_data_fetch->promoDiscount_Percent = 0.00;
							$carts_data_fetch->promoDiscount_in_Amount = 0.00;
							$carts_data_fetch->promoDiscount_Amount = 0.00;
							$carts_data_fetch->amountAfter_Promocode = $carts_data_fetch->taxAbleAmount;
							$carts_data_fetch->taxAbleAmount = $carts_data_fetch->taxAbleAmount;
							$carts_data_fetch->gstPercentageAdd = $carts_data_fetch->gst_percentage + 100;
							$carts_data_fetch->total_GST = $carts_data_fetch->taxAbleAmount * $carts_data_fetch->gst_percentage / $carts_data_fetch->gstPercentageAdd; 
							$carts_data_fetch->total_GST_division = round($carts_data_fetch->total_GST / 2,2);
							$carts_data_fetch->total_GST = $carts_data_fetch->total_GST_division * 2;
							$carts_data_fetch->taxAbleAmount = $carts_data_fetch->taxAbleAmount-$carts_data_fetch->total_GST;
							$carts_data_fetch->total_with_GST = $carts_data_fetch->taxAbleAmount + $carts_data_fetch->total_GST; 
							$carts_data_fetch->total_GST = number_format($carts_data_fetch->total_GST,2,".","");
							$carts_data_fetch->total_with_GST = number_format($carts_data_fetch->total_with_GST,2,".","");
					}	

					$this->request->data['order_details'][$i]['promo_percent']=$carts_data_fetch->promoDiscount_Percent;
					$this->request->data['order_details'][$i]['promo_amount']=$carts_data_fetch->promoDiscount_Amount;
					$this->request->data['order_details'][$i]['taxable_value']=$carts_data_fetch->taxAbleAmount;
					$this->request->data['order_details'][$i]['gst_figure_id']=$carts_data_fetch->item_variations_data->items_data->gst_figure_id;
					
					/* $carts_data_fetch->total_GST = $carts_data_fetch->taxAbleAmount * $carts_data_fetch->gst_percentage / 100; 
					$carts_data_fetch->total_with_GST = $carts_data_fetch->taxAbleAmount + $carts_data_fetch->total_GST;
					$carts_data_fetch->total_GST = number_format($carts_data_fetch->total_GST,2,".","");
					$carts_data_fetch->total_with_GST = number_format($carts_data_fetch->total_with_GST,2,".",""); */					

					
					if(empty($carts_data_fetch->gst_percentage))
					{
						$carts_data_fetch->gst_percentage = 0.00;
					}
					
					$this->request->data['order_details'][$i]['gst_percentage'] = $carts_data_fetch->gst_percentage;
					$this->request->data['order_details'][$i]['gst_value']=$carts_data_fetch->total_GST;
					$this->request->data['order_details'][$i]['net_amount']=$carts_data_fetch->total_with_GST;
					
					$i++;
				  }				  
			 }
			 
			 $order_details = $this->request->data['order_details'];
				// pr($order_details);exit;
				foreach($order_details as $order_detail)
				{	
					 
					$total_amount = $total_amount + $order_detail['amount'];
					$total_membershipDsicount = $total_membershipDsicount + $order_detail['discount_amount'];
					$total_promoDiscount = $total_promoDiscount + $order_detail['promo_amount'];
					$total_GST = $total_GST + $order_detail['gst_value'];
					$net_amount = $net_amount + $order_detail['net_amount'];				
				}
			//pr($order_details);exit;
			$cash_bank = $this->Orders->Ledgers->find()->select(['id'])->where(['cash'=>1])->first()->toArray();
			$this->request->data['discount_amount']=$total_membershipDsicount + $total_promoDiscount;			
			$this->request->data['total_gst']=$total_GST;
			$this->request->data['total_amount']=$net_amount;
			$this->request->data['grand_total']=$net_amount;
            $order = $this->Orders->patchEntity($order, $this->request->getData()); 
			
			$CityData = $this->Orders->Cities->get($order->city_id); 
			$StateData = $this->Orders->Cities->States->get($CityData->state_id);
        	$Voucher_no = $this->Orders->find()->select(['voucher_no'])->where(['Orders.city_id'=>$order->city_id])->order(['voucher_no' => 'DESC'])->first();
			if($Voucher_no){
				$voucher_no=$Voucher_no->voucher_no+1;
			}
			else
			{
				$voucher_no=1;
			}
			$order_no=$CityData->alise_name.'/'.$voucher_no;
			$order_no=$StateData->alias_name.'/'.$order_no;
			
			
			$order->order_no = $order_no;
			$order->voucher_no = $voucher_no;
            $order->order_date = date('Y-m-d');
			$order->transaction_date = date('Y-m-d');
            $order->location_id = $location_id;
            //$order->sales_ledger_id = $sales_ledgers['id'];
            $order->order_status = 'placed';
			if(!empty($delivery_date))
			{ 
				$order->delivery_date = date('Y-m-d',strtotime($delivery_date)); 
			}
			else { 
					$order->delivery_date = '0000-00-00'; 

				} 
			//$order->delivery_date = date('Y-m-d',strtotime("+2 days")); 
			
			$today=date('Y-m-d');
			$FinancialYear = $this->Orders->FinancialYears->find()->where(['FinancialYears.city_id'=>$order->city_id,'FinancialYears.fy_from <='=>$today,'FinancialYears.fy_to >='=>$today])->first();
			$order->financial_year_id=@$FinancialYear->id;	

				

			
			$accountLedgers = $this->Orders->AccountingGroups->find()
			->where(['AccountingGroups.sale_invoice_sales_account'=>1,'AccountingGroups.city_id'=>$order->city_id])
			->first();
			
			$salesLedger = $this->Orders->Ledgers->find()
			->where(['Ledgers.accounting_group_id' =>$accountLedgers->id,'city_id'=>$order->city_id])
			->first();
			
			$order->sales_ledger_id = $salesLedger->id;
			if($order->order_type=="Online")
			{
				$LedgerData = $this->Orders->Ledgers->find()->where(['Ledgers.ccavenue' =>'yes','Ledgers.city_id'=>$order->city_id])->first();
				$order->party_ledger_id=$LedgerData->id;
			}
			else if($order->order_type=="COD")
			{
				$LedgerData = $this->Orders->Ledgers->find()->where(['Ledgers.cash' =>'1','Ledgers.city_id'=>$order->city_id])->first();
				$order->party_ledger_id=$LedgerData->id;
			}else{
				$LedgerData = $this->Orders->Ledgers->find()->where(['Ledgers.customer_id' =>$order->customer_id,'Ledgers.city_id'=>$order->city_id])->first();
				$order->party_ledger_id=$LedgerData->id;				
			}  
			
			$p=$order->grand_total;
			$q=round($order->grand_total);
			$Round_off_amt=round(($p-$q),2);
			$order->grand_total=round($order->grand_total);	
			$order->round_off=$Round_off_amt;
			
			foreach($order->order_details as $order_detail)
			{
				$order_detail->item_status = 'placed';
					if(empty($order_detail->discount_amount))
					{
						$order_detail->discount_amount = 0.00;
					}
					if(empty($order_detail->promo_percent))
					{
						$order_detail->promo_percent = 0.00;
					}
					if(empty($order_detail->promo_amount))
					{
						$order_detail->promo_amount = 0.00;
					}				
			}
		$remaining_wallet_amount = 0.00;
		$ReadyToSave = 'No';	
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
				$remaining_wallet_amount= round($wallet_total_add_amount-$wallet_total_used_amount);
			}
		}			
			
		if($order->order_type=="Wallet"){
			if($remaining_wallet_amount >= $order->amount_from_wallet && $order->grand_total == $order->amount_from_wallet)
			{
				$ReadyToSave = 'Yes';	
			}
			else{
				$ReadyToSave = 'No';
				$message='Wallet amount mismatch';
        		$success=false;
			}			
		}
		
		if($order->order_type=="Wallet/Online"){
			$totalPayableAmount = 0.00;
			$totalPayableAmount = $order->amount_from_wallet + $order->pay_amount;
			if($remaining_wallet_amount == $order->amount_from_wallet && $order->grand_total == $totalPayableAmount)
			{
				$ReadyToSave = 'Yes';	
			}
			else{
				$ReadyToSave = 'No';
				$message='Wallet/Online amount mismatch';
        		$success=false;
			}			
		}		

		if($order->order_type=="Online")
		{
			$ReadyToSave = 'Yes';	
		}	
		if($order->order_type=="COD"){
			$ReadyToSave = 'Yes';	
		}

		
		//pr($order);exit;
		
		if($ReadyToSave == 'Yes')
		{
			if($orders = $this->Orders->save($order)) {
				$challenOrderId = $order->id;
			
				if($order->promotion_detail_id > 0)
				{
					$query = $this->Orders->PromotionDetails->CustomerPromotions->query();
					$query->insert(['city_id', 'customer_id','order_id','promotion_detail_id'])
					->values([
						'city_id' => $order->city_id,
						'customer_id' => $customer_id,
						'order_id' => $order->id,
						'promotion_detail_id' => $order->promotion_detail_id
					])->execute();							
				}
				if($order->order_type=="Wallet"){
					$query = $this->Orders->Wallets->query();
					$query->insert(['city_id', 'customer_id','order_id','used_amount','narration','amount_type','transaction_type'])
						->values([
							'city_id' => $order->city_id,
							'customer_id' => $customer_id,
							'order_id' => $order->id,
							'used_amount' => $order->amount_from_wallet,
							'narration' => 'Amount ('.$order->order_type.') used in Order No '. $order->order_no,
							'amount_type' => 'Order',
							'transaction_type' => 'Deduct'	
						])->execute();	
				}

				if($order->order_type=="Wallet/Online"){
					$query = $this->Orders->Wallets->query();
					$query->insert(['city_id', 'customer_id','order_id','used_amount','narration','amount_type','transaction_type'])
						->values([
							'city_id' => $order->city_id,
							'customer_id' => $customer_id,
							'order_id' => $order->id,
							'used_amount' => $order->amount_from_wallet,
							'narration' => 'Amount ('.$order->order_type.') used in Order No '. $order->order_no,
							'amount_type' => 'Order',
							'transaction_type' => 'Deduct'	
						])->execute();
						
						//Generate Voucher
						$Voucher_no = $this->Orders->JournalVouchers->find()->select(['voucher_no'])->where(['JournalVouchers.financial_year_id'=>@$order->financial_year_id,'JournalVouchers.city_id'=>$order->city_id])->order(['voucher_no' => 'DESC'])->first();
						
						if($Voucher_no){
							$voucher_no=$Voucher_no->voucher_no+1;
						}else{
							$voucher_no=1;
						}
						
						$JournalVoucher = $this->Orders->JournalVouchers->newEntity();
						$JournalVoucher->voucher_no = $voucher_no;
						$JournalVoucher->city_id = $order->city_id;
						$JournalVoucher->total_credit_amount = $order->online_amount;
						$JournalVoucher->total_debit_amount = $order->online_amount;
						$JournalVoucher->financial_year_id = $order->financial_year_id;
						$JournalVoucher->transaction_date = date('Y-m-d');
						$JournalVoucher->created_on = date('Y-m-d');
						$JournalVoucher->created_by ='NULL';
						$JournalVoucher->narration ="Online Payment";
						$this->Orders->JournalVouchers->save($JournalVoucher);
							
						$LedgerData = $this->Orders->Ledgers->find()->where(['Ledgers.ccavenue' =>'yes','Ledgers.city_id'=>$order->city_id])->first();
						
						//CCAvenue Accounting
						$JournalVoucherRow = $this->Orders->JournalVouchers->JournalVoucherRows->newEntity();
						$JournalVoucherRow->journal_voucher_id = $JournalVoucher->id;
						$JournalVoucherRow->ledger_id = $LedgerData->id;
						$JournalVoucherRow->cr_dr ="Dr";
						$JournalVoucherRow->debit = $order->online_amount;
						$JournalVoucherRow->credit =0;
						$this->Orders->JournalVouchers->JournalVoucherRows->save($JournalVoucherRow);
						
						$AccountingEntries1 = $this->Orders->JournalVouchers->AccountingEntries->newEntity();
						$AccountingEntries1->ledger_id = $LedgerData->id;
						$AccountingEntries1->city_id = $order->city_id;
						$AccountingEntries1->transaction_date = date('Y-m-d');
						$AccountingEntries1->debit = $order->online_amount;
						$AccountingEntries1->credit =0;
						$AccountingEntries1->journal_voucher_id = $JournalVoucher->id;
						$this->Orders->JournalVouchers->AccountingEntries->save($AccountingEntries1);
						
						$CustomerLedgerData = $this->Orders->Ledgers->find()->where(['Ledgers.customer_id'=>$order->customer_id,'Ledgers.city_id'=>$order->city_id])->first();
						//Cash Accounting
						$JournalVoucherRow = $this->Orders->JournalVouchers->JournalVoucherRows->newEntity();
						$JournalVoucherRow->journal_voucher_id = $JournalVoucher->id;
						$JournalVoucherRow->ledger_id = $CustomerLedgerData->id;
						$JournalVoucherRow->cr_dr ="Cr";
						$JournalVoucherRow->credit = $order->online_amount;
						$JournalVoucherRow->debit =0;
						$this->Orders->JournalVouchers->JournalVoucherRows->save($JournalVoucherRow);
						
						$AccountingEntries1 = $this->Orders->JournalVouchers->AccountingEntries->newEntity();
						$AccountingEntries1->ledger_id = $CustomerLedgerData->id;
						$AccountingEntries1->city_id = $order->city_id;
						$AccountingEntries1->transaction_date = date('Y-m-d');
						$AccountingEntries1->credit = $order->online_amount;
						$AccountingEntries1->debit =0;
						$AccountingEntries1->journal_voucher_id = $JournalVoucher->id;
						$this->Orders->JournalVouchers->AccountingEntries->save($AccountingEntries1);
						
						if($LedgerData->bill_to_bill_accounting=="yes"){
							$ReferenceDetail = $this->Orders->JournalVouchers->ReferenceDetails->newEntity(); 
							$ReferenceDetail->ledger_id=$LedgerData->id;
							$ReferenceDetail->debit=$order->online_amount;
							$ReferenceDetail->credit=0;
							$ReferenceDetail->transaction_date=date('Y-m-d');
							$ReferenceDetail->city_id=$order->city_id;
							$ReferenceDetail->entry_from="Web";
							$ReferenceDetail->type='New Ref';
							$ReferenceDetail->ref_name=$order->ccavvenue_tracking_no;
							$ReferenceDetail->journal_voucher_id=$JournalVoucher->id;//pr($ReferenceDetail); exit;
							$this->Orders->JournalVouchers->ReferenceDetails->save($ReferenceDetail);
						}
						
				}				
				
				if($order->order_type=="Online"){
						//Generate Voucher
						$Voucher_no = $this->Orders->JournalVouchers->find()->select(['voucher_no'])->where(['JournalVouchers.financial_year_id'=>@$order->financial_year_id,'JournalVouchers.city_id'=>$order->city_id])->order(['voucher_no' => 'DESC'])->first();
						
						if($Voucher_no){
							$voucher_no=$Voucher_no->voucher_no+1;
						}else{
							$voucher_no=1;
						}
						
						$JournalVoucher = $this->Orders->JournalVouchers->newEntity();
						$JournalVoucher->voucher_no = $voucher_no;
						$JournalVoucher->city_id = $order->city_id;
						$JournalVoucher->total_credit_amount = $order->pay_amount;
						$JournalVoucher->total_debit_amount = $order->pay_amount;
						$JournalVoucher->financial_year_id = $order->financial_year_id;
						$JournalVoucher->transaction_date = date('Y-m-d');
						$JournalVoucher->created_on = date('Y-m-d');
						$JournalVoucher->created_by ='NULL';
						$JournalVoucher->narration ="Online Payment";
						$this->Orders->JournalVouchers->save($JournalVoucher);
							
						$LedgerData = $this->Orders->Ledgers->find()->where(['Ledgers.ccavenue' =>'yes','Ledgers.city_id'=>$order->city_id])->first();
						
						//CCAvenue Accounting
						$JournalVoucherRow = $this->Orders->JournalVouchers->JournalVoucherRows->newEntity();
						$JournalVoucherRow->journal_voucher_id = $JournalVoucher->id;
						$JournalVoucherRow->ledger_id = $LedgerData->id;
						$JournalVoucherRow->cr_dr ="Dr";
						$JournalVoucherRow->debit = $order->pay_amount;
						$JournalVoucherRow->credit =0;
						$this->Orders->JournalVouchers->JournalVoucherRows->save($JournalVoucherRow);
						
						$AccountingEntries1 = $this->Orders->JournalVouchers->AccountingEntries->newEntity();
						$AccountingEntries1->ledger_id = $LedgerData->id;
						$AccountingEntries1->city_id = $order->city_id;
						$AccountingEntries1->transaction_date = date('Y-m-d');
						$AccountingEntries1->debit = $order->pay_amount;
						$AccountingEntries1->credit =0;
						$AccountingEntries1->journal_voucher_id = $JournalVoucher->id;
						$this->Orders->JournalVouchers->AccountingEntries->save($AccountingEntries1);
						
						$CustomerLedgerData = $this->Orders->Ledgers->find()->where(['Ledgers.customer_id'=>$order->customer_id,'Ledgers.city_id'=>$order->city_id])->first();
						//Cash Accounting
						$JournalVoucherRow = $this->Orders->JournalVouchers->JournalVoucherRows->newEntity();
						$JournalVoucherRow->journal_voucher_id = $JournalVoucher->id;
						$JournalVoucherRow->ledger_id = $CustomerLedgerData->id;
						$JournalVoucherRow->cr_dr ="Cr";
						$JournalVoucherRow->credit = $order->pay_amount;
						$JournalVoucherRow->debit =0;
						$this->Orders->JournalVouchers->JournalVoucherRows->save($JournalVoucherRow);
						
						$AccountingEntries1 = $this->Orders->JournalVouchers->AccountingEntries->newEntity();
						$AccountingEntries1->ledger_id = $CustomerLedgerData->id;
						$AccountingEntries1->city_id = $order->city_id;
						$AccountingEntries1->transaction_date = date('Y-m-d');
						$AccountingEntries1->credit = $order->pay_amount;
						$AccountingEntries1->debit =0;
						$AccountingEntries1->journal_voucher_id = $JournalVoucher->id;
						$this->Orders->JournalVouchers->AccountingEntries->save($AccountingEntries1);
						
						if($LedgerData->bill_to_bill_accounting=="yes"){
							$ReferenceDetail = $this->Orders->JournalVouchers->ReferenceDetails->newEntity(); 
							$ReferenceDetail->ledger_id=$LedgerData->id;
							$ReferenceDetail->debit=$order->pay_amount;
							$ReferenceDetail->credit=0;
							$ReferenceDetail->transaction_date=date('Y-m-d');
							$ReferenceDetail->city_id=$order->city_id;
							$ReferenceDetail->entry_from="Web";
							$ReferenceDetail->type='New Ref';
							$ReferenceDetail->ref_name=$order->ccavvenue_tracking_no;
							$ReferenceDetail->journal_voucher_id=$JournalVoucher->id;//pr($ReferenceDetail); exit;
							$this->Orders->JournalVouchers->ReferenceDetails->save($ReferenceDetail);
						}
					
				}
				
				//update in item variations
				foreach($order->order_details as $order_detail){ 
				$item= $this->Orders->OrderDetails->ItemVariations->Items->get($order_detail->item_id);
				if($item->item_maintain_by=="itemwise"){
					$allItemVariations= $this->Orders->OrderDetails->ItemVariations->find()->where(['ItemVariations.item_id'=>$order_detail->item_id,'ItemVariations.city_id'=>@$order->city_id,'ItemVariations.seller_id IS NULL'])->contain(['UnitVariations'=>['Units']]);
					$ItemVariationData= $this->Orders->OrderDetails->ItemVariations->get($order_detail->item_variation_id);
					$UnitVariation= $this->Orders->OrderDetails->ItemVariations->UnitVariations->get($ItemVariationData->unit_variation_id);
					foreach($allItemVariations as $iv){
						$p=($UnitVariation->convert_unit_qty*$order_detail->quantity); 
						$addQty=($p/$iv->unit_variation->convert_unit_qty); 
						$addQty=round($addQty,2);
						$item_variation_data = $this->Orders->OrderDetails->ItemVariations->get($iv->id);
						
						$current_stock=$item_variation_data->current_stock-$addQty;
						$cs=$item_variation_data->current_stock;
						$vs=$item_variation_data->virtual_stock;
						$ds=$item_variation_data->demand_stock;
						$actual_quantity=$addQty;
						
						if($cs>=$actual_quantity){
							$final_cs=$cs-$actual_quantity;
							$final_ds=$ds;
						}
						if($actual_quantity>$cs){
							$remaining_cs=$actual_quantity-$cs;
							$final_ds=$ds+$remaining_cs;
							//$vs=$vs-$final_ds;
							$final_cs=0;
						}
						$out_of_stock="No";
						$ready_to_sale="Yes";
						if(($final_cs==0) && ($vs==$final_ds)){
							$ready_to_sale="No";
							$out_of_stock="Yes";
						}
						$query = $this->Orders->OrderDetails->ItemVariations->query();
						$query->update()
						->set(['current_stock'=>$final_cs,'demand_stock'=>$final_ds,'out_of_stock'=>$out_of_stock,'ready_to_sale'=>$ready_to_sale])
						->where(['id'=>$iv->id])
						->execute(); 
					}
				}else{
					$ItemVariationData = $this->Orders->OrderDetails->ItemVariations->get($order_detail->item_variation_id);
					$current_stock=$ItemVariationData->current_stock-$order_detail->quantity;
					$cs=$ItemVariationData->current_stock;
					$vs=$ItemVariationData->virtual_stock;
					$ds=$ItemVariationData->demand_stock;
					$actual_quantity=$order_detail->quantity;

					if($cs>=$actual_quantity){
					$final_cs=$cs-$actual_quantity;
					$final_ds=$ds;
					}
					if($actual_quantity>$cs){
					$remaining_cs=$actual_quantity-$cs;
					$final_ds=$ds+$remaining_cs;
					$final_cs=0;
					}

					$out_of_stock="No";
					$ready_to_sale="Yes";
					if(($final_cs==0) && ($vs==$final_ds)){
					$ready_to_sale="No";
					$out_of_stock="Yes";

					}
					//pr($current_stock); exit;
					$query = $this->Orders->OrderDetails->ItemVariations->query();
					$query->update()
					->set(['current_stock'=>$final_cs,'demand_stock'=>$final_ds,'out_of_stock'=>$out_of_stock,'ready_to_sale'=>$ready_to_sale])
					->where(['id'=>$order_detail->item_variation_id])
					->execute();
					}
				}

				
				$this->Challan->challanAdd($challenOrderId);
				
			///////////////////////START DELETE FROM CART/////////////////
				
				$query = $this->Orders->Customers->Carts->query();
				$result = $query->delete()
					->where(['customer_id' => $customer_id])
					->execute(); 
			///////////////////////END DELETE FROM CART/////////////////


		/////////////////Notification////AND////////////////////////
		$customer_details=$this->Orders->Customers->find()
		->where(['Customers.id' => $customer_id])->first();
		$mob=$customer_details->username;
		$main_device_token1=$customer_details->device_token;
				 
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
				'title'=> 'Order Placed',
				'message' => 'Thank You, your order placed successfully',
				'image' => 'img/jain.png',
				'link' => 'jainthela://order?id='.$order->id,
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
			//pr($payload);
			$final_result=json_decode($response);
			$sms_flag=$final_result->success; 	
			if ($err) {
			 // echo "cURL Error #:" . $err;
			} else {
			//	$response;
			}

			$orderLink = 'jainthela://order?id='.$order->id;			
			$url = 'https://fcm.googleapis.com/fcm/send';
			
			
			$fcmRegIds = array();
			$fields = [
				"notification" => ["title" => "Order Placed", "text" => "Thank You, your order placed successfully","sound" => "default",'notification_id'=>$random,"link" =>$orderLink],
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
			/////////////////Notification////END////////////////////////	
			
			//////////////////////SMS///Start//////////////////
	  
					$sms=str_replace(' ', '+', 'Your order has been returned');
					$sms_sender='JAINTE';
					$sms=str_replace(' ', '+', $sms);
					//file_get_contents('http://103.39.134.40/api/mt/SendSMS?user=phppoetsit&password=9829041695&senderid='.$sms_sender.'&channel=Trans&DCS=0&flashsms=0&number='.$mob.'&text='.$sms.'&route=7');
			//////////////////////SMS///ENd//////////////////
			
			
				$message='Thank You ! Your Order placed successfully.';
          		$success=true;
            }else
            { 
				$message='Order not placed';
        		$success=false;
            }
		}
		else {
				$message='Invalid Payment method';
        		$success=false;	
		}		
			}
			else {
				$message='Your cart is empty';
        		$success=false;	
			}
        }
        $this->set(compact('success', 'message'));
        $this->set('_serialize', ['success', 'message']);
	}

	/* public function ItemWiseCancelOrder()
	{
        $customer_id=$this->request->query('customer_id');
        $order_id=$this->request->query('order_id');	
		$order_detail_ids = $this->request->query('order_detail_id');
		$isPromoCode = $this->request->query['isPromoCode'];
		$promo_detail_id = $this->request->query['promotion_detail_id'];		
		
		$isCombo = $this->request->query['isCombo'];
		$combo_offer_id = $this->request->query['combo_offer_id'];				
		$discount_amount = 0.00;
		$pay_amount = 0.00;
		$total_gst = 0.00;
		$total_GST = 0.00;				
		$order_detail_ids = explode(",",$order_detail_ids);
		$total_amount = 0.00;
		$total_membershipDsicount = 0.00;
		$total_promoDiscount = 0.00;	
		$net_amount = 0.00;
		$amount = 0.00;		
		if(is_array($order_detail_ids) && !empty($order_detail_ids))
		{
			$query = $this->Orders->OrderDetails->query();			
			
			if($isCombo == 'YES' && $combo_offer_id > 0)
			{
				$query->update()
				->set(['is_item_cancel'=>'Yes','item_status'=>'Cancel'])
				->where(['combo_offer_id'=>$combo_offer_id])->where(['order_id'=>$order_id])
				->execute();				
			} 
			
			foreach($order_detail_ids as $order_detail_id)
			{
				$query->update()
				->set(['is_item_cancel'=>'Yes','item_status'=>'Cancel'])
				->where(['id'=>$order_detail_id])->where(['order_id'=>$order_id])
				->execute();				
			}
						
			$OrderDetails = $this->Orders->find()->contain(['OrderDetails' =>function($q){
				return $q->where(['is_item_cancel' =>'No']);
			}])->where(['id'=>$order_id])->first();

			$memberShipDiscount = $this->Orders->Carts->Customers->find()
			->select(['membership_discount'])
			->where(['Customers.id' => $customer_id])
			->where(['Customers.start_date <='=> date('Y-m-d'),'Customers.end_date >='=> date('Y-m-d')])
			->first();
				

			if(!empty($OrderDetails))
			{				
				foreach($OrderDetails->order_details as $order_detail)
				{
					$amount = $order_detail->rate * $order_detail->quantity;
					$order_detail->amount = $amount;
					if(!empty($memberShipDiscount) && $memberShipDiscount->membership_discount > 0)
					{
						$memberShipDiscount_Amount = $amount * $memberShipDiscount->membership_discount/100;
						$order_detail->memberShipDiscount_Percent = $memberShipDiscount->membership_discount;
						$order_detail->memberShipDiscount_Amount = number_format($memberShipDiscount_Amount,2,".","");
						$memberShipDiscount_Amount = number_format($memberShipDiscount_Amount,2,".","");
						$amountAfter_Membership = $amount - $memberShipDiscount_Amount;
						$order_detail->amountAfter_Membership = number_format($amountAfter_Membership,2,".","");
						$order_detail->taxAbleAmount = number_format($amountAfter_Membership,2,".","");												
					}
					else{
						   $order_detail->memberShipDiscount_Percent = 0.00;
						   $order_detail->memberShipDiscount_Amount = 0.00;
						   $order_detail->amountAfter_Membership = $amount;
						   $order_detail->taxAbleAmount = number_format($amount,2,".","");								
					}
					$order_detail->discount_percent = $order_detail->memberShipDiscount_Percent;
					$order_detail->discount_amount = $order_detail->memberShipDiscount_Amount;

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
						}else{
									$order_detail->promoDiscount_Percent = 0.00;
									$order_detail->promoDiscount_in_Amount = 0.00;
									$order_detail->promoDiscount_Amount = 0.00;
									$order_detail->amountAfter_Promocode = $order_detail->taxAbleAmount;
									$order_detail->taxAbleAmount = $order_detail->taxAbleAmount;															
							}

						$order_detail->promo_percent=$order_detail->promoDiscount_Percent;
						$order_detail->promo_amount=$order_detail->promoDiscount_Amount;						
						$order_detail->taxable_value =$order_detail->taxAbleAmount;
						

						$order_detail->total_GST = $order_detail->taxAbleAmount * $order_detail->gst_percentage / 100; 
						$order_detail->total_with_GST = $order_detail->taxAbleAmount + $order_detail->total_GST; 
						$order_detail->total_GST = number_format($order_detail->total_GST,2,".","");
						$order_detail->total_with_GST = number_format($order_detail->total_with_GST,2,".","");
						
						$order_detail->gst_percentage = $order_detail->gst_percentage;
						$order_detail->gst_value=$order_detail->total_GST;
						$order_detail->net_amount=$order_detail->total_with_GST;		


						$query = $this->Orders->OrderDetails->query();
						$query->update()
						->set(['amount'=>$amount,'discount_percent' => $order_detail->discount_percent,'discount_amount' => $order_detail->discount_amount,
						'promo_percent' => $order_detail->promo_percent,'promo_amount' => $order_detail->promo_amount,'taxable_value' => $order_detail->taxable_value,
						'gst_percentage'=> $order_detail->gst_percentage,'gst_value'=>$order_detail->gst_value,'net_amount'=>$order_detail->net_amount])
						->where(['id'=>$order_detail->id])->execute();						
				}

				foreach($OrderDetails->order_details as $order_detail)
				{
					$total_amount = $total_amount + $order_detail->amount;
					$total_membershipDsicount = $total_membershipDsicount + $order_detail->discount_amount;
					$total_promoDiscount = $total_promoDiscount + $order_detail->promo_amount;
					$total_GST = $total_GST + $order_detail->gst_value;
					$net_amount = $net_amount + $order_detail->net_amount;				
				}
				//pr($OrderDetails);exit;
				//$OrderDetails->total_amount = $total_amount;
				$discount_amount=$total_membershipDsicount + $total_promoDiscount;			
				//$OrderDetails->total_gst = $total_GST;
				$pay_amount	= $total_amount + $total_GST;
				$query = $this->Orders->query();
				$query->update()
				->set(['total_amount'=>$total_amount,'discount_amount'=>$discount_amount,
				'total_gst' =>$total_gst,'pay_amount' =>$pay_amount])
				->where(['id'=>$OrderDetails->id])->execute();				
				
				$message='Canceled Successfully';
        		$success=true;				
				
			}else{
				$message='Something went all item cancel';
        		$success=false;				
			}
		}else{
				$message='No Record Found';
        		$success=false;			
		}
        $this->set(compact('success', 'message'));
        $this->set('_serialize', ['success', 'message']);		
	}	 */
	
	


	public function CustomerItemWiseCancel()
	{
	
        $customer_id=$this->request->query('customer_id');
        $order_id=$this->request->query('order_id');	
		$order_detail_ids = $this->request->query('order_detail_id');
		$isPromoCode = $this->request->query['isPromoCode'];
		$promo_detail_id = $this->request->query['promotion_detail_id'];		
		$isCombo = $this->request->query['isCombo'];
		$combo_offer_id = $this->request->query['combo_offer_id'];	
		//$status = $this->request->query['status'];	
		$status = 'Cancel';	
		
		$discount_amount = 0.00;
		$pay_amount = 0.00;
		$total_gst = 0.00;
		$total_GST = 0.00;			
	
		$order_detail_ids = explode(",",$order_detail_ids);
		
		$combo_offer_id = explode(",",$combo_offer_id);
		
		$total_amount = 0.00;
		$total_membershipDsicount = 0.00;
		$total_promoDiscount = 0.00;	
		$net_amount = 0.00;
		$amount = 0.00;	
		$taxAbleAmount_Total  = 0.00;
		
		if(empty($status)) { $status = 'Cancel'; }	
		
		if(is_array($order_detail_ids) && !empty($order_detail_ids))
		{
			$query = $this->Orders->OrderDetails->query();			
			
			if($isCombo == 'YES' && sizeof($combo_offer_id) > 0)
			{
				foreach($combo_offer_id as $combo_id)
				{
					$query->update()
					->set(['is_item_cancel'=>'Yes','item_status'=>$status,'already_cancel'=>"Yes"])
					->where(['combo_offer_id'=>$combo_id])->where(['order_id'=>$order_id])
					->execute();						
				}			
			} 
			
			foreach($order_detail_ids as $order_detail_id)
			{
				$query->update()
				->set(['is_item_cancel'=>'Yes','item_status'=>$status,'already_cancel'=>"Yes"])
				->where(['id'=>$order_detail_id])->where(['order_id'=>$order_id])
				->execute();				
			}
						
			$OrderDetails = $this->Orders->find()->contain(['OrderDetails' =>function($q){
				return $q->where(['is_item_cancel' =>'No'])->contain(['Items']);
			}])->where(['id'=>$order_id])->first();

			$memberShipDiscount = $this->Orders->Carts->Customers->find()
			->select(['membership_discount'])
			->where(['Customers.id' => $customer_id])
			->where(['Customers.start_date <='=> date('Y-m-d'),'Customers.end_date >='=> date('Y-m-d')])
			->first();
			
			$OrderDetailDatas = $this->Orders->find()->contain(['OrderDetails' =>function($q){
				return $q->where(['is_item_cancel' =>'Yes'])->contain(['Items']);
			}])->where(['id'=>$order_id])->first();
			
			foreach($OrderDetailDatas->order_details as $order_detail_data){
				if($order_detail_data->already_cancel == "Yes"){
					$item= $this->Orders->OrderDetails->ItemVariations->Items->get($order_detail_data->item_id);
					if($item->item_maintain_by=="itemwise"){
						$allItemVariations= $this->Orders->OrderDetails->ItemVariations->find()->where(['ItemVariations.item_id'=>$order_detail_data->item_id,'ItemVariations.city_id'=>@$OrderDetailDatas->city_id,'ItemVariations.seller_id IS NULL'])->contain(['UnitVariations'=>['Units']]);
						$ItemVariationData= $this->Orders->OrderDetails->ItemVariations->get($order_detail_data->item_variation_id);
						$UnitVariation= $this->Orders->OrderDetails->ItemVariations->UnitVariations->get($ItemVariationData->unit_variation_id);
						
						foreach($allItemVariations as $iv){ 
							$p=($UnitVariation->convert_unit_qty*$order_detail_data->quantity); 
							$addQty=($p/$iv->unit_variation->convert_unit_qty); 
							$addQty=round($addQty,2);
							$item_variation_data = $this->Orders->OrderDetails->ItemVariations->get($iv->id);
							
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
							$query = $this->Orders->OrderDetails->ItemVariations->query();
							$query->update()
							->set(['current_stock'=>$final_current_stock,'demand_stock'=>$final_demand_stock,'out_of_stock'=>$out_of_stock,'ready_to_sale'=>$ready_to_sale])
							->where(['id'=>$iv->id])
							->execute(); 
						}
					}else{
						$ItemVariationData = $this->Orders->OrderDetails->ItemVariations->get($order_detail_data->item_variation_id);
						$current_stock=$ItemVariationData->current_stock-$order_detail_data->quantity;
						$cs=$ItemVariationData->current_stock;
						$vs=$ItemVariationData->virtual_stock;
						$demand_stock=$ItemVariationData->demand_stock;
						$actual_quantity=$order_detail_data->quantity;
						$final_current_stock=0;
						$final_demand_stock=0;
						//pr($addQty); exit;
						if($demand_stock==0){
							$final_current_stock=$cs+$order_detail_data->quantity;
							$final_demand_stock=$demand_stock;
						}elseif($demand_stock > $actual_quantity){
							$final_current_stock=0;
							$final_demand_stock=$demand_stock-$order_detail_data->quantity;
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
						$query = $this->Orders->OrderDetails->ItemVariations->query();
						$query->update()
						->set(['current_stock'=>$final_current_stock,'demand_stock'=>$final_demand_stock,'out_of_stock'=>$out_of_stock,'ready_to_sale'=>$ready_to_sale])
						->where(['id'=>$order_detail_data->item_variation_id])
						->execute();
						}
						$query1 = $this->Orders->OrderDetails->query();
						$query1->update()
						->set(['already_cancel'=>'No'])
						->where(['id'=>$order_detail_data->id])
						->execute();	
					}
			}
			//pr($OrderDetails);exit;
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

						$query = $this->Orders->OrderDetails->query();
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
				
				$delivery_charge_amount=$OrderDetails->delivery_charge_amount;
				$total_delivery_charge_amount=0;
				if($delivery_charge_amount=="free"){
					$total_delivery_charge_amount=0;
				}else{
					$total_delivery_charge_amount=$delivery_charge_amount;
				}
				
				
				//pr($OrderDetails);
				//$OrderDetails->total_amount = $total_amount;
				$discount_amount=$total_membershipDsicount + $total_promoDiscount;			
				//$OrderDetails->total_gst = $total_GST;
				$pay_amount	= $total_amount + $total_GST;
				//echo $pay_amount;exit;
				
				$p=$pay_amount;
				$q=round($pay_amount);
				$Round_off_amt=round(($q-$p),2);
				$grand_total = $pay_amount;
				$pay_amount=round($pay_amount);	
				
				$query = $this->Orders->query();
				$query->update()
				->set(['total_amount'=>$total_amount,'discount_amount'=>$discount_amount,'grand_total'=>$grand_total,'round_off'=>$Round_off_amt,'total_gst' =>$total_GST,'pay_amount' =>$pay_amount+$total_delivery_charge_amount])
				->where(['id'=>$OrderDetails->id])->execute();				
				
				$this->UpdateOrderChallan->UpdateChallanOrder($OrderDetails->id,$status);

				$message='Canceled Successfully';
        		$success=true;				
				
			}else{
				$message='Something went all item cancel';
        		$success=false;				
			}
		}else{
				$message='No Record Found';
        		$success=false;			
		}
        $this->set(compact('success', 'message'));
        $this->set('_serialize', ['success', 'message']);		
	}
	
	public function DriverOrderStatus()
	{
        $customer_id=$this->request->query('customer_id');
        $order_id=$this->request->query('order_id');
		$promotion_detail_id = $this->request->query['promotion_detail_id'];		
		$challan_id=$this->request->query('challan_id');
        $cancel_reason_id=$this->request->query('cancel_reason_id');
		$other_reason =  $this->request->query('other_reason');
		$status =  $this->request->query('status');
		$email =  $this->request->query('email');
		$cancel_date = date('Y-m-d');		
		$orders_data = $this->Orders->find()->where(['Orders.id'=>$order_id])
		->contain(['CustomerAddresses'])->first();	
		$mobile = $orders_data->customer_address->mobile_no;
		$order_no = $orders_data->order_no;
		$order_cancel = $this->Orders->query();
		$challanQuery = $this->Orders->Challans->query();
		$sms = '';
		$isPromoCode = 'false';
		$isCombo = 'No';
		$comboIDs = [];
		$comboItemIDs = [];		
		$itemIDs = [];	
		$order_detail_ids = [];
		$total_amount = 0.00;
		$total_membershipDsicount = 0.00;
		$total_promoDiscount = 0.00;	
		$net_amount = 0.00;
		$amount = 0.00;	
		$taxAbleAmount_Total  = 0.00;
		if(empty($status)) { $status = 'Cancel'; }	

		if(!empty($email))
		{
			$query = $this->Orders->Customers->query();			
			$query->update()->set(['email'=>$email])->where(['id'=>$customer_id])
			->execute();							
		}
		
		if($status == 'Returned')
		{ //$this->UpdateOrderChallan->UpdateChallanOrder($order_id,$status);
			
		
			$combo_offer_id = [];		
			if(!empty($promotion_detail_id) && $promotion_detail_id > 0)
			{
				$isPromoCode = 'true';
			}	
			$challanDatas = $this->Orders->Challans->find()
			->contain(['ChallanRows'=> function($q) {
					return $q->where(['is_item_cancel'=>'No']);
			}])->where(['id'=>$challan_id,'order_id'=>$order_id])->first();				
			
			if(!empty($challanDatas->challan_rows))
			{		
				foreach($challanDatas->challan_rows as $challan_row)
				{
					if($challan_row->combo_offer_id > 0)
					{	$isCombo = 'YES';
						$combo_offer_id[] = $challan_row->combo_offer_id;
						$order_detail_ids[] = $challan_row->order_detail_id;
						$order_detail_ids = array_unique($order_detail_ids);
						$combo_offer_id = array_unique($combo_offer_id);	
					}
					
					$order_detail_ids[] = $challan_row->order_detail_id;
				}
			}		
			$order_detail_ids = array_unique($order_detail_ids);	
			
			
		//starting beginning
		
		if(is_array($order_detail_ids) && !empty($order_detail_ids))
		{
			
			if($isCombo == 'YES' && sizeof($combo_offer_id) > 0)
			{
				foreach($combo_offer_id as $combo_id)
				{
					$query = $this->Orders->OrderDetails->query();			
					$query->update()
					->set(['is_item_cancel'=>'Yes','item_status'=>$status])
					->where(['combo_offer_id'=>$combo_id])->where(['order_id'=>$order_id])
					->execute();						
				}	//pr($combo_id); exit; 		
			} 
			//exit;
			foreach($order_detail_ids as $order_detail_id)
			{
				$query = $this->Orders->OrderDetails->query();			
				$query->update()
				->set(['is_item_cancel'=>'Yes','item_status'=>$status])
				->where(['id'=>$order_detail_id])->where(['order_id'=>$order_id])
				->execute();
				
				//////////////////Stock///UP////////////////
				$order_detail_data=$this->Orders->OrderDetails->get($order_detail_id);
				$item= $this->Orders->OrderDetails->ItemVariations->Items->get($order_detail_data->item_id);
						if($item->item_maintain_by=="itemwise"){
							$allItemVariations= $this->Orders->OrderDetails->ItemVariations->find()->where(['ItemVariations.item_id'=>$order_detail_data->item_id,'ItemVariations.city_id'=>@$challanDatas->city_id,'ItemVariations.seller_id IS NULL'])->contain(['UnitVariations'=>['Units']]);
							$ItemVariationData= $this->Orders->OrderDetails->ItemVariations->get($order_detail_data->item_variation_id);
							$UnitVariation= $this->Orders->OrderDetails->ItemVariations->UnitVariations->get($ItemVariationData->unit_variation_id);
							foreach($allItemVariations as $iv){ 
								$p=($UnitVariation->convert_unit_qty*$order_detail_data->quantity); 
								$addQty=($p/$iv->unit_variation->convert_unit_qty); 
								$addQty=round($addQty,2);
								$item_variation_data = $this->Orders->OrderDetails->ItemVariations->get($iv->id);
								
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
								$query = $this->Orders->OrderDetails->ItemVariations->query();
								$query->update()
								->set(['current_stock'=>$final_current_stock,'demand_stock'=>$final_demand_stock,'out_of_stock'=>$out_of_stock,'ready_to_sale'=>$ready_to_sale])
								->where(['id'=>$iv->id])
								->execute(); 
							}
						}else{
							$ItemVariationData = $this->Orders->OrderDetails->ItemVariations->get($order_detail_data->item_variation_id);
							$current_stock=$ItemVariationData->current_stock-$order_detail_data->quantity;
							$cs=$ItemVariationData->current_stock;
							$vs=$ItemVariationData->virtual_stock;
							$demand_stock=$ItemVariationData->demand_stock;
							$actual_quantity=$order_detail_data->quantity;
							$final_current_stock=0;
							$final_demand_stock=0;
							//pr($addQty); exit;
							if($demand_stock==0){
								$final_current_stock=$cs+$order_detail_data->quantity;
								$final_demand_stock=$demand_stock;
							}elseif($demand_stock > $actual_quantity){
								$final_current_stock=0;
								$final_demand_stock=$demand_stock-$order_detail_data->quantity;
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
							$query = $this->Orders->OrderDetails->ItemVariations->query();
							$query->update()
							->set(['current_stock'=>$final_current_stock,'demand_stock'=>$final_demand_stock,'out_of_stock'=>$out_of_stock,'ready_to_sale'=>$ready_to_sale])
							->where(['id'=>$order_detail_data->item_variation_id])
							->execute();
							}
				
				//////////////////Stock////////////////////
			}
			
			$OrderDetails = $this->Orders->find()->contain(['OrderDetails' =>function($q){
				return $q->where(['is_item_cancel' =>'No'])->contain(['Items']);
			}])->where(['id'=>$order_id])->first();

			$memberShipDiscount = $this->Orders->Carts->Customers->find()
			->select(['membership_discount'])
			->where(['Customers.id' => $customer_id])
			->where(['Customers.start_date <='=> date('Y-m-d'),'Customers.end_date >='=> date('Y-m-d')])
			->first();
				
			//pr($OrderDetails);exit;
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

						$query = $this->Orders->OrderDetails->query();
						$query->update()
						->set(['amount'=>$amount,'discount_percent' => $order_detail->discount_percent,'discount_amount' => $order_detail->discount_amount,
						'promo_percent' => $order_detail->promo_percent,'promo_amount' => $order_detail->promo_amount,'taxable_value' => $order_detail->taxable_value,
						'gst_percentage'=> $order_detail->gst_percentage,'gst_value'=>$order_detail->gst_value,'net_amount'=>$order_detail->net_amount])
						->where(['id'=>$order_detail->id])->execute();						
				}
				$total_GST = 0.00;
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
				//pr($OrderDetails); exit;
				//$OrderDetails->total_amount = $total_amount;
				$discount_amount=$total_membershipDsicount + $total_promoDiscount;			
				//$OrderDetails->total_gst = $total_GST;
				$pay_amount	= $total_amount + $total_GST;
				//echo $pay_amount;exit;
				
				$p=$pay_amount;
				$q=round($pay_amount);
				$Round_off_amt=round(($q-$p),2);
				$grand_total = $pay_amount;
				$pay_amount=round($pay_amount);	
				
				$query = $this->Orders->query();
				$query->update()
				->set(['total_amount'=>$total_amount,'discount_amount'=>$discount_amount,'grand_total'=>$grand_total,'round_off'=>$Round_off_amt,'total_gst' =>$total_GST,'pay_amount' =>$pay_amount])
				->where(['id'=>$OrderDetails->id])->execute();				
				
				$this->UpdateOrderChallan->UpdateChallanOrder($OrderDetails->id,$status);

			//  end code 			
			$cancelOrderCount = $this->Orders->Customers->find()->select(['cancel_order_count'])->where(['id' => $customer_id])->first();
			$CountCancelOrder = $cancelOrderCount->cancel_order_count;
			$CountCancelOrder = $CountCancelOrder + 1;
			$customers = $this->Orders->Customers->query();
			$customers->update()->set(['cancel_order_count' => $CountCancelOrder])
			->where(['id' => $customer_id])->execute(); 				
			
				$sms="Your order no ".$order_no." has been returned. Thank you !";
				$success=true;			
				$message='Thank you, your order has been returned.';
				
			/////////////////Notification////AND////////////////////////
		$customer_details=$this->Orders->Customers->find()
		->where(['Customers.id' => $customer_id])->first();
		$main_device_token1=$customer_details->device_token;
		$mob=$customer_details->username;
				 
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
				'title'=> 'Order Returned',
				'message' => 'Your Order Has Been Returned',
				'image' => 'img/jain.png',
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
			//pr($payload);
			$final_result=json_decode($response);
			$sms_flag=$final_result->success; 	
			if ($err) {
			 // echo "cURL Error #:" . $err;
			} else {
			//	$response;
			}

			$orderLink = 'jainthela://order?id='.$order_id;			
			$url = 'https://fcm.googleapis.com/fcm/send';
			
			
			$fcmRegIds = array();
			$fields = [
				"notification" => ["title" => "Order Returned", "text" => "Your Order Has Been Returned","sound" => "default",'notification_id'=>$random,"link" =>$orderLink],
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

			/* 	$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
				curl_exec($ch);
				curl_close($ch); */					

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
			/////////////////Notification////END////////////////////////		
				
				
		}	
		}else{
				$success=false;			
				$message='No item found';
		}
		}		
		else {
			 $result = $challanQuery->update()
				->set(['order_status' => $status,'delivery_date' => $cancel_date])
				->where(['id'=>$challan_id,'order_id' => $order_id])->execute();


			$challanDatas = $this->Orders->Challans->find()
			->contain(['ChallanRows'=> function($q) {
					return $q->select(['challan_id','order_detail_id'])->where(['is_item_cancel'=>'No']);
			}])
			->where(['id'=>$challan_id,'order_id'=>$order_id])->first();				
				
			
			if(!empty($challanDatas->challan_rows))
			{		
				foreach($challanDatas->challan_rows as $challan_row)
				{
					$orderDetailQuery = $this->Orders->OrderDetails->query();
					$orderDetailQuery->update()
					->set(['item_status' => $status])
					->where(['id'=>$challan_row->order_detail_id,'order_id' => $order_id])->execute();
				}
			} 
			
			
			//Accounting START
			//$order->financial_year_id=@$FinancialYear->id;	
			
			$Challan = $this->Orders->Challans->get($challan_id	, [
            'contain' => ['SellerLedgers','PartyLedgers','Locations','Customers','CustomerAddresses', 'ChallanRows'=>['ItemVariations'=>['Items'], 'ComboOffers']]
			]);
			
			$today=date('Y-m-d');
			$FinancialYear = $this->Orders->FinancialYears->find()->where(['FinancialYears.city_id'=>$Challan->city_id,'FinancialYears.fy_from <='=>$today,'FinancialYears.fy_to >='=>$today])->first();
			$CityData = $this->Orders->Challans->Cities->get($Challan->city_id);
			$StateData = $this->Orders->Challans->Cities->States->get($CityData->state_id);
			
			$deliver_by=$Challan->seller_name;
			$Voucher_no = $this->Orders->Challans->Invoices->find()->select(['voucher_no'])->where(['Invoices.city_id'=>$Challan->city_id,'Invoices.financial_year_id'=>$FinancialYear->id])->order(['voucher_no' => 'DESC'])->first();
			if($Voucher_no){$voucher_no=$Voucher_no->voucher_no+1;}
			else{$voucher_no=1;}
			$order_no=$CityData->alise_name.'/IN/'.$voucher_no;
			$order_no=$StateData->alias_name.'/'.$order_no;
			
			
			$Invoice = $this->Orders->Challans->Invoices->newEntity(); 
			$Invoice->seller_id=$Challan->seller_id;
			$Invoice->seller_name=$Challan->seller_name;
			$Invoice->challan_id=$Challan->id;
			$Invoice->order_id=$Challan->order_id;
			$Invoice->location_id=$Challan->location_id;
			$Invoice->delivery_date=$Challan->delivery_date;
			$Invoice->delivery_time_id=$Challan->delivery_time_id;
			$Invoice->delivery_time_sloat=$Challan->delivery_time_sloat;
			$Invoice->customer_address_id=$Challan->customer_address_id;
			$Invoice->voucher_no=$voucher_no;
			$Invoice->invoice_no=$order_no;
			//$Invoice->seller_name=$sellerLedgerData->name;
			$Invoice->order_type=$Challan->order_type;
			$Invoice->financial_year_id=$FinancialYear->id;
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
			$Invoice->transaction_date=$Challan->order_date;
			$Invoice->round_off=$Challan->round_off; 
			$Invoice->order_status="Delivered";
			$Invoice->delivery_charge_amount=@$Challan->delivery_charge_amount;  
			$Invoice->grand_total=@$Challan->grand_total;  
			$Invoice->discount_amount=@$Challan->discount_amount;  
			$Invoice->total_gst=@$Challan->total_gst;  
			$Invoice->total_amount=@$Challan->total_amount;  
			$Invoice->deliver_by=@$deliver_by; 
			if($this->Orders->Challans->Invoices->save($Invoice)){
			//if(($Invoice)){
				foreach($Challan->challan_rows as $data){
					if($data->is_item_cancel=="No"){
						$InvoiceRow = $this->Orders->Challans->Invoices->InvoiceRows->newEntity(); 
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
						$InvoiceRow->net_amount=$data->net_amount; //pr($InvoiceRow); exit;
						$this->Orders->Challans->Invoices->InvoiceRows->save($InvoiceRow);
					}
				}
			}
			
			//$Invoice->id=4;
			$InvoiceData = $this->Orders->Challans->Invoices->get($Invoice->id, [
            'contain' => ['SellerLedgers','PartyLedgers','Locations','Customers','CustomerAddresses', 'InvoiceRows'=>['ItemVariations'=>['Items'], 'ComboOffers']]
			]);
			//pr($InvoiceData); exit;
			//exit;
			
			if($InvoiceData->order_type ==  "Wallet"){
				// Ledger entry for Customer
				$LedgerData = $this->Orders->Challans->Invoices->Ledgers->find()->where(['Ledgers.customer_id'=>$InvoiceData->customer_id,'Ledgers.city_id'=>$InvoiceData->city_id])->first();
				$customer_ledger_id=$LedgerData->id; 
				$AccountingEntrie = $this->Orders->AccountingEntries->newEntity(); 
				$AccountingEntrie->ledger_id=$customer_ledger_id;
				$AccountingEntrie->debit=$InvoiceData->pay_amount;
				$AccountingEntrie->credit=0;
				$AccountingEntrie->transaction_date=date('Y-m-d');
				$AccountingEntrie->city_id=$InvoiceData->city_id;
				$AccountingEntrie->entry_from="Web";
				$AccountingEntrie->invoice_id=$InvoiceData->id; 
				$this->Orders->AccountingEntries->save($AccountingEntrie);
				
				//	Payment History
				$OrderPaymentHistory = $this->Orders->Challans->Invoices->OrderPaymentHistories->newEntity();
				$OrderPaymentHistory->order_id=$InvoiceData->order_id;
				$OrderPaymentHistory->invoice_id=$InvoiceData->id;
				$OrderPaymentHistory->wallet_amount=$InvoiceData->pay_amount;
				$OrderPaymentHistory->total=$InvoiceData->pay_amount;
				$OrderPaymentHistory->entry_from="Invoice"; 
				$this->Orders->Challans->Invoices->OrderPaymentHistories->save( $OrderPaymentHistory);
			}else if($InvoiceData->order_type == "Online"){ 
				$LedgerData = $this->Orders->Challans->Invoices->Ledgers->find()->where(['Ledgers.customer_id'=>$InvoiceData->customer_id,'Ledgers.city_id'=>$InvoiceData->city_id])->first();
				
				// Ledger entry for Customer
				$AccountingEntrie = $this->Orders->AccountingEntries->newEntity(); 
				$AccountingEntrie->ledger_id=$LedgerData->id; 
				$AccountingEntrie->debit=$InvoiceData->pay_amount;
				$AccountingEntrie->credit=0;
				$AccountingEntrie->transaction_date=date('Y-m-d');
				$AccountingEntrie->city_id=$InvoiceData->city_id;
				$AccountingEntrie->entry_from="Web";
				$AccountingEntrie->invoice_id=$InvoiceData->id;  
				$this->Orders->AccountingEntries->save($AccountingEntrie);
				
				//	Payment History
				 $OrderPaymentHistory = $this->Orders->Challans->Invoices->OrderPaymentHistories->newEntity();
				 $OrderPaymentHistory->order_id=$InvoiceData->order_id;
				 $OrderPaymentHistory->invoice_id=$InvoiceData->id;
				 //$OrderPaymentHistory->online_amount=$order->online_amount;
				 $OrderPaymentHistory->online_amount=$InvoiceData->pay_amount;
				 $OrderPaymentHistory->total=$InvoiceData->pay_amount;
				 //$OrderPaymentHistory->wallet_return=;
				 $OrderPaymentHistory->entry_from="Invoice";
				 $this->Orders->Challans->Invoices->OrderPaymentHistories->save( $OrderPaymentHistory); 
				
				
			}else if($InvoiceData->order_type == "COD"){
					
					$LedgerData = $this->Orders->Challans->Invoices->Ledgers->find()->where(['Ledgers.cash' =>'1','Ledgers.city_id'=>$InvoiceData->city_id])->first();
					$cash_acc_ledger_id=$LedgerData->id; 
					$AccountingEntrie = $this->Orders->AccountingEntries->newEntity(); 
					$AccountingEntrie->ledger_id=$cash_acc_ledger_id;
					$AccountingEntrie->debit=$InvoiceData->pay_amount;
					$AccountingEntrie->credit=0;
					$AccountingEntrie->transaction_date=date('Y-m-d');
					$AccountingEntrie->city_id=$InvoiceData->city_id;
					$AccountingEntrie->entry_from="Web";
					$AccountingEntrie->invoice_id=$InvoiceData->id; 
					$this->Orders->AccountingEntries->save($AccountingEntrie);
					
					//	Payment History
					$OrderPaymentHistory = $this->Orders->Challans->Invoices->OrderPaymentHistories->newEntity();
					$OrderPaymentHistory->order_id=$InvoiceData->order_id;
					$OrderPaymentHistory->invoice_id=$InvoiceData->id;
					//$OrderPaymentHistory->online_amount=$order->online_amount;
					$OrderPaymentHistory->cod_amount=$InvoiceData->pay_amount;
					$OrderPaymentHistory->total=$InvoiceData->pay_amount;
					//$OrderPaymentHistory->wallet_return=$payToCustomer;
					$OrderPaymentHistory->entry_from="Invoice"; //pr($OrderPaymentHistory); exit;
					$this->Orders->Challans->Invoices->OrderPaymentHistories->save( $OrderPaymentHistory); 
					
					if($InvoiceData->deliver_by=="Seller"){
						$Voucher_no = $this->Orders->Challans->JournalVouchers->find()->select(['voucher_no'])->where(['city_id'=>$InvoiceData->city_id])->order(['voucher_no' => 'DESC'])->first();
						
						if($Voucher_no){
							$voucher_no=$Voucher_no->voucher_no+1;
						}else{
							$voucher_no=1;
						}
						
						$JournalVoucher = $this->Orders->Challans->JournalVouchers->newEntity();
						$JournalVoucher->voucher_no = $voucher_no;
						$JournalVoucher->city_id = $InvoiceData->city_id;
						$JournalVoucher->financial_year_id = $FinancialYear->id;
						$JournalVoucher->transaction_date = date('Y-m-d');
						$JournalVoucher->created_on = date('Y-m-d');
						$JournalVoucher->created_by =$user_id;
						$JournalVoucher->narration ="Customer COD Amount";
						$this->Orders->Challans->JournalVouchers->save($JournalVoucher);
							
						
						
						$SellerLedgerData = $this->Orders->Challans->Invoices->Ledgers->find()->where(['Ledgers.seller_id' =>$InvoiceData->seller_id,'Ledgers.city_id'=>$InvoiceData->city_id])->first();
						
						//Seller Accounting
						$JournalVoucherRow = $this->Orders->Challans->JournalVouchers->JournalVoucherRows->newEntity();
						$JournalVoucherRow->journal_voucher_id = $JournalVoucher->id;
						$JournalVoucherRow->ledger_id = $SellerLedgerData->id;
						$JournalVoucherRow->cr_dr ="Dr";
						$JournalVoucherRow->debit = $InvoiceData->pay_amount;
						$JournalVoucherRow->credit =0;
						$this->Orders->Challans->JournalVouchers->JournalVoucherRows->save($JournalVoucherRow);
						$AccountingEntries1 = $this->Orders->AccountingEntries->newEntity();
						$AccountingEntries1->ledger_id = $SellerLedgerData->id;
						$AccountingEntries1->city_id = $InvoiceData->city_id;
						$AccountingEntries1->transaction_date = date('Y-m-d');
						$AccountingEntries1->debit = $InvoiceData->pay_amount;
						$AccountingEntries1->credit =0;
						$AccountingEntries1->journal_voucher_id = $JournalVoucher->id;
						$this->Orders->AccountingEntries->save($AccountingEntries1);
						
						//Cash Accounting
						$JournalVoucherRow = $this->Orders->Challans->JournalVouchers->JournalVoucherRows->newEntity();
						$JournalVoucherRow->journal_voucher_id = $JournalVoucher->id;
						$JournalVoucherRow->ledger_id = $cash_acc_ledger_id;
						$JournalVoucherRow->cr_dr ="Cr";
						$JournalVoucherRow->credit = $InvoiceData->pay_amount;
						$JournalVoucherRow->debit =0;
						$this->Orders->Challans->JournalVouchers->JournalVoucherRows->save($JournalVoucherRow);
						$AccountingEntries1 = $this->Orders->AccountingEntries->newEntity();
						$AccountingEntries1->ledger_id = $cash_acc_ledger_id;
						$AccountingEntries1->city_id = $InvoiceData->city_id;
						$AccountingEntries1->transaction_date = date('Y-m-d');
						$AccountingEntries1->credit = $InvoiceData->pay_amount;
						$AccountingEntries1->debit =0;
						$AccountingEntries1->journal_voucher_id = $JournalVoucher->id;
						$this->Orders->AccountingEntries->save($AccountingEntries1);
						
						if($SellerLedgerData->bill_to_bill_accounting=="yes"){
							$ReferenceDetail = $this->Orders->Challans->JournalVouchers->ReferenceDetails->newEntity(); 
							$ReferenceDetail->ledger_id=$SellerLedgerData->id;
							$ReferenceDetail->debit=$InvoiceData->pay_amount;
							$ReferenceDetail->credit=0;
							$ReferenceDetail->transaction_date=date('Y-m-d');
							$ReferenceDetail->city_id=$InvoiceData->city_id;
							$ReferenceDetail->entry_from="Web";
							$ReferenceDetail->type='New Ref';
							$ReferenceDetail->ref_name=$InvoiceData->invoice_no;
							$ReferenceDetail->journal_voucher_id=$JournalVoucher->id;//pr($ReferenceDetail); exit;
							$this->Orders->Challans->JournalVouchers->ReferenceDetails->save($ReferenceDetail);
						}
					//	pr($JournalVoucher); exit;
					}
			}else if($InvoiceData->order_type == "Wallet/Online"){
				// Ledger entry for Customer
				$LedgerData = $this->Orders->Challans->Invoices->Ledgers->find()->where(['Ledgers.customer_id'=>$InvoiceData->customer_id,'Ledgers.city_id'=>$InvoiceData->city_id])->first();
				
				$AccountingEntrie = $this->Orders->AccountingEntries->newEntity(); 
				$AccountingEntrie->ledger_id=$LedgerData->id; 
				$AccountingEntrie->debit=$InvoiceData->pay_amount;
				$AccountingEntrie->credit=0;
				$AccountingEntrie->transaction_date=date('Y-m-d');
				$AccountingEntrie->city_id=$InvoiceData->city_id;
				$AccountingEntrie->entry_from="Web";
				$AccountingEntrie->invoice_id=$InvoiceData->id;  
				$this->Orders->AccountingEntries->save($AccountingEntrie);
					
			}else if($InvoiceData->order_type == "Credit"){
				// Ledger entry for Customer
				$LedgerData = $this->Orders->Challans->Invoices->Ledgers->find()->where(['Ledgers.customer_id'=>$InvoiceData->customer_id,'Ledgers.city_id'=>$InvoiceData->city_id])->first();
				$customer_ledger_id=$LedgerData->id; 
				$AccountingEntrie = $this->Orders->AccountingEntries->newEntity(); 
				$AccountingEntrie->ledger_id=$customer_ledger_id;
				$AccountingEntrie->debit=$InvoiceData->pay_amount;
				$AccountingEntrie->credit=0;
				$AccountingEntrie->transaction_date=date('Y-m-d');
				$AccountingEntrie->city_id=$InvoiceData->city_id;
				$AccountingEntrie->entry_from="Web";
				$AccountingEntrie->invoice_id=$InvoiceData->id; 
				$this->Orders->AccountingEntries->save($AccountingEntrie);
				
				if($LedgerData->bill_to_bill_accounting=="yes"){
					$ReferenceDetail = $this->Orders->ReferenceDetails->newEntity(); 
					$ReferenceDetail->ledger_id=$LedgerData->id;
					$ReferenceDetail->debit=$InvoiceData->pay_amount;
					$ReferenceDetail->credit=0;
					$ReferenceDetail->transaction_date=date('Y-m-d');
					$ReferenceDetail->city_id=$InvoiceData->city_id;
					$ReferenceDetail->entry_from="Web";
					$ReferenceDetail->type='New Ref';
					$ReferenceDetail->ref_name=$InvoiceData->invoice_no;
					$ReferenceDetail->invoice_id=$InvoiceData->id; //pr($ReferenceDetail); exit;
					$this->Orders->ReferenceDetails->save($ReferenceDetail);
				}
				
			}
			
			// Sales Account Entry 
			$AccountingEntrie = $this->Orders->AccountingEntries->newEntity(); 
			$AccountingEntrie->ledger_id=$InvoiceData->sales_ledger_id;
			$AccountingEntrie->credit=$InvoiceData->total_amount;
			$AccountingEntrie->debit=0;
			$AccountingEntrie->transaction_date=date('Y-m-d');
			$AccountingEntrie->city_id=$InvoiceData->city_id;
			$AccountingEntrie->entry_from="Web";
			$AccountingEntrie->invoice_id=$InvoiceData->id;
			$this->Orders->AccountingEntries->save($AccountingEntrie);
			
			//Delivery Charges Entry
			if($InvoiceData->delivery_charge_amount > 0){
				$TransportLedger = $this->Orders->Challans->Invoices->Ledgers->find()->where(['Ledgers.transport' =>'Receive','Ledgers.city_id'=>$InvoiceData->city_id])->first();
					$AccountingEntrie1 = $this->Orders->AccountingEntries->newEntity();
					$AccountingEntrie1->ledger_id=$TransportLedger->id;
					$AccountingEntrie1->credit=$InvoiceData->delivery_charge_amount;
					$AccountingEntrie1->debit=0;
					$AccountingEntrie1->transaction_date=$InvoiceData->order_date;
					$AccountingEntrie1->city_id=$InvoiceData->city_id;
					$AccountingEntrie1->entry_from="Web";
					$AccountingEntrie1->invoice_id=$InvoiceData->id; 
					$this->Orders->AccountingEntries->save($AccountingEntrie1);
				}
			
			
			//round Off Entry
			$roundOffLedger = $this->Orders->Challans->Invoices->Ledgers->find()->where(['Ledgers.round_off' =>'1','Ledgers.city_id'=>$InvoiceData->city_id])->first(); 
			$AccountingEntrie = $this->Orders->AccountingEntries->newEntity(); 
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
				$this->Orders->AccountingEntries->save($AccountingEntrie);
			}
			
			//GST Accounting Entry
			foreach($InvoiceData->invoice_rows as $invoice_row){  
				$ItemData = $this->Orders->Challans->Invoices->InvoiceRows->Items->find()->where(['Items.id'=>$invoice_row->item_id])->first();
				
				$gstAmtdata=$invoice_row->gst_value/2;
				$gstAmtInsert=round($gstAmtdata,2);
				
				//$gstLedgerCGST = $this->Challans->Invoices->Ledgers->find()->where(['Ledgers.gst_figure_id' =>$ItemData->gst_figure_id, 'Ledgers.input_output'=>'output', 'Ledgers.gst_type'=>'CGST','city_id'=>$InvoiceData->city_id])->first();
					
				//Accounting Entries for CGST//
				$gstLedgerCGST = $this->Orders->Challans->Invoices->Ledgers->find()
				->where(['Ledgers.gst_figure_id' =>$ItemData->gst_figure_id, 'Ledgers.input_output'=>'output', 'Ledgers.gst_type'=>'CGST','city_id'=>$InvoiceData->city_id])->first();
				$AccountingEntrieCGST = $this->Orders->AccountingEntries->newEntity();
				$AccountingEntrieCGST->ledger_id=$gstLedgerCGST->id;
				$AccountingEntrieCGST->credit=$gstAmtInsert;
				$AccountingEntrieCGST->debit=0;
				$AccountingEntrieCGST->transaction_date=date('Y-m-d');
				$AccountingEntrieCGST->city_id=$InvoiceData->city_id;
				$AccountingEntrieCGST->entry_from="Web";
				$AccountingEntrieCGST->invoice_id=$InvoiceData->id; 
				if($gstAmtInsert > 0){
					$this->Orders->AccountingEntries->save($AccountingEntrieCGST);
				}
				
				//Accounting Entries for SGST//
				 $gstLedgerSGST = $this->Orders->Challans->Invoices->Ledgers->find()
				->where(['Ledgers.gst_figure_id' =>$ItemData->gst_figure_id, 'Ledgers.input_output'=>'output', 'Ledgers.gst_type'=>'SGST','city_id'=>$InvoiceData->city_id])->first();
				$AccountingEntrieSGST = $this->Orders->AccountingEntries->newEntity();
				$AccountingEntrieSGST->ledger_id=$gstLedgerSGST->id;
				$AccountingEntrieSGST->credit=$gstAmtInsert;
				$AccountingEntrieSGST->debit=0;
				$AccountingEntrieSGST->transaction_date=date('Y-m-d');
				$AccountingEntrieSGST->city_id=$InvoiceData->city_id;
				$AccountingEntrieSGST->entry_from="Web";
				$AccountingEntrieSGST->invoice_id=$InvoiceData->id;  
				if($gstAmtInsert > 0){
					$this->Orders->AccountingEntries->save($AccountingEntrieSGST);
				}
				
				//Stock Entry in Item Ledgers
				$orderDetailsData = $this->Orders->Challans->Invoices->InvoiceRows->get($invoice_row->id, [
					'contain' => ['ItemVariations']
				]);
				
				if($InvoiceData->seller_name == "JainThela"){
					$ItemLedger = $this->Orders->Challans->Invoices->InvoiceRows->ItemLedgers->newEntity(); 
					$ItemLedger->item_id=$orderDetailsData->item_id; 
					$ItemLedger->unit_variation_id=$orderDetailsData->item_variation->unit_variation_id;
					$ItemLedger->item_variation_id=$orderDetailsData->item_variation_id;
					$ItemLedger->transaction_date=date('Y-m-d');  
					$ItemLedger->quantity=$invoice_row->quantity;
					$ItemLedger->rate=$invoice_row->rate;
					$ItemLedger->amount=$invoice_row->quantity*$invoice_row->rate;
					$ItemLedger->sales_rate=$invoice_row->rate;
					$ItemLedger->status="Out";
					$ItemLedger->city_id=$InvoiceData->city_id;
					$ItemLedger->location_id=$InvoiceData->location_id;
					$ItemLedger->invoice_id=$InvoiceData->id;
					$ItemLedger->invoice_row_id=$invoice_row->id; 
					$this->Orders->Challans->Invoices->InvoiceRows->ItemLedgers->save($ItemLedger);
				}
			}
			
			$query = $this->Orders->Challans->query();
			$query->update()
					->set(['order_status'=>'Delivered'])
					->where(['id'=>$InvoiceData->challan_id])
					->execute(); 
			
			$query = $this->Orders->query();
			$query->update()
					->set(['is_applicable_for_cancel'=>'No'])
					->where(['id'=>$InvoiceData->order_id])
					->execute(); 
			
			
			//Updating in order
			$Challans=$this->Orders->Challans->find()->where(['Challans.order_id'=>$InvoiceData->order_id]);
			$totalOrder=(sizeof($Challans->toArray()));
			
			if($totalOrder==1){
				$query = $this->Orders->query();
				$query->update()
					->set(['order_status'=>'Delivered'])
					->where(['id'=>$InvoiceData->order_id])
					->execute();
					
				$InvoiceRows=$this->Orders->Challans->Invoices->InvoiceRows->find()->where(['InvoiceRows.invoice_id'=>$InvoiceData->id]);
				foreach($InvoiceRows as $dt){ 
					$query = $this->Orders->OrderDetails->query();
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
				$InvoiceRows=$this->Orders->Challans->Invoices->InvoiceRows->find()->where(['InvoiceRows.invoice_id'=>$InvoiceData->id]);
				foreach($InvoiceRows as $dt){ 
					$query = $this->Orders->OrderDetails->query();
					$query->update()
						->set(['item_status'=>'Delivered'])
						->where(['id'=>$dt->order_detail_id])
						->execute();
				}
				
				if($order_status=="Delivered"){
					$query = $this->Orders->query();
					$query->update()
						->set(['order_status'=>'Delivered'])
						->where(['id'=>$InvoiceData->order_id])
						->execute();
				}
			}
			
			/////////////////Notification////AND////////////////////////
		$customer_details=$this->Orders->Customers->find()
		->where(['Customers.id' => $InvoiceData->customer_id])->first();
		$mob=$customer_details->username;
		$main_device_token1=$customer_details->device_token;
				 
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
				'title'=> 'Order Delivered',
				'message' => 'Your Order Has Been Delivered',
				'image' => 'img/jain.png',
				'link' => 'jainthela://order?id='.$InvoiceData->id,
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
			//pr($payload);
			$final_result=json_decode($response);
			$sms_flag=$final_result->success; 	
			if ($err) {
			 // echo "cURL Error #:" . $err;
			} else {
			//	$response;
			}

			$orderLink = 'jainthela://order?id='.$InvoiceData->id;			
			$url = 'https://fcm.googleapis.com/fcm/send';
			
			
			$fcmRegIds = array();
			$fields = [
				"notification" => ["title" => "Order Delivered", "text" => "Your Order Has Been Delivered","sound" => "default",'notification_id'=>$random,"link" =>$orderLink],
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
			/////////////////Notification////END////////////////////////	
			
			//////////////////////SMS///Start//////////////////
	  
					$sms=str_replace(' ', '+', 'Your order has been Delivered');
					$sms_sender='JAINTE';
					$sms=str_replace(' ', '+', $sms);
					//file_get_contents('http://103.39.134.40/api/mt/SendSMS?user=phppoetsit&password=9829041695&senderid='.$sms_sender.'&channel=Trans&DCS=0&flashsms=0&number='.$mob.'&text='.$sms.'&route=7');
			//////////////////////SMS///ENd//////////////////
			
			//End Accounting
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
 ?>