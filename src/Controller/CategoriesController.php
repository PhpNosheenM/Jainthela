<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Categories Controller
 *
 * @property \App\Model\Table\CategoriesTable $Categories
 *
 * @method \App\Model\Entity\Category[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CategoriesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index($id = null)
    {
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id'); 
		$this->viewBuilder()->layout('admin_portal');
		$this->paginate = [
            'contain' => ['ParentCategories'],
			'limit' => 20
        ];
		$categories = $this->Categories->find()->where(['Categories.city_id'=>$city_id]);
		if($id)
		{
			$category = $this->Categories->get($id);
		}
		else{
			$category = $this->Categories->newEntity();
		}
        if ($this->request->is(['post','put'])) { 
			
			$app_image=$this->request->data['app_image'];
			$app_error=$app_image['error'];
			$web_image=$this->request->data['web_image'];
			$web_error=$web_image['error'];
			
            $category = $this->Categories->patchEntity($category, $this->request->getData());
			if(empty($app_error))
			{
				$app_ext=explode('/',$app_image['type']);
				$category->app_image='app'.time().'.'.$app_ext[1];
			}
			if(empty($web_error))
			{
				$web_ext=explode('/',$web_image['type']);
				$category->web_image='web'.time().'.'.$web_ext[1];
			}
			$category->city_id=$city_id;
			
			if ($this->request->is('post')){
				$category->created_by=$user_id;
			}else{
				$category->edited_by=$user_id;
			}
            if ($category_data=$this->Categories->save($category)) {
				///////////////// S3 Upload //////////////
				if(empty($app_error))
				{
					$deletekeyname = 'category/'.$category_data->id.'/app';
					$this->AwsFile->deleteMatchingObjects($deletekeyname);
					$keyname = 'category/'.$category_data->id.'/app/'.$category_data->app_image;
					$this->AwsFile->putObjectFile($keyname,$app_image['tmp_name'],$app_image['type']);
				}
				if(empty($web_error))
				{
					$deletekeyname = 'category/'.$category_data->id.'/web';
					$this->AwsFile->deleteMatchingObjects($deletekeyname);
					$keyname = 'category/'.$category_data->id.'/web/'.$category_data->web_image;
					$this->AwsFile->putObjectFile($keyname,$web_image['tmp_name'],$web_image['type']);
				}
				///////////////////////////////
                $this->Flash->success(__('The category has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The category could not be saved. Please, try again.'));
        }
		else if ($this->request->is(['get'])){
			$search=$this->request->getQuery('search');
			$categories->where([
							'OR' => [
									'Categories.name LIKE' => $search.'%',
									'Categories.status LIKE' => $search.'%',
									'ParentCategories.name LIKE' => $search.'%'
							]
			]);
		}
		
        $parentCategories = $this->Categories->ParentCategories->find('list')->where(['ParentCategories.city_id'=>$city_id]);
        $categories = $this->paginate($categories);
		
		$paginate_limit=$this->paginate['limit'];
        $this->set(compact('categories','category', 'parentCategories','paginate_limit'));
    }

   
    /**
     * Delete method
     *
     * @param string|null $id Category id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $category = $this->Categories->get($id);
        if ($this->Categories->delete($category)) {
            $this->Flash->success(__('The category has been deleted.'));
        } else {
            $this->Flash->error(__('The category could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
