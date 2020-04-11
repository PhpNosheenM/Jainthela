<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * FinancialYears Controller
 *
 * @property \App\Model\Table\FinancialYearsTable $FinancialYears
 *
 * @method \App\Model\Entity\FinancialYear[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FinancialYearsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Locations', 'Cities']
        ];
        $financialYears = $this->paginate($this->FinancialYears);

        $this->set(compact('financialYears'));
    }

    /**
     * View method
     *
     * @param string|null $id Financial Year id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $financialYear = $this->FinancialYears->get($id, [
            'contain' => ['Locations', 'Cities']
        ]);

        $this->set('financialYear', $financialYear);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $financialYear = $this->FinancialYears->newEntity();
        if ($this->request->is('post')) {
            $financialYear = $this->FinancialYears->patchEntity($financialYear, $this->request->getData());
            if ($this->FinancialYears->save($financialYear)) {
                $this->Flash->success(__('The financial year has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The financial year could not be saved. Please, try again.'));
        }
        $locations = $this->FinancialYears->Locations->find('list', ['limit' => 200]);
        $cities = $this->FinancialYears->Cities->find('list', ['limit' => 200]);
        $this->set(compact('financialYear', 'locations', 'cities'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Financial Year id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $financialYear = $this->FinancialYears->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $financialYear = $this->FinancialYears->patchEntity($financialYear, $this->request->getData());
            if ($this->FinancialYears->save($financialYear)) {
                $this->Flash->success(__('The financial year has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The financial year could not be saved. Please, try again.'));
        }
        $locations = $this->FinancialYears->Locations->find('list', ['limit' => 200]);
        $cities = $this->FinancialYears->Cities->find('list', ['limit' => 200]);
        $this->set(compact('financialYear', 'locations', 'cities'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Financial Year id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $financialYear = $this->FinancialYears->get($id);
        if ($this->FinancialYears->delete($financialYear)) {
            $this->Flash->success(__('The financial year has been deleted.'));
        } else {
            $this->Flash->error(__('The financial year could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
