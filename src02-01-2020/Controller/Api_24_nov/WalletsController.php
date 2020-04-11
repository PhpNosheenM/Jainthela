<?php
namespace App\Controller\Api;
use Cake\Event\Event;
use Cake\Network\Exception\UnauthorizedException;
use Cake\Utility\Security;
use Firebase\JWT\JWT;

class WalletsController extends AppController
{

  public function initialize()
  {
    parent::initialize();
  }

  public function walletDetails($city_id=null,$customer_id=null,$token=null)
  {
    $city_id = @$this->request->query['city_id'];
    $customer_id = @$this->request->query['customer_id'];
    $token = @$this->request->query['token'];
    $transaction_type = @$this->request->query['transaction_type'];
    $page=@$this->request->query['page'];
    $limit=10;
    $wallet_balance=number_format(0, 2);
    // checkToken function is avaliable in app controller for checking token in customer table
    $isValidToken = $this->checkToken($token);
    if($isValidToken == 0)
    {
      if(!empty($city_id))
      {
        // CheckAvabiltyOfCity function is avaliable in app controller for checking city_id in cities table
        $isValidCity = $this->CheckAvabiltyOfCity($city_id);
        if($isValidCity == 0)
        {
          $wallet_details = $this->Wallets->find();
          if(!empty($transaction_type)){
            $wallet_details->where(['Wallets.transaction_type'=>$transaction_type]);
          }
          $wallet_details->where(['Wallets.customer_id'=>$customer_id])
          ->contain(['PlansLeft','OrdersLeft','PromotionsLeft'])
          ->order(['Wallets.id'=>'DESC'])
          ->autoFields(true);

          //  pr($wallet_details->toArray());exit;
          $query = $this->Wallets->find();
          $totalInCase = $query->newExpr()
          ->addCase(
            $query->newExpr()->add(['transaction_type' => 'Added']),
            $query->newExpr()->add(['add_amount']),
            'integer'
          );
          $totalOutCase = $query->newExpr()
          ->addCase(
            $query->newExpr()->add(['transaction_type' => 'Deduct']),
            $query->newExpr()->add(['used_amount']),
            'integer'
          );
          $query->select([
            'total_in' => $query->func()->sum($totalInCase),
            'total_out' => $query->func()->sum($totalOutCase),'id','customer_id'
          ])
          ->where(['Wallets.customer_id' => $customer_id])
          ->group('customer_id')
          ->autoFields(true);

          if(empty($query->toArray()))
          {
            $wallet_balance=number_format(0, 2);
          }
          else
          {
            foreach($query as $fetch_query)
            {
              $advance=$fetch_query->total_in;
              $consumed=$fetch_query->total_out;
              $wallet_balance= number_format($advance-$consumed, 2);
            }
          }

          $plans = $this->Wallets->Plans->find()->where(['status'=>'Active','plan_type'=>'Wallet']);
          if(empty($plans)){ $plans = []; }

          if(empty($wallet_details->toArray()))
          {
            $success=true;
            $message="No Transaction details";
          }
          else
          {
            $success=true;
            $message="Data found successfully";
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
    }
    else {
      $success = false;
      $message = 'Invalid Token';
    }
    $this->set(compact('success', 'message','wallet_details', 'wallet_balance','plans'));
    $this->set('_serialize', ['success', 'message','wallet_balance','wallet_details','plans']);

  }

  public function addMoney()
  {
    $city_id = @$this->request->data['city_id'];
    $wallet_balance=number_format(0, 2);
    if(!empty($city_id))
    {
      // CheckAvabiltyOfCity function is avaliable in app controller for checking city_id in cities table
      $isValidCity = $this->CheckAvabiltyOfCity($city_id);
      if($isValidCity == 0)
      {
        $wallet = $this->Wallets->newEntity();
        if($this->request->is('post')) {
          foreach(getallheaders() as $key => $value) {
            if($key == 'Authorization')
            {
              $token = $value;
            }
          }
          $token = str_replace("Bearer ","",$token);
          // checkToken function is avaliable in app controller for checking token in customer table
          $isValidToken = $this->checkToken($token);
          if($isValidToken == 0)
          {
            $wallet = $this->Wallets->patchEntity($wallet, $this->request->getData());
            $customer_id=$wallet->customer_id;
            $wallet->transaction_type = 'Added';

			$Order_no = $this->Wallets->find()->select(['order_no'])->where(['city_id'=>$wallet->city_id])->order(['order_no' => 'DESC'])->first();
			if($Order_no){
				$order_no=$Order_no->order_no+1;
			}else{
				$order_no=1;
			}
			$wallet->transaction_date = date('Y-m-d');
			$wallet->order_no = $order_no;
           //pr($wallet);exit;
            if ($this->Wallets->save($wallet)) {

			//Create Receipts
				$Voucher_no = $this->Wallets->Receipts->find()->select(['voucher_no'])->where(['city_id'=>$wallet->city_id])->order(['voucher_no' => 'DESC'])->first();
				if($Voucher_no){
					$voucher_no=$Voucher_no->voucher_no+1;
				}else{
					$voucher_no=1;
				}
				
				$today=date('Y-m-d');
				$FinancialYear = $this->Wallets->Receipts->FinancialYears->find()->where(['FinancialYears.city_id'=>$wallet->city_id,'FinancialYears.fy_from <='=>$today,'FinancialYears.fy_to >='=>$today])->first();
				$wallet->city_id=@$FinancialYear->id;	
				
				$receipt = $this->Wallets->Receipts->newEntity();
				$receipt->voucher_no = $voucher_no;
				$receipt->city_id = $wallet->city_id;
				$receipt->transaction_date = date('Y-m-d');
				$receipt->created_on = date('Y-m-d');
				$receipt->narration ="Amount from wallet";
				
				if($this->Wallets->Receipts->save($receipt)) {

					$ccavenueLedger = $this->Wallets->Orders->Ledgers->find()->where(['Ledgers.ccavenue' =>'yes','Ledgers.city_id'=>$wallet->city_id])->first();
					$ReceiptRow1 = $this->Wallets->Receipts->ReceiptRows->newEntity();
					$ReceiptRow1->receipt_id = $receipt->id;
					$ReceiptRow1->ledger_id = $ccavenueLedger->id;
					$ReceiptRow1->cr_dr = "Dr";
					$ReceiptRow1->debit = $wallet->add_amount;
					$ReceiptRow1->credit ='';
					$this->Wallets->Receipts->ReceiptRows->save($ReceiptRow1);
					
					$AccountingEntries1 = $this->Wallets->Orders->AccountingEntries->newEntity();
					$AccountingEntries1->receipt_id = $receipt->id;
					$AccountingEntries1->ledger_id = $ccavenueLedger->id;
					$AccountingEntries1->city_id = $wallet->city_id;
					$AccountingEntries1->transaction_date = date('Y-m-d');
					$AccountingEntries1->debit = $wallet->add_amount;
					$AccountingEntries1->credit ='';
					$AccountingEntries1->receipt_id = $receipt->id;
					$AccountingEntries1->receipt_row_id = $ReceiptRow1->id;
					$this->Wallets->Orders->AccountingEntries->save($AccountingEntries1);
					
					$customerLedger = $this->Wallets->Orders->Ledgers->find()->where(['Ledgers.customer_id' =>$customer_id,'Ledgers.city_id'=>$wallet->city_id])->first();
					$ReceiptRow1 = $this->Wallets->Receipts->ReceiptRows->newEntity();
					$ReceiptRow1->receipt_id = $receipt->id;
					$ReceiptRow1->ledger_id = $customerLedger->id;
					$ReceiptRow1->cr_dr = "Cr";
					$ReceiptRow1->credit = $wallet->add_amount;
					$ReceiptRow1->debit ='';
					$this->Wallets->Receipts->ReceiptRows->save($ReceiptRow1);
					
					$AccountingEntries2 = $this->Wallets->Orders->AccountingEntries->newEntity();
					$AccountingEntries2->receipt_id = $receipt->id;
					$AccountingEntries2->city_id = $wallet->city_id;
					$AccountingEntries2->ledger_id = $customerLedger->id;
					$AccountingEntries2->transaction_date = date('Y-m-d');
					$AccountingEntries2->credit = $wallet->add_amount;
					$AccountingEntries2->debit ='';
					$AccountingEntries2->receipt_id = $receipt->id;
					$AccountingEntries2->receipt_row_id = $ReceiptRow1->id;
					$this->Wallets->Orders->AccountingEntries->save($AccountingEntries2);
					
					$ReferenceDetail = $this->Wallets->Orders->ReferenceDetails->newEntity(); 
					$ReferenceDetail->ledger_id=$ccavenueLedger->id;
					$ReferenceDetail->city_id = $wallet->city_id;
					$ReferenceDetail->debit=$wallet->add_amount;
					$ReferenceDetail->credit=0;
					$ReferenceDetail->transaction_date=date('Y-m-d');
					$ReferenceDetail->city_id=$wallet->city_id;
					$ReferenceDetail->entry_from="Web";
					$ReferenceDetail->type='New Ref';
					$ReferenceDetail->ref_name=$wallet->ccavvenue_tracking_no;
					$ReferenceDetail->receipt_id = $receipt->id;
					$this->Wallets->Orders->ReferenceDetails->save($ReferenceDetail);
				}
              $success=true;
              $message="Thank You for add money with Jainthela.";
            }else { 
              $success = false;
              $message = 'Sorry no amount added';
            }

            $query = $this->Wallets->find();
            $totalInCase = $query->newExpr()
            ->addCase(
              $query->newExpr()->add(['transaction_type' => 'Added']),
              $query->newExpr()->add(['add_amount']),
              'integer'
            );
            $totalOutCase = $query->newExpr()
            ->addCase(
              $query->newExpr()->add(['transaction_type' => 'Deduct']),
              $query->newExpr()->add(['used_amount']),
              'integer'
            );

            $query->select([
              'total_in' => $query->func()->sum($totalInCase),
              'total_out' => $query->func()->sum($totalOutCase),'id','customer_id'
            ])
            ->where(['Wallets.customer_id' => $customer_id,'Wallets.city_id'=>$city_id])
            ->group('customer_id')
            ->autoFields(true);

            if(empty($query->toArray()))
            {
              $wallet_balance=number_format(0, 2);
              $success = false;
              $message = 'No Data Found';
            }
            else
            {
              foreach($query as $fetch_query)
              {
                $advance=$fetch_query->total_in;
                $consumed=$fetch_query->total_out;
                $wallet_balance= number_format($advance-$consumed, 2);
              }
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
    $this->set(compact('success', 'message', 'wallet_balance'));
    $this->set('_serialize', ['success', 'message','wallet_balance']);
  }
}
