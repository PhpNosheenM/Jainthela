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
<?php $this->set('title', 'ITEM'); ?>
<div class="page-content-wrap">
        <div class="page-title">                    
			<h2>Items</h2>
		
		<div class="pull-right">
			
		</div>
	</div>	
	<div class="row">
				
	<!-- END CONTENT FRAME LEFT -->

	<!-- START CONTENT FRAME BODY -->
	<div class="col-md-8">
		<div class="panel panel-default">
			  <div class="panel-heading">
				<h3 class="panel-title">LIST</h3>
				 <div class="pull-right">
					<div class="pull-left">
							<?= $this->Form->create('Search',['type'=>'GET']) ?>
							<input type="hidden" name="status" value="<?php echo @$status;?>">
								<div class="form-group" style="display:inline-table;width:500px;">
									<div class="input-group">
											
									</div>
								</div>
							<?= $this->Form->end() ?>
					</div> 
					
				 </div> 
				</div>	
				<div class="content-frame-body">
					<div class="panel panel-default">
						<div class="panel-body">
							<div class="table-responsive">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th><?= ('SN.') ?></th>
										<th><?= ('Item') ?></th>
										<th><?= ('Unit') ?></th>
										
										
									</tr>
								</thead>
								<tbody>                                            
									<?php $i = 0; 
									foreach ($Items as $key=>$data){ 
									foreach ($data->item_variations as $key=>$data1){ 
										
									?>
									<tr>
										<td><?= $this->Number->format(++$i) ?></td>
										<td><?php echo $data->name.' ( '.$data1->unit_variation->visible_variation.' )';?></td>
										<td><?php echo $data1->unit_variation->unit->unit_name;?></td>
										
										
										
									</tr>
									<?php } } ?>
								</tbody>
							</table>
							</div>
						</div>
						
					</div>
				</div>
	<!-- END CONTENT FRAME BODY -->
			</div> 
		</div> 
	</div> 
</div>

<!-- END CONTENT FRAME -->
<?= $this->Html->script('plugins/bootstrap/bootstrap-select.js',['block'=>'jsSelect']) ?>
<?= $this->Html->script('plugins/jquery-validation/jquery.validate.js',['block'=>'jsValidate']) ?>
<?php
   $js='var jvalidate = $("#jvalidate").validate({
		ignore: [],
		rules: {                                            
				unit_name: {
						required: true,
				},
				longname: {
						required: true,
				},
				shortname: {
						required: true,
				},
			   
			}                                        
		});';  
echo $this->Html->scriptBlock($js, array('block' => 'scriptBottom')); 		
?>
