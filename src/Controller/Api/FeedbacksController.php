<?php
namespace App\Controller\Api;
use Cake\Event\Event;
use Cake\Network\Exception\UnauthorizedException;
use Cake\Utility\Security;
use Firebase\JWT\JWT;

/**
 * Feedbacks Controller
 *
 * @property \App\Model\Table\FeedbacksTable $Feedbacks
 *
 * @method \App\Model\Entity\Feedback[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FeedbacksController extends AppController
{
	 public function initialize()
    {
        parent::initialize();
        //$this->Auth->allow(['feedbackform']);
    }

	public function feedbackform(){

		$Feedbacks = $this->Feedbacks->newEntity();

		if($this->request->is(['patch', 'post', 'put'])){
			$data=[];
			$city_id=$this->request->data['city_id'];
			$customer_id=$this->request->data['customer_id'];
			$token ='';

			//pr(getallheaders());exit;
			
			foreach(getallheaders() as $key => $value) {
				if($key == 'Authorization' || $key == 'authorization')
				{
				  $token = $value;
				}
			}

			 $token = str_replace("Bearer ","",$token);
			$isValidToken = $this->checkToken($token);
		

			if(!empty($customer_id) and (!empty($city_id))){

				$isValidCity = $this->CheckAvabiltyOfCity($city_id);
				if($isValidCity == 0)
				{
					$Feedbacks = $this->Feedbacks->patchEntity($Feedbacks, $this->request->getData());
					if ($Feedbacks_data = $this->Feedbacks->save($Feedbacks)) {
						$success=true;
						$message="data has been saved successfully";
						//$data=$Feedbacks_data;

					}else{
						//pr($Feedbacks);exit;
						$success=false;
						$message="data has not been saved";
					}


				}else{
					$success = false;
					$message = 'Invalid City';
				}


			}else{
				$success = false;
				$message = 'Empty customer id or city id';
			}
		

	}
		$this->set(['success' => $success,'message'=>$message,'_serialize' => ['success','message']]);
	}
}
