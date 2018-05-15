<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}
</style>
<?php $this->set('title', 'Ledger'); ?>
<div class="page-content-wrap">
        <div class="page-title">                    
			<h2><span class="fa fa-arrow-circle-o-left"></span>Ledger</h2>
		</div> 
	<div class="row">
				<div class="col-md-4">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">Create Ledger</h3>
						</div>
						<?= $this->Form->create($ledgers,['id'=>"jvalidate"]) ?>
								<div class="panel-body">
									<div class="form-group">
										<label>Name</label>
										<?= $this->Form->control('name',['class'=>'form-control','placeholder'=>'Name','label'=>false]) ?>
										<span class="help-block"></span>
									</div>
									<div class="form-group">
										<label>Under Accounting Group</label>
										<?= $this->Form->select('accounting_group_id',$accountingGroups,['class'=>'form-control select', 'label'=>false]) ?>
									</div>
									<div class="form-group">           
									<label >Opening balance</label>
										<div class="">	
											<div class="col-md-8">
													<?php echo $this->Form->control('opening_balance_value',['id'=>'opening_balance_value','class'=>'rightAligntextClass form-control input-sm balance','label'=>false,'placeholder'=>'Opening Balance']);
													?>
											</div>
												<div class="col-md-4">	
													<?php $options =[['value'=>'Dr','text'=>'Dr'],['value'=>'Cr','text'=>'Cr']]; ?>
													<?= $this->Form->select('debit_credit',$options,['class'=>'form-control select cr_dr','label'=>false]) ?>
												
											</div>
										</div>
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
						<h3 class="panel-title">List Ledger</h3>
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
								<div class="table-responsive">
									<table class="table table-bordered">
										<thead>
										<tr>
										<th><?= ('SN.') ?></th>
										<th><?= ('Name') ?></th>
										<th><?= ('Accounting Groups') ?></th>
										<th scope="col" class="actions"><?= __('Actions') ?></th>
										</tr>
										</thead>
										<tbody>                                            
											<?php $i = $paginate_limit*($this->Paginator->counter('{{page}}')-1);
													//pr($ledgers->toArray()); exit;
											foreach ($ledgers as $ledger): ?>
											<tr>
											<td><?= $this->Number->format(++$i) ?></td>
											<td><?= h($ledger->name) ?></td>
											<td><?= h($ledger->accounting_group->name) ?></td>
											<td class="actions">
												<?php if(!empty($seller->customer_id))
												{ ?>
													<?= $this->Html->link(__('<span class="fa fa-pencil"></span>'), ['controller'=> 'customers' ,'action' => 'edit', $ledger->customer_id],['class'=>'btn btn-primary  btn-condensed btn-sm','escape'=>false]) ?>
												<?php }
												else if(!empty($ledger->seller_id)){ ?>
												<?= $this->Html->link(__('<span class="fa fa-pencil"></span>'), ['controller'=> 'sellers' ,'action' => 'edit', $ledger->seller_id],['class'=>'btn btn-primary  btn-condensed btn-sm','escape'=>false]) ?>
												<?php } else if(!empty($ledger->vendor_id)) { ?>
													<?= $this->Html->link(__('<span class="fa fa-pencil"></span>'), ['controller'=> 'vendors' ,'action' => 'edit', $ledger->vendor_id],['class'=>'btn btn-primary  btn-condensed btn-sm','escape'=>false]) ?>
												<?php } else { ?>
												<?= $this->Html->link(__('<span class="fa fa-pencil"></span>'), ['action' => 'edit', $ledger->id],['class'=>'btn btn-primary  btn-condensed btn-sm','escape'=>false]) ?><?php } ?>
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
