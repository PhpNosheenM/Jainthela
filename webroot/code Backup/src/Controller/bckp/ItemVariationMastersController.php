<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ItemVariationMasters Controller
 *
 * @property \App\Model\Table\ItemVariationMastersTable $ItemVariationMasters
 *
 * @method \App\Model\Entity\ItemVariationMaster[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ItemVariationMastersController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Items', 'UnitVariations']
        ];
        $itemVariationMasters = $this->paginate($this->ItemVariationMasters);

        $this->set(compact('itemVariationMasters'));
    }

    /**
     * View method
     *
     * @param string|null $id Item Variation Master id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $itemVariationMaster = $this->ItemVariationMasters->get($id, [
            'contain' => ['Items', 'UnitVariations']
        ]);

        $this->set('itemVariationMaster', $itemVariationMaster);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $itemVariationMaster = $this->ItemVariationMasters->newEntity();
        if ($this->request->is('post')) {
            $itemVariationMaster = $this->ItemVariationMasters->patchEntity($itemVariationMaster, $this->request->getData());
            if ($this->ItemVariationMasters->save($itemVariationMaster)) {
                $this->Flash->success(__('The item variation master has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The item variation master could not be saved. Please, try again.'));
        }
        $items = $this->ItemVariationMasters->Items->find('list', ['limit' => 200]);
        $unitVariations = $this->ItemVariationMasters->UnitVariations->find('list', ['limit' => 200]);
        $this->set(compact('itemVariationMaster', 'items', 'unitVariations'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Item Variation Master id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $itemVariationMaster = $this->ItemVariationMasters->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $itemVariationMaster = $this->ItemVariationMasters->patchEntity($itemVariationMaster, $this->request->getData());
            if ($this->ItemVariationMasters->save($itemVariationMaster)) {
                $this->Flash->success(__('The item variation master has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The item variation master could not be saved. Please, try again.'));
        }
        $items = $this->ItemVariationMasters->Items->find('list', ['limit' => 200]);
        $unitVariations = $this->ItemVariationMasters->UnitVariations->find('list', ['limit' => 200]);
        $this->set(compact('itemVariationMaster', 'items', 'unitVariations'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Item Variation Master id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $itemVariationMaster = $this->ItemVariationMasters->get($id);
        if ($this->ItemVariationMasters->delete($itemVariationMaster)) {
            $this->Flash->success(__('The item variation master has been deleted.'));
        } else {
            $this->Flash->error(__('The item variation master could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
