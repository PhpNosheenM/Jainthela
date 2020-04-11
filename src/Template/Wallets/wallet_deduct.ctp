<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}
</style>
<?php $this->set('title', 'Money'); ?>
<div class="page-content-wrap">
    <div class="page-title">                    
			<h2> Wallet</h2>
	</div> 
	 <div class="row">
				<div class="col-md-4">
					<div class="panel panel-default">
									<div class="panel-heading">
										<h3 class="panel-title">Deduct Money</h3>
									</div>
									<?= $this->Form->create($wallet,['id'=>"jvalidate"]) ?>
							<div class="panel-body">
								 
								<div class="form-group">
									<label>Customer</label>
									<?= $this->Form->select('customer_id',$customers,['class'=>'form-control select','label'=>false,'empty' => '--Select--','data-live-search'=>true]) ?>
								</div>
								
								<div class="form-group">
									<label>Amount</label>
									<?= $this->Form->control('used_amount',['id'=>'total_amount','class'=>'form-control','placeholder'=>'Amount','label'=>false,'type'=>'text']) ?>
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
				<div class="col-md-8">
			       <div class="panel panel-default">
				    <div class="panel-heading">
						<h3 class="panel-title">Pending For Approvel</h3>
					   <!--  <div class="pull-right">
						    <div class="pull-left">
								<?= $this->Form->create('Search',['type'=>'GET']) ?>
								<?= $this->Html->link(__(' Wallet Deduct'), ['action' => 'walletDeduct'],['style'=>'margin-top:-30px !important;','class'=>'btn btn-success','escape'=>false]) ?>
								<?php // $this->Html->link(__('<span class="fa fa-plus"></span> Withdraw'), ['controller'=>'wallets','action' => 'withdraw'],['style'=>'margin-top:-30px !important;','class'=>'btn btn-success','escape'=>false]) ?>
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
					     </div>--> 
					    <div class="panel-body">
				            <div class="table-responsive">
								<table class="table table-bordered">
									<thead>
										<tr>
											<th><?= ('SN.') ?></th>
											<th><?= ('Customer') ?></th>
											<th><?= ('Use Amount') ?></th>
										</tr>
									</thead>
									<tbody>                                            
										<?php $i = $paginate_limit*($this->Paginator->counter('{{page}}')-1);
										foreach ($wallets as $data): ?>
										<tr>
											<td><?= $this->Number->format(++$i) ?></td>
											<td><?= h($data->customer->name) ?></td>
											<td><?= h($data->used_amount) ?></td>
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
		$(document).on("click", ".iradio", function(){
			var radio_value=$("input[name=amount_type]:checked").val(); 
			if(radio_value!="plan"){
				$("#pln_hd").hide();
				$("#plan_id").selectpicker("val","");
				$("#total_amount").removeAttr("readonly");
			}else{
				$("#pln_hd").show();
				$("#total_amount").attr("readonly","readonly");
			}
		});
		
		$(document).on("change", "#plan_id", function(){
			var actual_amount= $("option:selected", this).attr("actual_amount");
			var benifit= $("option:selected", this).attr("benifit");
			$("#total_amount").val(actual_amount);
			$("#benifit").val(benifit);
		});
		';
echo $this->Html->scriptBlock($js, array('block' => 'scriptBottom'));
?>
?>