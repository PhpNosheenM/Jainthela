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
        $this->Auth->allow(['city']);
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

