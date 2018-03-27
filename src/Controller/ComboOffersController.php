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
        $this->paginate = [
            'contain' => ['Cities', 'Admins']
        ];
        $comboOffers = $this->paginate($this->ComboOffers);

        $this->set(compact('comboOffers'));
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
				$comboOffer->combo_offer_image='combo_offer'.time().'.'.$combo_offer_ext[1];
			}
			
			$comboOffer->city_id=$city_id;
			$comboOffer->created_by=$user_id;
			$comboOffer->admin_id=$user_id;
            if ($this->ComboOffers->save($comboOffer)) {
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
            if ($this->ComboOffers->save($comboOffer)) {
                $this->Flash->success(__('The combo offer has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The combo offer could not be saved. Please, try again.'));
        }
        $cities = $this->ComboOffers->Cities->find('list', ['limit' => 200]);
        $admins = $this->ComboOffers->Admins->find('list', ['limit' => 200]);
        $this->set(compact('comboOffer', 'cities', 'admins'));
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
        $this->request->allowMethod(['post', 'delete']);
        $comboOffer = $this->ComboOffers->get($id);
        if ($this->ComboOffers->delete($comboOffer)) {
            $this->Flash->success(__('The combo offer has been deleted.'));
        } else {
            $this->Flash->error(__('The combo offer could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
