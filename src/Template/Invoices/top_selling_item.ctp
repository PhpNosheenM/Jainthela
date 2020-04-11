<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}
</style>
<?php $this->set('title', 'Top Selling Item Report'); ?><!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong>Top Selling Item Report</strong></h3>
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
								<label>From</label>
								<?= $this->Form->control('from_date',['class'=>'form-control datepicker','placeholder'=>'From','label'=>false,'type'=>'text','data-date-format' => 'dd-mm-yyyy','value'=>date('d-m-Y',strtotime($from_date))]) ?>
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<label>To</label>
								<?= $this->Form->control('to_date',['class'=>'form-control datepicker','placeholder'=>'To','label'=>false,'type'=>'text','data-date-format' => 'dd-mm-yyyy','value'=>date('d-m-Y',strtotime($to_date))]) ?>
								
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<label>Item</label>	
								<?php echo $this->Form->select('item_variation_id',$itemOptions, ['empty'=>'--Select Item--','label' => false,'class' => 'form-control input-sm ledger select', 'data-live-search'=>true,'value'=>$item_variation_id]); ?>
								
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
					<?php if(@$showItem){ ?>
					<div class="panel-body">   
						<div class="col-md-6">
							<div class="table-responsive">
								<table class="table table-bordered">
									<thead>
										<tr>
											<th><?= ('SNo.') ?></th>
											<th><?= ('Item Name') ?></th>
											<th><?= ('Quantity') ?></th>
											<th><?= ('Rate') ?></th>
											<th><?= ('Amount') ?></th>
											
										</tr>
									</thead>
									<tbody>                                            
										<?php $i = 0; $total_amt=0; ?>
										
										   <?php foreach (@$showItem as $key=>$showItemData){  
											?>
										<tr>
											<td><?= $this->Number->format(++$i) ?></td>
											<td><?php echo $showItemName[$key].' ('.$showItemUnit[$key]; ?>)</td>
											<td><?php echo $showItemData; ?></td>
											<td><?php echo $showItemrate[$key]; ?></td>
											<td><?php echo $showItemrate[$key]*$showItemData; ?></td>
											
										</tr>
										 <?php } ?>
										
									</tbody>
								</table>
							</div>
						</div>
					</div>
					 <?php }else{ ?>
					 <div class="panel-body">   
						<div class="col-md-6">No Item Found</div>
						</div>
					</div>
					 <?php } ?>
			</div>
		</div>
	</div>                    
</div>
<?= $this->Html->script('plugins/bootstrap/bootstrap-datepicker.js',['block'=>'jsDatePicker']) ?>
<?= $this->Html->script('plugins/bootstrap/bootstrap-select.js',['block'=>'jsSelect']) ?>
<?= $this->Html->script('plugins/jquery-validation/jquery.validate.js',['block'=>'jsValidate']) ?>
<?php
	$js="
	 
		$(document).on('keyup', '.wastage_quantity', function()
		{ 
			var total_qt=$(this).attr('total_qt');
			var wastage_quantity=$(this).val();
			var actual_quantity=total_qt-wastage_quantity;
			$(this).closest('tr').find('.actual_quantity').val(actual_quantity);
			
		});
	 
	";  
echo $this->Html->scriptBlock($js, array('block' => 'scriptBottom'));
?>