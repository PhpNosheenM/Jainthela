<?php
namespace App\Controller;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\View\View;

/**
 * BulkBookingLeads Controller
 *
 * @property \App\Model\Table\BulkBookingLeadsTable $BulkBookingLeads
 *
 * @method \App\Model\Entity\BulkBookingLead[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BulkBookingLeadsController extends AppController
{

	public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Security->setConfig('unlockedActions', ['index']);

    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index($id=null)
    {
       $city_id=$this->Auth->User('city_id'); 
		$user_id=$this->Auth->User('id');
		$this->viewBuilder()->layout('admin_portal');
        $this->paginate = [
            'limit' => 20
        ];
		
        $BulkBookingLeads =$this->BulkBookingLeads->find()->where(['BulkBookingLeads.city_id'=>$city_id]);
		
		if($id)
		{
			$bulkBookingLead = $this->BulkBookingLeads->get($id);
		}
		else{
			$bulkBookingLead = $this->BulkBookingLeads->newEntity();
		}
	
        if ($this->request->is(['post','put'])) {
			 $deliver_date=$this->request->data['delivery_date'];
			 $org_delivery_date=date('Y-m-d', strtotime($deliver_date));
			 
            $bulkBookingLead = $this->BulkBookingLeads->patchEntity($bulkBookingLead, $this->request->getData());
			 $bulk_fetch=$this->BulkBookingLeads->find()->Order(['id'=>'DESC'])->first();
			 $old_lead_no=$bulk_fetch->lead_no;
			 $new_lead_no=$old_lead_no+1;
			$bulkBookingLead->city_id=$city_id;
			$bulkBookingLead->delivery_date=$org_delivery_date;
			$bulkBookingLead->lead_no=$new_lead_no;
			 $bulk_booking_lead_row=$this->request->data['bulk_booking_lead_rows'];
            if ($bulk_data=$this->BulkBookingLeads->save($bulkBookingLead)) {
			 
			 foreach($bulk_booking_lead_row as $data1){
				 $bulk_booking_lead_row1=$this->BulkBookingLeads->BulkBookingLeadRows->newEntity();
				 $bulk_booking_lead_row1->bulk_booking_lead_id=$bulk_data->id;
				 $bulk_rows=$this->BulkBookingLeads->BulkBookingLeadRows->save($bulk_booking_lead_row1);
        		 $lastInsertId=$bulk_rows->id;
					
				 @$image_name=$data1->image_name;
				 $img_error=$image_name['error'];
					if(empty($img_error))
					{
						$img_ext=explode('/',$image_name['type']);
						$img_image_name='bulk_booking_lead'.time().'.'.$img_ext[1];
						
						
					$deletekeyname = 'bulk_booking_lead/'.$lastInsertId.'/web';
					$this->AwsFile->deleteMatchingObjects($deletekeyname);
					$keyname = 'bulk_booking_lead/'.$lastInsertId.'/web/'.$img_image_name;
					$this->AwsFile->putObjectFile($keyname,$image_name['tmp_name'],$image_name['type']);
					$bulk_image_web=$keyname;;
					
						
						
					$tempdir=sys_get_temp_dir();
					$destination_url = $tempdir . '/'.$img_image_name;
					if($img_ext[1]=='png'){
						$image = imagecreatefrompng($image_name['tmp_name']);
					}else{
						$image = imagecreatefromjpeg($image_name['tmp_name']); 
					}
					$im = imagejpeg($image, $destination_url, 10);
					
					
					/* For App Image */
					$deletekeyname = 'bulk_booking_lead/'.$lastInsertId.'/app';
					$this->AwsFile->deleteMatchingObjects($deletekeyname);
					$keyname = 'bulk_booking_lead/'.$lastInsertId.'/app/'.$img_image_name;
					$this->AwsFile->putObjectFile($keyname,$image_name['tmp_name'],$image_name['type']);
					$bulk_image_app=$keyname;
					
					 $query = $this->BulkBookingLeads->BulkBookingLeadRows->query();
					    	$query->update()
						   	->set([
						   		'BulkBookingLeadRows.image_name_web' => $bulk_image_web,
						   		'BulkBookingLeadRows.image_name' => $bulk_image_app
						   		])
						    ->where(['id' => $lastInsertId])
						    ->execute();
					
					}
			 }
				 
					/* For Web Image */
				  
				 
                $this->Flash->success(__('The bulkBookingLead has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
			pr($bulkBookingLead);
			exit;
            $this->Flash->error(__('The bulkBookingLead could not be saved. Please, try again.'));
        }
		else if ($this->request->is(['get'])){
			$search=$this->request->getQuery('search');
			/* $BulkBookingLeads->where([
							'OR' => [
									'BulkBookingLeads.name LIKE' => $search.'%',
									'BulkBookingLeads.link_name LIKE' => $search.'%',
									'BulkBookingLeads.status LIKE' => $search.'%'
							]
			]); */
		}
		$customers=$this->BulkBookingLeads->Customers->find('list');
        $BulkBookingLeads = $this->paginate($BulkBookingLeads);
		$paginate_limit=$this->paginate['limit'];
		$this->set(compact('BulkBookingLeads','bulkBookingLead','paginate_limit','customers'));
		
		
		/* 
        $bulkBookingLead = $this->BulkBookingLeads->get($id, [
            'contain' => ['Cities', 'Customers', 'BulkBookingLeadRows']
        ]);

        $this->set('bulkBookingLead', $bulkBookingLead); */
    }

    /**
     * View method
     *
     * @param string|null $id Bulk Booking Lead id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $bulkBookingLead = $this->BulkBookingLeads->get($id, [
            'contain' => ['Cities', 'Customers', 'BulkBookingLeadRows']
        ]);

        $this->set('bulkBookingLead', $bulkBookingLead);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $bulkBookingLead = $this->BulkBookingLeads->newEntity();
        if ($this->request->is('post')) {
            $bulkBookingLead = $this->BulkBookingLeads->patchEntity($bulkBookingLead, $this->request->getData());
            if ($this->BulkBookingLeads->save($bulkBookingLead)) {
                $this->Flash->success(__('The bulk booking lead has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The bulk booking lead could not be saved. Please, try again.'));
        }
        $cities = $this->BulkBookingLeads->Cities->find('list', ['limit' => 200]);
        $customers = $this->BulkBookingLeads->Customers->find('list', ['limit' => 200]);
        $this->set(compact('bulkBookingLead', 'cities', 'customers'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Bulk Booking Lead id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $bulkBookingLead = $this->BulkBookingLeads->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $bulkBookingLead = $this->BulkBookingLeads->patchEntity($bulkBookingLead, $this->request->getData());
            if ($this->BulkBookingLeads->save($bulkBookingLead)) {
                $this->Flash->success(__('The bulk booking lead has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The bulk booking lead could not be saved. Please, try again.'));
        }
        $cities = $this->BulkBookingLeads->Cities->find('list', ['limit' => 200]);
        $customers = $this->BulkBookingLeads->Customers->find('list', ['limit' => 200]);
        $this->set(compact('bulkBookingLead', 'cities', 'customers'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Bulk Booking Lead id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $bulkBookingLead = $this->BulkBookingLeads->get($id);
        if ($this->BulkBookingLeads->delete($bulkBookingLead)) {
            $this->Flash->success(__('The bulk booking lead has been deleted.'));
        } else {
            $this->Flash->error(__('The bulk booking lead could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
