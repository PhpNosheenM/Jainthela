<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ChallanRows Controller
 *
 * @property \App\Model\Table\ChallanRowsTable $ChallanRows
 *
 * @method \App\Model\Entity\ChallanRow[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ChallanRowsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Challans', 'OrderDetails', 'Items', 'ItemVariations', 'ComboOffers', 'GstFigures']
        ];
        $challanRows = $this->paginate($this->ChallanRows);

        $this->set(compact('challanRows'));
    }

    /**
     * View method
     *
     * @param string|null $id Challan Row id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $challanRow = $this->ChallanRows->get($id, [
            'contain' => ['Challans', 'OrderDetails', 'Items', 'ItemVariations', 'ComboOffers', 'GstFigures']
        ]);

        $this->set('challanRow', $challanRow);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $challanRow = $this->ChallanRows->newEntity();
        if ($this->request->is('post')) {
            $challanRow = $this->ChallanRows->patchEntity($challanRow, $this->request->getData());
            if ($this->ChallanRows->save($challanRow)) {
                $this->Flash->success(__('The challan row has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The challan row could not be saved. Please, try again.'));
        }
        $challans = $this->ChallanRows->Challans->find('list', ['limit' => 200]);
        $orderDetails = $this->ChallanRows->OrderDetails->find('list', ['limit' => 200]);
        $items = $this->ChallanRows->Items->find('list', ['limit' => 200]);
        $itemVariations = $this->ChallanRows->ItemVariations->find('list', ['limit' => 200]);
        $comboOffers = $this->ChallanRows->ComboOffers->find('list', ['limit' => 200]);
        $gstFigures = $this->ChallanRows->GstFigures->find('list', ['limit' => 200]);
        $this->set(compact('challanRow', 'challans', 'orderDetails', 'items', 'itemVariations', 'comboOffers', 'gstFigures'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Challan Row id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $challanRow = $this->ChallanRows->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $challanRow = $this->ChallanRows->patchEntity($challanRow, $this->request->getData());
            if ($this->ChallanRows->save($challanRow)) {
                $this->Flash->success(__('The challan row has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The challan row could not be saved. Please, try again.'));
        }
        $challans = $this->ChallanRows->Challans->find('list', ['limit' => 200]);
        $orderDetails = $this->ChallanRows->OrderDetails->find('list', ['limit' => 200]);
        $items = $this->ChallanRows->Items->find('list', ['limit' => 200]);
        $itemVariations = $this->ChallanRows->ItemVariations->find('list', ['limit' => 200]);
        $comboOffers = $this->ChallanRows->ComboOffers->find('list', ['limit' => 200]);
        $gstFigures = $this->ChallanRows->GstFigures->find('list', ['limit' => 200]);
        $this->set(compact('challanRow', 'challans', 'orderDetails', 'items', 'itemVariations', 'comboOffers', 'gstFigures'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Challan Row id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $challanRow = $this->ChallanRows->get($id);
        if ($this->ChallanRows->delete($challanRow)) {
            $this->Flash->success(__('The challan row has been deleted.'));
        } else {
            $this->Flash->error(__('The challan row could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
