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
    public function index($id=null)
    {
       $user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id'); 
		$this->viewBuilder()->layout('admin_portal');
		$this->paginate = [
			'limit' => 20,
         ];
		  
		if($id)
		{
		   $id = $this->EncryptingDecrypting->decryptData($id);
		}
		
		$termCondition1=$this->TermConditions->find();
		if($id)
		{
		   $termCondition = $this->TermConditions->get($id);
		}
		else
		{
			$termCondition = $this->TermConditions->newEntity();
		}
		
        if ($this->request->is(['post','put'])) {
            $termCondition = $this->TermConditions->patchEntity($termCondition, $this->request->getData());
			 
            if ($this->TermConditions->save($termCondition)) {
                $this->Flash->success(__('The cancel reason has been saved.'));
				return $this->redirect(['action' => 'index']);
            }
            pr($termCondition);
            exit;
            $this->Flash->error(__('The cancel reason could not be saved. Please, try again.'));
        }
		else if ($this->request->is(['get'])){
			$search=$this->request->getQuery('search');
			$termCondition1->where([
							'OR' => [
									'TermConditions.term_name LIKE' => $search.'%',
									'TermConditions.term LIKE' => $search.'%'
							]
			]);
		}
		$termConditions = $this->paginate($termCondition1);
		$paginate_limit=$this->paginate['limit'];
        $this->set(compact('termConditions','termCondition','paginate_limit'));
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
    public function delete($dir)
    {
        $this->request->allowMethod(['post', 'delete']);
		$id = $this->EncryptingDecrypting->decryptData($dir);
        $termCondition = $this->TermConditions->get($id);
        if ($this->TermConditions->delete($termCondition)) {
            $this->Flash->success(__('The term condition has been deleted.'));
        } else {
            $this->Flash->error(__('The term condition could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
