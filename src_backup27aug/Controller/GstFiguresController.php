<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * GstFigures Controller
 *
 * @property \App\Model\Table\GstFiguresTable $GstFigures
 *
 * @method \App\Model\Entity\GstFigure[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class GstFiguresController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Locations']
        ];
        $gstFigures = $this->paginate($this->GstFigures);

        $this->set(compact('gstFigures'));
    }

    /**
     * View method
     *
     * @param string|null $id Gst Figure id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $gstFigure = $this->GstFigures->get($id, [
            'contain' => ['Locations', 'Ledgers', 'SaleReturnRows', 'SalesInvoiceRows']
        ]);

        $this->set('gstFigure', $gstFigure);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $gstFigure = $this->GstFigures->newEntity();
        if ($this->request->is('post')) {
            $gstFigure = $this->GstFigures->patchEntity($gstFigure, $this->request->getData());
            if ($this->GstFigures->save($gstFigure)) {
                $this->Flash->success(__('The gst figure has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The gst figure could not be saved. Please, try again.'));
        }
        $locations = $this->GstFigures->Locations->find('list', ['limit' => 200]);
        $this->set(compact('gstFigure', 'locations'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Gst Figure id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $gstFigure = $this->GstFigures->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $gstFigure = $this->GstFigures->patchEntity($gstFigure, $this->request->getData());
            if ($this->GstFigures->save($gstFigure)) {
                $this->Flash->success(__('The gst figure has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The gst figure could not be saved. Please, try again.'));
        }
        $locations = $this->GstFigures->Locations->find('list', ['limit' => 200]);
        $this->set(compact('gstFigure', 'locations'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Gst Figure id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $gstFigure = $this->GstFigures->get($id);
        if ($this->GstFigures->delete($gstFigure)) {
            $this->Flash->success(__('The gst figure has been deleted.'));
        } else {
            $this->Flash->error(__('The gst figure could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
