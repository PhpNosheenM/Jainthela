<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\View\View;

/**
 * Sellers Controller
 *
 * @property \App\Model\Table\SellersTable $Sellers
 *
 * @method \App\Model\Entity\Seller[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SellersController extends AppController
{
	
	 public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Security->setConfig('unlockedActions', ['add']);

    }
	
	public function initialize()
	{
		parent::initialize();
		 $this->Auth->allow(['logout', 'login']);		
	}
	public function login()
    {
		$this->viewBuilder()->layout('seller_login');
        if ($this->request->is('post')) 
		{
			$user = $this->Auth->identify();
			if ($user) 
			{
				$city = $this->Sellers->Locations->get($user['location_id']);
				$user['city_id']=$city->id;
				$user['user_role']='seller';
				$this->Auth->setUser($user);
				return $this->redirect(['controller'=>'Sellers','action' => 'index']);
            }
            $this->Flash->error(__('Invalid Username or Password'));
        }	
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id'); 
		$location_id=$this->Auth->User('location_id'); 
		$this->viewBuilder()->layout('admin_portal');
        $this->paginate = [
			'limit' => 20
        ];
        $sellers = $this->Sellers->find()->where(['Sellers.location_id'=>$location_id]);
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
		$location_id=$this->Auth->User('location_id'); 
		$this->viewBuilder()->layout('admin_portal');
        $seller = $this->Sellers->newEntity();
        if ($this->request->is('post')) {
			
            $seller = $this->Sellers->patchEntity($seller, $this->request->getData());
			$seller->city_id=$city_id;
			$seller->created_by=$user_id;
			$seller->registration_date=date('Y-m-d');
			$bill_to_bill_accounting=$seller->bill_to_bill_accounting;
			$data=$this->Sellers->Locations->get($location_id);
			if(!empty($seller->reference_details))
				{
					foreach($seller->reference_details as $reference_detail)
					{
						//$data=$this->Sellers->Locations->get($location_id);
						$reference_detail->transaction_date = $data->books_beginning_from;
						$reference_detail->opening_balance = 'yes';
						
					}
				}
			//pr($seller); exit;
			 if ($this->Sellers->save($seller)) { 
				
				$accounting_group = $this->Sellers->Ledgers->AccountingGroups->find()->where(['supplier'=>1])->first();
				$ledger = $this->Sellers->Ledgers->newEntity();
				$ledger->name = $seller->firm_name;
				$ledger->accounting_group_id = $accounting_group->id;
				$ledger->seller_id=$seller->id;
				$ledger->bill_to_bill_accounting=$bill_to_bill_accounting;
				
				if($this->Sellers->Ledgers->save($ledger))
				{
					$query=$this->Sellers->ReferenceDetails->query();
						$result = $query->update()
						->set(['ledger_id' => $ledger->id])
						->where(['seller_id' => $seller->id])
						->execute();
					//Create Accounting Entry//
			        $transaction_date=$data->books_beginning_from;
					$AccountingEntry = $this->Sellers->Ledgers->AccountingEntries->newEntity();
					$AccountingEntry->ledger_id        = $ledger->id;
					if($seller->debit_credit=="Dr")
					{
						$AccountingEntry->debit        = $seller->opening_balance_value;
					}
					if($seller->debit_credit=="Cr")
					{
						$AccountingEntry->credit       = $seller->opening_balance_value;
					}
					$AccountingEntry->transaction_date = date("Y-m-d",strtotime($transaction_date));
					$AccountingEntry->location_id       = $location_id;
					$AccountingEntry->city_id       = $city_id;
					$AccountingEntry->is_opening_balance = 'yes';
					if($seller->opening_balance_value){
					$this->Sellers->Ledgers->AccountingEntries->save($AccountingEntry);
					}
				}
                $this->Flash->success(__('The seller has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
			 
            $this->Flash->error(__('The seller could not be saved. Please, try again.'));
        }
		//$categories = $this->Sellers->Categories->find('threaded')->contain(['Items']);
		
		$locations = $this->Sellers->Locations->find('list');
        
        $this->set(compact('seller','locations'));
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
	
	  public function sellerItem($id = null)
    {
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id'); 
		$this->viewBuilder()->layout('admin_portal');
		$id=6;
		$seller = $this->Sellers->get($id);
		$Categories = $this->Sellers->Categories->find()->where(['city_id'=>$city_id,'parent_id IS NULL']);
		
		if ($this->request->is(['patch', 'post', 'put'])) {
			$seller = $this->Sellers->patchEntity($seller, $this->request->getData());
			foreach($seller->seller_items as $seller_item){
				if($seller_item->check==1){
					$SellerItem = $this->Sellers->SellerItems->newEntity();
					$SellerItem->category_id = $seller_item->category_id;
					$SellerItem->commission_percentage = $seller_item->commission_percentage;
					$SellerItem->seller_id = $id;
					$SellerItem->created_by = $user_id;
					$SellerItem->created_on = date("Y-m-d");
					$SellerItem->commission_created_on = date("Y-m-d");
					$SellerItem->status ="Active";
					$this->Sellers->SellerItems->save($SellerItem);
					//pr($SellerItem); exit;
				}
			} // exit;
			$this->Flash->success(__('The seller has been saved.'));
			return $this->redirect(['action' => 'sellerItem']);
            
          
			//
		}
		
		
		$childrens = $this->Sellers->Categories
			 ->find('threaded')
			->toArray();
		//pr($children); exit;
		$this->set(compact('seller','Categories','childrens'));
		//exit;
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
