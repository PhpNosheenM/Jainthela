<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\View\View;
/**
 * Cities Controller
 *
 * @property \App\Model\Table\CitiesTable $Cities
 *
 * @method \App\Model\Entity\City[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CitiesController extends AppController
{
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
   
    public function index($ids = null)
    {
		$user_id=$this->Auth->User('id');
		$this->viewBuilder()->layout('super_admin_layout');
		 $this->paginate = [
            'contain' => ['States'],
			'limit' =>20
        ];
		if($ids)
		{
		   $id = $this->EncryptingDecrypting->decryptData($ids);
		}
		
		$cities = $this->Cities->find();
        if($ids)
		{
		    $city = $this->Cities->get($id);
		}
		else
		{
			 $city = $this->Cities->newEntity();
		}

        if ($this->request->is(['post','put'])) {
            $city = $this->Cities->patchEntity($city, $this->request->getData());
			$city->created_by=$user_id;
			if($id)
			{
				$city->id=$id;
			}
			
			if ($this->Cities->save($city)) {
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
					$accountingGroup = $this->Cities->AccountingGroups->newEntity();
					$accountingGroup->nature_of_group_id=$StatutoryInfo['nature_of_group_id'];
					$accountingGroup->name=$StatutoryInfo['name'];
					$accountingGroup->parent_id=$StatutoryInfo['parent_id'];
					$accountingGroup->city_id=$city->id;
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
						$accountingGroup->purchase_invoice_purchase_account=1;
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
					$this->Cities->AccountingGroups->save($accountingGroup);
				}
				
				$accountingParentGroup=$this->Cities->AccountingGroups->find()->where(['name'=>'Capital Account','city_id'=>$city->id])->first();
				$accountingGroup = $this->Cities->AccountingGroups->newEntity();
				$accountingGroup->nature_of_group_id=NULL;
				$accountingGroup->name='Reserves & Surplus';
				$accountingGroup->parent_id=$accountingParentGroup->id;
				$accountingGroup->city_id=$city->id;
				$accountingGroup->credit_note_all_row=1;
				$accountingGroup->receipt_ledger=1;
				$accountingGroup->debit_note_all_row=1;
				$this->Cities->AccountingGroups->save($accountingGroup);
				
				$accountingParentGroup=$this->Cities->AccountingGroups->find()->where(['name'=>'Current Assets','city_id'=>$city->id])->first();
				$accountingGroup = $this->Cities->AccountingGroups->newEntity();
				$accountingGroup->nature_of_group_id=NULL;
				$accountingGroup->name='Bank Accounts';
				$accountingGroup->parent_id=$accountingParentGroup->id;
				$accountingGroup->city_id=$city->id;
				$accountingGroup->purchase_voucher_first_ledger=1;
				$accountingGroup->credit_note_first_row=1;
				$accountingGroup->receipt_ledger=1;
				$accountingGroup->debit_note_first_row=1;
				$accountingGroup->sales_voucher_first_ledger=1;
				$accountingGroup->bank=1;
				$this->Cities->AccountingGroups->save($accountingGroup);
				
				$accountingGroup = $this->Cities->AccountingGroups->newEntity();
				$accountingGroup->nature_of_group_id=NULL;
				$accountingGroup->name='Cash-in-hand';
				$accountingGroup->parent_id=$accountingParentGroup->id;
				$accountingGroup->city_id=$city->id;
				$accountingGroup->purchase_voucher_party=1;
				$accountingGroup->sale_invoice_party=1;
				$accountingGroup->credit_note_first_row=1;
				$accountingGroup->receipt_ledger=1;
				$accountingGroup->purchase_voucher_first_ledger=1;
				$accountingGroup->debit_note_first_row=1;
				$accountingGroup->sales_voucher_first_ledger=1;
				$this->Cities->AccountingGroups->save($accountingGroup);
				
				$accountingGroup = $this->Cities->AccountingGroups->newEntity();
				$accountingGroup->nature_of_group_id=NULL;
				$accountingGroup->name='Deposits (Asset)';
				$accountingGroup->parent_id=$accountingParentGroup->id;
				$accountingGroup->city_id=$city->id;
				$accountingGroup->credit_note_all_row=1;
				$accountingGroup->receipt_ledger=1;
				$accountingGroup->debit_note_all_row=1;
				$this->Cities->AccountingGroups->save($accountingGroup);
				
				$accountingGroup = $this->Cities->AccountingGroups->newEntity();
				$accountingGroup->nature_of_group_id=NULL;
				$accountingGroup->name='Loans & Advances (Asset)';
				$accountingGroup->parent_id=$accountingParentGroup->id;
				$accountingGroup->city_id=$city->id;
				$accountingGroup->credit_note_all_row=1;
				$accountingGroup->receipt_ledger=1;
				$accountingGroup->debit_note_all_row=1;
				$this->Cities->AccountingGroups->save($accountingGroup);
				
				$accountingGroup = $this->Cities->AccountingGroups->newEntity();
				$accountingGroup->nature_of_group_id=NULL;
				$accountingGroup->name='Stock-in-hand';
				$accountingGroup->parent_id=$accountingParentGroup->id;
				$accountingGroup->city_id=$city->id;
				$this->Cities->AccountingGroups->save($accountingGroup);
				
				$accountingGroup = $this->Cities->AccountingGroups->newEntity();
				$accountingGroup->nature_of_group_id=NULL;
				$accountingGroup->name='Sundry Debtors';
				$accountingGroup->parent_id=$accountingParentGroup->id;
				$accountingGroup->customer=1;
				$accountingGroup->sale_invoice_party=1;
				$accountingGroup->credit_note_party=1;
				$accountingGroup->city_id=$city->id;
				$accountingGroup->purchase_voucher_first_ledger=1;
				$accountingGroup->credit_note_all_row=1;
				$accountingGroup->credit_note_first_row=1;
				$accountingGroup->receipt_ledger=1;
				$accountingGroup->debit_note_first_row=1;
				$accountingGroup->debit_note_all_row=1;
				$accountingGroup->sales_voucher_first_ledger=1;
				$this->Cities->AccountingGroups->save($accountingGroup);
				
				$accountingParentGroup=$this->Cities->AccountingGroups->find()->where(['name'=>'Current Liabilities','city_id'=>$city->id])->first();
				$accountingGroup = $this->Cities->AccountingGroups->newEntity();
				$accountingGroup->nature_of_group_id=NULL;
				$accountingGroup->name='Duties & Taxes';
				$accountingGroup->parent_id=$accountingParentGroup->id;
				$accountingGroup->city_id=$city->id;
				$accountingGroup->purchase_voucher_all_ledger=1;
				$accountingGroup->credit_note_all_row=1;
				$accountingGroup->receipt_ledger=1;
				$accountingGroup->debit_note_all_row=1;
				$accountingGroup->sales_voucher_all_ledger=1;
				$this->Cities->AccountingGroups->save($accountingGroup);
				
				$accountingGroup = $this->Cities->AccountingGroups->newEntity();
				$accountingGroup->nature_of_group_id=NULL;
				$accountingGroup->name='Provisions';
				$accountingGroup->parent_id=$accountingParentGroup->id;
				$accountingGroup->city_id=$city->id;
				$accountingGroup->credit_note_all_row=1;
				$accountingGroup->receipt_ledger=1;
				$accountingGroup->debit_note_all_row=1;
				$this->Cities->AccountingGroups->save($accountingGroup);
				
				$accountingGroup = $this->Cities->AccountingGroups->newEntity();
				$accountingGroup->nature_of_group_id=NULL;
				$accountingGroup->name='Sundry Creditors';
				$accountingGroup->parent_id=$accountingParentGroup->id;
				$accountingGroup->supplier=1;
				$accountingGroup->city_id=$city->id;
				$accountingGroup->purchase_voucher_party=1;
				$accountingGroup->payment_ledger=1;
				$accountingGroup->purchase_invoice_party=1;
				$accountingGroup->purchase_voucher_first_ledger=1;
				$accountingGroup->credit_note_all_row=1;
				$accountingGroup->credit_note_first_row=1;
				$accountingGroup->receipt_ledger=1;
				$accountingGroup->debit_note_first_row=1;
				$accountingGroup->debit_note_all_row=1;
				$accountingGroup->sales_voucher_first_ledger=1;
				$this->Cities->AccountingGroups->save($accountingGroup);
				
				$accountingParentGroup=$this->Cities->AccountingGroups->find()->where(['name'=>'Loans (Liability)','city_id'=>$city->id])->first();
				$accountingGroup = $this->Cities->AccountingGroups->newEntity();
				$accountingGroup->nature_of_group_id=NULL;
				$accountingGroup->name='Bank OD A/c';
				$accountingGroup->parent_id=$accountingParentGroup->id;
				$accountingGroup->city_id=$city->id;
				$accountingGroup->purchase_voucher_first_ledger=1;
				$accountingGroup->credit_note_first_row=1;
				$accountingGroup->receipt_ledger=1;
				$accountingGroup->debit_note_first_row=1;
				$accountingGroup->sales_voucher_first_ledger=1;
				$this->Cities->AccountingGroups->save($accountingGroup);
				
				$accountingGroup = $this->Cities->AccountingGroups->newEntity();
				$accountingGroup->nature_of_group_id=NULL;
				$accountingGroup->name='Secured Loans';
				$accountingGroup->parent_id=$accountingParentGroup->id;
				$accountingGroup->city_id=$city->id;
				$accountingGroup->credit_note_all_row=1;
				$accountingGroup->receipt_ledger=1;
				$accountingGroup->debit_note_all_row=1;
				$this->Cities->AccountingGroups->save($accountingGroup);
				
				$accountingGroup = $this->Cities->AccountingGroups->newEntity();
				$accountingGroup->nature_of_group_id=NULL;
				$accountingGroup->name='Unsecured Loans';
				$accountingGroup->parent_id=$accountingParentGroup->id;
				$accountingGroup->city_id=$city->id;
				$accountingGroup->credit_note_all_row=1;
				$accountingGroup->receipt_ledger=1;
				$accountingGroup->debit_note_all_row=1;
				$this->Cities->AccountingGroups->save($accountingGroup);
				
				$accountingParentGroup=$this->Cities->AccountingGroups->find()->where(['name'=>'Duties & Taxes','city_id'=>$city->id])->first();
				$accountingGroup = $this->Cities->AccountingGroups->newEntity();
				$accountingGroup->nature_of_group_id=NULL;
				$accountingGroup->name='Input GST';
				$accountingGroup->parent_id=$accountingParentGroup->id;
				$accountingGroup->city_id=$city->id;
				$accountingGroup->input_output_gst="Input";
				$this->Cities->AccountingGroups->save($accountingGroup);
				
				$accountingGroup = $this->Cities->AccountingGroups->newEntity();
				$accountingGroup->nature_of_group_id=NULL;
				$accountingGroup->name='Output GST';
				$accountingGroup->parent_id=$accountingParentGroup->id;
				$accountingGroup->city_id=$city->id;
				$accountingGroup->input_output_gst="Output";
				$this->Cities->AccountingGroups->save($accountingGroup);

				$financialY=date('Y', strtotime($city->books_beginning_from));
				$financialY=$financialY+1;
				$FYendDate=$financialY.'-3-31';
				
				$financialYear = $this->Cities->FinancialYears->newEntity();
				$financialYear->fy_from=date('Y-m-d',strtotime($city->books_beginning_from));
				$financialYear->fy_to=$FYendDate;
				$financialYear->status='open';
				$financialYear->city_id=$city->id;
				$this->Cities->FinancialYears->save($financialYear);
				

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
					$GstFigure = $this->Cities->GstFigures->newEntity();
					$GstFigure->name           = $GstFigureDetail['name'];
					$GstFigure->city_id     = $city->id;
					$GstFigure->tax_percentage = $GstFigureDetail['tax_percentage'];
					$this->Cities->GstFigures->save($GstFigure); 
					$gstFigureId[] =$GstFigure->id;
				}
				$gstInput = $this->Cities->AccountingGroups->find()->where(['name'=>'Input GST','city_id'=>$city->id])->first();
				$gstOutput = $this->Cities->AccountingGroups->find()->where(['name'=>'Output GST','city_id'=>$city->id])->first();
				$round_off_id = $this->Cities->AccountingGroups->find()->where(['name'=>'Indirect Expenses','city_id'=>$city->id])->first();
				$cash_id = $this->Cities->AccountingGroups->find()->where(['name'=>'Cash-in-hand','city_id'=>$city->id])->first();
				$bank_acc_id = $this->Cities->AccountingGroups->find()->where(['name'=>'Bank Accounts','city_id'=>$city->id])->first();
				$cur_assets_id = $this->Cities->AccountingGroups->find()->where(['name'=>'Current Assets','city_id'=>$city->id])->first();
				$dis_allowed = $this->Cities->AccountingGroups->find()->where(['name'=>'Indirect Expenses','city_id'=>$city->id])->first();
				$dis_rec = $this->Cities->AccountingGroups->find()->where(['name'=>'Indirect Incomes','city_id'=>$city->id])->first();
				$trans_paid = $this->Cities->AccountingGroups->find()->where(['name'=>'Direct Expenses','city_id'=>$city->id])->first();
				$trans_rec = $this->Cities->AccountingGroups->find()->where(['name'=>'Direct Incomes','city_id'=>$city->id])->first();
				$sale_acc = $this->Cities->AccountingGroups->find()->where(['name'=>'Sales Accounts','city_id'=>$city->id])->first();
				$pur_acc = $this->Cities->AccountingGroups->find()->where(['name'=>'Purchase Accounts','city_id'=>$city->id])->first();
				//pr($gstFigureId); exit;

				$gstLedgerEntrys=[
					['name'=>'0% CGST (input)', 'accounting_group_id'=>$gstInput->id,'city_id'=>$city->id,'bill_to_bill_accounting'=>'no','gst_figure_id'=>$gstFigureId[0],'tax_percentage'=>0,'input_output'=>'input','gst_type'=>'CGST','round_off'=>0,'cash'=>0,'flag'=>1,'ccavenue'=>'no','tds_account'=>'no','ccavenue_charges'=>'no','discount'=>null,'transport'=>null],
					['name'=>'0% SGST (input)', 'accounting_group_id'=>$gstInput->id,'city_id'=>$city->id,'bill_to_bill_accounting'=>'no','gst_figure_id'=>$gstFigureId[0],'tax_percentage'=>0,'input_output'=>'input','gst_type'=>'SGST','round_off'=>0,'cash'=>0,'flag'=>1,'ccavenue'=>'no','tds_account'=>'no','ccavenue_charges'=>'no','discount'=>null,'transport'=>null],
					['name'=>'0% IGST (input)', 'accounting_group_id'=>$gstInput->id,'city_id'=>$city->id,'bill_to_bill_accounting'=>'no','gst_figure_id'=>$gstFigureId[0],'tax_percentage'=>0,'input_output'=>'input','gst_type'=>'IGST','round_off'=>0,'cash'=>0,'flag'=>1,'ccavenue'=>'no','tds_account'=>'no','ccavenue_charges'=>'no','discount'=>null,'transport'=>null],
					['name'=>'0% CGST (output)', 'accounting_group_id'=>$gstOutput->id,'city_id'=>$city->id,'bill_to_bill_accounting'=>'no','gst_figure_id'=>$gstFigureId[0],'tax_percentage'=>0,'input_output'=>'output','gst_type'=>'CGST','round_off'=>0,'cash'=>0,'flag'=>1,'ccavenue'=>'no','tds_account'=>'no','ccavenue_charges'=>'no','discount'=>null,'transport'=>null],
					['name'=>'0% SGST (output)', 'accounting_group_id'=>$gstOutput->id,'city_id'=>$city->id,'bill_to_bill_accounting'=>'no','gst_figure_id'=>$gstFigureId[0],'tax_percentage'=>0,'input_output'=>'output','gst_type'=>'SGST','round_off'=>0,'cash'=>0,'flag'=>1,'ccavenue'=>'no','tds_account'=>'no','ccavenue_charges'=>'no','discount'=>null,'transport'=>null],
					['name'=>'0% IGST (output)', 'accounting_group_id'=>$gstOutput->id,'city_id'=>$city->id,'bill_to_bill_accounting'=>'no','gst_figure_id'=>$gstFigureId[0],'tax_percentage'=>0,'input_output'=>'output','gst_type'=>'IGST','round_off'=>0,'cash'=>0,'flag'=>1,'ccavenue'=>'no','tds_account'=>'no','ccavenue_charges'=>'no','discount'=>null,'transport'=>null],
					['name'=>'2.5% CGST (input)', 'accounting_group_id'=>$gstInput->id,'city_id'=>$city->id,'bill_to_bill_accounting'=>'no','gst_figure_id'=>$gstFigureId[1],'tax_percentage'=>0,'input_output'=>'input','gst_type'=>'CGST','round_off'=>0,'cash'=>0,'flag'=>1,'ccavenue'=>'no','tds_account'=>'no','ccavenue_charges'=>'no','discount'=>null,'transport'=>null],
					['name'=>'2.5% SGST (input)', 'accounting_group_id'=>$gstInput->id,'city_id'=>$city->id,'bill_to_bill_accounting'=>'no','gst_figure_id'=>$gstFigureId[1],'tax_percentage'=>0,'input_output'=>'input','gst_type'=>'SGST','round_off'=>0,'cash'=>0,'flag'=>1,'ccavenue'=>'no','tds_account'=>'no','ccavenue_charges'=>'no','discount'=>null,'transport'=>null],
					['name'=>'5% IGST (input)', 'accounting_group_id'=>$gstInput->id,'city_id'=>$city->id,'bill_to_bill_accounting'=>'no','gst_figure_id'=>$gstFigureId[1],'tax_percentage'=>0,'input_output'=>'input','gst_type'=>'IGST','round_off'=>0,'cash'=>0,'flag'=>1,'ccavenue'=>'no','tds_account'=>'no','ccavenue_charges'=>'no','discount'=>null,'transport'=>null],
					['name'=>'2.5% CGST (output)', 'accounting_group_id'=>$gstOutput->id,'city_id'=>$city->id,'bill_to_bill_accounting'=>'no','gst_figure_id'=>$gstFigureId[1],'tax_percentage'=>0,'input_output'=>'output','gst_type'=>'CGST','round_off'=>0,'cash'=>0,'flag'=>1,'ccavenue'=>'no','tds_account'=>'no','ccavenue_charges'=>'no','discount'=>null,'transport'=>null],
					['name'=>'2.5% SGST (output)', 'accounting_group_id'=>$gstOutput->id,'city_id'=>$city->id,'bill_to_bill_accounting'=>'no','gst_figure_id'=>$gstFigureId[1],'tax_percentage'=>0,'input_output'=>'output','gst_type'=>'SGST','round_off'=>0,'cash'=>0,'flag'=>1,'ccavenue'=>'no','tds_account'=>'no','ccavenue_charges'=>'no','discount'=>null,'transport'=>null],
					['name'=>'5% IGST (output)', 'accounting_group_id'=>$gstOutput->id,'city_id'=>$city->id,'bill_to_bill_accounting'=>'no','gst_figure_id'=>$gstFigureId[1],'tax_percentage'=>0,'input_output'=>'output','gst_type'=>'IGST','round_off'=>0,'cash'=>0,'flag'=>1,'ccavenue'=>'no','tds_account'=>'no','ccavenue_charges'=>'no','discount'=>null,'transport'=>null],
					['name'=>'6% CGST (input)', 'accounting_group_id'=>$gstInput->id,'city_id'=>$city->id,'bill_to_bill_accounting'=>'no','gst_figure_id'=>$gstFigureId[2],'tax_percentage'=>0,'input_output'=>'input','gst_type'=>'CGST','round_off'=>0,'cash'=>0,'flag'=>1,'ccavenue'=>'no','tds_account'=>'no','ccavenue_charges'=>'no','discount'=>null,'transport'=>null],
					['name'=>'6% SGST (input)', 'accounting_group_id'=>$gstInput->id,'city_id'=>$city->id,'bill_to_bill_accounting'=>'no','gst_figure_id'=>$gstFigureId[2],'tax_percentage'=>0,'input_output'=>'input','gst_type'=>'SGST','round_off'=>0,'cash'=>0,'flag'=>1,'ccavenue'=>'no','tds_account'=>'no','ccavenue_charges'=>'no','discount'=>null,'transport'=>null],
					['name'=>'12% IGST (input)', 'accounting_group_id'=>$gstInput->id,'city_id'=>$city->id,'bill_to_bill_accounting'=>'no','gst_figure_id'=>$gstFigureId[2],'tax_percentage'=>0,'input_output'=>'input','gst_type'=>'IGST','round_off'=>0,'cash'=>0,'flag'=>1,'ccavenue'=>'no','tds_account'=>'no','ccavenue_charges'=>'no','discount'=>null,'transport'=>null],
					['name'=>'6% CGST (output)', 'accounting_group_id'=>$gstOutput->id,'city_id'=>$city->id,'bill_to_bill_accounting'=>'no','gst_figure_id'=>$gstFigureId[2],'tax_percentage'=>0,'input_output'=>'output','gst_type'=>'CGST','round_off'=>0,'cash'=>0,'flag'=>1,'ccavenue'=>'no','tds_account'=>'no','ccavenue_charges'=>'no','discount'=>null,'transport'=>null],
					['name'=>'6% SGST (output)', 'accounting_group_id'=>$gstOutput->id,'city_id'=>$city->id,'bill_to_bill_accounting'=>'no','gst_figure_id'=>$gstFigureId[2],'tax_percentage'=>0,'input_output'=>'output','gst_type'=>'SGST','round_off'=>0,'cash'=>0,'flag'=>1,'ccavenue'=>'no','tds_account'=>'no','ccavenue_charges'=>'no','discount'=>null,'transport'=>null],
					['name'=>'12% IGST (output)', 'accounting_group_id'=>$gstOutput->id,'city_id'=>$city->id,'bill_to_bill_accounting'=>'no','gst_figure_id'=>$gstFigureId[2],'tax_percentage'=>0,'input_output'=>'output','gst_type'=>'IGST','round_off'=>0,'cash'=>0,'flag'=>1,'ccavenue'=>'no','tds_account'=>'no','ccavenue_charges'=>'no','discount'=>null,'transport'=>null],
					['name'=>'9% CGST (input)', 'accounting_group_id'=>$gstInput->id,'city_id'=>$city->id,'bill_to_bill_accounting'=>'no','gst_figure_id'=>$gstFigureId[3],'tax_percentage'=>0,'input_output'=>'input','gst_type'=>'CGST','round_off'=>0,'cash'=>0,'flag'=>1,'ccavenue'=>'no','tds_account'=>'no','ccavenue_charges'=>'no','discount'=>null,'transport'=>null],
					['name'=>'9% SGST (input)', 'accounting_group_id'=>$gstInput->id,'city_id'=>$city->id,'bill_to_bill_accounting'=>'no','gst_figure_id'=>$gstFigureId[3],'tax_percentage'=>0,'input_output'=>'input','gst_type'=>'SGST','round_off'=>0,'cash'=>0,'flag'=>1,'ccavenue'=>'no','tds_account'=>'no','ccavenue_charges'=>'no','discount'=>null,'transport'=>null],
					['name'=>'18% IGST (input)', 'accounting_group_id'=>$gstInput->id,'city_id'=>$city->id,'bill_to_bill_accounting'=>'no','gst_figure_id'=>$gstFigureId[3],'tax_percentage'=>0,'input_output'=>'input','gst_type'=>'IGST','round_off'=>0,'cash'=>0,'flag'=>1,'ccavenue'=>'no','tds_account'=>'no','ccavenue_charges'=>'no','discount'=>null,'transport'=>null],
					['name'=>'9% CGST (output)', 'accounting_group_id'=>$gstOutput->id,'city_id'=>$city->id,'bill_to_bill_accounting'=>'no','gst_figure_id'=>$gstFigureId[3],'tax_percentage'=>0,'input_output'=>'output','gst_type'=>'CGST','round_off'=>0,'cash'=>0,'flag'=>1,'ccavenue'=>'no','tds_account'=>'no','ccavenue_charges'=>'no','discount'=>null,'transport'=>null],
					['name'=>'9% SGST (output)', 'accounting_group_id'=>$gstOutput->id,'city_id'=>$city->id,'bill_to_bill_accounting'=>'no','gst_figure_id'=>$gstFigureId[3],'tax_percentage'=>0,'input_output'=>'output','gst_type'=>'SGST','round_off'=>0,'cash'=>0,'flag'=>1,'ccavenue'=>'no','tds_account'=>'no','ccavenue_charges'=>'no','discount'=>null,'transport'=>null],
					['name'=>'18% IGST (output)', 'accounting_group_id'=>$gstOutput->id,'city_id'=>$city->id,'bill_to_bill_accounting'=>'no','gst_figure_id'=>$gstFigureId[3],'tax_percentage'=>0,'input_output'=>'output','gst_type'=>'IGST','round_off'=>0,'cash'=>0,'flag'=>1,'ccavenue'=>'no','tds_account'=>'no','ccavenue_charges'=>'no','discount'=>null,'transport'=>null],
					['name'=>'14% CGST (input)', 'accounting_group_id'=>$gstInput->id,'city_id'=>$city->id,'bill_to_bill_accounting'=>'no','gst_figure_id'=>$gstFigureId[4],'tax_percentage'=>0,'input_output'=>'input','gst_type'=>'CGST','round_off'=>0,'cash'=>0,'flag'=>1,'ccavenue'=>'no','tds_account'=>'no','ccavenue_charges'=>'no','discount'=>null,'transport'=>null],
					['name'=>'14% SGST (input)', 'accounting_group_id'=>$gstInput->id,'city_id'=>$city->id,'bill_to_bill_accounting'=>'no','gst_figure_id'=>$gstFigureId[4],'tax_percentage'=>0,'input_output'=>'input','gst_type'=>'SGST','round_off'=>0,'cash'=>0,'flag'=>1,'ccavenue'=>'no','tds_account'=>'no','ccavenue_charges'=>'no','discount'=>null,'transport'=>null],
					['name'=>'28% IGST (input)', 'accounting_group_id'=>$gstInput->id,'city_id'=>$city->id,'bill_to_bill_accounting'=>'no','gst_figure_id'=>$gstFigureId[4],'tax_percentage'=>0,'input_output'=>'input','gst_type'=>'IGST','round_off'=>0,'cash'=>0,'flag'=>1,'ccavenue'=>'no','tds_account'=>'no','ccavenue_charges'=>'no','discount'=>null,'transport'=>null],
					['name'=>'14% CGST (output)', 'accounting_group_id'=>$gstOutput->id,'city_id'=>$city->id,'bill_to_bill_accounting'=>'no','gst_figure_id'=>$gstFigureId[4],'tax_percentage'=>0,'input_output'=>'output','gst_type'=>'CGST','round_off'=>0,'cash'=>0,'flag'=>1,'ccavenue'=>'no','tds_account'=>'no','ccavenue_charges'=>'no','discount'=>null,'transport'=>null],
					['name'=>'14% SGST (output)', 'accounting_group_id'=>$gstOutput->id,'city_id'=>$city->id,'bill_to_bill_accounting'=>'no','gst_figure_id'=>$gstFigureId[4],'tax_percentage'=>0,'input_output'=>'output','gst_type'=>'SGST','round_off'=>0,'cash'=>0,'flag'=>1,'ccavenue'=>'no','tds_account'=>'no','ccavenue_charges'=>'no','discount'=>null,'transport'=>null],
					['name'=>'28% IGST (output)', 'accounting_group_id'=>$gstOutput->id,'city_id'=>$city->id,'bill_to_bill_accounting'=>'no','gst_figure_id'=>$gstFigureId[4],'tax_percentage'=>0,'input_output'=>'output','gst_type'=>'IGST','round_off'=>0,'cash'=>0,'flag'=>1,'ccavenue'=>'no','tds_account'=>'no','ccavenue_charges'=>'no','discount'=>null,'transport'=>null],
					['name'=>'Round off', 'accounting_group_id'=>$round_off_id->id,'city_id'=>$city->id,'bill_to_bill_accounting'=>'no','gst_figure_id'=>null,'tax_percentage'=>0,'input_output'=>null,'gst_type'=>null,'round_off'=>1,'cash'=>0,'flag'=>1,'ccavenue'=>'no','tds_account'=>'no','ccavenue_charges'=>'no','discount'=>null,'transport'=>null],
					['name'=>'Cash', 'accounting_group_id'=>$cash_id->id,'city_id'=>$city->id,'bill_to_bill_accounting'=>'no','gst_figure_id'=>null,'tax_percentage'=>0,'input_output'=>null,'gst_type'=>null,'round_off'=>0,'cash'=>1,'flag'=>1,'ccavenue'=>'no','tds_account'=>'no','ccavenue_charges'=>'no','discount'=>null,'transport'=>null],
					['name'=>'ccavenue', 'accounting_group_id'=>$bank_acc_id->id,'city_id'=>$city->id,'bill_to_bill_accounting'=>'yes','gst_figure_id'=>null,'tax_percentage'=>0,'input_output'=>null,'gst_type'=>null,'round_off'=>0,'cash'=>0,'flag'=>1,'ccavenue'=>'yes','tds_account'=>'no','ccavenue_charges'=>'no','discount'=>null,'transport'=>null],
					['name'=>'Tds Account', 'accounting_group_id'=>$cur_assets_id->id,'city_id'=>$city->id,'bill_to_bill_accounting'=>'no','gst_figure_id'=>null,'tax_percentage'=>0,'input_output'=>null,'gst_type'=>null,'round_off'=>0,'cash'=>0,'flag'=>1,'ccavenue'=>'no','ccavenue_charges'=>'no','tds_account'=>'yes','discount'=>'Allowed','transport'=>null],
					['name'=>'CCavenue Charges', 'accounting_group_id'=>$round_off_id->id,'city_id'=>$city->id,'bill_to_bill_accounting'=>'no','gst_figure_id'=>null,'tax_percentage'=>0,'input_output'=>null,'gst_type'=>null,'round_off'=>0,'cash'=>0,'flag'=>1,'ccavenue'=>'no','tds_account'=>'no','ccavenue_charges'=>'yes','discount'=>null,'transport'=>null],
					['name'=>'Discount Allowed', 'accounting_group_id'=>$dis_allowed->id,'city_id'=>$city->id,'bill_to_bill_accounting'=>'no','gst_figure_id'=>null,'tax_percentage'=>0,'input_output'=>null,'gst_type'=>null,'round_off'=>0,'cash'=>0,'flag'=>1,'ccavenue'=>'no','ccavenue_charges'=>'no','tds_account'=>'no','discount'=>'Allowed','transport'=>null],
					['name'=>'Discount Received', 'accounting_group_id'=>$dis_rec->id,'city_id'=>$city->id,'bill_to_bill_accounting'=>'no','gst_figure_id'=>null,'tax_percentage'=>0,'input_output'=>null,'gst_type'=>null,'round_off'=>0,'cash'=>0,'flag'=>1,'ccavenue'=>'no','ccavenue_charges'=>'no','tds_account'=>'no','discount'=>'Received','transport'=>null],
					['name'=>'Transport Receive', 'accounting_group_id'=>$trans_rec->id,'city_id'=>$city->id,'bill_to_bill_accounting'=>'no','gst_figure_id'=>null,'tax_percentage'=>0,'input_output'=>null,'gst_type'=>null,'round_off'=>0,'cash'=>0,'flag'=>1,'ccavenue'=>'no','ccavenue_charges'=>'no','tds_account'=>'no','discount'=>null,'transport'=>'Receive'],
					['name'=>'Transport Paid', 'accounting_group_id'=>$trans_paid->id,'city_id'=>$city->id,'bill_to_bill_accounting'=>'no','gst_figure_id'=>null,'tax_percentage'=>0,'input_output'=>null,'gst_type'=>null,'round_off'=>0,'cash'=>0,'flag'=>1,'ccavenue'=>'no','ccavenue_charges'=>'no','tds_account'=>'no','discount'=>null,'transport'=>'Paid'],
					['name'=>'Sales Accounts', 'accounting_group_id'=>$sale_acc->id,'city_id'=>$city->id,'bill_to_bill_accounting'=>'no','gst_figure_id'=>null,'tax_percentage'=>0,'input_output'=>null,'gst_type'=>null,'round_off'=>0,'cash'=>0,'flag'=>1,'ccavenue'=>'no','ccavenue_charges'=>'no','tds_account'=>'no','discount'=>null,'transport'=>null],
					['name'=>'Purchase Account', 'accounting_group_id'=>$pur_acc->id,'city_id'=>$city->id,'bill_to_bill_accounting'=>'no','gst_figure_id'=>null,'tax_percentage'=>0,'input_output'=>null,'gst_type'=>null,'round_off'=>0,'cash'=>0,'flag'=>1,'ccavenue'=>'no','ccavenue_charges'=>'no','tds_account'=>'no','discount'=>null,'transport'=>null],
				];
			//pr($gstLedgerEntrys->toArray()); exit;

				foreach($gstLedgerEntrys as $gstLedgerEntry)
				{
					$Ledgers = $this->Cities->Sellers->Ledgers->newEntity();
					$Ledgers->name                    = $gstLedgerEntry['name'];
					$Ledgers->accounting_group_id     = $gstLedgerEntry['accounting_group_id'];
					$Ledgers->city_id              = $city->id;
					$Ledgers->bill_to_bill_accounting = $gstLedgerEntry['bill_to_bill_accounting'];
					$Ledgers->gst_figure_id           = $gstLedgerEntry['gst_figure_id'];
					$Ledgers->tax_percentage          = $gstLedgerEntry['tax_percentage'];
					$Ledgers->input_output            = $gstLedgerEntry['input_output'];
					$Ledgers->gst_type                = $gstLedgerEntry['gst_type'];
					$Ledgers->round_off               = $gstLedgerEntry['round_off'];
					$Ledgers->cash                    = $gstLedgerEntry['cash'];
					$Ledgers->flag					  = $gstLedgerEntry['flag'];
					$Ledgers->ccavenue					= @$gstLedgerEntry['ccavenue'];
					$Ledgers->ccavenue_charges					= @$gstLedgerEntry['ccavenue_charges'];
					$Ledgers->tds_account					= @$gstLedgerEntry['tds_account'];
					$Ledgers->discount					= @$gstLedgerEntry['discount'];
					$Ledgers->transport					= @$gstLedgerEntry['transport'];
					$this->Cities->Sellers->Ledgers->save($Ledgers);
				}

		
                $this->Flash->success(__('The city has been saved.'));
				return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The city could not be saved. Please, try again.'));
        }
		else if ($this->request->is(['get'])){
			$search=$this->request->getQuery('search');
			$cities->where([
							'OR' => [
									'States.name LIKE' => $search.'%',
									'Cities.name LIKE' => $search.'%',
									'Cities.status LIKE' => $search.'%'
							]
			]);
		}

        $cities = $this->paginate($cities);
		$states = $this->Cities->States->find('list');
		$paginate_limit=$this->paginate['limit'];
        $this->set(compact('cities','city','states','paginate_limit'));
    }


    /**
     * Delete method
     *
     * @param string|null $id City id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($dir)
    {
        $this->request->allowMethod(['patch', 'post', 'put']);
		$id = $this->EncryptingDecrypting->decryptData($dir);
        $city = $this->Cities->get($id);
		$city->status='Deactive';
        if ($this->Cities->save($city)) {
            $this->Flash->success(__('The city has been deleted.'));
        } else {
            $this->Flash->error(__('The city could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
