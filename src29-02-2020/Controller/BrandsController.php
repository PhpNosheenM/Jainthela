<?php
namespace App\Controller;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\View\View;

/**
 * Brands Controller
 *
 * @property \App\Model\Table\BrandsTable $Brands
 *
 * @method \App\Model\Entity\Brand[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BrandsController extends AppController
{
	public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Security->setConfig('unlockedActions', ['index','addd']);
		if (in_array($this->request->action, ['addd'])) {
			 $this->eventManager()->off($this->Csrf);
		 }

    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index($ids = null, $status=null)
	 {
		$status=$this->request->query('status');
		$city_id=$this->Auth->User('city_id'); 
		$user_id=$this->Auth->User('id');
		$this->viewBuilder()->layout('super_admin_layout');
		$this->paginate =[
				'limit' => 100
		];
		$id=0;
		if($ids)
		{
		   $id = $this->EncryptingDecrypting->decryptData($ids);
		}
		
		 if(!empty($status)){
			 $brands = $this->Brands->find()->where(['city_id'=>$city_id,'status'=>$status])->order(['Brands.name' => 'ASC']);;
		 }else{
			 $brands = $this->Brands->find()->where(['city_id'=>$city_id,'status'=>'Active'])->order(['Brands.name' => 'ASC']);;
			
		 }
		 $brandsData = $this->Brands->find()->where(['city_id'=>$city_id,'status'=>'Active'])->toArray();
		$stock=[];
		foreach($brandsData as $data){
				//$itemDetails=$this->Brands->Items->find()->where(['brand_id'=>$data->id,'status'=>'Active']);

				$itemDetails = $this->Brands->Items->find()->contain(['ItemVariations' => function($q) {
				return $q->select(['item_id','total_qty' => $q->func()->sum('ItemVariations.current_stock')]);
				}])->where(['brand_id'=>$data->id,'status'=>'Active'])->first();
				$stock[$data->id]=(@$itemDetails->item_variations[0]->total_qty); 
		}
//pr($stock);exit;
		if($ids)
		{
		   $brand = $this->Brands->get($id);
		}
		else
		{
			$brand = $this->Brands->newEntity();
		}
        if ($this->request->is(['post','put'])) {
		
			$brand_image=$this->request->data['brand_image'];
			$brand_error=$brand_image['error'];
			
			$brand = $this->Brands->patchEntity($brand, $this->request->getData());
			if(empty($brand_error))
			{
				$banner_ext=explode('/',$brand_image['type']);
				$brand_image_name='brand'.time().'.'.$banner_ext[1];
			}
			
			$brand->city_id=$city_id;
			$brand->created_by=$user_id;
			if($id)
			{
				$brand->id=$id;
			}
			if ($brand_data=$this->Brands->save($brand)) {
				
				if(empty($brand_error))
				{
					/* For Web Image */
					$deletekeyname = 'brand/'.$brand_data->id.'/web';
					$this->AwsFile->deleteMatchingObjects($deletekeyname);
					$keyname = 'brand/'.$brand_data->id.'/web/'.$brand_image_name;
					$this->AwsFile->putObjectFile($keyname,$brand_image['tmp_name'],$brand_image['type']);
					$brand_data->brand_image_web=$keyname;
					$this->Brands->save($brand_data);

					/* Resize Image */
					$destination_url = WWW_ROOT . 'img/temp/'.$brand_image_name;
					if($banner_ext[1]=='png'){
						$image = imagecreatefrompng($brand_image['tmp_name']);
					}else{
						$image = imagecreatefromjpeg($brand_image['tmp_name']); 
					}
					$im = imagejpeg($image, $destination_url, 10);
					
					
					/* For App Image */
					$deletekeyname = 'brand/'.$brand_data->id.'/app';
					$this->AwsFile->deleteMatchingObjects($deletekeyname);
					$keyname = 'brand/'.$brand_data->id.'/app/'.$brand_image_name;
					$this->AwsFile->putObjectFile($keyname,$brand_image['tmp_name'],$brand_image['type']);
					$brand_data->brand_image=$keyname;
					$this->Brands->save($brand_data);
                    $dir  = WWW_ROOT .  'img'.DS.'temp'.DS.$brand_image_name;
                    $dir = $this->EncryptingDecrypting->encryptData($dir);
 
				}
				
				$this->Flash->success(__('The brand has been saved.'));

				if(empty($brand_error))
                {
                 return $this->redirect(['action' => 'delete_file',$dir]);
                }
                else
                {
                    return $this->redirect(['action' => 'index']);
                }
			}
			$this->Flash->error(__('The unit could not be saved. Please, try again.'));
            
        }
		else if ($this->request->is(['get'])){
			$search=$this->request->getQuery('search');
			$brands->where([
							'OR' => [
									'name LIKE' => $search.'%',
									'status LIKE' => $search.'%'
							]
			]);
		}
		
		$brands=$this->paginate($brands);
		$paginate_limit=$this->paginate['limit'];
        $this->set(compact('brand','brands','paginate_limit','status','stock','search'));
        
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
     * @param string|null $id Brand id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $brand = $this->Brands->get($id, [
            'contain' => ['Cities']
        ]);

        $this->set('brand', $brand);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $brand = $this->Brands->newEntity();
        if ($this->request->is('post')) {
            $brand = $this->Brands->patchEntity($brand, $this->request->getData());
            if ($this->Brands->save($brand)) {
                $this->Flash->success(__('The brand has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The brand could not be saved. Please, try again.'));
        }
        $cities = $this->Brands->Cities->find('list', ['limit' => 200]);
        $this->set(compact('brand', 'cities'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Brand id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $brand = $this->Brands->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $brand = $this->Brands->patchEntity($brand, $this->request->getData());
            if ($this->Brands->save($brand)) {
                $this->Flash->success(__('The brand has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The brand could not be saved. Please, try again.'));
        }
        $cities = $this->Brands->Cities->find('list', ['limit' => 200]);
        $this->set(compact('brand', 'cities'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Brand id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function active($dir)
    {
        $this->request->allowMethod(['patch', 'post', 'put']);
		$id = $this->EncryptingDecrypting->decryptData($dir);
        $brand = $this->Brands->get($id);
		$brand->status='Active';
        if ($this->Brands->save($brand)) {
            $this->Flash->success(__('The brand has been deleted.'));
        } else {
            $this->Flash->error(__('The brand could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
	 public function delete($dir)
    {
        $this->request->allowMethod(['patch', 'post', 'put']);
		$id = $this->EncryptingDecrypting->decryptData($dir);
        $brand = $this->Brands->get($id);
		$brand->status='Deactive';
        if ($this->Brands->save($brand)) {
            $this->Flash->success(__('The brand has been deleted.'));
        } else {
            $this->Flash->error(__('The brand could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
	
	public function addd(){
	
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id');
		$brand= $this->Brands->newEntity();
		//echo "rere"; exit;
        if ($this->request->is('post')) {
				
            $brand = $this->Brands->patchEntity($brand, $this->request->getData());
			$brand->city_id=$city_id;
			$brand->created_by=$user_id;
			$brand->section_show="Yes";
			$brand->status="Active";
			
            if ($category_data=$this->Brands->save($brand)) {
				$arr = array('option' => '<option value="'.$brand->id.'">'.$brand->name.'</option>', 'brand_id' => $brand->id);
				echo json_encode($arr);
            }
        }
	exit;
	}
}
