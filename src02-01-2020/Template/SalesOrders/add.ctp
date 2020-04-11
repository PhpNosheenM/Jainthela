<?php $this->set('title', 'Sales Order'); ?>
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
	<div class="row">
		<div class="col-md-12">
		<?= $this->Form->create($salesOrder,['id'=>'jvalidate','class'=>'form-horizontal','type'=>'file']) ?>  
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong> Bulk Booking </strong></h3>
				</div>
			
				<div class="panel-body">
					<div class="row">
					<center><h3> Order Details</h3></center>
							<hr>
						<div class="col-md-3">
							<div class="form-group">
								<label class=" control-label"> No</label>
								<div class="">                                            
									
									<?= $this->Form->control('sales_order_no',['class'=>'form-control','placeholder'=>'','label'=>false,'value'=>$order_no,'readonly']) ?>
								</div>
							</div>
							<div class="form-group">
								<label class=" control-label">Customer</label>
								<div class="">     
									<?= $this->Form->select('sales_ledger_id',$partyOptions,['empty'=>'---Select--','class'=>'form-control select prty_ledgr','label'=>false,'value'=>@$sales_orders->customer_id,'data-live-search'=>true]) ?>	
									<input type="hidden" name='customer_id' id="customer_id">
									<?php //$this->Form->select('customer_id',$customers,['empty'=>'---Select--','class'=>'form-control select','label'=>false]) ?>
								</div>
								
								<input type="hidden" name="customer_id" id="cstmr_id">
								<input type="hidden" name="customer_address_id" id="customer_address_id">
							</div>
						
							
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label class=" control-label">Transaction Date </label>
								<div class="">                                            
									<?= $this->Form->control('transaction_date',['class'=>'form-control datepicker','placeholder'=>'Transaction Date','label'=>false,'type'=>'text','data-date-format' => 'dd-mm-yyyy','value'=>date("d-m-Y")]) ?>
								</div>
							</div>
							<div class="form-group">
								<label class=" control-label"></label>
								<div class="">                                            
									<?php //$this->Form->select('sales_ledger_id',$Accountledgers,['class'=>'form-control select','label'=>false]) ?>
								</div>
							</div>
							
						</div>
						<div class="col-md-6">
						<div class="form-group">
								<label class=" control-label">Narration</label>
								<div class=""> 
									<?= $this->Form->control('narration',['class'=>'form-control','placeholder'=>'Narration','label'=>false,'rows'=>'6']) ?>
								</div>
							</div>
						</div>
					</div>
					<div class="panel-body">    
						<div class="row">
							<div class="">
								
								<center><h3> Item Details</h3></center>
								<hr>
								<table class="table table-bordered main_table">
									<thead>
										<tr align="center">
										<th rowspan="2" style="text-align:left;width:10px;"><label>S.N<label></th>
										<th rowspan="2" style="text-align:left;width:300px;"><label>Item<label></th>
										<th rowspan="2" style="text-align:center;width:130px; "><label>Quantity<label></th>
										<th rowspan="2" style="text-align:center;width:110px;"><label>Rate<label></th>
										<th rowspan="2" style="text-align:center;width:110px;"><label>Amount<label></th>
										<th rowspan="2" style="text-align:center;width:110px;"><label>Action<label></th>
									</thead>
									<tbody class="MainTbody">  
										
									</tbody>
									<tfoot>
										<tr>
										<td colspan="4" style="text-align:right;">
											<b>Total Amount</b>
										</td>
										<td colspan="2" style="text-align:right;">
											<?= $this->Form->control('grand_total',['type'=>'hidden','class'=>'form-control grand_total','label'=>false,'readonly','value'=>@$sales_orders->grand_total]) ?>
											<?= $this->Form->control('pay_amount',['type'=>'hidden','class'=>'form-control pay_amount','label'=>false,'readonly','value'=>@$sales_orders->pay_amount]) ?>
											
											<?= $this->Form->control('show_amount',['type'=>'text','class'=>'form-control pay_amount','label'=>false,'readonly']) ?>
											
											<?= $this->Form->control('total_gst',['type'=>'hidden','class'=>'form-control gst_amt','label'=>false,'readonly','value'=>@$sales_orders->total_gst]) ?>
											<?= $this->Form->control('total_amount',['type'=>'hidden','class'=>'form-control total_taxable_value','label'=>false,'readonly','value'=>@$sales_orders->total_amount]) ?>
											<?= $this->Form->control('discount_amount',['type'=>'hidden','class'=>'form-control dis_amnt','label'=>false,'value'=>0]) ?>
											<?= $this->Form->control('txbal',['type'=>'hidden','class'=>'form-control txbal','label'=>false]) ?>
											<?= $this->Form->control('before_discount',['type'=>'hidden','class'=>'form-control before_discount','label'=>false,'readonly','value'=>@$sales_orders->total_amount]) ?>
										</td>
									</tr>
									</tfoot>
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
				<?= $this->Form->select('item_variation_id',$items,['empty'=>'--select--','style'=>'','class'=>'form-control item','label'=>false,'data-live-search'=>true,'readonly']) ?>
				<?= $this->Form->control('item_id',['type'=>'hidden','class'=>'form-control item_id','label'=>false,'readonly']) ?>
				
				<?= $this->Form->control('combo_offer_id',['type'=>'hidden','class'=>'form-control cmb_ofr_id','label'=>false]) ?>
			</td>
			
			<td  valign="top">
				<?= $this->Form->control('quantity',['class'=>'form-control quantity','label'=>false]) ?>
				
			</td>
			<td valign="top">
				<?= $this->Form->control('rate',['class'=>'form-control rate','label'=>false,'readonly']) ?>
			</td>
			<td valign="top">
				<?= $this->Form->control('amount',['class'=>'form-control amount','label'=>false]) ?>
				<?= $this->Form->control('discount_percent',['type'=>'hidden','class'=>'form-control discount_percent','label'=>false]) ?>
				<?= $this->Form->control('discount_amount',['type'=>'hidden','class'=>'form-control discount_amount','label'=>false,'readonly']) ?>
				<?= $this->Form->control('txbal',['type'=>'hidden','class'=>'form-control txbal','label'=>false]) ?>
				<?= $this->Form->control('taxable_value',['type'=>'hidden','class'=>'form-control taxable_value','label'=>false,'readonly']) ?>
				<?= $this->Form->control('taxable_value1',['type'=>'hidden','class'=>'form-control taxable_value1','label'=>false,'readonly']) ?>
				<?= $this->Form->control('gst_percentage',['type'=>'hidden','class'=>'form-control gst_percentage','label'=>false,'readonly']) ?>
				<?= $this->Form->control('gst_figure_id',['type'=>'hidden','type'=>'hidden','class'=>'form-control gst_figure_id','label'=>false,'readonly']) ?>
				<span class="gstAmt" style=" text-align:left;font-size:13px;"></span>
				<?= $this->Form->control('gst_value',['type'=>'hidden','class'=>'form-control gst_value','label'=>false,'readonly']) ?>
				<?= $this->Form->control('net_amount',['type'=>'hidden','class'=>'form-control net_amount','label'=>false,'readonly']) ?>
				<?= $this->Form->control('net_amount1',['type'=>'hidden','class'=>'form-control net_amount1','label'=>false,'readonly']) ?>
			</td>
			<td valign="top"  >
				<a class="btn btn-primary  btn-condensed btn-sm add_row" role="button" ><i class="fa fa-plus"></i></a>
				<a class="btn btn-danger  btn-condensed btn-sm delete_row " role="button" ><i class="fa fa-times"></i></a>
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
				party_ledger_id: {
						required: true,
				},
				sales_ledger_id: {
						required: true,
				},
				
			}                                        
		});
		
		$(document).on('change','.prty_ledgr',function(){
			var cstmrid=$('option:selected', this).attr('customer_id');
			var customeraddressid=$('option:selected', this).attr('customer_address_id');
			var membership_discount=$('option:selected', this).attr('membership_discount');
			var wallet=$('option:selected', this).attr('wallet');
			var membership_start_date=$('option:selected', this).attr('membership_start_date');
			var membership_end_date=$('option:selected', this).attr('membership_end_date');
			$('.wlt_amt').attr('max',wallet);
			$('#customer_id').val(cstmrid);
			$('#customer_address_id').val(customeraddressid);
			var today = new Date();
				var dd = today.getDate();

				var mm = today.getMonth()+1; 
				var yyyy = today.getFullYear();
				if(dd<10) 
				{
					dd='0'+dd;
				} 

				if(mm<10) 
				{
					mm='0'+mm;
				} 
				today = dd+'-'+mm+'-'+yyyy;
				
				if(membership_start_date<=today && membership_end_date>=today){
					var member_dis_per=membership_discount;
				}else{
					var member_dis_per=0;
				}
				//$('.dis_per').val(member_dis_per);
				
				var url='".$this->Url->build(["controller" => "Orders", "action" => "promo"])."';
				url=url+'/'+cstmrid
				$.ajax({
					url: url,
					type: 'GET'
				}).done(function(response) {
					//alert(response);
					//$('#promos').html(response);
				});
				
		});
		
		
	
		
		$(document).on('click','.add_row',function(){
			addMainRow();
		});
		
		addMainRow();
		function addMainRow(){
			var tr=$('#sampleTable tbody').html();
			$('.main_table tbody').append(tr);
			$('.select').select();
			renameRows();
		}
		
		$(document).on('click','.delete_row',function(){
			var t=$(this).closest('tr').remove();
			renameRows();
			calculation();
		});
	
		
		$(document).on('keyup','.rate',function(){
			calculation();
		});
		$(document).on('keyup','.quantity',function(){
			calculation();
		});
		
		
		
		
		
		$(document).on('change','.item',function(){ 
			var gst_value=$(this).find('option:selected', this).attr('gst_value'); 
			var sale_rate=$(this).find('option:selected', this).attr('sale_rate'); 
			var gst_figure_id=$(this).find('option:selected', this).attr('gst_figure_id');  
			var item_id=$(this).find('option:selected', this).attr('item_id');  
			var current_stock=$(this).find('option:selected', this).attr('current_stock');  
			$(this).closest('tr').find('.item_id').val(item_id);
			$(this).closest('tr').find('.gst_percentage').val(gst_value);
			$(this).closest('tr').find('.gst_figure_id').val(gst_figure_id);
			$(this).closest('tr').find('.rate').val(sale_rate);
			//$(this).closest('tr').find('.quantity').attr('max',current_stock);
			calculation();
		});
		
	
		function renameRows(){ 
			var i=0; 
			$('.main_table tbody tr').each(function(){
				$(this).attr('row_no',i);
				$(this).find('td:nth-child(1)').html(++i); i--;
				$(this).find('.item').selectpicker();
				$(this).find('input.item_id ').attr({name:'sales_order_rows['+i+'][item_id]',id:'sales_order_rows['+i+'][item_id]'})
				$(this).find('select.item ').attr({name:'sales_order_rows['+i+'][item_variation_id]',id:'sales_order_rows['+i+'][item_variation_id]'}).rules('add', 'required');
				$(this).find('.quantity ').attr({name:'sales_order_rows['+i+'][quantity]',id:'sales_order_rows['+i+'][quantity]'}).rules('add', 'required');
				$(this).find('.rate ').attr({name:'sales_order_rows['+i+'][rate]',id:'sales_order_rows['+i+'][rate]'}).rules('add', 'required');
				$(this).find('.amount ').attr({name:'sales_order_rows['+i+'][amount]',id:'sales_order_rows['+i+'][amount]'});
				$(this).find('.discount_percent ').attr({name:'sales_order_rows['+i+'][discount_percent]',id:'sales_order_rows['+i+'][discount_percent]'});
				$(this).find('.discount_amount ').attr({name:'sales_order_rows['+i+'][discount_amount]',id:'sales_order_rows['+i+'][discount_amount]'});
				$(this).find('.txbal ').attr({name:'order_details['+i+'][txbal]',id:'order_details['+i+'][txbal]'});
				$(this).find('.taxable_value ').attr({name:'order_details['+i+'][taxable_value]',id:'order_details['+i+'][taxable_value]'});
				$(this).find('.taxable_value1 ').attr({name:'order_details['+i+'][taxable_value1]',id:'order_details['+i+'][taxable_value1]'});
				
				$(this).find('.gst_percentage ').attr({name:'sales_order_rows['+i+'][gst_percentage]',id:'sales_order_rows['+i+'][gst_percentage]'});
				$(this).find('.gst_figure_id ').attr({name:'sales_order_rows['+i+'][gst_figure_id]',id:'sales_order_rows['+i+'][gst_figure_id]'});
				$(this).find('.gst_value ').attr({name:'sales_order_rows['+i+'][gst_value]',id:'sales_order_rows['+i+'][gst_value]'});
				$(this).find('.net_amount ').attr({name:'sales_order_rows['+i+'][net_amount]',id:'sales_order_rows['+i+'][net_amount]'});
				$(this).find('.net_amount1 ').attr({name:'order_details['+i+'][net_amount1]',id:'order_details['+i+'][net_amount1]'});
				i++;
			});
			calculation();
		}
		function calculation(){
			
			var total_amount=0;
			var total_gst=0;
			var total_taxable_value=0;
			var tot_txbl=0;
			var tot_discount_amount=0;
			
			
			$('.main_table tbody tr').each(function(){
				
					var discount_applicable=$(this).find('option:selected', this).attr('discount_applicable');
					var member_dis=$('.prty_ledgr').find('option:selected').attr('membership_discount');
					$(this).closest('tr').find('.discount_percent').val(member_dis);
					//var original_rate=$(this).find('.original_rate').val();
					var rate=$(this).find('.rate').val();
					
					//$(this).closest('tr').find('.rate').val(original_rate);
					var qty=$(this).find('.quantity').val();
					var gst_percentage=parseFloat($(this).find('.gst_percentage').val()); 
					
					var original_amount=qty*rate;
					var actual_amount=qty*rate;
					
					if(discount_applicable=='No'){
						$(this).closest('tr').find('.discount_percent').val(0);
						$(this).closest('tr').find('.discount_amount').val(0);
						$(this).closest('tr').find('.discount_percent').attr('applicable','No');
						//var rate=original_rate;
					}else{
						$(this).closest('tr').find('.discount_percent').attr('applicable','Yes');
						var dis=member_dis*original_amount/100;
						tot_discount_amount=tot_discount_amount+dis;
						$(this).closest('tr').find('.discount_percent').val((member_dis));
						$(this).closest('tr').find('.discount_amount').val((dis));
						var original_amount=original_amount-dis;
						
					}
					var taxable_value=original_amount;
					$(this).find('.txbal').val(taxable_value);
					
					$(this).find('.amount').val((actual_amount));
					if(!gst_percentage){ 
						gst_rate=0;
					}else{ 
						var x=100+gst_percentage;
						gst_rate=((((taxable_value*gst_percentage)/x)));
						
						gst_rate1=((gst_rate/2));
						gst_rate=((gst_rate1*2));
					} 
					
					taxable_value=taxable_value-gst_rate; 
					//$(this).find('.taxable_value').val(taxable_value);
					$(this).find('.taxable_value').val((taxable_value));
					$(this).find('.gst_value').val(gst_rate);
					var net_amount=gst_rate+taxable_value;
					var net_amount1=(net_amount);
					$(this).find('.net_amount').val((net_amount));
					//$(this).find('.net_amount').val(net_amount);
					total_gst=total_gst+gst_rate;
					total_amount=total_amount+net_amount1;
					
					total_taxable_value=total_taxable_value+taxable_value;
			});
			
			$('.dis_amnt').val((tot_discount_amount));
			$('.gst_amt').val((total_gst));
			$('.total_taxable_value').val((total_taxable_value));
			
			
			total_amount=total_amount;
			$('.grand_total').val((total_amount));
			$('.pay_amount').val((total_amount));
				
		}
	
	
		
		";  
echo $this->Html->scriptBlock($js, array('block' => 'scriptBottom')); 		
?>