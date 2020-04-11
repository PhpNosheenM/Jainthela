<?php $this->set('title', 'delivery_times'); ?>
<div class="page-content-wrap">
        <div class="page-title">                    
			<h2> DELIVERY TIMES</h2>
		</div>
		<div class="row">
			<div class="col-md-4">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">ADD DELIVERY TIMES</h3>
					</div>
					<?= $this->Form->create($deliveryTime,['id'=>"jvalidate"]) ?>
					<div class="panel-body">
						<div class="form-group">
							<label>Time From</label>
								<div class="input-group bootstrap-timepicker">
								<?= $this->Form->control('time_from',['class'=>'form-control timepicker','placeholder'=>'Time From','label'=>false]) ?>
								<span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
								</div>
						</div>
						<div class="form-group">
							<label>Time To</label>
								<div class="input-group bootstrap-timepicker">
								<?= $this->Form->control('time_to',['class'=>'form-control timepicker','placeholder'=>'Time To','label'=>false]) ?>
								<span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
								</div>
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
						<h3 class="panel-title">LIST DELIVERY TIME</h3>
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
					    <?php $page_no=$this->Paginator->current('deliveryTime'); $page_no=($page_no-1)*20; ?>
			    <div class="table-responsive">
				        <table class="table table-bordered">
					<thead>
						<tr>
							<th><?= ('SN.') ?></th>
							<th><?= ('TIME FROM') ?></th>
							<th><?= ('TIME TO') ?></th>
							<th><?= ('Status') ?></th>
							
							<th scope="col" class="actions"><?= __('Actions') ?></th>
						</tr>
					</thead>
					       <tbody>                                            
							   <?php 
									$i = $paginate_limit*($this->Paginator->counter('{{page}}')-1);
									foreach ($deliveryTimes as $deliveryTime): ?>
						    <tr>
								<td><?= $this->Number->format(++$i) ?></td>
								<td><?= h($deliveryTime->time_from) ?></td>
								<td><?= h($deliveryTime->time_to) ?></td>
								<td><?= h($deliveryTime->status) ?></td>
								<td class="actions">
									<?php
										$deliveryTime_id = $EncryptingDecrypting->encryptData($deliveryTime->id);
									?>
									<?= $this->Html->link(__('<span class="fa fa-pencil"></span>'), ['action' => 'index', $deliveryTime_id],['class'=>'btn btn-primary  btn-condensed btn-sm','escape'=>false]) ?>
									<?= $this->Form->postLink('<span class="fa fa-remove"></span>', ['action' => 'delete', $deliveryTime_id], ['class'=>'btn btn-danger btn-condensed btn-sm','confirm' => __('Are you sure you want to delete?'),'escape'=>false]) ?>
							     </td>
							</tr>
					                <?php endforeach; ?>
					       </tbody>
				    </table>
				</div>
            </div>
		</div>
    </div>
</div>
</div>
<?= $this->Html->script('plugins/bootstrap/bootstrap-timepicker.min.js',['block'=>'jsTimePicker']) ?>	