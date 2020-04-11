<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\View\View;
/**
 * SaleReturns Controller
 *
 * @property \App\Model\Table\SaleReturnsTable $SaleReturns
 *
 * @method \App\Model\Entity\SaleReturn[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SaleReturnsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
	   public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Security->setConfig('unlockedActions', ['add', 'index', 'view']);

    }
    public function index()
    {
		$this->viewBuilder()->layout('super_admin_layout');
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id');
		$location_id=$this->Auth->User('location_id');
        $this->paginate = [
            'contain' => ['Customers', 'Cities', 'Invoices'],
			'limit' => 100 
        ];
		
        $saleReturns = $this->paginate($this->SaleReturns);
		//pr($saleReturns); exit;
		$paginate_limit=$this->paginate['limit'];
        $this->set(compact('saleReturns','paginate_limit'));
    }
	
		
	public function itemLedgerUpdate($id = null){
		$SaleReturns=$this->SaleReturns->find()->contain(['Invoices','SaleReturnRows'=>['ItemVariations']])->toArray();
		
		foreach($SaleReturns as $data){
			foreach($data->sale_return_rows as $sale_return_row){
				
				if(empty($data->invoice->seller_id)){ //pr($data->transaction_date); exit;
					$ItemLedger = $this->SaleReturns->Invoices->InvoiceRows->ItemLedgers->newEntity(); 
					$ItemLedger->item_id=$sale_return_row->item_variation->item_id; 
					$ItemLedger->unit_variation_id=$sale_return_row->item_variation->unit_variation_id;
					$ItemLedger->item_variation_id=$sale_return_row->item_variation_id;
					$ItemLedger->transaction_date=$data->transaction_date;  
					$ItemLedger->quantity=$sale_return_row->return_quantity;
					$ItemLedger->rate=$sale_return_row->net_amount/$sale_return_row->return_quantity;
					$ItemLedger->amount=$sale_return_row->return_quantity*$ItemLedger->rate;
					//$ItemLedger->sale_rate=$sale_return_row->rate;
					$ItemLedger->status="In";
					$ItemLedger->city_id=$data->invoice->city_id;
					$ItemLedger->location_id=$data->invoice->location_id;
					$ItemLedger->sale_return_id=$data->id;  
					$ItemLedger->sale_return_row_id=$sale_return_row->id; //pr($ItemLedger); exit;
					$this->SaleReturns->Invoices->InvoiceRows->ItemLedgers->save($ItemLedger);
				}
			}
		}
		echo "Updation Complete"; exit;
	}

    /**
     * View method
     *
     * @param string|null $id Sale Return id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $saleReturn = $this->SaleReturns->get($id, [
            'contain' => ['Customers', 'SalesLedgers', 'PartyLedgers', 'Cities', 'Orders', 'AccountingEntries', 'ItemLedgers', 'ReferenceDetails', 'SaleReturnRows']
        ]);

        $this->set('saleReturn', $saleReturn);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($id)
    {
		$id = $this->EncryptingDecrypting->decryptData($id);
		$this->viewBuilder()->layout('super_admin_layout');
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id');
		$location_id=$this->Auth->User('location_id');
		$financial_year_id=$this->Auth->User('financial_year_id');
		
		$order = $this->SaleReturns->Invoices->get($id, [
            'contain' => ['SellerLedgers','PartyLedgers','InvoiceRows'=>['ItemVariations'=>['Items'=>['GstFigures']]]]
        ]);
		
        $saleReturn = $this->SaleReturns->newEntity();
         if ($this->request->is(['patch', 'post', 'put'])) {
            $saleReturn = $this->SaleReturns->patchEntity($saleReturn, $this->request->getData());
			
			$saleReturn->transaction_date = date("Y-m-d");
            $Voucher_no = $this->SaleReturns->find()->select(['voucher_no'])->where(['city_id'=>$city_id,'financial_year_id'=>$financial_year_id])->order(['voucher_no' => 'DESC'])->first();
            if($Voucher_no)
            {
                $saleReturn->voucher_no = $Voucher_no->voucher_no+1;
            }
            else
            {
                $saleReturn->voucher_no = 1;
            } 
			$saleReturn->city_id = $city_id;
			$saleReturn->financial_year_id = $financial_year_id;
			$saleReturn->sales_ledger_id = $order->sales_ledger_id;
			$saleReturn->customer_id = $order->customer_id;
			$saleReturn->invoice_id = $id;
			if($order->order_type=="COD"){
				$LedgerData = $this->SaleReturns->Invoices->Ledgers->find()->where(['Ledgers.cash' =>'1','Ledgers.city_id'=>$city_id])->first();
				$saleReturn->party_ledger_id=$LedgerData->id;
			}else{
				$LedgerData = $this->SaleReturns->Invoices->Ledgers->find()->where(['Ledgers.customer_id' =>$order->customer_id,'Ledgers.city_id'=>$city_id])->first();
				$saleReturn->party_ledger_id=$LedgerData->id;
			}

			
			if ($this->SaleReturns->save($saleReturn)) { 
				// Party Ledger entry
				$AccountingEntrie = $this->SaleReturns->Invoices->Ledgers->AccountingEntries->newEntity(); 
				$AccountingEntrie->ledger_id=$saleReturn->party_ledger_id; 
				$AccountingEntrie->credit=$saleReturn->amount_after_tax;
				$AccountingEntrie->debit=0;
				$AccountingEntrie->transaction_date=date('Y-m-d');
				$AccountingEntrie->city_id=$city_id;
				$AccountingEntrie->entry_from="Web";
				$AccountingEntrie->sale_return_id=$saleReturn->id;  
				$this->SaleReturns->Invoices->Ledgers->AccountingEntries->save($AccountingEntrie);
			
			// Sales Account Ledger entry
				$AccountingEntrie = $this->SaleReturns->Invoices->Ledgers->AccountingEntries->newEntity(); 
				$AccountingEntrie->ledger_id=$saleReturn->sales_ledger_id; 
				$AccountingEntrie->debit=$saleReturn->amount_before_tax;
				$AccountingEntrie->credit=0;
				$AccountingEntrie->transaction_date=date('Y-m-d');
				$AccountingEntrie->city_id=$city_id;
				$AccountingEntrie->entry_from="Web";
				$AccountingEntrie->sale_return_id=$saleReturn->id;  
				$this->SaleReturns->Invoices->Ledgers->AccountingEntries->save($AccountingEntrie);
			
			foreach($saleReturn->sale_return_rows as $sale_return_row){
				$ItemVarData = $this->SaleReturns->SaleReturnRows->ItemVariations->find()->where(['ItemVariations.id'=>$sale_return_row->item_variation_id])->first();
				$ItemData = $this->SaleReturns->SaleReturnRows->ItemVariations->Items->find()->where(['Items.id'=>$ItemVarData->item_id])->first();
				$gstAmtdata=$sale_return_row->gst_value/2;
				$gstAmtInsert=round($gstAmtdata,2);
				
				//Accounting Entries for CGST//
				$gstLedgerCGST = $this->SaleReturns->Invoices->Ledgers->find()
				->where(['Ledgers.gst_figure_id' =>$ItemData->gst_figure_id, 'Ledgers.input_output'=>'output', 'Ledgers.gst_type'=>'CGST','city_id'=>$city_id])->first();
				$AccountingEntrieCGST = $this->SaleReturns->Invoices->Ledgers->AccountingEntries->newEntity();
				$AccountingEntrieCGST->ledger_id=$gstLedgerCGST->id;
				$AccountingEntrieCGST->credit=0;
				$AccountingEntrieCGST->debit=$gstAmtInsert;
				$AccountingEntrieCGST->transaction_date=date('Y-m-d');
				$AccountingEntrieCGST->city_id=$city_id;
				$AccountingEntrieCGST->entry_from="Web";
				$AccountingEntrieCGST->sale_return_id=$saleReturn->id;  
				if($gstAmtInsert > 0){
					$this->SaleReturns->Invoices->Ledgers->AccountingEntries->save($AccountingEntrieCGST);
				}
				
				//Accounting Entries for SGST//
				 $gstLedgerSGST = $this->SaleReturns->Invoices->Ledgers->find()
				->where(['Ledgers.gst_figure_id' =>$ItemData->gst_figure_id, 'Ledgers.input_output'=>'output', 'Ledgers.gst_type'=>'SGST','city_id'=>$city_id])->first();
				$AccountingEntrieSGST = $this->SaleReturns->Invoices->Ledgers->AccountingEntries->newEntity();
				$AccountingEntrieSGST->ledger_id=$gstLedgerSGST->id;
				$AccountingEntrieSGST->credit=0;
				$AccountingEntrieSGST->debit=$gstAmtInsert;
				$AccountingEntrieSGST->transaction_date=date('Y-m-d');
				$AccountingEntrieSGST->city_id=$city_id;
				$AccountingEntrieSGST->entry_from="Web";
				$AccountingEntrieSGST->sale_return_id=$saleReturn->id;  
				if($gstAmtInsert > 0){
					$this->SaleReturns->Invoices->Ledgers->AccountingEntries->save($AccountingEntrieSGST);
				}
				
				if(empty($order->seller_id)){
					$ItemLedger = $this->SaleReturns->Invoices->InvoiceRows->ItemLedgers->newEntity(); 
					$ItemLedger->item_id=$ItemVarData->item_id; 
					$ItemLedger->unit_variation_id=$ItemVarData->unit_variation_id;
					$ItemLedger->item_variation_id=$sale_return_row->item_variation_id;
					$ItemLedger->transaction_date=date('Y-m-d');  
					$ItemLedger->quantity=$sale_return_row->return_quantity;
					$ItemLedger->rate=$sale_return_row->net_amount/$sale_return_row->return_quantity;
					$ItemLedger->amount=$sale_return_row->return_quantity*$ItemLedger->rate;
					//$ItemLedger->sale_rate=$sale_return_row->rate;
					$ItemLedger->status="In";
					$ItemLedger->city_id=$city_id;
					$ItemLedger->location_id=$order->location_id;
					$ItemLedger->sale_return_id=$saleReturn->id;  
					$ItemLedger->sale_return_row_id=$sale_return_row->id; //pr($ItemLedger); exit;
					$this->SaleReturns->Invoices->InvoiceRows->ItemLedgers->save($ItemLedger);
					
					//Stock Up
					
					
					$itemVariations = $this->SaleReturns->SaleReturnRows->ItemVariations->get($sale_return_row->item_variation_id);
						$query = $this->SaleReturns->SaleReturnRows->ItemVariations->query();
						$query->update()
						->set([
								'current_stock' =>$itemVariations->current_stock+$sale_return_row->return_quantity,
								'update_on' =>date('Y-m-d'),
								'status' =>'Active',
								'out_of_stock' => 'No',
								'ready_to_sale' => 'Yes'
							])
						->where(['id' => $sale_return_row->item_variation_id])
						->execute();
							
								$cs=$itemVariations->current_stock+$sale_return_row->return_quantity;
								//update in variation
								if($itemVariations->demand_stock == $cs){
									$query = $this->SaleReturns->SaleReturnRows->ItemVariations->query();
									$query->update()
									 ->set([
											'current_stock' =>0,
											'add_stock' =>0,
											'demand_stock' =>0,
											'update_on' =>date('Y-m-d'),
											'status' =>'Active',
											'out_of_stock' => 'No',
											'ready_to_sale' => 'Yes'
										])
									->where(['id' => $sale_return_row->item_variation_id])
									->execute(); 
								}else if($itemVariations->demand_stock < $cs){
									$remaining=$cs-$itemVariations->demand_stock;
									//$current_stock=$remaining+$item_variation_data->current_stock;
									$query = $this->SaleReturns->SaleReturnRows->ItemVariations->query();
									$query->update()
									 ->set([
											'current_stock' =>$remaining,
											'demand_stock' =>0,
											'update_on' =>date('Y-m-d'),
											'status' =>'Active',
											'out_of_stock' => 'No',
											'ready_to_sale' => 'Yes'
										])
									->where(['id' => $sale_return_row->item_variation_id])
									->execute(); 
								}else if($itemVariations->demand_stock > $cs){
									$demand_stock=$itemVariations->demand_stock-$cs;
									//$current_stock=$cur_stock-$item_variation_data->demand_stock;
									$query = $this->SaleReturns->SaleReturnRows->ItemVariations->query();
									$query->update()
									 ->set([
											'current_stock' =>0,
											'demand_stock' =>$demand_stock,
											'update_on' =>date('Y-m-d'),
											'status' =>'Active',
											'out_of_stock' => 'No',
											'ready_to_sale' => 'Yes'
										])
									->where(['id' => $sale_return_row->item_variation_id])
									->execute(); 
								}
						}
					$query = $this->SaleReturns->Invoices->query();
					$query->update()
					->set(['sales_return_status'=>'Complete'])
					->where(['id'=>$id])
					->execute();
			}
			
				if($order->order_type!="COD" && $order->order_type!="Credit"){
					$query = $this->SaleReturns->Wallets->query();
						$query->insert(['city_id', 'customer_id','invoice_id','add_amount','narration','amount_type','transaction_type'])
							->values([
								'city_id' => $city_id,
								'customer_id' => $order->customer_id,
								'invoice_id' => $order->id,
								'add_amount' => $saleReturn->amount_after_tax,
								'narration' => 'Amount Added For Item Return ',
								'amount_type' => 'Sale Return',
								'transaction_type' => 'Added'	
							])->execute();	
				}
			
				
                $this->Flash->success(__('The sale return has been saved.'));

                return $this->redirect(['action' => 'index']);
            }pr($saleReturn); exit;
            $this->Flash->error(__('The sale return could not be saved. Please, try again.'));
        }
		
       
		
		$itemList=$this->SaleReturns->Orders->Items->find()->contain(['ItemVariations'=> function ($q) {
								return $q
								->where(['ItemVariations.status'=>'Active','seller_id IS NULL'])->contain(['UnitVariations'=>['Units']]);
								}]);
		//pr($itemList->toArray()); exit;
		$items=array();
		foreach($itemList as $data1){ 
			foreach($data1->item_variations as $data){  
				$gstData=$this->SaleReturns->Orders->GstFigures->get($data1->gst_figure_id);
				$merge=$data1->name.'('.@$data->unit_variation->quantity_variation.'.'.@$data->unit_variation->unit->shortname.')';
				$items[]=['text' => $merge,'value' => $data->id,'item_id'=>$data1->id,'quantity_factor'=>@$data->unit_variation->convert_unit_qty,'unit'=>@$data->unit_variation->unit->unit_name,'gst_figure_id'=>$data1->gst_figure_id,'gst_value'=>$gstData->tax_percentage,'commission'=>@$data->commission,'sale_rate'=>$data->sales_rate,'current_stock'=>$data->current_stock];
			}
		}
		//pr($order); exit;
        $this->set(compact('order','saleReturn', 'customers', 'salesLedgers', 'partyLedgers', 'locations', 'cities', 'orders', 'items'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Sale Return id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $saleReturn = $this->SaleReturns->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $saleReturn = $this->SaleReturns->patchEntity($saleReturn, $this->request->getData());
            if ($this->SaleReturns->save($saleReturn)) {
                $this->Flash->success(__('The sale return has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The sale return could not be saved. Please, try again.'));
        }
        $customers = $this->SaleReturns->Customers->find('list', ['limit' => 200]);
        $salesLedgers = $this->SaleReturns->SalesLedgers->find('list', ['limit' => 200]);
        $partyLedgers = $this->SaleReturns->PartyLedgers->find('list', ['limit' => 200]);
        $locations = $this->SaleReturns->Locations->find('list', ['limit' => 200]);
        $cities = $this->SaleReturns->Cities->find('list', ['limit' => 200]);
        $orders = $this->SaleReturns->Orders->find('list', ['limit' => 200]);
        $this->set(compact('saleReturn', 'customers', 'salesLedgers', 'partyLedgers', 'locations', 'cities', 'orders'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Sale Return id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $saleReturn = $this->SaleReturns->get($id);
        if ($this->SaleReturns->delete($saleReturn)) {
            $this->Flash->success(__('The sale return has been deleted.'));
        } else {
            $this->Flash->error(__('The sale return could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
	
	public function pdfView($id = null)
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
        
		$this->loadmodel('SalesOrders');
		$Orders=$this->SaleReturns->get($ids,['contain'=>['saleReturnRows'=>['ItemVariations'=>['UnitVariations','Items']],'Customers'=>['CustomerAddresses']]]);
		//pr($Orders); exit;
		$company_details=$this->SaleReturns->Invoices->Companies->find()->where(['Companies.city_id'=>$city_id])->first();
        $this->set(compact('ids', 'sales_orders', 'order', 'locations', 'customers', 'drivers', 'customerAddresses', 'promotionDetails', 'deliveryCharges', 'deliveryTimes', 'cancelReasons','order_no','partyOptions','Accountledgers','items','company_details','Orders'));
    }
}
