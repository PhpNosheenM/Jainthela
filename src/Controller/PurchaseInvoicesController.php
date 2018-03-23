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
		$LocationData = $this->PurchaseInvoices->Locations->get($location_id);
		$Voucher_no = $this->PurchaseInvoices->find()->select(['voucher_no'])->where(['PurchaseInvoices.location_id'=>$location_id])->order(['voucher_no' => 'DESC'])->first();
		if($Voucher_no)
		{
			$voucher_no=$Voucher_no->voucher_no+1;
		}
		else
		{
			$voucher_no=1;
		}
		//pr($voucher_no); exit;
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
			$partyOptions[]=['text' =>$Partyledger->name, 'value' => $Partyledger->id,'city_id'=>$Partyledger->seller->city_id,'state_id'=>$Partyledger->seller->city->state_id,'bill_to_bill_accounting'=>$Partyledger->bill_to_bill_accounting,'seller_id'=>$Partyledger->seller_id];
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
       /*  $item1 = $this->PurchaseInvoices->Items->ItemVariations->find()->contain(['Items'=>['UnitVariations','Sellers']]);
		//pr($item1->toArray()); exit;
		$items=array();
				foreach($item1 as $data){
					pr($data); exit;
					$merge=$data->item->name.'('.$data->unit_variation->unit->shortname.')';
					$items[]=['text' => $merge,'value' => $data->id,'division_factor' => $data->unit_variation->convert_unit_qty];

				} */


        $GstFigures1 = $this->PurchaseInvoices->GstFigures->find();
		$GstFigures=array();
				foreach($GstFigures1 as $data){
					$GstFigures[]=['text' => $data->name,'value' => $data->id,'tax_percentage' => $data->tax_percentage];
				}
        $this->set(compact('purchaseInvoice', 'locations', 'partyOptions', 'Accountledgers', 'items','GstFigures','voucher_no','LocationData'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Purchase Invoice id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function SelectItemSellerWise($id = null)
    {
		$Sellertem=$this->PurchaseInvoices->Items->ItemVariations->find()->contain(['Items'=>['ItemVariations'=>['UnitVariations'=>['Units']]]])->where(['ItemVariations.seller_id'=>$id,'ItemVariations.status'=>'Active']);

		$items=array();
		foreach($Sellertem as $data){
		if($data->item->item_maintain_by=="itemwise"){
			$merge=$data->item->name;
			$p=@$data->item->item_variations[0]->unit_variation->quantity_variation/@$data->item->item_variations[0]->unit_variation->convert_unit_qty;
			@$quantity_factor=(@$p/@$data->item->item_variations[0]->unit_variation->unit->division_factor);
			//pr(@$quantity_factor); exit;
			$items[]=['text' => $merge,'value' =>0,'item_id'=>$data->item->id,'quantity_factor'=>@$quantity_factor,'unit'=>@$data->item->item_variations[0]->unit_variation->unit->print_unit,'gst_figure_id'=>$data->item->gst_figure_id,'commission'=>@$data->item->item_variations[0]->commission];
		}else{
			$merge=$data->item->name.'('.@$data->item->item_variations[0]->unit_variation->convert_unit_qty.'.'.@$data->item->item_variations[0]->unit_variation->unit->print_unit.')';
			$items[]=['text' => $merge,'value' => $data->id,'item_id'=>$data->item->id,'quantity_factor'=>@$data->item->item_variations[0]->unit_variation->convert_unit_qty,'unit'=>@$data->item->item_variations[0]->unit_variation->unit->print_unit,'gst_figure_id'=>$data->item->gst_figure_id,'commission'=>@$data->item->item_variations[0]->commission];
			}
		}
		$itemSize=sizeof($items);
	//	pr($items);exit;
		 $this->set(compact('items','itemSize'));
		//pr($items);exit;
	}

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
