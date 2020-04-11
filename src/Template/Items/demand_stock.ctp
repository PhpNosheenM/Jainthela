<?php $url_excel="/?".$url; ?>
<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}
</style>
<?php $this->set('title', 'Demand Stock'); ?><!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong>Demand Stock Report</strong></h3>
					<div class="pull-right">
						<div class="pull-left">
							<?php echo $this->Html->link('Export To Excel',['controller'=>'Items','action' => 'demandStockExcel'.$url_excel.''],['escape'=>false,'class'=>'btn btn-default backbutton','target'=>'_blank','escape'=>false]); ?>
						</div> 
					</div> 	
				</div>
				 <div class="panel-body">   			
					<div class="row">
					<?= $this->Form->create('Search',['type'=>'GET']) ?>
						
						<div class="col-md-2">
							<div class="form-group">
								<label>Brands</label>
								<?php echo $this->Form->select('brand_id',$Brands, ['empty'=>'--Select--','label' => false,'class' => 'form-control input-sm ledger select', 'data-live-search'=>true,'value'=>@$brand_id]); ?>
								
							</div>
						</div>
						
						<div class="col-md-2">
							<div class="form-group">
								<label>Categories</label>
								<?php echo $this->Form->select('category_id',$Categories, ['empty'=>'--Select--','label' => false,'class' => 'form-control input-sm ledger select', 'data-live-search'=>true,'value'=>@$category_id]); ?>
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
				<?php $LeftTotal=0; $RightTotal=0; ?>
				<div class="panel-body">    
					<div class="table-responsive">
									<?php
				if(!empty($DemandStocks))
				{
				?>
					<table class="table table-bordered  table-condensed" width="100%" border="1">
						<thead>
							<tr>
								<th scope="col"> SR. </th>
								<th scope="col">Item Name</th>
								<th scope="col">Virtual Quantity</th>
								<th scope="col">Demand Quantity</th>
							</tr>
						</thead>
						<tbody><?php $sno = 1;  $total_pending_amt=0;
								foreach ($DemandStocks as $DemandStock): ?>
									
										<tr >
											<td><?php echo $sno++; ?></td>
											<td><?php echo $DemandStock->item->name; ?>( <?php echo $DemandStock->unit_variation->visible_variation; ?>)</td>
											<td><?php echo $DemandStock->virtual_stock; ?></td>
											<td><?php echo $DemandStock->demand_stock; ?></td>
											
										</tr>
							<?php endforeach;   ?>
						</tbody>
						
					</table>
				<?php } ?>
					
					
					
					</div>
				</div>
			</div>
		</div>
	</div>                    
</div>
<?= $this->Html->script('plugins/bootstrap/bootstrap-datepicker.js',['block'=>'jsDatePicker']) ?>
<?= $this->Html->script('plugins/bootstrap/bootstrap-select.js',['block'=>'jsSelect']) ?>