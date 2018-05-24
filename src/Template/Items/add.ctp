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
									<?= $this->Form->control('name',['class'=>'form-control itemName','placeholder'=>'Item Name','label'=>false]) ?>
									<label id="unique-error" style="display:none;color: #B64645;margin-bottom: 0px;margin-top: 3px;font-size: 11px;font-weight: normal;width: 100%;">This Item Already Exist Against This Category.</label>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">Category</label>
								<div class="col-md-9">                                            
									<?= $this->Form->select('category_id',$categories,['class'=>'form-control select isExist','label'=>false,'empty'=>'--Select--']) ?>
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
							<!--div class="form-group">
								<label class="col-md-3 control-label">Item Maintain By</label>
								<div class="col-md-9 col-xs-12">
									<?php //$maintain_options['itemwise'] = 'Item Wise'; ?>
									<?php //$maintain_options['variationwise'] = 'Item Variation Wise'; ?>
									<?php //$this->Form->select('item_maintain_by',$maintain_options,['class'=>'form-control select','label'=>false]) ?>
								</div>
							</div-->
							
							<div class="form-group">    
								<label class="col-md-3 control-label">Status</label>
								<div class="col-md-9 col-xs-12">
									<?php $options['Active'] = 'Active'; ?>
									<?php $options['Deactive'] = 'Deactive'; ?>
									<?= $this->Form->select('status',$options,['class'=>'form-control select','label'=>false]) ?>
								</div>
							</div>
							
							<div class="form-group">                                        
								<label class="col-md-3 control-label">Units</label>
								<div class="col-md-9 col-xs-12">
									<?php
									$i=0;
									foreach ($unit_option as $data) {
										 
										echo '<div class="checkbox">';
											echo '<label>';
										 		echo $this->Form->checkbox('item_variation_row['.$i.'][unit_variation_id]',['value'=>$data['value'], 'hiddenField' => false,'label' => false,'class'=>'chk_class','id'=>'class'.$i,'divid'=>'deleteDisabled'.$i]);
										 		echo $data['text']; 
										 	echo '</label>';
										 	?>
											<div class="deleteDisabled<?php echo $i;?>">
										 	<?= $this->Form->control('item_variation_row['.$i.'][item_image_web]',['type'=>'file','label'=>false,'id' => 'item_image_'.$i,'data-show-upload'=>false, 'data-show-caption'=>false,'disabled'=>true, 'required'=>false,'class'=>'class'.$i]) ?>
											<?php
										 echo '</div>'; echo '</div>';
										 echo '<label id="item_image_'.$i.'-error" class="error" for="item_image_'.$i.'"></label>';
										$i++;
									}
									?>
									<?php //echo $this->Form->control('unit_variations._ids', ['lsabel' => false,'options' =>$unit_option,'multiple' => 'checkbox']); 
									
									?>
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
   $js='var jvalidate = $("#jvalidate").validate({
		ignore: [],
		rules: {                                            
				name: {
						required: true,
				},
				
			}                                        
		});';
	
		$i=0;
		foreach ($unit_option as $data) {
		
		$js.='$("#item_image_'.$i.'").fileinput({
            showUpload: false,
            showCaption: false,
            showCancel: false,
            browseClass: "btn btn-danger",
			allowedFileExtensions: ["jpeg", "jpg", "png"],
			maxFileSize: 1024,
		});';
		$i++;
		}
		
		
		$js.='$(document).on("click", ".fileinput-remove-button", function(){
			$(this).closest("div.file-input").find("input[type=file]").attr("required",true);
		});
		
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
			ItemNameIsExist(itemName,category);
		});
		$(document).on("blur", ".itemName", function(){
			var itemName = $(".itemName").val();
			var category = $(".isExist").val(); 
			ItemNameIsExist(itemName,category);
		});
		function ItemNameIsExist(itemName="null",category="null")
		{  
			if(itemName!="" & category!="")
			{
				var url =   "'.$this->Url->build(["controller"=>"Items","action"=>"checkItemExistance"]).'";
				url =   url+"?itemName="+itemName+"&category="+category;	 
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