<div class="item_variation">
	 <?php
	$status[] = ['value'=>'No','text'=>'No'];
	$status[] = ['value'=>'Yes','text'=>'Yes'];
	?>
<div class="panel-body" id="itemshow1" style="padding: 0px !important;;padding-right: 1% !important;" >
<div style="overflow:scroll;">
	<div class="table-responsive">
		<table class="table table-bordered main_tbl" >
			<thead>
				<tr>
					<th width="5%">
						<div class="">
							<h4 class="panel-title" style="width: 100%;">
									 
								<input type="checkbox" class="check_all_item"  >
								<a href="#itemshow1">
									 (Check All)
								</a>
							</h4>
						</div>
					</th>
					<th width="15%"> Item Variations</th>
					<th width="10%"> Maximum Quantity Purchase</th>
					<th width="10%"> Current Stock</th>
					<th width="10%"> Add Stock</th>
					<th width="10%"> MRP</th>
					<th width="10%"> Sales Rate</th>
					<th width="10%"> Read To Sale</th>
					
				</tr>
			</thead>
			<tbody>
			<?php 
			$k=0;
			 
			foreach($item as $item_variation_master)
			{  
			if(!empty($item_variation_master->item_variations[0]))
		{
			$chk="checked";$disabled=''; $style='display:none;'; $v_class='no_edit';
		}
		else
		{
			$chk="";$disabled='disabled';$style=''; $v_class='';
		}
			$final_check=0;
			 
			$first_item_id=$item_variation_master->item_id;
			$first_item_variation_master_id=$item_variation_master->id;
			 
			 ?>
				<tr>
					<td style="width:5%" align="center">
						<input type="hidden" name="item_variation_master_id[]" value="<?php echo $item_variation_master->id; ?>" />
						<input type="hidden" name="unit_variation_id[]" value="<?php echo $item_variation_master->unit_variation_id; ?>" />
						<input type="hidden" name="status[]" value="No" class="stst" />
						<input name="test[]" type="checkbox"  value="<?php echo $item_variation_master->item_id; ?>" class="entity_variation st2 entity_variation<?php echo $item_variation_master->unit_variation->id;?>" >
					</td>
					<td align="center">
					<label style="margin-left:30px;">
					  <?php echo $item_variation_master->unit_variation->quantity_variation;?> <?php echo $item_variation_master->unit_variation->unit->longname;?>
					</label>
					</td>
					
					<td style="width:20%">
		<?php 
		echo $this->Form->control('maximum_quantity_purchase[]', ['templates' => ['inputContainer'=>'{{content}}'],'label' => false,'type'=>'text','placeholder'=>'Maximum Quantity Purchase','class'=>'form-control entity_maximum entity_maximum'.$item_variation_master->unit_variation->id,'style'=>'display:inline !important;float:none;',$disabled,'value'=>@$item_variation_master->maximum_quantity_purchase,'required']);
		?>
		</td>
		<td style="width:10%">
		<?php echo $this->Form->control('current_stock[]', ['templates' => ['inputContainer'=>'{{content}}'],'label' => false,'type'=>'text','placeholder'=>'Current Stock','class'=>'form-control cStock  entity_maximum entity_maximum'.$item_variation_master->unit_variation->id,'style'=>'display:inline !important;float:none;',$disabled,'value'=>@$item_variation_master->current_stock,'required','readonly']);?>
		<input type="hidden" value="<?php echo @$item_variation_master->current_stock;?>" id="chstock">
		</td><td style="width:10%">
		<?php echo $this->Form->control('add_stock[]', ['templates' => ['inputContainer'=>'{{content}}'],'label' => false,'type'=>'text','placeholder'=>'Add Stock','class'=>'form-control addStock entity_maximum entity_maximum'.$item_variation_master->unit_variation->id,'style'=>'display:inline !important;float:none;',$disabled,'value'=>@$item_variation_master->add_stock]); ?>
		</td><td style="width:12%">
		<?php echo $this->Form->control('mrp[]', ['templates' => ['inputContainer'=>'{{content}}'],'label' => false,'type'=>'text','placeholder'=>'MRP','class'=>'form-control mrp calc entity_maximum entity_maximum'.$item_variation_master->unit_variation->id,'style'=>'display:inline !important;float:none;',$disabled,'value'=>@$item_variation_master->mrp,'required']); ?>
		</td><td style="width:13%">
		<?php 
		echo $this->Form->control('sales_rate[]', ['templates' => ['inputContainer'=>'{{content}}'],'label' => false,'type'=>'text','placeholder'=>'Sales Rate','class'=>'form-control sales_rate  entity_maximum entity_maximum'.$item_variation_master->unit_variation->id,'style'=>'display:inline !important;float:none;',$disabled,'value'=>@$item_variation_master->sales_rate,'required']);
		?>
		<input name="commissions[]" type="hidden"  value="<?php echo @$item->seller_items[0]->commission_percentage; ?>" class="entity_maximum entity_maximum<?php echo $item_variation_master->unit_variation->id; ?>" id="commission">
		<?php 
		echo $this->Form->control('purchase_rate[]', ['templates' => ['inputContainer'=>'{{content}}'],'label' => false,'type'=>'hidden','placeholder'=>'Rate','class'=>'form-control entity_maximum  purchase_rate entity_maximum '.$item_variation_master['unit_variation']['id'],'style'=>'float:none;',$disabled,'value'=>@$item_variation_master->purchase_rate]);
		?>
		</td><td style="width:15%">
		<?= $this->Form->select('ready_to_sale[]',$status,['empty'=>'---Select--','class'=>'form-control entity_maximum entity_maximum'.$item_variation_master['unit_variation']['id'],'label'=>false,$disabled,'style'=>'display:inline !important;float:none;','placeholder'=>'Select...','value'=>@$item_variation_master->ready_to_sale,'style'=>'display:inline !important;float:none;']) ?>
		</td>
					
				</tr>
			<?php 
					$k++;
				} 
			?>
			</tbody>
		</table>
	</div>
</div>