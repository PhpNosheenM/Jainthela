<?php $this->set('title', 'Seller Item'); ?>
    
<div class="page-content-wrap">
	<div class="row">
		<div class="col-md-12">
		<?= $this->Form->create($sellerItem,['id'=>"jvalidate",'class'=>"form-horizontal"]) ?>  
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong>Seller Item</strong></h3>
				</div>
			
				<div class="panel-body">   			
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="col-md-3 control-label">Seller Name</label>
								<div class="col-md-9">                                            
									<?= $this->Form->select('seller_id',$sellers,['class'=>'form-control select','label'=>false]) ?>
								</div>
							</div>
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
echo $js='
		$(document).on("change",".check_all",function(){
			if($(this).is(":checked"))
			{
				$(this).closest(".panel").find("input[type=checkbox]").prop("checked",true);
			}
			else
			{
				$(this).closest(".panel").find("input[type=checkbox]").prop("checked",false);
			}
		});

';
echo $this->Html->scriptBlock($js, array('block' => 'scriptBottom')); 	
?>
