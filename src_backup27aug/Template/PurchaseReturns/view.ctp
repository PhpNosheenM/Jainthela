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
	zoom: 200%;
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

.maindiv {
border:solid 1px #c7c7c7;background-color: #FFF;padding:0px;margin: auto;width: 100%;font-size: 12px;
}
</style>



<?php $this->set('title', 'View'); ?>
<div  class="maindiv" style="border:solid 1px #c7c7c7;background-color: #FFF;padding: 10px;margin: auto;width:65%;font-size: 12px; ">	
	<table width="100%" class="divHeader">
		<tbody><tr>
				<td width="30%"> 
					<?php echo $this->Html->image('/img/jain.png', ['height' => '70px', 'width' => '70px']); ?>
				</td>
				<td align="center" width="40%" style="font-size: 12px;"><div align="center" style="font-size: 18px;font-weight: bold;color: #0685a8;"> Purchase Return </div></td>
				<td align="right" width="40%" style="font-size: 12px;">
				<span style="font-size: 14px;font-weight: bold;"><?= @$company_details->firm_name ?></span><br/>
				<span><?= @$company_details->firm_address ?></span></br>
				<span> <i class="fa fa-phone" aria-hidden="true"></i>  Mobile : <?= @$company_details->firm_contact ?> <?=@$company_details->mobile ?><br> GSTIN NO:
				<?=@$company_details->gstin ?></span></td>
			</tr>
			<tr>
				<td colspan="3">
				<div style="border:solid 2px #0685a8;margin-bottom:5px;margin-top: 5px;"></div>
				</td>
			</tr>
		</tbody>
	</table>
	<table width="100%">
		<tr>
			<td width="50%" valign="top" align="left">
				<table>
					<tr>
						<td>Voucher No</td>
						<td width="20" align="center">:</td>
						<td><?= h(str_pad($purchaseReturn->voucher_no, 4, '0', STR_PAD_LEFT)) ?></td>
						
					</tr>
					<tr>
						<td>Vendor</td>
						<td width="20" align="center">:</td>
						<td><?= $purchaseReturn->seller_ledger->name ?></td>
					</tr>
					
				</table>
			</td>
			<td width="50%" valign="top" align="right">
				<table>
					<tr>
						<td>Transaction Date</td>
						<td width="20" align="center">:</td>
						<td><?= $purchaseReturn->transaction_date ?></td>
					</tr>
					
				</table>
			</td>
		</tr>
	</table>
	</br>
		
	<table class="GeneratedTable">
		<thead>
			<tr>
				<th rowspan="2" style="text-align:center">No.</th>
				<th rowspan="2" style="text-align:center">Item</th>
				<th rowspan="2" style="text-align:center">Qty</th>
				<th rowspan="2" style="text-align:center">Rate</th>
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
			foreach($purchaseReturn->purchase_return_rows as $purchase_invoice_row){ 
			$gstAmt=0;
			$gstfig=0;
			if($purchase_invoice_row->gst_value > 0){
				$gstAmt=$purchase_invoice_row->gst_value/2;
				$gstfig=$purchase_invoice_row->gst_figure->tax_percentage/2;
			}
			//pr($purchase_invoice_row); 
			?>
			<tr>
				<td  style="text-align:right"><?php echo ++$i; ?></td>
				<td  style="text-align:center"><?php echo $purchase_invoice_row->item->name.' '.$purchase_invoice_row->unit_variation->visible_variation; ?></td>
				<td  style="text-align:right"><?php echo $purchase_invoice_row->quantity; $totalQty+=$purchase_invoice_row->quantity; ?></td>
				<td  style="text-align:right"><?php echo $purchase_invoice_row->rate; ?></td>
				<td  style="text-align:right"><?php echo $purchase_invoice_row->taxable_value; $totalAmt+=$purchase_invoice_row->taxable_value;?></td>
				<td  style="text-align:right"><?php echo $gstfig; ?></td>
				<td  style="text-align:right"><?php  echo $gstAmt; $totalCgst+=$gstAmt;?></td>
				<td  style="text-align:right"><?php echo $gstfig; ?></td>
				<td  style="text-align:right"><?php echo $gstAmt; $totalSgst+=$gstAmt;?></td>
				<td  style="text-align:right"><?php echo $purchase_invoice_row->net_amount; $total+=$purchase_invoice_row->net_amount;?></td>
			</tr>
			<?php } ?>
			<!--<tr>
				<td colspan="2" style="text-align:center"><b>Total</b></td>
				<td style="text-align:right"><?php echo $totalQty; ?></td>
				<td style="text-align:right"></td>
				<td style="text-align:right"><?php echo $totalAmt; ?></td>
				<td style="text-align:right"></td>
				<td style="text-align:right"><?php echo $totalCgst; ?></td>
				<td style="text-align:right"></td>
				<td style="text-align:right"><?php echo $totalSgst; ?></td>
				<td style="text-align:right"><?php echo $total; ?></td>
			
			</tr>-->
			<tr>
				<td colspan="9" style="text-align:right"><b>Total Amount Before Tax</b></td>
				<td style="text-align:right"><b><?php echo $totalAmt; ?></b></td>
			</tr>
			<tr>
				<td colspan="9" style="text-align:right"><b>CGST</b></td>
				<td style="text-align:right"><b><?php echo $totalCgst; ?></b></td>
			</tr>
			<tr>
				<td colspan="9" style="text-align:right"><b>SGST</b></td>
				<td style="text-align:right"><b><?php echo $totalSgst; ?></b></td>
			</tr>
			<tr>
				<td colspan="9" style="text-align:right"><b>Total</b></td>
				<td style="text-align:right"><b><?php echo $total; ?></b></td>
			</tr>
			
			
			
			
		</tbody>
	</table>
	</br>
	</br>
	</br>
	</br>
			
	
	</div>
