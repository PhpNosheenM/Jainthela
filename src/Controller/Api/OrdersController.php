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
      ->contain(['DeliveryCharges'])
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
      $this->set(compact('success', 'message','orders_data'));
      $this->set('_serialize', ['success', 'message', 'orders_data']);
    }

    public function OrderDetail()
    {
        $customer_id=$this->request->query('customer_id');
    		$order_id=$this->request->query('order_id');

        $orders_details_data = $this->Orders->get($order_id, ['contain'=>['DeliveryCharges','OrderDetails'=>['ItemVariations'=>['Items','UnitVariations'=>['Units']]]]]);

        if(!empty($orders_details_data->toArray()))
        {
          $success = true;
          $message = 'data found successfully';
          $customer_address_id = $orders_details_data->customer_address_id;
          $customer_addresses=$this->Orders->CustomerAddresses->find()
            ->where(['CustomerAddresses.customer_id' => $customer_id, 'CustomerAddresses.id'=>$customer_address_id])->first();
        }else{
          $success = false;
          $message = 'No data found';
          $orders_details_data = [];
          $customer_addresses = [];
        }
        $cancellation_reasons=$this->Orders->CancelReasons->find();
        $this->set(compact('success', 'message','orders_details_data','customer_addresses','cancellation_reasons'));
        $this->set('_serialize', ['success', 'message', 'orders_details_data','customer_addresses','cancellation_reasons']);
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
      $jain_thela_admin_id=$this->request->data('jain_thela_admin_id');
      $customer_id=$this->request->data('customer_id');
      $wallet_amount=$this->request->data('wallet_amount');
      $jain_cash_amount=$this->request->data('jain_cash_amount');
      $customer_address_id=$this->request->data('customer_address_id');
      $delivery_time_id=$this->request->data('delivery_time_id');
      $online_amount=$this->request->data('online_amount');
      $total_amount=$this->request->data('total_amount');
      $delivery_charge1=$this->request->data('delivery_charge');
      $delivery_charge_id=$this->request->data('delivery_charge_id');
      $promo_code_amount=$this->request->data('promo_code_amount');
      $promo_code_id=$this->request->data('promo_code_id');
      $discount_percent=$this->request->data('discount_percent');
      $order_type=$this->request->data('order_type');
      $payment_status=$this->request->data('payment_status');
      $order_no=$this->request->data('order_no');
      $order_from=$this->request->data('order_from');
      $warehouse_id=1;
      $order = $this->Orders->newEntity();
      $curent_date=date('Y-m-d');
      $order_date=date('Y-m-d 00:00:00');
      $order_time=date('h:i:s:a');

      $order_no_counts=$this->Orders->find()->where(['transaction_order_no' => $order_no, 'status' => 'In Process'])->count();
      if(empty($order_no_counts))
      {
        if($total_amount >=100)
        {
          $delivery_charge=0;
        }
        else{
          $delivery_charge=$delivery_charge1;
        }

        ///////////////////////GET TIME/////////////////
        $delivery_time_data = $this->Orders->DeliveryTimes->find()
        ->where(['DeliveryTimes.id'=>$delivery_time_id])->first();
        $d_from=$delivery_time_data->time_from;
        $d_to=$delivery_time_data->time_to;
        $delivery_time=$d_from.$d_to;

        ///////////////////////GET DELIVERY DATE/////////////////
        $out_of_stock_data=$this->Orders->Carts->find()->where(['customer_id' => $customer_id]);
        $counts=0;
        foreach($out_of_stock_data as $fetch_data)
        {
          $item_id=$fetch_data->item_id;
          $out_data=$this->Orders->Carts->Items->get($item_id);
          $d=$out_data->out_of_stock;
          $counts+=$d;
        }
        $current_timess1=date('h', time());
        $current_timess2=date('i', time());
        $dots='.';
        $current_timess=$current_timess1.$dots.$current_timess2;
        $current_ampm=date('a', time());
        $start = "04";
        $end = "12";
        if($current_ampm=='pm' &&  $current_timess > $start  && $current_timess < $end || $counts>0)
        {
          $delivery_date=date('Y-m-d 00:00:00', strtotime('+1 day', strtotime($curent_date)));//$delivery_date='2017-10-21 00:00:00';
        }
        else{
          $delivery_date=date('Y-m-d 00:00:00');//delivery_date///
          //$delivery_date='2017-10-21 00:00:00';
        }

        ///////////////////////GET LAST ORDER NO/////////////////
        $last_order_no = $this->Orders->find()
        ->select(['get_auto_no'])
        ->order(['get_auto_no'=>'DESC'])->where(['jain_thela_admin_id'=>$jain_thela_admin_id, 'curent_date'=>$curent_date])
        ->first();

        if(!empty($last_order_no)){
          $get_auto_no = h(str_pad(number_format($last_order_no->get_auto_no+1),6, '0', STR_PAD_LEFT));
        }else{
          $get_auto_no=h(str_pad(number_format(1),6, '0', STR_PAD_LEFT));
        }
        $get_date=str_replace('-','',$curent_date);
        $exact_order_no=h('W'.$get_date.$get_auto_no);//orderno///

        ///////////////////////INSERTION IN ORDER/////////////////
        $grand_total=$total_amount+$delivery_charge;
        $pay_amount=$grand_total-($wallet_amount+$jain_cash_amount+$online_amount+$promo_code_amount);

        $this->loadModel('Carts');
        $carts_data=$this->Carts->find()->where(['customer_id'=>$customer_id])->contain(['Items']);
        $i=0;
        foreach($carts_data as $carts_data_fetch)
        {
          $amount=$carts_data_fetch->cart_count*$carts_data_fetch->item->sales_rate;
          $this->request->data['order_details'][$i]['item_id']=$carts_data_fetch->item_id;
          $this->request->data['order_details'][$i]['quantity']=$carts_data_fetch->quantity;
          $this->request->data['order_details'][$i]['rate']=$carts_data_fetch->item->sales_rate;
          $this->request->data['order_details'][$i]['amount']=$amount;
          $this->request->data['order_details'][$i]['is_combo']=$carts_data_fetch->is_combo;
          $i++;
        }
        $order = $this->Orders->patchEntity($order, $this->request->getData());
        $order->transaction_order_no=$order_no;
        $order->order_no=$exact_order_no;
        $order->customer_id=$customer_id;
        $order->jain_thela_admin_id=$jain_thela_admin_id;
        $order->amount_from_wallet=$wallet_amount;
        $order->customer_address_id=$customer_address_id;
        $order->amount_from_jain_cash=$jain_cash_amount;
        $order->amount_from_promo_code=$promo_code_amount;
        $order->total_amount=$total_amount;
        $order->grand_total=$grand_total;
        $order->pay_amount=$pay_amount;
        $order->online_amount=$online_amount;
        $order->delivery_charge=$delivery_charge;
        $order->delivery_charge_id=$delivery_charge_id;
        $order->promo_code_id=$promo_code_id;
        $order->order_type=$order_type;
        $order->discount_percent=$discount_percent;
        $order->status='In Process';
        $order->curent_date=$curent_date;
        $order->get_auto_no=$get_auto_no;
        $order->delivery_date=$delivery_date;
        $order->payment_status=$payment_status;
        $order->order_from=$order_from;
        $order->warehouse_id=$warehouse_id;
        $order->delivery_time=$delivery_time;
        $order->delivery_time_id=$delivery_time_id;
        $order->order_date=$order_date;
        $order->order_time=date('h:i:s:a');
        $this->Orders->save($order);



        ///////////////////////DELETED CART/////////////////
        $this->loadModel('Carts');
        $query = $this->Carts->query();
        $result = $query->delete()
        ->where(['customer_id' => $customer_id])
        ->execute();
        ///////////////////////DELETED CART/////////////////

        //////////WALLET UPDATION///////////////////
        if($wallet_amount>0)
        {
          $wallet_data=$this->Orders->find()->where(['customer_id'=>$customer_id,'transaction_order_no'=>$order_no])
          ->first();
          $order_id=$wallet_data->id;
          $wallet_query = $this->Orders->Wallets->query();
          $wallet_query->insert(['order_id', 'consumed', 'customer_id'])
          ->values([
            'order_id' => $order_id,
            'consumed' => $wallet_amount,
            'customer_id' => $customer_id
          ])
          ->execute();
        }
        ///////////////////////WALLET UPDATION/////////////////


        //////////SMS AND NOTIFICATIONS///////////////////

        $get_data = $this->Orders->find()
        ->order(['id'=>'DESC'])->where(['jain_thela_admin_id'=>$jain_thela_admin_id, 'customer_id'=>$customer_id])
        ->first();
        $delivery_day_date=date('D M j', strtotime($get_data->delivery_date));
        $order_day_date=date('D M j, Y H:i a', strtotime($get_data->order_date));
        $c_date=$curent_date;
        $d_date=date('Y-m-d', strtotime($get_data->delivery_date));

        if($c_date==$d_date)
        {
          $isOrderType='Today';
        }
        else{
          $isOrderType='Next day';
        }

        $result=array('order_date'=>$order_day_date,
        'delivery_date'=>$delivery_day_date,
        'order_no'=>$get_data->order_no,
        'pay_amount'=>$get_data->pay_amount,
        'order_type'=>$get_data->order_type,
        'grand_total'=>$get_data->grand_total,
        'order_day'=>$isOrderType
      );

      $customer_details=$this->Orders->Customers->find()
      ->where(['Customers.id' => $customer_id])->first();
      $mobile=$customer_details->mobile;
      $API_ACCESS_KEY=$customer_details->notification_key;
      $device_token=$customer_details->device_token;
      $device_token1=rtrim($device_token);
      $time1=date('Y-m-d G:i:s');

      if(!empty($device_token1))
      {

        $msg = array
        (
          'message' 	=> 'Thank You, your order place successfully',
          'image' 	=> '',
          'button_text'	=> 'Track Your Order',
          'link' => 'jainthela://track_order?id='.$get_data->id,
          'notification_id'	=> 1,
        );

        $url = 'https://fcm.googleapis.com/fcm/send';
        $fields = array
        (
          'registration_ids' 	=> array($device_token1),
          'data'			=> $msg
        );
        $headers = array
        (
          'Authorization: key=' .$API_ACCESS_KEY,
          'Content-Type: application/json'
        );

        //echo json_encode($fields);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result001 = curl_exec($ch);
        if ($result001 === FALSE) {
          die('FCM Send Error: ' . curl_error($ch));
        }
        curl_close($ch);



        /* $msg1 = array
        (
        'message' 	=> 'Due to festival season, our delivery is closed. We will resume our delivery services from 21st october 2017. Kindly place your order according to that. Team Jainthela',
        'image' 	=> '',
        'button_text'	=> 'Happy Diwali!',
        'link' => 'jainthela://home',
        'notification_id'	=> 1,
      );

      $url1 = 'https://fcm.googleapis.com/fcm/send';
      $fields1 = array
      (
      'registration_ids' 	=> array($device_token1),
      'data'			=> $msg1
    );
    $headers1 = array
    (
    'Authorization: key=' .$API_ACCESS_KEY,
    'Content-Type: application/json'
  );

  //echo json_encode($fields);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url1);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers1);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields1));
  $result001 = curl_exec($ch);
  if ($result001 === FALSE) {
  die('FCM Send Error: ' . curl_error($ch));
}
curl_close($ch);
*/
}

if($get_data->driver_id>0)
{
  $driver_warehouse_details=$this->Orders->Drivers->find()
  ->where(['Drivers.id' => $driver_id])->first();
  $API_ACCESS_KEY1=$driver_warehouse_details->notification_key;
  $exact_device_token=$driver_warehouse_details->device_token;
  $device_token0=rtrim($device_token1);
}
else if(($get_data->warehouse_id>0))
{
  $driver_warehouse_details=$this->Orders->Warehouses->find()
  ->where(['Warehouses.id' => $get_data->warehouse_id])->first();
  $API_ACCESS_KEY1=$driver_warehouse_details->notification_key;
  $exact_device_token=$driver_warehouse_details->device_token;
  $device_token0=rtrim($device_token1);
}


$customer_address_details=$this->Orders->CustomerAddresses->find()
->where(['CustomerAddresses.id' => $get_data->customer_address_id])->first();
$mobile_no=$customer_address_details->mobile;
$billing_address=$customer_address_details->address;
$billing_name=$customer_address_details->name;
$billing_locality=$customer_address_details->locality;
$billing_house_no=$customer_address_details->house_no;

if(!empty($exact_device_token))
{
  $msg = array
  (
    'title' 	=> 'Jainthela',
    'Message'	=> 'hello supplier',
    'billing_address'	=> $billing_house_no.', '.$billing_address.', ' .$billing_locality,
    'billing_name'	=> $billing_name,
    'order_no'	=> $get_data->order_no,
    'delivery_date'	=> $delivery_day_date,
    'id'	=> $get_data->id,
    'session_id'	=> $get_data->customer_id,
    'time'	=> $time1,
    'vibrate'	=> 1,
    'sound'		=> 1,
  );

  $fields = array
  (
    'registration_ids' 	=> array($exact_device_token),
    'data'			=> array("msg" =>$msg)
  );
  $headers = array
  (
    'Authorization: key=' .$API_ACCESS_KEY1,
    'Content-Type: application/json'
  );

  $ch = curl_init();
  curl_setopt( $ch,CURLOPT_URL, 'https://android.googleapis.com/gcm/send' );
  curl_setopt( $ch,CURLOPT_POST, true );
  curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
  curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
  curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
  curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode($fields) );
  $result121 = curl_exec($ch );
  curl_close($ch);
}	 	$sms=str_replace(' ', '+', 'Thank You, Your order placed successfully. order no. is: '.$get_data->order_no.'.
Your order will be delivered on '.$delivery_day_date.' at '.$get_data->delivery_time.'. Bill Amount '.$pay_amount.' Please note amount of order may vary depending on the actual quantity delivered to you.');

/* $diwaliSms=str_replace(' ', '+', 'Due to festival season, our delivery is closed. We will resume our delivery services from 21st october 2017. Kindly place your order according to that. Team Jainthela'); */


$working_key='A7a76ea72525fc05bbe9963267b48dd96';
$sms_sender='JAINTE';
$sms=str_replace(' ', '+', $sms);
/* 	file_get_contents('http://alerts.sinfini.com/api/web2sms.php?workingkey='.$working_key.'&sender='.$sms_sender.'&to='.$mobile.'&message='.$sms.'');
file_get_contents('http://alerts.sinfini.com/api/web2sms.php?workingkey='.$working_key.'&sender='.$sms_sender.'&to='.$mobile_no.'&message='.$sms.''); */

/* file_get_contents('http://103.39.134.40/api/mt/SendSMS?user=phppoetsit&password=9829041695&senderid='.$sms_sender.'&channel=Trans&DCS=0&flashsms=0&number='.$mobile.'&text='.$diwaliSms.'&route=7');  */


file_get_contents('http://103.39.134.40/api/mt/SendSMS?user=phppoetsit&password=9829041695&senderid='.$sms_sender.'&channel=Trans&DCS=0&flashsms=0&number='.$mobile.'&text='.$sms.'&route=7');

file_get_contents('http://103.39.134.40/api/mt/SendSMS?user=phppoetsit&password=9829041695&senderid='.$sms_sender.'&channel=Trans&DCS=0&flashsms=0&number='.$mobile_no.'&text='.$sms.'&route=7');

$status=true;
$error="Thank You, Your order has been placed.";
$this->set(compact('status', 'error','result'));
$this->set('_serialize', ['status', 'error', 'result']);
}else{

  $get_data = $this->Orders->find()
  ->order(['id'=>'DESC'])
  ->first();
  $delivery_day_date=date('D M j', strtotime($get_data->delivery_date));
  $order_day_date=date('D M j, Y H:i a', strtotime($get_data->order_date));
  $c_date=$curent_date;
  $d_date=date('Y-m-d', strtotime($get_data->delivery_date));

  if($c_date==$d_date)
  {
    $isOrderType='Today';
  }
  else{
    $isOrderType='Next day';
  }

  $result=array('order_date'=>$order_day_date,
  'delivery_date'=>$delivery_day_date,
  'order_no'=>$get_data->order_no,
  'pay_amount'=>$get_data->pay_amount,
  'order_type'=>$get_data->order_type,
  'grand_total'=>$get_data->grand_total,
  'order_day'=>$isOrderType
);
$status=true;
$error="Thank You, Your order has been placed.";
$this->set(compact('status', 'error','result'));
$this->set('_serialize', ['status', 'error', 'result']);

}

/////SMS AND NOTIFICATIONS///////////////////

}


}
