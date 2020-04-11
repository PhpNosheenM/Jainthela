<?php
namespace App\Controller\Api;
use Cake\Event\Event;
use Cake\Network\Exception\UnauthorizedException;
use Cake\Utility\Security;
use Firebase\JWT\JWT;


/**
 * ComboOffers Controller
 *
 * @property \App\Model\Table\ComboOffersTable $ComboOffers
 *
 * @method \App\Model\Entity\ComboOffer[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 
 
 
 
 */
class ComboOffersController extends AppController
{
		public function initialize()
			{
				parent::initialize();
				$this->Auth->allow(['combooffer','comboofferdetails','addComboRating','comboRatingList']);
			}

		public function comboofferdetails(){
			$offer_id = @$this->request->query['offer_id'];
			$customer_id = @$this->request->query['customer_id'];
			$cart_item_count = $this->ComboOffers->Carts->find('All')->where(['Carts.customer_id'=>$customer_id])->count();
			if(!empty($offer_id)){
			
			$ComboofferDetail=$this->ComboOffers->find();
			$ComboofferDetail->select(['LeftComboReviewRatings.combo_offer_id','ComboAverageRating' => $ComboofferDetail->func()->avg('LeftComboReviewRatings.rating')])
			->leftJoinWith('LeftComboReviewRatings')
			->contain(['LeftComboReviewRatings'=>['Customers'],'ComboOfferDetails'=>['ItemVariations'=>['ItemVariationMasters','Items','UnitVariations'=>['Units']]]])
			->where(['ComboOffers.id'=>$offer_id])->autoFields(true);
						
				//pr($offerDetails->toArray()); exit;
						
				if(!empty($ComboofferDetail->toArray()))
				{
					foreach($ComboofferDetail as $offerDetails){
					$offerDetails->total_item = sizeof($offerDetails->combo_offer_details);
					$offer_id = $offerDetails->id;
					$inWishList = $this->ComboOffers->WishListItems->find()->where(['combo_offer_id'=>$offer_id])->contain(['WishLists'=>function($q) use($customer_id){
						return $q->select(['WishLists.customer_id'])->where(['customer_id'=>$customer_id]);}])->count();
						if($inWishList  == 1)
						{ $offerDetails->inWishList = true; }
						else { $offerDetails->inWishList = false; }
						
						$inNotifylist = 0;
						$inNotifylist = $this->ComboOffers->Notifies->find()
							->where(['combo_offer_id'=>$offer_id])
							->where(['customer_id'=>$customer_id])->count();
						$offerDetails->inNotifylist = false;
						if($inNotifylist  >= 1)
						{ $offerDetails->inNotifylist = true; }
						else { $offerDetails->inNotifylist = false; }						
						
						
							$count_value = 0;
						$count_cart = $this->ComboOffers->Carts->find()->select(['Carts.cart_count'])->where(['Carts.combo_offer_id'=>$offer_id,'Carts.customer_id'=>$customer_id]);
						if(!empty($count_cart->toArray()))
						{
								foreach ($count_cart as $count) {
									$count_value = $count->cart_count;
								}
						}
						$offerDetails->cart_count = $count_value;
						if(empty($offerDetails->ComboAverageRating))
						{
						  $offerDetails->ComboAverageRating = 0.00;
						}
					}	
					$success = true;
					$message = 'data found';
				}else{
						$success = false;
						$message = 'no data found';
				}

			}else{

				$success = false;
				$message = 'empty offer id';
			}

			$this->set(['success' => $success,'message'=>$message,'cart_item_count'=>$cart_item_count,'offer_details' => $offerDetails,'_serialize' => ['success','message','cart_item_count','offer_details']]);
		}


