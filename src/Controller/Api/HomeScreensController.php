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
		$city_id=@$this->request->query['city_id'];
		if(!empty($city_id)){
			$Banners=$this->HomeScreens->Banners->find()->where(['city_id'=>$city_id,'status'=>'Active']);
			$SubCategories=$this->HomeScreens->Categories->find()->where(['city_id'=>$city_id,'	section_show'=>'yes','status'=>'Active']);
			$Categories=$this->HomeScreens->Categories->find()->where(['city_id'=>$city_id,'status'=>'Active','parent_id IS'=>Null]);
			$HomeScreens=$this->HomeScreens->find()->where(['screen_type'=>'Home','section_show'=>'Yes','city_id'=>$city_id]);
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

				
					if($HomeScreen->model_name=='Category'){
							$Items=$this->HomeScreens->Categories->find()->where(['status'=>'Active','city_id'=>$city_id,'id'=>$HomeScreen->category_id])->contain(['ItemActive'=>['ItemsVariations'=>['Units']]]);
							if($Items){
								$Itemc=array("layout"=>$HomeScreen->layout,"title"=>$HomeScreen->title,"HomeScreens"=>$Items);
								array_push($dynamic,$Itemc);
								
							}else{
								$Item=[];
							}
						}
				}
				
				//$dynamic=array($Express,$Brand);
				$data=array("Banners"=>$Banners,"Sub Categories"=>$SubCategories,"Categories"=>$Categories,'dynamic'=>$dynamic);
				$this->set(['success' => true,'message'=>'Data Found Successfully','data' => $data,'_serialize' => ['success','message','data']]);
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
