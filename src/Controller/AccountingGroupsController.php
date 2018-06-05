<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\View\View;
/**
 * AccountingGroups Controller
 *
 * @property \App\Model\Table\AccountingGroupsTable $AccountingGroups
 *
 * @method \App\Model\Entity\AccountingGroup[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AccountingGroupsController extends AppController
{
	public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Security->setConfig('unlockedActions', ['add' , 'index' , 'list' ,'accountList', 'accountView', 'getItemInfo', 'getItemInfos']);

    }
	
	public function getItemInfo()
	{
		$nm = $this->request->query('nm');
		$updt_id = $this->request->query('updt_id');
		
		$query = $this->AccountingGroups->query();
		$query->update()
			->set([$nm =>'1'])
			->where(['AccountingGroups.id' => $updt_id])
			->execute();
	}

	public function getItemInfos()
	{
		$nm = $this->request->query('nm');
		$updt_id = $this->request->query('updt_id');
		
		$query1 = $this->AccountingGroups->query();
		$query1->update()
			->set([$nm =>'NULL'])
			->where(['AccountingGroups.id' => $updt_id])
			->execute();
	}
	
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
	
	public function accountView($id)
    {
        $user_id=$this->Auth->User('id');
        $city_id=$this->Auth->User('city_id'); 
        $location_id=$this->Auth->User('location_id'); 
        $state_id=$this->Auth->User('state_id'); 
        $this->viewBuilder()->layout('super_admin_layout');
        $this->paginate = [
             'limit' => 20
        ];
        $accountingGroups = $this->paginate($this->AccountingGroups->find()->where(['AccountingGroups.id'=>$id])->contain(['NatureOfGroups','ParentAccountingGroups']))->first();
		$paginate_limit=$this->paginate['limit'];
        $this->set(compact('accountingGroups','paginate_limit'));
    }
		
	 
	 public function accountList()
    {
        $user_id=$this->Auth->User('id');
        $city_id=$this->Auth->User('city_id'); 
        $location_id=$this->Auth->User('location_id'); 
        $state_id=$this->Auth->User('state_id'); 
        $this->viewBuilder()->layout('super_admin_layout');
        $this->paginate = [
             'limit' => 20
        ];
        $accountingGroups = $this->paginate($this->AccountingGroups->find()->where(['AccountingGroups.city_id'=>$city_id])->contain(['NatureOfGroups','ParentAccountingGroups']));
		$paginate_limit=$this->paginate['limit'];
        $this->set(compact('accountingGroups','paginate_limit'));
    }
	
    public function index()
    {
        $user_id=$this->Auth->User('id');
        $city_id=$this->Auth->User('city_id'); 
        $location_id=$this->Auth->User('location_id'); 
        $state_id=$this->Auth->User('state_id'); 
        $this->viewBuilder()->layout('super_admin_layout');
        $this->paginate = [
            'contain' => ['NatureOfGroups', 'ParentAccountingGroups', 'Cities'],
             'limit' => 20
        ];
		 $accountingGroup = $this->AccountingGroups->newEntity();
		 if ($this->request->is(['patch', 'post', 'put'])) {
            $accountingGroup = $this->AccountingGroups->patchEntity($accountingGroup, $this->request->getData());
			$accountingGroup->city_id = $city_id;
			//pr($accountingGroup); exit;
            if ($this->AccountingGroups->save($accountingGroup)) {
                $this->Flash->success(__('The accounting group has been saved.'));
//pr($accountingGroup); exit;
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The accounting group could not be saved. Please, try again.'));
        }
//pr($this->Auth->User()); exit;
        $accountingGroups = $this->paginate($this->AccountingGroups);
        $natureOfGroups = $this->AccountingGroups->NatureOfGroups->find('list');
        $parentAccountingGroups = $this->AccountingGroups->ParentAccountingGroups->find('list')->where(['ParentAccountingGroups.city_id'=>$city_id]);
		$natureOfGroups = $this->AccountingGroups->NatureOfGroups->find('list');
        $parentAccountingGroups = $this->AccountingGroups->ParentAccountingGroups->find('list')->where(['ParentAccountingGroups.city_id'=>$city_id]);
		$paginate_limit=$this->paginate['limit'];
        $this->set(compact('accountingGroup','accountingGroups','natureOfGroups','parentAccountingGroups','paginate_limit'));
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
