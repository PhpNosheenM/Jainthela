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
	font-family:Lato !important;
}
</style>

<style type="text/css" media="print">
@page {
    size: auto;   /* auto is the initial value */
    margin: 0px 0px 0px 0px;  /* this affects the margin in the printer settings */
}
</style>
<?php $this->set('title', 'View'); ?>
	<div style="background-color: #FFF;padding:10px;width: 100%;font-size:14px;" class="maindiv">	
		<?php
		if(empty($print))
		{
			echo $this->Html->link('Print',['controller'=>'Orders','action'=>'view',$ids,'print'],['escape'=>false,'class'=>'btn  blue hidden-print fa fa-print','target'=>'_blank',]);
		}
		else
		{
			echo $this->Html->link('Print',array(),['escape'=>false,'class'=>'btn  blue hidden-print fa fa-print','onclick'=>'javascript:window.print();']);
		}
			echo $this->Html->link('Close',array(),['escape'=>false,'class'=>'btn  red hidden-print fa fa-remove pull-right','onclick'=>'javascript:window.close();']);
		?>
		
		<div class="col-md-12" >
			<div class="col-md-4">
				<?php echo $this->Html->image('/img/jain.png', ['height' => '150', 'width'=>'100px', 'class'=>'img-rounded img-responsive']); ?>
			</div>
			<div class="col-md-5" align="center" style="color:#337AB7; font-size: 14px;font-weight: bold;">
				<div align="center" style="color:#337AB7; font-size: 25px;font-weight: bold;">
					<?= h($company_details->firm_name) ?>
				</div>
				(<?= h($company_details->firm_address) ?>), Pincode:-<?= h($company_details->firm_pincode) ?><br>
				Contact Number: - <?= h($company_details->firm_contact) ?> ,Email: - <?= h($company_details->firm_email) ?><br>
				GSTIN Number:- <?= h($company_details->gstin) ?>
			</div>
		</div>
		 <div class="col-md-12" >
			<div class="col-md-1">
			</div>
			<div class="col-md-11"  align="center" style="color:#F98630; font-size: 16px;font-weight: bold;">
				Quatation
			</div>
		</div>
	<div style="border:solid 2px #F98630; margin-bottom:0px;"></div>
		<table width="100%">
			<tbody>
				<tr style="background-color:#fff; color:#000;">
					<td align="left" colspan="5">
						<b>
							Customer : <?= $sales_orders->customer->name ?> 
							(<?= h($sales_orders->customer->username) ?>)
							
						</b>
					</td>
				</tr>
				<?php
				foreach($sales_orders->customer->customer_addresses as $address_data){
					@$default_address=$address_data->default_address;
					 
					 if($default_address==1){
					@$receiver_name=$address_data->receiver_name;
					@$mobile_no=$address_data->mobile_no;
					@$receiver_name=$address_data->receiver_name;
					@$house_no=$address_data->house_no;
					@$landmark=$address_data->landmark;
					@$address=$address_data->address;
					@$pincode=$address_data->pincode;
					 }
				}
				?>
				<tr style="background-color:#fff; color:#000;">
					<td align="left" colspan="5">
					<b>Receiver: </b><?= h(ucwords(@$receiver_name)) ?><br>
					<b>Address: </b><?php echo $house_no.'-'.$address; ?><br>
					<?php echo $landmark.', '.$pincode ?> &nbsp;
					<br/>
					<b>Mobile:</b> <?= h(@$mobile_no) ?>
					</td>
				</tr>
			</table>
			<table width="100%" border="1">
				<thead>
				<tr style="background-color:#F98630; color:#fff;">
					<th rowspan="2" style="text-align:right;">#</th>
					<th rowspan="2" style="text-align:left;">Item Name</th>
					<th rowspan="2" width="50px" style="text-align:center;">QTY</th>
					<th rowspan="2" width="50px" style="text-align:center;">Rate</th>
					<th rowspan="2" width="50px" style="text-align:center;">Amount</th>
					
				</tr>
				
				</thead>
				
				<?php
				foreach($sales_orders->sales_order_rows as $order_detail ){ 
					@$i++;
					$quantity=$order_detail->quantity;
					$discount_percent=$order_detail->discount_percent;
					$discount_amount=$order_detail->discount_amount;
					$promo_percent=$order_detail->promo_percent;
					$promo_amount=$order_detail->promo_amount;
					$gst_percentage=$order_detail->gst_percentage;
					$gst_value=$order_detail->gst_value;
					$net_amount=$order_detail->net_amount;
					$taxable_value=$order_detail->taxable_value;
					$actual_quantity=$order_detail->actual_quantity;
					$image=$order_detail->item_variation->item_variation_master->item_image;
					$item_name=$order_detail->item_variation->item->name;
					$alise_name=$order_detail->item_variation->item->alias_name;
					$unit_name=$order_detail->item_variation->unit_variation->unit->shortname;
					$quantity_variation=$order_detail->item_variation->unit_variation->visible_variation;
					
					$sales_rate=$order_detail->rate;
					$show_quantity=$quantity;
					if(!empty($actual_quantity)){
					$show_actual_quantity=$actual_quantity.' '.$unit_name;
					}
					else{
					$show_actual_quantity='-';
					}
					$dumy_amount=$show_quantity*$sales_rate;
					$amount=$order_detail->amount;
					@$total_rate+=$amount;
					if(!empty($alise_name)){
						$show_item=$item_name.' ('.$alise_name.') '.$quantity_variation;
					}else{
						$show_item=$item_name.' ('.$alise_name.') '.$quantity_variation;
					} ?>
				<tr style="background-color:#fff;">
					<td align="right"><?= $i ?></td>
					
					<td style="text-align:left;"><?= h($show_item) ?></td>
					<td style="text-align:center;"><?= h($show_quantity) ?></td>
					<td style="text-align:center;"><?= h($sales_rate) ?></td>
					<td style="text-align:center;"><?= h($dumy_amount) ?></td>
					
				</tr>
				<?php } ?>
				<?php
				$amount_from_promo_code=$sales_orders->amount_from_promo_code;
				$delivery_charge=$sales_orders->delivery_charge_amount;
				$amount_from_jain_cash=$sales_orders->amount_from_jain_cash;
				$online_amount=$sales_orders->online_amount;
				$amount_from_wallet=$sales_orders->amount_from_wallet;
				$pay_amount=$sales_orders->pay_amount;
				$status=$sales_orders->status;
				$grand_total=@$total_rate+$delivery_charge;
				$discount_per=$sales_orders->discount_percent;
				?>
				
				<?php if(!empty($discount_per)){ ?>
				<tr style="background-color:#fff; border-top:1px solid #000">
					<td colspan="12">&nbsp;</td>
					<td align="center"><b>Discount</b></td>
					<td align="center"><b><?= h($discount_per) ?><?php echo '%'; ?></b></td>
				</tr>
				<?php } ?>
				
				<tr style="background-color:#F5F5F5; border-top:1px solid #000; border-bottom:1px solid #000">
					<td colspan="4">&nbsp;Total Amount</b></td>
					<td align="center"><b><?= h(@$sales_orders->pay_amount) ?></b></td>
				</tr>
			
				
				 
				
				
				<?php if(!empty($amount_from_jain_cash)){ ?>
				<tr style="background-color:#fff; border-top:1px solid #000">
					<td colspan="12">&nbsp;</td>
					<td align="center"><b>Jain Cash</b></td>
					<td align="center"><b><?= h($amount_from_jain_cash) ?></b></td>
				</tr>
				<?php } ?>
				
				<?php if(!empty($online_amount)){ ?>
				<tr style="background-color:#fff;">
					<td colspan="12">&nbsp;</td>
					<td align="center"><b>Online Payment</b></td>
					<td align="center"><b><?= h($online_amount) ?></b></td>
				</tr>
				<?php } ?>
				
				<?php if(!empty($amount_from_wallet)){ ?>
				<tr style="background-color:#fff;">
					<td colspan="12">&nbsp;</td>
					<td align="center"><b>Payment From Wallet </b></td>
					<td align="center"><b><?= h($amount_from_wallet) ?></b></td>
				</tr>
				<?php } ?>
				
				<?php if(!empty($amount_from_promo_code)){ ?>
				<tr style="background-color:#fff;">
					<td colspan="12">&nbsp;</td>
					<td align="center"><b>Promo code</b></td>
					<td align="center"><b><?= h($amount_from_promo_code)?></b></td>
				</tr>
				<?php } ?>
			 
			</tbody>
			 
		</table>
		
		 <div style="border:solid 2px #F98630; margin-bottom:0px;"></div>
		<fieldset>
			
			<div>
				<p class="MsoNormal" style="mso-margin-top-alt: auto; mso-margin-bottom-alt: auto; text-align: justify; line-height: normal; mso-outline-level: 1;"><strong><span style="font-size: 12.0pt; font-family: 'Times New Roman','serif'; mso-fareast-font-family: 'Times New Roman'; mso-font-kerning: 18.0pt;">Note*</span></strong></p>
				<p class="MsoNormal" style="mso-margin-top-alt: auto; mso-margin-bottom-alt: auto; text-align: justify; line-height: normal; mso-outline-level: 1;"><span style="font-size: 12.0pt; font-family: 'Century','serif'; mso-fareast-font-family: 'Times New Roman'; mso-bidi-font-family: 'Times New Roman'; color: #404040; mso-themecolor: text1; mso-themetint: 191;">.</span></p><p style="text-align: justify; line-height: 115%; background: white; mso-background-themecolor: background1;"><span lang="EN-IN" style="font-family: 'Century','serif'; mso-bidi-font-family: Arial; color: #404040; mso-themecolor: text1; mso-themetint: 191;"><?php echo $sales_orders->order_comment; ?></span></p><p style="text-align: justify; line-height: 55%; background: white; mso-background-themecolor: background1;"></p>
				GST is included.
				</br>
				
				<!--<p class="MsoNormal" style="mso-margin-top-alt: auto; mso-margin-bottom-alt: auto; text-align: justify; line-height: normal; mso-outline-level: 1;"><strong><span style="font-size: 14.0pt; font-family: 'Times New Roman','serif'; mso-fareast-font-family: 'Times New Roman'; mso-font-kerning: 18.0pt;">Return policy</span></strong></p><p class="MsoNormal" style="mso-margin-top-alt: auto; mso-margin-bottom-alt: auto; text-align: justify; line-height: normal; mso-outline-level: 1;"><span style="font-size: 12.0pt; font-family: 'Century','serif'; mso-fareast-font-family: 'Times New Roman'; mso-bidi-font-family: 'Times New Roman'; color: #404040; mso-themecolor: text1; mso-themetint: 191;">.</span></p><p style="text-align: justify; line-height: 115%; background: white; mso-background-themecolor: background1;"><span lang="EN-IN" style="font-family: 'Century','serif'; mso-bidi-font-family: Arial; color: #404040; mso-themecolor: text1; mso-themetint: 191;">Item can be return at the time of delivery..</span></p><p style="text-align: justify; line-height: 115%; background: white; mso-background-themecolor: background1;"></p>-->
			</div>
		</fieldset>
	</div>
