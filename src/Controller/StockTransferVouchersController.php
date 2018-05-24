<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * StockTransferVouchers Controller
 *
 * @property \App\Model\Table\StockTransferVouchersTable $StockTransferVouchers
 *
 * @method \App\Model\Entity\StockTransferVoucher[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class StockTransferVouchersController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Grns', 'Cities', 'Locations']
        ];
        $stockTransferVouchers = $this->paginate($this->StockTransferVouchers);

        $this->set(compact('stockTransferVouchers'));
    }

    /**
     * View method
     *
     * @param string|null $id Stock Transfer Voucher id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $stockTransferVoucher = $this->StockTransferVouchers->get($id, [
            'contain' => ['Grns', 'Cities', 'Locations', 'StockTransferVoucherRows']
        ]);

        $this->set('stockTransferVoucher', $stockTransferVoucher);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($grn_id)
    {
        $user_id=$this->Auth->User('id');
        $city_id=$this->Auth->User('city_id');
        $this->viewBuilder()->layout('super_admin_layout');
        $stockTransferVoucher = $this->StockTransferVouchers->newEntity();
        if ($this->request->is('post')) {
            $stockTransferVoucher = $this->StockTransferVouchers->patchEntity($stockTransferVoucher, $this->request->getData());
            if ($this->StockTransferVouchers->save($stockTransferVoucher)) {
                $this->Flash->success(__('The stock transfer voucher has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The stock transfer voucher could not be saved. Please, try again.'));
        }
        $Voucher_no = $this->StockTransferVouchers->find()->select(['voucher_no'])->where(['city_id'=>$city_id])->order(['voucher_no' => 'DESC'])->first();
        if($Voucher_no){
            $voucher_no=$Voucher_no->voucher_no+1;
        }else{
            $voucher_no=1;
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
      
    
        $locations = $this->StockTransferVouchers->Locations->find('list')->where(['city_id'=>$city_id,'status'=>'Active']);
        $this->set(compact('stockTransferVoucher', 'grns', 'locations','voucher_no'));
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
        $stockTransferVoucher = $this->StockTransferVouchers->get($id);
        if ($this->StockTransferVouchers->delete($stockTransferVoucher)) {
            $this->Flash->success(__('The stock transfer voucher has been deleted.'));
        } else {
            $this->Flash->error(__('The stock transfer voucher could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
