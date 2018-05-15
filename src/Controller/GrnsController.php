<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Grns Controller
 *
 * @property \App\Model\Table\GrnsTable $Grns
 *
 * @method \App\Model\Entity\Grn[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class GrnsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Locations', 'Orders']
        ];
        $grns = $this->paginate($this->Grns);

        $this->set(compact('grns'));
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
        $grn = $this->Grns->get($id, [
            'contain' => ['Locations', 'Orders']
        ]);

        $this->set('grn', $grn);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
     public function add()
    {
        $this->viewBuilder()->layout('admin_portal');
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
            $grn->city_id =$city_id;
            if ($this->Grns->save($grn)) 
            {
                //Create Item_Ledger//
                foreach($grn->grn_rows as $grn_row)
                {
                    $item_ledger = $this->Grns->ItemLedgers->newEntity();
                    $item_ledger->transaction_date = $grn->transaction_date;
                    $item_ledger->grn_id = $grn->id;
                    $item_ledger->grn_row_id = $grn_row->id;
                    $item_ledger->item_id = $grn_row->item_id;
                    $item_ledger->quantity = $grn_row->quantity;
                    $item_ledger->rate = $grn_row->purchase_rate;
                    $item_ledger->sale_rate = $grn_row->sale_rate;
                   // $item_ledger->company_id  =$company_id;
                    $item_ledger->city_id =$city_id;
                    $item_ledger->status ='in';
                    $item_ledger->amount=$grn_row->quantity*$grn_row->purchase_rate;
                    $this->Grns->ItemLedgers->save($item_ledger);
                    $item = $this->Grns->GrnRows->Items->find()->where(['Items.id'=>$grn_row->item_id])->first();
                    
                    
                    if($item)
                    {
                        if($grn->transaction_date >= date("Y-m-d",strtotime($item->sales_rate_update_on)))
                        {
                            $query = $this->Grns->GrnRows->Items->query();
                            $query->update()
                                    ->set(['sales_rate' => $grn_row->sale_rate, 'sales_rate_update_on' => $grn->transaction_date])
                                    ->where(['id' =>$grn_row->item_id])
                                    ->execute();
                        }
                    }
                }
                $this->Flash->success(__('The grn has been saved.'));
                return $this->redirect(['action' => 'add']);
            }
            $this->Flash->error(__('The grn could not be saved. Please, try again.'));
        }
        $items = $this->Grns->GrnRows->Items->find()
                    ->contain(['GstFigures']);
        $itemOptions=[];
        foreach($items as $item)
        {
            $itemOptions[]=['text' =>$item->item_code.' '.$item->name, 'value' => $item->id, 'gst_figure_tax_name'=>@$item->gst_figure->name];
        }
        $Voucher_no = $this->Grns->find()->select(['voucher_no'])->where(['super_admin_id'=>$user_id])->order(['voucher_no' => 'DESC'])->first();
        if($Voucher_no)
        {
            $voucher_no=$Voucher_no->voucher_no+1;
        }
        else
        { 
            $voucher_no=1;
        } 
        //$locations = $this->Grns->Locations->find('list', ['limit' => 200]);
         $partyParentGroups = $this->Grns->GrnRows->Ledgers->AccountingGroups->find()
                        ->where(['AccountingGroups.company_id'=>$company_id, 'AccountingGroups.
                        vendor'=>'1']);
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
            $Partyledgers = $this->Grns->SupplierLedgers->find()
                            ->where(['SupplierLedgers.accounting_group_id IN' =>$partyGroups,'SupplierLedgers.company_id'=>$company_id])
                            ->contain(['Suppliers']);
        }
        
        $partyOptions=[];
        foreach($Partyledgers as $Partyledger){
            $partyOptions[]=['text' =>$Partyledger->name, 'value' => $Partyledger->id];
        }
        
       
        $this->set(compact('grn','companies','voucher_no','itemOptions','partyOptions'));
        $this->set('_serialize', ['grn']);
    }
    /*public function add()
    {
        $grn = $this->Grns->newEntity();
        if ($this->request->is('post')) {
            $grn = $this->Grns->patchEntity($grn, $this->request->getData());
            if ($this->Grns->save($grn)) {
                $this->Flash->success(__('The grn has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The grn could not be saved. Please, try again.'));
        }
        $locations = $this->Grns->Locations->find('list', ['limit' => 200]);
        $orders = $this->Grns->Orders->find('list', ['limit' => 200]);
        $sellerLedgers = $this->Grns->SellerLedgers->find('list', ['limit' => 200]);
        $purchaseLedgers = $this->Grns->PurchaseLedgers->find('list', ['limit' => 200]);
        $this->set(compact('grn', 'locations', 'orders', 'sellerLedgers', 'purchaseLedgers'));
    }*/

    /**
     * Edit method
     *
     * @param string|null $id Grn id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $grn = $this->Grns->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $grn = $this->Grns->patchEntity($grn, $this->request->getData());
            if ($this->Grns->save($grn)) {
                $this->Flash->success(__('The grn has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The grn could not be saved. Please, try again.'));
        }
        $locations = $this->Grns->Locations->find('list', ['limit' => 200]);
        $orders = $this->Grns->Orders->find('list', ['limit' => 200]);
        $sellerLedgers = $this->Grns->SellerLedgers->find('list', ['limit' => 200]);
        $purchaseLedgers = $this->Grns->PurchaseLedgers->find('list', ['limit' => 200]);
        $this->set(compact('grn', 'locations', 'orders', 'sellerLedgers', 'purchaseLedgers'));
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
        if ($this->Grns->delete($grn)) {
            $this->Flash->success(__('The grn has been deleted.'));
        } else {
            $this->Flash->error(__('The grn could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
