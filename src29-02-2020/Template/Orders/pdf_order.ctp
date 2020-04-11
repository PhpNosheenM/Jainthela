<?php 
require_once(ROOT . DS  .'vendor' . DS  . 'dompdf' . DS . 'autoload.inc.php');
use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->set('defaultFont', 'Lato-Hairline');
$dompdf = new Dompdf($options);

$dompdf = new Dompdf();


//$description =  wordwrap($invoice->delivery_description,25,'<br/>');
//pr($description);exit;
$html = '
<html>
<head>
  <style>
  @page { margin: 160px 15px 10px 30px; }

  body{
    line-height: 20px;
	}
	
    #header { position:fixed; left: 0px; top: -160px; right: 0px; height: 160px;}
    
	#content{
    position: relative; 
	}
	
	@font-face {
		font-family: Lato;
		src: url("https://fonts.googleapis.com/css?family=Lato");
	}
	p.test {
		width: 11px; 
    word-wrap: break-word;
}
	p{
		margin:0;font-family: Lato;font-weight: 100;line-height: 12px !important;margin-top:-9px;
	}
	.odd td p{
		margin:0;font-family: Lato;font-weight: 100;line-height: 17px !important;margin-bottom: -1px;
	}
	.show td p{
			margin:0;font-family: Lato;font-weight: 100;line-height: 17px !important;
	}
	.topdata p{
		margin:0;font-family: Lato;font-weight: 100;line-height: 17px !important;margin-bottom: 1px;
	}
	.des p{
		margin:0;font-family: Lato;font-weight: 100;line-height: 17px !important;margin-bottom: 1px;width:291px;
	}
	table td{
		margin:0;font-family: Lato;font-weight: 100;padding:0;line-height: 1;
	}
	table.table_rows tr.odd{
		page-break-inside: avoid;
	}
	.table_rows, .table_rows th, .table_rows td {
	    border: 1px solid  #000; 
		border-collapse: collapse;
		padding:2px; 
	}
	.itemrow tbody td{
		border-bottom: none;border-top: none;
	}
	
	.table2 td{
		border: 0px solid  #000;font-size: 14px;padding:0px; 
	}
	.table_top td{
		font-size: 12px !important; 
	}
	.table-amnt td{
		border: 0px solid  #000;padding:0px; 
	}
	
	.avoid_break{
		page-break-inside: avoid;
	}
	.table-bordered{
		border: hidden;
	}
	table.table-bordered td {
		border: hidden;
	}
	
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

