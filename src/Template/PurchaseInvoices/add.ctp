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
									<?php $voucher_no= $LocationData->alise.'/'.$voucher_no ;
									//echo $voucher_no;
									?>
									<?= $this->Form->control('namsdfee',['class'=>'form-control','placeholder'=>'Item Name','label'=>false,'value'=>$voucher_no,'readonly']) ?>
								</div>
							</div>
							<div class="form-group">
								<label class=" control-label">Seller</label>
								<div class="">                                            
									<?= $this->Form->select('seller_ledger_id',$partyOptions,['empty'=>'---Select--','class'=>'form-control select seller_ledger_id','label'=>false]) ?>
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
										<th rowspan="2" style="text-align:left;width:10px;"><label>S.N<label></td>
										<th rowspan="2" style="text-align:left;width:200px;"><label>Item<label></td>
										
										<th rowspan="2" style="text-align:center; "><label>Quantity<label></td>
										<th rowspan="2" style="text-align:center;width:110px;"><label>Rate<label></td>
										
										<th rowspan="2" style="text-align:center;"><label>Taxable Value<label></td>
										<th colspan="2" style="text-align:center;"><label id="gstDisplay">GST<label></th>
										<th rowspan="2" style="text-align:center;width:200px;"><label>Total<label></td>
										<th rowspan="2" style="text-align:center;"><label>Purchase Rate<label></td>
										<th rowspan="2" style="text-align:center;"><label>Sales Rate<label></td>
										<th rowspan="2" style="text-align:center;"><label>Action<label></td>
									</tr>
									<tr>
										
										<th><div align="center" style="width:50px;">%</div></th>
										<th><div align="center"style="text-align:center;width:50px;">Rs</div></th>
										
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
			<td  valign="top" class="itemList"> 
				
			</td>
			
			<td  valign="top">
				<?= $this->Form->control('quantity',['class'=>'form-control quantity','label'=>false]) ?>
				<span class="itemQty" style="font-size:10px;"></span>
			</td>
			<td valign="top">
				<?= $this->Form->control('rate',['class'=>'form-control rate','label'=>false]) ?>
			</td>
			
			<td valign="top">
				<?= $this->Form->control('taxable_value',['class'=>'form-control taxable_value','label'=>false]) ?>
			</td>
			<td valign="top">
				
				<?= $this->Form->select('gst_percentage',$GstFigures,['class'=>'form-control gst_percentage','label'=>false,'readonly']) ?>
			</td>
			<td valign="top">
				<?= $this->Form->control('gst_value',['class'=>'form-control gst_value','label'=>false]) ?>
			</td>
			
			<td valign="top">
				<?= $this->Form->control('net_amount',['class'=>'form-control net_amount','label'=>false]) ?>
			</td>
			<td valign="top">
				<?= $this->Form->control('purchase_rate',['class'=>'form-control purchase_rate','label'=>false]) ?>
			</td>
			
			<td valign="top">
				<?= $this->Form->control('sales_rate',['class'=>'form-control sales_rate','label'=>false]) ?>
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
   $js="var jvalidate = $('#jvalidate').validate({
		ignore: [],
		rules: {                                            
				name: {
						required: true,
				},
				
			}                                        
		});
		
		$(document).on('change','.seller_ledger_id',function(){
			var seller_id=$('option:selected', this).attr('seller_id');
			var url='".$this->Url->build(["controller" => "PurchaseInvoices", "action" => "SelectItemSellerWise"])."';
			url=url+'/'+seller_id
			$.ajax({
				url: url,
				type: 'GET'
			}).done(function(response) {
				//$('#sampleTable tbody tr.MainTr').remove();
				var t=$('.MainTbody tr').remove();
				$('.itemList').html(response);
				addMainRow();
			});
			
		});
		
		$(document).on('click','.add_row',function(){
			addMainRow();
			renameRows();
		});
		
		function addMainRow(){
			var tr=$('#sampleTable tbody').html();
			$('.main_table tbody').append(tr);
			renameRows();
		}
		
		$(document).on('click','.delete_row',function(){
			var t=$(this).closest('tr').remove();
			renameRows();
		});
		
		$(document).on('keyup','.rate',function(){
			calculation();
		});
		
		$(document).on('change','.gst_percentage',function(){
			calculation();
		});
		$(document).on('change','.item',function(){
			var gst_figure_id=$(this).find('option:selected', this).attr('gst_figure_id');
			$(this).closest('tr').find('.gst_percentage').val(gst_figure_id);
		});
		
		function renameRows(){ 
				var i=0; 
				$('.main_table tbody tr').each(function(){
						$(this).attr('row_no',i);
						$(this).find('td:nth-child(1)').html(++i); i--;
						$(this).find('input.item_id ').attr({name:'purchase_invoice_rows['+i+'][item_id]',id:'purchase_invoice_rows['+i+'][item_id]'});
						$(this).find('select.item ').attr({name:'purchase_invoice_rows['+i+'][item_variation_id]',id:'purchase_invoice_rows['+i+'][item_variation_id]'});
						$(this).find('.quantity ').attr({name:'purchase_invoice_rows['+i+'][quantity]',id:'purchase_invoice_rows['+i+'][quantity]'});
						$(this).find('.rate ').attr({name:'purchase_invoice_rows['+i+'][rate]',id:'purchase_invoice_rows['+i+'][rate]'});
						
						i++;
			});
		}
		function calculation(){
			$('.main_table tbody tr').each(function(){
				var qty=$(this).find('.quantity').val();
				var rate=$(this).find('.rate').val();
				var quantity_factor=$(this).find('option:selected', this).attr('quantity_factor');
				var commission=$(this).find('option:selected', this).attr('commission');
				var unit=$(this).find('option:selected', this).attr('unit');
				var total_qty=quantity_factor*qty;
				$(this).find('.itemQty').html(total_qty +' '+ unit);
				var taxable_value=qty*rate;
				$(this).find('.taxable_value').val(taxable_value);
				var gst_percentage=parseFloat($(this).find('.gst_percentage option:selected').attr('tax_percentage'));
				//var gst_percentage=$(this).find('option:selected', this).attr('tax_percentage');
				
				
				if(!gst_percentage){
					gst_rate=0;
				}else{ 
					gst_rate=(taxable_value*gst_percentage)/100;
				}
				$(this).find('.gst_value').val(gst_rate);
				var net_amount=gst_rate+taxable_value;
				var net_amount1=round(net_amount,2);
				$(this).find('.net_amount').val(net_amount1);
				
				var per_item_purchase_rate=net_amount1/qty;
				$(this).find('.purchase_rate').val(per_item_purchase_rate);
				
				var commission_rate=(per_item_purchase_rate*commission)/100;
				var per_item_sales_rate=per_item_purchase_rate+commission_rate;
				$(this).find('.sales_rate').val(per_item_sales_rate);
				
			});
		}
		
	
		
		";  
echo $this->Html->scriptBlock($js, array('block' => 'scriptBottom')); 		
?>