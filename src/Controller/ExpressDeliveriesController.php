<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ExpressDeliveries Controller
 *
 * @property \App\Model\Table\ExpressDeliveriesTable $ExpressDeliveries
 *
 * @method \App\Model\Entity\ExpressDelivery[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ExpressDeliveriesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $expressDeliveries = $this->paginate($this->ExpressDeliveries);

        $this->set(compact('expressDeliveries'));
    }

    /**
     * View method
     *
     * @param string|null $id Express Delivery id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $expressDelivery = $this->ExpressDeliveries->get($id, [
            'contain' => []
        ]);

        $this->set('expressDelivery', $expressDelivery);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $expressDelivery = $this->ExpressDeliveries->newEntity();
        if ($this->request->is('post')) {
            $expressDelivery = $this->ExpressDeliveries->patchEntity($expressDelivery, $this->request->getData());
            if ($this->ExpressDeliveries->save($expressDelivery)) {
                $this->Flash->success(__('The express delivery has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The express delivery could not be saved. Please, try again.'));
        }
        $this->set(compact('expressDelivery'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Express Delivery id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $expressDelivery = $this->ExpressDeliveries->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $expressDelivery = $this->ExpressDeliveries->patchEntity($expressDelivery, $this->request->getData());
            if ($this->ExpressDeliveries->save($expressDelivery)) {
                $this->Flash->success(__('The express delivery has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The express delivery could not be saved. Please, try again.'));
        }
        $this->set(compact('expressDelivery'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Express Delivery id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $expressDelivery = $this->ExpressDeliveries->get($id);
        if ($this->ExpressDeliveries->delete($expressDelivery)) {
            $this->Flash->success(__('The express delivery has been deleted.'));
        } else {
            $this->Flash->error(__('The express delivery could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
