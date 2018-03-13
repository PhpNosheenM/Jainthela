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
        $this->Auth->allow(['homescreen']);
    }
	
	 public function homescreen(){
		 
		$city_id=$this->request->query['city_id'];
		
		$Banners=$this->HomeScreens->Banners->find()->where(['city_id'=>$city_id,'status'=>'Active']);
		$SubCategories=$this->HomeScreens->Categories->find()->where(['city_id'=>$city_id,'show_category'=>'yes','status'=>'Active']);
		
		$Categories=$this->HomeScreens->Categories->find()->where(['city_id'=>$city_id,'status'=>'Active','parent_id IS'=>Null]);
		
		$HomeScreens=$this->HomeScreens->find()->where(['screen_type'=>'home','section_show'=>'Yes']);
		if($HomeScreens->toArray()){
			foreach($HomeScreens as $HomeScreen){
				
					if($HomeScreen->model_name=='ExpressDeliveries'){
						
						$ExpressDeliveries=$this->HomeScreens->ExpressDeliveries->find()->where(['status'=>'Active']);
						if($ExpressDeliveries->toArray()){
							$Express=array("layout"=>$HomeScreen->layout,"title"=>$HomeScreen->title,"ExpressDeliveries"=>$ExpressDeliveries);
						}else{
							$Express=[];
						}
											
					}
					if($HomeScreen->model_name=='Brands'){
						
							$Brands=$this->HomeScreens->Brands->find()->where(['status'=>'Active','city_id'=>$city_id]);
							if($Brands->toArray()){
								$Brand=array("layout"=>$HomeScreen->layout,"title"=>$HomeScreen->title,"Brands"=>$Brands);
							}else{
								$Brand=[];
							}
						}	
				// Please check condition Model table Item and Itemvariation 
					if($HomeScreen->model_name=='Category'){
						
							$Items=$this->HomeScreens->Categories->find()->where(['status'=>'Active','city_id'=>$city_id,'id'=>$HomeScreen->category_id])->contain(['ItemActive'=>['ItemsVariations'=>['Units']]]);
							if($Items->toArray()){
								$Item=array("layout"=>$HomeScreen->layout,"title"=>$HomeScreen->title,"Items"=>$Items);
							}else{
								$Item=[];
							}
						}					
				}
				
				$dynamic=array($Express,$Brand,$Item);
			}
				
		$data=array("Banners"=>$Banners,"Sub Categories"=>$SubCategories,"Categories"=>$Categories,'dynamic'=>$dynamic);
		
		
		$this->set(['success' => true,'message'=>'Data Found Successfully','data' => $data,'_serialize' => ['success','message', 'data']]);
	 }
}
