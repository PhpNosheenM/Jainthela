<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * SalesOrderRows Controller
 *
 * @property \App\Model\Table\SalesOrderRowsTable $SalesOrderRows
 *
 * @method \App\Model\Entity\SalesOrderRow[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SalesOrderRowsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['SalesOrders', 'Items', 'ItemVariations', 'ComboOffers', 'GstFigures']
        ];
        $salesOrderRows = $this->paginate($this->SalesOrderRows);

        $this->set(compact('salesOrderRows'));
    }

    /**
     * View method
     *
     * @param string|null $id Sales Order Row id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $salesOrderRow = $this->SalesOrderRows->get($id, [
            'contain' => ['SalesOrders', 'Items', 'ItemVariations', 'ComboOffers', 'GstFigures']
        ]);

        $this->set('salesOrderRow', $salesOrderRow);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $salesOrderRow = $this->SalesOrderRows->newEntity();
        if ($this->request->is('post')) {
            $salesOrderRow = $this->SalesOrderRows->patchEntity($salesOrderRow, $this->request->getData());
            if ($this->SalesOrderRows->save($salesOrderRow)) {
                $this->Flash->success(__('The sales order row has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The sales order row could not be saved. Please, try again.'));
        }
        $salesOrders = $this->SalesOrderRows->SalesOrders->find('list', ['limit' => 200]);
        $items = $this->SalesOrderRows->Items->find('list', ['limit' => 200]);
        $itemVariations = $this->SalesOrderRows->ItemVariations->find('list', ['limit' => 200]);
        $comboOffers = $this->SalesOrderRows->ComboOffers->find('list', ['limit' => 200]);
        $gstFigures = $this->SalesOrderRows->GstFigures->find('list', ['limit' => 200]);
        $this->set(compact('salesOrderRow', 'salesOrders', 'items', 'itemVariations', 'comboOffers', 'gstFigures'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Sales Order Row id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $salesOrderRow = $this->SalesOrderRows->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $salesOrderRow = $this->SalesOrderRows->patchEntity($salesOrderRow, $this->request->getData());
            if ($this->SalesOrderRows->save($salesOrderRow)) {
                $this->Flash->success(__('The sales order row has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The sales order row could not be saved. Please, try again.'));
        }
        $salesOrders = $this->SalesOrderRows->SalesOrders->find('list', ['limit' => 200]);
        $items = $this->SalesOrderRows->Items->find('list', ['limit' => 200]);
        $itemVariations = $this->SalesOrderRows->ItemVariations->find('list', ['limit' => 200]);
        $comboOffers = $this->SalesOrderRows->ComboOffers->find('list', ['limit' => 200]);
        $gstFigures = $this->SalesOrderRows->GstFigures->find('list', ['limit' => 200]);
        $this->set(compact('salesOrderRow', 'salesOrders', 'items', 'itemVariations', 'comboOffers', 'gstFigures'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Sales Order Row id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $salesOrderRow = $this->SalesOrderRows->get($id);
        if ($this->SalesOrderRows->delete($salesOrderRow)) {
            $this->Flash->success(__('The sales order row has been deleted.'));
        } else {
            $this->Flash->error(__('The sales order row could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
