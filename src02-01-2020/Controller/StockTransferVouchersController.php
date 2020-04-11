<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\View\View;
/**
 * StockTransferVouchers Controller
 *
 * @property \App\Model\Table\StockTransferVouchersTable $StockTransferVouchers
 *
 * @method \App\Model\Entity\StockTransferVoucher[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class StockTransferVouchersController extends AppController
{
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Security->setConfig('unlockedActions', ['add','edit','index','view']);
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id');
		$this->viewBuilder()->layout('super_admin_layout');
        $this->paginate = [
            'contain' => ['Grns', 'Cities', 'Locations'],
			'limit' => 100
        ];
        $stockTransferVouchers = $this->paginate($this->StockTransferVouchers->find()->where(['StockTransferVouchers.city_id'=>$city_id]));
		
		$paginate_limit=$this->paginate['limit'];
        $this->set(compact('stockTransferVouchers','paginate_limit'));
    }

    /**
     * View method
     *
     * @param string|null $id Stock Transfer Voucher id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($ids = null)
    {
		if($ids)
		{
		  $id = $this->EncryptingDecrypting->decryptData($ids);
		}
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id');
		$this->viewBuilder()->layout('super_admin_layout');
		
        $stockTransferVoucher = $this->StockTransferVouchers->get($id, [
            'contain' => ['Grns', 'Cities', 'Locations', 'StockTransferVoucherRows'=>['Items','ItemVariations'=>['UnitVariations'=>['Units']]]]
        ]);
		//pr($stockTransferVoucher->toArray()); exit;
        $this->set('stockTransferVoucher', $stockTransferVoucher);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
		 public function itemLedgerUpdate(){
		 $stockTransferVouchers = $this->StockTransferVouchers->find()->contain(['StockTransferVoucherRows'=>['GrnRows']]);
		 foreach($stockTransferVouchers as $stockTransferVoucher){
			 foreach($stockTransferVoucher->stock_transfer_voucher_rows as $stock_transfer_voucher_row){
				 
					
					
					$ItemVariationData=$this->StockTransferVouchers->StockTransferVoucherRows->ItemVariations->find()->where(['item_id'=>$stock_transfer_voucher_row->item_id,'unit_variation_id'=>$stock_transfer_voucher_row->grn_row->unit_variation_id])->first();
					
					$ItemLedgersData=$this->StockTransferVouchers->Grns->ItemLedgers->find()->where(['grn_row_id' => $stock_transfer_voucher_row->grn_row_id,'status'=>'Out','stock_transfer_voucher_id' => $stockTransferVoucher->id])->first();
					
					// OUT
					if(empty($ItemLedgersData)){
						$query = $this->StockTransferVouchers->Grns->ItemLedgers->query();
						$query->insert(['item_id','city_id','unit_variation_id','transaction_date','quantity','rate','purchase_rate','amount','stock_transfer_voucher_id','grn_row_id','status','expiry_date'])
						->values(['item_id' => $stock_transfer_voucher_row->item_id,'city_id' => $stockTransferVoucher->city_id,'unit_variation_id' => $stock_transfer_voucher_row->grn_row->unit_variation_id,'transaction_date' => $stockTransferVoucher->transaction_date,'quantity' => $stock_transfer_voucher_row->quantity,'rate' => $stock_transfer_voucher_row->purchase_rate,'purchase_rate' => $stock_transfer_voucher_row->purchase_rate,'amount' => $stock_transfer_voucher_row->purchase_rate*$stock_transfer_voucher_row->quantity,'stock_transfer_voucher_id' => $stockTransferVoucher->id,'grn_row_id' => $stock_transfer_voucher_row->grn_row_id,'status'=>'Out','expiry_date'=>$stock_transfer_voucher_row->grn_row->expiry_date])->execute();
					}
					
					$ItemLedgersData1=$this->StockTransferVouchers->Grns->ItemLedgers->find()->where(['stock_transfer_voucher_row_id' => $stock_transfer_voucher_row->id,'status'=>'In','stock_transfer_voucher_id' => $stockTransferVoucher->id])->first();
					//pr($ItemLedgersData1); exit;
					// IN
					if(empty($ItemLedgersData1)){
						$query = $this->StockTransferVouchers->Grns->ItemLedgers->query();
						$query->insert(['item_id','city_id','location_id','unit_variation_id','item_variation_id','transaction_date','quantity','rate','purchase_rate','amount','sale_rate','stock_transfer_voucher_id','stock_transfer_voucher_row_id','status','expiry_date'])
						->values(['item_id' => $stock_transfer_voucher_row->item_id,'city_id' => $stockTransferVoucher->city_id,'location_id' => $stockTransferVoucher->location_id,'unit_variation_id' => $stock_transfer_voucher_row->grn_row->unit_variation_id,'item_variation_id' => $ItemVariationData->id,'transaction_date' => $stockTransferVoucher->transaction_date,'quantity' => $stock_transfer_voucher_row->quantity,'rate' => $stock_transfer_voucher_row->purchase_rate,'purchase_rate' => $stock_transfer_voucher_row->purchase_rate,'amount' => $stock_transfer_voucher_row->purchase_rate*$stock_transfer_voucher_row->quantity,'sale_rate' => $stock_transfer_voucher_row->sales_rate,'stock_transfer_voucher_id' => $stockTransferVoucher->id,'stock_transfer_voucher_row_id' => $stock_transfer_voucher_row->id,'status'=>'In','expiry_date'=>$stock_transfer_voucher_row->grn_row->expiry_date])->execute();
					}
				
			 } 
		 } 
		 echo "Updation Complete"; exit;
	 } 
	 
	
    public function add($grn_id)
    {
        $grn_id = $this->EncryptingDecrypting->decryptData($grn_id);
        $user_id=$this->Auth->User('id');
        $city_id=$this->Auth->User('city_id');
		$financial_year_id=$this->Auth->User('financial_year_id');
        $this->viewBuilder()->layout('super_admin_layout');
        $Voucher_no = $this->StockTransferVouchers->find()->select(['voucher_no'])->where(['StockTransferVouchers.city_id'=>$city_id,'StockTransferVouchers.financial_year_id'=>$financial_year_id])->order(['voucher_no' => 'DESC'])->first();
        if($Voucher_no){
            $voucher_no=$Voucher_no->voucher_no+1;
        }else{
            $voucher_no=1;
        } 
        $stockTransferVoucher = $this->StockTransferVouchers->newEntity();
        if ($this->request->is('post')) { 
			
			$Voucher_no = $this->StockTransferVouchers->find()->select(['voucher_no'])->where(['StockTransferVouchers.city_id'=>$city_id,'StockTransferVouchers.financial_year_id'=>$financial_year_id])->order(['voucher_no' => 'DESC'])->first();
				if($Voucher_no){
					$voucher_no=$Voucher_no->voucher_no+1;
				}else{
					$voucher_no=1;
				} 
			
            $stockTransferVoucher = $this->StockTransferVouchers->patchEntity($stockTransferVoucher, $this->request->getData());
            $stockTransferVoucher->grn_id=$grn_id;
            $stockTransferVoucher->city_id=$city_id;
            $stockTransferVoucher->voucher_no=$voucher_no;
            $transaction_date=date('Y-m-d',strtotime($this->request->getData('transaction_date')));
            $stockTransferVoucher->transaction_date=$transaction_date;
            $stockTransferVoucher->financial_year_id=$financial_year_id;
            $total_tranfer_quantity=0;
            $total_quantity=0;
			
			
			//$a="1.238";
			//pr($$stockTransferVoucher); exit;
            if ($this->StockTransferVouchers->save($stockTransferVoucher)) {
                $total_tranfer_quantity=0;
                $total_tranfer_quantity1=0;
                $total_quantity=0;
                foreach($this->request->getData('grn_rows') as $data)
                {
                    $grn_row = $this->StockTransferVouchers->Grns->GrnRows->get($data['grn_row_id']);
                    $transfer_quantity =$grn_row->transfer_quantity;
                    $transfer_quantity1 =$grn_row->transfer_quantity+$grn_row->return_quantity;
                    $total_quantity+=$grn_row->quantity;
                    $total_tranfer_quantity+=$data['transfer_quantity']+$transfer_quantity;
                    $total_tranfer_quantity1+=$data['transfer_quantity']+$transfer_quantity1;

                    $query = $this->StockTransferVouchers->Grns->GrnRows->query();
                    $query->update()
                        ->set(['transfer_quantity' =>$data['transfer_quantity']+$transfer_quantity])
                        ->where(['id' => $data['grn_row_id']])
                        ->execute();

                    //////////////////////  Item Ledger Out Entry /////////////////////////////////
                    $amount = $data['transfer_quantity']*$grn_row->purchase_rate;
                    $query = $this->StockTransferVouchers->Grns->ItemLedgers->query();
                    $query->insert(['item_id','city_id','unit_variation_id','transaction_date','quantity','rate','purchase_rate','amount','stock_transfer_voucher_id','grn_row_id','status','expiry_date'])
                    ->values(['item_id' => $grn_row->item_id,'city_id' => $city_id,'unit_variation_id' => $grn_row->unit_variation_id,'transaction_date' => $transaction_date,'quantity' => $data['transfer_quantity'],'rate' => $grn_row->purchase_rate,'purchase_rate' => $grn_row->purchase_rate,'amount' => $amount,'stock_transfer_voucher_id' => $stockTransferVoucher->id,'grn_row_id' => $data['grn_row_id'],'status'=>'Out','expiry_date'=>$grn_row->expiry_date])->execute();
    
                }
                if($total_quantity == $total_tranfer_quantity1)
                {
                    $query = $this->StockTransferVouchers->Grns->query();
                    $query->update()
                        ->set(['stock_transfer_status' =>'Completed'])
                        ->where(['id' => $grn_id])
                        ->execute();
                }

                foreach($stockTransferVoucher->stock_transfer_voucher_rows as $stock_transfer_voucher_row)
                { 
                    /////////////////////////////// Item Ledger In //////////////////////////
					$grn_row = $this->StockTransferVouchers->Grns->GrnRows->get($stock_transfer_voucher_row->grn_row_id);
                     $amount = $stock_transfer_voucher_row->quantity*$stock_transfer_voucher_row->purchase_rate;
                    $query = $this->StockTransferVouchers->Grns->ItemLedgers->query();
                    $query->insert(['item_id','city_id','location_id','unit_variation_id','item_variation_id','transaction_date','quantity','rate','purchase_rate','amount','sale_rate','stock_transfer_voucher_id','stock_transfer_voucher_row_id','status','expiry_date'])
                    ->values(['item_id' => $stock_transfer_voucher_row->item_id,'city_id' => $city_id,'location_id' => $stockTransferVoucher->location_id,'unit_variation_id' => $stock_transfer_voucher_row->unit_variation_id,'item_variation_id' => $stock_transfer_voucher_row->item_variation_id,'transaction_date' => $transaction_date,'quantity' => $stock_transfer_voucher_row->quantity,'rate' => $stock_transfer_voucher_row->purchase_rate,'purchase_rate' => $stock_transfer_voucher_row->purchase_rate,'amount' => $amount,'sale_rate' => $stock_transfer_voucher_row->sales_rate,'stock_transfer_voucher_id' => $stockTransferVoucher->id,'stock_transfer_voucher_row_id' => $stock_transfer_voucher_row->id,'status'=>'In','expiry_date'=>$grn_row->expiry_date])->execute();

                     /////////////////////////////// Item Variation //////////////////////////
					$item= $this->StockTransferVouchers->StockTransferVoucherRows->ItemVariations->Items->get($stock_transfer_voucher_row->item_id);
					if($item->item_maintain_by=="itemwise"){
						 $allItemVariations= $this->StockTransferVouchers->StockTransferVoucherRows->ItemVariations->find()->where(['ItemVariations.item_id'=>$stock_transfer_voucher_row->item_id,'ItemVariations.city_id'=>@$city_id,'ItemVariations.seller_id IS NULL'])->contain(['UnitVariations'=>['Units']]);
						 $UnitVariation= $this->StockTransferVouchers->StockTransferVoucherRows->ItemVariations->UnitVariations->get($stock_transfer_voucher_row->unit_variation_id);
						 
							foreach($allItemVariations as $iv){
								$p=($UnitVariation->convert_unit_qty*$stock_transfer_voucher_row->quantity); 
								$addQty=($p/$iv->unit_variation->convert_unit_qty); 
								$addQty=round($addQty,2);
								 $item_variation_data = $this->StockTransferVouchers->StockTransferVoucherRows->ItemVariations->get($iv->id);
								$query = $this->StockTransferVouchers->StockTransferVoucherRows->ItemVariations->query();
								$query->update()
								->set([
									'current_stock' =>$item_variation_data->current_stock+$addQty,
									'add_stock' =>$item_variation_data->quantity,
									'purchase_rate' =>$stock_transfer_voucher_row->purchase_rate*@$iv->unit_variation->convert_unit_qty,
									'update_on' =>date('Y-m-d'),
									'status' =>'Active',
									'out_of_stock' => 'No',
									'ready_to_sale' => 'Yes'
								])
								->where(['id' => $iv->id])
								->execute();
								
								$cs=$item_variation_data->current_stock+$addQty;
								//pr($item_variation_data->demand_stock);
								//pr($item_variation_data->current_stock); exit;
								//
								//update in variation
								if($item_variation_data->demand_stock == $cs){
									$query = $this->StockTransferVouchers->StockTransferVoucherRows->ItemVariations->query();
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
									->where(['id'=>$iv->id])
									->execute(); 
								}else if($item_variation_data->demand_stock < $cs){
									$remaining=$cs-$item_variation_data->demand_stock;
									//$current_stock=$remaining+$item_variation_data->current_stock;
									$query = $this->StockTransferVouchers->StockTransferVoucherRows->ItemVariations->query();
									$query->update()
									 ->set([
											'current_stock' =>$remaining,
											'add_stock' =>$stock_transfer_voucher_row->quantity,
											'demand_stock' =>0,
											'update_on' =>date('Y-m-d'),
											'status' =>'Active',
											'out_of_stock' => 'No',
											'ready_to_sale' => 'Yes'
										])
									->where(['id'=>$iv->id])
									->execute(); 
								}else if($item_variation_data->demand_stock > $cs){
									$demand_stock=$item_variation_data->demand_stock-$cs;
									//$current_stock=$cur_stock-$item_variation_data->demand_stock;
									$query = $this->StockTransferVouchers->StockTransferVoucherRows->ItemVariations->query();
									$query->update()
									 ->set([
											'current_stock' =>0,
											'add_stock' =>$stock_transfer_voucher_row->quantity,
											'demand_stock' =>$demand_stock,
											'update_on' =>date('Y-m-d'),
											'status' =>'Active',
											'out_of_stock' => 'No',
											'ready_to_sale' => 'Yes'
										])
									->where(['id'=>$iv->id])
									->execute(); 
								}
							 }
						}else{
							$itemVariations = $this->StockTransferVouchers->StockTransferVoucherRows->ItemVariations->get($stock_transfer_voucher_row->item_variation_id);
							$query = $this->StockTransferVouchers->StockTransferVoucherRows->ItemVariations->query();
							$query->update()
							->set([
									'current_stock' =>$itemVariations->current_stock+$stock_transfer_voucher_row->quantity,
									'add_stock' =>$stock_transfer_voucher_row->quantity,
									'purchase_rate' =>$stock_transfer_voucher_row->purchase_rate,
									'update_on' =>date('Y-m-d'),
									'status' =>'Active',
									'out_of_stock' => 'No',
									'ready_to_sale' => 'Yes'
								])
							->where(['id' => $stock_transfer_voucher_row->item_variation_id])
							->execute();
							
								$cs=$itemVariations->current_stock+$stock_transfer_voucher_row->quantity;
								
								//update in variation
								if($itemVariations->demand_stock == $cs){
									$query = $this->StockTransferVouchers->StockTransferVoucherRows->ItemVariations->query();
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
									->where(['id' => $stock_transfer_voucher_row->item_variation_id])
									->execute(); 
								}else if($itemVariations->demand_stock < $cs){
									$remaining=$cs-$itemVariations->demand_stock;
									//$current_stock=$remaining+$item_variation_data->current_stock;
									$query = $this->StockTransferVouchers->StockTransferVoucherRows->ItemVariations->query();
									$query->update()
									 ->set([
											'current_stock' =>$remaining,
											'add_stock' =>$stock_transfer_voucher_row->quantity,
											'demand_stock' =>0,
											'update_on' =>date('Y-m-d'),
											'status' =>'Active',
											'out_of_stock' => 'No',
											'ready_to_sale' => 'Yes'
										])
									->where(['id' => $stock_transfer_voucher_row->item_variation_id])
									->execute(); 
								}else if($itemVariations->demand_stock > $cs){
									$demand_stock=$itemVariations->demand_stock-$cs;
									//$current_stock=$cur_stock-$item_variation_data->demand_stock;
									$query = $this->StockTransferVouchers->StockTransferVoucherRows->ItemVariations->query();
									$query->update()
									 ->set([
											'current_stock' =>0,
											'add_stock' =>$stock_transfer_voucher_row->quantity,
											'demand_stock' =>$demand_stock,
											'update_on' =>date('Y-m-d'),
											'status' =>'Active',
											'out_of_stock' => 'No',
											'ready_to_sale' => 'Yes'
										])
									->where(['id' => $stock_transfer_voucher_row->item_variation_id])
									->execute(); 
								}
						}
			
						
						
						 
					//$item_variation_data = $this->StockTransferVouchers->StockTransferVoucherRows->ItemVariations->get($stock_transfer_voucher_row->item_variation_id);
					
					
                }
				 //exit;
                $this->Flash->success(__('The stock transfer voucher has been saved.'));

                return $this->redirect(['action' => 'index']);
            }else{ 
             
            $this->Flash->error(__('The stock transfer voucher could not be saved. Please, try again.'));
			}
        }
      
     
         $grns = $this->StockTransferVouchers->Grns->get($grn_id,
            [
                'contain'=>['GrnRows'=>function($q) use($city_id){
                        return $q->select(['GrnRows.grn_id','total_quantity'=>$q->func()->sum('GrnRows.quantity-GrnRows.transfer_quantity')])
                                ->contain(['Items'=>['ItemVariations'=>function($q) use($city_id){
                                        return $q->where(['ItemVariations.city_id'=>$city_id,'ItemVariations.seller_id IS NULL'])->contain(['UnitVariations'=>'Units']);
                                }],'UnitVariations'=>'Units'])
                                ->having(['total_quantity >' => 0])
                                ->group('GrnRows.id')
                                ->autoFields(true);
                }]

            ]);
        $itemVar=[];
		foreach($grns->grn_rows as $data){
			$ItemVariation = $this->StockTransferVouchers->StockTransferVoucherRows->Items->ItemVariations->find()->where(['item_id'=>$data->item_id,'unit_variation_id'=>$data->unit_variation_id])->first();
			$itemVar[$data->item_id][$data->unit_variation_id]=$ItemVariation->id;
			//pr($itemVar); exit;
		}
		//pr($grns); exit;
        $locations = $this->StockTransferVouchers->Locations->find('list')->where(['city_id'=>$city_id,'status'=>'Active']);
        $this->set(compact('stockTransferVoucher', 'grns', 'locations','voucher_no','itemVar'));
    }
    public function ajaxItemQuantity($grn_row_id=null)
    {
        $this->viewBuilder()->layout('');
        $city_id=$this->Auth->User('city_id');
        /*$items = $this->StockTransferVouchers->StockTransferVoucherRows->Items->find()
                    ->where(['Items.status'=>'Active', 'Items.id'=>$itemId])
                    ->contain(['Units'])->first();
                    $itemUnit=$items->unit->name;*/
                    
        $grns = $this->StockTransferVouchers->Grns->GrnRows->get($grn_row_id);
        pr($grns);
        exit;
        $query = $this->StockTransferVouchers->StockTransferVoucherRows->Items->ItemLedgers->find()->where(['ItemLedgers.city_id'=>$city_id,'']);
        $totalInCase = $query->newExpr()
            ->addCase(
                $query->newExpr()->add(['status' => 'In']),
                $query->newExpr()->add(['quantity']),
                'integer'
            );
        $totalOutCase = $query->newExpr()
            ->addCase(
                $query->newExpr()->add(['status' => 'out']),
                $query->newExpr()->add(['quantity']),
                'integer'
            );
        $query->select([
            'total_in' => $query->func()->sum($totalInCase),
            'total_out' => $query->func()->sum($totalOutCase),'id','item_id'
        ])
        ->where(['ItemLedgers.item_id' => $itemId, 'ItemLedgers.city_id' => $city_id])
        ->group('item_id')
        ->autoFields(true)
        ->contain(['Items']);
        $itemLedgers = ($query);
        
        
        
        
        if($itemLedgers->toArray())
        {
              foreach($itemLedgers as $itemLedger){
                   $available_stock=$itemLedger->total_in;
                   $stock_issue=$itemLedger->total_out;
                 @$remaining=number_format($available_stock-$stock_issue, 2);
                 $mainstock=str_replace(',','',$remaining);
                 $stock='current stock is '. $remaining. ' ' .$itemUnit;
                 if($remaining>0)
                 {
                 $stockType='false';
                 }
                 else{
                 $stockType='true';
                 }
                 $h=array('text'=>$stock, 'type'=>$stockType, 'mainStock'=>$mainstock);
                 echo  $f=json_encode($h);
              }
          }
          else{
         
                 @$remaining=0;
                 $stock='current stock is '. $remaining. ' ' .$itemUnit;
                 if($remaining>0)
                 {
                 $stockType='false';
                 }
                 else{
                 $stockType='true';
                 }
                 $h=array('text'=>$stock, 'type'=>$stockType);
                 echo  $f=json_encode($h);
          }
          exit;
    }   
    /**
     * Edit method
     *
     * @param string|null $id Stock Transfer Voucher id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $stockTransferVoucher = $this->StockTransferVouchers->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $stockTransferVoucher = $this->StockTransferVouchers->patchEntity($stockTransferVoucher, $this->request->getData());
            if ($this->StockTransferVouchers->save($stockTransferVoucher)) {
                $this->Flash->success(__('The stock transfer voucher has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The stock transfer voucher could not be saved. Please, try again.'));
        }
        $grns = $this->StockTransferVouchers->Grns->find('list', ['limit' => 200]);
        $cities = $this->StockTransferVouchers->Cities->find('list', ['limit' => 200]);
        $locations = $this->StockTransferVouchers->Locations->find('list', ['limit' => 200]);
        $this->set(compact('stockTransferVoucher', 'grns', 'cities', 'locations'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Stock Transfer Voucher id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
		$city_id=$this->Auth->User('city_id');
        //
		$StockTransferVouchers = $this->StockTransferVouchers->get($id,['contain'=>['StockTransferVoucherRows'=>['ItemVariations','GrnRows']]]);
		
		foreach($StockTransferVouchers->stock_transfer_voucher_rows as $data){
			$item= $this->StockTransferVouchers->StockTransferVoucherRows->ItemVariations->Items->get($data->item_id);
			if($item->item_maintain_by=="itemwise"){
						 $allItemVariations= $this->StockTransferVouchers->StockTransferVoucherRows->ItemVariations->find()->where(['ItemVariations.item_id'=>$data->item_id,'ItemVariations.city_id'=>@$city_id,'ItemVariations.seller_id IS NULL'])->contain(['UnitVariations'=>['Units']]);
						//pr($data->item_id); exit;
						
						 $UnitVariation= $this->StockTransferVouchers->StockTransferVoucherRows->ItemVariations->UnitVariations->get($data->item_variation->unit_variation_id);
						// pr($data->quantity); exit;
							foreach($allItemVariations as $iv){  
								$p=($UnitVariation->convert_unit_qty*$data->quantity); 
								$addQty=($p/$iv->unit_variation->convert_unit_qty); 
								$addQty=round($addQty,2);
								 $item_variation_data = $this->StockTransferVouchers->StockTransferVoucherRows->ItemVariations->get($iv->id);
								
								//
								//update in variation
								if($item_variation_data->current_stock == $addQty){
									$query = $this->StockTransferVouchers->StockTransferVoucherRows->ItemVariations->query();
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
									->where(['id'=>$iv->id])
									->execute(); 
								}else if($item_variation_data->current_stock < $addQty){ 
									$remaining=$addQty-$item_variation_data->current_stock;
									$ds=$remaining+$item_variation_data->demand_stock;
									$query = $this->StockTransferVouchers->StockTransferVoucherRows->ItemVariations->query();
									$query->update()
									 ->set([
											'current_stock' =>0,
											'add_stock' =>$data->quantity,
											'demand_stock' =>$ds,
											'update_on' =>date('Y-m-d'),
											'status' =>'Active',
											'out_of_stock' => 'No',
											'ready_to_sale' => 'Yes'
										])
									->where(['id'=>$iv->id])
									->execute(); 
								}else if($item_variation_data->current_stock > $addQty){
									$cur_stock=$item_variation_data->current_stock-$addQty;
									//$current_stock=$cur_stock-$item_variation_data->demand_stock;
									$query = $this->StockTransferVouchers->StockTransferVoucherRows->ItemVariations->query();
									$query->update()
									 ->set([
											'current_stock' =>$cur_stock,
											'add_stock' =>$addQty,
											'demand_stock' =>0,
											'update_on' =>date('Y-m-d'),
											'status' =>'Active',
											'out_of_stock' => 'No',
											'ready_to_sale' => 'Yes'
										])
									->where(['id'=>$iv->id])
									->execute(); 
								}
							 }
						}else{
							$ItemVariationData = $this->StockTransferVouchers->StockTransferVoucherRows->ItemVariations->get($data->item_variation_id);
							
							$current_stock=$ItemVariationData->current_stock-$data->quantity;
							$cs=$ItemVariationData->current_stock;
							$vs=$ItemVariationData->virtual_stock;
							$ds=$ItemVariationData->demand_stock;
							$actual_quantity=$data->quantity;
							
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
							
							$query = $this->StockTransferVouchers->StockTransferVoucherRows->ItemVariations->query();
							$query->update()
							->set(['current_stock'=>$final_cs,'demand_stock'=>$final_ds,'out_of_stock'=>$out_of_stock,'ready_to_sale'=>$ready_to_sale])
							->where(['id'=>$data->item_variation_id])
							->execute();
							
						}
						
						$query = $this->StockTransferVouchers->Grns->GrnRows->query();
						$query->update()
						->set(['transfer_quantity'=>$data->grn_row->transfer_quantity-$data->quantity])
						->where(['id'=>$data->grn_row_id])
						->execute();
						
			}
		$query = $this->StockTransferVouchers->Grns->query();
		$query->update()
		->set(['stock_transfer_status'=>'Pending'])
		->where(['id'=>$StockTransferVouchers->grn_id])
		->execute();
		
		$this->StockTransferVouchers->StockTransferVoucherRows->deleteAll(['stock_transfer_voucher_id' => $id]);
		$stockTransferVoucher = $this->StockTransferVouchers->get($id);
		$this->StockTransferVouchers->StockTransferVoucherRows->Items->ItemLedgers->deleteAll(['stock_transfer_voucher_id' => $id]);
		
        if ($this->StockTransferVouchers->delete($stockTransferVoucher)) {
            $this->Flash->success(__('The stock transfer voucher has been deleted.'));
        } else {
            $this->Flash->error(__('The stock transfer voucher could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
