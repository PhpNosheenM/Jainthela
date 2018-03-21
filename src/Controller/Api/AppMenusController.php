<?php
namespace App\Controller\Api;
use Cake\Event\Event;
use Cake\Network\Exception\UnauthorizedException;
use Cake\Utility\Security;
use Firebase\JWT\JWT;



/**
 * AppMenus Controller
 *
 * @property \App\Model\Table\AppMenusTable $AppMenus
 *
 * @method \App\Model\Entity\AppMenu[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AppMenusController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['myMenus']);
    }


    public function myMenus($city_id = null)
    {
      $city_id = @$this->request->query['city_id'];
      $menuData = [];
      if(!empty($city_id))
      {
        // CheckAvabiltyOfCity function is avaliable in app controller for checking city_id in cities table
		$dynamic=[];
        $isValidCity = $this->CheckAvabiltyOfCity($city_id);
         if($isValidCity == 0)
         {
             $menuData = $this->AppMenus->find()->where(['city_id'=>$city_id,'status'=>0]);
             if(!empty($menuData->toArray()))
             {
				        // pr($menuData->toArray());
                $Categories = $this->AppMenus->Categories->find()->where(['city_id'=>$city_id,'section_show'=>'Yes','status'=>'Active'])->contain(['ChildCategories']);
				           //$cat=array("ff"=>$Categories->toArray());
              array_push($menuData,array("Shop By Category"=>$Categories));
              array_push($dynamic,array("Menu"=>$menuData));
               $success = true;
               $message = 'Data Found Successfully';
             }else {
               $success = false;
               $message = 'No Data Found';
             }
         }
           else {
             $success = false;
             $message = 'Invalid City';
           }
      }else
      {
        $success = false;
        $message = 'City Id Empty';
      }
      $this->set(['success' => $success,'message'=>$message,'dynamic' => $dynamic,'_serialize' => ['success','message','dynamic']]);
    }
}
