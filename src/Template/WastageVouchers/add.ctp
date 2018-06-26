<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}
</style>
<?php $this->set('title', 'Wastage Voucher'); ?><!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong>Wastage Voucher</strong></h3>
					<div class="pull-right">
						<div class="pull-left">
						</div> 
					</div> 	
				</div>
				
				<div class="panel-body">   			
					<div class="row">
					<?= $this->Form->create('Search',['type'=>'GET']) ?>
						<div class="col-md-2">
							<div class="form-group">
								<label>Location</label>
								<?php echo $this->Form->select('location_id',$Locations, ['empty'=>'--Select--','label' => false,'class' => 'form-control input-sm ledger select', 'data-live-search'=>true,'value'=>$location_id]); ?>
								
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label></label></br/>
								<?= $this->Form->button(__('Search'),['class'=>'btn btn-primary','label'=>false]) ?>
							</div>
						</div>
						
						<?= $this->Form->end() ?>
					</div>
				</div>  
				 <?= $this->Form->create($wastageVoucher,['id'=>'jvalidate','class'=>'form-horizontal','type'=>'file']) ?>  
					<div class="panel-body">    
						<div class="table-responsive">
							<table class="table table-bordered main_tbl" id="main_tbl">
								<thead>
									<tr>
										<th><?= ('SNo.') ?></th>
										<th><?= ('Item Name') ?></th>
										<th><?= ('Current Stock') ?></th>
										<th><?= ('Wastage Quantity') ?></th>
										<th><?= ('Actual Quantity') ?></th>
									</tr>
								</thead>
								<tbody id="main_tbody">                                             
									<?php $i = 0; $total_amt=0; ?>
									
									   <?php foreach ($showItems as $showItem){
											if($showItem['stock'] > 0){
										?>
									<tr id="main_tr">
										<td><?= $this->Number->format(++$i) ?></td>
										<td><?php echo $showItem['item_variation_name']; ?></td>
										<td><?php echo $showItem['stock']; ?></td>
										<td>
										<?php echo $this->Form->input('wastage_voucher_rows['.$i.'][quantity]', ['label' => false,'class' => 'form-control input-sm wastage_quantity ','value'=>0,'placeholder'=>'Wastage','total_qt'=>$showItem['stock']]); ?>
										<?php echo $this->Form->input('wastage_voucher_rows['.$i.'][item_variation_id]', ['label' => false,'class' => 'form-control input-sm wastage_quantity ','placeholder'=>'Wastage','value'=>$showItem['item_variation_id'],'type'=>'hidden']); ?>
										<?php echo $this->Form->input('wastage_voucher_rows['.$i.'][item_id]', ['label' => false,'class' => 'form-control input-sm wastage_quantity ','placeholder'=>'Wastage','value'=>$showItem['item_id'],'type'=>'hidden']); ?>
										<?php echo $this->Form->input('wastage_voucher_rows['.$i.'][rate]', ['label' => false,'class' => 'form-control input-sm wastage_quantity ','placeholder'=>'Wastage','value'=>$showItem['unit_rate'],'type'=>'hidden']); ?>
										</td>
										<td><?php echo $this->Form->input('actual_quantity', ['label' => false,'class' => 'form-control input-sm  actual_quantity','placeholder'=>'Actual','total_qt'=>$showItem['stock'],'value'=>$showItem['stock']]); ?></td>
									</tr>
									   <?php } } ?>
									<tr >
										<th colspan="4" style="text-align:right">Total</th>
										<th  style="text-align:right"></th>
										
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					 <div class="panel-footer" id="btn_sbmt" style="display:none">
						 <center>
								<?= $this->Form->button(__('Submit'),['class'=>'btn btn-primary']) ?>
						 </center>
					</div>
				<?= $this->Form->end() ?>
			</div>
		</div>
	</div>                    
</div>
<?= $this->Html->script('plugins/bootstrap/bootstrap-datepicker.js',['block'=>'jsDatePicker']) ?>
<?= $this->Html->script('plugins/bootstrap/bootstrap-select.js',['block'=>'jsSelect']) ?>
<?= $this->Html->script('plugins/jquery-validation/jquery.validate.js',['block'=>'jsValidate']) ?>
<?php
	$js="var jvalidate = $('#jvalidate').validate({
		ignore: [],
		rules: {                                            
				party_ledger_id: {
						required: true,
				},
				sales_ledger_id: {
						required: true,
				},
				
			}                                        
		});
	 
		$(document).on('keyup', '.wastage_quantity', function()
		{ 
			var total_qt=$(this).attr('total_qt');
			var wastage_quantity=$(this).val();
			var actual_quantity=total_qt-wastage_quantity;
			$(this).closest('tr').find('.actual_quantity').val(actual_quantity);
			$(this).attr('max',total_qt);
			renameRows();
		});
		
		$(document).on('keyup', '.actual_quantity', function()
		{ 
			var total_qt=$(this).attr('total_qt');
			var actual_quantity=$(this).val();
			var wastage_quantity=total_qt-actual_quantity;
			$(this).closest('tr').find('.wastage_quantity').val(wastage_quantity);
			$(this).attr('max',total_qt);
			renameRows();
		});
		
		function renameRows(){ 
			var stutus=0;
			$('.main_tbl #main_tbody tr#main_tr').each(function(){
				var wastage_quantity=$(this).find('.wastage_quantity').val();
				if(wastage_quantity > 0){
					stutus=1;
				}
			});
			if(stutus==1){
				$('#btn_sbmt').show();
			}else{
				$('#btn_sbmt').hide();
			}
		}
	";  
echo $this->Html->scriptBlock($js, array('block' => 'scriptBottom'));
?>