<?php	
 	$date= date("d-m-Y"); 
	$time=date('h:i:a',time());
	$filename="Fruit_Vegetables_Purchase_On".$date.'_'.$time;
	header ("Expires: 0");
	header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
	header ("Cache-Control: no-cache, must-revalidate");
	header ("Pragma: no-cache");
	header ("Content-type: application/vnd.ms-excel");
	header ("Content-Disposition: attachment; filename=".$filename.".xls");
	header ("Content-Description: Generated Report" ); 
 ?>

<table border="1">
	<thead>
		<tr>
			<td colspan="11" align="center">Jain Thela (Fruit & Vegetables Purchase Detail)</td>
		</tr>
		<tr>
			<td colspan="9">Name of Purchaser:-</td>
			<td colspan="2">Date:-</td>
		</tr>
	<tr>
		<th><?= ('SNo.') ?></th>
		<th><?= ('Tick.') ?></th>
		<th><?= ('Item.') ?></th>
		<th ><?= ('Order Quantity') ?></th>
		<th><?= ('No. Of Order') ?></th>
		<th><?= ('Vendor') ?></th>
		<th><?= ('Purchased Quantity') ?></th>
		<th><?= ('Price') ?></th>
		<th><?= ('Amount') ?></th>
		<th><?= ('Cash/ Cheque') ?></th>
		<th><?= ('Credit') ?></th>
	</tr>
	</thead>
	<tbody>
		<?php $i=0; foreach ($ItemData as $data) {?>
			<tr>
				<td><?= $this->Number->format(++$i) ?></td>
				<td></td>
				<td><?= h($data['name']) ?> (<?php echo $data['unit']; ?>)</td>
				<td align="center"><?= h($data['qt']) ?></td>
				<td align="center"><?= h($data['order']) ?></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
		<?php } ?>
	</tbody>
</table>
				