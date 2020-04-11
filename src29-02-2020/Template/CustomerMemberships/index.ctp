<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}
</style>
<?php $this->set('title', 'Customer Membership'); ?>
<div class="page-content-wrap">
    <div class="page-title">                    
			<h2> Customer Membership</h2>
	</div> 
	 <div class="row">
				<div class="col-md-4">
					<div class="panel panel-default">
									<div class="panel-heading">
										<h3 class="panel-title">ADD Customer Membership</h3>
									</div>
									<?= $this->Form->create($customermembership,['id'=>"jvalidate"]) ?>
							<div class="panel-body">
								 
								<div class="form-group">
									<label>Customer</label>
									<?= $this->Form->select('customer_id',$customers,['class'=>'form-control select','empty'=>'---Select--Customer---','label'=>false,'required', 'data-live-search'=>true]) ?>
									<span class="help-block"></span>
								</div>
								
								<div class="form-group">
									<label>Plan</label>
									<?= $this->Form->select('plan_id',$plans,['class'=>'form-control select2me pln','empty'=>'---Select--Plans---','label'=>false,'required']) ?>
									<span class="help-block"></span>
								</div>
								
								<div class="form-group">
									<label>Amount</label>
									<?= $this->Form->control('amount',['id'=>'amount','class'=>'form-control amnt','placeholder'=>'Amount','label'=>false,'readonly']) ?>
									<span class="help-block"></span>
								</div>
								<div class="form-group">
									<label>Discount Percentage (%)</label>
									<?= $this->Form->control('discount_percentage',['id'=>'discount_percentage','class'=>'form-control','placeholder'=>'Discount Percentage','label'=>false,'readonly']) ?>
									<span class="help-block"></span>
								</div>
								
								<div class="form-group">
									<label>Discount Valid</label>
									<div class="input-group">
										<?= $this->Form->control('start_date',['class'=>'form-control start_date','placeholder'=>'Discount Valid From','label'=>false,'type'=>'text','data-date-format' => 'dd-mm-yyyy','readonly']) ?>
										<span class="input-group-addon add-on"> - </span>
										<?= $this->Form->control('end_date',['class'=>'form-control end_date','placeholder'=>'Discount Valid To','label'=>false,'type'=>'text','data-date-format' => 'dd-mm-yyyy','readonly']) ?>
									</div>
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
						<h3 class="panel-title">LIST Customer Membership</h3>
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
											<th><?= ('Customer') ?></th>
											<th><?= ('Plan') ?></th>
											<th><?= ('Amount') ?></th>
											<th><?= ('Discount %') ?></th>
											<th><?= ('Valid From') ?></th>
											<th><?= ('Valid To') ?></th>
											<th><?= ('Status') ?></th>
											<th scope="col" class="actions"><?= __('Actions') ?></th>
										</tr>
									</thead>
									<tbody>
										<?php $i = $paginate_limit*($this->Paginator->counter('{{page}}')-1);
										foreach ($customermemberships as $data): ?>
										<tr>
											<td><?= $this->Number->format(++$i) ?></td>
											<td><?= h($data->customer->name) ?></td>
											<td><?= h($data->plan->amount) ?></td>
											<td><?= h($data->amount) ?></td>
											<td><?= h($data->discount_percentage) ?> %</td>
											<td><?= h($data->start_date) ?></td>
											<td><?= h($data->end_date) ?></td>
											<td><?= h($data->status) ?></td>
											<td class="actions">
												<?php
													$promotion_id = $EncryptingDecrypting->encryptData($data->id);
												?>
												<?php //$this->Html->link(__('<span class="fa fa-pencil"></span>'), ['action' => 'index', $promotion_id],['class'=>'btn btn-primary  btn-condensed btn-sm','escape'=>false]) ?>
												<?php //$this->Form->postLink('<span class="fa fa-remove"></span>', ['action' => 'delete', $promotion_id], ['class'=>'btn btn-danger btn-condensed btn-sm','confirm' => __('Are you sure you want to delete ?'),'escape'=>false]) ?>
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
				},
				
			}                                        
		});
		$(document).on("change",".pln",function(){
			var pln_id=$("option:selected", this).val();
			var amount=$("option:selected", this).attr("amount");
			var start_date=$("option:selected", this).attr("start_date");
			var end_date=$("option:selected", this).attr("end_date");
			var benifit_per=$("option:selected", this).attr("benifit_per");
			
			$("#amount").val(amount);
			$("#discount_percentage").val(benifit_per);
			$(".start_date").val(start_date);
			$(".end_date").val(end_date);
			  
		});
		';     
echo $this->Html->scriptBlock($js, array('block' => 'scriptBottom')); 		
?>