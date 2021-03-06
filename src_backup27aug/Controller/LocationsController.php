<?php
namespace App\Controller;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\View\View;
/**
 * Locations Controller
 *
 * @property \App\Model\Table\LocationsTable $Locations
 *
 * @method \App\Model\Entity\Location[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LocationsController extends AppController
{

	public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Security->setConfig('unlockedActions', ['add','edit','index']);

    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index($ids = null)
    {
		if($ids)
		{
		   $id = $this->EncryptingDecrypting->decryptData($ids);
		}
		
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id');
		$this->viewBuilder()->layout('super_admin_layout');
		$this->paginate = [
			'limit' => 100
        ];
		
		$city_id=$this->Auth->User('city_id');
		$user_id=$this->Auth->User('id');
		$user_type=$this->Auth->User('user_type');
		if($user_type=='Super Admin'){
			$this->viewBuilder()->layout('super_admin_layout');
		}else if($user_type=='Admin'){
			$this->viewBuilder()->layout('admin_portal');
		}
        
		
        $locations =$this->Locations->find()->where(['Locations.city_id'=>$city_id]);
		if($ids)
		{
			$location = $this->Locations->get($id);
		}
		else{
			$location = $this->Locations->newEntity();
		}
		
		if ($this->request->is(['post','put'])) {
			 
			
            $location = $this->Locations->patchEntity($location, $this->request->getData());
			 

			$location->city_id=$city_id;
			$location->created_by=$user_id;
			 
			 
            if ($location_data=$this->Locations->save($location)) {
				
				$data = $this->Locations->Sellers->newEntity();
				
				$data->location_id=$location_data->id;
				$data->city_id=$location_data->city_id;
				$data->name=$location_data->name;
				$data->latitude=$location_data->latitude;
				$data->longitude=$location_data->longitude;
				
				$this->Locations->Sellers->save($data);
				 
				 
                $this->Flash->success(__('The banner has been saved.'));

                 
                    return $this->redirect(['action' => 'index']);
               
            }
            $this->Flash->error(__('The banner could not be saved. Please, try again.'));
        }
		else if ($this->request->is(['get'])){
			$search=$this->request->getQuery('search');
			$locations->where([
							'OR' => [
									'Locations.name LIKE' => $search.'%',
									'Locations.alise LIKE' => $search.'%',
									'Locations.latitude LIKE' => $search.'%',
									'Locations.longitude LIKE' => $search.'%',
									'Locations.financial_year_begins_from LIKE' => $search.'%',
									'Locations.financial_year_valid_to LIKE' => $search.'%',
									'Locations.books_beginning_from LIKE' => $search.'%',
									'Locations.status LIKE' => $search.'%'
							]
			]);
		}
		
		
		$locations = $this->paginate($locations);
		$paginate_limit=$this->paginate['limit'];
        $this->set(compact('locations','location','paginate_limit'));
    }

    /**
     * View method
     *
     * @param string|null $id Location id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $location = $this->Locations->get($id, [
            'contain' => ['Cities', 'AccountingGroups', 'FinancialYears', 'GstFigures', 'Ledgers', 'AccountingEntries', 'Admins', 'CreditNotes', 'CustomerAddresses', 'DebitNotes', 'Drivers', 'Grns', 'JournalVouchers', 'Orders', 'Payments', 'PurchaseInvoices', 'PurchaseReturns', 'PurchaseVouchers', 'Receipts', 'ReferenceDetails', 'SaleReturns', 'SalesInvoices', 'SalesVouchers', 'Suppliers']
        ]);

        $this->set('location', $location);
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
		$this->viewBuilder()->layout('super_admin_layout'); 
        $location = $this->Locations->newEntity(); 
		
        if ($this->request->is('post')) {
            $location = $this->Locations->patchEntity($location, $this->request->getData());
			$location->created_by=$user_id;
			$location->city_id=$city_id;
			//$location->id=2;
		
           if ($location=$this->Locations->save($location)) {
            	
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The location could not be saved. Please, try again.'));
        }
        $cities = $this->Locations->Cities->find('list', ['limit' => 200]);
        $this->set(compact('location', 'cities'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Location id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
       $city_id=$this->Auth->User('city_id');
		$user_id=$this->Auth->User('id');
		$this->viewBuilder()->layout('super_admin_layout');
        $this->paginate = [
            'limit' => 20
        ];
		
		if($id)
		{
		   $id = $this->EncryptingDecrypting->decryptData($id);
		}
		
        $locations =$this->Locations->find()->where(['Locations.city_id'=>$city_id]);
		if($id)
		{
			$location = $this->Locations->get($id);
		}
		else{
			$location = $this->Locations->newEntity();
		}
		
		if ($this->request->is(['post','put'])) {
			 
			
            $location = $this->Locations->patchEntity($location, $this->request->getData());
			 

			$location->city_id=$city_id;
			$location->created_by=$user_id;
            if ($location_data=$this->Locations->save($location)) {
				
				$data = $this->Locations->Sellers->newEntity();
				
				$data->location_id=$location_data->id;
				$data->city_id=$location_data->city_id;
				$data->name=$location_data->name;
				$data->latitude=$location_data->latitude;
				$data->longitude=$location_data->longitude;
				
				$this->Locations->Sellers->save($data);
				 
			 
                $this->Flash->success(__('The banner has been saved.'));
 
                    return $this->redirect(['action' => 'index']);
                
            }
            $this->Flash->error(__('The banner could not be saved. Please, try again.'));
        }
		 
		
		
		$locations = $this->paginate($locations);
		$paginate_limit=$this->paginate['limit'];
        $this->set(compact('locations','location','paginate_limit'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Location id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($dir)
    {
        $this->request->allowMethod(['post', 'delete']);
		$id = $this->EncryptingDecrypting->decryptData($dir);
        $location = $this->Locations->get($id);
		$location->status='Deactive';
        if ($this->Locations->save($location)) {
            $this->Flash->success(__('The location has been deleted.'));
        } else {
            $this->Flash->error(__('The location could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
