<?php
namespace App\Controller\Api;
use Cake\Event\Event;
use Cake\Network\Exception\UnauthorizedException;
use Cake\Utility\Security;
use Firebase\JWT\JWT;
/**
 * Cities Controller
 *
 * @property \App\Model\Table\CitiesTable $Cities
 *
 * @method \App\Model\Entity\City[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CitiesController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['city','locationList']);
    }

		public function locationList($city_id=null)
		{
			$city_id=@$this->request->query['city_id'];
			$isValidCity = $this->CheckAvabiltyOfCity($city_id);
			if($isValidCity == 0){
					$locations = $this->Cities->Locations->find()->where(['city_id'=>$city_id]);
					if(!empty($locations->toArray()))
					{
						$success = true;
						$message = 'Data Found Successfully';
					}
					else {
								$success = false;
								$message = 'Record not found';
								$locations = [];
					}
			}
			else{
				$success = false;
				$message = 'Invalid City';
				$locations = [];
			}
			$this->set(['success' => $success,'message'=>$message,'locations'=>$locations,'_serialize' => ['success','message','locations']]);
		}


	public function city(){

		//$state_id=$this->request->query['state_id'];
		$Cities=$this->Cities->find();
		if($Cities->toArray()){
			$message='Data found successfully';
			$success=true;
		}else{

			$message='Data not found';
			$success=false;
		}

		$this->set([
				'success' => $success,
				'message' => $message,
				'Cities' => $Cities,
				'_serialize' => ['success', 'message','Cities']
			]);
		}
}
