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
            'contain' => ['Customers','Locations', 'Cities', 'Orders']
        ];
        $saleReturns = $this->paginate($this->SaleReturns);

        $this->set(compact('saleReturns'));
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
            'contain' => ['Customers', 'SalesLedgers', 'PartyLedgers', 'Locations', 'Cities', 'Orders', 'AccountingEntries', 'ItemLedgers', 'ReferenceDetails', 'SaleReturnRows']
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
		$this->viewBuilder()->layout('super_admin_layout');
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id');
		$location_id=$this->Auth->User('location_id');
        $saleReturn = $this->SaleReturns->newEntity();
         if ($this->request->is(['patch', 'post', 'put'])) {
            $saleReturn = $this->SaleReturns->patchEntity($saleReturn, $this->request->getData());
			pr($saleReturn); exit;
            if ($this->SaleReturns->save($saleReturn)) {
				
                $this->Flash->success(__('The sale return has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The sale return could not be saved. Please, try again.'));
        }
		
       $order = $this->SaleReturns->Orders->get($id, [
            'contain' => ['SellerLedgers','PartyLedgers','OrderDetails'=>['ItemVariations'=>['Items'=>['GstFigures']]]]
        ]);
		
		$itemList=$this->SaleReturns->Orders->Items->find()->contain(['ItemVariations'=> function ($q) {
								return $q
								->where(['ItemVariations.status'=>'Active','current_stock >'=>'0'])->contain(['UnitVariations'=>['Units']]);
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
}
