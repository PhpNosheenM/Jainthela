<?php
namespace App\Controller;

namespace App\Controller;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\View\View;

/**
 * WalletWithdrawRequests Controller
 *
 * @property \App\Model\Table\WalletWithdrawRequestsTable $WalletWithdrawRequests
 *
 * @method \App\Model\Entity\WalletWithdrawRequest[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class WalletWithdrawRequestsController extends AppController
{

		public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Security->setConfig('unlockedActions', ['add','index','delete','edits']);

    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
		$city_id=$this->Auth->User('city_id'); 
		$user_id=$this->Auth->User('id');
		$user_type=$this->Auth->User('user_type');
		if($user_type=='Super Admin'){
			$this->viewBuilder()->layout('super_admin_layout');
		}
        $this->paginate = [
            'contain' => ['Cities', 'Customers']
        ];
		$walletWithdrawRequest = $this->WalletWithdrawRequests->newEntity();
		 if ($this->request->is('post')) {
			$SelectData=$this->request->data;
			
			return $this->redirect(['action' => 'add',json_encode($SelectData['to_be_send'])]);
			//$this->add($SelectData);
		 }
		
		
        $walletWithdrawRequests = $this->paginate($this->WalletWithdrawRequests->find()->where(['WalletWithdrawRequests.city_id'=>$city_id,'WalletWithdrawRequests.status'=>'Pending']));
		// pr($walletWithdrawRequests->toArray());exit;
        $this->set(compact('walletWithdrawRequests','walletWithdrawRequest'));
    }

    public function add($SelectData=null)
    {
		
		$city_id=$this->Auth->User('city_id'); 
		$user_id=$this->Auth->User('id');
		$user_type=$this->Auth->User('user_type');
		$financial_year_id=$this->Auth->User('financial_year_id');
		if($user_type=='Super Admin'){
			$this->viewBuilder()->layout('super_admin_layout');
		}
		
		$SelectData=(json_decode($SelectData));
		
		$SelectedCustomer=[];
		$RefundAmount=[];
		foreach($SelectData as $data){
			if($data > 0){
				$walletWithdrawRequestData = $this->WalletWithdrawRequests->get($data,['contain'=>['Ledgers']]);
				$SelectedCustomer[$data]=['text'=>$walletWithdrawRequestData->ledger->name,'value'=>$walletWithdrawRequestData->ledger_id];
				$RefundAmount[$data]=$walletWithdrawRequestData->amount;
				
			}
			
		}
		
        $walletWithdrawRequest = $this->WalletWithdrawRequests->newEntity();
        if ($this->request->is('post')) {
            
			$payment_rows=$this->request->getData()['payment_rows']; 
			
			//pr($payment_rows); exit;
			
			//Accounting
				$Voucher_no = $this->WalletWithdrawRequests->Payments->find()->select(['voucher_no'])->where(['city_id'=>$city_id])->order(['voucher_no' => 'DESC'])->first();
				if($Voucher_no){
					$voucher_no=$Voucher_no->voucher_no+1;
				}else{
					$voucher_no=1;
				}
				
				$Payment = $this->WalletWithdrawRequests->Payments->newEntity();
				$Payment->voucher_no = $voucher_no;
				$Payment->city_id = $city_id;
				$Payment->financial_year_id = $financial_year_id;
				$Payment->transaction_date = date('Y-m-d');
				$Payment->created_on = date('Y-m-d');
				$Payment->created_by =$user_id;
				$Payment->narration ="Wallet Refund";
				
				if($this->WalletWithdrawRequests->Payments->save($Payment)) {
				
					foreach($payment_rows as $data){ 
					
						$PaymentRows = $this->WalletWithdrawRequests->Payments->PaymentRows->newEntity();
						$PaymentRows->payment_id = $Payment->id;
						$PaymentRows->ledger_id = $data['ledger_id'];
						$PaymentRows->cr_dr = $data['cr_dr'];
						$PaymentRows->debit = $data['debit'];
						$PaymentRows->credit =$data['credit']; 
						if(@$data['mode_of_payment']){
							@$PaymentRows->mode_of_payment =@$data['mode_of_payment'];  
							@$PaymentRows->cheque_no =@$data['cheque_no'];  
							@$PaymentRows->cheque_date =date('Y-m-d',strtotime($data['cheque_date']));
							//@$PaymentRows->cheque_date =@$data['cheque_date'];  
						}
						$this->WalletWithdrawRequests->Payments->PaymentRows->save($PaymentRows);
						
						$AccountingEntries1 = $this->WalletWithdrawRequests->Payments->AccountingEntries->newEntity();
						$AccountingEntries1->ledger_id = $data['ledger_id'];
						$AccountingEntries1->city_id = $city_id;
						$AccountingEntries1->transaction_date = date('Y-m-d');
						$AccountingEntries1->debit = $data['debit'];
						$AccountingEntries1->credit =$data['credit'];  
						$AccountingEntries1->payment_id = $Payment->id;
						$this->WalletWithdrawRequests->Payments->AccountingEntries->save($AccountingEntries1);
						
						
					} 
					
					
					
					//update in WalletWithdrawRequest
					foreach($RefundAmount as $key=>$data){
						$WalletData = $this->WalletWithdrawRequests->get($key);
						$query = $this->WalletWithdrawRequests->Wallets->query();
						$query->insert(['customer_id', 'payment_id', 'used_amount', 'transaction_type', 'amount_type', 'city_id'])
								->values([
								'customer_id' => $WalletData->customer_id,
								'payment_id' => $Payment->id,
								'used_amount' => $data,
								'transaction_type' => 'Deduct',
								'amount_type' => 'Refund Amount',
								'city_id' => $city_id
								])
						->execute();
						
						$query = $this->WalletWithdrawRequests->query();
						$query->update()
						->set(['status'=>'Completed','completed_on'=>date('Y-m-d')])
						->where(['id'=>$key])
						->execute();
					}	
					
					$this->Flash->success(__('The Payment has been Saved.'));
					return $this->redirect(['controller'=>'WalletWithdrawRequests','action' => 'index']);
				}
				
												
           
        }
		//pr($SelectData);exit;
		
		$customerLedgers = $this->WalletWithdrawRequests->Ledgers->find('list')
		->where(['Ledgers.customer_id > ' =>0,'Ledgers.city_id'=>$city_id]);
		
		$cashBankLedgerData= $this->WalletWithdrawRequests->Ledgers->AccountingGroups->find()
		->where(['AccountingGroups.cash' =>1,'AccountingGroups.city_id'=>$city_id])
		->orWhere(['AccountingGroups.bank' =>1,'AccountingGroups.city_id'=>$city_id]);
		
		$partyGroups=[];
		
		foreach($cashBankLedgerData as $partyParentGroup)
		{
			
			$partyChildGroups = $this->WalletWithdrawRequests->Ledgers->AccountingGroups->find('children', ['for' => $partyParentGroup->id]);
			$partyGroups[]=$partyParentGroup->id;
			foreach($partyChildGroups as $partyChildGroup){
				$partyGroups[]=$partyChildGroup->id;
			}
		}
		
		$partyLedgers = $this->WalletWithdrawRequests->Ledgers->find()
		->where(['Ledgers.accounting_group_id IN' =>$partyGroups,'Ledgers.city_id'=>$city_id])->contain(['AccountingGroups']);
		//pr($partyLedgers->toArray()); exit;
		$cashBankLedgers=[];
		foreach($partyLedgers as $data){ 
			
				if($data->ccavenue=="yes"){
					
				}else{ 
					if($data->accounting_group->bank==0){
							$cashBankLedgers[]=['text' =>$data->name, 'value' => $data->id ,'open_window' => 'wrfwef','bank_and_cash' => 'no'];
						}else{
							$cashBankLedgers[]=['text' =>$data->name, 'value' => $data->id ,'open_window' => 'bank','bank_and_cash' => 'yes'];
						}
				}
			
		}
		
	//	pr($cashBankLedgers);
		//pr($cashBankLedgers);
		//exit;
		
        $cities = $this->WalletWithdrawRequests->Cities->find('list', ['limit' => 200]);
        $customers = $this->WalletWithdrawRequests->Customers->find('list', ['limit' => 200]);
        $this->set(compact('walletWithdrawRequest', 'cities', 'customers','RefundAmount','SelectedCustomer','customerLedgers','cashBankLedgers'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Wallet Withdraw Request id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $walletWithdrawRequest = $this->WalletWithdrawRequests->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $walletWithdrawRequest = $this->WalletWithdrawRequests->patchEntity($walletWithdrawRequest, $this->request->getData());
            if ($this->WalletWithdrawRequests->save($walletWithdrawRequest)) {
                $this->Flash->success(__('The wallet withdraw request has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The wallet withdraw request could not be saved. Please, try again.'));
        }
        $cities = $this->WalletWithdrawRequests->Cities->find('list', ['limit' => 200]);
        $customers = $this->WalletWithdrawRequests->Customers->find('list', ['limit' => 200]);
        $this->set(compact('walletWithdrawRequest', 'cities', 'customers'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Wallet Withdraw Request id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $walletWithdrawRequest = $this->WalletWithdrawRequests->get($id);
        if ($this->WalletWithdrawRequests->delete($walletWithdrawRequest)) {
            $this->Flash->success(__('The wallet withdraw request has been deleted.'));
        } else {
            $this->Flash->error(__('The wallet withdraw request could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
