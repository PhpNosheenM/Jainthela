<?php
namespace App\Controller;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\View\View;
/**
 * Items Controller
 *
 * @property \App\Model\Table\ItemsTable $Items
 *
 * @method \App\Model\Entity\Item[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ItemsController extends AppController
{
	public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Security->setConfig('unlockedActions', ['add','edit']);

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
			
            $item = $this->Items->patchEntity($item, $this->request->getData());


			$item->city_id=$city_id;
			$item->created_by=$user_id;

            if ($item_data=$this->Items->save($item)) {
				
				

				foreach ($this->request->getData('item_variation_row') as $value) {
        		
        			if(!empty($value['unit_variation_id']))
        			{

						$item_image=$value['item_image_web'];
						$item_error=$item_image['error'];
						if(empty($item_error))
						{
							$item_ext=explode('/',$item_image['type']);
							$item_item_image='item'.time().'.'.$item_ext[1];
						}

						$item_data_variation=$this->Items->ItemVariationMasters->newEntity();
				        $item_data_variation->item_id=$item_data->id;
				        $item_data_variation->unit_variation_id=$value['unit_variation_id'];
				        $item_data_variation->created_by= $user_id;
				        $item_data_variation->status= 'Active';
				        $item_data_variation=$this->Items->ItemVariationMasters->save($item_data_variation);
        				$lastInsertId=$item_data_variation->id;

					   

						if(empty($item_error))
						{
							/* For Web Image */
							$deletekeyname = 'item/'.$lastInsertId.'/web';
							$this->AwsFile->deleteMatchingObjects($deletekeyname);
							$keyname = 'item/'.$lastInsertId.'/web/'.$item_item_image;
							$this->AwsFile->putObjectFile($keyname,$item_image['tmp_name'],$item_image['type']);

							/* Resize Image */
							$destination_url = WWW_ROOT . 'img/temp/'.$item_item_image;
							if($item_ext[1]=='png'){
								$image = imagecreatefrompng($item_image['tmp_name']);
							}else{
								$image = imagecreatefromjpeg($item_image['tmp_name']); 
							}
							imagejpeg($image, $destination_url, 10);

							/* For App Image */
							$deletekeyname = 'item/'.$lastInsertId.'/app';
							$this->AwsFile->deleteMatchingObjects($deletekeyname);
							$keyname1 = 'item/'.$lastInsertId.'/app/'.$item_item_image;
							$this->AwsFile->putObjectFile($keyname1,$destination_url,$item_image['type']);

							 $query = $this->Items->ItemVariationMasters->query();
					    	$query->update()
						   	->set([
						   		'item_image' => $keyname1,
						   		'item_image_web' => $keyname
						   		])
						    ->where(['id' => $lastInsertId])
						    ->execute();

							/* Delete Temp File */
							$file = new File(WWW_ROOT . $destination_url, false, 0777);
							$file->delete();
						}
					}

				}
				
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
			$where['ItemLedgers.transaction_date >=']=$from_date;
		}
		if($to_date!="1970-01-01")
		{
			$where['ItemLedgers.transaction_date <=']=$to_date;
		}
		//pr($where); exit;
		$showItems=[];
		if($where){
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
		if($from_date=="1970-01-01")
		{
			$from_date=date("d-m-Y");
		}
		if($to_date=="1970-01-01")
		{
			$to_date=date("d-m-Y");;
		}
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
            'contain' => ['ItemVariationMasters'=>function ($q){
				return $q->where(['ItemVariationMasters.status'=>'Active'])->contain(['UnitVariations']);
			}]
        ]);
		if(sizeof($item->item_variation_masters)>0)
		{
			$VariationMasterArr = [];
			$img = [];
			foreach($item->item_variation_masters as $item_variation_master)
			{
				$VariationMasterArr[$item_variation_master->unit_variation_id]='exist';
				$img[$item_variation_master->unit_variation_id]=$item_variation_master->item_image_web; 
			}
		}
		//pr($VariationMasterArr); exit;
        if ($this->request->is(['patch', 'post', 'put'])) { 
			/* $item_image=$this->request->data['item_image_web'];
			$item_error=$item_image['error'];

            $item = $this->Items->patchEntity($item, $this->request->getData());
			if(empty($item_error))
			{
				$item_ext=explode('/',$item_image['type']);
				$item->item_image='item'.time().'.'.$item_ext[1];
			} */
			if ($item_data=$this->Items->save($item)) {
				$unitVariationIds=[];
				foreach ($this->request->getData('item_variation_row') as $value) {
					$unitVariationIds[]=$value['unit_variation_id'];
        			if(!empty($value['unit_variation_id']))
        			{

						$item_image=$value['item_image_web'];
						$item_error=$item_image['error'];
						if(empty($item_error))
						{
							$item_ext=explode('/',$item_image['type']);
							$item_item_image='item'.time().'.'.$item_ext[1];
						}
						$is_exist = $this->Items->ItemVariationMasters->find()->where(['ItemVariationMasters.item_id'=>$item_data->id,'ItemVariationMasters.unit_variation_id'=>$value['unit_variation_id']])->first(); 
						if(sizeof($is_exist)<1)
						{ 
							$item_data_variation=$this->Items->ItemVariationMasters->newEntity();
							$item_data_variation->item_id=$item_data->id;
							$item_data_variation->unit_variation_id=$value['unit_variation_id'];
							$item_data_variation->created_by= $user_id;
							$item_data_variation->status= 'Active';
							$item_data_variation=$this->Items->ItemVariationMasters->save($item_data_variation);
							$lastInsertId=$item_data_variation->id;
						}else
						{
							$lastInsertId=$is_exist->id; 
						}
						
					
						if(empty($item_error))
						{
							/* For Web Image */
							$deletekeyname = 'item/'.$lastInsertId.'/web';
							$this->AwsFile->deleteMatchingObjects($deletekeyname);
							$keyname = 'item/'.$lastInsertId.'/web/'.$item_item_image;
							$this->AwsFile->putObjectFile($keyname,$item_image['tmp_name'],$item_image['type']);

							/* Resize Image */
							$destination_url = WWW_ROOT . 'img/temp/'.$item_item_image;
							if($item_ext[1]=='png'){
								$image = imagecreatefrompng($item_image['tmp_name']);
							}else{
								$image = imagecreatefromjpeg($item_image['tmp_name']); 
							}
							imagejpeg($image, $destination_url, 10);

							/* For App Image */
							$deletekeyname = 'item/'.$lastInsertId.'/app';
							$this->AwsFile->deleteMatchingObjects($deletekeyname);
							$keyname1 = 'item/'.$lastInsertId.'/app/'.$item_item_image;
							$this->AwsFile->putObjectFile($keyname1,$destination_url,$item_image['type']);

							 $query = $this->Items->ItemVariationMasters->query();
					    	$query->update()
						   	->set([
						   		'item_image' => $keyname1,
						   		'item_image_web' => $keyname
						   		])
						    ->where(['id' => $lastInsertId])
						    ->execute();
						
							/* Delete Temp File */
							$file = new File(WWW_ROOT . $destination_url, false, 0777);
							$file->delete();
						}
					}

				} 
				$checkUnitVaritations= $this->Items->ItemVariationMasters->find()->where(['ItemVariationMasters.item_id'=>$item_data->id]);
				if(sizeof($checkUnitVaritations)>0)
				{
					foreach($checkUnitVaritations as $checkUnitVaritation)
					{
						if(!in_array($checkUnitVaritation->unit_variation_id,$unitVariationIds))
						{
							$query1 = $this->Items->ItemVariationMasters->query();
							  $query1->update()
							  ->set(['status' =>'Deactive'])
							  ->where(['unit_variation_id'=>$checkUnitVaritation->unit_variation_id,'item_id'=>$item_data->id])
							  ->execute();
						}else{
							
							$query1 = $this->Items->ItemVariationMasters->query();
							  $query1->update()
							  ->set(['status' =>'Active'])
							  ->where(['unit_variation_id'=>$checkUnitVaritation->unit_variation_id,'item_id'=>$item_data->id])
							  ->execute();
						}
					}
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
        $this->set(compact('item', 'categories', 'brands', 'admins', 'sellers', 'cities','unit_option','gstFigures','id','VariationMasterArr','img'));
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
	
	public function checkItemExistance()
	{
		$itemName= $this->request->query('itemName');
		$category= $this->request->query('category');
		$edit_id = $this->request->query('edit_id');
		if(!empty($itemName))
		{
			$where['Items.name LIKE']='%'.$itemName.'%';
		}
		if(!empty($category))
		{
			$where['Items.category_id']=$category;
		}
		if(!empty($edit_id))
		{
			$where['Items.id !=']=$edit_id;
		}
		$isExist = $this->Items->find()->where(@$where)->count();
		if($isExist>0)
		{
			echo 'exist'; 
		}
		else
		{
			echo 'not_exist';
		}
		exit;
	}
}
