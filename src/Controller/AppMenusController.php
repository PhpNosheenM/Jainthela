<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * AppMenus Controller
 *
 * @property \App\Model\Table\AppMenusTable $AppMenus
 *
 * @method \App\Model\Entity\AppMenu[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AppMenusController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $appMenus = $this->paginate($this->AppMenus);

        $this->set(compact('appMenus'));
    }

    /**
     * View method
     *
     * @param string|null $id App Menu id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $appMenu = $this->AppMenus->get($id, [
            'contain' => []
        ]);

        $this->set('appMenu', $appMenu);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $appMenu = $this->AppMenus->newEntity();
        if ($this->request->is('post')) {
            $appMenu = $this->AppMenus->patchEntity($appMenu, $this->request->getData());
            if ($this->AppMenus->save($appMenu)) {
                $this->Flash->success(__('The app menu has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The app menu could not be saved. Please, try again.'));
        }
        $this->set(compact('appMenu'));
    }

    /**
     * Edit method
     *
     * @param string|null $id App Menu id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $appMenu = $this->AppMenus->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $appMenu = $this->AppMenus->patchEntity($appMenu, $this->request->getData());
            if ($this->AppMenus->save($appMenu)) {
                $this->Flash->success(__('The app menu has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The app menu could not be saved. Please, try again.'));
        }
        $this->set(compact('appMenu'));
    }

    /**
     * Delete method
     *
     * @param string|null $id App Menu id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $appMenu = $this->AppMenus->get($id);
        if ($this->AppMenus->delete($appMenu)) {
            $this->Flash->success(__('The app menu has been deleted.'));
        } else {
            $this->Flash->error(__('The app menu could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
