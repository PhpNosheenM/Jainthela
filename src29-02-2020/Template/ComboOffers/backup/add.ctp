<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}
.file-preview-image
{
	width: 100% !important;
	height:160px !important;
}
.file-preview-frame
{
	display: contents;
	float:none !important;
}
.kv-file-zoom
{
	display:none;
}
</style>
<?php $this->set('title', 'Combo Offer'); ?>
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
	<div class="row">
		<div class="col-md-12">
		<?= $this->Form->create($comboOffer,['id'=>'jvalidate','class'=>'form-horizontal','type'=>'file']) ?>  
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong> Combo Offer</strong></h3>
				</div>
			
				<div class="panel-body">    
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="col-md-3 control-label">Name</label>
								<div class="col-md-9">                                            
									<?= $this->Form->control('name',['class'=>'form-control','placeholder'=>'Combo Offer Name','label'=>false]) ?>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-md-3 control-label">Max Purchase Qty</label>
								<div class="col-md-9">                                            
									<?= $this->Form->control('maximum_quantity_purchase',['class'=>'form-control','placeholder'=>'Max Purchase Qunatity','label'=>false]) ?>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-md-3 control-label">Ready to Sale</label>
								<div class="col-md-9 col-xs-12">
									<?php $show_options['No'] = 'No'; ?>
									<?php $show_options['Yes'] = 'Yes'; ?>
									<?= $this->Form->select('ready_to_sale',$show_options,['class'=>'form-control select','label'=>false]) ?>
								</div>
							</div>
							
							<div class="form-group">    
								<label class="col-md-3 control-label">Status</label>
								<div class="col-md-9 col-xs-12">
									<?php $options['Active'] = 'Active'; ?>
									<?php $options['Deactive'] = 'Deactive'; ?>
									<?= $this->Form->select('status',$options,['class'=>'form-control select','label'=>false]) ?>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-md-3 control-label">Print Rate </label>
								<div class="col-md-9">                                            
									<?= $this->Form->control('print_rate',['class'=>'form-control print_rate','placeholder'=>'Print Rate','label'=>false]) ?>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-md-3 control-label">Discount (%)</label>
								<div class="col-md-9">                                            
									<?= $this->Form->control('discount_per',['max'=>100,'class'=>'discount_per form-control','placeholder'=>'Discount(%)','label'=>false]) ?>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-md-3 control-label">Sales Rate </label>
								<div class="col-md-9">                                            
									<?= $this->Form->control('sales_rate',['class'=>'sales_rate form-control','placeholder'=>'Sales Rate','label'=>false,'readonly']) ?>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="col-md-3 control-label">Print Quantity </label>
								<div class="col-md-9">                                            
									<?= $this->Form->control('print_quantity',['class'=>'form-control','placeholder'=>'Print Quantity','label'=>false]) ?>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-md-3 control-label">Stock In</label>
								<div class="col-md-9">                                            
									<?= $this->Form->control('stock_in_quantity',['class'=>'form-control','placeholder'=>'Stock In Quantity','label'=>false]) ?>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-md-3 control-label">Offer Valid</label>
								<div class="col-md-9 col-xs-12">
									<div class="input-group">
										<?= $this->Form->control('start_date',['class'=>'form-control datepicker','placeholder'=>'Offer Valid From','label'=>false,'type'=>'text','data-date-format' => 'dd-mm-yyyy','value'=>'']) ?>
										<span class="input-group-addon add-on"> - </span>
										<?= $this->Form->control('end_date',['class'=>'form-control datepicker','placeholder'=>'Offer Valid To','label'=>false,'type'=>'text','data-date-format' => 'dd-mm-yyyy','value'=>'']) ?>
									</div>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-md-3 control-label">Description</label>
								<div class="col-md-9 col-xs-12"> 
									<?= $this->Form->control('description',['class'=>'form-control','placeholder'=>'Description','label'=>false,'rows'=>'4']) ?>
								</div>
							</div>
							<div class="form-group" id="web_image_data">
									<label class="col-md-3 control-label">Offer Image</label> 
									<div class="col-md-9 col-xs-12"> 
									<?= $this->Form->control('combo_offer_image',['type'=>'file','label'=>false,'id' => 'combo_offer_image','data-show-upload'=>false, 'data-show-caption'=>false, 'required'=>true]) ?>
									<label id="combo_offer_image-error" class="error" for="combo_offer_image"></label>
									</div>
							</div>
						</div>
					</div>
				</div>
				<div class="panel-body">    
					<div class="row">
						<div class="">
							<table class="table table-bordered main_table">
								<thead>
									<tr>
										<th><?= ('Item.') ?></th>
										<th><?= ('Quantity') ?></th>
										<th><?= ('Sales Rate') ?></th>
										<th><?= ('Combo Rate') ?></th>
										<th><?= ('GST Value') ?></th>
										<th><?= ('Combo Amount') ?></th>
										<th  class="actions"><?= __('Actions') ?></th>
									</tr>
								</thead>
								<tbody class="MainTbody">  
									<tr class="MainTr">
			
										<td width="30%" valign="top">
											<?= $this->Form->select('item_variation_id',$itemVariation_option,['empty'=>'---Select--Item---','class'=>'form-control itemVariations','label'=>false, 'data-live-search'=>true]) ?>
										</td>
										<td width="10%" valign="top">
											<?= $this->Form->control('quantity',['class'=>'form-control quantity','label'=>false, 'value'=>1]) ?>
											 
										</td>
										<td>
											<?php echo $this->Form->input('extra', ['label' => false,'class' => 'extra form-control input-sm number amnt','placeholder'=>'extra']); ?>
										</td>
										<td>
											<?php echo $this->Form->input('rate', ['label' => false,'class' => 'rate form-control input-sm','placeholder'=>'rate' ,'readonly'=>'readonly']); ?>
											<?php echo $this->Form->input('rate1', ['label' => false,'class' => 'rate1 form-control input-sm','placeholder'=>'rate' ,'readonly'=>'readonly']); ?>
											
											<?php echo $this->Form->input('taxable_value', ['type'=>'text','label' => false,'class' => 'txble form-control input-sm','placeholder'=>'txble' ,'readonly'=>'readonly']); ?>
										</td>
										<td>
											<?php echo $this->Form->input('gst_value', ['label' => false,'class' => 'gst_value form-control input-sm','placeholder'=>'Gst Value' ,'readonly'=>'readonly']); ?>
											
											<?php echo $this->Form->input('gst_percentage', ['type'=>'hidden','label' => false,'class' => 'gst_percent form-control input-sm','placeholder'=>'Gst Value' ,'readonly'=>'readonly']); ?>
											
											
											<?php echo $this->Form->input('gst_figure_id', ['type'=>'hidden','label' => false,'class' => 'gst_figure_id form-control input-sm','placeholder'=>'frsgrsd' ,'readonly'=>'readonly']); ?>
										</td>
										<td>
											<?php echo $this->Form->input('amount', ['label' => false,'class' => 'amount form-control input-sm number','placeholder'=>'amount','readonly'=>'readonly']); ?>
											
											<?php echo $this->Form->input('gst_percentage', ['type'=>'hidden','label' => false,'class' =>'form-control input-sm gst_percentage','placeholder'=>'amount','readonly'=>'readonly']); ?>
										</td>
										
										<td valign="top"  >
											<a class="btn btn-primary  btn-condensed btn-sm add_row" href="#" role="button" ><i class="fa fa-plus"></i></a>
											<a class="btn btn-danger  btn-condensed btn-sm delete_row " href="#" role="button" ><i class="fa fa-times"></i></a>
										</td>
									</tr>
								</tbody>
								<tfoot>
									<tr>
										<td colspan="4" align="right">Total GST Amount</td>
										<td>
										<?php echo $this->Form->input('gst_amount', ['label' => false,'class' => 'form-control input-sm tot_gst','placeholder'=>'amount','readonly'=>'readonly']); ?>
										</td>
										<td></td>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
				</div>
				<div class="panel-footer">
					
					<center>
						<?= $this->Form->button(__('Submit'),['class'=>'btn btn-primary']) ?>
					</center>
				</div>
			
			<?= $this->Form->end() ?>
		</div>
	</div>                    	
