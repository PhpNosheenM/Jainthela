<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\View\View;


/**
 * Grns Controller
 *
 * @property \App\Model\Table\GrnsTable $Grns
 *
 * @method \App\Model\Entity\Grn[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class GrnsController extends AppController
{
	
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Security->setConfig('unlockedActions', ['add','sellerAdd','sellerIndex','edit','editGrnRow','editGrn','addGrnRow','addGrn']);
		//$this->Auth->allow(['editTest']);
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        
        $company_id=$this->Auth->User('company_id');
        $user_type=$this->Auth->User('user_type');
		if($user_type=="Super Admin"){
			$this->viewBuilder()->layout('super_admin_layout');
		}
		$status=$this->request->query('status');
        $user_id=$this->Auth->User('id');
        $city_id=$this->Auth->User('city_id');
        $search=$this->request->query('search');
        $this->paginate = [
			'contain'=>['StockTransferVouchers'],
            'limit' => 100
        ];
        $grns = $this->Grns->find()
                            ->where(['Grns.city_id'=>$city_id])
                            ->where([ 'OR'=>['Grns.voucher_no' => $search,
                                // ...
                                'VendorLedgers.name LIKE' => '%'.$search.'%',
                                //.....
                                'Grns.reference_no LIKE' => '%'.$search.'%',
                                //...
                                'Grns.transaction_date ' => date('Y-m-d',strtotime($search))]])
                            ->contain(['VendorLedgers']);
      
        $grns = $this->paginate($grns);
		//pr($grns); exit;
        $this->set(compact('grns','status'));
    }
	public function sellerIndex()
    {
        
        $company_id=$this->Auth->User('company_id');
        $user_type=$this->Auth->User('user_type');
		$this->viewBuilder()->layout('seller_layout');
        $user_id=$this->Auth->User('id');
        $city_id=$this->Auth->User('city_id');
        $search=$this->request->query('search');
        $this->paginate = [
            'limit' => 10
        ];
        $grns = $this->Grns->find()
                            ->where(['Grns.city_id'=>$city_id,'Grns.seller_id'=>$user_id])
                            ->where([ 'OR'=>['Grns.voucher_no' => $search,
                                // ...
                                'VendorLedgers.name LIKE' => '%'.$search.'%',
                                //.....
                                'Grns.reference_no LIKE' => '%'.$search.'%',
                                //...
                                'Grns.transaction_date ' => date('Y-m-d',strtotime($search))]])
                            ->contain(['VendorLedgers']);
      
       // $grns = $this->paginate($grns);

        $this->set(compact('grns'));
    }
	
	public function index1()
    {
        $this->viewBuilder()->layout('super_admin_layout');
        $company_id=$this->Auth->User('company_id');
        $user_id=$this->Auth->User('id');
        $city_id=$this->Auth->User('city_id');
        $search=$this->request->query('search');
		$ledger_id = $this->request->query('ledger_id');
        $this->paginate = [
            'limit' => 10
        ];
		
		$newGrns=$this->Grns->newEntity();
        
		if ($this->request->is(['post'])) {
			$to_be_send=$this->request->data['to_be_send'];
			//pr($to_be_send); exit;
			$this->redirect(['controller'=>'PurchaseInvoices','action' => 'add/'.json_encode($to_be_send).'']);
		}
		
		 $partyParentGroups = $this->Grns->GrnRows->Ledgers->AccountingGroups->find('all')
                        ->where(['AccountingGroups.city_id'=>$city_id, 'AccountingGroups.vendor'=>'1'])
						->orWhere(['AccountingGroups.city_id'=>$city_id, 'AccountingGroups.seller'=>'1']);
        $partyGroups=[];
        //pr($partyParentGroups->toArray()); exit;
        foreach($partyParentGroups as $partyParentGroup)
        {
            $accountingGroups = $this->Grns->GrnRows->Ledgers->AccountingGroups
            ->find('children', ['for' => $partyParentGroup->id])->toArray();
            $partyGroups[]=$partyParentGroup->id;
            foreach($accountingGroups as $accountingGroup){
                $partyGroups[]=$accountingGroup->id;
            }
        }	//
		//pr($partyGroups); exit;
        if($partyGroups)
        {  
            $Partyledgers = $this->Grns->VendorLedgers->find()
                            ->where(['VendorLedgers.accounting_group_id IN' =>$partyGroups,'VendorLedgers.city_id'=>$city_id]);
        }
     //pr($Partyledgers->toArray()); exit;
        $partyOptions=[];
        foreach($Partyledgers as $Partyledger){
            $partyOptions[]=['text' =>$Partyledger->name, 'value' => $Partyledger->id];
        }
		
	  if($ledger_id > 0){
		 $grns = $this->Grns->find()->where(['Grns.city_id'=>$city_id,'purchase_invoice_status'=>'Pending','vendor_ledger_id'=>$ledger_id,'Grns.seller_id IS NULL '])->contain(['VendorLedgers']);
        $grns = $this->paginate($grns);
	  }else{
		  $grns = $this->Grns->find()->where(['Grns.city_id'=>$city_id,'Grns.purchase_invoice_status'=>'Pending','Grns.seller_id IS NULL '])->contain(['VendorLedgers']);
	  }

        $this->set(compact('grns','newGrns','partyOptions','ledger_id'));
    }

    /**
     * View method
     *
     * @param string|null $id Grn id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id');
		$location_id=$this->Auth->User('location_id');
		$this->viewBuilder()->layout('super_admin_layout');
        $grn = $this->Grns->get($id, [
            'contain' => ['VendorLedgers','Cities','GrnRows'=>['UnitVariations','Items']]
        ]);
		$this->loadmodel('Companies');
		$companies=$this->Companies->find()->where(['Companies.city_id'=>$city_id])->first();
		$this->set(compact('grn','companies'));
        $this->set('grn', $grn);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        //$this->viewBuilder()->layout('super_admin_layout');
		
		$user_type=$this->Auth->User('user_type');
		if($user_type=="Super Admin"){
			$this->viewBuilder()->layout('super_admin_layout');
		}else{
			$this->viewBuilder()->layout('seller_layout');
		}
        $company_id=$this->Auth->User('company_id');
        $financial_year_id=$this->Auth->User('financial_year_id');
     
        $user_id=$this->Auth->User('id');
        //$companies = $this->Grns->Companies->find('list')->where(['id'=>$company_id]);
        $city_id=$this->Auth->User('city_id');
        $grn = $this->Grns->newEntity();
        //$this->request->data['location_id'] =$location_id;
        if ($this->request->is('post')) 
        {
            $grn = $this->Grns->patchEntity($grn, $this->request->getData());
            $grn->transaction_date = date("Y-m-d",strtotime($this->request->getData()['transaction_date']));
            $Voucher_no = $this->Grns->find()->select(['voucher_no'])->where(['city_id'=>$city_id,'financial_year_id'=>$financial_year_id])->order(['voucher_no' => 'DESC'])->first();
            if($Voucher_no)
            {
                $grn->voucher_no = $Voucher_no->voucher_no+1;
            }
            else
            {
                $grn->voucher_no = 1;
            } 
             $Grn_no = $this->Grns->find()->select(['grn_no'])->where(['city_id'=>$city_id,'financial_year_id'=>$financial_year_id])->order(['grn_no' => 'DESC'])->first();
            if($Grn_no)
            {
                $grn->grn_no = $Grn_no->grn_no+1;
            }
            else
            {
                $grn->grn_no = 1;
            } 
            $grn->city_id =$city_id;
            $grn->financial_year_id=$financial_year_id;
            $grn->created_for ='Jainthela';
            $grn->super_admin_id =$user_id;
			//pr($grn); exit;
            if ($this->Grns->save($grn)) 
            {
                //Create Item_Ledger//
                foreach($grn->grn_rows as $grn_row)
                {
                    $item_ledger = $this->Grns->ItemLedgers->newEntity();
                    $item_ledger->transaction_date = $grn->transaction_date;
                    $item_ledger->grn_id = $grn->id;
                    $item_ledger->grn_row_id = $grn_row->id;
                    $item_ledger->unit_variation_id = $grn_row->unit_variation_id;
                    $item_ledger->item_id = $grn_row->item_id;
                    $item_ledger->quantity = $grn_row->quantity;
                    $item_ledger->rate = $grn_row->purchase_rate;
                    $item_ledger->expiry_date = $grn_row->expiry_date;
                    //$item_ledger->sale_rate = $grn_row->sale_rate;
                   // $item_ledger->company_id  =$company_id;
                    $item_ledger->city_id =$city_id;
                    $item_ledger->status ='In';
                    $item_ledger->amount=$grn_row->quantity*$grn_row->purchase_rate;
                    $this->Grns->ItemLedgers->save($item_ledger);
                    $item = $this->Grns->GrnRows->Items->find()->where(['Items.id'=>$grn_row->item_id])->first();
                    
					/* $item_variation_data = $this->Grns->GrnRows->Items->ItemVariations->get($grn_row->item_variation_id);
					
					if($item_variation_data->demand_stock < $grn_row->quantity){
						$remaining=$grn_row->quantity-$item_variation_data->demand_stock;
						$current_stock=$remaining+$item_variation_data->current_stock;
						$query = $this->Grns->GrnRows->Items->ItemVariations->query();
						$query->update()
						->set(['current_stock'=>$current_stock,'demand_stock'=>0])
						->where(['id'=>$grn_row->item_variation_id])
						->execute(); 
					}else{
						$demand_stock=$grn_row->demand_stock-$item_variation_data->quantity;
						//$current_stock=$cur_stock-$item_variation_data->demand_stock;
						$query = $this->Grns->GrnRows->Items->ItemVariations->query();
						$query->update()
						->set(['current_stock'=>0,'demand_stock'=>$demand_stock])
						->where(['id'=>$grn_row->item_variation_id])
						->execute(); 
					} */
                }
                $this->Flash->success(__('The challan has been saved.'));
                return $this->redirect(['action' => 'add']);
            }
            pr($grn);
            exit;
            $this->Flash->error(__('The challan could not be saved. Please, try again.'));
        }
        $items = $this->Grns->GrnRows->Items->SellerItems->find()->where(['SellerItems.city_id'=>$city_id,'SellerItems.seller_id IS NULL','SellerItems.status'=>'Active'])->contain(['Items'=>['GstFigures']]);
       
        $itemOptions=[];
        foreach($items as $item)
        {
                $itemOptions[]=['text' =>$item->item->name, 'value' => $item->item->id,'tax_percentage'=>$item->item->gst_figure->tax_percentage];
        }
        $Voucher_no = $this->Grns->find()->select(['voucher_no'])->where(['financial_year_id'=>$financial_year_id,'city_id'=>$city_id])->order(['voucher_no' => 'DESC'])->first();
        if($Voucher_no)
        {
            $voucher_no=$Voucher_no->voucher_no+1;
        }
        else
        { 
            $voucher_no=1;
        } 
        
         $partyParentGroups = $this->Grns->GrnRows->Ledgers->AccountingGroups->find('all')
                        ->where(['AccountingGroups.city_id'=>$city_id, 'AccountingGroups.vendor'=>'1']);
        $partyGroups=[];
         
        foreach($partyParentGroups as $partyParentGroup)
        {
            $accountingGroups = $this->Grns->GrnRows->Ledgers->AccountingGroups
            ->find('children', ['for' => $partyParentGroup->id])->toArray();
            $partyGroups[]=$partyParentGroup->id;
            foreach($accountingGroups as $accountingGroup){
                $partyGroups[]=$accountingGroup->id;
            }
        }	
        if($partyGroups)
        {  
            $Partyledgers = $this->Grns->VendorLedgers->find()
                            ->where(['VendorLedgers.accounting_group_id IN' =>$partyGroups,'VendorLedgers.city_id'=>$city_id])
                            ->contain(['Vendors']);
        }
       
        $partyOptions=[];
        foreach($Partyledgers as $Partyledger){
            $partyOptions[]=['text' =>$Partyledger->name, 'value' => $Partyledger->id];
        }
        
       $units = $this->Grns->Units->find()->where(['status'=>'Active','city_id'=>$city_id])->contain(['UnitVariations']);
       
        $unitVariationOptions=[];
        foreach($units as $unit)
        {
            foreach ($unit->unit_variations as $unit_variation) {
                
                $unitVariationOptions[]=['text' =>$unit_variation->quantity_variation.' '.$unit->shortname, 'value' => $unit_variation->id];
            }
        }
        $this->set(compact('grn','companies','voucher_no','itemOptions','partyOptions','unitVariationOptions'));
        $this->set('_serialize', ['grn']);
    }


   /*  public function updateRate(){
		$grns = $this->Grns->GrnRows->find();
		foreach($grns as $grn){
			$query = $this->Grns->GrnRows->query();
			$query->update()
			->set(['rate'=>$grn->purchase_rate])
			->where(['id'=>$grn->id])
			->execute(); 
			
		} exit;
	} */
    public function sellerAdd()
    {
        //$this->viewBuilder()->layout('super_admin_layout');
		
		$user_type=$this->Auth->User('user_type');
		if($user_type=="Super Admin"){
			$this->viewBuilder()->layout('super_admin_layout');
		}else{
			$this->viewBuilder()->layout('seller_layout');
		}
        $company_id=$this->Auth->User('company_id');
     
        $user_id=$this->Auth->User('id');
        //$companies = $this->Grns->Companies->find('list')->where(['id'=>$company_id]);
        $city_id=$this->Auth->User('city_id');
        $grn = $this->Grns->newEntity();
        //$this->request->data['location_id'] =$location_id;
        if ($this->request->is('post')) 
        { 
            $grn = $this->Grns->patchEntity($grn, $this->request->getData());
            $grn->transaction_date = date("Y-m-d",strtotime($this->request->getData()['transaction_date']));
            $Voucher_no = $this->Grns->find()->select(['voucher_no'])->where(['city_id'=>$city_id])->order(['voucher_no' => 'DESC'])->first();
            if($Voucher_no)
            {
                $grn->voucher_no = $Voucher_no->voucher_no+1;
            }
            else
            {
                $grn->voucher_no = 1;
            } 
             $Grn_no = $this->Grns->find()->select(['grn_no'])->where(['city_id'=>$city_id])->order(['grn_no' => 'DESC'])->first();
            if($Grn_no)
            {
                $grn->grn_no = $Grn_no->grn_no+1;
            }
            else
            {
                $grn->grn_no = 1;
            } 
			 $sellerLedger = $this->Grns->GrnRows->Ledgers->find()->where(['seller_id'=>$user_id])->first();
			
            $grn->city_id =$city_id;
            $grn->created_for ='Seller';
            $grn->seller_id =$user_id;
            $grn->vendor_ledger_id =$sellerLedger->id;
			 //pr($grn);  exit;
            if ($this->Grns->save($grn)) 
            {
                //Create Item_Ledger//
                foreach($grn->grn_rows as $grn_row)
                {
                    $item_ledger = $this->Grns->ItemLedgers->newEntity();
                    $item_ledger->transaction_date = $grn->transaction_date;
                    $item_ledger->grn_id = $grn->id;
                    $item_ledger->grn_row_id = $grn_row->id;
                    $item_ledger->unit_variation_id = $grn_row->unit_variation_id;
                    $item_ledger->item_id = $grn_row->item_id;
                    //$item_ledger->item_variation_id = $grn_row->item_variation_id;
                    $item_ledger->quantity = $grn_row->quantity;
                    $item_ledger->rate = $grn_row->purchase_rate;
                    $item_ledger->expiry_date = $grn_row->expiry_date;
					//$item_ledger->sale_rate = $grn_row->sale_rate;
					//$item_ledger->seller_id =$user_id;
                    $item_ledger->city_id =$city_id;
                    $item_ledger->status ='In';
                    $item_ledger->amount=$grn_row->quantity*$grn_row->purchase_rate;
                    $this->Grns->ItemLedgers->save($item_ledger);
                    $item = $this->Grns->GrnRows->Items->find()->where(['Items.id'=>$grn_row->item_id])->first();
					
					/* $item_variation_data = $this->Grns->GrnRows->Items->ItemVariations->get($grn_row->item_variation_id);
					
					if($item_variation_data->demand_stock < $grn_row->quantity){
						$remaining=$grn_row->quantity-$item_variation_data->demand_stock;
						$current_stock=$remaining+$item_variation_data->current_stock;
						$query = $this->Grns->GrnRows->Items->ItemVariations->query();
						$query->update()
						->set(['current_stock'=>$current_stock,'demand_stock'=>0,'add_stock'=>$grn_row->quantity])
						->where(['id'=>$grn_row->item_variation_id])
						->execute(); 
					}else{
						$demand_stock=$item_variation_data->demand_stock-$grn_row->quantity;
						//$current_stock=$cur_stock-$item_variation_data->demand_stock;
						$query = $this->Grns->GrnRows->Items->ItemVariations->query();
						$query->update()
						->set(['current_stock'=>0,'demand_stock'=>$demand_stock,'add_stock'=>$grn_row->quantity])
						->where(['id'=>$grn_row->item_variation_id])
						->execute(); 
					} */
					
					
                    
                }
                $this->Flash->success(__('The challan has been saved.'));
                return $this->redirect(['action' => 'sellerAdd']);
            }
            
            $this->Flash->error(__('The challan could not be saved. Please, try again.'));
        }
       /*  $items = $this->Grns->GrnRows->Items->SellerItems->find()->where(['SellerItems.city_id'=>$city_id,'SellerItems.seller_id IS NULL','SellerItems.status'=>'Active'])->contain(['Items']);
       
        $itemOptions=[];
        foreach($items as $item)
        {
                $itemOptions[]=['text' =>$item->item->name, 'value' => $item->item->id];
        } */
		
		$itemList=$this->Grns->GrnRows->Items->find()->contain(['ItemVariations'=> function ($q) use($city_id,$user_id){
								return $q 
								->where(['ItemVariations.status'=>'Active','ItemVariations.city_id '=>$city_id,'seller_id'=>$user_id])->contain(['UnitVariations'=>['Units']]);
								}]);
		//pr($itemList->toArray()); exit;
		$itemOptions=array();
		foreach($itemList as $data1){ 
		if($data1->item_variations){
				foreach($data1->item_variations as $data){  
					//$gstData=$this->Orders->GstFigures->get($data1->gst_figure_id);
					$merge=$data1->name.'('.@$data->unit_variation->quantity_variation.'.'.@$data->unit_variation->unit->shortname.')';
					$itemOptions[]=['text' => $merge,'value' => $data->id,'item_id'=>$data1->id,'quantity_factor'=>@$data->unit_variation->convert_unit_qty,'unit'=>@$data->unit_variation->unit->unit_name,'purchase_rate'=>@$data->purchase_rate,'unit_variation_id'=>@$data->unit_variation_id];
				}
			}
		}
		//pr($items); exit;
        $Voucher_no = $this->Grns->find()->select(['voucher_no'])->where(['super_admin_id'=>$user_id])->order(['voucher_no' => 'DESC'])->first();
        if($Voucher_no)
        {
            $voucher_no=$Voucher_no->voucher_no+1;
        }
        else
        { 
            $voucher_no=1;
        } 
        
         $partyParentGroups = $this->Grns->GrnRows->Ledgers->AccountingGroups->find('all')
                        ->where(['AccountingGroups.city_id'=>$city_id, 'AccountingGroups.vendor'=>'1']);
        $partyGroups=[];
         
        foreach($partyParentGroups as $partyParentGroup)
        {
            $accountingGroups = $this->Grns->GrnRows->Ledgers->AccountingGroups
            ->find('children', ['for' => $partyParentGroup->id])->toArray();
            $partyGroups[]=$partyParentGroup->id;
            foreach($accountingGroups as $accountingGroup){
                $partyGroups[]=$accountingGroup->id;
            }
        }	
        if($partyGroups)
        {  
            $Partyledgers = $this->Grns->VendorLedgers->find()
                            ->where(['VendorLedgers.accounting_group_id IN' =>$partyGroups,'VendorLedgers.city_id'=>$city_id])
                            ->contain(['Vendors']);
        }
       
        $partyOptions=[];
        foreach($Partyledgers as $Partyledger){
            $partyOptions[]=['text' =>$Partyledger->name, 'value' => $Partyledger->id];
        }
        
       $units = $this->Grns->Units->find()->where(['status'=>'Active','city_id'=>$city_id])->contain(['UnitVariations']);
       $Locations = $this->Grns->Locations->find('list')->where(['city_id'=>$city_id]);
       
        $unitVariationOptions=[];
        foreach($units as $unit)
        {
            foreach ($unit->unit_variations as $unit_variation) {
                
                $unitVariationOptions[]=['text' =>$unit_variation->quantity_variation.' '.$unit->shortname, 'value' => $unit_variation->id];
            }
        }
        $this->set(compact('grn','companies','voucher_no','itemOptions','partyOptions','unitVariationOptions','Locations'));
        $this->set('_serialize', ['grn']);
    }
   
    /**
     * Edit method
     *
     * @param string|null $id Grn id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function addGrn()
    {
        $success=0;
        if ($this->request->is(['get'])) {
            $company_id=$this->Auth->User('company_id');
            $financial_year_id=$this->Auth->User('financial_year_id');
         
            $user_id=$this->Auth->User('id');
            //$companies = $this->Grns->Companies->find('list')->where(['id'=>$company_id]);
            $city_id=$this->Auth->User('city_id');
            $grn = $this->Grns->newEntity();
            $grn = $this->Grns->patchEntity($grn, $this->request->query());
            $grn->transaction_date=date('Y-m-d',strtotime($this->request->query('transaction_date')));
            $Voucher_no = $this->Grns->find()->select(['voucher_no'])->where(['city_id'=>$city_id,'financial_year_id'=>$financial_year_id])->order(['voucher_no' => 'DESC'])->first();
            if($Voucher_no)
            {
                $grn->voucher_no = $Voucher_no->voucher_no+1;
            }
            else
            {
                $grn->voucher_no = 1;
            } 
             $Grn_no = $this->Grns->find()->select(['grn_no'])->where(['city_id'=>$city_id,'financial_year_id'=>$financial_year_id])->order(['grn_no' => 'DESC'])->first();
            if($Grn_no)
            {
                $grn->grn_no = $Grn_no->grn_no+1;
            }
            else
            {
                $grn->grn_no = 1;
            } 
            $grn->city_id =$city_id;
            $grn->financial_year_id=$financial_year_id;
            $grn->created_for ='Jainthela';
            $grn->super_admin_id =$user_id;
            if($this->Grns->save($grn))
            {
                $success=$grn->id;
            }
        }
        $response=$success;
        $this->set(compact('success','response'));
        $this->set('_serialize', ['response','success']);
    }
    public function addGrnRow()
    {
        $success=0;
        if ($this->request->is(['get'])) {
            $city_id=$this->Auth->User('city_id');
            $grn_id=$this->request->query('grn_id');
            $grn = $this->Grns->get($grn_id);
            $grnRows = $this->Grns->GrnRows->newEntity();
            $grnRows = $this->Grns->GrnRows->patchEntity($grnRows, $this->request->query());
            $grnRows->grn_id=$grn_id;
            $grnRows->expiry_date=date('Y-m-d',strtotime($this->request->query('expiry_date')));
            if($this->Grns->GrnRows->save($grnRows))
            {
                $this->Grns->ItemLedgers->deleteAll(['grn_row_id'=>$grnRows->id]);
                $item_ledger = $this->Grns->ItemLedgers->newEntity();
                $item_ledger->transaction_date = $grn->transaction_date;
                $item_ledger->grn_id = $grn->id;
                $item_ledger->grn_row_id = $grnRows->id;
                $item_ledger->unit_variation_id = $grnRows->unit_variation_id;
                $item_ledger->item_id = $grnRows->item_id;
                $item_ledger->quantity = $grnRows->quantity;
                $item_ledger->rate = $grnRows->purchase_rate;
                $item_ledger->expiry_date = $grnRows->expiry_date;
                $item_ledger->city_id =$city_id;
                $item_ledger->status ='In';
                $item_ledger->amount=$grnRows->quantity*$grnRows->purchase_rate;
                $this->Grns->ItemLedgers->save($item_ledger);
                $success=$grnRows->id;
            }
        }
        $response[]=$success;
        $this->set(compact('success','response'));
        $this->set('_serialize', ['response','success']);
    }
    public function editGrn()
    {
        $success=0;
        if ($this->request->is(['get'])) {
            $id=$this->request->query('grn_id');
            $grn = $this->Grns->get($id);
            $grn = $this->Grns->patchEntity($grn, $this->request->query());
            $grn->transaction_date=date('Y-m-d',strtotime($this->request->query('transaction_date')));
            if($this->Grns->save($grn))
            {
                $success=2;
            }
        }
        $response[]=$success;
        $this->set(compact('success','response'));
        $this->set('_serialize', ['response','success']);
    }
    public function editGrnRow()
    {
        $success=0;
        if ($this->request->is(['get'])) {
            $city_id=$this->Auth->User('city_id');
            $id=$this->request->query('id');
            $grn_id=$this->request->query('grn_id');
            $grn = $this->Grns->get($grn_id);
            if(!empty(@$id))
            {
                $grnRows = $this->Grns->GrnRows->get($id);
                $grnRows = $this->Grns->GrnRows->patchEntity($grnRows, $this->request->query());
            }
            else
            {
                $grnRows = $this->Grns->GrnRows->newEntity();
                $grnRows = $this->Grns->GrnRows->patchEntity($grnRows, $this->request->query());
                $grnRows->grn_id=$grn_id;
            }
            $grnRows->expiry_date=date('Y-m-d',strtotime($this->request->query('expiry_date')));
            if($this->Grns->GrnRows->save($grnRows))
            {
                $this->Grns->ItemLedgers->deleteAll(['grn_row_id'=>$grnRows->id]);
                $item_ledger = $this->Grns->ItemLedgers->newEntity();
                $item_ledger->transaction_date = $grn->transaction_date;
                $item_ledger->grn_id = $grn->id;
                $item_ledger->grn_row_id = $grnRows->id;
                $item_ledger->unit_variation_id = $grnRows->unit_variation_id;
                $item_ledger->item_id = $grnRows->item_id;
                $item_ledger->quantity = $grnRows->quantity;
                $item_ledger->rate = $grnRows->purchase_rate;
                $item_ledger->expiry_date = $grnRows->expiry_date;
                $item_ledger->city_id =$city_id;
                $item_ledger->status ='In';
                $item_ledger->amount=$grnRows->quantity*$grnRows->purchase_rate;
                $this->Grns->ItemLedgers->save($item_ledger);
                $success=$grnRows->id;
            }
        }
        $response[]=$success;
        $this->set(compact('success','response'));
        $this->set('_serialize', ['response','success']);
    }
    public function edit($id = null)
    {
	
		$user_type=$this->Auth->User('user_type');
		if($user_type=="Super Admin"){
			$this->viewBuilder()->layout('super_admin_layout');
		}else{
			$this->viewBuilder()->layout('seller_layout');
		}
        $company_id=$this->Auth->User('company_id');
        $financial_year_id=$this->Auth->User('financial_year_id');
     
        $user_id=$this->Auth->User('id');
        //$companies = $this->Grns->Companies->find('list')->where(['id'=>$company_id]);
        $city_id=$this->Auth->User('city_id');
		
        $grn = $this->Grns->get($id, [
            'contain' => ['GrnRows'=>['Items','UnitVariations']]
        ]);
		//pr($grn); exit;
        if ($this->request->is(['patch', 'post', 'put'])) {
			
            $grn = $this->Grns->patchEntity($grn, $this->request->getData());
			pr($this->request->data); 
			//pr($grn); 
			exit;
			$grn->transaction_date=date('Y-m-d',strtotime($grn->transaction_date));
			
            if ($this->Grns->save($grn)) {
				$this->Grns->ItemLedgers->deleteAll(['grn_id'=>$id]);
				foreach($grn->grn_rows as $grn_row)
                {
                    $item_ledger = $this->Grns->ItemLedgers->newEntity();
                    $item_ledger->transaction_date = $grn->transaction_date;
                    $item_ledger->grn_id = $grn->id;
                    $item_ledger->grn_row_id = $grn_row->id;
                    $item_ledger->unit_variation_id = $grn_row->unit_variation_id;
                    $item_ledger->item_id = $grn_row->item_id;
                   // $item_ledger->item_variation_id = $grn_row->item_variation_id;
                    $item_ledger->quantity = $grn_row->quantity;
                    $item_ledger->rate = $grn_row->purchase_rate;
                    $item_ledger->expiry_date = $grn_row->expiry_date;
					//$item_ledger->sale_rate = $grn_row->sale_rate;
					//$item_ledger->seller_id =$user_id;
                    $item_ledger->city_id =$city_id;
                    $item_ledger->status ='In';
                    $item_ledger->amount=$grn_row->quantity*$grn_row->purchase_rate;
					$this->Grns->ItemLedgers->save($item_ledger);
				}
				
                $this->Flash->success(__('The grn has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The grn could not be saved. Please, try again.'));
        }
         $items = $this->Grns->GrnRows->Items->SellerItems->find()->where(['SellerItems.city_id'=>$city_id,'SellerItems.seller_id IS NULL','SellerItems.status'=>'Active'])->contain(['Items'=>['GstFigures']]);
       
        $itemOptions=[];
        foreach($items as $item)
        {
                 $itemOptions[]=['text' =>$item->item->name, 'value' => $item->item->id,'tax_percentage'=>$item->item->gst_figure->tax_percentage];
        }
        /* $Voucher_no = $this->Grns->find()->select(['voucher_no'])->where(['financial_year_id'=>$financial_year_id,'city_id'=>$city_id])->order(['voucher_no' => 'DESC'])->first();
        if($Voucher_no)
        {
            $voucher_no=$Voucher_no->voucher_no+1;
        }
        else
        { 
            $voucher_no=1;
        }  */
        
         $partyParentGroups = $this->Grns->GrnRows->Ledgers->AccountingGroups->find('all')
                        ->where(['AccountingGroups.city_id'=>$city_id, 'AccountingGroups.vendor'=>'1']);
        $partyGroups=[];
         
        foreach($partyParentGroups as $partyParentGroup)
        {
            $accountingGroups = $this->Grns->GrnRows->Ledgers->AccountingGroups
            ->find('children', ['for' => $partyParentGroup->id])->toArray();
            $partyGroups[]=$partyParentGroup->id;
            foreach($accountingGroups as $accountingGroup){
                $partyGroups[]=$accountingGroup->id;
            }
        }	
        if($partyGroups)
        {  
            $Partyledgers = $this->Grns->VendorLedgers->find()
                            ->where(['VendorLedgers.accounting_group_id IN' =>$partyGroups,'VendorLedgers.city_id'=>$city_id])
                            ->contain(['Vendors']);
        }
       
        $partyOptions=[];
        foreach($Partyledgers as $Partyledger){
            $partyOptions[]=['text' =>$Partyledger->name, 'value' => $Partyledger->id];
        }
        
       $units = $this->Grns->Units->find()->where(['status'=>'Active','city_id'=>$city_id])->contain(['UnitVariations']);
       
        $unitVariationOptions=[];
        foreach($units as $unit)
        {
            foreach ($unit->unit_variations as $unit_variation) {
                
                $unitVariationOptions[]=['text' =>$unit_variation->visible_variation.'('.$unit->shortname.')', 'value' => $unit_variation->id];
            }
        }
        $this->set(compact('grn','companies','voucher_no','itemOptions','partyOptions','unitVariationOptions'));
        $this->set(compact('grn', 'locations', 'orders', 'sellerLedgers', 'purchaseLedgers'));
    }
	
	 public function deleteGrnRow($grn_row_id = null){
		$this->Grns->ItemLedgers->deleteAll(['grn_row_id'=>$grn_row_id]);
		 $this->Grns->GrnRows->deleteAll(['id'=>$grn_row_id]); 
		echo "done";
		exit;
	 }

    /**
     * Delete method
     *
     * @param string|null $id Grn id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $grn = $this->Grns->get($id);
		$this->Grns->ItemLedgers->deleteAll(['grn_id' => $id, 'ItemLedgers.status' => 'In']);
		$this->Grns->GrnRows->deleteAll(['grn_id' => $id]);
		//pr($grn); exit;
        if ($this->Grns->delete($grn)) {
            $this->Flash->success(__('The grn has been deleted.'));
        } else {
            $this->Flash->error(__('The grn could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
