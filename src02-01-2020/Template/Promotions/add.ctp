<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}
.table > thead > tr > th{
	text-align:center;
	vertical-align: top !important;
}
</style>
<?php $this->set('title', 'Promotion'); ?>
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
	<div class="row">
		<div class="col-md-12">
		<?= $this->Form->create($promotion,['id'=>"jvalidate",'class'=>"form-horizontal"]) ?>  
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong> Promotion</strong></h3>
				</div>
			
				<div class="panel-body">    
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="col-md-3 control-label">Offer Name</label>
								<div class="col-md-9">                                            
									<?= $this->Form->control('offer_name',['class'=>'form-control','placeholder'=>'Offer Name','label'=>false]) ?>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">City</label>
								<div class="col-md-9 col-xs-12"> 
									<?= $this->Form->select('city_id',$cities,['class'=>'form-control select','placeholder'=>'Select...','label'=>false,'empty'=>"--Select--"]) ?>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="col-md-3 control-label">Promotion Date</label>
								<div class="col-md-9 col-xs-12">
									<div class="input-group">
										<?= $this->Form->control('start_date',['class'=>'form-control datepicker','placeholder'=>'Promotion Date From','label'=>false,'type'=>'text','data-date-format' => 'dd-mm-yyyy','value'=>'']) ?>
										<span class="input-group-addon add-on"> - </span>
										<?= $this->Form->control('end_date',['class'=>'form-control datepicker','placeholder'=>'Promotion Date To','label'=>false,'type'=>'text','data-date-format' => 'dd-mm-yyyy','value'=>'']) ?>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">Description</label>
								<div class="col-md-9 col-xs-12"> 
									<?= $this->Form->control('description',['class'=>'form-control','placeholder'=>'Offer Description','label'=>false,'rows'=>'4']) ?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="panel-body">    
					<div class="row">
						<div class="panel-body panel-body-table">
							<div class="">
								<table class="table table-bordered main_table" >
								<?php
									$option[]=['value'=>'No','text'=>'No'];
									$option[]=['value'=>'Yes','text'=>'Yes'];
								?>
									<thead>
										<tr>
											<th rowspan='2'><?= ('Coupon Name') ?></th>
											<th rowspan='2'><?= ('Coupon Code') ?></th>
											<th rowspan='2'><?= ('Category.') ?></th>
											<th rowspan='2'><?= ('Items') ?></th>
											<th colspan='2'><?= ('Discount') ?></th>
											<th rowspan='2' ><?= ('Minimum Cart Amount') ?></th>
											<th rowspan='2'><?= ('Cash Back') ?></th>
											<th rowspan='2'><?= ('In Wallet') ?></th>
											<th rowspan='2'><?= ('Free Shipping') ?></th>
											<th  rowspan='2' class="actions"><?= __('Actions') ?></th>
										</tr>
										<tr>
											<th><?= ('( % )') ?></th>
											<th><?= ('( Amt )') ?></th>
										</tr>
									</thead>
									<tbody class="MainTbody">  
										<tr class="MainTr">
											<td valign="top">
												<?= $this->Form->control('coupan_name',['class'=>'form-control','label'=>false,'style'=>'width:100px;']) ?>
											</td>
											<td valign="top">
												<?= $this->Form->control('coupan_code',['class'=>'form-control','label'=>false,'style'=>'width:100px;']) ?>
											</td>
											<td valign="top">
												<?= $this->Form->select('category_id',$categories,['empty'=>'---Select--Category---','class'=>'form-control select','placeholder'=>'Select...','label'=>false,'style'=>'width:120px;']) ?>
											</td>
											<td  valign="top">
												<?= $this->Form->select('item_id',$items,['empty'=>'---Select--Items---','class'=>'form-control select','placeholder'=>'Select...','label'=>false,'style'=>'width:150px;']) ?>
											</td>
											<td valign="top">
												<?= $this->Form->control('discount_in_percentage',['type'=>'number','class'=>'form-control p_per','label'=>false,'style'=>'width:65px;']) ?>
											</td>
											<td  valign="top">
												<?= $this->Form->control('discount_in_amount',['type'=>'number','class'=>'form-control p_amnt','label'=>false,'style'=>'width:65px;']) ?>
											</td>
											<td valign="top">
												<?= $this->Form->control('discount_of_max_amount',['type'=>'number','class'=>'form-control', 'label'=>false]) ?>
											</td>
											<td valign="top">
												<?= $this->Form->control('cash_back',['type'=>'number','class'=>'form-control', 'label'=>false,'style'=>'width:90px;']) ?>
											</td>
											<td valign="top">
												<?= $this->Form->select('in_wallet',$option,['class'=>'form-control select','placeholder'=>'Select...','label'=>false,'style'=>'width:90px;']) ?>
											</td>
											<td valign="top">
												<?= $this->Form->select('is_free_shipping',$option,['class'=>'form-control select','placeholder'=>'Select...','label'=>false,'style'=>'width:90px;']) ?>
											</td>
											<td valign="top"  >
											<div style='width:70px;'>
												<a class="btn btn-primary  btn-condensed btn-sm add_row" href="#" role="button" ><i class="fa fa-plus"></i></a>
												<a class="btn btn-danger  btn-condensed btn-sm delete_row " href="#" role="button" ><i class="fa fa-times"></i></a>
											</div>
											</td>
										</tr>
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
			
			<?= $this->Form->end() ?>
		</div>
	</div>                    	
