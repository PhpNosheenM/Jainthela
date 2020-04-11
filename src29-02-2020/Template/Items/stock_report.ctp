<?php $url_excel="/?".urldecode($url); ?>
<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}
</style>
<?php $this->set('title', 'Stock Report'); ?><!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong>Stock Report</strong></h3>
					<div class="pull-right">
						<div class="pull-left">
						<?php echo $this->Html->link('Export To Excel',['controller'=>'Items','action' => 'stockReportExcel'.$url_excel.''],['escape'=>false,'class'=>'btn btn-default backbutton','target'=>'_blank','escape'=>false]); ?>
						</div> 
					</div> 	
				</div>
				<div class="panel-body">   			
					<div class="row">
					<?= $this->Form->create('Search',['type'=>'GET']) ?>
						
						<div class="col-md-2">
							<div class="form-group">
								<label>City</label>
								<?php echo $this->Form->select('city_id',$Cities, ['empty'=>'--Select--','label' => false,'class' => 'form-control input-sm ledger select', 'data-live-search'=>true,'value'=>$city_id]); ?>
								
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<label>Location</label>
								<?php echo $this->Form->select('location_id',$Locations, ['empty'=>'--Select--','label' => false,'class' => 'form-control input-sm ledger select', 'data-live-search'=>true,'value'=>$location_id]); ?>
								
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<label>Brands</label>
								<?php echo $this->Form->select('brand_id',$Brands, ['empty'=>'--Select--','label' => false,'class' => 'form-control input-sm ledger select', 'data-live-search'=>true,'value'=>$brand_id]); ?>
								
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<label>Items</label>
								<?php echo $this->Form->select('item_id',$Itemdatas, ['empty'=>'--Select--','label' => false,'class' => 'form-control input-sm ledger select', 'data-live-search'=>true,'value'=>@$item_id]); ?>
								
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
								<label></label></br/>
								<?= $this->Form->button(__('Search'),['class'=>'btn btn-primary','label'=>false]) ?>
							</div>
						</div>
						
						<?= $this->Form->end() ?>
					</div>
				</div>  
				<?php if(empty($location_id)){ ?>
				<div class="panel-body">    
					<div class="table-responsive">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th><?= ('SNo.') ?></th>
									<th><?= ('Item Name') ?></th>
									<th><?= ('MRP') ?></th>
									<th><?= ('Variation Name') ?></th>
									<th><?= ('Closing Stock') ?></th>
									<th><?= ('Unit rate') ?></th>
									<th><?= ('Amount') ?></th>
								</tr>
							</thead>
							<tbody>                                            
								<?php $i = 0; $total_amt=0; ?>
								
								   <?php foreach($showItems as $showItem){ 
								   $item_var_size=(sizeof($showItem));
									//$amt=$showItem['stock']*$showItem['unit_rate'];
									//$total_amt+=$amt;
									$rt=round(($showItem['amount']/$showItem['stock']),2);
								   ?>
								<tr>
									<td ><?= $this->Number->format(++$i) ?></td>
									<td><?php echo ($showItem['item_name']); ?></td>
									<td><?php echo ($showItem['mrp']); ?></td>
									<td><?php echo ($showItem['var_name']); ?></td>
									<td><?php echo ($showItem['stock']); ?></td>
									<td><?php echo ($rt); ?></td>
									<td><?php echo ($showItem['amount']); ?></td>
									
								</tr>
								<?php @$total_amt+=@$showItem['amount']; } ?>
								<tr>
									<td colspan="6" style="text-align:right">Total</td>
									<td><?= h($total_amt) ?></td>
								</tr>
								  
							</tbody>
						</table>
					</div>
				</div>
				<?php }else{  ?>
				<div class="panel-body">    
					<div class="table-responsive">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th><?= ('SNo.') ?></th>
									<th><?= ('Item Name') ?></th>
									<th><?= ('MRP') ?></th>
									<th><?= ('Variation Name') ?></th>
									<th><?= ('Closing Stock') ?></th>
									<th><?= ('Unit rate') ?></th>
									<th><?= ('Amount') ?></th>
								</tr>
							</thead>
							<tbody>                                            
								<?php $i = 0; $total_amt=0; ?>
								
								   <?php foreach($showItems as $showItem){ 
								   $item_var_size=(sizeof($showItem));
									//$amt=$showItem['stock']*$showItem['unit_rate'];
									//$total_amt+=$amt;
									$rt=round(($showItem['amount']/$showItem['stock']),2);
								   ?>
								<tr>
									<td ><?= $this->Number->format(++$i) ?></td>
									<td><?php echo ($showItem['item_name']); ?></td>
									<td><?php echo ($showItem['mrp']); ?></td>
									<td><?php echo ($showItem['var_name']); ?></td>
									<td><?php echo ($showItem['stock']); ?></td>
									<td><?php echo ($rt); ?></td>
									<td><?php echo ($showItem['amount']); ?></td>
									
								</tr>
								<?php @$total_amt+=@$showItem['amount']; } ?>
								<tr>
									<td colspan="6" style="text-align:right">Total</td>
									<td><?= h($total_amt) ?></td>
								</tr>
								  
							</tbody>
						</table>
					</div>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>                    
</div>
<?= $this->Html->script('plugins/bootstrap/bootstrap-datepicker.js',['block'=>'jsDatePicker']) ?>
<?= $this->Html->script('plugins/bootstrap/bootstrap-select.js',['block'=>'jsSelect']) ?>