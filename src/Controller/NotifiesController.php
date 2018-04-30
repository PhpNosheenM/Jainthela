<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Notifies Controller
 *
 * @property \App\Model\Table\NotifiesTable $Notifies
 *
 * @method \App\Model\Entity\Notify[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class NotifiesController extends AppController
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
		$this->viewBuilder()->layout('admin_portal');
        $this->paginate = [
            'contain' => ['Customers', 'ItemVariations'=>['Items','UnitVariations'=>['Units']]],
			'limit' => 20
        ];

		$notifies = $this->Notifies->find()->order(['Notifies.id'=>'DESC']);

		if ($this->request->is(['get'])){
			$search=$this->request->getQuery('search');
			$notifies->where([
							'OR' => [
									'Notifies.send_flag LIKE' => $search.'%',
									'Items.name LIKE' => $search.'%',
									'Customers.name LIKE' => $search.'%'
							]
			]);
		}
        $notifies = $this->paginate($notifies);
		 
		$paginate_limit=$this->paginate['limit'];
        $this->set(compact('notifies','paginate_limit'));
	
    }

    /**
     * View method
     *
     * @param string|null $id Notify id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $notify = $this->Notifies->get($id, [
            'contain' => ['Customers', 'ItemVariations']
        ]);

        $this->set('notify', $notify);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $notify = $this->Notifies->newEntity();
        if ($this->request->is('post')) {
            $notify = $this->Notifies->patchEntity($notify, $this->request->getData());
            if ($this->Notifies->save($notify)) {
                $this->Flash->success(__('The notify has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The notify could not be saved. Please, try again.'));
        }
        $customers = $this->Notifies->Customers->find('list', ['limit' => 200]);
        $itemVariations = $this->Notifies->ItemVariations->find('list', ['limit' => 200]);
        $this->set(compact('notify', 'customers', 'itemVariations'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Notify id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $notify = $this->Notifies->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $notify = $this->Notifies->patchEntity($notify, $this->request->getData());
            if ($this->Notifies->save($notify)) {
                $this->Flash->success(__('The notify has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The notify could not be saved. Please, try again.'));
        }
        $customers = $this->Notifies->Customers->find('list', ['limit' => 200]);
        $itemVariations = $this->Notifies->ItemVariations->find('list', ['limit' => 200]);
        $this->set(compact('notify', 'customers', 'itemVariations'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Notify id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $notify = $this->Notifies->get($id);
        if ($this->Notifies->delete($notify)) {
            $this->Flash->success(__('The notify has been deleted.'));
        } else {
            $this->Flash->error(__('The notify could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
