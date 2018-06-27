<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * PurchaseReturns Controller
 *
 * @property \App\Model\Table\PurchaseReturnsTable $PurchaseReturns
 *
 * @method \App\Model\Entity\PurchaseReturn[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PurchaseReturnsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['PurchaseInvoices', 'FinancialYears', 'Locations', 'SellerLedgers', 'PurchaseLedgers', 'Cities']
        ];
        $purchaseReturns = $this->paginate($this->PurchaseReturns);

        $this->set(compact('purchaseReturns'));
    }

    /**
     * View method
     *
     * @param string|null $id Purchase Return id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $purchaseReturn = $this->PurchaseReturns->get($id, [
            'contain' => ['PurchaseInvoices', 'FinancialYears', 'Locations', 'SellerLedgers', 'PurchaseLedgers', 'Cities', 'AccountingEntries', 'ItemLedgers', 'PurchaseReturnRows', 'ReferenceDetails']
        ]);

        $this->set('purchaseReturn', $purchaseReturn);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $purchaseReturn = $this->PurchaseReturns->newEntity();
        if ($this->request->is('post')) {
            $purchaseReturn = $this->PurchaseReturns->patchEntity($purchaseReturn, $this->request->getData());
            if ($this->PurchaseReturns->save($purchaseReturn)) {
                $this->Flash->success(__('The purchase return has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The purchase return could not be saved. Please, try again.'));
        }
        $purchaseInvoices = $this->PurchaseReturns->PurchaseInvoices->find('list', ['limit' => 200]);
        $financialYears = $this->PurchaseReturns->FinancialYears->find('list', ['limit' => 200]);
        $locations = $this->PurchaseReturns->Locations->find('list', ['limit' => 200]);
        $sellerLedgers = $this->PurchaseReturns->SellerLedgers->find('list', ['limit' => 200]);
        $purchaseLedgers = $this->PurchaseReturns->PurchaseLedgers->find('list', ['limit' => 200]);
        $cities = $this->PurchaseReturns->Cities->find('list', ['limit' => 200]);
        $this->set(compact('purchaseReturn', 'purchaseInvoices', 'financialYears', 'locations', 'sellerLedgers', 'purchaseLedgers', 'cities'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Purchase Return id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $purchaseReturn = $this->PurchaseReturns->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $purchaseReturn = $this->PurchaseReturns->patchEntity($purchaseReturn, $this->request->getData());
            if ($this->PurchaseReturns->save($purchaseReturn)) {
                $this->Flash->success(__('The purchase return has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The purchase return could not be saved. Please, try again.'));
        }
        $purchaseInvoices = $this->PurchaseReturns->PurchaseInvoices->find('list', ['limit' => 200]);
        $financialYears = $this->PurchaseReturns->FinancialYears->find('list', ['limit' => 200]);
        $locations = $this->PurchaseReturns->Locations->find('list', ['limit' => 200]);
        $sellerLedgers = $this->PurchaseReturns->SellerLedgers->find('list', ['limit' => 200]);
        $purchaseLedgers = $this->PurchaseReturns->PurchaseLedgers->find('list', ['limit' => 200]);
        $cities = $this->PurchaseReturns->Cities->find('list', ['limit' => 200]);
        $this->set(compact('purchaseReturn', 'purchaseInvoices', 'financialYears', 'locations', 'sellerLedgers', 'purchaseLedgers', 'cities'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Purchase Return id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $purchaseReturn = $this->PurchaseReturns->get($id);
        if ($this->PurchaseReturns->delete($purchaseReturn)) {
            $this->Flash->success(__('The purchase return has been deleted.'));
        } else {
            $this->Flash->error(__('The purchase return could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
