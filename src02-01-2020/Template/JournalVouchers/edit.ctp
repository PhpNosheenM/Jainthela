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
<?php $this->set('title', 'Journal Voucher'); ?>
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
	<div class="row">
		<div class="col-md-12">
		<?= $this->Form->create($journalVoucher,['id'=>'jvalidate','class'=>'form-horizontal','type'=>'file']) ?>  
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong> Journal Voucher</strong></h3>
				</div>
			
				<div class="panel-body">    
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="col-md-3 control-label">Voucher No : <?php  echo $voucher_no; ?> </label>
								
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
						<div class="">
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
								 <?php
							  //  unset($option_ref);								 
								$option_ref[]= ['value'=>'New Ref','text'=>'New Ref'];
								$option_ref[]= ['value'=>'Against','text'=>'Against'];
								$option_ref[]= ['value'=>'Advance','text'=>'Advance'];
								$option_ref[]= ['value'=>'On Account','text'=>'On Account'];
								$option_mode[]= ['value'=>'Cheque','text'=>'Cheque'];
								$option_mode[]= ['value'=>'NEFT/RTGS','text'=>'NEFT/RTGS'];
								 if(!empty($journalVoucher->journal_voucher_rows))
								 {$i=0;		
								         foreach($journalVoucher->journal_voucher_rows as $journalVoucherRows)
									     { ?>
									
									<tr class="MainTr" row_no="<?php echo $i;?>">
										<td width="10%">
											<?php 
											echo $this->Form->input('journal_voucher_rows.'.$i.'.id',['value'=>$journalVoucherRows->id,'class'=>'hidden']);
											if($i==0)
											{
												$options['Dr'] = 'Dr'; ?>
												<?= $this->Form->select('journal_voucher_rows.'.$i.'.cr_dr',$options,['class'=>'form-control input-sm cr_dr select','label'=>false,'value'=>$journalVoucherRows->cr_dr]) ?>
											<?php }
											else{
												 $options['Dr'] = 'Dr'; 
												 $options['Cr'] = 'Cr'; ?>
												<?= $this->Form->select('journal_voucher_rows.'.$i.'.cr_dr',$options,['class'=>'form-control input-sm cr_dr select','label'=>false,'value'=>$journalVoucherRows->cr_dr]) ?>
											<?php }
										?>
											  
										</td>
										<td width="65%">
										<input type="hidden" class="BankValueDefine" name=" journal_voucher_rows[<?php echo $i;?>][BankDefination]">
							
										<?php
										if($i==0)
										{ 
											echo $this->Form->select('journal_voucher_rows.'.$i.'.ledger_id',$ledgerOptions, ['empty'=>'--Select--','label' => false,'class' => 'form-control input-sm ledger select','required'=>'required', 'data-live-search'=>true,'value'=>$journalVoucherRows->ledger_id]); ?>
											<div class="window" style="margin:auto;"></div>
											
											<?php
										}
										else
										{ 
											echo $this->Form->select('journal_voucher_rows.'.$i.'.ledger_id',$ledgerOptions, ['empty'=>'--Select--','label' => false,'class' => 'form-control input-sm ledger select','required'=>'required', 'data-live-search'=>true,'value'=>$journalVoucherRows->ledger_id]); 
										}
										?>
										
											<div class="window" style="margin:auto;">
											<?php
											if(!empty($journalVoucherRows->reference_details)){
											?>
												<table width="90%" class="refTbl"><tbody>
												<?php
												    $j=0;$total_amount_dr=0;$total_amount_cr=0;$colspan=0; 
												    foreach($journalVoucherRows->reference_details as $reference_detail)
													{
												?>
													<tr>
														<td width="20%">
															<?php 
															echo $this->Form->input('journal_voucher_rows.'.$i.'.reference_details.'.$j.'.ledger_id', ['type'=>'hidden','label' => false,'class' => 'form-control input-sm ledgerIdContainer','value'=>$reference_detail->ledger_id]); ?>
															
															
															
															<?php 
															echo $this->Form->input('journal_voucher_rows.'.$i.'.reference_details.'.$j.'.city_id', ['type'=>'hidden','label' => false,'class' => 'form-control input-sm companyIdContainer','value'=>$reference_detail->city_id]); ?>
															 
															<?php
																echo $this->Form->select('journal_voucher_rows.'.$i.'.reference_details.'.$j.'.type',$option_ref, ['label' => false,'class' => 'form-control input-sm refType select','required'=>'required','value'=>$reference_detail->type]); ?>
														</td>
														
														<td width="">
														<?php if($reference_detail->type=='New Ref' || $reference_detail->type=='Advance'){ 
														?>
															<?php echo $this->Form->input('journal_voucher_rows.'.$i.'.reference_details.'.$j.'.ref_name', ['type'=>'text','label' => false,'class' => 'form-control input-sm ref_name','placeholder'=>'Reference Name','required'=>'required']); ?>
															<?php } if($reference_detail->type=='Against')
															{?>
															<?php 
															if(!empty($refDropDown[$journalVoucherRows->id]))
															{
																echo $this->Form->input('journal_voucher_rows.'.$i.'.reference_details.'.$j.'.ref_name', ['options'=>@$refDropDown[$journalVoucherRows->id],'label' => false,'class' => 'form-control input-sm paymentType refList','required'=>'required','value'=>$reference_detail->ref_name]);
																
															} }?>
															
														</td>
														
														<td width="20%" style="padding-right:0px;" valign="top">
															<?php
															$value="";
															$cr_dr="";
															
															if(!empty($reference_detail->debit))
															{
																$value=$reference_detail->debit;
																$total_amount_dr=$total_amount_dr+$reference_detail->debit;
																$cr_dr="Dr";
																$name="debit";
															}
															else
															{
																$value=$reference_detail->credit;
																$total_amount_cr=$total_amount_cr+$reference_detail->credit;
																$cr_dr="Cr";
																$name="credit";
															}

															echo $this->Form->input('journal_voucher_rows.'.$i.'.reference_details.'.$j.'.'.$name, ['label' => false,'class' => 'form-control input-sm calculation numberOnly rightAligntextClass','placeholder'=>'Amount','required'=>'required','value'=>$value, 'type'=>'text']); ?>
														</td>
														<td width="10%" style="padding-left:0px;" valign="top">
															<?php 
															echo $this->Form->input('type_cr_dr', ['options'=>['Dr'=>'Dr','Cr'=>'Cr'],'label' => false,'class' => 'form-control input-sm  calculation refDrCr select','value'=>$cr_dr]); ?>
														</td>
														<td  width="5%" align="right">
															<a class="delete-tr-ref calculation" href="#" role="button" style="margin-bottom: 5px;"><i class="fa fa-times"></i></a>
														</td>
													</tr>
													<?php $j++;} 
													
													if($total_amount_dr>$total_amount_cr)
													{
														$total = $total_amount_dr-$total_amount_cr;
														$type="Dr";
													}
													if($total_amount_dr<$total_amount_cr)
													{
														$total = $total_amount_cr-$total_amount_dr;
														$type="Cr";
													}
													?>
												</tbody>
												<tfoot>
												    <tr class="remove_ref_foot">
														<td colspan="2"><input type="hidden" id="htotal" value="<?php echo $total;?>">
														<a role="button" class="addRefRow">Add Row</a>
														</td>
														<td valign="top">
														<input type="text" class="form-control input-sm rightAligntextClass total calculation noBorder" name="journal_voucher_rows[<?php echo $i;?>][total]" id="journal_voucher_rows-<?php echo $i;?>-total" aria-invalid="true" aria-describedby="journal_voucher_rows-<?php echo $i;?>-total-error" value="<?php echo $total;?>" readonly>
														</td>
														<td valign="top"><input type="text" class="form-control input-sm total_type calculation noBorder" readonly value="<?php echo @$type;?>" name="journal_voucher_rows<?php echo $i;?>reference_details<?php echo $i;?>type_cr_dr"></td>
													</tr>
												</tfoot>
												</table>
												
											<?php } ?>
											<?php
											if(!empty($journalVoucherRows->mode_of_payment)){
											?>
											<table width='90%'>
												<tbody>
													<tr>
														<td width="30%">
															<?php 
															echo $this->Form->input('journal_voucher_rows.'.$i.'.mode_of_payment', ['options'=>$option_mode,'label' => false,'class' => 'form-control input-sm paymentType select','required'=>'required','value'=>$journalVoucherRows->mode_of_payment]); ?>
														</td>
														
													<?php if($journalVoucherRows->mode_of_payment=='NEFT/RTGS'){?>
														 <?php $style='display:none';?>
														<?php } else if($journalVoucherRows->mode_of_payment=='Cheque'){ ?>
														 <?php $style='';?>
														
														
														
														<td width="30%" style="<?php echo $style;?>">
															<?php echo $this->Form->input('journal_voucher_rows.'.$i.'.cheque_no', ['label' =>false,'class' => 'form-control input-sm cheque_no','placeholder'=>'Cheque No','value'=>$journalVoucherRows->cheque_no]); ?>
														<?php } ?>		
														</td>
														<td width="30%" style="<?php echo $style;?>">
															<?php echo $this->Form->input('journal_voucher_rows.'.$i.'.cheque_date', ['label' =>false,'class' => 'form-control input-sm date-picker cheque_date ','data-date-format'=>'dd-mm-yyyy','placeholder'=>'Cheque Date','value'=>date("d-m-Y",strtotime($journalVoucherRows->cheque_date)),'type'=>'text']); ?>
														</td>
													</tr>
												</tbody>
												<tfoot>
												<td colspan='4'></td>
												</tfoot>
											</table>
											<?php } ?>
											</div>
										</td>
										<td width="10%">
											 <?php if($journalVoucherRows->debit > 0){ ?>
											<?php echo $this->Form->input('journal_voucher_rows.'.$i.'.debit', ['label' => false,'class' => 'form-control input-sm debitBox rightAligntextClass numberOnly totalCalculation calculate_total','placeholder'=>'Debit','value'=>$journalVoucherRows->debit, 'type'=>'text']); ?>
											 <?php }else{ ?>
											 <?php echo $this->Form->input('journal_voucher_rows.'.$i.'.debit', ['label' => false,'class' => 'form-control input-sm debitBox rightAligntextClass numberOnly totalCalculation calculate_total','placeholder'=>'Debit','value'=>'', 'type'=>'text','style'=>'display:none;']); ?>
											 <?php } ?>
										</td>
										<td width="10%">
											 <?php if($journalVoucherRows->credit > 0){ ?>
											<?php echo $this->Form->input('journal_voucher_rows.'.$i.'.credit', ['label' => false,'class' => 'form-control input-sm creditBox rightAligntextClass numberOnly totalCalculation calculate_total','placeholder'=>'Credit','value'=>$journalVoucherRows->credit, 'type'=>'text']); ?>
											  <?php }else{ ?>
												<?php echo $this->Form->input('journal_voucher_rows.'.$i.'.credit', ['label' => false,'class' => 'form-control input-sm creditBox rightAligntextClass numberOnly totalCalculation calculate_total','placeholder'=>'Credit','value'=>'', 'type'=>'text','style'=>'display:none;']); ?>
											  <?php } ?>
										</td>
										<td align="center"  width="10%">
										<?php 
											if($i>=1)
											{
										?>
											<a class="btn btn-danger delete-tr btn-xs" href="#" role="button" style="margin-bottom: 5px;"><i class="fa fa-times"></i></a>
										<?php } ?>
										</td>
									</tr>
								<?php $i++; } } ?>
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
<?php
$option_ref['New Ref']= 'New Ref';
$option_ref['Against']= 'Against';
$option_ref['Advance']= 'Advance';
$option_ref['On Account']= 'On Account';
?>
<?php
$option_type['Cr']='Cr';
$option_type['Dr']='Dr';
?>
<table id="sampleForRef" style="display:none;" width="100%">
	<tbody>
		<tr>
			<td width="20%" valign="top"> 
				<input type="hidden" class="ledgerIdContainer" />
				<input type="hidden" class="locationIdContainer" />
				<input type="hidden" class="cityIdContainer" />
				<?php 
				echo $this->Form->select('type',$option_ref, ['label' => false,'class' => 'form-control input-sm refType','required'=>'required']); ?>
			</td>
			<td width="" valign="top">
				<?php echo $this->Form->input('ref_name', ['type'=>'text','label' => false,'class' => 'form-control input-sm ref_name','placeholder'=>'Reference Name','required'=>'required']); ?>
			</td>
			
			<td width="20%" style="padding-right:0px;" valign="top">
				<?php echo $this->Form->input('amount', ['label' => false,'class' => 'form-control input-sm calculation numberOnly rightAligntextClass','placeholder'=>'Amount','required'=>'required']); ?>
			</td>
			<td width="10%" style="padding-left:0px;" valign="top">
				<?php 
				echo $this->Form->select('type_cr_dr',$option_type, ['label' => false,'class' => 'form-control input-sm  calculation refDrCr','value'=>'Dr']); ?>
			</td>
			 
			<td width="5%" align="right" valign="top">
				<a class="delete-tr-ref" href="#" role="button" style="margin-bottom: 5px;"><i class="fa fa-times"></i></a>
			</td>
		</tr>
	</tbody>
