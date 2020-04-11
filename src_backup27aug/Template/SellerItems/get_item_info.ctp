<div class="item_variation">
	 <?php
	$status[] = ['value'=>'No','text'=>'No'];
	$status[] = ['value'=>'Yes','text'=>'Yes'];
	
	$Itemstatus[] = ['value'=>'Active','text'=>'Active'];
	$Itemstatus[] = ['value'=>'Deactive','text'=>'Deactive'];
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
								
								
							</h4>
						</div>
					</th>
					<th width="5%"> Variations</th>
					<th width="10%"> Maximum Purchase</th>
					<th width="10%"> Virtual Stock</th>
					<th width="10%"> Current Stock</th>
					<th width="5%"> MRP</th>
					<th width="10%"> Print Rate</th>
					<th width="10%"> Discount %</th>
					<th width="10%"> Sales Rate</th>
					<th width="5%"> Out Of Stock</th>
					<th width="10%"> Read To Sale</th>
					<th width="10%"> Status</th>
					
				</tr>
			</thead>
			<tbody>
			<?php 
			$k=0;
			 
			foreach($item->item_variation_masters as $item_variation_master)
			//pr($item_variation_master); exit;
			{  
			if(!empty($item_variation_master->item_variations[0]))
		{
			$chk="checked";$disabled=''; $style='display:none;'; $v_class='no_edit';
			$chk="";$disabled='disabled';$style=''; $v_class='';
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
					<td align="center">
						<input name="<?php echo $item_variation_master->id;?>[item_id]" type="checkbox"  value="<?php echo $item->id; ?>" class="entity_variation entity_variation<?php echo $item_variation_master->unit_variation->id;  ?>"  style="display:none;" <?php echo $chk; ?>>

						<input name="<?php echo $item_variation_master->id;?>[item_variation_master_id]" type="textbox"  value="<?php echo $item_variation_master->id;?>" class="entity_maximum entity_maximum<?php echo $item_variation_master->unit_variation->id;?>" <?php echo $disabled; ?> style="display:none;" >
						
						<input name="<?php echo $item_variation_master->id;?>[unit_variation_id]" type="textbox"  value="<?php echo $item_variation_master->unit_variation->id;?>" class="entity_maximum entity_maximum<?php echo $item_variation_master->unit_variation->id;?>" <?php echo $disabled; ?> style="display:none;" >
						
						<input name="test[]" type="checkbox"  value="<?php echo $item_variation_master->unit_variation->id; ?>" class="entity_variation single_item st2 entity_variation<?php echo $item_variation_master->unit_variation->id;?>" >
					</td>
					<td align="center">
					<label style="margin-left:30px;">
					  <?php echo $item_variation_master->unit_variation->visible_variation; ?>
					</label>
					
					<?php
						//echo $this->Form->control('status[]', ['label' => false,'type'=>'hidden','value'=>'No', 'class'=>'stst']);
						?>
					
			</td>
					
		<td >
		<?php
		echo $this->Form->control($item_variation_master->id.'[maximum_quantity_purchase]', ['templates' => ['inputContainer'=>'{{content}}'],'label' => false,'type'=>'text','placeholder'=>'Maximum Quantity Purchase','class'=>'form-control entity_maximum entity_maximum'.$item_variation_master->unit_variation->id,'style'=>'display:inline !important;float:none;',$disabled,'value'=>@$item_variation_master->item_variations[0]->maximum_quantity_purchase,'required']);
		?>
		</td>
		
		<td>
		<?php
		echo $this->Form->control($item_variation_master->id.'[virtual_stock]',['templates' => ['inputContainer'=>'{{content}}'],'label' => false,'type'=>'text','placeholder'=>'Current Stock','class'=>'form-control entity_maximum entity_maximum'.$item_variation_master->unit_variation->id,'style'=>'display:inline !important;float:none;',$disabled,'value'=>@$item_variation_master->item_variations[0]->virtual_stock,'required']);
		?>
		</td>
		
		<td>
		<?php 
		echo $this->Form->control($item_variation_master->id.'[current_stock]', ['templates' => ['inputContainer'=>'{{content}}'],'label' => false,'type'=>'text','placeholder'=>'Current Stock','class'=>'form-control cStock  entity_maximum entity_maximum'.$item_variation_master->unit_variation->id,'style'=>'display:inline !important;float:none;',$disabled,'value'=>@$item_variation_master->item_variations[0]->current_stock,'required','readonly']);?>
		<input type="hidden" value="<?php echo @$item_variation_master->item_variations[0]->current_stock;?>" id="chstock">
		</td>
		
		<td>
		<?php 
		echo $this->Form->control($item_variation_master->id.'[mrp]',['templates' => ['inputContainer'=>'{{content}}'],'label' => false,'type'=>'text','placeholder'=>'MRP','class'=>'form-control mrp calc entity_maximum entity_maximum'.$item_variation_master->unit_variation->id,'style'=>'display:inline !important;float:none;',$disabled,'value'=>@$item_variation_master->item_variations[0]->mrp,'required']); ?>
		</td>
		
		<td>
		<?php 
		echo $this->Form->control($item_variation_master->id.'[print_rate]', ['templates' => ['inputContainer'=>'{{content}}'],'label' => false,'type'=>'text','placeholder'=>'Print Rate','class'=>'form-control prate calc entity_maximum entity_maximum'.$item_variation_master->unit_variation->id,'style'=>'display:inline !important;float:none;',$disabled,'value'=>@$item_variation_master->item_variations[0]->print_rate,'required']);?>
		<input type="hidden" value="<?php echo @$item_variation_master->item_variations[0]->print_rate;?>" id="chstock">
		</td>
		<td>
		<?php 
		echo $this->Form->control($item_variation_master->id.'[discount_per]',['templates' => ['inputContainer'=>'{{content}}'],'label' => false,'type'=>'text','placeholder'=>'Current Stock','class'=>'form-control dper calc entity_maximum entity_maximum'.$item_variation_master->unit_variation->id,'style'=>'display:inline !important;float:none;',$disabled,'value'=>@$item_variation_master->item_variations[0]->discount_per,'required']);?>
		<input type="hidden" value="<?php echo @$item_variation_master->item_variations[0]->discount_per;?>" id="chstock">
		</td>
		<td>
		<?php 
		echo $this->Form->control($item_variation_master->id.'[sales_rate]', ['templates' => ['inputContainer'=>'{{content}}'],'label' => false,'type'=>'text','placeholder'=>'Sales Rate','class'=>'form-control sales_rate  entity_maximum entity_maximum'.$item_variation_master->unit_variation->id,'style'=>'display:inline !important;float:none;',$disabled,'value'=>@$item_variation_master->item_variations[0]->sales_rate,'required']);
		?>
		
		<?php
		echo $this->Form->control($item_variation_master->id.'[purchase_rate]', ['templates' => ['inputContainer'=>'{{content}}'],'label' => false,'type'=>'hidden','placeholder'=>'Rate','class'=>'form-control entity_maximum  purchase_rate entity_maximum'.$item_variation_master->unit_variation->id,'style'=>'float:none;',$disabled,'value'=>@$item_variation_master->item_variations[0]->purchase_rate]);
		?>
		</td>
		<td>
		<?= $this->Form->select($item_variation_master['id'].'[out_of_stock]',$status,['empty'=>'---Select--','class'=>'form-control entity_maximum entity_maximum'.$item_variation_master->unit_variation->id,'label'=>false,$disabled,'style'=>'display:inline !important;float:none;','placeholder'=>'Select...','value'=>@$item_variation_master->item_variations[0]->out_of_stock,'style'=>'display:inline !important;float:none;']) ?>
		</td>
		<td>
		<?= $this->Form->select($item_variation_master['id'].'[ready_to_sale]',$status,
		['empty'=>'---Select--','class'=>'form-control entity_maximum entity_maximum'.$item_variation_master->unit_variation->id,'label'=>false,$disabled,'style'=>'display:inline !important;float:none;','placeholder'=>'Select...','value'=>@$item_variation_master->item_variations[0]->ready_to_sale,'style'=>'display:inline !important;float:none;']) ?>
		</td>
		<td>
		<?= $this->Form->select($item_variation_master['id'].'[status]',$Itemstatus,['empty'=>'---Select--','class'=>'form-control entity_maximum entity_maximum'.$item_variation_master->unit_variation->id,'label'=>false,$disabled,'style'=>'display:inline !important;float:none;','placeholder'=>'Select...','value'=>@$item_variation_master->item_variations[0]->status,'style'=>'display:inline !important;float:none;']) ?>
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