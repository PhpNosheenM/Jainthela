<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\View\View;
/**
 * WastageVouchers Controller
 *
 * @property \App\Model\Table\WastageVouchersTable $WastageVouchers
 *
 * @method \App\Model\Entity\WastageVoucher[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class WastageVouchersController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
	 
	public function beforeFilter(Event $event)
	{
		parent::beforeFilter($event);
		 $this->Security->setConfig('unlockedActions', ['add','index','view','edit']);
	}
    public function index()
    {
		$city_id=$this->Auth->User('city_id');
		$user_id=$this->Auth->User('id');
		$this->viewBuilder()->layout('super_admin_layout');
        $this->paginate = [
            'contain' => ['Cities', 'Locations'],
			'limit' => 20
        ];
        $wastageVouchers = $this->paginate($this->WastageVouchers);
		$paginate_limit=$this->paginate['limit'];
        $this->set(compact('wastageVouchers','paginate_limit'));
    }

    /**
     * View method
     *
     * @param string|null $id Wastage Voucher id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $wastageVoucher = $this->WastageVouchers->get($id, [
            'contain' => ['Cities', 'Locations', 'WastageVoucherRows']
        ]);

        $this->set('wastageVoucher', $wastageVoucher);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
		$city_id=$this->Auth->User('city_id');
		$user_id=$this->Auth->User('id');
		$this->viewBuilder()->layout('super_admin_layout');
		//$city_id=$this->request->query('city_id');
		$location_id=$this->request->query('location_id');
		$from_date =  date("Y-m-d",strtotime($this->request->query('from_date')));
		$to_date   =  date("Y-m-d",strtotime($this->request->query('to_date')));
		
		
		if($from_date=="1970-01-01")
		{
			$from_date=date("d-m-Y");
		}
		if($to_date=="1970-01-01")
		{
			$to_date=date("d-m-Y");;
		}
		
		$where1=[];
		$status="No";  
		if(empty($location_id))
		{
			$status="Yes";
		}
        $wastageVoucher = $this->WastageVouchers->newEntity();
        if ($this->request->is('post')) {
            $wastageVoucher = $this->WastageVouchers->patchEntity($wastageVoucher, $this->request->getData());
			$Voucher = $this->WastageVouchers->find()->select(['voucher_no'])->where(['city_id'=>$city_id])->order(['voucher_no' => 'DESC'])->first();
			if($Voucher)
			{
				$wastageVoucher->voucher_no = $Voucher->voucher_no+1;
			}
			else
			{
				$wastageVoucher->voucher_no = 1;
			}
			$wastageVoucher->voucher_no = $location_id;
			$wastageVoucher->location_id = $location_id;
			$wastageVoucher->city_id = $city_id;
			$wastageVoucher->created_by = $user_id;
			
            if ($this->WastageVouchers->save($wastageVoucher)) {
				
				foreach($wastageVoucher->wastage_voucher_rows as $data){  
					$to_date   =  date("Y-m-d");
					$ItemLedger = $this->WastageVouchers->WastageVoucherRows->Items->ItemLedgers->newEntity(); 
					$ItemLedger->item_id=$data->item_id; 
					$ItemLedger->item_variation_id=$data->item_variation_id; 
					$ItemLedger->transaction_date=$to_date;  
					$ItemLedger->quantity=$data->quantity; 
					$ItemLedger->rate=$data->rate; 
					$ItemLedger->purchase_rate=$data->rate; 
					$ItemLedger->status="Out";
					$ItemLedger->city_id=$city_id;
					$ItemLedger->location_id=$location_id;
					$ItemLedger->wastage="Yes";
					$ItemLedger->wastage_voucher_id=$wastageVoucher->id;
					$ItemLedger->wastage_voucher_row_id=$data->id;
					$this->WastageVouchers->WastageVoucherRows->Items->ItemLedgers->save($ItemLedger);
				}
				
				
				
                $this->Flash->success(__('The wastage voucher has been saved.'));

                return $this->redirect(['action' => 'index']);
            } pr($wastageVoucher); exit;
            $this->Flash->error(__('The wastage voucher could not be saved. Please, try again.'));
        }
		$showItems=[];
		if($status=="No"){
			$to_date   =  date("Y-m-d");
			$transaction_date=$to_date;
			$LocationData=$this->WastageVouchers->WastageVoucherRows->Items->Locations->get($location_id);
			$ItemsVariations=$this->WastageVouchers->WastageVoucherRows->Items->ItemsVariationsData->find()->toArray();
			foreach($ItemsVariations as  $ItemsVariation){ 
				$ItemLedgers =  $this->WastageVouchers->WastageVoucherRows->Items->ItemLedgers->find()->where(['ItemLedgers.item_variation_id'=>$ItemsVariation->id,'ItemLedgers.city_id'=>$LocationData->city_id,'ItemLedgers.location_id'=>$location_id,'ItemLedgers.seller_id IS NULL'])->where($where1)->contain(['Items','UnitVariations'=>['Units']])->first();
				$merge=@$ItemLedgers->item->name.'('.@$ItemLedgers->unit_variation->quantity_variation.'.'.@$ItemLedgers->unit_variation->unit->shortname.')';
				if($ItemLedgers){ 
				$UnitRateSerialItem = $this->itemVariationWiseReport($ItemsVariation->id,$transaction_date,$LocationData->city_id,$where1);
				$showItems[]=['item_id'=>$ItemLedgers->item->id,'item_variation_name'=>$merge,'item_variation_id'=>$ItemsVariation->id,'stock'=>$UnitRateSerialItem['stock'],'unit_rate'=>$UnitRateSerialItem['unit_rate']];
				}
			}
		}
			
		$Locations = $this->WastageVouchers->Locations->find('list')->where(['city_id'=>$city_id]);
		$this->set(compact('ItemsVariations','Locations','Cities','from_date','to_date','city_id','location_id','showItems','wastageVoucher'));
    }
	
	
	public function itemVariationWiseReport($item_variation_id=null,$transaction_date,$city_id,$where1){
		$this->viewBuilder()->layout('super_admin_layout');
		//$city_id=$this->Auth->User('city_id');
		$location_id=$this->Auth->User('location_id');

		$StockLedgers =  $this->WastageVouchers->WastageVoucherRows->Items->ItemLedgers->find()->where(['item_variation_id'=>$item_variation_id,'transaction_date <='=>$transaction_date])->order(['ItemLedgers.transaction_date'=>'ASC'])->toArray();
		
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
     * @param string|null $id Wastage Voucher id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $wastageVoucher = $this->WastageVouchers->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $wastageVoucher = $this->WastageVouchers->patchEntity($wastageVoucher, $this->request->getData());
            if ($this->WastageVouchers->save($wastageVoucher)) {
                $this->Flash->success(__('The wastage voucher has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The wastage voucher could not be saved. Please, try again.'));
        }
        $cities = $this->WastageVouchers->Cities->find('list', ['limit' => 200]);
        $locations = $this->WastageVouchers->Locations->find('list', ['limit' => 200]);
        $this->set(compact('wastageVoucher', 'cities', 'locations'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Wastage Voucher id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $wastageVoucher = $this->WastageVouchers->get($id);
        if ($this->WastageVouchers->delete($wastageVoucher)) {
            $this->Flash->success(__('The wastage voucher has been deleted.'));
        } else {
            $this->Flash->error(__('The wastage voucher could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