</table>


<?php
$option_mode['Cheque']= 'Cheque';
$option_mode['NEFT/RTGS']='NEFT/RTGS';
?>
<table id="sampleForBank" style="display:none;" width="100%">
	<tbody>
		<tr>
			<td width="30%" valign="top">
				<?php 
				echo $this->Form->select('mode_of_payment', $option_mode,['label' => false,'class' => 'form-control input-sm paymentType','required'=>'required']); ?>
			</td>
			<td width="30%" valign="top">
				<?php echo $this->Form->input('cheque_no', ['label' =>false,'class' => 'form-control input-sm cheque_no positiveValue','placeholder'=>'Cheque No']); ?> 
			</td>
			
			<td width="30%" valign="top">
				<?php echo $this->Form->input('cheque_date', ['label' =>false,'class' => 'form-control input-sm date-picker cheque_date ','data-date-format'=>'dd-mm-yyyy','placeholder'=>'Cheque Date']); ?>
			</td>
			
			
		</tr>
	</tbody>
</table>
<table id="sampleMainTable" style="display:none;" width="100%">
	<tbody class="sampleMainTbody">
		<tr class="MainTr">
			
			<td width="10%" valign="top">
			
				<?php 
				$options['Cr'] = 'Cr'; 
				$options['Dr'] = 'Dr';			
				 
				echo $this->Form->select('cr_dr', $options,['label' => false,'class' => 'form-control input-sm cr_dr','required'=>'required','value'=>'Cr']); ?>
			</td>
			<td width="65%" valign="top">
				<?php echo $this->Form->select('ledger_id',$ledgerOptions, ['empty'=>'--Select--','label' => false,'class' => 'form-control input-sm ledger ','required'=>'required', 'data-live-search'=>true]); ?>
				<div class="window" style="margin:auto;"></div>
			</td>
			<td width="10%" valign="top">
				<?php echo $this->Form->input('debit', ['label' => false,'class' => 'form-control input-sm  debitBox rightAligntextClass numberOnly calculate_total','placeholder'=>'Debit','style'=>'display:none;']); ?>
			</td>
			<td width="10%" valign="top">
				<?php echo $this->Form->input('credit', ['label' => false,'class' => 'form-control input-sm creditBox rightAligntextClass numberOnly calculate_total','placeholder'=>'Credit']); ?>	
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
	
	 $js="var form1 = $('#jvalidate').validate({
		
		ignore: [],
		rules: {                                            
			totalMainCr: {
						equalTo: '#totalMainDr'
					},	
				
			} ,
			messages: {
				totalMainCr: {
					equalTo: 'Total debit and credit not matched !'
				},
			}, 
			submitHandler: function (form) {
					var totalMainDr  = parseFloat($('#totalMainDr').val());
					var totalBankCash = parseFloat($('#totalBankCash').val());
					if(!totalMainDr || totalMainDr==0){
						alert('Error: zero amount payment can not be generated.');
						return false;
					}
					/* else if(totalBankCash<=0){
						alert('Error: No Bank or Cash Credited.');
						return false;
					} */
					else{
						if(confirm('Are you sure you want to submit!'))
							{
								success1.show();
								error1.hide();
								form1[0].submit();
								$('.submit').attr('disabled','disabled');
								$('.submit').text('Submiting...');
								return true;
							}
					}
                }
				
				
		});
	
			$(document).on('click','.AddMainRow',function(){
			addMainRow();
			renameMainRows();
			});
		
			$(document).on('click','.delete-tr',function() 
			{	
				$(this).closest('tr.MainTr').remove();
				renameMainRows();
			});
			
			$(document).on('click','.delete-tr-ref',function() 
			{	var SelectedTr=$(this).closest('tr.MainTr');
				$(this).closest('tr').remove();
				calculation(SelectedTr);
				renameMainRows();
				renameRefRows(SelectedTr);
				
			});
			
			$(document).on('change','.paymentType',function(){
				
				var type=$(this).val();	
				var currentRefRow=$(this).closest('tr');
				var SelectedTr=$(this).closest('tr.MainTr');
				if(type=='NEFT/RTGS'){
				 currentRefRow.find('td:nth-child(2) input').val('');
					currentRefRow.find('td:nth-child(3) input').val('');
					currentRefRow.find('td:nth-child(2)').hide();
					currentRefRow.find('td:nth-child(3)').hide();
					renameBankRows(SelectedTr);
				}
				else{
					currentRefRow.find('td:nth-child(2)').show();
					currentRefRow.find('td:nth-child(3)').show();
				    renameBankRows(SelectedTr);
				}
				
			});
			
			$(document).on('change','.refDrCr',function(){
				var SelectedTr=$(this).closest('tr.MainTr');
				renameRefRows(SelectedTr);
			});
			
			$(document).on('change','.refType',function(){
				var type=$(this).val();
				var currentRefRow=$(this).closest('tr');
				var ledger_id=$(this).closest('tr.MainTr').find('select.ledger option:selected').val();
				var due_days=$(this).closest('tr.MainTr').find('select.ledger option:selected').attr('default_days');
				var SelectedTr=$(this).closest('tr.MainTr');
				if(type=='Against'){
					$(this).closest('tr').find('td:nth-child(2)').html('Loading Ref List...');
					var url='".$this->Url->build(['controller'=>'ReferenceDetails','action'=>'listRef'])."';
					url=url+'/'+ledger_id;
					$.ajax({
						url: url,
					}).done(function(response) { 
						currentRefRow.find('td:nth-child(2)').html(response);
						currentRefRow.find('td:nth-child(5)').html('');
						
						renameRefRows(SelectedTr);
					});
				}else if(type=='On Account'){
					currentRefRow.find('td:nth-child(2)').html('');
					currentRefRow.find('td:nth-child(5)').html('');
				}else{
					currentRefRow.find('td:nth-child(2)').html('".$kk."');
					currentRefRow.find('td:nth-child(5)').html('".$dd."');
					currentRefRow.find('td:nth-child(5) input.dueDays').val(due_days);
				}
				var SelectedTr=$(this).closest('tr.MainTr');
				renameRefRows(SelectedTr);
			});
			
		$(document).on('change','.ledger',function(){
				var openWindow=$(this).find('option:selected').attr('open_window');
				
				if(openWindow=='party'){
					var SelectedTr=$(this).closest('tr.MainTr');
					var windowContainer=$(this).closest('td').find('div.window');
					windowContainer.html('');
					windowContainer.html('<table width=90% class=refTbl><tbody></tbody><tfoot><tr style=border-top:double#a5a1a1><td colspan=2><a role=button class=addRefRow>Add Row</a></td><td>$total_input</td><td valign=top>$total_type</td></tr></tfoot></table>');
					AddRefRow(SelectedTr);
				}
				else if(openWindow=='bank'){
					var SelectedTr=$(this).closest('tr.MainTr')
					var windowContainer=$(this).closest('td').find('div.window');
					windowContainer.html('');
					windowContainer.html('<table width=90% ><tbody></tbody><tfoot><td colspan=4></td></tfoot></table>');
					AddBankRow(SelectedTr);
				}
				else{
					var windowContainer=$(this).closest('td').find('div.window');
					windowContainer.html('');
				}
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
		
		function addMainRow(){
			var tr=$('#sampleMainTable tbody.sampleMainTbody tr.MainTr').clone();
			$('#MainTable tbody#MainTbody').append(tr);
			renameMainRows();
		}
		
		renameMainRows();
		function renameMainRows(){
				var i=0; var main_debit=0; var main_credit=0; var count_bank_cash=0;
				$('#MainTable tbody#MainTbody tr.MainTr').each(function(){
					$(this).attr('row_no',i);
					var cr_dr=$(this).find('td:nth-child(1) select.cr_dr option:selected').val();
					var is_cash_bank=$(this).find('td:nth-child(2) option:selected').attr('bank_and_cash');
					$(this).find('td:nth-child(1) select.cr_dr').attr({name:'journal_voucher_rows['+i+'][cr_dr]',id:'journal_voucher_rows-'+i+'-cr_dr'}).selectpicker();
					$(this).find('td:nth-child(2) select.ledger').attr({name:'journal_voucher_rows['+i+'][ledger_id]',id:'journal_voucher_rows-'+i+'-ledger_id'}).selectpicker();
					$(this).find('td:nth-child(3) input.debitBox').attr({name:'journal_voucher_rows['+i+'][debit]',id:'journal_voucher_rows-'+i+'-debit'});
					$(this).find('td:nth-child(4) input.creditBox').attr({name:'journal_voucher_rows['+i+'][credit]',id:'journal_voucher_rows-'+i+'-credit'});
					
					if(cr_dr=='Dr'){
						$(this).find('td:nth-child(3) input.debitBox').rules('add', 'required');
						$(this).find('td:nth-child(4) input.creditBox').rules('remove', 'required');
						$(this).find('td:nth-child(4) span.help-block-error').remove();
						var debit_amt=parseFloat($(this).find('td:nth-child(3) input.debitBox').val());
						if(!debit_amt){
							debit_amt=0;
						}
						
						main_debit=Math.round(main_debit+debit_amt,2);
						
						
					}else{  
						$(this).find('td:nth-child(3) input.debitBox').rules('remove', 'required');
						$(this).find('td:nth-child(3) span.help-block-error').remove();
						$(this).find('td:nth-child(4) input.creditBox').rules('add', 'required');
						var credit_amt=parseFloat($(this).find('td:nth-child(4) input.creditBox').val());
						if(!credit_amt){
							credit_amt=0;
						}
						main_credit=Math.round(main_credit+credit_amt, 2);
						if(is_cash_bank=='yes'){
						 count_bank_cash++;
						}
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
			$(document).on('click','.addRefRow',function(){
				var SelectedTr=$(this).closest('tr.MainTr');
				
				AddRefRow(SelectedTr);
			});
			
			function AddRefRow(SelectedTr){
				var refTr=$('#sampleForRef tbody tr').clone();
				var due_days=SelectedTr.find('td:nth-child(2) select.ledger option:selected').attr('default_days');
				refTr.find('td:nth-child(5) input.dueDays').val(due_days);
				//console.log(refTr);
				SelectedTr.find('td:nth-child(2) div.window table tbody').append(refTr);
				renameRefRows(SelectedTr);
			}
			
			$(document).on('click','.addBankRow',function(){
				var SelectedTr=$(this).closest('tr.MainTr');
				AddBankRow(SelectedTr);
				
			});
		
			
			function AddBankRow(SelectedTr){
				var bankTr=$('#sampleForBank tbody tr').clone();
				//console.log(bankTr);
				SelectedTr.find('td:nth-child(2) div.window table tbody').append(bankTr);
				renameBankRows(SelectedTr);
			}
			
			function renameBankRows(SelectedTr){
				var row_no=SelectedTr.attr('row_no');
				SelectedTr.find('td:nth-child(2) div.window table tbody tr').each(function(){
					var type = SelectedTr.find('td:nth-child(1) select.paymentType option:selected').val(); 
					//alert(type);
					$(this).find('td:nth-child(1) select.paymentType').attr({name:'journal_voucher_rows['+row_no+'][mode_of_payment]',id:'journal_voucher_rows-'+row_no+'-mode_of_payment'}).selectpicker();
					$(this).find('td:nth-child(2) input.cheque_no').attr({name:'journal_voucher_rows['+row_no+'][cheque_no]',id:'journal_voucher_rows-'+row_no+'-cheque_no'});
					$(this).find('td:nth-child(3) input.cheque_date').attr({name:'journal_voucher_rows['+row_no+'][cheque_date]',id:'journal_voucher_rows-'+row_no+'-cheque_date'}).datepicker();
				
					if(type=='Cheque')
					{ 
						$(this).find('td:nth-child(2) input.cheque_no').rules('add','required');
						$(this).find('td:nth-child(3) input.cheque_date').rules('add','required');
					}
					else if(type=='NEFT/RTGS')
					{
						$(this).find('td:nth-child(2) input').rules('remove','required');
						$(this).find('td:nth-child(3) input').rules('remove','required');
					}
				});
			}
			
			
			function renameRefRows(SelectedTr){
				var i=0;
				
				var ledger_id=SelectedTr.find('td:nth-child(2) select.ledger').val();
				var cr_dr=SelectedTr.find('td:nth-child(1) select.cr_dr option:selected').val();
				if(cr_dr=='Dr'){
					var eqlClassDr=SelectedTr.find('td:nth-child(3) input.debitBox').attr('id');
					var mainAmt=SelectedTr.find('td:nth-child(3) input.debitBox').val();
				}else{
					var eqlClassCr=SelectedTr.find('td:nth-child(4) input.creditBox').attr('id');
					var mainAmt=SelectedTr.find('td:nth-child(4) input.creditBox').val();
				}
				
				SelectedTr.find('input.ledgerIdContainer').val(ledger_id);
				SelectedTr.find('input.locationIdContainer').val(".$location_id.");
				SelectedTr.find('input.cityIdContainer').val(".$city_id.");
				var row_no=SelectedTr.attr('row_no');
				if(SelectedTr.find('td:nth-child(2) div.window table tbody tr').length>0){
				SelectedTr.find('td:nth-child(2) div.window table tbody tr').each(function(){
					$(this).find('td:nth-child(1) input.companyIdContainer').attr({name:'journal_voucher_rows['+row_no+'][reference_details]['+i+'][location_id]',id:'journal_voucher_rows-'+row_no+'-reference_details-'+i+'-location_id'});
					$(this).find('td:nth-child(1) input.ledgerIdContainer').attr({name:'journal_voucher_rows['+row_no+'][reference_details]['+i+'][ledger_id]',id:'journal_voucher_rows-'+row_no+'-reference_details-'+i+'-ledger_id'});
					
					$(this).find('td:nth-child(1) select.refType').attr({name:'journal_voucher_rows['+row_no+'][reference_details]['+i+'][type]',id:'journal_voucher_rows-'+row_no+'-reference_details-'+i+'-type'}).selectpicker();
					var is_select=$(this).find('td:nth-child(2) select.refList').length;
					var is_input=$(this).find('td:nth-child(2) input.ref_name').length;
					if(is_select){
						$(this).find('td:nth-child(2) select.refList').attr({name:'journal_voucher_rows['+row_no+'][reference_details]['+i+'][ref_name]',id:'journal_voucher_rows-'+row_no+'-reference_details-'+i+'-ref_name'}).rules('add', 'required');
						$(this).find('td:nth-child(2) select.refList').selectpicker();
					}else if(is_input){
						$(this).find('td:nth-child(2) input.ref_name').attr({name:'journal_voucher_rows['+row_no+'][reference_details]['+i+'][ref_name]',id:'journal_voucher_rows-'+row_no+'-reference_details-'+i+'-ref_name'}).rules('add', 'required');
						 
					}
					$(this).find('td:nth-child(4) select.refDrCr').selectpicker();
					var Dr_Cr=$(this).find('td:nth-child(4) select option:selected').val();
					if(Dr_Cr=='Dr'){
						$(this).find('td:nth-child(3) input').attr({name:'journal_voucher_rows['+row_no+'][reference_details]['+i+'][debit]',id:'journal_voucher_rows-'+row_no+'-reference_details-'+i+'-debit'}).rules('add', 'required');
					}else{
						$(this).find('td:nth-child(3) input').attr({name:'journal_voucher_rows['+row_no+'][reference_details]['+i+'][credit]',id:'journal_voucher_rows-'+row_no+'-reference_details-'+i+'-credit'}).rules('add', 'required');
					}
					i++;
				});
				var total_type=SelectedTr.find('td:nth-child(2) div.window table.refTbl tfoot tr td:nth-child(3) input.total_type').val();
					if(total_type=='Dr'){
					 eqlClass=eqlClassDr;
					}else{
					 eqlClass=eqlClassCr;
					}

				
				SelectedTr.find('td:nth-child(2) div.window table.refTbl tfoot tr td:nth-child(2) input.total')
				.attr({name:'journal_voucher_rows['+row_no+'][total]',id:'journal_voucher_rows-'+row_no+'-total'})
						.rules('add', {
							equalTo: '#'+eqlClass,
							messages: {
								equalTo: 'Enter bill wise details upto '+mainAmt+' '+cr_dr
							}
						});
				}
			}
			
			$(document).on('keyup','.calculate_total',function()
			{ 
				 renameMainRows();
			});
			$(document).on('keyup', '.calculation', function()
			{ 
				var SelectedTr=$(this).closest('tr.MainTr');
				calculation(SelectedTr);
				
			});
			$(document).on('change', '.calculation',function()
			{ 
				var SelectedTr=$(this).closest('tr.MainTr');
				calculation(SelectedTr);
				
			});
			function calculation(SelectedTr)
			{
				var total_debit=0;var total_credit=0; var remaining=0; var i=0;
				SelectedTr.find('td:nth-child(2) div.window table tbody tr').each(function(){
				var Dr_Cr=$(this).find('td:nth-child(4) select option:selected').val();
				//console.log(Dr_Cr);
				var amt= parseFloat($(this).find('td:nth-child(3) input').val());
				if(!amt){amt=0; }
					if(Dr_Cr=='Dr'){
						total_debit=Math.round((total_debit+amt),2);
						
					}
					else if(Dr_Cr=='Cr'){
						total_credit=Math.round((total_credit+amt), 2);
						//console.log(total_credit);
					}
					
					remaining=Math.round(total_debit-total_credit, 2);
					
					if(remaining>0){
						//console.log(remaining);
						$(this).closest('table').find(' tfoot td:nth-child(2) input.total').val(remaining);
						$(this).closest('table').find(' tfoot td:nth-child(3) input.total_type').val('Dr');
					}
					else if(remaining<0){
						remaining=Math.abs(remaining)
						$(this).closest('table').find(' tfoot td:nth-child(2) input.total').val(remaining);
						$(this).closest('table').find(' tfoot td:nth-child(3) input.total_type').val('Cr');
					}
					else{
					$(this).closest('table').find(' tfoot td:nth-child(2) input.total').val('0');
					$(this).closest('table').find(' tfoot td:nth-child(3) input.total_type').val('');	
					}
					
				});
				renameRefRows(SelectedTr);
					
				i++;
			}
			
			
		
		";  
echo $this->Html->scriptBlock($js, array('block' => 'scriptBottom')); 		
?>

