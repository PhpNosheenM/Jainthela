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
									<?= $this->Form->control('discount_in_percentage',['class'=>'form-control','placeholder'=>'Discount','label'=>false]) ?>
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
								<label align="left" class="col-md-3 control-label">Opening balance</label>
								<div class="col-md-6 col-xs-12">
								
									<?php echo $this->Form->control('opening_balance_value',['id'=>'opening_balance_value','class'=>'rightAligntextClass form-control input-sm balance','label'=>false,'placeholder'=>'Opening Balance']);
									?>
								</div>
								<div class="col-md-3 col-xs-12">
									<?php $options =[['value'=>'Dr','text'=>'Dr'],['value'=>'Cr','text'=>'Cr']]; ?>
									<?= $this->Form->select('debit_credit',$options,['class'=>'form-control select cr_dr','label'=>false]) ?>
								</div>
							</div>
							
						</div>
						<div class="col-md-6">
							<div class="form-group">                                        
								<label align="left" class="col-md-3 control-label">Bill to Bill</label>
								<div class="col-md-9 col-xs-12">
									<?php $options =[['value'=>'no','text'=>'No'],['value'=>'yes','text'=>'Yes']]; ?>
									<?= $this->Form->select('bill_to_bill_accounting',$options,['class'=>'form-control select bill_to_bill','label'=>false]) ?>
								</div>
							</div> 
							
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
										<?= $this->Form->control('discount_created_on',['class'=>'form-control datepicker','placeholder'=>'Discount Valid From','label'=>false,'type'=>'text','data-date-format' => 'dd-mm-yyyy','value'=>'']) ?>
										<span class="input-group-addon add-on"> - </span>
										<?= $this->Form->control('discount_expiry',['class'=>'form-control datepicker','placeholder'=>'Discount Valid To','label'=>false,'type'=>'text','data-date-format' => 'dd-mm-yyyy','value'=>'']) ?>
									</div>
								</div>
							</div>
							
						</div>
					</div>
				</div>
				<div class="panel-body">    
					<div class="row">		
							<div class="col-md-7">
								<div class="window" style="margin:auto;display:none;">
										<table width="90%" class="refTbl">
										<tbody></tbody>
										<tfoot>
										<tr style="border-top:#a5a1a1"><td colspan="2"><a role="button" class="addRefRow">Add Row</a></td><td valign="top"><input type="text" name="total" class="form-control input-sm rightAligntextClass total calculation " id="total" readonly></td><td valign="top"><input type="text" id="total_type" name="total_type" class="form-control input-sm total_type calculation " readonly></td></tr></tfoot></table>
									</div>
							</div>
						</div>
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
											<?= $this->Form->control('pincode',['class'=>'form-control pincode','label'=>false]) ?>
										</td>
										
										<td valign="top">
											<?= $this->Form->control('default_address',['class'=>'default_address', 'label'=>false,'hiddenField'=>false,'type'=>'checkbox','checked'=>'checked','templates' => ['inputContainer' => '{{content}}']]) ?>
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
<?php
$option_ref[]= ['value'=>'New Ref','text'=>'New Ref'];
$option_ref[]= ['value'=>'Advance','text'=>'Advance'];
$option_ref[]= ['value'=>'On Account','text'=>'On Account'];

?>
<table id="sampleForRef" style="display:none;" width="100%">
	<tbody>
		<tr>
			<td width="20%" valign="top"> 
				
				<?php 
				//echo $this->Form->input('type', ['empty'=>'--Select ref--','options'=>$option_ref,'label' => false,'class' => 'form-control select input-sm refType','value'=>'New Ref']); ?>
				
				<?= $this->Form->select('type',$option_ref,['class'=>'form-control', 'label'=>false]) ?>
			</td>
			<td width="" valign="top">
				<?php echo $this->Form->input('ref_name', ['type'=>'text','label' => false,'class' => 'form-control input-sm ref_name','placeholder'=>'Reference Name']); ?>
			</td>
			
			<td width="20%" style="padding-right:0px;" valign="top">
				<?php echo $this->Form->input('amount', ['label' => false,'class' => 'form-control input-sm calculation rightAligntextClass','placeholder'=>'Amount']); ?>
			</td>
			<td width="10%" style="padding-left:0px;" valign="top">
				<?php 
				//echo $this->Form->input('type_cr_dr', ['options'=>['Dr'=>'Dr','Cr'=>'Cr'],'label' => false,'class' => 'form-control input-sm  calculation refDrCr','value'=>'Dr']); ?>
				<?php $options =[['value'=>'Dr','text'=>'Dr'],['value'=>'Cr','text'=>'Cr']]; ?>
				<?= $this->Form->select('type',$options,['class'=>'form-control calculation refDrCr', 'label'=>false]) ?>
			</td>
			
			<td width="5%" align="right" valign="top">
				<a class="delete_tr_ref" href="#" role="button" style="margin-bottom: 5px;"><i class="fa fa-times"></i></a>
			</td>
		</tr>
	</tbody>
