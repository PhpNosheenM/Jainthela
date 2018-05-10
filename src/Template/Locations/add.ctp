<?php $this->set('title', 'Location'); ?>
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
	<div class="row">
		<div class="col-md-12">
		<?= $this->Form->create($location,['id'=>"jvalidate",'class'=>"form-horizontal"]) ?>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong>Location</strong></h3>
				</div>
			
				<div class="panel-body">   			
					<div class="row">
					
					<fieldset>
					<legend><center>Location Registration</center></legend>
					<div class="col-md-12">
						<div class="col-md-6">
							<div class="form-group">
									<label>Name</label>
									<?= $this->Form->control('name',['class'=>'form-control','placeholder'=>'Name','label'=>false]) ?>
									<span class="help-block"></span>
					        </div>
							
							 <div class="form-group">
									<label>Alise</label>
									<?= $this->Form->control('alise',['class'=>'form-control','placeholder'=>'Alise','label'=>false]) ?>
									<span class="help-block"></span>
					        </div>
					        <div class="form-group">
									<label>Books Beginning From</label>
									<?= $this->Form->control('books_beginning_from',['class'=>'form-control datepicker','placeholder'=>'Books Beginning From','label'=>false,'type'=>'text','data-date-format' => 'dd-mm-yyyy','value'=>'']) ?> 
									<span class="help-block"></span>
					        </div>
					    </div>
						<div class="col-md-6">	
							 <div class="form-group">
									<label>Latitude</label>
									<?= $this->Form->control('latitude',['class'=>'form-control','placeholder'=>'Latitude','label'=>false]) ?>
									<span class="help-block"></span>
					        </div>
							
							 <div class="form-group">
									<label>Longitude</label>
									<?= $this->Form->control('longitude',['class'=>'form-control','placeholder'=>'Longitude','label'=>false]) ?>
									<span class="help-block"></span>
					        </div>

							<div class="form-group">
								<label>Status</label>
								<?php $options['Active'] = 'Active'; ?>
								<?php $options['Deactive'] = 'Deactive'; ?>
								<?= $this->Form->select('status',$options,['class'=>'form-control select','label'=>false]) ?>
					        </div>
					    </div>
					</div>
					</fieldset>
					<br>
					<br>
					<br>
						<fieldset>
						<legend><center>Seller Registration</center></legend>
						<div class="col-md-6">
						
							<div class="form-group">
								<label class="col-md-3 control-label">Seller Name</label>
								<div class="col-md-9">
									<?= $this->Form->control('seller_name',['class'=>'form-control','placeholder'=>'Seller Name','label'=>false]) ?>
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
								<label class="col-md-3 control-label">Firm Email</label>
								<div class="col-md-9">
									<?= $this->Form->control('firm_email',['type'=>'mail','class'=>'form-control','placeholder'=>'Firm Email','label'=>false]) ?>
								</div>
							</div>
							 
							 <div class="form-group">
								<label class="col-md-3 control-label">Firm Contact</label>
								<div class="col-md-9">
									<?= $this->Form->control('firm_contact',['type'=>'number','class'=>'form-control','placeholder'=>'Firm Contact','label'=>false]) ?>
								</div>
							</div>
							
							 <div class="form-group">
								<label class="col-md-3 control-label">Firm Pincode</label>
								<div class="col-md-9">
									<?= $this->Form->control('firm_pincode',['type'=>'number','class'=>'form-control','placeholder'=>'Firm Pincode','label'=>false]) ?>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-md-3 control-label">Registration Date</label>
								<div class="col-md-9"> 
										<?= $this->Form->control('registration_date',['class'=>'form-control datepicker','placeholder'=>'Registration Date','label'=>false,'type'=>'text','data-date-format' => 'dd-mm-yyyy','value'=>'']) ?> 
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
								<label class="col-md-3 control-label">PAN No </label>
								<div class="col-md-9"> 
									<div class="input text required error" aria-required="true">
										<?= $this->Form->control('pan',['class'=>'form-control','placeholder'=>'PAN No','label'=>false]) ?>
									</div>
								</div>
							</div>
							
							<div class="form-group">                                        
								<label class="col-md-3 control-label">GSTIN</label>
								<div class="col-md-9 col-xs-12">
									<?= $this->Form->control('gstin',['class'=>'form-control gst','placeholder'=>'Eg:22ASDFR0967W6Z5','label'=>false]) ?>
								</div>
							</div>
							
							
							<div class="form-group">                                        
								<label class="col-md-3 control-label">GSTIN Holder Name</label>
								<div class="col-md-9 col-xs-12">
									<?= $this->Form->control('gstin_holder_name',['class'=>'form-control','placeholder'=>'GSTIN Holder Name','label'=>false]) ?>
								</div>
							</div>
							
							<div class="form-group">                                        
								<label class="col-md-3 control-label">GSTIN Address</label>
								<div class="col-md-9 col-xs-12">
									<?= $this->Form->control('gstin_holder_address',['class'=>'form-control','placeholder'=>'GSTIN Address','label'=>false,'rows'=>4]) ?>
								</div>
							</div>
							    
							
							<div class="form-group">
								<label class="col-md-3 control-label">User Name</label>
								<div class="col-md-9"> 
									<div class="input text required error" aria-required="true">
										<?= $this->Form->control('username',['class'=>'form-control','placeholder'=>'User Name','label'=>false]) ?>
									</div>
								</div>
							</div>
							
							<div class="form-group">                                        
								<label class="col-md-3 control-label">Password</label>
								<div class="col-md-9 col-xs-12">
									<?= $this->Form->control('password',['class'=>'form-control','placeholder'=>'Password','label'=>false,'type'=>'password']) ?>
								</div>
							</div>
							
							
							<div class="form-group">                                        
								<label class="col-md-3 control-label">Status</label>
								<div class="col-md-9 col-xs-12">
									<?php $options1['Active'] = 'Active'; ?>
								<?php $options1['Deactive'] = 'Deactive'; ?>
								<?= $this->Form->select('seller_status',$options1,['class'=>'form-control select','label'=>false]) ?>
								</div>
							</div>
							
						</div>
						</fieldset>
						</div>
						</div>
					 
							 
							
							
							<div class="panel-body">    
					<div class="row">
						<div class="table-responsive">
							<table class="table table-bordered main_table">
								<thead>
									<tr> 
										<th><?= ('Contact Person') ?></th>
										<th><?= ('Contact Number') ?></th>
										<th><?= ('Contact Email') ?></th>
										<th  class="actions"><?= __('Actions') ?></th>
									</tr>
								</thead>
								<tbody class="MainTbody">  
									<tr class="MainTr">
			
										<td width="" valign="top">
											 
											<?= $this->Form->control('contact_person',['class'=>'form-control contact_person','label'=>false]) ?>
										</td>
										<td width="30%" valign="top">
											<?= $this->Form->control('contact_no',['class'=>'form-control contact_no','label'=>false,'type'=>'number']) ?>
										</td>
										<td width="20%" valign="top">
											<?= $this->Form->control('contact_email',['class'=>'form-control contact_email','label'=>false,'type'=>'mail']) ?>
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

