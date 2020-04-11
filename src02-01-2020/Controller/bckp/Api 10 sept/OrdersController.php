<?php
namespace App\Controller\Api;
use Cake\Event\Event;
use Cake\Network\Exception\UnauthorizedException;
use Cake\Utility\Security;
use Firebase\JWT\JWT;


class OrdersController extends AppController
{
	
	public function initialize()
	{
		parent::initialize();
		$this->Auth->allow(['DriverOrderList','CustomerVerify','DriverOrderStatus','DriverOrderDetail','ItemWiseCancelOrder']);
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
  				$grand_total1 = $order->total_amount;
				$grand_total=number_format(round($grand_total1), 2);
				$payableAmount = $payableAmount + $grand_total1;

				
				$payableAmount = number_format($payableAmount,2);

					if(empty($order->delivery_charge_amount))
					{
						$order->delivery_charge_amount = 'Free';
					}
				
				  //$order->delivery_charge_amount = $delivery_charge_amount;
				  $order->grand_total = $grand_total;
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
        $customer_id=$this->request->query('customer_id');
    		$order_id=$this->request->query('order_id');
        $city_id=$this->request->query('city_id');
        $orders_details_data = $this->Orders->find()
          ->contain(['OrderDetails'=> function($q) {
			  return $q->where(['combo_offer_id' =>0])
			  ->contain(['ItemVariations'=>['ItemVariationMasters','Items','UnitVariations'=>['Units']]]);
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
					$total_cat_wise = $total_cat_wise + $arrData->amount;	
				}				  
                $order_details[] = ['category_name'=>$category_arr[$key],'total_cat_wise'=>$total_cat_wise,'category'=>$value];
              }

/* 			  $comboTotal = 0.00;
			  $comboDataCounts = $this->Orders->OrderDetails->find()
                ->innerJoinWith('ComboOffers')
                ->where(['order_id' => $order_id])
                ->where(['combo_offer_id !=' =>0])->toArray();;
				
					if(!empty($comboDataCounts))
					{
						foreach($comboDataCounts as $comboDataCount)
						{
							$comboTotal = $comboTotal + $comboDataCount->net_amount;
						}
					} */
			
              $comboData =[];
              $comboData = $this->Orders->OrderDetails->find()
                ->innerJoinWith('ComboOffers')
                ->where(['order_id' => $order_id])
                ->where(['combo_offer_id !=' =>0])
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
				$order_data->total_amount = round($order_data->total_amount);
                $grand_total1 += $order_data->total_amount;
				
				if(empty($order_data->delivery_charge_amount)){
					$delivery_charge_amount = "free";
				}else {
				  $delivery_charge_amount =	$order_data->delivery_charge_amount;
				}
				
              }

			 // pr($orders_details_data);exit; array_replace($order_data->order_details,$order_details)

          			$grand_total=number_format(round($grand_total1), 2);
          			$payableAmount = $payableAmount + $grand_total1;

                // $delivery_charges=$this->Orders->DeliveryCharges->find()->where(['city_id'=>$city_id]);
          			// if(!empty($delivery_charges->toArray()))
          			// {
						// foreach ($delivery_charges as $delivery_charge) {
							// if($delivery_charge->amount >= $grand_total)
							// {
								 // $delivery_charge_amount = "$delivery_charge->charge";
								 // $payableAmount = $payableAmount + $delivery_charge->charge;
							// }else
							// {
								
							// }
						// }
          			// }
          			$payableAmount = $order_data->pay_amount;

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

    public function CancelOrder()
    {
        $customer_id=$this->request->query('customer_id');
        $order_id=$this->request->query('order_id');
        $cancel_reason_id=$this->request->query('cancel_reason_id');

        $odrer_datas=$this->Orders->get($order_id);
		$amount_from_wallet=$odrer_datas->amount_from_wallet;
		$amount_from_promo_code=$odrer_datas->amount_from_promo_code;
		$online_amount=$odrer_datas->online_amount;
		$return_amount=$amount_from_wallet+$amount_from_promo_code+$online_amount;
        $order_type = $odrer_datas->order_type;
        $other_reason = $odrer_datas->other_reason;
        $city_id = $odrer_datas->city_id;
        $cancel_date = date('Y-m-d');

        $order_cancel = $this->Orders->query();

        $result = $order_cancel->update()
					->set(['order_status' => 'Cancel','cancel_reason_id' => $cancel_reason_id, 'cancel_date' => $cancel_date,'cancel_reason_other'=>$other_reason])
					->where(['id' => $order_id])->execute();

        if($order_type == 'Online')
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
/* 		$customer_address_id=$this->request->query('customer_address_id');
		$orders_data = $this->Orders->CustomerAddresses->find()
		->select('mobile_no')
		->where(['id'=>$customer_address_id])->first();
		$address_Mobile_no = $orders_data->mobile_no;	 */
		$address_Mobile_no = $this->request->query('mobile_no');
		if(!empty($address_Mobile_no)){
			$opt=(mt_rand(1111,9999));
			$content="Your one time password for order verification is ".$opt;
			$this->Sms->sendSms($address_Mobile_no,$content);
			$success = true;
			$message = 'send otp successfully';
		}else{
			$success = false;
			$message = 'otp is not send';
			$opt = '';
		}

		$this->set(['success' => $success,'otp'=>$opt,'message'=>$message,'_serialize' => ['success','otp','message']]);	
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
		
		$this->Sms->sendSms($mobile,$sms);	
		
        $this->set(compact('success', 'message'));
        $this->set('_serialize', ['success', 'message']);		
	}

	
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
		  $delivery_date = $this->request->data['delivery_date'];
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
				 //pr($order_details);exit;
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
			$this->request->data['grand_total']=round($net_amount);
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
			}  
			
