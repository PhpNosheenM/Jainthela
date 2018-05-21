<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}
</style>
<?php $this->set('title', 'Sales Report'); ?><!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong>SALES REPORT</strong></h3>
					<div class="pull-right">
						<div class="pull-left">
						</div> 
					</div> 	
				</div>
				<div class="panel-body">   			
					<div class="row">
					<?= $this->Form->create('Search',['type'=>'GET']) ?>
						<div class="form-group">
								<div class="col-md-4 col-xs-12">
									<div class="input-group">
									<span class="input-group-addon add-on"> Location </span>
										<?php echo $this->Form->select('location_id',$Locations, ['empty'=>'--Select--','label' => false,'class' => 'form-control input-sm ledger select', 'data-live-search'=>true,'value'=>$location_id]); ?>
										</div>
								</div>
								
								<div class="col-md-4 col-xs-12">
									<div class="input-group">
									<span class="input-group-addon add-on"> FROM </span>
										<?= $this->Form->control('from_date',['class'=>'form-control datepicker','placeholder'=>'From','label'=>false,'type'=>'text','data-date-format' => 'dd-mm-yyyy','value'=>date('d-m-Y',strtotime($from_date))]) ?>
										<span class="input-group-addon add-on"> TO </span>
										<?= $this->Form->control('to_date',['class'=>'form-control datepicker','placeholder'=>'To','label'=>false,'type'=>'text','data-date-format' => 'dd-mm-yyyy','value'=>date('d-m-Y',strtotime($to_date))]) ?>
										</div>
								</div>
							<div class="input-group-btn">
								<?= $this->Form->button(__('Search'),['class'=>'btn btn-primary']) ?>
							</div>
						</div>
						
						<?= $this->Form->end() ?>
					</div>
				</div>  
				<?php $LeftTotal=0; $RightTotal=0;
				if(sizeof($orders->toArray()) > 0){ 
				?>
				<div class="row">
					<div class="col-md-12">                        
					<!-- START JUSTIFIED TABS -->
						<div class="panel panel-default tabs">
							<ul class="nav nav-tabs nav-justified">
								<li class="active"><a href="#tab8" data-toggle="tab" aria-expanded="true">Cash Report</a></li>
								<li class=""><a href="#tab9" data-toggle="tab" aria-expanded="false">Credit Report</a></li>
								<li class=""><a href="#tab10" data-toggle="tab" aria-expanded="false">Online/CCAvenue</a></li>
								
							</ul>
							<div class="panel-body tab-content">
								<div class="tab-pane active" id="tab8">
									<table class="table table-bordered">
										<thead>
											<tr>
												<th><?= ('SNo.') ?></th>
												<th><?= ('Order No') ?></th>
												<th><?= ('Transaction Date') ?></th>
												<th><?= ('Location') ?></th>
												<th><?= ('Sales Amount') ?></th>
												<th><?= ('GST') ?></th>
												<th><?= ('Total') ?></th>
											</tr>
										</thead>
										<tbody>                                            
											<?php $i = 0; $total_sales_amount=0; $total_gst_amount=0; $total_amount=0;?>
											
											  <?php foreach ($orders as $order):
												if($order->order_type=="COD"){
											  ?>
											<tr>
												<td><?= $this->Number->format(++$i) ?></td>
												<td><?php echo $this->Html->link($order->order_no,['controller'=>'Orders','action' => 'view', $order->id],['target'=>'_blank']); ?></td>
												<td><?= h(date("d-m-Y",strtotime($order->transaction_date))) ?></td>
												<td><?= h($order->location->name) ?></td>
												<td><?php echo $this->Money->moneyFormatIndia($order->total_amount,2); ?></td>
												<td><?php echo $this->Money->moneyFormatIndia($order->total_gst,2); ?></td>
												<td><?php echo $this->Money->moneyFormatIndia($order->grand_total,2); ?></td>
												<?php
													$total_sales_amount+=$order->total_amount;
													$total_gst_amount+=$order->total_gst;
													$total_amount+=$order->grand_total;
												?>
											</tr>
											<?php } endforeach; ?>
										</tbody>
										<tfoot>
											<?php if($total_sales_amount > 0){ ?>
											<tr>
												<td colspan="4" align="right"><b>Total</b></td>
												<td><b><?php echo $this->Money->moneyFormatIndia($total_sales_amount,2); ?></b></td>
												<td><b><?php echo $this->Money->moneyFormatIndia($total_gst_amount,2); ?></b></td>
												<td><b><?php echo $this->Money->moneyFormatIndia($total_amount,2); ?></b></td>
											</tr>
											<?php } ?>
										</tfoot>
									</table>
								</div>
								<div class="tab-pane" id="tab9">
									<table class="table table-bordered">
										<thead>
											<tr>
												<th><?= ('SNo.') ?></th>
												<th><?= ('Order No') ?></th>
												<th><?= ('Transaction Date') ?></th>
												<th><?= ('Location') ?></th>
												<th><?= ('Sales Amount') ?></th>
												<th><?= ('GST') ?></th>
												<th><?= ('Total') ?></th>
											</tr>
										</thead>
										<tbody>                                            
											<?php $i = 0; $total_sales_amount=0; $total_gst_amount=0; $total_amount=0; ?>
											  <?php foreach ($orders as $order):
												if($order->order_type=="Credit"){
											  ?>
											<tr>
												<td><?= $this->Number->format(++$i) ?></td>
												<td><?php echo $this->Html->link($order->order_no,['controller'=>'Orders','action' => 'view', $order->id],['target'=>'_blank']); ?></td>
												<td><?= h(date("d-m-Y",strtotime($order->transaction_date))) ?></td>
												<td><?= h($order->location->name) ?></td>
												<td><?php echo $this->Money->moneyFormatIndia($order->total_amount,2); ?></td>
												<td><?php echo $this->Money->moneyFormatIndia($order->total_gst,2); ?></td>
												<td><?php echo $this->Money->moneyFormatIndia($order->grand_total,2); ?></td>
												<?php
													$total_sales_amount+=$order->total_amount;
													$total_gst_amount+=$order->total_gst;
													$total_amount+=$order->grand_total;
												?>
											</tr>
											<?php } endforeach; ?>
										</tbody>
										<tfoot>
											<?php if($total_sales_amount > 0){ ?>
											<tr>
												<td colspan="4" align="right"><b>Total</b></td>
												<td><b><?php echo $this->Money->moneyFormatIndia($total_sales_amount,2); ?></b></td>
												<td><b><?php echo $this->Money->moneyFormatIndia($total_gst_amount,2); ?></b></td>
												<td><b><?php echo $this->Money->moneyFormatIndia($total_amount,2); ?></b></td>
											</tr>
											<?php } ?>
										</tfoot>
									</table>
								</div>
								<div class="tab-pane" id="tab10">
									<table class="table table-bordered">
										<thead>
											<tr>
												<th><?= ('SNo.') ?></th>
												<th><?= ('Order No') ?></th>
												<th><?= ('Transaction Date') ?></th>
												<th><?= ('Location') ?></th>
												<th><?= ('Sales Amount') ?></th>
												<th><?= ('GST') ?></th>
												<th><?= ('Total') ?></th>
											</tr>
										</thead>
										<tbody>                                            
											<?php $i = 0; $total_sales_amount=0; $total_gst_amount=0; $total_amount=0; ?>
											  <?php foreach ($orders as $order):
												if($order->order_type=="OnLine"){
											  ?>
											<tr>
												<td><?= $this->Number->format(++$i) ?></td>
												<td><?php echo $this->Html->link($order->order_no,['controller'=>'Orders','action' => 'view', $order->id],['target'=>'_blank']); ?></td>
												<td><?= h(date("d-m-Y",strtotime($order->transaction_date))) ?></td>
												<td><?= h($order->location->name) ?></td>
												<td><?php echo $this->Money->moneyFormatIndia($order->total_amount,2); ?></td>
												<td><?php echo $this->Money->moneyFormatIndia($order->total_gst,2); ?></td>
												<td><?php echo $this->Money->moneyFormatIndia($order->grand_total,2); ?></td>
												<?php
													$total_sales_amount+=$order->total_amount;
													$total_gst_amount+=$order->total_gst;
													$total_amount+=$order->grand_total;
												?>
											</tr>
											<?php } endforeach; ?>
										</tbody>
										<tfoot>
											<?php if($total_sales_amount > 0){ ?>
											<tr>
												<td colspan="4" align="right"><b>Total</b></td>
												<td><b><?php echo $this->Money->moneyFormatIndia($total_sales_amount,2); ?></b></td>
												<td><b><?php echo $this->Money->moneyFormatIndia($total_gst_amount,2); ?></b></td>
												<td><b><?php echo $this->Money->moneyFormatIndia($total_amount,2); ?></b></td>
											</tr>
											<?php } ?>
										</tfoot>
									</table>
								</div>
								                      
							</div>
						</div>                                         
						<!-- END JUSTIFIED TABS -->
					</div>
				</div>
				<?php } else {?>
				<div class="row">
					<div class="col-md-10">
					No Result Found
					</div>
				</div> 
				<?php } ?>
		</div>
	</div>                    
</div>
<?= $this->Html->script('plugins/bootstrap/bootstrap-datepicker.js',['block'=>'jsDatePicker']) ?>
<?= $this->Html->script('plugins/bootstrap/bootstrap-select.js',['block'=>'jsSelect']) ?>