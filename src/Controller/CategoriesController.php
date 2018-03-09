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
		if($id)
		{
			$category = $this->Categories->get($id);
		}
		else{
			$category = $this->Categories->newEntity();
		}
        if ($this->request->is(['post','put'])) {
            $category = $this->Categories->patchEntity($category, $this->request->getData());
			$category->city_id=$city_id;
			if ($this->request->is('post')){
				$category->created_by=$user_id;
			}else{
				$category->edited_by=$user_id;
			}
            if ($this->Categories->save($category)) {
                $this->Flash->success(__('The category has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The category could not be saved. Please, try again.'));
        }
        $parentCategories = $this->Categories->ParentCategories->find('list');
		
        $this->paginate = [
            'contain' => ['ParentCategories'],
			'limit' => 20
        ];
        $categories = $this->paginate($this->Categories);
		//pr( $categories ); exit;
        $this->set(compact('categories','category', 'parentCategories'));
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
