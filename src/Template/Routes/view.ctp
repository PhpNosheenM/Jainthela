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
</style>
<style type="text/css" media="print">
@page {
    size: auto;   /* auto is the initial value */
    margin: 0 5px 0 20px;  /* this affects the margin in the printer settings */
}
</style>
<?php $this->set('title', 'Routes'); ?>

<a class="btn  blue hidden-print margin-bottom-5 pull-right" onclick="javascript:window.print();">Print <i class="fa fa-print"></i></a>

<div style="border:solid 1px #c7c7c7;background-color: #FFF;padding: 10px;margin: auto;width: 55%;font-size: 12px;" class="maindiv">	
	<table width="100%" class="divHeader">
		
		<tr>
			<td colspan="3"><div style="font-size: 18px" align="center">Route Details</div>
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
						<td>Route Name</td>
						<td width="20" align="center">:</td>
						<td><b><?= h($routes->name) ?><b></td>
					</tr>
					<tr>
						<td>Location</td>
						<td width="20" align="center">:</td>
						<td><?= h($routes->location->name) ?></td>
					</tr>
					<tr>
						<td>Description</td>
						<td width="20" align="center">:</td>
						<td colspan="4"><?= h($routes->narration) ?> </td>
					</tr>
				</table>
			</td>
			<td width="50%" valign="top" align="right">
				<table>
					<tr>
						<td>City</td>
						<td width="20" align="center">:</td>
						 <td><?= h($routes->city->name) ?></td>
					</tr>
			
					<tr>
						<td>Created On</td>
						<td width="20" align="center">:</td>
						<td ><?= h($routes->created_on) ?> </td>
					</tr>
				</table>
				
			</td>
			
		</tr>
	</table>
	 
	<br/>
	<table width="100%" class="table" style="font-size:12px" align="center">
		<tr >
			<td ><strong><?= __('S.N.') ?></strong></td>
			<td ><strong><?= __('Landmark') ?></strong></td>
			<td ><strong><?= __('Priority') ?></strong></td>
			<td ><strong><?= __('Status') ?></strong></td>
		</tr>
		
		<?php 
		$i=0;
		$total=0;
		foreach ($routes->route_details as $data){
			 
			//$show_item=$item_name.' ('.$alise_name.') -'.$quantity_variation.$unit_name;
			?>
			
			<tr>
			<td ><?=h(++$i)?></td>
			<td ><?=h($data->landmark->name) ?></td>
			<td ><?=h($data->priority)?></td>
			<td ><?=h($data->status)?></td>
			
			</tr>
		<?php
		 
		} ?>
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
