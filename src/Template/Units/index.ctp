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
			<?= $this->Form->create($unit,['id'=>"jvalidate"]) ?>
				<div class="panel-body">
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
					<div class="form-group">
						<label>Status</label>
						<?php $options['Active'] = 'Active'; ?>
						<?php $options['Deactive'] = 'Deactive'; ?>
						<?= $this->Form->control('status',['class'=>'form-control select','options'=>$options, 'placeholder'=>'Select...','label'=>false]) ?>
					</div>
				</div>
				<div class="panel-footer">
					<div class="col-md-offset-3 col-md-4">
						<?= $this->Form->button(__('Submit'),['class'=>'btn btn-primary']) ?>
					</div>
				</div>
			<?= $this->Form->end() ?>
		</div>
	</div>
	<!-- END CONTENT FRAME LEFT -->
	
	<!-- START CONTENT FRAME BODY -->
	<div class="content-frame-body">
		<div class="panel panel-default">
			<div class="panel-body">
				<?php $page_no=$this->Paginator->current('Units'); $page_no=($page_no-1)*20; ?>
				<div class="table-responsive">
				<table class="table table-bordered">
					<thead>
						<tr>
							<th><?= ('SN.') ?></th>
							<th><?= ('Unit Name') ?></th>
							<th><?= ('Long Name') ?></th>
							<th><?= ('Short Name') ?></th>
							<th><?= ('Status') ?></th>
							
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
							<td><?= h($unit->status) ?></td>
							<td class="actions">
								<?= $this->Html->link(__('<span class="fa fa-pencil"></span>'), ['action' => 'index', $unit->id],['class'=>'btn btn-primary  btn-condensed btn-sm','escape'=>false]) ?>
								<?= $this->Form->postLink('<span class="fa fa-remove"></span>', ['action' => 'delete', $unit->id], ['class'=>'btn btn-danger btn-condensed btn-sm','confirm' => __('Are you sure you want to delete?', $unit->id),'escape'=>false]) ?>
							</td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
				</div>
			</div>
			<div class="panel-footer">
				<div class="paginator pull-right">
					<ul class="pagination">
						<?= $this->Paginator->first('<< ' . __('first')) ?>
						<?= $this->Paginator->prev('< ' . __('previous')) ?>
						<?= $this->Paginator->numbers() ?>
						<?= $this->Paginator->next(__('next') . ' >') ?>
						<?= $this->Paginator->last(__('last') . ' >>') ?>
					</ul>
					<p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
				</div>
			</div>
		</div>
	</div>
	<!-- END CONTENT FRAME BODY -->
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
