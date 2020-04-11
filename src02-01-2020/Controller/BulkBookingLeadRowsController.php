<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * BulkBookingLeadRows Controller
 *
 * @property \App\Model\Table\BulkBookingLeadRowsTable $BulkBookingLeadRows
 *
 * @method \App\Model\Entity\BulkBookingLeadRow[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BulkBookingLeadRowsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['BulkBookingLeads']
        ];
        $bulkBookingLeadRows = $this->paginate($this->BulkBookingLeadRows);

        $this->set(compact('bulkBookingLeadRows'));
    }

    /**
     * View method
     *
     * @param string|null $id Bulk Booking Lead Row id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $bulkBookingLeadRow = $this->BulkBookingLeadRows->get($id, [
            'contain' => ['BulkBookingLeads']
        ]);

        $this->set('bulkBookingLeadRow', $bulkBookingLeadRow);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $bulkBookingLeadRow = $this->BulkBookingLeadRows->newEntity();
        if ($this->request->is('post')) {
            $bulkBookingLeadRow = $this->BulkBookingLeadRows->patchEntity($bulkBookingLeadRow, $this->request->getData());
            if ($this->BulkBookingLeadRows->save($bulkBookingLeadRow)) {
                $this->Flash->success(__('The bulk booking lead row has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The bulk booking lead row could not be saved. Please, try again.'));
        }
        $bulkBookingLeads = $this->BulkBookingLeadRows->BulkBookingLeads->find('list', ['limit' => 200]);
        $this->set(compact('bulkBookingLeadRow', 'bulkBookingLeads'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Bulk Booking Lead Row id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $bulkBookingLeadRow = $this->BulkBookingLeadRows->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $bulkBookingLeadRow = $this->BulkBookingLeadRows->patchEntity($bulkBookingLeadRow, $this->request->getData());
            if ($this->BulkBookingLeadRows->save($bulkBookingLeadRow)) {
                $this->Flash->success(__('The bulk booking lead row has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The bulk booking lead row could not be saved. Please, try again.'));
        }
        $bulkBookingLeads = $this->BulkBookingLeadRows->BulkBookingLeads->find('list', ['limit' => 200]);
        $this->set(compact('bulkBookingLeadRow', 'bulkBookingLeads'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Bulk Booking Lead Row id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $bulkBookingLeadRow = $this->BulkBookingLeadRows->get($id);
        if ($this->BulkBookingLeadRows->delete($bulkBookingLeadRow)) {
            $this->Flash->success(__('The bulk booking lead row has been deleted.'));
        } else {
            $this->Flash->error(__('The bulk booking lead row could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
