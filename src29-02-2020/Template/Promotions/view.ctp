<?php $this->set('title', 'Promotions View'); ?>
<style>
@media print{
	.maindiv{
		width:100% !important;
	}
	.hidden-print{
		display:none;
	}
}
p{
margin-bottom: 0;
}
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    padding: 5px !important;
}
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}
</style>
<style type="text/css" media="print">
@page {
    size: auto;   /* auto is the initial value */
    margin: 0 5px 0 20px;  /* this affects the margin in the printer settings */
}
</style>
<a class="btn  blue hidden-print margin-bottom-5 pull-right" onclick="javascript:window.print();">Print <i class="fa fa-print"></i></a>

<div style="border:solid 1px #c7c7c7;background-color: #FFF;padding: 10px;margin: auto;width: 55%;font-size: 12px;" class="maindiv">	
	<table width="100%" class="divHeader">
		
		<tr>
			<td colspan="3"><div style="font-size: 18px" align="center">Promotion Details</div>
				<div style="border:solid 2px #0685a8;margin-bottom:5pxe;margin-top: 5px;"></div>
			</td>
		</tr>
	</table>
	<br>
	<table width="100%">
		<tr>
			<td width="50%" valign="top" align="left">
				<table>
					<tr>
						<td>Offer Name</td>
						<td width="20" align="center">:</td>
						<td><b><?= h($promotions->offer_name) ?><b></td>
					</tr>
					<tr>
						<td>Valid From</td>
						<td width="20" align="center">:</td>
						<td><?= h($promotions->start_date) ?></td>
					</tr>
					<tr>
						<td>Description</td>
						<td width="20" align="center">:</td>
						<td><?= h($promotions->description) ?></td>
					</tr>
				</table>
			</td>
			<td width="50%" valign="top" align="right">
				<table>
					<tr>
						<td>Status</td>
						<td width="20" align="center">:</td>
						<td ><b><?= h($promotions->status) ?></b></td>
					</tr>
					<tr>
						<td>Valid To</td>
						<td width="20" align="center">:</td>
						<td><?= h($promotions->end_date) ?></td>
					</tr>
					<tr>
						<td>Created On</td>
						<td width="20" align="center">:</td>
						<td><?= h($promotions->created_on) ?></td>
					</tr>
				</table>
				
			</td>
			
		</tr>
	</table>
	 
	<br/>
	<table width="100%" class="table" style="font-size:12px" align="center">
		<tr >
			<td ><strong><?= __('S.N.') ?></strong></td>
			<td ><strong><?= __('Customer name') ?></strong></td>
			<td ><strong><?= __('Coupon Code') ?></strong></td>
			<td ><strong><?= __('Category') ?></strong></td>
			<td ><strong><?= __('Item') ?></strong></td>
			<td ><strong><?= __('Dis Per') ?></strong></td>
			<td ><strong><?= __('Dis Amount') ?></strong></td>
			<!-- <td ><strong><?= __('Max Order Value') ?></strong></td> -->
			<td ><strong><?= __('Free Shipping') ?></strong></td>
			<td ><strong><?= __('Status') ?></strong></td>
			
		</tr>
		
		<?php 
		$i=0;
		$total=0;
		foreach ($promotions->promotion_details as $data){ 
			
			@$coupon_code=$data->coupon_code;
			@$category_name=$data->category->name;
			@$item_name=$data->item->name;
			@$discount_in_percentage=$data->discount_in_percentage;
			@$discount_in_amount=$data->discount_in_amount;
			@$discount_of_max_amount=$data->discount_of_max_amount;
			@$cash_back=$data->cash_back;
			@$is_free_shipping=$data->is_free_shipping;
			?>
			<tr>
			<td ><?=h(++$i)?></td>
			<td ><?=h(@$data->orders[0]->customer->name) ?></td>
			<td ><?=h($coupon_code) ?></td>
			<td ><?=h($category_name)?></td>
			<td ><?=h($item_name)?></td>
			<td > <?php if(!empty($discount_in_percentage)) { ?>  <?=h($discount_in_percentage)?> %  <?php } ?> </td>
			<td ><?=h($discount_in_amount)?></td>
			<!-- <td ><?=h($discount_of_max_amount)?></td> -->
			<td ><?=h($is_free_shipping)?></td>
			<td ><?php  if($data->status == 'Active') { echo 'Unused'; } else { echo 'Used'; }  ?></td>
			
			</tr>
		<?php } ?>
	</table>
	<div style="border:solid 1px ;"></div>
	<table width="100%" >
		</table>
	<table width="100%" class="divFooter">
		
			 <tr align="right">
			 <td align="right" valign="top" width="35%">
				<table style="margin-top:3px;">
					<tr>
					   <td width="15%" align="right"> 
						<br>
						<br>
						 <span>Prepared By</span><br/>
						 <span><b><?= __('Jain Thela') ?></b></span><br/>
						</td>
					</tr>
				</table>
			 </td>
			
		    
		</tr>
	</table>
</div>
</div>
