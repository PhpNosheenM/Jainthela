<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}
</style>
<?php $this->set('title', 'Customer'); ?>
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
	<div class="row">
		<div class="col-md-12">
		<?= $this->Form->create($customer,['id'=>"jvalidate",'class'=>"form-horizontal"]) ?>  
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong> Customer</strong></h3>
				</div>
			
				<div class="panel-body">    
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="col-md-3 control-label">Customer Name</label>
								<div class="col-md-9">                                            
									<?= $this->Form->control('name',['class'=>'form-control','placeholder'=>'Customer Name','label'=>false]) ?>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">Firm Name</label>
								<div class="col-md-9">    
									<?= $this->Form->control('firm_name',['class'=>'form-control','placeholder'=>'Firm Name','label'=>false]) ?>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">Firm Address</label>
								<div class="col-md-9 col-xs-12"> 
									<?= $this->Form->control('firm_address',['class'=>'form-control','placeholder'=>'Firm Address','label'=>false,'rows'=>'4']) ?>
								</div>
							</div>
							
							<div class="form-group">                                        
								<label class="col-md-3 control-label">Email</label>
								<div class="col-md-9 col-xs-12">
									<?= $this->Form->control('email',['class'=>'form-control','placeholder'=>'Email','label'=>false]) ?>
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
								<label class="col-md-3 control-label">GSTIN</label>
								<div class="col-md-9 col-xs-12">
									<?= $this->Form->control('gstin',['class'=>'form-control gst','placeholder'=>'Eg:22ASDFR0967W6Z5','label'=>false]) ?>
								</div>
							</div>
							
							<div class="form-group">    
								<label class="col-md-3 control-label">Mobile</label>
								<div class="col-md-9 col-xs-12">
									<?= $this->Form->control('username',['type'=>'number','minlength'=>'10','maxlength'=>'10','class'=>'form-control','placeholder'=>'Mobile No','label'=>false]) ?>
								</div>
							</div>
							
							 <div class="form-group">
								<label class="col-md-3 control-label">Discount</label>
								<div class="col-md-9 col-xs-12">
									<?= $this->Form->control('membership_discount',['type'=>'text','class'=>'form-control','placeholder'=>'Discount','label'=>false]) ?>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">Discount Date</label>
								<div class="col-md-9 col-xs-12">
									<div class="input-group">
									<span class="input-group-addon add-on"> FROM </span>
										<?= $this->Form->control('start_date',['class'=>'form-control datepicker','placeholder'=>'From','label'=>false,'type'=>'text','data-date-format' => 'dd-mm-yyyy','value'=>date('d-m-Y',strtotime($customer->start_date))]) ?>
										<span class="input-group-addon add-on"> TO </span>
										<?= $this->Form->control('end_date',['class'=>'form-control datepicker','placeholder'=>'To','label'=>false,'type'=>'text','data-date-format' => 'dd-mm-yyyy','value'=>date('d-m-Y',strtotime($customer->end_date))]) ?>
										</div>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-md-3 control-label">Default Credit Days</label>
								<div class="col-md-9 col-xs-12">
									<?= $this->Form->control('default_credit_days',['type'=>'number','class'=>'form-control','placeholder'=>'Default Credit Days','label'=>false]) ?>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-md-3 control-label">Free Shipping</label>
								<div class="col-md-9 col-xs-12">
									<?php $options11['No'] = 'No'; ?>
									<?php $options11['Yes'] = 'Yes'; ?>
									<?= $this->Form->select('is_free_shipping',$options11,['class'=>'form-control select','label'=>false]) ?>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">Cancel Order</label>
								<div class="col-md-9 col-xs-12">
									<?= $this->Form->control('cancel_order_count',['type'=>'number','class'=>'form-control','placeholder'=>'Default Credit Days','label'=>false]) ?>
								</div>
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
										<th><?= ('Name.') ?></th>
										<th><?= ('Mobile No.') ?></th>
										<th><?= ('House No.') ?></th>
										<th><?= ('Address') ?></th>
										<th><?= ('Landmark') ?></th>
										<th><?= ('Pincode') ?></th>
										<th><?= ('Area') ?></th>
										<th><?= ('default') ?></th>
										<th  class="actions"><?= __('Actions') ?></th>
									</tr>
								</thead>
								<tbody class="MainTbody">
								<?php foreach($customer->customer_addresses as $customer_address){ ?>
									<tr>
										<td width="30%" valign="top">
											<?= $this->Form->control('receiver_name',['class'=>'form-control receiver_name','label'=>false,'value'=>$customer_address->receiver_name]) ?>
										</td>
										<td width="30%" valign="top">
											<?= $this->Form->control('mobile_no',['class'=>'form-control mobile_no','label'=>false,'value'=>$customer_address->mobile_no]) ?>
										</td>
										<td width="" valign="top">
											<input type="hidden" class="city_container" value="<?php echo $city_id; ?>" >
											<input type="hidden" class="location_container" value="<?php echo $location_id; ?>">
											<input type="hidden" class="raw_id" value="<?php echo $customer_address->id; ?>">
											<?= $this->Form->control('house_no',['class'=>'form-control house_no','label'=>false,'value'=>$customer_address->house_no]) ?>
										</td>
										<td width="30%" valign="top">
											<?= $this->Form->control('address',['class'=>'form-control address','label'=>false,'rows'=>3,'value'=>$customer_address->address]) ?>
										</td>
										<td width="20%" valign="top">
											<?= $this->Form->control('landmark',['class'=>'form-control landmark','label'=>false,'rows'=>3,'value'=>$customer_address->landmark_name]) ?>
										</td>
										<td width="10%" valign="top">
											<?= $this->Form->control('pincode',['minlength'=>'6','maxlength'=>'6','class'=>'form-control pincode','label'=>false,'value'=>$customer_address->pincode]) ?>
										</td>
										<td>
											<?= $this->Form->select('landmark_id',$Landmarks,['empty'=>'---Select--Landmark---','class'=>'form-control select location_id','label'=>false,'required'=>'required', 'data-live-search'=>true,'value'=>$customer_address->landmark_id]) ?>
										</td>
										<?php if($customer_address->default_address==1){
												@$checked="checked";
											} else{
												@$checked="";
											}?>
										<td valign="top">
											<?= $this->Form->control('default_address',['class'=>'default_address', 'label'=>false,'hiddenField'=>false,'type'=>'checkbox','checked'=>$checked,'value'=>$customer_address->default_address,
											'templates' => ['inputContainer' => '{{content}}']]) ?>
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
				<input type="hidden" class="city_container" value="<?php echo $city_id; ?>" >
				<input type="hidden" class="location_container" value="<?php echo $location_id; ?>">
				<?= $this->Form->control('house_no',['class'=>'form-control house_no','label'=>false]) ?>
			</td>
			<td width="30%" valign="top">
				<?= $this->Form->control('address',['class'=>'form-control address','label'=>false,'rows'=>3]) ?>
			</td>
			<td width="20%" valign="top">
				<?= $this->Form->control('landmark',['class'=>'form-control landmark','label'=>false,'rows'=>3]) ?>
			</td>
			<td width="10%" valign="top">
				<?= $this->Form->control('pincode',['type'=>'number','minlength'=>'6','maxlength'=>'6','class'=>'form-control pincode','label'=>false]) ?>
			</td>
			<td>
				<?= $this->Form->select('location_id',$Landmarks,['empty'=>'---Select--Location---','class'=>'form-control location_id','label'=>false,'id'=>'location_id','required'=>'required', 'data-live-search'=>true]) ?>
				 
			</td>
		
			<td valign="top">
				<?= $this->Form->control('default_address',['class'=>'default_address', 'label'=>false,'hiddenField'=>false,'type'=>'checkbox','checked'=>'','templates' => ['inputContainer' => '{{content}}']]) ?>
				
			</td>
			
			<td valign="top"  >
				<a class="btn btn-primary  btn-condensed btn-sm add_row" href="#" role="button" ><i class="fa fa-plus"></i></a>
				<a class="btn btn-danger  btn-condensed btn-sm delete_row " href="#" role="button" ><i class="fa fa-times"></i></a>
			</td>
		</tr>
	</tbody>
</table>

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
					
					email: {
							required: true,
					},
					username: {
							required: true,
					},
					
			}	                                  
		});
		
		$(document).on("click",".add_row",function(){
			addMainRow();
			renameRows();
		});
		renameRows();
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
		
		$(document).on("click",".default_address",function(){
			$(".default_address").prop("checked",false);
			$(".default_address").val(0);
			$(this).prop("checked",true);
			$(this).val(1);
		});
		
		function renameRows(){
			var i=0; 
			$(".main_table tbody tr").each(function(){
				$(this).attr("row_no",i);
				$(this).find(".raw_id").attr({name:"customer_addresses["+i+"][id]",id:"customer_addresses-"+i+"-id"});
				$(this).find(".receiver_name").attr({name:"customer_addresses["+i+"][receiver_name]",id:"customer_addresses-"+i+"-receiver_name"})
				$(this).find(".mobile_no").attr({name:"customer_addresses["+i+"][mobile_no]",id:"customer_addresses-"+i+"-mobile_no"})
				
				$(this).find(".city_container").attr({name:"customer_addresses["+i+"][city_id]",id:"customer_addresses-"+i+"-city_container"})
						$(this).find(".location_container").attr({name:"customer_addresses["+i+"][location_id]",id:"customer_addresses-"+i+"-location_container"})
						$(this).find(".house_no").attr({name:"customer_addresses["+i+"][house_no]",id:"customer_addresses-"+i+"-house_no"}).rules("add", "required");
						$(this).find("textarea.address").attr({name:"customer_addresses["+i+"][address]",id:"customer_addresses-"+i+"-address"}).rules("add", "required");
						$(this).find("textarea.landmark").attr({name:"customer_addresses["+i+"][landmark_name]",id:"customer_addresses-"+i+"-landmark_name"}).rules("add", "required");
						$(this).find(".pincode").attr({name:"customer_addresses["+i+"][pincode]",id:"customer_addresses-"+i+"-pincode"}).rules("add", "required");
						$(this).find("select.location_id").selectpicker();
						$(this).find(".location_id").attr({name:"customer_addresses["+i+"][landmark_id]",id:"customer_addresses-"+i+"-landmark_id"});
						$(this).find(".default_address").attr({name:"customer_addresses["+i+"][default_address]",id:"customer_addresses-"+i+"-default_address"});
				i++;
			});
		}

		$(document).on("blur", ".gst", function()
		{ 
			var mdl=$(this).val();
			var numbers = /^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/;
			if(mdl.match(numbers))
			{
				
			}
			else
			{
				$(this).val("");
				return false;
			}
		});
	
		';  
echo $this->Html->scriptBlock($js, array('block' => 'scriptBottom')); 		
?>