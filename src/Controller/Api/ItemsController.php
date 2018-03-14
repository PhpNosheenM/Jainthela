<?php
namespace App\Controller\Api;
use Cake\Event\Event;
use Cake\Network\Exception\UnauthorizedException;
use Cake\Utility\Security;
use Firebase\JWT\JWT;

/**
 * Items Controller
 *
 * @property \App\Model\Table\ItemsTable $Items
 *
 * @method \App\Model\Entity\Item[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ItemsController extends AppController
{

    public function initialize()
     {
         parent::initialize();
         $this->Auth->allow(['productDetail']);
     }


    public function productDetail($item_id = null,$city_id =null)
    {
      $item_id = $this->request->query['item_id'];
      $city_id = $this->request->query['city_id'];
      $items = [];
      if(!empty($city_id))
      {

        // CheckAvabiltyOfCity function is avaliable in app controller for checking city_id in cities table
        $isValidCity = $this->CheckAvabiltyOfCity($city_id);
        if($isValidCity == 0)
        {
            if(!empty($item_id))
            {
                $items = $this->Items->find()
                          ->contain(['Categories','Brands','Sellers','Cities','ItemVariations'])
                          ->where(['Items.status'=>'Active','Items.approve'=>'Approved','Items.ready_to_sale'=>'Yes','Items.id'=>$item_id,'Items.city_id'=>$city_id]);

                if(!empty($items->toArray()))
                {
                  $success = true;
                  $message = 'Data Found Successfully';
                }
                else {
                      $success = false;
                      $message = 'Record not found';
                }
            }else {
                    $success = false;
                    $message = 'Empty Item Id';
            }
        }else {
                $success = false;
                $message = 'Invalid City';
        }
      }else {
            $success = false;
            $message = 'Empty City Id';
      }


      $this->set(['success' => $success,'message'=>$message,'Items' => $items,'_serialize' => ['success','message','Items']]);
    }
}
