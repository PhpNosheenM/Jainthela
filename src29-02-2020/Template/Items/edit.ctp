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
<?php $this->set('title', 'Item'); ?>
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
	<div class="row">
		<div class="col-md-12">
		<?= $this->Form->create($item,['id'=>'jvalidate','class'=>'form-horizontal','type'=>'file']) ?>  
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong> Item</strong></h3>
				</div>
				<?php $js=''; ?>
				<div class="panel-body">    
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="col-md-3 control-label">Name</label>
								<div class="col-md-9">                                            
									<?= $this->Form->control('name',['class'=>'form-control itemName','placeholder'=>'Item Name','label'=>false]) ?>
									<label id="unique-error" style="display:none;color: #B64645;margin-bottom: 0px;margin-top: 3px;font-size: 11px;font-weight: normal;width: 100%;">This Item Already Exist Against This Category.</label>
									<input type="hidden" id="editid" value="<?php echo $id;?>">
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">Category</label>
								<div class="col-md-7">                                            
									<?= $this->Form->select('category_id',$categories,['class'=>'form-control select isExist','label'=>false,'empty'=>'--Select--']) ?>
								</div>
								<div class="col-md-1">
								<button type="button" class="concl btn btn-success input-sm"><i class="fa fa-plus"></i></button>
								
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-md-3 control-label">Minimum Stock</label>
								<div class="col-md-9">                                            
									<?= $this->Form->control('minimum_stock',['class'=>'form-control','placeholder'=>'Minimum Stock','label'=>false]) ?>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-md-3 control-label">Available Online</label>
								<div class="col-md-9 col-xs-12">
									<?php $show_options['No'] = 'No'; ?>
									<?php $show_options['Yes'] = 'Yes'; ?>
									<?= $this->Form->select('section_show',$show_options,['class'=>'form-control select','label'=>false]) ?>
								</div>
							</div>
							<!--<div class="form-group">
								<label class="col-md-3 control-label">Item Maintain By</label>
								<div class="col-md-9 col-xs-12">
									<?php //$maintain_options['itemwise'] = 'Item Wise'; ?>
									<?php //$maintain_options['variationwise'] = 'Item Variation Wise'; ?>
									<?php //$this->Form->select('item_maintain_by',$maintain_options,['class'=>'form-control select','label'=>false]) ?>
								</div>
							</div>-->
							
							<div class="form-group">    
								<label class="col-md-3 control-label">Item Status</label>
								<div class="col-md-9 col-xs-12">
									<?php $options['Active'] = 'Active'; ?>
									<?php $options['Deactive'] = 'Deactive'; ?>
									<?= $this->Form->select('status',$options,['class'=>'form-control select','label'=>false]) ?>
								</div>
							</div>
							
							<div class="form-group">    
								<label class="col-md-3 control-label">HSN Code</label>
								<div class="col-md-9 col-xs-12">
									<?= $this->Form->control('hsn_code',['class'=>'form-control','placeholder'=>'HSN Code','label'=>false ]) ?>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-md-3 control-label">Stock Manage By</label>
								<div class="col-md-9 col-xs-12">
									<?php $gst['variationwise'] = 'Variation Wise'; ?>
									<?php $gst['itemwise'] = 'Item Wise'; ?>
									<?= $this->Form->select('item_maintain_by',$gst,['class'=>'form-control select','label'=>false,'disabled']) ?>
								</div>
							</div>
							<div class="form-group">    
								<label class="col-md-3 control-label">Item Create For</label>
								<div class="col-md-9 col-xs-12">
									
									<?= $this->Form->select('item_for',@$Sellers,['class'=>'form-control select','label'=>false,'disabled','value'=>@$item->item_variations[0]->seller_id]) ?>
									<?= $this->Form->control('item_for',['type'=>'hidden','class'=>'form-control','label'=>false,'value'=>@$item->item_variations[0]->seller_id]) ?>
								</div>
							</div>
							<div class="form-group">    
								<label class="col-md-3 control-label">Sold By</label>
								<div class="col-md-9 col-xs-12">
									<?= $this->Form->control('sold_by',['class'=>'form-control','placeholder'=>'By- Jain thela','label'=>false,'value'=>@$item->item_variations[0]->sold_by]) ?>
								</div>
							</div>
							 
							
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="col-md-3 control-label">Type in Hindi</label>
								<div class="col-md-9">                                            
									<?= $this->Form->control('alias_name',['class'=>'form-control','placeholder'=>'Type in Hindi','label'=>false]) ?>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">GST</label>
								<div class="col-md-9">                                            
									<?= $this->Form->select('gst_figure_id',$gstFigures,['class'=>'form-control select','label'=>false, 'data-live-search'=>true]) ?>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">Brand</label>
								<div class="col-md-7">                                            
									<?= $this->Form->select('brand_id',$brands,['class'=>'form-control select','label'=>false, 'data-live-search'=>true,'empty'=>'---Select--']) ?>
								</div>
								<div class="col-md-1">
								<button type="button" class="addbrand btn btn-success input-sm"><i class="fa fa-plus"></i></button>
								
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-md-3 control-label">Description</label>
								<div class="col-md-9 col-xs-12"> 
									<?= $this->Form->control('description',['class'=>'form-control','placeholder'=>'Description','label'=>false,'rows'=>'4']) ?>
								</div>
							</div>
							
							
							<div class="form-group">
								<label class="col-md-3 control-label">Discount Enable</label>
								<div class="col-md-9 col-xs-12">
									<?php $show_options1['Yes'] = 'Yes'; ?>
									<?php $show_options1['No'] = 'No'; ?>
									<?= $this->Form->select('is_discount_enable',$show_options1,['class'=>'form-control select','label'=>false]) ?>
								</div>
							</div>
							<div class="form-group">    
								<label class="col-md-3 control-label">Virtual Stock</label>
								<div class="col-md-9 col-xs-12">
									<?= $this->Form->control('virtual_stock',['class'=>'form-control','placeholder'=>'Virtual Stock','label'=>false,'value'=>@$item->item_variations[0]->virtual_stock]) ?>
								</div>
							</div>
							<div class="form-group">    
								<label class="col-md-3 control-label">Max Purchase Qty</label>
								<div class="col-md-9 col-xs-12">
									 <?= $this->Form->control('max_qty',['class'=>'form-control','placeholder'=>'Maximum Purchase Quantity','label'=>false,'value'=>@$item->item_variations[0]->maximum_quantity_purchase]) ?>
								</div>
							</div>
							<div class="form-group">
							<label class="col-md-3 control-label">Image Type</label>
							<div class="col-md-9 col-xs-12">
							<div class="col-md-4">
								<label class="check">
								<input type="radio" class="iradio" name="image_type" checked="checked" value="Multiple" /> Multiple</label>
							</div>
							<div class="col-md-4">
								<label class="check">
								<input type="radio" class="iradio" name="image_type" value="Single" /> Single</label>
							</div>
							
							<div class="col-md-4">
								<button type="button" class="addvariations btn btn-success input-sm">Add New Variations</button>
							</div>
						</div>
						
					<!--	<div class="form-group">
							<label class="col-md-3 control-label">GST Type</label>
							<div class="col-md-9 col-xs-12">
								<?php $gst['excluding'] = 'Excluding'; ?>
								<?php $gst['including'] = 'Including'; ?>
								<?= $this->Form->select('item_maintain_by',$gst,['class'=>'form-control select','label'=>false]) ?>
							</div>
						</div>-->
						
						</div>
						
					</div>
				
				</div>
				
				<div class="row"><div class="col-md-12"></div></div></br>
				<label class="col-md-2 control-label" style="text-align:center">Unit Variations</label>
				<div class="row">
					<div class="">
						<table id="MainTable" class="main_table table table-condensed table-striped" width="100%">
							<thead>
								<tr>
									<th>Sr.No</th>
									<th>Variation</th>
									<th>Status</th>
									<th style="text-align:center">Browse</th>
									<th>Add</th>
									<th>Delete</th>
								</tr>
							</thead>
							<tbody id='MainTbody' class="tab">
								<?php 
									foreach($item_variation_masters as $data){
									@$m++;
									?>
										
									<tr class="MainTr">
									<td>
										<span id="row_no">
											<?= h($m) ?>
										</span>
									</td>
									<td width="20%" valign="top">
										<?= $this->Form->control('id',['class'=>'form-control','placeholder'=>'Minimum Stock','label'=>false,'value'=>$data->id,'class'=>'raw_id']) ?>
										<?= $this->Form->select('unit_variation_id',$unit_option,['empty'=>'---Select--Unit--Variation---','class'=>'form-control unit_variation_id','label'=>false,'id'=>'unit_variation_id','value'=>$data->unit_variation_id]) ?>
									</td>
									<td width="20%" valign="top">
										<?php $show_options2['Active'] = 'Active'; ?>
										<?php $show_options2['Deactive'] = 'Deactive'; ?>
										<?= $this->Form->select('status',$show_options2,['empty'=>'---Select--status---','class'=>'form-control sts ','label'=>false,'id'=>'status','value'=>$data->status]) ?>
									</td>
									
									<td align="center">
										<div class="form-group" id="web_image_data<?= h($m) ?>" >
											<div> 
											<?= $this->Form->control('item_variation_row['.$m.'][item_image_web]',['type'=>'file','label'=>false,'id' => 'item_image_web','data-show-upload'=>false, 'data-show-caption'=>false, 'class'=>'item_image_web']) ?>
											<label id="item_image_web-error" class="error" for="item_image_web"></label>
											</div>
										</div>
									<?php

							 //$required=true; 
											if(!empty($data->item_image_web))
											{ 
												$keyname = $data->item_image_web;
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
											if($info)
											{
											$result=$awsFileLoad->getObjectFile($keyname); 
													 		
											 
											$js.=' $( document ).ready(function() {
												 
														$("#web_image_data'.$m.'").find("div.file-input-new").removeClass("file-input-new");
														$("#web_image_data'.$m.'").find("div.file-preview-thumbnails").html("<div data-template=image class=file-preview-frame><div class=kv-file-content><img src=data:'.$result['ContentType'].';base64,'.base64_encode($result['Body']).'></div></div>");
														$("#web_image_data'.$m.'").find("div.file-preview-frame").addClass("file-preview-frame krajee-default  kv-preview-thumb");
													
														$("#web_image_data'.$m.'").find("img").addClass("file-preview-image kv-preview-data rotate-1");
													});
											';
											}
											}
