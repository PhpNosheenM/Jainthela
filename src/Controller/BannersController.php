<?php
namespace App\Controller;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use App\Controller\AppController;

/**
 * Banners Controller
 *
 * @property \App\Model\Table\BannersTable $Banners
 *
 * @method \App\Model\Entity\Banner[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BannersController extends AppController
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
        $this->paginate = [
            'limit' => 20
        ];
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
				$banner->banner_image='banner'.time().'.'.$banner_ext[1];
			}

			$banner->city_id=$city_id;
            if ($banner_data=$this->Banners->save($banner)) {
				if(empty($category_error))
				{
					/* For Web Image */
					$deletekeyname = 'banner/'.$banner_data->id.'/web';
					$this->AwsFile->deleteMatchingObjects($deletekeyname);
					$keyname = 'banner/'.$banner_data->id.'/web/'.$banner_data->banner_image;
					$this->AwsFile->putObjectFile($keyname,$banner_image['tmp_name'],$banner_image['type']);

					/* Resize Image */
					$destination_url = WWW_ROOT . 'img/temp/'.$banner_data->banner_image;
					$image = imagecreatefromjpeg($banner_image['tmp_name']);
					imagejpeg($image, $destination_url, 10);

					/* For App Image */
					$deletekeyname = 'banner/'.$banner_data->id.'/app';
					$this->AwsFile->deleteMatchingObjects($deletekeyname);
					$keyname = 'banner/'.$banner_data->id.'/app/'.$banner_data->banner_image;
					$this->AwsFile->putObjectFile($keyname,$destination_url,$banner_image['type']);

					/* Delete Temp File */
					$file = new File(WWW_ROOT . $destination_url, false, 0777);
					$file->delete();
				}
                $this->Flash->success(__('The banner has been saved.'));

                return $this->redirect(['action' => 'index']);
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

        $banners = $this->paginate($banners);
		$paginate_limit=$this->paginate['limit'];
		$this->set(compact('banners','banner','paginate_limit'));
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
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $banner = $this->Banners->get($id);
        if ($this->Banners->delete($banner)) {
            $this->Flash->success(__('The banner has been deleted.'));
        } else {
            $this->Flash->error(__('The banner could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
