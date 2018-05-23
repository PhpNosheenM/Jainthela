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
                                                <?php echo $this->Form->control('transaction_date',['class'=>'form-control input-sm datepicker','data-date-format'=>'dd-mm-yyyy','label'=>false,'placeholder'=>'DD-MM-YYYY','type'=>'text','data-date-start-date'=>@$coreVariable[fyValidFrom],'data-date-end-date'=>@$coreVariable[fyValidTo],'value'=>date('d-m-Y')]); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Transfer To</label>
                                                  <?= $this->Form->select('location_id',$locations,['class'=>'form-control select transfer_to', 'label'=>false,'data-live-search'=>true,'required'=>true]) ?>
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
                                                    <td><label>Transfer Qty<label></td>
                                                    <td></td>
                                                </tr>
                                            </thead>
                                            <tbody id='main_tbody' class="tab">
                                            <?php
                                            $i=0;
                                            foreach($grns->grn_rows as $grn_row){
                                               
                                                ?>
                                                
                                                <tr class="main_tr" class="tab">
                                                    <td width="7%" align="center"><?= $i+1 ?></td>
                                                    <td width="25%">
                                                        <input type="hidden" name="" class="outStock" value="0">
                                                        <input type="hidden" name="" class="totStock " value="0">
                                                        <?php 
                                                        echo $this->Form->select('item_id',[$grn_row->id=>$grn_row->item->name.' '.$grn_row->unit_variation->quantity_variation.' '.$grn_row->unit_variation->unit->shortname], ['label' => false,'class' => 'form-control','required'=>'required']); ?>
                                                        <span class="itemQty" style="color:red ;font-size:10px;">current stock is <?php echo $convert_qty= $grn_row->total_quantity * $grn_row->unit_variation->convert_unit_qty ; ?> <?= ' '.$grn_row->unit_variation->unit->shortname ?> </span>
                                                        <?php echo $this->Form->input('item_quantity', ['label' => false,'class' => 'form-control  rightAligntextClass numberOnly item_quantity','placeholder'=>'Quantity','value'=>$convert_qty]); ?>
                                                        </td>
                                                    
                                                    <td width="70%" >
                                                        <table class="item_variation">
                                                            <?php
                                                             $itemOptions=[];
                                                             unset($itemOptions);
                                                            foreach($grn_row->item->item_variations as $item_variation){ 
                                                                    $itemOptions[]=['value'=>$item_variation->id,'text'=>$item_variation->unit_variation->quantity_variation.' '.$item_variation->unit_variation->unit->shortname,'convert_qty'=>$item_variation->unit_variation->convert_unit_qty];
                                                            }

                                                                ?>
                                                            <thead style="display: none;">
                                                                 <tr>
                                                                <td>
                                                                     <?php 
                                                                     echo $this->Form->select('item_id',$itemOptions, ['label' => false,'class' => 'form-control item_variation','required'=>true,'disabled'=>true]); ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $this->Form->input('quantity', ['label' => false,'class' => 'form-control input-sm rightAligntextClass numberOnly quantity','placeholder'=>'Quantity','required'=>true,'disabled'=>true]); ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $this->Form->input('sales_rate', ['label' => false,'class' => 'form-control input-sm rightAligntextClass numberOnly sales_rate','placeholder'=>'Sales Rate','required'=>true,'disabled'=>true]); ?>
                                                                </td>
                                                                 <td>    
                                                                    <button type="button" class="add_row btn btn-default input-sm"><i class="fa fa-plus"></i> Add row</button>
                                                                     <a class="btn btn-danger delete-tr btn-xs" href="#" role="button" style="margin-bottom: 5px;"><i class="fa fa-times"></i></a>
                                                                </td>
                                                                
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            <tr>
                                                                <td>
                                                                     <?php 
                                                                     echo $this->Form->select('item_id',$itemOptions, ['label' => false,'class' => 'form-control item_variation','required'=>'required']); ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $this->Form->input('quantity', ['label' => false,'class' => 'form-control input-sm rightAligntextClass numberOnly quantity','placeholder'=>'Quantity','required'=>true]); ?>
                                                                </td>
                                                                 <td>
                                                                    <?php echo $this->Form->input('sales_rate', ['label' => false,'class' => 'form-control input-sm rightAligntextClass numberOnly sales_rate','placeholder'=>'Sales Rate','required'=>true]); ?>
                                                                </td>
                                                                 <td>    
                                                                    <button type="button" class="add_row btn btn-default input-sm"><i class="fa fa-plus"></i> Add row</button>
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                            <tfoot>
                                                                <tr>
                                                                    <td colspan="4"> <?php echo $this->Form->input('total_quantity_transfer', ['label' => false,'class' => 'form-control input-sm rightAligntextClass numberOnly total_quantity_transfer','placeholder'=>'']); ?></td>
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                        
                                                    </td>
                                                    <td align="center">
                                                        <a class="btn btn-danger delete-tr btn-xs" href="#" role="button" style="margin-bottom: 5px;"><i class="fa fa-times"></i></a>
                                                    </td>
                                                </tr>
                                            <?php
                                             $i++;
                                            }
                                            ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="4" >
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
                <?php echo $this->Form->select('item_id',$itemOptions, ['label' => false,'class' => 'form-control itemStock','required'=>'required','empty'=>'--select--']); ?>
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
<?= $this->Html->script('plugins/bootstrap/bootstrap-datepicker.js',['block'=>'jsDatePicker']) ?>
<?= $this->Html->script('plugins/bootstrap/bootstrap-select.js',['block'=>'jsSelect']) ?>
<?php
    $js="
    $(document).ready(function() {
    
        $(document).on('change','.itemStock',function(){ alert();
            var itemQ=$(this).closest('tr'); 
            var itemId=$(this).val();
            var url='".$this->Url->build(["controller" => "StockTransferVouchers", "action" => "ajaxItemQuantity"])."';
            url=url+'/'+itemId
            $.ajax({
                url: url,
                type: 'GET'
                //dataType: 'text'
            }).done(function(response) { alert(response);
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
        rename_rows();
        $(document).on('click','.delete-tr',function() 
        {
            $(this).closest('tr').remove();
            rename_rows();
        });

        $(document).on('click','.add_row',function(){
            var tr = $(this).closest('table.item_variation').find('thead >tr').clone();
          
            $(this).closest('tbody').append(tr);

            rename_rows();
            
        });
         $(document).on('keyup','.quantity',function(){ 
            var quantity = parseFloat($(this).val());
            var convert_qty = parseFloat($(this).closest('tr').find('.item_variation option:selected').attr('convert_qty'));
            var total_quantity_transfer = parseFloat($(this).closest('table').find('tfoot input.total_quantity_transfer').val());
            var variation_stock = round(convert_qty*quantity,2);
            var total_quantity_transfer_match = variation_stock+total_quantity_transfer;
            var item_quantity =parseFloat($(this).closest('table').closest('tr.main_tr').find('td:eq(1) input.item_quantity').val());
            alert(variation_stock);
            //alert(total_quantity_transfer_match);

           if(total_quantity_transfer_match > item_quantity)
           {
                 alert('Stock value is graterthan current stock.');
           }
           
        });

        

        function rename_rows()
        {
            var i=0;
            $('#main_table tbody#main_tbody tr.main_tr').each(function(){ 
                $(this).find('td:eq(0)').html(i+1);
                $(this).find('td:eq(1) select').attr({name:'stock_transfer_voucher_rows['+i+'][item_id]',id:'stock_transfer_voucher_rows-'+i+'-item_id'});

                $(this).find('td:eq(2)').find('table.item_variation >tbody >tr').each(function(){
                        $(this).find('td:eq(0) select').attr({name:'stock_transfer_voucher_rows['+i+'][item_variation_id]', id:'stock_transfer_voucher_rows-'+i+'-item_variation_id'});
                        $(this).find('td:eq(1) input').attr({name:'stock_transfer_voucher_rows['+i+'][quantity]', id:'stock_transfer_voucher_rows-'+i+'-quantity'});
                        $(this).find('td:eq(2) input').attr({name:'stock_transfer_voucher_rows['+i+'][sales_rate]', id:'stock_transfer_voucher_rows-'+i+'-sales_rate'});
                    });
                    
                
                i++;
            });
        }

        
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