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
		$cust_promo_arr = [];
		$cust_promo_code = [];
		$isValidToken = $this->checkToken($token);
		if($isValidToken == 0)
		{
			if(!empty($city_id))
			{
				$conditions = ['Promotions.start_date <=' => date('Y-m-d'),'Promotions.end_date >= ' => date('Y-m-d')];
				$promotionList = $this->Promotions->find()->contain(['PromotionDetails'])
				->where(['Promotions.city_id'=>$city_id,'Promotions.status'=>'Active'])
				->where([$conditions])->toArray();
				
				
				
				$promotionCustomerList = $this->Promotions->CustomerPromotions->find()
				->contain(['Promotions'=>function($q) use($city_id,$conditions){
					return $q->contain(['PromotionDetails'])->where(['Promotions.city_id'=>$city_id,'Promotions.status'=>'Active'])
				->where([$conditions]);		
				}]);
				
				if(!empty($promotionCustomerList))
				{
					foreach($promotionCustomerList as $promotionCustomer)
					{
						$cust_promo_arr[] = $promotionCustomer->promotion;
					}
				}				

				
				$mainArray = array_diff($promotionList,$cust_promo_arr);
				

				$promotionCurrentCustomerList = $this->Promotions->CustomerPromotions->find()
				->contain(['Promotions'=>function($q) use($city_id,$conditions){
					return $q->contain(['PromotionDetails'])->where(['Promotions.city_id'=>$city_id,'Promotions.status'=>'Active'])
				->where([$conditions]);		
				}])->where(['CustomerPromotions.customer_id' =>$customer_id]);

				
				if(!empty($promotionCurrentCustomerList))
				{
					foreach($promotionCurrentCustomerList as $promotionCurrentCustomer)
					{
						$cust_promo_code[] = $promotionCurrentCustomer->promotion;
					}
				}
				
				$allPromoCode = array_merge($mainArray,$cust_promo_code);
				
				
				if($allPromoCode)
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

		$this->set(compact('success','message','item_in_cart','allPromoCode'));
		$this->set('_serialize',['success','message','item_in_cart','allPromoCode']);				
	}
	
    public function checkPromoCodes($promo_id=null,$city_id=null,$coupon_code = null,$promotion_detail_id=null,$customer_id=null,$token=null)
    {
		$ts = Time::now('Asia/Kolkata');
        $current_timestamp = date('Y-m-d H:i:s',strtotime($ts));
		$coupon_code=$this->request->query('coupon_code');
		$city_id=$this->request->query('city_id');
		$customer_id=$this->request->query('customer_id');
		$token=$this->request->query('token');
		$promotion_detail_id = $this->request->query('promotion_detail_id');
		$promo_id = $this->request->query('promo_id');
		$promoData = [];
		$conditions = ['Promotions.start_date <=' => date('Y-m-d'),'Promotions.end_date >= ' => date('Y-m-d')];
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
					->where([$conditions])
					->where(['city_id' => $city_id]);	
					//pr($promo_codes->toArray());exit;
					if(!empty($promo_codes->toArray()))
					{
						foreach($promo_codes as $promo_code)
						{
							if(!empty($promo_code->promotion_details))
							{
								$promoData = $promo_code->promotion_details;
								$success = true;
								$message = "Valid Code";
							}	
						}
					}else
					{
						$success = false;
						$message = "Invalid Code";						
					}
					
				}
				else{		
					if(!empty($promotion_detail_id))
					{	
						$promo_codes = $this->Promotions->find()
						->contain(['PromotionDetails' => function ($q) use($promotion_detail_id) {
							return $q->where(['PromotionDetails.id'=>$promotion_detail_id]);
						}])
						->where([$conditions])
						->where(['Promotions.id'=>$promo_id])
						->where(['city_id' => $city_id])->first();	

						if(!empty($promo_codes->toArray()))
						{
							if(!empty($promo_codes->promotion_details))
							{
								$customerUsedCount = $this->Promotions->CustomerPromotions->find('All')
								->where(['CustomerPromotions.customer_id'=>$customer_id,'promotion_detail_id'=>$promo_codes->promotion_details[0]->id])->count();
								if($customerUsedCount > 0)
								{
									$success = false;
									$message = "Customer has already used code";									
									
								}else
								{
									$promoData = $promo_codes->promotion_details;
									$success = true;
									$message = "Valid Code";									
								}

							}	
							else
							{
								$success = false;
								$message = "Invalid Code";						
							}					
						}else
						{
							$success = false;
							$message = "Invalid Promo Code";
						}								
					}else{
						$success = false;
						$message = "Empty promotion details id";					
					}
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
