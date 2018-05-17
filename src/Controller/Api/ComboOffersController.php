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
				$this->Auth->allow(['combooffer','comboofferdetails']);
			}

		public function comboofferdetails(){
			$offer_id = @$this->request->query['offer_id'];
			$customer_id = @$this->request->query['customer_id'];
			$cart_item_count = $this->ComboOffers->Carts->find('All')->where(['Carts.customer_id'=>$customer_id])->count();
			if(!empty($offer_id)){
				$offerDetails=$this->ComboOffers->get($offer_id,['contain'=>['ComboOfferDetails'=>['ItemVariations'=>['ItemVariationMasters','Items','UnitVariations'=>['Units']]]]]);

				if(!empty($offerDetails->toArray()))
				{
					$offerDetails->total_item = sizeof($offerDetails->combo_offer_details);
					$offer_id = $offerDetails->id;
					$inWishList = $this->ComboOffers->WishListItems->find()->where(['combo_offer_id'=>$offer_id])->contain(['WishLists'=>function($q) use($customer_id){
						return $q->select(['WishLists.customer_id'])->where(['customer_id'=>$customer_id]);}])->count();
						if($inWishList  == 1)
						{ $offerDetails->inWishList = true; }
						else { $offerDetails->inWishList = false; }
							$count_value = 0;
						$count_cart = $this->ComboOffers->Carts->find()->select(['Carts.cart_count'])->where(['Carts.combo_offer_id'=>$offer_id,'Carts.customer_id'=>$customer_id]);
						if(!empty($count_cart->toArray()))
						{
								foreach ($count_cart as $count) {
									$count_value = $count->cart_count;
								}
						}
						$offerDetails->cart_count = $count_value;
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
							$offer[]=array('inWishList'=>$inWishList,'cart_count'=>$cart_count,"offer_id"=>$offer_id,"offer_name"=>$offer_name,"print_rate"=>$print_rate,"discount_per"=>$discount_per,"sales_rate"=>$sales_rate,"item_name"=>$item_name,"quantity"=>$total_item,"combo_offer_image"=>$combo_offer_image,'combo_offer_image_web'=>$combo_offer_image_web,"maximum_quantity_purchase"=>$maximum_quantity_purchase,"out_of_stock"=>$out_of_stock);
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

}
