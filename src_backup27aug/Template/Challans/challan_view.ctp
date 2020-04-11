
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
<?php //pr($challan); exit;
/**
 * @Author: PHP Poets IT Solutions Pvt. Ltd.
 */
$this->set('title', 'Challan');
?>
<div style="width:300px;font-family: Calibri !important;" class="maindiv">
<?php echo $this->Html->link('Print',array(),['escape'=>false,'class'=>'hidden-print','style'=>' background-color:blue;  font-size:18px; padding:5px; color:white; cursor:hand;  float: left','onclick'=>'javascript:NewPrint(1);']);
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
				style="text-align:center;font-size:12px !important;"><span> Customer Care No:-9116336666</span>
			</td>
		</tr>
		<tr>
			<td colspan="5"
			style="text-align:center;font-size:16px; padding-bottom:10px;  padding-top:10px;"><b><span><u>CHALLAN</u></span></b>
			</td>
		</tr>
		<tr>
			<td colspan="5" style="font-size:14px;">
				<b>Order No:</b> <?= h(@$challan->order->order_no)?>
			</td>
		</tr>
		<tr>
			<td colspan="5" style="font-size:14px;">
				<?php $Otime=strtotime(@$challan->order->order_time);
					$Otime1=date('H:i:s',$Otime);
					//pr($Otime1);
				?>
				<b>Order Date:</b><?= h(@$challan->order->order_date)?> <?= h(@$Otime1)?>
			</td>
		</tr>
		<tr>
			<td colspan="5" style="font-size:14px;">
				<b>Challan No:</b> <?= h(@$challan->invoice_no)?>
			</td>
		</tr>
		
		<tr>
			<td colspan="5" style="font-size:14px;">
				<b>Mobile Number:</b> <?= h(@$challan->customer_address->mobile_no)?>
			</td>
		</tr>
		<tr>
			<td colspan="5" style="font-size:14px;">
				<b>Customer Name:</b> <?= h(@$challan->customer_address->receiver_name)?>
			</td>
		</tr>
		<tr>
			<td colspan="5" style="font-size:14px;">
				<b>Customer Address:</b> <?= h(@$challan->customer_address->house_no)?>,<?= h(@$challan->customer_address->landmark_name)?>,<?= h(@$challan->customer_address->address)?>
			</td>
		</tr>
		<tr>
			<td colspan="5" style="font-size:14px;">
				<b>Date:</b> <?= h(date('d-m-Y'))?>
			</td>
		</tr>
		
		<?php if($challan->order_status == 'Cancel') { ?>
			<tr id="cStatus">
				<td colspan="5" style="font-size:18px;color: red;">
					<b>Challan Status:</b> <?= h(ucfirst(@$challan->order_status))?>
				</td>
			</tr>
		<?php } ?>
		
		<tr>
			<td colspan="5"
			style=" padding-bottom:10px;  padding-top:10px;"></td>
		</tr>
		
		<tr>
			<td><b>Sr.No.</b></td>
			<td><b>Item</b></td>
			<td align="center"><b>Quantity</b></td>
			<td align="center"><b>Rate</b></td>
			<td align="center"><b>Amount</b></td>
		</tr>
		<tr><td colspan="5" style="border-top:1px dashed;"></td></tr>
		<?php if($challan->order_status=="Cancel"){ //pr($challan); exit; ?>
			<?php $total_amt=0; $i=1; foreach($challan->challan_rows as $challan_row){ 
			
			?>
				<tr>
					<td><?php echo $i++;  ?></td>
					<td><?php echo $challan_row->item_variation->item->name ?> <?= h(@$challan_row->item_variation->unit_variation->visible_variation)?></td>
					<td align="center"><?php echo $challan_row->quantity; ?></td>
					<td align="center"><?php echo $challan_row->net_amount/$challan_row->quantity; ?></td>
					<td align="center"><?php echo $challan_row->net_amount; $total_amt+=$challan_row->net_amount;?></td>
					
				</tr>
			<?php } ?>
				<tr><td colspan="5" style="border-top:1px dashed;"></td></tr>
				<tr>
					<td colspan="4">Total Amount</td>
					<td colspan="4" align="center"><?php echo $total_amt; ?></td>
				</tr>
				
				<?php if($challan->delivery_charge_amount){ ?>
					<tr>
					<td colspan="4">Delivery Charge</td>
					<td colspan="4" align="center"><?php echo $challan->delivery_charge_amount; ?></td>
				</tr>
				<?php } ?>
				<tr>
					<td colspan="4">Net Amount</td>
					<td colspan="4" align="center"><?php echo $total_amt+$challan->delivery_charge_amount; ?></td>
				</tr>
				<tr>
					<td colspan="4"><b>Payment Mode</b></td>
					<td colspan="4" align="center"><b><?php echo $challan->order_type; ?></b></td>
				</tr>
		<?php }else{ ?>
			<?php $i=1; foreach($challan->challan_rows as $challan_row){ 
			if($challan_row->is_item_cancel=="No"){
			?>
				<tr>
					<td><?php echo $i++;  ?></td>
					<td><?php echo $challan_row->item_variation->item->name ?> <?= h(@$challan_row->item_variation->unit_variation->visible_variation)?></td>
					<td align="center"><?php echo $challan_row->quantity; ?></td>
					<?php $Rate=round(($challan_row->net_amount/$challan_row->quantity),2) ?>
					<td align="center"><?php echo $Rate; ?></td>
					<td align="center"><?php echo $challan_row->net_amount; ?></td>
					
				</tr>
			<?php }} ?>
			
			<tr><td colspan="5" style="border-top:1px dashed;"></td></tr>
			<tr>
				<td colspan="4">Total Amount</td>
				<td colspan="4" align="center"><?php echo $challan->grand_total; ?></td>
			</tr>
			
			<?php if($challan->delivery_charge_amount){ ?>
				<tr>
				<td colspan="4">Delivery Charge</td>
				<td colspan="4" align="center"><?php echo $challan->delivery_charge_amount; ?></td>
			</tr>
			<?php } ?>
			<tr>
				<td colspan="4">Net Amount</td>
				<td colspan="4" align="center"><?php echo $challan->pay_amount; ?></td>
			</tr>
			<tr>
				<td colspan="4"><b>Payment Mode</b></td>
				<td colspan="4" align="center"><b><?php echo $challan->order_type; ?></b></td>
			</tr>
			
		<?php } ?>
		
	</tbody>
</table>
<?php 
//pr($challan); ?>
<table border="0"  style="font-size:12px; margin-top:15px; border-collapse: collapse;">
	<tr>
		<td><b>Terms & Condition:</b></td>
	</tr>
	<tr>
		<td>
			<ol>
				<li>Item can be returned at the time of delivery.</li>
				
				
			</ol>
		</td>
	</tr>
	<tr>
		<td><b>Comments By Customer:</b></td>
	</tr>
	<?php if(!empty(@$challan->order->order_comment)){ ?>
	<tr>
		<td>
			<ol>
				<li><?php echo @$challan->order->order_comment; ?></li>
			</ol>
		</td>
	</tr>
	<?php } ?>
	<?php if(!empty(@$challan->order->narration)){ ?>
	<tr>
		<td>
			<ol>
				<li><?php echo @$challan->order->narration; ?></li>
			</ol>
		</td>
	</tr>
	<?php } ?>
</table>
</div>

