<?php $this->set('title', 'Supplier'); ?>
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
	<div class="row">
		<div class="col-md-12">
		<?= $this->Form->create($supplier,['id'=>"jvalidate",'class'=>"form-horizontal"]) ?>  
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong>Supplier</strong></h3>
				</div>
			
				<div class="panel-body">    
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="col-md-3 control-label">Supplier Name</label>
								<div class="col-md-9">                                            
									<?= $this->Form->control('name',['class'=>'form-control','placeholder'=>'Supplier Name','label'=>false]) ?>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-md-3 control-label">Firm Name</label>
								<div class="col-md-9">    
									<?= $this->Form->control('firm_name',['class'=>'form-control','placeholder'=>'Firm Name','label'=>false]) ?>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-md-3 control-label">Address</label>
								<div class="col-md-9 col-xs-12"> 
									<?= $this->Form->control('address',['class'=>'form-control','placeholder'=>'Address','label'=>false,'rows'=>'4']) ?>
								</div>
							</div>
							
							<div class="form-group">                                        
								<label class="col-md-3 control-label">Email</label>
								<div class="col-md-9 col-xs-12">
									<?= $this->Form->control('email',['class'=>'form-control','placeholder'=>'Email','label'=>false]) ?>
								</div>
							</div>
							
							<div class="form-group">           
								<label align="left" class="col-md-3 control-label">Opening balance</label>
								<div class="col-md-6 col-xs-12">
								
									<?php echo $this->Form->control('opening_balance_value',['id'=>'opening_balance_value','class'=>'rightAligntextClass form-control input-sm balance','label'=>false,'placeholder'=>'Opening Balance']);
									?>
								</div>
								<div class="col-md-3 col-xs-12">
									<?php $options1 =[['value'=>'Dr','text'=>'Dr'],['value'=>'Cr','text'=>'Cr']]; ?>
									<?= $this->Form->select('debit_credit',$options1,['class'=>'form-control select cr_dr','label'=>false]) ?>
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
								<label class="col-md-3 control-label">GSTIN Holder</label>
								<div class="col-md-9 col-xs-12">
									<?= $this->Form->control('gstin_holder_name',['class'=>'form-control','placeholder'=>'GSTIN Holder Name','label'=>false]) ?>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">GSTIN Holder Address</label>
								<div class="col-md-9 col-xs-12"> 
									<?= $this->Form->control('gstin_holder_address',['class'=>'form-control','placeholder'=>'GSTIN Holder Address','label'=>false,'rows'=>'3']) ?>
								</div>
							</div>
							<div class="form-group">                                        
								<label class="col-md-3 control-label">City</label>
								<div class="col-md-9 col-xs-12">
									<?= $this->Form->select('city_id',$cities,['empty'=>'--Select--','class'=>'form-control city select','label'=>false]) ?>
								</div>
							</div>
							<div class="form-group">                                        
								<label class="col-md-3 control-label">Location</label>
								<div class="col-md-9 col-xs-12">
									<?= $this->Form->select('location_id',$locations,['empty'=>'--Select--','class'=>'form-control select','label'=>false]) ?>
								</div>
							</div>
							
							
							<div class="form-group">                                        
								<label class="col-md-3 control-label">Mobile</label>
								<div class="col-md-9 col-xs-12">
									<?= $this->Form->control('mobile_no',['class'=>'form-control','placeholder'=>'Mobile No','label'=>false]) ?>
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


<?= $this->Html->script('plugins/bootstrap/bootstrap-select.js',['block'=>'jsSelect']) ?>
<?= $this->Html->script('plugins/jquery-validation/jquery.validate.js',['block'=>'jsValidate']) ?>

<?php
   $js='var jvalidate = $("#jvalidate").validate({
		ignore: [],
		rules: {                                            
				name: {
						required: true,
				},
				address: {
						required: true,
				},
				email: {
						required: true,
				},
				location_id: {
						required: true,
				},
				city_id: {
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