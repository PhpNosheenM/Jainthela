<?php
namespace App\Controller\Api;
use Cake\Event\Event;
use Cake\Network\Exception\UnauthorizedException;
use Cake\Utility\Security;
use Firebase\JWT\JWT;

class WalletWithdrawRequestsController extends AppController
{

  public function initialize()
  {
    parent::initialize();
  }
 
  public function requestForMoney()
  {
    $city_id = @$this->request->data['city_id'];
	$customer_id = @$this->request->data['customer_id'];
    if(!empty($city_id))
    {
      // CheckAvabiltyOfCity function is avaliable in app controller for checking city_id in cities table
      $isValidCity = $this->CheckAvabiltyOfCity($city_id);
      if($isValidCity == 0)
      {
        $wallet_request = $this->WalletWithdrawRequests->newEntity();
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
            $wallet_request = $this->WalletWithdrawRequests->patchEntity($wallet_request, $this->request->getData());
			$wallet_request->request_date = date('Y-m-d');
			$wallet_request->status = 'Pending';
			$wallet_balance = 0.00;

            $query = $this->WalletWithdrawRequests->Wallets->find();
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
                $wallet_balance = number_format($advance-$consumed,2,".","");
              }
            }
			if($wallet_balance >= $wallet_request->amount)
			{
				$customerLedger = $this->WalletWithdrawRequests->Ledgers->find()->where(['Ledgers.customer_id' =>$customer_id,'Ledgers.city_id'=>$city_id])->first();
				$wallet_request->ledger_id = $customerLedger->id;	
				if($this->WalletWithdrawRequests->save($wallet_request)) {
				  $success=true;
				  $message="Thank You ! Your request has been submit.";
				}else {
				  $success = false;
				  $message = 'Something went wrong';
				}            				
			}else {
				  $success = false;
				  $message = 'Invalid amount request';
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
