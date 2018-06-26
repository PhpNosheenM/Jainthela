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
        $this->Auth->allow(['myMenus','mysubMenus','webMenu','menuItem']);
    }


		public function mysubMenus()
		{
			 $city_id = @$this->request->query['city_id'];
			 $menu_id = @$this->request->query['menu_id'];
			 $submenuData=[];
			   if(!empty($city_id) and !empty($menu_id))
				{
					 $isValidCity = $this->CheckAvabiltyOfCity($city_id);
					 if($isValidCity == 0)
					 {
						 $submenuData = $this->AppMenus->find()->select(['id','name','link','title_content'])->where(['city_id'=>$city_id,'status'=>0,'parent_id'=>$menu_id]);
						 if($submenuData->toArray()){

							$success = true;
							$message = 'Data Found Successfully';
						 }else {

							$success = false;
							$message = 'No Data Found';
						 }
					 }else {
						$success = false;
						$message = 'Invalid City';
					 }

				}else{
					$success = false;
					$message = 'City Id or menu_id Empty';
				  }
			 $this->set(['success' => $success,'message'=>$message,'submenuData' => $submenuData,'_serialize' => ['success','message','submenuData']]);
		}

    public function myMenus($city_id = null)
    {
      $city_id = @$this->request->query['city_id'];
      $menuData = [];
      if(!empty($city_id))
      {
        // CheckAvabiltyOfCity function is avaliable in app controller for checking city_id in cities table
		$dynamic=[]; $Categories=[];
        $isValidCity = $this->CheckAvabiltyOfCity($city_id);
         if($isValidCity == 0)
         {
             $menuData = $this->AppMenus->find()->select(['id','name','link','title_content'])->where(['city_id'=>$city_id,'status'=>0,'parent_id IS'=>Null]);

             if(!empty($menuData->toArray()))
             {
				 foreach($menuData as $menu){

					$title_content= $menu->title_content;
					 if($title_content=='Menu'){
						 $menus[]=$menu;
					 }
					 if($title_content=='My Information'){
						 $MyInformation[]=$menu;
					 }
					 if($title_content=='Other'){
						 $Other[]=$menu;
					 }
				 }
				array_push($dynamic,array("header_name"=>'Menu','title'=>$menus));
				array_push($dynamic,array("header_name"=>'My Information',"title"=>$MyInformation));
				array_push($dynamic,array("header_name"=>'Other',"title"=>$Other));
			/* 	$Categories = $this->AppMenus->Categories->find()->select(['id','name'])->where(['city_id'=>$city_id,'section_show'=>'Yes','status'=>'Active'])->contain(['ChildCategories'=>function($q){
					return $q->select(['ChildCategories.parent_id','ChildCategories.id','ChildCategories.name']); */

				$Categories = $this->AppMenus->Categories->find()
						->select(['id','name'])
						->where(['city_id'=>$city_id,'section_show'=>'Yes','status'=>'Active','parent_id IS'=>Null])
						->contain(['ChildCategories'=>function($q){
							return $q->select(['ChildCategories.parent_id','ChildCategories.id','ChildCategories.name']);
						}]);

			    //array_push($dynamic,array("header_name"=>'Shop By Category',"title"=>$Categories));

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
      $this->set(['success' => $success,'message'=>$message,'dynamic' => $dynamic,"Allcategories"=>$Categories,'_serialize' => ['success','message','dynamic','Allcategories']]);
    }

    public function webMenu($city_id = null)
    {
      $city_id = @$this->request->query['city_id'];
       $Categories=[];
      if(!empty($city_id))
      {
        // CheckAvabiltyOfCity function is avaliable in app controller for checking city_id in cities table
          $isValidCity = $this->CheckAvabiltyOfCity($city_id);
		
           if($isValidCity == 0)
           {		
					 $Main_category = $this->AppMenus->Categories->find()
  						   ->select(['id','name'])
  						   ->where(['city_id'=>$city_id,'section_show'=>'Yes','status'=>'Active','parent_id IS'=>Null])->limit(4);
					 $OthersCategories = $this->AppMenus->Categories->find()
  						   ->select(['id','name'])
  						   ->where(['city_id'=>$city_id,'section_show'=>'Yes','status'=>'Active','parent_id IS'=>Null])->skip(4);
						   
                 if(!empty($Main_category->toArray()))
                 {
                   $success = true;
                   $message = 'Data Found Successfully';
                 }else {
                      $success = false;
                      $message = 'No Data Found';
                 }
          } else {   $success = false; $message = 'Invalid City';  }
      }else
      {
        $success = false;
        $message = 'City Id Empty';
      }
	 
      $this->set(['success' => $success,'message'=>$message,"Allcategories"=>$Main_category,"more"=>$OthersCategories,'_serialize' => ['success','message','Allcategories','more']]);
    }

    public function menuItem($category_id = null,$city_id=null)
    {
      $category_id = @$this->request->query['category_id'];
      $city_id = @$this->request->query['city_id'];
      $Categories=[];
      if(!empty($city_id))
      {
        // CheckAvabiltyOfCity function is avaliable in app controller for checking city_id in cities table
          $isValidCity = $this->CheckAvabiltyOfCity($city_id);
           if($isValidCity == 0)
           {
			   
			   $items = $this->AppMenus->Categories->find()
				->contain(['SellerItems' => function($q) use($city_id,$category_id) {
					return $q->where(['SellerItems.city_id'=>$city_id])
					->contain(['Items'=> function($q) {
						return $q->select(['id','name','category_id']);
					}, 'ItemVariations' => function ($q)
						{ return $q->select(['ItemVariations.seller_item_id','ItemVariations.id','ItemVariations.item_id']); }    
					]);
				}])->where(['Categories.parent_id'=>$category_id]);
			   
			   
/*              $items = $this->AppMenus->Categories->SellerItems->find()
			->contain(['Items' => function($q) {
				return $q->select(['id','name','category_id']);
			},'ItemVariations' => function ($q)
               { return $q->select(['ItemVariations.seller_item_id','ItemVariations.id','ItemVariations.item_id']); }
             ])
             ->where(['SellerItems.city_id'=>$city_id,'SellerItems.category_id'=>$category_id]);
			->where(['SellerItems.city_id'=>$city_id,'SellerItems.category_id'=>$category_id]); */
                 if(!empty($items->toArray()))
                 {
                   $success = true;
                   $message = 'Data Found Successfully';
                 }else {
                      $success = false;
                      $message = 'No Data Found';
                 }
          } else {   $success = false; $message = 'Invalid City';  }
      }else
      {
        $success = false;
        $message = 'City Id Empty';
      }
      $this->set(['success' => $success,'message'=>$message,"items"=>$items,'_serialize' => ['success','message','items']]);
    }

}