?>
									</td> 
									
									<td>
										<button type="button" class="AddMainRow btn btn-success input-sm"><i class="fa fa-plus"></i></button>
									</td>	
									<td>
										<!--<button type="button" class="delete-tr btn btn-danger input-sm" var_id=<?php echo $data->id; ?>><i class="fa fa-minus"></i></button>-->
									</td>
								</tr>
								<?php } ?>
							</tbody>
							
						</table>
					</div>			
				</div>
				<div class="row">
					<center><b style="color:red;">
						Please Active At list one variations Otherwise App will be crash.
						</b>
					</center>
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




<table id="sampleMainTable" style="display:none;" width="100%">
	<tbody class="sampleMainTbody">
		<tr class="MainTr">
			<td>
				<span id="row_no"></span>
			</td>
			<td width="20%" valign="top">
				<?= $this->Form->select('unit_variation_id',$unit_option,['empty'=>'---Select--Unit--Variation---','class'=>'form-control unit_variation_id','label'=>false,'id'=>'unit_variation_id','required'=>'required']) ?>
			</td>
			<td width="20%" valign="top">
				<?= $this->Form->select('unit_variation_id',$show_options2,['empty'=>'---Select--status---','class'=>'form-control sts','label'=>false,'id'=>'sts','required'=>'required']) ?>
			</td>
			
			<td align="center">
				<div class="form-group" id="web_image_data">
					<div> 
					<?= $this->Form->control('item_image_web',['type'=>'file','label'=>false,'id' => 'item_image_web','data-show-upload'=>false, 'data-show-caption'=>false, 'required'=>true, 'class'=>'item_image_web']) ?>
					<label id="item_image_web-error" class="error" for="item_image_web"></label>
					</div>
				</div>
			</td> 
			
			<td>
				<button type="button" class="AddMainRow btn btn-success input-sm"><i class="fa fa-plus"></i></button>
			</td>	
			<td>
				<button type="button" class="delete-tr btn btn-danger input-sm"><i class="fa fa-minus"></i></button>
			</td>
		</tr>
	</tbody>
