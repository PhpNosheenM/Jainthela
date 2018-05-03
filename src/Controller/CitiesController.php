<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\View\View;
/**
 * Cities Controller
 *
 * @property \App\Model\Table\CitiesTable $Cities
 *
 * @method \App\Model\Entity\City[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CitiesController extends AppController
{
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
   
    public function index($id = null)
    {
		$user_id=$this->Auth->User('id');
		$this->viewBuilder()->layout('admin_portal');
		 $this->paginate = [
            'contain' => ['States'],
			'limit' =>20
        ];
		$cities = $this->Cities->find();
        if($id)
		{
		    $city = $this->Cities->get($id);
		}
		else
		{
			 $city = $this->Cities->newEntity();
		}

        if ($this->request->is(['post','put'])) {
            $city = $this->Cities->patchEntity($city, $this->request->getData());
			$city->created_by=$user_id;
			if($id)
			{
				$city->id=$id;
			}
            if ($this->Cities->save($city)) {
                $this->Flash->success(__('The city has been saved.'));
				return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The city could not be saved. Please, try again.'));
        }
		else if ($this->request->is(['get'])){
			$search=$this->request->getQuery('search');
			$cities->where([
							'OR' => [
									'States.name LIKE' => $search.'%',
									'Cities.name LIKE' => $search.'%',
									'Cities.status LIKE' => $search.'%'
							]
			]);
		}

        $cities = $this->paginate($cities);
		$states = $this->Cities->States->find('list');
		$paginate_limit=$this->paginate['limit'];
        $this->set(compact('cities','city','states','paginate_limit'));
    }


    /**
     * Delete method
     *
     * @param string|null $id City id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $city = $this->Cities->get($id);
        if ($this->Cities->delete($city)) {
            $this->Flash->success(__('The city has been deleted.'));
        } else {
            $this->Flash->error(__('The city could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
