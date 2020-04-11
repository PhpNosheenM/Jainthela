<style>

</style>
<div style="background-color:#FFF">
<table class="table table-condensed " width="100%">
	<thead>
		<tr>
			<th>Sr. No.</th>
			<th>Transaction Date</th>
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
			<?= h(date("d-m-Y",strtotime(@$itemLedger->transaction_date))) ?>
			</td>
			
			<td><?php if($in_out_type=='In'){ echo $itemLedger->quantity; } else { echo '-'; } ?></td>
			<td><?php if($in_out_type=='Out'){ echo $itemLedger->quantity; } else { echo '-'; } ?></td>
			<td align="right"><?php echo $this->Number->format($rate,['places'=>2]); ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
</div>
