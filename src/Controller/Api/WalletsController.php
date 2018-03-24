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
          if(!empty($city_id) && !empty($page))
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
              		->order(['Wallets.id'=>'DESC'])
					->limit($limit)->page($page)
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

                  if(empty($wallet_details->toArray()))
              		{
              			$success=false;
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
      $this->set(compact('success', 'message','wallet_details', 'wallet_balance'));
      $this->set('_serialize', ['success', 'message','wallet_balance','wallet_details']);

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
                     //pr($wallet);exit;
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
