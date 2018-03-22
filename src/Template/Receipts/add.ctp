<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}
.file-preview-image
{
	width: 100% !important;
	height:160px !important;
}
.file-preview-frame
{
	display: contents;
	float:none !important;
}
.kv-file-zoom
{
	display:none;
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
								<label class="col-md-3 control-label">Transaction Date</label>
								<div class="col-md-4">                                            
									<?= $this->Form->control('transaction_date',['class'=>'form-control datepicker','placeholder'=>'Transaction Date','label'=>false,'type'=>'text','data-date-format' => 'dd-mm-yyyy','value'=>date('d-m-Y')]) ?>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="table-responsive">
							<table id="MainTable" class="table table-condensed table-striped" height="60%" width="100%">
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
				<?php 
				$options=['Cr'=>'Cr']; ?>
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
				<?php 
				$options[]=['Dr'=>'Dr']; 
				$options[]=['Cr'=>'Cr']; 
				echo $this->Form->select('cr_dr', $options,['label' => false,'class' => 'form-control select input-sm cr_dr','required'=>'required','value'=>'Dr']); ?>
			</td>
			<td width="65%" valign="top">
				<?php echo $this->Form->input('ledger_id', ['empty'=>'--Select--','options'=>@$ledgerOptions,'label' => false,'class' => 'form-control input-sm ledger','required'=>'required']); ?>
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
	
	 $js='var jvalidate = $("#jvalidate").validate({
		ignore: [],
		rules: {                                            
				
				
			}                                        
		});
	
		$(document).on("click",".AddMainRow",function(){
			addMainRow();
		
		});
		
		//addMainRow();
		function addMainRow(){
			var tr=$("#sampleMainTable tbody.sampleMainTbody tr.MainTr").clone();
			$("#MainTable tbody#MainTbody").append(tr);
		}
		
		$(document).on("click",".delete_row",function(){
			var t=$(this).closest("tr").remove();
			renameRows();
			
		});
		
		function renameRows(){
				var i=0; 
				$(".main_table tbody tr").each(function(){
					$(this).attr("row_no",i);
						$(this).find("td:nth-child(1) select.unit").attr({name:"item_variations["+i+"][unit_id]",id:"item_variations-"+i+"-unit_id"}).rules("add", "required");
						$(this).find("td:nth-child(2) input.quantity_factor").attr({name:"item_variations["+i+"][quantity_factor]",id:"item_variations-"+i+"-quantity_factor"}).rules("add", "required");
						$(this).find("td:nth-child(3) input.print_quantity").attr({name:"item_variations["+i+"][print_quantity]",id:"item_variations-"+i+"-print_quantity"}).rules("add", "required");
						$(this).find("td:nth-child(4) input.print_rate").attr({name:"item_variations["+i+"][print_rate]",id:"item_variations-"+i+"-print_rate"}).rules("add", "required");
						$(this).find("td:nth-child(5) input.discount_per").attr({name:"item_variations["+i+"][discount_per]",id:"item_variations-"+i+"-discount_per"});
						$(this).find("td:nth-child(6) input.sales_rate").attr({name:"item_variations["+i+"][sales_rate]",id:"item_variations-"+i+"-sales_rate"}).rules("add", "required");
						$(this).find("td:nth-child(7) input.maximum_quantity_purchase").attr({name:"item_variations["+i+"][maximum_quantity_purchase]",id:"item_variations-"+i+"-maximum_quantity_purchase"});
						$(this).find("td:nth-child(8) select.ready_to_sale").attr({name:"item_variations["+i+"][ready_to_sale]",id:"item_variations-"+i+"-ready_to_sale"});
						$(this).find("td:nth-child(9) select.out_of_stock").attr({name:"item_variations["+i+"][out_of_stock]",id:"item_variations-"+i+"-out_of_stock"});
						$(this).find("td:nth-child(10) select.status1").attr({name:"item_variations["+i+"][status]",id:"item_variations-"+i+"-status"});
						i++;
			});
		}
		
		
		
		';  
echo $this->Html->scriptBlock($js, array('block' => 'scriptBottom')); 		
?>

