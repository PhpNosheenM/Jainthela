<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}
</style>
<?php $this->set('title', 'Purchase Invoice'); ?><!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong>Seller Request</strong></h3>
				<div class="pull-right">
			
				</div> 	
				</div>
				<div class="panel-body">    
					<div class="table-responsive">
					<table width="50%">
						<tr>
							<td width="20%" valign="top" align="left">
								<table>
									<tr>
										<td>Seller name</td>
										<td width="20" align="center">:</td>
										<td><?= h($sellerRequest->seller->name) ?></td>
									</tr>
									<tr>
										<td>Voucher No</td>
										<td width="20" align="center">:</td>
										<td><?= h('#'.str_pad($sellerRequest->voucher_no, 4, '0', STR_PAD_LEFT)) ?></td>
									</tr>
								</table>
							</td>
							<td width="20%" valign="top" align="right">
								<table>
									<tr>
										<td>Transaction Date</td>
										<td width="20" align="center">:</td>
										<td><?= h(date("d-m-Y",strtotime($sellerRequest->transaction_date))) ?></td>
									</tr>
									<tr>
										<td>Created On</td>
										<td width="20" align="center">:</td>
										<td></td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
					<br/>
						<table class="table table-bordered">
							<thead>
								<tr>
									<th><?= ('SNo.') ?></th>
									<th><?= ('ITEM') ?></th>
									<th><?= ('ITEM VARIATION') ?></th>
									<th><?= ('QUANTITY') ?></th>
									<th><?= ('RATE') ?></th>
									<th><?= ('GST') ?></th>
									<th><?= ('TOTAL') ?></th>
									<th><?= ('PURCHASE RATE') ?></th>
								</tr>
							</thead>
							<tbody>                                            
								<?php $i = 0; ?>
								
								  <?php foreach ($sellerRequest->seller_request_rows as $seller_request_row): 
							//  pr($seller_request_row);  ?>
								<tr>
									<td><?= $this->Number->format(++$i) ?></td>
									<td><?= h($seller_request_row->item_variation->item->name) ?></td>
									<td><?= h($seller_request_row->item_variation->unit_variation->convert_unit_qty) ?></td>
									<td><?= h($seller_request_row->quantity) ?></td>
									<td><?= h($seller_request_row->rate) ?></td>
									<td><?= h($seller_request_row->gst_value) ?></td>
									<td><?= h($seller_request_row->net_amount) ?></td>
									<td><?= h($seller_request_row->purchase_rate) ?></td>
									
								
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