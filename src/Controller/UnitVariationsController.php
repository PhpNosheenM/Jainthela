<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\View\View;
/**
 * UnitVariations Controller
 *
 * @property \App\Model\Table\UnitVariationsTable $UnitVariations
 *
 * @method \App\Model\Entity\UnitVariation[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UnitVariationsController extends AppController
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
		
        $this->paginate = [
            'contain' => ['Units'],
			'limit' => 20
        ];
		
		if($id)
		{
		   $id = $this->EncryptingDecrypting->decryptData($id);
		}
		
		$unitVariations = $this->UnitVariations->find()->where(['UnitVariations.city_id'=>$city_id]);
		if($id)
		{
		   $unitVariation = $this->UnitVariations->get($id);
		}
		else
		{
			$unitVariation = $this->UnitVariations->newEntity();
		}
		
        if ($this->request->is(['post','put'])) {
			$quantity_variation=$this->request->data(['quantity_variation']); 
			$unit_id=$this->request->data(['unit_id']); 
			$unit_data = $this->UnitVariations->Units->find()->where(['Units.id'=>$unit_id])->first();
			
			$division_factor=$unit_data->division_factor;
			$convert_unit_qty=$quantity_variation/$division_factor;
			
			$unitVariation = $this->UnitVariations->patchEntity($unitVariation, $this->request->getData());
			$unitVariation->convert_unit_qty=$convert_unit_qty;
			$unitVariation->created_by=$user_id;
			$unitVariation->city_id=$city_id;
			if($id)
			{
				$unitVariation->id=$id;
			}
            if ($this->UnitVariations->save($unitVariation)) {
                $this->Flash->success(__('The unit variation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The unit variation could not be saved. Please, try again.'));
        }
		else if ($this->request->is(['get'])){
			$search=$this->request->getQuery('search');
			$unitVariations->where([
							'OR' => [
									'Units.unit_name LIKE' => $search.'%',
									'UnitVariations.quantity_variation LIKE' => $search.'%'
								]
			]);
		}
		
		$units = $this->UnitVariations->Units->find('list');
        $unitVariations = $this->paginate($unitVariations);
		$paginate_limit=$this->paginate['limit'];
		$this->set(compact('unitVariations','unitVariation', 'units','paginate_limit'));
    }

    /**
     * View method
     *
     * @param string|null $id Unit Variation id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $unitVariation = $this->UnitVariations->get($id, [
            'contain' => ['Units']
        ]);

        $this->set('unitVariation', $unitVariation);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $unitVariation = $this->UnitVariations->newEntity();
        if ($this->request->is('post')) {
            $unitVariation = $this->UnitVariations->patchEntity($unitVariation, $this->request->getData());
            if ($this->UnitVariations->save($unitVariation)) {
                $this->Flash->success(__('The unit variation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The unit variation could not be saved. Please, try again.'));
        }
		
        $units = $this->UnitVariations->Units->find('list', ['limit' => 200]);
        $this->set(compact('unitVariation', 'units'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Unit Variation id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $unitVariation = $this->UnitVariations->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $unitVariation = $this->UnitVariations->patchEntity($unitVariation, $this->request->getData());
            if ($this->UnitVariations->save($unitVariation)) {
                $this->Flash->success(__('The unit variation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The unit variation could not be saved. Please, try again.'));
        }
        $units = $this->UnitVariations->Units->find('list', ['limit' => 200]);
        $this->set(compact('unitVariation', 'units'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Unit Variation id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($dir)
    {
        $this->request->allowMethod(['patch', 'post', 'put']);
		$id = $this->EncryptingDecrypting->decryptData($dir);
        $unitVariation = $this->UnitVariations->get($id);
		$unitVariation->status='Deactive';
        if ($this->UnitVariations->save($unitVariation)) {
            $this->Flash->success(__('The unit variation has been deleted.'));
        } else {
            $this->Flash->error(__('The unit variation could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
