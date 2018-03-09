<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Sellers Controller
 *
 * @property \App\Model\Table\SellersTable $Sellers
 *
 * @method \App\Model\Entity\Seller[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SellersController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Cities', 'FirmStates', 'FirmCities']
        ];
        $sellers = $this->paginate($this->Sellers);

        $this->set(compact('sellers'));
    }

    /**
     * View method
     *
     * @param string|null $id Seller id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $seller = $this->Sellers->get($id, [
            'contain' => ['Cities', 'FirmStates', 'FirmCities', 'Items', 'SellerItems', 'SellerRatings']
        ]);

        $this->set('seller', $seller);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $seller = $this->Sellers->newEntity();
        if ($this->request->is('post')) {
            $seller = $this->Sellers->patchEntity($seller, $this->request->getData());
            if ($this->Sellers->save($seller)) {
                $this->Flash->success(__('The seller has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The seller could not be saved. Please, try again.'));
        }
        $cities = $this->Sellers->Cities->find('list', ['limit' => 200]);
        $firmStates = $this->Sellers->FirmStates->find('list', ['limit' => 200]);
        $firmCities = $this->Sellers->FirmCities->find('list', ['limit' => 200]);
        $this->set(compact('seller', 'cities', 'firmStates', 'firmCities'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Seller id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $seller = $this->Sellers->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $seller = $this->Sellers->patchEntity($seller, $this->request->getData());
            if ($this->Sellers->save($seller)) {
                $this->Flash->success(__('The seller has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The seller could not be saved. Please, try again.'));
        }
        $cities = $this->Sellers->Cities->find('list', ['limit' => 200]);
        $firmStates = $this->Sellers->FirmStates->find('list', ['limit' => 200]);
        $firmCities = $this->Sellers->FirmCities->find('list', ['limit' => 200]);
        $this->set(compact('seller', 'cities', 'firmStates', 'firmCities'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Seller id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $seller = $this->Sellers->get($id);
        if ($this->Sellers->delete($seller)) {
            $this->Flash->success(__('The seller has been deleted.'));
        } else {
            $this->Flash->error(__('The seller could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
