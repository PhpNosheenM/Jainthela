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
		<?php $js=''; ?>		
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
									<?= $this->Form->control('discount_per',['class'=>'form-control','placeholder'=>'Discount(%)','label'=>false]) ?>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-md-3 control-label">Sales Rate </label>
								<div class="col-md-9">                                            
									<?= $this->Form->control('sales_rate',['class'=>'form-control','placeholder'=>'Sales Rate','label'=>false]) ?>
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
									<?php 
									 
									 
									$st_date=date('d-m-Y', strtotime($comboOffer->start_date));
									$ed_date=date('d-m-Y', strtotime($comboOffer->end_date));
								 
									?>
										<?= $this->Form->control('start_date',['class'=>'form-control datepicker','placeholder'=>'Offer Valid From','label'=>false,'type'=>'text','data-date-format' => 'dd-mm-yyyy','value'=>$st_date]) ?>
										<span class="input-group-addon add-on"> - </span>
										<?= $this->Form->control('end_date',['class'=>'form-control datepicker','placeholder'=>'Offer Valid To','label'=>false,'type'=>'text','data-date-format' => 'dd-mm-yyyy','value'=>$ed_date]) ?>
									</div>
								</div>
							</div>
							
							<div class="form-group ">
								<label class="col-md-3 control-label">Description</label>
								<div class="col-md-9 col-xs-12"> 
									<?= $this->Form->control('description',['class'=>'form-control','placeholder'=>'Description','label'=>false,'rows'=>'4']) ?>
								</div>
							</div>
							<!--div class="form-group" id="web_image_data">
									<label class="col-md-3 control-label">Offer Image</label> 
									<div class="col-md-9 col-xs-12"> 
									<?php // $this->Form->control('combo_offer_image',['type'=>'file','label'=>false,'id' => 'combo_offer_image','data-show-upload'=>false, 'data-show-caption'=>false, 'required'=>true]) ?>
									<label id="combo_offer_image-error" class="error" for="combo_offer_image"></label>
									</div>
							</div-->
							<div class="form-group col-md-12" id="web_image_data">
							     <label class="col-md-3 control-label">Combo Offer Image</label> 
									<?php
										$required=true;
										$keyname = $comboOffer->combo_offer_image_web;
										 
										if(!empty($keyname))
										{
											 $info = $awsFileLoad->doesObjectExistFile($keyname);
										}
										else
										{
											$info='';
										}
										if($info)
										{
											$required=false;
										}
										
									?>
										<?= $this->Form->control('combo_offer_image',['type'=>'file','label'=>false,'id' => 'combo_offer_image_web','data-show-upload'=>false, 'class'=>'col-md-9', 'data-show-caption'=>false, 'required'=>$required]) ?>
										<label id="combo_offer_image_web-error" class="error" for="combo_offer_image_web"></label>
										<?php
										if($info)
										{
											 $result=$awsFileLoad->getObjectFile($keyname);
											echo $app_image_view='<img src="data:'.$result['ContentType'].';base64,'.base64_encode($result['Body']).'" alt="" style="width: auto; height: 160px;" class="file-preview-image"/>';
											
											$js.=' $( document ).ready(function() {
														$("#web_image_data").find("div.file-input-new").removeClass("file-input-new");
														$("#web_image_data").find("div.file-preview-thumbnails").html("<div data-template=image class=file-preview-frame><div class=kv-file-content><img src=data:'.$result['ContentType'].';base64,'.base64_encode($result['Body']).'></div></div>");
														$("#web_image_data").find("div.file-preview-frame").addClass("file-preview-frame krajee-default  kv-preview-thumb");
													
														$("#web_image_data").find("img").addClass("file-preview-image kv-preview-data rotate-1");
													});
											';
										}
									?>
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
										
										<th  class="actions"><?= __('Actions') ?></th>
									</tr>
								</thead>
								<tbody class="MainTbody">  
								<?php  foreach($comboOffer->combo_offer_details as $data2){
								 
								?>
									<tr class="MainTr">
			
										<td width="" valign="top">
											<?= $this->Form->select('item_variation_id',$itemVariation_option,['class'=>'form-control itemVariations','label'=>false, 'data-live-search'=>true,'value'=>$data2->item_variation_id]) ?>
										</td>
										<td width="30%" valign="top">
											<?= $this->Form->control('quantity',['class'=>'form-control quantity','label'=>false, 'value'=>$data2->quantity]) ?>
											<?= $this->Form->control('rate',['class'=>'form-control rate','label'=>false,'type'=>'hidden']) ?>
										</td>
										
										
										<td valign="top"  >
											<a class="btn btn-primary  btn-condensed btn-sm add_row" href="#" role="button" ><i class="fa fa-plus"></i></a>
											<a class="btn btn-danger  btn-condensed btn-sm delete_row " href="#" role="button" ><i class="fa fa-times"></i></a>
										</td>
									</tr>
									<?php } ?>
								</tbody>
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
			
			<td width="" valign="top">
				<?= $this->Form->select('item_variation_id',$itemVariation_option,['class'=>'form-control itemVariations','label'=>false, 'data-live-search'=>true]) ?>
			</td>
			<td width="30%" valign="top">
				<?= $this->Form->control('quantity',['class'=>'form-control quantity','label'=>false, 'value'=>1]) ?>
				<?= $this->Form->control('rate',['class'=>'form-control rate','label'=>false,'type'=>'hidden']) ?>
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
	
		$("#combo_offer_image_web").fileinput({
            showUpload: false,
            showCaption: false,
            showCancel: false,
            browseClass: "btn btn-danger",
			allowedFileExtensions: ["jpg", "png"],
			maxFileSize: 1024,
		});
		
		$(document).on("click",".add_row",function(){
			addMainRow();
			//renameRows();
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
		
		$(document).on("change",".itemVariations",function(){
			
			renameRows();
		});
		function renameRows(){
				var i=0; 
				$(".main_table tbody tr").each(function(){
						$(this).attr("row_no",i);
						$(this).find("td:nth-child(1) select.itemVariations").selectpicker();
						$(this).find("td:nth-child(1) select.itemVariations").attr({name:"combo_offer_details["+i+"][item_variation_id]",id:"combo_offer_details-"+i+"-item_variation_id"}).rules("add", "required");
						$(this).find("td:nth-child(2) input.quantity").attr({name:"combo_offer_details["+i+"][quantity]",id:"combo_offer_details-"+i+"-quantity"}).rules("add", "required");
						
						
						i++;
			});
			calculation();
		}
		function calculation(){
			var i=0; var print_rate=0;
			$(".main_table tbody tr").each(function(){
				var quantity=$(this).find("td:nth-child(2) input.quantity").val();
				var rate=parseFloat($(this).find("option:selected", this).attr("rate"));
				var amount=quantity*rate;
				
				print_rate=print_rate+amount;
				$(".print_rate").val(print_rate);
				i++;
			});		
		}
		$(document).on("click", ".fileinput-remove-button", function(){
			$(this).closest("div.file-input").find("input[type=file]").attr("required",true);
		});
		
		';  
echo $this->Html->scriptBlock($js, array('block' => 'scriptBottom')); 		
?>
