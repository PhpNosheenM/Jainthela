<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}
}
</style>
<?php $this->set('title', 'Receipt Voucher'); ?>
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
	<div class="row">
		<div class="col-md-12">
		<?= $this->Form->create($receipt,['id'=>'jvalidate','class'=>'form-horizontal','type'=>'file']) ?>  
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong> Receipt Voucher</strong></h3>
				</div>
			
				<div class="panel-body">    
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="col-md-3 control-label">Voucher No</label>
								<div class="col-md-4">                                            
									<?= $this->Form->control('voucher_no',['class'=>'form-control ','label'=>false,'disable'=>true,'readonly'=>true, 'value'=>$voucher_no]) ?>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="col-md-6 control-label">Transaction Date</label>
								<div class="col-md-4">                                            
									<?= $this->Form->control('transaction_date',['class'=>'form-control datepicker','placeholder'=>'Transaction Date','label'=>false,'type'=>'text','data-date-format' => 'dd-mm-yyyy','value'=>date('d-m-Y')]) ?>
								</div>
							</div>
						</div>
					</div>
					<br/>
					<div class="row">
						<div class="table-responsive">
							<table id="MainTable" class="table table-condensed table-striped" width="100%">
								<thead>
									<tr>
										<td></td>
										<th>Particulars</th>
										<th>Debit</th>
										<th>Credit</th>
										<th width="10%"></th>
									</tr>
								</thead>
								<tbody id='MainTbody' class="tab">
									<tr class="MainTr">
										<td width="10%" valign="top">
											<?php $options['Cr'] = 'Cr'; ?>
											<?= $this->Form->select('cr_dr',$options,['class'=>'form-control input-sm select','label'=>false]) ?>
											<?php unset($options); ?>
										</td>
										<td width="65%" valign="top">
											<?php echo $this->Form->select('ledger_id',$ledgerOptions, ['empty'=>'--Select--','label' => false,'class' => 'form-control input-sm ledger select','required'=>'required', 'data-live-search'=>true]); ?>
											<div class="window" style="margin:auto;"></div>
										</td>
										<td width="10%" valign="top">
											<?php echo $this->Form->input('debit', ['label' => false,'class' => 'form-control input-sm  debitBox rightAligntextClass numberOnly calculate_total','placeholder'=>'Debit','style'=>'display:none;']); ?>
										</td>
										<td width="10%" valign="top">
											<?php echo $this->Form->input('credit', ['label' => false,'class' => 'form-control input-sm creditBox rightAligntextClass numberOnly calculate_total','placeholder'=>'Credit']); ?>	
										</td>
										<td align="center"  width="10%" valign="top">
											<!--<a class="btn btn-danger delete-tr btn-xs" href="#" role="button" style="margin-bottom: 5px;"><i class="fa fa-times"></i></a> -->
										</td>
									</tr>
		
								</tbody>
								<tfoot>
									<tr style="border-top:double;">
										<td colspan="2" valign="top" >	
											<button type="button" class="AddMainRow btn btn-default input-sm"><i class="fa fa-plus"></i> Add row</button>
											<input type="hidden" id="totalBankCash">
										</td>
										<td valign="top"><input type="text" class="form-control input-sm rightAligntextClass noBorder " name="totalMainDr" id="totalMainDr" readonly></td>
										<td valign="top"><input type="text" class="form-control input-sm rightAligntextClass noBorder" name="totalMainCr" id="totalMainCr" readonly></td>
										<td></td>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
					<div class="row">
						<div class="col-md-5">
							<div class="form-group">
								<label>Narration </label>
								<?php echo $this->Form->control('narration',['class'=>'form-control input-sm','label'=>false,'placeholder'=>'Narration','rows'=>'4']); ?>
							</div>
						</div>
					</div>
				</div>
				<div class="panel-footer">
					<center>
						<?= $this->Form->button(__('Submit'),['class'=>'btn btn-primary']) ?>
					</center>
				</div>
			</div>
			<?= $this->Form->end() ?>
		</div>
	</div>                    	
</div>


<table id="sampleMainTable" style="display:none;" width="100%">
	<tbody class="sampleMainTbody">
		<tr class="MainTr">
			
			<td width="10%" valign="top">
			
				<?php $options['Cr'] = 'Cr'; 
					$options['Dr'] = 'Dr';			
				 
				echo $this->Form->select('cr_dr', $options,['label' => false,'class' => 'form-control  input-sm cr_dr','required'=>'required','value'=>'Dr']); ?>
			</td>
			<td width="65%" valign="top">
				<?php echo $this->Form->select('ledger_id',$ledgerOptions, ['empty'=>'--Select--','label' => false,'class' => 'form-control input-sm ledger ','required'=>'required', 'data-live-search'=>true]); ?>
				<div class="window" style="margin:auto;"></div>
			</td>
			<td width="10%" valign="top">
				<?php echo $this->Form->input('debit', ['label' => false,'class' => 'form-control input-sm  debitBox rightAligntextClass numberOnly calculate_total','placeholder'=>'Debit']); ?>
			</td>
			<td width="10%" valign="top">
				<?php echo $this->Form->input('credit', ['label' => false,'class' => 'form-control input-sm creditBox rightAligntextClass numberOnly calculate_total','placeholder'=>'Credit','style'=>'display:none;']); ?>	
			</td>
			<td align="center"  width="10%" valign="top">
				<a class="btn btn-danger delete-tr btn-xs" href="#" role="button" style="margin-bottom: 5px;"><i class="fa fa-times"></i></a>
			</td>
		</tr>
		
	</tbody>
	<tfoot >
		<tr>
			<td colspan="2" >	
				<button type="button" class="add_row btn btn-default input-sm"><i class="fa fa-plus"></i> Add row</button>
			</td>
		</tr>
	</tfoot>
