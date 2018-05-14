<div class="item_variation">
	 
<div class="panel-body" id="itemshow<?php $item->id; ?>" style="padding: 0px !important;;padding-right: 1% !important;" >
<div style="overflow:scroll;">
	<div class="table-responsive">
		<table class="table table-bordered main_tbl" >
			<thead>
				<tr>
					<th width="50%"> Item Variations</th>
					<th width="50%">
						<div class="">
							<h4 class="panel-title" style="width: 100%;">
									<?php echo $item->name; ?>
								<input type="checkbox" class="check_all_item" value="<?php echo $item->id; ?>" >
								<a href="#itemshow<?php echo $item->id; ?>">
									 (Check All)
								</a>
							</h4>
						</div>
					</th>
				</tr>
			</thead>
			<tbody>
			<?php 
			$k=0;
			 
			foreach($item->item_variation_masters as $item_variation_master)
			{  
			$final_check=0;
			 
			$first_item_id=$item_variation_master->item_id;
			$first_item_variation_master_id=$item_variation_master->id;
		 $fetch_menu_submenu = $this->requestAction(['controller'=>'LocationItems', 'action'=>'checking'],['pass'=>array($first_item_id,$first_item_variation_master_id)]);
			 pr($fetch_menu_submenu); exit;
			echo $check_master_count=$fetch_menu_submenu['check_master_count'];
			echo $check_status=$fetch_menu_submenu['status'];
			?>
				<tr>
					<td align="center">
					<label style="margin-left:30px;">
					  <?php echo $item_variation_master->unit_variation->quantity_variation;?> <?php echo $item_variation_master->unit_variation->unit->longname;?>
					</label>
					</td>
					<td style="width:15%" align="center">
						<input type="hidden" name="item_variation_master_id[]" value="<?php echo $item_variation_master->id; ?>" />
						<input type="hidden" name="status[]" value="Deactive" class="stst" />
						<input name="test[]" type="checkbox"  value="<?php echo $item->id; ?>" class="entity_variation st2 entity_variation<?php echo $item_variation_master->unit_variation->id;?>" >
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