<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\View\View;

/**
 * Units Controller
 *
 * @property \App\Model\Table\UnitsTable $Units
 *
 * @method \App\Model\Entity\Unit[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UnitsController extends AppController
{
	/**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
	 public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Security->setConfig('unlockedActions', ['index']);

    }
    public function index($id = null)
    {  

    	
		$city_id=$this->Auth->User('city_id'); 
		$user_id=$this->Auth->User('id');
		$this->viewBuilder()->layout('super_admin_layout');
		$this->paginate =[
				'limit' => 20
		];
		$units = $this->Units->find()->where(['city_id'=>$city_id]);
		
		if($id)
		{
		   $id = $this->EncryptingDecrypting->decryptData($id);
		   $unit = $this->Units->get($id);
		}
		else
		{
			$unit = $this->Units->newEntity();
		}
        if ($this->request->is(['post','put'])) { 
		
			$unit = $this->Units->patchEntity($unit, $this->request->getData());
			$unit->city_id=$city_id;
			$unit->created_by=$user_id;
			if($id)
			{
				$unit->id=$id;
			}
			if ($this->Units->save($unit)) {
				$this->Flash->success(__('The unit has been saved.'));

				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('The unit could not be saved. Please, try again.'));
            
        }
		else if ($this->request->is(['get'])){
			$search=$this->request->getQuery('search');
			$units->where([
							'OR' => [
									'unit_name LIKE' => $search.'%',
									'longname LIKE' => $search.'%',
									'shortname LIKE' => $search.'%',
									'status LIKE' => $search.'%'
							]
			]);
		}
		
		$units=$this->paginate($units);
		$paginate_limit=$this->paginate['limit'];
        $this->set(compact('unit','units','paginate_limit'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Unit id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($dir)
    {
        $this->request->allowMethod(['patch', 'post', 'put']);
		$id = $this->EncryptingDecrypting->decryptData($dir);
        $unit = $this->Units->get($id);
		$unit->status='Deactive';
        if ($this->Units->save($unit)) {
            $this->Flash->success(__('The unit has been deleted.'));
			 
        } else {
            $this->Flash->error(__('The unit could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
