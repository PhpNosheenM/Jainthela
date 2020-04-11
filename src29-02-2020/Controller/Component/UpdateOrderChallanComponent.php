<?php
namespace App\Controller\Component;
use App\Controller\AppController;
use Cake\Controller\Component;
use Cake\ORM\TableRegistry;

require_once(ROOT . DS  .'vendor' . DS  .  'autoload.php');

class UpdateOrderChallanComponent extends Component
{
	function initialize(array $config) 
	{
		parent::initialize($config);
	}

	public function UpdateChallanOrder($id = null,$status = null)
    { 
		
		$this->Challans = TableRegistry::get('Challans');
		$this->ChallanRows = TableRegistry::get('ChallanRows');
		$this->Orders = TableRegistry::get('Orders');
		$this->Items = TableRegistry::get('Items');
		$this->ItemVariations = TableRegistry::get('ItemVariations');
		$this->UnitVariations = TableRegistry::get('UnitVariations');
		$order = $this->Orders->get($id, [
            'contain' => ['OrderDetails'=>['ItemVariations'=>['Items'=>['GstFigures']]]]
        ]);
		
		/* //$user_id=$this->Auth->User('id');
		$order = $this->Orders->get($id, [
            'contain' => ['OrderDetails'=>['ItemVariations'=>['Items'=>['GstFigures']]]]
        ]); */
		
		$total_promo_amount=0;
		$total_discount_amount=0;
		$total_taxable=0;
		$total_gst=0;
		$grand_total=0;
		$cancelOrder="Yes";
		
		foreach($order->order_details as $order_detail){ 
			if($order_detail->is_item_cancel=="Yes"){
				//Item Cancle Yes in Challan Rows
				if(!empty($status))
				{
					$query = $this->ChallanRows->query();
					$query->update()
							->set(['is_item_cancel' => 'Yes','item_status' =>$status])
							->where(['order_detail_id'=>$order_detail->id])
							->execute();					
				}

				//calculation
			}else if($order_detail->is_item_cancel=="No"){
				$total_discount_amount+=$order_detail->discount_amount;
				$total_promo_amount+=$order_detail->promo_amount;
				$total_taxable+=$order_detail->taxable_value;
				$total_gst+=$order_detail->gst_value;
				$grand_total+=$order_detail->net_amount;
				$cancelOrder="No";
				
				//Item Cancle N0 in Challan Rows
				$query = $this->ChallanRows->query();
				$query->update()
						->set(['is_item_cancel' => 'No'])
						->where(['order_detail_id'=>$order_detail->id])
						->execute();
						
				$query = $this->ChallanRows->query();
				$query->update()
						->set(['discount_amount'=>$order_detail->discount_amount,'promo_amount'=>$order_detail->promo_amount,'taxable_value'=>$order_detail->taxable_value,'gst_value'=>$order_detail->gst_value,'promo_percent'=>$order_detail->promo_percent,'net_amount'=>$order_detail->net_amount])
						->where(['order_detail_id'=>$order_detail->id])
						->execute();
			}
		}
		//pr($cancelOrder); exit;
		if($cancelOrder=="Yes"){
			if(!empty($status))
			{
				$query = $this->Orders->query();
				$query->update()
				->set(['order_status' =>$status])
				->where(['id'=>$order->id])
				->execute();				
			}
 
			if(!empty($status))
			{
				$query = $this->Challans->query();
				$query->update()
						->set(['order_status' => $status])
						->where(['order_id'=>$order->id])
						->execute();				
			}
 

			//New Code For Cancle order
			$total_promo_amount=0;
			$total_discount_amount=0;
			$total_taxable=0;
			$total_gst=0;
			$grand_total=0;		
			foreach($order->order_details as $order_detail){ 
				$total_discount_amount+=$order_detail->discount_amount;
				$total_promo_amount+=$order_detail->promo_amount;
				$total_taxable+=$order_detail->taxable_value;
				$total_gst+=$order_detail->gst_value;
				$grand_total+=$order_detail->net_amount;
			} 
			
			$after_round_of=round($grand_total);
			$round_off=0;
			if($after_round_of!=$grand_total){
				$round_off=$after_round_of-$grand_total;
			}
			
			$round_off=$round_off;
			$grand_total=$after_round_of;
			/* $query = $this->Orders->query();
			$query->update()
				->set(['grand_total' => $after_round_of,'discount_amount' => $total_discount_amount,'delivery_charge_amount' => $order->delivery_charge_amount,'total_gst' => $total_gst,'total_amount' => $total_taxable,'round_off' => $round_off,'pay_amount' => $after_round_of+$order->delivery_charge_amount])
				->where(['id'=>$order->id])
				->execute();   */
				// pr($grand_total); exit;
			
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
			
			
			$challans=$this->Challans->find()->where(['order_id'=>$id])->contain(['ChallanRows']);
			foreach($challans as $challan){
				$total_promo_amount=0;
				$total_discount_amount=0;
				$total_taxable=0;
				$total_gst=0;
				$grand_total=0;
				$cancelChallan="Yes";
					foreach($challan->challan_rows as $challan_row){
						if($challan_row->is_item_cancel=="No"){
							$total_discount_amount+=$challan_row->discount_amount+$challan_row->promo_amount;
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
						
						$old_pay_amount=$challan->old_pay_amount;
						$new_pay_amount=$after_round_of+$challan->delivery_charge_amount;
						$cod_amount=$new_pay_amount-$old_pay_amount;
						
						$query = $this->Challans->query();
						$query->update()
								->set(['grand_total' => $after_round_of,'discount_amount' => $total_discount_amount,'delivery_charge_amount' => $challan->delivery_charge_amount,'total_gst' => $total_gst,'total_amount' => $total_taxable,'round_off' => $round_off,'pay_amount' => $after_round_of+$challan->delivery_charge_amount,'old_pay_amount'=>$new_pay_amount])
								->where(['id'=>$challan->id])
								->execute();
					}else{ 
						if(!empty($status))
						{
							$query = $this->Challans->query();
							$query->update()
									->set(['order_status' => $status])
									->where(['id'=>$challan->id])
									->execute();							
						}

					}
				
			}
		}
		return true;
	}



	public function QuntityChallanOrderUpdate($id = null,$status = null)
     { 
		
		$this->Challans = TableRegistry::get('Challans');
		$this->ChallanRows = TableRegistry::get('ChallanRows');
		$this->Orders = TableRegistry::get('Orders');
		$this->Items = TableRegistry::get('Items');
		$this->ItemVariations = TableRegistry::get('ItemVariations');
		$this->UnitVariations = TableRegistry::get('UnitVariations');
		$order = $this->Orders->get($id, [
            'contain' => ['OrderDetails'=>['ItemVariations'=>['Items'=>['GstFigures']]]]
        ]);
		
		/* //$user_id=$this->Auth->User('id');
		$order = $this->Orders->get($id, [
            'contain' => ['OrderDetails'=>['ItemVariations'=>['Items'=>['GstFigures']]]]
        ]); */
		
		$total_promo_amount=0;
		$total_discount_amount=0;
		$total_taxable=0;
		$total_gst=0;
		$grand_total=0;
		$cancelOrder="Yes";
		
		foreach($order->order_details as $order_detail){ 
			if($order_detail->is_item_cancel=="Yes"){
				//Item Cancle Yes in Challan Rows
				if(!empty($status))
				{
					$query = $this->ChallanRows->query();
					$query->update()
							->set(['is_item_cancel' => 'Yes','item_status' =>$status])
							->where(['order_detail_id'=>$order_detail->id])
							->execute();					
				}

				//calculation
			}else if($order_detail->is_item_cancel=="No"){
				$total_discount_amount+=$order_detail->discount_amount;
				$total_promo_amount+=$order_detail->promo_amount;
				$total_taxable+=$order_detail->taxable_value;
				$total_gst+=$order_detail->gst_value;
				$grand_total+=$order_detail->net_amount;
				$cancelOrder="No";
				
				//Item Cancle N0 in Challan Rows
				$query = $this->ChallanRows->query();
				$query->update()
						->set(['is_item_cancel' => 'No'])
						->where(['order_detail_id'=>$order_detail->id])
						->execute();
						
				$query = $this->ChallanRows->query();
				$query->update()
						->set(['discount_amount'=>$order_detail->discount_amount,'promo_amount'=>$order_detail->promo_amount,'taxable_value'=>$order_detail->taxable_value,'gst_value'=>$order_detail->gst_value,'promo_percent'=>$order_detail->promo_percent,'net_amount'=>$order_detail->net_amount])
						->where(['order_detail_id'=>$order_detail->id])
						->execute();
			}
		}
		//pr($cancelOrder); exit;
		if($cancelOrder=="Yes"){
			if(!empty($status))
			{
				$query = $this->Orders->query();
				$query->update()
				->set(['order_status' =>$status])
				->where(['id'=>$order->id])
				->execute();				
			}
 
			if(!empty($status))
			{
				$query = $this->Challans->query();
				$query->update()
						->set(['order_status' => $status])
						->where(['order_id'=>$order->id])
						->execute();				
			}
 

			//New Code For Cancle order
			$total_promo_amount=0;
			$total_discount_amount=0;
			$total_taxable=0;
			$total_gst=0;
			$grand_total=0;		
			foreach($order->order_details as $order_detail){ 
				$total_discount_amount+=$order_detail->discount_amount;
				$total_promo_amount+=$order_detail->promo_amount;
				$total_taxable+=$order_detail->taxable_value;
				$total_gst+=$order_detail->gst_value;
				$grand_total+=$order_detail->net_amount;
			} 
			
			$after_round_of=round($grand_total);
			$round_off=0;
			if($after_round_of!=$grand_total){
				$round_off=$after_round_of-$grand_total;
			}
			
			$round_off=$round_off;
			$grand_total=$after_round_of;
			/* $query = $this->Orders->query();
			$query->update()
				->set(['grand_total' => $after_round_of,'discount_amount' => $total_discount_amount,'delivery_charge_amount' => $order->delivery_charge_amount,'total_gst' => $total_gst,'total_amount' => $total_taxable,'round_off' => $round_off,'pay_amount' => $after_round_of+$order->delivery_charge_amount])
				->where(['id'=>$order->id])
				->execute();   */
				// pr($grand_total); exit;
			
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
			
			
			$challans=$this->Challans->find()->where(['order_id'=>$id])->contain(['ChallanRows']);
			foreach($challans as $challan){
				$total_promo_amount=0;
				$total_discount_amount=0;
				$total_taxable=0;
				$total_gst=0;
				$grand_total=0;
				$cancelChallan="Yes";
					foreach($challan->challan_rows as $challan_row){
						if($challan_row->is_item_cancel=="No"){
							$total_discount_amount+=$challan_row->discount_amount+$challan_row->promo_amount;
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
						
						$old_pay_amount=$challan->old_pay_amount;
						$new_pay_amount=$after_round_of+$challan->delivery_charge_amount;
						$cod_amount=$new_pay_amount-$old_pay_amount;
						$pay_amount=$challan->pay_amount;
						
						$query = $this->Challans->query();
						$query->update()
								->set(['grand_total' => $after_round_of,'discount_amount' => $total_discount_amount,'delivery_charge_amount' => $challan->delivery_charge_amount,'total_gst' => $total_gst,'total_amount' => $total_taxable,'round_off' => $round_off,'pay_amount' => $after_round_of+$challan->delivery_charge_amount])
								->where(['id'=>$challan->id])
								->execute();
						
						$query=$this->Challans->Wallets->find()->where(['challan_id'=>$challan->id]);
						$query->select(['customer_id','totalAddAmt' => $query->func()->sum('Wallets.add_amount'),'totalDeductAmt' => $query->func()->sum('Wallets.used_amount')]);
						
						$temp=$query->toArray();
						$WalletAddAmt=($temp[0]['totalAddAmt']);
						$Walletused_amount=($temp[0]['totalDeductAmt']);
						$WalletAvailableAmt=$WalletAddAmt-$Walletused_amount;
						//pr($new_pay_amount); exit;
						if($pay_amount != $new_pay_amount){ 
							if($challan->payment_status=='Success' || $challan->order_type=="Wallet" || $challan->order_type=="Wallet/Online"){
								if($new_pay_amount > $pay_amount){
									$Cod_amt=$new_pay_amount-$pay_amount;
									if($WalletAvailableAmt){
										$diff_amt1=$new_pay_amount-$pay_amount;
											if($WalletAvailableAmt > $diff_amt1){
												$query = $this->Challans->Wallets->query();
												$query->insert(['customer_id', 'order_id','challan_id',  'amount_type', 'narration', 'transaction_type', 'transaction_date', 'used_amount', 'city_id', 'created_on'])
												->values([
												'customer_id' => $challan->customer_id,
												'order_id' => $challan->order_id,
												'challan_id' => $challan->id,
												'amount_type' => 'Item Quantity Update',
												'narration' =>'Amount Deduct form Order Quantity Update',
												'transaction_type' => 'Deduct',
												'transaction_date' => date('Y-m-d'),
												'used_amount' => $diff_amt1,
												'city_id' => $challan->city_id,
												'created_on' => date('Y-m-d H:i:s')
												])
												->execute();
												
												$query = $this->Challans->query();
													$query->update()
													->set(['take_cod_amount'=>0])
													->where(['id'=>$challan->id])
													->execute();
												
											}else{
												
												$Cod_amt1=$new_pay_amount-$old_pay_amount;
												//$WalletAddAmt
												$query = $this->Challans->Wallets->query();
												$query->insert(['customer_id', 'order_id','challan_id',  'amount_type', 'narration', 'transaction_type', 'transaction_date', 'used_amount', 'city_id', 'created_on'])
												->values([
												'customer_id' => $challan->customer_id,
												'order_id' => $challan->order_id,
												'challan_id' => $challan->id,
												'amount_type' => 'Item Quantity Update',
												'narration' =>'Amount Deduct form Order Quantity Update',
												'transaction_type' => 'Deduct',
												'transaction_date' => date('Y-m-d'),
												'used_amount' => $WalletAvailableAmt,
												'city_id' => $challan->city_id,
												'created_on' => date('Y-m-d H:i:s')
												])
												->execute();
												
												$query = $this->Challans->query();
													$query->update()
													->set(['take_cod_amount'=>$Cod_amt1])
													->where(['id'=>$challan->id])
													->execute();
											}
										
										
									}else{
										$query = $this->Challans->query();
										$query->update()
											->set(['take_cod_amount'=>$Cod_amt])
											->where(['id'=>$challan->id])
											->execute();
									}
								}else if($pay_amount == $new_pay_amount){
									$query = $this->Challans->query();
									$query->update()
											->set(['take_cod_amount'=>0])
											->where(['id'=>$challan->id])
											->execute();
								}else{
									$total_amt=$old_pay_amount-$WalletAddAmt;
										if($new_pay_amount < $total_amt){
											$diff_amt=$total_amt-$new_pay_amount;
											$wallet_no = $this->Challans->Wallets->find()->select(['order_no'])->where(['Wallets.city_id'=>$challan->city_id])->order(['order_no' => 'DESC'])->first();
											if($wallet_no){
												$seq_wallet=$wallet_no->order_no+1;
											}else{
												$seq_wallet=1;
											}
											
											//$this->Challans->Wallets->deleteAll(['challan_id' => $challan->id, 'order_id' => $challan->order_id]);
											
											$query = $this->Challans->Wallets->query();
											$query->insert(['customer_id', 'order_id','challan_id', 'order_no', 'amount_type', 'narration', 'transaction_type', 'transaction_date', 'add_amount', 'city_id', 'created_on'])
											->values([
											'customer_id' => $challan->customer_id,
											'order_id' => $challan->order_id,
											'challan_id' => $challan->id,
											'order_no' => $seq_wallet,
											'amount_type' => 'Item Quantity Update',
											'narration' =>'Amount Return form Order Quantity Update',
											'transaction_type' => 'Added',
											'transaction_date' => date('Y-m-d'),
											'add_amount' => $diff_amt,
											'city_id' => $challan->city_id,
											'created_on' => date('Y-m-d H:i:s')
											])
											->execute();
											
											$query = $this->Challans->query();
											$query->update()
											->set(['take_cod_amount'=>0])
											->where(['id'=>$challan->id])
											->execute();
											
										}else if($new_pay_amount > $total_amt){
											$diff_amt=$new_pay_amount-$total_amt;
											$query = $this->Challans->query();
											$query->update()
											->set(['take_cod_amount'=>$diff_amt])
											->where(['id'=>$challan->id])
											->execute();
										}
									
								}
								
							}
						}
						/* $this->Challans->get($challan->id);
						$query = $this->Challans->Wallets->query();
						$query->insert(['customer_id', 'order_id', 'order_no', 'amount_type', 'narration', 'transaction_type', 'transaction_date', 'add_amount', 'city_id', 'created_on'])
						->values([
						'customer_id' => $customer_id,
						'order_id' => $order_id,
						'order_no' => $seq_wallet,
						'amount_type' => 'Item Cancle',
						'narration' =>'Amount Return form Order Cancle',
						'transaction_type' => 'Added',
						'transaction_date' => date('Y-m-d'),
						'add_amount' => $OrderDatas->pay_amount,
						'city_id' => $OrderDatas->city_id,
						'created_on' => date('Y-m-d H:i:s')
						])
						->execute(); */
						
						
					}else{ 
						if(!empty($status))
						{
							$query = $this->Challans->query();
							$query->update()
									->set(['order_status' => $status])
									->where(['id'=>$challan->id])
									->execute();							
						}

					}
				
			}
		}
		return true;
	}



	
	
}
?>