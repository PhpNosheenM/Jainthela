<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}
</style>
<?php $this->set('title', 'Orders'); ?><!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong>Orders</strong></h3>
					<div class="pull-right">
					<div class="pull-right">
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
				</div> 	
				</div>
				<div class="panel-body">    
					<div class="table-responsive">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th><?= ('SNo.') ?></th>
									<th><?= ('Order No') ?></th>
									<th><?= ('Customer Name') ?></th>
									<th><?= ('Order Date Time') ?></th>
									<th><?= ('Delivery Date') ?></th>
									<th><?= ('Grand Total') ?></th>
									<th><?= ('Order Type') ?></th>
									<th><?= ('Order From') ?></th>
									<th><?= ('Payment Status') ?></th>
									<th><?= ('Status') ?></th>
								</tr>
							</thead>
							<tbody>                                            
								<?php $i = $paginate_limit*($this->Paginator->counter('{{page}}')-1); ?>
								
								  <?php foreach ($orders as $order): 
									$order->BgColor='';
								 if($order->order_comment){
									  $order->BgColor = 'style="background-color: #de6b80;color: white;"';
									  //pr($order->BgColor); exit;
								  }
								  
								  ?>
								<tr <?php echo $order->BgColor; ?>>
									<td <?php echo $order->BgColor; ?>><?= $this->Number->format(++$i) ?></td>
									<td <?php echo $order->BgColor; ?>>
										<?php if($order->order_type=="Credit"){ ?>
											<?php $order_id = $EncryptingDecrypting->encryptData($order->id); ?>
											<?php echo $this->Html->link($order->order_no,['controller'=>'Orders','action' => 'pdfView', $order_id],['target'=>'_blank']); ?>
										<?php }else { ?>
											<?php $order_id = $EncryptingDecrypting->encryptData($order->id); ?>
											<?php echo $this->Html->link($order->order_no,['controller'=>'Orders','action' => 'view', $order_id, 'print'],['target'=>'_blank']); ?>
										<?php } ?>
									</td>
									<td <?php echo $order->BgColor; ?>><?= h($order->customer->name) ?></td>
									<?php $Otime1='';
										if(!empty($order->order_time)){
											$Otime=strtotime(@$order->order_time);
											$Otime1=date('H:i:s',$Otime);
										}
										//pr($Otime1);
									?>
									<td <?php echo $order->BgColor; ?>><?= h($Otime1) ?></td>
									<td <?php echo $order->BgColor; ?>><?= h($order->delivery_date) ?></td>
									<td <?php echo $order->BgColor; ?>><?= h($order->pay_amount) ?></td>
									<td <?php echo $order->BgColor; ?>><?= h($order->order_type) ?></td>
									<td <?php echo $order->BgColor; ?>><?= h($order->order_from) ?></td>
									<td <?php echo $order->BgColor; ?>>
									<?php if($order->payment_status=="Success" || $order->payment_status=="Invalid"|| $order->payment_status=="Aborted" ){  echo $order->payment_status;?>
									<?php }else{  ?>
									<?php echo "-"; ?></td>
									<?php } ?>
									<td <?php echo $order->BgColor; ?>>
										<?= h($order->order_status) ?>
										<?php if($order->order_from=="Web" && $order->order_status=="placed") { ?>
										<?= $this->Html->link(__('<span class=""></span> Edit Order'), ['controller'=>'Orders','action' => 'RecreateOrder',$order->id],['class'=>'btn btn-danger btn-xs','escape'=>false]) ?>
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