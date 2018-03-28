<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * SellerRequests Controller
 *
 * @property \App\Model\Table\SellerRequestsTable $SellerRequests
 *
 * @method \App\Model\Entity\SellerRequest[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SellerRequestsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
		$this->viewBuilder()->layout('admin_portal');
		$city_id=$this->Auth->User('city_id'); 
		$location_id=$this->Auth->User('location_id'); 
		$seller_id=$this->Auth->User('id'); 
        $this->paginate = [
            'contain' => ['Sellers', 'Locations'],
			'limit' => 20
        ];
        $sellerRequests = $this->paginate($this->SellerRequests->find()->where(['seller_id'=>$seller_id]));
		$paginate_limit=$this->paginate['limit'];
        $this->set(compact('sellerRequests','paginate_limit'));
    }
	
	 public function pendingItemRequest()
    {
		$this->viewBuilder()->layout('admin_portal');
		$city_id=$this->Auth->User('city_id'); 
		$location_id=$this->Auth->User('location_id'); 
		$seller_id=$this->Auth->User('id'); 
        $this->paginate = [
            'contain' => ['Sellers', 'Locations'],
			'limit' => 20
        ];
        $sellerRequests = $this->paginate($this->SellerRequests->find()->where(['SellerRequests.status'=>"Pending"]));
		$paginate_limit=$this->paginate['limit'];
        $this->set(compact('sellerRequests','paginate_limit'));
    }

    /**
     * View method
     *
     * @param string|null $id Seller Request id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function sellerRequestApprove($id = null)
    { 
		$today_date=date("Y-m-d");
		 $sellerRequest = $this->SellerRequests->get($id, [
            'contain' => ['Sellers', 'Locations', 'SellerRequestRows'=>['ItemVariations'=>['Items','UnitVariations'=>['Units']]]]
			]);
			foreach($sellerRequest->seller_request_rows as $seller_request_row){
				$ItemVariationData = $this->SellerRequests->SellerRequestRows->ItemVariations->get($seller_request_row->item_variation_id);
				$current_stock=$ItemVariationData->current_stock+$seller_request_row->quantity;
				$out_of_stock="No";
				$ready_to_sale="Yes";
				$status="Active";
				$section_show="Yes";
				$query = $this->SellerRequests->SellerRequestRows->ItemVariations->query();
						$query->update()
						->set(['current_stock'=>$current_stock,'purchase_rate'=>$seller_request_row->purchase_rate,'sales_rate'=>$seller_request_row->sales_rate,'mrp'=>$seller_request_row->mrp,'print_rate'=>$seller_request_row->mrp,'update_on'=>$today_date,'out_of_stock'=>$out_of_stock,'ready_to_sale'=>$ready_to_sale,'status'=>$status,'section_show'=>$section_show])
						->where(['id'=>$seller_request_row->item_variation->id])
						->execute();
			}
			
			$query = $this->SellerRequests->query();
						$query->update()
						->set(['status'=>"Approve"])
						->where(['id'=>$id])
						->execute();
		 return $this->redirect(['action' => 'index']);
	}
	public function view($id = null)
    {
		$this->viewBuilder()->layout('admin_portal');
		$city_id=$this->Auth->User('city_id'); 
		$location_id=$this->Auth->User('location_id'); 
        $sellerRequest = $this->SellerRequests->get($id, [
            'contain' => ['Sellers', 'Locations', 'SellerRequestRows'=>['ItemVariations'=>['Items','UnitVariations'=>['Units']]]]
        ]);
		
	//pr($sellerRequest); exit;
        $this->set('sellerRequest', $sellerRequest);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
		$this->viewBuilder()->layout('admin_portal');
		$city_id=$this->Auth->User('city_id'); 
		$location_id=$this->Auth->User('location_id'); 
		$id=$this->Auth->User('id'); 
        $sellerRequest = $this->SellerRequests->newEntity();
        if ($this->request->is('post')) {
			$Voucher_no = $this->SellerRequests->find()->select(['voucher_no'])->where(['SellerRequests.seller_id'=>$id])->order(['voucher_no' => 'DESC'])->first();
			if($Voucher_no){
				$voucher_no=$Voucher_no->voucher_no+1;
			}else{
				$voucher_no=1;
			} 
			
            $sellerRequest = $this->SellerRequests->patchEntity($sellerRequest, $this->request->getData());
			$sellerRequest->transaction_date=date("Y-m-d");
			$sellerRequest->status="Pending";
			$sellerRequest->location_id=$location_id;
			$sellerRequest->seller_id=$id;
			$sellerRequest->voucher_no=$voucher_no;
			
            if ($this->SellerRequests->save($sellerRequest)) {
                $this->Flash->success(__('The seller request has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The seller request could not be saved. Please, try again.'));
        }
       //$ItemVariation = $this->SellerRequests->Items->ItemVariations->find()->where(['seller_id'=>$id])->toArray();
		
		$ItemVariation=$this->SellerRequests->Items->ItemVariations->find()->contain(['Items'=>['ItemVariations'=>['UnitVariations'=>['Units']]]])->where(['ItemVariations.seller_id'=>$id,'ItemVariations.status'=>'Active']);

		$items=array();
		foreach($ItemVariation as $data){
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
		$GstFigures1 = $this->SellerRequests->GstFigures->find();
		$GstFigures=array();
				foreach($GstFigures1 as $data){
					$GstFigures[]=['text' => $data->name,'value' => $data->id,'tax_percentage' => $data->tax_percentage];
				}
		
		//pr($items);exit;
        $locations = $this->SellerRequests->Locations->find('list', ['limit' => 200]);
        $this->set(compact('sellerRequest', 'sellers', 'locations', 'items', 'GstFigures'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Seller Request id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $sellerRequest = $this->SellerRequests->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $sellerRequest = $this->SellerRequests->patchEntity($sellerRequest, $this->request->getData());
            if ($this->SellerRequests->save($sellerRequest)) {
                $this->Flash->success(__('The seller request has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The seller request could not be saved. Please, try again.'));
        }
        $sellers = $this->SellerRequests->Sellers->find('list', ['limit' => 200]);
        $locations = $this->SellerRequests->Locations->find('list', ['limit' => 200]);
        $this->set(compact('sellerRequest', 'sellers', 'locations'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Seller Request id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $sellerRequest = $this->SellerRequests->get($id);
        if ($this->SellerRequests->delete($sellerRequest)) {
            $this->Flash->success(__('The seller request has been deleted.'));
        } else {
            $this->Flash->error(__('The seller request could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
