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
      ->where(['customer_id' => $customer_id,'city_id'=>$city_id])
      ->order(['order_date' => 'DESC'])
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

        $orders_details_data = $this->Orders->get($order_id, ['contain'=>['OrderDetails'=>['ItemVariations'=>['Items','UnitVariations'=>['Units']]]]]);

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


}