</div>

<table id="sampleTable" width="100%" style="display:none;">
	<tbody class="sampleMainTbody">
		<tr class="MainTr">
			
			<td width="30%" valign="top">
				<?= $this->Form->select('item_variation_id',$itemVariation_option,['empty'=>'---Select--Item---','class'=>'form-control itemVariations','label'=>false, 'data-live-search'=>true]) ?>
			</td> 
			<td width="10%" valign="top">
				<?= $this->Form->control('quantity',['class'=>'form-control quantity','label'=>false, 'value'=>1]) ?>
			</td>
			<td>
				<?php echo $this->Form->input('extra', ['label' => false,'class' => 'extra form-control input-sm number amnt','placeholder'=>'extra']); ?>
			</td>
			<td>
				<?php echo $this->Form->input('rate', ['label' => false,'class' => 'rate form-control input-sm','placeholder'=>'rate' ,'readonly'=>'readonly']); ?>
				<?php echo $this->Form->input('rate1', ['label' => false,'class' => 'rate1 form-control input-sm','placeholder'=>'rate' ,'readonly'=>'readonly']); ?>
				<?php echo $this->Form->input('taxable_value', ['type'=>'text','label' => false,'class' => 'txble form-control input-sm','placeholder'=>'txble' ,'readonly'=>'readonly']); ?>
				
			</td>
			<td>
				<?php echo $this->Form->input('gst_value', ['label' => false,'class' => 'gst_value form-control input-sm','placeholder'=>'Gst Value' ,'readonly'=>'readonly']); ?>
				
				<?php echo $this->Form->input('gst_percentage', ['type'=>'hidden','label' => false,'class' => 'gst_percent form-control input-sm','placeholder'=>'Gst Value' ,'readonly'=>'readonly']); ?>
				
				<?php echo $this->Form->input('gst_figure_id', ['type'=>'hidden','label' => false,'class' => 'gst_figure_id form-control input-sm','placeholder'=>'frsgrsd' ,'readonly'=>'readonly']); ?>
			</td>
			<td>
				<?php echo $this->Form->input('amount', ['label' => false,'class' =>  'amount form-control input-sm number','placeholder'=>'amount','readonly'=>'readonly']); ?>
				
				<?php echo $this->Form->input('gst_percentage', ['type'=>'hidden','label' => false,'class' =>'form-control input-sm gst_percentage','placeholder'=>'amount','readonly'=>'readonly']); ?>
			</td>
			
			<td valign="top"  >
				<a class="btn btn-primary  btn-condensed btn-sm add_row" href="#" role="button" ><i class="fa fa-plus"></i></a>
				<a class="btn btn-danger  btn-condensed btn-sm delete_row " href="#" role="button" ><i class="fa fa-times"></i></a>
			</td>
		</tr>
	</tbody>
