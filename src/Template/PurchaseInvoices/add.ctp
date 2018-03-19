<?php $this->set('title', 'Purchase Invoice'); ?>
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
	<div class="row">
		<div class="col-md-12">
		<?= $this->Form->create($purchaseInvoice,['id'=>'jvalidate','class'=>'form-horizontal','type'=>'file']) ?>  
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong> Purchase Invoice</strong></h3>
				</div>
			
				<div class="panel-body">    
					<div class="row">
						<div class="col-md-3">
							<div class="form-group">
								<label class=" control-label">Purchase Invoice No</label>
								<div class="">                                            
									<?= $this->Form->control('name',['class'=>'form-control','placeholder'=>'Item Name','label'=>false]) ?>
								</div>
							</div>
							<div class="form-group">
								<label class=" control-label">Seller</label>
								<div class="">                                            
									<?= $this->Form->select('seller_ledger_id',$partyOptions,['empty'=>'---Select--','class'=>'form-control select','label'=>false]) ?>
								</div>
							</div>
						
							
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label class=" control-label">Transaction Date </label>
								<div class="">                                            
									<?= $this->Form->control('transaction_date',['class'=>'form-control datepicker','placeholder'=>'Transaction Date','label'=>false,'type'=>'text','data-date-format' => 'DD-MM-YYYY','value'=>'']) ?>
								</div>
							</div>
							<div class="form-group">
								<label class=" control-label">Purchase Account</label>
								<div class="">                                            
									<?= $this->Form->select('purchase_ledger_id',$Accountledgers,['class'=>'form-control select','label'=>false]) ?>
								</div>
							</div>
							
						</div>
						<div class="col-md-6">
						<div class="form-group">
								<label class=" control-label">Narration</label>
								<div class=""> 
									<?= $this->Form->control('firm_address',['class'=>'form-control','placeholder'=>'Narration','label'=>false,'rows'=>'4']) ?>
								</div>
							</div>
						</div>
					</div>
					<div class="panel-body">    
					<div class="row">
						<div class="table-responsive">
							<table class="table table-bordered main_table">
								<thead>
									<tr align="center">
										<th rowspan="2" style="text-align:left;"><label>S.N<label></td>
										<th rowspan="2" style="text-align:left;"><label>Item<label></td>
										<th rowspan="2" style="text-align:left;"><label>Item Variation<label></td>
										<th rowspan="2" style="text-align:center; "><label>Quantity<label></td>
										<th rowspan="2" style="text-align:center;width:20px;"><label>Rate<label></td>
										<th  colspan="2" style="text-align:center;"><label align="center">Discount (%)</label></th>
										<th rowspan="2" style="text-align:center;"><label>Taxable Value<label></td>
										<th colspan="2" style="text-align:center;"><label id="gstDisplay">GST<label></th>
										<th rowspan="2" style="text-align:center;"><label>Total<label></td>
										<th rowspan="2" style="text-align:center;"><label>Action<label></td>
									</tr>
									<tr>
										<th><div align="center">%</div></th>
										<th><div align="center">Rs</div></th>
										<th><div align="center">%</div></th>
										<th><div align="center">Rs</div></th>
										
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



<table id="sampleTable" width="100%" style="display:none;">
	<tbody class="sampleMainTbody">
		<tr class="MainTr">
			<td  valign="top">1</td>
			<td  valign="top"> 
				<?php echo $this->Form->select('item_id', $items,['class'=>'form-control item select','label'=>false]) ?> 			</td>
			<td width="" valign="top">
				<?= $this->Form->control('item_variation_id',['class'=>'form-control item_variation_id','label'=>false]) ?>
			</td>
			<td  valign="top">
				<?= $this->Form->control('quantity',['class'=>'form-control quantity','label'=>false]) ?>
			</td>
			<td valign="top">
				<?= $this->Form->control('rate',['class'=>'form-control rate','label'=>false]) ?>
			</td>
			<td valign="top">
				<?= $this->Form->control('discount_percentage',['class'=>'form-control discount_percentage','label'=>false]) ?>
			</td>
			<td valign="top">
				<?= $this->Form->control('discount_amount',['class'=>'form-control discount_amount','label'=>false]) ?>
			</td>
			<td valign="top">
				<?= $this->Form->control('taxable_value',['class'=>'form-control taxable_value','label'=>false]) ?>
			</td>
			<td valign="top">
				<?= $this->Form->control('item_gst_figure_id',['type'=>'hidden','class'=>'form-control item_gst_figure_id','label'=>false]) ?>
				<?= $this->Form->select('gst_percentage',$GstFigures,['class'=>'form-control gst_percentage select','label'=>false]) ?>
			</td>
			<td valign="top">
				<?= $this->Form->control('gst_value',['class'=>'form-control gst_value','label'=>false]) ?>
			</td>
			
			<td valign="top">
				<?= $this->Form->control('net_amount',['class'=>'form-control net_amount','label'=>false]) ?>
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
				
			}                                        
		});
	
		$(document).on("click",".add_row",function(){
			addMainRow();
			renameRows();
		});
		
		addMainRow();
		function addMainRow(){
			var tr=$("#sampleTable tbody").html();
			$(".main_table tbody").append(tr);
		//	renameRows();
		}
		
		$(document).on("click",".delete_row",function(){
			var t=$(this).closest("tr").remove();
			//renameRows();
			
		});
		
		function renameRows(){ 
				var i=0; 
				$(".main_table tbody tr").each(function(){
						$(this).attr("row_no",i);
						$(this).find("td:nth-child(1)").html(++i); i--;
						
						
						i++;
			});
		}
		$("#item_image").fileinput({
            showUpload: false,
            showCaption: false,
            showCancel: false,
            browseClass: "btn btn-danger",
			allowedFileExtensions: ["jpg", "png"],
			maxFileSize: 1024,
		}); 
		
		
		$(document).on("click", ".fileinput-remove-button", function(){
			$(this).closest("div.file-input").find("input[type=file]").attr("required",true);
		});
		
		';  
echo $this->Html->scriptBlock($js, array('block' => 'scriptBottom')); 		
?>