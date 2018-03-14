<?php $this->set('title', 'Item'); ?>
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
	<div class="row">
		<div class="col-md-12">
		<?= $this->Form->create($item,['id'=>"jvalidate",'class'=>"form-horizontal"]) ?>  
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
								<label class="col-md-3 control-label">Out Of Stock</label>
								<div class="col-md-9 col-xs-12">
									<?php $out_options['No'] = 'No'; ?>
									<?php $out_options['Yes'] = 'Yes'; ?>
								
								<?= $this->Form->select('out_of_stock',$out_options,['class'=>'form-control select','label'=>false]) ?>
								</div>
							</div>
							<div class="form-group">                                        
								<label class="col-md-3 control-label">Ready To Sale</label>
								<div class="col-md-9 col-xs-12">
									<?php $sale_options['No'] = 'No'; ?>
									<?php $sale_options['Yes'] = 'Yes'; ?>
								<?= $this->Form->select('ready_to_sale',$sale_options,['class'=>'form-control select','label'=>false]) ?>
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
								<label class="col-md-3 control-label">Brand</label>
								<div class="col-md-9">                                            
									<?= $this->Form->select('brand_id',$brands,['class'=>'form-control select','label'=>false,'empty'=>'---Select--']) ?>
								</div>
							</div>
							<div class="form-group">                                        
								<label class="col-md-3 control-label">Sample Request</label>
								<div class="col-md-9 col-xs-12">
								<?php $request_options['Yes'] = 'Yes'; ?>
								<?php $request_options['No'] = 'No'; ?>
								<?= $this->Form->select('request_for_sample',$request_options,['class'=>'form-control select','label'=>false]) ?>
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
								 <?php  
									$required=true;
									$keyname = 'item/'.$item->id.'/app/'.$item->item_image;
									$info = $awsFileLoad->doesObjectExistFile($keyname);
									if($info)
									{
										$result=$awsFileLoad->getObjectFile($keyname);
										$app_image_view='<img src="data:'.$result['ContentType'].';base64,'.base64_encode($result['Body']).'" alt="" style="width: auto; height: 160px;" class="file-preview-image"/>';
										
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
							<table class="table table-bordered main_table">
								<thead>
									<tr>
										<th><?= ('Unit') ?></th>
										<th><?= ('Quantity Factor') ?></th>
										<th><?= ('Print Quantity') ?></th>
										<th><?= ('Print Rate') ?></th>
										<th><?= ('Discount (%)') ?></th>
										<th><?= ('Sale Rate') ?></th>
										<th><?= ('Maximum Quantity') ?></th>
										<th><?= ('Ready To Sale') ?></th>
										<th><?= ('Out Of Stock') ?></th>
										<th><?= ('Status') ?></th>
										
										<th  class="actions"><?= __('Actions') ?></th>
									</tr>
								</thead>
								<tbody class="MainTbody">  
								<?php foreach($item->item_variations as $item_variation){ //pr($item_variation);exit; ?>
									<tr class="MainTr">
										<td  valign="top"> 
											<?php echo $this->Form->select('unit_id', $units,['class'=>'form-control unit select','label'=>false, 'value'=>$item_variation->unit_id]) ?> 
										</td>
										<td width="" valign="top">
											<?= $this->Form->control('quantity_factor',['class'=>'form-control quantity_factor','label'=>false , 'value'=>$item_variation->quantity_factor]) ?>
										</td>
										<td valign="top">
											<?= $this->Form->control('print_quantity',['class'=>'form-control print_quantity','label'=>false, 'value'=>$item_variation->print_quantity]) ?>
										</td>
										<td valign="top">
											<?= $this->Form->control('print_rate',['class'=>'form-control print_rate','label'=>false, 'value'=>$item_variation->print_rate]) ?>
										</td>
										<td valign="top">
											<?= $this->Form->control('discount_per',['class'=>'form-control discount_per','label'=>false, 'value'=>$item_variation->discount_per]) ?>
										</td>
										<td valign="top">
											<?= $this->Form->control('sales_rate',['class'=>'form-control sales_rate','label'=>false, 'value'=>$item_variation->sales_rate]) ?>
										</td>
										<td valign="top">
											<?= $this->Form->control('maximum_quantity_purchase',['class'=>'form-control maximum_quantity_purchase','label'=>false, 'value'=>$item_variation->maximum_quantity_purchase]) ?>
										</td>
										
										<td valign="top">
											<?php $sale_options['No'] = 'No'; ?>
											<?php $sale_options['Yes'] = 'Yes'; ?>
											<?= $this->Form->select('ready_to_sale',$sale_options,['class'=>'form-control  ready_to_sale','label'=>false, 'value'=>$item_variation->ready_to_sale]) ?>
										</td>
										<td  valign="top">
											<?php $out_options['No'] = 'No'; ?>
											<?php $out_options['Yes'] = 'Yes'; ?>
											<?= $this->Form->select('out_of_stock',$out_options,['class'=>'form-control  out_of_stock','label'=>false, 'value'=>$item_variation->out_of_stock]) ?>
										</td>
										<td width="10%" valign="top">
											<?php $options1['Active'] = 'Active'; ?>
											<?php $options1['Deactive'] = 'Deactive'; ?>
															<?= $this->Form->select('status',$options1,['class'=>' form-control status1 ','label'=>false, 'value'=>$item_variation->status]) ?>
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
				<?php echo $this->Form->select('unit_id', $units,['class'=>'form-control unit select','label'=>false]) ?> 			</td>
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
				<?= $this->Form->select('ready_to_sale',$sale_options,['class'=>'form-control  ready_to_sale','label'=>false]) ?>
			</td>
			<td  valign="top">
				<?php $out_options['No'] = 'No'; ?>
				<?php $out_options['Yes'] = 'Yes'; ?>
				<?= $this->Form->select('out_of_stock',$out_options,['class'=>'form-control  out_of_stock','label'=>false]) ?>
			</td>
			<td width="10%" valign="top">
				<?php $options1['Active'] = 'Active'; ?>
				<?php $options1['Deactive'] = 'Deactive'; ?>
								<?= $this->Form->select('status',$options1,['class'=>'status1 form-control  ','label'=>false]) ?>
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
		
		renameRows();
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