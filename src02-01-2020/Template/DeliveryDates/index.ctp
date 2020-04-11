<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}
</style>
<?php $this->set('title', 'Delivery Date'); ?>
<div class="page-content-wrap">
         <div class="page-title">                    
			<h2> DELIVERY DATE</h2>
		</div>
	<div class="row">
		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">ADD DELIVERY DATE </h3>
				</div>
				<?= $this->Form->create($deliverydate,['id'=>"jvalidate"]) ?>
		        <div class="panel-body">
					<div class="form-group">
						<label>Same Day</label>
						<?php $options1['Active'] = 'Active'; ?>
						<?php $options1['Deactive'] = 'Deactive'; ?>
						<?= $this->Form->select('same_day',$options1,['class'=>'form-control select','label'=>false]) ?>
						<span class="help-block"></span>
					</div>
					<div class="form-group">
						<label>Next Day</label>
						<?= $this->Form->control('next_day',['class'=>'form-control','placeholder'=>'Charge','label'=>false]) ?>
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
					<h3 class="panel-title">LIST DELIVERY DATE</h3>
				<div class="pull-right">
					<div class="pull-left">
					<?= $this->Form->create('Search',['type'=>'GET']) ?>
					<?= $this->Html->link(__(' Add New'), ['action' => 'index'],['style'=>'margin-top:-30px !important;','class'=>'btn btn-success','escape'=>false]) ?>
						<div class="form-group" style="display:inline-table;width:500px;">
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
										<th><?= ('Same Day') ?></th>
										<th><?= ('Next Day') ?></th>
										<th><?= ('Status') ?></th>
										<th scope="col" class="actions"><?= __('Actions') ?></th>
									</tr>
								</thead>
					       <tbody>                                            
							    <?php 
								$i = $paginate_limit*($this->Paginator->counter('{{page}}')-1);
								foreach ($deliverydates as $data): ?>
								<tr>
									<td><?= $this->Number->format(++$i) ?></td>
									<td><?= h($data->same_day) ?></td>
									<td><?= h($data->next_day) ?></td>
									<td><?= h($data->status) ?></td>
									<td class="actions">
										<?php
											$data_id = $EncryptingDecrypting->encryptData($data->id);
										?>
										<?= $this->Html->link(__('<span class="fa fa-pencil"></span>'), ['action' => 'index', $data_id],['class'=>'btn btn-primary  btn-condensed btn-sm','escape'=>false]) ?>
										<?= $this->Form->postLink('<span class="fa fa-remove"></span>', ['action' => 'delete', $data_id], ['class'=>'btn btn-danger btn-condensed btn-sm','confirm' => __('Are you sure you want to delete?'),'escape'=>false]) ?>
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

<?= $this->Html->script('plugins/fileinput/fileinput.min.js',['block'=>'jsFileInput']) ?>
<?= $this->Html->script('plugins/bootstrap/bootstrap-select.js',['block'=>'jsSelect']) ?>
<?= $this->Html->script('plugins/jquery-validation/jquery.validate.js',['block'=>'jsValidate']) ?>
<?php
   $js='var jvalidate = $("#jvalidate").validate({
		ignore: [],
		rules: {                                            
				same_day: {
						required: true,
				},
				next_day: {
						required: true,
				},
				status: {
						required: true,
				},
			}                                        
		});';  
echo $this->Html->scriptBlock($js, array('block' => 'scriptBottom')); 		
?>