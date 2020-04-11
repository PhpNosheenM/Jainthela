<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * BulkOrderPerformas Controller
 *
 * @property \App\Model\Table\BulkOrderPerformasTable $BulkOrderPerformas
 *
 * @method \App\Model\Entity\BulkOrderPerforma[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BulkOrderPerformasController extends AppController
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
		//$location_id=$this->Auth->User('location_id');
		$this->viewBuilder()->layout('super_admin_layout');
        $this->paginate = [
            'contain' => ['Cities']
        ];
        $bulkOrderPerformas = $this->paginate($this->BulkOrderPerformas);

        $this->set(compact('bulkOrderPerformas'));
    }

    /**
     * View method
     *
     * @param string|null $id Bulk Order Performa id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function excelExport($id = null){
		//$id = $this->request->query('id');
		$this->viewBuilder()->layout('');
		$bulkOrderPerforma = $this->BulkOrderPerformas->get($id, [
		'contain' => ['Cities', 'BulkOrderPerformaRows'=>['Items']]
		]);
		$this->set('bulkOrderPerforma', $bulkOrderPerforma);
	}
    public function view($id = null)
    {
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id'); 
		//$location_id=$this->Auth->User('location_id');
		$this->viewBuilder()->layout('super_admin_layout');
        $bulkOrderPerforma = $this->BulkOrderPerformas->get($id, [
            'contain' => ['Cities', 'BulkOrderPerformaRows'=>['Items'=>['DefaultUnits']]]
        ]);
		//pr($bulkOrderPerforma); exit;
        $this->set('bulkOrderPerforma', $bulkOrderPerforma);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $bulkOrderPerforma = $this->BulkOrderPerformas->newEntity();
        if ($this->request->is('post')) {
            $bulkOrderPerforma = $this->BulkOrderPerformas->patchEntity($bulkOrderPerforma, $this->request->getData());
            if ($this->BulkOrderPerformas->save($bulkOrderPerforma)) {
                $this->Flash->success(__('The bulk order performa has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The bulk order performa could not be saved. Please, try again.'));
        }
        $cities = $this->BulkOrderPerformas->Cities->find('list', ['limit' => 200]);
        $this->set(compact('bulkOrderPerforma', 'cities'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Bulk Order Performa id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $bulkOrderPerforma = $this->BulkOrderPerformas->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $bulkOrderPerforma = $this->BulkOrderPerformas->patchEntity($bulkOrderPerforma, $this->request->getData());
            if ($this->BulkOrderPerformas->save($bulkOrderPerforma)) {
                $this->Flash->success(__('The bulk order performa has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The bulk order performa could not be saved. Please, try again.'));
        }
        $cities = $this->BulkOrderPerformas->Cities->find('list', ['limit' => 200]);
        $this->set(compact('bulkOrderPerforma', 'cities'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Bulk Order Performa id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $bulkOrderPerforma = $this->BulkOrderPerformas->get($id);
        if ($this->BulkOrderPerformas->delete($bulkOrderPerforma)) {
            $this->Flash->success(__('The bulk order performa has been deleted.'));
        } else {
            $this->Flash->error(__('The bulk order performa could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
