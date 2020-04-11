<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}
</style>
<?php $this->set('title', 'accounting Groups'); ?>
<div class="page-content-wrap">
        <div class="page-title">                    
            <h2><span class="fa fa-arrow-circle-o-left"></span>
				<?php  echo $accountingGroups->name.' List'; ?>
				</h2>
        </div> 
    <div class="row">
                <div class="col-md-12">
                   <div class="panel panel-default">
                      <div class="panel-heading">
                        <h3 class="panel-title">
						Type List
						</h3>
                         <div class="pull-right">
                            <div class="pull-left">
                                     
                            </div>     
                         </div> 
                        </div>  
                      <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
											<th><?= ('SN.') ?></th>
											<th><?= ('Type') ?></th>
											<th><?= ('Action') ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>                                            
                                            
                                            <tr>
												<td>1</td>
												<td>Customer</td>
												<td><input type="checkbox" name="customer" <?php if($accountingGroups->name=='NULL'){ echo "checked"; } ?> class="check_all_item"  ></td>
                                            </tr> 
											<tr>
												<td>2</td>
												<td>Vendor</td>
												<td><input type="checkbox" <?php if($accountingGroups->vendor=='NULL'){ echo "checked"; } ?> name="vendor" class="check_all_item"  ></td>
                                            </tr> 
											<tr>
												<td>3</td>
												<td>seller</td>
												<td><input type="checkbox" <?php if($accountingGroups->seller=='NULL'){ echo "checked"; } ?> name="seller" class="check_all_item"  ></td>
                                            </tr> 
											<tr>
												<td>4</td>
												<td>Payment Ledger</td>
												<td><input type="checkbox" <?php if($accountingGroups->payment_ledger=='NULL'){ echo "checked"; } ?> name="payment_ledger" class="check_all_item"  ></td>
                                            </tr>
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
                name: {
                        required: true,
                },
                
            }                                        
        });';  
echo $this->Html->scriptBlock($js, array('block' => 'scriptBottom'));       
?>
