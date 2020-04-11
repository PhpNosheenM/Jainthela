<style>

</style>
<div style="background-color:#FFF">
<table class="table table-condensed " width="100%">
	<thead>
		<tr>
			<th>Sr. No.</th>
			<th>Transaction Date</th>
			<th>Challan No.</th>
			<th>In</th>
			<th>Out</th>
			<th style="text-align:right;">Unit Rate</th>
		</tr>
	</thead>
	<tbody>

		<?php $page_no=0; 
		 foreach ($itemLedgers as $itemLedger): 
		 
		
		 
		$rate = $itemLedger->rate;
		$in_out_type=$itemLedger->status;
		
		?>
		<tr>
			
			<td><?= h(++$page_no) ?></td>
			<td>
			<?= h(date("d-m-Y",strtotime(@$itemLedger->invoice->transaction_date))) ?>
			</td>
			<td>
				<?php $challan_id = $EncryptingDecrypting->encryptData(@$itemLedger->invoice->challan_id); ?>
				<?php echo $this->Html->link(@$itemLedger->invoice->challan->invoice_no,['controller'=>'Challans','action' => 'challanView', $challan_id, 'print'],['target'=>'_blank']); ?>
			</td>
			
			<td></td>
			<td><?php echo $itemLedger->quantity; ?></td>
			<td align="right"><?php echo $this->Number->format($rate,['places'=>2]); ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
</div>
