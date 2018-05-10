<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * DeliveryDates Controller
 *
 * @property \App\Model\Table\DeliveryDatesTable $DeliveryDates
 *
 * @method \App\Model\Entity\DeliveryDate[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DeliveryDatesController extends AppController
{

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
			'limit' => 20,
         ];
		
		if($id)
		{
		   $id = $this->EncryptingDecrypting->decryptData($id);
		}
		
	     $deliverydates = $this->DeliveryDates->find()->where(['city_id'=>$city_id]);
		
		if($id)
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
			if($id)
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
        $this->request->allowMethod(['post', 'delete']);
		$id = $this->EncryptingDecrypting->decryptData($dir);
        $deliveryDate = $this->DeliveryDates->get($id);
        if ($this->DeliveryDates->delete($deliveryDate)) {
            $this->Flash->success(__('The delivery date has been deleted.'));
        } else {
            $this->Flash->error(__('The delivery date could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
