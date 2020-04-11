<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * PromotionDetails Controller
 *
 * @property \App\Model\Table\PromotionDetailsTable $PromotionDetails
 *
 * @method \App\Model\Entity\PromotionDetail[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PromotionDetailsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Promotions', 'Categories', 'Items', 'GetItems']
        ];
        $promotionDetails = $this->paginate($this->PromotionDetails);

        $this->set(compact('promotionDetails'));
    }

    /**
     * View method
     *
     * @param string|null $id Promotion Detail id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $promotionDetail = $this->PromotionDetails->get($id, [
            'contain' => ['Promotions', 'Categories', 'Items', 'GetItems', 'Orders']
        ]);

        $this->set('promotionDetail', $promotionDetail);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $promotionDetail = $this->PromotionDetails->newEntity();
        if ($this->request->is('post')) {
            $promotionDetail = $this->PromotionDetails->patchEntity($promotionDetail, $this->request->getData());
            if ($this->PromotionDetails->save($promotionDetail)) {
                $this->Flash->success(__('The promotion detail has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The promotion detail could not be saved. Please, try again.'));
        }
        $promotions = $this->PromotionDetails->Promotions->find('list', ['limit' => 200]);
        $categories = $this->PromotionDetails->Categories->find('list', ['limit' => 200]);
        $items = $this->PromotionDetails->Items->find('list', ['limit' => 200]);
        $getItems = $this->PromotionDetails->GetItems->find('list', ['limit' => 200]);
        $this->set(compact('promotionDetail', 'promotions', 'categories', 'items', 'getItems'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Promotion Detail id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $promotionDetail = $this->PromotionDetails->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $promotionDetail = $this->PromotionDetails->patchEntity($promotionDetail, $this->request->getData());
            if ($this->PromotionDetails->save($promotionDetail)) {
                $this->Flash->success(__('The promotion detail has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The promotion detail could not be saved. Please, try again.'));
        }
        $promotions = $this->PromotionDetails->Promotions->find('list', ['limit' => 200]);
        $categories = $this->PromotionDetails->Categories->find('list', ['limit' => 200]);
        $items = $this->PromotionDetails->Items->find('list', ['limit' => 200]);
        $getItems = $this->PromotionDetails->GetItems->find('list', ['limit' => 200]);
        $this->set(compact('promotionDetail', 'promotions', 'categories', 'items', 'getItems'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Promotion Detail id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $promotionDetail = $this->PromotionDetails->get($id);
        if ($this->PromotionDetails->delete($promotionDetail)) {
            $this->Flash->success(__('The promotion detail has been deleted.'));
        } else {
            $this->Flash->error(__('The promotion detail could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
