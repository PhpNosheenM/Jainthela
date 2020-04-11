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
<?php $this->set('title', 'CANCEL ITEM'); ?>
<div class="page-content-wrap">
        <div class="page-title">                    
			<h2> LIST CANCEL ITEM</h2>
		
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
										<th><?= ('Driver Name') ?></th>
										<th><?= ('Item') ?></th>
										<th><?= ('Quantity') ?></th>
										<th><?= ('Status') ?></th>
										
										
									</tr>
								</thead>
								<tbody>                                            
									<?php $i = 0; 
									foreach ($challanRows as $challanRow): //pr($challanRow);
										$category_id =$challanRow->id;
									?>
									<tr>
										<td><?= $this->Number->format(++$i) ?></td>
										<td><?= h($challanRow->challan->driver->name) ?></td>
										<td><?= h($challanRow->item->name) ?>(<?= h($challanRow->item_variation->unit_variation->visible_variation) ?>)</td>
										<td><?= h($challanRow->quantity) ?></td>
										
										<td>
										
										<?= $this->Form->postLink('<span class="fa">Recive</span>', ['action' => 'itemRecive', $challanRow->id], ['class'=>'btn btn-danger  btn-sm','confirm' => __('Are you sure you Recive Item?'),'escape'=>false]) ?>
										
										</td>
										
									</tr>
									<?php endforeach; ?>
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