		public function combooffer(){
				$offer=[];

				 $city_id = @$this->request->query['city_id'];
				 $customer_id = @$this->request->query['customer_id'];
			if(!empty($city_id)){

			$isValidCity = $this->CheckAvabiltyOfCity($city_id);
				 if($isValidCity == 0)
				 {
						$cart_item_count = $this->ComboOffers->Carts->find('All')->where(['Carts.customer_id'=>$customer_id])->count();
						$ComboOffers=$this->ComboOffers->find()
						->where(['status'=>'Active','city_id'=>$city_id])
						->contain(['ComboOfferDetails'=>['ItemVariations'=>['ItemVariationMasters','Items']]]);

					if($ComboOffers->toArray()){
						$total_item=0;
						foreach($ComboOffers as $ComboOffer){
							$offer_id=$ComboOffer->id;
							$offer_name=$ComboOffer->name;
							$print_rate=$ComboOffer->print_rate;
							$discount_per=$ComboOffer->discount_per;
							$sales_rate=$ComboOffer->sales_rate;
							$combo_offer_image=$ComboOffer->combo_offer_image;
							$combo_offer_image_web=$ComboOffer->combo_offer_image_web;
							$combo_offer_detail=$ComboOffer->combo_offer_details;
							$maximum_quantity_purchase = $ComboOffer->maximum_quantity_purchase;
							$out_of_stock = $ComboOffer->out_of_stock;
							//pr($combo_offer_detail);
							$item_names=[]; $item_name='';
							$total_item = sizeof($combo_offer_detail);
							foreach($combo_offer_detail as $combo_offer){
								 //$total_item+=$total_item + 1;
								 $item_names[]= $combo_offer->item_variation->item->name;
								$item_name = implode("-",$item_names);
							}


							$inWishList = $this->ComboOffers->WishListItems->find()->where(['combo_offer_id'=>$offer_id])->contain(['WishLists'=>function($q) use($customer_id){
								return $q->select(['WishLists.customer_id'])->where(['customer_id'=>$customer_id]);}])->count();
								if($inWishList  == 1)
								{ $inWishList = true; }
								else { $inWishList = false; }
								
							$inNotifylist = 0;
							$inNotifylist = $this->ComboOffers->Notifies->find()
								->where(['combo_offer_id'=>$offer_id])
								->where(['customer_id'=>$customer_id])->count();
							
							if($inNotifylist  >= 1)
							{ $inNotifyResult = true; }
							else { $inNotifyResult = false; }										
								
								
								  $count_value = 0;
									$cart_count =0;
                $count_cart = $this->ComboOffers->Carts->find()->select(['Carts.cart_count'])->where(['Carts.combo_offer_id'=>$offer_id,'Carts.customer_id'=>$customer_id]);
								//pr($count_cart->toArray());exit;
								if(!empty($count_cart->toArray()))
								{
										foreach ($count_cart as $count) {
		                  $count_value = $count->cart_count;
		                }
		                $cart_count = $count_value;
								}
							$offer[]=array('inNotifylist'=>$inNotifyResult,'inWishList'=>$inWishList,'cart_count'=>$cart_count,"offer_id"=>$offer_id,"offer_name"=>$offer_name,"print_rate"=>$print_rate,"discount_per"=>$discount_per,"sales_rate"=>$sales_rate,"item_name"=>$item_name,"quantity"=>$total_item,"combo_offer_image"=>$combo_offer_image,'combo_offer_image_web'=>$combo_offer_image_web,"maximum_quantity_purchase"=>$maximum_quantity_purchase,"out_of_stock"=>$out_of_stock);
						}


						$success = true;
					    $message = 'data found';
					}else{
						$success = false;
					    $message = 'No data found';

					}
			}else{
					$success = false;
					$message = 'Invalid city id';
			}
			}else{
					$success = false;
					$message = 'empty city id';
			}
			 $this->set(['success' => $success,'message'=>$message,'cart_item_count'=>$cart_item_count,'offers' => $offer,'_serialize' => ['success','message','cart_item_count','offers']]);

		}


