<?php $this->set('title', 'Item'); ?>
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
	<div class="row">
		<div class="col-md-12">
		<?= $this->Form->create($item,['id'=>"jvalidate",'class'=>"form-horizontal"]) ?>  
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
									<?= $this->Form->control('name',['class'=>'form-control','placeholder'=>'Item Name','label'=>false]) ?>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">Category</label>
								<div class="col-md-9">                                            
									<?= $this->Form->select('category_id',$categories,['class'=>'form-control select','label'=>false]) ?>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-md-3 control-label">Minimum Stock</label>
								<div class="col-md-9">                                            
									<?= $this->Form->control('minimum_stock',['class'=>'form-control','placeholder'=>'Minimum Stock','label'=>false]) ?>
								</div>
							</div>
							<div class="form-group">                                        
								<label class="col-md-3 control-label">Out Of Stock</label>
								<div class="col-md-9 col-xs-12">
									<?php $out_options['No'] = 'No'; ?>
									<?php $out_options['Yes'] = 'Yes'; ?>
								
								<?= $this->Form->select('out_of_stock',$out_options,['class'=>'form-control select','label'=>false]) ?>
								</div>
							</div>
							<div class="form-group">                                        
								<label class="col-md-3 control-label">Ready To Sale</label>
								<div class="col-md-9 col-xs-12">
									<?php $sale_options['No'] = 'No'; ?>
									<?php $sale_options['Yes'] = 'Yes'; ?>
								<?= $this->Form->select('ready_to_sale',$sale_options,['class'=>'form-control select','label'=>false]) ?>
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
								<label class="col-md-3 control-label">Alias Name</label>
								<div class="col-md-9">                                            
									<?= $this->Form->control('alias_name',['class'=>'form-control','placeholder'=>'Alias Name','label'=>false]) ?>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">Brand</label>
								<div class="col-md-9">                                            
									<?= $this->Form->select('brand_id',$brands,['class'=>'form-control select','label'=>false,'empty'=>'---Select--']) ?>
								</div>
							</div>
							<div class="form-group">                                        
								<label class="col-md-3 control-label">Sample Request</label>
								<div class="col-md-9 col-xs-12">
								<?php $request_options['Yes'] = 'Yes'; ?>
								<?php $request_options['No'] = 'No'; ?>
								<?= $this->Form->select('request_for_sample',$request_options,['class'=>'form-control select','label'=>false]) ?>
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
					<div class="panel-body">    
					<div class="row">
						<div class="table-responsive">
							<table class="table table-bordered main_table">
								<thead>
									<tr>
										<th><?= ('SN.') ?></th>
										<th><?= ('Unit') ?></th>
										<th><?= ('Quantity Factor') ?></th>
										<th><?= ('Print Quantity') ?></th>
										<th><?= ('Print Rate') ?></th>
										<th><?= ('Discount (%)') ?></th>
										<th><?= ('Sale Rate') ?></th>
										<th><?= ('Maximum Quantity') ?></th>
										<th><?= ('Ready To Sale') ?></th>
										<th><?= ('Out Of Stock') ?></th>
										<th><?= ('Status') ?></th>
										
										<th scope="col" class="actions"><?= __('Actions') ?></th>
									</tr>
								</thead>
								<tbody class="MainTbody">  
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
			</div>
			<?= $this->Form->end() ?>
		</div>
	</div>                    	
</div>



<table id="sampleTable" width="100%">
	<tbody class="sampleMainTbody">
		<tr class="MainTr">
			<td  valign="top"> 
				<?php echo $this->Form->select('unit_id', $units,['class'=>'form-control select','label'=>false]) ?> 			</td>
			<td width="" valign="top">
				<?= $this->Form->control('quantity_factor',['class'=>'form-control','label'=>false]) ?>
			</td>
			<td  style="padding-right:0px;" valign="top">
				<?= $this->Form->control('print_quantity',['class'=>'form-control','label'=>false]) ?>
			</td>
			<td  style="padding-left:0px;" valign="top">
				<?= $this->Form->control('print_rate',['class'=>'form-control','label'=>false]) ?>
			</td>
			<td style="padding-left:0px;" valign="top">
				<?= $this->Form->control('discount_per',['class'=>'form-control','label'=>false]) ?>
			</td>
			<td  style="padding-left:0px;" valign="top">
				<?= $this->Form->control('sales_rate',['class'=>'form-control','label'=>false]) ?>
			</td>
			<td style="padding-left:0px;" valign="top">
				<?= $this->Form->control('maximum_quantity_purchase',['class'=>'form-control','label'=>false]) ?>
			</td>
			<td  style="padding-left:0px;" valign="top">
				<?= $this->Form->control('sales_rate',['class'=>'form-control','label'=>false]) ?>
			</td>
			<td style="padding-left:0px;" valign="top">
				<?= $this->Form->control('maximum_quantity_purchase',['class'=>'form-control','label'=>false]) ?>
			</td>
			<td style="padding-left:0px;" valign="top">
				<?php $sale_options['No'] = 'No'; ?>
				<?php $sale_options['Yes'] = 'Yes'; ?>
				<?= $this->Form->select('ready_to_sale',$sale_options,['class'=>'form-control select','label'=>false]) ?>
			</td>
			<td style="padding-left:0px;" valign="top">
				<?php $out_options['No'] = 'No'; ?>
				<?php $out_options['Yes'] = 'Yes'; ?>
				<?= $this->Form->select('out_of_stock',$out_options,['class'=>'form-control select','label'=>false]) ?>
			</td>
			<td width="5%" align="right" valign="top">
				<a class="delete-tr-ref calculation" href="#" role="button" style="margin-bottom: 5px;"><i class="fa fa-times"></i></a>
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
				
			}                                        
		});
		
		addMainRow();
			function addMainRow(){
				var tr=$("#sampleTable tbody").html();
				$(".main_table tbody").append(tr);
			}
		
		
		
		';  
echo $this->Html->scriptBlock($js, array('block' => 'scriptBottom')); 		
?>