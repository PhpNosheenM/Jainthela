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
        $this->Security->setConfig('unlockedActions', ['index','addd']);

    }
    public function index($id = null)
    {
		$city_id=$this->Auth->User('city_id');
		$user_id=$this->Auth->User('id');
		$this->viewBuilder()->layout('super_admin_layout');
		$status=$this->request->query('status');
        $this->paginate = [
            'contain' => ['Units'],
			'limit' => 100
        ];
		
		if($id)
		{
		   $id = $this->EncryptingDecrypting->decryptData($id);
		}
		 if(!empty($status)){
			 $unitVariations = $this->UnitVariations->find()->where(['UnitVariations.city_id'=>$city_id,'UnitVariations.status'=>$status]);
			// $brands = $this->Brands->find()->where(['city_id'=>$city_id,'status'=>$status]);
		 }else{
			 $unitVariations = $this->UnitVariations->find()->where(['UnitVariations.city_id'=>$city_id,'UnitVariations.status'=>'Active']);
			
		 }
		
		//$unitVariations = $this->UnitVariations->find()->where(['UnitVariations.city_id'=>$city_id]);
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
		//	pr($unitVariation); exit;
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
		
		$units1 = $this->UnitVariations->Units->find()->where(['Units.city_id'=>$city_id]);
		foreach($units1 as $data){
			$units[]=['value'=>$data->id,'text'=>$data->shortname];
			
		}
		$variations=[];
		$variations[]=['text'=>1,'value'=>1];
		$i=5;			
		for($j=5; $j <1000 ; $j++){
			if($i < 1000)
			{
				$variations[]=['text'=>$i,'value'=>$i];
				$i = $i+5;
			}   
		}
		
        $unitVariations = $this->paginate($unitVariations);
		$paginate_limit=$this->paginate['limit'];
		$this->set(compact('unitVariations','unitVariation', 'units','paginate_limit','status','search','variations'));
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
	
	public function addd(){
	
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id');
		$unitVariation= $this->UnitVariations->newEntity();
		//echo "rere"; exit;
        if ($this->request->is('post')) {
			
			$unitVariation = $this->UnitVariations->patchEntity($unitVariation, $this->request->getData());
			
			$quantity_variation=$unitVariation->quantity_variation;
			$unit_id=$unitVariation->unit_id;
			$unit_data = $this->UnitVariations->Units->find()->where(['Units.id'=>$unit_id])->first();
			$division_factor=$unit_data->division_factor;
			$convert_unit_qty=$quantity_variation/$division_factor;
			
			$unitVariation->convert_unit_qty=$convert_unit_qty;
			$unitVariation->status="Active";
			$unitVariation->created_by=$user_id;
			$unitVariation->city_id=$city_id;
			
            if ($unitVariation=$this->UnitVariations->save($unitVariation)) {
				$arr = array('option' => '<option value="'.$unitVariation->id.'">'.$unitVariation->visible_variation.'</option>', 'unit_variation_id' => $unitVariation->id);
				echo json_encode($arr);
            } else{
				
			}
           
        }
	exit;
	}
}
