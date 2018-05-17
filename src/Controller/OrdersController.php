<?php
namespace App\Controller;

use App\Controller\AppController;

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
		$location_id=$this->Auth->User('location_id'); 
		$Location = $this->Orders->Locations->get($location_id);
		$today_date=date("Y-m-d");
		$orderdate = explode('-', $today_date);
		$year = $orderdate[0];
		$month   = $orderdate[1];
		$day  = $orderdate[2];
		$order = $this->Orders->get($id, [
            'contain' => ['OrderDetails'=>['ItemVariations'=>['Items'=>['GstFigures'],'Sellers']]]
        ]);
	//	$UnitRateSerialItem = $this->addSalesInvoice($id);
		$Totalsellers=[];
		foreach($order->order_details as $order_detail){
			$seller_id=$order_detail->item_variation->seller_id; 
			$Totalsellers[$seller_id][]=$order_detail;
		}
		foreach($Totalsellers as $key=>$Totalseller){
			$Total_amount=0; $Tabable_amount=0;$TotalTaxableValue=0;$purchaseGST=0;
					foreach($Totalseller as $data){
						$Items = $this->Orders->OrderDetails->ItemVariations->Items->get($data->item_variation->item_id,
						['contain'=>['GstFigures']]);
						$purchase_rate=$data->item_variation->purchase_rate;
						$gst_percentage=$Items->gst_figure->tax_percentage;
						$gst_rate=round(($purchase_rate*$gst_percentage)/(100+$gst_percentage),2);
						$gst_rate1=round(($gst_rate/2),2);
						$gst_rate=round(($gst_rate1*2),2);
						$purchase_rate1=($data->quantity*$purchase_rate);
						$gst_rate2=($data->quantity*$gst_rate);
						$TotalTaxableValue+=$purchase_rate1-$gst_rate2;
						$purchaseGST+=$gst_rate2; 
					}
					
					$Voucher_no = $this->Orders->Grns->find()->select(['voucher_no'])->where(['Grns.location_id'=>$location_id])->order(['voucher_no' => 'DESC'])->first();
					if($Voucher_no){$voucher_no=$Voucher_no->voucher_no+1;}
					else{$voucher_no=1;}  
					$purchaseInvoiceVoucherNo='GRN'.'/'.$Location->alise.'/'.$year.''.$month.''.$day.'/'.$voucher_no;
					$SellerLedgersData = $this->Orders->Ledgers->find()->where(['seller_id'=>$key])->first();
					
					$Grn = $this->Orders->Grns->newEntity(); 
					$Grn->seller_id=$key;
					$Grn->voucher_no=$voucher_no;
					$Grn->grn_no=$purchaseInvoiceVoucherNo;
					$Grn->location_id=$location_id;
					$Grn->transaction_date=$today_date;
					$Grn->total_taxable_value=$TotalTaxableValue;
					$Grn->total_gst=$purchaseGST;
					$Grn->total_amount=$purchaseGST+$TotalTaxableValue;
					$Grn->city_id=$city_id;
					$Grn->location_id=$location_id;
					$this->Orders->Grns->save($Grn);
					
				foreach($Totalseller as $data){
						$Items = $this->Orders->OrderDetails->ItemVariations->Items->get($data->item_variation->item_id,
						['contain'=>['GstFigures']]);
						$commission=($data->item_variation->commission);
						$purchase_rate=$data->item_variation->purchase_rate;
						$gst_percentage=$Items->gst_figure->tax_percentage;
						$gst_rate=round(($purchase_rate*$gst_percentage)/(100+$gst_percentage),2);
						$gst_rate1=round(($gst_rate/2),2);
						$gst_rate=round(($gst_rate1*2),2);
						$pr=$purchase_rate-$gst_rate;
						$TotalTaxableValue+=$purchase_rate-$gst_rate;
						$purchaseGST+=$gst_rate;  
						$GrnRow = $this->Orders->Grns->GrnRows->newEntity(); 
						$GrnRow->grn_id=$Grn->id;
						$GrnRow->seller_id=$data->item_variation->seller_id;
						$GrnRow->item_id=$Items->id;
						$GrnRow->item_variation_id=$data->item_variation->id;
						$GrnRow->quantity=$data->quantity;
						$GrnRow->rate=$pr;
						$GrnRow->taxable_value=$data->quantity*$pr;
						$GrnRow->gst_value=$data->quantity*$gst_rate;
						$GrnRow->gst_percentage=$Items->gst_figure->id;
						$GrnRow->net_amount=$GrnRow->taxable_value+$GrnRow->gst_value;
						$GrnRow->purchase_rate=$GrnRow->net_amount/$data->quantity;
						$GrnRow->sales_rate=round($GrnRow->purchase_rate+($GrnRow->purchase_rate*$commission/100),2);
						$GrnRow->mrp=$GrnRow->sales_rate; 
						$GrnRow = $this->Orders->Grns->GrnRows->save($GrnRow);
						
						
						$ItemLedger = $this->Orders->Grns->GrnRows->ItemLedgers->newEntity(); 
						$ItemLedger->item_id=$Items->id;
						$ItemLedger->item_variation_id=$data->item_variation->id;
						$ItemLedger->seller_id=$key;
						$ItemLedger->transaction_date=$today_date;
						$ItemLedger->quantity=$GrnRow->quantity;
						$ItemLedger->rate=$GrnRow->rate;
						$ItemLedger->purchase_rate=$GrnRow->purchase_rate;
						$ItemLedger->sales_rate=$GrnRow->sales_rate;
						$ItemLedger->mrp=$GrnRow->mrp;
						$ItemLedger->status="In";
						$ItemLedger->location_id=$location_id;
						$ItemLedger->city_id=$city_id;
						$ItemLedger->grn_id=$Grn->id;
						$ItemLedger->grn_row_id=$GrnRow->id;
						$this->Orders->Grns->GrnRows->ItemLedgers->save($ItemLedger);
						$ItemVariationData = $this->Orders->OrderDetails->ItemVariations->get($data->item_variation->id);
						
						/* $current_stock=$ItemVariationData->current_stock-$GrnRow->quantity;
						$out_of_stock="No";
						$ready_to_sale="Yes";
						if($current_stock <= 0){
							$ready_to_sale="No";
							$out_of_stock="Yes";
						}
						$query = $this->Orders->OrderDetails->ItemVariations->query();
						$query->update()
						->set(['current_stock'=>$current_stock,'purchase_rate'=>$GrnRow->purchase_rate,'sales_rate'=>$GrnRow->sales_rate,'mrp'=>$GrnRow->mrp,'print_rate'=>$GrnRow->mrp,'update_on'=>$today_date,'out_of_stock'=>$out_of_stock,'ready_to_sale'=>$ready_to_sale])
						->where(['item_id' => $Items->id,'id'=>$data->item_variation->id,'seller_id'=>$data->item_variation->seller_id])
						->execute(); */
						
				}
			}
			
	pr("Success");	exit;
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
		//$purchaseInvoiceVoucherNo=$voucher_no;
		$order_no=$CityData->alise_name.'/'.$voucher_no;
		$order_no=$StateData->alias_name.'/'.$order_no;
		//pr($order_no); exit;
		//pr($voucher_no); exit;
		
        if ($this->request->is('post')) {
            $order = $this->Orders->patchEntity($order, $this->request->getData());
			pr($order); exit;
            if ($this->Orders->save($order)) {
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
		
		$itemList=$this->Orders->Items->find()->contain(['ItemVariations'=> function ($q) {
								return $q
								->where(['ItemVariations.seller_id is NULL','ItemVariations.status'=>'Active','current_stock >'=>'0'])->contain(['UnitVariations'=>['Units']]);
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
