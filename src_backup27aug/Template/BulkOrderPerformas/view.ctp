<style>

@media print{
	.maindiv{
		width:100% !important;
		margin:auto;
	}	
	.hidden-print{
		display:none !important;
	}
	
}

p{
margin-bottom: 0;
}
td {
    border: 1px solid black;
}
</style>
<style type="text/css" media="print">
@page {
	width:100%;
    size: auto;   /* auto is the initial value */
    margin: 20px 20px 20px 20px;  /* this affects the margin in the printer settings */
	
}

.tables > thead > tr > th, .tables > tbody > tr > th, .tables > tfoot > tr > th, .tables > thead > tr > td, .tables > tbody > tr > td, .tables > tfoot > tr > td {
    padding: 5px !important;
	font-size:25px !important;	
}
</style>


<?php
/**
 * @Author: PHP Poets IT Solutions Pvt. Ltd.
 */
$this->set('title', 'Bulk Booking Performa');
?>
<a class="btn  blue hidden-print margin-bottom-5 pull-right" onclick="javascript:window.print();">Print <i class="fa fa-print"></i></a>
<div  class="maindiv" style="border:solid 1px #c7c7c7;background-color: #FFF;padding: 10px;margin: auto;width:50%;font-size: 12px;">	
	
	
	<table width="100%"style="font-size:14px" align="center" class="tables" >
		<thead><tr>
				<th width="10%"> 
					<?php echo $this->Html->image('/img/jain.png', ['height' => '70px', 'width' => '70px']); ?>
				</th>
				<th align="center" width="68%" style="font-size: 12px;"><div align="center" style="font-size: 18px;font-weight: bold;color: #0685a8;">Bulk Booking Performa</div></th>
				
				<th></th>
			</tr>
			<tr>
				<th colspan="3">
				<div style="border:solid 2px #0685a8;margin-bottom:5px;margin-top: 5px;"></div>
				</th>
			</tr>
			<tr>
				<th colspan="2">Customer Name:-</th>
				<th >Date:-</th>
			</tr>
		</thead>
		<tr>
			<th style="border: 1px solid black;" ><?= ('SNo.') ?></th>
			<th  style="border: 1px solid black;"><?= ('Item.') ?></th>
			<th style="border: 1px solid black;" ><?= ('Quantity') ?></th>
		</tr>
		<?php $i=0; foreach ($bulkOrderPerforma->bulk_order_performa_rows as $data) {?>
		<tr>
			<td  ><?= $this->Number->format(++$i) ?></td>
			<td><?= h($data->item->name) ?> (<?php echo $data->item->default_unit->shortname; ?>)</td>
			<td ></td>
		</tr>
	<?php } ?>
		 
		
	</table>
</div>
