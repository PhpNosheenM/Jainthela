<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * CompanyDetails Controller
 *
 * @property \App\Model\Table\CompanyDetailsTable $CompanyDetails
 *
 * @method \App\Model\Entity\CompanyDetail[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CompanyDetailsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Cities']
        ];
        $companyDetails = $this->paginate($this->CompanyDetails);

        $this->set(compact('companyDetails'));
    }

    /**
     * View method
     *
     * @param string|null $id Company Detail id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $companyDetail = $this->CompanyDetails->get($id, [
            'contain' => ['Cities']
        ]);

        $this->set('companyDetail', $companyDetail);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $companyDetail = $this->CompanyDetails->newEntity();
        if ($this->request->is('post')) {
            $companyDetail = $this->CompanyDetails->patchEntity($companyDetail, $this->request->getData());
            if ($this->CompanyDetails->save($companyDetail)) {
                $this->Flash->success(__('The company detail has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The company detail could not be saved. Please, try again.'));
        }
        $cities = $this->CompanyDetails->Cities->find('list', ['limit' => 200]);
        $this->set(compact('companyDetail', 'cities'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Company Detail id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $companyDetail = $this->CompanyDetails->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $companyDetail = $this->CompanyDetails->patchEntity($companyDetail, $this->request->getData());
            if ($this->CompanyDetails->save($companyDetail)) {
                $this->Flash->success(__('The company detail has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The company detail could not be saved. Please, try again.'));
        }
        $cities = $this->CompanyDetails->Cities->find('list', ['limit' => 200]);
        $this->set(compact('companyDetail', 'cities'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Company Detail id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $companyDetail = $this->CompanyDetails->get($id);
        if ($this->CompanyDetails->delete($companyDetail)) {
            $this->Flash->success(__('The company detail has been deleted.'));
        } else {
            $this->Flash->error(__('The company detail could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
