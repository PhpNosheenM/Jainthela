<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Grns Controller
 *
 * @property \App\Model\Table\GrnsTable $Grns
 *
 * @method \App\Model\Entity\Grn[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class GrnsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Locations', 'Orders', 'SellerLedgers', 'PurchaseLedgers']
        ];
        $grns = $this->paginate($this->Grns);

        $this->set(compact('grns'));
    }

    /**
     * View method
     *
     * @param string|null $id Grn id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $grn = $this->Grns->get($id, [
            'contain' => ['Locations', 'Orders', 'SellerLedgers', 'PurchaseLedgers']
        ]);

        $this->set('grn', $grn);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $grn = $this->Grns->newEntity();
        if ($this->request->is('post')) {
            $grn = $this->Grns->patchEntity($grn, $this->request->getData());
            if ($this->Grns->save($grn)) {
                $this->Flash->success(__('The grn has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The grn could not be saved. Please, try again.'));
        }
        $locations = $this->Grns->Locations->find('list', ['limit' => 200]);
        $orders = $this->Grns->Orders->find('list', ['limit' => 200]);
        $sellerLedgers = $this->Grns->SellerLedgers->find('list', ['limit' => 200]);
        $purchaseLedgers = $this->Grns->PurchaseLedgers->find('list', ['limit' => 200]);
        $this->set(compact('grn', 'locations', 'orders', 'sellerLedgers', 'purchaseLedgers'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Grn id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $grn = $this->Grns->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $grn = $this->Grns->patchEntity($grn, $this->request->getData());
            if ($this->Grns->save($grn)) {
                $this->Flash->success(__('The grn has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The grn could not be saved. Please, try again.'));
        }
        $locations = $this->Grns->Locations->find('list', ['limit' => 200]);
        $orders = $this->Grns->Orders->find('list', ['limit' => 200]);
        $sellerLedgers = $this->Grns->SellerLedgers->find('list', ['limit' => 200]);
        $purchaseLedgers = $this->Grns->PurchaseLedgers->find('list', ['limit' => 200]);
        $this->set(compact('grn', 'locations', 'orders', 'sellerLedgers', 'purchaseLedgers'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Grn id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $grn = $this->Grns->get($id);
        if ($this->Grns->delete($grn)) {
            $this->Flash->success(__('The grn has been deleted.'));
        } else {
            $this->Flash->error(__('The grn could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
