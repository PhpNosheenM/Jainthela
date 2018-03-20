<?php $this->set('title', 'Seller'); ?>
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
	<div class="row">
		<div class="col-md-12">
		<?= $this->Form->create($seller,['id'=>"jvalidate",'class'=>"form-horizontal"]) ?>  
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong>Seller</strong></h3>
				</div>
			
				<div class="panel-body">    
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="col-md-3 control-label">Seller Name</label>
								<div class="col-md-9">                                            
									<?= $this->Form->control('name',['class'=>'form-control','placeholder'=>'Seller Name','label'=>false]) ?>
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
								<label class="col-md-3 control-label">Status</label>
								<div class="col-md-9 col-xs-12">
									<?php $options['Active'] = 'Active'; ?>
								<?php $options['Deactive'] = 'Deactive'; ?>
								<?= $this->Form->select('status',$options,['class'=>'form-control select','label'=>false]) ?>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-md-3 control-label">Duration</label>
								<div class="col-md-9 col-xs-12">
									<div class="input-group">
										<?= $this->Form->control('duration_from',['class'=>'form-control datepicker','placeholder'=>'Duration From','label'=>false,'type'=>'text','data-date-format' => 'DD/MM/YYYY','value'=>'']) ?>
										<span class="input-group-addon add-on"> - </span>
										<?= $this->Form->control('duration_to',['class'=>'form-control datepicker','placeholder'=>'Duration To','label'=>false,'type'=>'text','data-date-format' => 'DD/MM/YYYY','value'=>'']) ?>
									</div>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-md-3 control-label">Terms And Condition</label>
								<div class="col-md-9 col-xs-12"> 
									<?= $this->Form->control('terms_and_condition',['class'=>'form-control','placeholder'=>'Terms And Condition','label'=>false,'rows'=>'4']) ?>
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
								
							
							<div class="form-group">                                        
								<label align="left" class="col-md-3 control-label">Bill to Bill</label>
								<div class="col-md-9 col-xs-12">
									<?php $options =[['value'=>'no','text'=>'no'],['value'=>'yes','text'=>'yes']]; ?>
									<?= $this->Form->select('bill_to_bill_accounting',$options,['class'=>'form-control select bill_to_bill','label'=>false]) ?>
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
								<label class="col-md-3 control-label">City</label>
								<div class="col-md-9 col-xs-12">
									
								<?= $this->Form->select('city_id',$Cities,['class'=>'form-control select','label'=>false]) ?>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-md-3 control-label">PAN No </label>
								<div class="col-md-9"> 
									<div class="input text required error" aria-required="true">
										<?= $this->Form->control('pan_no',['class'=>'form-control','placeholder'=>'PAN No','label'=>false]) ?>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">AADHAR No </label>
								<div class="col-md-9"> 
									<div class="input text required error" aria-required="true">
										<?= $this->Form->control('aadhar_no',['class'=>'form-control','placeholder'=>'AADHAR No','label'=>false]) ?>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">Contact Person </label>
								<div class="col-md-9"> 
									<div class="input text required error" aria-required="true">
										<?= $this->Form->control('contact_person',['class'=>'form-control','placeholder'=>'Contact Person Name','label'=>false]) ?>
									</div>
								</div>
							</div>
							
							<div class="form-group">                                        
								<label class="col-md-3 control-label">Email</label>
								<div class="col-md-9 col-xs-12">
									<?= $this->Form->control('email',['class'=>'form-control','placeholder'=>'Email','label'=>false]) ?>
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
								<label class="col-md-3 control-label">Mobile</label>
								<div class="col-md-9 col-xs-12">
									<?= $this->Form->control('mobile_no',['class'=>'form-control','placeholder'=>'Mobile No','label'=>false]) ?>
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
								<div class="col-md-6">
									<div class="window" style="margin:auto;">
											<table width="100%">
											<?php $i=0; foreach($childrens as $Category){ ?>
											<tr>
											
												<td width="15%">
												<div class="checkbox-material">
												<?= $this->Form->control('seller_items['.$i.'][check]',['type'=>'checkbox','class'=>'category','id'=>'category','placeholder'=>'Item Name','label'=>false,'hidden'=>false]) ?>
												</div>
												</td>
												<td width="60%"><a class="accordion-toggle accordion-toggle-styled collapsed " data-toggle="collapse" data-parent="#accordion0" href="#collapse_<?php echo $Category->id;?>" aria-expanded="false"><?php echo $Category->name; ?></a>
												<?= $this->Form->control('seller_items['.$i.'][category_id]',['type'=>'hidden','class'=>'form-control ','placeholder'=>'Item Name','label'=>false,'value'=>$Category->id]) ?>
												</td>
												<td><?= $this->Form->control('seller_items['.$i.'][commission_percentage]',['class'=>'form-control','placeholder'=>'Commission %','label'=>false]) ?></td>
											</tr>
											<?php } ?>	
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
<table id="sampleForRef" style="display:none;" width="100%">
	<tbody>
		<tr>
			<td width="20%" valign="top"> 
				
				<?php 
				echo $this->Form->input('type', ['empty'=>'--Select ref--','options'=>$option_ref,'label' => false,'class' => 'form-control select input-sm refType','value'=>'New Ref']); ?>
			</td>
			<td width="" valign="top">
				<?php echo $this->Form->input('ref_name', ['type'=>'text','label' => false,'class' => 'form-control input-sm ref_name','placeholder'=>'Reference Name']); ?>
			</td>
			
			<td width="20%" style="padding-right:0px;" valign="top">
				<?php echo $this->Form->input('amount', ['label' => false,'class' => 'form-control input-sm calculation rightAligntextClass','placeholder'=>'Amount']); ?>
			</td>
			<td width="10%" style="padding-left:0px;" valign="top">
				<?php 
				echo $this->Form->input('type_cr_dr', ['options'=>['Dr'=>'Dr','Cr'=>'Cr'],'label' => false,'class' => 'form-control select input-sm  calculation refDrCr','value'=>'Dr']); ?>
			</td>
			
			<td width="5%" align="right" valign="top">
				<a class="delete_tr_ref" href="#" role="button" style="margin-bottom: 5px;"><i class="fa fa-times"></i></a>
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
		$(document).on("click",".addRefRow",function(){
				AddRefRow();
				
		});
		
		
		function AddRefRow(){
			var refTr=$("#sampleForRef tbody tr").clone();
			$("div.window table tbody").append(refTr);
			renameRefRows();
			//calculation();
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