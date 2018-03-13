<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ReferenceDetails Controller
 *
 * @property \App\Model\Table\ReferenceDetailsTable $ReferenceDetails
 *
 * @method \App\Model\Entity\ReferenceDetail[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ReferenceDetailsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Customers', 'Suppliers', 'Locations', 'Ledgers', 'Receipts', 'ReceiptRows', 'PaymentRows', 'CreditNotes', 'CreditNoteRows', 'DebitNotes', 'DebitNoteRows', 'SalesVoucherRows', 'PurchaseVoucherRows', 'JournalVoucherRows', 'SaleReturns', 'PurchaseInvoices', 'PurchaseReturns', 'SalesInvoices']
        ];
        $referenceDetails = $this->paginate($this->ReferenceDetails);

        $this->set(compact('referenceDetails'));
    }

    /**
     * View method
     *
     * @param string|null $id Reference Detail id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $referenceDetail = $this->ReferenceDetails->get($id, [
            'contain' => ['Customers', 'Suppliers', 'Locations', 'Ledgers', 'Receipts', 'ReceiptRows', 'PaymentRows', 'CreditNotes', 'CreditNoteRows', 'DebitNotes', 'DebitNoteRows', 'SalesVoucherRows', 'PurchaseVoucherRows', 'JournalVoucherRows', 'SaleReturns', 'PurchaseInvoices', 'PurchaseReturns', 'SalesInvoices']
        ]);

        $this->set('referenceDetail', $referenceDetail);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $referenceDetail = $this->ReferenceDetails->newEntity();
        if ($this->request->is('post')) {
            $referenceDetail = $this->ReferenceDetails->patchEntity($referenceDetail, $this->request->getData());
            if ($this->ReferenceDetails->save($referenceDetail)) {
                $this->Flash->success(__('The reference detail has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The reference detail could not be saved. Please, try again.'));
        }
        $customers = $this->ReferenceDetails->Customers->find('list', ['limit' => 200]);
        $suppliers = $this->ReferenceDetails->Suppliers->find('list', ['limit' => 200]);
        $locations = $this->ReferenceDetails->Locations->find('list', ['limit' => 200]);
        $ledgers = $this->ReferenceDetails->Ledgers->find('list', ['limit' => 200]);
        $receipts = $this->ReferenceDetails->Receipts->find('list', ['limit' => 200]);
        $receiptRows = $this->ReferenceDetails->ReceiptRows->find('list', ['limit' => 200]);
        $paymentRows = $this->ReferenceDetails->PaymentRows->find('list', ['limit' => 200]);
        $creditNotes = $this->ReferenceDetails->CreditNotes->find('list', ['limit' => 200]);
        $creditNoteRows = $this->ReferenceDetails->CreditNoteRows->find('list', ['limit' => 200]);
        $debitNotes = $this->ReferenceDetails->DebitNotes->find('list', ['limit' => 200]);
        $debitNoteRows = $this->ReferenceDetails->DebitNoteRows->find('list', ['limit' => 200]);
        $salesVoucherRows = $this->ReferenceDetails->SalesVoucherRows->find('list', ['limit' => 200]);
        $purchaseVoucherRows = $this->ReferenceDetails->PurchaseVoucherRows->find('list', ['limit' => 200]);
        $journalVoucherRows = $this->ReferenceDetails->JournalVoucherRows->find('list', ['limit' => 200]);
        $saleReturns = $this->ReferenceDetails->SaleReturns->find('list', ['limit' => 200]);
        $purchaseInvoices = $this->ReferenceDetails->PurchaseInvoices->find('list', ['limit' => 200]);
        $purchaseReturns = $this->ReferenceDetails->PurchaseReturns->find('list', ['limit' => 200]);
        $salesInvoices = $this->ReferenceDetails->SalesInvoices->find('list', ['limit' => 200]);
        $this->set(compact('referenceDetail', 'customers', 'suppliers', 'locations', 'ledgers', 'receipts', 'receiptRows', 'paymentRows', 'creditNotes', 'creditNoteRows', 'debitNotes', 'debitNoteRows', 'salesVoucherRows', 'purchaseVoucherRows', 'journalVoucherRows', 'saleReturns', 'purchaseInvoices', 'purchaseReturns', 'salesInvoices'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Reference Detail id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $referenceDetail = $this->ReferenceDetails->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $referenceDetail = $this->ReferenceDetails->patchEntity($referenceDetail, $this->request->getData());
            if ($this->ReferenceDetails->save($referenceDetail)) {
                $this->Flash->success(__('The reference detail has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The reference detail could not be saved. Please, try again.'));
        }
        $customers = $this->ReferenceDetails->Customers->find('list', ['limit' => 200]);
        $suppliers = $this->ReferenceDetails->Suppliers->find('list', ['limit' => 200]);
        $locations = $this->ReferenceDetails->Locations->find('list', ['limit' => 200]);
        $ledgers = $this->ReferenceDetails->Ledgers->find('list', ['limit' => 200]);
        $receipts = $this->ReferenceDetails->Receipts->find('list', ['limit' => 200]);
        $receiptRows = $this->ReferenceDetails->ReceiptRows->find('list', ['limit' => 200]);
        $paymentRows = $this->ReferenceDetails->PaymentRows->find('list', ['limit' => 200]);
        $creditNotes = $this->ReferenceDetails->CreditNotes->find('list', ['limit' => 200]);
        $creditNoteRows = $this->ReferenceDetails->CreditNoteRows->find('list', ['limit' => 200]);
        $debitNotes = $this->ReferenceDetails->DebitNotes->find('list', ['limit' => 200]);
        $debitNoteRows = $this->ReferenceDetails->DebitNoteRows->find('list', ['limit' => 200]);
        $salesVoucherRows = $this->ReferenceDetails->SalesVoucherRows->find('list', ['limit' => 200]);
        $purchaseVoucherRows = $this->ReferenceDetails->PurchaseVoucherRows->find('list', ['limit' => 200]);
        $journalVoucherRows = $this->ReferenceDetails->JournalVoucherRows->find('list', ['limit' => 200]);
        $saleReturns = $this->ReferenceDetails->SaleReturns->find('list', ['limit' => 200]);
        $purchaseInvoices = $this->ReferenceDetails->PurchaseInvoices->find('list', ['limit' => 200]);
        $purchaseReturns = $this->ReferenceDetails->PurchaseReturns->find('list', ['limit' => 200]);
        $salesInvoices = $this->ReferenceDetails->SalesInvoices->find('list', ['limit' => 200]);
        $this->set(compact('referenceDetail', 'customers', 'suppliers', 'locations', 'ledgers', 'receipts', 'receiptRows', 'paymentRows', 'creditNotes', 'creditNoteRows', 'debitNotes', 'debitNoteRows', 'salesVoucherRows', 'purchaseVoucherRows', 'journalVoucherRows', 'saleReturns', 'purchaseInvoices', 'purchaseReturns', 'salesInvoices'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Reference Detail id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $referenceDetail = $this->ReferenceDetails->get($id);
        if ($this->ReferenceDetails->delete($referenceDetail)) {
            $this->Flash->success(__('The reference detail has been deleted.'));
        } else {
            $this->Flash->error(__('The reference detail could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
