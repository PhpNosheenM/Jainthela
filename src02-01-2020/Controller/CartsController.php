<?php
namespace App\Controller;

use App\Controller\AppController;

/**
* Carts Controller
*
* @property \App\Model\Table\CartsTable $Carts
*
* @method \App\Model\Entity\Cart[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
*/
class CartsController extends AppController
{
  
  /**
  * Index method
  *
  * @return \Cake\Http\Response|void
  */
  public function index()
  {
    $this->paginate = [
      'contain' => ['Cities', 'Customers', 'ItemVariations', 'ComboOffers']
    ];
    $carts = $this->paginate($this->Carts);
	
    $this->set(compact('carts'));
  }

  /**
  * View method
  *
  * @param string|null $id Cart id.
  * @return \Cake\Http\Response|void
  * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
  */
  public function view($id = null)
  {
    $cart = $this->Carts->get($id, [
      'contain' => ['Cities', 'Customers', 'ItemVariations', 'ComboOffers']
    ]);

    $this->set('cart', $cart);
  }

  /**
  * Add method
  *
  * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
  */
  public function add()
  {
    $cart = $this->Carts->newEntity();
    if ($this->request->is('post')) {
      $cart = $this->Carts->patchEntity($cart, $this->request->getData());
      if ($this->Carts->save($cart)) {
        $this->Flash->success(__('The cart has been saved.'));

        return $this->redirect(['action' => 'index']);
      }
      $this->Flash->error(__('The cart could not be saved. Please, try again.'));
    }
    $cities = $this->Carts->Cities->find('list', ['limit' => 200]);
    $customers = $this->Carts->Customers->find('list', ['limit' => 200]);
    $itemVariations = $this->Carts->ItemVariations->find('list', ['limit' => 200]);
    $comboOffers = $this->Carts->ComboOffers->find('list', ['limit' => 200]);
    $this->set(compact('cart', 'cities', 'customers', 'itemVariations', 'comboOffers'));
  }

  /**
  * Edit method
  *
  * @param string|null $id Cart id.
  * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
  * @throws \Cake\Network\Exception\NotFoundException When record not found.
  */
  public function edit($id = null)
  {
    $cart = $this->Carts->get($id, [
      'contain' => []
    ]);
    if ($this->request->is(['patch', 'post', 'put'])) {
      $cart = $this->Carts->patchEntity($cart, $this->request->getData());
      if ($this->Carts->save($cart)) {
        $this->Flash->success(__('The cart has been saved.'));

        return $this->redirect(['action' => 'index']);
      }
      $this->Flash->error(__('The cart could not be saved. Please, try again.'));
    }
    $cities = $this->Carts->Cities->find('list', ['limit' => 200]);
    $customers = $this->Carts->Customers->find('list', ['limit' => 200]);
    $itemVariations = $this->Carts->ItemVariations->find('list', ['limit' => 200]);
    $comboOffers = $this->Carts->ComboOffers->find('list', ['limit' => 200]);
    $this->set(compact('cart', 'cities', 'customers', 'itemVariations', 'comboOffers'));
  }

  /**
  * Delete method
  *
  * @param string|null $id Cart id.
  * @return \Cake\Http\Response|null Redirects to index.
  * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
  */
  public function delete($id = null)
  {
    $this->request->allowMethod(['post', 'delete']);
    $cart = $this->Carts->get($id);
    if ($this->Carts->delete($cart)) {
      $this->Flash->success(__('The cart has been deleted.'));
    } else {
      $this->Flash->error(__('The cart could not be deleted. Please, try again.'));
    }

    return $this->redirect(['action' => 'index']);
  }
}
