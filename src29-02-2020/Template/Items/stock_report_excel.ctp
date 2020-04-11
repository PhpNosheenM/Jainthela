<?php	
 	 $date= date("d-m-Y"); 
	$time=date('h:i:a',time());
	$filename="Stock_report_On".$date.'_'.$time;
	header ("Expires: 0");
	header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
	header ("Cache-Control: no-cache, must-revalidate");
	header ("Pragma: no-cache");
	header ("Content-type: application/vnd.ms-excel");
	header ("Content-Disposition: attachment; filename=".$filename.".xls");
	header ("Content-Description: Generated Report" );   
 ?>
<?php if(empty($location_id)){ ?>
				
						<table class="table table-bordered">
							<thead>
								<tr>
									<th><?= ('SNo.') ?></th>
									<th><?= ('Item Name') ?></th>
									<th><?= ('MRP') ?></th>
									<th><?= ('Variation Name') ?></th>
									<th><?= ('Closing Stock') ?></th>
									<th><?= ('Unit rate') ?></th>
									<th><?= ('Amount') ?></th>
								</tr>
							</thead>
							<tbody>                                            
								<?php $i = 0; $total_amt=0; ?>
								
								   <?php foreach($showItems as $showItem){ 
								   $item_var_size=(sizeof($showItem));
									//$amt=$showItem['stock']*$showItem['unit_rate'];
									//$total_amt+=$amt;
									$rt=round(($showItem['amount']/$showItem['stock']),2);
								   ?>
								<tr>
									<td ><?= $this->Number->format(++$i) ?></td>
									<td><?php echo ($showItem['item_name']); ?></td>
									<td><?php echo ($showItem['mrp']); ?></td>
									<td><?php echo ($showItem['var_name']); ?></td>
									<td><?php echo ($showItem['stock']); ?></td>
									<td><?php echo ($rt); ?></td>
									<td><?php echo ($showItem['amount']); ?></td>
									
								</tr>
								<?php @$total_amt+=@$showItem['amount']; } ?>
								<tr>
									<td colspan="6" style="text-align:right">Total</td>
									<td><?= h($total_amt) ?></td>
								</tr>
								  
							</tbody>
						</table>
					
				<?php }else{  ?>
			
						<table class="table table-bordered">
							<thead>
								<tr>
									<th><?= ('SNo.') ?></th>
									<th><?= ('Item Name') ?></th>
									<th><?= ('MRP') ?></th>
									<th><?= ('Variation Name') ?></th>
									<th><?= ('Closing Stock') ?></th>
									<th><?= ('Unit rate') ?></th>
									<th><?= ('Amount') ?></th>
								</tr>
							</thead>
							<tbody>                                            
								<?php $i = 0; $total_amt=0; ?>
								
								   <?php foreach($showItems as $showItem){ 
								   $item_var_size=(sizeof($showItem));
									//$amt=$showItem['stock']*$showItem['unit_rate'];
									//$total_amt+=$amt;
									$rt=round(($showItem['amount']/$showItem['stock']),2);
								   ?>
								<tr>
									<td ><?= $this->Number->format(++$i) ?></td>
									<td><?php echo ($showItem['item_name']); ?></td>
									<td><?php echo ($showItem['mrp']); ?></td>
									<td><?php echo ($showItem['var_name']); ?></td>
									<td><?php echo ($showItem['stock']); ?></td>
									<td><?php echo ($rt); ?></td>
									<td><?php echo ($showItem['amount']); ?></td>
									
								</tr>
								<?php @$total_amt+=@$showItem['amount']; } ?>
								<tr>
									<td colspan="6" style="text-align:right">Total</td>
									<td><?= h($total_amt) ?></td>
								</tr>
								  
							</tbody>
						</table>
				
		<?php } ?>
				