<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * BulkBookingLeads Controller
 *
 * @property \App\Model\Table\BulkBookingLeadsTable $BulkBookingLeads
 *
 * @method \App\Model\Entity\BulkBookingLead[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BulkBookingLeadsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Cities', 'Customers']
        ];
        $bulkBookingLeads = $this->paginate($this->BulkBookingLeads);

        $this->set(compact('bulkBookingLeads'));
    }

    /**
     * View method
     *
     * @param string|null $id Bulk Booking Lead id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $bulkBookingLead = $this->BulkBookingLeads->get($id, [
            'contain' => ['Cities', 'Customers', 'BulkBookingLeadRows']
        ]);

        $this->set('bulkBookingLead', $bulkBookingLead);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $bulkBookingLead = $this->BulkBookingLeads->newEntity();
        if ($this->request->is('post')) {
            $bulkBookingLead = $this->BulkBookingLeads->patchEntity($bulkBookingLead, $this->request->getData());
            if ($this->BulkBookingLeads->save($bulkBookingLead)) {
                $this->Flash->success(__('The bulk booking lead has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The bulk booking lead could not be saved. Please, try again.'));
        }
        $cities = $this->BulkBookingLeads->Cities->find('list', ['limit' => 200]);
        $customers = $this->BulkBookingLeads->Customers->find('list', ['limit' => 200]);
        $this->set(compact('bulkBookingLead', 'cities', 'customers'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Bulk Booking Lead id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $bulkBookingLead = $this->BulkBookingLeads->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $bulkBookingLead = $this->BulkBookingLeads->patchEntity($bulkBookingLead, $this->request->getData());
            if ($this->BulkBookingLeads->save($bulkBookingLead)) {
                $this->Flash->success(__('The bulk booking lead has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The bulk booking lead could not be saved. Please, try again.'));
        }
        $cities = $this->BulkBookingLeads->Cities->find('list', ['limit' => 200]);
        $customers = $this->BulkBookingLeads->Customers->find('list', ['limit' => 200]);
        $this->set(compact('bulkBookingLead', 'cities', 'customers'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Bulk Booking Lead id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $bulkBookingLead = $this->BulkBookingLeads->get($id);
        if ($this->BulkBookingLeads->delete($bulkBookingLead)) {
            $this->Flash->success(__('The bulk booking lead has been deleted.'));
        } else {
            $this->Flash->error(__('The bulk booking lead could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
