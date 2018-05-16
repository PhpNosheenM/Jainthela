<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}
.rightAligntextClass
{
    text-align: right;
}

</style><?php $this->set('title', 'Create Challan'); ?>
<div class="page-content-wrap">
    <div class="page-title">                    
        <h2><span class="fa fa-arrow-circle-o-left"></span> Create Challan</h2>
    </div> 
   
    <div class="panel panel-default">
        <?= $this->Form->create($grn) ?>
       
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Voucher No :</label>&nbsp;&nbsp;
                            <?= h('#'.str_pad($voucher_no, 4, '0', STR_PAD_LEFT)) ?>
                        </div>
                    </div>
                
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Transaction Date <span class="required">*</span></label>
                            <?php echo $this->Form->control('transaction_date',['class'=>'form-control datepicker','data-date-format'=>'dd-mm-yyyy', 'label'=>false,'placeholder'=>'DD-MM-YYYY','type'=>'text','data-date-start-date'=>@$coreVariable[fyValidFrom],'data-date-end-date'=>@$coreVariable[fyValidTo],'value'=>date('d-m-Y'),'data-date-format' => 'dd-mm-yyyy','required'=>'required']); ?>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Reference No.</label>
                            <?php echo $this->Form->control('reference_no', ['label' => false,'class' => 'form-control input-sm ','placeholder'=>'Reference No.', 'autofocus'=>'autofocus']); ?>
                        </div>  
                    </div>
                    <div class="col-md-3">
                        <label>Vendor <span class="required">*</span></label>
                        
                        <?= $this->Form->select('vendor_ledger_id',$partyOptions,['class'=>'form-control select vendor_ledger_id', 'label'=>false,'data-live-search'=>true,'required'=>true]) ?>
                    </div>
                </div>
            <br/>
            </div>
            <div class="row">
                <div class="table-responsive">
                    <table id="main_table" class="table table-condensed table-bordered" style="margin-bottom: 4px;" width="100%">
                        <thead>
                            <tr>
                                <td><label>Item<label></td>
                                <td><label>Unit Variation<label></td>
                                <td><label>Quantity<label></td>
                                <td><label>Purchase Rate Per Unit<label></td>
                                <td><label>Sale Rate Per Unit<label></td>
                                <td><label>Action<label></td>
                            </tr>
                        </thead>
                        <tbody id='main_tbody' class="tab">
                            
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2" >   
                                    <button type="button" class="add_row btn btn-default input-sm"><i class="fa fa-plus"></i> Add row</button>
                                </td>
                                <td>
                                    <?php echo $this->Form->input('total_purchase', ['label' => false,'class' => 'form-control input-sm rightAligntextClass','placeholder'=>'0.00','readonly']); ?>
                                </td>
                                <td>
                                    <?php echo $this->Form->input('total_sale', ['label' => false,'class' => 'form-control input-sm rightAligntextClass','placeholder'=>'0.00','readonly']); ?>
                                </td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>   
        <div class="panel-footer">
                 <center>
                        <?= $this->Form->button(__('Submit'),['class'=>'btn btn-primary']) ?>
                 </center>
        </div>
        <?= $this->Form->end() ?>
    </div>
</div>
<table id="sample_table" style="display:none;" width="100%">
    <tbody>
        <tr class="main_tr" class="tab">
            <td width="">
                <?php echo $this->Form->input('item_id', ['empty'=>'---Select---','options'=>$itemOptions,'label' => false,'class' => 'form-control input-medium ','required'=>'required']); ?>
            </td>
            <td width="">
                <?php echo $this->Form->input('unit_variation_id', ['empty'=>'---Select---','options'=>$unitVariationOptions,'label' => false,'class' => 'form-control input-medium ','required'=>'required']); ?>
            </td>
            <td width="" >
                <?php echo $this->Form->input('quantity', ['label' => false,'class' => 'form-control input-sm numberOnly rightAligntextClass','placeholder'=>'Qty','required']); ?>
            </td>
            <td width="">
                <?php echo $this->Form->input('purchase_rate', ['label' => false,'class' => 'form-control input-sm total numberOnly rightAligntextClass','required'=>'required','placeholder'=>'Purchase Rate','required']); ?> 
            </td>
            <td width="">
                <?php echo $this->Form->input('sale_rate', ['label' => false,'class' => 'form-control input-sm total numberOnly rightAligntextClass','required'=>'required','placeholder'=>'Sale Rate','required']); ?> 
            </td>
            <td align="center">
                <a class="btn btn-danger delete-tr btn-xs" href="#" role="button" style="margin-bottom: 5px;"><i class="fa fa-times"></i></a>
            </td>
        </tr>
    </tbody>
</table>
<!-- END CONTENT FRAME -->
<?= $this->Html->script('plugins/bootstrap/bootstrap-datepicker.js',['block'=>'jsDatePicker']) ?>
<?= $this->Html->script('plugins/bootstrap/bootstrap-select.js',['block'=>'jsSelect']) ?>
<?php
    $js="
    $(document).ready(function() {
        $(document).on('click','.delete-tr',function() 
        {
            $(this).closest('tr').remove();
            rename_rows();
        });

        function calculate()
        { 
            total_purchase=0;
            total_sale=0;
            
            $('#main_table tbody#main_tbody tr.main_tr').each(function()
            { 
                var purchase_rate=parseFloat($(this).find('td:nth-child(4) input').val());
                if(!purchase_rate){ purchase_rate=0; }
                total_purchase=total_purchase+purchase_rate;
                var sale_rate=parseFloat($(this).find('td:nth-child(5) input').val());
                if(!sale_rate){ sale_rate=0; }
                total_sale=total_sale+sale_rate;
            });
            $('input[name=total_purchase]').val(round(total_purchase,2));
            $('input[name=total_sale]').val(round(total_sale,2));
        }
         
        $(document).on('keyup','.total',function(){ 
            calculate();
        });
        
        add_row();

        $(document).on('click','.add_row',function(){ alert();
            add_row();
        });


        function add_row()
        { 
            var tr=$('#sample_table tbody tr.main_tr').clone();
            $('#main_table tbody#main_tbody').append(tr);
            rename_rows();
        }

        function rename_rows()
        {
            var i=0;
            $('#main_table tbody#main_tbody tr.main_tr').each(function()
            {
                $(this).find('td:nth-child(1) select').select().attr({name:'grn_rows['+i+'][item_id]', id:'grn_rows-'+i+'-item_id'});
                 $(this).find('td:nth-child(2) select').select().attr({name:'grn_rows['+i+'][unit_variation_id]', id:'grn_rows-'+i+'-unit_variation_id'});
                $(this).find('td:nth-child(3) input').attr({name:'grn_rows['+i+'][quantity]', id:'grn_rows-'+i+'-quantity'});
                $(this).find('td:nth-child(4) input').attr({name:'grn_rows['+i+'][purchase_rate]', id:'grn_rows-'+i+'-purchase_rate'});
                $(this).find('td:nth-child(5) input').attr({name:'grn_rows['+i+'][sales_rate]', id:'grn_rows-'+i+'-sale_rate'});

                i++;
            });
            calculate();
        }
        function checkValidation()
        {
                $('.submit').attr('disabled','disabled');
                $('.submit').text('Submiting...');
        }
    }); 
    
    
";
echo $this->Html->scriptBlock($js, array('block' => 'scriptBottom'));       
?>
