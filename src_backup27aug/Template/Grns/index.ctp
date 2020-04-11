<?php
/**
 * @Author: PHP Poets IT Solutions Pvt. Ltd.
 */
$this->set('title', 'GRN');
?>
<div class="page-content-wrap">
    <div class="page-title">                    
        <h2><span class="fa fa-arrow-circle-o-left"></span>GRN List</h2>
    </div> 
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="actions">
                        <form method="GET" id="">
                            <div class="row">
                                 
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <br/>
            <div class="portlet-body">
                <div class="table-responsive">
                    <?php $page_no=$this->Paginator->current('Grns'); 
                    $page_no=($page_no-1)*20; ?>
                    <table class="table table-bordered table-hover table-condensed" id="main_tb">
                        <thead>
                            <tr>
                                <th scope="col" class="actions">Sr. No.</th>
                                <th scope="col">Voucher No</th>
                                <th scope="col">Reference No</th>
                                <th scope="col">Vendor/Seller</th>
                                <th scope="col">Transaction Date</th>
                                <th scope="col" class="actions"><?= __('Actions') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            foreach ($grns as $grn): //pr($grn->stock_transfer_vouchers);
							//$grn_id = $EncryptingDecrypting->encryptData($grn->id);
                            ?>
                           <tr class="main_tr">
                                <td><?= h(++$page_no) ?></td>
                                <td><?= h('#'.str_pad($grn->voucher_no, 4, '0', STR_PAD_LEFT)) ?></td>
                                <td><?= h($grn->reference_no) ?></td>
                                <td><?= h(@$grn->vendor_ledger->name) ?></td>
                                <td><?= h($grn->transaction_date) ?></td>
                                <td class="actions">
									
									
                                    <?php  if($grn->stock_transfer_status=="Pending" && $status=="transfer"){
                                        $grn_id = $EncryptingDecrypting->encryptData($grn->id);
                                     ?>
									 <?= $this->Html->link(__('<span class=""></span> Stock Transfer'), ['controller'=>'StockTransferVouchers','action' => 'add',$grn_id],['class'=>'btn btn-danger btn-xs','escape'=>false]) ?>
									<?php } ?>
									<?= $this->Html->link(__('<span class="fa fa-search"></span> View'), ['action' => 'view',$grn->id],['class'=>'btn btn-warning btn-xs','escape'=>false]) ?>
									
									
									<?php if(empty($grn->stock_transfer_vouchers) && $grn->purchase_invoice_status=="Pending"){?>
									
									<?= $this->Html->link(__('<span class="fa fa-pencil"></span> Edit'), ['action' => 'edit',$grn->id],['class'=>'btn btn-primary btn-xs','escape'=>false]) ?>
									
									
									
									
									<?= $this->Form->postLink('<span class="fa fa-remove"></span>', ['action' => 'delete', $grn->id], ['class'=>'btn btn-danger btn-condensed btn-sm','confirm' => __('Are you sure you want to Delete?'),'escape'=>false]) ?>
                                    <?php } ?>
									
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
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

<?= $this->Html->script('plugins/bootstrap/bootstrap-datepicker.js',['block'=>'jsDatePicker']) ?>

<?= $this->Html->script('plugins/bootstrap/bootstrap-select.js',['block'=>'jsSelect']) ?>
<?= $this->Html->script('plugins/jquery-validation/jquery.validate.js',['block'=>'jsValidate']) ?>
<?php
   $js="
		$(document).on('click','.rename_check',function(){
			//alert();
			rename_rows();
		})
		
		function rename_rows(){  
		var i=0;
		var val='';
			$('#main_tb tbody tr.main_tr').each(function(){ 
			$(this).find('.rename_check').each(function(e)
			{
				if($(this).is(':checked'))
				{
					val=$(this).val(); alert(val);
				}
			});
			
			if(val){
				$(this).css('background-color','#fffcda');
			}
			
			});
		}
	//	alert()
		";  
echo $this->Html->scriptBlock($js, array('block' => 'scriptBottom')); 		
?>