<?php
/**
 * @Author: PHP Poets IT Solutions Pvt. Ltd.
 */
$this->set('title', 'Create Stock Transfer Voucher');
?>
<div class="page-content-wrap">
    <div class="page-title">                    
        <h2><span class="fa fa-arrow-circle-o-left"></span>  Create Stock Transfer Voucher</h2>
    </div> 
    <div class="row">
        <div class="panel panel-default">
            <?= $this->Form->create($stockTransferVoucher,['onsubmit'=>'return checkValidation()']) ?>
                <div class="panel-body">
                    <div class="col-md-12">
                        <div class="portlet light ">
                            <div class="portlet-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Voucher No :</label>&nbsp;&nbsp;
                                                <?= h(str_pad($voucher_no, 4, '0', STR_PAD_LEFT)) ?>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Transaction Date <span class="required">*</span></label>
                                                <?php echo $this->Form->control('transaction_date',['class'=>'form-control input-sm date-picker','data-date-format'=>'dd-mm-yyyy','label'=>false,'placeholder'=>'DD-MM-YYYY','type'=>'text','data-date-start-date'=>@$coreVariable[fyValidFrom],'data-date-end-date'=>@$coreVariable[fyValidTo],'value'=>date('d-m-Y')]); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Transfer From</label>
                                                
                                                <?php echo $this->Form->control('transfer_from_location_id',['options'=>$TransferFromLocations,'class'=>'form-control input-sm transfer_from','label'=>false,'value'=>$location_id]); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Transfer To</label>
                                                <?php echo $this->Form->control('transfer_to_location_id',['options'=>$TransferToLocations,'class'=>'form-control input-sm transfer_to','label'=>false,'empty'=>'--select--']); ?>
                                            </div>
                                        </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="table-responsive">
                                        <table id="main_table" class="table table-condensed table-bordered" style="margin-bottom: 4px;" width="100%">
                                            <thead>
                                                <tr align="center">
                                                    <td><label>Sr<label></td>
                                                    <td><label>Item<label></td>
                                                    <td><label>Qty<label></td>
                                                    <td></td>
                                                </tr>
                                            </thead>
                                            <tbody id='main_tbody' class="tab">
                                                <tr class="main_tr" class="tab">
                                                    
                                                </tr>
                                                
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td>    
                                                        <button type="button" class="add_row btn btn-default input-sm"><i class="fa fa-plus"></i> Add row</button>
                                                    </td>
                                                    <td colspan="3" >
                                                        <div class="form-group">
                                                        <label>Narration </label>
                                                        <?php echo $this->Form->control('narration',['class'=>'form-control input-sm ','label'=>false,'placeholder'=>'Narration','rows'=>'2']); ?>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                        </div>
                           
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                 <center>
                          <?= $this->Form->button(__('Submit'),['class'=>'btn btn-success submit']) ?>
                 </center>
            </div>
             <?= $this->Form->end() ?>
        </div>
    </div>
</div>


<table id="sample_table" style="display:none;" width="100%">
    <tbody>
        <tr class="main_tr" class="tab">
            <td width="7%" align="center"></td>
            <td width="50%">
                <input type="hidden" name="" class="outStock" value="0">
                <input type="hidden" name="" class="totStock " value="0">
                <?php echo $this->Form->control('item_id', ['options' => $itemOptions,'label' => false,'class' => 'form-control input-sm itemStock','required'=>'required','empty'=>'--select--']); ?>
                <span class="itemQty" style="color:red ;font-size:10px;"></span>
                </td>
            
            <td width="25%" >
                <?php echo $this->Form->input('quantity', ['label' => false,'class' => 'form-control input-sm rightAligntextClass numberOnly quantity','placeholder'=>'Quantity','required']); ?>
            </td>
            <td align="center">
                <a class="btn btn-danger delete-tr btn-xs" href="#" role="button" style="margin-bottom: 5px;"><i class="fa fa-times"></i></a>
            </td>
        </tr>
    </tbody>
</table>

<?php
    $js="
    $(document).ready(function() {
    
        $('.itemStock').die().live('change',function(){
        var itemQ=$(this).closest('tr'); 
        var itemId=$(this).val();
        var url='".$this->Url->build(["controller" => "IntraLocationStockTransferVouchers", "action" => "ajaxItemQuantity"])."';
        url=url+'/'+itemId
        $.ajax({
            url: url,
            type: 'GET'
            //dataType: 'text'
        }).done(function(response) {
            var fetch=$.parseJSON(response);
            var text=fetch.text;
            var type=fetch.type;
            var mainStock=fetch.mainStock;
            itemQ.find('.itemQty').html(text);
            itemQ.find('.totStock').val(mainStock);
            if(type=='true')
            {
                itemQ.find('.outStock').val(1);
            }
            else{
                itemQ.find('.outStock').val(0);
            }
        }); 
        });
        
        $('.delete-tr').die().live('click',function() 
        {
            $(this).closest('tr').remove();
            rename_rows();
        });

        $('.add_row').click(function(){
            add_row();
            
        }) ;


        function add_row()
        {
            var tr=$('#sample_table tbody tr.main_tr').clone();
            $('#main_table tbody#main_tbody').append(tr);

            rename_rows();
        }

        add_row();
        rename_rows();

        function rename_rows()
        {
            var i=0;
            $('#main_table tbody#main_tbody tr.main_tr').each(function(){ 
                
                $(this).find('td:nth-child(1)').html(i);
                $(this).find('td:nth-child(2) select').select2().attr({name:'intra_location_stock_transfer_voucher_rows['+i+'][item_id]',id:'intra_location_stock_transfer_voucher_rows-'+i+'-item_id'});   

                $(this).find('td:nth-child(3) input').attr({name:'intra_location_stock_transfer_voucher_rows['+i+'][quantity]', id:'intra_location_stock_transfer_voucher_rows-'+i+'-quantity'});
                
                i++;
            });
        }

        
    
    
        ComponentsPickers.init();
    });

    function checkValidation() 
    {  
        var transfer_from  = $('.transfer_from').val();
            var transfer_to = $('.transfer_to').val();
            if(transfer_from == transfer_to)
            {
                alert('Both the transfer location are same. Change the Location and try again...');
                return false;
            } 
        var StockDB=[]; var StockInput = {};
        $('#main_table tbody#main_tbody tr.main_tr').each(function()
        {
            var stock=$(this).find('td:nth-child(2) input.totStock').val();
            var item_id=$(this).find('td:nth-child(2) select.itemStock option:selected').val();
            var quantity=parseFloat($(this).find('td:nth-child(3) input.quantity').val());
            var existingQty=parseFloat(StockInput[item_id]);
            if(!existingQty){ existingQty=0; }
            StockInput[item_id] = quantity+existingQty;
            StockDB[item_id] = stock;
        });
        
        var c=1;
        $('#main_table tbody#main_tbody tr.main_tr').each(function()
        {
            var item_id=$(this).find('td:nth-child(2) select.itemStock option:selected').val();
            if(StockInput[item_id]>StockDB[item_id]){
                c=0;
            }
        });
        if(c==0){
            alert('Error: Stock is going in minus. Please Check');
            return false;
        }
        if(confirm('Are you sure you want to submit!'))
        {
            $('.submit').attr('disabled','disabled');
            $('.submit').text('Submiting...');
            return true;
        }
        else
        {
            return false;
        }
    }
    ";

echo $this->Html->scriptBlock($js, array('block' => 'scriptBottom')); 
?>