<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\View\View;

/**
 * Customers Controller
 *
 * @property \App\Model\Table\CustomersTable $Customers
 *
 * @method \App\Model\Entity\Customer[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CustomersController extends AppController
{

	public function beforeFilter(Event $event)
	{
		parent::beforeFilter($event);
		 $this->Security->setConfig('unlockedActions', ['add','index','edit','delete','view']);
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
		$this->viewBuilder()->layout('admin_portal');
        $this->paginate = [
            'contain' => ['Cities'],
			'limit' => 20
        ];
		$customers = $this->Customers->find()->where(['Customers.city_id'=>$city_id]);

		if ($this->request->is(['get'])){
			$search=$this->request->getQuery('search');
			$customers->where([
							'OR' => [
									'Customers.name LIKE' => $search.'%',
									'Customers.status LIKE' => $search.'%',
									'Customers.firm_name LIKE' => $search.'%',
									'Customers.email LIKE' => $search.'%',
									'Customers.username LIKE' => $search.'%',
									'Customers.gstin LIKE' => $search.'%',
									'Customers.gstin_holder_name LIKE' => $search.'%'
							]
			]);
		}
		$customers = $this->paginate($customers);
		$paginate_limit=$this->paginate['limit'];
        $this->set(compact('customers','paginate_limit'));
    }

    /**
     * View method
     *
     * @param string|null $id Customer id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $customer = $this->Customers->get($id, [
            'contain' => ['Cities', 'AppNotificationCustomers', 'BulkBookingLeads', 'Carts', 'CustomerAddresses', 'Feedbacks', 'Ledgers', 'Orders', 'ReferenceDetails', 'SaleReturns', 'SalesInvoices', 'SellerRatings', 'Wallets']
        ]);

        $this->set('customer', $customer);
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
		$this->viewBuilder()->layout('admin_portal');
        $customer = $this->Customers->newEntity();
        if ($this->request->is('post')) {

            $customer = $this->Customers->patchEntity($customer, $this->request->getData());
			$customer->city_id=$city_id;
			$customer->created_by=$user_id;
            if ($this->Customers->save($customer)) {
				if(!empty($customer->gstin)){
					$accounting_group = $this->Customers->Ledgers->AccountingGroups->find()->where(['customer'=>1])->first();
					$ledger = $this->Customers->Ledgers->newEntity();
					$ledger->name = $customer->name;
					$ledger->accounting_group_id = $accounting_group->id;
					$ledger->customer_id=$customer->id;
					$ledger->bill_to_bill_accounting='yes';
					$this->Customers->Ledgers->save($ledger);
				}
				$this->Flash->success(__('The customer has been saved.'));
				return $this->redirect(['action' => 'index']);
            }
  
            $this->Flash->error(__('The customer could not be saved. Please, try again.'));
        }
		$this->set(compact('customer', 'city_id','location_id'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Customer id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
  		$user_id=$this->Auth->User('id');
  		$city_id=$this->Auth->User('city_id');
  		$location_id=$this->Auth->User('location_id');
  		$this->viewBuilder()->layout('admin_portal');
        $customer = $this->Customers->get($id, [
            'contain' => ['CustomerAddresses']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {

            $customer = $this->Customers->patchEntity($customer, $this->request->getData());
			         $customer->edited_by = $user_id;
					 
            if ($this->Customers->save($customer)) {
                $this->Flash->success(__('The customer has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The customer could not be saved. Please, try again.'));
        }

        $this->set(compact('customer', 'city_id','location_id'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Customer id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $customer = $this->Customers->get($id);
        if ($this->Customers->delete($customer)) {
            $this->Flash->success(__('The customer has been deleted.'));
        } else {
            $this->Flash->error(__('The customer could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
