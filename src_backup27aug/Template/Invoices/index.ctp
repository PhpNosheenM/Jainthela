<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}
</style>
<?php $this->set('title', 'Invoice'); ?><!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong>Invoice</strong></h3>
					<div class="pull-right">
					<?php
						if($status=="Done"){
							$class1="btn btn-xs blue";
							$class2="btn btn-default";
						}else{
							$class2="btn btn-xs blue";
							$class1="btn btn-default";
						}
						 ?>
						<?php echo $this->Html->link('Invoice',['controller'=>'Invoices','action' => 'index?status='],['escape'=>false,'class'=>$class1]); ?>&nbsp;
						<?php echo $this->Html->link('Cancel Invoice',['controller'=>'Invoices','action' => 'index?status=Cancel'],['escape'=>false,'class'=>$class2]); ?>&nbsp;
					</div>	
					<div class="pull-left">
						<?= $this->Form->create('Search',['type'=>'GET']) ?>
						
						<div class="col-md-4 col-xs-12">
									<div class="input-group">
									<span class="input-group-addon add-on"> FROM </span>
										<?= $this->Form->control('from_date',['class'=>'form-control datepicker','placeholder'=>'From','label'=>false,'type'=>'text','data-date-format' => 'dd-mm-yyyy','value'=>date('d-m-Y',strtotime(@$from_date))]) ?>
										<span class="input-group-addon add-on"> TO </span>
										<?= $this->Form->control('to_date',['class'=>'form-control datepicker','placeholder'=>'To','label'=>false,'type'=>'text','data-date-format' => 'dd-mm-yyyy','value'=>date('d-m-Y',strtotime(@$to_date))]) ?>
										
										</div>
								</div>
							<div class="col-md-2">
									<div class="form-group">
										
										<?php echo $this->Form->select('seller_id',$Sellers, ['empty'=>'--Select Seller--','label' => false,'class' => 'form-control input-sm  select', 'data-live-search'=>true,'value'=>'']); ?>
										
									</div>
								</div>
								
							<div class="form-group" style="display:inline-table">
								<div class="input-group">
									<div class="input-group-addon">
										<span class="fa fa-search"></span>
									</div>
									<input type="hidden" name="status" value="<?php echo @$status; ?>">
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
									<th><?= ('SNo.') ?></th>
									<th><?= ('Invoice No') ?></th>
									<th><?= ('Challan No') ?></th>
									<th><?= ('Customer Name') ?></th>
									<th><?= ('Locality') ?></th>
									<th><?= ('Grand Total') ?></th>
									<th><?= ('Order Type') ?></th>
									<th><?= ('Transaction Date') ?></th>
									<th><?= ('Action') ?></th>
								</tr>
							</thead>
							<tbody>                                            
								<?php $i = $paginate_limit*($this->Paginator->counter('{{page}}')-1); ?>
								
								  <?php foreach ($invoices as $order): //pr($order); exit; ?>
								<tr>
									<td><?= $this->Number->format(++$i) ?></td>
									<td>
										
											<?php $order_id = $EncryptingDecrypting->encryptData($order->id); ?>
											<?php echo $this->Html->link($order->invoice_no,['controller'=>'Invoices','action' => 'pdfView', $order_id, 'print'],['target'=>'_blank']); ?>
										
									</td>
									<td>
										
											<?php $challan_id = $EncryptingDecrypting->encryptData($order->challan_id); ?>
											<?php echo $this->Html->link($order->challan->invoice_no,['controller'=>'Challans','action' => 'challanView', $challan_id, 'print'],['target'=>'_blank']); ?>
										
									</td>
									<td><?= h($order->customer->name) ?></td>
									<td><?= h($order->location->name) ?></td>
									<td><?= h($order->pay_amount) ?></td>
									<td><?= h($order->order_type) ?></td>
									<td><?= h($order->transaction_date) ?></td>
									<td>
									<?php if($status=="return"){ ?>
									<?= $this->Html->link(__('<span class="fa fa-pencil"> Create Sales Return </span>'), ['controller'=>'SaleReturns', 'action' => 'add', $order_id],['class'=>'btn btn-primary  btn-condensed btn-sm','escape'=>false]) ?>
									<?php }else{ ?>
									<?= $this->Form->postLink('<span class="fa fa-remove">Delete Invoice</span>', ['action' => 'delete', $order_id], ['class'=>'btn btn-danger btn-condensed btn-sm','confirm' => __('Are you sure you want to delete ?'),'escape'=>false]) ?>
									
									<?php } ?>
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
<?= $this->Html->script('plugins/bootstrap/bootstrap-datepicker.js',['block'=>'jsDatePicker']) ?>