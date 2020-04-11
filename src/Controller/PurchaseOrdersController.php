<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\View\View;
/**
 * PurchaseOrders Controller
 *
 * @property \App\Model\Table\PurchaseOrdersTable $PurchaseOrders
 *
 * @method \App\Model\Entity\PurchaseOrder[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PurchaseOrdersController extends AppController
{
	

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
	 
	  public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Security->setConfig('unlockedActions', ['add']);

    }
    public function index()
    {
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id'); 
		$state_id=$this->Auth->User('state_id'); 
		$financial_year_id=$this->Auth->User('financial_year_id');
		$this->viewBuilder()->layout('super_admin_layout');
        $this->paginate = [
            'contain' => ['FinancialYears', 'Vendors', 'Cities']
        ];
        $purchaseOrders = $this->paginate($this->PurchaseOrders);
		
        $this->set(compact('purchaseOrders','company_details'));
    }

    /**
     * View method
     *
     * @param string|null $id Purchase Order id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id'); 
		$state_id=$this->Auth->User('state_id'); 
		$financial_year_id=$this->Auth->User('financial_year_id');
		$this->viewBuilder()->layout('super_admin_layout');
		
		$id = $this->EncryptingDecrypting->decryptData($id);
		$purchaseOrder = $this->PurchaseOrders->get($id, [
            'contain' => ['FinancialYears', 'Vendors', 'Cities', 'PurchaseOrderRows'=>['ItemVariations'=>['UnitVariations','Items']]]
        ]);
		$company_details=$this->PurchaseOrders->Companies->find()->where(['Companies.city_id'=>$city_id])->first();
		
		$this->set(compact('purchaseOrder','company_details'));
        $this->set('purchaseOrder', $purchaseOrder);
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
		$state_id=$this->Auth->User('state_id'); 
		$financial_year_id=$this->Auth->User('financial_year_id');
		$this->viewBuilder()->layout('super_admin_layout');
		
        $purchaseOrder = $this->PurchaseOrders->newEntity();
        if ($this->request->is('post')) {
            $purchaseOrder = $this->PurchaseOrders->patchEntity($purchaseOrder, $this->request->getData());
			
			$CityData = $this->PurchaseOrders->Cities->get($city_id);
			$StateData = $this->PurchaseOrders->Cities->States->get($CityData->state_id);
		
			$Voucher_no = $this->PurchaseOrders->find()->select(['order_no'])->where(['PurchaseOrders.city_id'=>$city_id,'PurchaseOrders.financial_year_id'=>$financial_year_id])->order(['order_no' => 'DESC'])->first();
			
			if($Voucher_no){$voucher_no=$Voucher_no->order_no+1;}
			else{$voucher_no=1;}
			//pr($voucher_no); exit;
			$new_order_no=$voucher_no;
			$order_no=$CityData->alise_name.'/PO/'.$voucher_no;
			$voucher_no=$StateData->alias_name.'/'.$order_no;
			$purchaseOrder->voucher_no=$voucher_no;
			$purchaseOrder->order_no=$new_order_no;
			$purchaseOrder->financial_year_id=$financial_year_id;
			$purchaseOrder->city_id=$city_id;
			
			$purchaseOrder->transaction_date=date('Y-m-d',strtotime($this->request->getData()['transaction_date']));
			
			
			
            if ($this->PurchaseOrders->save($purchaseOrder)) { 
                $this->Flash->success(__('The purchase order has been saved.'));

                return $this->redirect(['action' => 'index']);
            }else{ pr($purchaseOrder); exit;
				$this->Flash->error(__('The purchase order could not be saved. Please, try again.'));
			}
        }
        $financialYears = $this->PurchaseOrders->FinancialYears->find('list', ['limit' => 200]);
        $vendors = $this->PurchaseOrders->Vendors->find('list', ['limit' => 200]);
        $locations = $this->PurchaseOrders->Locations->find('list', ['limit' => 200]);
        $cities = $this->PurchaseOrders->Cities->find('list', ['limit' => 200]);
		
		$itemList=$this->PurchaseOrders->PurchaseOrderRows->Items->find()->contain(['ItemVariations'=> function ($q) use($city_id){
								return $q 
								->where(['ItemVariations.seller_id IS NULL','ItemVariations.city_id '=>$city_id])->contain(['UnitVariations'=>['Units']]);
								}])->order(['Items.name' => 'ASC']);;
		//pr($itemList->toArray()); exit;
		$items=array();
		foreach($itemList as $data1){ 
			foreach($data1->item_variations as $data){
				
				$merge=$data1->name.'('.@$data->unit_variation->visible_variation.')';
				$items[]=['text' => $merge,'value' => $data->id,'item_id'=>$data1->id,'unit'=>@$data->unit_variation->unit->unit_name,'commission'=>@$data->commission,'sale_rate'=>$data->sales_rate,'mrp'=>$data->mrp];
			}
		}
		
		
        $this->set(compact('purchaseOrder', 'financialYears', 'vendors', 'locations', 'cities','items'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Purchase Order id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $purchaseOrder = $this->PurchaseOrders->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $purchaseOrder = $this->PurchaseOrders->patchEntity($purchaseOrder, $this->request->getData());
            if ($this->PurchaseOrders->save($purchaseOrder)) {
                $this->Flash->success(__('The purchase order has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The purchase order could not be saved. Please, try again.'));
        }
        $financialYears = $this->PurchaseOrders->FinancialYears->find('list', ['limit' => 200]);
        $vendors = $this->PurchaseOrders->Vendors->find('list', ['limit' => 200]);
        $locations = $this->PurchaseOrders->Locations->find('list', ['limit' => 200]);
        $cities = $this->PurchaseOrders->Cities->find('list', ['limit' => 200]);
        $this->set(compact('purchaseOrder', 'financialYears', 'vendors', 'locations', 'cities'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Purchase Order id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $purchaseOrder = $this->PurchaseOrders->get($id);
        if ($this->PurchaseOrders->delete($purchaseOrder)) {
            $this->Flash->success(__('The purchase order has been deleted.'));
        } else {
            $this->Flash->error(__('The purchase order could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
