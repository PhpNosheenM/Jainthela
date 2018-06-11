<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\View\View;
/**
 * Plans Controller
 *
 * @property \App\Model\Table\PlansTable $Plans
 *
 * @method \App\Model\Entity\Plan[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PlansController extends AppController
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
    public function index($id=null)
    {
		$city_id=$this->Auth->User('city_id'); 
		$user_id=$this->Auth->User('id');
		$this->viewBuilder()->layout('admin_portal');
		 $this->paginate = [
            'contain' => [],
			'limit' =>20
        ];
		
		if($id)
		{
		   $id = $this->EncryptingDecrypting->decryptData($id);
		}
		
		$plans1 = $this->Plans->find()->where(['Plans.city_id'=>$city_id,'Plans.admin_id'=>$user_id]);
        if($id)
		{
		    $plan = $this->Plans->get($id);
		}
		else
		{
			 $plan = $this->Plans->newEntity();
		}

        if ($this->request->is(['post','put'])) {
            $plan = $this->Plans->patchEntity($plan, $this->request->getData());
			$plan->admin_id=$user_id;
			$plan->city_id=$city_id;
			if($id)
			{
				$plan->id=$id;
			}
            if ($this->Plans->save($plan)) {
                $this->Flash->success(__('The plan has been saved.'));
				return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The plan could not be saved. Please, try again.'));
        }
		else if ($this->request->is(['get'])){
			$search=$this->request->getQuery('search');
			$plans1->where([
							'OR' => [
									'Plans.name LIKE' => $search.'%',
									'Plans.amount LIKE' => $search.'%',
									'Plans.benifit_per LIKE' => $search.'%',
									'Plans.total_amount LIKE' => $search.'%',
									'Plans.status LIKE' => $search.'%'
							]
			]);
		}

        $plans = $this->paginate($plans1);
		$paginate_limit=$this->paginate['limit'];
        $this->set(compact('plans','plan','states','paginate_limit'));
    }

    /**
     * View method
     *
     * @param string|null $id Plan id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $plan = $this->Plans->get($id, [
            'contain' => ['Admins', 'Cities', 'Wallets']
        ]);

        $this->set('plan', $plan);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $plan = $this->Plans->newEntity();
        if ($this->request->is('post')) {
            $plan = $this->Plans->patchEntity($plan, $this->request->getData());
            if ($this->Plans->save($plan)) {
                $this->Flash->success(__('The plan has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The plan could not be saved. Please, try again.'));
        }
        $admins = $this->Plans->Admins->find('list', ['limit' => 200]);
        $cities = $this->Plans->Cities->find('list', ['limit' => 200]);
        $this->set(compact('plan', 'admins', 'cities'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Plan id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $plan = $this->Plans->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $plan = $this->Plans->patchEntity($plan, $this->request->getData());
            if ($this->Plans->save($plan)) {
                $this->Flash->success(__('The plan has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The plan could not be saved. Please, try again.'));
        }
        $admins = $this->Plans->Admins->find('list', ['limit' => 200]);
        $cities = $this->Plans->Cities->find('list', ['limit' => 200]);
        $this->set(compact('plan', 'admins', 'cities'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Plan id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($dir)
    {
        $this->request->allowMethod(['patch', 'post', 'put']);
		$id = $this->EncryptingDecrypting->decryptData($dir);
        $plan = $this->Plans->get($id);
		$plan->status='Deactive';
        if ($this->Plans->save($plan)) {
            $this->Flash->success(__('The plan has been deleted.'));
        } else {
            $this->Flash->error(__('The plan could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
