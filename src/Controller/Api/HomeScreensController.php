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
		$city_id=1;
		$Banners=$this->HomeScreens->Banners->find()->where(['city_id'=>$city_id,'status'=>'Active']);
		$SubCategories=$this->HomeScreens->Categories->find()->where(['city_id'=>$city_id,'show_category'=>'yes','status'=>'Active']);
		
		$Categories=$this->HomeScreens->Categories->find()->where(['city_id'=>$city_id,'status'=>'Active','parent_id IS'=>Null]);
		
		$HomeScreens=$this->HomeScreens->find()->where(['screen_type'=>'home','section_show'=>'Yes']);
		if($HomeScreens->toArray()){
			foreach($HomeScreens as $HomeScreen){
				
				
			}
		}
		$data=array("Banners"=>$Banners,"Sub Categories"=>$SubCategories,"Categories"=>$Categories,'HomeScreens'=>$HomeScreens);
		
		
		$this->set(['success' => true,'data' => $data,'_serialize' => ['success', 'data']]);
	 }
}
