<?php
namespace App\Controller;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\View\View;

/**
 * AppNotifications Controller
 *
 * @property \App\Model\Table\AppNotificationsTable $AppNotifications
 *
 * @method \App\Model\Entity\AppNotification[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AppNotificationsController extends AppController
{
	public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Security->setConfig('unlockedActions', ['index']);

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
        $location_id=$this->Auth->User('location_id'); 
        $state_id=$this->Auth->User('state_id'); 
        $this->viewBuilder()->layout('super_admin_layout');
		$appNotification = $this->AppNotifications->newEntity();
		
        $this->paginate = [
            'contain' => ['Cities', 'Locations', 'Items', 'ItemVariations', 'ComboOffers', 'WishLists', 'Categories'],
			'limit' => 20
        ];
		
		if ($this->request->is(['post','put'])) {
			$image_web=$this->request->data['image_web'];
			 
			$web_image_error=$image_web['error'];
			
            $appNotification = $this->AppNotifications->patchEntity($appNotification, $this->request->getData());
			if(empty($web_image_error))
			{
				$banner_ext=explode('/',$image_web['type']);
				$banner_image_name='AppNotifications'.time().'.'.$banner_ext[1];
			}

			$appNotification->city_id=$city_id;
			//$appNotification->location_id=$location_id;
			$appNotification->location_id=1;
			$appNotification->created_by=$user_id;
			 	//pr($appNotification->toArray()); exit;
				$link_name=$this->request->data['link_name'];
				$category_id=$this->request->data['category_id'];
				$item_id=$this->request->data['item_id'];
				$item_variation_id=$this->request->data['item_variation_id'];
				$combo_offer_id=$this->request->data['combo_offer_id'];
				if($link_name=='product_description'){
					
					$dummy_link='/jainthela://'.$link_name.'?id='.$item_id.'&var_id='.$item_variation_id.'&cat_id='.$category_id;
					
				}else if($link_name=='combo_description'){
					
					$dummy_link='/jainthela://'.$link_name.'?id='.$combo_offer_id;
					
				}else if($link_name=='category_wise'){
					
					$dummy_link='/jainthela://'.$link_name.'?id='.$category_id;
					
				}else if($link_name=='item_wise'){
					
					$dummy_link='/jainthela://'.$link_name.'?id='.$item_id;
					
				}else if($link_name=='combo'){
					
					$dummy_link='/jainthela://'.$link_name.'?id='.$item_id;
					
				}else if($link_name=='store_item_wise'){
					
					$dummy_link='/jainthela://'.$link_name.'?id='.$category_id;
					
				}else{
					
					$dummy_link='/jainthela://'.$link_name;
				}
				$appNotification->app_link=$dummy_link;
            if ($banner_data=$this->AppNotifications->save($appNotification)) {
			 
				if(empty($web_image_error))
				{
					/* For Web Image */
					$deletekeyname = 'AppNotifications/'.$banner_data->id.'/web';
					$this->AwsFile->deleteMatchingObjects($deletekeyname);
					$keyname = 'AppNotifications/'.$banner_data->id.'/web/'.$banner_image_name;
					$this->AwsFile->putObjectFile($keyname,$image_web['tmp_name'],$image_web['type']);
					$banner_data->image_web=$keyname;
					$this->AppNotifications->save($banner_data);

					/* Resize Image */
					$destination_url = WWW_ROOT . 'img/temp/'.$banner_image_name;
					if($banner_ext[1]=='png'){
						$image = imagecreatefrompng($image_web['tmp_name']);
					}else{
						$image = imagecreatefromjpeg($image_web['tmp_name']); 
					}
					$im = imagejpeg($image, $destination_url, 10);
					
					
					/* For App Image */
					$deletekeyname = 'AppNotifications/'.$banner_data->id.'/app';
					$this->AwsFile->deleteMatchingObjects($deletekeyname);
					$keyname = 'AppNotifications/'.$banner_data->id.'/app/'.$banner_image_name;
					$this->AwsFile->putObjectFile($keyname,$image_web['tmp_name'],$image_web['type']);
					$banner_data->image_app=$keyname;
					$this->AppNotifications->save($banner_data);

					$dir  = WWW_ROOT .  'img'.DS.'temp'.DS.$banner_image_name;
                    $dir = $this->EncryptingDecrypting->encryptData($dir);
				}
                $this->Flash->success(__('The AppNotifications has been saved.'));

                if(empty($web_image_error))
                {
                 return $this->redirect(['action' => 'delete_file',$dir]);
                }
                else
                {
                    return $this->redirect(['action' => 'index']);
                }
            }
			pr($appNotification); exit;
            $this->Flash->error(__('The AppNotifications could not be saved. Please, try again.'));
        }
		
        $appNotifications = $this->AppNotifications->find();
		
		
		$categories=$this->AppNotifications->Categories->find('list')->where(['Categories.status'=>'Active','Categories.city_id'=>$city_id]);
		$Items=$this->AppNotifications->Items->find('list')->where(['Items.status'=>'Active','Items.city_id'=>$city_id]);
		$ComboOffers=$this->AppNotifications->ComboOffers->find('list')->where(['ComboOffers.status'=>'Active','ComboOffers.city_id'=>$city_id]);
		$ItemVariationMaster=$this->AppNotifications->ItemVariations->find()->where(['ItemVariations.status'=>'Active','ItemVariations.city_id'=>$city_id])->contain(['Items','UnitVariations'=>['Units']]);
		
		foreach($ItemVariationMaster as $data){
			$item_name=$data->item->name;
			$item_id=$data->item->id;
			$category_id=$data->item->category_id;
			$convert_unit_qty=$data->unit_variation->convert_unit_qty;
			$unit_name=$data->unit_variation->unit->unit_name;
			$id=$data->id;
			$show=$item_name.'('.$convert_unit_qty.'-'.$unit_name.')';
			$variation_options[]=['value'=>$id,'text'=>$show, 'category_id'=>$category_id, 'item_id'=>$item_id];
		}
		
		$appNotifications = $this->paginate($appNotifications);
		$paginate_limit=$this->paginate['limit'];
		$this->set(compact('appNotifications','appNotification','paginate_limit','categories','Items','Sellers','ComboOffers','ItemVariationMasters','variation_options'));
		 
    }

    /**
     * View method
     *
     * @param string|null $id App Notification id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $appNotification = $this->AppNotifications->get($id, [
            'contain' => ['Cities', 'Locations', 'Items', 'ItemVariations', 'ComboOffers', 'WishLists', 'Categories', 'AppNotificationCustomers']
        ]);

        $this->set('appNotification', $appNotification);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $appNotification = $this->AppNotifications->newEntity();
        if ($this->request->is('post')) {
            $appNotification = $this->AppNotifications->patchEntity($appNotification, $this->request->getData());
            if ($this->AppNotifications->save($appNotification)) {
                $this->Flash->success(__('The app notification has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The app notification could not be saved. Please, try again.'));
        }
        $cities = $this->AppNotifications->Cities->find('list', ['limit' => 200]);
        $locations = $this->AppNotifications->Locations->find('list', ['limit' => 200]);
        $items = $this->AppNotifications->Items->find('list', ['limit' => 200]);
        $itemVariations = $this->AppNotifications->ItemVariations->find('list', ['limit' => 200]);
        $comboOffers = $this->AppNotifications->ComboOffers->find('list', ['limit' => 200]);
        $wishLists = $this->AppNotifications->WishLists->find('list', ['limit' => 200]);
        $categories = $this->AppNotifications->Categories->find('list', ['limit' => 200]);
        $this->set(compact('appNotification', 'cities', 'locations', 'items', 'itemVariations', 'comboOffers', 'wishLists', 'categories'));
    }

    /**
     * Edit method
     *
     * @param string|null $id App Notification id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $appNotification = $this->AppNotifications->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $appNotification = $this->AppNotifications->patchEntity($appNotification, $this->request->getData());
            if ($this->AppNotifications->save($appNotification)) {
                $this->Flash->success(__('The app notification has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The app notification could not be saved. Please, try again.'));
        }
        $cities = $this->AppNotifications->Cities->find('list', ['limit' => 200]);
        $locations = $this->AppNotifications->Locations->find('list', ['limit' => 200]);
        $items = $this->AppNotifications->Items->find('list', ['limit' => 200]);
        $itemVariations = $this->AppNotifications->ItemVariations->find('list', ['limit' => 200]);
        $comboOffers = $this->AppNotifications->ComboOffers->find('list', ['limit' => 200]);
        $wishLists = $this->AppNotifications->WishLists->find('list', ['limit' => 200]);
        $categories = $this->AppNotifications->Categories->find('list', ['limit' => 200]);
        $this->set(compact('appNotification', 'cities', 'locations', 'items', 'itemVariations', 'comboOffers', 'wishLists', 'categories'));
    }

    /**
     * Delete method
     *
     * @param string|null $id App Notification id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
	 
	public function deleteFile($dir)
    {
        $dir = $this->EncryptingDecrypting->decryptData($dir);
        $dir  = new File($dir);             
        if ($dir->exists()) 
        {
            $dir->delete(); 
        }
         return $this->redirect(['action' => 'index']);
        exit;
    }
	
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $appNotification = $this->AppNotifications->get($id);
        if ($this->AppNotifications->delete($appNotification)) {
            $this->Flash->success(__('The app notification has been deleted.'));
        } else {
            $this->Flash->error(__('The app notification could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
