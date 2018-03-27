<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * SellerRequests Controller
 *
 * @property \App\Model\Table\SellerRequestsTable $SellerRequests
 *
 * @method \App\Model\Entity\SellerRequest[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SellerRequestsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Sellers', 'Locations']
        ];
        $sellerRequests = $this->paginate($this->SellerRequests);

        $this->set(compact('sellerRequests'));
    }

    /**
     * View method
     *
     * @param string|null $id Seller Request id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $sellerRequest = $this->SellerRequests->get($id, [
            'contain' => ['Sellers', 'Locations', 'SellerRequestRows']
        ]);

        $this->set('sellerRequest', $sellerRequest);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $sellerRequest = $this->SellerRequests->newEntity();
        if ($this->request->is('post')) {
            $sellerRequest = $this->SellerRequests->patchEntity($sellerRequest, $this->request->getData());
            if ($this->SellerRequests->save($sellerRequest)) {
                $this->Flash->success(__('The seller request has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The seller request could not be saved. Please, try again.'));
        }
        $sellers = $this->SellerRequests->Sellers->find('list', ['limit' => 200]);
        $locations = $this->SellerRequests->Locations->find('list', ['limit' => 200]);
        $this->set(compact('sellerRequest', 'sellers', 'locations'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Seller Request id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $sellerRequest = $this->SellerRequests->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $sellerRequest = $this->SellerRequests->patchEntity($sellerRequest, $this->request->getData());
            if ($this->SellerRequests->save($sellerRequest)) {
                $this->Flash->success(__('The seller request has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The seller request could not be saved. Please, try again.'));
        }
        $sellers = $this->SellerRequests->Sellers->find('list', ['limit' => 200]);
        $locations = $this->SellerRequests->Locations->find('list', ['limit' => 200]);
        $this->set(compact('sellerRequest', 'sellers', 'locations'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Seller Request id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $sellerRequest = $this->SellerRequests->get($id);
        if ($this->SellerRequests->delete($sellerRequest)) {
            $this->Flash->success(__('The seller request has been deleted.'));
        } else {
            $this->Flash->error(__('The seller request could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
