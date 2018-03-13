<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Items Controller
 *
 * @property \App\Model\Table\ItemsTable $Items
 *
 * @method \App\Model\Entity\Item[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ItemsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Categories', 'Brands', 'Admins', 'Sellers', 'Cities']
        ];
        $items = $this->paginate($this->Items);

        $this->set(compact('items'));
    }

    /**
     * View method
     *
     * @param string|null $id Item id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $item = $this->Items->get($id, [
            'contain' => ['Categories', 'Brands', 'Admins', 'Sellers', 'Cities', 'AppNotifications', 'Carts', 'ComboOfferDetails', 'GrnRows', 'ItemVariations', 'PromotionDetails', 'PurchaseInvoiceRows', 'PurchaseReturnRows', 'SaleReturnRows', 'SalesInvoiceRows', 'SellerItems']
        ]);

        $this->set('item', $item);
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
        $item = $this->Items->newEntity();
        if ($this->request->is('post')) {
			$item_image=$this->request->data['item_image'];
			$item_error=$item_image['error'];
            $item = $this->Items->patchEntity($item, $this->request->getData());
			
			if(empty($item_error))
			{
				$item_ext=explode('/',$item_image['type']);
				$item->item_image='item'.time().'.'.$item_ext[1];
			}
			//pr($item);exit;
			$item->city_id=$city_id;
			$item->created_by=$user_id;
			//pr($item); exit;
            if ($item_data=$this->Items->save($item)) { 
				if(empty($item_error))
				{
					/* For Web Image */
					$deletekeyname = 'item/'.$item_data->id.'/web';
					$this->AwsFile->deleteMatchingObjects($deletekeyname);
					$keyname = 'item/'.$item_data->id.'/web/'.$item_data->item_image;
					$this->AwsFile->putObjectFile($keyname,$item_image['tmp_name'],$item_image['type']);
					
					/* Resize Image */
					$destination_url = WWW_ROOT . 'img/temp/'.$item_data->item_image;
					$image = imagecreatefromjpeg($item_image['tmp_name']);
					imagejpeg($image, $destination_url, 10);
					
					/* For App Image */
					$deletekeyname = 'item/'.$item_data->id.'/app';
					$this->AwsFile->deleteMatchingObjects($deletekeyname);
					$keyname = 'item/'.$item_data->id.'/app/'.$item_data->item_image;
					$this->AwsFile->putObjectFile($keyname,$destination_url,$item_image['type']);
					
					/* Delete Temp File */
					$file = new File(WWW_ROOT . $destination_url, false, 0777);
					$file->delete();
				}
			//pr($item);exit;
                $this->Flash->success(__('The item has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
		
            $this->Flash->error(__('The item could not be saved. Please, try again.'));
        }
        $categories = $this->Items->Categories->find('list')->where(['Categories.city_id'=>$city_id]);
        $brands = $this->Items->Brands->find('list')->where(['Brands.city_id'=>$city_id]);
        $units = $this->Items->ItemVariations->Units->find('list')->where(['Units.city_id'=>$city_id]);
		
        $this->set(compact('item', 'categories', 'brands', 'admins', 'sellers', 'cities','units'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Item id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
		$city_id=$this->Auth->User('city_id'); 
		$user_id=$this->Auth->User('id');
		$this->viewBuilder()->layout('admin_portal');
        $item = $this->Items->get($id, [
            'contain' => ['ItemVariations']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $item = $this->Items->patchEntity($item, $this->request->getData());
            if ($this->Items->save($item)) {
                $this->Flash->success(__('The item has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The item could not be saved. Please, try again.'));
        }
        $categories = $this->Items->Categories->find('list')->where(['Categories.city_id'=>$city_id]);
        $brands = $this->Items->Brands->find('list')->where(['Brands.city_id'=>$city_id]);
        $units = $this->Items->ItemVariations->Units->find('list')->where(['Units.city_id'=>$city_id]);
        $this->set(compact('item', 'categories', 'brands', 'admins', 'sellers', 'cities','units'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Item id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $item = $this->Items->get($id);
        if ($this->Items->delete($item)) {
            $this->Flash->success(__('The item has been deleted.'));
        } else {
            $this->Flash->error(__('The item could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
