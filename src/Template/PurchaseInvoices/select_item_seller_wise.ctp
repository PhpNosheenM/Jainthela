


<?php 
if($itemSize > 0){
	 echo $this->Form->control('item_id',['type'=>'hidden','class'=>'item_id']);
	 echo $this->Form->select('item_variation_id', $items,['empty'=>'-select-','class'=>'form-control item','label'=>false]);
}else{
	echo "No Item";
}
?>