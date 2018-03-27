<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * SellerItems Controller
 *
 * @property \App\Model\Table\SellerItemsTable $SellerItems
 *
 * @method \App\Model\Entity\SellerItem[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SellerItemsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Items', 'Sellers']
        ];
        $sellerItems = $this->paginate($this->SellerItems);

        $this->set(compact('sellerItems'));
    }

    /**
     * View method
     *
     * @param string|null $id Seller Item id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $sellerItem = $this->SellerItems->get($id, [
            'contain' => ['Items', 'Sellers', 'SellerItemVariations']
        ]);

        $this->set('sellerItem', $sellerItem);
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
        $sellerItem = $this->SellerItems->newEntity();
        if ($this->request->is('post')) {
			$commissions=$this->request->getData('commissions');
			$item_ids=$this->request->getData('item_ids');
			$seller_id=$this->request->getData('seller_id');
			//pr($this->request->getData());
			//exit;
			$total_rows = sizeof($item_ids);
			
			$query = $this->SellerItems->query();
			$query->insert(['seller_id', 'item_id','commission_percentage']);
			for($i=0; $i<$total_rows; $i++)
			{
				$query->values([
					'seller_id' => $seller_id,
					'item_id' => $item_ids[$i],
					'commission_percentage' => $commissions[$i]
				]);
			}
            if ($query->execute()) {
                $this->Flash->success(__('The seller item has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The seller item could not be saved. Please, try again.'));
        }
        $categories = $this->SellerItems->Categories->find('threaded')->contain(['Items']);
        $sellers = $this->SellerItems->Sellers->find('list');
        $this->set(compact('sellerItem', 'categories', 'sellers'));
    }
	 public function itemVariation()
    {
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id'); 
		$location_id=$this->Auth->User('location_id');
		$this->viewBuilder()->layout('admin_portal');
        $itemVariation = $this->SellerItems->ItemVariations->newEntity();
        if ($this->request->is('post')) {
			$commissions=$this->request->getData('commissions');
			$item_ids=$this->request->getData('item_ids');
			$seller_id=$this->request->getData('seller_id');
			//pr($this->request->getData());
			//exit;
			$total_rows = sizeof($item_ids);
			
			$query = $this->SellerItems->query();
			$query->insert(['seller_id', 'item_id','commission_percentage']);
			for($i=0; $i<$total_rows; $i++)
			{
				$query->values([
					'seller_id' => $seller_id,
					'item_id' => $item_ids[$i],
					'commission_percentage' => $commissions[$i]
				]);
			}
            if ($query->execute()) {
                $this->Flash->success(__('The seller item has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The seller item could not be saved. Please, try again.'));
        }
		
		$sellerItems = $this->SellerItems->find()
							->where(['SellerItems.seller_id'=>$user_id]);
								
		foreach($sellerItems as $sellerItem)
		{
			$seller_item[]=$sellerItem->item_id;
		}
		$categories = $this->SellerItems->Categories->find('threaded');
							$categories->select(['total_item'=>$categories->func()->count('Items.id')])
							->innerJoinWith('Items',function($q) use($user_id,$seller_item){
									return $q->where(['Items.id IN'=>$seller_item]);
							})
							->contain(['Items'=>function($q) use($user_id,$seller_item){
								return $q->where(['Items.id IN'=>$seller_item])->contain(['ItemVariationMasters'=>['SellerItems','UnitVariations'=>['Units']]]);
							}
							])
							->group(['Categories.id'])
							->autoFields(true);
		//pr($categories->toArray());
		//exit;					
			
        $this->set(compact('itemVariation', 'categories'));
    }
    /**
     * Edit method
     *
     * @param string|null $id Seller Item id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $sellerItem = $this->SellerItems->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $sellerItem = $this->SellerItems->patchEntity($sellerItem, $this->request->getData());
            if ($this->SellerItems->save($sellerItem)) {
                $this->Flash->success(__('The seller item has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The seller item could not be saved. Please, try again.'));
        }
        $items = $this->SellerItems->Items->find('list', ['limit' => 200]);
        $categories = $this->SellerItems->Categories->find('list', ['limit' => 200]);
        $sellers = $this->SellerItems->Sellers->find('list', ['limit' => 200]);
        $this->set(compact('sellerItem', 'items', 'categories', 'sellers'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Seller Item id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $sellerItem = $this->SellerItems->get($id);
        if ($this->SellerItems->delete($sellerItem)) {
            $this->Flash->success(__('The seller item has been deleted.'));
        } else {
            $this->Flash->error(__('The seller item could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
