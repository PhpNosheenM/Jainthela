<?php
namespace App\Controller\Api;

use Cake\Controller\Controller;
use Cake\Event\Event;
class AppController extends Controller
{
    use \Crud\Controller\ControllerTrait;
    public function initialize()
    {
        parent::initialize();
		
		$encryption=$this->loadComponent('Encryption');
        $this->set(compact('encryption'));
		
        $this->loadComponent('RequestHandler');
        $this->loadComponent('AwsFile');
		$this->loadComponent('Challan');
		$this->loadComponent('UpdateOrderChallan');
        $this->loadComponent('Sms');
        $this->loadComponent('Crud.Crud', [
            'actions' => [
                'Crud.Index',
                'Crud.View',
                'Crud.Add',
                'Crud.Edit',
                'Crud.Delete'
            ],
            'listeners' => [
                'Crud.Api',
                'Crud.ApiPagination',
                'Crud.ApiQueryLog'
            ]
        ]);
        $this->loadComponent('Auth', [
            'storage' => 'Memory',
            'authenticate' => [

                'Form' => [
					'userModel' => 'Customers'
                ],
                'ADmad/JwtAuth.Jwt' => [
                    'parameter' => 'token',
                    'userModel' => 'Customers',
                    'fields' => [
                        'username' => 'id'
                    ],
                    'queryDatasource' => true
                ]
            ],

            'unauthorizedRedirect' => false,
            'checkAuthIn' => 'Controller.initialize'
        ]);
    }

    public function CheckAvabiltyOfCity($city_id)
    {	
      $this->loadModel('Cities');
        if(!empty($city_id))
        {
          $exists = $this->Cities->exists(['Cities.id'=>$city_id]);
          if($exists == 1) { return 0; } else { return 1; }
        }else {
          return 1;
        }
    }

    public function checkToken($token)
    {
		return 0;
	/*  $this->loadModel('Customers');
        if(!empty($token))
        {
          $exists = $this->Customers->exists(['Customers.token'=>$token]);
          if($exists == 1) { return 0; } else { return 1; }
        }else {
          return 1;
        } */
    }
}
?>
