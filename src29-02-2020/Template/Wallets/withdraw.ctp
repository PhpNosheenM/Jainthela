<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}
</style>
<?php $this->set('title', 'Withdrawal'); ?>
<div class="page-content-wrap">
    <div class="page-title">                    
			<h2> Withdrawal</h2>
	</div> 
	 <div class="row">
				<div class="col-md-4">
					<div class="panel panel-default">
									<div class="panel-heading">
										<h3 class="panel-title">Withdrawal Amount</h3>
									</div>
					<?= $this->Form->create($wallet,['id'=>"jvalidate"]) ?>
							<div class="panel-body">
								 
								<div class="form-group">
									<label>Customer</label>
									<?= $this->Form->select('customer_id',$customerList,['class'=>'form-control select customer_id','label'=>false,'empty' => '--Select--']) ?>
								</div>
								<div class="form-group">
								
								<div class="form-group">
									<label>Available Amount</label>
									<?= $this->Form->control('due_amount',['id'=>'total_amount','class'=>'form-control total_amount','placeholder'=>'Due Amount','label'=>false, 'readonly'=>true,'type'=>'number']) ?>
								</div>
								 
								<div class="form-group">
									<label>Withdraw Amount</label>
									<?= $this->Form->control('used_amount',['id'=>'benifit','class'=>'form-control','placeholder'=>'Withdrawal Amount','label'=>false,'type'=>'number']) ?>
									<span class="help-block"></span>
								</div>
								 
								<div class="form-group">
									<label>Narration</label>
									<?= $this->Form->control('narration',['id'=>'narration','class'=>'form-control','placeholder'=>'Narration','label'=>false]) ?>
									<span class="help-block"></span>
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
			
		</div>
						<div class="col-md-8">
			       <div class="panel panel-default">
				    <div class="panel-heading">
						<h3 class="panel-title">LIST Withdrawal Amount</h3>
					     <div class="pull-right">
						    <div class="pull-left">
								
							</div> 	   
					     </div> 
					    <div class="panel-body">
				            <div class="table-responsive">
								<table class="table table-bordered">
									<thead>
										<tr>
											<th><?= ('SN.') ?></th>
											<th><?= ('Customer') ?></th>
											<th><?= ('Withdrawal Amount') ?></th>
											<th><?= ('Created On') ?></th>
										</tr>
									</thead>
									<tbody>                                            
										<?php $i = 0;
										foreach ($wallets as $data): ?>
										<tr>
											<td><?= $this->Number->format(++$i) ?></td>
											<td><?= h($data->customer->name) ?></td>
											<td><?= h($data->used_amount) ?></td>
											<td><?= h($data->created_on) ?></td>
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
<?= $this->Html->script('plugins/fileinput/fileinput.min.js',['block'=>'jsFileInput']) ?>
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
		});
		
		
		$(document).on("change", ".customer_id", function(){
			var due= $("option:selected", this).attr("due");
			$("#total_amount").val(due);
			$("#benifit").attr("max" ,due);
			
		});
		';
echo $this->Html->scriptBlock($js, array('block' => 'scriptBottom'));
?>