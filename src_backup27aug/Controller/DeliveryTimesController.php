<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\View\View;
/**
 * DeliveryTimes Controller
 *
 * @property \App\Model\Table\DeliveryTimesTable $DeliveryTimes
 *
 * @method \App\Model\Entity\DeliveryTime[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DeliveryTimesController extends AppController
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
     public function index($ids = null)
    {
		
		$city_id=$this->Auth->User('city_id'); 
		$user_id=$this->Auth->User('id');
		$user_type=$this->Auth->User('user_type');
		if($user_type=='Super Admin'){
			$this->viewBuilder()->layout('super_admin_layout');
		}else if($user_type=='Admin'){
			$this->viewBuilder()->layout('admin_portal');
		}
        $this->paginate =[
		
            'limit' => 20
        ];
		
		if($ids)
		{
		   $id = $this->EncryptingDecrypting->decryptData($ids);
		}
		
		$deliveryTimes = $this->DeliveryTimes->find()->where(['city_id'=>$city_id]);
		
		if($ids)
		{
			$deliveryTime = $this->DeliveryTimes->get($id);
		}
		else
		{
		     $deliveryTime = $this->DeliveryTimes->newEntity();	 
		}
		if ($this->request->is(['post','put'])){
			
            $deliveryTime = $this->DeliveryTimes->patchEntity($deliveryTime, $this->request->getData());	
		    $deliveryTime->city_id=$city_id;
			$deliveryTime->created_by=$user_id;
			if($ids)
			{
				$deliveryTime->id=$id;
			}
			
			if ($this->DeliveryTimes->save($deliveryTime)) {
                $this->Flash->success(__('The delivery time has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
			$this->Flash->error(__('The delivery time could not be saved. Please, try again.'));
		}
		
		$deliveryTimes = $this->paginate($deliveryTimes);
        $paginate_limit=$this->paginate['limit'];
        $this->set(compact('deliveryTime','deliveryTimes','paginate_limit'));
    }
	
   

    /**
     * View method
     *
     * @param string|null $id Delivery Time id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $deliveryTime = $this->DeliveryTimes->get($id, [
            'contain' => ['Cities', 'Orders']
        ]);

        $this->set('deliveryTime', $deliveryTime);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $deliveryTime = $this->DeliveryTimes->newEntity();
        if ($this->request->is('post')) {
            $deliveryTime = $this->DeliveryTimes->patchEntity($deliveryTime, $this->request->getData());
            if ($this->DeliveryTimes->save($deliveryTime)) {
                $this->Flash->success(__('The delivery time has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The delivery time could not be saved. Please, try again.'));
        }
        $cities = $this->DeliveryTimes->Cities->find('list', ['limit' => 200]);
        $this->set(compact('deliveryTime', 'cities'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Delivery Time id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $deliveryTime = $this->DeliveryTimes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $deliveryTime = $this->DeliveryTimes->patchEntity($deliveryTime, $this->request->getData());
            if ($this->DeliveryTimes->save($deliveryTime)) {
                $this->Flash->success(__('The delivery time has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The delivery time could not be saved. Please, try again.'));
        }
        $cities = $this->DeliveryTimes->Cities->find('list', ['limit' => 200]);
        $this->set(compact('deliveryTime', 'cities'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Delivery Time id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($dir)
    {
        $this->request->allowMethod(['patch', 'post', 'put']);
		$id = $this->EncryptingDecrypting->decryptData($dir);
        $deliveryTime = $this->DeliveryTimes->get($id);
		$deliveryTime->status='Deactive';
        if ($this->DeliveryTimes->save($deliveryTime)) {
            $this->Flash->success(__('The delivery time has been deleted.'));
        } else {
            $this->Flash->error(__('The delivery time could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
