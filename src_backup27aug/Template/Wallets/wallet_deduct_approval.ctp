<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}
</style>
<?php $this->set('title', 'Wallet Approval'); ?>
<div class="page-content-wrap">
    <div class="page-title">                    
			<h2> Wallet Deduct Approval</h2>
	</div> 
	 <div class="row">
				 
				<div class="col-md-12">
			       <div class="panel panel-default">
				    <div class="panel-heading">
						<h3 class="panel-title">List</h3>
					     <div class="pull-right">
						    <div class="pull-left">
							</div> 	   
					     </div> 
					    <div class="panel-body">
						<form method="post">
				            <div class="table-responsive">
								<table class="table table-bordered">
									<thead>
										<tr>
											<th><?= ('SN.') ?></th>
											<th><?= ('Customer') ?></th>
											<th><?= ('Amount') ?></th>
											<th>
												<?= ('Action') ?><br>
												<input type="checkbox" class="check_all_item"  >
											</th>
										</tr>
									</thead>
									<tbody>                                            
										<?php $i = $paginate_limit*($this->Paginator->counter('{{page}}')-1);
										foreach ($wallets as $data): 
										
										?>
										<tr>
											<td><?= $this->Number->format(++$i) ?></td>
											<td><?= h($data->customer->name) ?></td>
											<td><?= h($data->used_amount) ?></td>
											<td>
											<input name="test[]" type="checkbox"  value="<?php echo $data->id; ?>" class="entity_variation single_item st2 entity_variation<?php echo $data->id;?>" >
											</td>
										</tr>
										<?php endforeach; ?>
									</tbody>
								</table>
								<div class="panel-footer" id="btn_sbmt" style="display:none">
									<center>
										<?= $this->Form->button(__('Submit'),['class'=>'btn btn-primary']) ?>
									</center>
								</div>
				            </div>
							</form>
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
		
		$(document).on("change",".check_all_item",function(){
			if($(this).is(":checked"))
			{ 	
				$(".single_item[type=checkbox]").prop("checked",true);
				$("#btn_sbmt").show();
			}
			else
			{
				$(".single_item[type=checkbox]").prop("checked",false);
				$("#btn_sbmt").hide();
			}
		});
		
		$(document).on("change",".st2",function(){
				if($(this).is(":checked"))
				{
					$("#btn_sbmt").show();
					
				}
				else{
				
				}	
			});
		';
echo $this->Html->scriptBlock($js, array('block' => 'scriptBottom'));
?>