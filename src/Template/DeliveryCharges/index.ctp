<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}
</style>
<?php $this->set('title', 'delivery_charges'); ?>
<div class="page-content-wrap">
         <div class="page-title">                    
			<h2><span class="fa fa-arrow-circle-o-left"></span> DELIVERY CHARGES</h2>
		</div>     
	<div class="row">
		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">ADD DELIVERY CHARGES</h3>
				</div>
				<?= $this->Form->create($deliveryCharge,['id'=>"jvalidate"]) ?>
		        <div class="panel-body">
					<div class="form-group">
						<label>Amount</label>
						<?= $this->Form->control('amount',['class'=>'form-control','placeholder'=>'Amount ','label'=>false]) ?>
						<span class="help-block"></span>
					</div>
					<div class="form-group">
						<label>Charge</label>
						<?= $this->Form->control('charge',['class'=>'form-control','placeholder'=>'Charge','label'=>false]) ?>
						<span class="help-block"></span>
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
					<h3 class="panel-title">LIST DELIVERY CHARGES</h3>
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
				<?php $page_no=$this->Paginator->current('delivery_charges'); $page_no=($page_no-1)*20; ?>
			    <div class="table-responsive">
				        <table class="table table-bordered">
								<thead>
									<tr>
										<th><?= ('SN.') ?></th>
										<th><?= ('amount') ?></th>
										<th><?= ('charge') ?></th>
										<th><?= ('Status') ?></th>
										
										<th scope="col" class="actions"><?= __('Actions') ?></th>
									</tr>
								</thead>
					       <tbody>                                            
							    <?php 
								$i = $paginate_limit*($this->Paginator->counter('{{page}}')-1);
								foreach ($deliveryCharges as $delivery_charge): ?>
								<tr>
									<td><?= $this->Number->format(++$i) ?></td>
									<td><?= h($delivery_charge->amount) ?></td>
									<td><?= h($delivery_charge->charge) ?></td>
									<td><?= h($delivery_charge->status) ?></td>
									<td class="actions">
										<?php
											$cdelivery_charge_id = $EncryptingDecrypting->encryptData($delivery_charge->id);
										?>
											
										<?= $this->Html->link(__('<span class="fa fa-pencil"></span>'), ['action' => 'index', $cdelivery_charge_id],['class'=>'btn btn-primary  btn-condensed btn-sm','escape'=>false]) ?>
										<?= $this->Form->postLink('<span class="fa fa-remove"></span>', ['action' => 'delete', $cdelivery_charge_id], ['class'=>'btn btn-danger btn-condensed btn-sm','confirm' => __('Are you sure you want to delete?'),'escape'=>false]) ?>
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
				amount: {
						required: true,
				},
				charge: {
						required: true,
				},
			}                                        
		});';  
echo $this->Html->scriptBlock($js, array('block' => 'scriptBottom')); 		
?>