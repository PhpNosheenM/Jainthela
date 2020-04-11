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
$this->set('title', 'Payment Voucher');
?>
<div  class="maindiv" style="border:solid 1px #c7c7c7;background-color: #FFF;padding: 10px;margin: auto;width:75%;font-size: 12px;">	
	<table width="100%" class="divHeader">
		<tbody>
			<tr>
				<td width="30%">
					<?php echo $this->Html->image('/img/jain.png', ['height' => '70px', 'width' => '70px']); ?>
				</td>
				<td align="center" width="40%" style="font-size: 12px;"><div align="center" style="font-size: 18px;font-weight: bold;color: #0685a8;"> DEBIT NOTE VOUCHER </div></td>
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
						<td><?= h(str_pad($debitNote->voucher_no, 4, '0', STR_PAD_LEFT)) ?></td>
					</tr>
				</table>
			</td>
			<td width="50%" valign="top" align="right">
				<table>
					<tr>
						<td>Transaction Date</td>
						<td width="20" align="center">:</td>
						<td><?= h(date("d-m-Y",strtotime($debitNote->transaction_date))) ?></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
		Narration: <?php echo $debitNote->narration;?>
		<br/><br/>
		<table width="100%" class="table" style="font-size:12px">
			<tr style="background-color:#F0EFED;">
				<th colspan="3"><?= __('Ledger A/C') ?></th>
				<th><?= __('Dr') ?></th>
				<th><?= __('Cr') ?></th>
			</tr>
			<?php foreach($debitNote->debit_note_rows as $debit_note_row)
				{ 
					@$total_debit+=$debit_note_row->debit;
					@$total_credit+=$debit_note_row->credit; ?>
					<tr>
					<td colspan="3" style="text-align:left"><b><?= $debit_note_row->ledger->name ?>
					
					<?php if($debit_note_row->mode_of_payment=='Cheque'){  
						echo '( Cheque no-'.$debit_note_row->cheque_no.', Date '.date('d-M-Y', strtotime($debit_note_row->cheque_date)).')';
					} ?>
					</b>
						<div class="window" style="margin:auto;"><table width="50%">
							<?php foreach($debit_note_row->reference_details as $refdata)
							{?><tr>
							
							<td style="text-align:left"><?=$refdata->type?></td>
							<td style="text-align:left"><?=$refdata->ref_name?></td>
							<?php if($refdata->debit){ ?>
							<td class="rightAligntextClass"><?=$refdata->debit?> Dr</td><?php } else {?>
							<td class="rightAligntextClass"><?=$refdata->credit?> Cr</td><?php } ?></tr>
							<?php } ?></table>
						</div>
					</td>
					<td ><?=$debit_note_row->debit?></td>
					<td><?=$debit_note_row->credit?></td>
					</tr>
			<?php } ?>
			 
			 
			<tr>
				<td colspan="5">
					<div style="border:solid 1px #0685a8;"></div>
				</td>
			</tr>
			<tr>
			<td colspan="3" align="right"></td>
			
			<th> <?php echo $total_debit;?></th>
			<th> <?php echo $total_credit;?></th>
			</tr>
		</table>
	</div>
