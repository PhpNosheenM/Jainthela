<?php
/**
 * @Author: PHP Poets IT Solutions Pvt. Ltd.
 */
$this->set('title', 'Challan');
?>
<div class="page-content-wrap">
	<div class="row">
		<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
						<h3 class="panel-title-box">Challan for  <?php echo (@$grns->toArray()[0]->vendor_ledger->name); ?> </h3>
						
			</div>
			<div class="panel-heading">
					
					<div class="pull-right">
							<?= $this->Form->create('Search',['type'=>'GET']) ?>
							<?php // $this->Html->link(__('<span class="fa fa-plus"></span> Add New'), ['action' => 'add'],['style'=>'margin-top:-30px !important;','class'=>'btn btn-success','escape'=>false]) ?>
							<?php //$this->Html->link(__('<span class=""></span> Freeze'), ['action' => 'add'],['style'=>'margin-top:-30px !important;','class'=>'btn btn-danger','escape'=>false]) ?>
							
						<?= $this->Form->end() ?>
					</div> 		
			</div>
			<div class="panel-body">
			  
            <div class="portlet-body">
			
                <div class="table-responsive">
                    <?php $page_no=$this->Paginator->current('Grns'); 
                    $page_no=($page_no-1)*20; ?>
                    <table class="table table-bordered table-hover table-condensed" id="main_tb">
                        <thead>
                            <tr>
                                <th scope="col" class="actions">Sr. No.</th>
                                <th scope="col">Voucher No</th>
                                <th scope="col">Transaction Date</th>
                                <th scope="col" class="actions"><?= __('Actions') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            foreach ($grns as $grn):
                            ?>
                           <tr class="main_tr">
                                <td><?= h(++$page_no) ?></td>
                                <td><?= h('#'.str_pad($grn->voucher_no, 4, '0', STR_PAD_LEFT)) ?></td>
                                <td><?= h($grn->transaction_date) ?></td>
                                <td class="actions">
                               </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
					
                </div>
                   
					
            </div>
        </div>
    </div>
	<?= $this->Form->end() ?>		
</div>

