<?php
namespace App\Controller\Api;
use Cake\Event\Event;
use Cake\Network\Exception\UnauthorizedException;
use Cake\Utility\Security;
use Firebase\JWT\JWT;

/**
 * Sellers Controller
 *
 * @property \App\Model\Table\SellersTable $Sellers
 *
 * @method \App\Model\Entity\Seller[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SellersController extends AppController
{
	public function initialize()
  {
    parent::initialize();
    $this->Auth->allow(['shopNearYou']);
  }
	public function shopNearYou($city_id=null)
	{
		$city_id = @$this->request->query['city_id'];
		if(!empty($city_id))
		{
				$getLocations = $this->Sellers->Locations->find()->select(['id'])->where(['city_id'=>$city_id]);
				if(!empty($getLocations->toArray()))
				{
		        $shopes = $this->Sellers->find()
						->select(['id','firm_name','firm_address','saller_image'])
						->where(['location_id IN'=>$getLocations,'status'=>'Active']);
						$success = true;
						$message = 'Shopes Found';
				}else{
					$success = false;
					$message = 'No shop Found';
				}
		}else{
			$success = false;
			$message = 'Record not found';
		}
	  $this->set(['success' => $success,'message'=>$message,'shopes' => $shopes,'_serialize' => ['success','message','shopes']]);
	}
}
