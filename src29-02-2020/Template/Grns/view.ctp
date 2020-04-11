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
    margin: 0px 30px 0px 0px;  /* this affects the margin in the printer settings */
}
.maindiv {
border:solid 1px #c7c7c7;background-color: #FFF;padding: 10px;margin: auto;width: 100%;font-size: 12px;
}
</style>


<?php
/**
 * @Author: PHP Poets IT Solutions Pvt. Ltd.
 */
$this->set('title', 'Grns');
?>
<div  class="maindiv" style="border:solid 1px #c7c7c7;background-color: #FFF;padding: 10px;margin: auto;width:65%;font-size: 12px;">	
	<table width="100%" class="divHeader">
		<tbody><tr>
				<td width="30%"> 
					<?php echo $this->Html->image('/img/jain.png', ['height' => '70px', 'width' => '70px']); ?>
				</td>
				<td align="center" width="40%" style="font-size: 12px;"><div align="center" style="font-size: 18px;font-weight: bold;color: #0685a8;"> Goods Recipt Note </div></td>
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
						<td><?= h(str_pad($grn->voucher_no, 4, '0', STR_PAD_LEFT)) ?></td>
						
					</tr>
					<tr>
						<td>Vendor</td>
						<td width="20" align="center">:</td>
						<td><?= $grn->vendor_ledger->name ?></td>
					</tr>
					
				</table>
			</td>
			<td width="50%" valign="top" align="right">
				<table>
					<tr>
						<td>Transaction Date</td>
						<td width="20" align="center">:</td>
						<td><?= $grn->transaction_date ?></td>
					</tr>
					
				</table>
			</td>
		</tr>
	</table>
	</br>
		
		<table width="100%" class="table" style="font-size:12px" >
			<tr style="background-color:#F0EFED;" border="1">
				<th><?= __('Sr.No') ?></th>
				<th><?= __('Items') ?></th>
				<th><?= __('Quantity') ?></th>
				<th><?= __('Rate') ?></th>
				<th><?= __('Taxable Value') ?></th>
				<th><?= __('GST Value') ?></th>
				<th><?= __('Net Amount') ?></th>
			</tr>
			<?php $total_amt=0; foreach($grn->grn_rows as $data){ 	
				@$k++;
				//$visible_variation=$purchase_invoice_row->item->name.' '.$data->unit_variation->visible_variation;
				//$merge=$visible_variation;
				$total_amt+=$data->net_amount;
			 ?>
			<tr>
				<td><?= $k ?></td>
				<td style="text-align:left"><b><?php echo $data->item->name.' '.$data->unit_variation->visible_variation ?></td>
				<td><?=$data->quantity?></td>
				<td><?=$data->rate?></td>
				<td><?=$data->taxable_value?></td>
				<td><?=$data->gst_value?></td>
				<td><?=$data->net_amount?></td>
			</tr>
			<?php } ?>
			  <tr>
				<td colspan="6" align="right">Total</td>
				<td><?=$total_amt?></td>
			  </tr>
		</table>
	</div>
