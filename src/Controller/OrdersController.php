<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\View\View;
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
	 
	   public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Security->setConfig('unlockedActions', ['add']);

    }
    public function index()
    {
		$this->viewBuilder()->layout('super_admin_layout');
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id');
		$location_id=$this->Auth->User('location_id');
		
	
		
        $this->paginate = [
            'contain' => ['Locations','Customers','OrderDetails'=>['ItemVariations']],
			'limit' => 20
        ];
        
        $orders = $this->paginate($this->Orders);
		//pr( $orders); exit;
		$paginate_limit=$this->paginate['limit'];
        $this->set(compact('orders','paginate_limit'));
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
		$this->viewBuilder()->layout('super_admin_layout');
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
		pr($Orders); exit;
		pr($Orders); exit;
		
	}
	
	
	public function orderDeliver($id = null)
    { 
		$this->viewBuilder()->layout('super_admin_layout');
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id');
		//$location_id=$this->Auth->User('location_id'); pr($city_id); exit;
		//$Location = $this->Orders->Locations->get($location_id);
		$today_date=date("Y-m-d");
		$orderdate = explode('-', $today_date);
		$year = $orderdate[0];
		$month   = $orderdate[1];
		$day  = $orderdate[2];
		$order = $this->Orders->get($id, [
            'contain' => ['OrderDetails'=>['ItemVariations'=>['Items'=>['GstFigures']]]]
        ]);
		
	//	$UnitRateSerialItem = $this->addSalesInvoice($id);
		$Totalsellers=[];
		foreach($order->order_details as $order_detail){ 
			if($order_detail->item_variation->seller_id > 0){
				$seller_id=$order_detail->item_variation->seller_id; 
				$Totalsellers[$seller_id][]=$order_detail;
			}
		}
		
		foreach($Totalsellers as $key=>$Totalseller){
			$Total_amount=0; $Tabable_amount=0;$TotalSaleRate=0;$TotalPurchaseRate=0;
					foreach($Totalseller as $data){
						$Item = $this->Orders->OrderDetails->ItemVariations->get($data->item_variation->id);
						$TotalPurchaseRate+=$Item->purchase_rate;
						$TotalSaleRate+=$Item->sales_rate;
					} 
					// pr($TotalPurchaseRate);pr($TotalSaleRate); exit;
					$StateData = $this->Orders->Cities->get($city_id,['contain'=>['States']]);
					//$StateData = $this->Orders->Cities->States->get($CityData->state_id);
					 //pr($StateData); exit;
					$Voucher_no = $this->Orders->Grns->find()->select(['voucher_no'])->where(['Grns.city_id'=>$city_id])->order(['voucher_no' => 'DESC'])->first();
					if($Voucher_no){$voucher_no=$Voucher_no->voucher_no+1; }
					else{$voucher_no=1;}   
					
					$order_no=$StateData->alise_name.'/'.$voucher_no;
					$purchaseInvoiceVoucherNo=$StateData->state->alias_name.'/'.$order_no;
					
					$Grn = $this->Orders->Grns->newEntity(); 
					$Grn->seller_id=$key;
					$Grn->order_id=$id;
					$Grn->voucher_no=$voucher_no;
					$Grn->grn_no=$purchaseInvoiceVoucherNo;
					$Grn->transaction_date=$today_date;
					$Grn->total_purchase_rate=$TotalPurchaseRate;
					$Grn->total_sales_rate=$TotalSaleRate;
					$Grn->city_id=$city_id;
					$Grn->created_for="Seller";
					$this->Orders->Grns->save($Grn);
					
				foreach($Totalseller as $data){ 
						$Item1 = $this->Orders->OrderDetails->ItemVariations->get($data->item_variation_id); 
						/* 
						$commission=($data->item_variation->commission);
						$purchase_rate=$data->item_variation->purchase_rate;
						$gst_percentage=$Items->gst_figure->tax_percentage;
						$gst_rate=round(($purchase_rate*$gst_percentage)/(100+$gst_percentage),2);
						$gst_rate1=round(($gst_rate/2),2);
						$gst_rate=round(($gst_rate1*2),2);
						$pr=$purchase_rate-$gst_rate;
						$TotalTaxableValue+=$purchase_rate-$gst_rate; 
						$purchaseGST+=$gst_rate;  */
						$GrnRow = $this->Orders->Grns->GrnRows->newEntity(); 
						$GrnRow->grn_id=$Grn->id;
						$GrnRow->item_id=$data->item_id;
						$GrnRow->item_variation_id=$Item1->id;
						$GrnRow->unit_variation_id=$Item1->unit_variation_id;
						$GrnRow->quantity=$data->quantity;
						$GrnRow->purchase_rate=$Item1->purchase_rate; 
						$GrnRow->sales_rate=$Item1->sales_rate;
						$GrnRow = $this->Orders->Grns->GrnRows->save($GrnRow);
						
						
						$ItemLedger = $this->Orders->Grns->GrnRows->ItemLedgers->newEntity(); 
						$ItemLedger->item_id=$data->item_id; 
						$ItemLedger->item_variation_id=$data->item_variation_id;
						$ItemLedger->seller_id=$key;
						$ItemLedger->transaction_date=$order->transaction_date;  
						$ItemLedger->quantity=$data->quantity;
						$ItemLedger->rate=$GrnRow->purchase_rate;
						$ItemLedger->purchase_rate=$GrnRow->purchase_rate;
						$ItemLedger->sales_rate=$GrnRow->sales_rate; 
						$ItemLedger->status="In";
						$ItemLedger->city_id=$city_id;
						$ItemLedger->grn_id=$Grn->id;
						$ItemLedger->grn_row_id=$GrnRow->id;
						$this->Orders->Grns->GrnRows->ItemLedgers->save($ItemLedger);
						
				}
			}
			
				$this->Flash->success(__('The order has been saved.'));
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
	public function view($id = null)
    {
        $order = $this->Orders->get($id, [
            'contain' => ['Locations', 'Customers', 'Drivers', 'CustomerAddresses', 'PromotionDetails', 'DeliveryCharges', 'DeliveryTimes', 'CancelReasons', 'OrderDetails', 'Wallets']
        ]);

        $this->set('order', $order);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id'); 
		//$location_id=$this->Auth->User('location_id'); 
		$state_id=$this->Auth->User('state_id'); 
		$this->viewBuilder()->layout('super_admin_layout');
        $order = $this->Orders->newEntity();
		$CityData = $this->Orders->Cities->get($city_id);
		$StateData = $this->Orders->Cities->States->get($CityData->state_id);
	
		$Voucher_no = $this->Orders->find()->select(['voucher_no'])->where(['Orders.city_id'=>$city_id])->order(['voucher_no' => 'DESC'])->first();
		if($Voucher_no){$voucher_no=$Voucher_no->voucher_no+1;}
		else{$voucher_no=1;}
		$order_no=$CityData->alise_name.'/'.$voucher_no;
		$order_no=$StateData->alias_name.'/'.$order_no;
		//pr($order_no); exit;
		//pr($voucher_no); exit;
		
        if ($this->request->is('post')) {
            $order = $this->Orders->patchEntity($order, $this->request->getData());
			$Voucher_no = $this->Orders->find()->select(['voucher_no'])->where(['Orders.city_id'=>$city_id])->order(['voucher_no' => 'DESC'])->first();
			if($Voucher_no){$voucher_no=$Voucher_no->voucher_no+1;}
			else{$voucher_no=1;} 
			$order->order_from="Web";
			$order->city_id=$city_id;
			$order->transaction_date=date('Y-m-d',strtotime($order->transaction_date));
			$Custledgers = $this->Orders->SellerLedgers->get($order->party_ledger_id,['contain'=>['Customers'=>['Cities']]]);
			
            if ($this->Orders->save($order)) { 
					if($order->order_type=="Credit"){
							
						//	Party/Customer Ledger Entry
						$AccountingEntrie = $this->Orders->AccountingEntries->newEntity(); 
						$AccountingEntrie->ledger_id=$order->party_ledger_id;
						$AccountingEntrie->debit=$order->total_amount;
						$AccountingEntrie->credit=0;
						$AccountingEntrie->transaction_date=$order->transaction_date;
						$AccountingEntrie->city_id=$city_id;
						$AccountingEntrie->entry_from="Web";
						$AccountingEntrie->order_id=$order->id;  
						$this->Orders->AccountingEntries->save($AccountingEntrie);
						
						// Sales Account Entry 
						$AccountingEntrie = $this->Orders->AccountingEntries->newEntity(); 
						$AccountingEntrie->ledger_id=$order->sales_ledger_id;
						$AccountingEntrie->credit=$order->total_taxable_value;
						$AccountingEntrie->debit=0;
						$AccountingEntrie->transaction_date=$order->transaction_date;
						$AccountingEntrie->city_id=$city_id;
						$AccountingEntrie->entry_from="Web";
						$AccountingEntrie->order_id=$order->id; 
						$this->Orders->AccountingEntries->save($AccountingEntrie);
						
						if($Custledgers->customer->city->state_id==$state_id){
							foreach($order->order_details as $order_detail){ 
							$gstAmtdata=$order_detail->gst_value/2;
							$gstAmtInsert=round($gstAmtdata,2);
							//pr($order_detail->gst_figure_id); exit;
							
							//Accounting Entries for CGST//
							$gstLedgerCGST = $this->Orders->Ledgers->find()
							->where(['Ledgers.gst_figure_id' =>$order_detail->gst_figure_id, 'Ledgers.input_output'=>'output', 'Ledgers.gst_type'=>'CGST','city_id'=>$city_id])->first();
							$AccountingEntrieCGST = $this->Orders->AccountingEntries->newEntity();
							$AccountingEntrieCGST->ledger_id=$gstLedgerCGST->id;
							$AccountingEntrieCGST->credit=$gstAmtInsert;
							$AccountingEntrieCGST->debit=0;
							$AccountingEntrieCGST->transaction_date=$order->transaction_date;
							$AccountingEntrieCGST->city_id=$city_id;
							$AccountingEntrieCGST->entry_from="Web";
							$AccountingEntrieCGST->order_id=$order->id;  
							$this->Orders->AccountingEntries->save($AccountingEntrieCGST);
							
							//Accounting Entries for SGST//
							 $gstLedgerSGST = $this->Orders->Ledgers->find()
							->where(['Ledgers.gst_figure_id' =>$order_detail->gst_figure_id, 'Ledgers.input_output'=>'output', 'Ledgers.gst_type'=>'SGST','city_id'=>$city_id])->first();
							$AccountingEntrieSGST = $this->Orders->AccountingEntries->newEntity();
							$AccountingEntrieSGST->ledger_id=$gstLedgerSGST->id;
							$AccountingEntrieSGST->credit=$gstAmtInsert;
							$AccountingEntrieSGST->debit=0;
							$AccountingEntrieSGST->transaction_date=$order->transaction_date;
							$AccountingEntrieSGST->city_id=$city_id;
							$AccountingEntrieSGST->entry_from="Web";
							$AccountingEntrieSGST->order_id=$order->id;  
							$this->Orders->AccountingEntries->save($AccountingEntrieSGST);
							
							$Item = $this->Orders->OrderDetails->ItemVariations->get($order_detail->item_variation_id);
							$ItemLedger = $this->Orders->Grns->GrnRows->ItemLedgers->newEntity(); 
							$ItemLedger->item_id=$order_detail->item_id; 
							$ItemLedger->item_variation_id=$order_detail->item_variation_id;
							$ItemLedger->seller_id=$Item->seller_id;
							$ItemLedger->transaction_date=$order->transaction_date;  
							$ItemLedger->quantity=$order_detail->quantity;
							$ItemLedger->rate=$order_detail->sales_rate;
							$ItemLedger->purchase_rate=$order_detail->purchase_rate;
							$ItemLedger->sales_rate=$order_detail->sales_rate; 
							$ItemLedger->status="Out";
							$ItemLedger->city_id=$city_id;
							$ItemLedger->order_id=$order->id;
							$ItemLedger->order_detail_id=$order_detail->id;
							$this->Orders->Grns->GrnRows->ItemLedgers->save($ItemLedger);
							
							$ItemVariationData = $this->Orders->OrderDetails->ItemVariations->get($order_detail->item_variation_id);
							$current_stock=$ItemVariationData->current_stock-$order_detail->quantity; 
							$out_of_stock="No";
							$ready_to_sale="Yes";
							if($current_stock <= 0){
								$ready_to_sale="No";
								$out_of_stock="Yes";
							}
							
							$query = $this->Orders->OrderDetails->ItemVariations->query();
							$query->update()
							->set(['current_stock'=>$current_stock,'out_of_stock'=>$out_of_stock,'ready_to_sale'=>$ready_to_sale])
							->where(['id'=>$order_detail->item_variation_id])
							->execute(); 
							
						   }
						}
						$this->orderDeliver($order->id);
					}
					
                $this->Flash->success(__('The order has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The order could not be saved. Please, try again.'));
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
			$partyOptions[]=['text' =>$Partyledger->name, 'value' => $Partyledger->id,'city_id'=>$Partyledger->customer->city->id,'state_id'=>$Partyledger->customer->city->state_id,'bill_to_bill_accounting'=>$Partyledger->bill_to_bill_accounting,'customer_id'=>$Partyledger->customer_id];
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
		$itemList=$this->Orders->Items->find()->contain(['ItemVariations'=> function ($q) {
								return $q
								->where(['ItemVariations.status'=>'Active','current_stock >'=>'0'])->contain(['UnitVariations'=>['Units']]);
								}]);
		//pr($itemList->toArray()); exit;
		$items=array();
		foreach($itemList as $data1){ 
			foreach($data1->item_variations as $data){  //pr($data); exit;
				$gstData=$this->Orders->GstFigures->get($data1->gst_figure_id);
				$merge=$data1->name.'('.@$data->unit_variation->quantity_variation.'.'.@$data->unit_variation->unit->shortname.')';
				$items[]=['text' => $merge,'value' => $data->id,'item_id'=>$data1->id,'quantity_factor'=>@$data->unit_variation->convert_unit_qty,'unit'=>@$data->unit_variation->unit->unit_name,'gst_figure_id'=>$data1->gst_figure_id,'gst_value'=>$gstData->tax_percentage,'commission'=>@$data->commission,'sale_rate'=>$data->sales_rate];
			}
		}
		
		//pr($items); exit;
		
        $this->set(compact('order', 'locations', 'customers', 'drivers', 'customerAddresses', 'promotionDetails', 'deliveryCharges', 'deliveryTimes', 'cancelReasons','order_no','partyOptions','Accountledgers','items'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Order id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
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
