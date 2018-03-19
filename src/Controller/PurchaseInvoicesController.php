<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * PurchaseInvoices Controller
 *
 * @property \App\Model\Table\PurchaseInvoicesTable $PurchaseInvoices
 *
 * @method \App\Model\Entity\PurchaseInvoice[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PurchaseInvoicesController extends AppController
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
		$location_id=$this->Auth->User('location_id'); 
		$this->viewBuilder()->layout('admin_portal');
        $this->paginate = [
            'contain' => ['Locations', 'Cities']
        ];
        $purchaseInvoices = $this->paginate($this->PurchaseInvoices);

        $this->set(compact('purchaseInvoices'));
    }

    /**
     * View method
     *
     * @param string|null $id Purchase Invoice id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $purchaseInvoice = $this->PurchaseInvoices->get($id, [
            'contain' => ['Locations', 'SellerLedgers', 'PurchaseLedgers', 'Cities', 'AccountingEntries', 'ItemLedgers', 'PurchaseInvoiceRows', 'PurchaseReturns', 'ReferenceDetails']
        ]);

        $this->set('purchaseInvoice', $purchaseInvoice);
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
        $purchaseInvoice = $this->PurchaseInvoices->newEntity();
        if ($this->request->is('post')) {
            $purchaseInvoice = $this->PurchaseInvoices->patchEntity($purchaseInvoice, $this->request->getData());
            if ($this->PurchaseInvoices->save($purchaseInvoice)) {
                $this->Flash->success(__('The purchase invoice has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The purchase invoice could not be saved. Please, try again.'));
        }
       
	   $partyParentGroups = $this->PurchaseInvoices->AccountingGroups->find()
						->where(['AccountingGroups.
						purchase_invoice_party'=>'1']);
		//pr($partyParentGroups->toArray()); exit;
		$partyGroups=[];
		

		foreach($partyParentGroups as $partyParentGroup)
		{
			$accountingGroups = $this->PurchaseInvoices->AccountingGroups
			->find('children', ['for' => $partyParentGroup->id])->toArray();
			$partyGroups[]=$partyParentGroup->id;
			foreach($accountingGroups as $accountingGroup){
				$partyGroups[]=$accountingGroup->id;
			}
		}
		if($partyGroups)
		{  
			$Partyledgers = $this->PurchaseInvoices->SellerLedgers->find()
							->where(['SellerLedgers.accounting_group_id IN' =>$partyGroups])
							->contain(['Sellers'=>['Cities']]);
        }
		$partyOptions=[];
		foreach($Partyledgers as $Partyledger){ 
			$partyOptions[]=['text' =>$Partyledger->name, 'value' => $Partyledger->id,'city_id'=>$Partyledger->seller->city_id,'state_id'=>$Partyledger->seller->city->state_id,'bill_to_bill_accounting'=>$Partyledger->bill_to_bill_accounting];
		}
		
		$accountLedgers = $this->PurchaseInvoices->AccountingGroups->find()->where(['AccountingGroups.purchase_invoice_purchase_account'=>1])->first();

		$accountingGroups2 = $this->PurchaseInvoices->AccountingGroups
		->find('children', ['for' => $accountLedgers->id])
		->find('List')->toArray();
		
		$accountingGroups2[$accountLedgers->id]=$accountLedgers->name;
		ksort($accountingGroups2); 
		if($accountingGroups2)
		{   
			$account_ids="";
			foreach($accountingGroups2 as $key=>$accountingGroup)
			{
				$account_ids .=$key.',';
			}
			$account_ids = explode(",",trim($account_ids,','));
			$Accountledgers = $this->PurchaseInvoices->AccountingGroups->Ledgers->find('list')->where(['Ledgers.accounting_group_id IN' =>$account_ids]);
        }
		//pr($Accountledgers->toArray()); exit;
		
		//pr($partyOptions); exit;
        $items = $this->PurchaseInvoices->Items->find('list');
        $GstFigures = $this->PurchaseInvoices->GstFigures->find('list');
        $this->set(compact('purchaseInvoice', 'locations', 'partyOptions', 'Accountledgers', 'items','GstFigures'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Purchase Invoice id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $purchaseInvoice = $this->PurchaseInvoices->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $purchaseInvoice = $this->PurchaseInvoices->patchEntity($purchaseInvoice, $this->request->getData());
            if ($this->PurchaseInvoices->save($purchaseInvoice)) {
                $this->Flash->success(__('The purchase invoice has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The purchase invoice could not be saved. Please, try again.'));
        }
        $locations = $this->PurchaseInvoices->Locations->find('list', ['limit' => 200]);
        $sellerLedgers = $this->PurchaseInvoices->SellerLedgers->find('list', ['limit' => 200]);
        $purchaseLedgers = $this->PurchaseInvoices->PurchaseLedgers->find('list', ['limit' => 200]);
        $cities = $this->PurchaseInvoices->Cities->find('list', ['limit' => 200]);
        $this->set(compact('purchaseInvoice', 'locations', 'sellerLedgers', 'purchaseLedgers', 'cities'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Purchase Invoice id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $purchaseInvoice = $this->PurchaseInvoices->get($id);
        if ($this->PurchaseInvoices->delete($purchaseInvoice)) {
            $this->Flash->success(__('The purchase invoice has been deleted.'));
        } else {
            $this->Flash->error(__('The purchase invoice could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
