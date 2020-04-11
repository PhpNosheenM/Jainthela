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
        <?= $this->Form->create($grn,['id'=>"jvalidate",'class'=>"form-horizontal"]) ?>  
       
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                   
                
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Transaction Date <span class="required">*</span></label>
                            <?php echo $this->Form->control('transaction_date',['class'=>'form-control datepicker','data-date-format'=>'dd-mm-yyyy', 'label'=>false,'placeholder'=>'DD-MM-YYYY','type'=>'text','data-date-start-date'=>@$coreVariable[fyValidFrom],'data-date-end-date'=>@$coreVariable[fyValidTo],'value'=>date('d-m-Y'),'data-date-format' => 'dd-mm-yyyy','required'=>'required']); ?>
                        </div>
                    </div><div class="col-md-3">
                        <div class="form-group">
                            <label>Locations <span class="required">*</span></label>
                            <?php echo $this->Form->input('location_id', ['empty'=>'---Select---','options'=>$Locations,'label' => false,'class' => 'form-control input-medium item_variation_id','required'=>'required']); ?>
                        </div>
                    </div>
                 
                   
                </div>
            
            </div>
            <br/>
            <div class="row">
                <div class="table-responsive">
                    <table id="main_table" class="table table-condensed table-bordered" style="margin-bottom: 4px;" width="100%">
                        <thead>
                            <tr>
                                <td><label>Item<label></td>
                                <td><label>Quantity<label></td>
                                <td><label>Sales Rate<label></td>
                                <td><label>Expiry Date<label></td>
                                <td><label>Action<label></td>
                            </tr>
                        </thead>
                        <tbody id='main_tbody' class="tab">
                            
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" >   
                                    <button type="button" class="add_row btn btn-default input-sm"><i class="fa fa-plus"></i> Add row</button>
                                </td>
                                <td>
                                    <?php echo $this->Form->input('total_purchase_rate', ['label' => false,'class' => 'form-control input-sm rightAligntextClass','placeholder'=>'0.00','readonly']); ?>
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
                <?php echo $this->Form->input('item_variation_id', ['empty'=>'---Select---','options'=>$itemOptions,'label' => false,'class' => 'form-control input-medium item_variation_id','required'=>'required']); ?>
                <?php echo $this->Form->input('unit_variation_id', ['label' => false,'class' => 'form-control input-medium unit_variation_id','type'=>'hidden']); ?>
                <?php echo $this->Form->input('item_id', ['label' => false,'class' => 'form-control input-medium item_id','type'=>'hidden']); ?>
            </td>
            
            <td width="" >
                <?php echo $this->Form->input('quantity', ['label' => false,'class' => 'form-control input-sm numberOnly rightAligntextClass total quantity','placeholder'=>'Qty','required'=>true]); ?>
            </td>
            <td width="">
                <?php echo $this->Form->input('purchase_rate', ['label' => false,'class' => 'form-control input-sm total numberOnly rightAligntextClass purchase_rate','required'=>'required','placeholder'=>'Rate','required','readonly']); ?> 
            </td>
			
			<td width="">
				<?php echo $this->Form->control('expiry_date',['class'=>'form-control datepicker expiry_date','data-date-format'=>'dd-mm-yyyy', 'label'=>false,'placeholder'=>'DD-MM-YYYY','type'=>'text','data-date-start-date'=>@$coreVariable[fyValidFrom],'data-date-end-date'=>@$coreVariable[fyValidTo],'value'=>date('d-m-Y'),'data-date-format' => 'dd-mm-yyyy','required'=>'required']); ?>
            </td>
            <td align="center">
                <a class="btn btn-danger delete-tr btn-xs" href="#" role="button" style="margin-bottom: 5px;"><i class="fa fa-times"></i></a>
                 <?php echo $this->Form->input('net_amount', ['label' => false,'class' => 'form-control input-sm total numberOnly rightAligntextClass net_amount','required'=>'required','placeholder'=>'','required','style'=>'display:none']); ?> 
            </td>
        </tr>
    </tbody>
</table>
<!-- END CONTENT FRAME -->
<?= $this->Html->script('plugins/bootstrap/bootstrap-datepicker.js',['block'=>'jsDatePicker']) ?>
<?= $this->Html->script('plugins/bootstrap/bootstrap-select.js',['block'=>'jsSelect']) ?>
<?= $this->Html->script('plugins/jquery-validation/jquery.validate.js',['block'=>'jsValidate']) ?>
<?php
    $js="var jvalidate = $('#jvalidate').validate({ 
		ignore: [],
			rules: {                                            
					vendor_ledger_id: {
							required: true,
					}
					
			}	                                  
		});
		
	
		
    $(document).ready(function() {
        $(document).on('click','.delete-tr',function() 
        {
            $(this).closest('tr').remove();
            rename_rows();
        });
	
		$(document).on('change','.item_variation_id',function(){ 
			var purchase_rate=$(this).find('option:selected', this).attr('purchase_rate'); 
			var unit_variation_id=$(this).find('option:selected', this).attr('unit_variation_id'); 
			var item_id=$(this).find('option:selected', this).attr('item_id'); 
			$(this).closest('tr').find('.purchase_rate').val(purchase_rate);
			$(this).closest('tr').find('.unit_variation_id').val(unit_variation_id);
			$(this).closest('tr').find('.item_id').val(item_id);
			calculate(); 
		});
		
        function calculate()
        { 
            total_purchase=0;
            
            $('#main_table tbody#main_tbody tr.main_tr').each(function()
            { 
                var quantity=parseFloat($(this).find('.quantity').val());
                if(!quantity){ quantity=0; }

                var purchase_rate=parseFloat($(this).find('.purchase_rate').val());
                if(!purchase_rate){ purchase_rate=0; }
                var net_mount = quantity*purchase_rate;
               $(this).find('.net_amount').val(round(net_mount,2));

                total_purchase=total_purchase+round(net_mount,2);
            });
            $('input[name=total_purchase_rate]').val(round(total_purchase,2));
        }
         
        $(document).on('keyup','.total',function(){ 
            calculate();
        });
        
        add_row();

        $(document).on('click','.add_row',function(){ 
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
                $(this).find('.item_variation_id').select().attr({name:'grn_rows['+i+'][item_variation_id]', id:'grn_rows-'+i+'-item_variation_id'});
                 $(this).find('.unit_variation_id').attr({name:'grn_rows['+i+'][unit_variation_id]', id:'grn_rows-'+i+'-unit_variation_id'});
                 $(this).find('.item_id').attr({name:'grn_rows['+i+'][item_id]', id:'grn_rows-'+i+'-item_id'});
				  $(this).find('.quantity').attr({name:'grn_rows['+i+'][quantity]', id:'grn_rows-'+i+'-quantity'});
                $(this).find('.quantity').attr({name:'grn_rows['+i+'][quantity]', id:'grn_rows-'+i+'-quantity'});
                $(this).find('.purchase_rate').attr({name:'grn_rows['+i+'][purchase_rate]', id:'grn_rows-'+i+'-purchase_rate'});
                 $(this).find('.net_amount').attr({name:'grn_rows['+i+'][net_amount]', id:'grn_rows-'+i+'-net_amount'});
                 $(this).find('.expiry_date').datepicker().attr({name:'grn_rows['+i+'][expiry_date]', id:'grn_rows-'+i+'-expiry_date'});
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
