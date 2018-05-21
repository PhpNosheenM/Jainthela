<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}
</style>
<?php $this->set('title', 'Sales Report'); ?><!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong>SALES REPORT</strong></h3>
					<div class="pull-right">
						<div class="pull-left">
						</div> 
					</div> 	
				</div>
				<div class="panel-body">   			
					<div class="row">
					<?= $this->Form->create('Search',['type'=>'GET']) ?>
						<div class="form-group">
								
								
								<div class="col-md-4 col-xs-12">
									<div class="input-group">
									<span class="input-group-addon add-on"> FROM </span>
										<?= $this->Form->control('from_date',['class'=>'form-control datepicker','placeholder'=>'From','label'=>false,'type'=>'text','data-date-format' => 'dd-mm-yyyy','value'=>date('d-m-Y',strtotime($from_date))]) ?>
										<span class="input-group-addon add-on"> TO </span>
										<?= $this->Form->control('to_date',['class'=>'form-control datepicker','placeholder'=>'To','label'=>false,'type'=>'text','data-date-format' => 'dd-mm-yyyy','value'=>date('d-m-Y',strtotime($to_date))]) ?>
										</div>
								</div>
							<div class="input-group-btn">
								<?= $this->Form->button(__('Search'),['class'=>'btn btn-primary']) ?>
							</div>
						</div>
						
						<?= $this->Form->end() ?>
					</div>
				</div>  
				<?php $LeftTotal=0; $RightTotal=0;
				if($orders){
				?>
				<div class="panel-body">    
					<div class="table-responsive">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th><?= ('SNo.') ?></th>
									<th><?= ('Order No') ?></th>
									<th><?= ('Location') ?></th>
									<th><?= ('Sales Amount') ?></th>
									<th><?= ('GST') ?></th>
									<th><?= ('Total') ?></th>
								</tr>
							</thead>
							<tbody>                                            
								<?php $i = 0; ?>
								
								  <?php foreach ($orders as $order): //pr($order); exit; ?>
								<tr>
									<td><?= $this->Number->format(++$i) ?></td>
									<td><?= h($order->order_no) ?></td>
									<td><?= h($order->location->name) ?></td>
									<td><?= h($order->total_amount) ?></td>
									<td><?= h($order->total_gst) ?></td>
									<td><?= h($order->grand_total) ?></td>
								</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
				<?php } ?>
		</div>
	</div>                    
</div>
<?= $this->Html->script('plugins/bootstrap/bootstrap-datepicker.js',['block'=>'jsDatePicker']) ?>
<?= $this->Html->script('plugins/bootstrap/bootstrap-select.js',['block'=>'jsSelect']) ?>