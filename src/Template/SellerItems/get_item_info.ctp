<div class="item_variation">
			<div class="">
				<h4 class="panel-title" style="width: 100%;">
					<input type="checkbox" class="check_all_item" value="<?php echo $item->id; ?>" >
					<a href="#itemshow<?php echo $item->id; ?>">
						<?php echo $item->name; ?>
					</a>
				</h4>
			</div>
	<?php
	$status[] = ['value'=>'No','text'=>'No'];
	$status[] = ['value'=>'Yes','text'=>'Yes'];
	?>
<div class="panel-body" id="itemshow<?php $item->id; ?>" style="padding: 0px !important;;padding-right: 1% !important;" ><div style="overflow:scroll;"><div class="table-responsive">
	<table class="table table-bordered main_tbl" >
	<thead>
	<tr>
		<th></th>
		<th>Maximum Quantity Purchase</th>
		<th>Current Stock</th>
		<th>Add Stock</th>
		<th>MRP</th>
		<th>Sales Rate</th>
		<th>Read To Sale</th>
	</tr>
	</thead>
	<tbody>
	<?php 
	foreach($item->item_variation_masters as $item_variation_master)
	{  
		if(!empty($item_variation_master->item_variations[0]))
		{
			$chk="checked";$disabled=''; $style='display:none;'; $v_class='no_edit';
		}
		else
		{
			$chk="";$disabled='disabled';$style=''; $v_class='';
		}
	?>
		<tr>
		<td style="width:10%">
		<input name="<?php echo $item_variation_master->id;?>[item_id]" type="checkbox"  value="<?php echo $item->id; ?>" class="entity_variation entity_variation<?php echo $item_variation_master->unit_variation->id;  echo ' '; echo $v_class; ?>"  style="display:none;" <?php echo $chk; ?>>

		<input name="<?php echo $item_variation_master->id;?>[item_variation_master_id]" type="textbox"  value="<?php echo $item_variation_master->id;?>" class="entity_maximum entity_maximum<?php echo $item_variation_master->unit_variation->id;?>" <?php echo $disabled; ?> style="display:none;" >
		<?php 
		if($style=='')
		{
			$class='single_item variation'.$item['id'];
		}else{$class='';} ?>
		
		<label style="margin-left:30px;"><input name="<?php echo $item_variation_master->id;?>[unit_variation_id]" type="checkbox"   value="<?php echo $item_variation_master->unit_variation->id;?>" class="<?php echo $class; ?>" <?php echo $disabled; echo $chk;?> style="<?php echo $style;?>">&nbsp;&nbsp;<?php echo $item_variation_master->unit_variation->quantity_variation;?><?php echo $item_variation_master->unit_variation->unit->longname;?></label>
		</td><td style="width:20%">
		<?php 
		echo $this->Form->control($item_variation_master->id.'[maximum_quantity_purchase]', ['templates' => ['inputContainer'=>'{{content}}'],'label' => false,'type'=>'text','placeholder'=>'Maximum Quantity Purchase','class'=>'form-control entity_maximum entity_maximum'.$item_variation_master->unit_variation->id,'style'=>'display:inline !important;float:none;',$disabled,'value'=>@$item_variation_master->item_variations[0]->maximum_quantity_purchase,'required']);
		?>
		</td><td style="width:10%">
		<?php echo $this->Form->control($item_variation_master->id.'[current_stock]', ['templates' => ['inputContainer'=>'{{content}}'],'label' => false,'type'=>'text','placeholder'=>'Current Stock','class'=>'form-control cStock  entity_maximum entity_maximum'.$item_variation_master->unit_variation->id,'style'=>'display:inline !important;float:none;',$disabled,'value'=>@$item_variation_master->item_variations[0]->current_stock,'required','readonly']);?>
		<input type="hidden" value="<?php echo @$item_variation_master->item_variations[0]->current_stock;?>" id="chstock">
		</td><td style="width:10%">
		<?php echo $this->Form->control($item_variation_master->id.'[add_stock]', ['templates' => ['inputContainer'=>'{{content}}'],'label' => false,'type'=>'text','placeholder'=>'Add Stock','class'=>'form-control addStock entity_maximum entity_maximum'.$item_variation_master->unit_variation->id,'style'=>'display:inline !important;float:none;',$disabled,'value'=>@$item_variation_master->item_variations[0]->add_stock]); ?>
		</td><td style="width:12%">
		<?php echo $this->Form->control($item_variation_master->id.'[mrp]', ['templates' => ['inputContainer'=>'{{content}}'],'label' => false,'type'=>'text','placeholder'=>'MRP','class'=>'form-control mrp calc entity_maximum entity_maximum'.$item_variation_master->unit_variation->id,'style'=>'display:inline !important;float:none;',$disabled,'value'=>@$item_variation_master->item_variations[0]->mrp,'required']); ?>
		</td><td style="width:13%">
		<?php 
		echo $this->Form->control($item_variation_master->id.'[sales_rate]', ['templates' => ['inputContainer'=>'{{content}}'],'label' => false,'type'=>'text','placeholder'=>'Sales Rate','class'=>'form-control sales_rate  entity_maximum entity_maximum'.$item_variation_master->unit_variation->id,'style'=>'display:inline !important;float:none;',$disabled,'value'=>@$item_variation_master->item_variations[0]->sales_rate,'required']);
		?>
		<input name="<?php echo $item_variation_master->id;?>[commissions]" type="hidden"  value="<?php echo @$item->seller_items[0]->commission_percentage; ?>" class="entity_maximum entity_maximum<?php echo $item_variation_master->unit_variation->id; ?>" id="commission">
		<?php 
		echo $this->Form->control($item_variation_master->id.'[purchase_rate]', ['templates' => ['inputContainer'=>'{{content}}'],'label' => false,'type'=>'hidden','placeholder'=>'Rate','class'=>'form-control entity_maximum  purchase_rate entity_maximum '.$item_variation_master['unit_variation']['id'],'style'=>'float:none;',$disabled,'value'=>@$item_variation_master->item_variations[0]->purchase_rate]);
		?>
		</td><td style="width:15%">
		<?= $this->Form->select($item_variation_master['id'].'[ready_to_sale]',$status,['empty'=>'---Select--','class'=>'form-control entity_maximum entity_maximum'.$item_variation_master['unit_variation']['id'],'label'=>false,$disabled,'style'=>'display:inline !important;float:none;','placeholder'=>'Select...','value'=>@$item_variation_master->item_variations[0]->ready_to_sale,'style'=>'display:inline !important;float:none;']) ?>
		</td>
		</tr>
	<?php } ?>
	</tbody></table>
	</div>
	</div>