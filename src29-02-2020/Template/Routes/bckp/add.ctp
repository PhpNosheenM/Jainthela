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
<?php $this->set('title', 'Route'); ?>
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
	<div class="row">
		<div class="col-md-12">
		<?= $this->Form->create($route,['id'=>'jvalidate','class'=>'form-horizontal','type'=>'file']) ?>  
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong> Route</strong></h3>
				</div>
			
				<div class="panel-body">
					<div class="row">
							<div class="form-group col-md-6">
								<label class="col-md-3 control-label">Name</label>
								<div class="col-md-9">                      
									<?= $this->Form->control('name',['class'=>'form-control','placeholder'=>'Route Name','label'=>false]) ?>
								</div>
							</div>
							
							<div class="form-group col-md-6">
								<label class="col-md-3 control-label">Location</label>
								<div class="col-md-9">                                            
									<?= $this->Form->select('location_id',$locations,['empty'=>'---Select--Item---','class'=>'form-control location_id','label'=>false, 'data-live-search'=>true]) ?>
								</div>
							</div>
							
							
							<div class="form-group col-md-6">
								<label class="col-md-3 control-label">Description</label>
								<div class="col-md-9 col-xs-12"> 
									<?= $this->Form->control('narration',['class'=>'form-control','placeholder'=>'Description','label'=>false,'rows'=>'4']) ?>
								</div>
							</div>
							
							<div class="form-group col-md-6">    
								<label class="col-md-3 control-label">Status</label>
								<div class="col-md-9 col-xs-12">
									<?php $options['Active'] = 'Active'; ?>
									<?php $options['Deactive'] = 'Deactive'; ?>
									<?= $this->Form->select('status',$options,['class'=>'form-control select','label'=>false]) ?>
								</div>
							</div>
							  
					</div>
				</div>
				<div class="panel-body">    
					<div class="row">
						<div class="">
							<table class="table table-bordered main_table">
								<thead>
									<tr>
										<th><?= ('Landmark') ?></th>
										<th><?= ('Priority') ?></th>
										<th class="actions"><?= __('Actions') ?></th>
									</tr>
								</thead>
								<tbody class="MainTbody">  
									<tr class="MainTr">
										<td width="30%" valign="top">
											<?= $this->Form->select('landmark_id',$landmarks,['empty'=>'---Select--Landmark---','class'=>'form-control lnd','label'=>false, 'data-live-search'=>true]) ?>
										</td>
										<td width="10%" valign="top">
											<?= $this->Form->control('priority',['class'=>'form-control prty','label'=>false, 'type'=>'number']) ?>
										</td>
										<td valign="top"  >
											<a class="btn btn-primary  btn-condensed btn-sm add_row" href="#" role="button" ><i class="fa fa-plus"></i></a>
											<a class="btn btn-danger  btn-condensed btn-sm delete_row " href="#" role="button" ><i class="fa fa-times"></i></a>
										</td>
									</tr>
								</tbody>
								<tfoot>
									
								</tfoot>
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
			<td width="30%" valign="top">
				<?= $this->Form->select('landmark_id',$landmarks,['empty'=>'---Select--Item---','class'=>'form-control lnd','label'=>false, 'data-live-search'=>true]) ?>
			</td>
			<td width="10%" valign="top">
				<?= $this->Form->control('priority',['class'=>'form-control prty','label'=>false, 'type'=>'number']) ?>
				 
			</td>
			<td valign="top"  >
				<a class="btn btn-primary  btn-condensed btn-sm add_row" href="#" role="button" ><i class="fa fa-plus"></i></a>
				<a class="btn btn-danger  btn-condensed btn-sm delete_row " href="#" role="button" ><i class="fa fa-times"></i></a>
			</td>
		</tr>
	</tbody>
</table>



<?= $this->Html->script('plugins/fileinput/fileinput.min.js',['block'=>'jsFileInput']) ?>
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
				location_id: {
						required: true,
				},
			}                                        
		});
	 
		
		$(document).on("click",".add_row",function(){
			addMainRow();
			//renameRows();
		});
		$(document).on("keyup",".print_rate",function(){
			calc1();
		});
		$(document).on("keyup",".discount_per",function(){
			
			calc1();
		});
		$(document).on("blur",".rate",function(){
			calcu1ation1();
		});
		
		//addMainRow();
		renameRows();
		function addMainRow(){
			var tr=$("#sampleTable tbody").html();
			$(".main_table tbody").append(tr);
			renameRows();
			
		}
		
		$(document).on("click",".delete_row",function(){
			//alert();
			var t=$(this).closest("tr").remove();
			renameRows();
		});
		$(document).on("keyup",".quantity",function(){
			renameRows();
		});
		$(document).on("keyup",".discount",function(){
			renameRows();
		});
		
		$(document).on("keyup",".quantity",function(){
			
			renameRows();
		});
		 
		
		function renameRows(){
				var i=0;
				$(".main_table tbody tr").each(function(){
						$(this).attr("row_no",i);
						$(this).find(".lnd").selectpicker();
						$(this).find(".lnd").attr({name:"route_details["+i+"][landmark_id]",id:"route_details-"+i+"-landmark_id"}).rules("add", "required");
						$(this).find(".prty").attr({name:"route_details["+i+"][priority]",id:"route_details-"+i+"-priority"}).rules("add", "required");
						 
						i++;
			});
		}
		 
		$(document).on("click", ".fileinput-remove-button", function(){
			$(this).closest("div.file-input").find("input[type=file]").attr("required",true);
		});
		
		';  
echo $this->Html->scriptBlock($js, array('block' => 'scriptBottom')); 		
?>
