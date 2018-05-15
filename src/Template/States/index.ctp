<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}
</style>
<?php $this->set('title', 'State'); ?>
<div class="page-content-wrap">
        <div class="page-title">                    
			<h2><span class="fa fa-arrow-circle-o-left"></span> STATES</h2>
		</div> 
	<div class="row">
				<div class="col-md-4">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">ADD STATE</h3>
						</div>
						<?= $this->Form->create($state,['id'=>"jvalidate"]) ?>
								<div class="panel-body">
									<div class="form-group">
										<label>State Name</label>
										<?= $this->Form->control('name',['class'=>'form-control','placeholder'=>'State Name','label'=>false]) ?>
										<span class="help-block"></span>
									</div>
									
									<div class="form-group">
										<label>Alias Name</label>
										<?= $this->Form->control('alias_name',['class'=>'form-control','placeholder'=>'Alias Name','label'=>false]) ?>
										<span class="help-block"></span>
									</div>
									
									<div class="form-group">
										<label>Status</label>
										<?php $options['Active'] = 'Active'; ?>
										<?php $options['Deactive'] = 'Deactive'; ?>
										<?= $this->Form->select('status',$options,['class'=>'form-control select', 'label'=>false]) ?>
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
				<div class="col-md-8">
			       <div class="panel panel-default">
				      <div class="panel-heading">
						<h3 class="panel-title">LIST STATES</h3>
					     <div class="pull-right">
						    <div class="pull-left">
									<?= $this->Form->create('Search',['type'=>'GET']) ?>
									<?= $this->Html->link(__('<span class="fa fa-plus"></span> Add State'), ['action' => 'index'],['style'=>'margin-top:-30px !important;','class'=>'btn btn-success','escape'=>false]) ?>
										<div class="form-group" style="display:inline-table">
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
                      <div class="panel-body">
								<div class="table-responsive">
									<table class="table table-bordered">
										<thead>
										<tr>
										<th><?= ('SN.') ?></th>
										<th><?= ('State') ?></th>
										<th><?= ('Alias Name') ?></th>
										<th><?= ('Status') ?></th>
										<th scope="col" class="actions"><?= __('Actions') ?></th>
										</tr>
										</thead>
										<tbody>                                            
											<?php $i = $paginate_limit*($this->Paginator->counter('{{page}}')-1); 
											foreach ($states as $state): ?>
											
											<tr>
											<td><?= $this->Number->format(++$i) ?></td>
											<td><?= h($state->name) ?></td>
											<td><?= h($state->alias_name) ?></td>
											<td><?= h($state->status) ?></td>
											<td class="actions">
											
											<?php
												$state_id = $EncryptingDecrypting->encryptData($state->id);
											?>
											
											<?= $this->Html->link(__('<span class="fa fa-pencil"></span>'), ['action' => 'index', $state_id],['class'=>'btn btn-primary  btn-condensed btn-sm','escape'=>false]) ?>
											<?= $this->Form->postLink('<span class="fa fa-remove"></span>', ['action' => 'delete', $state_id], ['class'=>'btn btn-danger btn-condensed btn-sm','confirm' => __('Are you sure you want to delete ?'),'escape'=>false]) ?>
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
     </div>
</div>	
<?= $this->Html->script('plugins/bootstrap/bootstrap-select.js',['block'=>'jsSelect']) ?>
<?= $this->Html->script('plugins/jquery-validation/jquery.validate.js',['block'=>'jsValidate']) ?>
<?php
   $js='var jvalidate = $("#jvalidate").validate({
		ignore: [],
		rules: {                                            
				name: {
						required: true,
				},
				
			}                                        
		});';  
echo $this->Html->scriptBlock($js, array('block' => 'scriptBottom')); 		
?>
