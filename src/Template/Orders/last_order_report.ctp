<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}
</style>
<?php $this->set('title', 'Orders'); ?><!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong>Customer Wise Orders List</strong></h3>
					<div class="pull-right">
					<div class="pull-right">
					<div class="pull-left">
						<?= $this->Form->create('Search',['type'=>'GET']) ?>
						
						<div class="col-md-4 col-xs-12">
									<div class="input-group">
									<span class="input-group-addon add-on"> FROM </span>
										<?= $this->Form->control('from_date',['class'=>'form-control datepicker','placeholder'=>'From','label'=>false,'type'=>'text','data-date-format' => 'dd-mm-yyyy','value'=>date('d-m-Y',strtotime(@$from_date))]) ?>
										<span class="input-group-addon add-on"> TO </span>
										<?= $this->Form->control('to_date',['class'=>'form-control datepicker','placeholder'=>'To','label'=>false,'type'=>'text','data-date-format' => 'dd-mm-yyyy','value'=>date('d-m-Y',strtotime(@$to_date))]) ?>
										
										</div>
								</div>
								
							<div class="form-group" style="display:inline-table">
								<div class="input-group">
									<div class="input-group-addon">
										<span class="fa fa-search"></span>
									</div>
									<input type="hidden" name="status" value="<?php echo @$status; ?>">
									<?= $this->Form->control('search',['class'=>'form-control','placeholder'=>'Search...','label'=>false,'value'=>$search]) ?>
									<div class="input-group-btn">
										<?= $this->Form->button(__('Search'),['class'=>'btn btn-primary']) ?>
									</div>
								</div>
							</div>
						<?= $this->Form->end() ?>
					</div> 
				</div>
				</div> 	
				</div>
				<div class="panel-body">    
					<div class="table-responsive">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th><?= ('SNo.') ?></th>
									<th><?= ('Customer Name') ?></th>
									<th><?= ('Last Order Date') ?></th>
									<th><?= ('Total Order') ?></th>
								</tr>
							</thead>
							<tbody>                                            
								
								
								  <?php $i=1; foreach ($AllCustomers as $key=>$AllCustomer): 
								  $customer_id = $EncryptingDecrypting->encryptData($key);
								  ?>
									<tr>
										<td><?php echo $i++; ?></td>
										<td><?php echo $this->Html->link(@$AllCustomer,['controller'=>'Customers','action' => 'view', $customer_id, 'print'],['target'=>'_blank']); ?></td>
										<td><?php echo $CustomerLastOrder[$key]; ?></td>
										<td><?php echo $CustomerWiseOrder[$key]; ?></td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
				
			</div>
			
		</div>
	</div>                    
	
</div>
<?= $this->Html->script('plugins/bootstrap/bootstrap-select.js',['block'=>'jsSelect']) ?>
<?= $this->Html->script('plugins/jquery-validation/jquery.validate.js',['block'=>'jsValidate']) ?>
<?= $this->Html->script('plugins/bootstrap/bootstrap-datepicker.js',['block'=>'jsDatePicker']) ?>