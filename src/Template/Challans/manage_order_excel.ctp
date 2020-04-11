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
<?php $this->set('title', 'Generate Bill');     ?><!-- PAGE CONTENT WRAPPER -->

						<table class="table-bordered" width="100%">
							<thead>
								<tr height="40px">
									<th><?= ('SNo.') ?></th>
									<?php if($user_type != "Seller"){ ?>
									<th><?= ('Order No') ?></th>
									<?php } ?>
									<th><?= ('Challan No') ?></th>
									<th><?= ('Customer Name') ?></th>
									<th><?= ('Customer Address') ?></th>
									<th><?= ('Locality') ?></th>
									<th><?= ('Location') ?></th>
									<th><?= ('Grand Total') ?></th>
									<th><?= ('Order Type') ?></th>
									<th><?= ('Order Date') ?></th>
									<th><?= ('Seller') ?></th>
									<th><?= ('Status') ?></th>
									<th><?= ('Challan Type') ?></th>
									
									
								</tr>
							</thead>
							<tbody>
								<?php $i = $paginate_limit*($this->Paginator->counter('{{page}}')-1); ?>
								<?php 
								
										if(!empty($orders->toArray()))
										{
											foreach ($orders as $order)
											{
												if($order->order_status == 'placed')
												{
													foreach($order->challan_rows as $orderData)
													{ //pr($AllCategories); pr($orderData->item->category_id); exit;
														if($order->seller_id==3)
														{
															$order->BgColor = 'style="background: green;color: white;"';
															$order->anchorColor =  'style="color : white !important;"';
														}else
														{
															$order->BgColor = '';
															$order->anchorColor =  'style="color : #337ab7 !important;"';
														}
														 
													}	
												}else {
															$order->BgColor = '';
															$order->anchorColor =  '';
												}
															
											}			
										}
								
								//pr($orders); exit; 
								$totalchall=$TotalChallans;
								?>
								  <?php 
									
								  foreach ($orders as $order): //pr($order->order->order_no); exit; 
								  if(!empty($order->order->order_comment)){ 
										$cmtColr='style="background: #de6b80;color: white;"';
									}else{
										@$cmtColr='style="background: white;color: black;"';
									}
								  $order_date=$order->transaction_date;
								  $delivery_date=$order->delivery_date;
								  @$time_from=$order->delivery_time->time_from;
								  @$time_to=$order->delivery_time->time_to;
								  $delivery_time=$time_from.'-'.$time_to;
								  $tdColor = '';
								  if($order->order_status == 'placed')
								  {
									 $tdColor = 'style = "background-color: yellow;color: black;"'; 
								  }
								  if($order->order_status == 'Packed')
								  {
									 $tdColor = 'style = "background-color: #264e26;color: white;"'; 
								  }
								  if($order->order_status == 'Dispatched')
								  {
									$tdColor = 'style = "background-color: red;color: white; "'; 
								  }
								  ?>
								<tr height="40px" <?php echo $order->BgColor; ?> >
									<td style="background: white;color: black;"><?= $this->Number->format(++$i) ?></td>
									<?php if($user_type != "Seller"){ ?>
									<?php if($TotalChallans[$order->order->id] >= 1){ ?>
									<td <?php echo $cmtColr; ?>rowspan="<?php echo $TotalChallans[$order->order->id]; ?>"><?= h($order->order->order_no) ?></td>
									<?php $TotalChallans[$order->order->id]=0; } ?>
									<?php } ?>
									
									<td  >
										<?php 
										$challan_id=$order->id;
										$ordr_id=$order->id;
										$cus_id=$order->customer_id;
										//pr($order->id);
										$order_id = $EncryptingDecrypting->encryptData($order->id); 
										//pr($order_id); exit;
										$customer_id = $EncryptingDecrypting->encryptData($order->customer->id);
										$challan_id_enc = $EncryptingDecrypting->encryptData($challan_id); 
										?>
										<?php echo $order->invoice_no; ?>
									</td>
									<td>&nbsp;
									<?php if($user_type != "Seller"){ ?>
										<?php echo @$order->customer->name.' ('.$order->customer->username.')'; ?>
									<?php } else { ?>
										<?php echo @$order->customer->name; ?>
									<?php } ?>
									</td>
									<td><?= h(@$order->customer_addresses_left->house_no)?> <?= h(@$order->customer_addresses_left->landmark_name)?> <?= h(@$order->customer_addresses_left->address)?></td>
									<td><?= h(@$order->customer_addresses_left->landmark->name) ?></td>
									<td><?= h($order->location->name) ?></td>
									<td><?= h($order->pay_amount) ?></td>
									<td><?= h($order->order_type) ?></td>
									<td><?= h($order_date) ?></td>
									<td><?= h($order->seller_name) ?></td>
									<td <?php echo $tdColor; ?>><?= h($order->order_status) ?></td>
									
									<td><?php 
									if($totalchall[$order->order->id]>1){
										echo"Vegetable/Grocery";
									}else{
										if($order->seller_id==3)
											{ echo"Vegetable";
											}else{
												echo"Grocery";
											}
									}
										?></td>
									
										
									
								</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					