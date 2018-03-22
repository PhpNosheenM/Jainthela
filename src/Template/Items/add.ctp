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
									<?= $this->Form->select('section_show',$show_options,['class'=>'form-control select','label'=>false]) ?>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">Item Maintain By</label>
								<div class="col-md-9 col-xs-12">
									<?php $maintain_options['itemwise'] = 'Item Wise'; ?>
									<?php $maintain_options['variationwise'] = 'Item Variation Wise'; ?>
									<?= $this->Form->select('item_maintain_by',$maintain_options,['class'=>'form-control select','label'=>false]) ?>
								</div>
							</div>
							<div class="form-group">                                        
								<label class="col-md-3 control-label">Units</label>
								<div class="col-md-9 col-xs-12">
									<?php echo $this->Form->control('unit_variations._ids', ['label' => false,'options' =>$unit_option,'multiple' => 'checkbox']); ?>
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
									<?= $this->Form->select('brand_id',$brands,['class'=>'form-control select','label'=>false, 'data-live-search'=>true,'empty'=>'---Select--']) ?>
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
								<div class="col-md-9 col-xs-12"> 
								<?= $this->Form->control('item_image',['type'=>'file','label'=>false,'id' => 'item_image','data-show-upload'=>false, 'data-show-caption'=>false, 'required'=>true]) ?>
								<label id="item_image-error" class="error" for="item_image"></label>
								</div>
							</div>
						
					</div>
				<!--	<div class="panel-body">    
					<div class="row">
						<div class="table-responsive">
							<table class="table">
								<tbody class="MainTbody"> 
								<?php $i=0; foreach($unitVariations as $unitVariation){ ?>
								<tr>
											
												<td width="5%">
												<div class="checkbox-material">
												<?= $this->Form->control('item_variation_masters['.$i.'][check]',['type'=>'checkbox','class'=>'form-control unit icheckbox','id'=>'unit','label'=>false,'hidden'=>false]) ?>
												<?= $this->Form->control('item_variation_masters['.$i.'][check]',['type'=>'checkbox','class'=>'form-control unit icheckbox','id'=>'unit','label'=>false,'hidden'=>false]) ?>
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
					</div> -->
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



<table id="sampleTable" width="100%" style="display:none;">
	<tbody class="sampleMainTbody">
		<tr class="MainTr">
			<td  valign="top"> 
				<?php echo $this->Form->select('unit_id', $units,['class'=>'form-control unit','label'=>false]) ?> 			</td>
			<td width="" valign="top">
				<?= $this->Form->control('quantity_factor',['class'=>'form-control quantity_factor','label'=>false]) ?>
			</td>
			<td valign="top">
				<?= $this->Form->control('print_quantity',['class'=>'form-control print_quantity','label'=>false]) ?>
			</td>
			<td valign="top">
				<?= $this->Form->control('print_rate',['class'=>'form-control print_rate','label'=>false]) ?>
			</td>
			<td valign="top">
				<?= $this->Form->control('discount_per',['class'=>'form-control discount_per','label'=>false]) ?>
			</td>
			<td valign="top">
				<?= $this->Form->control('sales_rate',['class'=>'form-control sales_rate','label'=>false]) ?>
			</td>
			<td valign="top">
				<?= $this->Form->control('maximum_quantity_purchase',['class'=>'form-control maximum_quantity_purchase','label'=>false]) ?>
			</td>
			
			<td valign="top">
				<?php $sale_options['No'] = 'No'; ?>
				<?php $sale_options['Yes'] = 'Yes'; ?>
				<?= $this->Form->select('ready_to_sale',$sale_options,['class'=>'form-control select ready_to_sale','label'=>false]) ?>
			</td>
			<td  valign="top">
				<?php $out_options['No'] = 'No'; ?>
				<?php $out_options['Yes'] = 'Yes'; ?>
				<?= $this->Form->select('out_of_stock',$out_options,['class'=>'form-control select out_of_stock','label'=>false]) ?>
			</td>
			<td width="10%" valign="top">
				<?php $options1['Active'] = 'Active'; ?>
				<?php $options1['Deactive'] = 'Deactive'; ?>
								<?= $this->Form->select('status',$options1,['class'=>'status1 form-control select ','label'=>false]) ?>
			</td>
			<td valign="top"  >
				<a class="btn btn-primary  btn-condensed btn-sm add_row" href="#" role="button" ><i class="fa fa-plus"></i></a>
				<a class="btn btn-danger  btn-condensed btn-sm delete_row " href="#" role="button" ><i class="fa fa-times"></i></a>
			</td>
		</tr>
	</tbody>
</table>

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
	
		$(document).on("click",".add_row",function(){
			addMainRow();
			renameRows();
		});
		
		//addMainRow();
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
						$(this).find("td:nth-child(10) select.status1").attr({name:"item_variations["+i+"][status]",id:"item_variations-"+i+"-status"});
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