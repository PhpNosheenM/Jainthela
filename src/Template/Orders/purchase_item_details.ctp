<?php $url_excel="/?".urldecode($url); ?>
<style>
.backbutton {
     background: #a6c8e6;
    color: #132339;
    font-size: 12px;
}
</style>
<?php $this->set('title', 'Purchase Detail'); ?>
<div class="page-content-wrap">

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
			
				<div class="panel-heading">
					<h3 class="panel-title"><strong>Fruit & Vegetables Purchase Detail</strong></h3>
					<div class="pull-right">
						<div class="pull-left">
							
							<?php //echo $this->Html->link( '<i class="fa fa-file-excel-o"></i> Export To Excel', '/Orders/PurchaseExcel/',['class' =>'btn btn-sm green tooltips pull-right','target'=>'_blank','escape'=>false,'data-original-title'=>'Download as excel']); ?>
							
							<?php echo $this->Html->link('Export To Excel',['controller'=>'Orders','action' => 'PurchaseExcel'.$url_excel.''],['escape'=>false,'class'=>'btn btn-default backbutton','target'=>'_blank','escape'=>false]); ?>
						</div> 
					</div> 	
				</div>
				<div class="panel-body">   			
					<div class="row">
					<?= $this->Form->create('Search',['type'=>'GET']) ?>
						<div class="form-group">
								<div class="col-md-4 col-xs-12">
									<div class="input-group">
									<span class="input-group-addon add-on"> Date </span>
										<?= $this->Form->control('to_date',['class'=>'form-control datepicker','placeholder'=>'To','label'=>false,'type'=>'text','data-date-format' => 'dd-mm-yyyy','value'=>date('d-m-Y',strtotime($to_date))]) ?>
										
										</div>
								</div>
								<div class="col-md-2 col-xs-12">
								
									<div class="input-group bootstrap-timepicker">
										<span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
										<?= $this->Form->control('order_time',['class'=>'form-control timepicker24','placeholder'=>'To','label'=>false,'type'=>'text','value'=>$order_time]) ?>
										
									</div>
                                            
								</div>
							<div class="input-group-btn">
								<?= $this->Form->button(__('Search'),['class'=>'btn btn-primary']) ?>
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
									<th><?= ('Item.') ?></th>
									<?php foreach($unit_variation_datas as $key=>$unit_variation_data){ ?>
										<th><?= $unit_variation_names[$unit_variation_data] ?></th>
									<?php } ?>
									<th><?= ('Total Qty') ?></th>
									<th><?= ('No. Of Order') ?></th>
									
								</tr>
							</thead>
							<tbody>
								
							<?php $i=0; foreach($QRdata as $item_id=>$row){ ?>
								  
								<tr>
									<td><?= $this->Number->format(++$i) ?></td>
									<td><?php echo $QRitemName[$item_id]; ?></td>
										<?php foreach($unit_variation_datas as $unit_variation_data){ ?>
											<td><?php echo @$row[$unit_variation_data]; ?></td>
										<?php } ?>
									<td><?php echo $OrderItemCount[$item_id]; ?></td>
									<td><?php echo count($OrderCount[$item_id]); ?></td>
									
								</tr>
								  <?php } ?>
							</tbody>
						</table>
					</div>
				</div>
				
			</div>
			
		</div>
	</div>
</div>
<?= $this->Html->script('plugins/bootstrap/bootstrap-datepicker.js',['block'=>'jsDatePicker']) ?>
<?= $this->Html->script('plugins/bootstrap/bootstrap-timepicker.js',['block'=>'jsTimePicker']) ?>
