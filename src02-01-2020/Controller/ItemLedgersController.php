<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ItemLedgers Controller
 *
 * @property \App\Model\Table\ItemLedgersTable $ItemLedgers
 *
 * @method \App\Model\Entity\ItemLedger[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ItemLedgersController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Items', 'ItemVariations', 'SalesInvoices', 'SalesInvoiceRows', 'Locations', 'CreditNotes', 'CreditNoteRows', 'SaleReturns', 'SaleReturnRows', 'PurchaseInvoices', 'PurchaseInvoiceRows', 'PurchaseReturns', 'PurchaseReturnRows', 'Cities']
        ];
        $itemLedgers = $this->paginate($this->ItemLedgers);

        $this->set(compact('itemLedgers'));
    }

    /**
     * View method
     *
     * @param string|null $id Item Ledger id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $itemLedger = $this->ItemLedgers->get($id, [
            'contain' => ['Items', 'ItemVariations', 'SalesInvoices', 'SalesInvoiceRows', 'Locations', 'CreditNotes', 'CreditNoteRows', 'SaleReturns', 'SaleReturnRows', 'PurchaseInvoices', 'PurchaseInvoiceRows', 'PurchaseReturns', 'PurchaseReturnRows', 'Cities']
        ]);

        $this->set('itemLedger', $itemLedger);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $itemLedger = $this->ItemLedgers->newEntity();
        if ($this->request->is('post')) {
            $itemLedger = $this->ItemLedgers->patchEntity($itemLedger, $this->request->getData());
            if ($this->ItemLedgers->save($itemLedger)) {
                $this->Flash->success(__('The item ledger has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The item ledger could not be saved. Please, try again.'));
        }
        $items = $this->ItemLedgers->Items->find('list', ['limit' => 200]);
        $itemVariations = $this->ItemLedgers->ItemVariations->find('list', ['limit' => 200]);
        $salesInvoices = $this->ItemLedgers->SalesInvoices->find('list', ['limit' => 200]);
        $salesInvoiceRows = $this->ItemLedgers->SalesInvoiceRows->find('list', ['limit' => 200]);
        $locations = $this->ItemLedgers->Locations->find('list', ['limit' => 200]);
        $creditNotes = $this->ItemLedgers->CreditNotes->find('list', ['limit' => 200]);
        $creditNoteRows = $this->ItemLedgers->CreditNoteRows->find('list', ['limit' => 200]);
        $saleReturns = $this->ItemLedgers->SaleReturns->find('list', ['limit' => 200]);
        $saleReturnRows = $this->ItemLedgers->SaleReturnRows->find('list', ['limit' => 200]);
        $purchaseInvoices = $this->ItemLedgers->PurchaseInvoices->find('list', ['limit' => 200]);
        $purchaseInvoiceRows = $this->ItemLedgers->PurchaseInvoiceRows->find('list', ['limit' => 200]);
        $purchaseReturns = $this->ItemLedgers->PurchaseReturns->find('list', ['limit' => 200]);
        $purchaseReturnRows = $this->ItemLedgers->PurchaseReturnRows->find('list', ['limit' => 200]);
        $cities = $this->ItemLedgers->Cities->find('list', ['limit' => 200]);
        $this->set(compact('itemLedger', 'items', 'itemVariations', 'salesInvoices', 'salesInvoiceRows', 'locations', 'creditNotes', 'creditNoteRows', 'saleReturns', 'saleReturnRows', 'purchaseInvoices', 'purchaseInvoiceRows', 'purchaseReturns', 'purchaseReturnRows', 'cities'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Item Ledger id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $itemLedger = $this->ItemLedgers->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $itemLedger = $this->ItemLedgers->patchEntity($itemLedger, $this->request->getData());
            if ($this->ItemLedgers->save($itemLedger)) {
                $this->Flash->success(__('The item ledger has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The item ledger could not be saved. Please, try again.'));
        }
        $items = $this->ItemLedgers->Items->find('list', ['limit' => 200]);
        $itemVariations = $this->ItemLedgers->ItemVariations->find('list', ['limit' => 200]);
        $salesInvoices = $this->ItemLedgers->SalesInvoices->find('list', ['limit' => 200]);
        $salesInvoiceRows = $this->ItemLedgers->SalesInvoiceRows->find('list', ['limit' => 200]);
        $locations = $this->ItemLedgers->Locations->find('list', ['limit' => 200]);
        $creditNotes = $this->ItemLedgers->CreditNotes->find('list', ['limit' => 200]);
        $creditNoteRows = $this->ItemLedgers->CreditNoteRows->find('list', ['limit' => 200]);
        $saleReturns = $this->ItemLedgers->SaleReturns->find('list', ['limit' => 200]);
        $saleReturnRows = $this->ItemLedgers->SaleReturnRows->find('list', ['limit' => 200]);
        $purchaseInvoices = $this->ItemLedgers->PurchaseInvoices->find('list', ['limit' => 200]);
        $purchaseInvoiceRows = $this->ItemLedgers->PurchaseInvoiceRows->find('list', ['limit' => 200]);
        $purchaseReturns = $this->ItemLedgers->PurchaseReturns->find('list', ['limit' => 200]);
        $purchaseReturnRows = $this->ItemLedgers->PurchaseReturnRows->find('list', ['limit' => 200]);
        $cities = $this->ItemLedgers->Cities->find('list', ['limit' => 200]);
        $this->set(compact('itemLedger', 'items', 'itemVariations', 'salesInvoices', 'salesInvoiceRows', 'locations', 'creditNotes', 'creditNoteRows', 'saleReturns', 'saleReturnRows', 'purchaseInvoices', 'purchaseInvoiceRows', 'purchaseReturns', 'purchaseReturnRows', 'cities'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Item Ledger id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $itemLedger = $this->ItemLedgers->get($id);
        if ($this->ItemLedgers->delete($itemLedger)) {
            $this->Flash->success(__('The item ledger has been deleted.'));
        } else {
            $this->Flash->error(__('The item ledger could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
