<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\View\View;
/**
 * DeliveryDates Controller
 *
 * @property \App\Model\Table\DeliveryDatesTable $DeliveryDates
 *
 * @method \App\Model\Entity\DeliveryDate[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DeliveryDatesController extends AppController
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
			'limit' => 20,
         ];
		
		if($ids)
		{
		   $id = $this->EncryptingDecrypting->decryptData($ids);
		}
		
	     $deliverydates = $this->DeliveryDates->find()->where(['city_id'=>$city_id]);
		
		if($ids)
		{
		   $deliverydate = $this->DeliveryDates->get($id);
		}
		else
		{
			$deliverydate = $this->DeliveryDates->newEntity();
		}

        if ($this->request->is(['post','put'])) {
			 
            $deliverydate = $this->DeliveryDates->patchEntity($deliverydate, $this->request->getData());
			$deliverydate->city_id=$city_id;
			if($ids)
			{
				$deliverydate->id=$id;
			}
            if ($this->DeliveryDates->save($deliverydate)) {
                $this->Flash->success(__('The delivery charge has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
		 
            $this->Flash->error(__('The delivery charge could not be saved. Please, try again.'));
			
        }
	
        $deliverydates = $this->paginate($deliverydates);
        $paginate_limit=$this->paginate['limit'];
        $this->set(compact('deliverydates','deliverydate','paginate_limit'));
		 
    }

    /**
     * View method
     *
     * @param string|null $id Delivery Date id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $deliveryDate = $this->DeliveryDates->get($id, [
            'contain' => []
        ]);

        $this->set('deliveryDate', $deliveryDate);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $deliveryDate = $this->DeliveryDates->newEntity();
        if ($this->request->is('post')) {
            $deliveryDate = $this->DeliveryDates->patchEntity($deliveryDate, $this->request->getData());
            if ($this->DeliveryDates->save($deliveryDate)) {
                $this->Flash->success(__('The delivery date has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The delivery date could not be saved. Please, try again.'));
        }
        $this->set(compact('deliveryDate'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Delivery Date id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $deliveryDate = $this->DeliveryDates->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $deliveryDate = $this->DeliveryDates->patchEntity($deliveryDate, $this->request->getData());
            if ($this->DeliveryDates->save($deliveryDate)) {
                $this->Flash->success(__('The delivery date has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The delivery date could not be saved. Please, try again.'));
        }
        $this->set(compact('deliveryDate'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Delivery Date id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($dir)
    {
        $this->request->allowMethod(['patch', 'post', 'put']);
		$id = $this->EncryptingDecrypting->decryptData($dir);
        $deliveryDate = $this->DeliveryDates->get($id);
		$deliveryDate->status='Deactive';
        if ($this->DeliveryDates->save($deliveryDate)) {
            $this->Flash->success(__('The delivery date has been deleted.'));
        } else {
            $this->Flash->error(__('The delivery date could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
