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
      if(!empty($orders_data))
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
}