</table>

<div class="modal animated fadeIn" id="modal_change_photo" tabindex="-1" role="dialog" aria-labelledby="smallModalHead" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="smallModalHead">Add New Category</h4>
			</div>
			<?= $this->Form->create($categoryData,['id'=>'category_data_form','type'=>'file']) ?>
			
			
			<div class="modal-body form-horizontal">
				<div class="form-group">
					<label class="col-md-4 control-label">Category Name</label>
					<div class="col-md-6">
						<?= $this->Form->control('name',['class'=>'form-control category_name','placeholder'=>'Category Name','label'=>false]) ?>
					</div>                            
				</div> 
				<div class="form-group">
					<label class="col-md-4 control-label">Parent Category</label>
					<div class="col-md-6">
						<?= $this->Form->select('parent_id',$parentCategories,['class'=>'form-control select','label'=>false,'empty' => '--Select--','data-live-search'=>true]) ?>
					</div>	
				</div>	
				
			</div>
			<div class="modal-footer">
				<button type="submit" name="save" id="savedata" class="btn btn-success cnc" >Save</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
			</form>
		</div>
	</div>
</div>
<input type="hidden" class="addcategories" 
value="<?php echo $this->Url->build(['controller'=>'Categories','action'=>'addd']); ?>">

<div class="modal animated fadeIn" id="add_new_brand" tabindex="-1" role="dialog" aria-labelledby="smallModalHead" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="smallModalHead">Add New Brand</h4>
			</div>
			<?= $this->Form->create($brandData,['id'=>'brand_data_form','type'=>'file']) ?>
			
			
			<div class="modal-body form-horizontal">
				<div class="form-group">
					<label class="col-md-4 control-label">Brand Name</label>
					<div class="col-md-6">
						<?= $this->Form->control('name',['class'=>'form-control category_name','placeholder'=>'Brand Name','label'=>false,'required'=>true]) ?>
					</div>                            
				</div> 
				
				
			</div>
			<div class="modal-footer">
				<button type="submit" name="save" id="savedata" class="btn btn-success cnc" >Save</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
			</form>
		</div>
	</div>
