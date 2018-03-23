<?php
namespace App\Controller\Api;
use Cake\Event\Event;
use Cake\Network\Exception\UnauthorizedException;
use Cake\Utility\Security;
use Firebase\JWT\JWT;


class CartsController extends AppController
{
    public function plusAddToCart()
    {
      $customer_id=$this->request->data('customer_id');
      $city_id=$this->request->data('city_id');
  		$item_variation_id=$this->request->data('item_variation_id');
    }
}
