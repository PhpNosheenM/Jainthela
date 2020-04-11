<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}
</style>
<?php $this->set('title', 'Consolidated Report'); ?><!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong>Consolidated Report For Fruits and Vegitables</strong></h3>
					<div class="pull-right">
						<div class="pull-left">
						</div> 
					</div> 	
				</div>
				<div class="panel-body">   			
					<div class="row">
					<?= $this->Form->create('Search',['type'=>'GET']) ?>
						<div class="col-md-4 col-xs-12">
									<div class="input-group">
									<span class="input-group-addon add-on"> FROM </span>
										<?= $this->Form->control('from_date',['class'=>'form-control datepicker','placeholder'=>'From','id'=>'from_date','label'=>false,'type'=>'text','data-date-format' => 'dd-mm-yyyy','value'=>date('d-m-Y',strtotime($from_date))]) ?>
										<span class="input-group-addon add-on"> TO </span>
										<?= $this->Form->control('to_date',['class'=>'form-control datepicker','placeholder'=>'To','label'=>false,'type'=>'text','id'=>'to_date','data-date-format' => 'dd-mm-yyyy','value'=>date('d-m-Y',strtotime($to_date))]) ?>
										</div>
								</div>
						<div class="col-md-2">
							<div class="form-group">
								<?php echo $this->Form->select('item_id',$items, ['empty'=>'--Select Item--','label' => false,'class' => 'form-control input-sm ledger select', 'data-live-search'=>true,'value'=>$item_id]); ?>
								
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								
								<?= $this->Form->button(__('Search'),['class'=>'btn btn-primary','label'=>false]) ?>
							</div>
						</div>
						
						<?= $this->Form->end() ?>
					</div>
				</div>  
				
				<div class="panel-body">    
					<div class="table-responsive">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th><?= ('SNo.') ?></th>
									<th><?= ('Item Name') ?></th>
									<th colspan="2" style="text-align:center"><?= ('In Stock') ?></th>
									<th colspan="2" style="text-align:center"><?= ('Out Stock') ?></th>
									
								</tr>
								<tr>
									<th></th>
									<th></th>
									<th><?= ('Quantity') ?></th>
									<th><?= ('Amount') ?></th>
									<th><?= ('Quantity') ?></th>
									<th><?= ('Amount') ?></th>
								</tr>
							</thead>
							<tbody>                                            
							
							<?php 
							$i=1; 
							$TotalOutQty=0; 
							$TotalOutRate=0; 
							$TotalInQty=0; 
							$TotalInRate=0; 
							
							foreach($QRdatas as $key=>$QRdata){ ?>
							<?php if(@$QRqty[$key] > 0){ ?>
								<tr class="main_tr">
									<td><?php echo $i++; ?></td>
									<td>
									<button type="button"  class="btn btn-xs tooltips revision_hide show_data" id="<?= h($key) ?>" value="" style="margin-left:5px;margin-bottom:2px;"><i class="fa fa-plus-circle"></i></button>
									<button type="button" class="btn btn-xs tooltips revision_show" style="margin-left:5px;margin-bottom:2px; display:none;"><i class="fa fa-minus-circle"></i></button>
									<?php echo $QRitemName[$key].'('.$unit_variation_names[$key].')'; ?>
									<div class="show_ledger"></div>
									</td>
									
									<td><?php echo @$GrnQty[$key]; $TotalInQty+=@$GrnQty[$key]; ?></td>
									<td><?php echo @$GrnRate[$key]; $TotalInRate+=@$GrnRate[$key]; ?></td>
									<td><?php echo @$QRqty[$key]; $TotalOutQty+=@$QRqty[$key]; ?></td>
									<td><?php echo @$QRrate[$key]; $TotalOutRate+=@$QRrate[$key]; ?></td>
									
								</tr>
							<?php } } ?>	
								<tr>
									<td colspan="2" style="text-align:right">Total</td>
									<td><?php echo $TotalInQty; ?></td>
									<td><?php echo $TotalInRate; ?></td>
									<td><?php echo $TotalOutQty; ?></td>
									<td><?php echo $TotalOutRate; ?></td>
								</tr>
								  
							</tbody>
						</table>
					</div>
				</div>
				
				
			</div>
		</div>
	</div>                    
</div>
<?php echo $this->Html->css('/assets/global/plugins/bootstrap-datepicker/css/datepicker3.css', ['block' => 'PAGE_LEVEL_CSS']); ?>
<?= $this->Html->script('plugins/bootstrap/bootstrap-datepicker.js',['block'=>'jsDatePicker']) ?>
<?= $this->Html->script('plugins/bootstrap/bootstrap-select.js',['block'=>'jsSelect']) ?>

<?= $this->Html->script('plugins/fileinput/fileinput.min.js',['block'=>'jsFileInput']) ?>
<?= $this->Html->script('plugins/bootstrap/bootstrap-datepicker.js',['block'=>'jsDatePicker']) ?>
<?= $this->Html->script('plugins/bootstrap/bootstrap-select.js',['block'=>'jsSelect']) ?>
<?= $this->Html->script('plugins/jquery-validation/jquery.validate.js',['block'=>'jsValidate']) ?>

<?php
   $js="
		
		
	$(document).on('click','.show_data',function(){			
		var sel=$(this);  
		var item_id=$(this).attr('id');
		show_ledger_data(sel,item_id);
		
	});
	
	function show_ledger_data(sel,item_id)
	 {
		var from_date = $('#from_date').val();
		var to_date = $('#to_date').val();
		var url='".$this->Url->build(["controller" => "Items", "action" => "fetchLedgerFruits"])."';
		url=url+'/'+item_id+'/'+from_date+'/'+to_date; 
		
		  $.ajax({
				url: url,
				type: 'GET',
				dataType: 'text'
			}).done(function(response) {  
			    $(sel).closest('tr.main_tr').find('.revision_show').show();
				$(sel).closest('tr.main_tr').find('.revision_hide').hide(); 
				//alert(response);
				$(sel).closest('tr.main_tr').find('.show_ledger').html(response);
				
			});
		 
	 }
	$(document).on('click','.revision_show',function(){	
		var sel=$(this);
		$(sel).closest('tr.main_tr').find('.revision_show').hide();
		$(sel).closest('tr.main_tr').find('.revision_hide').show();
		$(sel).closest('tr.main_tr').find('.show_ledger').html('');
	 });
	
		
		";  
echo $this->Html->scriptBlock($js, array('block' => 'scriptBottom')); 		
?>