</div>
<input type="hidden" class="addbrands" 
value="<?php echo $this->Url->build(['controller'=>'Brands','action'=>'addd']); ?>">

<div class="modal animated fadeIn" id="add_new_var" tabindex="-1" role="dialog" aria-labelledby="smallModalHead" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="smallModalHead">Add New Variation</h4>
			</div>
			<?= $this->Form->create($UnitVariationdata,['id'=>'unit_data_form','type'=>'file']) ?>
			
			
			<div class="modal-body form-horizontal">
				<div class="form-group">
					<label class="col-md-4 control-label">Variation</label>
					<div class="col-md-6">
						<?= $this->Form->control('quantity_variation',['class'=>'form-control category_name','placeholder'=>'Quantity Variation','label'=>false,'required'=>true]) ?>
					</div>                            
				</div> 
				<div class="form-group">
					<label class="col-md-4 control-label">Unit</label>
					<div class="col-md-6">
						<?php echo $this->Form->select('unit_id', @$unitsdata,['empty'=>'','class'=>'form-control unit','label'=>false,'data-placeholder'=>'Select Unit']) ?>
					</div>                            
				</div> 
				<div class="form-group">
					<label class="col-md-4 control-label">Variation Show on App</label>
					<div class="col-md-6">
						<?= $this->Form->control('visible_variation',['class'=>'form-control category_name','placeholder'=>'Show Name','label'=>false,'required'=>true]) ?>
					</div>                            
				</div> 
			</div>
			<div class="modal-footer">
				<button type="submit" name="save" id="savedata" class="btn btn-success cnc" >Save</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
			</form>
		</div>
	</div>
