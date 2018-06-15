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
          ->contain(['OrderDetails'=>['ItemVariations'=>['ItemVariationMasters','Items','UnitVariations'=>['Units']]]])
          ->where(['Orders.id'=>$order_id,'Orders.customer_id'=>$customer_id]);

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
                $order_details[] = ['category_name'=>$category_arr[$key],'category'=>$value];
              }

              $comboData =[];
              $comboData = $this->Orders->OrderDetails->find()
                ->innerJoinWith('ComboOffers')
                ->where(['order_id' => $order_id])
                ->contain(['ComboOffers'=>['ComboOfferDetails']])
                ->group('OrderDetails.combo_offer_id')->autoFields(true)->toArray();

              if(empty($comboData)) { $comboData = []; }
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
          $customer_id = $this->request->data['customer_id'];
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
            $carts_data=$this->Carts->find()->where(['customer_id'=>$customer_id])->contain(['ItemVariationsData'=>['ItemsDatas'],'ComboOffersData'=>['ComboOfferDetails'=>['ItemVariations'=>['Items'=>['GstFigures']]]]]);
			
            $i=0;
              foreach($carts_data as $carts_data_fetch)
              {  
				  if(!empty($carts_data_fetch->combo_offers_data)){
					 $total_combo_qty=$carts_data_fetch->cart_count;
					  foreach($carts_data_fetch->combo_offers_data->combo_offer_details as $combo_offer_detail){
						  
						/* $this->request->data['order_details'][$i]['item_id']=$carts_data_fetch->item_variation->item->id;
						$this->request->data['order_details'][$i]['item_variation_id']=$carts_data_fetch->item_variation_id;
						$this->request->data['order_details'][$i]['combo_offer_id']=$carts_data_fetch->combo_offer_id;
						$this->request->data['order_details'][$i]['quantity']=$carts_data_fetch->quantity;
						$this->request->data['order_details'][$i]['rate']=$carts_data_fetch->item_variation->sales_rate;
						$this->request->data['order_details'][$i]['amount']=$amount; */
						 // $amount=$carts_data_fetch->cart_count * $carts_data_fetch->item_variation->sales_rate;
						 
							$amount=$combo_offer_detail->quantity *$combo_offer_detail->rate;
							$this->request->data['order_details'][$i]['item_id']=$combo_offer_detail->item_variation->item_id;
							$this->request->data['order_details'][$i]['item_variation_id']=$combo_offer_detail->item_variation_id;
							$this->request->data['order_details'][$i]['combo_offer_id']=$carts_data_fetch->combo_offer_id;
							$this->request->data['order_details'][$i]['quantity']=$combo_offer_detail->quantity*$total_combo_qty;
							$this->request->data['order_details'][$i]['rate']=$combo_offer_detail->rate;
							$this->request->data['order_details'][$i]['amount']=$amount*$total_combo_qty;
							$this->request->data['order_details'][$i]['gst_figure_id']=$combo_offer_detail->item_variation->item->gst_figure_id;
							
						   $i++;
					   }
					  
				  } else{
					  
					$amount=$carts_data_fetch->cart_count * $carts_data_fetch->item_variations_data->sales_rate;
					$this->request->data['order_details'][$i]['item_id']=$carts_data_fetch->item_variations_data->item_id;
					$this->request->data['order_details'][$i]['item_variation_id']=$carts_data_fetch->item_variation_id;
					$this->request->data['order_details'][$i]['combo_offer_id']=$carts_data_fetch->combo_offer_id;
					$this->request->data['order_details'][$i]['quantity']=$carts_data_fetch->quantity;
					$this->request->data['order_details'][$i]['rate']=$carts_data_fetch->item_variations_data->sales_rate;
					$this->request->data['order_details'][$i]['amount']=$amount;
					$this->request->data['order_details'][$i]['gst_figure_id']=$carts_data_fetch->item_variations_data->items_data->gst_figure_id;
					$i++;
				  }
					
              }
			  
			 //$sales_ledgers = $this->Orders->Ledgers->find()->select(['id'])->where(['sales_account'=>1])->first()->toArray();
            $cash_bank = $this->Orders->Ledgers->find()->select(['id'])->where(['cash'=>1])->first()->toArray();
			//$total_amount=
			//pr($this->request->data); exit;
			$this->request->data['total_amount']=$this->request->data['grand_total_before_promoCode'];
			$this->request->data['grand_total']=$this->request->data['pay_Amount'];
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
            $order->location_id = $location_id;
            //$order->sales_ledger_id = $sales_ledgers['id'];
            $order->order_status = 'placed';

			$accountLedgers = $this->Orders->AccountingGroups->find()->where(['AccountingGroups.sale_invoice_sales_account'=>1,'AccountingGroups.city_id'=>$order->city_id])->first();
			$salesLedger = $this->Orders->Ledgers->find()->where(['Ledgers.accounting_group_id' =>$accountLedgers->id,'city_id'=>$order->city_id])->first();
			$order->sales_ledger_id=$salesLedger->id;
			if($order->order_type=="Online"){
				$LedgerData = $this->Orders->Ledgers->find()->where(['Ledgers.ccavenue' =>'yes','Ledgers.city_id'=>$order->city_id])->first();
				$order->party_ledger_id=$LedgerData->id;
			}else if($order->order_type="COD"){
				$LedgerData = $this->Orders->Ledgers->find()->where(['Ledgers.cash' =>'1','Ledgers.city_id'=>$order->city_id])->first();
				$order->party_ledger_id=$LedgerData->id;
			}  
			$p=$order->grand_total;
			$q=round($order->grand_total);
			$Round_off_amt=round(($p-$q),2);
			$order->grand_total=round($order->grand_total);	
			$order->round_off=$Round_off_amt;
			$order->order_from=="App"
			//pr($order); exit;
		
			if ($orders = $this->Orders->save($order)) {
				if($order->order_type=="Online"){
					// Cash Account Entry 
						$AccountingEntrie = $this->Orders->AccountingEntries->newEntity(); 
						$AccountingEntrie->ledger_id=$order->party_ledger_id;
						$AccountingEntrie->debit=$order->grand_total;
						$AccountingEntrie->credit=0;
						$AccountingEntrie->transaction_date=$order->order_date;
						$AccountingEntrie->city_id=$order->city_id;
						$AccountingEntrie->entry_from="App";
						$AccountingEntrie->order_id=$order->id;  
						$this->Orders->AccountingEntries->save($AccountingEntrie);
						
						// Sales Account Entry 
						$AccountingEntrie = $this->Orders->AccountingEntries->newEntity(); 
						$AccountingEntrie->ledger_id=$order->sales_ledger_id;
						$AccountingEntrie->credit=$order->total_amount;
						$AccountingEntrie->debit=0;
						$AccountingEntrie->transaction_date=$order->order_date;
						$AccountingEntrie->city_id=$order->city_id;
						$AccountingEntrie->entry_from="App";
						$AccountingEntrie->order_id=$order->id; 
						$this->Orders->AccountingEntries->save($AccountingEntrie);
						
						//round Off Entry
						$roundOffLedger = $this->Orders->Ledgers->find()->where(['Ledgers.round_off' =>'1','Ledgers.city_id'=>$order->city_id])->first();
						$AccountingEntrie = $this->Orders->AccountingEntries->newEntity(); 
						$AccountingEntrie->ledger_id=$roundOffLedger->id;
						if($Round_off_amt > 0){
							$AccountingEntrie->debit=$Round_off_amt;
							$AccountingEntrie->credit=0;
						}else{
						$AccountingEntrie->credit=$Round_off_amt;
						$AccountingEntrie->debit=0;
						}
						$AccountingEntrie->transaction_date=$order->order_date;
						$AccountingEntrie->city_id=$order->city_id;
						$AccountingEntrie->entry_from="App";
						$AccountingEntrie->order_id=$order->id; 
						if($Round_off_amt != 0){
							$this->Orders->AccountingEntries->save($AccountingEntrie);
						}
						
						if($order->delivery_charge_amount > 0){
								$TransportLedger = $this->Orders->Ledgers->find()->where(['Ledgers.transport' =>'Receive','Ledgers.city_id'=>$order->city_id])->first();
									$AccountingEntrie1 = $this->Orders->AccountingEntries->newEntity();
									$AccountingEntrie1->ledger_id=$TransportLedger->id;
									$AccountingEntrie1->credit=$order->delivery_charge_amount;
									$AccountingEntrie1->debit=0;
									$AccountingEntrie1->transaction_date=$order->order_date;
									$AccountingEntrie1->city_id=$order->city_id;
									$AccountingEntrie1->entry_from="App";
									$AccountingEntrie1->order_id=$order->id; 
									$this->Orders->AccountingEntries->save($AccountingEntrie1);
									
							}
						if($order->discount_amount > 0){
								$DiscountLedger = $this->Orders->Ledgers->find()->where(['Ledgers.discount' =>'Allowed','Ledgers.city_id'=>$order->city_id])->first();
									$AccountingEntrie1 = $this->Orders->AccountingEntries->newEntity();
									$AccountingEntrie1->ledger_id=$DiscountLedger->id;
									$AccountingEntrie1->debit=$order->discount_amount;
									$AccountingEntrie1->credit=0;
									$AccountingEntrie1->transaction_date=$order->order_date;
									$AccountingEntrie1->city_id=$order->city_id;
									$AccountingEntrie1->entry_from="App";
									$AccountingEntrie1->order_id=$order->id;
									$this->Orders->AccountingEntries->save($AccountingEntrie1);
									
							}
						
						$ReferenceDetail = $this->Orders->ReferenceDetails->newEntity(); 
						$ReferenceDetail->ledger_id=$order->party_ledger_id;
						$ReferenceDetail->debit=$order->grand_total;
						$ReferenceDetail->credit=0;
						$ReferenceDetail->transaction_date=$order->order_date;
						$ReferenceDetail->city_id=$order->city_id;
						$ReferenceDetail->entry_from="Web";
						$ReferenceDetail->type='New Ref';
						$ReferenceDetail->ref_name=$order->order_no;
						$ReferenceDetail->order_id=$order->id;
						$this->Orders->ReferenceDetails->save($ReferenceDetail);
						
						foreach($order->order_details as $order_detail){  //pr($order_detail); exit;
							$ItemData = $this->Orders->Items->find()->where(['Items.id'=>$order_detail->item_id])->contain(['GstFigures'])->first();
							$gstper=$ItemData->gst_figure->tax_percentage;
							$gst_value=$order_detail->amount*$gstper/100;
							$gstAmtdata=$gst_value/2;
							$gstAmtInsert=round($gstAmtdata,2);
							
							$gstLedgerCGST = $this->Orders->Ledgers->find()->where(['Ledgers.gst_figure_id' =>$ItemData->gst_figure_id, 'Ledgers.input_output'=>'output', 'Ledgers.gst_type'=>'CGST','city_id'=>$order->city_id])->first();
									
							//Accounting Entries for CGST//
							$gstLedgerCGST = $this->Orders->Ledgers->find()
							->where(['Ledgers.gst_figure_id' =>$ItemData->gst_figure_id, 'Ledgers.input_output'=>'output', 'Ledgers.gst_type'=>'CGST','city_id'=>$order->city_id])->first();
							$AccountingEntrieCGST = $this->Orders->AccountingEntries->newEntity();
							$AccountingEntrieCGST->ledger_id=$gstLedgerCGST->id;
							$AccountingEntrieCGST->credit=$gstAmtInsert;
							$AccountingEntrieCGST->debit=0;
							$AccountingEntrieCGST->transaction_date=$order->order_date;
							$AccountingEntrieCGST->city_id=$order->city_id;
							$AccountingEntrieCGST->entry_from="App";
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
							$AccountingEntrieSGST->transaction_date=$order->order_date;
							$AccountingEntrieSGST->city_id=$order->city_id;
							$AccountingEntrieSGST->entry_from="App";
							$AccountingEntrieSGST->order_id=$order->id;  
							if($gstAmtInsert > 0){
								$this->Orders->AccountingEntries->save($AccountingEntrieSGST);
							}
							
							$ItemVariationData = $this->Orders->OrderDetails->ItemVariations->get($order_detail->item_variation_id);
							$current_stock=$ItemVariationData->current_stock-$order_detail->quantity;
							//pr($current_stock); exit; 
							$out_of_stock="No";
							$ready_to_sale="Yes";
							if($current_stock <= 0){
								$ready_to_sale="No";
								$out_of_stock="Yes";
							}
							//pr($current_stock); exit;
							$query = $this->Orders->OrderDetails->ItemVariations->query();
							$query->update()
							->set(['current_stock'=>$current_stock,'out_of_stock'=>$out_of_stock,'ready_to_sale'=>$ready_to_sale])
							->where(['id'=>$order_detail->item_variation_id])
							->execute(); 
							
							 $query = $this->Orders->OrderDetails->query();
								$query->update()
								->set(['gst_figure_id'=>$ItemData->gst_figure_id,'gst_percentage'=>$ItemData->gst_figure->tax_percentage,'gst_value'=>$gst_value,'net_amount'=>$order_detail->amount+@$gst_value])
								->where(['id'=>$order_detail->id])
								->execute();
						}
					
				}else if($order->order_type=="COD"){
						foreach($order->order_details as $order_detail){
							
							$ItemData = $this->Orders->Items->find()->where(['Items.id'=>$order_detail->item_id])->contain(['GstFigures'])->first();
							$gstper=$ItemData->gst_figure->tax_percentage;
							$gst_value=$order_detail->amount*$gstper/100;
							
							$ItemVariationData = $this->Orders->OrderDetails->ItemVariations->get($order_detail->item_variation_id);
							$current_stock=$ItemVariationData->current_stock-$order_detail->quantity;
							//pr($order_detail->item_variation_id);
							$out_of_stock="No";
							$ready_to_sale="Yes";
							if($current_stock <= 0){
								$ready_to_sale="No";
								$out_of_stock="Yes";
							}
							//pr($current_stock); exit;
							$query = $this->Orders->OrderDetails->ItemVariations->query();
							$query->update()
							->set(['current_stock'=>$current_stock,'out_of_stock'=>$out_of_stock,'ready_to_sale'=>$ready_to_sale])
							->where(['id'=>$order_detail->item_variation_id])
							->execute(); 
							
							$query = $this->Orders->OrderDetails->query();
								$query->update()
								->set(['gst_figure_id'=>$ItemData->gst_figure_id,'gst_percentage'=>$ItemData->gst_figure->tax_percentage,'gst_value'=>$gst_value,'net_amount'=>$order_detail->amount+@$gst_value])
								->where(['id'=>$order_detail->id])
								->execute();
							
						}
				}else if($order->order_type=="Wallet"){
				
				}

                $message='Order placed successfully';
          			$success=true;
            }else
            { 
              $message='Order not placed';
        			$success=false;
            }
        }
        $this->set(compact('success', 'message'));
        $this->set('_serialize', ['success', 'message']);
}


}
