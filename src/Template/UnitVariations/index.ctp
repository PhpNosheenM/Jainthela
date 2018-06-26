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
<div class="page-content-wrap">
        <div class="page-title">
			<h2><span class="fa fa-arrow-circle-o-left"></span> UNIT VARIATION</h2>
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
						<label>Quantity Variation</label>
						<?= $this->Form->control('quantity_variation',['class'=>'form-control','placeholder'=>'Eg: 100','label'=>false]) ?>
						<span class="help-block"></span>
					</div>
					<div class="form-group">
						<label>Unit</label>
							<?php echo $this->Form->select('unit_id', $units,['empty'=>'---Select--Unit---','class'=>'form-control unit','label'=>false]) ?>
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
					<h3 class="panel-title">LIST UNITS VARIATION</h3>
					  <div class="pull-right">
						<div class="pull-left">
							<?= $this->Form->create('Search',['type'=>'GET']) ?>
							<?= $this->Html->link(__('<span class="fa fa-plus"></span> Add New'), ['action' => 'index'],['style'=>'margin-top:-30px !important;','class'=>'btn btn-success','escape'=>false]) ?>
								<div class="form-group" style="display:inline-table">
									<div class="input-group">
										<div class="input-group-addon">
											<span class="fa fa-search"></span>
										</div>
										<?= $this->Form->control('search',['class'=>'form-control','placeholder'=>'Search...','label'=>false]) ?>
										<div class="input-group-btn">
											<?= $this->Form->button(__('Search'),['class'=>'btn btn-primary']) ?>
										</div>
									</div>
								</div>
							<?= $this->Form->end() ?>
						</div>
					 </div>
				</div>
           <div class="panel-body">
			<?php $page_no=$this->Paginator->current('unitVariation'); $page_no=($page_no-1)*20; ?>
			    <div class="table-responsive">
				        <table class="table table-bordered">
					<thead>
						<tr>
							<th><?= ('SN.') ?></th>
							<th><?= ('Quantity Variation') ?></th>
							<th><?= ('Unit Name') ?></th>
							<th scope="col" class="actions"><?= __('Actions') ?></th>
						</tr>
					</thead>
					       <tbody>                                            
							   <?php 
						$i = $paginate_limit*($this->Paginator->counter('{{page}}')-1);
						foreach ($unitVariations as $unitVariation): ?>
						<tr>
							<td><?= $this->Number->format(++$i) ?></td>
							<td><?= h($unitVariation->quantity_variation). ' '. '(' . ' '?> <?= h($unitVariation->convert_unit_qty). ' ' .h($unitVariation->unit->print_unit). ' ' .')' ?></td>
							<td><?= h($unitVariation->unit->unit_name) ?></td>
							
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
				longname: {
						required: true,
				},
				shortname: {
						required: true,
				},
			   
			}                                        
		});';  
echo $this->Html->scriptBlock($js, array('block' => 'scriptBottom')); 		
?>
