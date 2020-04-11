<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}
</style>
<?php $this->set('title', 'unit'); ?>
<div class="content-frame">
	<div class="content-frame-top">
        <div class="page-title">
			<h2> UNIT</h2>
		</div>
		<div class="pull-right">
			<?php  if(($status=='Deactive') || ($status=='deactive')){
						$class1="btn btn-default";
						$class2="btn btn-xs blue";
					}else{
						$class1="btn btn-xs blue";
						$class2="btn btn-default";
					}
			 ?>
				<?php echo $this->Html->link('All',['controller'=>'Units','action' => 'index?status=Active'],['escape'=>false,'class'=>$class1]); ?>
				<?php echo $this->Html->link('Archive',['controller'=>'Units','action' => 'index?status=Deactive'],['escape'=>false,'class'=>$class2]); ?>&nbsp;
		</div>
	</div>
	<div class="row">
		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading">
				<?php if(!empty($ids)){ ?>
					<h3 class="panel-title">EDIT UNITS</h3>
				<?php }else{ ?>	
					<h3 class="panel-title">ADD UNITS</h3>
				<?php } ?>
				</div>
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
						<label>Division Factor</label>
						<?= $this->Form->control('division_factor',['class'=>'form-control','placeholder'=>'Division Factor','label'=>false]) ?>
					</div>
					<div class="form-group">
						<label>Status</label>
						<?php $options['Active'] = 'Active'; ?>
						<?php $options['Deactive'] = 'Deactive'; ?>
						<?= $this->Form->select('status',$options,['class'=>'form-control select','label'=>false]) ?>
					</div>
				     
				</div>
				<div class="panel-footer">
                 <center>
						<?= $this->Form->button(__('Submit'),['class'=>'btn btn-primary']) ?>
				 </center>
               </div> 
			    <?= $this->Form->end() ?>
			</div>
		</div>
		<div class="col-md-8">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">LIST UNITS</h3>
				  <div class="pull-right">
					<div class="pull-left">
								
					</div> 
				 </div>
				</div> 
           <div class="panel-body">
					    <?php $page_no=$this->Paginator->current('unit'); $page_no=($page_no-1)*20; ?>
			    <div class="table-responsive">
				     <table class="table datatable">
					<thead>
						<tr>
							<th><?= ('SN.') ?></th>
							<th><?= ('Unit Name') ?></th>
							<th><?= ('Long Name') ?></th>
							<th><?= ('Short Name') ?></th>
							<th><?= ('Division Factor') ?></th>
							<th><?= ('Status') ?></th>
							
							<th scope="col" class="actions"><?= __('Actions') ?></th>
						</tr>
					</thead>
					       <tbody>                                            
							   <?php 
						$i = $paginate_limit*($this->Paginator->counter('{{page}}')-1);
						foreach ($units as $unit): ?>
						<?php
						$unit_id = $EncryptingDecrypting->encryptData($unit->id);
						?>
						<tr>
							<td><?= $this->Number->format(++$i) ?></td>
							<td><?= h($unit->unit_name) ?></td>
							<td><?= h($unit->longname) ?></td>
							<td><?= h($unit->shortname) ?></td>
							<td><?= h($unit->division_factor) ?></td>
							<td><?= h($unit->status) ?></td>
							<td class="actions">
								<?= $this->Html->link(__('<span class="fa fa-pencil"></span>'), ['action' => 'index', $unit_id],['class'=>'btn btn-primary  btn-condensed btn-sm','escape'=>false]) ?>
								<?php if($unit->status=="Active"){ ?>
								<?= $this->Form->postLink('<span class="fa fa-remove"></span>', ['action' => 'delete', $unit_id], ['class'=>'btn btn-danger btn-condensed btn-sm','confirm' => __('Are you sure you want to delete?'),'escape'=>false]) ?>
								<?php } ?>
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
