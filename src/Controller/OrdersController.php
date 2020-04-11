<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\View\View;
use Cake\Routing\Router;
use Cake\Network\Exception\InvalidCsrfTokenException;
/**
 * Orders Controller
 *
 * @property \App\Model\Table\OrdersTable $Orders
 *
 * @method \App\Model\Entity\Order[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class OrdersController extends AppController
{

	
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
	public function initialize()
	{
		parent::initialize();
		$this->loadComponent('Csrf');
	}
	public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Security->setConfig('unlockedActions', ['add', 'index', 'view', 'manageOrder', 'ajaxDeliver','updateOrders','cancelOrder','invoiceManageOrder','pdfOrder','recreateOrder']);
		if (in_array($this->request->action, ['invoiceManageOrder'])) {
			 $this->eventManager()->off($this->Csrf);
		 }
		 $this->Auth->allow(['pdfOrder']);
    }

    public function checkOrderAmt(){
		$city_id=$this->Auth->User('city_id');
		$order_data=$this->Orders->find()->where(['Orders.city_id'=>$city_id])->order(['Orders.id'=>'DESC']);
		foreach($order_data as $data){
			if($data->grand_total >  $data->pay_amount){
				
				echo $data->order_no; echo "<br>";
				
			}
		}
		exit;
	}
    public function lastOrderReport()
    {
		$this->viewBuilder()->layout('admin_portal');
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id');
		$location_id=$this->Auth->User('location_id');
		$user_type =$this->Auth->User('user_type');
		if($user_type=="Super Admin"){
		$this->viewBuilder()->layout('super_admin_layout');	
		}else if($user_type=="Admin"){ 
		$this->viewBuilder()->layout('admin_portal');
		}
		$from_date = $this->request->query('from_date');
		$to_date = $this->request->query('to_date');
		
		/* $from_date = date("Y-4-1");
		$to_date   = date("Y-4-5"); */
		if(empty($from_date) || empty($to_date))
		{
			$from_date = date("Y-m-d");
			$to_date   = date("Y-m-d");
		}else{
			$from_date = date("Y-m-d",strtotime($from_date));
			$to_date= date("Y-m-d",strtotime($to_date));
		}

		if(!empty($from_date))
		{
			$from_date = date("Y-m-d",strtotime($from_date));
			$where_get['Orders.order_date >=']=$from_date;
		}
		if(!empty($to_date))
		{
			$to_date   = date("Y-m-d",strtotime($to_date));
			$where_get['Orders.order_date <=']=$to_date;
		}
		$search=$this->request->getQuery('search');
		if(!empty($search))
		{
			
			$where_get['Customers.name LIKE']=$search.'%';
		}
		
	
		$AllCustomers=[]; 
		$CustomerWiseOrder=[]; 
		$CustomerLastOrder=[]; 
		$order_data=$this->Orders->find()->contain(['Customers'=>function ($q){
			return $q->order(['Customers.name'=>'ASC']);
		}])->where($where_get);
		
		foreach($order_data as $data){  
			$AllCustomers[$data->customer->id]=$data->customer->name.' ('. $data->customer->username.')';
			@$CustomerWiseOrder[$data->customer->id]=@$CustomerWiseOrder[$data->customer->id]+1;
			@$CustomerLastOrder[$data->customer->id]=@$data->order_date;
		}
		//pr($AllCustomers); 
		asort($AllCustomers); 
		//$AllCustomers=sort($AllCustomers); 
		//pr($AllCustomers); exit;
		$this->set(compact('AllCustomers','CustomerWiseOrder','from_date','to_date','CustomerLastOrder','search'));
		
	}
	public function index()
    {
		$this->viewBuilder()->layout('admin_portal');
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id');
		$location_id=$this->Auth->User('location_id');
		$user_type =$this->Auth->User('user_type');
		if($user_type=="Super Admin"){
		$this->viewBuilder()->layout('super_admin_layout');	
		}else if($user_type=="Admin"){ 
		$this->viewBuilder()->layout('admin_portal');
		}
		
		$from_date = $this->request->query('from_date');
		$to_date = $this->request->query('to_date');
		//$Sellers = $this->request->query('Sellers');

		if(empty($from_date) || empty($to_date))
		{
			$from_date = date("Y-m-d");
			$to_date   = date("Y-m-d");
		}else{
			$from_date = date("Y-m-d",strtotime($from_date));
			$to_date= date("Y-m-d",strtotime($to_date));
		}

		if(!empty($from_date))
		{
			$from_date = date("Y-m-d",strtotime($from_date));
			$where_get['Orders.order_date >=']=$from_date;
		}
		if(!empty($to_date))
		{
			$to_date   = date("Y-m-d",strtotime($to_date));
			$where_get['Orders.order_date <=']=$to_date;
		}
		$search=$this->request->getQuery('search');
		if(!empty($search))
		{
			
			$where_get['Customers.name LIKE']=$search.'%';
		}
		
	
		
        $this->paginate = [
            //'contain' => ['OrderDetails'=>['ItemVariations'],'SellerLedgers','PartyLedgers','Locations'],
			'limit' => 100
        ];
		
		$order_data=$this->Orders->find()->order(['Orders.id'=>'DESC'])->contain(['SellerLedgers','PartyLedgers','Locations','Customers'])->where(['Orders.city_id'=>$city_id])->where($where_get);
		
		if ($this->request->is(['get'])){
			$search=$this->request->getQuery('search');
			$order_data->where([
							'OR' => [
									'Orders.order_type LIKE' => $search.'%',
									'Orders.order_no LIKE' => '%'.$search.'%',
									'Orders.order_status LIKE' => '%'.$search.'%',
									'Customers.name LIKE' => $search.'%'
							]
			]);
		}
		
        $orders = $this->paginate($order_data);
		$Sellers[]=['text'=>'Main JainThela','value'=>'NULL'];
		$AllSellers = $this->Orders->Sellers->find();
		foreach($AllSellers as $data){ 
			$Sellers[]=['text'=>$data->name,'value'=>$data->id];
		} //pr($Sellers);exit;
		$paginate_limit=$this->paginate['limit'];
        $this->set(compact('orders','paginate_limit','from_date','to_date','Sellers'));
    }
	
	public function ajaxDeliver($id = null)
    {
		//$this->viewBuilder()->layout('');
		$city_id=$this->Auth->User('city_id');
         $Orders = $this->Orders->Invoices->get($id, [
            'contain' => ['SellerLedgers','PartyLedgers','Locations','DeliveryTimes','Customers','CustomerAddresses', 'InvoiceRows'=>['ItemVariations'=>['Items'], 'ComboOffers']]
        ]);
		$customer_id=$Orders->customer->id;
		
		if ($this->request->is('post')) { exit;
			
			pr($this->request-data());
			exit;
		}	
		$this->loadmodel('DeliveryCharges');
		$deliveryCharges=$this->DeliveryCharges->find()->where(['DeliveryCharges.city_id'=>$city_id, 'DeliveryCharges.status'=>'Active'])->first();
		
        $this->set('Orders', $Orders);
        $this->set('deliveryCharges', $deliveryCharges);
        $this->set('_serialize', ['Orders']);
    }
	
	public function comboAdd($combo_id = null, $combo_count=null, $combo_qty=null)
    {
		$this->loadmodel('ComboOfferDetails');
		$combo_offer_details=$this->ComboOfferDetails->find()->where(['ComboOfferDetails.combo_offer_id'=>$combo_id])->contain(['ItemVariations'=>['Items','UnitVariations'=>['Units']]]);
		// echo "hello"; exit;
		$this->set('combo_offer_details',$combo_offer_details);
		$this->set('combo_count',$combo_count);
		$this->set('combo_qty',$combo_qty);
		
	}

	
	public function promo($customer_id = null)
    {
		$today=date('Y-m-d');
		$city_id=$this->Auth->User('city_id');
		$this->loadmodel('CustomerPromotions');
		$this->loadmodel('Promotions');
		$this->loadmodel('PromotionDetails');
		$cstmr_promotion=$this->CustomerPromotions->find()->where(['CustomerPromotions.customer_id'=>$customer_id,'CustomerPromotions.status'=>'Active','CustomerPromotions.city_id'=>$city_id,'CustomerPromotions.start_date <='=>$today,'CustomerPromotions.end_date >='=>$today])->contain(['PromotionDetails','Promotions']);
		//'CustomerPromotions.start_date <='=>$today,'CustomerPromotions.end_date >='=>$today
		//pr($cstmr_promotion->toArray()); exit;
		
		
		$conditions = ['Promotions.start_date <=' => date('Y-m-d'),'Promotions.end_date >= ' => date('Y-m-d')];
				$promotionList = $this->Promotions->find()->contain(['PromotionDetails'])
				->where(['Promotions.city_id'=>$city_id,'Promotions.status'=>'Active'])
				->where([$conditions])->toArray();

				$promotionCustomerList = $this->Promotions->CustomerPromotions->find()
				->contain(['Promotions'=>function($q) use($city_id,$conditions){
					return $q->contain(['PromotionDetails'])->where(['Promotions.city_id'=>$city_id,'Promotions.status'=>'Active'])
				->where([$conditions]);		
				}]);
				
				if(!empty($promotionCustomerList))
				{
					foreach($promotionCustomerList as $promotionCustomer)
					{
						$cust_promo_arr[] = $promotionCustomer->promotion;
					}
				}
				
				$mainArray = array_diff($promotionList,$cust_promo_arr);
				

				$promotionCurrentCustomerList = $this->Promotions->CustomerPromotions->find()
				->contain(['Promotions'=>function($q) use($city_id,$conditions){
					return $q->contain(['PromotionDetails'])->where(['Promotions.city_id'=>$city_id,'Promotions.status'=>'Active'])
				->where([$conditions]);
				}])->where(['CustomerPromotions.customer_id' =>$customer_id]);

				
				if(!empty($promotionCurrentCustomerList))
				{
					foreach($promotionCurrentCustomerList as $promotionCurrentCustomer)
					{
						$cust_promo_code[] = $promotionCurrentCustomer->promotion;
					}
				}
				
				$allPromoCode = array_merge($mainArray,$cust_promo_code);
				
				foreach($allPromoCode as $data1){
					
					if($data1->id==@$last_promo_id){ continue; }
					foreach($data1->promotion_details as $data){
						//pr($data->toArray()); exit;
						$promo[]=['text'=>$data->coupon_code,'value'=>$data->id,'discount_amount'=>$data->discount_in_amount,'discount_percent'=>$data->discount_in_percentage,'free_shipping'=>$data->is_free_shipping,'category_id'=>$data->category_id,'item_id'=>$data->item_id,'discount_of_max_amount'=>$data->discount_of_max_amount,'promotion_id'=>$data->promotion_id,'cash_back'=>$data->cash_back];
					}
					$last_promo_id=$data1->id;
				}
				
		 
        $this->set('promo', $promo);
        $this->set('_serialize', ['promo']);
    }
	
	public function dispatch($invoice_id=null)
    {
	$invoice_id;
	$invoice = $this->Orders->Invoices->get($invoice_id);
	$invoice->dispatch_flag='Active';
	$invoice->order_status='Dispatched';
	$invoice->dispatch_on= date('Y-m-d h:i:s a');
	$this->Orders->Invoices->save($invoice);
	echo '<a class="btn btn-primary dlvr btn-condensed btn-sm" > Deliver</a>';
	exit;
	}
	
	public function packing($invoice_id=null)
    {
	$invoice_id;
	$invoice = $this->Orders->Invoices->get($invoice_id);
	$invoice->packing_flag='Active';
	$invoice->order_status='Packed';
	$invoice->packing_on= date('Y-m-d h:i:s a');
	$this->Orders->Invoices->save($invoice);
	
	$sms=str_replace(' ', '+', 'You are not Receiving Our Call to receive invoice, your invoice has been again return to warehouse of jainthla please collect from their');
	$sms_sender='JAINTE';
	$sms=str_replace(' ', '+', $sms);
	//file_get_contents('http://103.39.134.40/api/mt/SendSMS?user=phppoetsit&password=9829041695&senderid='.$sms_sender.'&channel=Trans&DCS=0&flashsms=0&number='.$mob.'&text='.$sms.'&route=7');
	echo '<button class="btn btn-warning  btn-condensed btn-sm dsptch" type="submit">Dispatch</button>';
	exit;
	}
	
	
	public function cancel($ordr_id=null, $customer_id=null)
    {
	$ordr_id;
	$city_id=$this->Auth->User('city_id');
	$order = $this->Orders->get($ordr_id);
	$amount_from_wallet=$order->amount_from_wallet;
	$online_amount=$order->online_amount;
	$wallet_refund_amount=$amount_from_wallet+$online_amount;
	$order->order_status='Cancel';
	$order->packing_on= date('Y-m-d h:i:s a');
	//$this->Orders->save($order);
	
	if($wallet_refund_amount>0){
		$today=date('Y-m-d');
		$wallet_no = $this->Orders->Wallets->find()->select(['order_id'])->where(['Wallets.city_id'=>$city_id])->order(['order_id' => 'DESC'])->first();
		if($wallet_no){
			$seq_wallet=$wallet_no->order_id+1;
		}else{
			$seq_wallet=1;
		}
		
		$query = $this->Orders->Wallets->query();
		$query->insert(['customer_id', 'order_id', 'amount_type', 'transaction_type', 'transaction_date', 'add_amount', 'city_id'])
				->values([
				'customer_id' => $customer_id,
				'order_id' => $seq_wallet,
				'return_order_id' => $ordr_id,
				'amount_type' => 'order',
				'transaction_type' => 'Added',
				'transaction_date' => $today,
				'add_amount' => $wallet_refund_amount,
				'city_id' => $city_id,
				'narration' => 'Amount Return from Order',
				])
		->execute();
	}
	
	$customer = $this->Orders->Customers->get($customer_id);
	$mob=$customer->username;
	$cancel_count=$customer->cancel_order_count;
	$customer->cancel_order_count=$cancel_count+1;
	$this->Orders->Customers->save($customer);
	
	$sms=str_replace(' ', '+', 'YOur order has been cancel');
	$sms_sender='JAINTE';
	$sms=str_replace(' ', '+', $sms);
	//file_get_contents('http://103.39.134.40/api/mt/SendSMS?user=phppoetsit&password=9829041695&senderid='.$sms_sender.'&channel=Trans&DCS=0&flashsms=0&number='.$mob.'&text='.$sms.'&route=7');
	echo '<button class="btn btn-warning  btn-condensed btn-sm dsptch" type="submit">Dispatch</button>';
	exit;
	}
	
/////order not receive by customer on delivery time send sms start///////////	
	public function smsSend($ordr_id=null,$mob=null)
    {
	$ordr_id;
	$mob;
	$order = $this->Orders->get($ordr_id);
	$order->not_received='Yes';
	$this->Orders->save($order);
	
	$sms=str_replace(' ', '+', 'You are not Receiving Our Call to receive order, your order has been again return to warehouse of jainthla please collect from their');
	$sms_sender='JAINTE';
	$sms=str_replace(' ', '+', $sms);
	//file_get_contents('http://103.39.134.40/api/mt/SendSMS?user=phppoetsit&password=9829041695&senderid='.$sms_sender.'&channel=Trans&DCS=0&flashsms=0&number='.$mob.'&text='.$sms.'&route=7');
	
	exit;
	}