			$p=$order->grand_total;
			$q=round($order->grand_total);
			$Round_off_amt=round(($p-$q),2);
			$order->grand_total=round($order->grand_total);	
			$order->round_off=$Round_off_amt;
			
			foreach($order->order_details as $order_detail)
			{
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
						
					foreach($order->order_details as $order_detail){
							
							$ItemVariationData = $this->Orders->OrderDetails->ItemVariations->get($order_detail->item_variation_id);
							$current_stock=$ItemVariationData->current_stock-$order_detail->quantity;
							$cs = $ItemVariationData->current_stock;
							$vs = $ItemVariationData->virtual_stock;
							$ds = $ItemVariationData->demand_stock;
							$actual_quantity = $order_detail->quantity;

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
							
							$query = $this->Orders->OrderDetails->ItemVariations->query();
							$query->update()
							->set(['current_stock'=>$final_cs,'demand_stock'=>$final_ds,'out_of_stock'=>$out_of_stock,'ready_to_sale'=>$ready_to_sale])
							->where(['id'=>$order_detail->item_variation_id])
							->execute(); 
						}
								
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
						
					foreach($order->order_details as $order_detail){
							
							$ItemVariationData = $this->Orders->OrderDetails->ItemVariations->get($order_detail->item_variation_id);
							$current_stock=$ItemVariationData->current_stock-$order_detail->quantity;
							$cs = $ItemVariationData->current_stock;
							$vs = $ItemVariationData->virtual_stock;
							$ds = $ItemVariationData->demand_stock;
							$actual_quantity = $order_detail->quantity;

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
							
							$query = $this->Orders->OrderDetails->ItemVariations->query();
							$query->update()
							->set(['current_stock'=>$final_cs,'demand_stock'=>$final_ds,'out_of_stock'=>$out_of_stock,'ready_to_sale'=>$ready_to_sale])
							->where(['id'=>$order_detail->item_variation_id])
							->execute(); 
						}
				}				
				
				if($order->order_type=="Online"){
					foreach($order->order_details as $order_detail){  
							/* $ItemData = $this->Orders->Items->find()->where(['Items.id'=>$order_detail->item_id])->contain(['GstFigures'])->first();
							$gstper=$ItemData->gst_figure->tax_percentage;
							$gst_value=$order_detail->amount*$gstper/100;
							$gstAmtdata=$gst_value/2;
							$gstAmtInsert=round($gstAmtdata,2);
							$query = $this->Orders->OrderDetails->query();
								$query->update()
								->set(['gst_figure_id'=>$ItemData->gst_figure_id,'gst_percentage'=>$ItemData->gst_figure->tax_percentage,'gst_value'=>$gst_value,'net_amount'=>$order_detail->amount+@$gst_value])
								->where(['id'=>$order_detail->id])
								->execute(); */
							$ItemVariationData = $this->Orders->OrderDetails->ItemVariations->get($order_detail->item_variation_id);
							$current_stock=$ItemVariationData->current_stock-$order_detail->quantity;
							$cs = $ItemVariationData->current_stock;
							$vs = $ItemVariationData->virtual_stock;
							$ds = $ItemVariationData->demand_stock;
							$actual_quantity = $order_detail->quantity;							
							
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
							
							
						/* 	$out_of_stock="No";
							$ready_to_sale="Yes";
							if($current_stock <= 0){
								$ready_to_sale="No";
								$out_of_stock="Yes";
							}
							pr($current_stock); exit;
							*/
							
							$query = $this->Orders->OrderDetails->ItemVariations->query();
							$query->update()
							->set(['current_stock'=>$final_cs,'demand_stock'=>$final_ds,'out_of_stock'=>$out_of_stock,'ready_to_sale'=>$ready_to_sale])
							->where(['id'=>$order_detail->item_variation_id])
							->execute(); 
						}
					
				}else if($order->order_type=="COD"){
						foreach($order->order_details as $order_detail){
							
							$ItemVariationData = $this->Orders->OrderDetails->ItemVariations->get($order_detail->item_variation_id);
							$current_stock=$ItemVariationData->current_stock-$order_detail->quantity;
							$cs = $ItemVariationData->current_stock;
							$vs = $ItemVariationData->virtual_stock;
							$ds = $ItemVariationData->demand_stock;
							$actual_quantity = $order_detail->quantity;

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
							
							$query = $this->Orders->OrderDetails->ItemVariations->query();
							$query->update()
							->set(['current_stock'=>$final_cs,'demand_stock'=>$final_ds,'out_of_stock'=>$out_of_stock,'ready_to_sale'=>$ready_to_sale])
							->where(['id'=>$order_detail->item_variation_id])
							->execute(); 
						}
				}

			///////////////////////START DELETE FROM CART/////////////////
				
				$query = $this->Orders->Customers->Carts->query();
				$result = $query->delete()
					->where(['customer_id' => $customer_id])
					->execute(); 
			///////////////////////END DELETE FROM CART/////////////////			
				$message='Thank You ! Your Order placed successfully.';
          		$success=true;
            }else
            { 
				$message='Order not placed';
        		$success=false;
            }
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


	public function ItemWiseCancelOrder()
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
				->set(['is_item_cancel'=>'Yes'])
				->where(['combo_offer_id'=>$combo_offer_id])->where(['order_id'=>$order_id])
				->execute();				
			} 
			
			foreach($order_detail_ids as $order_detail_id)
			{
				$query->update()
				->set(['is_item_cancel'=>'Yes'])
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
	}

}
 ?>