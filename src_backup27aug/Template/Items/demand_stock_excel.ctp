<?php	
 	$date= date("d-m-Y"); 
	$time=date('h:i:a',time());
	
	
	$filename="Demand_Stock_On".$date.'_'.$time;
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
			<td colspan="4" align="center">Jain Thela Demanded Stock</td>
		</tr>
		
	<tr>
		<th><?= ('SNo.') ?></th>
		<th><?= ('Item Name.') ?></th>
		<th><?= ('Virtual Stock.') ?></th>
		<th><?= ('Demand Stock.') ?></th>
		
	</tr>
	</thead>
	<tbody>
		<?php $i=0; foreach ($DemandStocks as $key1=>$data) {?>

				<?php $sno = 1;  $total_pending_amt=0;
								foreach ($DemandStocks as $DemandStock): ?>
									
										<tr >
											<td><?php echo $sno++; ?></td>
											<td><?php echo $DemandStock->item->name; ?>( <?php echo $DemandStock->unit_variation->visible_variation; ?>)</td>
											<td><?php echo $DemandStock->virtual_stock; ?></td>
											<td><?php echo $DemandStock->demand_stock; ?></td>
											
										</tr>
							<?php endforeach;   ?>
			
		<?php } ?>
	</tbody>
</table>
				