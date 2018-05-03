<?php
namespace App\Controller\Api;
use Cake\Event\Event;
use Cake\Network\Exception\UnauthorizedException;
use Cake\Utility\Security;
use Firebase\JWT\JWT;


class FaqsController extends AppController
{
    public function initialize()
     {
         parent::initialize();
         $this->Auth->allow(['faqdata']);
     }

     public function faqdata($city_id = null)
     {
       $city_id = @$this->request->query['city_id'];
       $faqData = [];
       if(!empty($city_id))
       {
         // CheckAvabiltyOfCity function is avaliable in app controller for checking city_id in cities table
         $isValidCity = $this->CheckAvabiltyOfCity($city_id);
          if($isValidCity == 0)
          {
              $faqData = $this->Faqs->find()->where(['city_id'=>$city_id,'status'=>0]);
              if(!empty($faqData->toArray()))
              {
                $success = true;
                $message = 'Data Found Successfully';
              }else {
                $success = false;
                $message = 'No Data Found';
              }
          }
            else {
              $success = false;
              $message = 'Invalid City';
            }
       }else
       {
         $success = false;
         $message = 'City Id Empty';
       }
       $this->set(['success' => $success,'message'=>$message,'faqdata' => $faqData,'_serialize' => ['success','message','faqdata']]);
     }
}
