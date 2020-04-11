<?php
namespace App\Controller;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\View\View;
/**
 * Wallets Controller
 *
 * @property \App\Model\Table\WalletsTable $Wallets
 *
 * @method \App\Model\Entity\Wallet[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class WalletsController extends AppController
{
	public function initialize()
	{
		parent::initialize();
		$this->loadComponent('Csrf');
	}

	public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Security->setConfig('unlockedActions', ['add','index','delete','edits','approval','walletDeductApproval']);
		if (in_array($this->request->action, ['approval','walletDeductApproval'])) {
			 $this->eventManager()->off($this->Csrf);
		 }
		 $this->Auth->allow(['approval']);
    }
	
	
	 public function approval($id=null)
    {
		$city_id=$this->Auth->User('city_id'); 
		$user_id=$this->Auth->User('id');
		$user_type=$this->Auth->User('user_type');
		if($user_type=='Super Admin'){
			$this->viewBuilder()->layout('super_admin_layout');
		}else if($user_type=='Admin'){
			$this->viewBuilder()->layout('admin_portal');
		}
		   $this->paginate = [
			'limit' =>20
        ];  
		
		 if ($this->request->is(['post','put'])) {
			 
			//Accounting 
			$Voucher_no = $this->Wallets->Receipts->find()->select(['voucher_no'])->where(['city_id'=>$city_id])->order(['voucher_no' => 'DESC'])->first();
			if($Voucher_no){
				$voucher_no=$Voucher_no->voucher_no+1;
			}else{
				$voucher_no=1;
			}
			$receipt = $this->Wallets->Receipts->newEntity();
			$receipt->voucher_no = $voucher_no;
			$receipt->city_id = $city_id;
			$receipt->transaction_date = date('Y-m-d');
			$receipt->created_on = date('Y-m-d');
			$receipt->narration ="Amount From Wallet";
			$receipt=$this->Wallets->Receipts->save($receipt);
			
			
			$tests=$this->request->data('test');
			$totalAmount=0;
			foreach($tests as $data){
				//pr($data); exit;
				$query7 = $this->Wallets->query();
				$query7->update()
					->set(['transaction_type' => 'Added'])
					->where(['Wallets.id'=>$data])
					->execute();
				$wallet_details=$this->Wallets->get($data, [
					'contain' => ['Customers', 'PlansLeft']]);
			
				$customer_id=$wallet_details->customer_id;
				@$actual_amount=$wallet_details->add_amount;
				@$total_amount=$wallet_details->plans_left->total_amount;
				@$benifit=$total_amount-$actual_amount;
				$totalAmount+=@$actual_amount;
				$narration=$wallet_details->narration;
				
				
				$customer_details=$this->Wallets->Customers->find()
				->where(['Customers.id' => $customer_id])->first();
				$mob=$customer_details->username;
				$main_device_token1=$customer_details->device_token;
						 
				if((!empty($main_device_token1))){
				
					$device_token=$main_device_token1;
				} 
								 
				if(!empty($main_device_token1)){
					$tokens = array($device_token);
					$random=(string)mt_rand(1000,9999);
					$header = [
						'Content-Type:application/json',
						'Authorization: Key=AAAAXmNqxY4:APA91bG0X6RHVhwJKXUQGNSSCas44hruFdR6_CFd6WHPwx9abUr-WsrfEzsFInJawElgrp24QzaE4ksfmXu6kmIL6JG3yP487fierMys5byv-I1agRtMPIoSqdgCZf8R0iqsnds-u4CU'
					];

					$msg = [
						'title'=> 'Wallet Amount Added',
						'message' => $narration,
						'image' => 'img/jain.png',
						'link' => 'jainthela://wallet',
						'notification_id'    => $random,
					];
					
					$payload = array(
						'registration_ids' => $tokens,
						'data' => $msg
					);
					
					$curl = curl_init();
					curl_setopt_array($curl, array(
					  CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
					  CURLOPT_RETURNTRANSFER => true,
					  CURLOPT_CUSTOMREQUEST => "POST",
					  CURLOPT_POSTFIELDS => json_encode($payload),
					  CURLOPT_HTTPHEADER => $header
					));
					$response = curl_exec($curl);
					$err = curl_error($curl);
					curl_close($curl);
					//pr($payload);
					$final_result=json_decode($response);
					$sms_flag=$final_result->success; 	
					if ($err) {
					  //echo "cURL Error #:" . $err;
					} else {
						//echo $response;
					}
				}				
				
				
				
				
				//pr($actual_amount); exit;
				if($benifit>0){
					$this->loadmodel('MasterSetups');
					$setups=$this->MasterSetups->find()->where(['city_id'=>$city_id])->first();
					$cash_back_slot=$setups->cash_back_slot;
					$days=$setups->days;
					$after_slot_amount=$benifit/$cash_back_slot;
					
					$end_date=date('Y-m-d', strtotime("+".$days." days"));
					$today=date('Y-m-d');
					
					$promotions = $this->Wallets->Promotions->newEntity();
					$promotions->admin_id=$user_id;
					$promotions->city_id=$city_id;
					$promotions->offer_name='Cash Back Offer';
					$promotions->description='Cash Back Offer for you';
					$promotions->start_date=$today;
					$promotions->end_date=$end_date;
					
					$promo_data=$this->Wallets->Promotions->save($promotions);
					$promo_id=$promo_data->id;

						for($w=0;$w<$cash_back_slot;$w++){
							$jain_text='JAIN';
							$random=(string)mt_rand(01,99);
							$coupon_code=$jain_text.$promo_id.$random;
							
							$promotion_details = $this->Wallets->Promotions->PromotionDetails->newEntity();
							$promotion_details->promotion_id=$promo_id;
							$promotion_details->discount_in_amount=$after_slot_amount;
							$promotion_details->coupon_name=$coupon_code;
							$promotion_details->coupon_code=$coupon_code;
							$promotion_details->in_wallet='No';
							$promotion_details->is_free_shipping='No';
							
							$promo_detail_data=$this->Wallets->Promotions->PromotionDetails->save($promotion_details);
							
							$promo_detail_id=$promo_detail_data->id;
							
							$customer_promotion = $this->Wallets->CustomerPromotions->newEntity();
							$customer_promotion->city_id=$city_id;
							$customer_promotion->promotion_id=$promo_id;
							$customer_promotion->promotion_detail_id=$promo_detail_id;
							$customer_promotion->customer_id=$customer_id;
							$customer_promotion->city_id=$city_id;
							$customer_promotion->start_date=$today;
							$customer_promotion->end_date=$end_date; 
							$customer_promotion->status='Active'; 
							$this->Wallets->CustomerPromotions->save($customer_promotion);
							
						}
					} 
					
					//Receipt Row entry
					$customerLedger = $this->Wallets->Orders->Ledgers->find()->where(['Ledgers.customer_id' =>$customer_id,'Ledgers.city_id'=>$city_id])->first();
					$ReceiptRow1 = $this->Wallets->Receipts->ReceiptRows->newEntity();
					$ReceiptRow1->receipt_id = $receipt->id;
					$ReceiptRow1->ledger_id = $customerLedger->id;
					$ReceiptRow1->cr_dr = "Cr";
					$ReceiptRow1->credit = $actual_amount;
					$ReceiptRow1->debit ='';
					$this->Wallets->Receipts->ReceiptRows->save($ReceiptRow1);
					
					$AccountingEntries2 = $this->Wallets->Orders->AccountingEntries->newEntity();
					$AccountingEntries2->receipt_id = $receipt->id;
					$AccountingEntries2->city_id = $city_id;
					$AccountingEntries2->ledger_id = $customerLedger->id;
					$AccountingEntries2->transaction_date = date('Y-m-d');
					$AccountingEntries2->credit = $actual_amount;
					$AccountingEntries2->debit ='';
					$AccountingEntries2->receipt_id = $receipt->id;
					$AccountingEntries2->receipt_row_id = $ReceiptRow1->id;
					$this->Wallets->Orders->AccountingEntries->save($AccountingEntries2);
					
				}
			
			//Cash Entry
			$ccavenueLedger = $this->Wallets->Orders->Ledgers->find()->where(['Ledgers.cash' =>'1','Ledgers.city_id'=>$city_id])->first();
			$ReceiptRow1 = $this->Wallets->Receipts->ReceiptRows->newEntity();
			$ReceiptRow1->receipt_id = $receipt->id;
			$ReceiptRow1->ledger_id = $ccavenueLedger->id;
			$ReceiptRow1->cr_dr = "Dr";
			$ReceiptRow1->debit = $totalAmount;
			$ReceiptRow1->credit ='';
			$this->Wallets->Receipts->ReceiptRows->save($ReceiptRow1);
			
			$AccountingEntries1 = $this->Wallets->Orders->AccountingEntries->newEntity();
			$AccountingEntries1->receipt_id = $receipt->id;
			$AccountingEntries1->ledger_id = $ccavenueLedger->id;
			$AccountingEntries1->city_id = $city_id;
			$AccountingEntries1->transaction_date = date('Y-m-d');
			$AccountingEntries1->debit = $totalAmount;
			$AccountingEntries1->credit ='';
			$AccountingEntries1->receipt_id = $receipt->id;
			$AccountingEntries1->receipt_row_id = $ReceiptRow1->id;
			$this->Wallets->Orders->AccountingEntries->save($AccountingEntries1);
			
			
		 } 
		 
		$wallets1=$this->Wallets->find()->where(['Wallets.city_id'=>$city_id,'Wallets.transaction_type'=>"",'Wallets.add_amount >'=>0])->contain(['Customers','PlansLeft']);
		
		//pr($wallets1->toArray()); exit;
        $wallets = $this->paginate($wallets1);
		 
		$paginate_limit=$this->paginate['limit'];
		 
		
        $this->set(compact('wallets','wallet','paginate_limit'));
		 
    
    }
	public function walletDeductApproval($id=null)
    {
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id');
		$location_id=$this->Auth->User('location_id');
		$status = $this->request->query('status');
		$user_type =$this->Auth->User('user_type');
		$financial_year_id=$this->Auth->User('financial_year_id');
		//pr($financial_year_id); exit;
		
		//$financial_year_id =$this->Auth->User('financial_year_id ');
		//pr($financial_year_id); exit;
		if($user_type=='Super Admin'){
			$this->viewBuilder()->layout('super_admin_layout');
		}else if($user_type=='Admin'){
			$this->viewBuilder()->layout('admin_portal');
		}
		   $this->paginate = [
			'limit' =>20
        ];  
		
		 if ($this->request->is(['post','put'])) {
			  
			//Accounting 
			$Voucher_no = $this->Wallets->JournalVouchers->find()->select(['voucher_no'])->where(['city_id'=>$city_id,'financial_year_id '=>$financial_year_id ])->order(['voucher_no' => 'DESC'])->first();
			if($Voucher_no){
				$voucher_no=$Voucher_no->voucher_no+1;
			}else{
				$voucher_no=1;
			}
			$JournalVoucher = $this->Wallets->JournalVouchers->newEntity();
			$JournalVoucher->voucher_no = $voucher_no;
			$JournalVoucher->city_id = $city_id;
			$JournalVoucher->financial_year_id = $financial_year_id;
			$JournalVoucher->transaction_date = date('Y-m-d');
			$JournalVoucher->created_on = date('Y-m-d');
			$JournalVoucher->narration ="Amount Deduct From Wallet Manually";
			$JournalVoucher=$this->Wallets->JournalVouchers->save($JournalVoucher);
			
			
			$tests=$this->request->data('test');
			$totalAmount=0;
			foreach($tests as $data){
				//pr($data); exit;
				$query7 = $this->Wallets->query();
				$query7->update()
					->set(['transaction_type' => 'Deduct'])
					->where(['Wallets.id'=>$data])
					->execute();
				$wallet_details=$this->Wallets->get($data, [
					'contain' => ['Customers']]);
			
				$customer_id=$wallet_details->customer_id;
				@$actual_amount=$wallet_details->used_amount;
				$narration=$wallet_details->narration;

				$customer_details=$this->Wallets->Customers->find()
				->where(['Customers.id' => $customer_id])->first();
				$mob=$customer_details->username;
				$main_device_token1=$customer_details->device_token;
						 
				if((!empty($main_device_token1))){
				
					$device_token=$main_device_token1;
				} 
								 
				if(!empty($main_device_token1)){
					$tokens = array($device_token);
					$random=(string)mt_rand(1000,9999);
					$header = [
						'Content-Type:application/json',
						'Authorization: Key=AAAAXmNqxY4:APA91bG0X6RHVhwJKXUQGNSSCas44hruFdR6_CFd6WHPwx9abUr-WsrfEzsFInJawElgrp24QzaE4ksfmXu6kmIL6JG3yP487fierMys5byv-I1agRtMPIoSqdgCZf8R0iqsnds-u4CU'
					];

					$msg = [
						'title'=> 'Wallet Amount Deduct',
						'message' => $narration,
						'image' => 'img/jain.png',
						'link' => 'jainthela://wallet',
						'notification_id'    => $random,
					];
					
					$payload = array(
						'registration_ids' => $tokens,
						'data' => $msg
					);
					
					$curl = curl_init();
					curl_setopt_array($curl, array(
					  CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
					  CURLOPT_RETURNTRANSFER => true,
					  CURLOPT_CUSTOMREQUEST => "POST",
					  CURLOPT_POSTFIELDS => json_encode($payload),
					  CURLOPT_HTTPHEADER => $header
					));
					$response = curl_exec($curl);
					$err = curl_error($curl);
					curl_close($curl);
					//pr($payload);
					$final_result=json_decode($response);
					$sms_flag=$final_result->success; 	
					if ($err) {
					  //echo "cURL Error #:" . $err;
					} else {
						//echo $response;
					}
				}




				
				//pr($actual_amount); exit;
				if($actual_amount>0){
					$totalAmount+=@$actual_amount;
					//Journal Vouchers Row entry
					$customerLedger = $this->Wallets->Orders->Ledgers->find()->where(['Ledgers.customer_id' =>$customer_id,'Ledgers.city_id'=>$city_id])->first();
					$ReceiptRow1 = $this->Wallets->JournalVouchers->JournalVoucherRows->newEntity();
					$ReceiptRow1->journal_voucher_id = $JournalVoucher->id;
					$ReceiptRow1->ledger_id = $customerLedger->id;
					$ReceiptRow1->cr_dr = "Cr";
					$ReceiptRow1->credit = $actual_amount;
					$ReceiptRow1->debit ='';
					$this->Wallets->JournalVouchers->JournalVoucherRows->save($ReceiptRow1);
					
					$AccountingEntries2 = $this->Wallets->Orders->AccountingEntries->newEntity();
					$AccountingEntries2->journal_voucher_id = $JournalVoucher->id;
					$AccountingEntries2->city_id = $city_id;
					$AccountingEntries2->ledger_id = $customerLedger->id;
					$AccountingEntries2->transaction_date = date('Y-m-d');
					$AccountingEntries2->debit = $actual_amount;
					$AccountingEntries2->credit ='';
					$AccountingEntries2->journal_voucher_row_id = $ReceiptRow1->id;
					$this->Wallets->Orders->AccountingEntries->save($AccountingEntries2);
					
				}
			}
			
			
			//Cash Entry
			$ccavenueLedger = $this->Wallets->Orders->Ledgers->find()->where(['Ledgers.cash' =>'1','Ledgers.city_id'=>$city_id])->first();
			$ReceiptRow1 = $this->Wallets->JournalVouchers->JournalVoucherRows->newEntity();
			$ReceiptRow1->journal_voucher_id = $JournalVoucher->id;
			$ReceiptRow1->ledger_id = $ccavenueLedger->id;
			$ReceiptRow1->cr_dr = "Dr";
			$ReceiptRow1->credit = $totalAmount;
			$ReceiptRow1->debit ='';
			$this->Wallets->JournalVouchers->JournalVoucherRows->save($ReceiptRow1);
			
			$AccountingEntries1 = $this->Wallets->Orders->AccountingEntries->newEntity();
			$AccountingEntries1->journal_voucher_id = $JournalVoucher->id;
			$AccountingEntries1->ledger_id = $ccavenueLedger->id;
			$AccountingEntries1->city_id = $city_id;
			$AccountingEntries1->transaction_date = date('Y-m-d');
			$AccountingEntries1->credit = $totalAmount;
			$AccountingEntries1->debit ='';
			$AccountingEntries1->journal_voucher_row_id = $ReceiptRow1->id;
			$this->Wallets->Orders->AccountingEntries->save($AccountingEntries1);
			
			
		 } 
		 
		$wallets1=$this->Wallets->find()->where(['Wallets.city_id'=>$city_id,'Wallets.transaction_type'=>"",'Wallets.used_amount >'=>0])->contain(['Customers','PlansLeft']);
		
		//pr($wallets1->toArray()); exit;
        $wallets = $this->paginate($wallets1);
		 
		$paginate_limit=$this->paginate['limit'];
		 
		
        $this->set(compact('wallets','wallet','paginate_limit'));
		 
    
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function walletDeduct($id=null){
		$city_id=$this->Auth->User('city_id'); 
		$user_id=$this->Auth->User('id');
		$user_type=$this->Auth->User('user_type');
		if($user_type=='Super Admin'){
			$this->viewBuilder()->layout('super_admin_layout');
		}else if($user_type=='Admin'){
			$this->viewBuilder()->layout('admin_portal');
		}
		  $this->paginate = [
            'contain' => ['Customers'],
			'limit' =>20
        ];
		
		$wallets1 = $this->Wallets->find()->where(['Wallets.city_id'=>$city_id,'Wallets.transaction_type'=>"",'Wallets.used_amount >'=>0])->contain(['Customers'])->autoFields(true);
		//
		$wallet = $this->Wallets->newEntity();
        if ($this->request->is(['post','put'])) {
            $wallet = $this->Wallets->patchEntity($wallet, $this->request->getData());
			
			$wallet->appiled_from="Web";
			$wallet->transaction_type="";
			$wallet->city_id=$city_id;
			$wallet->amount_type="Manually Deduct";
			//pr($wallet);exit;
			if ($this->Wallets->save($wallet)) {
				$this->Flash->success(__('The wallet has been saved.'));
				return $this->redirect(['action' => 'walletDeduct']);
            }
            $this->Flash->error(__('The wallet could not be saved. Please, try again.'));
        }
		
		$wallets = $this->paginate($wallets1);
		$customersList=$this->Wallets->Customers->find()->where(['Customers.city_id'=>$city_id]);
		$customers=[];
		foreach($customersList as $data1){
			$customers[]= ['value'=>$data1->id,'text'=>$data1->name."(".$data1->username.")"];
		}
		$paginate_limit=$this->paginate['limit'];
		$this->set(compact('wallets','wallet','states','paginate_limit','customers','plans'));
	}
    public function index($id=null)
    {
		$city_id=$this->Auth->User('city_id'); 
		$user_id=$this->Auth->User('id');
		$user_type=$this->Auth->User('user_type');
		if($user_type=='Super Admin'){
			$this->viewBuilder()->layout('super_admin_layout');
		}else if($user_type=='Admin'){
			$this->viewBuilder()->layout('admin_portal');
		}
		  $this->paginate = [
            'contain' => ['Customers'],
			'limit' =>20
        ];  
		
		 
		$wallets1 = $this->Wallets->find()->where(['Wallets.city_id'=>$city_id]);
		$wallets1->select([
					'tot_add_amount' => $wallets1->func()->sum('add_amount'),
					'tot_used_amount' => $wallets1->func()->sum('used_amount'),'customer_id'
				])->contain(['Customers'])->group(['customer_id'])->autoFields(true);
		
		$wallets = $this->paginate($wallets1);

         if($id)
		{
		    $wallet = $this->Wallets->get($id);
		}
		else
		{
			 $wallet = $this->Wallets->newEntity();
		}
		

        if ($this->request->is(['post','put'])) {
            $wallet = $this->Wallets->patchEntity($wallet, $this->request->getData());
			 
			$wallet->transaction_type="";
			$wallet->city_id=$city_id;
			$benifit=$this->request->data['benifit'];
			$customer_id=$this->request->data['customer_id'];
			
			
			if($id)
			{
				$wallet->id=$id;
			} 

			
			//pr($Receipts); exit;
            if ($this->Wallets->save($wallet)) {
				
				 
				
                $this->Flash->success(__('The wallet has been saved.'));
				return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The wallet could not be saved. Please, try again.'));
        }
		if ($this->request->is(['get'])){
			$search=$this->request->getQuery('search');
			$wallets1->where([
							'OR' => [
									'Customers.name LIKE' => '%'.$search.'%'
							]
			]);
		} 

        $wallets = $this->paginate($wallets1);
		$customersList=$this->Wallets->Customers->find()->where(['Customers.city_id'=>$city_id]);
		$customers=[];
		foreach($customersList as $data1){
			$customers[]= ['value'=>$data1->id,'text'=>$data1->name."(".$data1->username.")"];
		}
		$plans1=$this->Wallets->Plans->find()->where(['Plans.status'=>'Active','Plans.plan_type'=>'Wallet']);
		$paginate_limit=$this->paginate['limit'];
		
		foreach($plans1 as $data){
			$plan_name=$data->name;
			$total_amount=$data->total_amount;
			$amount=$data->amount;
			$benifit=$total_amount-$amount;
			$plans[]= ['value'=>$data->id,'text'=>$plan_name." (Rs-".$amount.")", 'total_amount'=>$total_amount,'actual_amount'=>$amount, 'benifit'=>$benifit];
		}
		
        $this->set(compact('wallets','wallet','states','paginate_limit','customers','plans'));
		
		
     /*    $this->paginate = [
            'contain' => ['Customers', 'Orders', 'Plans', 'Promotions', 'ReturnOrders']
        ];
        $wallets = $this->paginate($this->Wallets);

        $this->set(compact('wallets')); */
    }

    /**
     * View method
     *
     * @param string|null $id Wallet id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function withdraw(){
		$city_id=$this->Auth->User('city_id'); 
		$user_id=$this->Auth->User('id');
		$user_type=$this->Auth->User('user_type');
		if($user_type=='Super Admin'){
			$this->viewBuilder()->layout('super_admin_layout');
		}else if($user_type=='Admin'){
			$this->viewBuilder()->layout('admin_portal');
		}
		$customers=$this->Wallets->Customers->find('list')->where(['Customers.city_id'=>$city_id]);
		$wallet = $this->Wallets->newEntity();
		$wallets1 = $this->Wallets->find();
		$wallets1->select([
					'tot_add_amount' => $wallets1->func()->sum('add_amount'),
					'tot_used_amount' => $wallets1->func()->sum('used_amount'),'customer_id'
				])->contain(['Customers'])->group(['customer_id'])->autoFields(true);
		
		 if ($this->request->is(['post','put'])) {
            $wallet = $this->Wallets->patchEntity($wallet, $this->request->getData());
			
			$wallet->transaction_type="Deduct";
			$wallet->amount_type="Withdrawal";
			$wallet->city_id=$city_id;
			 if ($this->Wallets->save($wallet)) { 
				$this->Flash->success(__('The wallet has been saved.'));
				return $this->redirect(['action' => 'withdraw']);
            }
            $this->Flash->error(__('The wallet could not be saved. Please, try again.'));
		 }
		
		$wallets = $this->Wallets->find()->where(['amount_type'=>'Withdrawal'])->contain(['Customers']);
		
		$customerList=[];
		foreach($wallets1 as $data){
			$customerList[]=['text'=>$data->customer->name,'value'=>$data->customer->id,'due'=>$data->tot_add_amount-$data->tot_used_amount];
		}
		 $this->set(compact('customerList','wallet','wallets'));
	}
    public function view($id = null)
    {
        $wallet = $this->Wallets->get($id, [
            'contain' => ['Customers', 'Orders', 'Plans', 'Promotions', 'ReturnOrders']
        ]);

        $this->set('wallet', $wallet);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $wallet = $this->Wallets->newEntity();
        if ($this->request->is('post')) {
            $wallet = $this->Wallets->patchEntity($wallet, $this->request->getData());
			
            if ($this->Wallets->save($wallet)) {
                $this->Flash->success(__('The wallet has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The wallet could not be saved. Please, try again.'));
        }
        $customers = $this->Wallets->Customers->find('list', ['limit' => 200]);
        $orders = $this->Wallets->Orders->find('list', ['limit' => 200]);
        $plans = $this->Wallets->Plans->find('list', ['limit' => 200]);
        $promotions = $this->Wallets->Promotions->find('list', ['limit' => 200]);
        $returnOrders = $this->Wallets->ReturnOrders->find('list', ['limit' => 200]);
        $this->set(compact('wallet', 'customers', 'orders', 'plans', 'promotions', 'returnOrders'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Wallet id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $wallet = $this->Wallets->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $wallet = $this->Wallets->patchEntity($wallet, $this->request->getData());
            if ($this->Wallets->save($wallet)) {
                $this->Flash->success(__('The wallet has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The wallet could not be saved. Please, try again.'));
        }
        $customers = $this->Wallets->Customers->find('list', ['limit' => 200]);
        $orders = $this->Wallets->Orders->find('list', ['limit' => 200]);
        $plans = $this->Wallets->Plans->find('list', ['limit' => 200]);
        $promotions = $this->Wallets->Promotions->find('list', ['limit' => 200]);
        $returnOrders = $this->Wallets->ReturnOrders->find('list', ['limit' => 200]);
        $this->set(compact('wallet', 'customers', 'orders', 'plans', 'promotions', 'returnOrders'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Wallet id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $wallet = $this->Wallets->get($id);
        if ($this->Wallets->delete($wallet)) {
            $this->Flash->success(__('The wallet has been deleted.'));
        } else {
            $this->Flash->error(__('The wallet could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
