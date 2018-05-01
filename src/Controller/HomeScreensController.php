<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * HomeScreens Controller
 *
 * @property \App\Model\Table\HomeScreensTable $HomeScreens
 *
 * @method \App\Model\Entity\HomeScreen[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class HomeScreensController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index($id=null)
    {
		
		$city_id=$this->Auth->User('city_id'); 
		$user_id=$this->Auth->User('id');
		$this->viewBuilder()->layout('admin_portal');
        $this->paginate = [
            'limit' => 20
        ];
		
        $homeScreens =$this->HomeScreens->find()->where(['HomeScreens.city_id'=>$city_id]);
		
		if($id)
		{
			$homeScreen = $this->HomeScreens->get($id);
		}
		else{
			$homeScreen = $this->HomeScreens->newEntity();
		}
	
        if ($this->request->is(['post','put'])) {
			$banner_image=$this->request->data['image'];
			$banner_error=$banner_image['error'];
			
            $homeScreen = $this->HomeScreens->patchEntity($homeScreen, $this->request->getData());
			if(empty($banner_error))
			{
				$banner_ext=explode('/',$banner_image['type']);
				$banner_image_name='homeScreen'.time().'.'.$banner_ext[1];
			}

			$homeScreen->city_id=$city_id;
			 
            if ($banner_data=$this->HomeScreens->save($homeScreen)) {
			 
				if(empty($banner_error))
				{ 
					/* Resize Image */
					$destination_url = WWW_ROOT . 'img/temp/'.$banner_image_name;
					if($banner_ext[1]=='png'){
						$image = imagecreatefrompng($banner_image['tmp_name']);
					}else{
						$image = imagecreatefromjpeg($banner_image['tmp_name']); 
					}
					$im = imagejpeg($image, $destination_url, 10);
					
					
					/* For App Image */
					$deletekeyname = 'homeScreen/'.$banner_data->id.'/app';
					$this->AwsFile->deleteMatchingObjects($deletekeyname);
					$keyname = 'homeScreen/'.$banner_data->id.'/app/'.$banner_image_name;
					$this->AwsFile->putObjectFile($keyname,$banner_image['tmp_name'],$banner_image['type']);
					$banner_data->image=$keyname;
					$this->HomeScreens->save($banner_data);

					$dir  = WWW_ROOT .  'img'.DS.'temp'.DS.$banner_image_name;
                    $dir = $this->EncryptingDecrypting->encryptData($dir);
				}
                $this->Flash->success(__('The homeScreen has been saved.'));

                if(empty($banner_error))
                {
                 return $this->redirect(['action' => 'delete_file',$dir]);
                }
                else
                {
                    return $this->redirect(['action' => 'index']);
                }
            }
            $this->Flash->error(__('The homeScreen could not be saved. Please, try again.'));
        }
	/* 	else if ($this->request->is(['get'])){
			$search=$this->request->getQuery('search');
			$homeScreens->where([
							'OR' => [
									'HomeScreens.name LIKE' => $search.'%',
									'HomeScreens.link_name LIKE' => $search.'%',
									'HomeScreens.status LIKE' => $search.'%'
							]
			]);
		} */
		$categories=$this->HomeScreens->Categories->find('List');
        $homeScreens = $this->paginate($homeScreens);
		$paginate_limit=$this->paginate['limit'];
		$this->set(compact('HomeScreens','homeScreen','paginate_limit','categories'));
		
        $this->paginate = [
            'contain' => ['Categories']
        ];
        $homeScreens = $this->paginate($this->HomeScreens);
		
        $this->set(compact('homeScreens'));
    }

    /**
     * View method
     *
     * @param string|null $id Home Screen id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $homeScreen = $this->HomeScreens->get($id, [
            'contain' => ['Categories']
        ]);

        $this->set('homeScreen', $homeScreen);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $homeScreen = $this->HomeScreens->newEntity();
        if ($this->request->is('post')) {
            $homeScreen = $this->HomeScreens->patchEntity($homeScreen, $this->request->getData());
            if ($this->HomeScreens->save($homeScreen)) {
                $this->Flash->success(__('The home screen has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The home screen could not be saved. Please, try again.'));
        }
        $categories = $this->HomeScreens->Categories->find('list', ['limit' => 200]);
        $this->set(compact('homeScreen', 'categories'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Home Screen id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $homeScreen = $this->HomeScreens->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $homeScreen = $this->HomeScreens->patchEntity($homeScreen, $this->request->getData());
            if ($this->HomeScreens->save($homeScreen)) {
                $this->Flash->success(__('The home screen has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The home screen could not be saved. Please, try again.'));
        }
        $categories = $this->HomeScreens->Categories->find('list', ['limit' => 200]);
        $this->set(compact('homeScreen', 'categories'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Home Screen id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $homeScreen = $this->HomeScreens->get($id);
        if ($this->HomeScreens->delete($homeScreen)) {
            $this->Flash->success(__('The home screen has been deleted.'));
        } else {
            $this->Flash->error(__('The home screen could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
