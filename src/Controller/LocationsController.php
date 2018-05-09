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
        $this->Security->setConfig('unlockedActions', ['add','edit'.'index']);

    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index($id = null)
    {
		$city_id=$this->Auth->User('city_id');
		$user_id=$this->Auth->User('id');
		$this->viewBuilder()->layout('admin_portal');
        $this->paginate = [
            'limit' => 20
        ];
		
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
			$location->financial_year_begins_from=date('Y-m-d', strtotime($this->request->data['financial_year_begins_from']));
			$location->financial_year_valid_to=date('Y-m-d', strtotime($this->request->data['financial_year_valid_to']));
			$location->books_beginning_from=date('Y-m-d', strtotime($this->request->data['books_beginning_from']));
			 
            if ($location_data=$this->Locations->save($location)) {
				
				$data = $this->Locations->Sellers->newEntity();
				
				$data->location_id=$location_data->id;
				$data->city_id=$location_data->city_id;
				$data->name=$location_data->name;
				$data->latitude=$location_data->latitude;
				$data->longitude=$location_data->longitude;
				
				$this->Locations->Sellers->save($data);
				 
				pr($data); exit;
                $this->Flash->success(__('The banner has been saved.'));

                if(empty($banner_error))
                {
                 return $this->redirect(['action' => 'delete_file',$dir]);
                }
                else
                {
                    return $this->redirect(['action' => 'index']);
                }
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
		$this->viewBuilder()->layout('admin_portal'); 
        $location = $this->Locations->newEntity(); 
		
        if ($this->request->is('post')) {
            $location = $this->Locations->patchEntity($location, $this->request->getData());
			$location->created_by=$user_id;
			$location->city_id=$city_id;
		
            if ($location=$this->Locations->save($location)) {
				 
				$seller = $this->Locations->Sellers->newEntity(); 
				$seller = $this->Locations->Sellers->patchEntity($seller, $this->request->getData());
				
				$seller->location_id=$location->id;
				$seller->city_id=$location->city_id;
				$seller->name=$this->request->getData('seller_name');
				$seller->status=$this->request->getData('seller_status');

				if($this->Locations->Sellers->save($seller))
				{
					$bill_to_bill_accounting=$seller->bill_to_bill_accounting;
					$accounting_group = $this->Locations->Sellers->Ledgers->AccountingGroups->find()->where(['seller'=>1])->first();
					$ledger = $this->Locations->Sellers->Ledgers->newEntity();
					$ledger->name = $seller->firm_name;
					$ledger->accounting_group_id = $accounting_group->id;
					$ledger->seller_id=$seller->id;
					$ledger->bill_to_bill_accounting=$bill_to_bill_accounting;
					
					if($this->Locations->Sellers->Ledgers->save($ledger))
					{
						$query=$this->Locations->Sellers->ReferenceDetails->query();
							$result = $query->update()
							->set(['ledger_id' => $ledger->id])
							->where(['seller_id' => $seller->id])
							->execute();
						//Create Accounting Entry//
				        $transaction_date=$location->books_beginning_from;
						$AccountingEntry = $this->Locations->Sellers->Ledgers->AccountingEntries->newEntity();
						$AccountingEntry->ledger_id        = $ledger->id;
						if($seller->debit_credit=="Dr")
						{
							$AccountingEntry->debit        = $seller->opening_balance_value;
						}
						if($seller->debit_credit=="Cr")
						{
							$AccountingEntry->credit       = $seller->opening_balance_value;
						}
						$AccountingEntry->transaction_date = date("Y-m-d",strtotime($transaction_date));
						$AccountingEntry->location_id       = $location_id;
						$AccountingEntry->city_id       = $city_id;
						$AccountingEntry->is_opening_balance = 'yes';
						if($seller->opening_balance_value){
						$this->Locations->Sellers->Ledgers->AccountingEntries->save($AccountingEntry);
						}
					}
				}
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
		$this->viewBuilder()->layout('admin_portal');
        $this->paginate = [
            'limit' => 20
        ];
		
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
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $location = $this->Locations->get($id);
        if ($this->Locations->delete($location)) {
            $this->Flash->success(__('The location has been deleted.'));
        } else {
            $this->Flash->error(__('The location could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
