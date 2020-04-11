<?php
namespace App\Controller\Api;
use Cake\Event\Event;
use Cake\Network\Exception\UnauthorizedException;
use Cake\Utility\Security;
use Firebase\JWT\JWT;

class ChallansController extends AppController
{
	public function initialize()
	{
		parent::initialize();
		$this->Auth->allow(['DriverOrderList','CustomerVerify','DriverOrderStatus','DriverChallanDetail','ItemWiseCancelOrder','CustomerItemWiseCancel']);
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
			  ->order(['Challans.order_date' => 'DESC'])
			  ->autoFields(true);			
		}else
		{
		  $orders_data = $this->Challans->find()
		  ->where(['Challans.driver_id'=>$driver_id])
		   ->where(['Challans.order_status'=>$order_status])
		   ->where($dateFilter)
		  ->contain(['CustomerAddresses','Customers'])
		  ->order(['Challans.order_date' => 'DESC'])
		  ->autoFields(true);			
		}
		

		  
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


    public function DriverChallanDetail()
    {
        $customer_id=$this->request->query('customer_id');
    	$challan_id=$this->request->query('challan_id');
        $city_id=$this->request->query('city_id');
		$is_item_cancel=$this->request->query('is_item_cancel');
        $orders_details_data = $this->Challans->find()
          ->contain(['ChallanRows'=> function($q) use($is_item_cancel){
			  return $q->where(['combo_offer_id' =>0,'is_item_cancel'=>$is_item_cancel])
			  ->contain(['ItemVariations'=>['ItemVariationMasters','Items','UnitVariations'=>['Units']]]);
		  }])
          ->where(['Challans.id'=>$challan_id,'Challans.customer_id'=>$customer_id]);
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
          ->where(['customer_id' => $customer_id])
          ->contain(['ChallanRows'=>['ItemVariations'=>['ItemVariationMasters','Items'=>['Categories']]]]);
			$category = [];
		
          if(!empty($categories->toArray()))
          {
              $category_arr = [];
			  foreach ($categories as $cat_date) {
                foreach($cat_date->challan_rows as $order_data) {
					$cat_name = $order_data->item_variation->item->category->name;
					$cat_id = $order_data->item_variation->item->category->id;
					
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
		
		$this->Sms->sendSms($mobile,$sms);	
		
        $this->set(compact('success', 'message'));
        $this->set('_serialize', ['success', 'message']);		
	}


	
}
