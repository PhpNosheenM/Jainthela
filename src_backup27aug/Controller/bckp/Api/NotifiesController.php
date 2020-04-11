<?php
namespace App\Controller\Api;


class NotifiesController extends AppController
{
    public function initialize()
    {
         parent::initialize();
         $this->Auth->allow(['notifyMe']);
    }	
	
	public function notifyMe()
	{
		$notifies = $this->Notifies->newEntity();
		if ($this->request->is('post')) {
			
			$isCombo  = $this->request->getData('isCombo');
            $notifies = $this->Notifies->patchEntity($notifies, $this->request->getData());
			$exists = $this->Notifies->exists(['Notifies.customer_id'=>$notifies->customer_id]);
			if($exists != 1)
			{
				if ($this->Notifies->save($notifies)) {
					$success = true;
				    $isAdded = true;
					$message = 'Item added to Notify me';
                }
                else {
					$success = false;
				    $isAdded = false;
					$message = 'not successfully added';
                }
				
			}else{
				if($isCombo == 'true')
				{
					if(!empty($this->request->getData('combo_offer_id')))
					{
						$exists = $this->Notifies->exists(['Notifies.customer_id'=>$notifies->customer_id,'Notifies.combo_offer_id'=>$this->request->getData('combo_offer_id')]);

							if($exists != 1)
							{
								$query = $this->Notifies->query();
								$query->insert(['customer_id','combo_offer_id'])
								  ->values(['customer_id'=>$notifies->customer_id,'combo_offer_id' => $this->request->getData('combo_offer_id')])
								  ->execute();
								  $success = true;
								  $isAdded = true;
								  $message = 'combo offer added to Notifies';
							}
							else {
								$query = $this->Notifies->query();
								$query->delete()->where(['Notifies.customer_id'=>$notifies->customer_id,'Notifies.combo_offer_id'=>$this->request->getData('combo_offer_id')])
								->execute();
								   $success = true;
								   $isAdded = false;
								   $message = 'removed from Notifies';
							}						
						
					}else
					{
					  $success = false;
					  $message = 'empty combo details';
					  $isAdded = false;
					}
				}
				else{
						
						if(!empty($this->request->getData('item_id')) and  !empty($this->request->getData('item_variation_id')))
                        {
                          
                            $exists = $this->Notifies->exists(['Notifies.customer_id'=>$notifies->customer_id,'Notifies.item_id'=>$this->request->getData('item_id'),'Notifies.item_variation_id'=>$this->request->getData('item_variation_id')]);
                                if($exists != 1)
                                {
                                     $query = $this->Notifies->query();
                                      $query->insert(['customer_id','item_id','item_variation_id'])
                                          ->values([
                                            'customer_id' =>$notifies->customer_id,
                                            'item_id' => $this->request->getData('item_id'),
                                            'item_variation_id' => $this->request->getData('item_variation_id')
                                          ])
                                          ->execute();
                                          $success = true;
        							      $isAdded = true;
                                          $message = 'Item added to Notify me';
                                }
                                else {
                                    $query = $this->Notifies->query();
                                    $query->delete()->where(['Notifies.customer_id'=>$notifies->customer_id,'Notifies.item_id'=>$this->request->getData('item_id'),'Notifies.item_variation_id'=>$this->request->getData('item_variation_id')])
                                    ->execute();
                                        $success = true;
        						        $isAdded = false;
                                        $message = 'removed from Notify me';
                                }
                        }else
                        {
                          $success = false;
                          $message = 'empty item details';
                          $isAdded = false;
                        }					
				}
			}
		}
		
		$this->set(['isAdded'=>$isAdded,'success' => $success,'message'=>$message,'_serialize' => ['success','message','isAdded']]);
	}
}	

?>