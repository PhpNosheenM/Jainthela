<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\View\View;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
/**
 * Vendors Controller
 *
 * @property \App\Model\Table\VendorsTable $Vendors
 *
 * @method \App\Model\Entity\Vendor[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class VendorsController extends AppController
{

    /** 
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
	 
	public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Security->setConfig('unlockedActions', ['add','edit','index']);

    }
	
    public function index()
    {
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id'); 
		$location_id=$this->Auth->User('location_id'); 
		$this->viewBuilder()->layout('super_admin_layout'); 
        $this->paginate = [
            'limit' => 100
        ];
		$vendors = $this->Vendors->find()->where(['Vendors.city_id'=>$city_id]);
		
        if ($this->request->is(['get'])){
			$search=$this->request->getQuery('search');
			$vendors->where([
							'OR' => [
									'Vendors.name LIKE' => $search.'%',
									'Vendors.status LIKE' => $search.'%',
									'Vendors.firm_name LIKE' => $search.'%',
									'Vendors.firm_address LIKE' => $search.'%',
									/* 'Vendors.firm_email LIKE' => $search.'%',
									'Vendors.firm_contact LIKE' => $search.'%',
									'Vendors.gstin_holder_name LIKE' => $search.'%', */
									'Vendors.gstin LIKE' => $search.'%',
									'Vendors.firm_pincode LIKE' => $search.'%',
 							]
			]);
		}
		
		$vendors= $this->paginate($vendors);
		$paginate_limit=$this->paginate['limit'];
        $this->set(compact('vendors','paginate_limit'));
    }

    /**
     * View method
     *
     * @param string|null $id Vendor id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $vendor = $this->Vendors->get($id, [
            'contain' => ['Cities', 'Locations', 'Ledgers', 'VendorDetails']
        ]);

        $this->set('vendor', $vendor);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id'); 
		$location_id=$this->Auth->User('location_id'); 
		$this->viewBuilder()->layout('super_admin_layout');
        $vendor = $this->Vendors->newEntity();
        if ($this->request->is('post')) {
			
			$document_image=$this->request->data['document_image'];
			$img_error=$document_image['error'];
			
            $vendor = $this->Vendors->patchEntity($vendor, $this->request->getData());
			$vendor->city_id=$city_id;
			$vendor->created_by=$user_id;
			$registration_date=$this->request->data['registration_date'];
			$vendor->registration_date=date('Y-m-d', strtotime($registration_date));
			$bill_to_bill_accounting=$vendor->bill_to_bill_accounting;
			$data=$this->Vendors->Cities->get($city_id);
			$reference_details=[];
			if(@$this->request->getData()['reference_details']){
				@$reference_details=$this->request->getData()['reference_details'];
			}
			
			$accounting_group = $this->Vendors->Ledgers->AccountingGroups->find()->where(['AccountingGroups.vendor'=>1,'AccountingGroups.city_id'=>$city_id])->first();
			
			if(empty($img_error))
			{
				$banner_ext=explode('/',$document_image['type']);
				$brand_image_name='vendor'.time().'.'.$banner_ext[1];
			}
			 
			
			
            if ($data=$this->Vendors->save($vendor)) {
				
				
				/* For Web Image */
				if(empty($img_error))
				{
				$deletekeyname = 'vendor/'.$data->id;
				$this->AwsFile->deleteMatchingObjects($deletekeyname);
				$keyname = 'vendor/'.$data->id.'/'.$brand_image_name;
				$this->AwsFile->putObjectFile($keyname,$document_image['tmp_name'],$document_image['type']);
				$data->document_image=$keyname;
				$this->Vendors->save($data);
				}
				
				$accounting_group = $this->Vendors->Ledgers->AccountingGroups->find()->where(['AccountingGroups.vendor'=>1,'AccountingGroups.city_id'=>$city_id])->first();
				//pr($accounting_group)
				$ledger = $this->Vendors->Ledgers->newEntity();
				$ledger->name = $vendor->firm_name;
				$ledger->accounting_group_id = $accounting_group->id;
				$ledger->vendor_id=$vendor->id;
				$ledger->city_id=$city_id;
				$ledger->bill_to_bill_accounting=$bill_to_bill_accounting;
				
				if($this->Vendors->Ledgers->save($ledger))
				{
				
					//Create Accounting Entry//
			        $transaction_date=$data->books_beginning_from;
					$AccountingEntry = $this->Vendors->Ledgers->AccountingEntries->newEntity();
					$AccountingEntry->ledger_id        = $ledger->id;
					if($vendor->debit_credit=="Dr")
					{
						$AccountingEntry->debit        = $vendor->opening_balance_value;
					}
					if($vendor->debit_credit=="Cr")
					{
						$AccountingEntry->credit       = $vendor->opening_balance_value;
					}
					$AccountingEntry->transaction_date = date("Y-m-d",strtotime($transaction_date));
					//$AccountingEntry->location_id       = $location_id;
					$AccountingEntry->city_id       = $city_id;
					$AccountingEntry->is_opening_balance = 'yes';
					
					if($vendor->opening_balance_value>0){
						if($vendor->opening_balance_value){
						$this->Vendors->Ledgers->AccountingEntries->save($AccountingEntry);

						//Refrence Entry//
						if($reference_details){
						foreach($reference_details as $reference_detail){
								$ReferenceDetail = $this->Vendors->ReferenceDetails->newEntity();
								$ReferenceDetail->ref_name        = $reference_detail['ref_name'];
								$ReferenceDetail->vendor_id        = $vendor->id;
								$ReferenceDetail->city_id        = $city_id;
								$ReferenceDetail->opening_balance        = "Yes";
								$ReferenceDetail->ledger_id        = $ledger->id;
								if($reference_detail['debit'] > 0)
								{
									$ReferenceDetail->debit        = $reference_detail['debit'];
								}
								else
								{
									$ReferenceDetail->credit       = $reference_detail['credit'];
								}
								$ReferenceDetail->transaction_date = date("Y-m-d",strtotime($data->books_beginning_from));
								$ReferenceDetail = $this->Vendors->ReferenceDetails->save($ReferenceDetail);
								}
							}
						}
					}
				}
				
                $this->Flash->success(__('The vendor has been saved.'));

                return $this->redirect(['action' => 'index']);
            }else{
				pr($vendor); exit;
			}
            $this->Flash->error(__('The vendor could not be saved. Please, try again.'));
        }
        $cities = $this->Vendors->Cities->find('list', ['limit' => 200]); 
        $this->set(compact('vendor', 'cities'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Vendor id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
		
		if($id)
		{
		   $id = $this->EncryptingDecrypting->decryptData($id);
		}
		
		$user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id'); 
		$this->viewBuilder()->layout('super_admin_layout');
        $vendor = $this->Vendors->get($id, [
            'contain' => ['VendorDetails']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $vendor = $this->Vendors->patchEntity($vendor, $this->request->getData());
			$vendor->city_id=$city_id;
			$vendor->created_by=$user_id;
			$registration_date=$this->request->data['registration_date'];
			$vendor->registration_date=date('Y-m-d', strtotime($registration_date));
			
            if ($this->Vendors->save($vendor)) {
                $this->Flash->success(__('The vendor has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The vendor could not be saved. Please, try again.'));
        }
        $cities = $this->Vendors->Cities->find('list', ['limit' => 200]);
        $this->set(compact('vendor', 'cities', 'locations'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Vendor id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($dir)
    {
		
		$this->request->allowMethod(['patch', 'post', 'put']);
        $vendor = $this->Vendors->get($id);
		$vendor->status='Deactive';
        if ($this->Vendors->save($vendor)) {
            $this->Flash->success(__('The vendor has been deleted.'));
        } else {
            $this->Flash->error(__('The vendor could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
