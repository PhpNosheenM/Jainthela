<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}
</style>
<?php $this->set('title', 'Holidays'); ?>
<div class="page-content-wrap">
    <div class="page-title">                    
			<h2><span class="fa fa-arrow-circle-o-left"></span> Holidays</h2>
	</div> 
	 <div class="row">
				<div class="col-md-4">
					<div class="panel panel-default">
									<div class="panel-heading">
										<h3 class="panel-title">ADD Holidays</h3>
									</div>
									<?= $this->Form->create($holiday,['id'=>"jvalidate"]) ?>
							<div class="panel-body">
								  
								 <div class="form-group">
									<label>Date</label>
									<?= $this->Form->control('date',['class'=>'form-control datepicker','placeholder'=>'Holidays Date','label'=>false,'type'=>'text','data-date-format' => 'dd-mm-yyyy']) ?>
									<span class="help-block"></span>
								</div>
								
								<div class="form-group">
									<label>Reason</label>
									<?= $this->Form->control('reason',['class'=>'form-control','placeholder'=>'Name','label'=>false]) ?>
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
						<h3 class="panel-title">LIST Holidays</h3>
					     <div class="pull-right">
						    <div class="pull-left">
								<?= $this->Form->create('Search',['type'=>'GET']) ?>
								<?= $this->Html->link(__('<span class="fa fa-plus"></span> Add New'), ['action' => 'index'],['style'=>'margin-top:-30px !important;','class'=>'btn btn-success','escape'=>false]) ?>
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
											<th><?= ('Date') ?></th>
											<th><?= ('Reason') ?></th>
											<th><?= ('Created On') ?></th>
											<th scope="col" class="actions"><?= __('Actions') ?></th>
										</tr>
									</thead>
									<tbody>
										<?php $i = $paginate_limit*($this->Paginator->counter('{{page}}')-1);
										foreach ($holidays as $data): ?>
										<tr>
											<td><?= $this->Number->format(++$i) ?></td>
											<td><?= h($data->date) ?></td>
											<td><?= h($data->reason) ?></td>
											<td><?= h($data->created_on) ?></td>
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
		';     
echo $this->Html->scriptBlock($js, array('block' => 'scriptBottom')); 		
?>