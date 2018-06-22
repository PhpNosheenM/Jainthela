<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * SaleReturnRows Controller
 *
 * @property \App\Model\Table\SaleReturnRowsTable $SaleReturnRows
 *
 * @method \App\Model\Entity\SaleReturnRow[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SaleReturnRowsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['SaleReturns', 'ItemVariations', 'GstFigures', 'OrderDetails']
        ];
        $saleReturnRows = $this->paginate($this->SaleReturnRows);

        $this->set(compact('saleReturnRows'));
    }

    /**
     * View method
     *
     * @param string|null $id Sale Return Row id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $saleReturnRow = $this->SaleReturnRows->get($id, [
            'contain' => ['SaleReturns', 'ItemVariations', 'GstFigures', 'OrderDetails', 'ItemLedgers']
        ]);

        $this->set('saleReturnRow', $saleReturnRow);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $saleReturnRow = $this->SaleReturnRows->newEntity();
        if ($this->request->is('post')) {
            $saleReturnRow = $this->SaleReturnRows->patchEntity($saleReturnRow, $this->request->getData());
            if ($this->SaleReturnRows->save($saleReturnRow)) {
                $this->Flash->success(__('The sale return row has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The sale return row could not be saved. Please, try again.'));
        }
        $saleReturns = $this->SaleReturnRows->SaleReturns->find('list', ['limit' => 200]);
        $itemVariations = $this->SaleReturnRows->ItemVariations->find('list', ['limit' => 200]);
        $gstFigures = $this->SaleReturnRows->GstFigures->find('list', ['limit' => 200]);
        $orderDetails = $this->SaleReturnRows->OrderDetails->find('list', ['limit' => 200]);
        $this->set(compact('saleReturnRow', 'saleReturns', 'itemVariations', 'gstFigures', 'orderDetails'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Sale Return Row id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $saleReturnRow = $this->SaleReturnRows->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $saleReturnRow = $this->SaleReturnRows->patchEntity($saleReturnRow, $this->request->getData());
            if ($this->SaleReturnRows->save($saleReturnRow)) {
                $this->Flash->success(__('The sale return row has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The sale return row could not be saved. Please, try again.'));
        }
        $saleReturns = $this->SaleReturnRows->SaleReturns->find('list', ['limit' => 200]);
        $itemVariations = $this->SaleReturnRows->ItemVariations->find('list', ['limit' => 200]);
        $gstFigures = $this->SaleReturnRows->GstFigures->find('list', ['limit' => 200]);
        $orderDetails = $this->SaleReturnRows->OrderDetails->find('list', ['limit' => 200]);
        $this->set(compact('saleReturnRow', 'saleReturns', 'itemVariations', 'gstFigures', 'orderDetails'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Sale Return Row id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $saleReturnRow = $this->SaleReturnRows->get($id);
        if ($this->SaleReturnRows->delete($saleReturnRow)) {
            $this->Flash->success(__('The sale return row has been deleted.'));
        } else {
            $this->Flash->error(__('The sale return row could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
