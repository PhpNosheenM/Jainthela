<?php
namespace App\Controller\Api;
use Cake\Event\Event;
use Cake\Network\Exception\UnauthorizedException;
use Cake\Utility\Security;
use Firebase\JWT\JWT;



class CustomerMembershipsController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['membershipPlan','addMembershipPlan']);
    }


	public function membershipPlan($city_id=null)
	{
		$city_id = @$this->request->query['city_id'];
		if(!empty($city_id))
		  {	
			// CheckAvabiltyOfCity function is avaliable in app controller for checking city_id in cities table
			$isValidCity = $this->CheckAvabiltyOfCity($city_id);
			if($isValidCity == 0)
			{
			  $plans = $this->CustomerMemberships->Plans->find()->where(['status'=>'Active','plan_type'=>'Membership']);
			  if(empty($plans->toArray()))
				{ 
					$plans = []; 
				  $success = false;
				  $message = 'No Data found';					
				}else{
					$success = true;
					$message = 'Data found';
				}				
			}
			else {
			  $success = false;
			  $message = 'Invalid city id';
			}	  
	      }else {
			$success = false;
			$message = 'City id or Page no empty';
		  }
		  
		$this->loadModel('MasterSetups');  
		$tcs = $this->MasterSetups->find()->select(['membership_tc'])->where(['city_id' => $city_id])->first();
		
		$tc = $tcs->membership_tc;
		
		$this->set(compact('success', 'message','plans','tc'));
		$this->set('_serialize', ['success', 'message','plans','tc']);			
		
	}


  public function addMembershipPlan()
  {
    $city_id = @$this->request->data['city_id'];
    $wallet_balance=number_format(0, 2);
    if(!empty($city_id))
    {
      // CheckAvabiltyOfCity function is avaliable in app controller for checking city_id in cities table
      $isValidCity = $this->CheckAvabiltyOfCity($city_id);
      if($isValidCity == 0)
      {
        $membershipPlanData = $this->CustomerMemberships->newEntity();
        if($this->request->is('post')) {
          foreach(getallheaders() as $key => $value) {
            if($key == 'Authorization')
            {
              $token = $value;
            }
          }
          $token = '';
		  $token = str_replace("Bearer ","",$token);
          // checkToken function is avaliable in app controller for checking token in customer table
          $isValidToken = $this->checkToken($token);
          if($isValidToken == 0)
          {
            $membershipPlanData = $this->CustomerMemberships->patchEntity($membershipPlanData, $this->request->getData());            
			
			$plan_id = $membershipPlanData->plan_id;
			
			$plans = $this->CustomerMemberships->Plans->find()
				->where(['status'=>'Active','plan_type'=>'Membership'])
				->where(['id'=>$plan_id])->first();
			
			if(!empty($plans))
			{
									
				$currentDate = date('Y-m-d');
				
				/* 	$date1 = date_create($plans->start_date);
				
				$date2 = date_create($plans->end_date);
				
				$diff = date_diff($date1,$date2);
				
				$diffranceDate = $diff->format("%a");

				$lastDate = date('Y-m-d', strtotime($currentDate.' + '.$diffranceDate.' days'));					
				*/

				$noDays = $plans->no_of_days;
				$lastDate = date('Y-m-d', strtotime($currentDate.' + '.$noDays.' days'));	

				$membershipPlanData->amount = $plans->amount;
				$membershipPlanData->discount_percentage = $plans->benifit_per;
				//$membershipPlanData->start_date = date('Y-m-d',strtotime($plans->start_date));
				//$membershipPlanData->end_date = date('Y-m-d',strtotime($plans->end_date));

				$membershipPlanData->start_date = date('Y-m-d',strtotime($currentDate));
				$membershipPlanData->end_date = date('Y-m-d',strtotime($lastDate));
				$Order_no = $this->CustomerMemberships->find()->select(['order_no'])->where(['city_id'=>$city_id])->order(['order_no' => 'DESC'])->first();
				if($Order_no){
					$order_id=$Order_no->order_no+1;
				}else{
					$order_id=1;
				}
				
				$membershipPlanData->order_no = $order_id;			
				
				if($membershipPlanData->payment_status == 'Success')
				{
					if ($this->CustomerMemberships->save($membershipPlanData)) {
						$customers = $this->CustomerMemberships->Customers->query();
						$customers->update()
						->set(['membership_discount' => $membershipPlanData->discount_percentage,'start_date' =>$membershipPlanData->start_date,'end_date'=>$membershipPlanData->end_date])
						->where(['id' => $membershipPlanData->customer_id])
						->execute();
						
						
						//Create JV
						
						$Voucher_no = $this->CustomerMemberships->JournalVouchers->find()->select(['voucher_no'])->where(['city_id'=>$city_id])->order(['voucher_no' => 'DESC'])->first();
						if($Voucher_no){
							$voucher_no=$Voucher_no->voucher_no+1;
						}else{
							$voucher_no=1;
						}
						
						$today=date('Y-m-d');
						$FinancialYear = $this->CustomerMemberships->FinancialYears->find()->where(['FinancialYears.city_id'=>$city_id,'FinancialYears.fy_from <='=>$today,'FinancialYears.fy_to >='=>$today])->first();
						$financial_year_id=@$FinancialYear->id;	
						
						$receipt = $this->CustomerMemberships->JournalVouchers->newEntity();
						$receipt->voucher_no = $voucher_no;
						$receipt->city_id = $city_id;
						$receipt->financial_year_id = $financial_year_id;
						$receipt->total_credit_amount =$membershipPlanData->amount;
						$receipt->total_debit_amount =$membershipPlanData->amount;
						$receipt->transaction_date = date('Y-m-d');
						$receipt->created_on = date('Y-m-d');
						$receipt->narration ="Amount from Membership";
						
						if($this->CustomerMemberships->JournalVouchers->save($receipt)) {

							$ccavenueLedger = $this->CustomerMemberships->JournalVouchers->JournalVoucherRows->Ledgers->find()->where(['Ledgers.ccavenue' =>'yes','Ledgers.city_id'=>$city_id])->first();
							$ReceiptRow1 = $this->CustomerMemberships->JournalVouchers->JournalVoucherRows->newEntity();
							$ReceiptRow1->journal_voucher_id = $receipt->id;
							$ReceiptRow1->ledger_id = $ccavenueLedger->id;
							$ReceiptRow1->cr_dr = "Dr";
							$ReceiptRow1->debit = $membershipPlanData->amount;
							$ReceiptRow1->credit ='';
							$this->CustomerMemberships->JournalVouchers->JournalVoucherRows->save($ReceiptRow1);
							
							$AccountingEntries1 = $this->CustomerMemberships->JournalVouchers->AccountingEntries->newEntity();
							$AccountingEntries1->journal_voucher_id = $receipt->id;
							$AccountingEntries1->ledger_id = $ccavenueLedger->id;
							$AccountingEntries1->city_id = $city_id;
							$AccountingEntries1->transaction_date = date('Y-m-d');
							$AccountingEntries1->debit = $membershipPlanData->amount;
							$AccountingEntries1->credit ='';
							$AccountingEntries1->journal_voucher_id = $receipt->id;
							$AccountingEntries1->journal_voucher_row_id = $ReceiptRow1->id;
							$this->CustomerMemberships->JournalVouchers->AccountingEntries->save($AccountingEntries1);
							//2652
							$customerLedger = $this->CustomerMemberships->JournalVouchers->JournalVoucherRows->Ledgers->find()->where(['Ledgers.id' =>'2652'])->first();
							$ReceiptRow1 = $this->CustomerMemberships->JournalVouchers->JournalVoucherRows->newEntity();
							$ReceiptRow1->journal_voucher_id = $receipt->id;
							$ReceiptRow1->ledger_id = $customerLedger->id;
							$ReceiptRow1->cr_dr = "Cr";
							$ReceiptRow1->credit = $membershipPlanData->amount;
							$ReceiptRow1->debit ='';
							$this->CustomerMemberships->JournalVouchers->JournalVoucherRows->save($ReceiptRow1);
							
							$AccountingEntries2 = $this->CustomerMemberships->JournalVouchers->AccountingEntries->newEntity();
							$AccountingEntries2->city_id = $city_id;
							$AccountingEntries2->ledger_id = $customerLedger->id;
							$AccountingEntries2->transaction_date = date('Y-m-d');
							$AccountingEntries2->credit = $membershipPlanData->amount;
							$AccountingEntries2->debit ='';
							$AccountingEntries2->journal_voucher_id = $receipt->id;
							$AccountingEntries2->journal_voucher_row_id = $ReceiptRow1->id;
							$this->CustomerMemberships->JournalVouchers->AccountingEntries->save($AccountingEntries2);
							
							$ReferenceDetail = $this->CustomerMemberships->JournalVouchers->ReferenceDetails->newEntity(); 
							$ReferenceDetail->ledger_id=$ccavenueLedger->id;
							$ReferenceDetail->city_id = $city_id;
							$ReferenceDetail->debit=$membershipPlanData->amount;
							$ReferenceDetail->credit=0;
							$ReferenceDetail->transaction_date=date('Y-m-d');
							$ReferenceDetail->entry_from="App";
							$ReferenceDetail->type='New Ref';
							$ReferenceDetail->ref_name=$membershipPlanData->ccavvenue_tracking_no;
							$ReferenceDetail->journal_voucher_id = $receipt->id;
							$this->CustomerMemberships->JournalVouchers->ReferenceDetails->save($ReferenceDetail);
						}
					  $success=true;
					  $message="Thank You ! Your membership plan is activated.";
					}else {
					  $success = false;
					  $message = 'Something went wrong';
					}					
				}else {
				  $success = false;
				  $message = 'Something went wrong';
				}					
			}
			else {
            $success = false;
            $message = 'Invalid Plan';
          }
          }else {
            $success = false;
            $message = 'Invalid Token';
          }
        }
      }
      else {
        $success = false;
        $message = 'Invalid city id';
      }
    }else {
      $success = false;
      $message = 'City id empty';
    }
    $this->set(compact('success', 'message'));
    $this->set('_serialize', ['success', 'message']);
  }


	
}
