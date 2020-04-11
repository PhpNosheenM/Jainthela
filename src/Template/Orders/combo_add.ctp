<?php 
foreach($combo_offer_details as $data1){
			
		$merge=$data1->item_variation->item->name.'('.@$data1->item_variation->unit_variation->quantity_variation.'.'.@$data1->item_variation->unit_variation->unit->shortname.')';
		
		$items1[]=['text' => $merge,'value' => $data1->item_variation->id,'item_id'=>$data1->item_variation->item_id,'quantity_factor'=>@$data1->item_variation->unit_variation->convert_unit_qty,'unit'=>@$data1->item_variation->unit_variation->unit->unit_name,'gst_figure_id'=>$data1->gst_figure_id,'gst_value'=>$data1->gst_percentage,'commission'=>@$data1->item_variation->commission,'sale_rate'=>$data1->rate,'current_stock'=>'5','virtual_stock'=>'5','demand_stock'=>'5','discount_applicable'=>'Yes','category_id'=>$data1->item_variation->item->category_id];
?>
		<tr class="combo_tr cmbo_<?php echo $combo_count; ?>">
			<td  valign="top"></td>
			<td  valign="top" class="itemList">
				<?= $this->Form->select('item_variation_id',$items1,['selected','style'=>'','class'=>'form-control item','label'=>false,'readonly']) ?>
				<?= $this->Form->control('item_id',['type'=>'hidden','class'=>'form-control item_id','label'=>false,'readonly','value'=>$data1->item_variation->item_id]); ?>
				
				<?= $this->Form->control('combo_offer_id',['type'=>'hidden','class'=>'form-control cmb_ofr_id','label'=>false,'value'=>$data1->combo_offer_id]) ?>
			</td>
			<td  valign="top">
				<?= $this->Form->control('quantity',['class'=>'form-control quantity','label'=>false,'value'=>$data1->quantity*$combo_qty,'readonly']) ?>
				<span class="itemQty" style="font-size:10px;"></span>
			</td>
			<td valign="top">
				<?= $this->Form->control('rate',['class'=>'form-control rate','label'=>false,'value'=>$data1->rate,'readonly']) ?>
			</td>
			<td valign="top">
				<?= $this->Form->control('amount',['class'=>'form-control amount','label'=>false,'value'=>$data1->taxable_value,'readonly']) ?>
				
			</td>
			<td valign="top">
				<?= $this->Form->control('discount_percent',['class'=>'form-control discount_percent','label'=>false]) ?>
				
			</td>
			<td valign="top">
				<?= $this->Form->control('discount_amount',['class'=>'form-control discount_amount','label'=>false,'readonly']) ?>
				<?= $this->Form->control('txbal',['class'=>'form-control txbal','label'=>false]) ?>
			</td>
			
			<td valign="top">
				<?= $this->Form->control('promo_percent',['class'=>'form-control promo_percent','label'=>false]) ?>
			</td>
			
			<td valign="top">
				<?= $this->Form->control('promo_amount',['class'=>'form-control promo_amount','label'=>false,'readonly']) ?>
			</td>
			
			<td valign="top">
				<?= $this->Form->control('taxable_value',['class'=>'form-control taxable_value','label'=>false,'readonly','value'=>$data1->taxable_value,]) ?>
			</td>
			<td valign="top">
				<?= $this->Form->control('gst_percentage',['class'=>'form-control gst_percentage','label'=>false,'readonly','value'=>$data1->gst_percentage]) ?>
				<?= $this->Form->control('gst_figure_id',['type'=>'hidden','class'=>'form-control gst_figure_id','label'=>false,'readonly','value'=>$data1->gst_figure_id]) ?>
				<span class="gstAmt" style=" text-align:left;font-size:13px;"></span>
			</td>
			<td valign="top">
				<?= $this->Form->control('gst_value',['class'=>'form-control gst_value','label'=>false,'readonly','value'=>$data1->gst_value]) ?>
			</td>
			
			<td valign="top">
				<?= $this->Form->control('net_amount',['class'=>'form-control net_amount','label'=>false,'readonly','value'=>$data1->amount]) ?>
			</td>
			
			<td valign="top"  >
				<a class="btn btn-primary  btn-condensed btn-sm add_row" role="button" ><i class="fa fa-plus"></i></a>
				<a class="btn btn-danger  btn-condensed btn-sm delete_row " role="button" ><i class="fa fa-times"></i></a>
			</td>
		</tr>
		 
<?php
unset($items1);
 } ?>
 