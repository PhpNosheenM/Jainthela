<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\View\View;
/**
 * PurchaseReturns Controller
 *
 * @property \App\Model\Table\PurchaseReturnsTable $PurchaseReturns
 *
 * @method \App\Model\Entity\PurchaseReturn[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PurchaseReturnsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
	public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Security->setConfig('unlockedActions', ['add','index']);

    }
	
    public function index()
    {

        $this->paginate = [
            'contain' => ['PurchaseInvoices', 'FinancialYears', 'Locations', 'SellerLedgers', 'PurchaseLedgers', 'Cities']
        ];
		
		
        $purchaseReturns = $this->paginate($this->PurchaseReturns);

        $this->set(compact('purchaseReturns'));
    }

    /**
     * View method
     *
     * @param string|null $id Purchase Return id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $purchaseReturn = $this->PurchaseReturns->get($id, [
            'contain' => ['PurchaseInvoices', 'FinancialYears', 'Locations', 'SellerLedgers', 'PurchaseLedgers', 'Cities', 'AccountingEntries', 'ItemLedgers', 'PurchaseReturnRows', 'ReferenceDetails']
        ]);

        $this->set('purchaseReturn', $purchaseReturn);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */

    public function add($invoice_id=null)
    { 
		$status=$this->request->query('status');
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id');
		$this->viewBuilder()->layout('super_admin_layout');
		
		$purchase_invoices=$this->PurchaseReturns->PurchaseInvoices->find()->where(['PurchaseInvoices.id'=>$invoice_id])->contain(['PurchaseInvoiceRows'=>['GrnRows'=>['Grns'],'Items'=>['GstFigures'],'ItemVariationsData'=>['Items'=>['GstFigures'],'UnitVariations'=>['Units']],'UnitVariations'=>['Units']]])->first();
		//pr($purchase_invoices->purchase_invoice_rows[0]->grn_row)
		$seller_type=$purchase_invoices->purchase_invoice_rows[0]->grn_row->grn->created_for;
		$CityData = $this->PurchaseReturns->PurchaseInvoices->Cities->get($city_id);
		$StateData = $this->PurchaseReturns->PurchaseInvoices->Cities->States->get($CityData->state_id);
		$Voucher_no = $this->PurchaseReturns->find()->select(['voucher_no'])->where(['PurchaseReturns.city_id'=>$city_id])->order(['voucher_no' => 'DESC'])->first();
		if($Voucher_no){$voucher_no=$Voucher_no->voucher_no+1;}
		else{$voucher_no=1;}
		$order_no=$CityData->alise_name.'/PR/'.$voucher_no;
		$voucher_no=$StateData->alias_name.'/'.$order_no;
		// pr($purchase_invoices); exit;
        $purchaseReturn = $this->PurchaseReturns->newEntity();
        if ($this->request->is('post')) {
            $purchaseReturn = $this->PurchaseReturns->patchEntity($purchaseReturn, $this->request->getData());
			$purchaseReturn->transaction_date = date('Y-m-d',strtotime($purchaseReturn->transaction_date));
			if($seller_type=="Seller"){
				
			}else{
				
			}
            if ($this->PurchaseReturns->save($purchaseReturn)) {
                $this->Flash->success(__('The purchase return has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The purchase return could not be saved. Please, try again.'));
        }
       
		$Partyledger = $this->PurchaseReturns->PurchaseInvoices->SellerLedgers->get($purchase_invoices->seller_ledger_id,['contain'=>['Cities']]);
			
		$partyOptions[]=['text' =>$Partyledger->name, 'value' => $Partyledger->id,'city_id'=>$Partyledger->city_id,'state_id'=>$Partyledger->city->state_id,'bill_to_bill_accounting'=>$Partyledger->bill_to_bill_accounting,'vendor_id'=>$Partyledger->vendor_id];
		
		$accountLedgers = $this->PurchaseReturns->PurchaseInvoices->AccountingGroups->find()->where(['AccountingGroups.purchase_invoice_purchase_account'=>1,'AccountingGroups.city_id'=>$city_id])->first();
		
		$accountingGroups2 = $this->PurchaseReturns->PurchaseInvoices->AccountingGroups
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
			$Accountledgers = $this->PurchaseReturns->PurchaseInvoices->AccountingGroups->Ledgers->find('list')->where(['Ledgers.accounting_group_id IN' =>$account_ids]);
        } //pr($Accountledgers->toArray()); exit;
        $this->set(compact('purchaseReturn', 'purchaseInvoices', 'financialYears', 'locations', 'sellerLedgers', 'purchaseLedgers', 'cities', 'purchase_invoices','partyOptions','Accountledgers','voucher_no'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Purchase Return id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $purchaseReturn = $this->PurchaseReturns->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $purchaseReturn = $this->PurchaseReturns->patchEntity($purchaseReturn, $this->request->getData());
            if ($this->PurchaseReturns->save($purchaseReturn)) {
                $this->Flash->success(__('The purchase return has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The purchase return could not be saved. Please, try again.'));
        }
        $purchaseInvoices = $this->PurchaseReturns->PurchaseInvoices->find('list', ['limit' => 200]);
        $financialYears = $this->PurchaseReturns->FinancialYears->find('list', ['limit' => 200]);
        $locations = $this->PurchaseReturns->Locations->find('list', ['limit' => 200]);
        $sellerLedgers = $this->PurchaseReturns->SellerLedgers->find('list', ['limit' => 200]);
        $purchaseLedgers = $this->PurchaseReturns->PurchaseLedgers->find('list', ['limit' => 200]);
        $cities = $this->PurchaseReturns->Cities->find('list', ['limit' => 200]);
        $this->set(compact('purchaseReturn', 'purchaseInvoices', 'financialYears', 'locations', 'sellerLedgers', 'purchaseLedgers', 'cities'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Purchase Return id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $purchaseReturn = $this->PurchaseReturns->get($id);
        if ($this->PurchaseReturns->delete($purchaseReturn)) {
            $this->Flash->success(__('The purchase return has been deleted.'));
        } else {
            $this->Flash->error(__('The purchase return could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
