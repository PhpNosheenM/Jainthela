<?php
namespace App\Controller\Api;
use Cake\Event\Event;
use Cake\Network\Exception\UnauthorizedException;
use Cake\Utility\Security;
use Firebase\JWT\JWT;

class BulkBookingNumbersController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['bulkBookingNoList']);
    }

	public function bulkBookingNoList()
	{
		$city_id = @$this->request->query['city_id'];
		if(!empty($city_id))
		  {	
			// CheckAvabiltyOfCity function is avaliable in app controller for checking city_id in cities table
			$isValidCity = $this->CheckAvabiltyOfCity($city_id);
			if($isValidCity == 0)
			{
			  $BulkBookingNumbers = $this->BulkBookingNumbers->find()->where(['status'=>'Active','city_id'=>$city_id]);
			  if(empty($BulkBookingNumbers->toArray()))
				{ 
					$BulkBookingNumbers = []; 
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
			$message = 'City id empty';
		  }
		$this->set(compact('success', 'message','BulkBookingNumbers'));
		$this->set('_serialize', ['success', 'message','BulkBookingNumbers']);			
		
	}		
}
