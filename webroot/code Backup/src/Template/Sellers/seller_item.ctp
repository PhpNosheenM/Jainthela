<?php $this->set('title', 'Purchase Invoice'); ?>
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
	<div class="row">
		<div class="col-md-12">
		<?= $this->Form->create($seller,['id'=>'jvalidate','class'=>'form-horizontal','type'=>'file']) ?>  
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong> Purchase Invoice</strong></h3>
				</div>
			
				<div class="panel-body">    
					<div class="row">
						<div class="col-md-3">
							<div class="form-group">
								<label class=" control-label">Seller Name</label>
								<div class="">                                            
									<?php echo $seller->name; ?>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label class=" control-label">Narration</label>
								<div class=""> 
									<?= $this->Form->control('firm_address',['class'=>'form-control','placeholder'=>'Narration','label'=>false,'rows'=>'4']) ?>
								</div>
							</div>
						</div>
						<div class="col-md-6"></div>
					</div>
					<div class="row">
					<div class="panel-group accordion" id="accordion0">
					<?php $i=0; foreach($childrens as $Category){ ?>
						<div class="panel panel-default">
							<div class="panel-heading">
									<h4 class="panel-title">
										<table width="100%">
											<tr>
											
												<td width="5%">
												<div class="checkbox-material">
												<?= $this->Form->control('seller_items['.$i.'][check]',['type'=>'checkbox','class'=>'form-control category icheckbox','id'=>'category','placeholder'=>'Item Name','label'=>false,'hidden'=>false]) ?>
												</div>
												</td>
												<td width="80%"><a class="accordion-toggle accordion-toggle-styled collapsed " data-toggle="collapse" data-parent="#accordion0" href="#collapse_<?php echo $Category->id;?>" aria-expanded="false"><?php echo $Category->name; ?></a>
												<?= $this->Form->control('seller_items['.$i.'][category_id]',['type'=>'hidden','class'=>'form-control ','placeholder'=>'Item Name','label'=>false,'value'=>$Category->id]) ?>
												</td>
												<td><?= $this->Form->control('seller_items['.$i.'][commission_percentage]',['class'=>'form-control','placeholder'=>'Discount %','label'=>false]) ?></td>
											</tr>
												
										</table>
									</h4>
							</div>
							<div id="collapse_<?php echo $Category->id;?>" class="panel-collapse collapse" aria-expanded="false">
							
							</div>
						</div>
					<?php $i++; } ?>
						
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
   
  $(document).on("click", ".category", function () {

		alert("Thanks for checking me");

	});

   
   ';  
echo $this->Html->scriptBlock($js, array('block' => 'scriptBottom'));  ?>