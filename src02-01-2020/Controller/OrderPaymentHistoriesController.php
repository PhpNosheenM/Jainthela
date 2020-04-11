<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * OrderPaymentHistories Controller
 *
 * @property \App\Model\Table\OrderPaymentHistoriesTable $OrderPaymentHistories
 *
 * @method \App\Model\Entity\OrderPaymentHistory[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class OrderPaymentHistoriesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Orders', 'Invoices']
        ];
        $orderPaymentHistories = $this->paginate($this->OrderPaymentHistories);

        $this->set(compact('orderPaymentHistories'));
    }

    /**
     * View method
     *
     * @param string|null $id Order Payment History id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $orderPaymentHistory = $this->OrderPaymentHistories->get($id, [
            'contain' => ['Orders', 'Invoices']
        ]);

        $this->set('orderPaymentHistory', $orderPaymentHistory);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $orderPaymentHistory = $this->OrderPaymentHistories->newEntity();
        if ($this->request->is('post')) {
            $orderPaymentHistory = $this->OrderPaymentHistories->patchEntity($orderPaymentHistory, $this->request->getData());
            if ($this->OrderPaymentHistories->save($orderPaymentHistory)) {
                $this->Flash->success(__('The order payment history has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The order payment history could not be saved. Please, try again.'));
        }
        $orders = $this->OrderPaymentHistories->Orders->find('list', ['limit' => 200]);
        $invoices = $this->OrderPaymentHistories->Invoices->find('list', ['limit' => 200]);
        $this->set(compact('orderPaymentHistory', 'orders', 'invoices'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Order Payment History id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $orderPaymentHistory = $this->OrderPaymentHistories->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $orderPaymentHistory = $this->OrderPaymentHistories->patchEntity($orderPaymentHistory, $this->request->getData());
            if ($this->OrderPaymentHistories->save($orderPaymentHistory)) {
                $this->Flash->success(__('The order payment history has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The order payment history could not be saved. Please, try again.'));
        }
        $orders = $this->OrderPaymentHistories->Orders->find('list', ['limit' => 200]);
        $invoices = $this->OrderPaymentHistories->Invoices->find('list', ['limit' => 200]);
        $this->set(compact('orderPaymentHistory', 'orders', 'invoices'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Order Payment History id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $orderPaymentHistory = $this->OrderPaymentHistories->get($id);
        if ($this->OrderPaymentHistories->delete($orderPaymentHistory)) {
            $this->Flash->success(__('The order payment history has been deleted.'));
        } else {
            $this->Flash->error(__('The order payment history could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
