<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}
</style>
<?php $this->set('title', 'Plans'); ?>
<div class="page-content-wrap">
    <div class="page-title">                    
			<h2> Plans</h2>
	</div> 
	 <div class="row">
				<div class="col-md-4">
					<div class="panel panel-default">
									<div class="panel-heading">
										<h3 class="panel-title">ADD Plans</h3>
									</div>
									<?= $this->Form->create($plan,['id'=>"jvalidate"]) ?>
							<div class="panel-body">
								 
								<div class="form-group">
									<label>Plan Type</label>
									<?php $options1['Membership'] = 'Membership'; ?>
									<?php $options1['Wallet'] = 'Wallet'; ?>
									<?= $this->Form->select('plan_type',$options1,['class'=>'form-control select plan_type','placeholder'=>'Select...','label'=>false]) ?>
								</div>

								<div class="form-group" id="st" >
									<label>Date Duration</label>
									<div class="input-group">
										<?= $this->Form->control('start_date',['class'=>'form-control datepicker start_date','placeholder'=>'Valid From','label'=>false,'type'=>'text','data-date-format' => 'dd-mm-yyyy']) ?>
										<span class="input-group-addon add-on"> - </span>
										<?= $this->Form->control('end_date',['class'=>'form-control datepicker end_date','placeholder'=>'Valid To','label'=>false,'type'=>'text','data-date-format' => 'dd-mm-yyyy']) ?>
									</div>
								</div>
								
								
								<div class="form-group">
									<label>Name</label>
									<?= $this->Form->control('name',['class'=>'form-control','placeholder'=>'Name','label'=>false]) ?>
									<span class="help-block"></span>
								</div>
								<div class="form-group">
									<label>Amount</label>
									<?= $this->Form->control('amount',['id'=>'amount','class'=>'form-control','placeholder'=>'Amount','label'=>false]) ?>
									<span class="help-block"></span>
								</div>
								<div class="form-group">
									<label>Benifit Percentage</label>
									<?= $this->Form->control('benifit_per',['id'=>'benifit_per','class'=>'form-control','placeholder'=>'Benifit Percentage','label'=>false,'max'=>'100']) ?>
									<span class="help-block"></span>
								</div>
								<div class="form-group">
									<label>No Of Days</label>
									<?= $this->Form->control('no_of_days',['id'=>'no_of_days','class'=>'form-control','placeholder'=>'No Of Days','label'=>false]) ?>
									<span class="help-block"></span>
								</div>
								
								
								
								<div class="form-group">
									<label>Status</label>
									<?php $options['Active'] = 'Active'; ?>
									<?php $options['Deactive'] = 'Deactive'; ?>
									<?= $this->Form->select('status',$options,['class'=>'form-control select','placeholder'=>'Select...','label'=>false]) ?>
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
						<h3 class="panel-title">LIST Plans</h3>
					     <div class="pull-right">
						    <div class="pull-left">
								<?= $this->Form->create('Search',['type'=>'GET']) ?>
								<?= $this->Html->link(__(' Add New'), ['action' => 'index'],['style'=>'margin-top:-30px !important;','class'=>'btn btn-success','escape'=>false]) ?>
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
					    <div class="panel-body">
				            <div class="table-responsive">
								<table class="table table-bordered">
									<thead>
										<tr>
											<th><?= ('SN.') ?></th>
											<th><?= ('Name') ?></th>
											<th><?= ('Amount') ?></th>
											<th><?= ('Benifit Per') ?></th>
											<th><?= ('Total Amount') ?></th>
											<th><?= ('Type') ?></th>
											<th><?= ('Status') ?></th>
											<th scope="col" class="actions"><?= __('Actions') ?></th>
										</tr>
									</thead>
									<tbody>
										<?php $i = $paginate_limit*($this->Paginator->counter('{{page}}')-1);
										foreach ($plans as $data): ?>
										<tr>
											<td><?= $this->Number->format(++$i) ?></td>
											<td><?= h($data->name) ?></td>
											<td><?= h($data->amount) ?></td>
											<td><?= h($data->benifit_per) ?></td>
											<td><?= h($data->total_amount) ?></td>
											<td><?= h($data->plan_type) ?></td>
											<td><?= h($data->status) ?></td>
											<td class="actions">
												<?php
													$promotion_id = $EncryptingDecrypting->encryptData($data->id);
												?>
												<?= $this->Html->link(__('<span class="fa fa-pencil"></span>'), ['action' => 'index', $promotion_id],['class'=>'btn btn-primary  btn-condensed btn-sm','escape'=>false]) ?>
												<?= $this->Form->postLink('<span class="fa fa-remove"></span>', ['action' => 'delete', $promotion_id], ['class'=>'btn btn-danger btn-condensed btn-sm','confirm' => __('Are you sure you want to delete ?'),'escape'=>false]) ?>
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
</div>
<?= $this->Html->script('plugins/bootstrap/bootstrap-datepicker.js',['block'=>'jsDatePicker']) ?>
<?= $this->Html->script('plugins/fileinput/fileinput.min.js',['block'=>'jsFileInput']) ?>
<?= $this->Html->script('plugins/bootstrap/bootstrap-select.js',['block'=>'jsSelect']) ?>
<?= $this->Html->script('plugins/jquery-validation/jquery.validate.js',['block'=>'jsValidate']) ?>
<?php
   $js='var jvalidate = $("#jvalidate").validate({
		ignore: [],
		rules: {                                            
				name: {
						required: true,
				},no_of_days: {
						required: true,
				},
				
			}                                        
		});
		$(document).on("keyup", "#benifit_per,#amount", function(){
			var benifit_per=parseFloat($("#benifit_per").val());
			if(!benifit_per){ benifit_per=0; }
			var amount=parseFloat($("#amount").val());
			if(!amount){ amount=0; }
			
			var remainging=Math.round((amount*benifit_per)/100);
			if(!remainging){ remainging=0; }
			var total_amount=parseFloat(amount+remainging);
			$("#total_amount").val(total_amount);
		});
		
		/* $(document).on("change", ".plan_type", function(){
			 var plan_type=$("option:selected", this).val();
			 if(plan_type=="Membership"){
				 $("#st").show();
			 }else{
				$("#st").hide();
				$(".start_date").val("");
				$(".end_date").val("");
			 }
		}); */
		
		';     
echo $this->Html->scriptBlock($js, array('block' => 'scriptBottom')); 		
?>