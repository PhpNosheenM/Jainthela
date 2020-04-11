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
        $this->Auth->allow(['membershipPlan']);
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
		$this->set(compact('success', 'message','plans'));
		$this->set('_serialize', ['success', 'message','plans']);			
		
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
			
			$membershipPlanData->amount = $plans->amount;
			$membershipPlanData->discount_percentage = $plans->benifit_per;
			$membershipPlanData->start_date = date('Y-m-d',strtotime($plans->start_date));
			$membershipPlanData->end_date = date('Y-m-d',strtotime($plans->end_date));
			
			$Order_no = $this->CustomerMemberships->find()->select(['order_no'])->where(['city_id'=>$city_id])->order(['order_no' => 'DESC'])->first();
			if($Order_no){
				$order_id=$Order_no->order_no+1;
			}else{
				$order_id=1;
			}
			$membershipPlanData->order_no = $order_id;			
			
			//pr($membershipPlanData);exit;
			
			if ($this->CustomerMemberships->save($membershipPlanData)) {
				$customers = $this->CustomerMemberships->Customers->query();
				$customers->update()
				->set(['membership_discount' => $membershipPlanData->discount_percentage,'start_date' =>$membershipPlanData->start_date,'end_date'=>$membershipPlanData->end_date])
				->where(['id' => $membershipPlanData->customer_id])
				->execute();

			  $success=true;
              $message="Thank You ! Your membership plan is activated.";
            }else {
              $success = false;
              $message = 'Something went wrong';
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
