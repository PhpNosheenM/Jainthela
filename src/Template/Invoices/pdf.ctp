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
				<td colspan="3" align="right">
				<span style="font-size: 13px;margin:0;"><b>tgerg</b></span>
				</td>
			</tr>
			<tr>
				<td width="35%" rowspan="2" valign="bottom">
				<img src='.ROOT . DS  . 'webroot' . DS  .'img/jain.png  height="80px" />
				</td>
				<td colspan="2" align="right">
				<span style="font-size: 20px;">SHRINAKODA AGROPRODUCT PRIVATE LIMITED</span>
				</td>
			</tr>
			<tr>
				<td width="30%" valign="top"> 
				<div align="center" style="font-size: 28px;font-weight: bold;color: #0685a8;">TAX INVOICE</div>
				</td>
				<td align="right" width="35%" style="font-size: 12px; ">
				<span >(15-16 Nr. Eicher Service Center, Aapni Dhani, PratapNagar), Pincode:-313002</span>
				<span ><img style="margin-top:3px !important;" src='.ROOT . DS  . 'webroot' . DS  .'img/telephone.gif height="11px" /> 9874563210 </span> | 
				<span><img style="margin-top:2px !important;" src='.ROOT . DS  . 'webroot' . DS  .'img/email.png height="15px" /> jainthela@gmail.com</span>
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
					<th colspan="4" style="text-align:center; padding-top:5px;">Tax Invoice</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td width="50%" colspan="2">Invoice No : - '. h($Orders->order_no) .'</td>
					<td width="50%"  colspan="2">Transport Mode : -</td>
				</tr>
				
				<tr>
					<td  colspan="2">Invoice Date : -'. h(date('d-m-Y',strtotime($Orders->transaction_date))) .'</td>
					<td  colspan="2">Vehical Number : -</td>
				</tr>
				
				<tr>
					<td  colspan="2">Reverse Charge : - </td>
					<td  colspan="2">Date Of Supply : - '. h(date('d-m-Y',strtotime($Orders->delivery_date))) .'</td>
					
				</tr>
				
				<tr>
					
					<td>State : - Rajsthan	</td>
					<td>Code : - 313001</td>
					<td colspan="2"> Place of Supply : -'. h(@$Orders->customer_address->address) .'</td>
					
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
					<td colspan="2">Name  : -'. h($Orders->customer->name) .'</td>
					<td colspan="2">Name  : -'. h($Orders->customer->name) .'</td>
					
				</tr>
				
				<tr>
					<td  colspan="2">Address : -'. h($Orders->customer_address) .'</td>
					<td  colspan="2">Address : -'. h($Orders->customer->customer_addresses[0]->address) .'</td>
				</tr>
				
				<tr>
					<td  colspan="2">GSTIN : -'. h($Orders->customer->gstin) .'</td>
					<td  colspan="2">GSTIN : -'. h($Orders->customer->gstin) .'</td>
					
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
					<td colspan="7" rowspan="3" style="text-align:center"><b>'. h($this->NumberWords->convert_number_to_words($totalTaxVal)).'</b></td>
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
					<td  colspan="3"  style="text-align:center"><b>2982214000019</b></td>
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
