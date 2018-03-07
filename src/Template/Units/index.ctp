<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}
</style>
<div class="content-frame">
	
	<!-- START CONTENT FRAME TOP -->
	<div class="content-frame-top">                        
		<div class="page-title">                    
			<h2><span class="fa fa-arrow-circle-o-left"></span> Units</h2>
		</div>                                      
		<div class="pull-right">
			<button class="btn btn-default content-frame-left-toggle"><span class="fa fa-bars"></span></button>
		</div>                        
	</div>
	<!-- END CONTENT FRAME TOP -->
	
	<!-- START CONTENT FRAME LEFT -->
	<div class="content-frame-left">
		<div class="panel panel-default">
			<div class="panel-body">
				<?= $this->Form->create($unit,['id'=>"jvalidate"]) ?>
					<div class="form-group">
						<label>Unit Name</label>
						<?= $this->Form->control('unit_name',['class'=>'form-control','placeholder'=>'Unit Name','label'=>false]) ?>
						<span class="help-block"></span>
					</div>
					<div class="form-group">
						<label>Long Name</label>
						<?= $this->Form->control('longname',['class'=>'form-control','placeholder'=>'Long Name','label'=>false]) ?>
					</div>
					<div class="form-group">
						<label>Short Name</label>
						<?= $this->Form->control('shortname',['class'=>'form-control','placeholder'=>'Short Name','label'=>false]) ?>
					</div>
			</div>
			<div class="panel-footer">
				<div class="col-md-offset-3 col-md-4">
				<?= $this->Form->button(__('Submit'),['class'=>'btn btn-primary']) ?>
				</div>
			</div>
		</div>
	</div>
	<!-- END CONTENT FRAME LEFT -->
	
	<!-- START CONTENT FRAME BODY -->
	<div class="content-frame-body">
		<div class="panel panel-default">
			<div class="panel-body">
				<table class="table datatable">
					<thead>
						<tr>
							<th><?= ('SN.') ?></th>
							<th><?= ('Unit Name') ?></th>
							<th><?= ('Long Name') ?></th>
							<th><?= ('Short Name') ?></th>
							
							<th scope="col" class="actions"><?= __('Actions') ?></th>
						</tr>
					</thead>
					<tbody>                                            
						<?php $i=0; foreach ($units as $unit): ?>
						<tr>
							<td><?= $this->Number->format(++$i) ?></td>
							<td><?= h($unit->unit_name) ?></td>
							<td><?= h($unit->longname) ?></td>
							<td><?= h($unit->shortname) ?></td>
							<td class="actions">
								<?= $this->Form->button(__('<span class="fa fa-pencil"></span>'),['class'=>'btn btn-primary  btn-condensed btn-sm']) ?>
								<?= $this->Form->postLink('<span class="fa fa-remove"></span>', ['action' => 'delete', $unit->id], ['class'=>'btn btn-danger btn-condensed btn-sm','confirm' => __('Are you sure you want to delete # {0}?', $unit->id),'escape'=>false]) ?>
							</td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<!-- END CONTENT FRAME BODY -->
</div>
<!-- END CONTENT FRAME -->
<?php

$this->Html->script('plugins/jquery-validation/jquery.validate.js',['block' =>'jsValidate']); 
$this->Html->script('plugins/datatables/jquery.dataTables.min.js',['block' =>'jsDataTables']);
?>
 <script type="text/javascript" src="plugins/datatables/jquery.dataTables.min.js"></script>
<script type="text/javascript">
            var jvalidate = $("#jvalidate").validate({
                ignore: [],
                rules: {                                            
                        unit_name: {
                                required: true,
                        },
                        longname: {
                                required: true,
                        },
                       
                    }                                        
                });                                    

        </script>