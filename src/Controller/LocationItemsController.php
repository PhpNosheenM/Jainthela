<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * LocationItems Controller
 *
 * @property \App\Model\Table\LocationItemsTable $LocationItems
 *
 * @method \App\Model\Entity\LocationItem[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LocationItemsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Items', 'ItemVariations', 'Locations']
        ];
        $locationItems = $this->paginate($this->LocationItems);

        $this->set(compact('locationItems'));
    }

    /**
     * View method
     *
     * @param string|null $id Location Item id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $locationItem = $this->LocationItems->get($id, [
            'contain' => ['Items', 'ItemVariations', 'Locations']
        ]);

        $this->set('locationItem', $locationItem);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $locationItem = $this->LocationItems->newEntity();
        if ($this->request->is('post')) {
            $locationItem = $this->LocationItems->patchEntity($locationItem, $this->request->getData());
            if ($this->LocationItems->save($locationItem)) {
                $this->Flash->success(__('The location item has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The location item could not be saved. Please, try again.'));
        }
        $items = $this->LocationItems->Items->find('list', ['limit' => 200]);
        $itemVariations = $this->LocationItems->ItemVariations->find('list', ['limit' => 200]);
        $locations = $this->LocationItems->Locations->find('list', ['limit' => 200]);
        $this->set(compact('locationItem', 'items', 'itemVariations', 'locations'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Location Item id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $locationItem = $this->LocationItems->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $locationItem = $this->LocationItems->patchEntity($locationItem, $this->request->getData());
            if ($this->LocationItems->save($locationItem)) {
                $this->Flash->success(__('The location item has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The location item could not be saved. Please, try again.'));
        }
        $items = $this->LocationItems->Items->find('list', ['limit' => 200]);
        $itemVariations = $this->LocationItems->ItemVariations->find('list', ['limit' => 200]);
        $locations = $this->LocationItems->Locations->find('list', ['limit' => 200]);
        $this->set(compact('locationItem', 'items', 'itemVariations', 'locations'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Location Item id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $locationItem = $this->LocationItems->get($id);
        if ($this->LocationItems->delete($locationItem)) {
            $this->Flash->success(__('The location item has been deleted.'));
        } else {
            $this->Flash->error(__('The location item could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
