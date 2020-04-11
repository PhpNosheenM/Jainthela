<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\View\View;
/**
 * PurchaseReturns Controller
 *
 * @property \App\Model\Table\PurchaseReturnsTable $PurchaseReturns
 *
 * @method \App\Model\Entity\PurchaseReturn[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PurchaseReturnsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
	public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Security->setConfig('unlockedActions', ['add','index','directAdd']);

    }
	
    public function index()
    {
		$city_id=$this->Auth->User('city_id');
		$financial_year_id =$this->Auth->User('financial_year_id');
		$this->viewBuilder()->layout('super_admin_layout');
        $this->paginate = [
            'contain' => ['FinancialYears',  'SellerLedgers', 'PurchaseLedgers', 'Cities'],
			'limit' => 20
        ];
		
		
        $purchaseReturns = $this->paginate($this->PurchaseReturns); //pr($purchaseReturns); exit;
		$paginate_limit=$this->paginate['limit'];
        $this->set(compact('purchaseReturns','paginate_limit'));
    }

    /**
     * View method
     *
     * @param string|null $id Purchase Return id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id');
		$location_id=$this->Auth->User('location_id');
		$this->viewBuilder()->layout('super_admin_layout');
        $purchaseReturn = $this->PurchaseReturns->get($id, [
            'contain' => ['PurchaseInvoices', 'FinancialYears', 'SellerLedgers', 'PurchaseLedgers', 'Cities', 'PurchaseReturnRows'=>['UnitVariations','GstFigures','Items'], 'ReferenceDetails']
        ]);
		$this->loadmodel('Companies');
		$company_details=$this->Companies->find()->where(['Companies.city_id'=>$city_id])->first();
		$this->set(compact('purchaseReturn','company_details'));
        $this->set('purchaseReturn', $purchaseReturn);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
	 public function directAdd($invoice_id=null)
    { 
		$status=$this->request->query('status');
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id');
		$financial_year_id =$this->Auth->User('financial_year_id');
		$this->viewBuilder()->layout('super_admin_layout');
		//pr($financial_year_id); exit;
		
		//pr($purchase_invoices->purchase_invoice_rows[0]->grn_row)
		//$seller_type=$purchase_invoices->purchase_invoice_rows[0]->grn_row->grn->created_for;
		$CityData = $this->PurchaseReturns->PurchaseInvoices->Cities->get($city_id);
		$StateData = $this->PurchaseReturns->PurchaseInvoices->Cities->States->get($CityData->state_id);
		$Voucher_no = $this->PurchaseReturns->find()->select(['voucher_no'])->where(['PurchaseReturns.city_id'=>$city_id,'PurchaseReturns.financial_year_id'=>$financial_year_id])->order(['voucher_no' => 'DESC'])->first();
		if($Voucher_no){$voucher_no=$Voucher_no->voucher_no+1;}
		else{$voucher_no=1;}
		$order_no=$CityData->alise_name.'/PR/'.$voucher_no;
		$voucher_no=$StateData->alias_name.'/'.$order_no;
		// pr($purchase_invoices); exit;
        $purchaseReturn = $this->PurchaseReturns->newEntity();
        if ($this->request->is('post')) {
            $purchaseReturn = $this->PurchaseReturns->patchEntity($purchaseReturn, $this->request->getData());
			
			$Voucher_no = $this->PurchaseReturns->find()->select(['voucher_no'])->where(['PurchaseReturns.city_id'=>$city_id,'PurchaseReturns.financial_year_id'=>$financial_year_id])->order(['voucher_no' => 'DESC'])->first();
			if($Voucher_no){
				$voucher_no=$Voucher_no->voucher_no+1;
				$purchaseReturn->voucher_no=$voucher_no;
			}else{
				$voucher_no=1;
				$purchaseReturn->voucher_no=$voucher_no;
			}
			$order_no=$CityData->alise_name.'/PR/'.$voucher_no;
			$voucher_no=$StateData->alias_name.'/'.$order_no; 
			$purchaseReturn->invoice_no=$voucher_no;
			
			$purchaseReturn->transaction_date = date('Y-m-d',strtotime($purchaseReturn->transaction_date));
			$purchaseReturn->city_id = $city_id;
			$purchaseReturn->financial_year_id = $financial_year_id;
			$purchaseReturn->direct ="Yes";
			//pr($purchaseReturn); exit;
			//$GrnRowData = $this->PurchaseReturns->PurchaseInvoices->PurchaseInvoiceRows->get($purchaseReturn->purchase_return_rows[0]->purchase_invoice_row_id,['contain'=>['GrnRows']]);
			
			
			 
			if ($this->PurchaseReturns->save($purchaseReturn)) {  
			
				//Accounting Entries for Purchase account//
				$AccountingEntrie = $this->PurchaseReturns->AccountingEntries->newEntity(); 
				$AccountingEntrie->ledger_id=$purchaseReturn->purchase_ledger_id;
				$AccountingEntrie->credit=$purchaseReturn->total_taxable_value;
				$AccountingEntrie->debit=0;
				$AccountingEntrie->transaction_date=$purchaseReturn->transaction_date;
				$AccountingEntrie->city_id=$city_id;
				$AccountingEntrie->entry_from="Web";
				$AccountingEntrie->purchase_return_id=$purchaseReturn->id; 
				$this->PurchaseReturns->AccountingEntries->save($AccountingEntrie);  
				
				//Accounting Entries for Seller & Vendor account//
				$AccountingEntrie = $this->PurchaseReturns->AccountingEntries->newEntity(); 
				$AccountingEntrie->ledger_id=$purchaseReturn->seller_ledger_id; 
				$AccountingEntrie->debit=$purchaseReturn->total_amount;
				$AccountingEntrie->credit=0;
				$AccountingEntrie->transaction_date=$purchaseReturn->transaction_date;
				$AccountingEntrie->city_id=$city_id;
				$AccountingEntrie->entry_from="Web";
				$AccountingEntrie->purchase_return_id=$purchaseReturn->id;
				$this->PurchaseReturns->AccountingEntries->save($AccountingEntrie);
				
				foreach($purchaseReturn->purchase_return_rows as $purchase_return_row){ 
					$gstAmtdata=$purchase_return_row->gst_value/2;
					$gstAmtInsert=round($gstAmtdata,2);
					
					if($gstAmtInsert > 0){
						//Accounting Entries for CGST//
						$gstLedgerCGST = $this->PurchaseReturns->Ledgers->find()
						->where(['Ledgers.gst_figure_id' =>$purchase_return_row->gst_figure_id, 'Ledgers.input_output'=>'output', 'Ledgers.gst_type'=>'CGST','city_id'=>$city_id])->first();
						$AccountingEntrieCGST = $this->PurchaseReturns->AccountingEntries->newEntity();
						$AccountingEntrieCGST->ledger_id=$gstLedgerCGST->id;
						$AccountingEntrieCGST->credit=$gstAmtInsert;
						$AccountingEntrieCGST->debit=0;
						$AccountingEntrieCGST->transaction_date=$purchaseReturn->transaction_date;
						$AccountingEntrieCGST->city_id=$city_id;
						$AccountingEntrieCGST->entry_from="Web";
						$AccountingEntrieCGST->purchase_return_id=$purchaseReturn->id;  
						$this->PurchaseReturns->AccountingEntries->save($AccountingEntrieCGST);
						
						
						//Accounting Entries for SGST//
						 $gstLedgerSGST = $this->PurchaseReturns->Ledgers->find()
						->where(['Ledgers.gst_figure_id' =>$purchase_return_row->gst_figure_id, 'Ledgers.input_output'=>'output', 'Ledgers.gst_type'=>'SGST','city_id'=>$city_id])->first();
						$AccountingEntrieSGST = $this->PurchaseReturns->AccountingEntries->newEntity();
						$AccountingEntrieSGST->ledger_id=$gstLedgerSGST->id;
						$AccountingEntrieSGST->credit=$gstAmtInsert;
						$AccountingEntrieSGST->debit=0;
						$AccountingEntrieSGST->transaction_date=$purchaseReturn->transaction_date;
						$AccountingEntrieSGST->city_id=$city_id;
						$AccountingEntrieSGST->entry_from="Web";
						$AccountingEntrieSGST->purchase_return_id=$purchaseReturn->id;  
						$this->PurchaseReturns->AccountingEntries->save($AccountingEntrieSGST);
					}
						$ItemLedger = $this->PurchaseReturns->PurchaseReturnRows->Items->ItemLedgers->newEntity(); 
						$ItemLedger->item_id=$purchase_return_row->item_id; 
						$ItemLedger->unit_variation_id=$purchase_return_row->unit_variation_id;
						$ItemLedger->item_variation_id=$purchase_return_row->item_variation_id;
						$ItemLedger->seller_id=NULL;
						$ItemLedger->transaction_date=$purchaseReturn->transaction_date;  
						$ItemLedger->quantity=$purchase_return_row->quantity;
						$ItemLedger->rate=$purchase_return_row->rate;
						$ItemLedger->purchase_rate=$purchase_return_row->rate;
						//$ItemLedger->sales_rate=$purchase_return_row->rate; 
						$ItemLedger->status="Out";
						$ItemLedger->city_id=$city_id;
						$ItemLedger->location_id=1;
						$ItemLedger->purchase_return_id=$purchaseReturn->id;
						$ItemLedger->purchase_return_row_id=$purchase_return_row->id; //pr($order_detail); exit;
						$this->PurchaseReturns->PurchaseReturnRows->Items->ItemLedgers->save($ItemLedger);
						
						// Item Variation Entry
						$ItemVariationData = $this->PurchaseReturns->PurchaseReturnRows->Items->ItemVariations->get($purchase_return_row->item_variation_id);
						$current_stock=$ItemVariationData->current_stock-$purchase_return_row->quantity;
						$cs=$ItemVariationData->current_stock;
						$vs=$ItemVariationData->virtual_stock;
						$ds=$ItemVariationData->demand_stock;
						$actual_quantity=$purchase_return_row->quantity;

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
						$query = $this->PurchaseReturns->PurchaseReturnRows->Items->ItemVariations->query();
						$query->update()
						->set(['current_stock'=>$final_cs,'demand_stock'=>$final_ds,'out_of_stock'=>$out_of_stock,'ready_to_sale'=>$ready_to_sale])
						->where(['id'=>$purchase_return_row->item_variation_id])
						->execute();
						}
						
					$this->Flash->success(__('The purchase return has been saved.'));
					return $this->redirect(['action' => 'index']);
            } pr($purchaseReturn); exit;
            $this->Flash->error(__('The purchase return could not be saved. Please, try again.'));
        }
      
		 $partyParentGroups = $this->PurchaseReturns->PurchaseInvoices->SellerLedgers->AccountingGroups->find('all')
                        ->where(['AccountingGroups.city_id'=>$city_id, 'AccountingGroups.vendor'=>'1'])
						->orWhere(['AccountingGroups.city_id'=>$city_id, 'AccountingGroups.seller'=>'1']);
		$partyGroups=[];
		foreach($partyParentGroups as $partyParentGroup)
		{
		$accountingGroups = $this->PurchaseReturns->PurchaseInvoices->SellerLedgers->AccountingGroups
		->find('children', ['for' => $partyParentGroup->id])->toArray();
		$partyGroups[]=$partyParentGroup->id;
		foreach($accountingGroups as $accountingGroup){
		$partyGroups[]=$accountingGroup->id;
		}
		}	//
		//pr($partyGroups); exit;
        if($partyGroups)
        {  
            $Partyledgers = $this->PurchaseReturns->SellerLedgers->find()
                            ->where(['SellerLedgers.accounting_group_id IN' =>$partyGroups,'SellerLedgers.city_id'=>$city_id]);
        }
     
        $partyOptions=[];
        foreach($Partyledgers as $Partyledger){
            $partyOptions[]=['text' =>$Partyledger->name, 'value' => $Partyledger->id];
        }
		//pr($partyOptions); exit;
		$accountLedgers = $this->PurchaseReturns->PurchaseInvoices->AccountingGroups->find()->where(['AccountingGroups.purchase_invoice_purchase_account'=>1,'AccountingGroups.city_id'=>$city_id])->first();
		
		$accountingGroups2 = $this->PurchaseReturns->PurchaseInvoices->AccountingGroups
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
			$Accountledgers = $this->PurchaseReturns->PurchaseInvoices->AccountingGroups->Ledgers->find('list')->where(['Ledgers.accounting_group_id IN' =>$account_ids]);
        } 
		
		
		
		
		$itemList=$this->PurchaseReturns->PurchaseReturnRows->Items->find()->contain(['ItemVariations'=> function ($q) use($city_id){
								return $q 
								->where(['ItemVariations.seller_id IS NULL','current_stock > '=>0])->contain(['UnitVariations'=>['Units']]);
								}]);
		//pr($itemList->toArray()); exit;
		$items=array();
		foreach($itemList as $data1){ 
			foreach($data1->item_variations as $data){
				$discount_applicable=$data1->is_discount_enable;
				$category_id=$data1->category_id;
				$gstData=$this->PurchaseReturns->PurchaseReturnRows->Items->GstFigures->get($data1->gst_figure_id);
				$merge=$data1->name.'('.@$data->unit_variation->visible_variation.')';
				$items[]=['text' => $merge,'value' => $data->id,'item_id'=>$data1->id,'gst_value'=>$gstData->tax_percentage,'gst_figure_id'=>$gstData->id,'sale_rate'=>$data->sales_rate,'current_stock'=>$data->current_stock,'virtual_stock'=>$data->virtual_stock,'demand_stock'=>$data->demand_stock,'unit_variation_id'=>@$data->unit_variation->id];
			}
		} 
		//pr($items); exit;
        $this->set(compact('purchaseReturn', 'purchaseInvoices', 'financialYears', 'locations', 'sellerLedgers', 'purchaseLedgers', 'cities', 'purchase_invoices','partyOptions','Accountledgers','voucher_no','ReferenceDetails','items'));
    }


    public function add($invoice_id=null)
    { 
		$status=$this->request->query('status');
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id');
		$financial_year_id =$this->Auth->User('financial_year_id');
		$this->viewBuilder()->layout('super_admin_layout');
		//pr($financial_year_id); exit;
		$purchase_invoices=$this->PurchaseReturns->PurchaseInvoices->find()->where(['PurchaseInvoices.id'=>$invoice_id])->contain(['PurchaseInvoiceRows'=>['GrnRows'=>['Grns'],'Items'=>['GstFigures'],'ItemVariationsData'=>['Items'=>['GstFigures'],'UnitVariations'=>['Units']],'UnitVariations'=>['Units']]])->first();
		
		$ReferenceDetails=$this->PurchaseReturns->ReferenceDetails->find()->where(['purchase_invoice_id'=>$invoice_id])->first();
		//pr($ReferenceDetails); exit;
		//pr($purchase_invoices->purchase_invoice_rows[0]->grn_row)
		$seller_type=$purchase_invoices->purchase_invoice_rows[0]->grn_row->grn->created_for;
		$CityData = $this->PurchaseReturns->PurchaseInvoices->Cities->get($city_id);
		$StateData = $this->PurchaseReturns->PurchaseInvoices->Cities->States->get($CityData->state_id);
		$Voucher_no = $this->PurchaseReturns->find()->select(['voucher_no'])->where(['PurchaseReturns.city_id'=>$city_id,'PurchaseReturns.financial_year_id'=>$financial_year_id])->order(['voucher_no' => 'DESC'])->first();
		if($Voucher_no){$voucher_no=$Voucher_no->voucher_no+1;}
		else{$voucher_no=1;}
		$order_no=$CityData->alise_name.'/PR/'.$voucher_no;
		$voucher_no=$StateData->alias_name.'/'.$order_no;
		// pr($purchase_invoices); exit;
        $purchaseReturn = $this->PurchaseReturns->newEntity();
        if ($this->request->is('post')) {
            $purchaseReturn = $this->PurchaseReturns->patchEntity($purchaseReturn, $this->request->getData());
			
			$Voucher_no = $this->PurchaseReturns->find()->select(['voucher_no'])->where(['PurchaseReturns.city_id'=>$city_id,'PurchaseReturns.financial_year_id'=>$financial_year_id])->order(['voucher_no' => 'DESC'])->first();
			if($Voucher_no){
				$voucher_no=$Voucher_no->voucher_no+1;
				$purchaseReturn->voucher_no=$voucher_no;
			}else{
				$voucher_no=1;
				$purchaseReturn->voucher_no=$voucher_no;
			}
			$order_no=$CityData->alise_name.'/PR/'.$voucher_no;
			$voucher_no=$StateData->alias_name.'/'.$order_no; 
			$purchaseReturn->invoice_no=$voucher_no;
			
			$purchaseReturn->transaction_date = date('Y-m-d',strtotime($purchaseReturn->transaction_date));
			$purchaseReturn->city_id = $city_id;
			$purchaseReturn->financial_year_id = $financial_year_id;
			$purchaseReturn->purchase_invoice_id = $invoice_id;
			//pr($purchaseReturn->purchase_return_rows[0]->purchase_invoice_row_id); exit;
			$GrnRowData = $this->PurchaseReturns->PurchaseInvoices->PurchaseInvoiceRows->get($purchaseReturn->purchase_return_rows[0]->purchase_invoice_row_id,['contain'=>['GrnRows']]);
			
			
			 
			if ($this->PurchaseReturns->save($purchaseReturn)) {  
			
				//Accounting Entries for Purchase account//
				$AccountingEntrie = $this->PurchaseReturns->AccountingEntries->newEntity(); 
				$AccountingEntrie->ledger_id=$purchaseReturn->purchase_ledger_id;
				$AccountingEntrie->credit=$purchaseReturn->total_taxable_value;
				$AccountingEntrie->debit=0;
				$AccountingEntrie->transaction_date=$purchaseReturn->transaction_date;
				$AccountingEntrie->city_id=$city_id;
				$AccountingEntrie->entry_from="Web";
				$AccountingEntrie->purchase_return_id=$purchaseReturn->id; 
				$this->PurchaseReturns->AccountingEntries->save($AccountingEntrie);  
				
				//Accounting Entries for Seller & Vendor account//
				$AccountingEntrie = $this->PurchaseReturns->AccountingEntries->newEntity(); 
				$AccountingEntrie->ledger_id=$purchaseReturn->seller_ledger_id; 
				$AccountingEntrie->debit=$purchaseReturn->total_amount;
				$AccountingEntrie->credit=0;
				$AccountingEntrie->transaction_date=$purchaseReturn->transaction_date;
				$AccountingEntrie->city_id=$city_id;
				$AccountingEntrie->entry_from="Web";
				$AccountingEntrie->purchase_return_id=$purchaseReturn->id;
				$this->PurchaseReturns->AccountingEntries->save($AccountingEntrie);
				
				foreach($purchaseReturn->purchase_return_rows as $purchase_return_row){ 
					$gstAmtdata=$purchase_return_row->gst_value/2;
					$gstAmtInsert=round($gstAmtdata,2);
					
					if($gstAmtInsert > 0){
						//Accounting Entries for CGST//
						$gstLedgerCGST = $this->PurchaseReturns->Ledgers->find()
						->where(['Ledgers.gst_figure_id' =>$purchase_return_row->gst_figure_id, 'Ledgers.input_output'=>'output', 'Ledgers.gst_type'=>'CGST','city_id'=>$city_id])->first();
						$AccountingEntrieCGST = $this->PurchaseReturns->AccountingEntries->newEntity();
						$AccountingEntrieCGST->ledger_id=$gstLedgerCGST->id;
						$AccountingEntrieCGST->credit=$gstAmtInsert;
						$AccountingEntrieCGST->debit=0;
						$AccountingEntrieCGST->transaction_date=$purchaseReturn->transaction_date;
						$AccountingEntrieCGST->city_id=$city_id;
						$AccountingEntrieCGST->entry_from="Web";
						$AccountingEntrieCGST->purchase_return_id=$purchaseReturn->id;  
						$this->PurchaseReturns->AccountingEntries->save($AccountingEntrieCGST);
						
						
						//Accounting Entries for SGST//
						 $gstLedgerSGST = $this->PurchaseReturns->Ledgers->find()
						->where(['Ledgers.gst_figure_id' =>$purchase_return_row->gst_figure_id, 'Ledgers.input_output'=>'output', 'Ledgers.gst_type'=>'SGST','city_id'=>$city_id])->first();
						$AccountingEntrieSGST = $this->PurchaseReturns->AccountingEntries->newEntity();
						$AccountingEntrieSGST->ledger_id=$gstLedgerSGST->id;
						$AccountingEntrieSGST->credit=$gstAmtInsert;
						$AccountingEntrieSGST->debit=0;
						$AccountingEntrieSGST->transaction_date=$purchaseReturn->transaction_date;
						$AccountingEntrieSGST->city_id=$city_id;
						$AccountingEntrieSGST->entry_from="Web";
						$AccountingEntrieSGST->purchase_return_id=$purchaseReturn->id;  
						$this->PurchaseReturns->AccountingEntries->save($AccountingEntrieSGST);
					}
						$ItemLedger = $this->PurchaseReturns->PurchaseReturnRows->Items->ItemLedgers->newEntity(); 
						$ItemLedger->item_id=$purchase_return_row->item_id; 
						$ItemLedger->unit_variation_id=$purchase_return_row->unit_variation_id;
						$ItemLedger->seller_id=NULL;
						$ItemLedger->transaction_date=$purchaseReturn->transaction_date;  
						$ItemLedger->quantity=$purchase_return_row->quantity;
						$ItemLedger->rate=$purchase_return_row->rate;
						$ItemLedger->purchase_rate=$purchase_return_row->rate;
						//$ItemLedger->sales_rate=$purchase_return_row->rate; 
						$ItemLedger->status="Out";
						$ItemLedger->city_id=$city_id;
						$ItemLedger->purchase_return_id=$purchaseReturn->id;
						$ItemLedger->purchase_return_row_id=$purchase_return_row->id; //pr($order_detail); exit;
						$this->PurchaseReturns->PurchaseReturnRows->Items->ItemLedgers->save($ItemLedger);
						$this->Flash->success(__('The purchase return has been saved.'));
						
						$GrnRowData = $this->PurchaseReturns->PurchaseInvoices->PurchaseInvoiceRows->get($purchase_return_row->purchase_invoice_row_id,['contain'=>['GrnRows']]);
						$newQty=$purchase_return_row->quantity+$GrnRowData->grn_row->return_quantity;
						$query = $this->PurchaseReturns->PurchaseInvoices->PurchaseInvoiceRows->GrnRows->query();
							$query->update()
							->set(['return_quantity'=>$newQty])
							->where(['id'=>$GrnRowData->grn_row_id])
							->execute();
						
					}
					
					if($purchaseReturn->total_amount > 0){
						$ReferenceDetail = $this->PurchaseReturns->ReferenceDetails->newEntity(); 
						$ReferenceDetail->ledger_id=$purchaseReturn->seller_ledger_id;
						$ReferenceDetail->ref_name=$purchaseReturn->ref_name; 
						$ReferenceDetail->debit=$purchaseReturn->total_amount;
						$ReferenceDetail->credit=0;
						$ReferenceDetail->transaction_date=$purchaseReturn->transaction_date;
						//$ReferenceDetail->location_id=$location_id;
						$ReferenceDetail->city_id=$city_id;
						$ReferenceDetail->entry_from="Web";
						$ReferenceDetail->type='Against';
						//$ReferenceDetail->ref_name=$purchaseReturn->reference_details[0]->ref_name;
						$ReferenceDetail->purchase_return_id=$purchaseReturn->id; //
						$this->PurchaseReturns->ReferenceDetails->save($ReferenceDetail); 
					}
					
                return $this->redirect(['action' => 'index']);
            } pr($purchaseReturn); exit;
            $this->Flash->error(__('The purchase return could not be saved. Please, try again.'));
        }
       
		$Partyledger = $this->PurchaseReturns->PurchaseInvoices->SellerLedgers->get($purchase_invoices->seller_ledger_id,['contain'=>['Cities']]);
			
		$partyOptions[]=['text' =>$Partyledger->name, 'value' => $Partyledger->id,'city_id'=>$Partyledger->city_id,'state_id'=>$Partyledger->city->state_id,'bill_to_bill_accounting'=>$Partyledger->bill_to_bill_accounting,'vendor_id'=>$Partyledger->vendor_id];
		
		$accountLedgers = $this->PurchaseReturns->PurchaseInvoices->AccountingGroups->find()->where(['AccountingGroups.purchase_invoice_purchase_account'=>1,'AccountingGroups.city_id'=>$city_id])->first();
		
		$accountingGroups2 = $this->PurchaseReturns->PurchaseInvoices->AccountingGroups
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
			$Accountledgers = $this->PurchaseReturns->PurchaseInvoices->AccountingGroups->Ledgers->find('list')->where(['Ledgers.accounting_group_id IN' =>$account_ids]);
        } //pr($Accountledgers->toArray()); exit;
        $this->set(compact('purchaseReturn', 'purchaseInvoices', 'financialYears', 'locations', 'sellerLedgers', 'purchaseLedgers', 'cities', 'purchase_invoices','partyOptions','Accountledgers','voucher_no','ReferenceDetails'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Purchase Return id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $purchaseReturn = $this->PurchaseReturns->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $purchaseReturn = $this->PurchaseReturns->patchEntity($purchaseReturn, $this->request->getData());
            if ($this->PurchaseReturns->save($purchaseReturn)) {
                $this->Flash->success(__('The purchase return has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The purchase return could not be saved. Please, try again.'));
        }
        $purchaseInvoices = $this->PurchaseReturns->PurchaseInvoices->find('list', ['limit' => 200]);
        $financialYears = $this->PurchaseReturns->FinancialYears->find('list', ['limit' => 200]);
        $locations = $this->PurchaseReturns->Locations->find('list', ['limit' => 200]);
        $sellerLedgers = $this->PurchaseReturns->SellerLedgers->find('list', ['limit' => 200]);
        $purchaseLedgers = $this->PurchaseReturns->PurchaseLedgers->find('list', ['limit' => 200]);
        $cities = $this->PurchaseReturns->Cities->find('list', ['limit' => 200]);
        $this->set(compact('purchaseReturn', 'purchaseInvoices', 'financialYears', 'locations', 'sellerLedgers', 'purchaseLedgers', 'cities'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Purchase Return id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
	public function getSeller($seller_ledger_id = null){
			$PurchaseReturns=$this->PurchaseReturns->PurchaseInvoices->find()->where(['PurchaseInvoices.seller_ledger_id'=>$seller_ledger_id]);
			
			$items=array();
			foreach($PurchaseReturns as $data){
				$items[]=['text' => $data->invoice_no,'value' => $data->id];
			}
			//pr($items); exit;
			$this->set(compact('items'));
			//pr($items); 
			
	}
	
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        //$purchaseReturn = $this->PurchaseReturns->get($id);
		 $purchaseReturn = $this->PurchaseReturns->get($id,['contain'=>['PurchaseReturnRows'=>['PurchaseInvoiceRows'=>['GrnRows'=>function($q){
			return $q->select(['id','return_quantity'])->group('grn_id');
		}]]]]);
		
		foreach($purchaseReturn->purchase_return_rows as $data){
			//pr($data->purchase_invoice_row->grn_row); exit;
			$query = $this->PurchaseReturns->PurchaseReturnRows->PurchaseInvoiceRows->GrnRows->query();
			$query->update()
			->set(['return_quantity'=>0])
			->where(['id'=>$data->purchase_invoice_row->grn_row->id])
			->execute(); 
			
			//
		}
		$this->PurchaseReturns->PurchaseReturnRows->deleteAll(['purchase_return_id' => $id]);
		$this->PurchaseReturns->AccountingEntries->deleteAll(['purchase_return_id' => $id]);
		$this->PurchaseReturns->PurchaseReturnRows->Items->ItemLedgers->deleteAll(['purchase_return_id' => $id]);
		//pr($purchaseReturn->toArray()); exit;
        if ($this->PurchaseReturns->delete($purchaseReturn)) {
            $this->Flash->success(__('The purchase return has been deleted.'));
        } else {
            $this->Flash->error(__('The purchase return could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
