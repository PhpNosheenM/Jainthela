<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Feedbacks Controller
 *
 * @property \App\Model\Table\FeedbacksTable $Feedbacks
 *
 * @method \App\Model\Entity\Feedback[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FeedbacksController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
		
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id');
		$user_type =$this->Auth->User('user_type');
		if($user_type=="Super Admin"){
		$this->viewBuilder()->layout('super_admin_layout');	
		}else if($user_type=="Admin"){ 
		$this->viewBuilder()->layout('admin_portal');
		}
        $this->paginate = [
			'limit' => 20
        ];
        $feedback = $this->Feedbacks->find()->where(['Feedbacks.city_id'=>$city_id])->order(['Feedbacks.id'=>'Desc'])->contain(['Customers']);
		 
		if ($this->request->is(['get'])){
			$search=$this->request->getQuery('search');
			$feedback->where([
							'OR' => [
									'Feedbacks.name LIKE' => $search.'%',
									'Feedbacks.email LIKE' => $search.'%',
									'Feedbacks.mobile_no LIKE' => $search.'%',
									'Feedbacks.comment LIKE' => $search.'%'
							]
			]);
		}
		$feedbacks=$this->paginate($feedback);
		$paginate_limit=$this->paginate['limit'];
        $this->set(compact('feedbacks','paginate_limit'));
		   
        
    }

    /**
     * View method
     *
     * @param string|null $id Feedback id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $feedback = $this->Feedbacks->get($id, [
            'contain' => ['Customers', 'Cities']
        ]);

        $this->set('feedback', $feedback);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $feedback = $this->Feedbacks->newEntity();
        if ($this->request->is('post')) {
            $feedback = $this->Feedbacks->patchEntity($feedback, $this->request->getData());
            if ($this->Feedbacks->save($feedback)) {
                $this->Flash->success(__('The feedback has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The feedback could not be saved. Please, try again.'));
        }
        $customers = $this->Feedbacks->Customers->find('list', ['limit' => 200]);
        $cities = $this->Feedbacks->Cities->find('list', ['limit' => 200]);
        $this->set(compact('feedback', 'customers', 'cities'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Feedback id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $feedback = $this->Feedbacks->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $feedback = $this->Feedbacks->patchEntity($feedback, $this->request->getData());
            if ($this->Feedbacks->save($feedback)) {
                $this->Flash->success(__('The feedback has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The feedback could not be saved. Please, try again.'));
        }
        $customers = $this->Feedbacks->Customers->find('list', ['limit' => 200]);
        $cities = $this->Feedbacks->Cities->find('list', ['limit' => 200]);
        $this->set(compact('feedback', 'customers', 'cities'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Feedback id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $feedback = $this->Feedbacks->get($id);
        if ($this->Feedbacks->delete($feedback)) {
            $this->Flash->success(__('The feedback has been deleted.'));
        } else {
            $this->Flash->error(__('The feedback could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
