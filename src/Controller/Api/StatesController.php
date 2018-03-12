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
		$this->set([
				'success' => true,
				'message' => 'data successfully',
				'state' => $this->States->find(),
				'_serialize' => ['success', 'message','state']
			]);
		}	
}