/////order not receive by customer on delivery time send sms end///////////	
	
	public function otpSend($ordr_id=null,$mob=null)
    {
	$ordr_id;
	$mob;
	$random=(string)mt_rand(1000,9999);
	$order = $this->Orders->get($ordr_id);
	$order->otp=$random;
	$this->Orders->save($order);
	
	$sms=str_replace(' ', '+', 'Your order delivery confirmation one time OTP is: '.$random.'');
	$sms_sender='JAINTE';
	$sms=str_replace(' ', '+', $sms);
	//file_get_contents('http://103.39.134.40/api/mt/SendSMS?user=phppoetsit&password=9829041695&senderid='.$sms_sender.'&channel=Trans&DCS=0&flashsms=0&number='.$mob.'&text='.$sms.'&route=7');
	
	exit;
	}
	
	
	public function driverAssign($ordr_id=null,$driver_id=null)
    {
	$ordr_id;
	$driver_id;
	$order = $this->Orders->Invoices->get($ordr_id);
	$order->driver_id=$driver_id;
	$this->Orders->Invoices->save($order);
	exit;
	}
	
	public function cancelOrder($ordr_id=null,$cancel_reason_id=null,$customer_id=null)
    {
	$cancel_reason_id;
	$customer_id;
	$ordr_id;
	$city_id=$this->Auth->User('city_id');
	$order = $this->Orders->get($ordr_id);
	$amount_from_wallet=$order->amount_from_wallet;
	$online_amount=$order->online_amount;
	$wallet_refund_amount=$amount_from_wallet+$online_amount;
	$order->order_status='Cancel';
	$order->cancel_reason_id=$cancel_reason_id;
	
	$data=$this->Orders->save($order);
	
	$query7 = $this->Orders->OrderDetails->query();
			$query7->update()
				->set(['item_status' => 'Cancel', 'is_item_cancel' => 'Yes'])
				->where(['OrderDetails.order_id'=>$ordr_id])
				->execute();
	
	$query3 = $this->Orders->Challans->query();
		$query3->update()
			->set(['order_status' => 'Cancel', 'cancel_reason_id' => $cancel_reason_id])
			->where(['Challans.order_id'=>$ordr_id])
			->execute();
	 
		$challan_details=$this->Orders->Challans->find()->where(['Challans.order_id'=>$ordr_id])->contain(['ChallanRows']);
		
		foreach($challan_details as $challan_detail){
			
			$update_challan_id=$challan_detail->id;
			
			$query5 = $this->Orders->Challans->ChallanRows->query();
				$query5->update()
					->set(['item_status' => 'Cancel', 'is_item_cancel' => 'Yes'])
					->where(['ChallanRows.challan_id'=>$update_challan_id])
					->execute();
		}
			
	$order_details=$this->Orders->OrderDetails->find()->where(['OrderDetails.order_id'=>$ordr_id])->contain(['Items']);
	
		foreach($order_details as $order_detail){
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

	if($wallet_refund_amount>0){
		$today=date('Y-m-d');
		$wallet_no = $this->Orders->Wallets->find()->select(['order_no'])->where(['Wallets.city_id'=>$city_id])->order(['order_no' => 'DESC'])->first();
		if($wallet_no){
			$seq_wallet=$wallet_no->order_no+1;
		}else{
			$seq_wallet=1;
		}
		
		$query = $this->Orders->Wallets->query();
		$query->insert(['customer_id', 'order_id', 'order_no', 'return_order_id', 'amount_type', 'transaction_type', 'transaction_date', 'add_amount', 'city_id', 'created_on'])
				->values([
				'customer_id' => $customer_id,
				'order_no' => $seq_wallet,
				'order_id' => $ordr_id,
				'return_order_id' => $ordr_id,
				'amount_type' => 'order',
				'transaction_type' => 'Added',
				'transaction_date' => $today,
				'add_amount' => $wallet_refund_amount,
				'city_id' => $city_id,
				'created_on' => date('Y-m-d h:i:s a')
				])
		->execute();
	}
	
	
	
	$customer = $this->Orders->Customers->get($customer_id);
	$mob=$customer->username;
	$cancel_count=$customer->cancel_order_count;
	$customer->cancel_order_count=$cancel_count+1;
	$this->Orders->Customers->save($customer);
	
	
	//////////////Notification//Code///Start//////////////////
	$mobile=$customer->mobile;
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
				'title'=> 'Order Canceled',
				'message' => 'Your order has Been Canceled',
				'image' => '',
				'link' => 'jainthela://order?id='.$ordr_id,
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
			  // "cURL Error #:" . $err;
			} else {
			    $response;
			}			
					  
		}
	//////////////Notification//Code///end../////////////////
	
	$sms=str_replace(' ', '+', 'Your order has been canceled');
	$sms_sender='JAINTE';
	$sms=str_replace(' ', '+', $sms);
	//file_get_contents('http://103.39.134.40/api/mt/SendSMS?user=phppoetsit&password=9829041695&senderid='.$sms_sender.'&channel=Trans&DCS=0&flashsms=0&number='.$mob.'&text='.$sms.'&route=7');
	echo 'Canceled';
	exit;
	}
	
	public function orderRelatedToSeller($status=null){
		$this->viewBuilder()->layout('super_admin_layout');
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id');
		$location_id=$this->Auth->User('location_id');
		$location_id = $this->request->query('location_id');
		$seller_id = $this->request->query('seller_id');
		$gst_figure_id = $this->request->query('gst_figure_id');
		$from_date = $this->request->query('from_date');
		$to_date   = $this->request->query('to_date');
		if(empty($from_date) || empty($to_date))
		{
			$from_date = date("Y-m-01");
			$to_date   = date("Y-m-d");
		}else{
			$from_date = date("Y-m-d",strtotime($from_date));
			$to_date= date("Y-m-d",strtotime($to_date));
		}
		if(!empty($from_date))
		{
			$from_date = date("Y-m-d",strtotime($from_date));
			$where['Orders.transaction_date >=']=$from_date;
		}
		if(!empty($to_date))
		{
			$to_date   = date("Y-m-d",strtotime($to_date));
			$where['Orders.transaction_date <=']=$to_date;
		}
		if(!empty($location_id))
		{
			//$to_date   = date("Y-m-d",strtotime($to_date));
			$where['Orders.location_id']=$location_id;
		}
		$orders=[];
		if($seller_id){ 
			 $orders=$this->Orders->find()->contain(['Locations','PartyLedgers'=>['CustomerData'],'OrderDetails'=>['Items','ItemVariations'=>function ($q) use($seller_id) {
							return $q->where(['ItemVariations.seller_id'=>$seller_id])->contain(['Sellers','UnitVariations']);
						}]])->where($where);
		
			  $orders->innerJoinWith('OrderDetails.ItemVariations',function ($q) use($seller_id) {
							return $q->where(['ItemVariations.seller_id'=>$seller_id])->contain(['Sellers','UnitVariations']);
						})->group('OrderDetails.order_id')
					->autoFields(true);

			//pr($orders->toArray()); exit;
		}else{
			
			 $orders=$this->Orders->find()->contain(['Locations','PartyLedgers'=>['CustomerData'],'OrderDetails'=>['Items','ItemVariations'=>function ($q) {
							return $q->where(['ItemVariations.seller_id IS NULL'])->contain(['UnitVariations']);
						}]])->where($where);
			//pr($orders->toArray()); exit;
			  $orders->innerJoinWith('OrderDetails.ItemVariations',function ($q)  {
							return $q->where(['ItemVariations.seller_id IS NULL'])->contain(['UnitVariations']);
						})->group('OrderDetails.order_id')
					->autoFields(true);
				//pr($orders->toArray()); exit;
		}
		
		$Locations = $this->Orders->Locations->find('list')->where(['city_id'=>$city_id]);
		$Sellers = $this->Orders->OrderDetails->Items->Sellers->find('list')->where(['city_id'=>$city_id]);
		$this->set(compact('from_date','to_date','orders','Locations','location_id','seller_id','Sellers','GstFigures'));
	}
	
	public function updateOrders($order_id = null,$item_id = null,$actual_quantity=null,$amount = null,$gst_value = null,$net_amount =null, $detail_id = null, $taxable_value = null, $total_gst = null,$grand_total = null){
		
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id');
		$location_id=$this->Auth->User('location_id');
		$location_id = $this->request->query('location_id');
		
		$order_id;
		$taxable_value;
		$total_gst;
		$grand_total;
		$quantity=explode(',',$actual_quantity);
		$items=explode(',',$item_id);
		$item_amount=explode(',',$amount);
		$gst_values=explode(',',$gst_value);
		$net_amounts=explode(',',$net_amount);
		$detail_ids=explode(',',$detail_id);
		$x=0;
		foreach($detail_ids as $detail_id){
			
			$qty = $quantity[$x];
			$amt = $item_amount[$x];
			$gst = $gst_values[$x];
			$nt_amt = $net_amounts[$x];
			$dtl_id = $detail_ids[$x];
			$final_amount+=$amt;
				$query = $this->Orders->OrderDetails->query();
					$query->update()
							->set(['actual_quantity' => $qty, 'amount' => $amt, 'gst_value' => $gst, 'net_amount' => $nt_amt])
							->where(['id'=>$dtl_id,'order_id'=>$order_id])
							->execute();
				$x++;
		
		}
		
		$Orders = $this->Orders->get($order_id);
		$customer_id=$Orders->customer_id;
		$amount_from_wallet=$Orders->amount_from_wallet;
		//$amount_from_jain_cash=$Orders->amount_from_jain_cash;
		//$amount_from_promo_code=$Orders->amount_from_promo_code;
		$online_amount=$Orders->online_amount;
		$discount_percent=$Orders->discount_percent;
		
		$paid_amount=$amount_from_wallet+$amount_from_jain_cash+$amount_from_promo_code+$online_amount;
		
		$total_amount=$final_amount;
		$discount_percent=$Orders->discount_percent;
		$discount_amount=$total_amount*($discount_percent/100);
		
		$delivery_charges=$this->Orders->DeliveryCharges->find()->where(['DeliveryCharges.city_id'=>$city_id, 'DeliveryCharges.status'=>'Active']);
		
	exit;
	}
	public function manageOrder($status=null)
    {
		
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id');
		$location_id=$this->Auth->User('location_id');
		$status = $this->request->query('status');
		$user_type =$this->Auth->User('user_type');
		if($user_type=="Super Admin"){
		$this->viewBuilder()->layout('super_admin_layout');
		}else if($user_type=="Admin"){ 
		$this->viewBuilder()->layout('admin_portal');
		}
		
        $this->paginate = [
			'limit' => 100 
        ];
		
		
		if ($this->request->is('post')) { 
			 
			$NewOrder=$this->request->data;
			$query = $this->Orders->OrderDetails->query();
			$query->update()
					->set(['is_item_cancel' => 'Yes'])
					->where(['order_id'=>$NewOrder['order_id']])
					->execute();
			 $order = $this->Orders->get($NewOrder['order_id']);
			//pr($NewOrder); 
		//	pr($order);  exit;
				if($order->order_type=="Credit"){

						// Cash Account Entry 
						$AccountingEntrie = $this->Orders->AccountingEntries->newEntity(); 
						$AccountingEntrie->ledger_id=$order->party_ledger_id;
						$AccountingEntrie->debit=$NewOrder['grand_total'];
						$AccountingEntrie->credit=0;
						$AccountingEntrie->transaction_date=date('Y-m-d');
						$AccountingEntrie->city_id=$order->city_id;
						$AccountingEntrie->entry_from="Web";
						$AccountingEntrie->order_id=$order->id;  
						$this->Orders->AccountingEntries->save($AccountingEntrie);
						
						// Sales Account Entry 
						$AccountingEntrie = $this->Orders->AccountingEntries->newEntity(); 
						$AccountingEntrie->ledger_id=$order->sales_ledger_id;
						$AccountingEntrie->credit=$NewOrder['total_amount'];
						$AccountingEntrie->debit=0;
						$AccountingEntrie->transaction_date=date('Y-m-d');
						$AccountingEntrie->city_id=$order->city_id;
						$AccountingEntrie->entry_from="Web";
						$AccountingEntrie->order_id=$order->id; 
						$this->Orders->AccountingEntries->save($AccountingEntrie);
						
						//Delivery Charges Entry
						if($order->delivery_charge_amount > 0){
							$TransportLedger = $this->Orders->Ledgers->find()->where(['Ledgers.transport' =>'Receive','Ledgers.city_id'=>$order->city_id])->first();
								$AccountingEntrie1 = $this->Orders->AccountingEntries->newEntity();
								$AccountingEntrie1->ledger_id=$TransportLedger->id;
								$AccountingEntrie1->credit=$order->delivery_charge_amount;
								$AccountingEntrie1->debit=0;
								$AccountingEntrie1->transaction_date=$order->order_date;
								$AccountingEntrie1->city_id=$order->city_id;
								$AccountingEntrie1->entry_from="Web";
								$AccountingEntrie1->order_id=$order->id; 
								$this->Orders->AccountingEntries->save($AccountingEntrie1);
							}
						
						
						//round Off Entry
						$roundOffLedger = $this->Orders->Ledgers->find()->where(['Ledgers.round_off' =>'1','Ledgers.city_id'=>$order->city_id])->first(); 
						//
						$AccountingEntrie = $this->Orders->AccountingEntries->newEntity(); 
						$AccountingEntrie->ledger_id=$roundOffLedger->id;
						if($NewOrder['round_off'] < 0){
							$AccountingEntrie->debit=$NewOrder['round_off'];
							$AccountingEntrie->credit=0;
						}else{
						$AccountingEntrie->credit=$NewOrder['round_off'];
						$AccountingEntrie->debit=0;
						}
						$AccountingEntrie->transaction_date=date('Y-m-d');
						$AccountingEntrie->city_id=$order->city_id;
						$AccountingEntrie->entry_from="App";
						$AccountingEntrie->order_id=$order->id; 
						if($NewOrder['round_off'] != 0){
							$this->Orders->AccountingEntries->save($AccountingEntrie);
						}
						
				
						foreach($NewOrder['order_details'] as $order_detail){  
							$ItemData = $this->Orders->Items->find()->where(['Items.id'=>$order_detail['item_id']])->first();
							$gstAmtdata=$order_detail['gst_value']/2;
							$gstAmtInsert=round($gstAmtdata,2);
							
							$gstLedgerCGST = $this->Orders->Ledgers->find()->where(['Ledgers.gst_figure_id' =>$ItemData->gst_figure_id, 'Ledgers.input_output'=>'output', 'Ledgers.gst_type'=>'CGST','city_id'=>$order->city_id])->first();
								
							//Accounting Entries for CGST//
							$gstLedgerCGST = $this->Orders->Ledgers->find()
							->where(['Ledgers.gst_figure_id' =>$ItemData->gst_figure_id, 'Ledgers.input_output'=>'output', 'Ledgers.gst_type'=>'CGST','city_id'=>$order->city_id])->first();
							$AccountingEntrieCGST = $this->Orders->AccountingEntries->newEntity();
							$AccountingEntrieCGST->ledger_id=$gstLedgerCGST->id;
							$AccountingEntrieCGST->credit=$gstAmtInsert;
							$AccountingEntrieCGST->debit=0;
							$AccountingEntrieCGST->transaction_date=date('Y-m-d');
							$AccountingEntrieCGST->city_id=$order->city_id;
							$AccountingEntrieCGST->entry_from="Web";
							$AccountingEntrieCGST->order_id=$order->id; 
							if($gstAmtInsert > 0){
								$this->Orders->AccountingEntries->save($AccountingEntrieCGST);
							}
							
							//Accounting Entries for SGST//
							 $gstLedgerSGST = $this->Orders->Ledgers->find()
							->where(['Ledgers.gst_figure_id' =>$ItemData->gst_figure_id, 'Ledgers.input_output'=>'output', 'Ledgers.gst_type'=>'SGST','city_id'=>$order->city_id])->first();
							$AccountingEntrieSGST = $this->Orders->AccountingEntries->newEntity();
							$AccountingEntrieSGST->ledger_id=$gstLedgerSGST->id;
							$AccountingEntrieSGST->credit=$gstAmtInsert;
							$AccountingEntrieSGST->debit=0;
							$AccountingEntrieSGST->transaction_date=date('Y-m-d');
							$AccountingEntrieSGST->city_id=$order->city_id;
							$AccountingEntrieSGST->entry_from="Web";
							$AccountingEntrieSGST->order_id=$order->id;  
							if($gstAmtInsert > 0){
								$this->Orders->AccountingEntries->save($AccountingEntrieSGST);
							}
							
							//Refrence Details Entry
							$ReferenceDetail = $this->Orders->ReferenceDetails->newEntity(); 
							$ReferenceDetail->ledger_id=$order->party_ledger_id;
							$ReferenceDetail->debit=$order->grand_total;
							$ReferenceDetail->credit=0;
							$ReferenceDetail->transaction_date=date('Y-m-d');
							$ReferenceDetail->city_id=$order->city_id;
							$ReferenceDetail->entry_from="Web";
							$ReferenceDetail->type='New Ref';
							$ReferenceDetail->ref_name=$order->order_no;
							$ReferenceDetail->order_id=$order->id;
							$this->Orders->ReferenceDetails->save($ReferenceDetail);
						
							
							//Stock Entry in Item Ledgers
							$orderDetailsData = $this->Orders->OrderDetails->get($order_detail['id'], [
								'contain' => ['ItemVariations']
							]);
							
							$ItemLedger = $this->Orders->OrderDetails->ItemLedgers->newEntity(); 
							$ItemLedger->item_id=$orderDetailsData->item_id; 
							$ItemLedger->unit_variation_id=$orderDetailsData->item_variation->unit_variation_id;
							$ItemLedger->item_variation_id=$orderDetailsData->item_variation_id;
							$ItemLedger->transaction_date=date('Y-m-d');  
							$ItemLedger->quantity=$order_detail['quantity'];
							$ItemLedger->rate=$order_detail['rate'];
							$ItemLedger->amount=$order_detail['quantity']*$order_detail['rate'];
							$ItemLedger->sales_rate=$order_detail['rate'];
							$ItemLedger->status="Out";
							$ItemLedger->city_id=$order->city_id;
							$ItemLedger->location_id=$order->location_id;
							$ItemLedger->order_id=$order->id;
							$ItemLedger->order_detail_id=$orderDetailsData->id;
							$this->Orders->OrderDetails->ItemLedgers->save($ItemLedger);
							
							
							$query = $this->Orders->OrderDetails->query();
							$query->update()
									->set(['is_item_cancel' => 'No'])
									->where(['id'=>$order_detail['id']])
									->execute();
						}
						
						//Update in Order
							$query = $this->Orders->query();
							$query->update()
									->set(['discount_amount' => $NewOrder['discount_amount'],'total_amount'=>$NewOrder['total_amount'],'total_gst'=>$NewOrder['total_gst'],'grand_total'=>$NewOrder['grand_total'],'round_off'=>$NewOrder['round_off'],'delivery_charge_amount'=>$NewOrder['delivery_charge_amount']])
									->where(['id'=>$order->id])
									->execute();
						
						//Stock Up in item Variations
						$orderDetailsCancleItems = $this->Orders->OrderDetails->find()->where(['order_id'=>$order->id,'is_item_cancel'=>'Yes']);
						$datasize=sizeof($orderDetailsCancleItems->toArray());
						if($datasize > 0){
							foreach($orderDetailsCancleItems as $data){
								//pr($data); exit;
							}
						}
				}else{
					if($order->online_amount == 0 && $order->amount_from_wallet == 0){
						
						// COD Ledger Entry
						
						$LedgerData = $this->Orders->Ledgers->find()->where(['Ledgers.cash' =>'1','Ledgers.city_id'=>$order->city_id])->first();
						$order->party_ledger_id=$LedgerData->id;
						
						// Cash Account Entry 
						$AccountingEntrie = $this->Orders->AccountingEntries->newEntity(); 
						$AccountingEntrie->ledger_id=$order->party_ledger_id;
						$AccountingEntrie->debit=$NewOrder['grand_total'];
						$AccountingEntrie->credit=0;
						$AccountingEntrie->transaction_date=date('Y-m-d');
						$AccountingEntrie->city_id=$order->city_id;
						$AccountingEntrie->entry_from="Web";
						$AccountingEntrie->order_id=$order->id;  
						$this->Orders->AccountingEntries->save($AccountingEntrie);
						
						// Sales Account Entry 
						$AccountingEntrie = $this->Orders->AccountingEntries->newEntity(); 
						$AccountingEntrie->ledger_id=$order->sales_ledger_id;
						$AccountingEntrie->credit=$NewOrder['total_amount'];
						$AccountingEntrie->debit=0;
						$AccountingEntrie->transaction_date=date('Y-m-d');
						$AccountingEntrie->city_id=$order->city_id;
						$AccountingEntrie->entry_from="Web";
						$AccountingEntrie->order_id=$order->id; 
						$this->Orders->AccountingEntries->save($AccountingEntrie);
						
						//Delivery Charges Entry
						if($order->delivery_charge_amount > 0){
							$TransportLedger = $this->Orders->Ledgers->find()->where(['Ledgers.transport' =>'Receive','Ledgers.city_id'=>$order->city_id])->first();
								$AccountingEntrie1 = $this->Orders->AccountingEntries->newEntity();
								$AccountingEntrie1->ledger_id=$TransportLedger->id;
								$AccountingEntrie1->credit=$order->delivery_charge_amount;
								$AccountingEntrie1->debit=0;
								$AccountingEntrie1->transaction_date=$order->order_date;
								$AccountingEntrie1->city_id=$order->city_id;
								$AccountingEntrie1->entry_from="Web";
								$AccountingEntrie1->order_id=$order->id; 
								$this->Orders->AccountingEntries->save($AccountingEntrie1);
							}
						
						//round Off Entry
						$roundOffLedger = $this->Orders->Ledgers->find()->where(['Ledgers.round_off' =>'1','Ledgers.city_id'=>$order->city_id])->first(); 
						//
						$AccountingEntrie = $this->Orders->AccountingEntries->newEntity(); 
						$AccountingEntrie->ledger_id=$roundOffLedger->id;
						if($NewOrder['round_off'] < 0){
							$AccountingEntrie->debit=$NewOrder['round_off'];
							$AccountingEntrie->credit=0;
						}else{
						$AccountingEntrie->credit=$NewOrder['round_off'];
						$AccountingEntrie->debit=0;
						}
						$AccountingEntrie->transaction_date=date('Y-m-d');
						$AccountingEntrie->city_id=$order->city_id;
						$AccountingEntrie->entry_from="App";
						$AccountingEntrie->order_id=$order->id; 
						if($NewOrder['round_off'] != 0){
							$this->Orders->AccountingEntries->save($AccountingEntrie);
						}

						foreach($NewOrder['order_details'] as $order_detail){  
							$ItemData = $this->Orders->Items->find()->where(['Items.id'=>$order_detail['item_id']])->first();
							$gstAmtdata=$order_detail['gst_value']/2;
							$gstAmtInsert=round($gstAmtdata,2);
							
							$gstLedgerCGST = $this->Orders->Ledgers->find()->where(['Ledgers.gst_figure_id' =>$ItemData->gst_figure_id, 'Ledgers.input_output'=>'output', 'Ledgers.gst_type'=>'CGST','city_id'=>$order->city_id])->first();
								
							//Accounting Entries for CGST//
							$gstLedgerCGST = $this->Orders->Ledgers->find()
							->where(['Ledgers.gst_figure_id' =>$ItemData->gst_figure_id, 'Ledgers.input_output'=>'output', 'Ledgers.gst_type'=>'CGST','city_id'=>$order->city_id])->first();
							$AccountingEntrieCGST = $this->Orders->AccountingEntries->newEntity();
							$AccountingEntrieCGST->ledger_id=$gstLedgerCGST->id;
							$AccountingEntrieCGST->credit=$gstAmtInsert;
							$AccountingEntrieCGST->debit=0;
							$AccountingEntrieCGST->transaction_date=date('Y-m-d');
							$AccountingEntrieCGST->city_id=$order->city_id;
							$AccountingEntrieCGST->entry_from="Web";
							$AccountingEntrieCGST->order_id=$order->id; 
							if($gstAmtInsert > 0){
								$this->Orders->AccountingEntries->save($AccountingEntrieCGST);
							}
							
							//Accounting Entries for SGST//
							 $gstLedgerSGST = $this->Orders->Ledgers->find()
							->where(['Ledgers.gst_figure_id' =>$ItemData->gst_figure_id, 'Ledgers.input_output'=>'output', 'Ledgers.gst_type'=>'SGST','city_id'=>$order->city_id])->first();
							$AccountingEntrieSGST = $this->Orders->AccountingEntries->newEntity();
							$AccountingEntrieSGST->ledger_id=$gstLedgerSGST->id;
							$AccountingEntrieSGST->credit=$gstAmtInsert;
							$AccountingEntrieSGST->debit=0;
							$AccountingEntrieSGST->transaction_date=date('Y-m-d');
							$AccountingEntrieSGST->city_id=$order->city_id;
							$AccountingEntrieSGST->entry_from="Web";
							$AccountingEntrieSGST->order_id=$order->id;  
							if($gstAmtInsert > 0){
								$this->Orders->AccountingEntries->save($AccountingEntrieSGST);
							}
							
							//Stock Entry in Item Ledgers
							$orderDetailsData = $this->Orders->OrderDetails->get($order_detail['id'], [
								'contain' => ['ItemVariations']
							]);
							
							$ItemLedger = $this->Orders->OrderDetails->ItemLedgers->newEntity(); 
							$ItemLedger->item_id=$orderDetailsData->item_id; 
							$ItemLedger->unit_variation_id=$orderDetailsData->item_variation->unit_variation_id;
							$ItemLedger->item_variation_id=$orderDetailsData->item_variation_id;
							$ItemLedger->transaction_date=date('Y-m-d');  
							$ItemLedger->quantity=$order_detail['quantity'];
							$ItemLedger->rate=$order_detail['rate'];
							$ItemLedger->amount=$order_detail['quantity']*$order_detail['rate'];
							$ItemLedger->sales_rate=$order_detail['rate'];
							$ItemLedger->status="Out";
							$ItemLedger->city_id=$order->city_id;
							$ItemLedger->location_id=$order->location_id;
							$ItemLedger->order_id=$order->id;
							$ItemLedger->order_detail_id=$orderDetailsData->id;
							$this->Orders->OrderDetails->ItemLedgers->save($ItemLedger);
							
							
							$query = $this->Orders->OrderDetails->query();
							$query->update()
									->set(['is_item_cancel' => 'No'])
									->where(['id'=>$order_detail['id']])
									->execute();
						}
						
						//Update in Order
							$query = $this->Orders->query();
							$query->update()
									->set(['discount_amount' => $NewOrder['discount_amount'],'total_amount'=>$NewOrder['total_amount'],'total_gst'=>$NewOrder['total_gst'],'grand_total'=>$NewOrder['grand_total'],'round_off'=>$NewOrder['round_off'],'delivery_charge_amount'=>$NewOrder['delivery_charge_amount']])
									->where(['id'=>$order->id])
									->execute();
						
						//Stock Up in item Variations
						$orderDetailsCancleItems = $this->Orders->OrderDetails->find()->where(['order_id'=>$order->id,'is_item_cancel'=>'Yes']);
						$datasize=sizeof($orderDetailsCancleItems->toArray());
						if($datasize > 0){
							foreach($orderDetailsCancleItems as $data){
								//pr($data); exit;
							}
						}
						
					//echo "cod";exit;
				}else if($order->online_amount > 0 &&  $order->amount_from_wallet == 0 ){ 
						if($order->grand_total == $NewOrder['grand_total']){
							
							// Ledger entry for ccavenue
							$LedgerData = $this->Orders->Ledgers->find()->where(['Ledgers.ccavenue' =>'yes','Ledgers.city_id'=>$order->city_id])->first();
							$ccavenue_ledger_id=$LedgerData->id;
							$AccountingEntrie = $this->Orders->AccountingEntries->newEntity(); 
							$AccountingEntrie->ledger_id=$ccavenue_ledger_id;
							$AccountingEntrie->debit=$order->online_amount;
							$AccountingEntrie->credit=0;
							$AccountingEntrie->transaction_date=date('Y-m-d');
							$AccountingEntrie->city_id=$order->city_id;
							$AccountingEntrie->entry_from="Web";
							$AccountingEntrie->order_id=$order->id;  
							$this->Orders->AccountingEntries->save($AccountingEntrie);
						}else{
							
							// Ledger entry for ccavenue
							$LedgerData = $this->Orders->Ledgers->find()->where(['Ledgers.ccavenue' =>'yes','Ledgers.city_id'=>$order->city_id])->first();
							$ccavenue_ledger_id=$LedgerData->id;
							$AccountingEntrie = $this->Orders->AccountingEntries->newEntity(); 
							$AccountingEntrie->ledger_id=$ccavenue_ledger_id;
							$AccountingEntrie->debit=$NewOrder['grand_total'];
							$AccountingEntrie->credit=0;
							$AccountingEntrie->transaction_date=date('Y-m-d');
							$AccountingEntrie->city_id=$order->city_id;
							$AccountingEntrie->entry_from="Web";
							$AccountingEntrie->order_id=$order->id;  
							$this->Orders->AccountingEntries->save($AccountingEntrie);
							
							$online_return_amount=$order->online_amount-$NewOrder['grand_total'];
							$query = $this->Orders->query();
							$query->update()
									->set(['online_return_amount' => $online_return_amount])
									->where(['id'=>$order->id])
									->execute();
							
						}
						
						// Sales Account Entry 
						$AccountingEntrie = $this->Orders->AccountingEntries->newEntity(); 
						$AccountingEntrie->ledger_id=$order->sales_ledger_id;
						$AccountingEntrie->credit=$NewOrder['total_amount'];
						$AccountingEntrie->debit=0;
						$AccountingEntrie->transaction_date=date('Y-m-d');
						$AccountingEntrie->city_id=$order->city_id;
						$AccountingEntrie->entry_from="Web";
						$AccountingEntrie->order_id=$order->id; 
						$this->Orders->AccountingEntries->save($AccountingEntrie);
						
						//Delivery Charges Entry
						if($order->delivery_charge_amount > 0){
							$TransportLedger = $this->Orders->Ledgers->find()->where(['Ledgers.transport' =>'Receive','Ledgers.city_id'=>$order->city_id])->first();
								$AccountingEntrie1 = $this->Orders->AccountingEntries->newEntity();
								$AccountingEntrie1->ledger_id=$TransportLedger->id;
								$AccountingEntrie1->credit=$order->delivery_charge_amount;
								$AccountingEntrie1->debit=0;
								$AccountingEntrie1->transaction_date=$order->order_date;
								$AccountingEntrie1->city_id=$order->city_id;
								$AccountingEntrie1->entry_from="Web";
								$AccountingEntrie1->order_id=$order->id; 
								$this->Orders->AccountingEntries->save($AccountingEntrie1);
							}
						
						//round Off Entry
						$roundOffLedger = $this->Orders->Ledgers->find()->where(['Ledgers.round_off' =>'1','Ledgers.city_id'=>$order->city_id])->first(); 
						//
						$AccountingEntrie = $this->Orders->AccountingEntries->newEntity(); 
						$AccountingEntrie->ledger_id=$roundOffLedger->id;
						if($NewOrder['round_off'] < 0){
							$AccountingEntrie->debit=$NewOrder['round_off'];
							$AccountingEntrie->credit=0;
						}else{
						$AccountingEntrie->credit=$NewOrder['round_off'];
						$AccountingEntrie->debit=0;
						}
						$AccountingEntrie->transaction_date=date('Y-m-d');
						$AccountingEntrie->city_id=$order->city_id;
						$AccountingEntrie->entry_from="App";
						$AccountingEntrie->order_id=$order->id; 
						if($NewOrder['round_off'] != 0){
							$this->Orders->AccountingEntries->save($AccountingEntrie);
						}
						
						 
						foreach($NewOrder['order_details'] as $order_detail){   //pr($order_detail); exit;
							$ItemData = $this->Orders->Items->find()->where(['Items.id'=>$order_detail['item_id']])->first();
							$gstAmtdata=$order_detail['gst_value']/2;
							$gstAmtInsert=round($gstAmtdata,2);
							
							$gstLedgerCGST = $this->Orders->Ledgers->find()->where(['Ledgers.gst_figure_id' =>$ItemData->gst_figure_id, 'Ledgers.input_output'=>'output', 'Ledgers.gst_type'=>'CGST','city_id'=>$order->city_id])->first();
								
							//Accounting Entries for CGST//
							$gstLedgerCGST = $this->Orders->Ledgers->find()
							->where(['Ledgers.gst_figure_id' =>$ItemData->gst_figure_id, 'Ledgers.input_output'=>'output', 'Ledgers.gst_type'=>'CGST','city_id'=>$order->city_id])->first();
							$AccountingEntrieCGST = $this->Orders->AccountingEntries->newEntity();
							$AccountingEntrieCGST->ledger_id=$gstLedgerCGST->id;
							$AccountingEntrieCGST->credit=$gstAmtInsert;
							$AccountingEntrieCGST->debit=0;
							$AccountingEntrieCGST->transaction_date=date('Y-m-d');
							$AccountingEntrieCGST->city_id=$order->city_id;
							$AccountingEntrieCGST->entry_from="Web";
							$AccountingEntrieCGST->order_id=$order->id; 
							if($gstAmtInsert > 0){
								$this->Orders->AccountingEntries->save($AccountingEntrieCGST);
							}
							
							//Accounting Entries for SGST//
							 $gstLedgerSGST = $this->Orders->Ledgers->find()
							->where(['Ledgers.gst_figure_id' =>$ItemData->gst_figure_id, 'Ledgers.input_output'=>'output', 'Ledgers.gst_type'=>'SGST','city_id'=>$order->city_id])->first();
							$AccountingEntrieSGST = $this->Orders->AccountingEntries->newEntity();
							$AccountingEntrieSGST->ledger_id=$gstLedgerSGST->id;
							$AccountingEntrieSGST->credit=$gstAmtInsert;
							$AccountingEntrieSGST->debit=0;
							$AccountingEntrieSGST->transaction_date=date('Y-m-d');
							$AccountingEntrieSGST->city_id=$order->city_id;
							$AccountingEntrieSGST->entry_from="Web";
							$AccountingEntrieSGST->order_id=$order->id;  
							if($gstAmtInsert > 0){
								$this->Orders->AccountingEntries->save($AccountingEntrieSGST);
							}
							
							//Stock Entry in Item Ledgers
							$orderDetailsData = $this->Orders->OrderDetails->get($order_detail['id'], [
								'contain' => ['ItemVariations']
							]);
							
							$ItemLedger = $this->Orders->OrderDetails->ItemLedgers->newEntity(); 
							$ItemLedger->item_id=$orderDetailsData->item_id; 
							$ItemLedger->unit_variation_id=$orderDetailsData->item_variation->unit_variation_id;
							$ItemLedger->item_variation_id=$orderDetailsData->item_variation_id;
							$ItemLedger->transaction_date=date('Y-m-d');  
							$ItemLedger->quantity=$order_detail['quantity'];
							$ItemLedger->rate=$order_detail['rate'];
							$ItemLedger->amount=$order_detail['quantity']*$order_detail['rate'];
							$ItemLedger->sales_rate=$order_detail['rate'];
							$ItemLedger->status="Out";
							$ItemLedger->city_id=$order->city_id;
							$ItemLedger->location_id=$order->location_id;
							$ItemLedger->order_id=$order->id;
							$ItemLedger->order_detail_id=$orderDetailsData->id;
							$this->Orders->OrderDetails->ItemLedgers->save($ItemLedger);
							
							
							$query = $this->Orders->OrderDetails->query();
							$query->update()
									->set(['is_item_cancel' => 'No'])
									->where(['id'=>$order_detail['id']])
									->execute();
						}
						
						//Refrence Details Entry
							$ReferenceDetail = $this->Orders->ReferenceDetails->newEntity(); 
							$ReferenceDetail->ledger_id=$ccavenue_ledger_id;
							$ReferenceDetail->debit=$order->grand_total;
							$ReferenceDetail->credit=0;
							$ReferenceDetail->transaction_date=date('Y-m-d');
							$ReferenceDetail->city_id=$order->city_id;
							$ReferenceDetail->entry_from="Web";
							$ReferenceDetail->type='New Ref';
							$ReferenceDetail->ref_name=$order->ccavvenue_tracking_no;
							$ReferenceDetail->order_id=$order->id;
							$this->Orders->ReferenceDetails->save($ReferenceDetail);
						
						
						//Update in Order
							$query = $this->Orders->query();
							$query->update()
									->set(['discount_amount' => $NewOrder['discount_amount'],'total_amount'=>$NewOrder['total_amount'],'total_gst'=>$NewOrder['total_gst'],'grand_total'=>$NewOrder['grand_total'],'round_off'=>$NewOrder['round_off'],'delivery_charge_amount'=>$NewOrder['delivery_charge_amount']])
									->where(['id'=>$order->id])
									->execute();
						
						//Stock Up in item Variations
						$orderDetailsCancleItems = $this->Orders->OrderDetails->find()->where(['order_id'=>$order->id,'is_item_cancel'=>'Yes']);
						$datasize=sizeof($orderDetailsCancleItems->toArray());
						if($datasize > 0){
							foreach($orderDetailsCancleItems as $data){
								//pr($data); exit;
							}
						}
					
				}else if($order->amount_from_wallet > 0 && $order->online_amount ==  0){
						if($order->grand_total == $NewOrder['grand_total']){
							
							// Ledger entry for Customer
							$LedgerData = $this->Orders->Ledgers->find()->where(['Ledgers.customer_id'=>$order->customer_id])->first();
							$customer_ledger_id=$LedgerData->id; 
							$AccountingEntrie = $this->Orders->AccountingEntries->newEntity(); 
							$AccountingEntrie->ledger_id=$customer_ledger_id;
							$AccountingEntrie->debit=$order->grand_total;
							$AccountingEntrie->credit=0;
							$AccountingEntrie->transaction_date=date('Y-m-d');
							$AccountingEntrie->city_id=$order->city_id;
							$AccountingEntrie->entry_from="Web";
							$AccountingEntrie->order_id=$order->id;  
							$this->Orders->AccountingEntries->save($AccountingEntrie);
							
						
						}else if($order->grand_total > $NewOrder['grand_total']){  
							$add_amt_in_wallet=$order->grand_total-$NewOrder['grand_total'];
							
							// Ledger entry for Customer
							$LedgerData = $this->Orders->Ledgers->find()->where(['Ledgers.customer_id'=>$order->customer_id])->first();
							$customer_ledger_id=$LedgerData->id; 
							$AccountingEntrie = $this->Orders->AccountingEntries->newEntity(); 
							$AccountingEntrie->ledger_id=$customer_ledger_id;
							$AccountingEntrie->debit=$NewOrder['grand_total'];
							$AccountingEntrie->credit=0;
							$AccountingEntrie->transaction_date=date('Y-m-d');
							$AccountingEntrie->city_id=$order->city_id;
							$AccountingEntrie->entry_from="Web";
							$AccountingEntrie->order_id=$order->id;  
							$this->Orders->AccountingEntries->save($AccountingEntrie);
						
							//Add amount in wallet
							if($add_amt_in_wallet > 0){
								$wallet = $this->Orders->Wallets->newEntity(); 
								$wallet->transaction_type="Added";
								$wallet->amount_type="Return Order Amount";
								$wallet->narration="Return Order Amount";
								$wallet->add_amount=$add_amt_in_wallet;
								$wallet->city_id=$city_id;
								$wallet->customer_id=$order->customer_id;
								$wallet->order_id=$order->id;
								$this->Orders->Wallets->save($wallet);
							}
							
							
						}
						
						// Sales Account Entry 
							$AccountingEntrie = $this->Orders->AccountingEntries->newEntity(); 
							$AccountingEntrie->ledger_id=$order->sales_ledger_id;
							$AccountingEntrie->credit=$NewOrder['total_amount'];
							$AccountingEntrie->debit=0;
							$AccountingEntrie->transaction_date=date('Y-m-d');
							$AccountingEntrie->city_id=$order->city_id;
							$AccountingEntrie->entry_from="Web";
							$AccountingEntrie->order_id=$order->id; 
							$this->Orders->AccountingEntries->save($AccountingEntrie);
						
						//Delivery Charges Entry
						if($order->delivery_charge_amount > 0){
							$TransportLedger = $this->Orders->Ledgers->find()->where(['Ledgers.transport' =>'Receive','Ledgers.city_id'=>$order->city_id])->first();
								$AccountingEntrie1 = $this->Orders->AccountingEntries->newEntity();
								$AccountingEntrie1->ledger_id=$TransportLedger->id;
								$AccountingEntrie1->credit=$order->delivery_charge_amount;
								$AccountingEntrie1->debit=0;
								$AccountingEntrie1->transaction_date=$order->order_date;
								$AccountingEntrie1->city_id=$order->city_id;
								$AccountingEntrie1->entry_from="Web";
								$AccountingEntrie1->order_id=$order->id; 
								$this->Orders->AccountingEntries->save($AccountingEntrie1);
							}
						
						//round Off Entry
						$roundOffLedger = $this->Orders->Ledgers->find()->where(['Ledgers.round_off' =>'1','Ledgers.city_id'=>$order->city_id])->first(); 
						//
						$AccountingEntrie = $this->Orders->AccountingEntries->newEntity(); 
						$AccountingEntrie->ledger_id=$roundOffLedger->id;
						if($NewOrder['round_off'] < 0){
							$AccountingEntrie->debit=$NewOrder['round_off'];
							$AccountingEntrie->credit=0;
						}else{
						$AccountingEntrie->credit=$NewOrder['round_off'];
						$AccountingEntrie->debit=0;
						}
						$AccountingEntrie->transaction_date=date('Y-m-d');
						$AccountingEntrie->city_id=$order->city_id;
						$AccountingEntrie->entry_from="App";
						$AccountingEntrie->order_id=$order->id; 
						if($NewOrder['round_off'] != 0){
							$this->Orders->AccountingEntries->save($AccountingEntrie);
						}
						
				
						foreach($NewOrder['order_details'] as $order_detail){  
							$ItemData = $this->Orders->Items->find()->where(['Items.id'=>$order_detail['item_id']])->first();
							$gstAmtdata=$order_detail['gst_value']/2;
							$gstAmtInsert=round($gstAmtdata,2);
							
							$gstLedgerCGST = $this->Orders->Ledgers->find()->where(['Ledgers.gst_figure_id' =>$ItemData->gst_figure_id, 'Ledgers.input_output'=>'output', 'Ledgers.gst_type'=>'CGST','city_id'=>$order->city_id])->first();
								
							//Accounting Entries for CGST//
							$gstLedgerCGST = $this->Orders->Ledgers->find()
							->where(['Ledgers.gst_figure_id' =>$ItemData->gst_figure_id, 'Ledgers.input_output'=>'output', 'Ledgers.gst_type'=>'CGST','city_id'=>$order->city_id])->first();
							$AccountingEntrieCGST = $this->Orders->AccountingEntries->newEntity();
							$AccountingEntrieCGST->ledger_id=$gstLedgerCGST->id;
							$AccountingEntrieCGST->credit=$gstAmtInsert;
							$AccountingEntrieCGST->debit=0;
							$AccountingEntrieCGST->transaction_date=date('Y-m-d');
							$AccountingEntrieCGST->city_id=$order->city_id;
							$AccountingEntrieCGST->entry_from="Web";
							$AccountingEntrieCGST->order_id=$order->id; 
							if($gstAmtInsert > 0){
								$this->Orders->AccountingEntries->save($AccountingEntrieCGST);
							}
							
							//Accounting Entries for SGST//
							 $gstLedgerSGST = $this->Orders->Ledgers->find()
							->where(['Ledgers.gst_figure_id' =>$ItemData->gst_figure_id, 'Ledgers.input_output'=>'output', 'Ledgers.gst_type'=>'SGST','city_id'=>$order->city_id])->first();
							$AccountingEntrieSGST = $this->Orders->AccountingEntries->newEntity();
							$AccountingEntrieSGST->ledger_id=$gstLedgerSGST->id;
							$AccountingEntrieSGST->credit=$gstAmtInsert;
							$AccountingEntrieSGST->debit=0;
							$AccountingEntrieSGST->transaction_date=date('Y-m-d');
							$AccountingEntrieSGST->city_id=$order->city_id;
							$AccountingEntrieSGST->entry_from="Web";
							$AccountingEntrieSGST->order_id=$order->id;  
							if($gstAmtInsert > 0){
								$this->Orders->AccountingEntries->save($AccountingEntrieSGST);
							}
							
							//Stock Entry in Item Ledgers
							$orderDetailsData = $this->Orders->OrderDetails->get($order_detail['id'], [
								'contain' => ['ItemVariations']
							]);
							
							$ItemLedger = $this->Orders->OrderDetails->ItemLedgers->newEntity(); 
							$ItemLedger->item_id=$orderDetailsData->item_id; 
							$ItemLedger->unit_variation_id=$orderDetailsData->item_variation->unit_variation_id;
							$ItemLedger->item_variation_id=$orderDetailsData->item_variation_id;
							$ItemLedger->transaction_date=date('Y-m-d');  
							$ItemLedger->quantity=$order_detail['quantity'];
							$ItemLedger->rate=$order_detail['rate'];
							$ItemLedger->amount=$order_detail['quantity']*$order_detail['rate'];
							$ItemLedger->sales_rate=$order_detail['rate'];
							$ItemLedger->status="Out";
							$ItemLedger->city_id=$order->city_id;
							$ItemLedger->location_id=$order->location_id;
							$ItemLedger->order_id=$order->id;
							$ItemLedger->order_detail_id=$orderDetailsData->id;
							$this->Orders->OrderDetails->ItemLedgers->save($ItemLedger);
							
							
							$query = $this->Orders->OrderDetails->query();
							$query->update()
									->set(['is_item_cancel' => 'No'])
									->where(['id'=>$order_detail['id']])
									->execute();
						}
						
						//Update in Order
							$query = $this->Orders->query();
							$query->update()
									->set(['discount_amount' => $NewOrder['discount_amount'],'total_amount'=>$NewOrder['total_amount'],'total_gst'=>$NewOrder['total_gst'],'grand_total'=>$NewOrder['grand_total'],'round_off'=>$NewOrder['round_off'],'delivery_charge_amount'=>$NewOrder['delivery_charge_amount']])
									->where(['id'=>$order->id])
									->execute();
						
						//Stock Up in item Variations
						$orderDetailsCancleItems = $this->Orders->OrderDetails->find()->where(['order_id'=>$order->id,'is_item_cancel'=>'Yes']);
						$datasize=sizeof($orderDetailsCancleItems->toArray());
						if($datasize > 0){
							foreach($orderDetailsCancleItems as $data){
								//pr($data); exit;
							}
						}
					}else if($order->online_amount > 0 && $order->amount_from_wallet > 0){ // pr($NewOrder['grand_total']); exit;
						if($order->grand_total == $NewOrder['grand_total']){
							
							// Ledger entry for ccavenue
							$LedgerData = $this->Orders->Ledgers->find()->where(['Ledgers.ccavenue' =>'yes','Ledgers.city_id'=>$order->city_id])->first();
							$ccavenue_ledger_id=$LedgerData->id;
							$AccountingEntrie = $this->Orders->AccountingEntries->newEntity(); 
							$AccountingEntrie->ledger_id=$ccavenue_ledger_id;
							$AccountingEntrie->debit=$order->online_amount;
							$AccountingEntrie->credit=0;
							$AccountingEntrie->transaction_date=date('Y-m-d');
							$AccountingEntrie->city_id=$order->city_id;
							$AccountingEntrie->entry_from="Web";
							$AccountingEntrie->order_id=$order->id;  
							$this->Orders->AccountingEntries->save($AccountingEntrie);
							
							// Ledger entry for Customer
							$LedgerData = $this->Orders->Ledgers->find()->where(['Ledgers.customer_id'=>$order->customer_id])->first();
							$customer_ledger_id=$LedgerData->id; 
							$AccountingEntrie = $this->Orders->AccountingEntries->newEntity(); 
							$AccountingEntrie->ledger_id=$customer_ledger_id;
							$AccountingEntrie->debit=$order->amount_from_wallet;
							$AccountingEntrie->credit=0;
							$AccountingEntrie->transaction_date=date('Y-m-d');
							$AccountingEntrie->city_id=$order->city_id;
							$AccountingEntrie->entry_from="Web";
							$AccountingEntrie->order_id=$order->id;  
							$this->Orders->AccountingEntries->save($AccountingEntrie);
							
							echo "no cancel";
						}else if($order->amount_from_wallet < $NewOrder['grand_total']){
							//echo "850";exit;
						}else if($order->amount_from_wallet > $NewOrder['grand_total']){
							//echo "750";exit;
						}else if($order->amount_from_wallet == $NewOrder['grand_total']){
							//echo "800";exit;
						}
						
						// Sales Account Entry 
							$AccountingEntrie = $this->Orders->AccountingEntries->newEntity(); 
							$AccountingEntrie->ledger_id=$order->sales_ledger_id;
							$AccountingEntrie->credit=$NewOrder['total_amount'];
							$AccountingEntrie->debit=0;
							$AccountingEntrie->transaction_date=date('Y-m-d');
							$AccountingEntrie->city_id=$order->city_id;
							$AccountingEntrie->entry_from="Web";
							$AccountingEntrie->order_id=$order->id; 
							$this->Orders->AccountingEntries->save($AccountingEntrie);
						
						//Delivery Charges Entry
						if($order->delivery_charge_amount > 0){
							$TransportLedger = $this->Orders->Ledgers->find()->where(['Ledgers.transport' =>'Receive','Ledgers.city_id'=>$order->city_id])->first();
								$AccountingEntrie1 = $this->Orders->AccountingEntries->newEntity();
								$AccountingEntrie1->ledger_id=$TransportLedger->id;
								$AccountingEntrie1->credit=$order->delivery_charge_amount;
								$AccountingEntrie1->debit=0;
								$AccountingEntrie1->transaction_date=$order->order_date;
								$AccountingEntrie1->city_id=$order->city_id;
								$AccountingEntrie1->entry_from="Web";
								$AccountingEntrie1->order_id=$order->id; 
								$this->Orders->AccountingEntries->save($AccountingEntrie1);
							}
						
						//round Off Entry
						$roundOffLedger = $this->Orders->Ledgers->find()->where(['Ledgers.round_off' =>'1','Ledgers.city_id'=>$order->city_id])->first(); 
						//
						$AccountingEntrie = $this->Orders->AccountingEntries->newEntity(); 
						$AccountingEntrie->ledger_id=$roundOffLedger->id;
						if($NewOrder['round_off'] < 0){
							$AccountingEntrie->debit=$NewOrder['round_off'];
							$AccountingEntrie->credit=0;
						}else{
						$AccountingEntrie->credit=$NewOrder['round_off'];
						$AccountingEntrie->debit=0;
						}
						$AccountingEntrie->transaction_date=date('Y-m-d');
						$AccountingEntrie->city_id=$order->city_id;
						$AccountingEntrie->entry_from="App";
						$AccountingEntrie->order_id=$order->id; 
						if($NewOrder['round_off'] != 0){
							$this->Orders->AccountingEntries->save($AccountingEntrie);
						}
						
				
						foreach($NewOrder['order_details'] as $order_detail){  
							$ItemData = $this->Orders->Items->find()->where(['Items.id'=>$order_detail['item_id']])->first();
							$gstAmtdata=$order_detail['gst_value']/2;
							$gstAmtInsert=round($gstAmtdata,2);
							
							$gstLedgerCGST = $this->Orders->Ledgers->find()->where(['Ledgers.gst_figure_id' =>$ItemData->gst_figure_id, 'Ledgers.input_output'=>'output', 'Ledgers.gst_type'=>'CGST','city_id'=>$order->city_id])->first();
								
							//Accounting Entries for CGST//
							$gstLedgerCGST = $this->Orders->Ledgers->find()
							->where(['Ledgers.gst_figure_id' =>$ItemData->gst_figure_id, 'Ledgers.input_output'=>'output', 'Ledgers.gst_type'=>'CGST','city_id'=>$order->city_id])->first();
							$AccountingEntrieCGST = $this->Orders->AccountingEntries->newEntity();
							$AccountingEntrieCGST->ledger_id=$gstLedgerCGST->id;
							$AccountingEntrieCGST->credit=$gstAmtInsert;
							$AccountingEntrieCGST->debit=0;
							$AccountingEntrieCGST->transaction_date=date('Y-m-d');
							$AccountingEntrieCGST->city_id=$order->city_id;
							$AccountingEntrieCGST->entry_from="Web";
							$AccountingEntrieCGST->order_id=$order->id; 
							if($gstAmtInsert > 0){
								$this->Orders->AccountingEntries->save($AccountingEntrieCGST);
							}
							
							//Accounting Entries for SGST//
							 $gstLedgerSGST = $this->Orders->Ledgers->find()
							->where(['Ledgers.gst_figure_id' =>$ItemData->gst_figure_id, 'Ledgers.input_output'=>'output', 'Ledgers.gst_type'=>'SGST','city_id'=>$order->city_id])->first();
							$AccountingEntrieSGST = $this->Orders->AccountingEntries->newEntity();
							$AccountingEntrieSGST->ledger_id=$gstLedgerSGST->id;
							$AccountingEntrieSGST->credit=$gstAmtInsert;
							$AccountingEntrieSGST->debit=0;
							$AccountingEntrieSGST->transaction_date=date('Y-m-d');
							$AccountingEntrieSGST->city_id=$order->city_id;
							$AccountingEntrieSGST->entry_from="Web";
							$AccountingEntrieSGST->order_id=$order->id;  
							if($gstAmtInsert > 0){
								$this->Orders->AccountingEntries->save($AccountingEntrieSGST);
							}
							
							//Stock Entry in Item Ledgers
							$orderDetailsData = $this->Orders->OrderDetails->get($order_detail['id'], [
								'contain' => ['ItemVariations']
							]);
							
							$ItemLedger = $this->Orders->OrderDetails->ItemLedgers->newEntity(); 
							$ItemLedger->item_id=$orderDetailsData->item_id; 
							$ItemLedger->unit_variation_id=$orderDetailsData->item_variation->unit_variation_id;
							$ItemLedger->item_variation_id=$orderDetailsData->item_variation_id;
							$ItemLedger->transaction_date=date('Y-m-d');  
							$ItemLedger->quantity=$order_detail['quantity'];
							$ItemLedger->rate=$order_detail['rate'];
							$ItemLedger->amount=$order_detail['quantity']*$order_detail['rate'];
							$ItemLedger->sales_rate=$order_detail['rate'];
							$ItemLedger->status="Out";
							$ItemLedger->city_id=$order->city_id;
							$ItemLedger->location_id=$order->location_id;
							$ItemLedger->order_id=$order->id;
							$ItemLedger->order_detail_id=$orderDetailsData->id;
							$this->Orders->OrderDetails->ItemLedgers->save($ItemLedger);
							
							
							$query = $this->Orders->OrderDetails->query();
							$query->update()
									->set(['is_item_cancel' => 'No'])
									->where(['id'=>$order_detail['id']])
									->execute();
						}
						
						//Update in Order
							$query = $this->Orders->query();
							$query->update()
									->set(['discount_amount' => $NewOrder['discount_amount'],'total_amount'=>$NewOrder['total_amount'],'total_gst'=>$NewOrder['total_gst'],'grand_total'=>$NewOrder['grand_total'],'round_off'=>$NewOrder['round_off'],'delivery_charge_amount'=>$NewOrder['delivery_charge_amount']])
									->where(['id'=>$order->id])
									->execute();
						
						//Stock Up in item Variations
						$orderDetailsCancleItems = $this->Orders->OrderDetails->find()->where(['order_id'=>$order->id,'is_item_cancel'=>'Yes']);
						$datasize=sizeof($orderDetailsCancleItems->toArray());
						if($datasize > 0){
							foreach($orderDetailsCancleItems as $data){
								//pr($data); exit;
							}
						}
					}
			//exit;	
			}
			$query = $this->Orders->query();
			$query->update()
					->set(['order_status' => 'Delivered'])
					->where(['id'=>$order->id])
					->execute();
					
						
			$this->Flash->success(__('The order has been Deliverd.'));
             return $this->redirect(['action' => 'manageOrder']);
			
			
	 
		}	
		if(!empty($status)){
			
			$order_data=$this->Orders->find()->where(['Orders.order_status'=>$status])->order(['Orders.id'=>'DESC'])->contain(['SellerLedgers','PartyLedgers','Locations','Customers','CustomerAddressesLeft','Drivers']);
		}else{
			
			$order_data=$this->Orders->find()->order(['Orders.id'=>'DESC'])->contain(['SellerLedgers','PartyLedgers','Locations','Customers','CustomerAddressesLeft','Drivers']);
		}
		
		$drivers=$this->Orders->Drivers->find('list')->where(['Drivers.status'=>'Active'])->contain(['Locations'=>function ($q) use($city_id){
							return $q->where(['Locations.city_id'=>$city_id]);
						}]);
		$cancelReasons=$this->Orders->CancelReasons->find('list')->where(['CancelReasons.city_id'=>$city_id,'CancelReasons.status'=>'Active']);
        $orders = $this->paginate($order_data);
		//pr( $orders->toArray()); exit;
		$paginate_limit=$this->paginate['limit'];
        $this->set(compact('orders','paginate_limit','status','drivers','cancelReasons'));
    }
	
	
	
	
	public function cancleOrderReport($status=null){
		//$this->viewBuilder()->layout('super_admin_layout');
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id');
		$location_id=$this->Auth->User('location_id');
		//$location_id = $this->request->query('location_id');
		$seller_id = $this->request->query('seller_id');
		$gst_figure_id = $this->request->query('gst_figure_id');
		$from_date = $this->request->query('from_date');
		$to_date   = $this->request->query('to_date');
		$user_type =$this->Auth->User('user_type');
		if($user_type=="Super Admin"){
		$this->viewBuilder()->layout('super_admin_layout');
		}else if($user_type=="Admin"){ 
		$this->viewBuilder()->layout('admin_portal');
		}
		
		
		if(empty($from_date) || empty($to_date))
		{
			$from_date = date("Y-m-01");
			$to_date   = date("Y-m-d");
		}else{
			$from_date = date("Y-m-d",strtotime($from_date));
			$to_date= date("Y-m-d",strtotime($to_date));
		}
		if(!empty($from_date))
		{
			$from_date = date("Y-m-d",strtotime($from_date));
			$where['Orders.transaction_date >=']=$from_date;
		}
		if(!empty($to_date))
		{
			$to_date   = date("Y-m-d",strtotime($to_date));
			$where['Orders.transaction_date <=']=$to_date;
		}
		if(!empty($location_id))
		{
			//$to_date   = date("Y-m-d",strtotime($to_date));
			$where['Orders.location_id']=$location_id;
		}
		$orders=[];
		//pr($location_id); exit;
		$orders=$this->Orders->find()->contain(['Locations','Customers','OrderDetails' =>function ($q) {
			return $q->where(['OrderDetails.is_item_cancel' =>'Yes','OrderDetails.other_order_create' =>'No'])->contain(['Items','ItemVariations'=>['UnitVariations']]);
		}])->where($where)->group('Orders.id');
		//pr($orders->toArray()); exit;
			 
		$Locations = $this->Orders->Locations->find('list')->where(['city_id'=>$city_id]);
		$Sellers = $this->Orders->OrderDetails->Items->Sellers->find('list')->where(['city_id'=>$city_id]);
		$this->set(compact('from_date','to_date','orders','Locations','location_id','seller_id','Sellers','GstFigures'));
	}
	public function itemStatusCheck($status=null){
		$orders=$this->Orders->find()
		->contain(['OrderDetails'=> function ($q) {
								return $q 
								->where(['OrderDetails.item_status'=>'placed']);
					}])
		->where(['Orders.order_status'=>'Dispatched']);
		foreach($orders as $data){
			//
			if(!empty($data->order_details)){
				foreach($data->order_details as $data1){
					$OrderDetails_data = $this->Orders->OrderDetails->find();
					$OrderDetails_data->update()
					->set(['item_status' => 'Dispatched'])
					->where(['id' => $data1->id])->execute();
				}  //pr($data1); 
			}
		}
		echo "Done"; exit;
	}
	public function purchaseItemDetails($status=null){
		
		$url=$this->request->here();
		$url=parse_url($url,PHP_URL_QUERY);
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id');
		$location_id=$this->Auth->User('location_id');
		$status = $this->request->query('status');
		$user_type =$this->Auth->User('user_type');
		if($user_type=="Super Admin"){
		$this->viewBuilder()->layout('super_admin_layout');
		}else if($user_type=="Admin"){ 
		$this->viewBuilder()->layout('admin_portal');
		}
		$type = $this->request->query('type');
		//$from_date = $this->request->query('from_date');
		$to_date   = $this->request->query('to_date');
		$order_time   = $this->request->query('order_time');
		if(empty($to_date))
		{ 
			$to_date   = date("Y-m-d");
			$order_time=date('H:i:s');
		}else{
			$to_date= date("Y-m-d",strtotime($to_date));
		}
		
		$back_date=date('Y-m-d', strtotime('-1 day', strtotime($to_date)));
		
		
		$Fruits="Fruits";
		$Vegetables="Vegetables";
		
		
		$fruitId=$this->Orders->Categories->find()->where(['name LIKE' =>'%'. $Fruits.'%','city_id'=>$city_id])->first();
		$VegetableId=$this->Orders->Categories->find()->where(['name LIKE' =>'%'. $Vegetables.'%','city_id'=>$city_id])->first();
		$Fruits = $this->Orders->Categories
				->find('children', ['for' =>$fruitId->id])->select(['id'])
				->toArray();
		$Vegetables = $this->Orders->Categories
				->find('children', ['for' =>$VegetableId->id])->select(['id'])
				->toArray();
		if($type=="Fruits"){
			$FruitsVegetables=$Fruits;
		}else if($type=="Vegetables"){
			$FruitsVegetables=$Vegetables;
		}else{
			$FruitsVegetables=array_merge($Fruits,$Vegetables);
		}
		$AllCategories=[];
		$AllCategories=[$fruitId->id,$VegetableId->id];
		foreach($FruitsVegetables as $data){
			$AllCategories[]=$data->id;
		}
		//pr($AllCategories); exit;
		//$order = $this->Orders->find()->where(['order_status'=>'placed','city_id'=>$city_id])->contain(['OrderDetails'=>['ItemVariations']]);
		// in_array($page->id,$allowed_pages)
		
		$OrderDetails=$this->Orders->OrderDetails->find()
			->innerJoinWith('ItemVariations.UnitVariations')
			->innerJoinWith('ItemVariations.Items')
			->innerJoinWith('Orders')
			->order(['Items.name'=>'ASC'])
			->select([
				'item_name'=>'Items.name',
				'item_id'=>'Items.id',
				'unit_variation_id'=>'UnitVariations.id',
				'unit_variation_name'=>'UnitVariations.visible_variation',
				'convert_unit_qty'=>'UnitVariations.convert_unit_qty',
				'order_quantity'=>'OrderDetails.quantity',
			])
			->where(['OrderDetails.item_status'=>'placed','Orders.city_id'=>$city_id,'Orders.order_date <= '=>$back_date,'Items.category_id IN'=>$AllCategories])
			->orWhere(['OrderDetails.item_status'=>'placed','Orders.city_id'=>$city_id,'Orders.order_date <= '=>$to_date,'Orders.order_time <= '=>$order_time,'Items.category_id IN'=>$AllCategories]);
						
		$QRdata=[]; 
		$unit_variation_datas=[];
		$QRitemName=[];
		$OrderCount=[];
		$OrderItemCount=[];
		foreach($OrderDetails as $OrderDetail){
			
			@$QRdata[$OrderDetail->item_id][$OrderDetail->unit_variation_id]+=$OrderDetail->order_quantity;
			$unit_variation_datas[]=$OrderDetail->unit_variation_id;
			@$unit_variation_names[$OrderDetail->unit_variation_id]=@$OrderDetail->unit_variation_name;
			$QRitemName[$OrderDetail->item_id]=$OrderDetail->item_name;
			$OrderCount[$OrderDetail->item_id][]=$OrderDetail->order_id;
			@$OrderItemCount[$OrderDetail->item_id]+=$OrderDetail->convert_unit_qty*$OrderDetail->order_quantity;
			
		}
		$unit_variation_datas=array_unique($unit_variation_datas);
		sort($unit_variation_datas);
		//pr($unit_variation_datas); exit;
		
		/*$Orders = $this->Orders->find()->contain(['OrderDetails' => function($q) {
			return $q->select(['order_id','item_id','item_variation_id','total_qty' => $q->func()->sum('OrderDetails.quantity'),'total_order' => $q->func()->count('OrderDetails.order_id')])
			->where(['item_status'=>'placed'])
			->group('OrderDetails.item_variation_id')->contain(['ItemVariations']);
		}])
		->where(['city_id'=>$city_id,'order_date <= '=>$back_date])
		->orWhere(['city_id'=>$city_id,'order_date <= '=>$to_date,'order_time <= '=>$order_time])
		->group('Orders.id'); 
		
		 $ItemData=[];
		$ItemName=[];
		$AvailUnit=[];
		
		$unit_name="kg";
		$unit_id=['142','143','144'];
		
		//pr($unit_id);
		$units1=$this->Orders->OrderDetails->Items->UnitVariations->Units->find()->where(['id IN '=>$unit_id])->contain(['UnitVariations'=>function($p){ return $p->where(['status'=>'Active']);}])->toArray();
		//pr($units1); exit;
		$units2=$this->Orders->OrderDetails->Items->UnitVariations->Units->find()->where(['Units.unit_name LIKE' =>'%'. $unit_name.'%','city_id'=>$city_id])->contain(['UnitVariations'=>function($p){ return $p->where(['status'=>'Active']);}])->toArray();
		
		$units=array_merge($units2,$units1);
		//pr($units); exit;
		$showUnits=[];
		foreach($units as $datas){
			foreach($datas->unit_variations as $data){
				if(in_array($data->id,$AvailUnit)){
					$showUnits[$data->id]=$data->visible_variation;
				}
			}
		} */
		//pr($QRitemName);
		//pr($AvailUnit);pr($showUnits); exit;
		$this->set(compact('ItemData','to_date','showUnits','url','ItemName','order_time', 'QRdata', 'unit_variation_datas', 'QRitemName','unit_variation_names','OrderCount','OrderItemCount'));
		
	}
	public function purchaseGroceryItems($status=null){
		
		$url=$this->request->here();
		$url=parse_url($url,PHP_URL_QUERY);
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id');
		$location_id=$this->Auth->User('location_id');
		$status = $this->request->query('status');
		$user_type =$this->Auth->User('user_type');
		if($user_type=="Super Admin"){
		$this->viewBuilder()->layout('super_admin_layout');
		}else if($user_type=="Admin"){ 
		$this->viewBuilder()->layout('admin_portal');
		}
		$type = $this->request->query('type');
		//$from_date = $this->request->query('from_date');
		$to_date   = $this->request->query('to_date');
		$order_time   = $this->request->query('order_time');
		if(empty($to_date))
		{ 
			$to_date   = date("Y-m-d");
			$order_time=date('H:i:s');
		}else{
			$to_date= date("Y-m-d",strtotime($to_date));
		}
		
		$back_date=date('Y-m-d', strtotime('-1 day', strtotime($to_date)));
		
		/* $Challans=$this->Orders->Challans->find()
		->contain([''])
		->where(['Challans.order_status'=>'placed','Challans.city_id'=>$city_id,'Challans.seller_id IS NULL']);
		
		 */
		
		$OrderDetails=$this->Orders->Challans->ChallanRows->find()
		->innerJoinWith('ItemVariations.UnitVariations')
			->innerJoinWith('ItemVariations.Items')
			->innerJoinWith('Challans')
			->innerJoinWith('Challans.Orders')
			->order(['Items.name'=>'ASC'])
			->select([
				'item_name'=>'Items.name',
				'item_id'=>'Items.id',
				'unit_variation_id'=>'UnitVariations.id',
				'unit_variation_name'=>'UnitVariations.visible_variation',
				'convert_unit_qty'=>'UnitVariations.convert_unit_qty',
				'order_quantity'=>'ChallanRows.quantity',
			])
			->where(['Challans.order_status'=>'placed','Challans.city_id'=>$city_id,'Challans.seller_id IS NULL','Challans.transaction_date <= '=>$to_date,'Orders.order_time <= '=>$order_time])
			->orWhere(['Challans.order_status'=>'placed','Challans.city_id'=>$city_id,'Challans.seller_id IS NULL','Challans.transaction_date <= '=>$back_date]);
		//pr($Challans->toArray()); exit; 
			//->orWhere(['Orders.order_status'=>'placed','Orders.city_id'=>$city_id,'Orders.order_date <= '=>$to_date,'Orders.order_time <= '=>$order_time])
	
		$QRdata=[]; 
		$unit_variation_datas=[];
		$QRitemName=[];
		$OrderCount=[];
		$OrderItemCount=[];
		foreach($OrderDetails as $OrderDetail){
			
			@$QRdata[$OrderDetail->item_id][$OrderDetail->unit_variation_id]+=$OrderDetail->order_quantity;
			$unit_variation_datas[]=$OrderDetail->unit_variation_id;
			@$unit_variation_names[$OrderDetail->unit_variation_id]=@$OrderDetail->unit_variation_name;
			$QRitemName[$OrderDetail->item_id]=$OrderDetail->item_name;
			$OrderCount[$OrderDetail->item_id][]=$OrderDetail->order_id;
			@$OrderItemCount[$OrderDetail->item_id]+=$OrderDetail->convert_unit_qty*$OrderDetail->order_quantity;
			
		}
		$unit_variation_datas=array_unique($unit_variation_datas);
		sort($unit_variation_datas);
		
		$this->set(compact('ItemData','to_date','showUnits','url','ItemName','order_time', 'QRdata', 'unit_variation_datas', 'QRitemName','unit_variation_names','OrderCount','OrderItemCount'));
		
	}
	public function PurchaseGroceryExcel($status=null){
		
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id');
		$location_id=$this->Auth->User('location_id');
		$status = $this->request->query('status');
		$user_type =$this->Auth->User('user_type');
		$this->viewBuilder()->layout('');
		
		$type = $this->request->query('type');
		$to_date   = $this->request->query('to-date');
		$order_time   = $this->request->query('order-time');
		if(empty($to_date))
		{ 
			$to_date   = date("Y-m-d");
			$order_time=date('H:i:s');
		}else{
			$to_date= date("Y-m-d",strtotime($to_date));
		}
		
		$back_date=date('Y-m-d', strtotime('-1 day', strtotime($to_date)));
		
		/* $Challans=$this->Orders->Challans->find()
		->contain([''])
		->where(['Challans.order_status'=>'placed','Challans.city_id'=>$city_id,'Challans.seller_id IS NULL']);
		
		 */
		
		$OrderDetails=$this->Orders->Challans->ChallanRows->find()
		->innerJoinWith('ItemVariations.UnitVariations')
			->innerJoinWith('ItemVariations.Items')
			->innerJoinWith('Challans')
			->innerJoinWith('Challans.Orders')
			->order(['Items.name'=>'ASC'])
			->select([
				'item_name'=>'Items.name',
				'item_id'=>'Items.id',
				'unit_variation_id'=>'UnitVariations.id',
				'unit_variation_name'=>'UnitVariations.visible_variation',
				'convert_unit_qty'=>'UnitVariations.convert_unit_qty',
				'order_quantity'=>'ChallanRows.quantity',
			])
			//->where(['Challans.order_status'=>'placed','Challans.city_id'=>$city_id,'Challans.seller_id IS NULL'])
			//->orWhere(['Orders.city_id'=>$city_id,'Orders.order_date <= '=>$to_date,'Orders.order_time <= '=>$order_time]);
			
			->where(['Challans.order_status'=>'placed','Challans.city_id'=>$city_id,'Challans.seller_id IS NULL','Challans.transaction_date <= '=>$to_date,'Orders.order_time <= '=>$order_time])
			->orWhere(['Challans.order_status'=>'placed','Challans.city_id'=>$city_id,'Challans.seller_id IS NULL','Challans.transaction_date <= '=>$back_date]);
			
			
		//pr($Challans->toArray()); exit;
	
		$QRdata=[]; 
		$unit_variation_datas=[];
		$QRitemName=[];
		$OrderCount=[];
		$OrderItemCount=[];
		foreach($OrderDetails as $OrderDetail){
			
			@$QRdata[$OrderDetail->item_id][$OrderDetail->unit_variation_id]+=$OrderDetail->order_quantity;
			$unit_variation_datas[]=$OrderDetail->unit_variation_id;
			@$unit_variation_names[$OrderDetail->unit_variation_id]=@$OrderDetail->unit_variation_name;
			$QRitemName[$OrderDetail->item_id]=$OrderDetail->item_name;
			$OrderCount[$OrderDetail->item_id][]=$OrderDetail->order_id;
			@$OrderItemCount[$OrderDetail->item_id]+=$OrderDetail->convert_unit_qty*$OrderDetail->order_quantity;
			
		}
		$unit_variation_datas=array_unique($unit_variation_datas);
		sort($unit_variation_datas);
		
		$this->set(compact('ItemData','to_date','showUnits','url','ItemName','order_time', 'QRdata', 'unit_variation_datas', 'QRitemName','unit_variation_names','OrderCount','OrderItemCount'));
		
	}
	
	public function PurchaseExcel(){ 
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id');
		$location_id=$this->Auth->User('location_id');
		$status = $this->request->query('status');
		$user_type =$this->Auth->User('user_type');
		$this->viewBuilder()->layout('');
		
		$type = $this->request->query('type');
		$to_date   = $this->request->query('to-date');
		$order_time   = $this->request->query('order-time');
		if(empty($to_date))
		{ 
			$to_date   = date("Y-m-d");
		}else{
			$to_date= date("Y-m-d",strtotime($to_date));
		}
		if(empty($order_time))
		{ 
			$order_time=date('H:i:s');
		}
		
		$back_date=date('Y-m-d', strtotime('-1 day', strtotime($to_date)));
		
		
		$Fruits="Fruits";
		$Vegetables="Vegetables";
		
		
		$fruitId=$this->Orders->Categories->find()->where(['name LIKE' =>'%'. $Fruits.'%','city_id'=>$city_id])->first();
		$VegetableId=$this->Orders->Categories->find()->where(['name LIKE' =>'%'. $Vegetables.'%','city_id'=>$city_id])->first();
		$Fruits = $this->Orders->Categories
				->find('children', ['for' =>$fruitId->id])->select(['id'])
				->toArray();
		$Vegetables = $this->Orders->Categories
				->find('children', ['for' =>$VegetableId->id])->select(['id'])
				->toArray();
		if($type=="Fruits"){
			$FruitsVegetables=$Fruits;
		}else if($type=="Vegetables"){
			$FruitsVegetables=$Vegetables;
		}else{
			$FruitsVegetables=array_merge($Fruits,$Vegetables);
		}
		$AllCategories=[];
		$AllCategories=[$fruitId->id,$VegetableId->id];
		foreach($FruitsVegetables as $data){
			$AllCategories[]=$data->id;
		}
		$OrderDetails=$this->Orders->OrderDetails->find()
			->innerJoinWith('ItemVariations.UnitVariations')
			->innerJoinWith('ItemVariations.Items')
			->innerJoinWith('Orders')
			->order(['Items.name'=>'ASC'])
			->select([
				'item_name'=>'Items.name',
				'item_id'=>'Items.id',
				'unit_variation_id'=>'UnitVariations.id',
				'unit_variation_name'=>'UnitVariations.visible_variation',
				'convert_unit_qty'=>'UnitVariations.convert_unit_qty',
				'order_quantity'=>'OrderDetails.quantity',
			])
			->where(['OrderDetails.item_status'=>'placed','Orders.city_id'=>$city_id,'Orders.order_date <= '=>$back_date,'Items.category_id IN'=>$AllCategories])
			->orWhere(['OrderDetails.item_status'=>'placed','Orders.city_id'=>$city_id,'Orders.order_date <= '=>$to_date,'Orders.order_time <= '=>$order_time,'Items.category_id IN'=>$AllCategories]);
						
		$QRdata=[]; 
		$unit_variation_datas=[];
		$QRitemName=[];
		$OrderCount=[];
		$OrderItemCount=[];
		foreach($OrderDetails as $OrderDetail){
			
			@$QRdata[$OrderDetail->item_id][$OrderDetail->unit_variation_id]+=$OrderDetail->order_quantity;
			$unit_variation_datas[]=$OrderDetail->unit_variation_id;
			@$unit_variation_names[$OrderDetail->unit_variation_id]=@$OrderDetail->unit_variation_name;
			$QRitemName[$OrderDetail->item_id]=$OrderDetail->item_name;
			$OrderCount[$OrderDetail->item_id][]=$OrderDetail->order_id;
			@$OrderItemCount[$OrderDetail->item_id]+=$OrderDetail->convert_unit_qty*$OrderDetail->order_quantity;
			
		}
		$unit_variation_datas=array_unique($unit_variation_datas);
		sort($unit_variation_datas);
		//pr($ItemData);pr($showUnits); exit;
		$this->set(compact('ItemData','to_date','showUnits','url','ItemName','order_time', 'QRdata', 'unit_variation_datas', 'QRitemName','unit_variation_names','OrderCount','OrderItemCount'));
		
	}
	public function invoiceManageOrder($status=null)
    {
		
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id');
		$location_id=$this->Auth->User('location_id');
		$status = $this->request->query('status');
		$user_type =$this->Auth->User('user_type');
		if($user_type=="Super Admin"){
		$this->viewBuilder()->layout('super_admin_layout');
		}else if($user_type=="Admin"){ 
		$this->viewBuilder()->layout('admin_portal');
		}
		
        $this->paginate = [
			'limit' => 100 
        ];
		
		
		if ($this->request->is('post')) { 
			 
			$NewOrder=$this->request->data;
			$query = $this->Orders->Invoices->InvoiceRows->query();
			$query->update()
					->set(['is_item_cancel' => 'Yes'])
					->where(['invoice_id'=>$NewOrder['invoice_id']])
					->execute();
			$order = $this->Orders->Invoices->get($NewOrder['invoice_id']);
			
				
				if($order->order_type ==  "Wallet"){
						if($order->grand_total == $NewOrder['grand_total']){
							
							// Ledger entry for Customer
							$LedgerData = $this->Orders->Ledgers->find()->where(['Ledgers.customer_id'=>$order->customer_id,'Ledgers.city_id'=>$order->city_id])->first();
							$customer_ledger_id=$LedgerData->id; 
							$AccountingEntrie = $this->Orders->AccountingEntries->newEntity(); 
							$AccountingEntrie->ledger_id=$customer_ledger_id;
							$AccountingEntrie->debit=$order->grand_total;
							$AccountingEntrie->credit=0;
							$AccountingEntrie->transaction_date=date('Y-m-d');
							$AccountingEntrie->city_id=$order->city_id;
							$AccountingEntrie->entry_from="Web";
							$AccountingEntrie->invoice_id=$order->id;  
							//$this->Orders->AccountingEntries->save($AccountingEntrie);
							
							//	Payment History
							 $OrderPaymentHistory = $this->Orders->OrderPaymentHistories->newEntity();
							 $OrderPaymentHistory->order_id=$order->order_id;
							 $OrderPaymentHistory->invoice_id=$order->id;
							 //$OrderPaymentHistory->online_amount=$order->online_amount;
							 $OrderPaymentHistory->wallet_amount=$order->grand_total;
							 
							 $OrderPaymentHistory->total=$order->grand_total;
							 $OrderPaymentHistory->entry_from="Invoice";
							 $this->Orders->OrderPaymentHistories->save( $OrderPaymentHistory);  // pr($OrderPaymentHistory); exit;
							//
						
						}else if($order->grand_total > $NewOrder['grand_total']){  
							$add_amt_in_wallet=$order->grand_total-$NewOrder['grand_total'];
							//pr($add_amt_in_wallet); exit;
							// Ledger entry for Customer
							$LedgerData = $this->Orders->Ledgers->find()->where(['Ledgers.customer_id'=>$order->customer_id,'Ledgers.city_id'=>$order->city_id])->first();
							$customer_ledger_id=$LedgerData->id; 
							$AccountingEntrie = $this->Orders->AccountingEntries->newEntity(); 
							$AccountingEntrie->ledger_id=$customer_ledger_id;
							$AccountingEntrie->debit=$NewOrder['grand_total'];
							$AccountingEntrie->credit=0;
							$AccountingEntrie->transaction_date=date('Y-m-d');
							$AccountingEntrie->city_id=$order->city_id;
							$AccountingEntrie->entry_from="Web";
							$AccountingEntrie->invoice_id=$order->id;  
							$this->Orders->AccountingEntries->save($AccountingEntrie);
							//Payment History
							 $OrderPaymentHistory = $this->Orders->OrderPaymentHistories->newEntity();
							 $OrderPaymentHistory->order_id=$order->order_id;
							 $OrderPaymentHistory->invoice_id=$order->id;
							 $OrderPaymentHistory->order_id=$order->order_id;
							 $OrderPaymentHistory->wallet_amount=$NewOrder['grand_total'];
							 $OrderPaymentHistory->total=$NewOrder['grand_total'];
							 $OrderPaymentHistory->wallet_return=$add_amt_in_wallet;
							 $OrderPaymentHistory->entry_from="Invoice";
							 $this->Orders->OrderPaymentHistories->save( $OrderPaymentHistory); 
							//
							//Add amount in wallet
							if($add_amt_in_wallet > 0){
								$wallet = $this->Orders->Wallets->newEntity(); 
								$wallet->transaction_type="Added";
								$wallet->amount_type="Return Invoice Amount";
								$wallet->narration="Return Invoice Amount";
								$wallet->add_amount=$add_amt_in_wallet;
								$wallet->city_id=$city_id;
								$wallet->customer_id=$order->customer_id;
								$wallet->invoice_id=$order->id;
								$this->Orders->Wallets->save($wallet);
							}
						}
						
						// Sales Account Entry 
							$AccountingEntrie = $this->Orders->AccountingEntries->newEntity(); 
							$AccountingEntrie->ledger_id=$order->sales_ledger_id;
							$AccountingEntrie->credit=$NewOrder['total_amount'];
							$AccountingEntrie->debit=0;
							$AccountingEntrie->transaction_date=date('Y-m-d');
							$AccountingEntrie->city_id=$order->city_id;
							$AccountingEntrie->entry_from="Web";
							$AccountingEntrie->invoice_id=$order->id; 
							$this->Orders->AccountingEntries->save($AccountingEntrie);
						
						//Delivery Charges Entry
						if($NewOrder['delivery_charge_amount'] > 0){
							$TransportLedger = $this->Orders->Ledgers->find()->where(['Ledgers.transport' =>'Receive','Ledgers.city_id'=>$order->city_id])->first();
								$AccountingEntrie1 = $this->Orders->AccountingEntries->newEntity();
								$AccountingEntrie1->ledger_id=$TransportLedger->id;
								$AccountingEntrie1->credit=$NewOrder['delivery_charge_amount'];
								$AccountingEntrie1->debit=0;
								$AccountingEntrie1->transaction_date=$order->order_date;
								$AccountingEntrie1->city_id=$order->city_id;
								$AccountingEntrie1->entry_from="Web";
								$AccountingEntrie1->invoice_id=$order->id; 
								$this->Orders->AccountingEntries->save($AccountingEntrie1);
							}
						
						//round Off Entry
						$roundOffLedger = $this->Orders->Ledgers->find()->where(['Ledgers.round_off' =>'1','Ledgers.city_id'=>$order->city_id])->first(); 
						//
						$AccountingEntrie = $this->Orders->AccountingEntries->newEntity(); 
						$AccountingEntrie->ledger_id=$roundOffLedger->id;
						if($NewOrder['round_off'] < 0){
							$AccountingEntrie->debit=$NewOrder['round_off'];
							$AccountingEntrie->credit=0;
						}else{
						$AccountingEntrie->credit=$NewOrder['round_off'];
						$AccountingEntrie->debit=0;
						}
						$AccountingEntrie->transaction_date=date('Y-m-d');
						$AccountingEntrie->city_id=$order->city_id;
						$AccountingEntrie->entry_from="Web";
						$AccountingEntrie->invoice_id=$order->id; 
						if($NewOrder['round_off'] != 0){
							$this->Orders->AccountingEntries->save($AccountingEntrie);
						}
						
				
						foreach($NewOrder['order_details'] as $order_detail){  
							$ItemData = $this->Orders->Items->find()->where(['Items.id'=>$order_detail['item_id']])->first();
							$gstAmtdata=$order_detail['gst_value']/2;
							$gstAmtInsert=round($gstAmtdata,2);
							
							$gstLedgerCGST = $this->Orders->Ledgers->find()->where(['Ledgers.gst_figure_id' =>$ItemData->gst_figure_id, 'Ledgers.input_output'=>'output', 'Ledgers.gst_type'=>'CGST','city_id'=>$order->city_id])->first();
								
							//Accounting Entries for CGST//
							$gstLedgerCGST = $this->Orders->Ledgers->find()
							->where(['Ledgers.gst_figure_id' =>$ItemData->gst_figure_id, 'Ledgers.input_output'=>'output', 'Ledgers.gst_type'=>'CGST','city_id'=>$order->city_id])->first();
							$AccountingEntrieCGST = $this->Orders->AccountingEntries->newEntity();
							$AccountingEntrieCGST->ledger_id=$gstLedgerCGST->id;
							$AccountingEntrieCGST->credit=$gstAmtInsert;
							$AccountingEntrieCGST->debit=0;
							$AccountingEntrieCGST->transaction_date=date('Y-m-d');
							$AccountingEntrieCGST->city_id=$order->city_id;
							$AccountingEntrieCGST->entry_from="Web";
							$AccountingEntrieCGST->invoice_id=$order->id; 
							if($gstAmtInsert > 0){
								$this->Orders->AccountingEntries->save($AccountingEntrieCGST);
							}
							
							//Accounting Entries for SGST//
							 $gstLedgerSGST = $this->Orders->Ledgers->find()
							->where(['Ledgers.gst_figure_id' =>$ItemData->gst_figure_id, 'Ledgers.input_output'=>'output', 'Ledgers.gst_type'=>'SGST','city_id'=>$order->city_id])->first();
							$AccountingEntrieSGST = $this->Orders->AccountingEntries->newEntity();
							$AccountingEntrieSGST->ledger_id=$gstLedgerSGST->id;
							$AccountingEntrieSGST->credit=$gstAmtInsert;
							$AccountingEntrieSGST->debit=0;
							$AccountingEntrieSGST->transaction_date=date('Y-m-d');
							$AccountingEntrieSGST->city_id=$order->city_id;
							$AccountingEntrieSGST->entry_from="Web";
							$AccountingEntrieSGST->invoice_id=$order->id;  
							if($gstAmtInsert > 0){
								$this->Orders->AccountingEntries->save($AccountingEntrieSGST);
							}
							
							//Stock Entry in Item Ledgers
							$orderDetailsData = $this->Orders->Invoices->InvoiceRows->get($order_detail['id'], [
								'contain' => ['ItemVariations']
							]);
							
							$ItemLedger = $this->Orders->OrderDetails->ItemLedgers->newEntity(); 
							$ItemLedger->item_id=$orderDetailsData->item_id; 
							$ItemLedger->unit_variation_id=$orderDetailsData->item_variation->unit_variation_id;
							$ItemLedger->item_variation_id=$orderDetailsData->item_variation_id;
							$ItemLedger->transaction_date=date('Y-m-d');  
							$ItemLedger->quantity=$order_detail['quantity'];
							$ItemLedger->rate=$order_detail['rate'];
							$ItemLedger->amount=$order_detail['quantity']*$order_detail['rate'];
							$ItemLedger->sales_rate=$order_detail['rate'];
							$ItemLedger->status="Out";
							$ItemLedger->city_id=$order->city_id;
							$ItemLedger->location_id=$order->location_id;
							$ItemLedger->invoice_id=$order->id;
							$ItemLedger->invoice_row_id=$orderDetailsData->id;
							$this->Orders->OrderDetails->ItemLedgers->save($ItemLedger);
							
							
							$query = $this->Orders->Invoices->InvoiceRows->query();
							$query->update()
									->set(['is_item_cancel' => 'No'])
									->where(['id'=>$order_detail['id']])
									->execute();
						}
						
						//Update in Order
							$query = $this->Orders->Invoices->query();
							$query->update()
									->set(['discount_amount' => $NewOrder['discount_amount'],'total_amount'=>$NewOrder['total_amount'],'total_gst'=>$NewOrder['total_gst'],'grand_total'=>$NewOrder['grand_total'],'round_off'=>$NewOrder['round_off'],'delivery_charge_amount'=>$NewOrder['delivery_charge_amount']])
									->where(['id'=>$order->id])
									->execute();
						
						//Stock Up in item Variations
						$orderDetailsCancleItems = $this->Orders->Invoices->InvoiceRows->find()->where(['invoice_id'=>$order->id,'is_item_cancel'=>'Yes']);
						$datasize=sizeof($orderDetailsCancleItems->toArray());
						if($datasize > 0){
							foreach($orderDetailsCancleItems as $data){
								
								$ItemVariationData = $this->Orders->OrderDetails->ItemVariations->get($data->item_variation_id);
								$current_stock=$ItemVariationData->current_stock-$data->quantity; 
								$cs=$ItemVariationData->current_stock;
								$vs=$ItemVariationData->virtual_stock;
								$ds=$ItemVariationData->demand_stock;
								$actual_quantity=$data->quantity;
								
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
								->where(['id'=>$data->item_variation_id])
								->execute(); 
								
							}
						}
						
			}else if($order->order_type ==  "online"){ 
						
						$LedgerData = $this->Orders->Ledgers->find()->where(['Ledgers.ccavenue' =>'yes','Ledgers.city_id'=>$order->city_id])->first();
						$ccavenue_ledger_id=$LedgerData->id; 
						//pr($ccavenue_ledger_id); exit;
						if($order->grand_total == $NewOrder['grand_total']){
							
							// Ledger entry for Customer
							
							$AccountingEntrie = $this->Orders->AccountingEntries->newEntity(); 
							$AccountingEntrie->ledger_id=$ccavenue_ledger_id;
							$AccountingEntrie->debit=$order->grand_total;
							$AccountingEntrie->credit=0;
							$AccountingEntrie->transaction_date=date('Y-m-d');
							$AccountingEntrie->city_id=$order->city_id;
							$AccountingEntrie->entry_from="Web";
							$AccountingEntrie->invoice_id=$order->id;  
							$this->Orders->AccountingEntries->save($AccountingEntrie);
							
							//	Payment History
							 $OrderPaymentHistory = $this->Orders->OrderPaymentHistories->newEntity();
							 $OrderPaymentHistory->order_id=$order->order_id;
							 $OrderPaymentHistory->invoice_id=$order->id;
							 //$OrderPaymentHistory->online_amount=$order->online_amount;
							 $OrderPaymentHistory->online_amount=$order->grand_total;
							 
							 $OrderPaymentHistory->total=$order->grand_total;
							 $OrderPaymentHistory->entry_from="Invoice";
							 $this->Orders->OrderPaymentHistories->save( $OrderPaymentHistory); 
							//
						
						}else if($order->grand_total > $NewOrder['grand_total']){  
							$add_amt_in_wallet=$order->grand_total-$NewOrder['grand_total'];
							//pr($NewOrder['grand_total']); 
							//pr($add_amt_in_wallet); exit;
							// Ledger entry for Customer
							
							$AccountingEntrie = $this->Orders->AccountingEntries->newEntity(); 
							$AccountingEntrie->ledger_id=$ccavenue_ledger_id;
							$AccountingEntrie->debit=$NewOrder['grand_total'];
							$AccountingEntrie->credit=0;
							$AccountingEntrie->transaction_date=date('Y-m-d');
							$AccountingEntrie->city_id=$order->city_id;
							$AccountingEntrie->entry_from="Web";
							$AccountingEntrie->invoice_id=$order->id;  
							$this->Orders->AccountingEntries->save($AccountingEntrie);
							//Payment History
							 $OrderPaymentHistory = $this->Orders->OrderPaymentHistories->newEntity();
							// $OrderPaymentHistory->order_id=$order->order_id;
							 $OrderPaymentHistory->invoice_id=$order->id;
							 $OrderPaymentHistory->order_id=$order->order_id;
							 $OrderPaymentHistory->online_amount=$NewOrder['grand_total'];
							 $OrderPaymentHistory->total=$NewOrder['grand_total'];
							 $OrderPaymentHistory->wallet_return=$add_amt_in_wallet;
							 $OrderPaymentHistory->entry_from="Invoice";
							 $this->Orders->OrderPaymentHistories->save( $OrderPaymentHistory); 
							//
							//Add amount in wallet
							if($add_amt_in_wallet > 0){
								$wallet = $this->Orders->Wallets->newEntity(); 
								$wallet->transaction_type="Added";
								$wallet->amount_type="Return Invoice Online Amount";
								$wallet->narration="Return Invoice Online Amount";
								$wallet->add_amount=$add_amt_in_wallet;
								$wallet->city_id=$city_id;
								$wallet->customer_id=$order->customer_id;
								$wallet->invoice_id=$order->id;
								$this->Orders->Wallets->save($wallet);
							}
						}
						
						// Sales Account Entry 
							$AccountingEntrie = $this->Orders->AccountingEntries->newEntity(); 
							$AccountingEntrie->ledger_id=$order->sales_ledger_id;
							$AccountingEntrie->credit=$NewOrder['total_amount'];
							$AccountingEntrie->debit=0;
							$AccountingEntrie->transaction_date=date('Y-m-d');
							$AccountingEntrie->city_id=$order->city_id;
							$AccountingEntrie->entry_from="Web";
							$AccountingEntrie->invoice_id=$order->id; 
							$this->Orders->AccountingEntries->save($AccountingEntrie);
						
						//Delivery Charges Entry
						if($NewOrder['delivery_charge_amount'] > 0){
							$TransportLedger = $this->Orders->Ledgers->find()->where(['Ledgers.transport' =>'Receive','Ledgers.city_id'=>$order->city_id])->first();
								$AccountingEntrie1 = $this->Orders->AccountingEntries->newEntity();
								$AccountingEntrie1->ledger_id=$TransportLedger->id;
								$AccountingEntrie1->credit=$NewOrder['delivery_charge_amount'];
								$AccountingEntrie1->debit=0;
								$AccountingEntrie1->transaction_date=$order->order_date;
								$AccountingEntrie1->city_id=$order->city_id;
								$AccountingEntrie1->entry_from="Web";
								$AccountingEntrie1->invoice_id=$order->id; 
								$this->Orders->AccountingEntries->save($AccountingEntrie1);
							}
						
						//round Off Entry
						$roundOffLedger = $this->Orders->Ledgers->find()->where(['Ledgers.round_off' =>'1','Ledgers.city_id'=>$order->city_id])->first(); 
						//
						$AccountingEntrie = $this->Orders->AccountingEntries->newEntity(); 
						$AccountingEntrie->ledger_id=$roundOffLedger->id;
						if($NewOrder['round_off'] < 0){
							$AccountingEntrie->debit=$NewOrder['round_off'];
							$AccountingEntrie->credit=0;
						}else{
						$AccountingEntrie->credit=$NewOrder['round_off'];
						$AccountingEntrie->debit=0;
						}
						$AccountingEntrie->transaction_date=date('Y-m-d');
						$AccountingEntrie->city_id=$order->city_id;
						$AccountingEntrie->entry_from="Web";
						$AccountingEntrie->invoice_id=$order->id; 
						if($NewOrder['round_off'] != 0){
							$this->Orders->AccountingEntries->save($AccountingEntrie);
						}
						
				
						foreach($NewOrder['order_details'] as $order_detail){  
							$ItemData = $this->Orders->Items->find()->where(['Items.id'=>$order_detail['item_id']])->first();
							$gstAmtdata=$order_detail['gst_value']/2;
							$gstAmtInsert=round($gstAmtdata,2);
							
							$gstLedgerCGST = $this->Orders->Ledgers->find()->where(['Ledgers.gst_figure_id' =>$ItemData->gst_figure_id, 'Ledgers.input_output'=>'output', 'Ledgers.gst_type'=>'CGST','city_id'=>$order->city_id])->first();
								
							//Accounting Entries for CGST//
							$gstLedgerCGST = $this->Orders->Ledgers->find()
							->where(['Ledgers.gst_figure_id' =>$ItemData->gst_figure_id, 'Ledgers.input_output'=>'output', 'Ledgers.gst_type'=>'CGST','city_id'=>$order->city_id])->first();
							$AccountingEntrieCGST = $this->Orders->AccountingEntries->newEntity();
							$AccountingEntrieCGST->ledger_id=$gstLedgerCGST->id;
							$AccountingEntrieCGST->credit=$gstAmtInsert;
							$AccountingEntrieCGST->debit=0;
							$AccountingEntrieCGST->transaction_date=date('Y-m-d');
							$AccountingEntrieCGST->city_id=$order->city_id;
							$AccountingEntrieCGST->entry_from="Web";
							$AccountingEntrieCGST->invoice_id=$order->id; 
							if($gstAmtInsert > 0){
								$this->Orders->AccountingEntries->save($AccountingEntrieCGST);
							}
							
							//Accounting Entries for SGST//
							 $gstLedgerSGST = $this->Orders->Ledgers->find()
							->where(['Ledgers.gst_figure_id' =>$ItemData->gst_figure_id, 'Ledgers.input_output'=>'output', 'Ledgers.gst_type'=>'SGST','city_id'=>$order->city_id])->first();
							$AccountingEntrieSGST = $this->Orders->AccountingEntries->newEntity();
							$AccountingEntrieSGST->ledger_id=$gstLedgerSGST->id;
							$AccountingEntrieSGST->credit=$gstAmtInsert;
							$AccountingEntrieSGST->debit=0;
							$AccountingEntrieSGST->transaction_date=date('Y-m-d');
							$AccountingEntrieSGST->city_id=$order->city_id;
							$AccountingEntrieSGST->entry_from="Web";
							$AccountingEntrieSGST->invoice_id=$order->id;  
							if($gstAmtInsert > 0){
								$this->Orders->AccountingEntries->save($AccountingEntrieSGST);
							}
							
							//Stock Entry in Item Ledgers
							$orderDetailsData = $this->Orders->Invoices->InvoiceRows->get($order_detail['id'], [
								'contain' => ['ItemVariations']
							]);
							
							$ItemLedger = $this->Orders->OrderDetails->ItemLedgers->newEntity(); 
							$ItemLedger->item_id=$orderDetailsData->item_id; 
							$ItemLedger->unit_variation_id=$orderDetailsData->item_variation->unit_variation_id;
							$ItemLedger->item_variation_id=$orderDetailsData->item_variation_id;
							$ItemLedger->transaction_date=date('Y-m-d');  
							$ItemLedger->quantity=$order_detail['quantity'];
							$ItemLedger->rate=$order_detail['rate'];
							$ItemLedger->amount=$order_detail['quantity']*$order_detail['rate'];
							$ItemLedger->sales_rate=$order_detail['rate'];
							$ItemLedger->status="Out";
							$ItemLedger->city_id=$order->city_id;
							$ItemLedger->location_id=$order->location_id;
							$ItemLedger->invoice_id=$order->id;
							$ItemLedger->invoice_row_id=$orderDetailsData->id;
							$this->Orders->OrderDetails->ItemLedgers->save($ItemLedger);
							
							
							$query = $this->Orders->Invoices->InvoiceRows->query();
							$query->update()
									->set(['is_item_cancel' => 'No'])
									->where(['id'=>$order_detail['id']])
									->execute();
						}
						
						//Refrence Details Entry
						if($LedgerData->bill_to_bill_accounting=="yes"){
							$ReferenceDetail = $this->Orders->ReferenceDetails->newEntity(); 
							$ReferenceDetail->ledger_id=$ccavenue_ledger_id;
							$ReferenceDetail->debit=$NewOrder['grand_total'];
							$ReferenceDetail->credit=0;
							$ReferenceDetail->transaction_date=date('Y-m-d');
							$ReferenceDetail->city_id=$order->city_id;
							$ReferenceDetail->entry_from="Web";
							$ReferenceDetail->type='New Ref';
							$ReferenceDetail->ref_name=$order->ccavvenue_tracking_no;
							$ItemLedger->invoice_id=$order->id;
							$ReferenceDetail->order_id=$order->order_id;
							$this->Orders->ReferenceDetails->save($ReferenceDetail);
						}
						
						//Update in Order
							$query = $this->Orders->Invoices->query();
							$query->update()
									->set(['discount_amount' => $NewOrder['discount_amount'],'total_amount'=>$NewOrder['total_amount'],'total_gst'=>$NewOrder['total_gst'],'grand_total'=>$NewOrder['grand_total'],'round_off'=>$NewOrder['round_off'],'delivery_charge_amount'=>$NewOrder['delivery_charge_amount']])
									->where(['id'=>$order->id])
									->execute();
						
						//Stock Up in item Variations
						$orderDetailsCancleItems = $this->Orders->Invoices->InvoiceRows->find()->where(['invoice_id'=>$order->id,'is_item_cancel'=>'Yes']);
						$datasize=sizeof($orderDetailsCancleItems->toArray());
						if($datasize > 0){
							foreach($orderDetailsCancleItems as $data){
								//pr($data); exit;
							}
						}
						
			}else if($order->order_type ==  "COD"){ 
						
						$LedgerData = $this->Orders->Ledgers->find()->where(['Ledgers.cash' =>'1','Ledgers.city_id'=>$order->city_id])->first();
						$ccavenue_ledger_id=$LedgerData->id; 
						//pr($ccavenue_ledger_id); exit;
						if($order->grand_total == $NewOrder['grand_total']){
							
							// Ledger entry for Customer
							
							$AccountingEntrie = $this->Orders->AccountingEntries->newEntity(); 
							$AccountingEntrie->ledger_id=$ccavenue_ledger_id;
							$AccountingEntrie->debit=$order->grand_total;
							$AccountingEntrie->credit=0;
							$AccountingEntrie->transaction_date=date('Y-m-d');
							$AccountingEntrie->city_id=$order->city_id;
							$AccountingEntrie->entry_from="Web";
							$AccountingEntrie->invoice_id=$order->id;  
							$this->Orders->AccountingEntries->save($AccountingEntrie);
							
							//	Payment History
							 $OrderPaymentHistory = $this->Orders->OrderPaymentHistories->newEntity();
							 $OrderPaymentHistory->order_id=$order->order_id;
							 $OrderPaymentHistory->invoice_id=$order->id;
							 //$OrderPaymentHistory->online_amount=$order->online_amount;
							 $OrderPaymentHistory->cod_amount=$order->grand_total;
							 
							 $OrderPaymentHistory->total=$order->grand_total;
							 $OrderPaymentHistory->entry_from="Invoice";
							 $this->Orders->OrderPaymentHistories->save( $OrderPaymentHistory); 
							//
						
						}else if($order->grand_total > $NewOrder['grand_total']){  
							$add_amt_in_wallet=$order->grand_total-$NewOrder['grand_total'];
							//pr($NewOrder['grand_total']); 
							//pr($add_amt_in_wallet); exit;
							// Ledger entry for Customer
							
							$AccountingEntrie = $this->Orders->AccountingEntries->newEntity(); 
							$AccountingEntrie->ledger_id=$ccavenue_ledger_id;
							$AccountingEntrie->debit=$NewOrder['grand_total'];
							$AccountingEntrie->credit=0;
							$AccountingEntrie->transaction_date=date('Y-m-d');
							$AccountingEntrie->city_id=$order->city_id;
							$AccountingEntrie->entry_from="Web";
							$AccountingEntrie->invoice_id=$order->id;  
							$this->Orders->AccountingEntries->save($AccountingEntrie);
							//Payment History
							 $OrderPaymentHistory = $this->Orders->OrderPaymentHistories->newEntity();
							// $OrderPaymentHistory->order_id=$order->order_id;
							 $OrderPaymentHistory->invoice_id=$order->id;
							 $OrderPaymentHistory->order_id=$order->order_id;
							 $OrderPaymentHistory->cod_amount=$NewOrder['grand_total'];
							 $OrderPaymentHistory->total=$NewOrder['grand_total'];
							// $OrderPaymentHistory->wallet_return=$add_amt_in_wallet;
							 $OrderPaymentHistory->entry_from="Invoice";
							 $this->Orders->OrderPaymentHistories->save( $OrderPaymentHistory); 
							//
							//Add amount in wallet
							if($add_amt_in_wallet > 0){
								$wallet = $this->Orders->Wallets->newEntity(); 
								$wallet->transaction_type="Added";
								$wallet->amount_type="Return Invoice Online Amount";
								$wallet->narration="Return Invoice Online Amount";
								$wallet->add_amount=$add_amt_in_wallet;
								$wallet->city_id=$city_id;
								$wallet->customer_id=$order->customer_id;
								$wallet->invoice_id=$order->id;
								$this->Orders->Wallets->save($wallet);
							}
						}
						
						// Sales Account Entry 
							$AccountingEntrie = $this->Orders->AccountingEntries->newEntity(); 
							$AccountingEntrie->ledger_id=$order->sales_ledger_id;
							$AccountingEntrie->credit=$NewOrder['total_amount'];
							$AccountingEntrie->debit=0;
							$AccountingEntrie->transaction_date=date('Y-m-d');
							$AccountingEntrie->city_id=$order->city_id;
							$AccountingEntrie->entry_from="Web";
							$AccountingEntrie->invoice_id=$order->id; 
							$this->Orders->AccountingEntries->save($AccountingEntrie);
						
						//Delivery Charges Entry
						if($NewOrder['delivery_charge_amount'] > 0){
							$TransportLedger = $this->Orders->Ledgers->find()->where(['Ledgers.transport' =>'Receive','Ledgers.city_id'=>$order->city_id])->first();
								$AccountingEntrie1 = $this->Orders->AccountingEntries->newEntity();
								$AccountingEntrie1->ledger_id=$TransportLedger->id;
								$AccountingEntrie1->credit=$NewOrder['delivery_charge_amount'];
								$AccountingEntrie1->debit=0;
								$AccountingEntrie1->transaction_date=$order->order_date;
								$AccountingEntrie1->city_id=$order->city_id;
								$AccountingEntrie1->entry_from="Web";
								$AccountingEntrie1->invoice_id=$order->id; 
								$this->Orders->AccountingEntries->save($AccountingEntrie1);
							}
						
						//round Off Entry
						$roundOffLedger = $this->Orders->Ledgers->find()->where(['Ledgers.round_off' =>'1','Ledgers.city_id'=>$order->city_id])->first(); 
						//
						$AccountingEntrie = $this->Orders->AccountingEntries->newEntity(); 
						$AccountingEntrie->ledger_id=$roundOffLedger->id;
						if($NewOrder['round_off'] < 0){
							$AccountingEntrie->debit=$NewOrder['round_off'];
							$AccountingEntrie->credit=0;
						}else{
						$AccountingEntrie->credit=$NewOrder['round_off'];
						$AccountingEntrie->debit=0;
						}
						$AccountingEntrie->transaction_date=date('Y-m-d');
						$AccountingEntrie->city_id=$order->city_id;
						$AccountingEntrie->entry_from="Web";
						$AccountingEntrie->invoice_id=$order->id; 
						if($NewOrder['round_off'] != 0){
							$this->Orders->AccountingEntries->save($AccountingEntrie);
						}
						
				
						foreach($NewOrder['order_details'] as $order_detail){  
							$ItemData = $this->Orders->Items->find()->where(['Items.id'=>$order_detail['item_id']])->first();
							$gstAmtdata=$order_detail['gst_value']/2;
							$gstAmtInsert=round($gstAmtdata,2);
							
							$gstLedgerCGST = $this->Orders->Ledgers->find()->where(['Ledgers.gst_figure_id' =>$ItemData->gst_figure_id, 'Ledgers.input_output'=>'output', 'Ledgers.gst_type'=>'CGST','city_id'=>$order->city_id])->first();
								
							//Accounting Entries for CGST//
							$gstLedgerCGST = $this->Orders->Ledgers->find()
							->where(['Ledgers.gst_figure_id' =>$ItemData->gst_figure_id, 'Ledgers.input_output'=>'output', 'Ledgers.gst_type'=>'CGST','city_id'=>$order->city_id])->first();
							$AccountingEntrieCGST = $this->Orders->AccountingEntries->newEntity();
							$AccountingEntrieCGST->ledger_id=$gstLedgerCGST->id;
							$AccountingEntrieCGST->credit=$gstAmtInsert;
							$AccountingEntrieCGST->debit=0;
							$AccountingEntrieCGST->transaction_date=date('Y-m-d');
							$AccountingEntrieCGST->city_id=$order->city_id;
							$AccountingEntrieCGST->entry_from="Web";
							$AccountingEntrieCGST->invoice_id=$order->id; 
							if($gstAmtInsert > 0){
								$this->Orders->AccountingEntries->save($AccountingEntrieCGST);
							}
							
							//Accounting Entries for SGST//
							 $gstLedgerSGST = $this->Orders->Ledgers->find()
							->where(['Ledgers.gst_figure_id' =>$ItemData->gst_figure_id, 'Ledgers.input_output'=>'output', 'Ledgers.gst_type'=>'SGST','city_id'=>$order->city_id])->first();
							$AccountingEntrieSGST = $this->Orders->AccountingEntries->newEntity();
							$AccountingEntrieSGST->ledger_id=$gstLedgerSGST->id;
							$AccountingEntrieSGST->credit=$gstAmtInsert;
							$AccountingEntrieSGST->debit=0;
							$AccountingEntrieSGST->transaction_date=date('Y-m-d');
							$AccountingEntrieSGST->city_id=$order->city_id;
							$AccountingEntrieSGST->entry_from="Web";
							$AccountingEntrieSGST->invoice_id=$order->id;  
							if($gstAmtInsert > 0){
								$this->Orders->AccountingEntries->save($AccountingEntrieSGST);
							}
							
							//Stock Entry in Item Ledgers
							$orderDetailsData = $this->Orders->Invoices->InvoiceRows->get($order_detail['id'], [
								'contain' => ['ItemVariations']
							]);
							
							$ItemLedger = $this->Orders->OrderDetails->ItemLedgers->newEntity(); 
							$ItemLedger->item_id=$orderDetailsData->item_id; 
							$ItemLedger->unit_variation_id=$orderDetailsData->item_variation->unit_variation_id;
							$ItemLedger->item_variation_id=$orderDetailsData->item_variation_id;
							$ItemLedger->transaction_date=date('Y-m-d');  
							$ItemLedger->quantity=$order_detail['quantity'];
							$ItemLedger->rate=$order_detail['rate'];
							$ItemLedger->amount=$order_detail['quantity']*$order_detail['rate'];
							$ItemLedger->sales_rate=$order_detail['rate'];
							$ItemLedger->status="Out";
							$ItemLedger->city_id=$order->city_id;
							$ItemLedger->location_id=$order->location_id;
							$ItemLedger->invoice_id=$order->id;
							$ItemLedger->invoice_row_id=$orderDetailsData->id;
							$this->Orders->OrderDetails->ItemLedgers->save($ItemLedger);
							
							
							$query = $this->Orders->Invoices->InvoiceRows->query();
							$query->update()
									->set(['is_item_cancel' => 'No'])
									->where(['id'=>$order_detail['id']])
									->execute();
						}
						
						
						//Update in Order
							$query = $this->Orders->Invoices->query();
							$query->update()
									->set(['discount_amount' => $NewOrder['discount_amount'],'total_amount'=>$NewOrder['total_amount'],'total_gst'=>$NewOrder['total_gst'],'grand_total'=>$NewOrder['grand_total'],'round_off'=>$NewOrder['round_off'],'delivery_charge_amount'=>$NewOrder['delivery_charge_amount']])
									->where(['id'=>$order->id])
									->execute();
						
						//Stock Up in item Variations
						$orderDetailsCancleItems = $this->Orders->Invoices->InvoiceRows->find()->where(['invoice_id'=>$order->id,'is_item_cancel'=>'Yes']);
						$datasize=sizeof($orderDetailsCancleItems->toArray());
						if($datasize > 0){
							foreach($orderDetailsCancleItems as $data){
								//pr($data); exit;
							}
						}
						
			}else if($order->order_type ==  "Wallet/Online"){ 
				exit;
			}else if($order->order_type ==  "Credit"){ 
						
						$LedgerData = $this->Orders->Ledgers->get($order->party_ledger_id);
						//pr($LedgerData->bill_to_bill_accounting); exit;
						// Cash Account Entry 
						$AccountingEntrie = $this->Orders->AccountingEntries->newEntity(); 
						$AccountingEntrie->ledger_id=$order->party_ledger_id;
						$AccountingEntrie->debit=$NewOrder['grand_total'];
						$AccountingEntrie->credit=0;
						$AccountingEntrie->transaction_date=date('Y-m-d');
						$AccountingEntrie->city_id=$order->city_id;
						$AccountingEntrie->entry_from="Web";
						$AccountingEntrie->invoice_id=$order->id;  
						$this->Orders->AccountingEntries->save($AccountingEntrie);
						
						// Sales Account Entry 
						$AccountingEntrie = $this->Orders->AccountingEntries->newEntity(); 
						$AccountingEntrie->ledger_id=$order->sales_ledger_id;
						$AccountingEntrie->credit=$NewOrder['total_amount'];
						$AccountingEntrie->debit=0;
						$AccountingEntrie->transaction_date=date('Y-m-d');
						$AccountingEntrie->city_id=$order->city_id;
						$AccountingEntrie->entry_from="Web";
						$AccountingEntrie->invoice_id=$order->id; 
						$this->Orders->AccountingEntries->save($AccountingEntrie);
						
						//Delivery Charges Entry
						if($order->delivery_charge_amount > 0){
							$TransportLedger = $this->Orders->Ledgers->find()->where(['Ledgers.transport' =>'Receive','Ledgers.city_id'=>$order->city_id])->first();
								$AccountingEntrie1 = $this->Orders->AccountingEntries->newEntity();
								$AccountingEntrie1->ledger_id=$TransportLedger->id;
								$AccountingEntrie1->credit=$order->delivery_charge_amount;
								$AccountingEntrie1->debit=0;
								$AccountingEntrie1->transaction_date=$order->order_date;
								$AccountingEntrie1->city_id=$order->city_id;
								$AccountingEntrie1->entry_from="Web";
								$AccountingEntrie1->invoice_id=$order->id; 
								$this->Orders->AccountingEntries->save($AccountingEntrie1);
							}
						
						
						//round Off Entry
						$roundOffLedger = $this->Orders->Ledgers->find()->where(['Ledgers.round_off' =>'1','Ledgers.city_id'=>$order->city_id])->first(); 
						//
						$AccountingEntrie = $this->Orders->AccountingEntries->newEntity(); 
						$AccountingEntrie->ledger_id=$roundOffLedger->id;
						if($NewOrder['round_off'] < 0){
							$AccountingEntrie->debit=$NewOrder['round_off'];
							$AccountingEntrie->credit=0;
						}else{
						$AccountingEntrie->credit=$NewOrder['round_off'];
						$AccountingEntrie->debit=0;
						}
						$AccountingEntrie->transaction_date=date('Y-m-d');
						$AccountingEntrie->city_id=$order->city_id;
						$AccountingEntrie->entry_from="Web";
						$AccountingEntrie->invoice_id=$order->id; 
						if($NewOrder['round_off'] != 0){
							$this->Orders->AccountingEntries->save($AccountingEntrie);
						}
						
				
						foreach($NewOrder['order_details'] as $order_detail){  
							$ItemData = $this->Orders->Items->find()->where(['Items.id'=>$order_detail['item_id']])->first();
							$gstAmtdata=$order_detail['gst_value']/2;
							$gstAmtInsert=round($gstAmtdata,2);
							
							$gstLedgerCGST = $this->Orders->Ledgers->find()->where(['Ledgers.gst_figure_id' =>$ItemData->gst_figure_id, 'Ledgers.input_output'=>'output', 'Ledgers.gst_type'=>'CGST','city_id'=>$order->city_id])->first();
								
							//Accounting Entries for CGST//
							$gstLedgerCGST = $this->Orders->Ledgers->find()
							->where(['Ledgers.gst_figure_id' =>$ItemData->gst_figure_id, 'Ledgers.input_output'=>'output', 'Ledgers.gst_type'=>'CGST','city_id'=>$order->city_id])->first();
							$AccountingEntrieCGST = $this->Orders->AccountingEntries->newEntity();
							$AccountingEntrieCGST->ledger_id=$gstLedgerCGST->id;
							$AccountingEntrieCGST->credit=$gstAmtInsert;
							$AccountingEntrieCGST->debit=0;
							$AccountingEntrieCGST->transaction_date=date('Y-m-d');
							$AccountingEntrieCGST->city_id=$order->city_id;
							$AccountingEntrieCGST->entry_from="Web";
							$AccountingEntrieCGST->invoice_id=$order->id; 
							if($gstAmtInsert > 0){
								$this->Orders->AccountingEntries->save($AccountingEntrieCGST);
							}
							
							//Accounting Entries for SGST//
							 $gstLedgerSGST = $this->Orders->Ledgers->find()
							->where(['Ledgers.gst_figure_id' =>$ItemData->gst_figure_id, 'Ledgers.input_output'=>'output', 'Ledgers.gst_type'=>'SGST','city_id'=>$order->city_id])->first();
							$AccountingEntrieSGST = $this->Orders->AccountingEntries->newEntity();
							$AccountingEntrieSGST->ledger_id=$gstLedgerSGST->id;
							$AccountingEntrieSGST->credit=$gstAmtInsert;
							$AccountingEntrieSGST->debit=0;
							$AccountingEntrieSGST->transaction_date=date('Y-m-d');
							$AccountingEntrieSGST->city_id=$order->city_id;
							$AccountingEntrieSGST->entry_from="Web";
							$AccountingEntrieSGST->invoice_id=$order->id;  
							if($gstAmtInsert > 0){
								$this->Orders->AccountingEntries->save($AccountingEntrieSGST);
							}
							
							//Stock Entry in Item Ledgers
							$orderDetailsData = $this->Orders->OrderDetails->get($order_detail['id'], [
								'contain' => ['ItemVariations']
							]);
							
							$ItemLedger = $this->Orders->OrderDetails->ItemLedgers->newEntity(); 
							$ItemLedger->item_id=$orderDetailsData->item_id; 
							$ItemLedger->unit_variation_id=$orderDetailsData->item_variation->unit_variation_id;
							$ItemLedger->item_variation_id=$orderDetailsData->item_variation_id;
							$ItemLedger->transaction_date=date('Y-m-d');  
							$ItemLedger->quantity=$order_detail['quantity'];
							$ItemLedger->rate=$order_detail['rate'];
							$ItemLedger->amount=$order_detail['quantity']*$order_detail['rate'];
							$ItemLedger->sales_rate=$order_detail['rate'];
							$ItemLedger->status="Out";
							$ItemLedger->city_id=$order->city_id;
							$ItemLedger->location_id=$order->location_id;
							$ItemLedger->invoice_id=$order->id;
							$ItemLedger->invoice_row_id=$orderDetailsData->id;
							$this->Orders->OrderDetails->ItemLedgers->save($ItemLedger);
							
							
							$query = $this->Orders->OrderDetails->query();
							$query->update()
									->set(['is_item_cancel' => 'No'])
									->where(['id'=>$order_detail['id']])
									->execute();
						}
						
						
						//Refrence Details Entry
						if($LedgerData->bill_to_bill_accounting=="yes"){
							$ReferenceDetail = $this->Orders->ReferenceDetails->newEntity(); 
							$ReferenceDetail->ledger_id=$order->party_ledger_id;
							$ReferenceDetail->debit=$order->grand_total;
							$ReferenceDetail->credit=0;
							$ReferenceDetail->transaction_date=date('Y-m-d');
							$ReferenceDetail->city_id=$order->city_id;
							$ReferenceDetail->entry_from="Web";
							$ReferenceDetail->type='New Ref';
							$ReferenceDetail->ref_name=$order->invoice_no;
							$ReferenceDetail->order_id=$order->order_id;
							$ReferenceDetail->invoice_id=$order->id;
							$this->Orders->ReferenceDetails->save($ReferenceDetail);
						}
						
							
						
						//Update in Order
							$query = $this->Orders->Invoices->query();
							$query->update()
									->set(['discount_amount' => $NewOrder['discount_amount'],'total_amount'=>$NewOrder['total_amount'],'total_gst'=>$NewOrder['total_gst'],'grand_total'=>$NewOrder['grand_total'],'round_off'=>$NewOrder['round_off'],'delivery_charge_amount'=>$NewOrder['delivery_charge_amount']])
									->where(['id'=>$order->id])
									->execute();
						
						//Stock Up in item Variations
						$orderDetailsCancleItems = $this->Orders->Invoices->InvoiceRows->find()->where(['invoice_id'=>$order->id,'is_item_cancel'=>'Yes']);
						$datasize=sizeof($orderDetailsCancleItems->toArray());
						if($datasize > 0){
							foreach($orderDetailsCancleItems as $data){
								//pr($data); exit;
							}
						}
			}
			
			
			$query = $this->Orders->Invoices->query();
			$query->update()
					->set(['order_status' => 'Delivered'])
					->where(['id'=>$order->id])
					->execute();
			
			
			//Main Order_Status Change
			$totalInvoice=$this->Orders->Invoices->find()->where(['Invoices.order_id'=>$NewOrder['order_id']])->toArray();
			$completeInvoice=$this->Orders->Invoices->find()->where(['Invoices.order_id'=>$NewOrder['order_id'],'Invoices.order_status'=>'Delivered'])->orWhere(['Invoices.order_status'=>'Cancel','Invoices.order_id'=>$NewOrder['order_id']])->toArray();
			$totalInvoice=(sizeof($totalInvoice)); 
			$completeInvoice=(sizeof($completeInvoice));
			if($totalInvoice==$completeInvoice){
				$query = $this->Orders->query();
				$query->update()
					->set(['order_status' => 'Delivered'])
					->where(['id'=>$NewOrder['order_id']])
					->execute();
			}
						
			$this->Flash->success(__('The order has been Deliverd.'));
             return $this->redirect(['action' => 'invoiceManageOrder']);
			
			
	 
		}	
		if(!empty($status)){
			
			$order_data=$this->Orders->Invoices->find()->where(['Invoices.order_status'=>$status])->order(['Invoices.id'=>'DESC'])->contain(['SellerLedgers','PartyLedgers','Locations','DeliveryTimes','Customers','CustomerAddressesLeft','Drivers'])->where(['Invoices.city_id'=>$city_id]);
		}else{
			
			$order_data=$this->Orders->Invoices->find()->order(['Invoices.id'=>'DESC'])->contain(['SellerLedgers','PartyLedgers','Locations','DeliveryTimes','Customers','CustomerAddressesLeft','Drivers'])->where(['Invoices.city_id'=>$city_id]);
		}
		
		$drivers=$this->Orders->Invoices->Drivers->find('list')->where(['Drivers.status'=>'Active'])->contain(['Locations'=>function ($q) use($city_id){
							return $q->where(['Locations.city_id'=>$city_id]);
						}]);
		$cancelReasons=$this->Orders->Invoices->CancelReasons->find('list')->where(['CancelReasons.city_id'=>$city_id,'CancelReasons.status'=>'Active']);
		 
        $orders = $this->paginate($order_data);
		//pr( $orders->toArray()); exit;
		$paginate_limit=$this->paginate['limit'];
        $this->set(compact('orders','paginate_limit','status','drivers','cancelReasons'));
    }
	
    /**
     * View method
     *
     * @param string|null $id Order id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function sellerOrderList($id = null)
    {
		$this->viewBuilder()->layout('admin_portal');
		$seller_id=$this->Auth->User('id');
		$user_role=$this->Auth->User('user_role');
		$location_id=$this->Auth->User('location_id');
		
		/* $Orders = $this->Orders->find()->contain(['OrderDetails'=>['ItemVariations'=> function($q) use($seller_id) {
				return $q->where(['ItemVariations.seller_id'=>$seller_id]);
		}]])->toArray(); */
		/* $Orders = $this->Orders->find()->contain(['OrderDetails'])->matching('OrderDetails.ItemVariations' , function($q) use($seller_id){
			return $q->where(['ItemVariations.seller_id'=>6]);
		})->toArray(); */
		
		 $Orders = $this->Orders->find()
            ->matching('OrderDetails.ItemVariations', function ($q) use($seller_id) {
                return $q->where(['ItemVariations.seller_id'=>$seller_id]);
            })->toArray();
		 
		
	}
	
	
	public function orderDeliver($id = null)
    { 
		$this->viewBuilder()->layout('admin_portal');
		$user_id=$this->Auth->User('id');
		$financial_year_id=$this->Auth->User('financial_year_id');
		$city_id=$this->Auth->User('city_id'); 
		$location_id=$this->Auth->User('location_id'); 
		$state_id=$this->Auth->User('state_id'); 
		$this->viewBuilder()->layout('admin_portal');
        $order = $this->Orders->newEntity();
		$CityData = $this->Orders->Cities->get($city_id);
		$StateData = $this->Orders->Cities->States->get($CityData->state_id);
		$today_date=date("Y-m-d");
		$orderdate = explode('-', $today_date);
		$year = $orderdate[0];
		$month   = $orderdate[1];
		$day  = $orderdate[2];
		$order = $this->Orders->get($id, [
            'contain' => ['OrderDetails'=>['ItemVariations'=>['Items'=>['GstFigures']]]]
        ]);
		
		
		$Totalsellers=[];
		$Jainsellers=[];
		$sellersum=0;
		foreach($order->order_details as $order_detail){ 
			if($order_detail->item_variation->seller_id > 0){ 
				$seller_id=$order_detail->item_variation->seller_id; 
				$Totalsellers[$seller_id][]=$order_detail;
				
			}else
			{
				$Jainsellers[0][]=$order_detail;
				
			}
		}
		
		$totalSellerCount=(sizeof($Jainsellers)+sizeof($Totalsellers));
		//pr($Jainsellers);
		//pr($Totalsellers);
		//pr($totalSellerCount); exit;
		foreach($Totalsellers as $key=>$Totalseller){
			
			$Voucher_no = $this->Orders->Challans->find()->select(['voucher_no'])->where(['Challans.city_id'=>$city_id,'Challans.financial_year_id'=>$financial_year_id])->order(['voucher_no' => 'DESC'])->first();
			//pr($Voucher_no); exit;
			if($Voucher_no){$voucher_no=$Voucher_no->voucher_no+1;}
			else{$voucher_no=1;}
			
			$vn=str_pad($voucher_no, 7, '0', STR_PAD_LEFT);
			$order_no='CH/'.$vn;
			
			//$order_no=$CityData->alise_name.'/CH/'.$voucher_no;
			//$order_no=$StateData->alias_name.'/'.$order_no;
			
			$sellerLedgerData = $this->Orders->AccountingEntries->Ledgers->find()->where(['seller_id'=>$key])->first();
			
			$Invoice = $this->Orders->Challans->newEntity(); 
			$Invoice->seller_id=$key;
			$Invoice->order_id=$id;
			$Invoice->location_id=$order->location_id;
			$Invoice->customer_address_id=$order->customer_address_id;
			$Invoice->voucher_no=$voucher_no;
			$Invoice->invoice_no=$order_no;
			$Invoice->seller_name=$sellerLedgerData->name;
			$Invoice->order_type=$order->order_type;
			$Invoice->financial_year_id=$financial_year_id;
			$Invoice->city_id=$order->city_id;
			$Invoice->sales_ledger_id=$order->sales_ledger_id;
			$Invoice->party_ledger_id=$order->party_ledger_id;
			$Invoice->customer_id=$order->customer_id;
			//$Invoice->driver_id=$order->driver_id;
			$Invoice->address=$order->address;
			$Invoice->promotion_detail_id=$order->promotion_detail_id;
			$Invoice->ccavvenue_tracking_no=$order->ccavvenue_tracking_no;
			$Invoice->order_type=$order->order_type;
			$Invoice->order_date=$order->order_date;
			$Invoice->transaction_date=$order->order_date;
			$Invoice->order_status=$order->order_status;
			$Invoice->where_challan='Web';
			$Invoice->delivery_charge_amount=@$order->delivery_charge_amount/$totalSellerCount; 
			//pr($Invoice); exit;
			if($this->Orders->Challans->save($Invoice)){
				
			}else{
				
			}
			$total_promo_amount=0;
			$total_discount_amount=0;
			$total_taxable=0;
			$total_gst=0;
			$grand_total=0;
			foreach($Totalseller as $data){  
					$InvoiceRow = $this->Orders->Challans->ChallanRows->newEntity(); 
					$InvoiceRow->challan_id=$Invoice->id;
					$InvoiceRow->order_detail_id=$data->id;
					$InvoiceRow->item_id=$data->item_id;
					$InvoiceRow->item_variation_id=$data->item_variation_id;
					$InvoiceRow->combo_offer_id=0;
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
					$this->Orders->Challans->ChallanRows->save($InvoiceRow);
					
					$total_discount_amount+=$data->discount_amount;
					$total_promo_amount+=$data->promo_amount;
					$total_taxable+=$data->taxable_value;
					$total_gst+=$data->gst_value;
					$grand_total+=$data->net_amount;
			}
			
			
			$after_round_of=round($grand_total);
			$round_off=0;
			if($after_round_of!=$grand_total){
				$round_off=$after_round_of-$grand_total;
			}
			
			$round_off=$round_off;
			$grand_total=$after_round_of;
			
			
			$query = $this->Orders->Challans->query();
			$query->update()
					->set(['grand_total' => $after_round_of,'discount_amount' => $total_discount_amount,'delivery_charge_amount' => $Invoice->delivery_charge_amount,'total_gst' => $total_gst,'total_amount' => $total_taxable,'round_off' => $round_off,'pay_amount' => $after_round_of+$Invoice->delivery_charge_amount])
					->where(['id'=>$Invoice->id])
					->execute();
		}
		
		foreach($Jainsellers as $key=>$Jainseller){
			$Voucher_no = $this->Orders->Challans->find()->select(['voucher_no'])->where(['Challans.city_id'=>$city_id,'Challans.financial_year_id'=>$financial_year_id])->order(['voucher_no' => 'DESC'])->first();
			if($Voucher_no){$voucher_no=$Voucher_no->voucher_no+1;}
			else{$voucher_no=1;}
			//$order_no=$CityData->alise_name.'/CH/'.$voucher_no;
			//$order_no=$StateData->alias_name.'/'.$order_no;
			
			$vn=str_pad($voucher_no, 7, '0', STR_PAD_LEFT);
			$order_no='CH/'.$vn;
			
			$Invoice = $this->Orders->Challans->newEntity(); 
			$Invoice->seller_id=NULL;
			$Invoice->order_id=$id;
			$Invoice->voucher_no=$voucher_no;
			$Invoice->invoice_no=$order_no;
			$Invoice->seller_name="JainThela";
			$Invoice->order_type=$order->order_type;
			$Invoice->financial_year_id=$financial_year_id;
			$Invoice->city_id=$order->city_id;
			//$Invoice->driver_id=$order->driver_id;
			$Invoice->sales_ledger_id=$order->sales_ledger_id;
			$Invoice->party_ledger_id=$order->party_ledger_id;
			$Invoice->customer_id=$order->customer_id;
			//$Invoice->driver_id=$order->driver_id;
			$Invoice->address=$order->address;
			$Invoice->promotion_detail_id=$order->promotion_detail_id;
			$Invoice->ccavvenue_tracking_no=$order->ccavvenue_tracking_no;
			$Invoice->order_type=$order->order_type;
			$Invoice->order_date=$order->order_date;
			$Invoice->order_date=$order->order_date;
			$Invoice->transaction_date=$order->order_date;
			$Invoice->order_status=$order->order_status;
			$Invoice->delivery_charge_amount=@$order->delivery_charge_amount/$totalSellerCount; 
			$Invoice->location_id=$order->location_id;
			$Invoice->delivery_date=$order->delivery_date;
			$Invoice->delivery_time_id=$order->delivery_time_id;
			$Invoice->delivery_time_sloat=$order->delivery_time_sloat;
			$Invoice->where_challan='Web';
			$Invoice->customer_address_id=$order->customer_address_id; //pr($Invoice); exit;
			if($this->Orders->Challans->save($Invoice)){
				
			}else{
				
			}
			$total_promo_amount=0;
			$total_discount_amount=0;
			$total_taxable=0;
			$total_gst=0;
			$grand_total=0;
			foreach($Jainseller as $data){ 
					$InvoiceRow = $this->Orders->Challans->ChallanRows->newEntity(); 
					$InvoiceRow->challan_id=$Invoice->id;
					$InvoiceRow->order_detail_id=$data->id;
					$InvoiceRow->item_id=$data->item_id;
					$InvoiceRow->item_variation_id=$data->item_variation_id;
					$InvoiceRow->combo_offer_id=0;
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
					$this->Orders->Challans->ChallanRows->save($InvoiceRow); 
					$total_discount_amount+=$data->discount_amount;
					$total_promo_amount+=$data->promo_amount;
					$total_taxable+=$data->taxable_value;
					$total_gst+=$data->gst_value;
					$grand_total+=$data->net_amount;
			}
			$after_round_of=round($grand_total);
			$round_off=0;
			if($after_round_of!=$grand_total){
				$round_off=$after_round_of-$grand_total;
			}
			
			$round_off=$round_off;
			$grand_total=$after_round_of;
			
			
			$query = $this->Orders->Challans->query();
			$query->update()
					->set(['grand_total' => $after_round_of,'discount_amount' =>@$total_discount_amount+@$total_promo_amount,'delivery_charge_amount' => $Invoice->delivery_charge_amount,'total_gst' => $total_gst,'total_amount' => $total_taxable,'round_off' => $round_off,'pay_amount' => $after_round_of+$Invoice->delivery_charge_amount])
					->where(['id'=>$Invoice->id])
					->execute();
		}
		
		//	Payment History
		 $OrderPaymentHistory = $this->Orders->OrderPaymentHistories->newEntity();
		 $OrderPaymentHistory->order_id=$order->id;
		 $OrderPaymentHistory->online_amount=$order->online_amount;
		 $OrderPaymentHistory->wallet_amount=$order->amount_from_wallet;
		 if($order->order_type=="COD"){
			$OrderPaymentHistory->cod_amount=$order->pay_amount;
		 }
		 $OrderPaymentHistory->total=$order->pay_amount;
		 $OrderPaymentHistory->entry_from="Order";
		 $this->Orders->OrderPaymentHistories->save( $OrderPaymentHistory); 
		//
		 
        return $this->redirect(['action' => 'index']);
	}
	public function checkSellerStock($seller_id = null,$item_id = null,$item_variation_id = null)
    {
		$city_id=$this->Auth->User('city_id');
		$location_id=$this->Auth->User('location_id'); 
		
		$Item = $this->Orders->OrderDetails->ItemVariations->Items->get($item_id); 
		$StockInHand=0;
		if($Item->item_maintain_by=="itemwise"){
			$StockInHand=$this->sellerStockItemWiseReport($seller_id ,$item_id);
			
		}else{
			$StockInHand=$this->sellerStockItemVariationWiseReport($seller_id ,$item_id,$item_variation_id);
		}
		return $StockInHand;
			
	}
	
	public function addSalesInvoice($id = null)
    { 	
	
		$order = $this->Orders->get($id, [
            'contain' => [ 'OrderDetails'=>['ItemVariations'=>['Items']]]
        ]);
		pr($order);
		//echo "addSalesInvoice";
		exit;
	}
	
	public function confirm($id = null)
    {
		
		$ids = $this->EncryptingDecrypting->decryptData($id);
		
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id'); 
		$user_type =$this->Auth->User('user_type');
		$state_id=$this->Auth->User('state_id'); 
		
		$this->viewBuilder()->layout('pdf_layout');	
		
        $order = $this->Orders->newEntity();
		$CityData = $this->Orders->Cities->get($city_id);
		$StateData = $this->Orders->Cities->States->get($CityData->state_id);
	 
		$this->loadmodel('SalesOrders');
		$order=$this->Orders->find()->where(['Orders.id'=>$ids])->contain(['DeliveryTimes','OrderDetails'=>['ItemVariations'=>['ItemVariationMasters','Items','UnitVariations'=>['Units']]], 'Customers'=>['CustomerAddresses']])->first();
		// pr($order); exit;
		$company_details=$this->Orders->Companies->find()->where(['Companies.city_id'=>$city_id])->first();
        $this->set(compact('ids', 'sales_orders', 'order', 'locations', 'customers', 'drivers', 'customerAddresses', 'promotionDetails', 'deliveryCharges', 'deliveryTimes', 'cancelReasons','order_no','partyOptions','Accountledgers','items','company_details','ids'));
    }
	public function Pdf($id = null)
    {
		$this->viewBuilder()->layout('');
		$id = $this->EncryptingDecrypting->decryptData($id);
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id'); 
		$user_type =$this->Auth->User('user_type');
		$state_id=$this->Auth->User('state_id'); 
		$Orders=$this->Orders->find()->where(['Orders.id'=>$id])->contain(['OrderDetails'=>['ItemVariations'=>['ItemVariationMasters','Items','UnitVariations'=>['Units']]], 'Customers'=>['CustomerAddresses']])->first();
		//pr($Orders); exit;
		$company_details=$this->Orders->Companies->find()->where(['Companies.city_id'=>$city_id])->first();
        $this->set(compact('ids', 'sales_orders', 'Orders', 'locations', 'customers', 'drivers', 'customerAddresses', 'promotionDetails', 'deliveryCharges', 'deliveryTimes', 'cancelReasons','order_no','partyOptions','Accountledgers','items','company_details','id'));
	}
	
	
	public function pdfOrder($id = null)
    {
		$id=$this->request->query('id');
		$detail_data=$this->Orders->get($id,['contain'=>['Cities'=>['States']]]);
		$city_id=$detail_data->city_id;
		$state_id=$detail_data->city->state_id;	
		$this->viewBuilder()->layout(''); 		 
		$cities=$this->Orders->Cities->get($city_id);
		$states=$this->Orders->Cities->States->get($state_id);
		$Orders=$this->Orders->find()->where(['Orders.id'=>$id])->contain(['OrderDetails'=> function($q){
			return $q->contain(['ItemVariations'=>['ItemVariationMasters','Items','UnitVariations'=>['Units']]])
			->where(['OrderDetails.item_status !=' => 'Cancel']);
		} , 'Customers'=>['CustomerAddresses']])->first();
		 
		$company_details=$this->Orders->Companies->find()->where(['Companies.city_id'=>$city_id,'Companies.status'=>'Active'])->first();
        $this->set(compact('ids', 'sales_orders', 'Orders', 'locations', 'customers', 'drivers', 'customerAddresses', 'promotionDetails', 'deliveryCharges', 'deliveryTimes', 'cancelReasons','order_no','partyOptions','Accountledgers','items','company_details','id','cities', 'states', 'invoices'));
	}
	
	
	
	public function Pdf1($id = null,$invc_id =null)
    {
		
		$this->viewBuilder()->layout('');
		$id = $this->EncryptingDecrypting->decryptData($id);
		//$invoice_id = $this->EncryptingDecrypting->decryptData($invc_id);
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id'); 
		$user_type =$this->Auth->User('user_type');
		$state_id=$this->Auth->User('state_id'); 
		$cities=$this->Orders->Cities->get($city_id);
		$states=$this->Orders->Cities->States->get($state_id);
		$Orders=$this->Orders->find()->where(['Orders.id'=>$id])->contain(['OrderDetails'=>['ItemVariations'=>['ItemVariationMasters','Items','UnitVariations'=>['Units']]], 'Customers'=>['CustomerAddresses']])->first();
		 
		//$invoices=$this->Orders->Invoices->find()->where(['Invoices.id'=>$invoice_id])->contain(['Drivers','DeliveryTimes','InvoiceRows'=>['ItemVariations'=>['ItemVariationMasters','Items','UnitVariations'=>['Units']]], 'Customers'=>['CustomerAddresses']])->first();
		
		//pr($invoices); exit;
		//pr($Orders); exit;
		$company_details=$this->Orders->Companies->find()->where(['Companies.city_id'=>$city_id,'Companies.status'=>'Active'])->first();
        $this->set(compact('ids', 'sales_orders', 'Orders', 'locations', 'customers', 'drivers', 'customerAddresses', 'promotionDetails', 'deliveryCharges', 'deliveryTimes', 'cancelReasons','order_no','partyOptions','Accountledgers','items','company_details','id','cities', 'states', 'invoices'));
	}
	
	public function view($id = null,$print=null)
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
        $order = $this->Orders->newEntity();
		$CityData = $this->Orders->Cities->get($city_id);
		$StateData = $this->Orders->Cities->States->get($CityData->state_id);
	 
		$this->loadmodel('SalesOrders');
		$sales_orders=$this->Orders->find()->where(['Orders.id'=>$ids])->contain(['OrderDetails'=>['ItemVariations'=>['ItemVariationMasters','Items','UnitVariations'=>['Units']]], 'Customers'=>['CustomerAddresses']])->first();
		 
		$company_details=$this->Orders->Companies->find()->where(['Companies.city_id'=>$city_id])->first();
        $this->set(compact('ids', 'sales_orders', 'order', 'locations', 'customers', 'drivers', 'customerAddresses', 'promotionDetails', 'deliveryCharges','cancelReasons','order_no','partyOptions','Accountledgers','items','company_details','print'));
    }
	
	public function pdfView($id = null,$print=null)
    {
		$orderPrintId=$id;
		$ids = $this->EncryptingDecrypting->decryptData($id);
		//pr($ids); exit;
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id'); 
		$user_type =$this->Auth->User('user_type');
		$state_id=$this->Auth->User('state_id'); 
		if($user_type=="Super Admin"){
		$this->viewBuilder()->layout('super_admin_layout');	
		}else if($user_type=="Admin"){ 
		$this->viewBuilder()->layout('admin_portal');
		}
        $order = $this->Orders->newEntity();
		$CityData = $this->Orders->Cities->get($city_id);
		$StateData = $this->Orders->Cities->States->get($CityData->state_id);
		//pr($print); exit;
		$this->loadmodel('SalesOrders');
		$Orders=$this->Orders->get($ids,['contain'=>['OrderDetails'=>['ItemVariations','Items'],'Customers'=>['CustomerAddresses'],'CustomerAddresses']]);
		//pr($Orders); exit;
		$company_details=$this->Orders->Companies->find()->where(['Companies.city_id'=>$city_id])->first();
        $this->set(compact('ids', 'sales_orders', 'order', 'locations', 'customers', 'drivers', 'customerAddresses', 'promotionDetails', 'deliveryCharges', 'deliveryTimes', 'cancelReasons','order_no','partyOptions','Accountledgers','items','company_details','Orders','orderPrintId','print'));
    }
	
	public function recreateOrder($id=null,$status=null)
    {
		
		$user_id=$this->Auth->User('id'); 
		$financial_year_id=$this->Auth->User('financial_year_id');
		$city_id=$this->Auth->User('city_id'); 
		$location_id=$this->Auth->User('location_id'); 
		$state_id=$this->Auth->User('state_id'); 
		$this->viewBuilder()->layout('admin_portal');
        $order = $this->Orders->newEntity();
		$CityData = $this->Orders->Cities->get($city_id);
		$StateData = $this->Orders->Cities->States->get($CityData->state_id);
		$ids=$id;
		/* $todayDate=date('Y-m-d');
		$Voucher_no = $this->Orders->find()->select(['voucher_no'])->where(['Orders.city_id'=>$city_id,'Orders.financial_year_id'=>$financial_year_id,'order_date'=>$todayDate])->order(['voucher_no' => 'DESC'])->first();
		if($Voucher_no){$voucher_no=$Voucher_no->voucher_no+1;}
		else{$voucher_no=1;} 
		
		
		
		$vn=str_pad($voucher_no, 7, '0', STR_PAD_LEFT);
		$orderdate = explode('-', $todayDate);
		$year = $orderdate[0];
		$month   = $orderdate[1];
		$day  = $orderdate[2];
		$order_no=$year.''.$month.''.$day.''.$vn;
		$order_no=$CityData->alise_name.'/'.$order_no;
		$order_no=$StateData->alias_name.'/'.$order_no; membership_discount
		$order_no=$order_no; */ 
		
		$this->loadmodel('DeliveryCharges');
		$deliveryCharges=$this->DeliveryCharges->find()->where(['DeliveryCharges.city_id'=>$city_id, 'DeliveryCharges.status'=>'Active'])->first();
		
		$Orders=$this->Orders->get($id,['contain'=>['OrderDetails'=>['ItemVariations','Items'],'Customers'=>['CustomerAddresses'],'CustomerAddresses']]);
		$Old_order_Data=$Orders;
		
        if ($this->request->is(['patch', 'post', 'put'])) {
			
			$pay_amount=($this->request->getData()['pay_amount']); 
			//pr($this->request->getData()); exit; 
			$order = $this->Orders->patchEntity($order, $this->request->getData());
			
			$delivery_date = date('Y-m-d',strtotime("+2 days"));
			$order->financial_year_id=$financial_year_id;
			$order->city_id=$city_id;
			$order->pay_amount=$this->request->data('due_amount');
			$order->order_from="Web";
			$order->location_id=$location_id;
			$order->voucher_no=$Old_order_Data->voucher_no;
			$order->delivery_date=$delivery_date;
			$order->order_status="placed";
			$order->order_date=date('Y-m-d');
			
			/* $vn=str_pad($voucher_no, 7, '0', STR_PAD_LEFT);
			$orderdate = explode('-', $order->order_date);
			$year = $orderdate[0];
			$month   = $orderdate[1];
			$day  = $orderdate[2];
			$order_no=$year.''.$month.''.$day.''.$vn;
			$order_no=$CityData->alise_name.'/'.$order_no;
			$order_no=$StateData->alias_name.'/'.$order_no; */
			$order->order_no=$Old_order_Data->order_no;
			
			///Round///off///functionality/////////
			$p=$order->grand_total;
			$q=round($order->grand_total);
			$Round_off_amt=round(($q-$p),2);
			$order->grand_total=round($order->grand_total);	
			$order->round_off=$Round_off_amt;
			///Round///off///functionality/////////
		
			$order->transaction_date=date('Y-m-d',strtotime($order->transaction_date));
			
			$CustomerData = $this->Orders->Challans->Invoices->Ledgers->find()->where(['Ledgers.customer_id' =>$order->customer_id,'Ledgers.city_id'=>$city_id])->first(); 
			$order->customer_id=$CustomerData->customer_id;
			
			//$Custledgers = $this->Orders->SellerLedgers->get($order->party_ledger_id,['contain'=>['Customers'=>['Cities']]]);
			if($order->order_type=="COD"){
				$LedgerData = $this->Orders->Challans->Invoices->Ledgers->find()->where(['Ledgers.cash' =>'1','Ledgers.city_id'=>$city_id])->first();
				$order->party_ledger_id=$LedgerData->id;
			}else{
				$LedgerData = $this->Orders->Challans->Invoices->Ledgers->find()->where(['Ledgers.customer_id' =>$order->customer_id,'Ledgers.city_id'=>$city_id])->first();
				$order->party_ledger_id=$LedgerData->id;
			}
			
			$order->pay_amount=$pay_amount;
			
			
			$CustDefaultAddress = $this->Orders->Customers->CustomerAddresses->find()->where(['customer_id'=>$order->customer_id,'default_address'=>1])->first();

			$order->customer_address_id=$CustDefaultAddress->id;	
			$order->order_time=date('H:i:s');
			
			$CustAdd=$CustDefaultAddress->house_no.",".$CustDefaultAddress->landmark_name.",".$CustDefaultAddress->address;
			$order->address=$CustAdd;
			
			
			if($order->delivery_charge_amount > 0){
				$order->grand_total=$order->grand_total-$order->delivery_charge_amount;
			}
			$pay_amount=$order->grand_total;
			$order->pay_amount=$pay_amount;
			
			if ($this->Orders->save($order)) {
			foreach($order->order_details as $order_detail){ 
				$item= $this->Orders->OrderDetails->ItemVariations->Items->get($order_detail->item_id);
				if($item->item_maintain_by=="itemwise"){
					
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
				
				$query = $this->Orders->OrderDetails->query();
					$query->update()
					->set(['item_status'=>'placed'])
					->where(['OrderDetails.order_id'=>$order->id])
					->execute();
				
				$this->reGenerateOrder($order->id,$Old_order_Data->id);
			$this->Flash->success(__('The order has been saved.'));
			return $this->redirect(['action' => 'index']);
            }else{ pr($order); exit;
				$this->Flash->error(__('The order could not be saved. Please, try again.'));
			}
        }
		
		$partyParentGroups = $this->Orders->AccountingGroups->find()
						->where(['AccountingGroups.
						sale_invoice_party'=>'1','AccountingGroups.city_id'=>$city_id]); 
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
							->contain(['Customers'=>['Cities']]);
        } 
		
		
		$accountLedgers = $this->Orders->AccountingGroups->find()->where(['AccountingGroups.sale_invoice_sales_account'=>1,'AccountingGroups.city_id'=>$city_id])->first();
		$accountingGroups2 = $this->Orders->AccountingGroups
		->find('children', ['for' => $accountLedgers->id])
		->find('List')->toArray();
		$accountingGroups2[$accountLedgers->id]=$accountLedgers->name;
		ksort($accountingGroups2);
		if($accountingGroups2)
		{   
			$account_ids="";
			foreach($accountingGroups2 as $key=>$accountingGroup)
			{
				$account_ids .=$key.',';
			}
			$account_ids = explode(",",trim($account_ids,','));
			$Accountledgers = $this->Orders->Ledgers->find('list')->where(['Ledgers.accounting_group_id IN' =>$account_ids]);
        }

		$itemList=$this->Orders->Items->find()->contain(['ItemVariations'=> function ($q) use($city_id){
								return $q 
								->where(['ItemVariations.ready_to_sale'=>'Yes','ItemVariations.city_id '=>$city_id,'ItemVariations.status'=>'Active'])->contain(['UnitVariations'=>['Units']]);
								}]);
		//pr($itemList->toArray()); exit;
		$items=array();
		foreach($itemList as $data1){ 
			foreach($data1->item_variations as $data){
				$discount_applicable=$data1->is_discount_enable;
				$category_id=$data1->category_id;
				$gstData=$this->Orders->GstFigures->get($data1->gst_figure_id);
				$merge=$data1->name.'('.@$data->unit_variation->visible_variation.')';
				$items[]=['text' => $merge,'value' => $data->id,'item_id'=>$data1->id,'quantity_factor'=>@$data->unit_variation->convert_unit_qty,'unit'=>@$data->unit_variation->unit->unit_name,'gst_figure_id'=>$data1->gst_figure_id,'gst_value'=>$gstData->tax_percentage,'commission'=>@$data->commission,'sale_rate'=>$data->sales_rate,'current_stock'=>$data->current_stock,'virtual_stock'=>$data->virtual_stock,'demand_stock'=>$data->demand_stock,'discount_applicable'=>$discount_applicable,'category_id'=>$category_id,'maximum_quantity_purchase'=>$data->maximum_quantity_purchase];
			}
		}
		$todayDate=date('Y-m-d');
		$partyOptions=[];
		foreach($Partyledgers as $Partyledger){
			$membership_discount=0;
			$start_date=(date('Y-m-d',strtotime($Partyledger->customer->start_date)));
			$end_date=(date('Y-m-d',strtotime($Partyledger->customer->end_date)));
			if($start_date <= $todayDate && $end_date >= $todayDate){
				$membership_discount=$Partyledger->customer->membership_discount;
			}
			$partyOptions[]=['text' =>$Partyledger->name, 'value' => $Partyledger->customer_id,'city_id'=>$Partyledger->customer->city->id,'state_id'=>$Partyledger->customer->city->state_id,'bill_to_bill_accounting'=>$Partyledger->bill_to_bill_accounting,'customer_id'=>$Partyledger->customer_id,'membership_discount'=>$membership_discount,'membership_start_date'=>$Partyledger->customer->start_date,'membership_end_date'=>$Partyledger->customer->end_date];
		}
		
		//pr($partyOptions); exit;
		//$partyOptions=$this->Orders->Customers->find('list')->where(['Customers.city_id'=>$city_id]);
		 
		
		$this->set(compact('ids', 'sales_orders', 'order', 'locations', 'customers', 'drivers', 'customerAddresses', 'promotionDetails', 'deliveryCharges', 'deliveryTimes', 'cancelReasons','order_no','partyOptions','Accountledgers','items','deliverydates','holidays','holiday_count','combos','CancelItemOrder','Orders'));
    }
	
	public function reGenerateOrder($id = null,$old_id = null)
    {  
		
		$this->viewBuilder()->layout('admin_portal');
		$user_id=$this->Auth->User('id');
		$financial_year_id=$this->Auth->User('financial_year_id');
		$city_id=$this->Auth->User('city_id'); 
		$location_id=$this->Auth->User('location_id'); 
		$state_id=$this->Auth->User('state_id'); 
		$this->viewBuilder()->layout('admin_portal');
        $order = $this->Orders->newEntity();
		$CityData = $this->Orders->Cities->get($city_id);
		$StateData = $this->Orders->Cities->States->get($CityData->state_id);
		$today_date=date("Y-m-d");
		$orderdate = explode('-', $today_date);
		$year = $orderdate[0];
		$month   = $orderdate[1];
		$day  = $orderdate[2];
		$order = $this->Orders->get($id, [
            'contain' => ['OrderDetails'=>['ItemVariations'=>['Items'=>['GstFigures']]]]
        ]);
		
		$oldOrder = $this->Orders->get($old_id, [
            'contain' => ['OrderDetails'=>['ItemVariations'=>['Items'=>['GstFigures']]]]
        ]);
		//pr($oldOrder); exit;
		
		$Totalsellers=[];
		$Jainsellers=[];
		$sellersum=0;
		foreach($order->order_details as $order_detail){ 
			if($order_detail->item_variation->seller_id > 0){ 
				$seller_id=$order_detail->item_variation->seller_id; 
				$Totalsellers[$seller_id][]=$order_detail;
				
			}else
			{
				$Jainsellers[0][]=$order_detail;
				
			}
		}
		
		
		$totalSellerCount=(sizeof($Jainsellers)+sizeof($Totalsellers));
		
		foreach($Totalsellers as $key=>$Totalseller){
			
			$OldChallan = $this->Orders->Challans->find()->where(['Challans.seller_id'=>$key,'Challans.order_id'=>$oldOrder->id])->order(['voucher_no' => 'DESC'])->first();
			
			if($OldChallan){
				$order_no=$OldChallan->invoice_no;
				$voucher_no=$OldChallan->voucher_no;
			}else{
				$Voucher_no = $this->Orders->Challans->find()->select(['voucher_no'])->where(['Challans.city_id'=>$city_id,'Challans.financial_year_id'=>$financial_year_id])->order(['voucher_no' => 'DESC'])->first();
				if($Voucher_no){$voucher_no=$Voucher_no->voucher_no+1;}
				else{$voucher_no=1;}
				$vn=str_pad($voucher_no, 7, '0', STR_PAD_LEFT);
				$order_no='CH/'.$vn;
			}
			
			//$order_no=$CityData->alise_name.'/CH/'.$voucher_no;
			//$order_no=$StateData->alias_name.'/'.$order_no;
			
			$sellerLedgerData = $this->Orders->AccountingEntries->Ledgers->find()->where(['seller_id'=>$key])->first();
			
			$Invoice = $this->Orders->Challans->newEntity(); 
			$Invoice->seller_id=$key;
			$Invoice->order_id=$id;
			$Invoice->location_id=$order->location_id;
			$Invoice->customer_address_id=$order->customer_address_id;
			$Invoice->voucher_no=$voucher_no;
			$Invoice->invoice_no=$order_no;
			$Invoice->seller_name=$sellerLedgerData->name;
			$Invoice->order_type=$order->order_type;
			$Invoice->financial_year_id=$financial_year_id;
			$Invoice->city_id=$order->city_id;
			$Invoice->sales_ledger_id=$order->sales_ledger_id;
			$Invoice->party_ledger_id=$order->party_ledger_id;
			$Invoice->customer_id=$order->customer_id;
			//$Invoice->driver_id=$order->driver_id;
			$Invoice->address=$order->address;
			$Invoice->promotion_detail_id=$order->promotion_detail_id;
			$Invoice->ccavvenue_tracking_no=$order->ccavvenue_tracking_no;
			$Invoice->order_type=$order->order_type;
			$Invoice->order_date=$order->order_date;
			$Invoice->transaction_date=$order->order_date;
			$Invoice->order_status=$order->order_status;
			$Invoice->delivery_charge_amount=@$order->delivery_charge_amount/$totalSellerCount;  
			if($this->Orders->Challans->save($Invoice)){
				
			}else{
				
			}
			$total_promo_amount=0;
			$total_discount_amount=0;
			$total_taxable=0;
			$total_gst=0;
			$grand_total=0;
			foreach($Totalseller as $data){  
					$InvoiceRow = $this->Orders->Challans->ChallanRows->newEntity(); 
					$InvoiceRow->challan_id=$Invoice->id;
					$InvoiceRow->order_detail_id=$data->id;
					$InvoiceRow->item_id=$data->item_id;
					$InvoiceRow->item_variation_id=$data->item_variation_id;
					$InvoiceRow->combo_offer_id=0;
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
					$this->Orders->Challans->ChallanRows->save($InvoiceRow);
					
					$total_discount_amount+=$data->discount_amount;
					$total_promo_amount+=$data->promo_amount;
					$total_taxable+=$data->taxable_value;
					$total_gst+=$data->gst_value;
					$grand_total+=$data->net_amount;
			}
			
			
			$after_round_of=round($grand_total);
			$round_off=0;
			if($after_round_of!=$grand_total){
				$round_off=$after_round_of-$grand_total;
			}
			
			$round_off=$round_off;
			$grand_total=$after_round_of;
			
			
			$query = $this->Orders->Challans->query();
			$query->update()
					->set(['grand_total' => $after_round_of,'discount_amount' => $total_discount_amount,'delivery_charge_amount' => $Invoice->delivery_charge_amount,'total_gst' => $total_gst,'total_amount' => $total_taxable,'round_off' => $round_off,'pay_amount' => $after_round_of+$Invoice->delivery_charge_amount])
					->where(['id'=>$Invoice->id])
					->execute();
		}
		
		foreach($Jainsellers as $key=>$Jainseller){
			
			$OldChallan = $this->Orders->Challans->find()->where(['Challans.seller_id IS NULL','Challans.order_id'=>$oldOrder->id])->order(['voucher_no' => 'DESC'])->first();
			
			if($OldChallan){
				$order_no=$OldChallan->invoice_no;
				$voucher_no=$OldChallan->voucher_no;
			}else{
				$Voucher_no = $this->Orders->Challans->find()->select(['voucher_no'])->where(['Challans.city_id'=>$city_id,'Challans.financial_year_id'=>$financial_year_id])->order(['voucher_no' => 'DESC'])->first();
				if($Voucher_no){$voucher_no=$Voucher_no->voucher_no+1;}
				else{$voucher_no=1;}
				$vn=str_pad($voucher_no, 7, '0', STR_PAD_LEFT);
				$order_no='CH/'.$vn;
			} 
			
			
			$Invoice = $this->Orders->Challans->newEntity(); 
			$Invoice->seller_id=NULL;
			$Invoice->order_id=$id;
			$Invoice->voucher_no=$voucher_no;
			$Invoice->invoice_no=$order_no;
			$Invoice->seller_name="JainThela";
			$Invoice->order_type=$order->order_type;
			$Invoice->financial_year_id=$financial_year_id;
			$Invoice->city_id=$order->city_id;
			//$Invoice->driver_id=$order->driver_id;
			$Invoice->sales_ledger_id=$order->sales_ledger_id;
			$Invoice->party_ledger_id=$order->party_ledger_id;
			$Invoice->customer_id=$order->customer_id;
			//$Invoice->driver_id=$order->driver_id;
			$Invoice->address=$order->address;
			$Invoice->promotion_detail_id=$order->promotion_detail_id;
			$Invoice->ccavvenue_tracking_no=$order->ccavvenue_tracking_no;
			$Invoice->order_type=$order->order_type;
			$Invoice->order_date=$order->order_date;
			$Invoice->order_date=$order->order_date;
			$Invoice->transaction_date=$order->order_date;
			$Invoice->order_status=$order->order_status;
			$Invoice->delivery_charge_amount=@$order->delivery_charge_amount/$totalSellerCount; 
			$Invoice->location_id=$order->location_id;
			$Invoice->delivery_date=$order->delivery_date;
			$Invoice->delivery_time_id=$order->delivery_time_id;
			$Invoice->delivery_time_sloat=$order->delivery_time_sloat;
			$Invoice->customer_address_id=$order->customer_address_id; //pr($Invoice); exit;
			if($this->Orders->Challans->save($Invoice)){
				
			}else{
				
			}
			$total_promo_amount=0;
			$total_discount_amount=0;
			$total_taxable=0;
			$total_gst=0;
			$grand_total=0;
			foreach($Jainseller as $data){ 
					$InvoiceRow = $this->Orders->Challans->ChallanRows->newEntity(); 
					$InvoiceRow->challan_id=$Invoice->id;
					$InvoiceRow->order_detail_id=$data->id;
					$InvoiceRow->item_id=$data->item_id;
					$InvoiceRow->item_variation_id=$data->item_variation_id;
					$InvoiceRow->combo_offer_id=0;
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
					$this->Orders->Challans->ChallanRows->save($InvoiceRow); 
					$total_discount_amount+=$data->discount_amount;
					$total_promo_amount+=$data->promo_amount;
					$total_taxable+=$data->taxable_value;
					$total_gst+=$data->gst_value;
					$grand_total+=$data->net_amount;
			}
			$after_round_of=round($grand_total);
			$round_off=0;
			if($after_round_of!=$grand_total){
				$round_off=$after_round_of-$grand_total;
			}
			
			$round_off=$round_off;
			$grand_total=$after_round_of;
			
			
			$query = $this->Orders->Challans->query();
			$query->update()
					->set(['grand_total' => $after_round_of,'discount_amount' =>@$total_discount_amount+@$total_promo_amount,'delivery_charge_amount' => $Invoice->delivery_charge_amount,'total_gst' => $total_gst,'total_amount' => $total_taxable,'round_off' => $round_off,'pay_amount' => $after_round_of+$Invoice->delivery_charge_amount])
					->where(['id'=>$Invoice->id])
					->execute();
		}
		
		/* //	Payment History
		 $OrderPaymentHistory = $this->Orders->OrderPaymentHistories->newEntity();
		 $OrderPaymentHistory->order_id=$order->id;
		 $OrderPaymentHistory->online_amount=$order->online_amount;
		 $OrderPaymentHistory->wallet_amount=$order->amount_from_wallet;
		 if($order->order_type=="COD"){
			$OrderPaymentHistory->cod_amount=$order->pay_amount;
		 }
		 $OrderPaymentHistory->total=$order->pay_amount;
		 $OrderPaymentHistory->entry_from="Order";
		 $this->Orders->OrderPaymentHistories->save( $OrderPaymentHistory); 
		// */
		
		$Challans=$this->Orders->Challans->find()->where(['Challans.order_id'=>$oldOrder->id]);
		foreach($Challans as $Data){
			$this->Orders->Challans->ChallanRows->deleteAll(['ChallanRows.challan_id'=>$Data->id]);
		}
		$this->Orders->Challans->deleteAll(['Challans.order_id'=>$oldOrder->id]);
		$this->Orders->OrderDetails->deleteAll(['OrderDetails.order_id'=>$oldOrder->id]);
		$this->Orders->deleteAll(['Orders.id'=>$oldOrder->id]);
		 
        return $this->redirect(['action' => 'index']);
	}

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($id=null,$status=null)
    {
		$status = $this->request->query('status');
		if(!empty($id)){
			$ids= $this->EncryptingDecrypting->decryptData($id);
		}
		$user_id=$this->Auth->User('id'); 
		$financial_year_id=$this->Auth->User('financial_year_id');
		$city_id=$this->Auth->User('city_id'); 
		$location_id=$this->Auth->User('location_id'); 
		$state_id=$this->Auth->User('state_id'); 
		$this->viewBuilder()->layout('admin_portal');
        $order = $this->Orders->newEntity();
		$CityData = $this->Orders->Cities->get($city_id);
		$StateData = $this->Orders->Cities->States->get($CityData->state_id);
	
		$todayDate=date('Y-m-d');
		$Voucher_no = $this->Orders->find()->select(['voucher_no'])->where(['Orders.city_id'=>$city_id,'Orders.financial_year_id'=>$financial_year_id,'order_date'=>$todayDate])->order(['voucher_no' => 'DESC'])->first();
		if($Voucher_no){$voucher_no=$Voucher_no->voucher_no+1;}
		else{$voucher_no=1;}
		
		
		
		$vn=str_pad($voucher_no, 7, '0', STR_PAD_LEFT);
		$orderdate = explode('-', $todayDate);
		$year = $orderdate[0];
		$month   = $orderdate[1];
		$day  = $orderdate[2];
		$order_no=$year.''.$month.''.$day.''.$vn;
		$order_no=$CityData->alise_name.'/'.$order_no;
		$order_no=$StateData->alias_name.'/'.$order_no;
		$order_no=$order_no;
		
		$this->loadmodel('DeliveryCharges');
		$deliveryCharges=$this->DeliveryCharges->find()->where(['DeliveryCharges.city_id'=>$city_id, 'DeliveryCharges.status'=>'Active'])->first();
		$this->loadmodel('SalesOrders');
		if(!empty($ids)){
			$sales_orders=$this->SalesOrders->find()->where(['SalesOrders.id'=>$ids])->contain(['Customers','SalesOrderRows'])->first();
			$sales_combos=$this->SalesOrders->SalesOrderRows->find()->where(['SalesOrderRows.sales_order_id'=>$ids,'SalesOrderRows.combo_offer_id !='=>'NULL'])->contain(['ComboOffers']);
			$sales_combo_count=$this->SalesOrders->SalesOrderRows->find()->where(['SalesOrderRows.sales_order_id'=>$ids,'SalesOrderRows.combo_offer_id !='=>'NULL'])->count();
		}
		if($status=="cancel"){
			$order_id = $this->request->query('order_id');
			$order_id= $this->EncryptingDecrypting->decryptData($order_id);
			$CancelItemOrder=$this->Orders->get($order_id,['contain'=>['Customers'=>['CustomerAddresses'],'CustomerAddresses','OrderDetails' =>function ($q) {
			return $q->where(['OrderDetails.is_item_cancel' =>'Yes'])->contain(['Items','ItemVariations'=>['UnitVariations']]);
			}]]);
			//pr($CancelItemOrder); exit;
		}
		
        if ($this->request->is('post')) {
			
			//pr($this->request->getData()); exit;
			if(!empty($ids)){
			$query1 = $this->Orders->SalesOrders->query();
							$query1->update()
							->set(['status'=>'Yes'])
							->where(['id'=>$ids])
							->execute();
			}
			$pay_amount=($this->request->getData()['pay_amount']); 
			
            $order = $this->Orders->patchEntity($order, $this->request->getData());
			$Voucher_no = $this->Orders->find()->select(['voucher_no'])->where(['Orders.city_id'=>$city_id,'Orders.financial_year_id'=>$financial_year_id,'order_date'=>$todayDate])->order(['voucher_no' => 'DESC'])->first(); 
			
			@$promotion_detail_id=$this->request->data('promotion_detail_id');
			@$amount_from_wallet=$this->request->data('amount_from_wallet');
			
			if($Voucher_no){$voucher_no=$Voucher_no->voucher_no+1;}
			else{$voucher_no=1;} 
			$delivery_date = date('Y-m-d',strtotime("+2 days"));
			$order->financial_year_id=$financial_year_id;
			$order->city_id=$city_id;
			$order->pay_amount=$this->request->data('due_amount');
			$order->order_from="Web";
			$order->location_id=$location_id;
			$order->voucher_no=$voucher_no;
			$order->delivery_date=$delivery_date;
			$order->order_status="placed";
			$order->order_date=date('Y-m-d');
			
			$vn=str_pad($voucher_no, 7, '0', STR_PAD_LEFT);
			$orderdate = explode('-', $order->order_date);
			$year = $orderdate[0];
			$month   = $orderdate[1];
			$day  = $orderdate[2];
			$order_no=$year.''.$month.''.$day.''.$vn;
			$order_no=$CityData->alise_name.'/'.$order_no;
			$order_no=$StateData->alias_name.'/'.$order_no;
			$order->order_no=$order_no;
			
			///Round///off///functionality/////////
			$p=$order->grand_total;
			$q=round($order->grand_total);
			$Round_off_amt=round(($q-$p),2);
			$order->grand_total=round($order->grand_total);	
			$order->round_off=$Round_off_amt;
			///Round///off///functionality/////////
			
		
			$order->transaction_date=date('Y-m-d',strtotime($order->transaction_date));
			
			$CustomerData = $this->Orders->Challans->Invoices->Ledgers->find()->where(['Ledgers.id' =>$order->customer_id,'Ledgers.city_id'=>$city_id])->first();
			$order->customer_id=$CustomerData->customer_id;
			
			//$Custledgers = $this->Orders->SellerLedgers->get($order->party_ledger_id,['contain'=>['Customers'=>['Cities']]]);
			if($order->order_type=="COD"){
				$LedgerData = $this->Orders->Challans->Invoices->Ledgers->find()->where(['Ledgers.cash' =>'1','Ledgers.city_id'=>$city_id])->first();
				$order->party_ledger_id=$LedgerData->id;
			}else{
				$LedgerData = $this->Orders->Challans->Invoices->Ledgers->find()->where(['Ledgers.customer_id' =>$order->customer_id,'Ledgers.city_id'=>$city_id])->first();
				$order->party_ledger_id=$LedgerData->id;
			}
			
			
			
			$CustDefaultAddress = $this->Orders->Customers->CustomerAddresses->find()->where(['customer_id'=>$order->customer_id,'default_address'=>1])->first();

			$order->customer_address_id=$CustDefaultAddress->id;	
			$order->order_time=date('H:i:s');
			
			$CustAdd=$CustDefaultAddress->house_no.",".$CustDefaultAddress->landmark_name.",".$CustDefaultAddress->address;
			$order->address=$CustAdd;
			if($order->delivery_charge_amount > 0){
				$order->grand_total=$order->grand_total-$order->delivery_charge_amount;
			}
			$pay_amount=$order->grand_total;
			$order->pay_amount=$pay_amount;
			//pr($order); exit;
			if ($this->Orders->save($order)) { //pr($order); exit;delivery_charge_amount
			//if ($order) { 
				//pr($order); exit;
				$customer1 = $this->Orders->Customers->get($order->customer_id);
				
				$mob=$customer1->username;
				
				$sms=str_replace(' ', '+', 'YOur order has been cancel');
				$sms_sender='JAINTE';
				$sms=str_replace(' ', '+', $sms);
				//file_get_contents('http://103.39.134.40/api/mt/SendSMS?user=phppoetsit&password=9829041695&senderid='.$sms_sender.'&channel=Trans&DCS=0&flashsms=0&number='.$mob.'&text='.$sms.'&route=7');
				
				
				//update in item variation
						
			
			foreach($order->order_details as $order_detail){ 
				$item= $this->Orders->OrderDetails->ItemVariations->Items->get($order_detail->item_id);
				//pr($item->item_maintain_by); exit;
				if($item->item_maintain_by=="itemwise"){
					/* $allItemVariations= $this->Orders->OrderDetails->ItemVariations->find()->where(['ItemVariations.item_id'=>$order_detail->item_id,'ItemVariations.city_id'=>@$city_id,'ItemVariations.seller_id IS NULL'])->contain(['UnitVariations'=>['Units']]);
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
					} */
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
					/* $query = $this->Orders->OrderDetails->query();
					$query->update()
					->set(['old_item_variation_id'=>$order_detail->item_variation_id])
					->where(['id'=>$order_detail->id])
					->execute(); */
					
				}
				
				$query = $this->Orders->OrderDetails->query();
					$query->update()
					->set(['item_status'=>'placed'])
					->where(['OrderDetails.order_id'=>$order->id])
					->execute();
				
				if($status=="cancel"){
					$query = $this->Orders->OrderDetails->query();
					$query->update()
					->set(['other_order_create'=>'Yes'])
					->where(['OrderDetails.order_id'=>$order_id,'OrderDetails.item_status'=>'Cancel'])
					->execute();
				}
					
				$this->orderDeliver($order->id);
				
				$customer_details=$this->Orders->Customers->find()
				->where(['Customers.id' => $order->customer_id])->first();
				$mobile=$customer_details->mobile;
				$main_device_token1=$customer_details->device_token;
					 
					if((!empty($main_device_token1))){
					
						$device_token=$main_device_token1;
					}
						 
	/* 					 
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
				'image' => '',
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
				$response;
			}			
			  
		} */
			$this->Flash->success(__('The order has been saved.'));
			return $this->redirect(['action' => 'index']);
            }else{ pr($order); exit;
				$this->Flash->error(__('The order could not be saved. Please, try again.'));
			}
        }
		
		$partyParentGroups = $this->Orders->AccountingGroups->find()
						->where(['AccountingGroups.
						sale_invoice_party'=>'1','AccountingGroups.city_id'=>$city_id]); 
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
							->contain(['Customers'=>['Cities']]);
        } 
		
		
		$accountLedgers = $this->Orders->AccountingGroups->find()->where(['AccountingGroups.sale_invoice_sales_account'=>1,'AccountingGroups.city_id'=>$city_id])->first();
		$accountingGroups2 = $this->Orders->AccountingGroups
		->find('children', ['for' => $accountLedgers->id])
		->find('List')->toArray();
		$accountingGroups2[$accountLedgers->id]=$accountLedgers->name;
		ksort($accountingGroups2);
		if($accountingGroups2)
		{   
			$account_ids="";
			foreach($accountingGroups2 as $key=>$accountingGroup)
			{
				$account_ids .=$key.',';
			}
			$account_ids = explode(",",trim($account_ids,','));
			$Accountledgers = $this->Orders->Ledgers->find('list')->where(['Ledgers.accounting_group_id IN' =>$account_ids]);
        }

		$itemList=$this->Orders->Items->find()->contain(['ItemVariations'=> function ($q) use($city_id){
								return $q 
								->where(['ItemVariations.ready_to_sale'=>'Yes','ItemVariations.city_id '=>$city_id,'ItemVariations.status'=>'Active'])->contain(['UnitVariations'=>['Units']]);
								}]);
		//pr($itemList->toArray()); exit;
		$items=array();
		foreach($itemList as $data1){ 
			foreach($data1->item_variations as $data){
				$discount_applicable=$data1->is_discount_enable;
				$category_id=$data1->category_id;
				$gstData=$this->Orders->GstFigures->get($data1->gst_figure_id);
				$merge=$data1->name.'('.@$data->unit_variation->visible_variation.')';
				$items[]=['text' => $merge,'value' => $data->id,'item_id'=>$data1->id,'quantity_factor'=>@$data->unit_variation->convert_unit_qty,'unit'=>@$data->unit_variation->unit->unit_name,'gst_figure_id'=>$data1->gst_figure_id,'gst_value'=>$gstData->tax_percentage,'commission'=>@$data->commission,'sale_rate'=>$data->sales_rate,'current_stock'=>$data->current_stock,'virtual_stock'=>$data->virtual_stock,'demand_stock'=>$data->demand_stock,'discount_applicable'=>$discount_applicable,'category_id'=>$category_id,'maximum_quantity_purchase'=>$data->maximum_quantity_purchase];
			}
		}
		$todayDate=date('Y-m-d');
		$partyOptions=[];
		foreach($Partyledgers as $Partyledger){
			$membership_discount=0;
			$start_date=(date('Y-m-d',strtotime($Partyledger->customer->start_date)));
			$end_date=(date('Y-m-d',strtotime($Partyledger->customer->end_date)));
			if($start_date <= $todayDate && $end_date >= $todayDate){
				$membership_discount=$Partyledger->customer->membership_discount;
			}
			$partyOptions[]=['text' =>$Partyledger->name, 'value' => $Partyledger->id,'city_id'=>$Partyledger->customer->city->id,'state_id'=>$Partyledger->customer->city->state_id,'bill_to_bill_accounting'=>$Partyledger->bill_to_bill_accounting,'customer_id'=>$Partyledger->customer_id,'membership_discount'=>$membership_discount,'membership_start_date'=>$Partyledger->customer->start_date,'membership_end_date'=>$Partyledger->customer->end_date];
		}
		
		//pr($items); exit;
		//$partyOptions=$this->Orders->Customers->find('list')->where(['Customers.city_id'=>$city_id]);
		 
		
		$this->set(compact('ids', 'sales_orders', 'order', 'locations', 'customers', 'drivers', 'customerAddresses', 'promotionDetails', 'deliveryCharges', 'deliveryTimes', 'cancelReasons','order_no','partyOptions','Accountledgers','items','deliverydates','holidays','holiday_count','combos','CancelItemOrder'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Order id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
	public function purchaseOrder(){
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id'); 
		$location_id=$this->Auth->User('location_id'); 
		$this->viewBuilder()->layout('super_admin_layout');
		$location_id = $this->request->query('location_id');
		$seller_id = $this->request->query('seller_id');
		$from_date = $this->request->query('from_date');
		$to_date   = $this->request->query('to_date');
		if(empty($from_date) || empty($to_date))
		{
			$from_date = date("Y-m-01");
			$to_date   = date("Y-m-d");
		}else{
			$from_date = date("Y-m-d",strtotime($from_date));
			$to_date= date("Y-m-d",strtotime($to_date));
		}
		if(!empty($from_date))
		{
			$from_date = date("Y-m-d",strtotime($from_date));
			$where['Orders.transaction_date >=']=$from_date;
		}
		if(!empty($to_date))
		{
			$to_date   = date("Y-m-d",strtotime($to_date));
			$where['Orders.transaction_date <=']=$to_date;
		}
		if(!empty($location_id))
		{
			//$to_date   = date("Y-m-d",strtotime($to_date)); ItemVariationData
			$where['Orders.location_id']=$location_id;
		}
		
	//	$orders = $this->Orders->find()->contain(['Locations','OrderDetails'=>['Items','ItemVariations'=>['SellersData','UnitVariations'=>['Units']]]])->where($where)->where(['order_status'=>'placed']);
		if($seller_id){
			$orders = $this->Orders->find()->contain(['Locations','OrderDetails'=>['Items','ItemVariations'=> function ($q) use($seller_id){
								return $q 
								->where(['ItemVariations.seller_id '=>$seller_id])->contain(['SellersData','UnitVariations'=>['Units']]);
								}]])->where($where)->where(['order_status'=>'placed']);
		}else{
			$orders = $this->Orders->find()->contain(['Locations','OrderDetails'=>['Items','ItemVariations'=>['SellersData','UnitVariations'=>['Units']]]])->where($where)->where(['order_status'=>'placed']);
		}
		//pr($orders->toArray()); exit;
		$Locations = $this->Orders->Locations->find('list')->where(['city_id'=>$city_id]);
		$Sellers = $this->Orders->Sellers->find('list')->where(['city_id'=>$city_id]);
		$this->set(compact('from_date','to_date','orders','Locations','location_id','Sellers','seller_id'));
		
	}
	
	public function cashCreditReport()
    {
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id'); 
		$location_id=$this->Auth->User('location_id'); 
		$this->viewBuilder()->layout('super_admin_layout');
		$location_id = $this->request->query('location_id');
		$from_date = $this->request->query('from_date');
		$to_date   = $this->request->query('to_date');
		if(empty($from_date) || empty($to_date))
		{
			$from_date = date("Y-m-01");
			$to_date   = date("Y-m-d");
		}else{
			$from_date = date("Y-m-d",strtotime($from_date));
			$to_date= date("Y-m-d",strtotime($to_date));
		}
		if(!empty($from_date))
		{
			$from_date = date("Y-m-d",strtotime($from_date));
			$where['Orders.transaction_date >=']=$from_date;
		}
		if(!empty($to_date))
		{
			$to_date   = date("Y-m-d",strtotime($to_date));
			$where['Orders.transaction_date <=']=$to_date;
		}
		if(!empty($location_id))
		{
			//$to_date   = date("Y-m-d",strtotime($to_date));
			$where['Orders.location_id']=$location_id;
		}
	//pr($where); exit;
		$orders = $this->Orders->find()->contain(['Locations'])->where(['Orders.city_id'=>$city_id])->where($where);
		$Locations = $this->Orders->Locations->find('list');
	//	pr($orders->toArray()); exit;
		$this->set(compact('from_date','to_date','orders','Locations','location_id'));
	}
	 
    public function edit($id = null)
    {
        $order = $this->Orders->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $order = $this->Orders->patchEntity($order, $this->request->getData());
            if ($this->Orders->save($order)) {
                $this->Flash->success(__('The order has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The order could not be saved. Please, try again.'));
        }
        $locations = $this->Orders->Locations->find('list', ['limit' => 200]);
        $customers = $this->Orders->Customers->find('list', ['limit' => 200]);
        $drivers = $this->Orders->Drivers->find('list', ['limit' => 200]);
        $customerAddresses = $this->Orders->CustomerAddresses->find('list', ['limit' => 200]);
        $promotionDetails = $this->Orders->PromotionDetails->find('list', ['limit' => 200]);
        $deliveryCharges = $this->Orders->DeliveryCharges->find('list', ['limit' => 200]);
        $deliveryTimes = $this->Orders->DeliveryTimes->find('list', ['limit' => 200]);
        $cancelReasons = $this->Orders->CancelReasons->find('list', ['limit' => 200]);
        $this->set(compact('order', 'locations', 'customers', 'drivers', 'customerAddresses', 'promotionDetails', 'deliveryCharges', 'deliveryTimes', 'cancelReasons'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Order id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $order = $this->Orders->get($id);
        if ($this->Orders->delete($order)) {
            $this->Flash->success(__('The order has been deleted.'));
        } else {
            $this->Flash->error(__('The order could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
	
	
	 public function itemCancleOnOrder($id = null)
    {
	
		$user_id=$this->Auth->User('id');
		$order = $this->Orders->get($id, [
            'contain' => ['OrderDetails'=>['ItemVariations'=>['Items'=>['GstFigures']]]]
        ]);
		
		$total_promo_amount=0;
		$total_discount_amount=0;
		$total_taxable=0;
		$total_gst=0;
		$grand_total=0;
		$cancelOrder="Yes";
		
		foreach($order->order_details as $order_detail){
			if($order_detail->is_item_cancel=="Yes"){
				//Item Cancle Yes in Challan Rows
				$query = $this->Orders->Challans->ChallanRows->query();
				$query->update()
						->set(['is_item_cancel' => 'Yes'])
						->where(['order_detail_id'=>$order_detail->id])
						->execute();
				//calculation
			}else if($order_detail->is_item_cancel=="No"){
				$total_discount_amount+=$order_detail->discount_amount;
				$total_promo_amount+=$order_detail->promo_amount;
				$total_taxable+=$order_detail->taxable_value;
				$total_gst+=$order_detail->gst_value;
				$grand_total+=$order_detail->net_amount;
				$cancelOrder="No";
				
				//Item Cancle N0 in Challan Rows
				$query = $this->Orders->Challans->ChallanRows->query();
				$query->update()
						->set(['is_item_cancel' => 'No'])
						->where(['order_detail_id'=>$order_detail->id])
						->execute();
			}
		}
		if($cancelOrder=="Yes"){
			$query = $this->Orders->query();
			$query->update()
				->set(['order_status' =>'Cancel'])
				->where(['id'=>$order->id])
				->execute(); 
			$query = $this->Orders->Challans->query();
			$query->update()
					->set(['order_status' => 'Cancel'])
					->where(['order_id'=>$order->id])
					->execute();
			
		}else{
			$after_round_of=round($grand_total);
			$round_off=0;
			if($after_round_of!=$grand_total){
				$round_off=$after_round_of-$grand_total;
			}
			/* pr($round_off); exit;
			$round_off=$round_off;
			$grand_total=$after_round_of;
			$query = $this->Orders->query();
			$query->update()
					->set(['grand_total' => $after_round_of,'discount_amount' => $total_discount_amount,'delivery_charge_amount' => $order->delivery_charge_amount,'total_gst' => $total_gst,'total_amount' => $total_taxable,'round_off' => $round_off,'pay_amount' => $after_round_of+$order->delivery_charge_amount])
					->where(['id'=>$order->id])
					->execute();  */
		
		
			//Update In Challan
			
			
			$challans=$this->Orders->Challans->find()->where(['order_id'=>$id])->contain(['ChallanRows']);
			foreach($challans as $challan){
				$total_promo_amount=0;
				$total_discount_amount=0;
				$total_taxable=0;
				$total_gst=0;
				$grand_total=0;
				$cancelChallan="Yes";
					foreach($challan->challan_rows as $challan_row){
						if($challan_row->is_item_cancel=="No"){
							$total_discount_amount+=$challan_row->discount_amount;
							$total_promo_amount+=$challan_row->promo_amount;
							$total_taxable+=$challan_row->taxable_value;
							$total_gst+=$challan_row->gst_value;
							$grand_total+=$challan_row->net_amount;
							$cancelChallan="No";
						}
					}
					
					if($cancelChallan=="No"){  
						$after_round_of=round($grand_total);
						$round_off=0;
						if($after_round_of!=$grand_total){
							$round_off=$after_round_of-$grand_total;
						}
						
						$round_off=$round_off;
						$grand_total=$after_round_of;
						
						/* $query = $this->Orders->Challans->query();
						$query->update()
								->set(['grand_total' => $after_round_of,'discount_amount' => $total_discount_amount,'delivery_charge_amount' => $challan->delivery_charge_amount,'total_gst' => $total_gst,'total_amount' => $total_taxable,'round_off' => $round_off,'pay_amount' => $after_round_of+$challan->delivery_charge_amount])
								->where(['id'=>$challan->id])
								->execute();  */
						
					}else{ 
						$query = $this->Orders->Challans->query();
						$query->update()
								->set(['order_status' => 'Cancel'])
								->where(['id'=>$challan->id])
								->execute();
					}
				
			}
		}
		 exit;
	}
	
}
