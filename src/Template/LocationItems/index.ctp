<style>
.main_tbl > thead > tr > th{
padding: 10px 5px;text-align:center;
}
.main_tbl > tbody > tr > td{
padding: 10px 5px;
}
</style>
<?php $this->set('title', 'Location Item'); ?>
<div class="page-content-wrap">
	<div class="row">
		<div class="col-md-12">
		<?= $this->Form->create($locationItem,['id'=>"jvalidate",'class'=>"form-horizontal"]) ?>  
		<?php $js=''; ?>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong> Location Item </strong></h3>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group" style="text-align:center;">
								<div class="col-md-4"></div>    
								<div class="col-md-4"> 
									<?php echo $this->Form->select('item_id',$Items, ['empty'=>'--Select--','label' => false,'class' => 'form-control input-sm ledger select', 'data-live-search'=>true,'id'=>'item_id']); ?>
								</div>
								<div class="col-md-4"></div>
							</div>
						</div>
					</div>
					<br>
					<br>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group addResult">
							
							</div>
						</div>
					</div>
				</div>
				<div class="panel-footer">
					<center>
						<?= $this->Form->button(__('Submit'),['class'=>'btn btn-primary']) ?>
					</center>
				</div>
			</div>
			<?= $this->Form->end() ?>
		</div>
	</div>
</div>
<!-- END CONTENT FRAME -->
<?= $this->Html->script('plugins/fileinput/fileinput.min.js',['block'=>'jsFileInput']) ?>
<?= $this->Html->script('plugins/bootstrap/bootstrap-select.js',['block'=>'jsSelect']) ?>
<?= $this->Html->script('plugins/jquery-validation/jquery.validate.js',['block'=>'jsValidate']) ?>
<?php
   $js.='var jvalidate = $("#jvalidate").validate({
		ignore: [],
		rules: {                                            
				name: {
						required: true,
				},
				
			}
		});
		
		$(document).on("change","#item_id",function(){
			 var item_id=$("option:selected", this).val();
		 
			 
			var url =   "'.$this->Url->build(["controller"=>"LocationItems","action"=>"getItemInfo"]).'";
			url =   url+"?item_id="+item_id;
			
            $.ajax({
					url: url,
			}).done(function(response){
				$(".addResult").html(response);
			});	
			  
			  $(document).on("change",".st2",function(){
				if($(this).is(":checked"))
				{
					 
					//$(this).closest("td.item_variation").find("input.stst[type=text]").val("Actice");
					$(this).closest("tr").find(".stst").val("Actice");
				}
				else{
					//$(this).closest("td.item_variation").find("input.stst[type=text]").val("Deactive");
					$(this).closest("tr").find(".stst").val("Deactive");
				}	
			});
			$(document).on("change",".check_all_item",function(){
			if($(this).is(":checked"))
			{
				$(".stst").val("Actice");
				$(this).closest(".item_variation").find("input.single_item[type=checkbox]").prop("checked",true);
				$(this).closest(".item_variation").find("input.entity_variation[type=checkbox]").prop("checked",true);
				$(this).closest(".item_variation").find("input.single_item[type=checkbox]").prop("disabled",false);  
				$(this).closest(".item_variation").find("input.entity_maximum").prop("disabled",false);
				$(this).closest(".item_variation").find("select.entity_maximum").prop("disabled",false);
			}
			else
			{
				$(".stst").val("Deactive");
				$(this).closest(".item_variation").find("input.single_item[type=checkbox]").prop("checked",false);
				$(this).closest(".item_variation").find("input.entity_variation[type=checkbox]").prop("checked",false);
				$(this).closest(".item_variation").find("input.single_item[type=checkbox]").prop("disabled",true);
				$(this).closest(".item_variation").find("input.entity_maximum").prop("disabled",true);
				$(this).closest(".item_variation").find("select.entity_maximum").prop("disabled",true);
			}
		});
		});
	';
echo $this->Html->scriptBlock($js, array('block' => 'scriptBottom'));
?>