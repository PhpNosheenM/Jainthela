<table class="table table-bordered">
	<thead>
		<tr>
			<th><?= ('SNo.') ?></th>
			<th><?= ('Item Name') ?></th>
			<th><?= ('Unit Variation') ?></th>
			<th><?= ('Current Stock') ?></th>
			<th scope="col" class="actions"><?= __('Status') ?></th>
		</tr>
	</thead>
	<tbody>
		<?php
				$status[] =['value'=>'Deactive','text'=>'Deactive'];
				$status[] =['value'=>'Active','text'=>'Active'];
		?>
		<?php
		
		$i=0; foreach ($itemVariations as $itemVariation): 
		
		$quantity_variation=$itemVariation->unit_variation->quantity_variation;
		$shortname=$itemVariation->unit_variation->unit->shortname;
		$show_unit=$shortname.' ('.$quantity_variation.')';
		?>
		<tr>
			<td><?= $this->Number->format(++$i) ?></td>
			<td width="40%"><?= h($itemVariation->item->name) ?></td>
			<td><?= h(@$show_unit) ?></td>
			<td><?= h($itemVariation->current_stock) ?></td>
			<td class="actions">
				<?= $this->Form->select('status['.$itemVariation->id.']',$status,['class'=>'form-control select', 'data-live-search'=>true, 'label'=>false,'value'=>$itemVariation->status]) ?>
			    <?= $this->Form->control('ids[]',['type'=>'hidden','value'=>$itemVariation->id]) ?>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>