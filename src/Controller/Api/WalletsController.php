<?php
namespace App\Controller\Api;
use Cake\Event\Event;
use Cake\Network\Exception\UnauthorizedException;
use Cake\Utility\Security;
use Firebase\JWT\JWT;

class WalletsController extends AppController
{

  public function addMoney()
    {
  /*
      $customer_id=$this->request->data('customer_id');
      $plan_id=$this->request->data('plan_id');
      $advance=$this->request->data('advance');
      $order_no=$this->request->data('order_no');
    		$query = $this->Wallets->query();
    			$query->insert(['plan_id', 'advance', 'customer_id', 'order_no'])
    					->values([
    					'plan_id' => $plan_id,
    					'advance' => $advance,
    					'customer_id' => $customer_id,
    					'order_no' => $order_no
    					])
    			->execute(); */

          $wallet = $this->Wallets->newEntity();
          if($this->request->is('post')) {
            foreach(getallheaders() as $key => $value) {
               if($key == 'Authorization')
               {
                 $token = $value;
               }
            }
            $token = str_replace("Bearer ","",$token);
             $isValidToken = $this->checkToken($token);
               if($isValidToken == 0)
                 {
                   $wallet = $this->Wallets->patchEntity($wallet, $this->request->getData());
                   $customer_id=$wallet->customer_id;
                   if ($this->Wallets->save($wallet)) {
                       $success=true;
                       $message="Thank You for add money with Jainthela.";
                     }else {
                         $success = false;
                         $message = 'Sorry no amount added';
                     }
                      $query = $this->Wallets->find();
                      $totalInCase = $query->newExpr()
                        ->addCase(
                          $query->newExpr()->add(['order_id' => '0']),
                          $query->newExpr()->add(['add_amount']),
                          'integer'
                        );
                       $totalOutCase = $query->newExpr()
                         ->addCase(
                          $query->newExpr()->add(['plan_id' => '0']),
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
                        $wallet_balance=0;
                        $success = false;
                        $message = 'No Data Found';
                      }
                      else
                      {
                        foreach($query as $fetch_query)
                          {
                            $advance=$fetch_query->total_in;
                            $consumed=$fetch_query->total_out;
                            $wallet_balance=$advance-$consumed;
                          }
                      }
                 }else {
                     $success = false;
                     $message = 'Invalid Token';
                 }
          }
  		$this->set(compact('success', 'message', 'wallet_balance'));
  		$this->set('_serialize', ['success', 'message','wallet_balance']);
    }
}
