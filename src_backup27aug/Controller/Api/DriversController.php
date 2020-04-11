<?php

namespace App\Controller\Api;
use App\Controller\Api\AppController;
class DriversController extends AppController
{	
	public function initialize()
	{
		parent::initialize();
		$this->Auth->allow(['supplierLogin','PushTokenUpdate','driverLocationUpdate']);
	}

	public function supplierLogin()
    {	
		$user_name=$this->request->query('user_name');
	    $password=$this->request->query('password');
	    $pwd=md5($password);
		
		if(!empty($user_name) && !empty($password))
		{
			
		        $driverDetails = $this->Drivers->find()
				->contain(['Locations' =>'Cities'])
				->where(['user_name'=>$user_name,'password'=>$pwd])->first();
				if($driverDetails){
				    
					$status=true;
					$error='Successfully Login';
					$this->set(compact('status', 'error', 'driverDetails'));
					$this->set('_serialize', ['status', 'error', 'driverDetails']);
				}
				else
				{
					$status=false;
					$error="Sorry, Entered user name and password are incorrect. Try again.";
					$this->set(compact('status', 'error'));
					$this->set('_serialize', ['status', 'error']);
				}
        }
		else
		{
					$status=false;
					$error="Sorry, Entered user name and password are incorrect. Try agian.";
					$this->set(compact('status', 'error'));
					$this->set('_serialize', ['status', 'error']);
		}
	}

	public function PushTokenUpdate()
    {
		$driver_id=$this->request->data('driver_id');
		$device_token=$this->request->data('device_token');
		
		$query = $this->Drivers->query();
				$result = $query->update()
                    ->set([ 'device_token' => $device_token
							])
					->where(['id' => $driver_id])
					->execute();
		
		$status=true;
		$error="Token Updated Successfully";
        $this->set(compact('status', 'error'));
        $this->set('_serialize', ['status', 'error']);
    }
	public function driverLocationUpdate()
    {
		$driver_id=$this->request->query('driver_id');
		$lattitude=$this->request->query('lattitude');
		$longitude=$this->request->query('longitude');
		
		$query = $this->Drivers->query();
				$result = $query->update()
                    ->set([ 'latitude' => $lattitude,
					'longitude' => $longitude
					])
					->where(['id' => $driver_id])
					->execute();
		
		$status=true;
		$error="Locations Updated Successfully";
        $this->set(compact('status', 'error'));
        $this->set('_serialize', ['status', 'error']);
    }
}