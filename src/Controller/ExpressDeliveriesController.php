<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ExpressDeliveries Controller
 *
 * @property \App\Model\Table\ExpressDeliveriesTable $ExpressDeliveries
 *
 * @method \App\Model\Entity\ExpressDelivery[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ExpressDeliveriesController extends AppController
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
		 
		if($id)
		{
		   $id = $this->EncryptingDecrypting->decryptData($id);
		}
		
        $expressDeliveries =$this->ExpressDeliveries->find()->where(['ExpressDeliveries.city_id'=>$city_id]);
		
		if($id)
		{
			$expressDeliverie = $this->ExpressDeliveries->get($id);
		}
		else{
			$expressDeliverie = $this->ExpressDeliveries->newEntity();
		}
	
        if ($this->request->is(['post','put'])) {
			$express_image=$this->request->data['icon'];
			$express_error=$express_image['error'];
			
            $expressDeliverie = $this->ExpressDeliveries->patchEntity($expressDeliverie, $this->request->getData());
			if(empty($express_error))
			{
				$express_ext=explode('/',$express_image['type']);
				$express_image_name='express'.time().'.'.$express_ext[1];
			}

			$expressDeliverie->city_id=$city_id;
			 
            if ($express_data=$this->ExpressDeliveries->save($expressDeliverie)) {
			 
				if(empty($express_error))
				{
					/* For Web Image */
					$deletekeyname = 'express_delivery/'.$express_data->id.'/web';
					$this->AwsFile->deleteMatchingObjects($deletekeyname);
					$keyname = 'express_delivery/'.$express_data->id.'/web/'.$express_image_name;
					$this->AwsFile->putObjectFile($keyname,$express_image['tmp_name'],$express_image['type']);
					$express_data->icon_web=$keyname;
					$this->ExpressDeliveries->save($express_data);

					/* Resize Image */
					//$destination_url = WWW_ROOT . 'img/temp/'.$express_image_name;
					$tempdir=sys_get_temp_dir();
					$destination_url = $tempdir . '/'.$express_image_name;
					if($express_ext[1]=='png'){
						$image = imagecreatefrompng($express_image['tmp_name']);
					}else{
						$image = imagecreatefromjpeg($express_image['tmp_name']); 
					}
					$im = imagejpeg($image, $destination_url, 10);
					
					
					/* For App Image */
					$deletekeyname = 'express_delivery/'.$express_data->id.'/app';
					$this->AwsFile->deleteMatchingObjects($deletekeyname);
					$keyname = 'express_delivery/'.$express_data->id.'/app/'.$express_image_name;
					$this->AwsFile->putObjectFile($keyname,$express_image['tmp_name'],$express_image['type']);
					$express_data->icon=$keyname;
					$this->ExpressDeliveries->save($express_data);
 
				}
                $this->Flash->success(__('The banner has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
			 
            $this->Flash->error(__('The banner could not be saved. Please, try again.'));
        }
		 else if ($this->request->is(['get'])){
			$search=$this->request->getQuery('search');
			$expressDeliveries->where([
							'OR' => [
									'ExpressDeliveries.title LIKE' => $search.'%',
									'ExpressDeliveries.content_data LIKE' => $search.'%',
									'ExpressDeliveries.status LIKE' => $search.'%'
							]
			]);
		}

        $expressDeliveries = $this->paginate($expressDeliveries);
		$paginate_limit=$this->paginate['limit'];
		$this->set(compact('expressDeliveries','expressDeliverie','paginate_limit'));
		
        $expressDeliveries = $this->paginate($this->ExpressDeliveries);
    }

    /**
     * View method
     *
     * @param string|null $id Express Delivery id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $expressDelivery = $this->ExpressDeliveries->get($id, [
            'contain' => []
        ]);

        $this->set('expressDelivery', $expressDelivery);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $expressDelivery = $this->ExpressDeliveries->newEntity();
        if ($this->request->is('post')) {
            $expressDelivery = $this->ExpressDeliveries->patchEntity($expressDelivery, $this->request->getData());
            if ($this->ExpressDeliveries->save($expressDelivery)) {
                $this->Flash->success(__('The express delivery has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The express delivery could not be saved. Please, try again.'));
        }
        $this->set(compact('expressDelivery'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Express Delivery id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $expressDelivery = $this->ExpressDeliveries->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $expressDelivery = $this->ExpressDeliveries->patchEntity($expressDelivery, $this->request->getData());
            if ($this->ExpressDeliveries->save($expressDelivery)) {
                $this->Flash->success(__('The express delivery has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The express delivery could not be saved. Please, try again.'));
        }
        $this->set(compact('expressDelivery'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Express Delivery id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($dir)
    {
        $this->request->allowMethod(['patch', 'post', 'put']);
		$id = $this->EncryptingDecrypting->decryptData($dir);
        $expressDelivery = $this->ExpressDeliveries->get($id);
		$expressDelivery->status='Deactive';
        if ($this->ExpressDeliveries->save($expressDelivery)) {
            $this->Flash->success(__('The express delivery has been deleted.'));
        } else {
            $this->Flash->error(__('The express delivery could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
