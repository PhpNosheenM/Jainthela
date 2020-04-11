<style>
.main_tbl > thead > tr > th{
padding: 10px 5px;text-align:center;
}
.main_tbl > tbody > tr > td{
padding: 10px 5px;
}
</style>
<?php $this->set('title', 'Seller Item'); ?>
<div class="page-content-wrap">
	<div class="row">
		<div class="col-md-12">
		<?= $this->Form->create($itemVariation,['id'=>"jvalidate",'class'=>"form-horizontal"]) ?>  
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong>Seller Item</strong></h3>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group" style="text-align:center;">
								<div class="col-md-4"></div>    
								<div class="col-md-4"> 
									<!--<div class="panel-group accordion accordion-dc">
										<?php //$this->RecursiveCategories->categoryItemVariations($categories,$sellerItemCommision) ?>
									</div>-->
									<select class="form-control select change_option" label="false" >
									<option>--select--</option>
									<?= $this->RecursiveCategories->categoryItemVariationsOption($categories) ?>
									</select>

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
<?php
$js='
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
				//var commission = parseFloat($(this).closest("tr").find("td input#commission").val()); 
				var amt_after_commission = sales_rate-((sales_rate)/100);
				$(this).closest("tr").find("td input.purchase_rate").val(round(amt_after_commission));
			}
		});
		
		$(document).on("keyup",".mrp",function(){
			mrp=$(this).val();
			$(this).closest("tr").find("td input.prate").val(round(mrp)); 
		});
		
		$(document).on("keyup",".calc",function(){
			var mrp = parseFloat($(this).closest("tr").find("td input.mrp").val());
			var prate = parseFloat($(this).closest("tr").find("td input.prate").val());
			if(!prate){ prate=0; }
			var dper = parseFloat($(this).closest("tr").find("td input.dper").val());
			if(!dper){ dper=0; }
			var discount_amount=((prate*dper)/100);
			if(!discount_amount){ discount_amount=0; }
			var final_sales_rate=prate-discount_amount;
			if(final_sales_rate>mrp){
				alert("sales rate is greater then print rate, please try again");
				$(this).closest("tr").find("td input.sales_rate").val(0);
			}else{
				var final_sales_rate1=round(final_sales_rate);
				$(this).closest("tr").find("td input.sales_rate").val(final_sales_rate1);
			}
			
			var sales_rate = parseFloat($(this).closest("tr").find("td input.sales_rate").val());
			//var commission = parseFloat($(this).closest("tr").find("td input.commission").val()); 
			
			if(!isNaN(sales_rate))
			{ 
				var amt_after_commission = sales_rate-((sales_rate)/100);
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
		
		$(document).on("change",".change_option",function(){
			var item_id  = $(this).val();
			$(".addResult").html("<b> Loading... </b>");	
			var url =   "'.$this->Url->build(["controller"=>"SellerItems","action"=>"getItemInfo"]).'";
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
					$(this).closest("tr").find("input.stst").val("Yes");
					$("#btn_sbmt").show();
					
				}
				else{
					//$(this).closest("td.item_variation").find("input.stst[type=text]").val("No");
					$(this).closest("tr").find("input.stst").val("No");
				}	
			});
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
	
';
echo $this->Html->scriptBlock($js, array('block' => 'scriptBottom')); 	
?>
