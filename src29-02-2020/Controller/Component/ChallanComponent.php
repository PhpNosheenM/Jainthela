<?php
namespace App\Controller\Component;
use App\Controller\AppController;
use Cake\Controller\Component;
use Cake\ORM\TableRegistry;

require_once(ROOT . DS  .'vendor' . DS  .  'autoload.php');

class ChallanComponent extends Component
{
	function initialize(array $config) 
	{
		parent::initialize($config);
	}

	public function challanAdd($id = null)
    { 
		
		$this->Challans = TableRegistry::get('Challans');
		$this->ChallanRows = TableRegistry::get('ChallanRows');
		$this->Orders = TableRegistry::get('Orders');
		$order = $this->Orders->get($id, [
            'contain' => ['OrderDetails'=>['ItemVariations'=>['Items'=>['GstFigures']]]]
        ]);
		
		
		$today=date('Y-m-d');
		//$today=date('2019-04-01');
		//pr($order->toArray()); exit;
		$this->FinancialYears = TableRegistry::get('FinancialYears');
		$FinancialYear = $this->FinancialYears->find()->where(['city_id'=>$order->city_id,'fy_from <='=>$today,'fy_to >='=>$today])->first();
		
		$this->Cities = TableRegistry::get('Cities');
		$CityData = $this->Cities->get($order->city_id);
		
		$financial_year_id=$FinancialYear->id;	
		$city_id=$order->city_id; 
		$location_id=$order->location_id;
		$state_id=$CityData->state_id;
		
		//$order = $this->Orders->newEntity();
		$this->States = TableRegistry::get('States');
		$StateData = $this->States->get($state_id);
		$today_date=date("Y-m-d");
		$orderdate = explode('-', $today_date);
		$year = $orderdate[0];
		$month   = $orderdate[1];
		$day  = $orderdate[2];
		
		$Totalsellers=[];
		$Jainsellers=[];
		$sellersum=0;
		//pr($order); exit;
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
		/* pr($Jainsellers);
		pr($Totalsellers);
		pr($totalSellerCount); exit; */
		foreach($Totalsellers as $key=>$Totalseller){
			
			$Voucher_no = $this->Challans->find()->select(['voucher_no'])->where(['Challans.city_id'=>$city_id,'Challans.financial_year_id'=>$financial_year_id])->order(['voucher_no' => 'DESC'])->first();
			//pr($Voucher_no); exit;
			if($Voucher_no){$voucher_no=$Voucher_no->voucher_no+1;}
			else{$voucher_no=1;}
			$vn=str_pad($voucher_no, 7, '0', STR_PAD_LEFT);
			$order_no='CH/'.$vn;
			//$order_no=$StateData->alias_name.'/'.$order_no;
			
			
			$this->Ledgers = TableRegistry::get('Ledgers');
			$sellerLedgerData = $this->Ledgers->find()->where(['Ledgers.seller_id'=>$key])->first();
			
			//$sellerLedgerData = $this->Orders->AccountingEntries->Ledgers->find()->where(['seller_id'=>$key])->first();
			
			$Invoice = $this->Challans->newEntity(); 
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
			$Invoice->payment_status=$order->payment_status;
			$Invoice->order_date=$order->order_date;
			$Invoice->transaction_date=$order->order_date;
			$Invoice->order_status=$order->order_status;
			$Invoice->where_challan=$order->order_from;
			$Invoice->delivery_charge_amount=@$order->delivery_charge_amount/$totalSellerCount;  
			if($this->Challans->save($Invoice)){
				
			}else{
				
			}
			$total_promo_amount=0;
			$total_discount_amount=0;
			$total_taxable=0;
			$total_gst=0;
			$grand_total=0;
			foreach($Totalseller as $data){  
					$InvoiceRow = $this->ChallanRows->newEntity(); 
					$InvoiceRow->challan_id=$Invoice->id;
					$InvoiceRow->order_detail_id=$data->id;
					$InvoiceRow->item_id=$data->item_id;
					$InvoiceRow->item_variation_id=$data->item_variation_id;
					$InvoiceRow->combo_offer_id=$data->combo_offer_id;
					$InvoiceRow->quantity=$data->quantity;
					$InvoiceRow->actual_quantity=$data->quantity;
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
					$this->ChallanRows->save($InvoiceRow);
					
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
			
			
			$query = $this->Challans->query();
			$query->update()
					->set(['grand_total' => $after_round_of,'discount_amount' => $total_discount_amount+@$total_promo_amount,'delivery_charge_amount' => $Invoice->delivery_charge_amount,'total_gst' => $total_gst,'total_amount' => $total_taxable,'round_off' => $round_off,'pay_amount' => $after_round_of+$Invoice->delivery_charge_amount,'old_pay_amount' => $after_round_of+$Invoice->delivery_charge_amount])
					->where(['id'=>$Invoice->id])
					->execute();
		}
		
		foreach($Jainsellers as $key=>$Jainseller){
			
			
			$Voucher_no = $this->Challans->find()->select(['voucher_no'])->where(['Challans.city_id'=>$city_id,'Challans.financial_year_id'=>$financial_year_id])->order(['voucher_no' => 'DESC'])->first();
			
			
			if($Voucher_no){$voucher_no=$Voucher_no->voucher_no+1;}
			else{$voucher_no=1;}
			
			$vn=str_pad($voucher_no, 7, '0', STR_PAD_LEFT);
			$order_no='CH/'.$vn;
			
			//$order_no=$CityData->alise_name.'/CH/'.$voucher_no;
			//$order_no=$StateData->alias_name.'/'.$order_no;
			
			$Invoice = $this->Challans->newEntity(); 
			$Invoice->seller_id=NULL;
			$Invoice->order_id=$id;
			$Invoice->voucher_no=$voucher_no;
			$Invoice->invoice_no=$order_no;
			$Invoice->seller_name="JainThela";
			$Invoice->order_type=$order->order_type;
			$Invoice->payment_status=$order->payment_status;
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
			$Invoice->customer_address_id=$order->customer_address_id; 
			$Invoice->where_challan=$order->order_from;
			if($this->Challans->save($Invoice)){
				
			}else{
				
			} 
			$total_promo_amount=0;
			$total_discount_amount=0;
			$total_taxable=0;
			$total_gst=0;
			$grand_total=0;
			foreach($Jainseller as $data){ 
					$InvoiceRow = $this->ChallanRows->newEntity(); 
					$InvoiceRow->challan_id=$Invoice->id;
					$InvoiceRow->order_detail_id=$data->id;
					$InvoiceRow->item_id=$data->item_id;
					$InvoiceRow->item_variation_id=$data->item_variation_id;
					$InvoiceRow->combo_offer_id=$data->combo_offer_id;
					$InvoiceRow->quantity=$data->quantity;
					$InvoiceRow->actual_quantity=$data->quantity;
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
					$this->ChallanRows->save($InvoiceRow); 
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
			
			
			$query = $this->Challans->query();
			$query->update()
					->set(['grand_total' => $after_round_of,'discount_amount' => $total_discount_amount+@$total_promo_amount,'delivery_charge_amount' => $Invoice->delivery_charge_amount,'total_gst' => $total_gst,'total_amount' => $total_taxable,'round_off' => $round_off,'pay_amount' => $after_round_of+$Invoice->delivery_charge_amount,'old_pay_amount' => $after_round_of+$Invoice->delivery_charge_amount])
					->where(['id'=>$Invoice->id])
					->execute();
		}
		
		//	Payment History
		$this->OrderPaymentHistories = TableRegistry::get('OrderPaymentHistories');
		 $OrderPaymentHistory = $this->OrderPaymentHistories->newEntity();
		 $OrderPaymentHistory->order_id=$order->id;
		 $OrderPaymentHistory->online_amount=$order->online_amount;
		 $OrderPaymentHistory->wallet_amount=$order->amount_from_wallet;
		 if($order->order_type=="COD"){
			$OrderPaymentHistory->cod_amount=$order->pay_amount;
		 }
		 $OrderPaymentHistory->total=$order->pay_amount;
		 $OrderPaymentHistory->entry_from="Order";
		 $this->OrderPaymentHistories->save( $OrderPaymentHistory); 
		 
		 return true;
		//
		 
        //return $this->redirect(['action' => 'index']);
	}

	
	
}
?>