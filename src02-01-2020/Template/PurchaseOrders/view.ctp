
<script type="text/javascript">
<!--



function NewPrint(Copies){
	
  
    window.print(0);
  
}
//-->
</script>
<style>

@media print{
	.maindiv{
		width:300px !important;
	}	
	.hidden-print{
		display:none;
	}
}
p{
margin-bottom: 0;
}
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    padding: 1px !important;
	font-family: Calibri !important;
}
</style>

<style type="text/css" media="print">
@page {
    size: auto;   /* auto is the initial value */
    margin: 0px 0px 0px 0px;  /* this affects the margin in the printer settings */
}
</style>
<?php
/**
 * @Author: PHP Poets IT Solutions Pvt. Ltd.
 */
$this->set('title', 'Purchase Order');
?>
<div style="width:300px;height:100%;font-family: Calibri !important; background-color:white;" class="maindiv">
<?php echo $this->Html->link('Print',array(),['escape'=>false,'class'=>'hidden-print','style'=>' background-color:blue;  font-size:18px; padding:5px; color:white; cursor:hand;  float: left','onclick'=>'javascript:NewPrint(2);']);
 echo $this->Html->link('Close',['controller'=>'Challans','action'=>'manageOrder'],['escape'=>false,'class'=>'hidden-print','style'=>' background-color:blue;  font-size:18px; padding:5px; color:white; cursor:hand;  float: right']);
?>
<table  width="100%" border="0"  >
	<tbody>
		<tr>
			<td colspan="5" align="center">
				<?php echo $this->Html->image('/img/jain.png', ['height' => '50px', 'width' => '50px']); ?>
			</td>
		</tr>
		<tr>
			<td colspan="5"
				style="text-align:center;font-size:16px;"><b><span><?=@$company_details->firm_name?></span></b>
			</td>
		</tr>
		<tr>
			<td colspan="5"
				style="text-align:center;font-size:12px !important;"><span> GST No:-<?=@$company_details->gstin?></span>
			</td>
		</tr>
		<tr>
			<td colspan="5"
			style="text-align:center;font-size:16px; padding-bottom:10px;  padding-top:10px;"><b><span><u>Purchase Order</u></span></b>
			</td>
		</tr>
		<tr>
			<td colspan="5" style="font-size:14px;">
				<b>Vendor Name:</b> <?= h(@$purchaseOrder->vendor->name)?>
			</td>
		</tr>
		<tr>
			<td colspan="5" style="font-size:14px;">
				<b>Date:</b> <?= h(@$purchaseOrder->transaction_date)?>
			</td>
		</tr>
		
		<tr>
			<td colspan="5"
			style=" padding-bottom:10px;  padding-top:10px;"></td>
		</tr>
		
		<tr>
			<td><b>Sr.No.</b></td>
			<td><b>Item</b></td>
			<td align="center"><b>Quantity</b></td>
			
		</tr>
		<tr><td colspan="5" style="border-top:1px dashed;"></td></tr>
		<?php $i=1; foreach($purchaseOrder->purchase_order_rows as $challan_row){ ?>
		<tr>
			<td><?php echo $i++;  ?></td>
			<td><?php echo $challan_row->item_variation->item->name ?> <?= h(@$challan_row->item_variation->unit_variation->visible_variation)?></td>
			<td align="center"><?php echo $challan_row->quantity; ?></td>
			
			
		</tr>
		<?php } ?>
		<tr><td colspan="5" style="border-top:1px dashed;"></td></tr>
		
	</tbody>
</table>
<?php 
//pr($challan); ?>

</div>