<body>
   <div id="header" ><br/>	
		<table width="100%">
			<tr>
				<td width="35%" rowspan="2" valign="bottom">
				<img src='.ROOT . DS  . 'webroot' . DS  .'img/jain.png  height="100px" />
				</td>
				 
			</tr>
			<tr>
				<td width="30%" valign="top"> 
				<div align="center" style="font-size: 28px;font-weight: bold;color: #0685a8;">Order Detail</div>
				</td>
				 
			</tr></br>
			 <tr>
				<td colspan="3" >
					<div style="border:solid 2px #0685a8;"></div>
				</td>
			</tr>
		</table>
  </div>
 

  
  <div id="content"> ';
  
  $html.='
  
	<table class="GeneratedTable">
			<thead> 
				<tr>
					<td colspan="3" rowspan="2" width="50%">
						<b>'.h(@$company_details->firm_name).'</b>
						<br>
						<font size="13px">('.h(@$company_details->firm_address).'), 
						'. h(@$cities->name) .' ('.h(@$states->alias_name).'.) 
						Pincode:-'.h(@$company_details->firm_pincode).'
						<br>
						PH: '.h(@$company_details->firm_contact).'
						<br>
						GSTIN/UIN : '.h(@$company_details->gstin).'
						<br>
						State Name: '. h(@$states->name).'
						<br>
						E-mail : '.h(@$company_details->firm_email).'
						</font>
					</td>
					<td width="25%">
						<font size="15px">
							Order No. 
							<br>
							<b>'.h(@$Orders->order_no).'</b>
						</font>
						</td>
					<td width="25%">
						<font size="15px">
							Dated 
							<br>
							<b>'.h(date('d-M-Y', strtotime($Orders->order_date))).'</b>
						</font>
					</td>
				</tr>
				<tr>
					<td width="25%">
						<font size="15px">
							Order Type 
							<br>
							<b>'.h(@$Orders->order_type).'</b>
						</font>
						</td>
					<td width="25%">
						<font size="15px">
							Order From 
							<br>
							<b>'.h(@$Orders->order_from).'</b>
						</font>
					</td>
				</tr>
				
				<tr>
					<td colspan="3" rowspan="2" width="50%">
							
						<b>'.h(@$Orders->customer->name).'</b>
						<br>
						<font size="13px">('.h(@$Orders->customer->customer_addresses[0]->address).')
						<br>
						Name: '.h(@$Orders->customer->name).' | 
						PH: '.h(@$Orders->customer->username).'
						<br>
						
						</font>
					</td>
					
					<td width="25%">
						<font size="15px">
							Receiver Name
							<br>
							'.h(@$Orders->customer->customer_addresses[0]->receiver_name).'
						</font>
						</td>
					<td width="25%">
						<font size="15px">
							Receiver Mobile No. 
							<br>
							<b>'.h(@$Orders->customer->customer_addresses[0]->mobile_no).'</b>
						</font>
					</td>
				</tr>
				 
				<tr>
					<td colspan="2">
					'.$Orders->customer->customer_addresses[0]->house_no.', 
					'.$Orders->customer->customer_addresses[0]->address.' 
					<br>
					'.$Orders->customer->customer_addresses[0]->landmark.',
					'.$Orders->customer->customer_addresses[0]->pincode.',
					
					
					
					</td>
				</tr>
				 
			</thead>
	</table>
	
	 
		<table class="GeneratedTable">
			<caption>Order Details</caption>
			<thead>
				<tr style="background-color:#005B9E;">
					<th rowspan="2" style="text-align:center">No.</th>
					<th rowspan="2" style="text-align:center">Product Description</th>
					<th rowspan="2" style="text-align:center">Qty</th>
					<th rowspan="2" style="text-align:center">Rate</th>
					<th rowspan="2" style="text-align:center">Amount</th>
					<th rowspan="2" style="text-align:center">Discount</th>
					<th rowspan="2" style="text-align:center">Taxable Value</th>
					<th colspan="2" style="text-align:center">CGST</th>
					<th colspan="2" style="text-align:center">SGST</th>
					<th rowspan="2" style="text-align:center">Total</th>
				</tr>
				<tr style="background-color:#005B9E;">
					<th  style="text-align:center">Rate</th>
					<th style="text-align:center">Amount</th>
					<th  style="text-align:center">Rate</th>
					<th style="text-align:center">Amount</th>
				</tr>
			</thead>
			<tbody>';
				$i=0;
				$totalQty=0;
				$totalAmt=0;
				$totalDis=0;
				$totalTaxVal=0;
				$totalCgst=0;
				$totalSgst=0;
				$totalIgst=0;
				$total=0;
				foreach($Orders->order_details as $order_detail): 
				$gstAmt=0;
				$gstfig=0;
				if($order_detail->gst_value > 0){
					$gstAmt=$order_detail->gst_value/2;
					$gstfig=$order_detail->gst_percentage/2;
				}
				$totalQty+=$order_detail->quantity;
				$totalDis+=$order_detail->discount_amount;
				$totalTaxVal+=$order_detail->taxable_value;
				$totalCgst+=$gstAmt;
				$totalSgst+=$gstAmt;
				$total+=$order_detail->net_amount;
			$html.='
				<tr>
					<td  style="text-align:right">'. h(++$i) .'</td>
					<td  style="text-align:right">'. h($order_detail->item_variation->item->name.' '.$order_detail->item_variation->unit_variation->visible_variation) .'</td>
					<td  style="text-align:right">'. h($order_detail->quantity).'</td>
					<td  style="text-align:right">'. h($order_detail->rate).'</td>
					<td  style="text-align:right">'. h($order_detail->quantity*$order_detail->rate).'</td>
					<td  style="text-align:right">'. h($order_detail->discount_amount+$order_detail->promo_amount).'</td>
					<td  style="text-align:right">'. h($order_detail->taxable_value).'</td>
					<td  style="text-align:right">'. h($gstfig).'</td>
					<td  style="text-align:right">'. h($gstAmt).'</td>
					<td  style="text-align:right">'. h($gstfig).'</td>
					<td  style="text-align:right">'. h($gstAmt).'</td>
					<td  style="text-align:right">'. h($order_detail->net_amount).'</td>
					
				</tr>';
				endforeach; 
				$html.='
				<tr>
					<td colspan="2" style="text-align:center"><b>Total</b></td>
					<td  style="text-align:right">'. h($totalQty).'</td>
					<td style="text-align:right"></td>
					<td  style="text-align:right">'. h($totalAmt).'</td>
					<td  style="text-align:right">'. h($totalDis).'</td>
					<td  style="text-align:right">'. h($totalTaxVal).'</td>
					<td style="text-align:right"></td>
					<td  style="text-align:right">'. h($totalCgst).'</td>
					<td style="text-align:right"></td>
					<td  style="text-align:right">'. h($totalSgst).'</td>
					<td  style="text-align:right">'. h($total).'</td>
				
				</tr>
				<tr>
					<td colspan="7" style="text-align:center"><b>Total Invoice Amount In Words</b></td>
					<td colspan="4" style="text-align:center"><b>Total Amount Before Tax</b></td>
					<td  style="text-align:right">'. h($totalTaxVal).'</td>
				</tr>
				<tr>
					<td colspan="7" rowspan="3" style="text-align:center"><b>'. h($this->NumberWords->convert_number_to_words($total)).'</b></td>
					<td colspan="4" style="text-align:center"><b>Add : CGST</b></td>
					<td  style="text-align:right">'. h($totalCgst).'</td>
				</tr>
				<tr>
					<td colspan="4" style="text-align:center"><b>Add : SGST</b></td>
					<td  style="text-align:right">'. h($totalSgst).'</td>
				</tr>
				<tr>
					<td colspan="4" style="text-align:center"><b>Total Amount</b></td>
					<td  style="text-align:right">'. h($total).'</td>
				</tr>
				 
			</tbody>
		</table>
		
		<table class="GeneratedTable" style="text-decoration:none;">
			<thead> 
				<tr>
					<td style="text-align:center" colspan="6">Bank Details</td>
				</tr>
				<tr>
					 <td>Bank Name</td>
					 <td>Canara Bank</td>
					 
					 <td>Bank A/C</td>
					 <td>2982214000019</td>
					 
					 <td>Bank IFSC</td>
					 <td>CNRB0002982</td>
				</tr> 
				
				<tr>
					<td style="text-align:center" colspan="6">Declaration</td>
				</tr>
				<tr>
					<td style="text-align:center" colspan="6">We declare that this invoice shows the actual price of the goods described and that all particulars are true and correct.</td>
				</tr>
				
			</thead>
	</table>
	
	<table class="GeneratedTable">
		<tr>
					 <td colspan="5" style="border:none;"> </td>
					 <td style="text-align:right;border:none;">JAINTHELA</td>
				</tr>
				 <tr>
					 <td style="border:none;"> </td>
					 <td style="border:none;"> </td>
					 <td style="border:none;"> </td>
					 <td style="border:none;"> &nbsp;</td>
					 <td style="border:none;"> </td>
					 <td style="border:none;"> </td>
				</tr>
				<tr>
					 <td style="text-align:left;border:none;">Customers Seal and Signature</td>
					 <td style="border:none;"> </td>
					 <td style="border:none;"> </td>
					 <td style="border:none;"> </td>
					 <td style="border:none;"> </td>
					 <td style="text-align:right;border:none;">Authorised signature</td>
				</tr>
	</table>
			';

 $html .= '
</body>
</html>';

	//echo $html; exit; 

//$name='Invoice-'.h(($invoice->in1.'_IN'.str_pad($invoice->in2, 3, '0', STR_PAD_LEFT).'_'.$invoice->in3.'_'.$invoice->in4));
$name ="abc";
$dompdf->loadHtml($html);
$dompdf->set_paper('letter', 'portrait');
//$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$output = $dompdf->output(); //echo $name; exit;
//file_put_contents('Invoice_email/'.$name.'.pdf', $output);
//$dompdf->stream($name,array('Attachment'=>0));
$dompdf->stream($name,array('Attachment'=>0));
exit(0);
?>
