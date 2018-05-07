<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\View\View;
/**
 * Vendors Controller
 *
 * @property \App\Model\Table\VendorsTable $Vendors
 *
 * @method \App\Model\Entity\Vendor[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class VendorsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
	 
	public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Security->setConfig('unlockedActions', ['add','edit','index']);

    }
	
    public function index()
    {
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id'); 
		$location_id=$this->Auth->User('location_id'); 
		$this->viewBuilder()->layout('admin_portal'); 
        $this->paginate = [
            'limit' => 20
        ];
		$vendors = $this->Vendors->find()->where(['Vendors.city_id'=>$city_id]);
		
        if ($this->request->is(['get'])){
			$search=$this->request->getQuery('search');
			$vendors->where([
							'OR' => [
									'Vendors.name LIKE' => $search.'%',
									'Vendors.status LIKE' => $search.'%',
									'Vendors.firm_name LIKE' => $search.'%',
									'Vendors.firm_address LIKE' => $search.'%',
									'Vendors.firm_email LIKE' => $search.'%',
									'Vendors.firm_contact LIKE' => $search.'%',
									'Vendors.firm_pincode LIKE' => $search.'%',
									'Vendors.gstin LIKE' => $search.'%',
									'Vendors.gstin_holder_name LIKE' => $search.'%',
									'Vendors.registration_date' => $search.'%'
							]
			]);
		}
		
		$vendors= $this->paginate($vendors);
		$paginate_limit=$this->paginate['limit'];
        $this->set(compact('vendors','paginate_limit'));
    }

    /**
     * View method
     *
     * @param string|null $id Vendor id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $vendor = $this->Vendors->get($id, [
            'contain' => ['Cities', 'Locations', 'Ledgers', 'VendorDetails']
        ]);

        $this->set('vendor', $vendor);
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
        $vendor = $this->Vendors->newEntity();
        if ($this->request->is('post')) {
            $vendor = $this->Vendors->patchEntity($vendor, $this->request->getData());
			$vendor->city_id=$city_id;
			$vendor->created_by=$user_id;
			$registration_date=$this->request->data['registration_date'];
			$vendor->registration_date=date('Y-m-d', strtotime($registration_date));
			$bill_to_bill_accounting=$vendor->bill_to_bill_accounting;
			//$data=$this->Sellers->Locations->get($location_id);
			 
            if ($this->Vendors->save($vendor)) {
                $this->Flash->success(__('The vendor has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The vendor could not be saved. Please, try again.'));
        }
        $cities = $this->Vendors->Cities->find('list', ['limit' => 200]); 
        $this->set(compact('vendor', 'cities'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Vendor id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id'); 
		$this->viewBuilder()->layout('admin_portal');
        $vendor = $this->Vendors->get($id, [
            'contain' => ['VendorDetails']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $vendor = $this->Vendors->patchEntity($vendor, $this->request->getData());
			$vendor->city_id=$city_id;
			$vendor->created_by=$user_id;
			$registration_date=$this->request->data['registration_date'];
			$vendor->registration_date=date('Y-m-d', strtotime($registration_date));
			
            if ($this->Vendors->save($vendor)) {
                $this->Flash->success(__('The vendor has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The vendor could not be saved. Please, try again.'));
        }
        $cities = $this->Vendors->Cities->find('list', ['limit' => 200]);
        $this->set(compact('vendor', 'cities', 'locations'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Vendor id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $vendor = $this->Vendors->get($id);
        if ($this->Vendors->delete($vendor)) {
            $this->Flash->success(__('The vendor has been deleted.'));
        } else {
            $this->Flash->error(__('The vendor could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
