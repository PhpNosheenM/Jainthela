<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * PurchaseInvoices Controller
 *
 * @property \App\Model\Table\PurchaseInvoicesTable $PurchaseInvoices
 *
 * @method \App\Model\Entity\PurchaseInvoice[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PurchaseInvoicesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id'); 
		$location_id=$this->Auth->User('location_id'); 
		$this->viewBuilder()->layout('admin_portal');
        $this->paginate = [
            'contain' => ['Locations', 'Cities','SellerLedgers'=>['Sellers']],
			'limit' => 20
        ];
        $purchaseInvoices = $this->paginate($this->PurchaseInvoices);
		
		$paginate_limit=$this->paginate['limit'];
        $this->set(compact('purchaseInvoices','paginate_limit'));
    }

    /**
     * View method
     *
     * @param string|null $id Purchase Invoice id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $purchaseInvoice = $this->PurchaseInvoices->get($id, [
            'contain' => ['Locations', 'SellerLedgers', 'PurchaseLedgers', 'Cities', 'AccountingEntries', 'ItemLedgers', 'PurchaseInvoiceRows', 'PurchaseReturns', 'ReferenceDetails']
        ]);

        $this->set('purchaseInvoice', $purchaseInvoice);
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
		$location_id=$this->Auth->User('location_id'); 
		$state_id=$this->Auth->User('state_id'); 
		$this->viewBuilder()->layout('admin_portal');
		
        $purchaseInvoice = $this->PurchaseInvoices->newEntity();
		$LocationData = $this->PurchaseInvoices->Locations->get($location_id);
		$Voucher_no = $this->PurchaseInvoices->find()->select(['voucher_no'])->where(['PurchaseInvoices.location_id'=>$location_id])->order(['voucher_no' => 'DESC'])->first();
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
        if ($this->request->is('post')) {
            $purchaseInvoice = $this->PurchaseInvoices->patchEntity($purchaseInvoice, $this->request->getData());
            $purchaseInvoice->voucher_no=$voucher_no;
            $purchaseInvoice->location_id=$location_id;
            $purchaseInvoice->city_id=$city_id;
            $purchaseInvoice->created_by=$user_id;
            $purchaseInvoice->created_on=date('Y-m-d');
            $purchaseInvoice->entry_from="Web";
			$purchaseInvoiceVoucherNo=$year.''.$month.''.$day.'/'.$voucher_no;
			$purchaseInvoice->invoice_no=$LocationData->alise.'/'.$purchaseInvoiceVoucherNo;
			
			$seller_ledger = $this->PurchaseInvoices->SellerLedgers->get($purchaseInvoice->seller_ledger_id);
			$sellerData = $this->PurchaseInvoices->Sellers->get($seller_ledger->seller_id, [
				'contain' => (['Locations'=>['Cities']])
			]);
			//pr($sellerData->location->city->state_id); exit;
			if ($this->PurchaseInvoices->save($purchaseInvoice)) {
				
			//Accounting Entries for Purchase account//
			$AccountingEntrie = $this->PurchaseInvoices->AccountingEntries->newEntity(); 
			$AccountingEntrie->ledger_id=$purchaseInvoice->purchase_ledger_id;
			$AccountingEntrie->debit=$purchaseInvoice->total_taxable_value;
			$AccountingEntrie->credit=0;
			$AccountingEntrie->transaction_date=$purchaseInvoice->transaction_date;
			$AccountingEntrie->location_id=$location_id;
			$AccountingEntrie->city_id=$city_id;
			$AccountingEntrie->entry_from="Web";
			$AccountingEntrie->purchase_invoice_id=$purchaseInvoice->id; 
			$this->PurchaseInvoices->AccountingEntries->save($AccountingEntrie);
	
			//Accounting Entries for Supplier account//
			$AccountingEntrie = $this->PurchaseInvoices->AccountingEntries->newEntity(); 
			$AccountingEntrie->ledger_id=$purchaseInvoice->seller_ledger_id;
			$AccountingEntrie->credit=$purchaseInvoice->total_amount;
			$AccountingEntrie->debit=0;
			$AccountingEntrie->transaction_date=$purchaseInvoice->transaction_date;
			$AccountingEntrie->location_id=$location_id;
			$AccountingEntrie->city_id=$city_id;
			$AccountingEntrie->entry_from="Web";
			$AccountingEntrie->purchase_invoice_id=$purchaseInvoice->id;
			$this->PurchaseInvoices->AccountingEntries->save($AccountingEntrie);
		
			
			if($sellerData->location->city->state_id==$state_id){
				foreach($purchaseInvoice->purchase_invoice_rows as $purchase_invoice_row){ 
					$gstAmtdata=$purchase_invoice_row->gst_value/2;
					$gstAmtInsert=round($gstAmtdata,2);
					
					//Accounting Entries for CGST//
					$gstLedgerCGST = $this->PurchaseInvoices->PurchaseInvoiceRows->Ledgers->find()
					->where(['Ledgers.gst_figure_id' =>$purchase_invoice_row->gst_percentage, 'Ledgers.input_output'=>'input', 'Ledgers.gst_type'=>'CGST'])->first();
					$AccountingEntrieCGST = $this->PurchaseInvoices->AccountingEntries->newEntity();
					$AccountingEntrieCGST->ledger_id=$gstLedgerCGST->id;
					$AccountingEntrieCGST->debit=$gstAmtInsert;
					$AccountingEntrieCGST->credit=0;
					$AccountingEntrieCGST->transaction_date=$purchaseInvoice->transaction_date;
					$AccountingEntrieCGST->location_id=$location_id;
					$AccountingEntrieCGST->city_id=$city_id;
					$AccountingEntrieCGST->entry_from="Web";
					$AccountingEntrieCGST->purchase_invoice_id=$purchaseInvoice->id;
					$this->PurchaseInvoices->AccountingEntries->save($AccountingEntrieCGST);
					
					//Accounting Entries for SGST//
					 $gstLedgerSGST = $this->PurchaseInvoices->PurchaseInvoiceRows->Ledgers->find()
					->where(['Ledgers.gst_figure_id' =>$purchase_invoice_row->gst_percentage, 'Ledgers.input_output'=>'input', 'Ledgers.gst_type'=>'SGST'])->first();
					$AccountingEntrieSGST = $this->PurchaseInvoices->AccountingEntries->newEntity();
					$AccountingEntrieSGST->ledger_id=$gstLedgerSGST->id;
					$AccountingEntrieSGST->debit=$gstAmtInsert;
					$AccountingEntrieSGST->credit=0;
					$AccountingEntrieSGST->transaction_date=$purchaseInvoice->transaction_date;
					$AccountingEntrieSGST->location_id=$location_id;
					$AccountingEntrieSGST->city_id=$city_id;
					$AccountingEntrieSGST->entry_from="Web";
					$AccountingEntrieSGST->purchase_invoice_id=$purchaseInvoice->id; 
					$this->PurchaseInvoices->AccountingEntries->save($AccountingEntrieSGST);
					
				   }
			}else{
				foreach($purchaseInvoice->purchase_invoice_rows as $purchase_invoice_row){ 
					$gstAmtdata=round($purchase_invoice_row->gst_value/2,2);
					$gstAmtInsert=round($gstAmtdata*2,2); 
					
					//Accounting Entries for IGST//
					 $gstLedgerIGST = $this->PurchaseInvoices->PurchaseInvoiceRows->Ledgers->find()
					->where(['Ledgers.gst_figure_id' =>$purchase_invoice_row->gst_percentage, 'Ledgers.input_output'=>'input', 'Ledgers.gst_type'=>'IGST'])->first();
					$AccountingEntrieIGST = $this->PurchaseInvoices->AccountingEntries->newEntity();
					$AccountingEntrieIGST->ledger_id=$gstLedgerIGST->id;
					$AccountingEntrieIGST->debit=$gstAmtInsert;
					$AccountingEntrieIGST->credit=0;
					$AccountingEntrieIGST->transaction_date=$purchaseInvoice->transaction_date;
					$AccountingEntrieIGST->location_id=$location_id;
					$AccountingEntrieIGST->city_id=$city_id;
					$AccountingEntrieIGST->entry_from="Web";
					$AccountingEntrieIGST->purchase_invoice_id=$purchaseInvoice->id; 
					$this->PurchaseInvoices->AccountingEntries->save($AccountingEntrieIGST);
					
				}
			}
			
			//Accounting Entries for Reference Details//
			$ReferenceDetail = $this->PurchaseInvoices->ReferenceDetails->newEntity(); 
			$ReferenceDetail->ledger_id=$purchaseInvoice->seller_ledger_id;
			$ReferenceDetail->credit=$purchaseInvoice->total_amount;
			$ReferenceDetail->debit=0;
			$ReferenceDetail->transaction_date=$purchaseInvoice->transaction_date;
			$ReferenceDetail->location_id=$location_id;
			$ReferenceDetail->city_id=$city_id;
			$ReferenceDetail->entry_from="Web";
			$ReferenceDetail->type='New Ref';
			$ReferenceDetail->ref_name=$LocationData->alise.'/'.$purchaseInvoiceVoucherNo;
			$ReferenceDetail->purchase_invoice_id=$purchaseInvoice->id;
			$this->PurchaseInvoices->ReferenceDetails->save($ReferenceDetail);
			
			foreach($purchaseInvoice->purchase_invoice_rows as $purchase_invoice_row){ 
				
				$ItemLedger = $this->PurchaseInvoices->ItemLedgers->newEntity(); 
				$ItemLedger->item_id=$purchase_invoice_row->item_id;
				$ItemLedger->item_variation_id=$purchase_invoice_row->item_variation_id;
				$ItemLedger->transaction_date=$purchaseInvoice->transaction_date;
				$ItemLedger->quantity=$purchase_invoice_row->quantity;
				$ItemLedger->rate=$purchase_invoice_row->rate;
				$ItemLedger->purchase_rate=$purchase_invoice_row->purchase_rate;
				$ItemLedger->sales_rate=$purchase_invoice_row->sales_rate;
				$ItemLedger->mrp=$purchase_invoice_row->mrp;
				$ItemLedger->status="In";
				$ItemLedger->location_id=$location_id;
				$ItemLedger->city_id=$city_id;
				$ItemLedger->purchase_invoice_id=$purchaseInvoice->id;
				$ItemLedger->purchase_invoice_row_id=$purchase_invoice_row->id;
				$ItemLedger->entry_from="Web";
				$this->PurchaseInvoices->ItemLedgers->save($ItemLedger);
			}
			
			foreach($purchaseInvoice->purchase_invoice_rows as $purchase_invoice_row){ 
				if($purchase_invoice_row->item_variation_id==0){
					$query = $this->PurchaseInvoices->Items->ItemVariations->query();
					$query->update()
					->set(['purchase_rate'=>$purchase_invoice_row->purchase_rate,'sales_rate'=>$purchase_invoice_row->sales_rate,'mrp'=>$purchase_invoice_row->mrp])
					->where(['item_id' => $purchase_invoice_row->item_id,'seller_id'=>$seller_ledger->seller_id])
					->execute();
					
				}else{
					
					$query = $this->PurchaseInvoices->Items->ItemVariations->query();
					$query->update()
					->set(['purchase_rate'=>$purchase_invoice_row->purchase_rate,'sales_rate'=>$purchase_invoice_row->sales_rate,'mrp'=>$purchase_invoice_row->mrp,'print_rate'=>$purchase_invoice_row->mrp,'update_on'=>$today_date])
					->where(['item_id' => $purchase_invoice_row->item_id,'seller_id'=>$seller_ledger->seller_id])
					->execute();
				}
			}
				
				
                $this->Flash->success(__('The purchase invoice has been saved.'));

                return $this->redirect(['action' => 'index']);
            }else{
				pr($purchaseInvoice); exit;
			}
            $this->Flash->error(__('The purchase invoice could not be saved. Please, try again.'));
        }
       
	   $partyParentGroups = $this->PurchaseInvoices->AccountingGroups->find()
						->where(['AccountingGroups.
						purchase_invoice_party'=>'1']);

		$partyGroups=[];
		foreach($partyParentGroups as $partyParentGroup)
		{
			$accountingGroups = $this->PurchaseInvoices->AccountingGroups
			->find('children', ['for' => $partyParentGroup->id])->toArray();
			$partyGroups[]=$partyParentGroup->id;
			foreach($accountingGroups as $accountingGroup){
				$partyGroups[]=$accountingGroup->id;
			}
		}
		if($partyGroups)
		{  
			$Partyledgers = $this->PurchaseInvoices->SellerLedgers->find()
							->where(['SellerLedgers.accounting_group_id IN' =>$partyGroups])
							->contain(['Sellers'=>['Locations'=>['Cities']]]);
        }
		$partyOptions=[];
		foreach($Partyledgers as $Partyledger){ 
			$partyOptions[]=['text' =>$Partyledger->name, 'value' => $Partyledger->id,'city_id'=>$Partyledger->seller->city_id,'state_id'=>$Partyledger->seller->location->city->state_id,'bill_to_bill_accounting'=>$Partyledger->bill_to_bill_accounting,'seller_id'=>$Partyledger->seller_id];
		}
		
		$accountLedgers = $this->PurchaseInvoices->AccountingGroups->find()->where(['AccountingGroups.purchase_invoice_purchase_account'=>1])->first();

		$accountingGroups2 = $this->PurchaseInvoices->AccountingGroups
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
			$Accountledgers = $this->PurchaseInvoices->AccountingGroups->Ledgers->find('list')->where(['Ledgers.accounting_group_id IN' =>$account_ids]);
        }
		$GstFigures1 = $this->PurchaseInvoices->GstFigures->find();
		$GstFigures=array();
				foreach($GstFigures1 as $data){
					$GstFigures[]=['text' => $data->name,'value' => $data->id,'tax_percentage' => $data->tax_percentage];
				}
        $this->set(compact('purchaseInvoice', 'locations', 'partyOptions', 'Accountledgers', 'items','GstFigures','voucher_no','LocationData'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Purchase Invoice id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function SelectItemSellerWise($id = null)
    {
		$Sellertem=$this->PurchaseInvoices->Items->ItemVariations->find()->contain(['Items'=>['ItemVariations'=>['UnitVariations'=>['Units']]]])->where(['ItemVariations.seller_id'=>$id,'ItemVariations.status'=>'Active']);
		
		$items=array();
		foreach($Sellertem as $data){
		if($data->item->item_maintain_by=="itemwise"){
			$merge=$data->item->name;
			$p=@$data->item->item_variations[0]->unit_variation->quantity_variation/@$data->item->item_variations[0]->unit_variation->convert_unit_qty;
			@$quantity_factor=(@$p/@$data->item->item_variations[0]->unit_variation->unit->division_factor); 
			//pr(@$quantity_factor); exit;
			$items[]=['text' => $merge,'value' =>0,'item_id'=>$data->item->id,'quantity_factor'=>@$quantity_factor,'unit'=>@$data->item->item_variations[0]->unit_variation->unit->print_unit,'gst_figure_id'=>$data->item->gst_figure_id,'commission'=>@$data->item->item_variations[0]->commission];
		}else{
			$merge=$data->item->name.'('.@$data->item->item_variations[0]->unit_variation->convert_unit_qty.'.'.@$data->item->item_variations[0]->unit_variation->unit->print_unit.')';
			$items[]=['text' => $merge,'value' => $data->id,'item_id'=>$data->item->id,'quantity_factor'=>@$data->item->item_variations[0]->unit_variation->convert_unit_qty,'unit'=>@$data->item->item_variations[0]->unit_variation->unit->print_unit,'gst_figure_id'=>$data->item->gst_figure_id,'commission'=>@$data->item->item_variations[0]->commission];
			}
		} 
		$itemSize=sizeof($items); 
		//pr($items);exit;
		 $this->set(compact('items','itemSize'));
		//pr($items);exit;
	} 
	
	public function edit($id = null)
    {
        $purchaseInvoice = $this->PurchaseInvoices->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $purchaseInvoice = $this->PurchaseInvoices->patchEntity($purchaseInvoice, $this->request->getData());
            if ($this->PurchaseInvoices->save($purchaseInvoice)) {
                $this->Flash->success(__('The purchase invoice has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The purchase invoice could not be saved. Please, try again.'));
        }
        $locations = $this->PurchaseInvoices->Locations->find('list', ['limit' => 200]);
        $sellerLedgers = $this->PurchaseInvoices->SellerLedgers->find('list', ['limit' => 200]);
        $purchaseLedgers = $this->PurchaseInvoices->PurchaseLedgers->find('list', ['limit' => 200]);
        $cities = $this->PurchaseInvoices->Cities->find('list', ['limit' => 200]);
        $this->set(compact('purchaseInvoice', 'locations', 'sellerLedgers', 'purchaseLedgers', 'cities'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Purchase Invoice id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $purchaseInvoice = $this->PurchaseInvoices->get($id);
        if ($this->PurchaseInvoices->delete($purchaseInvoice)) {
            $this->Flash->success(__('The purchase invoice has been deleted.'));
        } else {
            $this->Flash->error(__('The purchase invoice could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
