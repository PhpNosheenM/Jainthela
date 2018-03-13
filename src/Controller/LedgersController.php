<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Ledgers Controller
 *
 * @property \App\Model\Table\LedgersTable $Ledgers
 *
 * @method \App\Model\Entity\Ledger[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LedgersController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['AccountingGroups', 'Locations', 'Suppliers', 'Customers', 'GstFigures']
        ];
        $ledgers = $this->paginate($this->Ledgers);

        $this->set(compact('ledgers'));
    }

    /**
     * View method
     *
     * @param string|null $id Ledger id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $ledger = $this->Ledgers->get($id, [
            'contain' => ['AccountingGroups', 'Locations', 'Suppliers', 'Customers', 'GstFigures', 'AccountingEntries', 'CreditNoteRows', 'DebitNoteRows', 'JournalVoucherRows', 'PaymentRows', 'PurchaseVoucherRows', 'ReceiptRows', 'ReferenceDetails', 'SalesVoucherRows']
        ]);

        $this->set('ledger', $ledger);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $ledger = $this->Ledgers->newEntity();
        if ($this->request->is('post')) {
            $ledger = $this->Ledgers->patchEntity($ledger, $this->request->getData());
            if ($this->Ledgers->save($ledger)) {
                $this->Flash->success(__('The ledger has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The ledger could not be saved. Please, try again.'));
        }
        $accountingGroups = $this->Ledgers->AccountingGroups->find('list', ['limit' => 200]);
        $locations = $this->Ledgers->Locations->find('list', ['limit' => 200]);
        $suppliers = $this->Ledgers->Suppliers->find('list', ['limit' => 200]);
        $customers = $this->Ledgers->Customers->find('list', ['limit' => 200]);
        $gstFigures = $this->Ledgers->GstFigures->find('list', ['limit' => 200]);
        $this->set(compact('ledger', 'accountingGroups', 'locations', 'suppliers', 'customers', 'gstFigures'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Ledger id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $ledger = $this->Ledgers->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $ledger = $this->Ledgers->patchEntity($ledger, $this->request->getData());
            if ($this->Ledgers->save($ledger)) {
                $this->Flash->success(__('The ledger has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The ledger could not be saved. Please, try again.'));
        }
        $accountingGroups = $this->Ledgers->AccountingGroups->find('list', ['limit' => 200]);
        $locations = $this->Ledgers->Locations->find('list', ['limit' => 200]);
        $suppliers = $this->Ledgers->Suppliers->find('list', ['limit' => 200]);
        $customers = $this->Ledgers->Customers->find('list', ['limit' => 200]);
        $gstFigures = $this->Ledgers->GstFigures->find('list', ['limit' => 200]);
        $this->set(compact('ledger', 'accountingGroups', 'locations', 'suppliers', 'customers', 'gstFigures'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Ledger id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $ledger = $this->Ledgers->get($id);
        if ($this->Ledgers->delete($ledger)) {
            $this->Flash->success(__('The ledger has been deleted.'));
        } else {
            $this->Flash->error(__('The ledger could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
