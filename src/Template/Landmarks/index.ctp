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
<?php $this->set('title', 'Area'); ?>
<div class="page-content-wrap">
        <div class="page-title">                    
			<h2> Area </h2>
		</div> 
		
	<div class="row">
				<div class="col-md-4">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">Add Area</h3>
						</div>
			<?= $this->Form->create($landmark,['id'=>'jvalidate','type'=>'file']) ?>
				<?php $js=''; ?>
				<div class="panel-body">
					<div class="form-group">
						<div class="form-group">
							<label>Routes </label>
							<?= $this->Form->select('route_id',$Routes,['class'=>'form-control select','label'=>false]) ?>
							<span class="help-block"></span>
						</div>
						<label>Warehouse </label>
						<?= $this->Form->select('location_id',$locations,['class'=>'form-control select','label'=>false]) ?>
						<span class="help-block"></span>
					</div>
					<div class="form-group">
						<label>Area Name</label>
						<?= $this->Form->control('name',['class'=>'form-control','placeholder'=>'Area Name','label'=>false]) ?>
					</div>
					
					<div class="form-group">
						<label>Status</label>
						<?php unset($options); $options['Active'] = 'Active'; ?>
						<?php $options['Deactive'] = 'Deactive'; ?>
						<?= $this->Form->select('status',$options,['class'=>'form-control select','label'=>false]) ?>
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
	<div class="col-md-8">
		<div class="panel panel-default">
			  <div class="panel-heading">
				<h3 class="panel-title">List Area</h3>
				 <div class="pull-right">
					<div class="pull-left">
							<?= $this->Form->create('Search',['type'=>'GET']) ?>
							<?= $this->Html->link(__(' Add Area'), ['action' => 'index'],['style'=>'margin-top:-30px !important;','class'=>'btn btn-success','escape'=>false]) ?>
								<div class="form-group" style="display:inline-table;width:500px;">
									<div class="input-group">
										<div class="input-group-addon">
											<span class="fa fa-search"></span>
										</div>
										<?= $this->Form->control('search',['class'=>'form-control','placeholder'=>'Search...','label'=>false]) ?>
											<div class="input-group-btn">
												<?= $this->Form->button(__('Search'),['class'=>'btn btn-primary']) ?>
											</div>
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
											<th><?= ('Area Name') ?></th>
											<th><?= ('Name') ?></th>
											<th><?= ('Status') ?></th>
											
											<th scope="col" class="actions"><?= __('Actions') ?></th>
										</tr>
									</thead>
									<tbody>                                            
										<?php $i = $paginate_limit*($this->Paginator->counter('{{page}}')-1); 
										foreach ($landmarks as $data): ?>
										<tr>
											<td><?= $this->Number->format(++$i) ?></td>
											<td><?= h($data->location->name) ?></td>
											<td><?= h($data->name) ?></td>
											<td><?= h($data->status) ?></td>
											<td class="actions">
												<?php
													$landmark_id = $EncryptingDecrypting->encryptData($data->id);
												?>
												
												<?= $this->Html->link(__('<span class="fa fa-pencil"></span>'), ['action' => 'index', $landmark_id],['class'=>'btn btn-primary  btn-condensed btn-sm','escape'=>false]) ?>
												<?= $this->Form->postLink('<span class="fa fa-remove"></span>', ['action' => 'delete', $landmark_id], ['class'=>'btn btn-danger btn-condensed btn-sm','confirm' => __('Are you sure you want to delete?'),'escape'=>false]) ?>
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
									<?= $this->Paginator->first(__('First')) ?>
									<?= $this->Paginator->prev(__('Previous')) ?>
									<?= $this->Paginator->numbers() ?>
									<?= $this->Paginator->next(__('Next')) ?>
									<?= $this->Paginator->last(__('Last')) ?>
								</ul>
								<p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
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
<?= $this->Html->script('plugins/fileinput/fileinput.min.js',['block'=>'jsFileInput']) ?>
<?= $this->Html->script('plugins/bootstrap/bootstrap-select.js',['block'=>'jsSelect']) ?>
<?= $this->Html->script('plugins/jquery-validation/jquery.validate.js',['block'=>'jsValidate']) ?>
<?php
   $js.='var jvalidate = $("#jvalidate").validate({
		ignore: [],
		rules: {                                            
				name: {
						required: true,
				},
				
			}                                        
		});
		
		$("#category_image").fileinput({
            showUpload: false,
            showCaption: false,
            showCancel: false,
            browseClass: "btn btn-danger",
			allowedFileExtensions: ["jpeg", "jpg", "png"],
			maxFileSize: 1024,
		}); 
		
		
		$(document).on("click", ".fileinput-remove-button", function(){
			$(this).closest("div.file-input").find("input[type=file]").attr("required",true);
		});
		';  
echo $this->Html->scriptBlock($js, array('block' => 'scriptBottom')); 		
?>
