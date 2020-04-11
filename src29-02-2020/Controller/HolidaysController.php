<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\View\View;
/**
 * Holidays Controller
 *
 * @property \App\Model\Table\HolidaysTable $Holidays
 *
 * @method \App\Model\Entity\Holiday[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class HolidaysController extends AppController
{
	public function beforeFilter(Event $event)
	{
		parent::beforeFilter($event);
		$this->Security->setConfig('unlockedActions', ['index']);
	}
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index($ids=null)
    {
		
		$city_id=$this->Auth->User('city_id'); 
		$user_id=$this->Auth->User('id');
		$user_type=$this->Auth->User('user_type');
		if($user_type=='Super Admin'){
			$this->viewBuilder()->layout('super_admin_layout');
		}else if($user_type=='Admin'){
			$this->viewBuilder()->layout('admin_portal');
		}
		 $this->paginate = [
            'contain' => ['Cities'],
			'limit' =>20
        ];
		
		if($ids)
		{
		   $id = $this->EncryptingDecrypting->decryptData($ids);
		}
		
		$holidays1 = $this->Holidays->find()->where(['Holidays.city_id'=>$city_id]);
        if($ids)
		{
		    $holiday = $this->Holidays->get($id);
		}
		else
		{
			 $holiday = $this->Holidays->newEntity();
		}
		
		if ($this->request->is(['post','put'])) {
			
            $holiday = $this->Holidays->patchEntity($holiday, $this->request->getData());
			$date=$this->request->data['date'];
			$org_date=date('Y-m-d', strtotime($date));
			$holiday->date=$org_date;
			$holiday->created_by=$user_id;
			$holiday->city_id=$city_id;
			if($ids)
			{
				$holiday->id=$id;
			}
            if ($this->Holidays->save($holiday)) {
                $this->Flash->success(__('The Holidays has been saved.'));
				return $this->redirect(['action' => 'index']);
            }
			
            $this->Flash->error(__('The Holidays could not be saved. Please, try again.'));
        }
		else if ($this->request->is(['get'])){
			$search=$this->request->getQuery('search');
			$holidays1->where([
							'OR' => [
									'Holidays.date LIKE' => $search.'%',
									'Holidays.reason LIKE' => $search.'%'
							]
			]);
		}
		
		$holidays = $this->paginate($holidays1);
		$paginate_limit=$this->paginate['limit'];
        $this->set(compact('holidays','holiday','states','paginate_limit'));
		
    }

    /**
     * View method
     *
     * @param string|null $id Holiday id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $holiday = $this->Holidays->get($id, [
            'contain' => ['Cities']
        ]);

        $this->set('holiday', $holiday);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $holiday = $this->Holidays->newEntity();
        if ($this->request->is('post')) {
            $holiday = $this->Holidays->patchEntity($holiday, $this->request->getData());
            if ($this->Holidays->save($holiday)) {
                $this->Flash->success(__('The holiday has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The holiday could not be saved. Please, try again.'));
        }
        $cities = $this->Holidays->Cities->find('list', ['limit' => 200]);
        $this->set(compact('holiday', 'cities'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Holiday id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $holiday = $this->Holidays->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $holiday = $this->Holidays->patchEntity($holiday, $this->request->getData());
            if ($this->Holidays->save($holiday)) {
                $this->Flash->success(__('The holiday has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The holiday could not be saved. Please, try again.'));
        }
        $cities = $this->Holidays->Cities->find('list', ['limit' => 200]);
        $this->set(compact('holiday', 'cities'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Holiday id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($dir = null)
    {
		$id = $this->EncryptingDecrypting->decryptData($dir);
        $this->request->allowMethod(['post', 'delete']);
        $holiday = $this->Holidays->get($id);
        if ($this->Holidays->delete($holiday)) {
            $this->Flash->success(__('The holiday has been deleted.'));
        } else {
            $this->Flash->error(__('The holiday could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
