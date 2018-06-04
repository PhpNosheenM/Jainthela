<?php
namespace App\Controller;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\View\View;
/**
 * ComboOffers Controller
 *
 * @property \App\Model\Table\ComboOffersTable $ComboOffers
 *
 * @method \App\Model\Entity\ComboOffer[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ComboOffersController extends AppController
{

	 public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Security->setConfig('unlockedActions', ['add','index','delete','edits']);

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
		$this->viewBuilder()->layout('admin_portal');
        $this->paginate = [
            'contain' => ['Cities', 'Admins'],
			'limit' => 20
        ];
        $comboOffer = $this->ComboOffers->find()->where(['ComboOffers.city_id'=>$city_id]);
		if ($this->request->is(['get'])){
			$search=$this->request->getQuery('search');
			$comboOffer->where([
							'OR' => [
									'ComboOffers.name LIKE' => $search.'%',
									'ComboOffers.print_rate LIKE' => $search.'%',
									'ComboOffers.discount_per LIKE' => $search.'%',
									'ComboOffers.sales_rate LIKE' => $search.'%',
									'ComboOffers.maximum_quantity_purchase LIKE' => $search.'%',
									'ComboOffers.ready_to_sale LIKE' => $search.'%',
									'ComboOffers.status LIKE' => $search.'%',
									'ComboOffers.end_date LIKE' => date('Y-m-d', strtotime($search)).'%'
							]
			]);
		}
		$comboOffers=$this->paginate($comboOffer);
		$paginate_limit=$this->paginate['limit'];
        $this->set(compact('comboOffers','paginate_limit'));
    }

    /**
     * View method
     *
     * @param string|null $id Combo Offer id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($ids = null)
    {
		if($ids)
		{
		   $id = $this->EncryptingDecrypting->decryptData($ids);
		}
		
		$user_id=$this->Auth->User('id');
		$this->viewBuilder()->layout('admin_portal');
        $comboOffers = $this->ComboOffers->find()->contain(['ComboOfferDetails'=>['ItemVariations'=>['ItemVariationMasters','Items','UnitVariations'=>['Units']]]])->where(['ComboOffers.id'=>$id])->first();
        $this->set('comboOffers', $comboOffers);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {

		$city_id=$this->Auth->User('city_id'); 
		$user_id=$this->Auth->User('id');
		$this->viewBuilder()->layout('admin_portal');

        $comboOffer = $this->ComboOffers->newEntity();
        if ($this->request->is('post')) {
			$combo_offer_image=$this->request->data['combo_offer_image'];
		
			$combo_offer_error=$combo_offer_image['error'];
			
            $comboOffer = $this->ComboOffers->patchEntity($comboOffer, $this->request->getData());
			if(empty($combo_offer_error))
			{
				$combo_offer_ext=explode('/',$combo_offer_image['type']);
				$combo_offer_image_name='combo_offer'.time().'.'.$combo_offer_ext[1];
			}
			
			$comboOffer->city_id=$city_id;
			$comboOffer->created_by=$user_id;
			$comboOffer->admin_id=$user_id;
            if ($combo_data=$this->ComboOffers->save($comboOffer)) {
				
				if(empty($combo_offer_error))
				{
					/* For Web Image */
					$deletekeyname = 'combo_offer/'.$combo_data->id.'/web';
					$this->AwsFile->deleteMatchingObjects($deletekeyname);
					$keyname = 'combo_offer/'.$combo_data->id.'/web/'.$combo_offer_image_name;
					$this->AwsFile->putObjectFile($keyname,$combo_offer_image['tmp_name'],$combo_offer_image['type']);
					$combo_data->combo_offer_image_web=$keyname;
					$this->ComboOffers->save($combo_data);
				
					/* Resize Image */
					$destination_url = WWW_ROOT . 'img/temp/'.$combo_offer_image_name;
					
					if($combo_offer_ext[1]=='png'){
						$image = imagecreatefrompng($combo_offer_image['tmp_name']);
					}else{
						$image = imagecreatefromjpeg($combo_offer_image['tmp_name']); 
					}
					$im = imagejpeg($image, $destination_url, 10);
				
					/* For App Image */
					$deletekeyname = 'combo_offer/'.$combo_data->id.'/app';
					$this->AwsFile->deleteMatchingObjects($deletekeyname);
					$keyname = 'combo_offer/'.$combo_data->id.'/app/'.$combo_offer_image_name;
					$this->AwsFile->putObjectFile($keyname,$combo_offer_image['tmp_name'],$combo_offer_image['type']);
					$combo_data->combo_offer_image=$keyname;
					$this->ComboOffers->save($combo_data);
					$dir  = WWW_ROOT .  'img'.DS.'temp'.DS.$combo_offer_image_name;
                    $dir = $this->EncryptingDecrypting->encryptData($dir);
				
				}
                $this->Flash->success(__('The combo offer has been saved.'));
                if(empty($combo_offer_error))
                {
                 return $this->redirect(['action' => 'delete_file',$dir]);
                }
                else
                {
                    return $this->redirect(['action' => 'index']);
                }
            }
			
            $this->Flash->error(__('The combo offer could not be saved. Please, try again.'));
        }
		$itemVariations = $this->ComboOffers->ComboOfferDetails->ItemVariations->find('all')->contain(['Items','UnitVariations'=>['Units']]);
		$itemVariation_option=[];
		$i=0; foreach($itemVariations as $itemVariation){
			$itemVariation_option[]=['text'=>$itemVariation->item->name .' ' .$itemVariation->unit_variation->quantity_variation .' '.$itemVariation->unit_variation->unit->unit_name,'value'=>$itemVariation->id,'rate'=>$itemVariation->print_rate ];
		}
		//pr($itemVariations->toArray()); exit;
        $this->set(compact('comboOffer', 'cities', 'itemVariation_option'));
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
    public function deleteFileEdit($dir)
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
     * Edit method
     *
     * @param string|null $id Combo Offer id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $comboOffer = $this->ComboOffers->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
			 
            $comboOffer = $this->ComboOffers->patchEntity($comboOffer, $this->request->getData());
			
            if ($combo_data=$this->ComboOffers->save($comboOffer)) {
				
				
				
                $this->Flash->success(__('The combo offer has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The combo offer could not be saved. Please, try again.'));
        }
        $cities = $this->ComboOffers->Cities->find('list', ['limit' => 200]);
        $admins = $this->ComboOffers->Admins->find('list', ['limit' => 200]);
        $this->set(compact('comboOffer', 'cities', 'admins'));
    }
	
	public function edits($id = null)
    {
		if($id)
		{
		   $id = $this->EncryptingDecrypting->decryptData($id);
		}
		
		$user_id=$this->Auth->User('id');
		$this->viewBuilder()->layout('admin_portal');
        $comboOffer = $this->ComboOffers->get($id, [
            'contain' => ['ComboOfferDetails'=>['ItemVariations']]
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
			
			$combo_offer_image=$this->request->data['combo_offer_image'];
			$combo_offer_error=$combo_offer_image['error'];
			
            $comboOffer = $this->ComboOffers->patchEntity($comboOffer, $this->request->getData());
			if(empty($combo_offer_error))
			{
				$combo_offer_ext=explode('/',$combo_offer_image['type']);
				$combo_offer_image_name='combo_offer'.time().'.'.$combo_offer_ext[1];
			}
			
			
            if ($combo_data=$this->ComboOffers->save($comboOffer)) {
				
				if(empty($combo_offer_error))
				{
					/* For Web Image */
					$deletekeyname = 'combo_offer/'.$combo_data->id.'/web';
					$this->AwsFile->deleteMatchingObjects($deletekeyname);
					$keyname = 'combo_offer/'.$combo_data->id.'/web/'.$combo_offer_image_name;
					$this->AwsFile->putObjectFile($keyname,$combo_offer_image['tmp_name'],$combo_offer_image['type']);
					$combo_data->combo_offer_image_web=$keyname;
					$this->ComboOffers->save($combo_data);
				
					/* Resize Image */
					$destination_url = WWW_ROOT . 'img/temp/'.$combo_offer_image_name;
					if($combo_offer_ext[1]=='png'){
						$image = imagecreatefrompng($combo_offer_image['tmp_name']);
					}else{
						$image = imagecreatefromjpeg($combo_offer_image['tmp_name']); 
					}
					$im = imagejpeg($image, $destination_url, 10);
				
					/* For App Image */
					$deletekeyname = 'combo_offer/'.$combo_data->id.'/app';
					$this->AwsFile->deleteMatchingObjects($deletekeyname);
					$keyname = 'combo_offer/'.$combo_data->id.'/app/'.$combo_offer_image_name;
					$this->AwsFile->putObjectFile($keyname,$combo_offer_image['tmp_name'],$combo_offer_image['type']);
					$combo_data->combo_offer_image=$keyname;
					$this->ComboOffers->save($combo_data);
					$dir  = WWW_ROOT .  'img'.DS.'temp'.DS.$combo_offer_image_name;
                    $dir = $this->EncryptingDecrypting->encryptData($dir);
				
				}
                $this->Flash->success(__('The combo offer has been saved.'));

                if(empty($combo_offer_error))
                {
                 return $this->redirect(['action' => 'delete_file_edit',$dir]);
                }
                else
                {
                    return $this->redirect(['action' => 'index']);
                }
            }
            $this->Flash->error(__('The combo offer could not be saved. Please, try again.'));
        }
		
		$itemVariations = $this->ComboOffers->ComboOfferDetails->ItemVariations->find('all')->contain(['Items','UnitVariations'=>['Units']]);
		$itemVariation_option=[];
		$i=0; foreach($itemVariations as $itemVariation){
			$itemVariation_option[]=['text'=>$itemVariation->item->name .' ' .$itemVariation->unit_variation->quantity_variation .' ' .$itemVariation->unit_variation->unit->unit_name,'value'=>$itemVariation->id,'rate'=>$itemVariation->print_rate ];
		}
		
        $cities = $this->ComboOffers->Cities->find('list', ['limit' => 200]);
        $admins = $this->ComboOffers->Admins->find('list', ['limit' => 200]);
        $this->set(compact('comboOffer', 'cities', 'admins','itemVariation_option'));
    }


    /**
     * Delete method
     *
     * @param string|null $id Combo Offer id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($dir)
    {
        $this->request->allowMethod(['patch', 'post', 'put']);
		$id = $this->EncryptingDecrypting->decryptData($dir);
        $comboOffer = $this->ComboOffers->get($id);
		$comboOffer->status='Deactive';
        if ($this->ComboOffers->save($comboOffer)) {
            $this->Flash->success(__('The combo offer has been deleted.'));
        } else {
            $this->Flash->error(__('The combo offer could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
