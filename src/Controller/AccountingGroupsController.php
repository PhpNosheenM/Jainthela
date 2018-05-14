<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * AccountingGroups Controller
 *
 * @property \App\Model\Table\AccountingGroupsTable $AccountingGroups
 *
 * @method \App\Model\Entity\AccountingGroup[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AccountingGroupsController extends AppController
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
        $location_id=$this->Auth->User('location_id'); 
        $state_id=$this->Auth->User('state_id'); 
        $this->viewBuilder()->layout('admin_portal');
        $this->paginate = [
            'contain' => ['NatureOfGroups', 'ParentAccountingGroups', 'Locations']
        ];
        $accountingGroups = $this->paginate($this->AccountingGroups);
        $natureOfGroups = $this->AccountingGroups->NatureOfGroups->find('list');
        $parentAccountingGroups = $this->AccountingGroups->ParentAccountingGroups->find('list')->where(['ParentAccountingGroups.location_id'=>$location_id]);

        $this->set(compact('accountingGroups','natureOfGroups','parentAccountingGroups'));
    }

    /**
     * View method
     *
     * @param string|null $id Accounting Group id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $accountingGroup = $this->AccountingGroups->get($id, [
            'contain' => ['NatureOfGroups', 'ParentAccountingGroups', 'Locations', 'ChildAccountingGroups', 'Ledgers']
        ]);

        $this->set('accountingGroup', $accountingGroup);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user_id=$this->Auth->User('id');
        $city_id=$this->Auth->User('city_id'); 
        $location_id=$this->Auth->User('location_id'); 
        $state_id=$this->Auth->User('state_id'); 
        $this->viewBuilder()->layout('admin_portal');

        $accountingGroup = $this->AccountingGroups->newEntity();
        if ($this->request->is('post')) {
            $accountingGroup = $this->AccountingGroups->patchEntity($accountingGroup, $this->request->getData());
            if ($this->AccountingGroups->save($accountingGroup)) {
                $this->Flash->success(__('The accounting group has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The accounting group could not be saved. Please, try again.'));
        }
        $natureOfGroups = $this->AccountingGroups->NatureOfGroups->find('list', ['limit' => 200]);
        $parentAccountingGroups = $this->AccountingGroups->ParentAccountingGroups->find('list', ['limit' => 200]);
        $locations = $this->AccountingGroups->Locations->find('list', ['limit' => 200]);
        $this->set(compact('accountingGroup', 'natureOfGroups', 'parentAccountingGroups', 'locations'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Accounting Group id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $accountingGroup = $this->AccountingGroups->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $accountingGroup = $this->AccountingGroups->patchEntity($accountingGroup, $this->request->getData());
            if ($this->AccountingGroups->save($accountingGroup)) {
                $this->Flash->success(__('The accounting group has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The accounting group could not be saved. Please, try again.'));
        }
        $natureOfGroups = $this->AccountingGroups->NatureOfGroups->find('list', ['limit' => 200]);
        $parentAccountingGroups = $this->AccountingGroups->ParentAccountingGroups->find('list', ['limit' => 200]);
        $locations = $this->AccountingGroups->Locations->find('list', ['limit' => 200]);
        $this->set(compact('accountingGroup', 'natureOfGroups', 'parentAccountingGroups', 'locations'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Accounting Group id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $accountingGroup = $this->AccountingGroups->get($id);
        if ($this->AccountingGroups->delete($accountingGroup)) {
            $this->Flash->success(__('The accounting group has been deleted.'));
        } else {
            $this->Flash->error(__('The accounting group could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
