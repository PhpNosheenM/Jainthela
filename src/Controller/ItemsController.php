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
        $this->Security->setConfig('unlockedActions', ['add','edit','stockReport','wastageReport']);

    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
	 public function index1()
    {
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id');
		$this->viewBuilder()->layout('super_admin_layout');
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
	
	
    public function index()
    {
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id');
		$this->viewBuilder()->layout('super_admin_layout');
        $this->paginate = [
            'contain' => ['Categories', 'Brands'],
			'limit' => 20
        ];

		$items = $this->Items->find()->where(['Items.city_id'=>$city_id]);
//pr($items->toArray()); exit;
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
		$this->viewBuilder()->layout('super_admin_layout');
        $item = $this->Items->newEntity();


        if ($this->request->is('post')) {
			
            $item = $this->Items->patchEntity($item, $this->request->getData());


			$item->city_id=$city_id;
			$item->created_by=$user_id;
            if ($item_data=$this->Items->save($item)) {
				$seller_item = $this->Items->SellerItems->query();
				$seller_item->update()
					->set(['brand_id' => $item_data->brand_id])
					->where(['item_id' => $item_data->id])
					->execute();
				
            	$dir_name=[];
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

							$dir  = WWW_ROOT .  'img'.DS.'temp'.DS.$item_item_image;
							$dir_name[] = $this->EncryptingDecrypting->encryptData($dir);
						}
					}

				}
				
                $this->Flash->success(__('The item has been saved.'));
                if(empty($dir_name))
                {
                	return $this->redirect(['action' => 'index']);
                }
                else
                {
                	$url = urlencode(serialize($dir_name));
                	return $this->redirect(['action' => 'delete_file',$url]);
                }
                
            }

            $this->Flash->error(__('The item could not be saved. Please, try again.'));
        }
		$unitVariations = $this->Items->ItemVariationMasters->UnitVariations->find()->where(['UnitVariations.city_id'=>$city_id])->contain(['Units']);
		$unit_option=[];
		$i=0; foreach($unitVariations as $unitVariation){
			$unit_option[]=['text'=>$unitVariation->quantity_variation .' ' .$unitVariation->unit->unit_name ,'value'=>$unitVariation->id ];
		}
        $categories = $this->Items->Categories->find('list')->where(['Categories.city_id'=>$city_id]);
        $brands = $this->Items->Brands->find('list')->where(['Brands.city_id'=>$city_id]);

		$gstFigures =  $this->Items->GstFigures->find('list')->where(['city_id'=>$city_id]);
		//pr($unitVariations->toArray());exit;
		$this->set(compact('item', 'categories', 'brands', 'admins', 'sellers', 'cities','unitVariations','gstFigures','unit_option'));
    }
    public function deleteFile($dir_name)
    {
    	$dir_name = unserialize(urldecode($dir_name));
    	foreach ($dir_name as  $dir) {
    		
	    	$dir = $this->EncryptingDecrypting->decryptData($dir);
	    	$dir  = new File($dir);				
			if ($dir->exists()) 
			{
				$dir->delete();	
			}
		}

		return $this->redirect(['action' => 'index']);
    	exit;
    }
	public function expiryReport($id = null){
		$city_id=$this->Auth->User('city_id');
		$location_id=$this->request->query('location_id');
		$day_no=$this->request->query('day_no');
		$this->viewBuilder()->layout('super_admin_layout');
		$item_variation_id=$this->request->query('item_variation_id');
		$ItemsVariationsForJainthela1=$this->Items->ItemsVariationsData->find()->contain(['Items','UnitVariations'=>['Units']])->where(['ItemsVariationsData.seller_id IS NULL','ItemsVariationsData.city_id'=>$city_id])->toArray();
		
		$listItems=[];
		foreach($ItemsVariationsForJainthela1 as $data){
			$merge=@$data->item->name.'('.@$data->unit_variation->quantity_variation.'.'.@$data->unit_variation->unit->shortname.')';
			$listItems[$data->id]=['text'=>$merge,'value'=>$data->id]; 
		}
		
		$where1=[];
		if(!empty($item_variation_id))
		{
			$where1['ItemsVariationsData.id']=$item_variation_id;
		}
		
		
		$ItemsVariationsForJainthela=$this->Items->ItemsVariationsData->find()->contain(['Items','UnitVariations'=>['Units']])->where(['ItemsVariationsData.seller_id IS NULL','ItemsVariationsData.city_id'=>$city_id])->where($where1)->toArray();
		//pr($ItemsVariationsForJainthela); exit;
		$itemStock=[];
		$itemName=[];
		foreach($ItemsVariationsForJainthela as $data){
			$ItemLedgersexists = $this->Items->ItemLedgers->exists(['item_variation_id' => $data->id]);
			if($ItemLedgersexists){
				$transaction_date=date('d-m-Y');
				//$location_id=4;
				$Itemdata=$this->Items->get($data->item_id);
				$dateWiseItem = $this->itemVariationWiseReportForExpiryReport($data->id,$transaction_date,$location_id);
				
				$itemStock[$data->id]=($dateWiseItem);
				//$itemName[$data->id]=($Itemdata->name);
				$merge=@$data->item->name.'('.@$data->unit_variation->quantity_variation.'.'.@$data->unit_variation->unit->shortname.')';
				//pr($merge); exit;
				$itemName[$data->id]=$merge; 
			}
		} 
		if(empty($day_no))
		{
			$day_no=7;
		}
		$Locations = $this->Items->Locations->find('list')->where(['city_id'=>$city_id]);
		$this->set(compact('itemStock','itemName','listItems','item_variation_id','location_id','Locations','day_no'));
	}
	public function todayStockReport($id = null){
		$city_id=$this->Auth->User('city_id');
		$this->viewBuilder()->layout('super_admin_layout');
		$ItemsVariationsForJainthela=$this->Items->ItemsVariationsData->find()->contain(['Items','UnitVariations'=>['Units']])->where(['ItemsVariationsData.seller_id IS NULL','ItemsVariationsData.city_id'=>$city_id])->toArray();
		$ItemsVariations=$this->Items->ItemsVariationsData->find()->contain(['Items','Sellers','UnitVariations'=>['Units']])->where(['ItemsVariationsData.city_id'=>$city_id])->toArray();
		$this->set(compact('ItemsVariations','ItemsVariationsForJainthela'));
	}
	public function wastageVoucher($id = null){
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
		$item = $this->Items->ItemLedgers->newEntity();
        if ($this->request->is(['patch', 'post', 'put'])) { 
				$item_ledgers=$this->request->getData()['item_ledgers'];
				foreach($item_ledgers as $item_ledger){ 
					$to_date   =  date("Y-m-d");
					$ItemLedger = $this->Items->ItemLedgers->newEntity(); 
					$ItemLedger->item_id=$item_ledger['item_id']; 
					$ItemLedger->item_variation_id=$item_ledger['item_variation_id'];
					$ItemLedger->transaction_date=$to_date;  
					$ItemLedger->quantity=$item_ledger['quantity'];
					$ItemLedger->rate=$item_ledger['rate'];
					$ItemLedger->purchase_rate=$item_ledger['rate'];
					$ItemLedger->status="Out";
					$ItemLedger->city_id=$city_id;
					$ItemLedger->location_id=$location_id;
					$ItemLedger->wastage="Yes";
					$this->Items->ItemLedgers->save($ItemLedger);
				}
				return $this->redirect(['action' => 'wastageVoucher']);
			//pr($item_ledgers); exit;
		}
		
		
		$showItems=[];
		if($status=="No"){
			$to_date   =  date("Y-m-d");
			$transaction_date=$to_date;
			$LocationData=$this->Items->Locations->get($location_id);
			$ItemsVariations=$this->Items->ItemsVariationsData->find()->toArray();
			foreach($ItemsVariations as  $ItemsVariation){ 
				$ItemLedgers =  $this->Items->ItemLedgers->find()->where(['ItemLedgers.item_variation_id'=>$ItemsVariation->id,'ItemLedgers.city_id'=>$LocationData->city_id,'ItemLedgers.location_id'=>$location_id,'ItemLedgers.seller_id IS NULL'])->where($where1)->contain(['Items','UnitVariations'=>['Units']])->first();
				$merge=@$ItemLedgers->item->name.'('.@$ItemLedgers->unit_variation->quantity_variation.'.'.@$ItemLedgers->unit_variation->unit->shortname.')';
				if($ItemLedgers){ 
				$UnitRateSerialItem = $this->itemVariationWiseReport($ItemsVariation->id,$transaction_date,$LocationData->city_id,$where1);
				$showItems[]=['item_id'=>$ItemLedgers->item->id,'item_variation_name'=>$merge,'item_variation_id'=>$ItemsVariation->id,'stock'=>$UnitRateSerialItem['stock'],'unit_rate'=>$UnitRateSerialItem['unit_rate']];
				}
			}
		}
			
		$Locations = $this->Items->Locations->find('list')->where(['city_id'=>$city_id]);
		$this->set(compact('ItemsVariations','Locations','Cities','from_date','to_date','city_id','location_id','showItems','item'));
	}
	public function wastageReport($id = null)
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
		
		$showItems=[];
		if($status=="No"){
			
			//$to_date   =  date("Y-m-d");
			$transaction_date=date("Y-m-d",strtotime($to_date));
			$LocationData=$this->Items->Locations->get($location_id);
			$ItemsVariations=$this->Items->ItemsVariationsData->find();
			foreach($ItemsVariations as  $ItemsVariation){ 
					$ItemLedgers =  $this->Items->ItemLedgers->find()->where(['ItemLedgers.item_variation_id'=>$ItemsVariation->id,'ItemLedgers.city_id'=>$LocationData->city_id,'ItemLedgers.location_id'=>$location_id,'ItemLedgers.seller_id IS NULL','ItemLedgers.wastage'=>'Yes','transaction_date >='=>$from_date,'transaction_date <='=>$to_date])->contain(['Items']);
					
					 $itemVarData = $this->Items->ItemVariations->get($ItemsVariation->id, [
						'contain' => ['UnitVariations'=>['Units']]
					]);
							
					
					$merge=@$ItemLedgers->toArray()[0]['item']['name'].'('.@$itemVarData->unit_variation->quantity_variation.'.'.@$itemVarData->unit_variation->unit->shortname.')';
					//pr(@$merge); exit;
					$ItemLedgers->select(['ItemLedgers.item_id','total_quantity'=>$ItemLedgers->func()->sum('ItemLedgers.quantity')])->group('ItemLedgers.item_variation_id');
					
					if(@$ItemLedgers->toArray()[0]['total_quantity'] > 0){
							//pr(@$ItemLedgers->toArray()); exit;
					$showItems[]=['item_id'=>$itemVarData->item_id,'item_variation_name'=>$merge,'item_variation_id'=>$ItemsVariation->id,'stock'=>$ItemLedgers->toArray()[0]['total_quantity']];
				}
			}
		}
		
		//pr($showItems);exit;
			
		$Locations = $this->Items->Locations->find('list')->where(['city_id'=>$city_id]);
		$this->set(compact('ItemsVariations','Locations','Cities','from_date','to_date','city_id','location_id','showItems','item'));
	}
		
	public function stockReport($id = null)
    {
		$city_id=$this->Auth->User('city_id');
		$user_id=$this->Auth->User('id');
		$this->viewBuilder()->layout('super_admin_layout');

		$city_id=$this->request->query('city_id');
		$location_id=$this->request->query('location_id');
		$seller_id=$this->request->query('seller_id');
		$from_date =  date("Y-m-d",strtotime($this->request->query('from_date')));
		$to_date   =  date("Y-m-d",strtotime($this->request->query('to_date')));
		$transaction_date=$to_date;
		$where1=[];
		if(!empty($location_id))
		{
			$where1['ItemLedgers.location_id']=$location_id;
		}
		if(!empty($city_id))
		{
			$where1['ItemLedgers.city_id']=$city_id;
		}
		if($from_date!="1970-01-01")
		{
			$where1['ItemLedgers.transaction_date >=']=$from_date;
		}
		if($to_date!="1970-01-01")
		{
			$where1['ItemLedgers.transaction_date <=']=$to_date;
		}
		//pr($where); exit;
		$showItems=[];
		
		 if($location_id){ //exit;
			$LocationData=$this->Items->Locations->get($location_id);
			$ItemsVariations=$this->Items->ItemsVariationsData->find()->toArray(); //pr($LocationData);exit;
			foreach($ItemsVariations as  $ItemsVariation){ 
					 
						//$location_id=1;
						$ItemLedgers =  $this->Items->ItemLedgers->find()->where(['ItemLedgers.item_variation_id'=>$ItemsVariation->id,'ItemLedgers.city_id'=>$LocationData->city_id,'ItemLedgers.location_id'=>$location_id,'ItemLedgers.seller_id IS NULL'])->where($where1)->contain(['Items','UnitVariations'=>['Units']])->first();
						
						$merge=@$ItemLedgers->item->name.'('.@$ItemLedgers->unit_variation->quantity_variation.'.'.@$ItemLedgers->unit_variation->unit->shortname.')';
						
						if($ItemLedgers){ //pr($merge); exit;
						$UnitRateSerialItem = $this->itemVariationWiseReport($ItemsVariation->id,$transaction_date,$location_id,$where1);
						
						$showItems[$ItemLedgers->item->id][]=['item_name'=>$ItemLedgers->item->name,'item_variation_name'=>$merge,'stock'=>$UnitRateSerialItem['stock'],'unit_rate'=>$UnitRateSerialItem['unit_rate']];
						//pr($showItems); exit;
					}
			}
		}else if($city_id){ 
			 $Items = $this->Items->find()->toArray();
				foreach($Items as  $Item){ 
					/* 	$ItemsVariations=$this->Items->ItemsVariations->find()->contain(['UnitVariations'=>['Units']])->where(['item_id'=>$Item->id])->toArray(); */
							
							$ItemLedgers =  $this->Items->ItemLedgers->find()->where(['ItemLedgers.item_id'=>$Item->id,'ItemLedgers.city_id'=>$city_id,'ItemLedgers.seller_id IS NULL'])->where($where1)->contain(['UnitVariations'=>['Units']])->first();
							
							//$merge=$Item->name.'('.@$ItemLedgers->unit_variation->quantity_variation.'.'.@$ItemLedgers->unit_variation->unit->shortname.')';
							$merge=$Item->name;
							
							if($ItemLedgers){  
							
							$UnitRateSerialItem = $this->itemWiseReport($Item->id,$transaction_date,$city_id,$where1);
							$showItems[$Item->id]=['item_name'=>$merge,'stock'=>$UnitRateSerialItem['stock'],'unit_rate'=>$UnitRateSerialItem['unit_rate']]; 
							
						}
				}
			}
			
		
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
		$unit_variation=$this->Items->UnitVariations->find()->contain(['Units']);
		$unit_variation_data=[];
		foreach($unit_variation as $data){
			$unit_variation_data[$data->id]='('.@$data->quantity_variation.'.'.@$data->unit->shortname.')';
		}
		// pr($unit_variation_data); exit;
		$this->set(compact('Locations','Cities','showItems','city_id','location_id','Sellers','seller_id','from_date','to_date','unit_variation_data'));
	}

	/* public function itemWiseReport($item_id=null,$transaction_date,$city_id){
		pr($item_id); exit;
		
	} */
	
	public function itemVariationWiseReportForExpiryReport($item_variation_id=null,$transaction_date,$location_id){
		$this->viewBuilder()->layout('super_admin_layout');
		$transaction_date=date('Y-m-d',strtotime($transaction_date));
		$StockLedgers =  $this->Items->ItemLedgers->find()->where(['item_variation_id'=>$item_variation_id,'transaction_date <='=>$transaction_date,'location_id'=>$location_id])->order(['ItemLedgers.expiry_date'=>'ASC'])->toArray();
		//pr($item_variation_id);  
		//pr($transaction_date);  
		
		$stockNew=[];
		foreach($StockLedgers as $StockLedger){
			if($StockLedger->status=='In'){
				$stockNew[]=['qty'=>$StockLedger->quantity,'rate'=>$StockLedger->rate,'expiry_date'=>date('Y-m-d',strtotime($StockLedger->expiry_date))];
			}
		}
		//pr($stockNew);   exit;
		
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
/* pr($stockNew); exit;
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

		$Data=['stock'=>$total_stock,'unit_rate'=>$unit_rate]; */
		return $stockNew;
		exit;
	}
	
	
	
	public function itemVariationWiseReport($item_variation_id=null,$transaction_date,$location_id,$where1){
		$this->viewBuilder()->layout('super_admin_layout');
		//$city_id=$this->Auth->User('city_id');
		//$location_id=$this->Auth->User('location_id');

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
	public function itemWiseReport($item_id,$transaction_date,$city_id,$where){
	
		$this->viewBuilder()->layout('super_admin_layout');
		//$city_id=$this->Auth->User('city_id');
		$location_id=$this->Auth->User('location_id');
	
		$ItemLedgers =  $this->Items->ItemLedgers->find()->where(['item_id'=>$item_id,'seller_id IS NULL','location_id'=>0,'transaction_date <='=>$transaction_date])->order(['ItemLedgers.transaction_date'=>'ASC'])->toArray(); 
		
			foreach($ItemLedgers as $ItemLedger){
					
					if($ItemLedger->status=="In"){
						for($inc=0;$inc<$ItemLedger->quantity;$inc++){
						$stock[$ItemLedger->unit_variation_id][]=$ItemLedger->rate;
						}
					}
				}
			
				foreach($ItemLedgers as $ItemLedger){ 
					if($ItemLedger->status=='Out'){ 
						if(sizeof(@$stock[$ItemLedger->unit_variation_id])>0){ 
							$stock[$ItemLedger->unit_variation_id] = array_slice($stock[$ItemLedger->unit_variation_id], $ItemLedger->quantity); 
							
						}
					}
				}
		
				$closingValue=0;
				$remaining=0;
				$item_var_val=[];
				$item_stock=[];
				foreach($stock  as $key=>$stockRow){ 
					$rate=0;
					foreach($stockRow as $data){  
						$remaining=count($stock[$key]); 
						$rate+=$data;
					}
					if($remaining > 0){
						$item_var_val[$key]=$rate/$remaining;
						$item_stock[$key]=$remaining;
					}
					
				}
		//pr($item_stock); 
	//	pr($item_var_val); exit;
	/* $query = $this->Items->ItemLedgers->find()->where(['ItemLedgers.city_id'=>$city_id]);
        $totalInCase = $query->newExpr()
            ->addCase(
                $query->newExpr()->add(['status' => 'In']),
                $query->newExpr()->add(['quantity']),
                'integer'
            );
        $totalOutCase = $query->newExpr()
            ->addCase(
                $query->newExpr()->add(['status' => 'out']),
                $query->newExpr()->add(['quantity']),
                'integer'
            );
        $query->select([
            'total_in' => $query->func()->sum($totalInCase),
            'total_out' => $query->func()->sum($totalOutCase),'id','item_id'
        ])
        ->where(['item_id'=>$item_id,'seller_id IS NULL','location_id'=>0,'transaction_date <='=>$transaction_date])
        ->group('unit_variation_id')
        ->autoFields(true); */
		
		
		
		
		/*  $stockNew=[]; 
		 $stockNew1=[]; 
		foreach($StockLedgers as $StockLedger){  
			if($StockLedger->status=='In'){ 
				//$stockNew[$StockLedger->unit_variation_id]=['qty'=>$StockLedger->quantity,'rate'=>$StockLedger->rate];
				$stockNew[$StockLedger->unit_variation_id]+=$StockLedger->quantity;
				$stockNew1[$StockLedger->unit_variation_id]+=$StockLedger->rate;
			}
		}
		pr($stockNew); 
		pr($stockNew1); 
		exit;
		//pr($stockNew); exit;
		foreach($StockLedgers as $StockLedger){
			if($StockLedger->status=='Out'){
				 if(sizeof(@$stock) > 0){
					$stock= array_slice($stock, $StockLedger->quantity*100);
				} 

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
		} */

		$Data=['stock'=>$item_stock,'unit_rate'=>$item_var_val]; //pr($Data); exit;
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
		if($id)
		{
		   $id = $this->EncryptingDecrypting->decryptData($id);
		}
		
		$city_id=$this->Auth->User('city_id');
		$user_id=$this->Auth->User('id');
		$this->viewBuilder()->layout('super_admin_layout');
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

        if ($this->request->is(['patch', 'post', 'put'])) { 
			$item = $this->Items->patchEntity($item, $this->request->getData());
			if ($item_data=$this->Items->save($item)) { 
				$dir_name=[];
				$unitVariationIds=[];
				$seller_item = $this->Items->SellerItems->query();
				$seller_item->update()
					->set(['brand_id' => $item_data->brand_id])
					->where(['item_id' => $item_data->id])
					->execute();
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

							$dir  = WWW_ROOT .  'img'.DS.'temp'.DS.$item_item_image;
							$dir_name[] = $this->EncryptingDecrypting->encryptData($dir);
							/* Delete Temp File */
							
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
                if(empty($dir_name))
                {
                	return $this->redirect(['action' => 'index']);
                }
                else
                {
                	$url = urlencode(serialize($dir_name));
                	return $this->redirect(['action' => 'delete_file',$url]);
                }
               

                
            }
			//spr($item); exit;
            $this->Flash->error(__('The item could not be saved. Please, try again.'));
        }
		$unitVariations = $this->Items->ItemVariationMasters->UnitVariations->find()->where(['UnitVariations.city_id'=>$city_id])->contain(['Units']);
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
    public function delete($dir)
    {
        $this->request->allowMethod(['post', 'delete']);
		$id = $this->EncryptingDecrypting->decryptData($dir);
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
		
		
	public function SalesReport()
    { 
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id'); 
		//$location_id=$this->Auth->User('location_id'); 
		$this->viewBuilder()->layout('super_admin_layout');
		$location_id = $this->request->query('location_id');
		$seller_id = $this->request->query('seller_id');
		$gst_figure_id = $this->request->query('gst_figure_id');
		$from_date = $this->request->query('from_date');
		$to_date   = $this->request->query('to_date');
		if(empty($from_date) || empty($to_date))
		{
			$from_date = date("Y-m-01");
			$to_date   = date("Y-m-d");
		}else{
			$from_date = date("Y-m-d",strtotime($from_date));
			$to_date= date("Y-m-d",strtotime($to_date));
		}
		if(!empty($from_date))
		{
			$from_date = date("Y-m-d",strtotime($from_date));
			$where['Orders.transaction_date >=']=$from_date;
		}
		if(!empty($to_date))
		{
			$to_date   = date("Y-m-d",strtotime($to_date));
			$where['Orders.transaction_date <=']=$to_date;
		}
		if(!empty($location_id))
		{
			//$to_date   = date("Y-m-d",strtotime($to_date));
			$where['Orders.location_id']=$location_id;
		}
		if($gst_figure_id){ 
			 $orders=$this->Items->Orders->find()->contain(['Locations','PartyLedgers'=>['CustomerData'],'OrderDetails'=>function ($q) use($gst_figure_id) {
							return $q->where(['OrderDetails.gst_figure_id'=>$gst_figure_id])->contain(['GstFigures','Items']);
						}])->where($where);
						
			 $orders->innerJoinWith('OrderDetails',function ($q) use($gst_figure_id) {
							return $q->where(['OrderDetails.gst_figure_id'=>$gst_figure_id])->contain(['GstFigures']);
						})->group('OrderDetails.order_id')
					->autoFields(true);

			//pr($orders->toArray()); exit;
		}else{
			$orders = $this->Items->Orders->find()->contain(['Locations','PartyLedgers'=>['CustomerData']])->where($where)->where(['location_id'=>$location_id]);
			//pr($orders->toArray()); exit;
		}
		$Locations = $this->Items->Orders->Locations->find('list')->where(['city_id'=>$city_id]);
		//$Sellers = $this->Items->Sellers->find('list')->where(['city_id'=>$city_id]);
		$GstFigures = $this->Items->GstFigures->find('list')->where(['city_id'=>$city_id]);
		//pr($orders->toArray()); exit;
		$this->set(compact('from_date','to_date','orders','Locations','location_id','gst_figure_id','Sellers','GstFigures'));
	}
	
		public function PurchaseReport()
    { 
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id'); 
		$location_id=$this->Auth->User('location_id'); 
		$this->viewBuilder()->layout('super_admin_layout');
		$location_id = $this->request->query('location_id');
		$gst_figure_id = $this->request->query('gst_figure_id');
		$from_date = $this->request->query('from_date');
		$to_date   = $this->request->query('to_date');
		if(empty($from_date) || empty($to_date))
		{
			$from_date = date("Y-m-01");
			$to_date   = date("Y-m-d");
		}else{
			$from_date = date("Y-m-d",strtotime($from_date));
			$to_date= date("Y-m-d",strtotime($to_date));
		}
		if(!empty($from_date))
		{
			$from_date = date("Y-m-d",strtotime($from_date));
			$where['PurchaseInvoices.transaction_date >=']=$from_date;
		}
		if(!empty($to_date))
		{
			$to_date   = date("Y-m-d",strtotime($to_date));
			$where['PurchaseInvoices.transaction_date <=']=$to_date;
			$where['PurchaseInvoices.city_id ']=$city_id;
		}
		
		if($gst_figure_id){ 
			 $PurchaseInvoices=$this->Items->PurchaseInvoices->find()->contain(['SellerLedgers'=>['SellerData'],'PurchaseInvoiceRows'=>function ($q) use($gst_figure_id) {
							return $q->where(['PurchaseInvoiceRows.gst_figure_id'=>$gst_figure_id])->contain(['GstFigures','Items']);
						}])->where($where);
						
			 $PurchaseInvoices->innerJoinWith('PurchaseInvoiceRows',function ($q) use($gst_figure_id) {
							return $q->where(['PurchaseInvoiceRows.gst_figure_id'=>$gst_figure_id])->contain(['GstFigures']);
						})->group('PurchaseInvoiceRows.purchase_invoice_id')
					->autoFields(true);

			//pr($PurchaseInvoices->toArray()); exit;
		}else{
			$PurchaseInvoices = $this->Items->PurchaseInvoices->find()->contain(['SellerLedgers'=>['SellerData']])->where($where)->where(['PurchaseInvoices.city_id'=>$city_id]);
			//pr($orders->toArray()); exit;
		}
		
		//pr($PurchaseInvoices->toArray()); exit;
		//pr($from_date); exit;
		//$PurchaseInvoices = $this->Items->PurchaseInvoices->find()->contain(['Cities','SellerLedgers'=>['SellerData']])->where($where);
		//$Locations = $this->Items->Orders->Locations->find('list');
		$GstFigures = $this->Items->GstFigures->find('list')->where(['city_id'=>$city_id]);
		$this->set(compact('from_date','to_date','PurchaseInvoices','Locations','gst_figure_id','location_id','GstFigures'));
	}
}
