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
						</div> 
					</div> 	
				</div>
				<div class="panel-body">   			
					<div class="row">
					<?= $this->Form->create('Search',['type'=>'GET']) ?>
						<div class="col-md-3">
							<div class="form-group">
								<label>Under Accounting Group</label>
								<?= $this->Form->select('city_id',$Cities,['class'=>'form-control select', 'label'=>false]) ?>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>Under Accounting Group</label>
								<?= $this->Form->select('location_id',$Locations,['class'=>'form-control select', 'label'=>false]) ?>
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
				<div class="panel-body">    
					<div class="table-responsive">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th><?= ('SNo.') ?></th>
									<th><?= ('Item Name') ?></th>
									<th><?= ('Closing Stock') ?></th>
									<th><?= ('Unit rate') ?></th>
									<th><?= ('Amount') ?></th>
								</tr>
							</thead>
							<tbody>                                            
								<?php $i = 0; $total_amt=0; ?>
								
								   <?php foreach ($showItems as $showItem):  
										$amt=$showItem['stock']*$showItem['unit_rate'];
										$total_amt+=$amt;
								   ?>
								<tr>
									<td><?= $this->Number->format(++$i) ?></td>
									<td><?= h($showItem['item_name']) ?></td>
									<td><?= h($showItem['stock']) ?></td>
									<td><?= h($showItem['unit_rate']) ?></td>
									<td><?= h($amt) ?></td>
								</tr>
								<?php endforeach; ?>
								<tr>
									<th colspan="4" style="text-align:right">Total</th>
									<td><?= h($total_amt) ?></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>                    
</div>