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

			// CheckAvabiltyOfCity function is avaliable in app controller for checking city_id in cities table
			$isValidCity = $this->CheckAvabiltyOfCity($city_id);
			if($isValidCity == 0)
			{
				$data = $this->Categories->find()->where(['id'=>$category_id,'city_id'=>$city_id,'section_show'=>'Yes','status'=>'Active'])->contain(['ChildCategories']);
					if($data->toArray()){
							$this->set(['success' => true,'message'=>'Data Found Successfully','data' => $data,'_serialize' => ['success','message','data']]);
					}else{
						$data=[];
						$this->set(['success' => false,'message'=>'Data Not Found','data' => $data,'_serialize' => ['success','message','data']]);
					}
			}else {
							$data=[];
							$success = false;
							$message = 'Invalid City';
							$this->set(['success' => $success,'message'=>$message,'data' => $data,'_serialize' => ['success','message','data']]);
			}
		}else{
			$data=[];
			$this->set(['success' => false,'message'=>'Empty Category_id or city_id or page','data' => $data,'_serialize' => ['success','message','data']]);
			}
	 }
}
