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
    public function index()
    {
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
