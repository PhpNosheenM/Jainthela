<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Suppliers Controller
 *
 * @property \App\Model\Table\SuppliersTable $Suppliers
 *
 * @method \App\Model\Entity\Supplier[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SuppliersController extends AppController
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
            'contain' => ['Locations', 'Cities'],
			'limit' => 20
        ];
		
		$suppliers = $this->Suppliers->find()->where(['Suppliers.city_id'=>$city_id]);
		if ($this->request->is(['get'])){
			$search=$this->request->getQuery('search'); 
			$suppliers->where([
							'OR' => [
									'Suppliers.name LIKE' => $search.'%',
									'Suppliers.email LIKE' => $search.'%',
									'Suppliers.mobile_no LIKE' => $search.'%'
									
							]
			]);
		//	pr($suppliers->toArray()); exit;
		}
        $suppliers = $this->paginate($suppliers);
		$paginate_limit=$this->paginate['limit'];
        $this->set(compact('suppliers','paginate_limit'));
    }

    /**
     * View method
     *
     * @param string|null $id Supplier id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $supplier = $this->Suppliers->get($id, [
            'contain' => ['Locations', 'Cities', 'Ledgers', 'ReferenceDetails']
        ]);

        $this->set('supplier', $supplier);
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
		//$location_id=$this->Auth->User('location_id'); 
		$this->viewBuilder()->layout('admin_portal');
        $supplier = $this->Suppliers->newEntity();
        if ($this->request->is('post')) {
            $supplier = $this->Suppliers->patchEntity($supplier, $this->request->getData());
			$supplier->created_by=$user_id; 
			$supplier->created_on=date("Y-m-d"); 
			$bill_to_bill_accounting=$supplier->bill_to_bill_accounting;
			$data=$this->Suppliers->Locations->get($supplier->location_id);
			if(!empty($supplier->reference_details))
				{
					foreach($supplier->reference_details as $reference_detail)
					{
						//$data=$this->Sellers->Locations->get($location_id);
						$reference_detail->transaction_date = $data->books_beginning_from;
						$reference_detail->opening_balance = 'yes';
						
					}
				}
			//pr($supplier); exit;
			if ($this->Suppliers->save($supplier)) {
				
				$accounting_group = $this->Suppliers->Ledgers->AccountingGroups->find()->where(['supplier'=>1])->first();
				$ledger = $this->Suppliers->Ledgers->newEntity();
				$ledger->name = $supplier->firm_name;
				$ledger->accounting_group_id = $accounting_group->id;
				$ledger->supplier_id=$supplier->id;
				$ledger->bill_to_bill_accounting=$bill_to_bill_accounting;
				
				if($this->Suppliers->Ledgers->save($ledger))
				{
					$query=$this->Suppliers->ReferenceDetails->query();
						$result = $query->update()
						->set(['ledger_id' => $ledger->id])
						->where(['supplier_id' => $supplier->id])
						->execute();
					//Create Accounting Entry//
			        $transaction_date=$data->books_beginning_from;
					$AccountingEntry = $this->Suppliers->Ledgers->AccountingEntries->newEntity();
					$AccountingEntry->ledger_id        = $ledger->id;
					if($supplier->debit_credit=="Dr")
					{
						$AccountingEntry->debit        = $supplier->opening_balance_value;
					}
					if($supplier->debit_credit=="Cr")
					{
						$AccountingEntry->credit       = $supplier->opening_balance_value;
					}
					$AccountingEntry->transaction_date = date("Y-m-d",strtotime($transaction_date));
					$AccountingEntry->location_id       = $supplier->location_id;
					$AccountingEntry->city_id       = $city_id;
					$AccountingEntry->is_opening_balance = 'yes';
					if($supplier->opening_balance_value){
					$this->Suppliers->Ledgers->AccountingEntries->save($AccountingEntry);
					}
				}
				
                $this->Flash->success(__('The supplier has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The supplier could not be saved. Please, try again.'));
        }
        $locations = $this->Suppliers->Locations->find('list', ['limit' => 200]);
        $cities = $this->Suppliers->Cities->find('list', ['limit' => 200]);
        $this->set(compact('supplier', 'locations', 'cities'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Supplier id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $supplier = $this->Suppliers->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $supplier = $this->Suppliers->patchEntity($supplier, $this->request->getData());
            if ($this->Suppliers->save($supplier)) {
                $this->Flash->success(__('The supplier has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The supplier could not be saved. Please, try again.'));
        }
        $locations = $this->Suppliers->Locations->find('list', ['limit' => 200]);
        $cities = $this->Suppliers->Cities->find('list', ['limit' => 200]);
        $this->set(compact('supplier', 'locations', 'cities'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Supplier id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $supplier = $this->Suppliers->get($id);
        if ($this->Suppliers->delete($supplier)) {
            $this->Flash->success(__('The supplier has been deleted.'));
        } else {
            $this->Flash->error(__('The supplier could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