<table id="sampleTable" width="100%" style="display:none;">
	<tbody class="sampleMainTbody">
		<tr class="MainTr">
			
			<td width="" valign="top">
				<?= $this->Form->control('contact_person',['class'=>'form-control contact_person','label'=>false]) ?>
			</td>
			<td width="30%" valign="top">
				<?= $this->Form->control('contact_no',['class'=>'form-control contact_no','label'=>false,'type'=>'number']) ?>
			</td>
			<td width="20%" valign="top">
				<?= $this->Form->control('contact_email',['class'=>'form-control contact_email','label'=>false,'type'=>'mail']) ?>
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
				firm_name: {
						required: true,
				},
				email: {
						required: true,
				},
				user_name: {
						required: true,
				},
				password: {
						required: true,
				},
				mobile_no: {
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
					$(this).find("td:nth-child(1) input.contact_person").attr({name:"seller_details["+i+"][contact_person]",id:"seller_details-"+i+"-contact_person"});
					$(this).find("td:nth-child(2) input.contact_no").attr({name:"seller_details["+i+"][contact_no]",id:"seller_details-"+i+"-contact_no"});
					$(this).find("td:nth-child(3) input.contact_email").attr({name:"seller_details["+i+"][contact_email]",id:"seller_details-"+i+"-contact_email"});
					 
					i++;
			});
		}
		/* 
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
			$(".main_table tbody tr").each(function(){
				alert();
					$(this).find("td:nth-child(1) input.contact_person").attr({name:"seller_details["+i+"][contact_person]",id:"seller_details-"+i+"-contact_person"});
					$(this).find("td:nth-child(2) input.contact_no").attr({name:"seller_details["+i+"][contact_no]",id:"seller_details-"+i+"-contact_no"});
					$(this).find("td:nth-child(3) input.contact_email").attr({name:"seller_details["+i+"][contact_email]",id:"seller_details-"+i+"-contact_email"});
					 
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
		 */
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