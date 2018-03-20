<?php 
if($itemSize > 0){
	 echo $this->Form->select('item_id', $items,['class'=>'form-control item','label'=>false]);
}else{
	echo "No Item";
}
?>