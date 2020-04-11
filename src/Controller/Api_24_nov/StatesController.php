<?php
namespace App\Controller\Api;
use Cake\Event\Event;
use Cake\Network\Exception\UnauthorizedException;
use Cake\Utility\Security;
use Firebase\JWT\JWT;

/**
 * States Controller
 *
 * @property \App\Model\Table\StatesTable $States
 *
 * @method \App\Model\Entity\State[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class StatesController extends AppController
{
	
    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['state']);
    }
	
	public function state(){
		
		$state=$this->States->find();
		if($state->toArray()){
			$message='Data found successfully';
			$success=true;
		}else{
			
			$message='Data not found';
			$success=false;
		}
				
		$this->set([
				'success' => $success,
				'message' => $message,
				'state' => $state,
				'_serialize' => ['success', 'message','state']
			]);
		}	
}
