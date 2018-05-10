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
		$this->Security->setConfig('unlockedActions', ['add','edit']);
	}
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
		$this->viewBuilder()->layout('admin_portal');
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
									'Promotions.description LIKE' => $search.'%',
									'Promotions.start_date LIKE' => $search.'%',
									'Promotions.end_date LIKE' => $search.'%',
									'Promotions.status LIKE' => $search.'%'
							]
			]);
		}
		
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
    public function view($id = null)
    {
        $promotion = $this->Promotions->get($id, [
            'contain' => ['Admins', 'Cities', 'PromotionDetails', 'Wallets']
        ]);

        $this->set('promotion', $promotion);
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
		$this->viewBuilder()->layout('admin_portal');
        $promotion = $this->Promotions->newEntity();
        if ($this->request->is('post')) {
            $promotion = $this->Promotions->patchEntity($promotion, $this->request->getData());
			$promotion->admin_id = $user_id;
			$promotion->status = 'Active';
			//pr($promotion);exit;
            if ($this->Promotions->save($promotion)) {
                $this->Flash->success(__('The promotion has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
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
        $this->request->allowMethod(['post', 'delete']);
		$id = $this->EncryptingDecrypting->decryptData($dir);
        $promotion = $this->Promotions->get($id,[
            'contain' => ['PromotionDetails']]);
        if ($this->Promotions->delete($promotion)) {
            $this->Flash->success(__('The promotion has been deleted.'));
        } else {
            $this->Flash->error(__('The promotion could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
