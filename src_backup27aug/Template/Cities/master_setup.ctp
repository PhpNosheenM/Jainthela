<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}
</style>
<?php $this->set('title', 'Master Setup'); ?>
<div class="page-content-wrap">
    <div class="page-title">                    
			<h2><span class="fa fa-arrow-circle-o-left"></span> Master Setup</h2>
	</div> 
	 <div class="row">
				<div class="col-md-4">
					<div class="panel panel-default">
									<div class="panel-heading">
										<h3 class="panel-title">Add Master Setup</h3>
									</div>
									<?= $this->Form->create($masterSetup,['id'=>"jvalidate"]) ?>
							<div class="panel-body">
								
								<div class="form-group">
									<label>Cash Back Slot</label>
									<?= $this->Form->control('cash_back_slot',['class'=>'form-control','placeholder'=>'Cash Back Slot','label'=>false]) ?>
									<span class="help-block"></span>
								</div>
								<div class="form-group">
									<label>Online Amount Limit</label>
									<?= $this->Form->control('online_amount_limit',['class'=>'form-control','placeholder'=>'Online Amount Limit','label'=>false]) ?>
									<span class="help-block"></span>
								</div>
								 <div class="form-group">
									<label>Cancel Order Limit</label>
									<?= $this->Form->control('cancel_order_limit',['class'=>'form-control','placeholder'=>'Cancel Order Limit','label'=>false]) ?>
									<span class="help-block"></span>
								</div>
								 <div class="form-group">
									<label>Promotion Duration Days</label>
									<?= $this->Form->control('days',['class'=>'form-control','placeholder'=>'Promotion Duration Days','label'=>false]) ?>
									<span class="help-block"></span>
								</div>
								 <div class="form-group">
									<label>Wallet Withdrawl Charge Per</label>
									<?= $this->Form->control('wallet_withdrawl_charge_per',['class'=>'form-control','placeholder'=>'Wallet Withdrawl Charge Per','label'=>false]) ?>
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
				<div class="col-md-8">
			       <div class="panel panel-default">
				    <div class="panel-heading">
						<h3 class="panel-title">List Master Setup</h3>
					     <div class="pull-right">
						    <div class="pull-left">
								<?= $this->Form->create('Search',['type'=>'GET']) ?>
								<?= $this->Html->link(__('<span class="fa fa-plus"></span> Add Master Setup'), ['action' => 'masterSetup'],['style'=>'margin-top:-30px !important;','class'=>'btn btn-success','escape'=>false]) ?>
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
					    <div class="panel-body">
				            <div class="table-responsive">
								<table class="table table-bordered">
									<thead>
										<tr>
											<th><?= ('SN.') ?></th>
											<th><?= ('Cash Back Slot') ?></th>
											<th><?= ('Online Amount Limit') ?></th>
											<th><?= ('Cancel Order Limit') ?></th>
											<th><?= ('Promotion Days') ?></th>
											<th><?= ('Wallet Withdrawl Charges(%)') ?></th>
											<th scope="col" class="actions"><?= __('Action') ?></th>
										</tr>
									</thead>
									<tbody>
										<?php $i = $paginate_limit*($this->Paginator->counter('{{page}}')-1);
										foreach ($masterSetups as $data): ?>
										<tr>
											<td><?= $this->Number->format(++$i) ?></td>
											<td><?= h($data->cash_back_slot) ?></td>
											<td><?= h($data->online_amount_limit) ?></td>
											<td><?= h($data->cancel_order_limit) ?></td>
											<td><?= h($data->days) ?></td>
											<td><?= h($data->wallet_withdrawl_charge_per) ?> %</td>
											<td class="actions">
											<?php
												$master_setup_id = $EncryptingDecrypting->encryptData($data->id);
											?>
												<?= $this->Html->link(__('<span class="fa fa-pencil"></span>'), ['action' => 'masterSetup', $master_setup_id],['class'=>'btn btn-primary  btn-condensed btn-sm','escape'=>false]) ?>
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
		});';  
echo $this->Html->scriptBlock($js, array('block' => 'scriptBottom')); 		
?>
				