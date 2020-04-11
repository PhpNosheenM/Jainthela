<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Invoices Controller
 *
 * @property \App\Model\Table\InvoicesTable $Invoices
 *
 * @method \App\Model\Entity\Invoice[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class InvoicesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
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
		$seller_id = $this->request->query('seller_id');

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
			$where_get['Invoices.transaction_date >=']=$from_date;
		}
		if(!empty($to_date))
		{
			$to_date   = date("Y-m-d",strtotime($to_date));
			$where_get['Invoices.transaction_date <=']=$to_date;
		}
		$search=$this->request->getQuery('search');
		if(!empty($search))
		{
			
			$where_get['Customers.name LIKE']=$search.'%';
			//$where_get['Customers.voucher_no LIKE']=$search.'%';
		}
		
		//pr($where_get); exit;
		$status=$this->request->query('status');
		if(empty($status)){
			$status="Done";
		}else if($status=="return"){
			$status="return";
		}else{
			$status=$status;
		}
        $this->paginate = [
            'contain' => ['Orders', 'Locations','Challans', 'Sellers', 'FinancialYears', 'Cities', 'Customers', 'CustomerAddresses'],
			'limit' => 100
        ]; 
		if($status=="return"){
			$invoices = $this->paginate($this->Invoices->find()->where($where_get)->where(['Invoices.seller_id IS NULL','Invoices.invoice_status'=>'Done'])->order(['Invoices.id' => 'ASC']));
		}else{
			$invoicesDatas = $this->Invoices->find()->where(['Invoices.invoice_status'=>$status]);
			if(!empty($seller_id))
			{
				if($seller_id == 'NULL'){
					$invoicesDatas->where(['Invoices.seller_id IS NULL']);
				}else{
					$invoicesDatas->where(['Invoices.seller_id'=>$seller_id]);
				}
			}
			$invoicesDatas->where($where_get)->order(['Invoices.id' => 'ASC']);
			
			$invoices = $this->paginate($invoicesDatas);//pr($invoices->toArray());exit;
		}
		$Sellers[]=['text'=>'Main JainThela','value'=>'NULL'];
		$AllSellers = $this->Invoices->Sellers->find();
		foreach($AllSellers as $data){ 
			$Sellers[]=['text'=>$data->name,'value'=>$data->id];
		} //pr($Sellers);exit;
		$paginate_limit=$this->paginate['limit'];
        $this->set(compact('invoices','paginate_limit','status','to_date','from_date','Sellers'));
    }
	
	 public function hsnWiseReport()
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
		$seller_id = $this->request->query('seller_id');

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
			$where_get['Invoices.transaction_date >=']=$from_date;
		}
		if(!empty($to_date))
		{
			$to_date   = date("Y-m-d",strtotime($to_date));
			$where_get['Invoices.transaction_date <=']=$to_date;
		}
		$search=$this->request->getQuery('search');
		
		$invoices = $this->Invoices->find()
		->contain(['InvoiceRows'=>['Items'],'Customers'=>['Cities']])
		->where($where_get)
		->where(['Invoices.seller_id IS NULL','Invoices.invoice_status'=>'Done'])
		->order(['Invoices.id' => 'ASC']);
		
		$hsn=[];
		$quantity=[];
		$taxable_value=[];
		$total_value=[];
		$gst=[];
		$igst=[];
		//pr($SalesInvoices->toArray());exit;
		if(!empty($search)){
			foreach($invoices as $Invoice){  
				foreach($Invoice->invoice_rows as $invoice_row){ 
					if($search==$invoice_row->item->hsn_code){	
						$hsn[$invoice_row->item->hsn_code]=$invoice_row->item->hsn_code;
						@$quantity[@$invoice_row->item->hsn_code]+=@$invoice_row->quantity;
						@$total_value[@$invoice_row->item->hsn_code]+=@$invoice_row->net_amount;
						@$taxable_value[@$invoice_row->item->hsn_code]+=@$invoice_row->taxable_value;
						if($Invoice->customer->city->state_id == 1){
							@$gst[@$invoice_row->item->hsn_code]+=@$invoice_row->gst_value;
						}else {
							@$igst[@$invoice_row->item->hsn_code]+=@$invoice_row->gst_value;
						}
					}
				}
			}
		}else{
			foreach($invoices as $Invoice){  
				foreach($Invoice->invoice_rows as $invoice_row){ 
					$hsn[$invoice_row->item->hsn_code]=$invoice_row->item->hsn_code;
					@$quantity[@$invoice_row->item->hsn_code]+=@$invoice_row->quantity;
					@$total_value[@$invoice_row->item->hsn_code]+=@$invoice_row->net_amount;
					@$taxable_value[@$invoice_row->item->hsn_code]+=@$invoice_row->taxable_value;
					if($Invoice->customer->city->state_id == 1){
						@$gst[@$invoice_row->item->hsn_code]+=@$invoice_row->gst_value;
					}else {
						@$igst[@$invoice_row->item->hsn_code]+=@$invoice_row->gst_value;
					}
				}
			}				
		}
		
		//pr($invoices->toArray());exit;
		$this->set(compact('invoices','paginate_limit','status','to_date','from_date','hsn','item_category','unit','quantity','taxable_value','gst','total_value','igst'));
	}

		public function checkInvoice()
    {
		$AllSellers = $this->Invoices->find();
		$AllInvoice=[];
		$AllInvoice1=[];
		foreach($AllSellers as $data){  
			if(@$AllInvoice[$data->challan_id]){
				$AllInvoice1[$data->id]=$data->challan_id;
			}else{
				$AllInvoice[$data->challan_id]=$data->challan_id;
			}
		} //
		pr($AllInvoice1);exit;
		exit;
		
	}
    /**
     * View method
     *
     * @param string|null $id Invoice id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $invoice = $this->Invoices->get($id, [
            'contain' => ['Orders', 'Locations', 'Sellers', 'FinancialYears', 'Cities', 'SalesLedgers', 'PartyLedgers', 'Customers', 'Drivers', 'CustomerAddresses', 'PromotionDetails', 'DeliveryCharges', 'DeliveryTimes', 'CancelReasons', 'InvoiceRows']
        ]);

        $this->set('invoice', $invoice);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
	 public function itemLedgerUpdate(){
		$Invoices=$this->Invoices->find()->where(['Invoices.invoice_status'=>'Done','Invoices.transaction_date >='=>'2019-06-26','seller_id IS NULL'])->contain(['InvoiceRows'=>['ItemVariations'=>['UnitVariations']]]);
		//pr($Invoices->toArray()); exit;
		foreach($Invoices as $data){
			foreach($data->invoice_rows as $invoice_row){
				$dataExist=$this->Invoices->InvoiceRows->ItemLedgers->find()->where(['ItemLedgers.invoice_id'=>$data->id,'ItemLedgers.invoice_row_id'=>$invoice_row->id])->first();
				if(empty($dataExist)){
					$ItemLedger = $this->Invoices->InvoiceRows->ItemLedgers->newEntity(); 
					$ItemLedger->item_id=$invoice_row->item_id; 
					/* if(empty($invoice_row->item_variation->unit_variation_id)){
						pr($invoice_row->id);
					}else{
						pr($invoice_row->id);
					} exit; */
					$ItemLedger->unit_variation_id=$invoice_row->item_variation->unit_variation_id;
					$ItemLedger->item_variation_id=$invoice_row->item_variation_id;
					$ItemLedger->transaction_date=$data->transaction_date;
					$ItemLedger->quantity=$invoice_row->quantity;
					$ItemLedger->rate=$invoice_row->rate;
					$ItemLedger->amount=$invoice_row->quantity*$invoice_row->rate;
					$ItemLedger->sales_rate=$invoice_row->rate;
					$ItemLedger->status="Out";
					$ItemLedger->city_id=$data->city_id;
					$ItemLedger->location_id=$data->location_id;
					$ItemLedger->invoice_id=$data->id;
					$ItemLedger->invoice_row_id=$invoice_row->id;
					$this->Invoices->InvoiceRows->ItemLedgers->save($ItemLedger);
				}
			}
		}
		echo "Updation Complete"; exit;
	}
	 
    public function add()
    {
        $invoice = $this->Invoices->newEntity();
        if ($this->request->is('post')) {
            $invoice = $this->Invoices->patchEntity($invoice, $this->request->getData());
            if ($this->Invoices->save($invoice)) {
                $this->Flash->success(__('The invoice has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The invoice could not be saved. Please, try again.'));
        }
        $orders = $this->Invoices->Orders->find('list', ['limit' => 200]);
        $locations = $this->Invoices->Locations->find('list', ['limit' => 200]);
        $sellers = $this->Invoices->Sellers->find('list', ['limit' => 200]);
        $financialYears = $this->Invoices->FinancialYears->find('list', ['limit' => 200]);
        $cities = $this->Invoices->Cities->find('list', ['limit' => 200]);
        $salesLedgers = $this->Invoices->SalesLedgers->find('list', ['limit' => 200]);
        $partyLedgers = $this->Invoices->PartyLedgers->find('list', ['limit' => 200]);
        $customers = $this->Invoices->Customers->find('list', ['limit' => 200]);
        $drivers = $this->Invoices->Drivers->find('list', ['limit' => 200]);
        $customerAddresses = $this->Invoices->CustomerAddresses->find('list', ['limit' => 200]);
        $promotionDetails = $this->Invoices->PromotionDetails->find('list', ['limit' => 200]);
        $deliveryCharges = $this->Invoices->DeliveryCharges->find('list', ['limit' => 200]);
        $deliveryTimes = $this->Invoices->DeliveryTimes->find('list', ['limit' => 200]);
        $cancelReasons = $this->Invoices->CancelReasons->find('list', ['limit' => 200]);
        $this->set(compact('invoice', 'orders', 'locations', 'sellers', 'financialYears', 'cities', 'salesLedgers', 'partyLedgers', 'customers', 'drivers', 'customerAddresses', 'promotionDetails', 'deliveryCharges', 'deliveryTimes', 'cancelReasons'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Invoice id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $invoice = $this->Invoices->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $invoice = $this->Invoices->patchEntity($invoice, $this->request->getData());
            if ($this->Invoices->save($invoice)) {
                $this->Flash->success(__('The invoice has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The invoice could not be saved. Please, try again.'));
        }
        $orders = $this->Invoices->Orders->find('list', ['limit' => 200]);
        $locations = $this->Invoices->Locations->find('list', ['limit' => 200]);
        $sellers = $this->Invoices->Sellers->find('list', ['limit' => 200]);
        $financialYears = $this->Invoices->FinancialYears->find('list', ['limit' => 200]);
        $cities = $this->Invoices->Cities->find('list', ['limit' => 200]);
        $salesLedgers = $this->Invoices->SalesLedgers->find('list', ['limit' => 200]);
        $partyLedgers = $this->Invoices->PartyLedgers->find('list', ['limit' => 200]);
        $customers = $this->Invoices->Customers->find('list', ['limit' => 200]);
        $drivers = $this->Invoices->Drivers->find('list', ['limit' => 200]);
        $customerAddresses = $this->Invoices->CustomerAddresses->find('list', ['limit' => 200]);
        $promotionDetails = $this->Invoices->PromotionDetails->find('list', ['limit' => 200]);
        $deliveryCharges = $this->Invoices->DeliveryCharges->find('list', ['limit' => 200]);
        $deliveryTimes = $this->Invoices->DeliveryTimes->find('list', ['limit' => 200]);
        $cancelReasons = $this->Invoices->CancelReasons->find('list', ['limit' => 200]);
        $this->set(compact('invoice', 'orders', 'locations', 'sellers', 'financialYears', 'cities', 'salesLedgers', 'partyLedgers', 'customers', 'drivers', 'customerAddresses', 'promotionDetails', 'deliveryCharges', 'deliveryTimes', 'cancelReasons'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Invoice id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
       public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
		$ids = $this->EncryptingDecrypting->decryptData($id);
		$invoice = $this->Invoices->get($ids,['contain'=>['InvoiceRows','AccountingEntries','PurchaseVouchers']]);
		
		$this->Invoices->AccountingEntries->deleteAll(['AccountingEntries.invoice_id' => $ids]);
		$this->Invoices->InvoiceRows->ItemLedgers->deleteAll(['ItemLedgers.invoice_id' => $ids]);
		
		if($invoice->purchase_voucher){
			$this->Invoices->AccountingEntries->deleteAll(['AccountingEntries.purchase_voucher_id' => $invoice->purchase_voucher->id]);
			
			$this->Invoices->PurchaseVouchers->ReferenceDetails->deleteAll(['ReferenceDetails.purchase_voucher_id' => $invoice->purchase_voucher->id]);
			
			$this->Invoices->PurchaseVouchers->PurchaseVoucherRows->deleteAll(['PurchaseVoucherRows.purchase_voucher_id' => $invoice->purchase_voucher->id]);
			
			$this->Invoices->PurchaseVouchers->deleteAll(['PurchaseVouchers.id' => $invoice->purchase_voucher->id]);
		}
		$query = $this->Invoices->query();
			$query->update()
			->set(['invoice_status'=>"Cancel"])
			->where(['id'=>$ids])
			->execute();
		
		$query = $this->Invoices->Challans->query();
			$query->update()
			->set(['order_status'=>"placed",'packing_flag'=>"Deactive",'dispatch_flag'=>"Deactive"])
			->where(['id'=>$invoice->challan_id])
			->execute();
		$query = $this->Invoices->Orders->query();
			$query->update()
			->set(['order_status'=>"placed",'packing_flag'=>"Deactive",'dispatch_flag'=>"Deactive"])
			->where(['id'=>$invoice->order_id])
			->execute();
		
       $this->Flash->success(__('The invoice has been deleted.'));
       return $this->redirect(['action' => 'index']);
    }
	
	
	public function confirm($id = null)
    {
		
		$ids = $this->EncryptingDecrypting->decryptData($id);
		
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id'); 
		$user_type =$this->Auth->User('user_type');
		$state_id=$this->Auth->User('state_id'); 
		
		$this->viewBuilder()->layout('pdf_layout');	
		
        $order = $this->Invoices->newEntity();
		$CityData = $this->Invoices->Cities->get($city_id);
		$StateData = $this->Invoices->Cities->States->get($CityData->state_id);
	 
		//$this->loadmodel('SalesOrders');
		$order=$this->Invoices->find()->where(['Invoices.id'=>$ids])->contain(['DeliveryTimes','OrderDetails'=>['ItemVariations'=>['ItemVariationMasters','Items','UnitVariations'=>['Units']]], 'Customers'=>['CustomerAddresses']])->first();
		// pr($order); exit;
		$company_details=$this->Invoices->Companies->find()->where(['Companies.city_id'=>$city_id])->first();
        $this->set(compact('ids', 'sales_orders', 'order', 'locations', 'customers', 'drivers', 'customerAddresses', 'promotionDetails', 'deliveryCharges', 'deliveryTimes', 'cancelReasons','order_no','partyOptions','Accountledgers','items','company_details','ids'));
    }
	public function pdfView($id = null,$print=null)
    {
		$orderPrintId=$id;
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
        $order = $this->Invoices->newEntity();
		$CityData = $this->Invoices->Cities->get($city_id);
		$StateData = $this->Invoices->Cities->States->get($CityData->state_id);
	// pr($ids); exit;
		$this->loadmodel('SalesOrders');
		$Orders=$this->Invoices->get($ids,['contain'=>['Orders','Cities','InvoiceRows'=>['ItemVariations'=>['UnitVariations'],'Items'],'Customers'=>['CustomerAddresses','Cities'],'CustomerAddresses']]);
		//pr($Orders->city->state_id); exit;
		$billType='';
		if($Orders->customer->city->state_id == $Orders->city->state_id){
			$billType="GST";
		}else{
			$billType="IGST";
		}
		$company_details=$this->Invoices->Companies->find()->where(['Companies.city_id'=>$city_id])->first();
		$GstFigures=$this->Invoices->InvoiceRows->Items->GstFigures->find()->where(['GstFigures.city_id'=>$city_id])->toArray();
        $this->set(compact('ids', 'sales_orders', 'order', 'locations', 'customers', 'drivers', 'customerAddresses', 'promotionDetails', 'deliveryCharges', 'deliveryTimes', 'cancelReasons','order_no','partyOptions','Accountledgers','items','company_details','Orders','orderPrintId','print','billType','GstFigures'));
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
			$where['Invoices.transaction_date >=']=$from_date;
		}
		if(!empty($to_date))
		{
			$to_date   = date("Y-m-d",strtotime($to_date));
			$where['Invoices.transaction_date <=']=$to_date;
		}
		if(!empty($location_id))
		{
			//$to_date   = date("Y-m-d",strtotime($to_date));
			$where['Invoices.location_id']=$location_id;
		}
	
		$orders = $this->Invoices->find()->contain(['Locations'])->where(['Invoices.city_id'=>$city_id])->where($where);
		$Locations = $this->Invoices->Locations->find('list');
		//pr($orders->toArray()); exit;
		$this->set(compact('from_date','to_date','orders','Locations','location_id'));
	}
		public function topSellingItem(){
		 
		$this->viewBuilder()->layout('super_admin_layout');
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id'); 
		$location_id=$this->Auth->User('location_id');
		$item_variation_id = $this->request->query('item_variation_id');
		$category_id = 49;
		$location_id = $this->request->query('location_id');
		$from_date = $this->request->query('from_date');
		$to_date   = $this->request->query('to_date');
		
		if(empty($from_date))
		{
			$from_date = date("Y-m-01");
			$to_date   = date("Y-m-d");
		}else{
			$from_date =  date("Y-m-d",strtotime($from_date));
			$to_date   =  date("Y-m-d",strtotime($to_date));
		}
		/* pr($from_date);
		pr($to_date); exit; */
		 if($item_variation_id){
			$InvoicesData=$this->Invoices->find()
			->contain(['InvoiceRows' => function($q) use($item_variation_id) {
				return $q->select(['invoice_id','quantity','item_id','item_variation_id'
				,'total_quantity' => $q->func()->sum('InvoiceRows.quantity')
				])->group('InvoiceRows.item_variation_id')->where(['item_variation_id'=>$item_variation_id])->contain(['Items','ItemVariations'=>['UnitVariations']])->order(['InvoiceRows.quantity' => 'DESC'])->autoFields(true);
			}
			])
			->where(['seller_id IS NULL','city_id'=>$city_id,'transaction_date >='=>$from_date,'transaction_date <='=>$to_date]);
		}else{
			$InvoicesData=$this->Invoices->find()
			->contain(['InvoiceRows' => function($q) {
				return $q->select(['invoice_id','quantity','item_id','item_variation_id'
				,'total_quantity' => $q->func()->sum('InvoiceRows.quantity')
				])->group('InvoiceRows.item_variation_id')->contain(['Items','ItemVariations'=>['UnitVariations']])->order(['InvoiceRows.quantity' => 'DESC'])->autoFields(true);
			}
			])
			->where(['seller_id IS NULL','city_id'=>$city_id,'transaction_date >='=>$from_date,'transaction_date <='=>$to_date]);
		}
		
		
		$showItemQty=[];
		$showItemName=[];
		$showItemUnit=[];
		$showItemrate=[];
		$itemOptions=[];
		foreach($InvoicesData as $data){
			foreach($data->invoice_rows as $invoice_row){ 
				@$showItem[$invoice_row->item_variation_id]+=@$invoice_row->total_quantity;
				@$showItemName[$invoice_row->item_variation_id]=@$invoice_row->item->name;
				@$showItemUnit[$invoice_row->item_variation_id]=@$invoice_row->item_variation->unit_variation->visible_variation;
				@$showItemrate[$invoice_row->item_variation_id]=@$invoice_row->rate;
				
			}
		}
		if(@$showItem){
			arsort($showItem);
			
		}
		$ItemVariations=$this->Invoices->InvoiceRows->Items->ItemVariations->find()->contain(['UnitVariations','Items']);
		
		foreach($ItemVariations as $ItemVariation){ 
			$itemOptions[]=['text'=>$ItemVariation->item->name.' ('.$ItemVariation->unit_variation->visible_variation.')','value'=>$ItemVariation->id];
		}
		//pr($showItemName);exit;
		$this->set(compact('showItem','showItemName','showItemUnit','from_date','to_date','showItemrate','item_variation_id','itemOptions'));
	}
	public function salesReport(){
		
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id'); 
		$location_id=$this->Auth->User('location_id'); 
		$this->viewBuilder()->layout('super_admin_layout');
		$location_id = $this->request->query('location_id');
		$from_date = $this->request->query('from_date');
		$to_date   = $this->request->query('to_date');
		$invoice_type   = $this->request->query('invoice_type');
		
		if(empty($from_date))
		{
			$from_date = date("Y-m-01");
			$to_date   = date("Y-m-d");
		}
		$where=[];
		if(!empty($from_date)){
			$where['Invoices.transaction_date >=']=date('Y-m-d',strtotime($from_date));
			$where['Invoices.transaction_date <=']=date('Y-m-d',strtotime($to_date));
			$where['Invoices.city_id']=$city_id;
			$where['Invoices.invoice_status']='Done';
			
		}
		if($invoice_type){
			$where['Invoices.order_type']=$invoice_type;
		}
			//pr($where); exit;
		$query=$this->Invoices->find()->where($where)->contain(['Challans','InvoiceRows','Customers'=>['Cities'=>function ($q){ return $q->where(['Cities.state_id '=>1]);}]]);
		/* $query->contain(['InvoiceRows'=>function($q){
					return $q->select(['invoice_id','gst_figure_id','totalTaxable' => $q->func()->sum('InvoiceRows.taxable_value'),'gst_value' => $q->func()->sum('InvoiceRows.gst_value')])
					->group('InvoiceRows.gst_figure_id');
				}]);  */
		//pr($invoice_type); exit;
		$totalGstTaxable=[];
		$totalGst=[];
		$InvoiceNo=[];
		$ChallaNo=[];
		//$InvoiceNoIGST=[];
		$InvoiceCustomer=[];
		$InvoiceCustomerGST=[];
		$InvoiceDate=[];
		$InvoiceType=[];
		foreach($query as $data){ 
			
			foreach($data->invoice_rows as $data1){
				@$totalGstTaxable[$data->id][$data1->gst_figure_id]+=$data1->taxable_value;
				@$totalGst[$data->id][$data1->gst_figure_id]+=$data1->gst_value;
			}
			$InvoiceNo[$data->id]=$data->invoice_no;
			$ChallaNo[$data->id]=$data->challan->invoice_no;
			$InvoiceType[$data->id]=$data->order_type;
			$InvoiceCustomer[$data->id]=$data->customer->name;
			$InvoiceCustomerGST[$data->id]=$data->customer->gstin;
			$InvoiceDate[$data->id]=$data->transaction_date;
		}
		
		//pr($totalGstTaxable); pr($totalGst); exit;
		
		
		$query=$this->Invoices->find()->where($where)->contain(['Challans','InvoiceRows','Customers'=>['Cities'=>function ($q){ return $q->where(['Cities.state_id != '=>1]);}]]);
		/* $query->contain(['InvoiceRows'=>function($q){
					return $q->select(['invoice_id','gst_figure_id','totalTaxable' => $q->func()->sum('InvoiceRows.taxable_value'),'gst_value' => $q->func()->sum('InvoiceRows.gst_value')])
					->group('InvoiceRows.gst_figure_id');
				}]);  */
		
		$totalIGstTaxable=[];
		$totalIGst=[];
		
		foreach($query as $data){
			foreach($data->invoice_rows as $data1){
				@$totalIGstTaxable[$data->id][$data1->gst_figure_id]+=$data1->taxable_value;
				@$totalIGst[$data->id][$data1->gst_figure_id]+=$data1->gst_value;
			}
			$ChallaNo[$data->id]=$data->challan->invoice_no;
			$InvoiceNoIGST[$data->id]=$data->invoice_no;
			$InvoiceCustomer[$data->id]=$data->customer->name;
			$InvoiceCustomerGST[$data->id]=$data->customer->gstin;
			$InvoiceDate[$data->id]=$data->transaction_date;
		}
		
		
		//pr($InvoiceNoIGST); pr($totalIGstTaxable); exit;
		$GstFigures=$this->Invoices->InvoiceRows->Items->GstFigures->find()->where(['GstFigures.city_id'=>$city_id])->toArray();
		
		$this->set(compact('totalGstTaxable','totalGst','GstFigures','from_date','to_date','InvoiceNo','totalIGst','InvoiceNoIGST','totalIGstTaxable','InvoiceCustomer','InvoiceCustomerGST','InvoiceDate','InvoiceType','ChallaNo','invoice_type'));
	}
}
