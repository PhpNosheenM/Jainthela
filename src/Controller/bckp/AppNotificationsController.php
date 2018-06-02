<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * AppNotifications Controller
 *
 * @property \App\Model\Table\AppNotificationsTable $AppNotifications
 *
 * @method \App\Model\Entity\AppNotification[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AppNotificationsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Cities', 'Locations', 'Items', 'ItemVariations', 'ComboOffers', 'WishLists', 'Categories']
        ];
        $appNotifications = $this->paginate($this->AppNotifications);

        $this->set(compact('appNotifications'));
    }

    /**
     * View method
     *
     * @param string|null $id App Notification id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $appNotification = $this->AppNotifications->get($id, [
            'contain' => ['Cities', 'Locations', 'Items', 'ItemVariations', 'ComboOffers', 'WishLists', 'Categories', 'AppNotificationCustomers']
        ]);

        $this->set('appNotification', $appNotification);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $appNotification = $this->AppNotifications->newEntity();
        if ($this->request->is('post')) {
            $appNotification = $this->AppNotifications->patchEntity($appNotification, $this->request->getData());
            if ($this->AppNotifications->save($appNotification)) {
                $this->Flash->success(__('The app notification has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The app notification could not be saved. Please, try again.'));
        }
        $cities = $this->AppNotifications->Cities->find('list', ['limit' => 200]);
        $locations = $this->AppNotifications->Locations->find('list', ['limit' => 200]);
        $items = $this->AppNotifications->Items->find('list', ['limit' => 200]);
        $itemVariations = $this->AppNotifications->ItemVariations->find('list', ['limit' => 200]);
        $comboOffers = $this->AppNotifications->ComboOffers->find('list', ['limit' => 200]);
        $wishLists = $this->AppNotifications->WishLists->find('list', ['limit' => 200]);
        $categories = $this->AppNotifications->Categories->find('list', ['limit' => 200]);
        $this->set(compact('appNotification', 'cities', 'locations', 'items', 'itemVariations', 'comboOffers', 'wishLists', 'categories'));
    }

    /**
     * Edit method
     *
     * @param string|null $id App Notification id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $appNotification = $this->AppNotifications->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $appNotification = $this->AppNotifications->patchEntity($appNotification, $this->request->getData());
            if ($this->AppNotifications->save($appNotification)) {
                $this->Flash->success(__('The app notification has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The app notification could not be saved. Please, try again.'));
        }
        $cities = $this->AppNotifications->Cities->find('list', ['limit' => 200]);
        $locations = $this->AppNotifications->Locations->find('list', ['limit' => 200]);
        $items = $this->AppNotifications->Items->find('list', ['limit' => 200]);
        $itemVariations = $this->AppNotifications->ItemVariations->find('list', ['limit' => 200]);
        $comboOffers = $this->AppNotifications->ComboOffers->find('list', ['limit' => 200]);
        $wishLists = $this->AppNotifications->WishLists->find('list', ['limit' => 200]);
        $categories = $this->AppNotifications->Categories->find('list', ['limit' => 200]);
        $this->set(compact('appNotification', 'cities', 'locations', 'items', 'itemVariations', 'comboOffers', 'wishLists', 'categories'));
    }

    /**
     * Delete method
     *
     * @param string|null $id App Notification id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $appNotification = $this->AppNotifications->get($id);
        if ($this->AppNotifications->delete($appNotification)) {
            $this->Flash->success(__('The app notification has been deleted.'));
        } else {
            $this->Flash->error(__('The app notification could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
