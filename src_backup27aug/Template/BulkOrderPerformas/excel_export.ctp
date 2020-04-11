<?php



	
 	$date= date("d-m-Y"); 
	$time=date('h:i:a',time());
	$filename="Bulk_order".$date.'_'.$time;
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
			<td colspan="3" align="center">Order</td>
		</tr>
		
	<tr>
		<th><?= ('SNo.') ?></th>
		<th><?= ('Item.') ?></th>
		<th ><?= ('Order Quantity') ?></th>
		
	</tr>
	</thead>
	<tbody>
		<?php $i=0; foreach ($bulkOrderPerforma->bulk_order_performa_rows as $data) {?>
			<tr>
				<td><?= $this->Number->format(++$i) ?></td>
				<td><?= h($data->item->name) ?> </td>
				<td></td>
			</tr>
		<?php } ?>
	</tbody>
</table>
				