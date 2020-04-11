<?php
/**
 * @Author: PHP Poets IT Solutions Pvt. Ltd.
 */
$this->set('title', 'walletWithdrawRequests');
?>
<div class="page-content-wrap">
	<div class="row">
		<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
						<h3 class="panel-title"><strong>Challan</strong></h3>
					<div class="pull-right">
					<div class="pull-left">
						
						</div> 
				</div> 	
			</div>
			<div class="panel-body">
			  
            <div class="portlet-body">
			<?= $this->Form->create($walletWithdrawRequest) ?>
                <div class="table-responsive">
                    <?php $page_no=$this->Paginator->current('Grns'); 
                    $page_no=($page_no-1)*20; ?>
                    <table class="table table-bordered table-hover table-condensed" id="main_tb">
                        <thead>
                            <tr>
                                <th scope="col" class="actions">Sr. No.</th>
                                <th scope="col">Customer Name</th>
                                <th scope="col">Bank Name</th>
                                <th scope="col">IFSC Code</th>
                                <th scope="col">Account No.</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Request Date</th>
                                <th scope="col" class="actions"><?= __('Actions') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            foreach ($walletWithdrawRequests as $walletWithdrawRequest):
                            ?>
                           <tr class="main_tr">
                                <td><?= h(++$page_no) ?></td>
                                <td><?= h($walletWithdrawRequest->customer->name) ?></td>
                                <td><?= h($walletWithdrawRequest->bank_name) ?></td>
                                <td><?= h($walletWithdrawRequest->ifsc_code) ?></td>
                                <td><?= h($walletWithdrawRequest->account_no) ?></td>
                                <td><?= h($walletWithdrawRequest->amount) ?></td>
                                <td><?= h($walletWithdrawRequest->request_date) ?></td>
                               
                                <td class="actions">
                                    
									<?php  ?>
									<div class="checkbox pull-left">
										<label>
										<?php echo $this->Form->input('to_be_send['.$walletWithdrawRequest->id.']', ['label' => false,'type'=>'checkbox','class'=>'rename_check qty','value' => @$walletWithdrawRequest->id]);  ?></label>
										
									</div>
									<?php //echo $this->Form->input('to_be_send['.$grn->id.']', ['label' => false,'type'=>'checkbox','class'=>'rename_check qty','value' => @$grn->id,'hiddenField'=>false]);  ?>
                                    <?php  ?>
                                    
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
					<div align="right" class="form-actions">
						<button type="submit" class="btn btn-primary btns" >Create Payment Voucher</button>
					</div>
                </div>
                   
					
            </div>
        </div>
    </div>
	<?= $this->Form->end() ?>		
</div>

<?= $this->Html->script('plugins/bootstrap/bootstrap-datepicker.js',['block'=>'jsDatePicker']) ?>

<?= $this->Html->script('plugins/bootstrap/bootstrap-select.js',['block'=>'jsSelect']) ?>
<?= $this->Html->script('plugins/jquery-validation/jquery.validate.js',['block'=>'jsValidate']) ?>
<?php
   $js="
		$('.btns').attr('disabled','disabled');
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
					val=$(this).val(); 
				}
			});
			
			if(val){
				$('.btns').removeAttr('disabled');
				//$(this).css('background-color','#fffcda');
			}else{
 				//$(this).css('background-color','#FFF');
				$('.btns').attr('disabled','disabled');
			}
			
			});
		}
	//	alert()
		";  
echo $this->Html->scriptBlock($js, array('block' => 'scriptBottom')); 		
?>