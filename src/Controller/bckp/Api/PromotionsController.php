<?php
namespace App\Controller\Api;
use Cake\Event\Event;
use Cake\Network\Exception\UnauthorizedException;
use Cake\Utility\Security;
use Firebase\JWT\JWT;


class PromotionsController extends AppController
{
	public function initialize()
	{
		parent::initialize();
		$this->Auth->allow(['promocodeList']);		
	}

	public function promocodeList($city_id=null,$customer_id=null)
	{
		$city_id = $this->request->query('city_id');
		$customer_id = $this->request->query('customer_id');
		$item_in_cart = $this->Promotions->Carts->find('All')->where(['Carts.customer_id'=>$customer_id])->count();
		$success=true;
		$message="Item Added Successfully";
		$this->set(compact('success','message','item_in_cart'));
		$this->set('_serialize',['success','message','item_in_cart']);				
	}
	
}
