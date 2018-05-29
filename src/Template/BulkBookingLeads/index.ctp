<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}

</style><?php $this->set('title', 'Bulk Booking Lead'); ?>
<div class="page-content-wrap">
        <div class="page-title">                    
			<h2><span class="fa fa-arrow-circle-o-left"></span> Bulk Booking Lead</h2>
		</div> 
	<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">ADD Bulk Booking Lead</h3>
						</div>
						<?= $this->Form->create($bulkBookingLead,['id'=>"jvalidate",'type'=>'file','enctype'=>'multipart/form-data']) ?>
						<?php $js=''; ?>
						<div class="panel-body ">
							<div class="col-md-6">
								<div class="form-group">
									<label>Customer</label>
										<?= $this->Form->control('customer_id',['option'=>$customers,'class'=>'form-control select','empty'=>'select customer','label'=>false]) ?>
									<span class="help-block"></span>
								</div>
								<div class="form-group">
									<label>Name</label>
										<?= $this->Form->control('name',['class'=>'form-control','placeholder'=>'Name','label'=>false]) ?>
									<span class="help-block"></span>
								</div>
								<div class="form-group">
									<label>Mobile</label>
										<?= $this->Form->control('mobile',['type'=>'number','class'=>'form-control','placeholder'=>'Mobile','label'=>false]) ?>
									<span class="help-block"></span>
								</div>
							</div>	 
							
							<div class="col-md-6">
								<div class="form-group">
										<label>Delivery Date</label>
										<?= $this->Form->control('delivery_date',['class'=>'form-control datepicker','placeholder'=>'Delivery Date','label'=>false,'type'=>'text','data-date-format' => 'dd-mm-yyyy','value'=>'']) ?>
										 
								</div>
								<div class="form-group">
									<label>Delivery Time</label>
										<div class="input-group bootstrap-timepicker">
										<?= $this->Form->control('delivery_time',['class'=>'form-control timepicker','placeholder'=>'Delivery Time','label'=>false]) ?>
										<span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
										</div>
								</div>
								<div class="form-group">
									<label>Status</label>
									<?php $options['Open'] = 'Open'; ?>
									<?php $options['Close'] = 'Close'; ?>
									<?= $this->Form->select('status',$options,['class'=>'form-control select','label'=>false]) ?>
								</div>
							</div>	 
							<div class="col-md-12">
									<div class="form-group">
											<label>Lead Description</label>
											<?= $this->Form->control('lead_description',['class'=>'form-control','placeholder'=>'Lead Description','label'=>false]) ?>
											<span class="help-block"></span>
									</div>
							</div>
						</div>
					<div class="panel-body">
					<div class="row">
						<div class="">
							<table class="table table-bordered main_table">
								<thead>
									<tr> 
										<th><?= ('Image') ?></th>
										
										<th  class="actions"><?= __('Actions') ?></th>
									</tr>
								</thead>
								<tbody class="MainTbody">  
									<tr class="MainTr">
			 
										<td width="50%" valign="top">
											<div class="form-group" id="web_image_data">
												<label class="col-md-3 control-label">Offer Image</label> 
												<div class="col-md-9 col-xs-12"> 
													<?= $this->Form->control('image_name',['class'=>'image_name','type'=>'file','label'=>false,'id' => 'image_name','data-show-upload'=>false, 'data-show-caption'=>false, 'required'=>true]) ?>
													<label id="combo_offer_image-error" class="error" for="combo_offer_image"></label>
												</div>
											</div>
										</td>
										
										
										<td valign="top"  >
											<a class="btn btn-primary  btn-condensed btn-sm add_row" href="#" role="button" ><i class="fa fa-plus"></i></a>
											<a class="btn btn-danger  btn-condensed btn-sm delete_row " href="#" role="button" ><i class="fa fa-times"></i></a>
										</td>
									</tr>
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
			
			 
			<td width="50%" valign="top">
				<div class="form-group" id="web_image_data">
					<label class="col-md-3 control-label">Offer Image</label> 
					<div class="col-md-9 col-xs-12"> 
						<?= $this->Form->control('image_name',['class'=>'image_name','type'=>'file','label'=>false,'data-show-upload'=>false, 'data-show-caption'=>false, 'required'=>true]) ?>
						<label id="combo_offer_image-error" class="error" for="combo_offer_image"></label>
					</div>
				</div>
			</td>
			
			<td valign="top"  >
				<a class="btn btn-primary  btn-condensed btn-sm add_row" href="#" role="button" ><i class="fa fa-plus"></i></a>
				<a class="btn btn-danger  btn-condensed btn-sm delete_row " href="#" role="button" ><i class="fa fa-times"></i></a>
			</td>
		</tr>
	</tbody>
</table>
<!-- END CONTENT FRAME -->
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
		});
		
		$("#image_name").fileinput({
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
			alert();
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
						  
						$(this).find("td:nth-child(1) .image_name").attr({name:"bulk_booking_lead_row["+i+"][image_name]"}).rules("add", "required");
						$(this).find("td:nth-child(1) .image_name").attr({id:"image_name"+i});
						
						$("#image_name"+i).fileinput({
							showUpload: false,
							showCaption: false,
							showCancel: false,
							browseClass: "btn btn-danger",
							allowedFileExtensions: ["jpg", "png"],
							maxFileSize: 1024,
						}); 
						i++;
			});
			calculation();
		}
		
		$(document).on("click", ".fileinput-remove-button", function(){
			$(this).closest("div.file-input").find("input[type=file]").attr("required",true);
		});
		';  
echo $this->Html->scriptBlock($js, array('block' => 'scriptBottom')); 		
?>
