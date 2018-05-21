<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * StockTransferVouchers Controller
 *
 * @property \App\Model\Table\StockTransferVouchersTable $StockTransferVouchers
 *
 * @method \App\Model\Entity\StockTransferVoucher[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class StockTransferVouchersController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Grns', 'Cities', 'Locations']
        ];
        $stockTransferVouchers = $this->paginate($this->StockTransferVouchers);

        $this->set(compact('stockTransferVouchers'));
    }

    /**
     * View method
     *
     * @param string|null $id Stock Transfer Voucher id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $stockTransferVoucher = $this->StockTransferVouchers->get($id, [
            'contain' => ['Grns', 'Cities', 'Locations', 'StockTransferVoucherRows']
        ]);

        $this->set('stockTransferVoucher', $stockTransferVoucher);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $stockTransferVoucher = $this->StockTransferVouchers->newEntity();
        if ($this->request->is('post')) {
            $stockTransferVoucher = $this->StockTransferVouchers->patchEntity($stockTransferVoucher, $this->request->getData());
            if ($this->StockTransferVouchers->save($stockTransferVoucher)) {
                $this->Flash->success(__('The stock transfer voucher has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The stock transfer voucher could not be saved. Please, try again.'));
        }
        $grns = $this->StockTransferVouchers->Grns->find('list', ['limit' => 200]);
        $cities = $this->StockTransferVouchers->Cities->find('list', ['limit' => 200]);
        $locations = $this->StockTransferVouchers->Locations->find('list', ['limit' => 200]);
        $this->set(compact('stockTransferVoucher', 'grns', 'cities', 'locations'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Stock Transfer Voucher id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $stockTransferVoucher = $this->StockTransferVouchers->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $stockTransferVoucher = $this->StockTransferVouchers->patchEntity($stockTransferVoucher, $this->request->getData());
            if ($this->StockTransferVouchers->save($stockTransferVoucher)) {
                $this->Flash->success(__('The stock transfer voucher has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The stock transfer voucher could not be saved. Please, try again.'));
        }
        $grns = $this->StockTransferVouchers->Grns->find('list', ['limit' => 200]);
        $cities = $this->StockTransferVouchers->Cities->find('list', ['limit' => 200]);
        $locations = $this->StockTransferVouchers->Locations->find('list', ['limit' => 200]);
        $this->set(compact('stockTransferVoucher', 'grns', 'cities', 'locations'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Stock Transfer Voucher id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $stockTransferVoucher = $this->StockTransferVouchers->get($id);
        if ($this->StockTransferVouchers->delete($stockTransferVoucher)) {
            $this->Flash->success(__('The stock transfer voucher has been deleted.'));
        } else {
            $this->Flash->error(__('The stock transfer voucher could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
