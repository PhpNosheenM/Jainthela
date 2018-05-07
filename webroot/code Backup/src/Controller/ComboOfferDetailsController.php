<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ComboOfferDetails Controller
 *
 * @property \App\Model\Table\ComboOfferDetailsTable $ComboOfferDetails
 *
 * @method \App\Model\Entity\ComboOfferDetail[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ComboOfferDetailsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['ComboOffers', 'ItemVariations', 'Units']
        ];
        $comboOfferDetails = $this->paginate($this->ComboOfferDetails);

        $this->set(compact('comboOfferDetails'));
    }

    /**
     * View method
     *
     * @param string|null $id Combo Offer Detail id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $comboOfferDetail = $this->ComboOfferDetails->get($id, [
            'contain' => ['ComboOffers', 'ItemVariations', 'Units']
        ]);

        $this->set('comboOfferDetail', $comboOfferDetail);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $comboOfferDetail = $this->ComboOfferDetails->newEntity();
        if ($this->request->is('post')) {
            $comboOfferDetail = $this->ComboOfferDetails->patchEntity($comboOfferDetail, $this->request->getData());
            if ($this->ComboOfferDetails->save($comboOfferDetail)) {
                $this->Flash->success(__('The combo offer detail has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The combo offer detail could not be saved. Please, try again.'));
        }
        $comboOffers = $this->ComboOfferDetails->ComboOffers->find('list', ['limit' => 200]);
        $itemVariations = $this->ComboOfferDetails->ItemVariations->find('list', ['limit' => 200]);
        $units = $this->ComboOfferDetails->Units->find('list', ['limit' => 200]);
        $this->set(compact('comboOfferDetail', 'comboOffers', 'itemVariations', 'units'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Combo Offer Detail id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $comboOfferDetail = $this->ComboOfferDetails->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $comboOfferDetail = $this->ComboOfferDetails->patchEntity($comboOfferDetail, $this->request->getData());
            if ($this->ComboOfferDetails->save($comboOfferDetail)) {
                $this->Flash->success(__('The combo offer detail has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The combo offer detail could not be saved. Please, try again.'));
        }
        $comboOffers = $this->ComboOfferDetails->ComboOffers->find('list', ['limit' => 200]);
        $itemVariations = $this->ComboOfferDetails->ItemVariations->find('list', ['limit' => 200]);
        $units = $this->ComboOfferDetails->Units->find('list', ['limit' => 200]);
        $this->set(compact('comboOfferDetail', 'comboOffers', 'itemVariations', 'units'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Combo Offer Detail id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $comboOfferDetail = $this->ComboOfferDetails->get($id);
        if ($this->ComboOfferDetails->delete($comboOfferDetail)) {
            $this->Flash->success(__('The combo offer detail has been deleted.'));
        } else {
            $this->Flash->error(__('The combo offer detail could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
