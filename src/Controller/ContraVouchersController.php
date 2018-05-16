<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\View\View;

/**
 * ContraVouchers Controller
 *
 * @property \App\Model\Table\ContraVouchersTable $ContraVouchers
 *
 * @method \App\Model\Entity\ContraVoucher[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ContraVouchersController extends AppController
{

	public function beforeFilter(Event $event)
	{
		parent::beforeFilter($event);
		 $this->Security->setConfig('unlockedActions', ['add','index']);
	}
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
        $contraVouchers = $this->paginate($this->ContraVouchers);

        $this->set(compact('contraVouchers'));
    }

    /**
     * View method
     *
     * @param string|null $id Contra Voucher id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $contraVoucher = $this->ContraVouchers->get($id, [
            'contain' => ['Locations', 'AccountingEntries']
        ]);

        $this->set('contraVoucher', $contraVoucher);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
		$city_id=$this->Auth->User('city_id'); 
		$location_id=$this->Auth->User('location_id'); 
		$user_id=$this->Auth->User('id');
		$this->viewBuilder()->layout('admin_portal');
        $contraVoucher = $this->ContraVouchers->newEntity();
		if ($this->request->is('post')) {
			
			//$this->request->data['transaction_date'] = date("Y-m-d",strtotime($this->request->getData()['transaction_date']));
			$Voucher = $this->ContraVouchers->find()->select(['voucher_no'])->where(['location_id'=>$location_id])->order(['voucher_no' => 'DESC'])->first();
			if($Voucher)
			{
				$contraVoucher->voucher_no = $Voucher->voucher_no+1;
			}
			else
			{
				$contraVoucher->voucher_no = 1;
			}
			$contraVoucher->location_id = $location_id;
			
			$contraVoucher = $this->ContraVouchers->patchEntity($contraVoucher, $this->request->getData(), [
							'associated' => ['ContraVoucherRows','ContraVoucherRows.ReferenceDetails']
						]);
					
			//transaction date for contraVoucher code start here--
			foreach($contraVoucher->contra_voucher_row as $payment_row)
			{
				if(!empty($payment_row->reference_details))
				{
					foreach($payment_row->reference_details as $reference_detail)
					{
						$reference_detail->transaction_date = $contraVoucher->transaction_date;
					}
				}
			}
			//transaction date for contraVoucher code close here-- 
			
			if ($this->ContraVouchers->save($contraVoucher)) {
				
			foreach($contraVoucher->contra_voucher_row as $payment_row)
				{
					$accountEntry = $this->ContraVouchers->AccountingEntries->newEntity();
					$accountEntry->ledger_id                  = $payment_row->ledger_id;
					$accountEntry->debit                      = @$payment_row->debit;
					$accountEntry->credit                     = @$payment_row->credit;
					$accountEntry->transaction_date           = $contraVoucher->transaction_date;
					$accountEntry->location_id                = $location_id;
					$accountEntry->city_id                    = $city_id;
					$accountEntry->contra_voucher_id                 = $contraVoucher->id;
					$accountEntry->contra_voucher_row_id             = $payment_row->id;
					$accountEntry->entry_from                 = 'web';
					$this->ContraVouchers->AccountingEntries->save($accountEntry);
				}
				$this->Flash->success(__('The contraVoucher has been saved.'));

				return $this->redirect(['action' => 'index']);
			}
			
			$this->Flash->error(__('The contraVoucher could not be saved. Please, try again.'));
		}
		 
		
		$Voucher = $this->ContraVouchers->find()->select(['voucher_no'])->where(['location_id'=>$location_id])->order(['voucher_no' => 'DESC'])->first();
		if($Voucher)
		{
			$voucher_no=$Voucher->voucher_no+1;
		}
		else
		{
			$voucher_no=1;
		} 
		
		$bankParentGroups = $this->ContraVouchers->ContraVoucherRows->Ledgers->AccountingGroups->find()
						->where(['AccountingGroups.bank'=>'1']);
						
		$bankGroups=[];
		
		foreach($bankParentGroups as $bankParentGroup)
		{
			$accountingGroups = $this->ContraVouchers->ContraVoucherRows->Ledgers->AccountingGroups
			->find('children', ['for' => $bankParentGroup->id])->toArray();
			$bankGroups[]=$bankParentGroup->id;
			foreach($accountingGroups as $accountingGroup){
				$bankGroups[]=$accountingGroup->id;
			}
		}
		
		$partyParentGroups = $this->ContraVouchers->ContraVoucherRows->Ledgers->AccountingGroups->find()
							->where(['AccountingGroups.contra_voucher_ledger'=>1]);

		$partyGroups=[];
		
		foreach($partyParentGroups as $partyParentGroup)
		{
			
			$partyChildGroups = $this->ContraVouchers->ContraVoucherRows->Ledgers->AccountingGroups->find('children', ['for' => $partyParentGroup->id]);
			$partyGroups[]=$partyParentGroup->id;
			foreach($partyChildGroups as $partyChildGroup){
				$partyGroups[]=$partyChildGroup->id;
			}
		}
	
		$partyLedgers = $this->ContraVouchers->ContraVoucherRows->Ledgers->find()
		->where(['Ledgers.accounting_group_id IN' =>$partyGroups]);
		
		//$ledgers = $this->Payments->ContraVoucherRows->Ledgers->find()->where(['company_id'=>$company_id]);
		foreach($partyLedgers as $ledger){
			if(in_array($ledger->accounting_group_id,$bankGroups)){
				$ledgerOptions[]=['text' =>$ledger->name, 'value' => $ledger->id ,'open_window' => 'bank','bank_and_cash' => 'yes'];
			}
			else if($ledger->bill_to_bill_accounting == 'yes'){
				$ledgerOptions[]=['text' =>$ledger->name, 'value' => $ledger->id,'open_window' => 'party','bank_and_cash' => 'no','default_days'=>$ledger->default_credit_days];
			}
			else if(in_array($ledger->accounting_group_id,$cashGroups)){
				$ledgerOptions[]=['text' =>$ledger->name, 'value' => $ledger->id ,'open_window' => 'no','bank_and_cash' => 'yes'];
			}
			else{
				$ledgerOptions[]=['text' =>$ledger->name, 'value' => $ledger->id,'open_window' => 'no','bank_and_cash' => 'no' ];
			}
			
		}
		
		
        $locations = $this->ContraVouchers->Locations->find('list', ['limit' => 200]);
        $this->set(compact('voucher_no','contraVoucher', 'locations', 'voucher_no','ledgerOptions','city_id'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Contra Voucher id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $contraVoucher = $this->ContraVouchers->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $contraVoucher = $this->ContraVouchers->patchEntity($contraVoucher, $this->request->getData());
            if ($this->ContraVouchers->save($contraVoucher)) {
                $this->Flash->success(__('The contra voucher has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The contra voucher could not be saved. Please, try again.'));
        }
        $locations = $this->ContraVouchers->Locations->find('list', ['limit' => 200]);
        $this->set(compact('contraVoucher', 'locations'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Contra Voucher id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $contraVoucher = $this->ContraVouchers->get($id);
        if ($this->ContraVouchers->delete($contraVoucher)) {
            $this->Flash->success(__('The contra voucher has been deleted.'));
        } else {
            $this->Flash->error(__('The contra voucher could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
