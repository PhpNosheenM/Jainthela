<?php   $this->set('title', 'Manage Item');  ?><!-- PAGE CONTENT WRAPPER --> 
<div class="page-content-wrap">                
                
                    <div class="row">
                        <div class="col-md-2">
						</div>
                        <div class="col-md-8">

                            

                            <!-- START BLOCK BUTTONS -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Item Manage</h3>
                                    <ul class="panel-controls">
                                      
                                    </ul>                                
                                </div>
                                                      
								<div class="panel-body">
                                    <form class="form-horizontal" role="form">
                                        <div class="form-group">                                        
                                            <div class="col-md-4">
												<?php echo $this->Html->link('Category wise Discount',['controller'=>'Items','action' => 'categoryWiseDiscount'],['escape'=>false,'class'=>'btn btn-success btn-block']); ?>
                                             </div>
											 <div class="col-md-4">
												<?php echo $this->Html->link('Brand wise Discount',['controller'=>'Items','action' => 'brandWiseDiscount'],['escape'=>false,'class'=>'btn btn-success btn-block']); ?>
                                             </div>
											 <div class="col-md-4">
												<?php echo $this->Html->link('Item wise Discount',['controller'=>'Items','action' => 'mangeItem'],['escape'=>false,'class'=>'btn btn-success btn-block']); ?>
                                             </div>
                                        </div>  
										
										<div class="form-group">                                        
                                           
                                        </div>  
                                                                                 
                                    </form>
                                </div>  
									
								 <div class="panel-body">
                                    <form class="form-horizontal" role="form">
                                        <div class="form-group">                                        
                                            <div class="col-md-4">
												<?php echo $this->Html->link('Next Day Purchase Detail',['controller'=>'Orders','action' => 'purchaseItemDetails'],['escape'=>false,'class'=>'btn btn-success btn-block']); ?>
                                             </div>
											 <div class="col-md-4">
												<?php echo $this->Html->link('Material Indent Report',['controller'=>'Items','action' => 'materialIndentReport'],['escape'=>false,'class'=>'btn btn-success btn-block']); ?>
                                             </div>
											 <div class="col-md-4">
												<?php echo $this->Html->link('Cancle Order Report',['controller'=>'Orders','action' => 'cancleOrderReport'],['escape'=>false,'class'=>'btn btn-success btn-block']); ?>
                                             </div>
                                        </div>  
										
										<div class="form-group">                                        
                                           
                                        </div>  
                                                                                 
                                    </form>
                                </div>     
								 <div class="panel-body">
                                    <form class="form-horizontal" role="form">
                                        <div class="form-group">                                        
                                            <div class="col-md-4">
												<?php echo $this->Html->link('Rate Update',['controller'=>'Items','action' => 'itemWiseRate'],['escape'=>false,'class'=>'btn btn-success btn-block']); ?>
                                             </div>
											 <div class="col-md-4">
												<?php echo $this->Html->link('Cancle Item Approval',['controller'=>'Challans','action' => 'cancelItem'],['escape'=>false,'class'=>'btn btn-success btn-block']); ?>
                                             </div>
											  <div class="col-md-4">
												<?php echo $this->Html->link('App Crash Report',['controller'=>'SellerItems','action' => 'crashItemReport'],['escape'=>false,'class'=>'btn btn-success btn-block']); ?>
                                             </div>
											
                                        </div>  
										
										<div class="form-group">                                        
                                           
                                        </div>  
                                                                                 
                                    </form>
                                </div>
								<div class="panel-body">
                                    <form class="form-horizontal" role="form">
                                        <div class="form-group">                                        
                                            <div class="col-md-4">
												<?php echo $this->Html->link('Consolidated Report For Grocery',['controller'=>'Items','action' => 'consolidateReport'],['escape'=>false,'class'=>'btn btn-success btn-block']); ?>
                                             </div>
											 <div class="col-md-4">
												<?php echo $this->Html->link('Consolidated Report For Fruits',['controller'=>'Items','action' => 'consolidateReportNew'],['escape'=>false,'class'=>'btn btn-success btn-block']); ?>
                                             </div>
											 <div class="col-md-4">
												<?php echo $this->Html->link('Zero Rate Item',['controller'=>'Items','action' => 'zeroItemRate'],['escape'=>false,'class'=>'btn btn-success btn-block']); ?>
                                             </div>
                                        </div>  
										
										<div class="form-group">                                        
                                           
                                        </div>  
                                                                                 
                                    </form>
                                </div>
								<div class="panel-body">
                                    <form class="form-horizontal" role="form">
                                        <div class="form-group">                                        
                                            <div class="col-md-4">
												<?php echo $this->Html->link('Expiry Report',['controller'=>'Items','action' => 'expiry_report'],['escape'=>false,'class'=>'btn btn-success btn-block']); ?>
                                             </div>
											 
											  <div class="col-md-4">
												<?php echo $this->Html->link('Item Unit Report',['controller'=>'Items','action' => 'ItemVariationWiseReoprt'],['escape'=>false,'class'=>'btn btn-success btn-block']); ?>
                                             </div>
											 
											  <div class="col-md-4">
												<?php echo $this->Html->link('Top Selling Item',['controller'=>'Invoices','action' => 'topSellingItem'],['escape'=>false,'class'=>'btn btn-success btn-block']); ?>
                                             </div>
											 
                                        </div>  
										
										<div class="form-group">                                        
                                           
                                        </div>  
                                                                                 
                                    </form>
                                </div>
								<div class="panel-body">
                                    <form class="form-horizontal" role="form">
                                        <div class="form-group">                                        
                                            <div class="col-md-4">
												<?php echo $this->Html->link('Item Active/Deactive History',['controller'=>'Items','action' => 'ItemHistory'],['escape'=>false,'class'=>'btn btn-success btn-block']); ?>
                                             </div>
											 
											  <div class="col-md-4">
												<?php echo $this->Html->link('Item Rate Report',['controller'=>'Items','action' => 'ItemRateDetail'],['escape'=>false,'class'=>'btn btn-success btn-block']); ?>
                                             </div>
											 
											  <div class="col-md-4">
												<?php echo $this->Html->link('Customer History',['controller'=>'AccountingEntries','action' => 'CustomerHistory'],['escape'=>false,'class'=>'btn btn-success btn-block']); ?>
                                             </div>
											 
                                        </div>  
										
										<div class="form-group">                                        
                                           
                                        </div>  
                                                                                 
                                    </form>
                                </div>
								<div class="panel-body">
                                    <form class="form-horizontal" role="form">
                                        <div class="form-group">                                        
                                            <div class="col-md-4">
												<?php echo $this->Html->link('Minimum stock items',['controller'=>'Items','action' => 'ItemAlert'],['escape'=>false,'class'=>'btn btn-success btn-block']); ?>
                                             </div>
											 
											  <div class="col-md-4">
												<?php echo $this->Html->link('Customer Order Report',['controller'=>'Orders','action' => 'lastOrderReport'],['escape'=>false,'class'=>'btn btn-success btn-block']); ?>
                                             </div>
											 
											  <div class="col-md-4">
												<?php echo $this->Html->link('Sales Return Report',['controller'=>'Items','action' => 'SalesReturnReport'],['escape'=>false,'class'=>'btn btn-success btn-block']); ?>
                                             </div>
											 
                                        </div>  
										
										<div class="form-group">                                        
                                           
                                        </div>  
                                                                                 
                                    </form>
                                </div>
								<div class="panel-body">
                                    <form class="form-horizontal" role="form">
                                        <div class="form-group">                                        
                                            
											 
											  <div class="col-md-4">
												<?php echo $this->Html->link('Purchase Report',['controller'=>'Items','action' => 'PurchaseReport'],['escape'=>false,'class'=>'btn btn-success btn-block']); ?>
                                             </div>
											 <div class="col-md-4">
												<?php echo $this->Html->link('Purchase Return Report',['controller'=>'Items','action' => 'PurchaseReturnReport'],['escape'=>false,'class'=>'btn btn-success btn-block']); ?>
                                             </div>
											 
                                        </div>  
										
										<div class="form-group">                                        
                                           
                                        </div>  
                                                                                 
                                    </form>
                                </div>
                            </div>
                            <!-- END BLOCK BUTTONS -->

                         
                        </div>
                    </div>
                    
                </div>