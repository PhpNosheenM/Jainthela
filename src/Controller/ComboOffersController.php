<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ComboOffers Controller
 *
 * @property \App\Model\Table\ComboOffersTable $ComboOffers
 *
 * @method \App\Model\Entity\ComboOffer[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ComboOffersController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Cities', 'Admins']
        ];
        $comboOffers = $this->paginate($this->ComboOffers);

        $this->set(compact('comboOffers'));
    }

    /**
     * View method
     *
     * @param string|null $id Combo Offer id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $comboOffer = $this->ComboOffers->get($id, [
            'contain' => ['Cities', 'Admins', 'Carts', 'ComboOfferDetails', 'OrderDetails']
        ]);

        $this->set('comboOffer', $comboOffer);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
		$city_id=$this->Auth->User('city_id'); 
		$user_id=$this->Auth->User('id');
		$this->viewBuilder()->layout('admin_portal');
        $comboOffer = $this->ComboOffers->newEntity();
        if ($this->request->is('post')) {
            $comboOffer = $this->ComboOffers->patchEntity($comboOffer, $this->request->getData());
            if ($this->ComboOffers->save($comboOffer)) {
                $this->Flash->success(__('The combo offer has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The combo offer could not be saved. Please, try again.'));
        }
        $cities = $this->ComboOffers->Cities->find('list', ['limit' => 200]);
        $admins = $this->ComboOffers->Admins->find('list', ['limit' => 200]);
        $this->set(compact('comboOffer', 'cities', 'admins'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Combo Offer id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $comboOffer = $this->ComboOffers->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $comboOffer = $this->ComboOffers->patchEntity($comboOffer, $this->request->getData());
            if ($this->ComboOffers->save($comboOffer)) {
                $this->Flash->success(__('The combo offer has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The combo offer could not be saved. Please, try again.'));
        }
        $cities = $this->ComboOffers->Cities->find('list', ['limit' => 200]);
        $admins = $this->ComboOffers->Admins->find('list', ['limit' => 200]);
        $this->set(compact('comboOffer', 'cities', 'admins'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Combo Offer id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $comboOffer = $this->ComboOffers->get($id);
        if ($this->ComboOffers->delete($comboOffer)) {
            $this->Flash->success(__('The combo offer has been deleted.'));
        } else {
            $this->Flash->error(__('The combo offer could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
