<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\View\View;

/**
 * MasterSetups Controller
 *
 * @property \App\Model\Table\MasterSetupsTable $MasterSetups
 *
 * @method \App\Model\Entity\MasterSetup[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MasterSetupsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
     public function index($ids = null)
    {
		
		$status=$this->request->query('status');
		$city_id=$this->Auth->User('city_id'); 
		$user_id=$this->Auth->User('id');
		$user_type=$this->Auth->User('user_type');
		if($user_type=='Super Admin'){
			$this->viewBuilder()->layout('super_admin_layout');
		}else if($user_type=='Admin'){
			$this->viewBuilder()->layout('admin_portal');
		}
		
		
		if($ids)
		{
		   $id = $this->EncryptingDecrypting->decryptData($ids);
		   $masterSetup = $this->MasterSetups->get($id);
		}
		else
		{
			 $masterSetup = $this->MasterSetups->newEntity();
		}
		
		  if ($this->request->is(['patch', 'post', 'put'])) {
            $masterSetup = $this->MasterSetups->patchEntity($masterSetup, $this->request->getData());
            
			if ($this->MasterSetups->save($masterSetup)) {
                $this->Flash->success(__('The master setup has been saved.'));

                return $this->redirect(['action' => 'index']);
            }else{ pr($masterSetup); exit;
            $this->Flash->error(__('The master setup could not be saved. Please, try again.'));
			}
        }
		
		
       
        
		 $MasterSetups = $this->MasterSetups->find()->where(['city_id'=>$city_id]);
		//$paginate_limit=$this->paginate['limit'];
        $this->set(compact('masterSetup','MasterSetups','ids'));
    }

    /**
     * View method
     *
     * @param string|null $id Master Setup id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $masterSetup = $this->MasterSetups->get($id, [
            'contain' => ['Cities']
        ]);

        $this->set('masterSetup', $masterSetup);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $masterSetup = $this->MasterSetups->newEntity();
        if ($this->request->is('post')) {
            $masterSetup = $this->MasterSetups->patchEntity($masterSetup, $this->request->getData());
            if ($this->MasterSetups->save($masterSetup)) {
                $this->Flash->success(__('The master setup has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The master setup could not be saved. Please, try again.'));
        }
        $cities = $this->MasterSetups->Cities->find('list', ['limit' => 200]);
        $this->set(compact('masterSetup', 'cities'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Master Setup id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $masterSetup = $this->MasterSetups->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $masterSetup = $this->MasterSetups->patchEntity($masterSetup, $this->request->getData());
            if ($this->MasterSetups->save($masterSetup)) {
                $this->Flash->success(__('The master setup has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The master setup could not be saved. Please, try again.'));
        }
        $cities = $this->MasterSetups->Cities->find('list', ['limit' => 200]);
        $this->set(compact('masterSetup', 'cities'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Master Setup id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $masterSetup = $this->MasterSetups->get($id);
        if ($this->MasterSetups->delete($masterSetup)) {
            $this->Flash->success(__('The master setup has been deleted.'));
        } else {
            $this->Flash->error(__('The master setup could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
