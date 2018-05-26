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
        $this->Security->setConfig('unlockedActions', ['add']);

    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->viewBuilder()->layout('super_admin_layout');
        $company_id=$this->Auth->User('company_id');
        $user_id=$this->Auth->User('id');
        $city_id=$this->Auth->User('city_id');
        $search=$this->request->query('search');
        $this->paginate = [
            'limit' => 10
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
		 $grns = $this->Grns->find()->where(['Grns.city_id'=>$city_id,'purchase_invoice_status'=>'Pending','vendor_ledger_id'=>$ledger_id,'Grns.seller_id IS  NOT NULL '])->contain(['VendorLedgers']);
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
        $this->viewBuilder()->layout('super_admin_layout');
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
            $grn->city_id =$city_id;
            $grn->created_for ='Jainthela';
            $grn->super_admin_id =$user_id;

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
                    //$item_ledger->sale_rate = $grn_row->sale_rate;
                   // $item_ledger->company_id  =$company_id;
                    $item_ledger->city_id =$city_id;
                    $item_ledger->status ='In';
                    $item_ledger->amount=$grn_row->quantity*$grn_row->purchase_rate;
                    $this->Grns->ItemLedgers->save($item_ledger);
                    $item = $this->Grns->GrnRows->Items->find()->where(['Items.id'=>$grn_row->item_id])->first();
                    
                }
                $this->Flash->success(__('The challan has been saved.'));
                return $this->redirect(['action' => 'add']);
            }
            pr($grn);
            exit;
            $this->Flash->error(__('The challan could not be saved. Please, try again.'));
        }
        $items = $this->Grns->GrnRows->Items->SellerItems->find()->where(['SellerItems.city_id'=>$city_id,'SellerItems.seller_id IS NULL','SellerItems.status'=>'Active'])->contain(['Items']);
       
        $itemOptions=[];
        foreach($items as $item)
        {
                $itemOptions[]=['text' =>$item->item->name, 'value' => $item->item->id];
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
        
       $units = $this->Grns->Units->find()->where(['status'=>'Active'])->contain(['UnitVariations']);
       
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
