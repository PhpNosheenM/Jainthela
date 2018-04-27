<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}
</style>
<?php $this->set('title', 'Delivery Charges'); ?>
<div class="page-content-wrap">
    <div class="page-title">
			<h2><span class="fa fa-arrow-circle-o-left"></span>Delivery Charges</h2>
	</div>
	 <div class="row">
				<div class="col-md-4">
					<div class="panel panel-default">
									<div class="panel-heading">
										<h3 class="panel-title">ADD Delivery Charges</h3>
									</div>
									<?= $this->Form->create($plan,['id'=>"jvalidate"]) ?>
							<div class="panel-body">
								 
								<div class="form-group">
									<label>Amount</label>
									<?= $this->Form->control('amount',['id'=>'amount','class'=>'form-control','placeholder'=>'Amount','label'=>false]) ?>
									<span class="help-block"></span>
								</div>
								<div class="form-group">
									<label>Benifit Percentage</label>
									<?= $this->Form->control('charges',['id'=>'charges','class'=>'form-control','placeholder'=>'Benifit Percentage','label'=>false]) ?>
									<span class="help-block"></span>
								</div>
								<div class="form-group">
									<label>Status</label>
									<?php $options['Active'] = 'Active'; ?>
									<?php $options['Deactive'] = 'Deactive'; ?>
									<?= $this->Form->select('status',$options,['class'=>'form-control select','placeholder'=>'Select...','label'=>false]) ?>
								</div>
							</div>
								<div class="panel-footer">
									<div class="col-md-offset-3 col-md-4">
									   <?= $this->Form->button(__('Submit'),['class'=>'btn btn-primary']) ?>
									</div>
				                </div>
			                     <?= $this->Form->end() ?>
		            </div>
	            </div>
				<div class="col-md-8">
			       <div class="panel panel-default">
				    <div class="panel-heading">
						<h3 class="panel-title">LIST Delivery Charges</h3>
					     <div class="pull-right">
						    <div class="pull-left">
								<?= $this->Form->create('Search',['type'=>'GET']) ?>
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
					    <div class="panel-body">
				            <div class="table-responsive">
								<table class="table table-bordered">
									<thead>
										<tr>
											<th><?= ('SN.') ?></th>
											<th><?= ('Name') ?></th>
											<th><?= ('Amount') ?></th>
											<th><?= ('Benifit Per') ?></th>
											<th><?= ('Total Amount') ?></th>
											<th><?= ('Status') ?></th>
											<th scope="col" class="actions"><?= __('Actions') ?></th>
										</tr>
									</thead>
									<tbody>                                            
										<?php $i = $paginate_limit*($this->Paginator->counter('{{page}}')-1);
										foreach ($plans as $data): ?>
										<tr>
											<td><?= $this->Number->format(++$i) ?></td>
											<td><?= h($data->name) ?></td>
											<td><?= h($data->amount) ?></td>
											<td><?= h($data->benifit_per) ?></td>
											<td><?= h($data->total_amount) ?></td>
											<td><?= h($data->status) ?></td>
											<td class="actions">
												<?= $this->Html->link(__('<span class="fa fa-pencil"></span>'), ['action' => 'index', $data->id],['class'=>'btn btn-primary  btn-condensed btn-sm','escape'=>false]) ?>
												<?= $this->Form->postLink('<span class="fa fa-remove"></span>', ['action' => 'delete', $data->id], ['class'=>'btn btn-danger btn-condensed btn-sm','confirm' => __('Are you sure you want to delete ?', $data->id),'escape'=>false]) ?>
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
</div>		
<?= $this->Html->script('plugins/fileinput/fileinput.min.js',['block'=>'jsFileInput']) ?>
<?= $this->Html->script('plugins/bootstrap/bootstrap-select.js',['block'=>'jsSelect']) ?>
<?= $this->Html->script('plugins/jquery-validation/jquery.validate.js',['block'=>'jsValidate']) ?>
<?php
   $js='var jvalidate = $("#jvalidate").validate({
		ignore: [],
		rules: {                                            
				name: {
						required: true,
				},
				
			}                                        
		});
		';     
echo $this->Html->scriptBlock($js, array('block' => 'scriptBottom')); 		
?>


<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\HomeScreen[]|\Cake\Collection\CollectionInterface $homeScreens
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Home Screen'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Categories'), ['controller' => 'Categories', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Category'), ['controller' => 'Categories', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="homeScreens index large-9 medium-8 columns content">
    <h3><?= __('Home Screens') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('title') ?></th>
                <th scope="col"><?= $this->Paginator->sort('layout') ?></th>
                <th scope="col"><?= $this->Paginator->sort('section_show') ?></th>
                <th scope="col"><?= $this->Paginator->sort('preference') ?></th>
                <th scope="col"><?= $this->Paginator->sort('category_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('screen_type') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($homeScreens as $homeScreen): ?>
            <tr>
                <td><?= $this->Number->format($homeScreen->id) ?></td>
                <td><?= h($homeScreen->title) ?></td>
                <td><?= h($homeScreen->layout) ?></td>
                <td><?= h($homeScreen->section_show) ?></td>
                <td><?= $this->Number->format($homeScreen->preference) ?></td>
                <td><?= $homeScreen->has('category') ? $this->Html->link($homeScreen->category->name, ['controller' => 'Categories', 'action' => 'view', $homeScreen->category->id]) : '' ?></td>
                <td><?= h($homeScreen->screen_type) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $homeScreen->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $homeScreen->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $homeScreen->id], ['confirm' => __('Are you sure you want to delete # {0}?', $homeScreen->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
