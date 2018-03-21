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
    			->execute();

    		$query = $this->Wallets->find();
    		$totalInCase = $query->newExpr()
    			->addCase(
    				$query->newExpr()->add(['order_id' => '0']),
    				$query->newExpr()->add(['advance']),
    				'integer'
    			);
        $totalOutCase = $query->newExpr()
          ->addCase(
          	$query->newExpr()->add(['plan_id' => '0']),
          	$query->newExpr()->add(['consumed']),
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

  		$status=true;
  		$error="Thank You for add money with Jainthela.";
  		$this->set(compact('status', 'error', 'wallet_balance'));
  		$this->set('_serialize', ['status', 'error','wallet_balance']);
    }
}
