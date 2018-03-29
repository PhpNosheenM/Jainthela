<?php
namespace App\Controller\Api;
use Cake\Event\Event;
use Cake\Network\Exception\UnauthorizedException;
use Cake\Utility\Security;
use Firebase\JWT\JWT;


class OrdersController extends AppController
{
    public function CustomerOrder()
    {
      $city_id=$this->request->query('city_id');
      $customer_id=$this->request->query('customer_id');
      $orders_data = $this->Orders->find()
      ->where(['Orders.customer_id' => $customer_id,'Orders.city_id'=>$city_id])
      ->order(['Orders.order_date' => 'DESC'])
      ->autoFields(true);

      $payableAmount = number_format(0, 2);
      $grand_total1=0;

      if(!empty($orders_data->toArray()))
      {
  			foreach($orders_data as $order)
  			{
  				$grand_total1+=$order->total_amount;
  			}
  			$grand_total=number_format(round($grand_total1), 2);
  			$payableAmount = $payableAmount + $grand_total1;

        $delivery_charges=$this->Orders->DeliveryCharges->find()->where(['city_id'=>$city_id]);
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

        foreach($orders_data as $order)
        {
          $order->grand_total = $grand_total;
          $order->delivery_charge_amount = $delivery_charge_amount;
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
          ->contain(['OrderDetails'=>['ItemVariations'=>['Items','UnitVariations'=>['Units']]]])
          ->where(['Orders.id'=>$order_id,'Orders.customer_id'=>$customer_id]);

          $payableAmount = number_format(0, 2);
          $grand_total1=0;

        if(!empty($orders_details_data->toArray()))
        {

          foreach ($orders_details_data as  $orders_detail) {
              $customer_address_id = $orders_detail->customer_address_id;
          }

          $customer_addresses=$this->Orders->CustomerAddresses->find()
            ->where(['CustomerAddresses.customer_id' => $customer_id, 'CustomerAddresses.id'=>$customer_address_id])->first();


          $categories = $this->Orders->find()
          ->where(['customer_id' => $customer_id])
          ->contain(['OrderDetails'=>['ItemVariations'=>['Items'=>['Categories']]]]);

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
                $order_details[] = ['category_name'=>$category_arr[$key],'category_wise'=>$value];
                }

              foreach ($orders_details_data as $order_data) {
                $order_data->order_details = array_replace($order_data->order_details,$order_details);
                $orders_details_data = $order_data;
                $grand_total1 += $order_data->total_amount;
              }

          			$grand_total=number_format(round($grand_total1), 2);
          			$payableAmount = $payableAmount + $grand_total1;

                $delivery_charges=$this->Orders->DeliveryCharges->find()->where(['city_id'=>$city_id]);
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
  							->values([
                'city_id' =>$city_id,
                'customer_id' => $customer_id,
  							'add_amount' => $return_amount,
                'amount_type' =>'Cancel Order',
  							'narration' => 'Amount Return form Order',
  							'return_order_id' => $order_id,
                'transaction_type' => 'Added'
  							])
  					->execute();
        }

        $customer_details=$this->Orders->Customers->find()
  			->where(['Customers.id' => $customer_id])->first();

  			$mobile=$customer_details->username;
  			$sms=str_replace(' ', '+', 'Your order has been cancelled.' );
  			$sms_sender='JAINTE';
  			$sms=str_replace(' ', '+', $sms);

        //file_get_contents('http://103.39.134.40/api/mt/SendSMS?user=phppoetsit&password=9829041695&senderid='.$sms_sender.'&channel=Trans&DCS=0&flashsms=0&number='.$mobile.'&text='.$sms.'&route=7');

        $message='Thank you, your order has been cancelled.';
  			$success=true;
        $this->set(compact('success', 'message'));
        $this->set('_serialize', ['success', 'message']);

    }

    public function placeOrder()
    {
      if ($this->request->is('post')) {

        $customer_address_id = $this->request->data['customer_address_id'];

        $location_data = $this->Orders->CustomerAddresses->find()
        ->select(['location_id'])->where(['id'=>$customer_address_id]);

        if(!empty($location_data->toArray()))
        {
          foreach ($location_data as $value) {
            $location_id = $value->location_id;
          }
        }

        $order = $this->Orders->newEntity();
    		$LocationData = $this->Orders->Locations->get($location_id);
    		$Voucher_no = $this->Orders->find()->select(['voucher_no'])->where(['Orders.location_id'=>$location_id])->order(['voucher_no' => 'DESC'])->first();
    		$today_date=date("Y-m-d");
    		$orderdate = explode('-', $today_date);
    		$year = $orderdate[0];
    		$month   = $orderdate[1];
    		$day  = $orderdate[2];
    		if($Voucher_no)
    		{
    			$voucher_no=$Voucher_no->voucher_no+1;
    		}
    		else
    		{
    			$voucher_no=1;
    		}
    		$purchaseInvoiceVoucherNo='IN'.'/'.$year.''.$month.''.$day.'/'.$voucher_no;
    		$order_no=$LocationData->alise.'/'.$purchaseInvoiceVoucherNo;
        $order = $this->Orders->patchEntity($order, $this->request->getData());

        pr($order);exit;


            if ($this->Orders->save($order)) {
                $this->Flash->success(__('The order has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The order could not be saved. Please, try again.'));
        }

    		$partyParentGroups = $this->Orders->AccountingGroups->find()
    						->where(['AccountingGroups.purchase_invoice_party'=>'1']);

    		$partyGroups=[];
    		foreach($partyParentGroups as $partyParentGroup)
    		{
    			$accountingGroups = $this->Orders->AccountingGroups
    			->find('children', ['for' => $partyParentGroup->id])->toArray();
    			$partyGroups[]=$partyParentGroup->id;
    			foreach($accountingGroups as $accountingGroup){
    				$partyGroups[]=$accountingGroup->id;
    			}
    		}
    		if($partyGroups)
    		{
    			$Partyledgers = $this->Orders->SellerLedgers->find()
    							->where(['SellerLedgers.accounting_group_id IN' =>$partyGroups])
    							->contain(['Sellers'=>['Locations'=>['Cities']]]);
            }
    		$partyOptions=[];
    		foreach($Partyledgers as $Partyledger){
    			$partyOptions[]=['text' =>$Partyledger->name, 'value' => $Partyledger->id,'city_id'=>$Partyledger->seller->city_id,'state_id'=>$Partyledger->seller->location->city->state_id,'bill_to_bill_accounting'=>$Partyledger->bill_to_bill_accounting,'seller_id'=>$Partyledger->seller_id];
    		}

            $this->set(compact('order', 'order_no'));
    }


}
