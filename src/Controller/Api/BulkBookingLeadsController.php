<?php
namespace App\Controller\Api;
use Cake\Event\Event;
use Cake\Network\Exception\UnauthorizedException;
use Cake\Utility\Security;
use Firebase\JWT\JWT;

/**
 * BulkBookingLeads Controller
 *
 * @property \App\Model\Table\BulkBookingLeadsTable $BulkBookingLeads
 *
 * @method \App\Model\Entity\BulkBookingLead[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BulkBookingLeadsController extends AppController
{
    public function add()
    {
        $bulkBookingLead = $this->BulkBookingLeads->newEntity();
        if ($this->request->is('post')) {
          foreach(getallheaders() as $key => $value) {
             if($key == 'Authorization')
             {
               $token = $value;
             }
          }
          // checkToken function is avaliable in app controller for checking token in customer table
         $token = str_replace("Bearer ","",$token);
          $isValidToken = $this->checkToken($token);
            if($isValidToken == 0)
              {
                  $bulkBookingLead = $this->BulkBookingLeads->patchEntity($bulkBookingLead, $this->request->getData());
                  if ($this->BulkBookingLeads->save($bulkBookingLead)) {

                  }
              }
        }
        $this->set(compact('bulkBookingLead'));
    }
}
