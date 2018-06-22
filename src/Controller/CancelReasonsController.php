<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * CancelReasons Controller
 *
 * @property \App\Model\Table\CancelReasonsTable $CancelReasons
 *
 * @method \App\Model\Entity\CancelReason[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CancelReasonsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index($id=null)
    {
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id'); 
		$this->viewBuilder()->layout('admin_portal');
		$this->paginate = [
			'limit' => 20,
         ];
		 
		if($id)
		{
		   $id = $this->EncryptingDecrypting->decryptData($id);
		}
		
       $CancelReason1=$this->CancelReasons->find();
		if($id)
		{
		   $cancelReason = $this->CancelReasons->get($id);
		}
		else
		{
			$cancelReason = $this->CancelReasons->newEntity();
		}
		
        if ($this->request->is(['post','put'])) {
            $cancelReason = $this->CancelReasons->patchEntity($cancelReason, $this->request->getData());
			$cancelReason->created_by=$user_id;
            if ($this->CancelReasons->save($cancelReason)) {
                $this->Flash->success(__('The cancel reason has been saved.'));
				return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The cancel reason could not be saved. Please, try again.'));
        }
		else if ($this->request->is(['get'])){
			$search=$this->request->getQuery('search');
			$CancelReason1->where([
							'OR' => [
									'CancelReasons.reason LIKE' => $search.'%',
									'CancelReasons.status LIKE' => $search.'%'
							]
			]);
		}
		$cancelReasons = $this->paginate($CancelReason1);
		$paginate_limit=$this->paginate['limit'];
        $this->set(compact('cancelReasons','cancelReason','paginate_limit'));
    }

    /**
     * View method
     *
     * @param string|null $id Cancel Reason id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $cancelReason = $this->CancelReasons->get($id, [
            'contain' => ['Orders']
        ]);

        $this->set('cancelReason', $cancelReason);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $cancelReason = $this->CancelReasons->newEntity();
        if ($this->request->is('post')) {
            $cancelReason = $this->CancelReasons->patchEntity($cancelReason, $this->request->getData());
            if ($this->CancelReasons->save($cancelReason)) {
                $this->Flash->success(__('The cancel reason has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The cancel reason could not be saved. Please, try again.'));
        }
        $this->set(compact('cancelReason'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Cancel Reason id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $cancelReason = $this->CancelReasons->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $cancelReason = $this->CancelReasons->patchEntity($cancelReason, $this->request->getData());
            if ($this->CancelReasons->save($cancelReason)) {
                $this->Flash->success(__('The cancel reason has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The cancel reason could not be saved. Please, try again.'));
        }
        $this->set(compact('cancelReason'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Cancel Reason id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($dir)
    {
        $this->request->allowMethod(['patch', 'post', 'put']);
		$id = $this->EncryptingDecrypting->decryptData($dir);
        $cancelReason = $this->CancelReasons->get($id);
		$cancelReason->status='Deactive';
        if ($this->CancelReasons->save($cancelReason)) {
            $this->Flash->success(__('The cancel reason has been deleted.'));
        } else {
            $this->Flash->error(__('The cancel reason could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