</table>

<?= $this->Html->script('plugins/bootstrap/bootstrap-datepicker.js',['block'=>'jsDatePicker']) ?>
	<?= $this->Html->script('plugins/bootstrap/bootstrap-select.js',['block'=>'jsSelect']) ?>
	<?= $this->Html->script('plugins/jquery-validation/jquery.validate.js',['block'=>'jsValidate']) ?>
<?php
	$kk='<input type="text" class="form-control input-sm ref_name " placeholder="Reference Name">';
	$dd='<input type="text" class="form-control input-sm rightAligntextClass dueDays " placeholder="Due Days">';
	
	$total_input='<input type="text" class="form-control input-sm rightAligntextClass total calculation noBorder" readonly >';
	$total_type='<input type="text" class="form-control input-sm total_type calculation noBorder" readonly >';
	
	 $js="var jvalidate = $('#jvalidate').validate({
		ignore: [],
		rules: {                                            
				
				
			}                                        
		});
	
		$(document).on('click','.AddMainRow',function(){
			addMainRow();
			renameMainRows();
		});
		$(document).on('change','.cr_dr',function(){
				var cr_dr=$(this).val();
				
				if(cr_dr=='Cr'){
					$(this).closest('tr').find('.debitBox').val('');
					$(this).closest('tr').find('.debitBox').hide();
					$(this).closest('tr').find('.creditBox').show();
				}else{
					$(this).closest('tr').find('.creditBox').val('');
					$(this).closest('tr').find('.debitBox').show();
					$(this).closest('tr').find('.creditBox').hide();
				}
				renameMainRows();
			});
		//addMainRow();
		function addMainRow(){
			var tr=$('#sampleMainTable tbody.sampleMainTbody tr.MainTr').clone();
			$('#MainTable tbody#MainTbody').append(tr);
			renameMainRows();
		}
		
		function renameMainRows(){
				var i=0; var main_debit=0; var main_credit=0; var count_bank_cash=0;
				$('#MainTable tbody#MainTbody tr.MainTr').each(function(){
					$(this).attr('row_no',i);
					var cr_dr=$(this).find('td:nth-child(1) select.cr_dr option:selected').val();
					var is_cash_bank=$(this).find('td:nth-child(2) option:selected').attr('bank_and_cash');
					$(this).find('td:nth-child(1) select.cr_dr').attr({name:'receipt_rows['+i+'][cr_dr]',id:'receipt_rows-'+i+'-cr_dr'}).selectpicker();
					$(this).find('td:nth-child(2) select.ledger').attr({name:'receipt_rows['+i+'][ledger_id]',id:'receipt_rows-'+i+'-ledger_id'}).selectpicker();
					$(this).find('td:nth-child(3) input.debitBox').attr({name:'receipt_rows['+i+'][debit]',id:'receipt_rows-'+i+'-debit'});
					$(this).find('td:nth-child(4) input.creditBox').attr({name:'receipt_rows['+i+'][credit]',id:'receipt_rows-'+i+'-credit'});
					
					if(cr_dr=='Dr'){
						$(this).find('td:nth-child(3) input.debitBox').rules('add', 'required');
						$(this).find('td:nth-child(4) input.creditBox').rules('remove', 'required');
						$(this).find('td:nth-child(4) span.help-block-error').remove();
						var debit_amt=parseFloat($(this).find('td:nth-child(3) input.debitBox').val());
						if(!debit_amt){
							debit_amt=0;
						}
						main_debit=round(main_debit+debit_amt, 2);
						if(is_cash_bank=='yes'){
						 count_bank_cash++;
						}
						
					}else{
						$(this).find('td:nth-child(3) input.debitBox').rules('remove', 'required');
						$(this).find('td:nth-child(3) span.help-block-error').remove();
						$(this).find('td:nth-child(4) input.creditBox').rules('add', 'required');
						var credit_amt=parseFloat($(this).find('td:nth-child(4) input.creditBox').val());
						if(!credit_amt){
							credit_amt=0;
						}
						main_credit=round(main_credit+credit_amt, 2);
						
					}
					i++;
					var type=$(this).find('td:nth-child(2) option:selected').attr('open_window'); 
					var SelectedTr=$(this).closest('tr.MainTr');
					if(type=='party'){
						renameRefRows(SelectedTr);
					}
					if(type=='bank'){
						renameBankRows(SelectedTr);
					}
				});
				$('#MainTable tfoot tr td:nth-child(2) input#totalMainDr').val(main_debit);
				$('#MainTable tfoot tr td:nth-child(3) input#totalMainCr').val(main_credit);
				$('#MainTable tfoot tr td:nth-child(1) input#totalBankCash').val(count_bank_cash);
			}
			
		
		";  
echo $this->Html->scriptBlock($js, array('block' => 'scriptBottom')); 		
?>

