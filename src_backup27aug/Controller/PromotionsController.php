<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\View\View;
/**
 * Promotions Controller
 *
 * @property \App\Model\Table\PromotionsTable $Promotions
 *
 * @method \App\Model\Entity\Promotion[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PromotionsController extends AppController
{
	public function beforeFilter(Event $event)
	{
		parent::beforeFilter($event);
		$this->Security->setConfig('unlockedActions', ['add','index','view']);
	}
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
		$user_type =$this->Auth->User('user_type');
		if($user_type=="Super Admin"){
		$this->viewBuilder()->layout('super_admin_layout');
		}else if($user_type=="Admin"){ 
		$this->viewBuilder()->layout('admin_portal');
		}
        $this->paginate = [
            'contain' => ['Admins', 'Cities'],
			'limit' => 20
        ];
		$promotions = $this->Promotions->find();
		
		 if ($this->request->is(['get'])){
			$search=$this->request->getQuery('search');
			$promotions->where([
							'OR' => [
									'Promotions.offer_name LIKE' => $search.'%',
									'Admins.name LIKE' => $search.'%',
									'Cities.name LIKE' => $search.'%',
									'Promotions.description LIKE' => $search.'%',
									'Promotions.start_date LIKE' => $search.'%',
									'Promotions.end_date LIKE' => $search.'%',
									'Promotions.status LIKE' => $search.'%'
							]
			]);
		} 
		//pr($promotions->toArray()); exit;
        $promotions = $this->paginate($promotions);
		$paginate_limit=$this->paginate['limit'];
        $this->set(compact('promotions','paginate_limit','search'));
    }

    /**
     * View method
     *
     * @param string|null $id Promotion id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($ids = null)
    {
		if($ids)
		{
		   $id = $this->EncryptingDecrypting->decryptData($ids);
		}
		
		$user_id=$this->Auth->User('id');
		$user_type=$this->Auth->User('user_type');
		if($user_type=="Super Admin"){
			$this->viewBuilder()->layout('super_admin_layout');
		}else{
			$this->viewBuilder()->layout('admin_portal');
		}
		
        $promotions = $this->Promotions->get($id, [
            'contain' => ['Admins', 'Cities', 'PromotionDetails'=>['Orders'=>['Customers'],'Categories','Items']]
        ]);
			
		//pr($promotions->toArray()); exit;	
        $this->set('promotions', $promotions);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
	 
	
	 
	 
    public function add()
    {
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id');
		$location_id=$this->Auth->User('location_id');
		$user_type =$this->Auth->User('user_type');
		if($user_type=="Super Admin"){
		$this->viewBuilder()->layout('super_admin_layout');
		}else if($user_type=="Admin"){ 
		$this->viewBuilder()->layout('admin_portal');
		}

        $promotion = $this->Promotions->newEntity();
        if ($this->request->is('post')) {
            $promotion = $this->Promotions->patchEntity($promotion, $this->request->getData());
			$promotion->admin_id = $user_id;
			$promotion->status = 'Active';
			//pr($promotion); exit;
			
 			/* echo'<table style="width:100%">';
			
			for($i=1;$i<=10000;$i++)
			{
				if($i==1)
				{
					$query = $this->Promotions->newEntity();
					$query->offer_name = $promotion->offer_name;
					$query->city_id = $promotion->city_id;
					$query->start_date = $promotion->start_date;
					$query->end_date = $promotion->end_date;
					$query->description = $promotion->description;
					$query->admin_id = $promotion->admin_id;
					$query->status = $promotion->status;					
					$result = $this->Promotions->save($query);
					$id = $result->id;		
				}
				$code = strtoupper(substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 8));
				
				$ProDetail = $this->Promotions->PromotionDetails->newEntity();
				$ProDetail->promotion_id = $id;
				$ProDetail->coupon_name = 'JT-10-'.$code;
				$ProDetail->coupon_code = $code;
				$ProDetail->discount_in_amount = 10;
				$ProDetail->discount_of_max_amount = 10;
				$resultDetail = $this->Promotions->PromotionDetails->save($ProDetail);

				
				echo '<tr>';
				echo '<td>'.$code.'</td>';
				echo '</tr>';
				
			}
			echo '</table>';
			exit; */	 
			
			
            if ($this->Promotions->save($promotion)) {
                $this->Flash->success(__('The promotion has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
			//pr($promotion);exit;
            $this->Flash->error(__('The promotion could not be saved. Please, try again.'));
        }
        $categories = $this->Promotions->PromotionDetails->Categories->find('list')->where(['Categories.status'=>'Active']);
        $items = $this->Promotions->PromotionDetails->Items->find('list')->where(['Items.status'=>'Active']);
        $cities = $this->Promotions->Cities->find('list')->where(['Cities.status'=>'Active']);
        $this->set(compact('promotion','user_id','city_id','categories','items','cities'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Promotion id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
		if($id)
		{
		   $id = $this->EncryptingDecrypting->decryptData($id);
		}
		
		$this->viewBuilder()->layout('admin_portal');
        $promotion = $this->Promotions->get($id, [
            'contain' => ['PromotionDetails']
        ]);
		
        if ($this->request->is(['patch', 'post', 'put'])) {
            $promotion = $this->Promotions->patchEntity($promotion, $this->request->getData());
            if ($this->Promotions->save($promotion)) {
                $this->Flash->success(__('The promotion has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The promotion could not be saved. Please, try again.'));
        }
        $categories = $this->Promotions->PromotionDetails->Categories->find('list')->where(['Categories.status'=>'Active']);
        $items = $this->Promotions->PromotionDetails->Items->find('list')->where(['Items.status'=>'Active']);
        $cities = $this->Promotions->Cities->find('list')->where(['Cities.status'=>'Active']);
        $this->set(compact('promotion', 'items', 'cities','categories'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Promotion id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($dir)
    {
        $this->request->allowMethod(['patch', 'post', 'put']);
		$id = $this->EncryptingDecrypting->decryptData($dir);
        $promotion = $this->Promotions->get($id);
		$promotion->status='Deactive';
        if ($this->Promotions->save($promotion)) {
            $this->Flash->success(__('The promotion has been deleted.'));
        } else {
            $this->Flash->error(__('The promotion could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
