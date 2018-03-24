<?php
namespace App\Controller;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use App\Controller\AppController;

/**
 * Items Controller
 *
 * @property \App\Model\Table\ItemsTable $Items
 *
 * @method \App\Model\Entity\Item[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ItemsController extends AppController
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
            'contain' => ['Categories', 'Brands'],
			'limit' => 20
        ];

		$items = $this->Items->find()->where(['Items.city_id'=>$city_id]);

		if ($this->request->is(['get'])){
			$search=$this->request->getQuery('search');
			$items->where([
							'OR' => [
									'Items.name LIKE' => $search.'%',
									'Items.alias_name LIKE' => $search.'%',
									'Categories.name LIKE' => $search.'%',
									'Brands.name LIKE' => $search.'%',
									'Items.status LIKE' => $search.'%',
									'Items.minimum_stock ' => $search.'%'
							]
			]);
		}
        $items = $this->paginate($items);

		$paginate_limit=$this->paginate['limit'];
        $this->set(compact('items','paginate_limit'));
    }

    /**
     * View method
     *
     * @param string|null $id Item id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $item = $this->Items->get($id, [
            'contain' => ['Categories', 'Brands', 'Admins', 'Sellers', 'Cities', 'AppNotifications', 'Carts', 'ComboOfferDetails', 'GrnRows', 'ItemVariations', 'PromotionDetails', 'PurchaseInvoiceRows', 'PurchaseReturnRows', 'SaleReturnRows', 'SalesInvoiceRows', 'SellerItems']
        ]);

        $this->set('item', $item);
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
		$this->viewBuilder()->layout('admin_portal');
        $item = $this->Items->newEntity();
        if ($this->request->is('post')) {
			$item_image=$this->request->data['item_image'];
			$item_error=$item_image['error'];
			//$item_variation_masters=$this->request->data['item_variation_masters'];

            $item = $this->Items->patchEntity($item, $this->request->getData());

			if(empty($item_error))
			{
				$item_ext=explode('/',$item_image['type']);
				$item->item_image='item'.time().'.'.$item_ext[1];
			}

			$item->city_id=$city_id;
			$item->created_by=$user_id;

            if ($item_data=$this->Items->save($item)) {
			//pr($item->toArray()); exit;
				if(empty($item_error))
				{
					/* For Web Image */
					$deletekeyname = 'item/'.$item_data->id.'/web';
					$this->AwsFile->deleteMatchingObjects($deletekeyname);
					$keyname = 'item/'.$item_data->id.'/web/'.$item_data->item_image;
					$this->AwsFile->putObjectFile($keyname,$item_image['tmp_name'],$item_image['type']);

					/* Resize Image */
					$destination_url = WWW_ROOT . 'img/temp/'.$item_data->item_image;
					$image = imagecreatefromjpeg($item_image['tmp_name']);
					imagejpeg($image, $destination_url, 10);

					/* For App Image */
					$deletekeyname = 'item/'.$item_data->id.'/app';
					$this->AwsFile->deleteMatchingObjects($deletekeyname);
					$keyname = 'item/'.$item_data->id.'/app/'.$item_data->item_image;
					$this->AwsFile->putObjectFile($keyname,$destination_url,$item_image['type']);

					/* Delete Temp File */
					$file = new File(WWW_ROOT . $destination_url, false, 0777);
					$file->delete();
				}


				//pr($item);exit;
                $this->Flash->success(__('The item has been saved.'));

                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('The item could not be saved. Please, try again.'));
        }
		$unitVariations = $this->Items->ItemVariationMasters->UnitVariations->find('all')->contain(['Units']);
		$unit_option=[];
		$i=0; foreach($unitVariations as $unitVariation){
			$unit_option[]=['text'=>$unitVariation->quantity_variation .' ' .$unitVariation->unit->unit_name ,'value'=>$unitVariation->id ];
		}
        $categories = $this->Items->Categories->find('list')->where(['Categories.city_id'=>$city_id]);
        $brands = $this->Items->Brands->find('list')->where(['Brands.city_id'=>$city_id]);

		$gstFigures =  $this->Items->GstFigures->find('list');
		//pr($unitVariations->toArray());exit;
		$this->set(compact('item', 'categories', 'brands', 'admins', 'sellers', 'cities','unitVariations','gstFigures','unit_option'));
    }
	
	public function stockReport($id = null)
    {
		$city_id=$this->Auth->User('city_id'); 
		$user_id=$this->Auth->User('id');
		$this->viewBuilder()->layout('admin_portal');
		
		$city_id=$this->request->query('city_id');
		$location_id=$this->request->query('location_id');
		$seller_id=$this->request->query('seller_id');
		$from_date =  date("Y-m-d",strtotime($this->request->query('from_date')));
		$to_date   =  date("Y-m-d",strtotime($this->request->query('to_date')));
		$transaction_date=date("Y-m-d");
		$where=[];
		if(!empty($location_id))
		{
			$where['ItemLedgers.location_id']=$location_id;
		}
		if(!empty($seller_id))
		{ 
			$where['ItemLedgers.seller_id']=$seller_id;
		}
		if($from_date!="1970-01-01")
		{
			$where['ItemLedgers.location_id']=$location_id;
		}
		if($to_date!="1970-01-01")
		{ 
			$where['ItemLedgers.seller_id']=$seller_id;
		}
		//pr($where); exit;
		$showItems=[];
		if($location_id || $seller_id){
			 $Items = $this->Items->find()->toArray();
				foreach($Items as  $Item){
					if($Item->item_maintain_by=="itemwise"){
						$ItemLedgers =  $this->Items->ItemLedgers->find()->where(['item_id'=>$Item->id])->where($where)->toArray(); // pr($ItemLedgers); exit;
						if($ItemLedgers){
							$UnitRateSerialItem = $this->itemWiseReport($Item->id,$where);
							$showItems[$Item->id]=['item_name'=>$Item->name,'stock'=>$UnitRateSerialItem['stock'],'unit_rate'=>$UnitRateSerialItem['unit_rate']];
						}
						
					}else{
						$ItemsVariations=$this->Items->ItemsVariations->find()->contain(['UnitVariations'=>['Units']])->where(['item_id'=>$Item->id])->toArray();
						foreach($ItemsVariations as $ItemsVariation){
							$merge=$Item->name.'('.@$ItemsVariation->unit_variation->convert_unit_qty.'.'.@$ItemsVariation->unit_variation->unit->print_unit.')';
							$ItemLedgers =  $this->Items->ItemLedgers->find()->where(['item_id'=>$Item->id,'city_id'=>$city_id])->toArray();
							if($ItemLedgers){
							$UnitRateSerialItem = $this->itemVariationWiseReport($ItemsVariation->id,$transaction_date,$city_id);
							
							$showItems[$Item->id]=['item_name'=>$merge,'stock'=>$UnitRateSerialItem['stock'],'unit_rate'=>$UnitRateSerialItem['unit_rate']];
							}
						}
					}
				}
			
		}
		//pr($showItems); exit;
		
		$Locations = $this->Items->Locations->find('list');
		$Cities = $this->Items->Cities->find('list');
		$Sellers = $this->Items->Sellers->find('list');
		$this->set(compact('Locations','Cities','showItems','city_id','location_id','Sellers','seller_id','from_date','to_date'));
	}

	public function itemVariationWiseReport($item_variation_id=null,$transaction_date,$city_id){ 
		$this->viewBuilder()->layout('admin_portal');
		//$city_id=$this->Auth->User('city_id'); 
		$location_id=$this->Auth->User('location_id'); 
		
		$StockLedgers =  $this->Items->ItemLedgers->find()->where(['item_variation_id'=>$item_variation_id,'transaction_date <='=>$transaction_date])->order(['ItemLedgers.transaction_date'=>'ASC'])->toArray();
		
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
	public function itemWiseReport($item_id=null,$where=null){ 
		$this->viewBuilder()->layout('admin_portal');
		//$city_id=$this->Auth->User('city_id'); 
		$location_id=$this->Auth->User('location_id'); 
		//pr($where); exit;
		$StockLedgers =  $this->Items->ItemLedgers->find()->where(['item_id'=>$item_id])->where($where)->order(['ItemLedgers.transaction_date'=>'ASC'])->toArray();
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
     * @param string|null $id Item id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
		$city_id=$this->Auth->User('city_id');
		$user_id=$this->Auth->User('id');
		$this->viewBuilder()->layout('admin_portal');
        $item = $this->Items->get($id, [
            'contain' => ['ItemVariationMasters'=>['UnitVariations']]
        ]);
		//pr($item->toArray()); exit;
        if ($this->request->is(['patch', 'post', 'put'])) {
			$item_image=$this->request->data['item_image'];
			$item_error=$item_image['error'];

            $item = $this->Items->patchEntity($item, $this->request->getData());
			if(empty($item_error))
			{
				$item_ext=explode('/',$item_image['type']);
				$item->item_image='item'.time().'.'.$item_ext[1];
			}
			if ($item_data=$this->Items->save($item)) {
				if(empty($item_error))
				{


					/* For Web Image */
					$deletekeyname = 'item/'.$item_data->id.'/web';
					$this->AwsFile->deleteMatchingObjects($deletekeyname);
					$keyname = 'item/'.$item_data->id.'/web/'.$item_data->item_image;
					$this->AwsFile->putObjectFile($keyname,$item_image['tmp_name'],$item_image['type']);

					/* Resize Image */
					$destination_url = WWW_ROOT . 'img/temp/'.$item_data->item_image;
					$image = imagecreatefromjpeg($item_image['tmp_name']);
					imagejpeg($image, $destination_url, 10);

					/* For App Image */
					$deletekeyname = 'item/'.$item_data->id.'/app';
					$this->AwsFile->deleteMatchingObjects($deletekeyname);
					$keyname = 'item/'.$item_data->id.'/app/'.$item_data->item_image;
					$this->AwsFile->putObjectFile($keyname,$destination_url,$item_image['type']);

					/* Delete Temp File */
					$file = new File(WWW_ROOT . $destination_url, false, 0777);
					$file->delete();
				}
                $this->Flash->success(__('The item has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
			//spr($item); exit;
            $this->Flash->error(__('The item could not be saved. Please, try again.'));
        }
		$unitVariations = $this->Items->ItemVariationMasters->UnitVariations->find('all')->contain(['Units']);
		$unit_option=[];
		$i=0; foreach($unitVariations as $unitVariation){
			$unit_option[]=['text'=>$unitVariation->quantity_variation .' ' .$unitVariation->unit->unit_name ,'value'=>$unitVariation->id ];
		}
		//pr($unit_option); exit;
        $categories = $this->Items->Categories->find('list')->where(['Categories.city_id'=>$city_id]);
        $brands = $this->Items->Brands->find('list')->where(['Brands.city_id'=>$city_id]);

		$gstFigures =  $this->Items->GstFigures->find('list');
        $this->set(compact('item', 'categories', 'brands', 'admins', 'sellers', 'cities','unit_option','gstFigures'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Item id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $item = $this->Items->get($id);
        if ($this->Items->delete($item)) {
            $this->Flash->success(__('The item has been deleted.'));
        } else {
            $this->Flash->error(__('The item could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
