<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\View\View;
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
        $this->Security->setConfig('unlockedActions', ['add', 'index', 'view', 'manageOrder', 'ajaxDeliver','updateOrders','cancelOrder','invoiceManageOrder']);
		if (in_array($this->request->action, ['manageOrder'])) {
			 $this->eventManager()->off($this->Csrf);
		 }
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
	
		
        $this->paginate = [
            //'contain' => ['OrderDetails'=>['ItemVariations'],'SellerLedgers','PartyLedgers','Locations'],
			'limit' => 100
        ];
		
		$order_data=$this->Orders->find()->order(['Orders.id'=>'DESC'])->contain(['SellerLedgers','PartyLedgers','Locations','Customers'])->where(['Orders.city_id'=>$city_id]);

        $orders = $this->paginate($order_data);
		//pr( $orders); exit;
		$paginate_limit=$this->paginate['limit'];
        $this->set(compact('orders','paginate_limit'));
    }
	
	public function ajaxDeliver($id = null)
    {
		//$this->viewBuilder()->layout('');
		$city_id=$this->Auth->User('city_id');
         $Orders = $this->Orders->get($id, [
            'contain' => ['SellerLedgers','PartyLedgers','Locations','DeliveryTimes','Customers','CustomerAddresses', 'OrderDetails'=>['ItemVariations'=>['Items'], 'ComboOffers']]
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
	
	public function dispatch($ordr_id=null)
    {
	$ordr_id;
	$order = $this->Orders->get($ordr_id);
	$order->dispatch_flag='Active';
	$order->order_status='Dispatched';
	$order->dispatch_on= date('Y-m-d h:i:s a');
	$this->Orders->save($order);
	echo '<a class="btn btn-primary dlvr btn-condensed btn-sm" order_id="15"> Deliver</a>';
	exit;
	}
	
	public function packing($ordr_id=null)
    {
	$ordr_id;
	$order = $this->Orders->get($ordr_id);
	$order->packing_flag='Active';
	$order->order_status='Packed';
	$order->packing_on= date('Y-m-d h:i:s a');
	$this->Orders->save($order);
	
	$sms=str_replace(' ', '+', 'You are not Receiving Our Call to receive order, your order has been again return to warehouse of jainthla please collect from their');
	$sms_sender='JAINTE';
	$sms=str_replace(' ', '+', $sms);
	//file_get_contents('http://103.39.134.40/api/mt/SendSMS?user=phppoetsit&password=9829041695&senderid='.$sms_sender.'&channel=Trans&DCS=0&flashsms=0&number='.$mob.'&text='.$sms.'&route=7');
	echo '<button class="btn btn-warning  btn-condensed btn-sm dsptch" type="submit">Dispatch</button>';
	exit;
	}
	
	
	public function cancel($ordr_id=null, $customer_id=null)
    {
	$ordr_id;
	$order = $this->Orders->get($ordr_id);
	$order->order_status='Cancel';
	$order->packing_on= date('Y-m-d h:i:s a');
	$this->Orders->save($order);
	
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
	$ordr_id;
	$cancel_reason_id;
	$customer_id;
	$ordr_id;
	$order = $this->Orders->get($ordr_id);
	$order->order_status='Cancel';
	$order->cancel_reason_id=$cancel_reason_id;
	
	$data=$this->Orders->save($order);
	
	$customer = $this->Orders->Customers->get($customer_id);
	$mob=$customer->username;
	$cancel_count=$customer->cancel_order_count;
	$customer->cancel_order_count=$cancel_count+1;
	$this->Orders->Customers->save($customer);
	
	$sms=str_replace(' ', '+', 'Your order has been cancel');
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
							return $q->where(['ItemVariations.seller_id'=>$seller_id])->contain(['Sellers']);
						}]])->where($where);
		
			  $orders->innerJoinWith('OrderDetails.ItemVariations',function ($q) use($seller_id) {
							return $q->where(['ItemVariations.seller_id'=>$seller_id])->contain(['Sellers']);
						})->group('OrderDetails.order_id')
					->autoFields(true);

			//pr($orders->toArray()); exit;
		}else{
			
			 $orders=$this->Orders->find()->contain(['Locations','PartyLedgers'=>['CustomerData'],'OrderDetails'=>['Items','ItemVariations'=>function ($q) {
							return $q->where(['ItemVariations.seller_id IS NULL']);
						}]])->where($where);
			//pr($orders->toArray()); exit;
			  $orders->innerJoinWith('OrderDetails.ItemVariations',function ($q)  {
							return $q->where(['ItemVariations.seller_id IS NULL']);
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
			$query = $this->Orders->Invoices->InvoiceRows->query();
			$query->update()
					->set(['is_item_cancel' => 'Yes'])
					->where(['invoice_id'=>$NewOrder['order_id']])
					->execute();
			 $order = $this->Orders->Invoices->get($NewOrder['order_id']);
			//pr($NewOrder); 
			//pr($order->order_type);  exit;
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
					if($order->order_type == "COD"){
						
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
				}else if($order->order_type == "online" ){ 
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
					
				}else if($order->order_type ==  "Wallet"){ 
						if($order->grand_total == $NewOrder['grand_total']){
							//echo $order; exit;
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
							$AccountingEntrie->invoice_id=$order->id;  
							$this->Orders->AccountingEntries->save($AccountingEntrie);
							
						
						}else if($order->grand_total > $NewOrder['grand_total']){  //echo "change"; exit;
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
							$AccountingEntrie->invoice_id=$order->id;  
							$this->Orders->AccountingEntries->save($AccountingEntrie);
						
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
						exit;
						
					}else if($order->order_type == "Wallet/Online"){ // pr($NewOrder['grand_total']); exit;
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
			
			$order_data=$this->Orders->find()->where(['Orders.order_status'=>$status])->order(['Orders.id'=>'DESC'])->contain(['SellerLedgers','PartyLedgers','Locations','DeliveryTimes','Customers','CustomerAddressesLeft','Drivers']);
		}else{
			
			$order_data=$this->Orders->find()->order(['Orders.id'=>'DESC'])->contain(['SellerLedgers','PartyLedgers','Locations','DeliveryTimes','Customers','CustomerAddressesLeft','Drivers']);
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
			
			$Voucher_no = $this->Orders->Invoices->find()->select(['voucher_no'])->where(['Invoices.city_id'=>$city_id,'Invoices.financial_year_id'=>$financial_year_id])->order(['voucher_no' => 'DESC'])->first();
			//pr($Voucher_no); exit;
			if($Voucher_no){$voucher_no=$Voucher_no->voucher_no+1;}
			else{$voucher_no=1;}
			$order_no=$CityData->alise_name.'/IN/'.$voucher_no;
			$order_no=$StateData->alias_name.'/'.$order_no;
			
			$sellerLedgerData = $this->Orders->AccountingEntries->Ledgers->find()->where(['seller_id'=>$key])->first();
			
			$Invoice = $this->Orders->Invoices->newEntity(); 
			$Invoice->seller_id=$key;
			$Invoice->order_id=$id;
			$Invoice->location_id=$order->location_id;
			$Invoice->delivery_date=$order->delivery_date;
			$Invoice->delivery_time_id=$order->delivery_time_id;
			$Invoice->delivery_time_sloat=$order->delivery_time_sloat;
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
			if($this->Orders->Invoices->save($Invoice)){
				
			}else{
				
			}
			$total_promo_amount=0;
			$total_discount_amount=0;
			$total_taxable=0;
			$total_gst=0;
			$grand_total=0;
			foreach($Totalseller as $data){  
					$InvoiceRow = $this->Orders->Invoices->InvoiceRows->newEntity(); 
					$InvoiceRow->invoice_id=$Invoice->id;
					$InvoiceRow->order_detail_id=$data->id;
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
					$this->Orders->Invoices->InvoiceRows->save($InvoiceRow);
					
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
			
			
			$query = $this->Orders->Invoices->query();
			$query->update()
					->set(['grand_total' => $after_round_of,'discount_amount' => $total_discount_amount,'delivery_charge_amount' => $Invoice->delivery_charge_amount,'total_gst' => $total_gst,'total_amount' => $total_taxable,'round_off' => $round_off,'pay_amount' => $after_round_of+$Invoice->delivery_charge_amount])
					->where(['id'=>$Invoice->id])
					->execute();
		}
		
		foreach($Jainsellers as $key=>$Jainseller){
			$Voucher_no = $this->Orders->Invoices->find()->select(['voucher_no'])->where(['Invoices.city_id'=>$city_id,'Invoices.financial_year_id'=>$financial_year_id])->order(['voucher_no' => 'DESC'])->first();
			if($Voucher_no){$voucher_no=$Voucher_no->voucher_no+1;}
			else{$voucher_no=1;}
			$order_no=$CityData->alise_name.'/IN/'.$voucher_no;
			$order_no=$StateData->alias_name.'/'.$order_no;
			
			$Invoice = $this->Orders->Invoices->newEntity(); 
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
			$Invoice->transaction_date=$order->order_date;
			$Invoice->order_status=$order->order_status;
			$Invoice->delivery_charge_amount=@$order->delivery_charge_amount/$totalSellerCount; 
			$Invoice->location_id=$order->location_id;
			$Invoice->delivery_date=$order->delivery_date;
			$Invoice->delivery_time_id=$order->delivery_time_id;
			$Invoice->delivery_time_sloat=$order->delivery_time_sloat;
			$Invoice->customer_address_id=$order->customer_address_id; //pr($Invoice); exit;
			if($this->Orders->Invoices->save($Invoice)){
				
			}else{
				
			}
			$total_promo_amount=0;
			$total_discount_amount=0;
			$total_taxable=0;
			$total_gst=0;
			$grand_total=0;
			foreach($Jainseller as $data){ 
					$InvoiceRow = $this->Orders->Invoices->InvoiceRows->newEntity(); 
					$InvoiceRow->invoice_id=$Invoice->id;
					$InvoiceRow->order_detail_id=$data->id;
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
					$this->Orders->Invoices->InvoiceRows->save($InvoiceRow); 
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
			
			
			$query = $this->Orders->Invoices->query();
			$query->update()
					->set(['grand_total' => $after_round_of,'discount_amount' => $total_discount_amount,'delivery_charge_amount' => $Invoice->delivery_charge_amount,'total_gst' => $total_gst,'total_amount' => $total_taxable,'round_off' => $round_off,'pay_amount' => $after_round_of+$Invoice->delivery_charge_amount])
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
		
		$this->Flash->success(__('The Invoice has been saved.'));
        return $this->redirect(['action' => 'invoiceManageOrder']);
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
		$Orders=$this->Orders->find()->where(['Orders.id'=>$id])->contain(['DeliveryTimes','OrderDetails'=>['ItemVariations'=>['ItemVariationMasters','Items','UnitVariations'=>['Units']]], 'Customers'=>['CustomerAddresses']])->first();
		//pr($Orders); exit;
		$company_details=$this->Orders->Companies->find()->where(['Companies.city_id'=>$city_id])->first();
        $this->set(compact('ids', 'sales_orders', 'Orders', 'locations', 'customers', 'drivers', 'customerAddresses', 'promotionDetails', 'deliveryCharges', 'deliveryTimes', 'cancelReasons','order_no','partyOptions','Accountledgers','items','company_details','id'));
	}
	
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
        $order = $this->Orders->newEntity();
		$CityData = $this->Orders->Cities->get($city_id);
		$StateData = $this->Orders->Cities->States->get($CityData->state_id);
	 
		$this->loadmodel('SalesOrders');
		$sales_orders=$this->Orders->find()->where(['Orders.id'=>$ids])->contain(['DeliveryTimes','OrderDetails'=>['ItemVariations'=>['ItemVariationMasters','Items','UnitVariations'=>['Units']]], 'Customers'=>['CustomerAddresses']])->first();
		 
		$company_details=$this->Orders->Companies->find()->where(['Companies.city_id'=>$city_id])->first();
        $this->set(compact('ids', 'sales_orders', 'order', 'locations', 'customers', 'drivers', 'customerAddresses', 'promotionDetails', 'deliveryCharges', 'deliveryTimes', 'cancelReasons','order_no','partyOptions','Accountledgers','items','company_details'));
    }
	
	public function pdfView($id = null)
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
	// pr($ids); exit;
		$this->loadmodel('SalesOrders');
		$Orders=$this->Orders->get($ids,['contain'=>['OrderDetails'=>['ItemVariations','Items'],'Customers'=>['CustomerAddresses'],'CustomerAddresses']]);
		//pr($Orders); exit;
		$company_details=$this->Orders->Companies->find()->where(['Companies.city_id'=>$city_id])->first();
        $this->set(compact('ids', 'sales_orders', 'order', 'locations', 'customers', 'drivers', 'customerAddresses', 'promotionDetails', 'deliveryCharges', 'deliveryTimes', 'cancelReasons','order_no','partyOptions','Accountledgers','items','company_details','Orders'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($id=null)
    {
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
	
		$Voucher_no = $this->Orders->find()->select(['voucher_no'])->where(['Orders.city_id'=>$city_id,'Orders.financial_year_id'=>$financial_year_id])->order(['voucher_no' => 'DESC'])->first();
		if($Voucher_no){$voucher_no=$Voucher_no->voucher_no+1;}
		else{$voucher_no=1;}
		$order_no=$CityData->alise_name.'/'.$voucher_no;
		$order_no=$StateData->alias_name.'/'.$order_no;
		//pr($order_no); exit;
		//pr($voucher_no); exit;
		
		$this->loadmodel('DeliveryCharges');
		$deliveryCharges=$this->DeliveryCharges->find()->where(['DeliveryCharges.city_id'=>$city_id, 'DeliveryCharges.status'=>'Active'])->first();
		$this->loadmodel('SalesOrders');
		if(!empty($ids)){
		$sales_orders=$this->SalesOrders->find()->where(['SalesOrders.id'=>$ids])->contain(['SalesOrderRows'])->first();
		
		$sales_combos=$this->SalesOrders->SalesOrderRows->find()->where(['SalesOrderRows.sales_order_id'=>$ids,'SalesOrderRows.combo_offer_id !='=>'NULL'])->contain(['ComboOffers']);
		
		$sales_combo_count=$this->SalesOrders->SalesOrderRows->find()->where(['SalesOrderRows.sales_order_id'=>$ids,'SalesOrderRows.combo_offer_id !='=>'NULL'])->count();
		 
		}
		
        if ($this->request->is('post')) {
			
			if(!empty($ids)){
			$query1 = $this->Orders->SalesOrders->query();
							$query1->update()
							->set(['status'=>'Yes'])
							->where(['id'=>$ids])
							->execute();
			}
			
			
            $order = $this->Orders->patchEntity($order, $this->request->getData());
			$Voucher_no = $this->Orders->find()->select(['voucher_no'])->where(['Orders.city_id'=>$city_id,'Orders.financial_year_id'=>$financial_year_id])->order(['voucher_no' => 'DESC'])->first(); 
			
			@$promotion_detail_id=$this->request->data('promotion_detail_id');
			@$amount_from_wallet=$this->request->data('amount_from_wallet');
			
			if($Voucher_no){$voucher_no=$Voucher_no->voucher_no+1;}
			else{$voucher_no=1;} 
			$order->financial_year_id=$financial_year_id;
			$order->city_id=$city_id;
			$order->delivery_date=date('Y-m-d', strtotime($this->request->getData('delivery_date')));
			$order->order_from="Web";
			$order->location_id=$location_id;
			$order->voucher_no=$voucher_no;
			$order->order_status="placed";
			$order->transaction_date=date('Y-m-d',strtotime($order->transaction_date));
			$Custledgers = $this->Orders->SellerLedgers->get($order->party_ledger_id,['contain'=>['Customers'=>['Cities']]]);
			
			if ($this->Orders->save($order)) {
				 
				 if($amount_from_wallet>0){
					$query = $this->Orders->Wallets->query();
					$query->insert(['customer_id', 'order_id', 'used_amount', 'transaction_type', 'amount_type', 'city_id'])
							->values([
							'customer_id' => $order->customer_id,
							'order_id' => $order->id,
							'used_amount' => $amount_from_wallet,
							'transaction_type' => 'Deduct',
							'amount_type' => 'order',
							'city_id' => $city_id
							])
					->execute();
				 }
					
					if($order->promotion_detail_id>0){
						$this->loadmodel('UsesCustomerPromotions');
						$this->loadmodel('PromotionDetails');
						$promotionDetails = $this->PromotionDetails->get($order->promotion_detail_id);
						$query = $this->UsesCustomerPromotions->query();
						$query->insert(['customer_id', 'promotion_detail_id', 'promotion_id'])
								->values([
								'customer_id' => $order->customer_id,
								'promotion_detail_id' => $order->promotion_detail_id,
								'promotion_id' => $promotionDetails->promotion_id
								])
						->execute();
					}
					
					
					if($order->order_type=="Credit"){
						if($Custledgers->customer->city->state_id==$state_id){
							foreach($order->order_details as $order_detail){ 
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
								 
								$query = $this->Orders->OrderDetails->ItemVariations->query();
								$query->update()
								->set(['current_stock'=>$final_cs,'demand_stock'=>$final_ds,'out_of_stock'=>$out_of_stock,'ready_to_sale'=>$ready_to_sale])
								->where(['id'=>$order_detail->item_variation_id])
								->execute(); 
						   }
						}else{
							foreach($order->order_details as $order_detail){ 
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
								 
								
								$query = $this->Orders->OrderDetails->ItemVariations->query();
								$query->update()
								->set(['current_stock'=>$final_cs,'demand_stock'=>$final_ds,'out_of_stock'=>$out_of_stock,'ready_to_sale'=>$ready_to_sale])
								->where(['id'=>$order_detail->item_variation_id])
								->execute(); 
							 }
						}
						
				}else if($order->order_type=="Cod"){
					if($Custledgers->customer->city->state_id==$state_id){ 
								foreach($order->order_details as $order_detail){ 
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
							}else{
								foreach($order->order_details as $order_detail){ 
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
								  
									$query = $this->Orders->OrderDetails->ItemVariations->query();
									$query->update()
									->set(['current_stock'=>$final_cs,'demand_stock'=>$final_ds,'out_of_stock'=>$out_of_stock,'ready_to_sale'=>$ready_to_sale])
									->where(['id'=>$order_detail->item_variation_id])
									->execute(); 
							   }
							}
				}else if($order->order_type=="OnLine"){
					if($Custledgers->customer->city->state_id==$state_id){ 
								foreach($order->order_details as $order_detail){ 
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
							}else{
								foreach($order->order_details as $order_detail){ 
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
								 
									$query = $this->Orders->OrderDetails->ItemVariations->query();
									$query->update()
									->set(['current_stock'=>$final_cs,'demand_stock'=>$final_ds,'out_of_stock'=>$out_of_stock,'ready_to_sale'=>$ready_to_sale])
									->where(['id'=>$order_detail->item_variation_id])
									->execute(); 
							   }
							}
					}
					
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
		$partyOptions=[];
		foreach($Partyledgers as $Partyledger){
		
			$customer_address=$this->Orders->CustomerAddresses->find()->where(['CustomerAddresses.customer_id'=>$Partyledger->customer_id,'CustomerAddresses.default_address'=>1,'CustomerAddresses.is_deleted'=>0])->first();
			$customer_address_count=$this->Orders->CustomerAddresses->find()->where(['CustomerAddresses.customer_id'=>$Partyledger->customer_id,'CustomerAddresses.default_address'=>1,'CustomerAddresses.is_deleted'=>0])->count();
			if(!empty($customer_address_count)){
				@$customer_address_id=@$customer_address->id;
			}else{
				@$customer_address_id=0;
			}
			
			$customer_id=$Partyledger->customer_id;
			
			
			
			
			$this->loadmodel('Wallets');
			$query1 = $this->Wallets->find();
		$totalInCase = $query1->newExpr()
			->addCase(
				$query1->newExpr()->add(['add_amount > ' => 0]),
				$query1->newExpr()->add(['add_amount']),
				'integer'
			); 
		$totalOutCase = $query1->newExpr()
			->addCase(
				$query1->newExpr()->add(['used_amount > ' => 0]),
				$query1->newExpr()->add(['used_amount']),
				'integer'
			);
			$query1->select([
			'total_advanced' => $query1->func()->sum($totalInCase),
			'total_consumed' => $query1->func()->sum($totalOutCase),'id','customer_id'
		])
		->where(['Wallets.customer_id' => $customer_id])
		->autoFields(true);
		$wallets = ($query1);
		foreach($wallets as $wallet){
			
			$total_advanced=$wallet->total_advanced;
			$total_consumed=$wallet->total_consumed;
			$wallet_remaining=$total_advanced-$total_consumed;
			
		}
			
			
			$partyOptions[]=['text' =>$Partyledger->name, 'value' => $Partyledger->id,'city_id'=>$Partyledger->customer->city->id,'state_id'=>$Partyledger->customer->city->state_id,'bill_to_bill_accounting'=>$Partyledger->bill_to_bill_accounting,'customer_id'=>$Partyledger->customer_id,'customer_address_id'=>$customer_address_id,'membership_discount'=>$Partyledger->customer->membership_discount,'membership_start_date'=>$Partyledger->customer->start_date,'membership_end_date'=>$Partyledger->customer->end_date,'wallet'=>$wallet_remaining];
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
		
		/* $itemList=$this->Orders->Items->find()->contain(['ItemVariations'=> function ($q) {
								return $q
								->where(['ItemVariations.seller_id is NULL','ItemVariations.status'=>'Active','current_stock >'=>'0'])->contain(['UnitVariations'=>['Units']]);
								}]); */
		$itemList=$this->Orders->Items->find()->contain(['ItemVariations'=> function ($q) use($city_id){
								return $q 
								->where(['ItemVariations.status'=>'Active','ItemVariations.city_id '=>$city_id])->contain(['UnitVariations'=>['Units']]);
								}]);
		//pr($itemList->toArray()); exit;
		$items=array();
		foreach($itemList as $data1){ 
			foreach($data1->item_variations as $data){
				$discount_applicable=$data1->is_discount_enable;
				$category_id=$data1->category_id;
				$gstData=$this->Orders->GstFigures->get($data1->gst_figure_id);
				$merge=$data1->name.'('.@$data->unit_variation->visible_variation.')';
				$items[]=['text' => $merge,'value' => $data->id,'item_id'=>$data1->id,'quantity_factor'=>@$data->unit_variation->convert_unit_qty,'unit'=>@$data->unit_variation->unit->unit_name,'gst_figure_id'=>$data1->gst_figure_id,'gst_value'=>$gstData->tax_percentage,'commission'=>@$data->commission,'sale_rate'=>$data->sales_rate,'current_stock'=>$data->current_stock,'virtual_stock'=>$data->virtual_stock,'demand_stock'=>$data->demand_stock,'discount_applicable'=>$discount_applicable,'category_id'=>$category_id];
			}
		}
		
		
		$deliveryTmes = $this->Orders->DeliveryTimes->find()->where(['DeliveryTimes.city_id'=>$city_id, 'DeliveryTimes.status'=>'Active']);
		
		foreach($deliveryTmes as $deliveryTmes_data){
			
			$time_from=$deliveryTmes_data->time_from;
			$time_to=$deliveryTmes_data->time_to;
			$show_time=$time_from.' - '.$time_to;
			$deliveryTimes[]=['text' => $show_time,'value' => $deliveryTmes_data->id];
		}
		
		$this->loadmodel('DeliveryCharges');
		$deliveryCharges=$this->DeliveryCharges->find()->where(['DeliveryCharges.city_id'=>$city_id, 'DeliveryCharges.status'=>'Active'])->first();
		
		$this->loadmodel('DeliveryDates');
		$deliverydates=$this->DeliveryDates->find()->where(['DeliveryDates.city_id'=>$city_id, 'DeliveryDates.status'=>'Active'])->first();
		
		$this->loadmodel('Holidays');
		$holidays=$this->Holidays->find()->where(['Holidays.city_id'=>$city_id]);
		
		$next_day=$deliverydates->next_day;
		$same_day=$deliverydates->same_day;
		  
		if($same_day=='Active'){
			$g=0;
		}else if($same_day=='Deactive'){
			$g=1;
		}
		  
		$start_date=date('Y-m-d', strtotime("+".$g."days"));
		$last_date=date('Y-m-d', strtotime("+".$next_day."days"));
		
		$holiday_count=$this->Holidays->find()->where(['Holidays.city_id'=>$city_id,'Holidays.date >='=>$start_date,'Holidays.date <='=>$last_date])->count();
		
		$this->loadmodel('CustomerPromotions');
		$customer_promotions=$this->CustomerPromotions->find()->where(['CustomerPromotions']);
		
		$this->loadmodel('ComboOffers');
		$combos=$this->ComboOffers->find('list')->where(['ComboOffers.out_of_stock'=>'No','ComboOffers.ready_to_sale'=>'Yes','ComboOffers.status'=>'Active']);
		
        $this->set(compact('ids', 'sales_orders', 'order', 'locations', 'customers', 'drivers', 'customerAddresses', 'promotionDetails', 'deliveryCharges', 'deliveryTimes', 'cancelReasons','order_no','partyOptions','Accountledgers','items','deliverydates','holidays','holiday_count','combos'));
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
}
