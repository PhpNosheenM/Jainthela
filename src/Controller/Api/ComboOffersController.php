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
			if(!empty($offer_id)){
				$offerDetails=$this->ComboOffers->get($offer_id,['contain'=>['ComboOfferDetails'=>['ItemVariations'=>['Items','UnitVariations'=>['Units']]]]]);
				$success = true;
				$message = 'data found';
			}else{
				
				$success = false;
				$message = 'empty offer id';
			}
			
			$this->set(['success' => $success,'message'=>$message,'offer_details' => $offerDetails,'_serialize' => ['success','message','offer_details']]);
		}
	
			
		public function combooffer(){
				$offer=[];
				
				 $city_id = @$this->request->query['city_id'];
			if(!empty($city_id)){
				
			$isValidCity = $this->CheckAvabiltyOfCity($city_id);
				 if($isValidCity == 0)
				 {
						
				$ComboOffers=$this->ComboOffers->find()
					->where(['status'=>'Active','city_id'=>$city_id])
					->contain(['ComboOfferDetails'=>['ItemVariations'=>['Items']]]);
				
					if($ComboOffers->toArray()){
						
						foreach($ComboOffers as $ComboOffer){
							$offer_id=$ComboOffer->id;
							$offer_name=$ComboOffer->name;
							$print_rate=$ComboOffer->print_rate;
							$discount_per=$ComboOffer->discount_per;
							$sales_rate=$ComboOffer->sales_rate;
							$combo_offer_image=$ComboOffer->combo_offer_image;
							$combo_offer_detail=$ComboOffer->combo_offer_details;
							//pr($combo_offer_detail);
							$item_names=[]; $quantitys=0;$item_name='';
							foreach($combo_offer_detail as $combo_offer){
								 $quantitys+=$combo_offer->quantity;
								 $item_names[]= $combo_offer->item_variation->item->name;
								$item_name = implode("-",$item_names);
							}
							$offer[]=array("offer_id"=>$offer_id,"offer_name"=>$offer_name,"print_rate"=>$print_rate,"discount_per"=>$discount_per,"sales_rate"=>$sales_rate,"item_name"=>$item_name,"quantity"=>$quantitys,"combo_offer_image"=>$combo_offer_image);
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
			 $this->set(['success' => $success,'message'=>$message,'offers' => $offer,'_serialize' => ['success','message','offers']]);

		}		

}
