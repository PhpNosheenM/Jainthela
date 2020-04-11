<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}
</style>
<?php $this->set('title', 'unit'); ?>
<div class="content-frame">
	<div class="content-frame-top">
        <div class="page-title">
			<h2> UNIT VARIATION</h2>
		</div>
		<div class="pull-right">
			<?php  if(($status=='Deactive') || ($status=='deactive')){
						$class1="btn btn-default";
						$class2="btn btn-xs blue";
					}else{
						$class1="btn btn-xs blue";
						$class2="btn btn-default";
					}
			 ?>
				<?php echo $this->Html->link('All',['controller'=>'UnitVariations','action' => 'index?status=Active'],['escape'=>false,'class'=>$class1]); ?>
				<?php echo $this->Html->link('Archive',['controller'=>'UnitVariations','action' => 'index?status=Deactive'],['escape'=>false,'class'=>$class2]); ?>&nbsp;
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">ADD UNIT VARIATIONS</h3>
				</div>
				<?= $this->Form->create($unitVariation,['id'=>"jvalidate"]) ?>
		        <div class="panel-body">
					<div class="form-group">
						<label>Variation</label>
						<?php echo $this->Form->control('quantity_variation',['class'=>'form-control quantity_variation','placeholder'=>'Eg: 100','label'=>false]) ?>
						<?php //echo $this->Form->select('quantity_variation',$variations,['empty'=>'--select--','class'=>'form-control quantity_variation select','label'=>false, 'data-live-search'=>true]); ?>
						<span class="help-block"></span>
					</div>
					<div class="form-group">
						<label>Unit</label>
						<?php echo $this->Form->select('unit_id', @$units,['empty'=>'','class'=>'form-control unit','label'=>false,'data-placeholder'=>'Select Unit']) ?>
					</div>
					<div class="form-group">
						<label>Variation Show on App</label>
						<?= $this->Form->control('visible_variation',['class'=>'form-control visible_variation','placeholder'=>'Short Variation','label'=>false]) ?>
					</div>
					<div class="form-group">
						<label>Status</label>
						<?php $options['Active'] = 'Active'; ?>
						<?php $options['Deactive'] = 'Deactive'; ?>
						<?= $this->Form->select('status',$options,['class'=>'form-control select','label'=>false]) ?>
					</div>
				
				</div>
				<div class="panel-footer">
                 <center>
						<?= $this->Form->button(__('Submit'),['class'=>'btn btn-primary']) ?>
				 </center>
               </div> 
			    <?= $this->Form->end() ?>
			</div>
		</div>
		<div class="col-md-8">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">LIST UNIT VARIATIONS</h3>
					  <div class="pull-right">
						<div class="pull-left">
							
						</div>
					 </div>
				</div>
           <div class="panel-body">
			<?php $page_no=$this->Paginator->current('unitVariation'); $page_no=($page_no-1)*20; ?>
			    <div class="table-responsive">
				  <table class="table datatable">
					<thead>
						<tr>
							<th><?= ('SN.') ?></th>
							<th><?= ('Show Variation') ?></th>
							<th><?= ('Unit Name') ?></th>
							<th><?= ('Status') ?></th>
							<th scope="col" class="actions"><?= __('Actions') ?></th>
						</tr>
					</thead>
					       <tbody>                                            
							   <?php 
						$i = $paginate_limit*($this->Paginator->counter('{{page}}')-1);
						foreach ($unitVariations as $unitVariation): ?>
						<tr>
							<td><?= $this->Number->format(++$i) ?></td>
							<td><?= h($unitVariation->visible_variation) ?></td>
							<td><?= h($unitVariation->unit->shortname) ?></td>
							<td><?= h($unitVariation->status) ?></td>
							
							<td class="actions">
									<?php
										$unitVariation_id = $EncryptingDecrypting->encryptData($unitVariation->id);
									?>
									
								<?= $this->Html->link(__('<span class="fa fa-pencil"></span>'), ['action' => 'index', $unitVariation_id],['class'=>'btn btn-primary  btn-condensed btn-sm','escape'=>false]) ?>
								<?= $this->Form->postLink('<span class="fa fa-remove"></span>', ['action' => 'delete', $unitVariation_id], ['class'=>'btn btn-danger btn-condensed btn-sm','confirm' => __('Are you sure you want to delete?'),'escape'=>false]) ?>
									</td>
								</tr>
					            <?php endforeach; ?>
					       </tbody>
				    </table>
				</div>	 	 
            </div>
      		                    <div class="panel-footer">
						<div class="paginator pull-right">
								<ul class="pagination">
								<?= $this->Paginator->first(__('First')) ?>
								<?= $this->Paginator->prev(__('Previous')) ?>
								<?= $this->Paginator->numbers() ?>
								<?= $this->Paginator->next(__('Next')) ?>
								<?= $this->Paginator->last(__('Last')) ?>
								</ul>
								<p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
						</div>
               </div> 			   
			</div>
		</div>
		
	</div>
</div>
<?= $this->Html->script('plugins/bootstrap/bootstrap-select.js',['block'=>'jsSelect']) ?>
<?= $this->Html->script('plugins/jquery-validation/jquery.validate.js',['block'=>'jsValidate']) ?>
<?php
   $js='var jvalidate = $("#jvalidate").validate({
		ignore: [],
		rules: {                                            
				unit_name: {
						required: true,
				},
				visible_variation: {
						required: true,
				},
				unit_id: {
						required: true,
				},
			   
			}                                     
		});
		
		
		/* $(document).on("change",".unit",function(){
			//var quantity_variation=$(".quantity_variation").val();
			var quantity_variation=$("option:selected", ".quantity_variation").text();
			var unit=$("option:selected", ".unit").text();
			
			var cocatdata = quantity_variation+" "+unit; 
			$(".visible_variation").val(cocatdata);
		});
		 $(document).on("change",".quantity_variation",function(){
			 var quantity_variation=$("option:selected", ".quantity_variation").text();
			var unit=$("option:selected", ".unit").text();
			
			var cocatdata = quantity_variation+" "+unit; 
			$(".visible_variation").val(cocatdata);
		});
		 */
		
		 $(document).on("change",".unit",function(){
			var quantity_variation=$(".quantity_variation").val();
			var unit=$("option:selected", ".unit").text();
			
			var cocatdata = quantity_variation+" "+unit; 
			$(".visible_variation").val(cocatdata);
		});
		 $(document).on("keyup",".quantity_variation",function(){
			var quantity_variation=$(this).val();
			var unit=$("option:selected", ".unit").text();
			
			var cocatdata = quantity_variation+" "+unit; 
			$(".visible_variation").val(cocatdata);
		}); 
		
		';  
echo $this->Html->scriptBlock($js, array('block' => 'scriptBottom')); 		
?>
