<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Cities Controller
 *
 * @property \App\Model\Table\CitiesTable $Cities
 *
 * @method \App\Model\Entity\City[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CitiesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index($id = null)
    {
		$user_id=$this->Auth->User('id');
		$this->viewBuilder()->layout('admin_portal');
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
		
        $this->paginate = [
            'contain' => ['States'],
			'limit' =>20
        ];
        $cities = $this->paginate($this->Cities);
		$states = $this->Cities->States->find('list');
        $this->set(compact('cities','city','states'));
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
