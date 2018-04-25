<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ComboOffers Controller
 *
 * @property \App\Model\Table\ComboOffersTable $ComboOffers
 *
 * @method \App\Model\Entity\ComboOffer[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ComboOffersController extends AppController
{

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
        $comboOffers = $this->paginate($this->ComboOffers->find()->where(['ComboOffers.city_id'=>$city_id]));
		
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
    public function view($id = null)
    {
        $comboOffer = $this->ComboOffers->get($id, [
            'contain' => ['Cities', 'Admins', 'Carts', 'ComboOfferDetails', 'OrderDetails']
        ]);

        $this->set('comboOffer', $comboOffer);
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
					//$destination_url = WWW_ROOT . 'img/temp/'.$banner_image_name;
					$tempdir=sys_get_temp_dir();
					$destination_url = $tempdir . '/'.$combo_offer_image_name;
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
				
				}
                $this->Flash->success(__('The combo offer has been saved.'));

                return $this->redirect(['action' => 'add']);
            }
			
            $this->Flash->error(__('The combo offer could not be saved. Please, try again.'));
        }
		$itemVariations = $this->ComboOffers->ComboOfferDetails->ItemVariations->find('all')->contain(['Items','UnitVariations'=>['Units']]);
		$itemVariation_option=[];
		$i=0; foreach($itemVariations as $itemVariation){
			$itemVariation_option[]=['text'=>$itemVariation->item->name .' ' .$itemVariation->unit_variation->quantity_variation .' ' .$itemVariation->unit_variation->unit->unit_name,'value'=>$itemVariation->id,'rate'=>$itemVariation->print_rate ];
		}
		//pr($itemVariations->toArray()); exit;
        $this->set(compact('comboOffer', 'cities', 'itemVariation_option'));
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
					//$destination_url = WWW_ROOT . 'img/temp/'.$banner_image_name;
					$tempdir=sys_get_temp_dir();
					$destination_url = $tempdir . '/'.$combo_offer_image_name;
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
				
				}
                $this->Flash->success(__('The combo offer has been saved.'));

                return $this->redirect(['action' => 'index']);
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
    public function delete($id = null)
    {
        $this->request->allowMethod(['patch', 'post', 'put']);
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
