


<?php 
if($itemSize > 0){
	 echo $this->Form->control('item_id',['type'=>'hidden','class'=>'item_id']);
	 echo $this->Form->select('item_variation_id', $items,['empty'=>'-select-','class'=>'form-control item select-picker','label'=>false]);
}else{
	echo "No Item";
}
?>
<?= $this->Html->script('plugins/bootstrap/bootstrap-select.js',['block'=>'jsSelect']) ?>