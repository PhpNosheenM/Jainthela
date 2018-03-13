<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ExpesssDeliveries Controller
 *
 * @property \App\Model\Table\ExpesssDeliveriesTable $ExpesssDeliveries
 *
 * @method \App\Model\Entity\ExpesssDelivery[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ExpesssDeliveriesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $expesssDeliveries = $this->paginate($this->ExpesssDeliveries);

        $this->set(compact('expesssDeliveries'));
    }

    /**
     * View method
     *
     * @param string|null $id Expesss Delivery id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $expesssDelivery = $this->ExpesssDeliveries->get($id, [
            'contain' => []
        ]);

        $this->set('expesssDelivery', $expesssDelivery);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $expesssDelivery = $this->ExpesssDeliveries->newEntity();
        if ($this->request->is('post')) {
            $expesssDelivery = $this->ExpesssDeliveries->patchEntity($expesssDelivery, $this->request->getData());
            if ($this->ExpesssDeliveries->save($expesssDelivery)) {
                $this->Flash->success(__('The expesss delivery has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The expesss delivery could not be saved. Please, try again.'));
        }
        $this->set(compact('expesssDelivery'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Expesss Delivery id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $expesssDelivery = $this->ExpesssDeliveries->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $expesssDelivery = $this->ExpesssDeliveries->patchEntity($expesssDelivery, $this->request->getData());
            if ($this->ExpesssDeliveries->save($expesssDelivery)) {
                $this->Flash->success(__('The expesss delivery has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The expesss delivery could not be saved. Please, try again.'));
        }
        $this->set(compact('expesssDelivery'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Expesss Delivery id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $expesssDelivery = $this->ExpesssDeliveries->get($id);
        if ($this->ExpesssDeliveries->delete($expesssDelivery)) {
            $this->Flash->success(__('The expesss delivery has been deleted.'));
        } else {
            $this->Flash->error(__('The expesss delivery could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
