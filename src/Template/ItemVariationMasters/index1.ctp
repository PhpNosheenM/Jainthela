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
		<?= $this->Form->create($itemVariation,['id'=>"jvalidate",'class'=>"form-horizontal"]) ?>  
		<?php $js=''; ?>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong> Admin Item Variations Sales Rate</strong></h3>
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
				<div class="panel-footer" id="btn_sbmt" style="display:none">
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
		
		$(document).on("blur",".sales_rate",function(){
			var sales_rate = parseFloat($(this).closest("tr").find("td input.sales_rate").val());
			var mrp        = parseFloat($(this).closest("tr").find("td input.mrp").val());
			if(!isNaN(sales_rate) & !isNaN(mrp))
			{
				if(sales_rate > mrp)
				{
					alert("Sales rate grater than mrp?.");
					$(this).closest("tr").find("td input.sales_rate").val(mrp);
					sales_rate=mrp;

				}
				var commission = parseFloat($(this).closest("tr").find("td input#commission").val()); 
				var amt_after_commission = sales_rate-((sales_rate*commission)/100);
				$(this).closest("tr").find("td input.purchase_rate").val(round(amt_after_commission));
			}
		});
		
		$(document).on("keyup",".calc",function(){
			var mrp        = parseFloat($(this).closest("tr").find("td input.mrp").val());
			$(this).closest("tr").find("td input.sales_rate").val(mrp)
			var sales_rate = parseFloat($(this).closest("tr").find("td input.sales_rate").val());
			var commission = parseFloat($(this).closest("tr").find("td input#commission").val()); 
			
			if(!isNaN(sales_rate))
			{ 
				var amt_after_commission = sales_rate-((sales_rate*commission)/100);
				$(this).closest("tr").find("td input.purchase_rate").val(round(amt_after_commission)); 
			}
		});
		
		$(document).on("keyup",".addStock",function(){
			var stock    = parseFloat($(this).val()); 
			var oldStock = parseFloat($(this).closest("tr").find("td input.cStock").val());
			var chstock = parseFloat($(this).closest("tr").find("td input#chstock").val());
			
			if(!isNaN(stock) & !isNaN(chstock))
			{ 
				var totalStock = stock+chstock;
				$(this).closest("tr").find("td input.cStock").val(totalStock);
			}
			else if(!isNaN(stock) & isNaN(chstock))
			{
				$(this).closest("tr").find("td input.cStock").val(stock);
			}
			else if(isNaN(stock) & isNaN(chstock) & isNaN(chstock))
			{
				$(this).closest("tr").find("td input.cStock").val("");
			}
			else if(isNaN(stock) & !isNaN(chstock) & !isNaN(chstock))
			{
				$(this).closest("tr").find("td input.cStock").val(chstock);
			}
			
			
			
			
		});
		
		$(document).on("change",".single_item",function(){
			var item_variation=$(this).val(); 
			
			if($(this).is(":checked"))
			{
				$(this).closest("tr").find("td input.entity_variation"+item_variation).prop("checked",true);
				$(this).closest("tr").find("td input.entity_maximum"+item_variation).prop("disabled",false);
				$(this).closest("tr").find("td select.entity_maximum"+item_variation).prop("disabled",false);
			}
			else
			{
				$(this).closest("tr").find("td input.entity_variation"+item_variation).prop("checked",false);
				$(this).closest("tr").find("td input.entity_maximum"+item_variation).prop("disabled",true);
				$(this).closest("tr").find("td select.entity_maximum"+item_variation).prop("disabled",true);
			}
		});
		
		$(document).on("change","#item_id",function(){
			 var item_id=$("option:selected", this).val();
		 
			 
			var url =   "'.$this->Url->build(["controller"=>"ItemVariationMasters","action"=>"getItemInfo1"]).'";
			url =   url+"?item_id="+item_id;
			
            $.ajax({
					url: url,
			}).done(function(response){
				 
				$(".addResult").html(response);
			});	
			  
			  $(document).on("change",".st2",function(){
				if($(this).is(":checked"))
				{
					 
					//$(this).closest("td.item_variation").find("input.stst[type=text]").val("Yes");
					$(this).closest("tr").find(".stst").val("Yes");
					$("#btn_sbmt").show();
					
				}
				else{
					//$(this).closest("td.item_variation").find("input.stst[type=text]").val("No");
					$(this).closest("tr").find(".stst").val("No");
				}	
			});
			$(document).on("change",".check_all_item",function(){
			if($(this).is(":checked"))
			{
				$(".stst").val("Yes");
				$(this).closest(".item_variation").find("input.single_item[type=checkbox]").prop("checked",true);
				$(this).closest(".item_variation").find("input.entity_variation[type=checkbox]").prop("checked",true);
				$(this).closest(".item_variation").find("input.single_item[type=checkbox]").prop("disabled",false);  
				$(this).closest(".item_variation").find("input.entity_maximum").prop("disabled",false);
				$(this).closest(".item_variation").find("select.entity_maximum").prop("disabled",false);
				$("#btn_sbmt").show();
			}
			else
			{
				$(".stst").val("No");
				$("#btn_sbmt").hide();
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