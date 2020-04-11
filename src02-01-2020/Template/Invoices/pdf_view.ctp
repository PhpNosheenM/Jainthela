<style>
@media print{
	.maindiv{
		width:100% !important;
	}	
	.hidden-print{
		display:none;
	}
}
p{
margin-bottom: 0;
}
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    padding: 5px !important;
	font-family:Lato !important;
}
</style>

<style type="text/css" media="print">
@page {
    size: auto;   /* auto is the initial value */
    margin: 0px 0px 0px 0px;  /* this affects the margin in the printer settings */
}
</style>
<!-- Codes by HTML.am -->

<!-- CSS Code -->
<style type="text/css" scoped>
table.GeneratedTable {
width:100%;
background-color:#FFFFFF;
border-collapse:collapse;border-width:1px;
border-color:#000000;
border-style:solid;
color:#000000;
}

table.GeneratedTable td, table.GeneratedTable th {
border-width:1px;
border-color:#000000;
border-style:solid;
padding:3px;
}

table.GeneratedTable thead {
background-color:#FFFFFF;
}
</style>



<?php $this->set('title', 'View'); ?>
	<div style="background-color: #FFF;padding:10px;width: 100%;font-size:14px;" class="maindiv">		
		<?php
		if(empty($print))
		{
			echo $this->Html->link('Print',['controller'=>'Orders','action'=>'pdf-view',$orderPrintId,'print'],['escape'=>false,'class'=>'btn  blue hidden-print fa fa-print','target'=>'_blank',]);
		}
		else
		{
			echo $this->Html->link('Print',array(),['escape'=>false,'class'=>'btn  blue hidden-print fa fa-print','onclick'=>'javascript:window.print();']);
		}
			echo $this->Html->link('Close',array(),['escape'=>false,'class'=>'btn  red hidden-print fa fa-remove pull-right','onclick'=>'javascript:window.close();']);
		?>
		
		<div class="col-md-12" >
			<div class="col-md-2">
				<?php echo $this->Html->image('/img/jain.png', ['height' => '150', 'width'=>'100px', 'class'=>'img-rounded img-responsive']); ?>
			</div>
			<div class="col-md-10" align="center" style="color:#337AB7; font-size: 18px;font-weight: bold;">
				<div align="center" style="color:#337AB7; font-size:14px;font-weight: bold;">
					<?= h($company_details->firm_name) ?>
				</div>
				<?= h($company_details->firm_address) ?><br>
				Tel: - <?= h($company_details->firm_contact) ?></br>
				Email: - <?= h($company_details->firm_email) ?><br>
				GSTIN Number:- <?= h($company_details->gstin) ?>
			</div>
		</div>
		
		<table class="GeneratedTable">
			<thead>
				
				<tr>
					<th colspan="4" style="text-align:center; padding-top:5px;">Tax Invoice</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td width="50%" colspan="2">Invoice No : - <?php echo $Orders->invoice_no; ?></td>
					<td width="50%"  colspan="2">Transport Mode : -</td>
				</tr>
				
				<tr>
					<td  colspan="2">Invoice Date : - <?php echo date('d-m-Y',strtotime($Orders->transaction_date)); ?></td>
					<td  colspan="2">Vehical Number : -</td>
				</tr>
				
				<tr>
					<td  colspan="2">Reverse Charge : - <?php echo date('d-m-Y',strtotime($Orders->delivery_date)); ?></td>
					<td  colspan="2">Date Of Supply</td>
				</tr>
				
				<tr>
					
					<td>State : - Rajsthan	</td>
					<td>Code : - 313001</td>
					<td colspan="2"> Place of Supply : -<?php echo $Orders->customer_address->address; ?></td>
					
				</tr>
				
			</tbody>
		</table>
		
		
		<table class="GeneratedTable">
			<thead>
				<tr>
					<th colspan="4" style="height:25px;"> </th>
				</tr>
				<tr>
					<th colspan="2" style="text-align:center">Bill To Party</th>
					<th colspan="2" style="text-align:center">Ship To Party</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td colspan="2">Name  : -<?php echo $Orders->customer->name; ?></td>
					<td colspan="2">Name  : -<?php echo $Orders->customer->name; ?></td>
				</tr>
				
				<tr>
					<td  colspan="2">Address : -<?php echo $Orders->customer->customer_addresses[0]->address; ?></td>
					<td  colspan="2">Address : -<?php echo $Orders->customer_address->address; ?></td>
				</tr>
				
				<tr>
					<td  colspan="2">GSTIN : -<?php echo $Orders->customer->gstin; ?></td>
					<td  colspan="1">GSTIN : -<?php echo $Orders->customer->gstin; ?></td>
					<td>Challan No : - <?php echo @$Orders->challan->invoice_no; ?></td>
				</tr>
				
				<tr>
					<td>State : - Rajsthan	</td>
					<td>Code : - 313001</td>
					<td>State : - Rajsthan	</td>
					<td>Code : - 313001</td>
				</tr>
				
			</tbody>
		</table>
		
		
		<table class="GeneratedTable">
			<thead>
				<tr>
					<th rowspan="2" style="text-align:center">No.</th>
					<th rowspan="2" style="text-align:center">Product Description</th>
					<th rowspan="2" style="text-align:center">HSN Code</th>
					<th rowspan="2" style="text-align:center">UOM</th>
					<th rowspan="2" style="text-align:center">Qty</th>
					<th rowspan="2" style="text-align:center">Rate</th>
					<th rowspan="2" style="text-align:center">Amount</th>
					<th rowspan="2" style="text-align:center">Discount</th>
					<th rowspan="2" style="text-align:center">Taxable Value</th>
					<?php if($billType=="GST"){ ?>
						<th colspan="2" style="text-align:center">CGST</th>
						<th colspan="2" style="text-align:center">SGST</th>
					<?php }else{ ?>
						<th colspan="2" style="text-align:center">IGST</th>
					<?php } ?>
					<th rowspan="2" style="text-align:center">Total</th>
				</tr>
				<tr>
					<?php if($billType=="GST"){ ?>
						<th  style="text-align:center">Rate</th>
						<th style="text-align:center">Amount</th>
						<th  style="text-align:center">Rate</th>
						<th style="text-align:center">Amount</th>
					<?php }else{ ?>
						<th  style="text-align:center">Rate</th>
						<th style="text-align:center">Amount</th>
					<?php } ?>
				</tr>
			</thead>
			<tbody>
				<?php 
				$i=0;
				$totalQty=0;
				$totalAmt=0;
				$totalDis=0;
				$totalTaxVal=0;
				$totalGstPerWise=[];
				$totalTaxableGstPerWise=[];
				$totalCgst=0;
				$totalSgst=0;
				$totalIgst=0;
				$total=0;
				foreach($Orders->invoice_rows as $order_detail){ 
				$gstAmt=0;
				if($order_detail->gst_value > 0){
					$gstAmt=$order_detail->gst_value/2;
				}
				@$totalTaxableGstPerWise[$order_detail->gst_figure_id]+=@$order_detail->taxable_value;
				@$totalGstPerWise[$order_detail->gst_figure_id]+=@$order_detail->gst_value;
				?>
				<tr>
					<td  style="text-align:right"><?php echo ++$i; ?></td>
					<td  style="text-align:center"><?php echo $order_detail->item->name; ?>(<?php echo $order_detail->item_variation->unit_variation->visible_variation;?> )</td>
					<td  style="text-align:right"><?php echo $order_detail->item->hsn_code; ?></td>
					<td  style="text-align:right"></td>
					<td  style="text-align:right"><?php echo $order_detail->quantity; $totalQty+=$order_detail->quantity; ?></td>
					<td  style="text-align:right"><?php echo $order_detail->rate; ?></td>
					<td  style="text-align:right"><?php echo $order_detail->quantity*$order_detail->rate; $totalAmt+=$order_detail->quantity*$order_detail->rate;?></td>
					<td  style="text-align:right"><?php echo $order_detail->discount_amount; $totalDis+=$order_detail->discount_amount;?></td>
					<td  style="text-align:right"><?php echo $order_detail->taxable_value;  $totalTaxVal+=$order_detail->taxable_value;?></td>
					<?php if($billType=="GST"){ ?>
						<td  style="text-align:right"><?php echo $order_detail->gst_percentage/2; ?></td>
						<td  style="text-align:right"><?php  echo $gstAmt; $totalCgst+=$gstAmt;?></td>
						<td  style="text-align:right"><?php echo $order_detail->gst_percentage/2; ?></td>
						<td  style="text-align:right"><?php echo $gstAmt; $totalSgst+=$gstAmt;?></td>
					<?php }else{ ?>
						<td  style="text-align:right"><?php echo $order_detail->gst_percentage; ?></td>
						<td  style="text-align:right"><?php echo $order_detail->gst_value; $totalIgst+=$order_detail->gst_value;?></td>
					<?php } ?>
					
					<td  style="text-align:right"><?php echo $order_detail->net_amount; $total+=$order_detail->net_amount;?></td>
				</tr>
				<?php } ?>
				<tr>
					<td colspan="4" style="text-align:center"><b>Total</b></td>
					<td style="text-align:right"><?php echo $totalQty; ?></td>
					<td style="text-align:right"></td>
					<td style="text-align:right"><?php echo $totalAmt; ?></td>
					<td style="text-align:right"><?php echo $totalDis; ?></td>
					<td style="text-align:right"><?php echo $totalTaxVal; ?></td>
					<?php if($billType=="GST"){ ?>
						<td style="text-align:right"></td>
						<td style="text-align:right"><?php echo $totalCgst; ?></td>
						<td style="text-align:right"></td>
						<td style="text-align:right"><?php echo $totalSgst; ?></td>
					<?php }else { ?>
						<td style="text-align:right"></td>
						<td style="text-align:right"><?php echo $totalIgst; ?></td>
					<?php } ?>
					<td style="text-align:right"><?php echo $total; ?></td>
				
				</tr>
				<tr>
					<?php if($billType=="GST"){ ?>
						<td colspan="9" style="text-align:center"><b>Total Invoice Amount In Words</b></td>
					<?php }else { ?>
						<td colspan="7" style="text-align:center"><b>Total Invoice Amount In Words</b></td>
					<?php } ?>
					<td colspan="4" style="text-align:center"><b>Total Amount Before Tax</b></td>
					<td style="text-align:right"><b><?php echo $totalTaxVal; ?></b></td>
				</tr>
				<?php if($billType=="GST"){ ?>
				<tr>
					<td colspan="9" rowspan="1" style="text-align:center"><b><?php echo $this->NumberWords->convert_number_to_words($Orders->pay_amount); ?> Rupees</b></td>
					<td colspan="4" style="text-align:center"><b>Add : CGST</b></td>
					<td style="text-align:right"><b><?php echo $totalCgst; ?></b></td>
					
				</tr>
				<tr>
					<td colspan="9" rowspan="4" style="text-align:center">
						<table align="center">
							<tr>
								<?php foreach($GstFigures as $GstFigure){ ?>
									<td  colspan="3"><?php echo $GstFigure->tax_percentage; ?>%</td>
								<?php } ?>
									<td  colspan="3">Total</td>
							</tr>
							<tr>
								<td >Taxable</td>
								<td >CGST</td>
								<td >SGST</td>
								<td >Taxable</td>
								<td >CGST</td>
								<td >SGST</td>
								<td >Taxable</td>
								<td >CGST</td>
								<td >SGST</td>
								<td >Taxable</td>
								<td >CGST</td>
								<td >SGST</td>
								<td >Taxable</td>
								<td >CGST</td>
								<td >SGST</td>
								<td >Total Taxable</td>
								<td >Total CGST</td>
								<td >Total SGST</td>
							</tr>
							<tr>
								<?php foreach($GstFigures as $GstFigure){  ?>
								
									<?php if(empty(@$totalTaxableGstPerWise[$GstFigure->id])){ ?>
										<td>-</td>
										<td>-</td>
										<td>-</td>
									<?php }else{ ?>
									<td><?php echo @$totalTaxableGstPerWise[$GstFigure->id]; ?></td>
									<td><?php echo @$totalGstPerWise[$GstFigure->id]/2; ?></td>
									<td><?php echo @$totalGstPerWise[$GstFigure->id]/2; ?></td>
								<?php } } ?>
										<td><?php echo $totalTaxVal; ?></td>
										<td><?php echo $totalCgst; ?></td>
										<td><?php echo $totalSgst; ?></td>
										
							</tr>
						</table>
					</td>
					<td colspan="4" style="text-align:center"><b>Add : SGST</b></td>
					<td style="text-align:right"><b><?php echo $totalSgst; ?></b></td>
				</tr>
				<?php } else { ?>
					<tr>
					<td colspan="7" rowspan="1" style="text-align:center"><b><?php echo $this->NumberWords->convert_number_to_words($Orders->pay_amount); ?> Rupees</b></td>
					<td colspan="4" style="text-align:center"><b>Add : IGST</b></td>
					<td style="text-align:right"><b><?php echo $totalIgst; ?></b></td>
					
				</tr>
				<?php }  ?>
				<tr>
				<?php if($billType=="GST"){ ?>
						
				<?php } else { ?>
					<td colspan="7" rowspan="3" style="text-align:center">
						<table align="center">
							<tr>
								<?php foreach($GstFigures as $GstFigure){ ?>
									<td  colspan="2"><?php echo $GstFigure->tax_percentage; ?>%</td>
								<?php } ?>
									<td  colspan="2">Total</td>
							</tr>
							<tr>
								<td >Taxable</td>
								<td >IGST</td>
								<td >Taxable</td>
								<td >IGST</td>
								<td >Taxable</td>
								<td >IGST</td>
								<td >Taxable</td>
								<td >IGST</td>
								<td >Taxable</td>
								<td >IGST</td>
								<td >Total Taxable</td>
								<td >Total IGST</td>
							</tr>
							<tr>
								<?php foreach($GstFigures as $GstFigure){  ?>
								
									<?php if(empty(@$totalTaxableGstPerWise[$GstFigure->id])){ ?>
										<td>-</td>
										<td>-</td>
									<?php }else{ ?>
									<td><?php echo @$totalTaxableGstPerWise[$GstFigure->id]; ?></td>
									<td><?php echo @$totalGstPerWise[$GstFigure->id]; ?></td>
									
								<?php } } ?>
										<td><?php echo $totalTaxVal; ?></td>
										<td><?php echo $totalIgst; ?></td>
							</tr>
						</table>
					</td>
					<?php }  ?>
					<td colspan="4" style="text-align:center"><b>Delivery Charge</b></td>
					<td style="text-align:right"><b><?php echo $Orders->delivery_charge_amount; ?></b></td>
				</tr>
				
				<tr>
					<td colspan="4" style="text-align:center"><b>round Off</b></td>
					<td style="text-align:right"><b><?php echo $Orders->round_off; ?></b></td>
				</tr>
				<tr>
					<td colspan="4" style="text-align:center"><b>Total Amount After Tax</b></td>
					<td style="text-align:right"><b><?php 
					
					echo $Orders->pay_amount; ?></b></td>
				</tr>
				
				<tr>
					<td colspan="4"  style="text-align:center"><b>Bank Details</b></td>
					<td colspan="5"   rowspan="1" style="text-align:center"><b>Terms & Conditions</b></td>
					<td  colspan="5" rowspan="5" style="text-align:center" valign="top"><b>Certified That the particulars given</br> above are true and correct</b><br/>or SHRINAKAODA AGROPRODUCT PRIVATE LIMITED</td>
				</tr>
				<tr>
					<td colspan="1"   style="text-align:center"><b>Bank Name</b></td>
					<td  colspan="3"  style="text-align:center"><b>Canara Bank</b></td>
					<td colspan="5"  rowspan="5" style="text-align:center">1.Item can be returned at the time of delivery.</td>
				</tr>
				<tr>
					<td colspan="1"   style="text-align:center"><b>Bank A/C</b></td>
					<td  colspan="3"  style="text-align:center"><b>2982214000019</b></td>
				</tr>
				<tr>
					<td colspan="1"   style="text-align:center"><b>Bank IFSC</b></td>
					<td  colspan="3"  style="text-align:center"><b>CNRB0002982</b></td>
				</tr>
				<tr>
					<td colspan="4" rowspan="2" style="text-align:center"><b>Order Comments</b>
					<?php if($Orders->order->order_comment){ ?></br><?php echo ($Orders->order->order_comment); ?> <?php } ?>
					<?php if($Orders->order->narration){ ?></br><?php echo ($Orders->order->narration); ?><?php } ?>
					
					</td>
					
				</tr>
				
				<tr>
					
					<td colspan="5"  rowspan="2" style="text-align:center"><b>Authorised Signatory</b></td>
				</tr>
				
				
				
			</tbody>
		</table>
		
			
	
	</div>