</div>


<table id="sampleTable" width="100%" style="display:none;">
	<tbody class="sampleMainTbody">
		<tr class="MainTr">
			<td valign="top">
				<?= $this->Form->control('coupan_name',['class'=>'form-control','label'=>false,'style'=>'width:100px;']) ?>
			</td>
			<td valign="top">
				<?= $this->Form->control('coupan_code',['class'=>'form-control','label'=>false,'style'=>'width:100px;']) ?>
			</td>
			<td valign="top">
				<?= $this->Form->select('category_id',$categories,['empty'=>'---Select--Category---','class'=>'form-control select','placeholder'=>'Select...','label'=>false,'style'=>'width:120px;']) ?>
			</td>
			<td  valign="top">
				<?= $this->Form->select('item_id',$items,['empty'=>'---Select--Items---','class'=>'form-control select','placeholder'=>'Select...','label'=>false,'style'=>'width:150px;']) ?>
			</td>
			<td valign="top">
				<?= $this->Form->control('discount_in_percentage',['type'=>'number','class'=>'form-control p_per','label'=>false,'style'=>'width:65px;']) ?>
			</td>
			<td  valign="top">
				<?= $this->Form->control('discount_in_amount',['type'=>'number','class'=>'form-control p_amnt','label'=>false,'style'=>'width:65px;']) ?>
			</td>
			<td valign="top">
				<?= $this->Form->control('discount_of_max_amount',['type'=>'number','class'=>'form-control', 'label'=>false]) ?>
			</td>
			<td valign="top">
				<?= $this->Form->control('cash_back',['type'=>'number','class'=>'form-control', 'label'=>false,'style'=>'width:90px;']) ?>
			</td>
			<td valign="top">
				<?= $this->Form->select('in_wallet',$option,['class'=>'form-control select','placeholder'=>'Select...','label'=>false,'style'=>'width:90px;']) ?>
			</td>
			<td valign="top">
				<?= $this->Form->select('is_free_shipping',$option,['class'=>'form-control select','placeholder'=>'Select...','label'=>false,'style'=>'width:90px;']) ?>
			</td>
			<td valign="top"  >
			<div style='width:70px;'>
				<a class="btn btn-primary  btn-condensed btn-sm add_row" href="#" role="button" ><i class="fa fa-plus"></i></a>
				<a class="btn btn-danger  btn-condensed btn-sm delete_row " href="#" role="button" ><i class="fa fa-times"></i></a>
			</div>
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
					offer_name: {
							required: true,
					},
					
					city_id: {
							required: true,
					},
					start_date: {
							required: true,
					},
					end_date: {
							required: true,
					},
			}	                                  
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
		
		$(document).on("keyup",".p_per",function(){
			var p_per=$(this).val();
			if(!p_per){ p_per=0; }
			
			if(p_per>0){
				$(this).closest("tr").find(".p_amnt").val(0);
			}
		});	
		
		$(document).on("keyup",".p_amnt",function(){
			var p_amnt=$(this).val();
			if(!p_amnt){ p_amnt=0; }
			
			if(p_amnt>0){
				$(this).closest("tr").find(".p_per").val(0);
			}
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
						$(this).find("td:nth-child(1) input").attr({name:"promotion_details["+i+"][coupon_name]",id:"promotion_details-"+i+"-coupon_name"}).rules("add", "required");
						$(this).find("td:nth-child(2) input").attr({name:"promotion_details["+i+"][coupon_code]",id:"promotion_details-"+i+"-coupon_code"}).rules("add", "required");
						$(this).find("td:nth-child(3) select").attr({name:"promotion_details["+i+"][category_id]",id:"promotion_details-"+i+"-category_id"});
						$(this).find("td:nth-child(4) select").attr({name:"promotion_details["+i+"][item_id]",id:"promotion_details-"+i+"-item_id"});
						$(this).find("td:nth-child(5) input").attr({name:"promotion_details["+i+"][discount_in_percentage]",id:"promotion_details-"+i+"-discount_in_percentage"});
						$(this).find("td:nth-child(6) input").attr({name:"promotion_details["+i+"][discount_in_amount]",id:"promotion_details-"+i+"-discount_in_amount"});
						$(this).find("td:nth-child(7) input").attr({name:"promotion_details["+i+"][discount_of_max_amount]",id:"promotion_details-"+i+"-discount_of_max_amount"});
						$(this).find("td:nth-child(8) input").attr({name:"promotion_details["+i+"][cash_back]",id:"promotion_details-"+i+"-cash_back"});
						$(this).find("td:nth-child(9) select").attr({name:"promotion_details["+i+"][in_wallet]",id:"promotion_details-"+i+"-in_wallet"});
						$(this).find("td:nth-child(10) select").attr({name:"promotion_details["+i+"][is_free_shipping]",id:"promotion_details-"+i+"-is_free_shipping"});
						i++;
			});
		}

		
	
		';  
echo $this->Html->scriptBlock($js, array('block' => 'scriptBottom')); 		
?>