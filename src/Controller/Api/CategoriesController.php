<?php
namespace App\Controller\Api;
use Cake\Event\Event;
use Cake\Network\Exception\UnauthorizedException;
use Cake\Utility\Security;
use Firebase\JWT\JWT;

/**
 * Categories Controller
 *
 * @property \App\Model\Table\CategoriesTable $Categories
 *
 * @method \App\Model\Entity\Category[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CategoriesController extends AppController
{
	 public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['category']);
    }
		
	 public function category(){
		$category_id=@$this->request->query['category_id'];
		$city_id=@$this->request->query['city_id'];
		if(!empty($category_id) and (!empty($city_id))){
			
			
			
			
			$data=[];
			$this->set(['success' => true,'message'=>'Data Found Successfully','data' => $data,'_serialize' => ['success','message','data']]);
		}else{
			$data=[];
			$this->set(['success' => false,'message'=>'Data Not Found','data' => $data,'_serialize' => ['success','message','data']]);
			}
	 }
}
