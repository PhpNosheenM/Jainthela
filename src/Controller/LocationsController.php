<?php
namespace App\Controller;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\View\View;
/**
 * Locations Controller
 *
 * @property \App\Model\Table\LocationsTable $Locations
 *
 * @method \App\Model\Entity\Location[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LocationsController extends AppController
{

	public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Security->setConfig('unlockedActions', ['add','edit'.'index']);

    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index($id = null)
    {
		$city_id=$this->Auth->User('city_id');
		$user_id=$this->Auth->User('id');
		$this->viewBuilder()->layout('admin_portal');
        $this->paginate = [
            'limit' => 20
        ];
		
        $locations =$this->Locations->find()->where(['Locations.city_id'=>$city_id]);
		if($id)
		{
			$location = $this->Locations->get($id);
		}
		else{
			$location = $this->Locations->newEntity();
		}
		
		if ($this->request->is(['post','put'])) {
			 
			
            $location = $this->Locations->patchEntity($location, $this->request->getData());
			 

			$location->city_id=$city_id;
			$location->created_by=$user_id;
			$location->financial_year_begins_from=date('Y-m-d', strtotime($this->request->data['financial_year_begins_from']));
			$location->financial_year_valid_to=date('Y-m-d', strtotime($this->request->data['financial_year_valid_to']));
			$location->books_beginning_from=date('Y-m-d', strtotime($this->request->data['books_beginning_from']));
			 
            if ($location_data=$this->Locations->save($location)) {
				
				$data = $this->Locations->Sellers->newEntity();
				
				$data->location_id=$location_data->id;
				$data->city_id=$location_data->city_id;
				$data->name=$location_data->name;
				$data->latitude=$location_data->latitude;
				$data->longitude=$location_data->longitude;
				
				$this->Locations->Sellers->save($data);
				 
				pr($data); exit;
                $this->Flash->success(__('The banner has been saved.'));

                if(empty($banner_error))
                {
                 return $this->redirect(['action' => 'delete_file',$dir]);
                }
                else
                {
                    return $this->redirect(['action' => 'index']);
                }
            }
            $this->Flash->error(__('The banner could not be saved. Please, try again.'));
        }
		else if ($this->request->is(['get'])){
			$search=$this->request->getQuery('search');
			$locations->where([
							'OR' => [
									'Locations.name LIKE' => $search.'%',
									'Locations.alise LIKE' => $search.'%',
									'Locations.latitude LIKE' => $search.'%',
									'Locations.longitude LIKE' => $search.'%',
									'Locations.financial_year_begins_from LIKE' => $search.'%',
									'Locations.financial_year_valid_to LIKE' => $search.'%',
									'Locations.books_beginning_from LIKE' => $search.'%',
									'Locations.status LIKE' => $search.'%'
							]
			]);
		}
		
		
		$locations = $this->paginate($locations);
		$paginate_limit=$this->paginate['limit'];
        $this->set(compact('locations','location','paginate_limit'));
    }

    /**
     * View method
     *
     * @param string|null $id Location id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $location = $this->Locations->get($id, [
            'contain' => ['Cities', 'AccountingGroups', 'FinancialYears', 'GstFigures', 'Ledgers', 'AccountingEntries', 'Admins', 'CreditNotes', 'CustomerAddresses', 'DebitNotes', 'Drivers', 'Grns', 'JournalVouchers', 'Orders', 'Payments', 'PurchaseInvoices', 'PurchaseReturns', 'PurchaseVouchers', 'Receipts', 'ReferenceDetails', 'SaleReturns', 'SalesInvoices', 'SalesVouchers', 'Suppliers']
        ]);

        $this->set('location', $location);
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
		$this->viewBuilder()->layout('admin_portal'); 
        $location = $this->Locations->newEntity(); 
		
        if ($this->request->is('post')) {
            $location = $this->Locations->patchEntity($location, $this->request->getData());
			$location->created_by=$user_id;
			//$location->id=2;
		
           if ($location=$this->Locations->save($location)) {
            	//Accounting Entries Location Wise
			//if($location){
            	$StatutoryInfos=[
					['nature_of_group_id'=>2, 'name'=>'Branch / Divisions', 'parent_id'=>NULL],
					['nature_of_group_id'=>2, 'name'=>'Capital Account', 'parent_id'=>NULL],
					['nature_of_group_id'=>1, 'name'=>'Current Assets', 'parent_id'=>NULL],
					['nature_of_group_id'=>2, 'name'=>'Current Liabilities', 'parent_id'=>NULL],
					['nature_of_group_id'=>4, 'name'=>'Direct Expenses', 'parent_id'=>NULL],
					['nature_of_group_id'=>3, 'name'=>'Direct Incomes', 'parent_id'=>NULL],
					['nature_of_group_id'=>1, 'name'=>'Fixed Assets', 'parent_id'=>NULL],
					['nature_of_group_id'=>4, 'name'=>'Indirect Expenses', 'parent_id'=>NULL],
					['nature_of_group_id'=>3, 'name'=>'Indirect Incomes', 'parent_id'=>NULL],
					['nature_of_group_id'=>1, 'name'=>'Investments', 'parent_id'=>NULL],
					['nature_of_group_id'=>2, 'name'=>'Loans (Liability)', 'parent_id'=>NULL],
					['nature_of_group_id'=>1, 'name'=>'Misc. Expenses (ASSET)', 'parent_id'=>NULL],
					['nature_of_group_id'=>4, 'name'=>'Purchase Accounts', 'parent_id'=>NULL],
					['nature_of_group_id'=>3, 'name'=>'Sales Accounts', 'parent_id'=>NULL],
					['nature_of_group_id'=>2, 'name'=>'Suspense A/c', 'parent_id'=>NULL]
				];

				//Statutory Info//
				foreach($StatutoryInfos as $StatutoryInfo){
					$accountingGroup = $this->Locations->AccountingGroups->newEntity();
					$accountingGroup->nature_of_group_id=$StatutoryInfo['nature_of_group_id'];
					$accountingGroup->name=$StatutoryInfo['name'];
					$accountingGroup->parent_id=$StatutoryInfo['parent_id'];
					$accountingGroup->location_id=$location->id;
					if($accountingGroup->name=='Suspense A/c')
					{
						$accountingGroup->credit_note_all_row=1;
						$accountingGroup->receipt_ledger=1;
						$accountingGroup->debit_note_all_row=1;
					}
					if($accountingGroup->name=='Loans (Liability)')
					{
						$accountingGroup->credit_note_all_row=1;
						$accountingGroup->receipt_ledger=1;
						$accountingGroup->debit_note_all_row=1;
					}
					if($accountingGroup->name=='Investments')
					{
						$accountingGroup->credit_note_all_row=1;
						$accountingGroup->receipt_ledger=1;
						$accountingGroup->debit_note_all_row=1;
					}
					if($accountingGroup->name=='Capital Account')
					{
						$accountingGroup->credit_note_all_row=1;
						$accountingGroup->receipt_ledger=1;
						$accountingGroup->debit_note_all_row=1;
					}
					if($accountingGroup->name=='Current Assets')
					{
						$accountingGroup->purchase_voucher_all_ledger=1;
						$accountingGroup->credit_note_all_row=1;
						$accountingGroup->receipt_ledger=1;
						$accountingGroup->debit_note_all_row=1;
						$accountingGroup->sales_voucher_all_ledger=1;
					}
					if($accountingGroup->name=='Current Liabilities')
					{
						$accountingGroup->purchase_voucher_all_ledger=1;
						$accountingGroup->credit_note_all_row=1;
						$accountingGroup->receipt_ledger=1;
						$accountingGroup->debit_note_all_row=1;
						$accountingGroup->sales_voucher_all_ledger=1;
					}
					if($accountingGroup->name=='Direct Incomes')
					{
						$accountingGroup->purchase_voucher_all_ledger=1;
						$accountingGroup->credit_note_all_row=1;
						$accountingGroup->receipt_ledger=1;
						$accountingGroup->debit_note_all_row=1;
						$accountingGroup->sales_voucher_all_ledger=1;
					}
					if($accountingGroup->name=='Direct Expenses')
					{
						$accountingGroup->purchase_voucher_all_ledger=1;
						$accountingGroup->credit_note_all_row=1;
						$accountingGroup->receipt_ledger=1;
						$accountingGroup->debit_note_all_row=1;
						$accountingGroup->sales_voucher_all_ledger=1;
					}
					if($accountingGroup->name=='Indirect Incomes')
					{
						$accountingGroup->purchase_voucher_all_ledger=1;
						$accountingGroup->credit_note_all_row=1;
						$accountingGroup->receipt_ledger=1;
						$accountingGroup->debit_note_all_row=1;
						$accountingGroup->sales_voucher_all_ledger=1;
					}
					if($accountingGroup->name=='Indirect Expenses')
					{
						$accountingGroup->purchase_voucher_all_ledger=1;
						$accountingGroup->credit_note_all_row=1;
						$accountingGroup->receipt_ledger=1;
						$accountingGroup->debit_note_all_row=1;
						$accountingGroup->sales_voucher_all_ledger=1;
					}
					if($accountingGroup->name=='Misc. Expenses (ASSET)')
					{
						$accountingGroup->purchase_voucher_all_ledger=1;
						$accountingGroup->credit_note_all_row=1;
						$accountingGroup->receipt_ledger=1;
						$accountingGroup->debit_note_all_row=1;
					}
					if($accountingGroup->name=='Branch / Divisions')
					{
						$accountingGroup->purchase_voucher_purchase_ledger=1;
						$accountingGroup->credit_note_all_row=1;
						$accountingGroup->credit_note_first_row=1;
						$accountingGroup->receipt_ledger=1;
						$accountingGroup->debit_note_first_row=1;
						$accountingGroup->debit_note_all_row=1;
						$accountingGroup->sales_voucher_first_ledger=1;
					}
					if($accountingGroup->name=='Purchase Accounts')
					{
						$accountingGroup->purchase_voucher_all_ledger=1;
						$accountingGroup->purchase_voucher_purchase_ledger=1;
						$accountingGroup->credit_note_all_row=1;
						$accountingGroup->receipt_ledger=1;
						$accountingGroup->debit_note_all_row=1;
					}
					if($accountingGroup->name=='Sales Accounts')
					{
						$accountingGroup->sale_invoice_sales_account=1;
						$accountingGroup->credit_note_all_row=1;
						$accountingGroup->receipt_ledger=1;
						$accountingGroup->debit_note_all_row=1;
						$accountingGroup->sales_voucher_all_ledger=1;
						$accountingGroup->sales_voucher_sales_ledger=1;
					}
					$this->Locations->AccountingGroups->save($accountingGroup);
				}

				$accountingParentGroup=$this->Locations->AccountingGroups->find()->where(['name'=>'Capital Account','location_id'=>$location->id])->first();
				$accountingGroup = $this->Locations->AccountingGroups->newEntity();
				$accountingGroup->nature_of_group_id=NULL;
				$accountingGroup->name='Reserves & Surplus';
				$accountingGroup->parent_id=$accountingParentGroup->id;
				$accountingGroup->location_id=$location->id;
				$accountingGroup->credit_note_all_row=1;
				$accountingGroup->receipt_ledger=1;
				$accountingGroup->debit_note_all_row=1;
				$this->Locations->AccountingGroups->save($accountingGroup);
				
				$accountingParentGroup=$this->Locations->AccountingGroups->find()->where(['name'=>'Current Assets','location_id'=>$location->id])->first();
				$accountingGroup = $this->Locations->AccountingGroups->newEntity();
				$accountingGroup->nature_of_group_id=NULL;
				$accountingGroup->name='Bank Accounts';
				$accountingGroup->parent_id=$accountingParentGroup->id;
				$accountingGroup->location_id=$location->id;
				$accountingGroup->purchase_voucher_first_ledger=1;
				$accountingGroup->credit_note_first_row=1;
				$accountingGroup->receipt_ledger=1;
				$accountingGroup->debit_note_first_row=1;
				$accountingGroup->sales_voucher_first_ledger=1;
				$this->Locations->AccountingGroups->save($accountingGroup);
				
				$accountingGroup = $this->Locations->AccountingGroups->newEntity();
				$accountingGroup->nature_of_group_id=NULL;
				$accountingGroup->name='Cash-in-hand';
				$accountingGroup->parent_id=$accountingParentGroup->id;
				$accountingGroup->location_id=$location->id;
				$accountingGroup->purchase_voucher_party=1;
				$accountingGroup->sale_invoice_party=1;
				$accountingGroup->credit_note_first_row=1;
				$accountingGroup->receipt_ledger=1;
				$accountingGroup->purchase_voucher_first_ledger=1;
				$accountingGroup->debit_note_first_row=1;
				$accountingGroup->sales_voucher_first_ledger=1;
				$this->Locations->AccountingGroups->save($accountingGroup);
				
				$accountingGroup = $this->Locations->AccountingGroups->newEntity();
				$accountingGroup->nature_of_group_id=NULL;
				$accountingGroup->name='Deposits (Asset)';
				$accountingGroup->parent_id=$accountingParentGroup->id;
				$accountingGroup->location_id=$location->id;
				$accountingGroup->credit_note_all_row=1;
				$accountingGroup->receipt_ledger=1;
				$accountingGroup->debit_note_all_row=1;
				$this->Locations->AccountingGroups->save($accountingGroup);
				
				$accountingGroup = $this->Locations->AccountingGroups->newEntity();
				$accountingGroup->nature_of_group_id=NULL;
				$accountingGroup->name='Loans & Advances (Asset)';
				$accountingGroup->parent_id=$accountingParentGroup->id;
				$accountingGroup->location_id=$location->id;
				$accountingGroup->credit_note_all_row=1;
				$accountingGroup->receipt_ledger=1;
				$accountingGroup->debit_note_all_row=1;
				$this->Locations->AccountingGroups->save($accountingGroup);
				
				$accountingGroup = $this->Locations->AccountingGroups->newEntity();
				$accountingGroup->nature_of_group_id=NULL;
				$accountingGroup->name='Stock-in-hand';
				$accountingGroup->parent_id=$accountingParentGroup->id;
				$accountingGroup->location_id=$location->id;
				$this->Locations->AccountingGroups->save($accountingGroup);
				
				$accountingGroup = $this->Locations->AccountingGroups->newEntity();
				$accountingGroup->nature_of_group_id=NULL;
				$accountingGroup->name='Sundry Debtors';
				$accountingGroup->parent_id=$accountingParentGroup->id;
				$accountingGroup->customer=1;
				$accountingGroup->sale_invoice_party=1;
				$accountingGroup->credit_note_party=1;
				$accountingGroup->location_id=$location->id;
				$accountingGroup->purchase_voucher_first_ledger=1;
				$accountingGroup->credit_note_all_row=1;
				$accountingGroup->credit_note_first_row=1;
				$accountingGroup->receipt_ledger=1;
				$accountingGroup->debit_note_first_row=1;
				$accountingGroup->debit_note_all_row=1;
				$accountingGroup->sales_voucher_first_ledger=1;
				$this->Locations->AccountingGroups->save($accountingGroup);
				
				$accountingParentGroup=$this->Locations->AccountingGroups->find()->where(['name'=>'Current Liabilities','location_id'=>$location->id])->first();
				$accountingGroup = $this->Locations->AccountingGroups->newEntity();
				$accountingGroup->nature_of_group_id=NULL;
				$accountingGroup->name='Duties & Taxes';
				$accountingGroup->parent_id=$accountingParentGroup->id;
				$accountingGroup->location_id=$location->id;
				$accountingGroup->purchase_voucher_all_ledger=1;
				$accountingGroup->credit_note_all_row=1;
				$accountingGroup->receipt_ledger=1;
				$accountingGroup->debit_note_all_row=1;
				$accountingGroup->sales_voucher_all_ledger=1;
				$this->Locations->AccountingGroups->save($accountingGroup);
				
				$accountingGroup = $this->Locations->AccountingGroups->newEntity();
				$accountingGroup->nature_of_group_id=NULL;
				$accountingGroup->name='Provisions';
				$accountingGroup->parent_id=$accountingParentGroup->id;
				$accountingGroup->location_id=$location->id;
				$accountingGroup->credit_note_all_row=1;
				$accountingGroup->receipt_ledger=1;
				$accountingGroup->debit_note_all_row=1;
				$this->Locations->AccountingGroups->save($accountingGroup);
				
				$accountingGroup = $this->Locations->AccountingGroups->newEntity();
				$accountingGroup->nature_of_group_id=NULL;
				$accountingGroup->name='Sundry Creditors';
				$accountingGroup->parent_id=$accountingParentGroup->id;
				$accountingGroup->supplier=1;
				$accountingGroup->location_id=$location->id;
				$accountingGroup->purchase_voucher_party=1;
				$accountingGroup->purchase_voucher_first_ledger=1;
				$accountingGroup->credit_note_all_row=1;
				$accountingGroup->credit_note_first_row=1;
				$accountingGroup->receipt_ledger=1;
				$accountingGroup->debit_note_first_row=1;
				$accountingGroup->debit_note_all_row=1;
				$accountingGroup->sales_voucher_first_ledger=1;
				$this->Locations->AccountingGroups->save($accountingGroup);
				
				$accountingParentGroup=$this->Locations->AccountingGroups->find()->where(['name'=>'Loans (Liability)','location_id'=>$location->id])->first();
				$accountingGroup = $this->Locations->AccountingGroups->newEntity();
				$accountingGroup->nature_of_group_id=NULL;
				$accountingGroup->name='Bank OD A/c';
				$accountingGroup->parent_id=$accountingParentGroup->id;
				$accountingGroup->location_id=$location->id;
				$accountingGroup->purchase_voucher_first_ledger=1;
				$accountingGroup->credit_note_first_row=1;
				$accountingGroup->receipt_ledger=1;
				$accountingGroup->debit_note_first_row=1;
				$accountingGroup->sales_voucher_first_ledger=1;
				$this->Locations->AccountingGroups->save($accountingGroup);
				
				$accountingGroup = $this->Locations->AccountingGroups->newEntity();
				$accountingGroup->nature_of_group_id=NULL;
				$accountingGroup->name='Secured Loans';
				$accountingGroup->parent_id=$accountingParentGroup->id;
				$accountingGroup->location_id=$location->id;
				$accountingGroup->credit_note_all_row=1;
				$accountingGroup->receipt_ledger=1;
				$accountingGroup->debit_note_all_row=1;
				$this->Locations->AccountingGroups->save($accountingGroup);
				
				$accountingGroup = $this->Locations->AccountingGroups->newEntity();
				$accountingGroup->nature_of_group_id=NULL;
				$accountingGroup->name='Unsecured Loans';
				$accountingGroup->parent_id=$accountingParentGroup->id;
				$accountingGroup->location_id=$location->id;
				$accountingGroup->credit_note_all_row=1;
				$accountingGroup->receipt_ledger=1;
				$accountingGroup->debit_note_all_row=1;
				$this->Locations->AccountingGroups->save($accountingGroup);
				
				$accountingParentGroup=$this->Locations->AccountingGroups->find()->where(['name'=>'Duties & Taxes','location_id'=>$location->id])->first();
				$accountingGroup = $this->Locations->AccountingGroups->newEntity();
				$accountingGroup->nature_of_group_id=NULL;
				$accountingGroup->name='Input GST';
				$accountingGroup->parent_id=$accountingParentGroup->id;
				$accountingGroup->location_id=$location->id;
				$this->Locations->AccountingGroups->save($accountingGroup);
				
				$accountingGroup = $this->Locations->AccountingGroups->newEntity();
				$accountingGroup->nature_of_group_id=NULL;
				$accountingGroup->name='Output GST';
				$accountingGroup->parent_id=$accountingParentGroup->id;
				$accountingGroup->location_id=$location->id;
				$this->Locations->AccountingGroups->save($accountingGroup);


				//Financial year entry//
				//$financialY=date('Y', strtotime($location->financial_year_begins_from));
				$financialY=date('Y', strtotime($location->books_beginning_from));
				$financialY=$financialY+1;
				$FYendDate=$financialY.'-3-31';
				
				$financialYear = $this->Locations->FinancialYears->newEntity();
				$financialYear->fy_from=date('Y-m-d',strtotime($location->books_beginning_from));
				$financialYear->fy_to=$FYendDate;
				$financialYear->status='open';
				$financialYear->location_id=$location->id;
				$this->Locations->FinancialYears->save($financialYear);
				
				//gst figure add
				$GstFigureDetails=[
					['name'=>'0%',  'tax_percentage'=>0],
					['name'=>'5%',  'tax_percentage'=>5],
					['name'=>'12%', 'tax_percentage'=>12],
					['name'=>'18%', 'tax_percentage'=>18],
					['name'=>'28%', 'tax_percentage'=>28],
				];
				
				$gstFigureId=[];
				foreach($GstFigureDetails as $GstFigureDetail)
				{ 
					$GstFigure = $this->Locations->GstFigures->newEntity();
					$GstFigure->name           = $GstFigureDetail['name'];
					$GstFigure->location_id     = $location->id;
					$GstFigure->tax_percentage = $GstFigureDetail['tax_percentage'];
					$this->Locations->GstFigures->save($GstFigure);
					$gstFigureId[] =$GstFigure->id;
				}

				//gst figure ledger entry//
				$gstInput = $this->Locations->AccountingGroups->find()->where(['name'=>'Input GST','location_id'=>$location->id])->first();
				$gstOutput = $this->Locations->AccountingGroups->find()->where(['name'=>'Output GST','location_id'=>$location->id])->first();
				$round_off_id = $this->Locations->AccountingGroups->find()->where(['name'=>'Indirect Expenses','location_id'=>$location->id])->first();
				$cash_id = $this->Locations->AccountingGroups->find()->where(['name'=>'Cash-in-hand','location_id'=>$location->id])->first();
				$gstLedgerEntrys=[
					['name'=>'0% CGST (input)', 'accounting_group_id'=>$gstInput->id,'location_id'=>$location->id,'bill_to_bill_accounting'=>'no','gst_figure_id'=>$gstFigureId[0],'tax_percentage'=>0,'input_output'=>'input','gst_type'=>'CGST','round_off'=>0,'cash'=>0,'flag'=>1],
					['name'=>'0% SGST (input)', 'accounting_group_id'=>$gstInput->id,'location_id'=>$location->id,'bill_to_bill_accounting'=>'no','gst_figure_id'=>$gstFigureId[0],'tax_percentage'=>0,'input_output'=>'input','gst_type'=>'SGST','round_off'=>0,'cash'=>0,'flag'=>1],
					['name'=>'0% IGST (input)', 'accounting_group_id'=>$gstInput->id,'location_id'=>$location->id,'bill_to_bill_accounting'=>'no','gst_figure_id'=>$gstFigureId[0],'tax_percentage'=>0,'input_output'=>'input','gst_type'=>'IGST','round_off'=>0,'cash'=>0,'flag'=>1],
					['name'=>'0% CGST (output)', 'accounting_group_id'=>$gstOutput->id,'location_id'=>$location->id,'bill_to_bill_accounting'=>'no','gst_figure_id'=>$gstFigureId[0],'tax_percentage'=>0,'input_output'=>'output','gst_type'=>'CGST','round_off'=>0,'cash'=>0,'flag'=>1],
					['name'=>'0% SGST (output)', 'accounting_group_id'=>$gstOutput->id,'location_id'=>$location->id,'bill_to_bill_accounting'=>'no','gst_figure_id'=>$gstFigureId[0],'tax_percentage'=>0,'input_output'=>'output','gst_type'=>'SGST','round_off'=>0,'cash'=>0,'flag'=>1],
					['name'=>'0% IGST (output)', 'accounting_group_id'=>$gstOutput->id,'location_id'=>$location->id,'bill_to_bill_accounting'=>'no','gst_figure_id'=>$gstFigureId[0],'tax_percentage'=>0,'input_output'=>'output','gst_type'=>'IGST','round_off'=>0,'cash'=>0,'flag'=>1],
					['name'=>'2.5% CGST (input)', 'accounting_group_id'=>$gstInput->id,'location_id'=>$location->id,'bill_to_bill_accounting'=>'no','gst_figure_id'=>$gstFigureId[1],'tax_percentage'=>0,'input_output'=>'input','gst_type'=>'CGST','round_off'=>0,'cash'=>0,'flag'=>1],
					['name'=>'2.5% SGST (input)', 'accounting_group_id'=>$gstInput->id,'location_id'=>$location->id,'bill_to_bill_accounting'=>'no','gst_figure_id'=>$gstFigureId[1],'tax_percentage'=>0,'input_output'=>'input','gst_type'=>'SGST','round_off'=>0,'cash'=>0,'flag'=>1],
					['name'=>'5% IGST (input)', 'accounting_group_id'=>$gstInput->id,'location_id'=>$location->id,'bill_to_bill_accounting'=>'no','gst_figure_id'=>$gstFigureId[1],'tax_percentage'=>0,'input_output'=>'input','gst_type'=>'IGST','round_off'=>0,'cash'=>0,'flag'=>1],
					['name'=>'2.5% CGST (output)', 'accounting_group_id'=>$gstOutput->id,'location_id'=>$location->id,'bill_to_bill_accounting'=>'no','gst_figure_id'=>$gstFigureId[1],'tax_percentage'=>0,'input_output'=>'output','gst_type'=>'CGST','round_off'=>0,'cash'=>0,'flag'=>1],
					['name'=>'2.5% SGST (output)', 'accounting_group_id'=>$gstOutput->id,'location_id'=>$location->id,'bill_to_bill_accounting'=>'no','gst_figure_id'=>$gstFigureId[1],'tax_percentage'=>0,'input_output'=>'output','gst_type'=>'SGST','round_off'=>0,'cash'=>0,'flag'=>1],
					['name'=>'5% IGST (output)', 'accounting_group_id'=>$gstOutput->id,'location_id'=>$location->id,'bill_to_bill_accounting'=>'no','gst_figure_id'=>$gstFigureId[1],'tax_percentage'=>0,'input_output'=>'output','gst_type'=>'IGST','round_off'=>0,'cash'=>0,'flag'=>1],
					['name'=>'6% CGST (input)', 'accounting_group_id'=>$gstInput->id,'location_id'=>$location->id,'bill_to_bill_accounting'=>'no','gst_figure_id'=>$gstFigureId[2],'tax_percentage'=>0,'input_output'=>'input','gst_type'=>'CGST','round_off'=>0,'cash'=>0,'flag'=>1],
					['name'=>'6% SGST (input)', 'accounting_group_id'=>$gstInput->id,'location_id'=>$location->id,'bill_to_bill_accounting'=>'no','gst_figure_id'=>$gstFigureId[2],'tax_percentage'=>0,'input_output'=>'input','gst_type'=>'SGST','round_off'=>0,'cash'=>0,'flag'=>1],
					['name'=>'12% IGST (input)', 'accounting_group_id'=>$gstInput->id,'location_id'=>$location->id,'bill_to_bill_accounting'=>'no','gst_figure_id'=>$gstFigureId[2],'tax_percentage'=>0,'input_output'=>'input','gst_type'=>'IGST','round_off'=>0,'cash'=>0,'flag'=>1],
					['name'=>'6% CGST (output)', 'accounting_group_id'=>$gstOutput->id,'location_id'=>$location->id,'bill_to_bill_accounting'=>'no','gst_figure_id'=>$gstFigureId[2],'tax_percentage'=>0,'input_output'=>'output','gst_type'=>'CGST','round_off'=>0,'cash'=>0,'flag'=>1],
					['name'=>'6% SGST (output)', 'accounting_group_id'=>$gstOutput->id,'location_id'=>$location->id,'bill_to_bill_accounting'=>'no','gst_figure_id'=>$gstFigureId[2],'tax_percentage'=>0,'input_output'=>'output','gst_type'=>'SGST','round_off'=>0,'cash'=>0,'flag'=>1],
					['name'=>'12% IGST (output)', 'accounting_group_id'=>$gstOutput->id,'location_id'=>$location->id,'bill_to_bill_accounting'=>'no','gst_figure_id'=>$gstFigureId[2],'tax_percentage'=>0,'input_output'=>'output','gst_type'=>'IGST','round_off'=>0,'cash'=>0,'flag'=>1],
					['name'=>'9% CGST (input)', 'accounting_group_id'=>$gstInput->id,'location_id'=>$location->id,'bill_to_bill_accounting'=>'no','gst_figure_id'=>$gstFigureId[3],'tax_percentage'=>0,'input_output'=>'input','gst_type'=>'CGST','round_off'=>0,'cash'=>0,'flag'=>1],
					['name'=>'9% SGST (input)', 'accounting_group_id'=>$gstInput->id,'location_id'=>$location->id,'bill_to_bill_accounting'=>'no','gst_figure_id'=>$gstFigureId[3],'tax_percentage'=>0,'input_output'=>'input','gst_type'=>'SGST','round_off'=>0,'cash'=>0,'flag'=>1],
					['name'=>'18% IGST (input)', 'accounting_group_id'=>$gstInput->id,'location_id'=>$location->id,'bill_to_bill_accounting'=>'no','gst_figure_id'=>$gstFigureId[3],'tax_percentage'=>0,'input_output'=>'input','gst_type'=>'IGST','round_off'=>0,'cash'=>0,'flag'=>1],
					['name'=>'9% CGST (output)', 'accounting_group_id'=>$gstOutput->id,'location_id'=>$location->id,'bill_to_bill_accounting'=>'no','gst_figure_id'=>$gstFigureId[3],'tax_percentage'=>0,'input_output'=>'output','gst_type'=>'CGST','round_off'=>0,'cash'=>0,'flag'=>1],
					['name'=>'9% SGST (output)', 'accounting_group_id'=>$gstOutput->id,'location_id'=>$location->id,'bill_to_bill_accounting'=>'no','gst_figure_id'=>$gstFigureId[3],'tax_percentage'=>0,'input_output'=>'output','gst_type'=>'SGST','round_off'=>0,'cash'=>0,'flag'=>1],
					['name'=>'18% IGST (output)', 'accounting_group_id'=>$gstOutput->id,'location_id'=>$location->id,'bill_to_bill_accounting'=>'no','gst_figure_id'=>$gstFigureId[3],'tax_percentage'=>0,'input_output'=>'output','gst_type'=>'IGST','round_off'=>0,'cash'=>0,'flag'=>1],
					['name'=>'14% CGST (input)', 'accounting_group_id'=>$gstInput->id,'location_id'=>$location->id,'bill_to_bill_accounting'=>'no','gst_figure_id'=>$gstFigureId[4],'tax_percentage'=>0,'input_output'=>'input','gst_type'=>'CGST','round_off'=>0,'cash'=>0,'flag'=>1],
					['name'=>'14% SGST (input)', 'accounting_group_id'=>$gstInput->id,'location_id'=>$location->id,'bill_to_bill_accounting'=>'no','gst_figure_id'=>$gstFigureId[4],'tax_percentage'=>0,'input_output'=>'input','gst_type'=>'SGST','round_off'=>0,'cash'=>0,'flag'=>1],
					['name'=>'28% IGST (input)', 'accounting_group_id'=>$gstInput->id,'location_id'=>$location->id,'bill_to_bill_accounting'=>'no','gst_figure_id'=>$gstFigureId[4],'tax_percentage'=>0,'input_output'=>'input','gst_type'=>'IGST','round_off'=>0,'cash'=>0,'flag'=>1],
					['name'=>'14% CGST (output)', 'accounting_group_id'=>$gstOutput->id,'location_id'=>$location->id,'bill_to_bill_accounting'=>'no','gst_figure_id'=>$gstFigureId[4],'tax_percentage'=>0,'input_output'=>'output','gst_type'=>'CGST','round_off'=>0,'cash'=>0,'flag'=>1],
					['name'=>'14% SGST (output)', 'accounting_group_id'=>$gstOutput->id,'location_id'=>$location->id,'bill_to_bill_accounting'=>'no','gst_figure_id'=>$gstFigureId[4],'tax_percentage'=>0,'input_output'=>'output','gst_type'=>'SGST','round_off'=>0,'cash'=>0,'flag'=>1],
					['name'=>'28% IGST (output)', 'accounting_group_id'=>$gstOutput->id,'location_id'=>$location->id,'bill_to_bill_accounting'=>'no','gst_figure_id'=>$gstFigureId[4],'tax_percentage'=>0,'input_output'=>'output','gst_type'=>'IGST','round_off'=>0,'cash'=>0,'flag'=>1],
					['name'=>'Round off', 'accounting_group_id'=>$round_off_id->id,'location_id'=>$location->id,'bill_to_bill_accounting'=>'no','gst_figure_id'=>null,'tax_percentage'=>0,'input_output'=>null,'gst_type'=>null,'round_off'=>1,'cash'=>0,'flag'=>1],
					['name'=>'Cash', 'accounting_group_id'=>$cash_id->id,'location_id'=>$location->id,'bill_to_bill_accounting'=>'no','gst_figure_id'=>null,'tax_percentage'=>0,'input_output'=>null,'gst_type'=>null,'round_off'=>0,'cash'=>1,'flag'=>1]
				];

				foreach($gstLedgerEntrys as $gstLedgerEntry)
				{
					$Ledgers = $this->Locations->Sellers->Ledgers->newEntity();
					$Ledgers->name                    = $gstLedgerEntry['name'];
					$Ledgers->accounting_group_id     = $gstLedgerEntry['accounting_group_id'];
					$Ledgers->location_id              = $location->id;
					$Ledgers->bill_to_bill_accounting = $gstLedgerEntry['bill_to_bill_accounting'];
					$Ledgers->gst_figure_id           = $gstLedgerEntry['gst_figure_id'];
					$Ledgers->tax_percentage          = $gstLedgerEntry['tax_percentage'];
					$Ledgers->input_output            = $gstLedgerEntry['input_output'];
					$Ledgers->gst_type                = $gstLedgerEntry['gst_type'];
					$Ledgers->round_off               = $gstLedgerEntry['round_off'];
					$Ledgers->cash                    = $gstLedgerEntry['cash'];
					$Ledgers->flag					  = $gstLedgerEntry['flag'];
					$this->Locations->Sellers->Ledgers->save($Ledgers);
				}

				//pr($StatutoryInfos); exit;
				//End 
				$seller = $this->Locations->Sellers->newEntity(); 
				$seller = $this->Locations->Sellers->patchEntity($seller, $this->request->getData());
				$seller->location_id=$location->id;
				$seller->city_id=$location->city_id;
				$seller->name=$this->request->getData('seller_name');
				$seller->status=$this->request->getData('seller_status');

				if($this->Locations->Sellers->save($seller))
				{
					$bill_to_bill_accounting=$seller->bill_to_bill_accounting;
					$accounting_group = $this->Locations->Sellers->Ledgers->AccountingGroups->find()->where(['seller'=>1])->first();
					$ledger = $this->Locations->Sellers->Ledgers->newEntity();
					$ledger->name = $seller->firm_name;
					$ledger->accounting_group_id = $accounting_group->id;
					$ledger->seller_id=$seller->id;
					$ledger->bill_to_bill_accounting=$bill_to_bill_accounting;
					
					if($this->Locations->Sellers->Ledgers->save($ledger))
					{
						$query=$this->Locations->Sellers->ReferenceDetails->query();
							$result = $query->update()
							->set(['ledger_id' => $ledger->id])
							->where(['seller_id' => $seller->id])
							->execute();
						//Create Accounting Entry//
				        $transaction_date=$location->books_beginning_from;
						$AccountingEntry = $this->Locations->Sellers->Ledgers->AccountingEntries->newEntity();
						$AccountingEntry->ledger_id        = $ledger->id;
						if($seller->debit_credit=="Dr")
						{
							$AccountingEntry->debit        = $seller->opening_balance_value;
						}
						if($seller->debit_credit=="Cr")
						{
							$AccountingEntry->credit       = $seller->opening_balance_value;
						}
						$AccountingEntry->transaction_date = date("Y-m-d",strtotime($transaction_date));
						$AccountingEntry->location_id       = $location_id;
						$AccountingEntry->city_id       = $city_id;
						$AccountingEntry->is_opening_balance = 'yes';
						if($seller->opening_balance_value){
						$this->Locations->Sellers->Ledgers->AccountingEntries->save($AccountingEntry);
						}
					}
				}
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The location could not be saved. Please, try again.'));
        }
        $cities = $this->Locations->Cities->find('list', ['limit' => 200]);
        $this->set(compact('location', 'cities'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Location id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
       $city_id=$this->Auth->User('city_id');
		$user_id=$this->Auth->User('id');
		$this->viewBuilder()->layout('admin_portal');
        $this->paginate = [
            'limit' => 20
        ];
		
		if($id)
		{
		   $id = $this->EncryptingDecrypting->decryptData($id);
		}
		
        $locations =$this->Locations->find()->where(['Locations.city_id'=>$city_id]);
		if($id)
		{
			$location = $this->Locations->get($id);
		}
		else{
			$location = $this->Locations->newEntity();
		}
		
		if ($this->request->is(['post','put'])) {
			 
			
            $location = $this->Locations->patchEntity($location, $this->request->getData());
			 

			$location->city_id=$city_id;
			$location->created_by=$user_id;
            if ($location_data=$this->Locations->save($location)) {
				
				$data = $this->Locations->Sellers->newEntity();
				
				$data->location_id=$location_data->id;
				$data->city_id=$location_data->city_id;
				$data->name=$location_data->name;
				$data->latitude=$location_data->latitude;
				$data->longitude=$location_data->longitude;
				
				$this->Locations->Sellers->save($data);
				 
			 
                $this->Flash->success(__('The banner has been saved.'));
 
                    return $this->redirect(['action' => 'index']);
                
            }
            $this->Flash->error(__('The banner could not be saved. Please, try again.'));
        }
		 
		
		
		$locations = $this->paginate($locations);
		$paginate_limit=$this->paginate['limit'];
        $this->set(compact('locations','location','paginate_limit'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Location id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($dir)
    {
        $this->request->allowMethod(['post', 'delete']);
		$id = $this->EncryptingDecrypting->decryptData($dir);
        $location = $this->Locations->get($id);
        if ($this->Locations->delete($location)) {
            $this->Flash->success(__('The location has been deleted.'));
        } else {
            $this->Flash->error(__('The location could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
