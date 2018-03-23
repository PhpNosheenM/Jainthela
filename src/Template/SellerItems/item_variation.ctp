<?php $this->set('title', 'Seller Item'); ?>
<div class="page-content-wrap">
	<div class="row">
		<div class="col-md-12">
		<?= $this->Form->create($itemVariation,['id'=>"jvalidate",'class'=>"form-horizontal"]) ?>  
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong>Seller Item</strong></h3>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<div class="col-md-12">    
									<div class="panel-group accordion accordion-dc">
										<?= $this->RecursiveCategories->categoryItems($categories) ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="panel-footer">
					<center>
						<?= $this->Form->button(__('Submit'),['class'=>'btn btn-primary']) ?>
					</center>
				</div>
			</div>
			
						
			
			<?= $this->Form->end() ?>
		</div>
	</div>                    	
</div>
<?php
$js='
		$(document).on("change",".check_all",function(){
			if($(this).is(":checked"))
			{
				$(this).closest(".panel").find("input[type=checkbox]").prop("checked",true);
				$(this).closest(".panel").find("input[type=text]").prop("disabled",false);
			}
			else
			{
				$(this).closest(".panel").find("input[type=checkbox]").prop("checked",false);
				$(this).closest(".panel").find("input[type=text]").prop("disabled",true);
			}
		});
		$(document).on("change",".single_item",function(){
			var item_id = $(this).val();
			if($(this).is(":checked"))
			{
				$(this).closest("div").find("input[item_id="+item_id+"]").prop("disabled",false);
			}
			else
			{
				$(this).closest("div").find("input[item_id="+item_id+"]").prop("disabled",true);
			}
		});
		$(document).on("keyup",".commission_all",function(){
			$(this).closest(".panel").find("input[type=text]").val($(this).val());
		});
';
echo $this->Html->scriptBlock($js, array('block' => 'scriptBottom')); 	
?>
