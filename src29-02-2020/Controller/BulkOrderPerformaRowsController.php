<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * BulkOrderPerformaRows Controller
 *
 * @property \App\Model\Table\BulkOrderPerformaRowsTable $BulkOrderPerformaRows
 *
 * @method \App\Model\Entity\BulkOrderPerformaRow[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BulkOrderPerformaRowsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['BulkOrderPerformas', 'Categories', 'Brands', 'Items']
        ];
        $bulkOrderPerformaRows = $this->paginate($this->BulkOrderPerformaRows);

        $this->set(compact('bulkOrderPerformaRows'));
    }

    /**
     * View method
     *
     * @param string|null $id Bulk Order Performa Row id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $bulkOrderPerformaRow = $this->BulkOrderPerformaRows->get($id, [
            'contain' => ['BulkOrderPerformas', 'Categories', 'Brands', 'Items']
        ]);

        $this->set('bulkOrderPerformaRow', $bulkOrderPerformaRow);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $bulkOrderPerformaRow = $this->BulkOrderPerformaRows->newEntity();
        if ($this->request->is('post')) {
            $bulkOrderPerformaRow = $this->BulkOrderPerformaRows->patchEntity($bulkOrderPerformaRow, $this->request->getData());
            if ($this->BulkOrderPerformaRows->save($bulkOrderPerformaRow)) {
                $this->Flash->success(__('The bulk order performa row has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The bulk order performa row could not be saved. Please, try again.'));
        }
        $bulkOrderPerformas = $this->BulkOrderPerformaRows->BulkOrderPerformas->find('list', ['limit' => 200]);
        $categories = $this->BulkOrderPerformaRows->Categories->find('list', ['limit' => 200]);
        $brands = $this->BulkOrderPerformaRows->Brands->find('list', ['limit' => 200]);
        $items = $this->BulkOrderPerformaRows->Items->find('list', ['limit' => 200]);
        $this->set(compact('bulkOrderPerformaRow', 'bulkOrderPerformas', 'categories', 'brands', 'items'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Bulk Order Performa Row id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $bulkOrderPerformaRow = $this->BulkOrderPerformaRows->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $bulkOrderPerformaRow = $this->BulkOrderPerformaRows->patchEntity($bulkOrderPerformaRow, $this->request->getData());
            if ($this->BulkOrderPerformaRows->save($bulkOrderPerformaRow)) {
                $this->Flash->success(__('The bulk order performa row has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The bulk order performa row could not be saved. Please, try again.'));
        }
        $bulkOrderPerformas = $this->BulkOrderPerformaRows->BulkOrderPerformas->find('list', ['limit' => 200]);
        $categories = $this->BulkOrderPerformaRows->Categories->find('list', ['limit' => 200]);
        $brands = $this->BulkOrderPerformaRows->Brands->find('list', ['limit' => 200]);
        $items = $this->BulkOrderPerformaRows->Items->find('list', ['limit' => 200]);
        $this->set(compact('bulkOrderPerformaRow', 'bulkOrderPerformas', 'categories', 'brands', 'items'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Bulk Order Performa Row id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $bulkOrderPerformaRow = $this->BulkOrderPerformaRows->get($id);
        if ($this->BulkOrderPerformaRows->delete($bulkOrderPerformaRow)) {
            $this->Flash->success(__('The bulk order performa row has been deleted.'));
        } else {
            $this->Flash->error(__('The bulk order performa row could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
