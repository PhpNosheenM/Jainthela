<?php
namespace App\Controller;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\View\View;
/**
 * Banners Controller
 *
 * @property \App\Model\Table\BannersTable $Banners
 *
 * @method \App\Model\Entity\Banner[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BannersController extends AppController
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
    public function index($id = null)
    {
		$city_id=$this->Auth->User('city_id');
		$user_id=$this->Auth->User('id');
		$this->viewBuilder()->layout('super_admin_layout');
        $this->paginate = [
            'limit' => 20
        ];
		
		if($id)
		{
		   $id = $this->EncryptingDecrypting->decryptData($id);
		}
		
        $banners =$this->Banners->find()->where(['Banners.city_id'=>$city_id]);
		
		if($id)
		{
			$banner = $this->Banners->get($id);
		}
		else{
			$banner = $this->Banners->newEntity();
		}
	
        if ($this->request->is(['post','put'])) {
			$banner_image=$this->request->data['banner_image'];
			 
			$banner_error=$banner_image['error'];
			
            $banner = $this->Banners->patchEntity($banner, $this->request->getData());
			if(empty($banner_error))
			{
				$banner_ext=explode('/',$banner_image['type']);
				$banner_image_name='banner'.time().'.'.$banner_ext[1];
			}

			$banner->city_id=$city_id;
			 
            if ($banner_data=$this->Banners->save($banner)) {
			 
				if(empty($banner_error))
				{
					/* For Web Image */
					$deletekeyname = 'banner/'.$banner_data->id.'/web';
					$this->AwsFile->deleteMatchingObjects($deletekeyname);
					$keyname = 'banner/'.$banner_data->id.'/web/'.$banner_image_name;
					$this->AwsFile->putObjectFile($keyname,$banner_image['tmp_name'],$banner_image['type']);
					$banner_data->banner_image_web=$keyname;
					$this->Banners->save($banner_data);

					/* Resize Image */
					$destination_url = WWW_ROOT . 'img/temp/'.$banner_image_name;
					if($banner_ext[1]=='png'){
						$image = imagecreatefrompng($banner_image['tmp_name']);
					}else{
						$image = imagecreatefromjpeg($banner_image['tmp_name']); 
					}
					$im = imagejpeg($image, $destination_url, 10);
					
					
					/* For App Image */
					$deletekeyname = 'banner/'.$banner_data->id.'/app';
					$this->AwsFile->deleteMatchingObjects($deletekeyname);
					$keyname = 'banner/'.$banner_data->id.'/app/'.$banner_image_name;
					$this->AwsFile->putObjectFile($keyname,$banner_image['tmp_name'],$banner_image['type']);
					$banner_data->banner_image=$keyname;
					$this->Banners->save($banner_data);

					$dir  = WWW_ROOT .  'img'.DS.'temp'.DS.$banner_image_name;
                    $dir = $this->EncryptingDecrypting->encryptData($dir);
				}
                $this->Flash->success(__('The banner has been saved.'));

                if(empty($banner_error))
                {
                 return $this->redirect(['action' => 'delete_file',$dir]);
                }
                else
                {
                    return $this->redirect(['action' => 'index']);
                }
            }
            $this->Flash->error(__('The banner could not be saved. Please, try again.'));
        }
		else if ($this->request->is(['get'])){
			$search=$this->request->getQuery('search');
			$banners->where([
							'OR' => [
									'Banners.name LIKE' => $search.'%',
									'Banners.link_name LIKE' => $search.'%',
									'Banners.status LIKE' => $search.'%'
							]
			]);
		}
		$categories=$this->Banners->Categories->find('list')->where(['Categories.status'=>'Active']);
		$Items=$this->Banners->Items->find('list')->where(['Items.status'=>'Active']);
		$Sellers=$this->Banners->Sellers->find('list')->where(['Sellers.status'=>'Active']);
		$ComboOffers=$this->Banners->ComboOffers->find('list')->where(['ComboOffers.status'=>'Active']);
		$ItemVariationMaster=$this->Banners->ItemVariations->find()->where(['ItemVariations.status'=>'Active'])->contain(['Items','UnitVariations'=>['Units']]);
		 
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
	 
        $banners = $this->paginate($banners);
		$paginate_limit=$this->paginate['limit'];
		$this->set(compact('banners','banner','paginate_limit','categories','Items','Sellers','ComboOffers','ItemVariationMasters','variation_options'));
    }
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
    /**
     * View method
     *
     * @param string|null $id Banner id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $banner = $this->Banners->get($id, [
            'contain' => ['Cities']
        ]);
		
        $this->set('banner', $banner);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $banner = $this->Banners->newEntity();
        if ($this->request->is('post')) {
            $banner = $this->Banners->patchEntity($banner, $this->request->getData());
            if ($this->Banners->save($banner)) {
                $this->Flash->success(__('The banner has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The banner could not be saved. Please, try again.'));
        }
        $cities = $this->Banners->Cities->find('list', ['limit' => 200]);
        $this->set(compact('banner', 'cities'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Banner id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $banner = $this->Banners->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $banner = $this->Banners->patchEntity($banner, $this->request->getData());
            if ($this->Banners->save($banner)) {
                $this->Flash->success(__('The banner has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The banner could not be saved. Please, try again.'));
        }
        $cities = $this->Banners->Cities->find('list', ['limit' => 200]);
        $this->set(compact('banner', 'cities'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Banner id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($dir)
    {
        $this->request->allowMethod(['post', 'delete']);
		$id = $this->EncryptingDecrypting->decryptData($dir);
        $banner = $this->Banners->get($id);
        if ($this->Banners->delete($banner)) {
            $this->Flash->success(__('The banner has been deleted.'));
        } else {
            $this->Flash->error(__('The banner could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
