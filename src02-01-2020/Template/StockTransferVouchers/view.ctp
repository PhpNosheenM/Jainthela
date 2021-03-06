<style>

@media print{
	.maindiv{
		width:100% !important;
		margin:auto;
	}	
	.hidden-print{
		display:none;
	}
}

</style>
<style type="text/css" media="print">
@page {
	width:100%;
    size: auto;   /* auto is the initial value */
    margin: 0px 0px 0px 0px;  /* this affects the margin in the printer settings */
}
.maindiv {
border:solid 1px #c7c7c7;background-color: #FFF;padding: 10px;margin: auto;width: 100%;font-size: 12px;
}
</style>


<?php
/**
 * @Author: PHP Poets IT Solutions Pvt. Ltd.
 */
$this->set('title', 'Stock Transfer Voucher');
?>
<div  class="maindiv" style="border:solid 1px #c7c7c7;background-color: #FFF;padding: 10px;margin: auto;width:75%;font-size: 12px;">	
	<table width="100%" class="divHeader">
		<tbody><tr>
				<td width="30%"> 
					<?php echo $this->Html->image('/img/jain.png', ['height' => '70px', 'width' => '70px']); ?>
				</td>
				<td align="center" width="40%" style="font-size: 12px;">
					<div align="center" style="font-size: 18px;font-weight: bold;color: #0685a8;">
						STOCK TRANSFER VOUCHER
					</div>
				</td>
				<td align="right" width="40%" style="font-size: 12px;">
				<span style="font-size: 14px;font-weight: bold;"><?= @$companies->firm_name ?></span><br/>
				<span><?= @$companies->firm_address ?></span></br>
				<span> <i class="fa fa-phone" aria-hidden="true"></i>  Mobile : <?= @$companies->firm_contact ?> <?=@$companies->mobile ?><br> GSTIN NO:
				<?=@$companies->gstin ?></span></td>
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
						<td><?= h(str_pad($stockTransferVoucher->voucher_no, 4, '0', STR_PAD_LEFT)) ?></td>
					</tr>
				</table>
			</td>
			<td width="50%" valign="top" align="right">
				<table>
					<tr>
						<td>Transaction Date</td>
						<td width="20" align="center">:</td>
						<td><?= h(date("d-m-Y",strtotime($stockTransferVoucher->transaction_date))) ?></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
		Narration: <?php echo $stockTransferVoucher->narration;?>
		<br/><br/>
		<table width="100%" class="table" style="font-size:12px">
			<tr style="background-color:#F0EFED;">
				<th><?= __('Sr.No') ?></th>
				<th><?= __('Name') ?></th>
				<th><?= __('Quantity') ?></th>
				<th><?= __('Purchase Rate') ?></th>
				
			</tr>
			<?php foreach($stockTransferVoucher->stock_transfer_voucher_rows as $stock_data)
				{  
				@$k++;
				$visible_variation=$stock_data->item_variation->unit_variation->visible_variation;
				$item_name=$stock_data->item->name;
				?>
					<tr>
					<td><?= h($k) ?></td>	
					<td style="text-align:left">
					<b>
						<?= h($item_name) ?> (<?= h($visible_variation) ?>)
					</b>
						 
					</td>
					<td ><?= $stock_data->quantity ?></td>
					<td><?= $stock_data->purchase_rate ?></td>
					
					</tr>
			<?php } ?>
			<tr>
				<td colspan="5">
					<div style="border:solid 1px #0685a8;"></div>
				</td>
			</tr>
			<tr>
			<td colspan="3" align="right"></td>
			
			<th> <?php ///echo $total_debit;?></th>
			<th> <?php ///echo $total_credit;?></th>
			</tr>
		</table>
	</div>
