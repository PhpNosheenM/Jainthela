<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * States Controller
 *
 * @property \App\Model\Table\StatesTable $States
 *
 * @method \App\Model\Entity\State[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class StatesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index($id = null)
    {
		$user_id=$this->Auth->User('id');
		$this->viewBuilder()->layout('super_admin_layout');
		$this->paginate= [
					'limit'=>20
		];
		if($id)
		{
		   $id = $this->EncryptingDecrypting->decryptData($id);
		}
		
		$states=$this->States->find();
        if($id)
		{
		    $state = $this->States->get($id);
		}
		else
		{
			$state = $this->States->newEntity();
		}
		
        if ($this->request->is(['post','put'])) {
			
            $state = $this->States->patchEntity($state, $this->request->getData());
			$state->created_by=$user_id;
			if($id)
			{
				$state->id=$id;
			}
            if ($this->States->save($state)) {
                $this->Flash->success(__('The state has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
			//pr($state); exit;
            $this->Flash->error(__('The state could not be saved. Please, try again.'));
        }
		else if ($this->request->is(['get'])){
			$search=$this->request->getQuery('search');
			$states->where([
							'OR' => [
									'States.name LIKE' => $search.'%',
									'States.alias_name LIKE' => $search.'%',
									'States.status LIKE' => $search.'%'
							]
			]);
		}
		
		$states = $this->paginate($states);
        $paginate_limit=$this->paginate['limit'];
		$this->set(compact('states','state','paginate_limit'));
    }

    

    /**
     * Delete method
     *
     * @param string|null $id State id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($dir)
    {
        $this->request->allowMethod(['post', 'delete']);
		$id = $this->EncryptingDecrypting->decryptData($dir);
        $state = $this->States->get($id);
        if ($this->States->delete($state)) {
            $this->Flash->success(__('The state has been deleted.'));
        } else {
            $this->Flash->error(__('The state could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
