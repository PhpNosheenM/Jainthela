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
			//pr(getallheaders());exit;
			$token = '';
          foreach(getallheaders() as $key => $value) {
             if($key == 'Authorization' || $key == 'authorization')
             {
               $token = $value;
             }
          }
		//  echo $token;exit;
          // checkToken function is avaliable in app controller for checking token in customer table
         $token = str_replace("Bearer ","",$token);
          $isValidToken = $this->checkToken($token);

            if($isValidToken == 0)
              {
                  $rowsDatas = $this->request->getData('bulk_booking_lead_rows');
                  $leadNo = $this->BulkBookingLeads->find()->select(['lead_no'])->order(['id' => 'DESC'])->first();
                  if(!empty($leadNo)){ $maxLead = $leadNo->lead_no + 1;}
                  else{ $maxLead = 1;}
                if(!empty($rowsDatas))
                  {
                    $i=0;
					$bulk_booking_lead_rows = [];
                      foreach ($rowsDatas as $rowsData) {
                        if($rowsData['image_name']['error'] == 0)
                         {
                           $rowsData_ext=explode('/',$rowsData['image_name']['type']);
                           $bulk_booking_lead_rows[$i]['image_name'] = 'Bulk_Booking'.time().rand().'.'.$rowsData_ext[1];
                           $i++;
                         }
                      }

                      $bulkBookingLead = $this->BulkBookingLeads->patchEntity($bulkBookingLead, $this->request->getData());
                    //  pr($bulk_booking_lead_rows);exit;
                      $j=0;
                      foreach ($bulk_booking_lead_rows as $bulk_booking_lead_row) {
                          $bulkBookingLeadRows = $this->BulkBookingLeads->BulkBookingLeadRows->newEntity();
                          $bulkBookingLeadRows->image_name = $bulk_booking_lead_row['image_name'];
                          $bulkBookingLead->bulk_booking_lead_rows[$j] = $bulkBookingLeadRows;
                          $j++;
                      }
                      $bulkBookingLead->lead_no = $maxLead;
                      $bulkBookingLead->delivery_date = date('Y-m-d',strtotime($this->request->getData('delivery_date')));



					//  pr($bulkBookingLead);exit;
                      if ($bulkBookingLeadData = $this->BulkBookingLeads->save($bulkBookingLead)) {

                          foreach ($rowsDatas as $rowsData) {
                            if($rowsData['image_name']['error'] == 0)
                             {
                            //   $deletekeyname = 'bulkbooking/customer/'.$bulkBookingLeadData->id;
                        //       $this->AwsFile->deleteMatchingObjects($deletekeyname);
                               foreach ($bulkBookingLeadData->bulk_booking_lead_rows as $imageData) {
                                 $keyname = 'bulkbooking/customer/'.$bulkBookingLeadData->id.'/'.$imageData->image_name;
                                 $this->AwsFile->putObjectFile($keyname,$rowsData['image_name']['tmp_name'],$rowsData['image_name']['type']);
                               }
                             }
                          }
                          $success = true;
                          $message = 'Successfully Uploaded';
                      }
                      else{ //pr($bulkBookingLead);exit;
                        $success = false;
                        $message = 'Something went wrong';
                      }
                  }else {
                      $bulkBookingLead = $this->BulkBookingLeads->patchEntity($bulkBookingLead, $this->request->getData());
                      $bulkBookingLead->lead_no = $maxLead;
                      $bulkBookingLead->delivery_date = date('Y-m-d',strtotime($this->request->getData('delivery_date')));

                        if($this->BulkBookingLeads->save($bulkBookingLead))
                        {
                          $success = true;
                          $message = 'Successfully Added';
                        }
                        else
                        {
                          $success = false;
                          $message = 'invalid data';
                        }

                  }

              }else {
                          $success = false;
                          $message = 'Invalid Token';
			  }

        }
        $this->set(['success' => $success,'message'=>$message,'_serialize' => ['success','message']]);
    }
}
