<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}

</style>
<?php $this->set('title', 'Super Admin'); ?>
<div class="page-content-wrap">
        <div class="page-title">
			<h2><span class="fa fa-arrow-circle-o-left"></span> Super Admin</h2>
		</div> 
	<div class="row">
				<div class="col-md-4">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">ADD Super Admin</h3>
						</div>
						<?= $this->Form->create($superAdmin,['id'=>"jvalidate",'type'=>'file']) ?>
						<?php $js=''; ?>
						<div class="panel-body">
						    <div class="form-group">
									<label>Name</label>
									<?= $this->Form->control('name',['class'=>'form-control','placeholder'=>'Name','label'=>false]) ?>
									<span class="help-block"></span>
					        </div>
							
							<div class="form-group">
									<label>Email</label>
									<?= $this->Form->control('email',['type'=>'mail','class'=>'form-control','placeholder'=>'Email','label'=>false]) ?>
									<span class="help-block"></span>
					        </div>
							<br>
							<br>
							<div class="form-group">
									<label>Mobile No.</label>
									<?= $this->Form->control('mobile_no',['type'=>'number','class'=>'form-control','placeholder'=>'Mobile No.','label'=>false,'minlength'=>'10','maxlength'=>'10','required']) ?>
									<span class="help-block"></span>
					        </div>
							 
							<div class="form-group" >
								<label>Role</label>
								<?= $this->Form->select('role_id',$roles,['id'=>'role_id','empty'=>'Select Role','class'=>'form-control select','label'=>false]) ?>
								<span class="help-block"></span>
							</div>
							
							<div class="form-group" >
								<label>City</label>
								<?= $this->Form->select('city_id',$cities,['id'=>'city_id','empty'=>'Select City','class'=>'form-control select','label'=>false]) ?>
								<span class="help-block"></span>
							</div>
							
							<div class="form-group">
									<label>Username</label>
									<?= $this->Form->control('username',['class'=>'form-control','placeholder'=>'username','label'=>false]) ?>
									<span class="help-block"></span>
					        </div>

							<div class="form-group">
									<label>Password</label>
									<?= $this->Form->control('password',['class'=>'form-control','placeholder'=>'****','label'=>false,'value'=>'']) ?>
									<span class="help-block"></span>
					        </div>	
									 
							<div class="form-group">
								<label>Status</label>
								<?php $options['Active'] = 'Active'; ?>
								<?php $options['Deactive'] = 'Deactive'; ?>
								<?= $this->Form->select('status',$options,['class'=>'form-control select','label'=>false]) ?>
					        </div>
						</div>
						
					</div>
					<div class="panel-footer">
							 <center>
									<?= $this->Form->button(__('Submit'),['class'=>'btn btn-primary']) ?>
							 </center>
					</div>
			            <?= $this->Form->end() ?>
	            </div>
				
	            <div class="col-md-8">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">LIST Super Admin</h3>
						<div class="pull-right">
						<div class="pull-left">
							<?= $this->Form->create('Search',['type'=>'GET']) ?>
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
						<?php $page_no=$this->Paginator->current('banners'); $page_no=($page_no-1)*20; ?>
						<div class="table-responsive">
                            <table class="table table-bordered">
								<thead>
									<tr>
										<th><?= ('SN.') ?></th>
										<th><?= ('Name') ?></th>
										<th><?= ('Email') ?></th>
										<th><?= ('Mobile No.') ?></th>
										<th><?= ('City') ?></th>
										<th><?= ('Role') ?></th>
										<th><?= ('Username') ?></th>
										<th><?= ('Status') ?></th>
										<th scope="col" class="actions"><?= __('Actions') ?></th>
									</tr>
								</thead>
								<tbody>                                            
								<?php $i = $paginate_limit*($this->Paginator->counter('{{page}}')-1); ?>
								
								  <?php foreach ($superAdmins as $data): ?>
								<tr>
									<td><?= $this->Number->format(++$i) ?></td>
									<td><?= h($data->name) ?></td>
									<td><?= h($data->email) ?></td>
									<td><?= h($data->mobile_no) ?></td>
									<td><?= h($data->city->name) ?></td>
									<td><?= h($data->role->name) ?></td>
									<td><?= h($data->username) ?></td>
									<td><?= h($data->status) ?></td>
									
									<td class="actions">
										<?= $this->Html->link(__('<span class="fa fa-pencil"></span>'), ['action' => 'add',$data->id],['class'=>'btn btn-primary  btn-condensed btn-sm','escape'=>false]) ?>
										<?= $this->Form->postLink('<span class="fa fa-remove"></span>', ['action' => 'delete', $data->id], ['class'=>'btn btn-danger btn-condensed btn-sm','confirm' => __('Are you sure you want to delete?', $data->id),'escape'=>false]) ?>
									
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
				email: {
						required: true,
				},
				
			}                                        
		});
		 
		';  
echo $this->Html->scriptBlock($js, array('block' => 'scriptBottom')); 		
?>