</table>


<?= $this->Html->script('plugins/fileinput/fileinput.min.js',['block'=>'jsFileInput']) ?>
<?= $this->Html->script('plugins/bootstrap/bootstrap-datepicker.js',['block'=>'jsDatePicker']) ?>
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
	
		$("#combo_offer_image").fileinput({
            showUpload: false,
            showCaption: false,
            showCancel: false,
            browseClass: "btn btn-danger",
			allowedFileExtensions: ["jpeg", "jpg", "png"],
			maxFileSize: 1024,
		});
		
		$(document).on("click",".add_row",function(){
			addMainRow();
			//renameRows();
		});
		$(document).on("keyup",".print_rate",function(){
			calc1();
		});
		$(document).on("keyup",".discount_per",function(){
			
			calc1();
		});
		
		//addMainRow();
		renameRows();
		function addMainRow(){
			var tr=$("#sampleTable tbody").html();
			$(".main_table tbody").append(tr);
			renameRows();
			
		}
		
		$(document).on("click",".delete_row",function(){
			//alert();
			var t=$(this).closest("tr").remove();
			renameRows();
		});
		$(document).on("keyup",".quantity",function(){
			
			renameRows();
		});
		
		$(document).on("keyup",".quantity",function(){
			
			renameRows();
		});
		
		
		function calc1(){
			 
			var print_rate=parseFloat($(".print_rate").val());
			if(!print_rate){ print_rate=0; }
			var discount_per=parseFloat($(".discount_per").val());
			if(!discount_per){ discount_per=0; }
			var final_sales_rate=Math.round((print_rate*discount_per/100));
			$(".sales_rate").val(print_rate-final_sales_rate);
			renameRows();
		}
		$(document).on("change",".itemVariations",function(){
			var rate=$("option:selected", this).attr("rate");
			var gst_per=$("option:selected", this).attr("gst_per");
			if(!gst_per){ gst_per=0; }
			var gst_figure_id=$("option:selected", this).attr("gst_figure_id");
			if(!gst_figure_id){ gst_figure_id=0; }
			$(this).closest("tr").find(".amnt").val(rate);
			$(this).closest("tr").find(".gst_percentage").val(gst_per);
			$(this).closest("tr").find(".gst_percent").val(gst_per);
			$(this).closest("tr").find(".gst_figure_id").val(gst_figure_id);
			renameRows();
		});
		function renameRows(){
				var i=0;
				$(".main_table tbody tr").each(function(){
						$(this).attr("row_no",i);
						$(this).find("td:nth-child(1) select.itemVariations").selectpicker();
						$(this).find("td:nth-child(1) select.itemVariations").attr({name:"combo_offer_details["+i+"][item_variation_id]",id:"combo_offer_details-"+i+"-item_variation_id"}).rules("add", "required");
						$(this).find("td:nth-child(2) input.quantity").attr({name:"combo_offer_details["+i+"][quantity]",id:"combo_offer_details-"+i+"-quantity"}).rules("add", "required");
						$(this).find("td:nth-child(3) input.extra").attr({name:"combo_offer_details["+i+"][extra]",id:"combo_offer_details-"+i+"-extra"}).rules("add", "required");
						$(this).find("td:nth-child(4) input.rate").attr({name:"combo_offer_details["+i+"][rate]",id:"combo_offer_details-"+i+"-rate"}).rules("add", "required");
						
						$(this).find("td:nth-child(4) input.rate1").attr({name:"combo_offer_details["+i+"][rate1]",id:"combo_offer_details-"+i+"-rate1"}).rules("add", "required");
						
						$(this).find("td:nth-child(4) input.txble").attr({name:"combo_offer_details["+i+"][taxable_value]",id:"combo_offer_details-"+i+"-taxable_value"}).rules("add", "required");
						$(this).find("td:nth-child(5) input.gst_value").attr({name:"combo_offer_details["+i+"][gst_value]",id:"combo_offer_details-"+i+"-gst_value"}).rules("add", "required");
						$(this).find("td:nth-child(5) input.gst_percent").attr({name:"combo_offer_details["+i+"][gst_percentage]",id:"combo_offer_details-"+i+"-gst_percentage"}).rules("add", "required");
						
						$(this).find("td:nth-child(5) input.gst_figure_id").attr({name:"combo_offer_details["+i+"][gst_figure_id]",id:"combo_offer_details-"+i+"-gst_figure_id"}).rules("add", "required");
						
						$(this).find("td:nth-child(6) input.amount").attr({name:"combo_offer_details["+i+"][amount]",id:"combo_offer_details-"+i+"-amount"}).rules("add", "required");
						$(this).find("td:nth-child(6) input.gst_percentage").attr({name:"combo_offer_details["+i+"][gst]",id:"gst_percentage-"+i+"-gst"}).rules("add", "required");
						 
						i++;
			});
			calculation();
		}
		function calculation(){
			var total_gst=0;
			var i=0; var grand_total=0;
			$(".main_table tbody tr").each(function(){
				var print_rate=0;
				var print_rate1=0;
				var quantity=$(this).find("td:nth-child(2) input.quantity").val();
				var rate=parseFloat($(this).find("option:selected", this).attr("rate"));
				 
				var amount=quantity*rate;
				print_rate1=print_rate+amount;
				grand_total=grand_total+print_rate1;
				if(!grand_total){ grand_total=0; }
				i++;
			});
			 
			var selling_rate=parseFloat($(".sales_rate").val());
			if(!selling_rate){ selling_rate=0; }
			
			$(".main_table tbody tr").each(function(){
			var amount_value=parseFloat($(this).find("td:nth-child(3) input").val());
			if(!amount_value){ amount_value=0; }
			var quantity1 = parseFloat($(this).find("td:nth-child(2) input").val());
			if(!quantity1){ quantity1=0; }
			var actual_amount=Math.round((selling_rate*amount_value)/grand_total);
			if(!actual_amount){ actual_amount=0; }
			var gst_percentage=$(this).find("td:nth-child(6) input.gst_percentage").val();
			if(!gst_percentage){ gst_percentage=0; }
			var main_div=parseFloat(actual_amount*100);
			var gst_div=parseFloat(100)+parseFloat(gst_percentage);
			var temp_amunt=parseFloat((main_div)/(gst_div));
			if(!temp_amunt){ temp_amunt=0; }
			 
			var ac_amnt=temp_amunt;
			var txbl_value=parseFloat(quantity1*ac_amnt);
			if(!txbl_value){ txbl_value=0; }
			var only_gst=parseFloat((actual_amount-ac_amnt)*quantity1);
			if(!only_gst){ only_gst=0; }
			var actual_rate=Math.round(actual_amount/quantity1);
			if(!actual_rate){ actual_rate=0; }
			var garad_amount=quantity1*actual_amount;
			if(!garad_amount){ garad_amount=0; }
			$(this).find("td:nth-child(4) input.rate").val(ac_amnt.toFixed(2));
			$(this).find("td:nth-child(4) input.txble").val(txbl_value.toFixed(2));
			$(this).find("td:nth-child(5) input.gst_value").val(only_gst.toFixed(2));
			$(this).find("td:nth-child(6) input.amount").val(garad_amount);
			$(this).find("td:nth-child(4) input.rate1").val(garad_amount/quantity1);
			
			 
			//$(this).find("td:nth-child(4) input").val(actual_amount.toFixed(2));
			var gst_amount=$(this).find("td:nth-child(5) input").val();
			if(!gst_amount){ gst_amount=0; }
			 
			total_gst+=parseFloat(gst_amount);
		});
		$(".tot_gst").val(total_gst);
		}
		
		
		$(".quant").die().live("keyup",function(){
		var quant = parseFloat($(this).val());
		if(!quant){ quant=0; }
		var minimum_quantity_factor = parseFloat($(this).attr("minimum_quantity_factor"));
		if(!minimum_quantity_factor){ minimum_quantity_factor=0; }
		var unit_name = $(this).attr("unit_name");
		if(!unit_name){ unit_name=0; }
		var price =  parseFloat($(this).attr("price"));
		if(!price){ price=0; }
		var g_total = quant*minimum_quantity_factor;
		var rate = Math.round(quant*price);
		$(this).closest("tr").find(".amnt").val(rate);
		$(this).closest("tr").find(".msg_shw2").html(g_total+" "+unit_name);
		$(this).closest("tr").find(".act_quant").val(g_total);
		var g_total =  parseFloat($(".grnd_ttl").val());
		if(!g_total){ g_total=0; }
		var final_val = g_total+rate;
		//$(".grnd_ttl").val(final_val);
	});  
	
		$(document).on("click", ".fileinput-remove-button", function(){
			$(this).closest("div.file-input").find("input[type=file]").attr("required",true);
		});
		
		';  
echo $this->Html->scriptBlock($js, array('block' => 'scriptBottom')); 		
?>