</div>
<input type="hidden" class="addvar" 
value="<?php echo $this->Url->build(['controller'=>'UnitVariations','action'=>'addd']); ?>">


<?= $this->Html->script('plugins/fileinput/fileinput.min.js',['block'=>'jsFileInput']) ?>
<?= $this->Html->script('plugins/bootstrap/bootstrap-datepicker.js',['block'=>'jsDatePicker']) ?>
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
		});';
	
		$i=0;
		/* foreach ($unit_option as $data) {
		
		$js.='$("#item_image_'.$i.'").fileinput({
            showUpload: false,
            showCaption: false,
            showCancel: false,
            browseClass: "btn btn-danger",
			allowedFileExtensions: ["jpeg", "jpg", "png"],
			maxFileSize: 1024,
		});';
		$i++;
		} */
		
		
		
		
		$js.='$(document).on("click", ".fileinput-remove-button", function(){
			$(this).closest("div.file-input").find("input[type=file]").attr("required",true);
		});
		 
		
		renameMainRows();
		function addMainRow(){
			var tr=$("#sampleMainTable tbody.sampleMainTbody tr.MainTr").clone();
			$("#MainTable tbody#MainTbody").append(tr);
			renameMainRows();
		}
		
		$(document).on("click",".AddMainRow",function(){
			addMainRow();
			renameMainRows();
			});
		
		$(document).on("click",".delete-tr",function() {
			var l=$(this).closest("table tbody").find("tr").length;
			if(l>1){
				 $(this).closest("tr").remove();
					renameMainRows();
			}
		});
		$(document).on("click",".delettr",function() 
			{	
				var var_id=$(this).attr("var_id");
				alert(var_id);
				var obj=$(this);
				var url =   "'.$this->Url->build(["controller"=>"Items","action"=>"deleteItemVariation"]).'";
				url =   url+"?var_id="+var_id;	 
				alert(url);
				$.ajax({
					url: url,
				}).done(function(response){ 
					location.reload();
				});
				
			
				
			});
			
		var addcategories = $(".addcategories").val();
		$("#category_data_form").on("submit",function (e)
		{
			e.preventDefault();
			var formData = $(this).serialize();
			
			$.ajax(
			{
					type:"post",
					url:addcategories,
					data:formData,
					dataType: "json",
					success:function(response)
					{ 
						if(response){
							$("select[name=category_id]").append(response["option"]);
							$("select[name=category_id]").selectpicker("refresh");
							
							$("#modal_change_photo").modal("hide");
						}	
					}
			});
		});
		
		var addbrands = $(".addbrands").val();
		
		
		$("#brand_data_form").on("submit",function (e)
		{ alert();
			e.preventDefault();
			var formData = $(this).serialize();
			$.ajax(
			{
					type:"post",
					url:addbrands,
					data:formData,
					dataType: "json",
					success:function(response)
					{ 
						if(response){
							$("select[name=brand_id]").append(response["option"]);
							$("select[name=brand_id]").selectpicker("refresh");
							$("#add_new_brand").modal("hide");
						}	
					}
			});
		});
		
		var addvar = $(".addvar").val();
		$("#unit_data_form").on("submit",function (e)
		{
			e.preventDefault();
			var formData = $(this).serialize();
			
			$.ajax(
			{
					type:"post",
					url:addvar,
					data:formData,
					dataType: "json",
					success:function(response)
					{  
						if(response){
							
							$("select.fetch_variations").append(response["option"]);
							//$("select.fetch_variations").remove();
							//$("select.fetch_variations").selectpicker("refresh");
							$("#add_new_var").modal("hide");
						}	
					}
			});
		});
		 
		$(document).on("click",".concl",function(){
			$("#modal_change_photo").modal("show");
			
		});
		
		$(document).on("click",".addbrand",function(){
			$("#add_new_brand").modal("show");
			
		});
		
		$(document).on("click",".addvariations",function(){
			$("#add_new_var").modal("show");
			
		});
		 
		function renameMainRows(){
				 var i=0; 
				$(".main_table tbody tr").each(function(){
						//$(this).find()attr("row_no",i);
						$(this).find("#row_no").text(i+1);	
						
						$(this).find(".raw_id").attr({name:"item_variation_row["+i+"][id]",id:"item_variation_row-"+i+"-id"});
						
						$(this).find("td:nth-child(2) select.unit_variation_id").attr({name:"item_variation_row["+i+"][unit_variation_id]",id:"item_variation_row-"+i+"-unit_variation_id"})
						$(this).find("td:nth-child(3) select.sts").attr({name:"item_variation_row["+i+"][status]",id:"item_variation_row-"+i+"-status"})
						
						$(this).find("td:nth-child(4) input.item_image_web").attr({name:"item_variation_row["+i+"][item_image_web]",id:"item_variation_row-"+i+"-item_image_web"})
						 
						 $("#item_variation_row-"+i+"-item_image_web").fileinput({
							showUpload: false,
							showCaption: false,
							showCancel: false,
							browseClass: "btn btn-danger",
							allowedFileExtensions: ["jpeg", "jpg", "png"],
							maxFileSize: 1024,
							
						});
						
						i++;
			});
		}


		$(document).on("click", ".chk_class", function(){
			var className = $(this).attr("id"); 
			var divid = $(this).attr("divid"); 
			if (this.checked) { 
			    $("."+className).removeAttr("disabled");
				$("."+divid).find(".btn-file").removeAttr("disabled");
				$("."+divid).find(".fileinput-remove").removeAttr("disabled");
				$("."+divid).find(".btn-file").removeClass("disabled");
				$("."+className).attr("required", "true");
			}
			else
			{
				$("."+className).attr("disabled", "true");
				$("."+divid).find(".btn-file").attr("disabled", "true");
				$("."+divid).find(".fileinput-remove").attr("disabled", "true");
				$("."+divid).find(".btn-file").addClass("disabled");
				$("."+className).removeAttr("required");
			}
		});
		$(document).on("change", ".isExist", function(){
			var itemName = $(".itemName").val();
			var category = $(this).val(); 
			var edit_id = $("#editid").val(); 
			ItemNameIsExist(itemName,category,edit_id);
		});
		$(document).on("blur", ".itemName", function(){
			var itemName = $(".itemName").val();
			var category = $(".isExist").val(); 
			var edit_id = $("#editid").val(); 
			ItemNameIsExist(itemName,category,edit_id);
		});
		
		function ItemNameIsExist(itemName="null",category="null",edit_id="null")
		{  
			if(itemName!="" & category!="")
			{
				var url =   "'.$this->Url->build(["controller"=>"Items","action"=>"checkItemExistance"]).'";
				url =   url+"?itemName="+itemName+"&category="+category+"&edit_id="+edit_id;	 
				$.ajax({
								url: url,
				}).done(function(response){ 
							   if(response=="exist")
							   {
								   $("#unique-error").show();
								   
							   }
				});
			}
			
		}
		';  
echo $this->Html->scriptBlock($js, array('block' => 'scriptBottom')); 		
?>