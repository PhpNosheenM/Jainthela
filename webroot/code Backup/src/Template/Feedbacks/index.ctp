<?php $this->set('title', 'Feedbacks'); ?>
<div class="page-content-wrap">
	<div class="page-title">                    
		<h2><span class="fa fa-arrow-circle-o-left"></span> Feedback</h2>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">List Of Feedback</h3>
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
			</div>
				
		    <div class="panel-body">
				<?php $page_no=$this->Paginator->current('delivery_charges'); $page_no=($page_no-1)*20; ?>
			    <div class="table-responsive">
				        <table class="table table-bordered">
								<thead>
									<tr>
										<th><?= ('SN.') ?></th>
										<th><?= ('Customer') ?></th>
										<th><?= ('Name') ?></th>
										<th><?= ('Email') ?></th>
										<th><?= ('Mobile No.') ?></th>
										<th><?= ('Comment') ?></th>
										<th><?= ('Created On') ?></th>
									</tr>
								</thead>
					       <tbody>                                            
							    <?php 
								$i = $paginate_limit*($this->Paginator->counter('{{page}}')-1);
								foreach ($feedbacks as $data): ?>
								<tr>
									<td><?= $this->Number->format(++$i) ?></td>
									<td><?= h($data->customer->name) ?></td>
									<td><?= h($data->name) ?></td>
									<td><?= h($data->email) ?></td>
									<td><?= h($data->mobile_no) ?></td>
									<td><?= h($data->comment) ?></td>
									<td><?= h($data->created_on) ?></td>
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