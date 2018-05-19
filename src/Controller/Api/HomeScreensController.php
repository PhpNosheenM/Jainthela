<?php
namespace App\Controller\Api;
use Cake\Event\Event;
use Cake\Network\Exception\UnauthorizedException;
use Cake\Utility\Security;
use Firebase\JWT\JWT;

/**
 * HomeScreens Controller
 *
 * @property \App\Model\Table\HomeScreensTable $HomeScreens
 *
 * @method \App\Model\Entity\HomeScreen[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class HomeScreensController extends AppController
{
	 public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['homescreen','current_api_version']);
    }


	public function current_api_version(){
		//$data=[];
		$api_version=@$this->request->query['version'];
		if(!empty($api_version)){
			$ApiVersions=$this->HomeScreens->ApiVersions->find()->where(['version'=>$api_version]);

			if($ApiVersions->toArray()){
				$success=true;
				$message="data found";
				//$data=$ApiVersions;
			}else{
				$success=false;
				$message="data not found";
			  }

		}else{
			$success=false;
			$message="version is empty";

		}
		$this->set(['success' => $success,'message'=>$message,'_serialize' => ['success','message']]);
	}

	 public function homescreen(){
		$city_id=@$this->request->query['city_id'];
		$customer_id=@$this->request->query['customer_id'];
		$screen_type=@$this->request->query['screen_type'];
		if(!empty($city_id)){
			/* $Banners=$this->HomeScreens->Banners->find()->where(['city_id'=>$city_id,'status'=>'Active']);
			$SubCategories=$this->HomeScreens->Categories->find()->where(['city_id'=>$city_id,'	section_show'=>'yes','status'=>'Active']);
			$Categories=$this->HomeScreens->Categories->find()->where(['city_id'=>$city_id,'status'=>'Active','parent_id IS'=>Null]);
			*/
			$HomeScreens=$this->HomeScreens->find()->where(['screen_type'=>'Home','section_show'=>'Yes','city_id'=>$city_id]);
			if($screen_type=='web'){
				$HomeScreens->order(['web_preference'=>'ASC']);
			}else{

				$HomeScreens->order(['preference'=>'ASC']);
			}
		if($HomeScreens->toArray())
		{		$dynamic=[];
				$Express =[];
				$Brand =[];
				$Item =[];
				foreach($HomeScreens as $HomeScreen){
					if($HomeScreen->model_name=='ExpressDeliveries'){
							$ExpressDeliveries=$this->HomeScreens->ExpressDeliveries->find()->where(['status'=>'Active','city_id'=>$city_id]);
							if($ExpressDeliveries->toArray()){
								$Express=array("layout"=>$HomeScreen->layout,"title"=>$HomeScreen->title,"HomeScreens"=>$ExpressDeliveries);
								array_push($dynamic,$Express);
							}else{
								$Express=[];
							}
					}
					if($HomeScreen->model_name=='Brands'){
							$Brands=$this->HomeScreens->Brands->find()->where(['status'=>'Active','city_id'=>$city_id]);
							if($Brands->toArray()){
								$Brand=array("layout"=>$HomeScreen->layout,"title"=>$HomeScreen->title,"HomeScreens"=>$Brands);
								array_push($dynamic,$Brand);
							}else{
								$Brand=[];
							}
						}

						if($HomeScreen->model_name=='Banners'){
								$Banners=$this->HomeScreens->Banners->find()->where(['city_id'=>$city_id,'status'=>'Active']);
								if($Banners->toArray()){
									$Banner=array("layout"=>$HomeScreen->layout,"title"=>$HomeScreen->title,"HomeScreens"=>$Banners);
									array_push($dynamic,$Banner);
								}else{
									$Banner=[];
								}
							}

						if($HomeScreen->model_name=='SubCategory'){
							$SubCategories=$this->HomeScreens->Categories->find()->where(['city_id'=>$city_id,'	section_show'=>'yes','status'=>'Active','parent_id IS NOT'=>Null]);
							if($SubCategories->toArray()){
								$SubCategory=array("layout"=>$HomeScreen->layout,"title"=>$HomeScreen->title,"HomeScreens"=>$SubCategories);
								array_push($dynamic,$SubCategory);
							}else{
								$SubCategory=[];
							}
						}
						if($HomeScreen->model_name=='MainCategory'){
							$Categories=$this->HomeScreens->Categories->find('threaded')->where(['city_id'=>$city_id,'status'=>'Active','parent_id IS'=>Null]);
							if($Categories->toArray()){
								$Category=array("layout"=>$HomeScreen->layout,"title"=>$HomeScreen->title,"HomeScreens"=>$Categories);
								array_push($dynamic,$Category);
							}else{
								$SubCategory=[];
							}
						}


					if($HomeScreen->model_name=='Category'){
							//$Items=$this->HomeScreens->Categories->find()->where(['status'=>'Active','city_id'=>$city_id,'id'=>$HomeScreen->category_id])->contain(['ItemActive'=>['ItemsVariations'=>['ItemVariationMasters','UnitVariations'=>['Units']]]]);

							/* $Items=$this->HomeScreens->Categories->find()->where(['status'=>'Active','city_id'=>$city_id,'id'=>$HomeScreen->category_id])->contain(['ItemActive'=>['ItemsVariations'=>function($q){
								return  $q->where(['ItemsVariations.status'=>'Active','ItemsVariations.section_show'=>'Yes']);
							}]]); */

							$Items = $this->HomeScreens->Categories->find();
							$Items->where(['status'=>'Active','city_id'=>$city_id,'id'=>$HomeScreen->category_id])->contain(['SellerItems'=> function($q) use($city_id,$Items) { 
								return $q->contain(['Items','ItemVariations'=>['ItemVariationMasters','UnitVariations'=>['Units']]])
									->select(['SellerItems.category_id','sellerItemCount'=>$Items->func()->count('ItemVariations.seller_item_id')])
									->innerJoinWith('ItemVariations')
									->having(['sellerItemCount' > 0])	
									->group(['SellerItems.id'])
									->where(['SellerItems.city_id' => $city_id,'SellerItems.status'=>'Active'])
									->autoFields(true);
											
								}   
							]);

							if(!empty($Items->toArray())){
								
							foreach($Items as $itemData)
							{	
								foreach ($itemData->seller_items as $Item) {
									foreach ($Item->item_variations as $items_variation) {
											$count_cart = $this->HomeScreens->Carts->find()->select(['Carts.cart_count'])->where(['Carts.item_variation_id'=>$items_variation->id,'Carts.customer_id'=>$customer_id]);
											$items_variation->cart_count = 0;
											$count_value = 0;
											foreach ($count_cart as $count) {
											  $count_value = $count->cart_count;
											}			
											$items_variation->cart_count = $count_value;
										}
								}
							}	
								$Itemc=array("layout"=>$HomeScreen->layout,"title"=>$HomeScreen->title,"category_id"=>$HomeScreen->category_id,"HomeScreens"=>$Items);
								array_push($dynamic,$Itemc);

							}else{
								$Item=[];
							}
						}
						
						if($HomeScreen->model_name=='Combooffer'){
							$Combooffers=$this->HomeScreens->ComboOffers->find()->where(['status'=>'Active','city_id'=>$city_id])->limit(3);

							if($Combooffers){
								$count_value = 0;
								$cart_count =0;
									foreach ($Combooffers as $Combooffer) {
										$count_cart = $this->HomeScreens->ComboOffers->Carts->find()->select(['Carts.cart_count'])->where(['Carts.combo_offer_id'=>$Combooffer->id,'Carts.customer_id'=>$customer_id]);
										//pr($count_cart->toArray());exit;
											if(!empty($count_cart->toArray()))
											{
													foreach ($count_cart as $count) {
														$count_value = $count->cart_count;
													}
													$cart_count = $count_value;
											}
										$Combooffer->cart_count = $cart_count;
									}

								$Combooffer=array("layout"=>$HomeScreen->layout,"title"=>$HomeScreen->title,"HomeScreens"=>$Combooffers);
								array_push($dynamic,$Combooffer);

							}else{
								$Combooffer=[];
							}
						}

						if($HomeScreen->model_name=='Categorytwoitem'){
							$Singleimagetwoitems=$this->HomeScreens->Categories->find();
							$Singleimagetwoitems->where(['status'=>'Active','city_id'=>$city_id,'id'=>$HomeScreen->category_id])
							->contain(['SellerItems'=> function($q) use($city_id,$Items)
								{ 
									return $q->contain(['Items' => function($q) {
											return $q->limit(2);
									} ,'ItemVariations'=>['ItemVariationMasters','UnitVariations'=>['Units']]])
									->select(['SellerItems.category_id','sellerItemCount'=>$Items->func()->count('ItemVariations.seller_item_id')])
									->innerJoinWith('ItemVariations')
									->having(['sellerItemCount' > 0])	
									->group(['SellerItems.id'])
									->where(['SellerItems.city_id' => $city_id,'SellerItems.status'=>'Active'])
									->autoFields(true);
								}   
							]);
						
							
						/* 	$Singleimagetwoitems=$this->HomeScreens->Categories->find()
							->where(['status'=>'Active','city_id'=>$city_id,'id'=>$HomeScreen->category_id])
							->contain(['Items'=>function($q){
								return $q->where(['status'=>'Active','section_show'=>'Yes'])
								->limit(2)
								->contain(['ItemsVariations'=>['ItemVariationMasters','UnitVariations'=>['Units']]]);
							}]); */
						//	pr($Singleimagetwoitems->toArray());exit;
							
							if($Singleimagetwoitems){
								foreach ($Singleimagetwoitems as $Item) {
									foreach($Item->seller_items as $itemData)
									{
										foreach($itemData->item_variations as $items_variation) {
											$count_cart = $this->HomeScreens->Carts->find()->select(['Carts.cart_count'])->where(['Carts.item_variation_id'=>$items_variation->id,'Carts.customer_id'=>$customer_id]);
											$items_variation->cart_count = 0;
											$count_value = 0;

											foreach ($count_cart as $count) {
											  $count_value = $count->cart_count;
											}
											$items_variation->cart_count = $count_value;
										}
									}	
								}
								$Singleimagetwoitem=array("layout"=>$HomeScreen->layout,"title"=>$HomeScreen->title,'Image'=>$HomeScreen->image,"HomeScreens"=>$Singleimagetwoitems);
								array_push($dynamic,$Singleimagetwoitem);

							}else{
								$Singleimagetwoitem=[];
							}
						}
				}
				$cart_item_count = $this->HomeScreens->Carts->find('All')->where(['Carts.customer_id'=>$customer_id])->count();
				//$dynamic=array($Express,$Brand);
				$data=array('dynamic'=>$dynamic);
				$this->set(['success' => true,'message'=>'Data Found Successfully','total_count'=>$cart_item_count,'data' => $data,'_serialize' => ['success','message','total_count','data']]);
			}else{
				$data=[];
				$this->set(['success' => false,'message'=>'Data Not Found','data' => $data,'_serialize' => ['success','message','data']]);
			}

		}else{
				$data=[];
				$this->set(['success' => false,'message'=>'Data Not Found','data' => $data,'_serialize' => ['success','message','data']]);
			}
 }
}
