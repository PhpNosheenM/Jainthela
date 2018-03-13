<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Locations Controller
 *
 * @property \App\Model\Table\LocationsTable $Locations
 *
 * @method \App\Model\Entity\Location[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LocationsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Cities']
        ];
        $locations = $this->paginate($this->Locations);

        $this->set(compact('locations'));
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
            'contain' => ['Cities', 'AccountingEntries', 'AccountingGroups', 'Admins', 'CreditNotes', 'CustomerAddresses', 'DebitNotes', 'Drivers', 'Grns', 'GstFigures', 'JournalVouchers', 'Orders', 'Payments', 'PurchaseInvoices', 'PurchaseReturns', 'PurchaseVouchers', 'Receipts', 'ReferenceDetails', 'SaleReturns', 'SalesInvoices', 'SalesVouchers', 'Suppliers']
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
        $location = $this->Locations->newEntity();
        if ($this->request->is('post')) {
			
			$date = date('d-m-Y');
			$date = explode("-",$date);
			$this->request->data['financial_year_begins_from'] =$date[2]."-04-01";
			$this->request->data['books_beginning_from'] = $date[2]."-04-01"; 
			$fyt=$date[2]+1;
			$this->request->data['financial_year_valid_to'] = $fyt."-03-31";
			
            $location = $this->Locations->patchEntity($location, $this->request->getData());
			//pr($location); exit;
		if ($this->Locations->save($location)) {
			
            
                $this->Flash->success(__('The location has been saved.'));

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
        $location = $this->Locations->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $location = $this->Locations->patchEntity($location, $this->request->getData());
            if ($this->Locations->save($location)) {
                $this->Flash->success(__('The location has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The location could not be saved. Please, try again.'));
        }
        $cities = $this->Locations->Cities->find('list', ['limit' => 200]);
        $this->set(compact('location', 'cities'));
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
