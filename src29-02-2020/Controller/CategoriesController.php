<?php
namespace App\Controller;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\View\View;


/**
 * Categories Controller
 *
 * @property \App\Model\Table\CategoriesTable $Categories
 *
 * @method \App\Model\Entity\Category[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CategoriesController extends AppController
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
    public function index($id = null, $category_image_name_data = null)
    {
    	/*$dir='';
    	if(!empty($category_image_name_data))
    	{
	    	$category_image_name_data = $this->EncryptingDecrypting->decryptData($category_image_name_data);
	    	$dir  = new File(WWW_ROOT .  'img'.DS.'temp'.DS.$category_image_name_data, true, 0777);				
			if ($dir->exists()) 
			{
				$dir->delete();	
			}
		}*/
		$status=$this->request->query('status');
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id');
		$this->viewBuilder()->layout('super_admin_layout');
		$this->paginate = [
            'contain' => ['ParentCategories'],
			'limit' => 100
        ];
		
		if($id)
		{
		   $id = $this->EncryptingDecrypting->decryptData($id);
		}
		
		//$categories = $this->Categories->find()->where(['Categories.city_id'=>$city_id]);
		
		 if(!empty($status)){
			 $categories = $this->Categories->find()->where(['Categories.city_id'=>$city_id,'Categories.status'=>$status])->order(['Categories.name' => 'ASC']);
			// $brands = $this->Brands->find()->where(['city_id'=>$city_id,'status'=>$status]);
		 }else{
			 $categories = $this->Categories->find()->where(['Categories.city_id'=>$city_id,'Categories.status'=>'Active'])->order(['Categories.name' => 'ASC']);
			
		 }
		
		
		if($id)
		{
			$category = $this->Categories->get($id);
		}
		else{
			$category = $this->Categories->newEntity();
		}
        if ($this->request->is(['post','put'])) {

			$category_image=$this->request->data['category_image'];
			$category_error=$category_image['error'];

            $category = $this->Categories->patchEntity($category, $this->request->getData());

			if(empty($category_error))
			{
				$category_ext=explode('/',$category_image['type']);
				$category_image_name='category'.time().'.'.$category_ext[1];
			}

			$category->city_id=$city_id;

			if ($this->request->is('post')){
				$category->created_by=$user_id;
			}else{
				$category->edited_by=$user_id;
			}
		//	pr($category);exit;
			
            if ($category_data=$this->Categories->save($category)) {
				///////////////// S3 Upload //////////////
				if(empty($category_error))
				{
					/* For Web Image */
					$deletekeyname = 'category/'.$category_data->id.'/web';
					$this->AwsFile->deleteMatchingObjects($deletekeyname);
					$keyname = 'category/'.$category_data->id.'/web/'.$category_image_name;
					$this->AwsFile->putObjectFile($keyname,$category_image['tmp_name'],$category_image['type']);
					$category_data->category_image_web=$keyname;
					$this->Categories->save($category_data);
					
					
					/* Resize Image */
					$destination_url = WWW_ROOT . 'img/temp/'.$category_image_name;
					if($category_ext[1]=='png'){
						$image = imagecreatefrompng($category_image['tmp_name']);
					}else{
						$image = imagecreatefromjpeg($category_image['tmp_name']); 
					}
					imagejpeg($image, $destination_url, 10);
					
					imagedestroy($image);
					/* For App Image */
					$deletekeyname = 'category/'.$category_data->id.'/app';
					$this->AwsFile->deleteMatchingObjects($deletekeyname);
					$keyname = 'category/'.$category_data->id.'/app/'.$category_image_name;
					$this->AwsFile->putObjectFile($keyname,$destination_url,$category_image['type']);
					$category_data->category_image=$keyname;
					$this->Categories->save($category_data);
					$dir  = WWW_ROOT .  'img'.DS.'temp'.DS.$category_image_name;
					$dir = $this->EncryptingDecrypting->encryptData($dir);
				}
				///////////////////////////////
                $this->Flash->success(__('The category has been saved.'));
                if(empty($category_error))
                {
              	 return $this->redirect(['action' => 'delete_file',$dir]);
                }
                else
                {
                	return $this->redirect(['action' => 'index']);
                }
            }
            $this->Flash->error(__('The category could not be saved. Please, try again.'));
        }
		else if ($this->request->is(['get'])){
			$search=$this->request->getQuery('search');
			//pr($search); exit;
			if($search){
				$categories->where(['Categories.parent_id'=>$search]);
			}else{
				
			}
			
			
		}

        $parentCategories = $this->Categories->ParentCategories->find('list')->where(['ParentCategories.city_id'=>$city_id])->order(['ParentCategories.name' => 'ASC']);
        $filterOptions = $this->Categories->find('list')->where(['Categories.city_id'=>$city_id,'parent_id IS NULL']);
        $categories = $this->paginate($categories);

		$paginate_limit=$this->paginate['limit'];
        $this->set(compact('categories','category', 'parentCategories','paginate_limit','search','status','filterOptions'));
    }
	
	public function addd(){
	
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id');
		$category = $this->Categories->newEntity();
		
        if ($this->request->is('post')) {

            $category = $this->Categories->patchEntity($category, $this->request->getData());
			$category->city_id=$city_id;
			$category->created_by=$user_id;
			$category->section_show="Yes";
			$category->status="Active";
            if ($category_data=$this->Categories->save($category)) {
				$arr = array('option' => '<option value="'.$category->id.'">'.$category->name.'</option>', 'category_id' => $category->id);
				echo json_encode($arr);
            }
           
        }
	exit;
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
     * Delete method
     *
     * @param string|null $id Category id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function active($dir)
    {
        $this->request->allowMethod(['patch', 'post', 'put']);
		$id = $this->EncryptingDecrypting->decryptData($dir);
        $category = $this->Categories->get($id);
		$category->status='Active';
        if ($this->Categories->save($category)) {
			
			$query1 = $this->Categories->Items->query();
			$query1->update()
			->set(['status' =>'Active'])
			->where(['category_id'=>$id])
			->execute();

			$query2 = $this->Categories->SellerItems->query();
			$query2->update()
			->set(['status' =>'Active'])
			->where(['category_id'=>$id])
			->execute();	
			
			
            $this->Flash->success(__('The category has been deleted.'));
        } else {
            $this->Flash->error(__('The category could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
	public function delete($dir)
    {
        $this->request->allowMethod(['patch', 'post', 'put']);
		$id = $this->EncryptingDecrypting->decryptData($dir);
        $category = $this->Categories->get($id);
		$category->status='Deactive';
        if ($this->Categories->save($category)) {
			
			$query1 = $this->Categories->Items->query();
			$query1->update()
			->set(['status' =>'Deactive'])
			->where(['category_id'=>$id])
			->execute();

			$query2 = $this->Categories->SellerItems->query();
			$query2->update()
			->set(['status' =>'Deactive'])
			->where(['category_id'=>$id])
			->execute();			
			
            $this->Flash->success(__('The category has been deleted.'));
        } else {
            $this->Flash->error(__('The category could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
