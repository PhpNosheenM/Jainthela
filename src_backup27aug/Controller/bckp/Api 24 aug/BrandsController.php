<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Brands Controller
 *
 * @property \App\Model\Table\BrandsTable $Brands
 *
 * @method \App\Model\Entity\Brand[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BrandsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index($id = null)
	 {
		$city_id=$this->Auth->User('city_id'); 
		$user_id=$this->Auth->User('id');
		$this->viewBuilder()->layout('admin_portal');
		$this->paginate =[
				'limit' => 20
		];
		$brands = $this->Brands->find()->where(['city_id'=>$city_id]);
		
		if($id)
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
					//$destination_url = WWW_ROOT . 'img/temp/'.$brand_image_name;
					$tempdir=sys_get_temp_dir();
					$destination_url = $tempdir . '/'.$brand_image_name;
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
 
				}
				
				$this->Flash->success(__('The brand has been saved.'));

				return $this->redirect(['action' => 'index']);
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
        $this->set(compact('brand','brands','paginate_limit'));
        
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
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $brand = $this->Brands->get($id);
        if ($this->Brands->delete($brand)) {
            $this->Flash->success(__('The brand has been deleted.'));
        } else {
            $this->Flash->error(__('The brand could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
