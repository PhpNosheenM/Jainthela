<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Orders Controller
 *
 * @property \App\Model\Table\OrdersTable $Orders
 *
 * @method \App\Model\Entity\Order[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class OrdersController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Locations', 'Customers', 'Drivers', 'CustomerAddresses', 'PromotionDetails', 'DeliveryCharges', 'DeliveryTimes', 'CancelReasons']
        ];
        $orders = $this->paginate($this->Orders);

        $this->set(compact('orders'));
    }

    /**
     * View method
     *
     * @param string|null $id Order id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $order = $this->Orders->get($id, [
            'contain' => ['Locations', 'Customers', 'Drivers', 'CustomerAddresses', 'PromotionDetails', 'DeliveryCharges', 'DeliveryTimes', 'CancelReasons', 'OrderDetails', 'Wallets']
        ]);

        $this->set('order', $order);
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
        $order = $this->Orders->newEntity();
		$LocationData = $this->Orders->Locations->get($location_id);
		$Voucher_no = $this->Orders->find()->select(['voucher_no'])->where(['Orders.location_id'=>$location_id])->order(['voucher_no' => 'DESC'])->first();
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
		$purchaseInvoiceVoucherNo='IN'.'/'.$year.''.$month.''.$day.'/'.$voucher_no;
		$order_no=$LocationData->alise.'/'.$purchaseInvoiceVoucherNo;
		//pr($order_no); exit;
		//pr($voucher_no); exit;
		
        if ($this->request->is('post')) {
            $order = $this->Orders->patchEntity($order, $this->request->getData());
            if ($this->Orders->save($order)) {
                $this->Flash->success(__('The order has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The order could not be saved. Please, try again.'));
        }
		
		$partyParentGroups = $this->Orders->AccountingGroups->find()
						->where(['AccountingGroups.
						purchase_invoice_party'=>'1']);

		$partyGroups=[];
		foreach($partyParentGroups as $partyParentGroup)
		{
			$accountingGroups = $this->Orders->AccountingGroups
			->find('children', ['for' => $partyParentGroup->id])->toArray();
			$partyGroups[]=$partyParentGroup->id;
			foreach($accountingGroups as $accountingGroup){
				$partyGroups[]=$accountingGroup->id;
			}
		}
		if($partyGroups)
		{  
			$Partyledgers = $this->Orders->SellerLedgers->find()
							->where(['SellerLedgers.accounting_group_id IN' =>$partyGroups])
							->contain(['Sellers'=>['Locations'=>['Cities']]]);
        }
		$partyOptions=[];
		foreach($Partyledgers as $Partyledger){ 
			$partyOptions[]=['text' =>$Partyledger->name, 'value' => $Partyledger->id,'city_id'=>$Partyledger->seller->city_id,'state_id'=>$Partyledger->seller->location->city->state_id,'bill_to_bill_accounting'=>$Partyledger->bill_to_bill_accounting,'seller_id'=>$Partyledger->seller_id];
		}
		
		
		
        $locations = $this->Orders->Locations->find('list', ['limit' => 200]);
        $customers = $this->Orders->Customers->find('list', ['limit' => 200]);
        $drivers = $this->Orders->Drivers->find('list', ['limit' => 200]);
        $customerAddresses = $this->Orders->CustomerAddresses->find('list', ['limit' => 200]);
        $promotionDetails = $this->Orders->PromotionDetails->find('list', ['limit' => 200]);
        $deliveryCharges = $this->Orders->DeliveryCharges->find('list', ['limit' => 200]);
        $deliveryTimes = $this->Orders->DeliveryTimes->find('list', ['limit' => 200]);
        $cancelReasons = $this->Orders->CancelReasons->find('list', ['limit' => 200]);
        $this->set(compact('order', 'locations', 'customers', 'drivers', 'customerAddresses', 'promotionDetails', 'deliveryCharges', 'deliveryTimes', 'cancelReasons','order_no'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Order id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $order = $this->Orders->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $order = $this->Orders->patchEntity($order, $this->request->getData());
            if ($this->Orders->save($order)) {
                $this->Flash->success(__('The order has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The order could not be saved. Please, try again.'));
        }
        $locations = $this->Orders->Locations->find('list', ['limit' => 200]);
        $customers = $this->Orders->Customers->find('list', ['limit' => 200]);
        $drivers = $this->Orders->Drivers->find('list', ['limit' => 200]);
        $customerAddresses = $this->Orders->CustomerAddresses->find('list', ['limit' => 200]);
        $promotionDetails = $this->Orders->PromotionDetails->find('list', ['limit' => 200]);
        $deliveryCharges = $this->Orders->DeliveryCharges->find('list', ['limit' => 200]);
        $deliveryTimes = $this->Orders->DeliveryTimes->find('list', ['limit' => 200]);
        $cancelReasons = $this->Orders->CancelReasons->find('list', ['limit' => 200]);
        $this->set(compact('order', 'locations', 'customers', 'drivers', 'customerAddresses', 'promotionDetails', 'deliveryCharges', 'deliveryTimes', 'cancelReasons'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Order id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $order = $this->Orders->get($id);
        if ($this->Orders->delete($order)) {
            $this->Flash->success(__('The order has been deleted.'));
        } else {
            $this->Flash->error(__('The order could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
