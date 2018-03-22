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
</style><?php $this->set('title', 'Item'); 
?>
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
	<div class="row">
		<div class="col-md-12">
		<?= $this->Form->create($item,['id'=>'jvalidate','class'=>'form-horizontal','type'=>'file']) ?>  
		<?php $js=''; ?>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong> Edit Item</strong></h3>
				</div>
			
				<div class="panel-body">    
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="col-md-3 control-label">Name</label>
								<div class="col-md-9">                                            
									<?= $this->Form->control('name',['class'=>'form-control','placeholder'=>'Item Name','label'=>false]) ?>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">Category</label>
								<div class="col-md-9">                                            
									<?= $this->Form->select('category_id',$categories,['class'=>'form-control select','label'=>false]) ?>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-md-3 control-label">Minimum Stock</label>
								<div class="col-md-9">                                            
									<?= $this->Form->control('minimum_stock',['class'=>'form-control','placeholder'=>'Minimum Stock','label'=>false]) ?>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-md-3 control-label">Show Section</label>
								<div class="col-md-9 col-xs-12">
								<?php $show_options['No'] = 'No'; ?>
								<?php $show_options['Yes'] = 'Yes'; ?>
								<?= $this->Form->select('section_show',$show_options,['class'=>'form-control select','label'=>false]) ?></div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">Item Maintain By</label>
								<div class="col-md-9 col-xs-12">
									<?php $maintain_options['itemwise'] = 'Item Wise'; ?>
									<?php $maintain_options['variationwise'] = 'Item Variation Wise'; ?>
									<?= $this->Form->select('item_maintain_by',$maintain_options,['class'=>'form-control select','label'=>false]) ?>
								</div>
							</div>
							<?php $i=0; foreach($unitVariations as $unitVariation){ 
							
							}?>
							<div class="form-group">                                        
								<label class="col-md-3 control-label">Units</label>
								<div class="col-md-9 col-xs-12">
									<?php echo $this->Form->control('item_variation_masters[unit_variations]._ids', ['label' => false,'options' =>$unit_option,'multiple' => 'checkbox']); ?>
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
							
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="col-md-3 control-label">Alias Name</label>
								<div class="col-md-9">                                            
									<?= $this->Form->control('alias_name',['class'=>'form-control','placeholder'=>'Alias Name','label'=>false]) ?>
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
								<div class="col-md-9">                                            
									<?= $this->Form->select('brand_id',$brands,['class'=>'form-control select','label'=>false,'empty'=>'---Select--']) ?>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-md-3 control-label">Description</label>
								<div class="col-md-9 col-xs-12"> 
									<?= $this->Form->control('description',['class'=>'form-control','placeholder'=>'Description','label'=>false,'rows'=>'4']) ?>
								</div>
							</div>
							<div class="form-group" id="web_image_data">
							<label class="col-md-3 control-label">Web Image</label> 
								 <?php  
									$required=true;
									$keyname = 'item/'.$item->id.'/app/'.$item->item_image;
									$info = $awsFileLoad->doesObjectExistFile($keyname);
									if($info)
									{
										$required=false;
									}
									?>
								<div class="col-md-9 col-xs-12"> 
								<?= $this->Form->control('item_image',['type'=>'file','label'=>false,'id' => 'item_image','data-show-upload'=>false, 'data-show-caption'=>false]) ?>
								<label id="item_image-error" class="error" for="item_image"></label>
								 <?php  
									
									if($info)
									{
										$result=$awsFileLoad->getObjectFile($keyname);
										
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
						<div class="table-responsive">
							<table class="table">
								<?php foreach($item->item_variation_masters as $item_variation_master){ 
								@$unit_array[]=$item_variation_master->unit_variation_id;
								// pr($unit_array); exit;
								 } ?>
								
								<tbody class="MainTbody">  
									<?php $i=0; foreach($unitVariations as $unitVariation){ ?>
										<tr>
											
												<td width="5%">
												<div class="checkbox-material">
												<?= $this->Form->control('item_variation_masters['.$i.'][check]',['type'=>'checkbox','class'=>'form-control unit icheckbox','id'=>'unit','label'=>false,'hidden'=>false,]) ?>
												
												</div>
												</td>
												<td width="80%"><?php echo $unitVariation->quantity_variation .' ' .$unitVariation->unit->unit_name ; ?>
												<?= $this->Form->control('item_variation_masters['.$i.'][unit_variation_id]',['type'=>'hidden','class'=>'form-control ','label'=>false,'value'=>$unitVariation->id]) ?>
												</td>
											
											</tr>	<?php $i++; } ?>
			
								</tbody>
							</table>
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
	
		$(document).on("click",".add_row",function(){
			addMainRow();
			renameRows();
		});
		
		//renameRows();
		function addMainRow(){
			var tr=$("#sampleTable tbody").html();
			$(".main_table tbody").append(tr);
			renameRows();
		}
		
		$(document).on("click",".delete_row",function(){
			var t=$(this).closest("tr").remove();
			renameRows();
			
		});
		
		function renameRows(){
				var i=0; 
				$(".main_table tbody tr").each(function(){
					$(this).attr("row_no",i);
						$(this).find("td:nth-child(1) select.unit").attr({name:"item_variations["+i+"][unit_id]",id:"item_variations-"+i+"-unit_id"}).rules("add", "required");
						$(this).find("td:nth-child(2) input.quantity_factor").attr({name:"item_variations["+i+"][quantity_factor]",id:"item_variations-"+i+"-quantity_factor"}).rules("add", "required");
						$(this).find("td:nth-child(3) input.print_quantity").attr({name:"item_variations["+i+"][print_quantity]",id:"item_variations-"+i+"-print_quantity"}).rules("add", "required");
						$(this).find("td:nth-child(4) input.print_rate").attr({name:"item_variations["+i+"][print_rate]",id:"item_variations-"+i+"-print_rate"}).rules("add", "required");
						$(this).find("td:nth-child(5) input.discount_per").attr({name:"item_variations["+i+"][discount_per]",id:"item_variations-"+i+"-discount_per"});
						$(this).find("td:nth-child(6) input.sales_rate").attr({name:"item_variations["+i+"][sales_rate]",id:"item_variations-"+i+"-sales_rate"}).rules("add", "required");
						$(this).find("td:nth-child(7) input.maximum_quantity_purchase").attr({name:"item_variations["+i+"][maximum_quantity_purchase]",id:"item_variations-"+i+"-maximum_quantity_purchase"});
						$(this).find("td:nth-child(8) select.ready_to_sale").attr({name:"item_variations["+i+"][ready_to_sale]",id:"item_variations-"+i+"-ready_to_sale"});
						$(this).find("td:nth-child(9) select.out_of_stock").attr({name:"item_variations["+i+"][out_of_stock]",id:"item_variations-"+i+"-out_of_stock"});
						$(this).find("td:nth-child(10) select.status1").attr({name:"item_variations["+i+"][status]",id:"item_variations-"+i+"-status"}).addClass("select");
						i++;
			});
		}
		$("#item_image").fileinput({
            showUpload: false,
            showCaption: false,
            showCancel: false,
            browseClass: "btn btn-danger",
			allowedFileExtensions: ["jpg", "png"],
			maxFileSize: 1024,
		}); 
		
		
		$(document).on("click", ".fileinput-remove-button", function(){
			$(this).closest("div.file-input").find("input[type=file]").attr("required",true);
		});
		
		';  
echo $this->Html->scriptBlock($js, array('block' => 'scriptBottom')); 		
?>