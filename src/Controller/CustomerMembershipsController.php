<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\View\View;


/**
 * CustomerMemberships Controller
 *
 * @property \App\Model\Table\CustomerMembershipsTable $CustomerMemberships
 *
 * @method \App\Model\Entity\CustomerMembership[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CustomerMembershipsController extends AppController
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
            'contain' => ['Customers', 'Plans'],
			'limit' =>20
        ];
		
		if($ids)
		{
		   $id = $this->EncryptingDecrypting->decryptData($ids);
		}
		
		$customermemberships1 = $this->CustomerMemberships->find()->where(['CustomerMemberships.city_id'=>$city_id]);
        if($ids)
		{
		    $customermembership = $this->CustomerMemberships->get($id);
		}
		else
		{
			 $customermembership = $this->CustomerMemberships->newEntity();
		}
		
		 if ($this->request->is(['post','put'])) {
            $customermembership = $this->CustomerMemberships->patchEntity($customermembership, $this->request->getData());
			$start_date=$this->request->data['start_date'];
			$org_start_date=date('Y-m-d', strtotime($start_date));
			$end_date=$this->request->data['end_date'];
			$org_end_date=date('Y-m-d', strtotime($end_date));
			
			$customermembership->city_id=$city_id;
			$customermembership->start_date=$org_start_date;
			$customermembership->end_date=$org_end_date;
			
			
			if($ids)
			{
				$customermembership->id=$id;
			}
            if ($this->CustomerMemberships->save($customermembership)) {
				$discount=$customermembership->discount_percentage;
				$customer_id=$customermembership->customer_id;
				$start_date=$customermembership->start_date;
				$end_date=$customermembership->end_date;
				
				$query = $this->CustomerMemberships->Customers->query();
					$query->update()
							->set(['membership_discount' => $discount, 'start_date' => $start_date, 'end_date' => $end_date])
							->where(['id'=>$customer_id])
							->execute();
							
                $this->Flash->success(__('The Customer Memberships has been saved.'));
				return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The Customer Memberships could not be saved. Please, try again.'));
        }
		
		$today=date('Y-m-d');
		$customermemberships = $this->paginate($customermemberships1);
		$paginate_limit=$this->paginate['limit'];
		$customers=$this->CustomerMemberships->Customers->find('list')->where(['Customers.city_id'=>$city_id, 'Customers.status'=>'Active', 'Customers.end_date <'=>$today]);
		$plans1=$this->CustomerMemberships->Plans->find()->where(['Plans.city_id'=>$city_id,'Plans.plan_type'=>'Membership']);
		foreach($plans1 as $data){
			$org_start_date=date('d-m-Y', strtotime($data->start_date));
			$org_end_date=date('d-m-Y', strtotime($data->end_date));
			$plans[]=['value'=>$data->id,'text'=>$data->name,'amount'=>$data->amount,'benifit_per'=>$data->benifit_per, 'start_date'=>$org_start_date, 'end_date'=>$org_end_date];
		}
        $this->set(compact('customermemberships','customermembership','customers','plans','paginate_limit'));
		
		
		
      /*   $this->paginate = [
            'contain' => ['Customers', 'Cities', 'Plans']
        ];
        $customerMemberships = $this->paginate($this->CustomerMemberships);

        $this->set(compact('customerMemberships')); */
    }

    /**
     * View method
     *
     * @param string|null $id Customer Membership id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $customerMembership = $this->CustomerMemberships->get($id, [
            'contain' => ['Customers', 'Cities', 'Plans']
        ]);

        $this->set('customerMembership', $customerMembership);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $customerMembership = $this->CustomerMemberships->newEntity();
        if ($this->request->is('post')) {
            $customerMembership = $this->CustomerMemberships->patchEntity($customerMembership, $this->request->getData());
            if ($this->CustomerMemberships->save($customerMembership)) {
                $this->Flash->success(__('The customer membership has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The customer membership could not be saved. Please, try again.'));
        }
        $customers = $this->CustomerMemberships->Customers->find('list', ['limit' => 200]);
        $cities = $this->CustomerMemberships->Cities->find('list', ['limit' => 200]);
        $plans = $this->CustomerMemberships->Plans->find('list', ['limit' => 200]);
        $this->set(compact('customerMembership', 'customers', 'cities', 'plans'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Customer Membership id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $customerMembership = $this->CustomerMemberships->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $customerMembership = $this->CustomerMemberships->patchEntity($customerMembership, $this->request->getData());
            if ($this->CustomerMemberships->save($customerMembership)) {
                $this->Flash->success(__('The customer membership has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The customer membership could not be saved. Please, try again.'));
        }
        $customers = $this->CustomerMemberships->Customers->find('list', ['limit' => 200]);
        $cities = $this->CustomerMemberships->Cities->find('list', ['limit' => 200]);
        $plans = $this->CustomerMemberships->Plans->find('list', ['limit' => 200]);
        $this->set(compact('customerMembership', 'customers', 'cities', 'plans'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Customer Membership id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $customerMembership = $this->CustomerMemberships->get($id);
        if ($this->CustomerMemberships->delete($customerMembership)) {
            $this->Flash->success(__('The customer membership has been deleted.'));
        } else {
            $this->Flash->error(__('The customer membership could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
