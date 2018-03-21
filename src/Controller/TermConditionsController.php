<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * TermConditions Controller
 *
 * @property \App\Model\Table\TermConditionsTable $TermConditions
 *
 * @method \App\Model\Entity\TermCondition[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TermConditionsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $termConditions = $this->paginate($this->TermConditions);

        $this->set(compact('termConditions'));
    }

    /**
     * View method
     *
     * @param string|null $id Term Condition id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $termCondition = $this->TermConditions->get($id, [
            'contain' => []
        ]);

        $this->set('termCondition', $termCondition);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $termCondition = $this->TermConditions->newEntity();
        if ($this->request->is('post')) {
            $termCondition = $this->TermConditions->patchEntity($termCondition, $this->request->getData());
            if ($this->TermConditions->save($termCondition)) {
                $this->Flash->success(__('The term condition has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The term condition could not be saved. Please, try again.'));
        }
        $this->set(compact('termCondition'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Term Condition id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $termCondition = $this->TermConditions->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $termCondition = $this->TermConditions->patchEntity($termCondition, $this->request->getData());
            if ($this->TermConditions->save($termCondition)) {
                $this->Flash->success(__('The term condition has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The term condition could not be saved. Please, try again.'));
        }
        $this->set(compact('termCondition'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Term Condition id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $termCondition = $this->TermConditions->get($id);
        if ($this->TermConditions->delete($termCondition)) {
            $this->Flash->success(__('The term condition has been deleted.'));
        } else {
            $this->Flash->error(__('The term condition could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
