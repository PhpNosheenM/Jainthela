<?php
namespace App\Controller;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\View\View;
/**
 * LocationTransferVouchers Controller
 *
 * @property \App\Model\Table\LocationTransferVouchersTable $LocationTransferVouchers
 *
 * @method \App\Model\Entity\LocationTransferVoucher[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LocationTransferVouchersController extends AppController
{

	public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Security->setConfig('unlockedActions', ['add','index']);

    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
		$financial_year_id=$this->Auth->User('financial_year_id');
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id');
		$user_type =$this->Auth->User('user_type');
		if($user_type=="Super Admin"){
			$this->viewBuilder()->layout('super_admin_layout');
		}else if($user_type=="Admin"){ 
			$this->viewBuilder()->layout('admin_portal');
		}
		
        $this->paginate = [
			'limit' => 20
        ];
		
		$locationTransferVouchers = $this->LocationTransferVouchers->find()->where(['LocationTransferVouchers.city_id'=>$city_id,'LocationTransferVouchers.financial_year_id'=>$financial_year_id])->contain(['LocationTransferVoucherRows','Cities', 'LocationOuts', 'LocationIns']);
	   
		if ($this->request->is(['get'])){
			$search=$this->request->getQuery('search');
			$locationTransferVouchers->where([
							'OR' => [
									'LocationTransferVouchers.voucher_no LIKE' => $search.'%',
									'Cities.name LIKE' => $search.'%',
									'LocationOuts.name LIKE' => $search.'%',
									'LocationIns.name LIKE' => $search.'%',
									'LocationTransferVouchers.created_on LIKE' => $search.'%'
									
							]
			]);
		}
		
	    $locationTransferVouchers=$this->paginate($locationTransferVouchers);
		$paginate_limit=$this->paginate['limit'];
        $this->set(compact('locationTransferVouchers','paginate_limit'));
    }

    /**
     * View method
     *
     * @param string|null $id Location Transfer Voucher id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($ids = null)
    {
		if($ids)
		{
		  $id = $this->EncryptingDecrypting->decryptData($ids);
		}
		
		$financial_year_id=$this->Auth->User('financial_year_id');
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id');
		$user_type =$this->Auth->User('user_type');
		if($user_type=="Super Admin"){
			$this->viewBuilder()->layout('super_admin_layout');
		}else if($user_type=="Admin"){ 
			$this->viewBuilder()->layout('admin_portal');
		}
        
        $locationTransferVoucher = $this->LocationTransferVouchers->get($id, [
            'contain' => ['FinancialYears', 'Cities', 'LocationOuts', 'LocationIns', 'LocationTransferVoucherRows'=>['Items','ItemVariations','UnitVariations']]
        ]);

		$this->loadmodel('Companies');
		$companies=$this->Companies->find()->where(['Companies.city_id'=>$city_id])->first();
		$this->set(compact('locationTransferVoucher', 'companies'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
		$financial_year_id=$this->Auth->User('financial_year_id');
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id'); 
		$location_id=$this->Auth->User('location_id');
		$state_id=$this->Auth->User('state_id'); 
		$user_type =$this->Auth->User('user_type');
		if($user_type=="Super Admin"){
		$this->viewBuilder()->layout('super_admin_layout');
		}else if($user_type=="Admin"){ 
		$this->viewBuilder()->layout('admin_portal');
		}
		

        $locationTransferVoucher = $this->LocationTransferVouchers->newEntity();
        if ($this->request->is('post')) {
			
            $locationTransferVoucher = $this->LocationTransferVouchers->patchEntity($locationTransferVoucher, $this->request->getData());
			
			$locationTransferVoucher->location_out_id=$location_id;
			$locationTransferVoucher->financial_year_id=$financial_year_id;
			$locationTransferVoucher->city_id=$city_id;
			
			$Voucher = $this->LocationTransferVouchers->find()->select(['voucher_no'])->where(['city_id'=>$city_id,'financial_year_id'=>$financial_year_id])->order(['voucher_no' => 'DESC'])->first();
			if($Voucher)
			{
				$locationTransferVoucher->voucher_no = $Voucher->voucher_no+1;
			}
			else
			{
				$locationTransferVoucher->voucher_no = 1;
			}
			//pr($locationTransferVoucher); exit;
            if ($data=$this->LocationTransferVouchers->save($locationTransferVoucher)) {
				
				//pr($data->location_transfer_voucher_rows); exit;
				
				
				foreach($data->location_transfer_voucher_rows as $data1){
					
					$item_id=$data1->item_id;
					$item_variation_id=$data1->item_variation_id;
					$unit_variation_id=$data1->unit_variation_id;
					$quantity=$data1->quantity;
					
					$this->loadmodel('ItemLedgers');
					$item_ldgr=$this->ItemLedgers->newEntity();
				        $item_ldgr->item_id=$data1->item_id;
				        $item_ldgr->item_variation_id=$data1->item_variation_id;
				        $item_ldgr->unit_variation_id=$data1->unit_variation_id;
				        $item_ldgr->quantity=$data1->quantity;
				        $item_ldgr->transaction_date=date('Y-m-d');
				        $item_ldgr->status='Out';
				        $item_ldgr->location_id=$data->location_out_id;
				        $item_ldgr->location_transfer_voucher_id=$data->id;
				        $item_ldgr->location_transfer_voucher_row_id=$data1->id;
				        $item_ldgr=$this->ItemLedgers->save($item_ldgr);
						
						
						
						$item_ldgr1=$this->ItemLedgers->newEntity();
				        $item_ldgr1->item_id=$data1->item_id;
				        $item_ldgr1->item_variation_id=$data1->item_variation_id;
				        $item_ldgr1->unit_variation_id=$data1->unit_variation_id;
				        $item_ldgr1->quantity=$data1->quantity;
				        $item_ldgr1->transaction_date=date('Y-m-d');
				        $item_ldgr1->status='In';
				        $item_ldgr1->location_id=$data->location_in_id;
						$item_ldgr1->location_transfer_voucher_id=$data->id;
				        $item_ldgr1->location_transfer_voucher_row_id=$data1->id;
				        $item_ldgr1=$this->ItemLedgers->save($item_ldgr1);
					
					
				}
                $this->Flash->success(__('The location transfer voucher has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The location transfer voucher could not be saved. Please, try again.'));
        }
        $financialYears = $this->LocationTransferVouchers->FinancialYears->find('list', ['limit' => 200]);
        $cities = $this->LocationTransferVouchers->Cities->find('list', ['limit' => 200]);
        $locationOuts = $this->LocationTransferVouchers->LocationOuts->find('list', ['limit' => 200]);
        $locationIns = $this->LocationTransferVouchers->LocationIns->find('list', ['limit' => 200]);
		
		$this->loadmodel('Locations');
		$locations=$this->Locations->find('list')->where(['city_id'=>$city_id,'status'=>'Active','id !='=>$location_id]);
		$to_date=date('Y-m-d');
		if(!empty($location_id))
		{
			$where1['ItemLedgers.location_id']=$location_id;
		}
		if(!empty($city_id))
		{
			$where1['ItemLedgers.city_id']=$city_id;
		}
		 
			$where1['ItemLedgers.transaction_date <=']=$to_date;
	
		$this->loadmodel('Items');
		$LocationData=$this->Items->Locations->get($location_id);
			$ItemsVariations=$this->Items->ItemsVariationsData->find()->toArray(); //pr($LocationData);exit;
			foreach($ItemsVariations as  $ItemsVariation){ 
					 
						//$location_id=1;
						$ItemLedgers =  $this->Items->ItemLedgers->find()->where(['ItemLedgers.item_variation_id'=>$ItemsVariation->id,'ItemLedgers.city_id'=>$LocationData->city_id,'ItemLedgers.location_id'=>$location_id,'ItemLedgers.seller_id IS NULL'])->where($where1)->contain(['Items','UnitVariations'=>['Units']])->first();
						
						$merge=@$ItemLedgers->item->name.'('.@$ItemLedgers->unit_variation->visible_variation.')';
						
						if($ItemLedgers){ //pr($merge); exit;
						$UnitRateSerialItem = $this->itemVariationWiseReport($ItemsVariation->id,$to_date,$location_id,$where1);
						
						$showItems[]=['id'=>$ItemsVariation->id,'item_name'=>$ItemLedgers->item->name,'item_variation_name'=>$merge,'stock'=>$UnitRateSerialItem['stock'],'unit_rate'=>$UnitRateSerialItem['unit_rate'],'item_id'=>$ItemsVariation->item_id,'unit_variation_id'=>$ItemsVariation->unit_variation_id];
						 
					}
			}
			$ItemToBeShown=[];
			 
			foreach($showItems as $data){ 
				$ItemToBeShown[]=['text'=>$data['item_variation_name'] ,'value'=>$data['id'],'current_stock'=>$data['stock'],'item_id'=>$data['item_id'],'unit_variation_id'=>$data['unit_variation_id']];
			}
			
        $this->set(compact('locationTransferVoucher', 'financialYears', 'cities', 'locationOuts', 'locations','ItemToBeShown'));
    }
	
	
	public function itemVariationWiseReport($item_variation_id=null,$transaction_date,$location_id,$where1){
		 
		$this->viewBuilder()->layout('admin_portal');
		  
		$this->loadmodel('Items');
		$StockLedgers =  $this->Items->ItemLedgers->find()->where(['item_variation_id'=>$item_variation_id,'transaction_date <='=>$transaction_date,'location_id'=>$location_id])->order(['ItemLedgers.transaction_date'=>'ASC'])->toArray();
		
		 $stockNew=[];
		foreach($StockLedgers as $StockLedger){
			if($StockLedger->status=='In'){
				$stockNew[]=['qty'=>$StockLedger->quantity,'rate'=>$StockLedger->rate];
			}
		}

		foreach($StockLedgers as $StockLedger){
			if($StockLedger->status=='Out'){
				/* if(sizeof(@$stock) > 0){
					$stock= array_slice($stock, $StockLedger->quantity*100);
				} */

				if(sizeof(@$stockNew)==0){
				break;
				}

				$outQty=$StockLedger->quantity;
				a:
				if(sizeof(@$stockNew)==0){
					break;
				}
				$R=@$stockNew[0]['qty']-$outQty;
				if($R>0){
					$stockNew[0]['qty']=$R;
				}
				else if($R<0){
					unset($stockNew[0]);
					@$stockNew=array_values(@$stockNew);
					$outQty=abs($R);
					goto a;
				}
				else{
					unset($stockNew[0]);
					$stockNew=array_values($stockNew);
				}
			}
		}

		$closingValue=0;
		$total_stock=0;
		$total_amt=0;
		$unit_rate=0;
		foreach($stockNew as $qw){
			$total_stock+=$qw['qty'];
			$total_amt+=$qw['rate']*$qw['qty'];
		}
		if($total_amt > 0 && $total_stock > 0){
			 $unit_rate = $total_amt/$total_stock;
		}

		$Data=['stock'=>$total_stock,'unit_rate'=>$unit_rate];
		return $Data;
		exit;
	}

    /**
     * Edit method
     *
     * @param string|null $id Location Transfer Voucher id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $locationTransferVoucher = $this->LocationTransferVouchers->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $locationTransferVoucher = $this->LocationTransferVouchers->patchEntity($locationTransferVoucher, $this->request->getData());
            if ($this->LocationTransferVouchers->save($locationTransferVoucher)) {
                $this->Flash->success(__('The location transfer voucher has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The location transfer voucher could not be saved. Please, try again.'));
        }
        $financialYears = $this->LocationTransferVouchers->FinancialYears->find('list', ['limit' => 200]);
        $cities = $this->LocationTransferVouchers->Cities->find('list', ['limit' => 200]);
        $locationOuts = $this->LocationTransferVouchers->LocationOuts->find('list', ['limit' => 200]);
        $locationIns = $this->LocationTransferVouchers->LocationIns->find('list', ['limit' => 200]);
        $this->set(compact('locationTransferVoucher', 'financialYears', 'cities', 'locationOuts', 'locationIns'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Location Transfer Voucher id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $locationTransferVoucher = $this->LocationTransferVouchers->get($id);
        if ($this->LocationTransferVouchers->delete($locationTransferVoucher)) {
            $this->Flash->success(__('The location transfer voucher has been deleted.'));
        } else {
            $this->Flash->error(__('The location transfer voucher could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
