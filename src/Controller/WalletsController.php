<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Wallets Controller
 *
 * @property \App\Model\Table\WalletsTable $Wallets
 *
 * @method \App\Model\Entity\Wallet[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class WalletsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index($id=null)
    {
		$city_id=$this->Auth->User('city_id'); 
		$user_id=$this->Auth->User('id');
		$this->viewBuilder()->layout('admin_portal');
		 $this->paginate = [
            'contain' => ['Customers',   'Plans' ],
			'limit' =>20
        ];
		 
		$wallets1 = $this->Wallets->find();
		 $wallets1->select([
					'tot_add_amount' => $wallets1->func()->sum('add_amount'),
					'tot_used_amount' => $wallets1->func()->sum('used_amount'),'customer_id',
				])->group(['customer_id']);
				pr($wallets1->toArray()); exit;
        if($id)
		{
		    $wallet = $this->Wallets->get($id);
		}
		else
		{
			 $wallet = $this->Wallets->newEntity();
		}

        if ($this->request->is(['post','put'])) {
            $wallet = $this->Wallets->patchEntity($wallet, $this->request->getData());
			$wallet->amount_type="plan";
			$wallet->transaction_type="Added";
			$wallet->city_id=$city_id;
			if($id)
			{
				$wallet->id=$id;
			}
            if ($this->Wallets->save($wallet)) {
                $this->Flash->success(__('The wallet has been saved.'));
				return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The wallet could not be saved. Please, try again.'));
        }
		/* else if ($this->request->is(['get'])){
			$search=$this->request->getQuery('search');
			$wallets1->where([
							'OR' => [
									'Plans.name LIKE' => $search.'%',
									'Plans.amount LIKE' => $search.'%',
									'Plans.benifit_per LIKE' => $search.'%',
									'Plans.total_amount LIKE' => $search.'%',
									'Plans.status LIKE' => $search.'%'
							]
			]);
		} */

        $wallets = $this->paginate($wallets1);
		$customers=$this->Wallets->Customers->find('list');
		$plans1=$this->Wallets->Plans->find();
		$paginate_limit=$this->paginate['limit'];
		
		foreach($plans1 as $data){
			$plan_name=$data->name;
			$total_amount=$data->total_amount;
			$amount=$data->amount;
			$plans[]= ['value'=>$data->id,'text'=>$plan_name." (Rs-".$amount.")", 'total_amount'=>$total_amount];
		}
		
        $this->set(compact('wallets','wallet','states','paginate_limit','customers','plans'));
		
		
     /*    $this->paginate = [
            'contain' => ['Customers', 'Orders', 'Plans', 'Promotions', 'ReturnOrders']
        ];
        $wallets = $this->paginate($this->Wallets);

        $this->set(compact('wallets')); */
    }

    /**
     * View method
     *
     * @param string|null $id Wallet id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $wallet = $this->Wallets->get($id, [
            'contain' => ['Customers', 'Orders', 'Plans', 'Promotions', 'ReturnOrders']
        ]);

        $this->set('wallet', $wallet);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $wallet = $this->Wallets->newEntity();
        if ($this->request->is('post')) {
            $wallet = $this->Wallets->patchEntity($wallet, $this->request->getData());
            if ($this->Wallets->save($wallet)) {
                $this->Flash->success(__('The wallet has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The wallet could not be saved. Please, try again.'));
        }
        $customers = $this->Wallets->Customers->find('list', ['limit' => 200]);
        $orders = $this->Wallets->Orders->find('list', ['limit' => 200]);
        $plans = $this->Wallets->Plans->find('list', ['limit' => 200]);
        $promotions = $this->Wallets->Promotions->find('list', ['limit' => 200]);
        $returnOrders = $this->Wallets->ReturnOrders->find('list', ['limit' => 200]);
        $this->set(compact('wallet', 'customers', 'orders', 'plans', 'promotions', 'returnOrders'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Wallet id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $wallet = $this->Wallets->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $wallet = $this->Wallets->patchEntity($wallet, $this->request->getData());
            if ($this->Wallets->save($wallet)) {
                $this->Flash->success(__('The wallet has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The wallet could not be saved. Please, try again.'));
        }
        $customers = $this->Wallets->Customers->find('list', ['limit' => 200]);
        $orders = $this->Wallets->Orders->find('list', ['limit' => 200]);
        $plans = $this->Wallets->Plans->find('list', ['limit' => 200]);
        $promotions = $this->Wallets->Promotions->find('list', ['limit' => 200]);
        $returnOrders = $this->Wallets->ReturnOrders->find('list', ['limit' => 200]);
        $this->set(compact('wallet', 'customers', 'orders', 'plans', 'promotions', 'returnOrders'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Wallet id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $wallet = $this->Wallets->get($id);
        if ($this->Wallets->delete($wallet)) {
            $this->Flash->success(__('The wallet has been deleted.'));
        } else {
            $this->Flash->error(__('The wallet could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
