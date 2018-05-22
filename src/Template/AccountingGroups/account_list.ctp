<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}
#accordion{
    width: 600px;
    margin: 0px;
    padding: 0px;
    list-style: none;
}
#accordion h2{
    font-size: 12pt;
    margin: 0px;
    padding: 10px;
    background: #ccc;
    border-bottom: 1px solid #fff;
}
#accordion li div.content{
    display: none;
    padding: 10px;
    background: #f9f9f9;
    border: 1px solid #ddd;
}
#accordion li:hover div.content{
    display: inherit;
}
</style>
<?php $this->set('title', 'accounting Groups'); ?>
<div class="page-content-wrap">
        <div class="page-title">                    
            <h2><span class="fa fa-arrow-circle-o-left"></span>Ledger</h2>
        </div> 
    <div class="row">
                <div class="col-md-12">
                   <div class="panel panel-default">
                      <div class="panel-heading">
                        <h3 class="panel-title">List Ledger</h3>
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
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                        <th><?= ('SN.') ?></th>
                                        <th><?= ('Nature of Group') ?></th>
                                        <th><?= ('Name') ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>                                            
                                            <?php $i = $paginate_limit*($this->Paginator->counter('{{page}}')-1);
                                                    //pr($ledgers->toArray()); exit;
                                            foreach ($accountingGroups as $accountingGroup):?>
                                            <tr>
                                            <td><?= $this->Number->format(++$i) ?></td>
                                            <td><?= h(@$accountingGroup->nature_of_group->name) ?></td>
                                            <td>
												<ul id="accordion">
													<li>
														<h2><?= h($accountingGroup->name) ?></h2>
														<div class="content">
														   <table width="100%">
														   <tr>
														   <th width="20%">Sr.no</th>
														   <th width="60%">Name</th>
														   <th width="20%">Check</th>
														   </tr>
															<tr>
												<td>1</td>
												<td>Customer</td>
												<td><input type="checkbox" nm="customer" updt_id="<?php echo $accountingGroup->id; ?>" name="customer" <?php if($accountingGroup->name=='NULL'){ echo "checked"; } ?> class="check_all_item"  ></td>
                                            </tr> 
											<tr>
												<td>2</td>
												<td>Vendor</td>
												<td><input type="checkbox" <?php if($accountingGroup->vendor=='NULL'){ echo "checked"; } ?> nm="vendor" updt_id="<?php echo $accountingGroup->id; ?>" name="vendor" class="check_all_item"  ></td>
                                            </tr> 
											<tr>
												<td>3</td>
												<td>seller</td>
												<td><input type="checkbox" <?php if($accountingGroup->seller=='NULL'){ echo "checked"; } ?> nm="seller" updt_id="<?php echo $accountingGroup->id; ?>" name="seller" class="check_all_item"  ></td>
                                            </tr> 
											<tr>
												<td>4</td>
												<td>Payment Ledger</td>
												<td><input type="checkbox" <?php if($accountingGroup->payment_ledger=='NULL'){ echo "checked"; } ?> nm="payment_ledger" updt_id="<?php echo $accountingGroup->id; ?>"  name="payment_ledger" class="check_all_item"  ></td>
                                            </tr>
											<tr>
												<td>5</td>
												<td>Credit Note Party</td>
												<td><input type="checkbox" <?php if($accountingGroup->credit_note_party=='NULL'){ echo "checked"; } ?> nm="credit_note_party" updt_id="<?php echo $accountingGroup->id; ?>"  name="credit_note_party" class="check_all_item"  ></td>
                                            </tr>
											<tr>
												<td>6</td>
												<td>Receipt Ledger</td>
												<td><input type="checkbox" <?php if($accountingGroup->receipt_ledger=='NULL'){ echo "checked"; } ?> nm="receipt_ledger" updt_id="<?php echo $accountingGroup->id; ?>"  name="receipt_ledger" class="check_all_item"  ></td>
                                            </tr>
											<tr>
												<td>7</td>
												<td>Contra Voucher Ledger</td>
												<td><input type="checkbox" <?php if($accountingGroup->contra_voucher_ledger=='NULL'){ echo "checked"; } ?> nm="contra_voucher_ledger" updt_id="<?php echo $accountingGroup->id; ?>"  name="contra_voucher_ledger" class="check_all_item"  ></td>
                                            </tr>
											<tr>
												<td>8</td>
												<td>Journal Voucher Ledger</td>
												<td><input type="checkbox" <?php if($accountingGroup->journal_voucher_ledger=='NULL'){ echo "checked"; } ?> nm="journal_voucher_ledger" updt_id="<?php echo $accountingGroup->id; ?>"  name="journal_voucher_ledger" class="check_all_item"  ></td>
                                            </tr>
											<tr>
												<td>9</td>
												<td>Debit Note All Row</td>
												<td><input type="checkbox" <?php if($accountingGroup->debit_note_all_row=='NULL'){ echo "checked"; } ?> nm="debit_note_all_row" updt_id="<?php echo $accountingGroup->id; ?>"  name="debit_note_all_row" class="check_all_item"  ></td>
                                            </tr>
											<tr>
												<td>10</td>
												<td>Payment Ledger</td>
												<td><input type="checkbox" <?php if($accountingGroup->payment_ledger=='NULL'){ echo "checked"; } ?> nm="payment_ledger" updt_id="<?php echo $accountingGroup->id; ?>"  name="payment_ledger" class="check_all_item"  ></td>
                                            </tr>
											<tr>
												<td>11</td>
												<td>Sale Invoice Sales Account</td>
												<td><input type="checkbox" <?php if($accountingGroup->sale_invoice_sales_account=='NULL'){ echo "checked"; } ?> nm="sale_invoice_sales_account" updt_id="<?php echo $accountingGroup->id; ?>"  name="sale_invoice_sales_account" class="check_all_item"  ></td>
                                            </tr>
											<tr>
												<td>12</td>
												<td>Sale Invoice Party</td>
												<td><input type="checkbox" <?php if($accountingGroup->sale_invoice_party=='NULL'){ echo "checked"; } ?> nm="sale_invoice_party" updt_id="<?php echo $accountingGroup->id; ?>"  name="sale_invoice_party" class="check_all_item"  ></td>
                                            </tr>
											<tr>
												<td>13</td>
												<td>Purchase Invoice Purchase Account</td>
												<td><input type="checkbox" <?php if($accountingGroup->purchase_invoice_purchase_account=='NULL'){ echo "checked"; } ?> nm="purchase_invoice_purchase_account" updt_id="<?php echo $accountingGroup->id; ?>"  name="purchase_invoice_purchase_account" class="check_all_item"  ></td>
                                            </tr>
											<tr>
												<td>14</td>
												<td>Purchase Invoice Party</td>
												<td><input type="checkbox" <?php if($accountingGroup->purchase_invoice_party=='NULL'){ echo "checked"; } ?> nm="purchase_invoice_party" updt_id="<?php echo $accountingGroup->id; ?>"  name="purchase_invoice_party" class="check_all_item"  ></td>
                                            </tr>
														   </table>
														</div>
													</li>
												</ul>
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
<?php
   $js='var jvalidate = $("#jvalidate").validate({
        ignore: [],
        rules: {                                            
                name: {
                        required: true,
                },
                
            }  
});
$(document).on("click",".check_all_item",function(){
			if($(this).is(":checked"))
			{
				var updt_id=$(this).attr("updt_id");
				var nm=$(this).attr("nm");
				
			var url =   "'.$this->Url->build(["controller"=>"AccountingGroups","action"=>"getItemInfo"]).'";
			url =   url+"?updt_id="+updt_id+"&nm="+nm;
			alert(url);
            $.ajax({
					url: url,
			}).done(function(response){
				 
				$(".addResult").html(response);
			});
			
			}
			});			
        ';  
echo $this->Html->scriptBlock($js, array('block' => 'scriptBottom'));       
?>
