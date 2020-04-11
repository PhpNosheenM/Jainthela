<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * InvoiceRows Controller
 *
 * @property \App\Model\Table\InvoiceRowsTable $InvoiceRows
 *
 * @method \App\Model\Entity\InvoiceRow[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class InvoiceRowsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Invoices', 'OrderDetails', 'Items', 'ItemVariations', 'ComboOffers', 'GstFigures']
        ];
        $invoiceRows = $this->paginate($this->InvoiceRows);

        $this->set(compact('invoiceRows'));
    }

    /**
     * View method
     *
     * @param string|null $id Invoice Row id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $invoiceRow = $this->InvoiceRows->get($id, [
            'contain' => ['Invoices', 'OrderDetails', 'Items', 'ItemVariations', 'ComboOffers', 'GstFigures']
        ]);

        $this->set('invoiceRow', $invoiceRow);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $invoiceRow = $this->InvoiceRows->newEntity();
        if ($this->request->is('post')) {
            $invoiceRow = $this->InvoiceRows->patchEntity($invoiceRow, $this->request->getData());
            if ($this->InvoiceRows->save($invoiceRow)) {
                $this->Flash->success(__('The invoice row has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The invoice row could not be saved. Please, try again.'));
        }
        $invoices = $this->InvoiceRows->Invoices->find('list', ['limit' => 200]);
        $orderDetails = $this->InvoiceRows->OrderDetails->find('list', ['limit' => 200]);
        $items = $this->InvoiceRows->Items->find('list', ['limit' => 200]);
        $itemVariations = $this->InvoiceRows->ItemVariations->find('list', ['limit' => 200]);
        $comboOffers = $this->InvoiceRows->ComboOffers->find('list', ['limit' => 200]);
        $gstFigures = $this->InvoiceRows->GstFigures->find('list', ['limit' => 200]);
        $this->set(compact('invoiceRow', 'invoices', 'orderDetails', 'items', 'itemVariations', 'comboOffers', 'gstFigures'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Invoice Row id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $invoiceRow = $this->InvoiceRows->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $invoiceRow = $this->InvoiceRows->patchEntity($invoiceRow, $this->request->getData());
            if ($this->InvoiceRows->save($invoiceRow)) {
                $this->Flash->success(__('The invoice row has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The invoice row could not be saved. Please, try again.'));
        }
        $invoices = $this->InvoiceRows->Invoices->find('list', ['limit' => 200]);
        $orderDetails = $this->InvoiceRows->OrderDetails->find('list', ['limit' => 200]);
        $items = $this->InvoiceRows->Items->find('list', ['limit' => 200]);
        $itemVariations = $this->InvoiceRows->ItemVariations->find('list', ['limit' => 200]);
        $comboOffers = $this->InvoiceRows->ComboOffers->find('list', ['limit' => 200]);
        $gstFigures = $this->InvoiceRows->GstFigures->find('list', ['limit' => 200]);
        $this->set(compact('invoiceRow', 'invoices', 'orderDetails', 'items', 'itemVariations', 'comboOffers', 'gstFigures'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Invoice Row id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $invoiceRow = $this->InvoiceRows->get($id);
        if ($this->InvoiceRows->delete($invoiceRow)) {
            $this->Flash->success(__('The invoice row has been deleted.'));
        } else {
            $this->Flash->error(__('The invoice row could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
