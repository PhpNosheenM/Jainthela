<?php
namespace App\Controller\Api;
use Cake\Event\Event;
use Cake\Network\Exception\UnauthorizedException;
use Cake\Utility\Security;
use Firebase\JWT\JWT;


class SellerItemsController extends AppController
{

 public function initialize()
  {
    parent::initialize();
    $this->Auth->allow(['items']);
  }
  
  
  public function items($city_id=null)
  {
	$city_id = @$this->request->query['city_id'];
	$items = $this->SellerItems->find()->contain(['Items','ItemsVariations'])
	->where(['SellerItems.city_id'=>$city_id]);

	pr($items->toArray());exit;
	
  }


}

?>