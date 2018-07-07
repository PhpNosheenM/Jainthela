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
								<label class="col-md-3 control-label">Discount(%)</label>
								<div class="col-md-9 col-xs-12">
									<?= $this->Form->control('discount_in_percentage',['max'=>'100','class'=>'form-control','placeholder'=>'Discount','label'=>false]) ?>
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
								<label class="col-md-3 control-label">GSTIN Holder</label>
								<div class="col-md-9 col-xs-12">
									<?= $this->Form->control('gstin_holder_name',['class'=>'form-control','placeholder'=>'GSTIN Holder Name','label'=>false]) ?>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">GSTIN Holder Address</label>
								<div class="col-md-9 col-xs-12"> 
									<?= $this->Form->control('gstin_holder_address',['class'=>'form-control','placeholder'=>'GSTIN Holder Address','label'=>false,'rows'=>'4']) ?>
								</div>
							</div>
							
							<div class="form-group">    
								<label class="col-md-3 control-label">Mobile</label>
								<div class="col-md-9 col-xs-12">
									<?= $this->Form->control('username',['class'=>'form-control','placeholder'=>'Mobile No','label'=>false]) ?>
								</div>
							</div>
							
							
							<div class="form-group">
								<label class="col-md-3 control-label">Discount Valid</label>
								<div class="col-md-9 col-xs-12">
									<div class="input-group">
										<?= $this->Form->control('discount_created_on',['class'=>'form-control datepicker','placeholder'=>'Discount Valid From','label'=>false,'type'=>'text','data-date-format' => 'dd-mm-yyyy']) ?>
										<span class="input-group-addon add-on"> - </span>
										<?= $this->Form->control('discount_expiry',['class'=>'form-control datepicker','placeholder'=>'Discount Valid To','label'=>false,'type'=>'text','data-date-format' => 'dd-mm-yyyy']) ?>
									</div>
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
										<th><?= ('House No.') ?></th>
										<th><?= ('Address') ?></th>
										<th><?= ('Landmark') ?></th>
										<th><?= ('Pincode') ?></th>
										<th><?= ('default') ?></th>
										<th  class="actions"><?= __('Actions') ?></th>
									</tr>
								</thead>
								<tbody class="MainTbody">
								<?php foreach($customer->customer_addresses as $customer_address){ ?>
									<tr>
										<td width="" valign="top">
											<input type="hidden" class="city_container" value="<?php echo $city_id; ?>" >
											<input type="hidden" class="location_container" value="<?php echo $location_id; ?>">
											<?= $this->Form->control('house_no',['class'=>'form-control house_no','label'=>false,'value'=>$customer_address->house_no]) ?>
										</td>
										<td width="30%" valign="top">
											<?= $this->Form->control('address',['class'=>'form-control address','label'=>false,'rows'=>3,'value'=>$customer_address->address]) ?>
										</td>
										<td width="20%" valign="top">
											<?= $this->Form->control('landmark',['class'=>'form-control landmark','label'=>false,'rows'=>3,'value'=>$customer_address->landmark]) ?>
										</td>
										<td width="10%" valign="top">
											<?= $this->Form->control('pincode',['minlength'=>'6','maxlength'=>'6','class'=>'form-control pincode','label'=>false,'value'=>$customer_address->pincode]) ?>
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
				<?= $this->Form->control('pincode',['minlength'=>'6','maxlength'=>'6','class'=>'form-control pincode','label'=>false]) ?>
			</td>
		
			<td valign="top">
				<?= $this->Form->control('default_address',['class'=>'ichecked', 'label'=>false,'hidden'=>false,'type'=>'checkbox']) ?>
				
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
						$(this).find("td:nth-child(1) input.city_container").attr({name:"customer_addresses["+i+"][city_id]",id:"customer_addresses-"+i+"-city_container"})
						$(this).find("td:nth-child(1) input.location_container").attr({name:"customer_addresses["+i+"][location_id]",id:"customer_addresses-"+i+"-location_container"})
						$(this).find("td:nth-child(1) input.house_no").attr({name:"customer_addresses["+i+"][house_no]",id:"customer_addresses-"+i+"-house_no"}).rules("add", "required");
						$(this).find("td:nth-child(2) textarea.address").attr({name:"customer_addresses["+i+"][address]",id:"customer_addresses-"+i+"-address"}).rules("add", "required");
						$(this).find("td:nth-child(3) textarea.landmark").attr({name:"customer_addresses["+i+"][landmark]",id:"customer_addresses-"+i+"-landmark"}).rules("add", "required");
						$(this).find("td:nth-child(4) input.pincode").attr({name:"customer_addresses["+i+"][pincode]",id:"customer_addresses-"+i+"-pincode"}).rules("add", "required");
						
						$(this).find("td:nth-child(5) input.default_address").attr({name:"customer_addresses["+i+"][default_address]",id:"customer_addresses-"+i+"-default_address"});
						
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