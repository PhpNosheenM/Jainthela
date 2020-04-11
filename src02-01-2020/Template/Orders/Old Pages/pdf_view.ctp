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
	<div style="border:solid 1px #c7c7c7;background-color: #FFF; margin-left:100px; margin-right:100px;width: 80%;font-size:14px;" class="maindiv">	
		<?php
		if(empty($print))
		{
			echo $this->Html->link('Print',['controller'=>'Orders','action'=>'view',$ids,'print'],['escape'=>false,'class'=>'btn  blue hidden-print fa fa-print','target'=>'_blank',]);
		}
		else
		{
			echo $this->Html->link('Print',array(),['escape'=>false,'class'=>'btn  blue hidden-print fa fa-print','onclick'=>'javascript:window.print();']);
		}
			echo $this->Html->link('Close',array(),['escape'=>false,'class'=>'btn  red hidden-print fa fa-remove pull-right','onclick'=>'javascript:window.close();']);
		?>
		
		<div class="col-md-12" >
			<div class="col-md-1">
				<?php echo $this->Html->image('/img/jain.png', ['height' => '150', 'width'=>'100px', 'class'=>'img-rounded img-responsive']); ?>
			</div>
			<div class="col-md-10" align="center" style="color:#337AB7; font-size: 18px;font-weight: bold;">
				<div align="center" style="color:#337AB7; font-size: 25px;font-weight: bold;">
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
					<td width="50%" colspan="2">Invoice No : - <?php echo $Orders->order_no; ?></td>
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
					<td  colspan="2">GSTIN : -<?php echo $Orders->customer->gstin; ?></td>
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
					<th colspan="2" style="text-align:center">CGST</th>
					<th colspan="2" style="text-align:center">SGST</th>
					<th rowspan="2" style="text-align:center">Total</th>
				</tr>
				<tr>
					<th  style="text-align:center">Rate</th>
					<th style="text-align:center">Amount</th>
					<th  style="text-align:center">Rate</th>
					<th style="text-align:center">Amount</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				$i=0;
				$totalQty=0;
				$totalAmt=0;
				$totalDis=0;
				$totalTaxVal=0;
				$totalCgst=0;
				$totalSgst=0;
				$totalIgst=0;
				$total=0;
				foreach($Orders->order_details as $order_detail){ 
				$gstAmt=0;
				if($order_detail->gst_value > 0){
					$gstAmt=$order_detail->gst_value/2;
				}
				?>
				<tr>
					<td  style="text-align:right"><?php echo ++$i; ?></td>
					<td  style="text-align:center"><?php echo $order_detail->item->name; ?></td>
					<td  style="text-align:right"></td>
					<td  style="text-align:right"></td>
					<td  style="text-align:right"><?php echo $order_detail->quantity; $totalQty+=$order_detail->quantity; ?></td>
					<td  style="text-align:right"><?php echo $order_detail->rate; ?></td>
					<td  style="text-align:right"><?php echo $order_detail->quantity*$order_detail->rate; $totalAmt+=$order_detail->quantity*$order_detail->rate;?></td>
					<td  style="text-align:right"><?php echo $order_detail->discount_amount; $totalDis+=$order_detail->discount_amount;?></td>
					<td  style="text-align:right"><?php echo $order_detail->amount;  $totalTaxVal+=$order_detail->amount;?></td>
					<td  style="text-align:right"><?php echo $order_detail->gst_percentage; ?></td>
					<td  style="text-align:right"><?php  echo $gstAmt; ?></td>
					<td  style="text-align:right"><?php echo $order_detail->gst_percentage; ?></td>
					<td  style="text-align:right"><?php echo $gstAmt; ?></td>
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
					<td style="text-align:right"></td>
					<td style="text-align:right"><?php echo $gstAmt; ?></td>
					<td style="text-align:right"></td>
					<td style="text-align:right"><?php echo $gstAmt; ?></td>
					<td style="text-align:right"><?php echo $total; ?></td>
				
				</tr>
				<tr>
					<td colspan="9" style="text-align:center"><b>Total Invoice Amount In Words</b></td>
					<td colspan="4" style="text-align:center"><b>Total Amount Before Tax</b></td>
					<td style="text-align:right"><b><?php echo $totalTaxVal; ?></b></td>
				</tr>
				<tr>
					<td colspan="9" rowspan="5" style="text-align:center"><b>Total Invoice Amount In Words</b></td>
					<td colspan="4" style="text-align:center"><b>Add : CGST</b></td>
					<td style="text-align:right"><b><?php echo $gstAmt; ?></b></td>
					
				</tr>
				<tr>
					<td colspan="4" style="text-align:center"><b>Add : CGST</b></td>
					<td style="text-align:right"><b><?php echo $gstAmt; ?></b></td>
				</tr>
				<tr>
					<td colspan="4" style="text-align:center"><b>Total Tax Amount</b></td>
					<td style="text-align:right"><b><?php echo $totalTaxVal; ?></b></td>
				</tr>
				<tr>
					<td colspan="4" style="text-align:center"><b>Total Amount After Tax</b></td>
					<td style="text-align:right"><b><?php echo $totalTaxVal; ?></b></td>
				</tr>
				<tr>
					<td colspan="4" style="text-align:center"><b>GST on Reverse Charge</b></td>
					<td style="text-align:right"><b><?php echo "0"; ?></b></td>
				</tr>
				
				<tr>
					<td colspan="4"  style="text-align:center"><b>Bank Details</b></td>
					<td colspan="5" rowspan="5" style="text-align:center"></td>
					<td  colspan="5" rowspan="5" style="text-align:center" valign="top"><b>Certified That the particulars given</br> above are true and correct</b><br/>or SHRINAKAODA AGROPRODUCT PRIVATE LIMITED</td>
				</tr>
				<tr>
					<td colspan="1"   style="text-align:center"><b>Bank Name</b></td>
					<td  colspan="3"  style="text-align:center"><b>Canara Bank</b></td>
					
				</tr>
				<tr>
					<td colspan="1"   style="text-align:center"><b>Bank A/C</b></td>
					<td  colspan="3"  style="text-align:center"><b>29822140019</b></td>
				</tr>
				<tr>
					<td colspan="1"   style="text-align:center"><b>Bank IFSC</b></td>
					<td  colspan="3"  style="text-align:center"><b>CNRB0002982</b></td>
				</tr>
				<tr>
					<td colspan="4" rowspan="2" style="text-align:center"><b>Terms & Conditions</br></br></br></br></b></td>
					
				</tr>
				
				<tr>
					<td colspan="5" rowspan="2" style="text-align:center"><b>Common seal</b></td>
					<td colspan="5"  rowspan="2" style="text-align:center"><b>Authorised Signatory</b></td>
				</tr>
				
				
				
			</tbody>
		</table>
		
			
	
	</div>
