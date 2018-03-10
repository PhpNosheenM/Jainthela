<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Sellers Controller
 *
 * @property \App\Model\Table\SellersTable $Sellers
 *
 * @method \App\Model\Entity\Seller[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SellersController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id'); 
		$this->viewBuilder()->layout('admin_portal');
        $this->paginate = [
            'contain' => ['Cities'],
			'limit' => 20
        ];
        $sellers = $this->Sellers->find()->where(['Sellers.city_id'=>$city_id]);
		if ($this->request->is(['get'])){
			$search=$this->request->getQuery('search');
			$sellers->where([
							'OR' => [
									'Sellers.name LIKE' => $search.'%',
									'Sellers.status LIKE' => $search.'%',
									'Sellers.firm_name LIKE' => $search.'%',
									'Sellers.email LIKE' => $search.'%',
									'Sellers.mobile_no LIKE' => $search.'%',
									'Sellers.gstin LIKE' => $search.'%',
									'Sellers.gstin_holder_name LIKE' => $search.'%',
									'Sellers.registration_date' => $search.'%'
							]
			]);
		}
		$sellers= $this->paginate($sellers);
		$paginate_limit=$this->paginate['limit'];
        $this->set(compact('sellers','paginate_limit'));
    }

    /**
     * View method
     *
     * @param string|null $id Seller id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
		
        $seller = $this->Sellers->get($id, [
            'contain' => ['Cities','Items', 'SellerItems', 'SellerRatings']
        ]);

        $this->set('seller', $seller);
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
		$this->viewBuilder()->layout('admin_portal');
        $seller = $this->Sellers->newEntity();
        if ($this->request->is('post')) {
			
            $seller = $this->Sellers->patchEntity($seller, $this->request->getData());
			$seller->city_id=$city_id;
			$seller->created_by=$user_id;
			$seller->registration_date=date('Y-m-d');
            if ($this->Sellers->save($seller)) {
                $this->Flash->success(__('The seller has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
			//pr($seller); exit;
            $this->Flash->error(__('The seller could not be saved. Please, try again.'));
        }
        
        $this->set(compact('seller'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Seller id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id'); 
		$this->viewBuilder()->layout('admin_portal');
        $seller = $this->Sellers->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $seller = $this->Sellers->patchEntity($seller, $this->request->getData());
            if ($this->Sellers->save($seller)) {
                $this->Flash->success(__('The seller has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The seller could not be saved. Please, try again.'));
        }
     
        $this->set(compact('seller'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Seller id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $seller = $this->Sellers->get($id);
        if ($this->Sellers->delete($seller)) {
            $this->Flash->success(__('The seller has been deleted.'));
        } else {
            $this->Flash->error(__('The seller could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
