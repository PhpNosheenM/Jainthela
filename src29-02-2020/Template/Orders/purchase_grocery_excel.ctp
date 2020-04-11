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
<?php $totSize=sizeof($unit_variation_datas);
$totSize=$totSize+9;
 ?>
<table border="1">
	<thead>
		<tr>
			<td colspan="<?php echo $totSize+2; ?>" align="center">Jain Thela (Fruit & Vegetables Purchase Detail)</td>
		</tr>
		<tr>
			<td colspan="<?php echo $totSize; ?>">Name of Purchaser:-</td>
			<td colspan="2">Date:-</td>
		</tr>
	<tr>
		<th><?= ('SNo.') ?></th>
		<th><?= ('Tick.') ?></th>
		<th><?= ('Item.') ?></th>
		<?php foreach($unit_variation_datas as $key=>$unit_variation_data){ ?>
			<th><?= $unit_variation_names[$unit_variation_data] ?></th>
		<?php } ?>
		<th><?= ('Total Qty') ?></th>
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
		<?php $i=0; foreach($QRdata as $item_id=>$row){ ?>
			<tr>
				<td><?= $this->Number->format(++$i) ?></td>
				<td></td>
				<td><?php echo $QRitemName[$item_id]; ?></td>
				<?php foreach($unit_variation_datas as $unit_variation_data){ ?>
					<td><?php echo @$row[$unit_variation_data]; ?></td>
				<?php } ?>
									
				<td><?php echo $OrderItemCount[$item_id]; ?></td>
				<td><?php echo count($OrderCount[$item_id]); ?></td>
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
				