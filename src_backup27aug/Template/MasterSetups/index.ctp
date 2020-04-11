<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}
</style>
<?php $this->set('title', 'Master Setups'); ?>
<div class="content-frame">
	<div class="content-frame-top">
        <div class="page-title">
			<h2> Master Setups</h2>
		</div>
		<div class="pull-right">
			
		</div>
	</div>
	<div class="row">
		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading">
				<?php if(!empty($ids)){ ?>
					<h3 class="panel-title">EDIT Master Setups</h3>
				<?php }else{ ?>	
					<h3 class="panel-title">ADD Master Setups</h3>
				<?php } ?>
				</div>
				<?= $this->Form->create($masterSetup,['id'=>"jvalidate"]) ?>
		        <div class="panel-body">
					<div class="form-group">
						<label>Unit Name</label>
						<?= $this->Form->control('delivery_message',['class'=>'form-control','placeholder'=>'Unit Name','label'=>false]) ?>
						<span class="help-block"></span>
					</div>
				</div>
				<?php if(!empty($ids)){ ?>
				<div class="panel-footer">
                 <center>
						<?= $this->Form->button(__('Submit'),['class'=>'btn btn-primary']) ?>
				 </center>
               </div> 
			   <?php }?>	
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
					    <?php $page_no=0; ?>
			    <div class="table-responsive">
				        <table class="table table-bordered">
					<thead>
						<tr>
							<th><?= ('SN.') ?></th>
							<th><?= ('Delivery Message') ?></th>
							<th scope="col" class="actions"><?= __('Actions') ?></th>
						</tr>
					</thead>
					       <tbody>                                            
							   <?php 
						$i = 0;
						foreach ($MasterSetups as $unit): ?>
						<?php
						$unit_id = $EncryptingDecrypting->encryptData($unit->id);
						?>
						<tr>
							<td><?= $this->Number->format(++$i) ?></td>
							<td><?= h($unit->delivery_message) ?></td>
							
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