</table>

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
				<?= $this->Form->control('pincode',['class'=>'form-control pincode','label'=>false]) ?>
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
		
		
		$(document).on("change",".bill_to_bill",function(){
			var bill_accounting=$("option:selected", this).val();
			
			if(bill_accounting=="no"){ 
				$(".window").hide();
				$("div.window table tbody").find("tr").remove();
			}
			else{
				var mainAmt=$(".balance").val();
				if(mainAmt>0){
					$(".window").show();
					AddRefRow();
				}
				
			}
			
		});
		 
		$(document).on("blur",".balance",function(){
			var main_amt=$(this).val();
			var bill_accounting=$(".bill_to_bill option:selected").val();
			if(main_amt>0 && bill_accounting=="yes"){
					$(".window").show();
					AddRefRow();
				}
			
		});
		
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
		
		$(document).on("click",".delete_tr_ref",function(){
				$(this).closest("tr").remove();
				calculation();
				
			});
			
		$(document).on("click",".add_row",function(){
			addMainRow();
			renameRows();
		});
		
		//addMainRow();
		renameRows();
		function addMainRow(){
			var tr=$("#sampleTable tbody").html();
			$(".main_table tbody").append(tr);
			renameRows();
			
		}
		$(document).on("click",".addRefRow",function(){
				AddRefRow();
				
		});
		
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
		
		function AddRefRow(){
			var refTr=$("#sampleForRef tbody tr").clone();
			$("div.window table tbody").append(refTr);
			renameRefRows();
			calculation();
		}
		
		function renameRefRows(){
			var i=0;
			var bill_accounting=$("option:selected", this).val();
			var cr_dr =$(".cr_dr option:selected").val();
			var mainAmt=$(".balance").val();
			if(cr_dr=="Dr"){
					var eqlClassDr=$(".balance").attr("id");
			}else{
					var eqlClassCr=$(".balance").attr("id");
			}
			$("div.window table tbody tr").each(function(){
					$(this).find("td:nth-child(1) select.refType").attr({name:"reference_details["+i+"][type]",id:"reference_details-"+i+"-type"}).addClass("select");
					var is_input=$(this).find("td:nth-child(2) input.ref_name").length;
					if(is_input){
						$(this).find("td:nth-child(2) input.ref_name").attr({name:"reference_details["+i+"][ref_name]",id:"reference_details-"+i+"-ref_name"}).rules("add", "required");
					}
					var Dr_Cr=$(this).find("td:nth-child(4) select option:selected").val();
					if(Dr_Cr=="Dr"){
						$(this).find("td:nth-child(3) input").attr({name:"reference_details["+i+"][debit]",id:"reference_details-"+i+"-debit"}).rules("add", "required");
					}else{
						$(this).find("td:nth-child(3) input").attr({name:"reference_details["+i+"][credit]",id:"reference_details-"+i+"-credit"}).rules("add", "required");
					}
					i++;
				});
				
					var total_type=$("div.window table.refTbl tfoot tr td:nth-child(3) input.total_type").val();
				if(total_type=="Dr"){
					eqlClass=eqlClassDr;
				}else{
					eqlClass=eqlClassCr;
				}
				
				$("div.window table.refTbl tfoot tr td:nth-child(2) input.total")
						.rules("add", {
							equalTo: "#"+eqlClass,
							messages: {
								equalTo: "Enter bill wise details upto "+mainAmt+" "+cr_dr
							}
						});
		}
		$(document).on("keyup, change",".calculation",function()
			{ 
				calculation();
			});	
		
		function calculation(){ 
				var total_debit=0;var total_credit=0; var remaining=0;
				$("div.window table tbody tr").each(function(){
					var Dr_Cr=$(this).find("td:nth-child(4) select option:selected").val();
					var amt= parseFloat($(this).find("td:nth-child(3) input").val());
					
					if(!amt){ amt=0; }
					if(Dr_Cr=="Dr"){ 
						total_debit=total_debit+amt;
						
					}
					else if(Dr_Cr=="Cr"){
						total_credit=total_credit+amt;
					}
					
					remaining=total_debit-total_credit;
					
					if(remaining>0){
						$(this).closest("table").find(" tfoot td:nth-child(2) input.total").val(remaining);
						$(this).closest("table").find(" tfoot td:nth-child(3) input.total_type").val("Dr");
					}
					else if(remaining<0){
						remaining=Math.abs(remaining)
						$(this).closest("table").find(" tfoot td:nth-child(2) input.total").val(remaining);
						$(this).closest("table").find(" tfoot td:nth-child(3) input.total_type").val("Cr");
					}
					else{
						$(this).closest("table").find(" tfoot td:nth-child(2) input.total").val("0");
						$(this).closest("table").find(" tfoot td:nth-child(3) input.total_type").val("");	
					}
				});
				renameRefRows();	
			}
	
		';  
echo $this->Html->scriptBlock($js, array('block' => 'scriptBottom')); 		
?>