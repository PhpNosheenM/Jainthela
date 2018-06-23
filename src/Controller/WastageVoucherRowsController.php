<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * WastageVoucherRows Controller
 *
 * @property \App\Model\Table\WastageVoucherRowsTable $WastageVoucherRows
 *
 * @method \App\Model\Entity\WastageVoucherRow[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class WastageVoucherRowsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['WastageVouchers', 'Items', 'ItemVariations']
        ];
        $wastageVoucherRows = $this->paginate($this->WastageVoucherRows);

        $this->set(compact('wastageVoucherRows'));
    }

    /**
     * View method
     *
     * @param string|null $id Wastage Voucher Row id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $wastageVoucherRow = $this->WastageVoucherRows->get($id, [
            'contain' => ['WastageVouchers', 'Items', 'ItemVariations']
        ]);

        $this->set('wastageVoucherRow', $wastageVoucherRow);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $wastageVoucherRow = $this->WastageVoucherRows->newEntity();
        if ($this->request->is('post')) {
            $wastageVoucherRow = $this->WastageVoucherRows->patchEntity($wastageVoucherRow, $this->request->getData());
            if ($this->WastageVoucherRows->save($wastageVoucherRow)) {
                $this->Flash->success(__('The wastage voucher row has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The wastage voucher row could not be saved. Please, try again.'));
        }
        $wastageVouchers = $this->WastageVoucherRows->WastageVouchers->find('list', ['limit' => 200]);
        $items = $this->WastageVoucherRows->Items->find('list', ['limit' => 200]);
        $itemVariations = $this->WastageVoucherRows->ItemVariations->find('list', ['limit' => 200]);
        $this->set(compact('wastageVoucherRow', 'wastageVouchers', 'items', 'itemVariations'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Wastage Voucher Row id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $wastageVoucherRow = $this->WastageVoucherRows->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $wastageVoucherRow = $this->WastageVoucherRows->patchEntity($wastageVoucherRow, $this->request->getData());
            if ($this->WastageVoucherRows->save($wastageVoucherRow)) {
                $this->Flash->success(__('The wastage voucher row has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The wastage voucher row could not be saved. Please, try again.'));
        }
        $wastageVouchers = $this->WastageVoucherRows->WastageVouchers->find('list', ['limit' => 200]);
        $items = $this->WastageVoucherRows->Items->find('list', ['limit' => 200]);
        $itemVariations = $this->WastageVoucherRows->ItemVariations->find('list', ['limit' => 200]);
        $this->set(compact('wastageVoucherRow', 'wastageVouchers', 'items', 'itemVariations'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Wastage Voucher Row id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $wastageVoucherRow = $this->WastageVoucherRows->get($id);
        if ($this->WastageVoucherRows->delete($wastageVoucherRow)) {
            $this->Flash->success(__('The wastage voucher row has been deleted.'));
        } else {
            $this->Flash->error(__('The wastage voucher row could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
