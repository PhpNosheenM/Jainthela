<?php
namespace App\Controller\Api;
use Cake\Event\Event;
use Cake\Network\Exception\UnauthorizedException;
use Cake\Utility\Security;
use Firebase\JWT\JWT;
use Cake\I18n\Time;


class PromotionsController extends AppController
{
	public function initialize()
	{
		parent::initialize();
		$this->Auth->allow(['promocodeList']);		
	}

	public function promocodeList($city_id=null,$customer_id=null,$token=null)
	{
		$city_id = $this->request->query('city_id');
		$customer_id = $this->request->query('customer_id');
		$token = $this->request->query('token');
		$item_in_cart = $this->Promotions->Carts->find('All')->where(['Carts.customer_id'=>$customer_id])->count();
		$promotionList = [];	
		$isValidToken = $this->checkToken($token);
		if($isValidToken == 0)
		{
			if(!empty($city_id))
			{
				$promotionList = $this->Promotions->find()->contain(['PromotionDetails'])->where(['city_id'=>$city_id,'status'=>'Active']);
				if($promotionList->toArray())
				{
					$success = true;
					$message = "List Found Successfully";			
				}else {
					$success = false;
					$message = "No List Found";			
				}			  
			} 
			else 
			{
				$success = false;
				$message = 'City id empty';
			}
		}
		else {
		  $success = false;
		  $message = 'Invalid Token';
		}

		$this->set(compact('success','message','item_in_cart','promotionList'));
		$this->set('_serialize',['success','message','item_in_cart','promotionList']);				
	}
	
    public function checkPromoCodes($city_id=null,$coupon_code = null,$promotion_detail_id=null,$customer_id=null,$token=null)
    {
		$ts = Time::now('Asia/Kolkata');
        $current_timestamp = date('Y-m-d H:i:s',strtotime($ts));
		$coupon_code=$this->request->query('coupon_code');
		$city_id=$this->request->query('city_id');
		$customer_id=$this->request->query('customer_id');
		$token=$this->request->query('token');

		$promotion_detail_id = $this->request->query('promotion_detail_id');
		
		
		
		$isValidToken = $this->checkToken($token);
		if($isValidToken == 0)
		{
			if(!empty($city_id))
			{
				
				if(!empty($coupon_code))
				{
					$promo_codes = $this->Promotions->find()
					->contain(['PromotionDetails' => function ($q) use($coupon_code) {
						return $q->where(['PromotionDetails.coupon_code'=>$coupon_code]);
					}])
					->where(['city_id' => $city_id,'Promotions.start_date <' =>$current_timestamp, 'Promotions.end_date >' =>$current_timestamp])->first();						  					
				}
				else{
					
					if(!empty($promotion_detail_id))
					{
						$promo_codes = $this->Promotions->find()
						->contain(['PromotionDetails' => function ($q) use($promotion_detail_id) {
							return $q->where(['PromotionDetails.id'=>$promotion_detail_id]);
						}])
						->where(['city_id' => $city_id,'Promotions.start_date <' =>$current_timestamp, 'Promotions.end_date >' =>$current_timestamp])->first();											
					}else{
						$success = true;
						$message = "empty promotion details id";					
					}
				}
				
				//pr($promo_codes);exit;
				
				$promoData = [];
				
				if(!empty($promo_codes))
				{
					if(!empty($promo_codes->promotion_details))
					{
						$promoData = $promo_codes->promotion_details;
					}	
					else
					{
						$success = false;
						$message = "Invalid Code";						
					}					
				
					$success = true;
					$message = "Valid Code";
				}
				else
				{
					$success = false;
					$message = "Invalid Promo Code";
				}

			} 
			else 
			{
				$success = false;
				$message = 'City id empty';
			}
		}
		else {
		  $success = false;
		  $message = 'Invalid Token';
		}		
		$this->set(compact('success','message','promoData'));
		$this->set('_serialize',['success','message','promoData']);		

    }
}
