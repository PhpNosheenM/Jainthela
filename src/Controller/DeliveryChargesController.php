<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * DeliveryCharges Controller
 *
 * @property \App\Model\Table\DeliveryChargesTable $DeliveryCharges
 *
 * @method \App\Model\Entity\DeliveryCharge[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DeliveryChargesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index($id = null)
    {
		$city_id=$this->Auth->User('city_id'); 
		$user_id=$this->Auth->User('id');
		$this->viewBuilder()->layout('admin_portal');
		$this->paginate = [
			'limit' => 20,
         ];
	     $deliveryCharges = $this->DeliveryCharges->find()->where(['city_id'=>$city_id]);
		
		if($id)
		{
		   $deliveryCharge = $this->DeliveryCharges->get($id);
		}
		else
		{
			$deliveryCharge = $this->DeliveryCharges->newEntity();
		}

        if ($this->request->is(['post','put'])) {
			 
            $deliveryCharge = $this->DeliveryCharges->patchEntity($deliveryCharge, $this->request->getData());
			$deliveryCharge->city_id=$city_id;
			$deliveryCharge->created_by=$user_id;
			if($id)
			{
				$deliveryCharge->id=$id;
			}
            if ($this->DeliveryCharges->save($deliveryCharge)) {
                $this->Flash->success(__('The delivery charge has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
			 
            $this->Flash->error(__('The delivery charge could not be saved. Please, try again.'));
			
        }
	 
        $deliveryCharges = $this->paginate($deliveryCharges);
        $paginate_limit=$this->paginate['limit'];
        $this->set(compact('deliveryCharges','deliveryCharge','paginate_limit'));
    }

    /**
     * View method
     *
     * @param string|null $id Delivery Charge id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $deliveryCharge = $this->DeliveryCharges->get($id, [
            'contain' => ['Cities', 'Orders']
        ]);

        $this->set('deliveryCharge', $deliveryCharge);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $deliveryCharge = $this->DeliveryCharges->newEntity();
        if ($this->request->is('post')) {
            $deliveryCharge = $this->DeliveryCharges->patchEntity($deliveryCharge, $this->request->getData());
            if ($this->DeliveryCharges->save($deliveryCharge)) {
                $this->Flash->success(__('The delivery charge has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The delivery charge could not be saved. Please, try again.'));
        }
        $cities = $this->DeliveryCharges->Cities->find('list', ['limit' => 200]);
        $this->set(compact('deliveryCharge', 'cities'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Delivery Charge id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $deliveryCharge = $this->DeliveryCharges->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $deliveryCharge = $this->DeliveryCharges->patchEntity($deliveryCharge, $this->request->getData());
            if ($this->DeliveryCharges->save($deliveryCharge)) {
                $this->Flash->success(__('The delivery charge has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The delivery charge could not be saved. Please, try again.'));
        }
        $cities = $this->DeliveryCharges->Cities->find('list', ['limit' => 200]);
        $this->set(compact('deliveryCharge', 'cities'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Delivery Charge id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $deliveryCharge = $this->DeliveryCharges->get($id);
        if ($this->DeliveryCharges->delete($deliveryCharge)) {
            $this->Flash->success(__('The delivery charge has been deleted.'));
        } else {
            $this->Flash->error(__('The delivery charge could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
