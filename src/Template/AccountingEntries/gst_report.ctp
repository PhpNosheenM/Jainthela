<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}
</style>
<?php $this->set('title', 'Gst Report'); ?><!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong>GST REPORT</strong></h3>
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
				<?php $LeftTotal=0; $RightTotal=0; ?>
				<div class="panel-body">    
					<div class="table-responsive" class="col-md-10">
						<div class="form-group" >
								<div class="col-md-6" align="center" style="font-weight: bold">INPUT TAX (GST) - PURCHASE
									<table class="table table-bordered  table-condensed" width="100%" border="1">
										<thead>
											<tr>
												<th style="background-color:#a3bad0"  scope="col">GST Type</th>
												<th style="background-color:#a3bad0"  scope="col" >Amount</th>
											</tr>
										</thead>
										<tbody>
										<?php $totalgstinput=0; foreach($GstFigures as $GstFigure) {?>
											<tr>
												<td><?php echo $GstFigure->name; ?></td>
												<td align="right"><?php echo @$inputgst[@$GstFigure->id]; ?></td>
												<?php $totalgstinput+=@$inputgst[@$GstFigure->id]; ?>
											</tr>
										<?php } ?>
										</tbody>
										
										<tfoot>
											<tr>
												<td scope="col"  style="text-align:right";><b>Total GST</b></td>
												<td scope="col" style="text-align:right";><b><?php echo $totalgstinput; ?></b></td>
												
											</tr>
											
										</tfoot>
									</table>
								</div>
								<div class="col-md-6" align="center" style="font-weight: bold">OUTPUT TAX (GST) - SALES
										<table class="table table-bordered  table-condensed" width="100%" border="1">
										<thead>
											
											<tr>
												<th style="background-color:#a3bad0"  scope="col">GST Type</th>
												<th style="background-color:#a3bad0"  scope="col" >Amount</th>
											</tr>
										</thead>
										<tbody>
										<?php $totalgstoutput=0; foreach($GstFigures as $GstFigure) {?>
											<tr>
												<td><?php echo $GstFigure->name; ?></td>
												<td  align="right"><?php echo @$outputgst[@$GstFigure->id]; ?></td>
												<?php $totalgstoutput+=@$outputgst[@$GstFigure->id]; ?>
											</tr>
										<?php } ?>
										</tbody>
										
										<tfoot>
											<tr>
												<td scope="col"  style="text-align:right";><b>Total GST</b></td>
												<td scope="col" style="text-align:right";><b><?php echo $totalgstoutput; ?></b></td>
												
											</tr>
											
										</tfoot>
									</table>
								</div>
								
						</div>
						
						<div class="form-group" >
								<div class="col-md-12" align="center">
								</div>
						</div>
						<div class="form-group" >
								<div class="col-md-6 " align="center" style="font-weight: bold"></b>INPUT TAX (IGST) - PURCHASE</b>
									<table class="table table-bordered  table-condensed" width="100%" border="1">
										<thead>
											
											<tr>
												<th style="background-color:#a3bad0"  scope="col">GST Type</th>
												<th style="background-color:#a3bad0"  scope="col" >Amount</th>
											</tr>
										</thead>
										<tbody>
										<?php $totalgstinput=0; foreach($GstFigures as $GstFigure) {?>
											<tr>
												<td><?php echo $GstFigure->name; ?></td>
												<td><?php echo @$inputIgst[@$GstFigure->id]; ?></td>
												<?php $totalgstinput+=@$inputIgst[@$GstFigure->id]; ?>
											</tr>
										<?php } ?>
										</tbody>
										
										<tfoot>
											<tr>
												<td scope="col"  style="text-align:right";><b>Total IGST</b></td>
												<td scope="col" style="text-align:right";><b><?php echo $totalgstinput; ?></b></td>
												
											</tr>
											
										</tfoot>
									</table>
								</div>
								<div class="col-md-6" align="center" style="font-weight: bold">OUTPUT TAX (IGST) - SALES
										<table class="table table-bordered  table-condensed" width="100%" border="1">
										<thead>
											
											<tr>
												<th style="background-color:#a3bad0"  scope="col">GST Type</th>
												<th style="background-color:#a3bad0"  scope="col" >Amount</th>
											</tr>
										</thead>
										<tbody>
										<?php $totalgstoutput=0; foreach($GstFigures as $GstFigure) {?>
											<tr>
												<td><?php echo $GstFigure->name; ?></td>
												<td><?php echo @$outputIgst[@$GstFigure->id]; ?></td>
												<?php $totalgstoutput+=@$outputIgst[@$GstFigure->id]; ?>
											</tr>
										<?php } ?>
										</tbody>
										
										<tfoot>
											<tr>
												<td scope="col"  style="text-align:right";><b>Total IGST</b></td>
												<td scope="col" style="text-align:right";><b><?php echo $totalgstoutput; ?></b></td>
												
											</tr>
											
										</tfoot>
									</table>
								</div>
								
						</div>
						
				</div>
			</div>
		</div>
	</div>                    
</div>
<?= $this->Html->script('plugins/bootstrap/bootstrap-datepicker.js',['block'=>'jsDatePicker']) ?>
<?= $this->Html->script('plugins/bootstrap/bootstrap-select.js',['block'=>'jsSelect']) ?>