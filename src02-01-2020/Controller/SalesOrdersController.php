<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\View\View;
/**
 * SalesOrders Controller
 *
 * @property \App\Model\Table\SalesOrdersTable $SalesOrders
 *
 * @method \App\Model\Entity\SalesOrder[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SalesOrdersController extends AppController
{

	public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Security->setConfig('unlockedActions', ['add', 'index', 'view', 'edit','bulkBookingPerforma']);

    }
	
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
		$user_type =$this->Auth->User('user_type');
		if($user_type=="Super Admin"){
		$this->viewBuilder()->layout('super_admin_layout');	
		}else if($user_type=="Admin"){
		$this->viewBuilder()->layout('admin_portal');
		}
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id');
		$location_id=$this->Auth->User('location_id');
		
        $this->paginate = [
            'contain' => ['SalesOrderRows'=>['ItemVariations'], 'Customers',  'Cities'],
			'limit' => 100
        ];
		$sales=$this->SalesOrders->find()->where(['SalesOrders.city_id'=>$city_id,'SalesOrders.status'=>'Active'])->order(['SalesOrders.id'=>'DESC']);
        $salesOrders = $this->paginate($sales);
		
		$paginate_limit=$this->paginate['limit'];
        $this->set(compact('salesOrders','paginate_limit'));
    }

    /**
     * View method
     *
     * @param string|null $id Sales Order id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
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
        $order = $this->SalesOrders->newEntity();
		$CityData = $this->SalesOrders->Cities->get($city_id);
		$StateData = $this->SalesOrders->Cities->States->get($CityData->state_id);
	 
		$this->loadmodel('SalesOrders');
		$sales_orders = $this->SalesOrders->get($ids, [
            'contain' => ['Locations', 'Cities', 'Customers'=>['CustomerAddresses'], 'SalesOrderRows'=>['ItemVariations'=>['ItemVariationMasters','Items','UnitVariations'=>['Units']]]]
        ]);
		 
		$company_details=$this->SalesOrders->Companies->find()->where(['Companies.city_id'=>$city_id])->first();
        $this->set(compact('ids', 'sales_orders', 'order', 'locations', 'customers', 'drivers', 'customerAddresses', 'promotionDetails', 'deliveryCharges','cancelReasons','order_no','partyOptions','Accountledgers','items','company_details','print'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function bulkBookingPerforma(){
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id'); 
		//$location_id=$this->Auth->User('location_id');
		$this->viewBuilder()->layout('super_admin_layout');
       $sellerItem = $this->SalesOrders->newEntity();
	   
	     if ($this->request->is('post')) {
			$BulkOrderPerforma=$this->request->getData();
			$AllItems=$BulkOrderPerforma['item_ids'];
			$AllBrands=$BulkOrderPerforma['brand_id'];
			$AllQuantity=$BulkOrderPerforma['commissions'];
			$AllCategory=$BulkOrderPerforma['category_ids'];
			
			$BulkOrderPerformaData = $this->SalesOrders->BulkOrderPerformas->newEntity();
			$BulkOrderPerformaData->name=$BulkOrderPerforma['performa_name'];
			$BulkOrderPerformaData->city_id=$city_id;
			$BulkOrderPerformaData->created_on=date('Y-m-d');
			$BulkOrderPerformaData=$this->SalesOrders->BulkOrderPerformas->save($BulkOrderPerformaData);
			
			foreach($AllItems as $key=>$data){ 
				$BulkOrderPerformaRows = $this->SalesOrders->BulkOrderPerformas->BulkOrderPerformaRows->newEntity();
				$BulkOrderPerformaRows->bulk_order_performa_id=$BulkOrderPerformaData->id;
				$BulkOrderPerformaRows->category_id=$AllCategory[$key];
				$BulkOrderPerformaRows->brand_id=$AllBrands[$key];
				$BulkOrderPerformaRows->item_id=$data;
				$BulkOrderPerformaRows->quantity=$AllQuantity[$key];
				$this->SalesOrders->BulkOrderPerformas->BulkOrderPerformaRows->save($BulkOrderPerformaRows);
				//pr($BulkOrderPerformaRows); 
			} //exit;
			 return $this->redirect(['controller'=>'BulkOrderPerformas','action' => 'index']);
		 }
		
		$categories = $this->SalesOrders->SalesOrderRows->Items->Categories->find('threaded')->where(['Categories.city_id'=>$city_id])->contain(['Items']);
		//pr($categories->toArray()); exit;
        //$sellers = $this->SellerItems->Sellers->find('list')->where(['Sellers.city_id'=>$city_id]);
        $this->set(compact('sellerItem', 'categories', 'sellers'));
	}
	
	public function getSellerItems()
	{
		$city_id=$this->Auth->User('city_id');
		//$seller_id= $this->request->query('id');
		$categories = $this->SalesOrders->SalesOrderRows->Items->Categories->find('threaded')->where(['Categories.city_id'=>$city_id])->contain(['Items'=>['ItemVariations']]);
		
		$this->set(compact('getSellerItems','categories'));
	}
	
    public function add()
    {
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id'); 
		$location_id=$this->Auth->User('location_id');
		$state_id=$this->Auth->User('state_id'); 
		$user_type =$this->Auth->User('user_type');
		/* if($user_type=="Super Admin"){
		$this->viewBuilder()->layout('super_admin_layout');	
		$location_id=1;
		}else if($user_type=="Admin"){ */
		$this->viewBuilder()->layout('admin_portal');
		
        $salesOrder = $this->SalesOrders->newEntity();
		$CityData = $this->SalesOrders->Cities->get($city_id);
		$StateData = $this->SalesOrders->Cities->States->get($CityData->state_id);
	
		$Voucher_no = $this->SalesOrders->find()->select(['voucher_no'])->where(['SalesOrders.city_id'=>$city_id])->order(['voucher_no' => 'DESC'])->first();
		if($Voucher_no){$voucher_no=$Voucher_no->voucher_no+1;}
		else{$voucher_no=1;}
		$order_no=$CityData->alise_name.'/'.$voucher_no;
		$order_no=$StateData->alias_name.'/'.$order_no;
		//pr($sales_order_no); exit;
		//pr($sales_order_no); exit;
		
        if ($this->request->is('post')) {
            $salesOrder = $this->SalesOrders->patchEntity($salesOrder, $this->request->getData());
			$Voucher_no = $this->SalesOrders->find()->select(['voucher_no'])->where(['SalesOrders.city_id'=>$city_id])->order(['voucher_no' => 'DESC'])->first(); 
			if($Voucher_no){$voucher_no=$Voucher_no->voucher_no+1;}
			else{$voucher_no=1;}
			$salesOrder->delivery_date=date('Y-m-d', strtotime($this->request->getData('delivery_date')));
			$salesOrder->city_id=$city_id;
			$salesOrder->location_id=$location_id;
			$salesOrder->sales_order_from="Web";
			$salesOrder->narration=$this->request->getData('narration');
			$salesOrder->voucher_no=$voucher_no;
			$salesOrder->sales_order_status="Pending";
			$salesOrder->transaction_date=date('Y-m-d',strtotime($salesOrder->transaction_date));
			$Custledgers = $this->SalesOrders->SellerLedgers->get($salesOrder->sales_ledger_id);
			$salesOrder->customer_id=$Custledgers->customer_id;
			//pr($salesOrder);exit;
			 if ($this->SalesOrders->save($salesOrder)) { 
				$this->Flash->success(__('The sales salesOrder has been saved.'));

				return $this->redirect(['action' => 'index']);
			}
		 pr($salesOrder);
		 exit;
            $this->Flash->error(__('The sales salesOrder could not be saved. Please, try again.'));
        }
		
    /*
		$locations = $this->SalesOrders->Locations->find('list', ['limit' => 200]);
        $cities = $this->SalesOrders->Cities->find('list', ['limit' => 200]);
        $salesLedgers = $this->SalesOrders->SalesLedgers->find('list', ['limit' => 200]);
        $partyLedgers = $this->SalesOrders->PartyLedgers->find('list', ['limit' => 200]);
        $drivers = $this->SalesOrders->Drivers->find('list', ['limit' => 200]);
        $customerAddresses = $this->SalesOrders->CustomerAddresses->find('list', ['limit' => 200]);
        $promotionDetails = $this->SalesOrders->PromotionDetails->find('list', ['limit' => 200]);
        $deliveryCharges = $this->SalesOrders->DeliveryCharges->find('list', ['limit' => 200]);
        $deliveryTimes = $this->SalesOrders->DeliveryTimes->find('list', ['limit' => 200]);
        $cancelReasons = $this->SalesOrders->CancelReasons->find('list', ['limit' => 200]);
        $this->set(compact('salesOrder', 'locations', 'cities', 'salesLedgers', 'partyLedgers', 'customers', 'drivers', 'customerAddresses', 'promotionDetails', 'deliveryCharges', 'deliveryTimes', 'cancelReasons'));
	*/
		$customersData= $this->SalesOrders->Customers->find()->where(['Customers.city_id'=>$city_id]);
		$customers=array();
		foreach($customersData as $data){  
			$customers[]=['text' => $data->name,'value' => $data->id,'membership_discount'=>$data->membership_discount];
		}
		//pr($customers); exit;
		$itemList=$this->SalesOrders->Items->find()->contain(['ItemVariations'=> function ($q) use($city_id){
								return $q
								->where(['ItemVariations.status'=>'Active','ItemVariations.seller_id IS NULL','ItemVariations.city_id'=>$city_id])->contain(['UnitVariations'=>['Units']]);
								}]);
		
		$items=array();
		foreach($itemList as $data1){  
			if($data1->item_variations){
			foreach($data1->item_variations as $data){  
				
				$discount_applicable=$data1->is_discount_enable;
				$category_id=$data1->category_id;
				$gstData=$this->SalesOrders->GstFigures->get($data1->gst_figure_id);
				$merge=$data1->name.'('.@$data->unit_variation->quantity_variation.'.'.@$data->unit_variation->unit->shortname.')';
				$items[]=['text' => $merge,'value' => $data->id,'item_id'=>$data1->id,'quantity_factor'=>@$data->unit_variation->convert_unit_qty,'unit'=>@$data->unit_variation->unit->unit_name,'gst_figure_id'=>$data1->gst_figure_id,'gst_value'=>$gstData->tax_percentage,'commission'=>@$data->commission,'sale_rate'=>$data->sales_rate,'current_stock'=>(($data->current_stock+$data->virtual_stock)-$data->demand_stock),'virtual_stock'=>$data->virtual_stock,'demand_stock'=>$data->demand_stock,'discount_applicable'=>$discount_applicable,'category_id'=>$category_id];
				 
			}
			}
		}
		 //pr($items); exit;
		//pr($items); exit;
		
		
		$accountLedgers = $this->SalesOrders->AccountingGroups->find()->where(['AccountingGroups.sale_invoice_sales_account'=>1,'AccountingGroups.city_id'=>$city_id])->first();

		$accountingGroups2 = $this->SalesOrders->AccountingGroups
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
			$Accountledgers = $this->SalesOrders->Ledgers->find('list')->where(['Ledgers.accounting_group_id IN' =>$account_ids]);
        }
		
		
		
		
		
		
		
		
		$partyParentGroups = $this->SalesOrders->AccountingGroups->find()
						->where(['AccountingGroups.
						sale_invoice_party'=>'1','AccountingGroups.city_id'=>$city_id]); 
		$partyGroups=[];
		foreach($partyParentGroups as $partyParentGroup)
		{
			$accountingGroups = $this->SalesOrders->AccountingGroups
			->find('children', ['for' => $partyParentGroup->id])->toArray(); 
			$partyGroups[]=$partyParentGroup->id;
			foreach($accountingGroups as $accountingGroup){
				$partyGroups[]=$accountingGroup->id;
			}
		}  
		if($partyGroups)
		{  
			$Partyledgers = $this->SalesOrders->SellerLedgers->find()
							->where(['SellerLedgers.accounting_group_id IN' =>$partyGroups])
							->contain(['Customers'=>['Cities']]);
        } 
		$partyOptions=[];
		foreach($Partyledgers as $Partyledger){  

			
			$customer_address=$this->SalesOrders->CustomerAddresses->find()->where(['CustomerAddresses.customer_id'=>$Partyledger->customer_id,'CustomerAddresses.default_address'=>1,'CustomerAddresses.is_deleted'=>0])->first();
			$customer_address_count=$this->SalesOrders->CustomerAddresses->find()->where(['CustomerAddresses.customer_id'=>$Partyledger->customer_id,'CustomerAddresses.default_address'=>1,'CustomerAddresses.is_deleted'=>0])->count();
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
			 
			//$partyOptions[]=['text' =>$Partyledger->name, 'value' => $Partyledger->id,'city_id'=>$Partyledger->customer->city->id,'state_id'=>$Partyledger->customer->city->state_id,'bill_to_bill_accounting'=>$Partyledger->bill_to_bill_accounting,'customer_id'=>$Partyledger->customer_id,'customer_address_id'=>$customer_address_id];
			
			$partyOptions[]=['text' =>$Partyledger->name, 'value' => $Partyledger->id,'city_id'=>$Partyledger->customer->city->id,'state_id'=>$Partyledger->customer->city->state_id,'bill_to_bill_accounting'=>$Partyledger->bill_to_bill_accounting,'customer_id'=>$Partyledger->customer_id,'customer_address_id'=>$customer_address_id,'membership_discount'=>$Partyledger->customer->membership_discount,'membership_start_date'=>$Partyledger->customer->start_date,'membership_end_date'=>$Partyledger->customer->end_date,'wallet'=>$wallet_remaining];
		}
		
		
		$deliveryTmes = $this->SalesOrders->DeliveryTimes->find()->where(['DeliveryTimes.city_id'=>$city_id, 'DeliveryTimes.status'=>'Active']);
		
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
		  
		$start_date=date('d-m-Y', strtotime("+".$g."days"));
		$last_date=date('d-m-Y', strtotime("+".$next_day."days"));
		
		$holiday_count=$this->Holidays->find()->where(['Holidays.city_id'=>$city_id,'Holidays.date >='=>$start_date,'Holidays.date <='=>$last_date])->count();
		
        $this->set(compact('salesOrder', 'locations', 'customers', 'drivers', 'customerAddresses', 'promotionDetails', 'deliveryCharges', 'deliveryTimes', 'cancelReasons','order_no','partyOptions','Accountledgers','items','deliverydates', 'holidays', 'holiday_count'));
		
    }

    /**
     * Edit method
     *
     * @param string|null $id Sales Order id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $salesOrder = $this->SalesOrders->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $salesOrder = $this->SalesOrders->patchEntity($salesOrder, $this->request->getData());
            if ($this->SalesOrders->save($salesOrder)) {
                $this->Flash->success(__('The sales order has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The sales order could not be saved. Please, try again.'));
        }
        $locations = $this->SalesOrders->Locations->find('list', ['limit' => 200]);
        $cities = $this->SalesOrders->Cities->find('list', ['limit' => 200]);
        $salesLedgers = $this->SalesOrders->SalesLedgers->find('list', ['limit' => 200]);
        $partyLedgers = $this->SalesOrders->PartyLedgers->find('list', ['limit' => 200]);
        $customers = $this->SalesOrders->Customers->find('list', ['limit' => 200]);
        $drivers = $this->SalesOrders->Drivers->find('list', ['limit' => 200]);
        $customerAddresses = $this->SalesOrders->CustomerAddresses->find('list', ['limit' => 200]);
        $promotionDetails = $this->SalesOrders->PromotionDetails->find('list', ['limit' => 200]);
        $deliveryCharges = $this->SalesOrders->DeliveryCharges->find('list', ['limit' => 200]);
        $deliveryTimes = $this->SalesOrders->DeliveryTimes->find('list', ['limit' => 200]);
        $cancelReasons = $this->SalesOrders->CancelReasons->find('list', ['limit' => 200]);
        $this->set(compact('salesOrder', 'locations', 'cities', 'salesLedgers', 'partyLedgers', 'customers', 'drivers', 'customerAddresses', 'promotionDetails', 'deliveryCharges', 'deliveryTimes', 'cancelReasons'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Sales Order id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($dir)
    {
        $this->request->allowMethod(['patch', 'post', 'put']);
		$id = $this->EncryptingDecrypting->decryptData($dir);
        $salesOrder = $this->SalesOrders->get($id);
		$salesOrder->status='Deactive';
        if ($this->SalesOrders->save($salesOrder)) {
            $this->Flash->success(__('The sales order has been deleted.'));
        } else {
            $this->Flash->error(__('The sales order could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
