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
								<div class="col-md-6" align="center" style="font-weight: bold">INPUT TAX (GST) - 
								<?php $purchase="PURCHASE REPORT";  ?>
								<?= $this->Html->link($purchase, ['controller' => 'Items', 'action' => 'PurchaseReport'],['target'=>'_blank']) ?>
									<table class="table table-bordered  table-condensed" width="100%" border="1">
										<thead>
											<tr>
												<th style="background-color:#a3bad0 ; text-align:center"  scope="col">GST Type</th>
												<th style="background-color:#a3bad0 ; text-align:center"  scope="col" >Taxable Amount</th>
												<th style="background-color:#a3bad0 ; text-align:center"  scope="col" >GST</th>
											</tr>
										</thead>
										<tbody>
										<?php $totalTaxPur=0; $totalgstinput=0; foreach($GstFigures as $GstFigure) {?>
											<tr>
												<td style="text-align:center"><?php echo $GstFigure->name; ?></td>
												<td scope="col" style="text-align:center";><b>
												<?php //if(@$inputgst[@$GstFigure->id]){ ?>
												<?php echo @$input_taxable_gst_wise[@$GstFigure->id]; ?>
												<?php $totalgstinput+=@$inputgst[@$GstFigure->id]; ?>
												<?php $totalTaxPur+=@$input_taxable_gst_wise[@$GstFigure->id];
												 ?>
												</b></td>
												<td align="center"><?php echo @$inputgst[@$GstFigure->id]; ?></td>
												
											</tr>
										<?php } ?>
										</tbody>
										
										<tfoot>
											<tr>
												<td scope="col"  style="text-align:center";><b>Total GST</b></td>
												<td scope="col" style="text-align:center";><b><?php echo $totalTaxPur; ?></b></td>
												<td scope="col" style="text-align:center";><b><?php echo $totalgstinput; ?></b></td>
												
											</tr>
											
										</tfoot>
									</table>
								</div>
								<div class="col-md-6" align="center" style="font-weight: bold">OUTPUT TAX (GST) - 
										<?php $purchase="SALES REPORT";  ?>
										<?= $this->Html->link($purchase, ['controller' => 'Invoices', 'action' => 'SalesReport','location_id'=>'','from_date'=>date('d-m-Y',strtotime($from_date)),'to_date'=>date('d-m-Y',strtotime($to_date))],['target'=>'_blank']) ?>
										<table class="table table-bordered  table-condensed" width="100%" border="1">
										<thead>
											
											<tr>
												<th style="background-color:#a3bad0 ; text-align:center"  scope="col">GST Type</th>
												<th style="background-color:#a3bad0 ; text-align:center"  scope="col" >Taxable Amount</th>
												<th style="background-color:#a3bad0 ; text-align:center"  scope="col" >GST</th>
											</tr>
										</thead>
										<tbody>
										<?php $totalgstoutput=0; $totalgstoutputtaxable=0;
											foreach($GstFigures as $GstFigure) {?>
											<tr>
												<td style="text-align:center"><?php echo $GstFigure->name; ?></td>
												<td scope="col" style="text-align:center";><b>
												<?php //if(@$outputgst[@$GstFigure->id]){ ?>
												<?php echo @$taxable_gst_wise[@$GstFigure->id]; ?>
												<?php $totalgstoutputtaxable+=@$taxable_gst_wise[@$GstFigure->id]; ?>
												<?php $totalgstoutput+=@$outputgst[@$GstFigure->id]; ?>
												<?php  ?>
												</b></td>
												
												<td  align="center"><?php echo @$outputgst[@$GstFigure->id]; ?></td>
												
											</tr>
										<?php } ?>
										</tbody>
										
										<tfoot>
											<tr>
												<td scope="col"  style="text-align:center";><b>Total GST</b></td>
												<td scope="col" style="text-align:center";><b><?php echo $totalgstoutputtaxable; ?></b></td>
												<td scope="col" style="text-align:center";><b><?php echo $totalgstoutput; ?></b></td>
												
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
												<th style="background-color:#a3bad0 ; text-align:center"  scope="col" >Taxable Amount</th>
												<th style="background-color:#a3bad0 ; text-align:center"  scope="col" >GST</th>
											</tr>
										</thead>
										<tbody>
										<?php $totalgstinput1=0; foreach($GstFigures as $GstFigure) {?>
											<tr>
												<td><?php echo $GstFigure->name; ?></td>
												<td></td>
												<td><?php echo @$inputIgst[@$GstFigure->id]; ?></td>
												<?php $totalgstinput1+=@$inputIgst[@$GstFigure->id]; ?>
											</tr>
										<?php } ?>
										</tbody>
										
										<tfoot>
											<tr>
												<td scope="col"  style="text-align:right";><b>Total IGST</b></td>
												<td></td>
												<td scope="col" style="text-align:right";><b><?php echo $totalgstinput1; ?></b></td>
												
											</tr>
											
										</tfoot>
									</table>
								</div>
								<div class="col-md-6" align="center" style="font-weight: bold">OUTPUT TAX (IGST) - SALES
										<table class="table table-bordered  table-condensed" width="100%" border="1">
										<thead>
											
											<tr>
												<th style="background-color:#a3bad0"  scope="col">GST Type</th>
												<th style="background-color:#a3bad0 ; text-align:center"  scope="col" >Taxable Amount</th>
												<th style="background-color:#a3bad0 ; text-align:center"  scope="col" >GST</th>
											</tr>
										</thead>
										<tbody>
										<?php $totalgstoutput1=0;$totaligstoutputtaxable=0; foreach($GstFigures as $GstFigure) {?>
											<tr>
												<td><?php echo $GstFigure->name; ?></td>
												<td scope="col" style="text-align:center";><b>
												<?php //if(@$outputgst[@$GstFigure->id]){ ?>
												<?php echo @$taxable_igst_wise[@$GstFigure->id]; ?>
												<?php $totaligstoutputtaxable+=@$taxable_igst_wise[@$GstFigure->id]; ?>
												<?php $totalgstoutput1+=@$outputIgst[@$GstFigure->id]; ?>
												<?php  ?>
												</b></td>
												<td><?php echo @$outputIgst[@$GstFigure->id]; ?></td>
												
											</tr>
										<?php } ?>
										</tbody>
										
										<tfoot>
											<tr>
												<td scope="col"  style="text-align:center";><b>Total IGST</b></td>
												<td scope="col" style="text-align:center";><b><?php echo $totaligstoutputtaxable; ?></b></td>
												<td scope="col" style="text-align:center";><b><?php echo $totalgstoutput1; ?></b></td>
												
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
								<div class="col-md-3 " align="center" style="font-weight: bold"></div>
								<div class="col-md-6 " align="center" style="font-weight: bold"></b>Total GST</b>
									<table class="table table-bordered  table-condensed" width="100%" border="1">
										<thead>
											
											<tr>
												<th style="background-color:#f7c062; "  scope="col">GST</th>
												<th style="background-color:#f7c062"  scope="col" >Amount</th>
											</tr>
										</thead>
										<tbody>
										
											<tr>
												<td >Total Input GST</td>
												<td style="text-align:right";><?php echo @$totalgstinput+$totalgstinput1; ?></td>
											</tr>
											
											<tr>
												<td>Total Output GST</td>
												<td style="text-align:right";><?php echo @$totalgstoutput+$totalgstoutput1; ?></td>
											</tr>
									
										</tbody>
										
										<tfoot> 
											<tr>
												<td   style="text-align:left";><b>Diffrence</b></td>
												<td scope="col" style="text-align:right";><?php echo ((@$totalgstinput+$totalgstinput1)-(@$totalgstoutput+$totalgstoutput1)); ?></td>
												
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