      public function addComboRating()
      {
        $addComboRating = $this->ComboOffers->ComboReviewRatings->newEntity();
        if($this->request->is(['patch', 'post', 'put'])){
          $addComboRating = $this->ComboOffers->ComboReviewRatings->patchEntity($addComboRating, $this->request->getData());
		  
		  //pr($addComboRating);exit;
		  
          if(!empty($addComboRating->combo_offer_id) and (!empty($addComboRating->customer_id))){

            $exists = $this->ComboOffers->ComboReviewRatings->exists(['ComboReviewRatings.combo_offer_id'=>$addComboRating->combo_offer_id,'ComboReviewRatings.customer_id'=>$addComboRating->customer_id]);
            if($exists == 1) {
              $success = false;
              $message = 'rating already given';
            }
            else {
              if ($this->ComboOffers->ComboReviewRatings->save($addComboRating)) {
                $success=true;
                $message="rating n review has been saved successfully";
              }else{
                $success=false;
                $message="rating n review has not been saved";
              }
            }
          }else{
            $success = false;
            $message = 'Invalid Combo Offer id or customer id';
          }
        }
        $this->set(['success' => $success,'message'=>$message,'_serialize' => ['success','message']]);
      }

	  
      public function comboRatingList($combo_offer_id = null,$city_id =null)
      {
        $combo_offer_id = @$this->request->query['combo_offer_id'];
        $city_id = @$this->request->query['city_id'];
        $averageRating = number_format(0,1);
        if(!empty($city_id))
        {
          // CheckAvabiltyOfCity function is avaliable in app controller for checking city_id in cities table
          $isValidCity = $this->CheckAvabiltyOfCity($city_id);
          if($isValidCity == 0)
          {
			 
            $ratingLists = $this->ComboOffers->ComboReviewRatings->find()
            ->contain(['Customers'=>function($q){ return $q->select(['name']);  } ])
            ->where(['ComboReviewRatings.combo_offer_id'=>$combo_offer_id,'ComboReviewRatings.status'=>0,'ComboReviewRatings.comment !='=>'']);
            if(!empty($ratingLists->toArray()))
            {
              $rating = $this->ComboOffers->ComboReviewRatings->find();
              $rating->select(['averageRating' => $rating->func()->avg('rating')])
              ->where(['ComboReviewRatings.combo_offer_id'=>$combo_offer_id,'ComboReviewRatings.status'=>0]);

              foreach ($rating as $ratingarr) {
                $averageRating = number_format($ratingarr->averageRating,1);
              }

              $success = true;
              $message = 'Data Found Successfully';
            } else {
              $success = true;
              $message = 'No data found';
            }

            $star1 = $this->ComboOffers->ComboReviewRatings->find()->where(['ComboReviewRatings.combo_offer_id'=>$combo_offer_id,'ComboReviewRatings.status'=>0,'rating >='=>1,'rating <'=>1.9])->all();
            $star1count = $star1->count();
            $star2 = $this->ComboOffers->ComboReviewRatings->find()->where(['ComboReviewRatings.combo_offer_id'=>$combo_offer_id,'ComboReviewRatings.status'=>0,'rating >='=>2,'rating <'=>2.9])->all();
            $star2count = $star2->count();
            $star3 = $this->ComboOffers->ComboReviewRatings->find()->where(['ComboReviewRatings.combo_offer_id'=>$combo_offer_id,'ComboReviewRatings.status'=>0,'rating >='=>3,'rating <'=>3.9])->all();
            $star3count = $star3->count();
            $star4 = $this->ComboOffers->ComboReviewRatings->find()->where(['ComboReviewRatings.combo_offer_id'=>$combo_offer_id,'ComboReviewRatings.status'=>0,'rating >='=>4,'rating <'=>4.9])->all();
            $star4count = $star4->count();
            $star5 = $this->ComboOffers->ComboReviewRatings->find()->where(['ComboReviewRatings.combo_offer_id'=>$combo_offer_id,'ComboReviewRatings.status'=>0,'rating'=>5])->all();
            $star5count = $star5->count();
            $star1 = $star1count;
            $star2 = $star2count;
            $star3 = $star3count;
            $star4 = $star4count;
            $star5 = $star5count;
            $tot_stars = $star1count + $star2count + $star3count + $star4count + $star5count;
            $allpercentage =array();

            for ($i=5;$i >=1; --$i) {
              $var = "star$i";
              $count = $$var;
              if($count>0){
                $percent = $count * 100 / $tot_stars;
              }
              else
              {
                $percent=0;
              }
              $percentage = round($percent,2);
              $allpercentage[] = array("rating"=>$i,"percentage"=>$percentage);
              $percentage = '';
            }


          }
          else {
            $success = false;
            $message = 'Invalid City';
          }
        }else {
          $success = false;
          $message = 'Empty City Id';
        }
        $this->set(['success' => $success,'message'=>$message,'averageRating'=>$averageRating,'ratingLists' => $ratingLists,'percentage'=>$allpercentage,'_serialize' => ['success','message','averageRating','ratingLists','percentage']]);
      }	  
	  
	  
	  
}
