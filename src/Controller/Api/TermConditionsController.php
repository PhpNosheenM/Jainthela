<?php
namespace App\Controller\Api;
use Cake\Event\Event;
use Cake\Network\Exception\UnauthorizedException;
use Cake\Utility\Security;
use Firebase\JWT\JWT;

class TermConditionsController extends AppController
{

  public function initialize()
   {
       parent::initialize();
       $this->Auth->allow(['tnc']);
   }

  public function tnc($city_id = null)
    {
       $city_id = @$this->request->query['city_id'];
       if(!empty($city_id))
       {
         $isValidCity = $this->CheckAvabiltyOfCity($city_id);
          if($isValidCity == 0)
          {
           $privacy = $this->TermConditions->find()->where(['TermConditions.term_name'=>'privacy'])->first();
           $tcs = $this->TermConditions->find()->where(['TermConditions.term_name'=>'tcs'])->first();
           $aboutus = $this->TermConditions->find()->where(['TermConditions.term_name'=>'aboutus'])->first();
           $company_details = $this->TermConditions->CompanyDetails->find()->first();
           $supplier_areas = $this->TermConditions->SupplierAreas->find()->order(['name' => 'ASC']);
           $success=true;
           $message = 'Data found Successfully';
         }else {
           $success = false;
           $message = 'Invalid City';
         }
       }else{
         $success = false;
         $message = 'City id empty';
       }

       $this->set(compact('success','message','privacy', 'tcs', 'aboutus', 'company_details', 'supplier_areas'));
       $this->set('_serialize', ['success', 'message','privacy', 'tcs', 'aboutus', 'company_details', 'supplier_areas']);
    }
}
