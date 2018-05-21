<?php
/**
 * @Author: PHP Poets IT Solutions Pvt. Ltd.
 */
$this->set('title', 'Challan');
?>
<div class="page-content-wrap">
    <div class="page-title">                    
        <h2><span class="fa fa-arrow-circle-o-left"></span> Create Challan</h2>
    </div> 
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="actions">
                        <form method="GET" id="">
                            <div class="row">
                                <div class="col-md-9">
                                    <?php echo $this->Form->input('search',['class'=>'form-control input-sm pull-right','label'=>false, 'placeholder'=>'Search','autofocus'=>'autofocus','value'=>@$search]);
                                    ?>
                                </div>
                                <div class="col-md-1">
                                    <button type="submit" class="go btn blue-madison input-sm">Go</button>
                                </div> 
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
                    <table class="table table-bordered table-hover table-condensed">
                        <thead>
                            <tr>
                                <th scope="col" class="actions">Sr. No.</th>
                                <th scope="col">Voucher No</th>
                                <th scope="col">Reference No</th>
                                <th scope="col">Vendor</th>
                                <th scope="col">Transaction Date</th>
                                <th scope="col" class="actions"><?= __('Actions') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            foreach ($grns as $grn):
                            ?>
                            <tr>
                                <td><?= h(++$page_no) ?></td>
                                <td><?= h('#'.str_pad($grn->voucher_no, 4, '0', STR_PAD_LEFT)) ?></td>
                                <td><?= h($grn->reference_no) ?></td>
                                <td><?= h(@$grn->vendor_ledger->name) ?></td>
                                <td><?= h($grn->transaction_date) ?></td>
                                <td class="actions">
                                    <?php  if($grn->status=="Pending"){ ?>
                                    <?= $this->Html->link(__('Stock Transfer'), ['controller'=>'StockTransferVouchers','action' => 'add', $grn->id]) ?>
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