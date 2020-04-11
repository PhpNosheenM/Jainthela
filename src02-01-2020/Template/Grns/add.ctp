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

</style><?php $this->set('title', 'Create GRN'); ?>
<div class="page-content-wrap">
    <div class="page-title">                    
        <h2><span class="fa fa-arrow-circle-o-left"></span> Create GRN</h2>
    </div> 
   
    <div class="panel panel-default">
        <?= $this->Form->create($grn,['id'=>"jvalidate",'class'=>"form-horizontal"]) ?>  
      
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
            
            </div>
            <br/>
            <div class="row">
                <div class="">
                    <table id="main_table" class="table table-condensed table-bordered" style="margin-bottom: 4px;" width="100%">
                        <thead>
                            <tr>
                                <td><label>S.No<label></td>
                                <td><label>Item<label></td>
                                <td><label>Unit Variation<label></td>
                                <td><label>Quantity<label></td>
                                <td><label>Rate<label></td>
                                <td><label>Taxable Amount<label></td>
								<td><label>GST<label></td>
								<td><label>Net Amount<label></td>
                                <td><label>Expiry Date<label></td>
                                <td><label>Action<label></td>
                            </tr>
                        </thead>
                        <tbody id='main_tbody' class="tab">
                            
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="6" >   
                                    <button type="button" class="add_row btn btn-default input-sm"><i class="fa fa-plus"></i> Add row</button>
                                </td>
                                <td colspan="2">
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
                        <?= $this->Form->button(__('Submit'),['class'=>'btn btn-primary submit']) ?>
                 </center>
        </div>
        <?= $this->Form->end() ?>
    </div>
</div>
<?php $GstType['excluding'] = 'Exc'; ?>
<?php $GstType['including'] = 'Inc'; ?>
<table id="sample_table" style="display:none;" width="100%">
    <tbody>
        <tr class="main_tr" class="tab">
            <td width="">
            
            </td>
            <td width="">
                <?php echo $this->Form->input('item_id', ['empty'=>'---Select---','options'=>$itemOptions,'label' => false,'class' => 'form-control input-medium item_id','required'=>'required', 'data-live-search'=>true]); ?>
            </td>
            <td id="unit_variations">
                
            </td>
            <td width="" >
                <?php echo $this->Form->input('quantity', ['label' => false,'class' => 'form-control input-sm numberOnly rightAligntextClass total quantity','placeholder'=>'Qty','required'=>true]); ?>
            </td>
            <td width="">
                <?php echo $this->Form->input('rate', ['label' => false,'class' => 'form-control input-sm total numberOnly rightAligntextClass rate','required'=>'required','placeholder'=>'Purchase Rate','required']); ?> 
            </td>
			<td width="">
                <?php echo $this->Form->input('amount', ['label' => false,'class' => 'form-control input-sm total numberOnly rightAligntextClass amount','required'=>'required','placeholder'=>'Purchase Amount','required','type' => 'hidden']); ?> 
				 <?php echo $this->Form->input('taxable_value', ['label' => false,'class' => 'form-control input-sm total numberOnly rightAligntextClass taxable_value','required'=>'required','placeholder'=>'Taxable','required','readonly']); ?> 
            </td>
			<td width="">
				<?php echo $this->Form->input('gst_value', ['label' => false,'class' => 'form-control input-sm total numberOnly rightAligntextClass gst_value','required'=>'required','placeholder'=>'Purchase Rate','required']); ?> 
            </td>
           <td>
				<?php echo $this->Form->input('net_amount', ['label' => false,'class' => 'form-control input-sm total numberOnly rightAligntextClass net_amount','required'=>'required','placeholder'=>'','required']); ?> 
				<?php echo $this->Form->input('purchase_rate', ['label' => false,'class' => 'form-control input-sm total numberOnly rightAligntextClass purchase_rate','required'=>'required','placeholder'=>'Purchase Rate','required','type' => 'hidden']); ?> 
				
				</td>
			
			<td width="">
				<?php echo $this->Form->control('expiry_date',['class'=>'form-control datepicker temp expiry_date','data-date-format'=>'dd-mm-yyyy', 'label'=>false,'placeholder'=>'DD-MM-YYYY','type'=>'text','data-date-start-date'=>@$coreVariable[fyValidFrom],'data-date-end-date'=>@$coreVariable[fyValidTo],'value'=>date('d-m-Y'),'data-date-format' => 'dd-mm-yyyy','required'=>'required']); ?>
            </td>
			
            <td align="center">
                <a class="btn btn-danger delete-tr btn-xs" href="#" role="button" style="margin-bottom: 5px;"><i class="fa fa-times"></i></a>
				<?= $this->Form->select('gst_type',$GstType,['class'=>'form-control gst_type','label'=>false]) ?>
                 
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
        });
        
        $(document).on('change','.item_id',function(){
            var item_id=$('option:selected', this).val();
            var item_id=$(this).closest('tr').find('select.item_id option:selected').val();
            //var item_id=$(this).closest('tr').find('.item_id option:selected').attr('value'));
            var temp =$(this);
            var url='".$this->Url->build(["controller" => "Items", "action" => "SelectItemVariation"])."';
            url=url+'/'+item_id
			
            $.ajax({
                url: url,
                type: 'GET'
            }).done(function(response) {
                temp.closest('tr').find('#unit_variations').html(response);
                 //rename_rows();
            });
        });
        
        function calculate(thisObj)
        { 
            var gst_type=thisObj.find('.gst_type option:selected').val();
            if(gst_type=='excluding'){
                var quantity=parseFloat(thisObj.find('.quantity').val());
                if(!quantity){ quantity=0; }
                var rate=parseFloat(thisObj.find('.rate').val());
                if(!rate){ rate=0; }
                amount=rate*quantity;
                thisObj.find('.amount').val(round(amount,2));
                
                taxable_value=amount;
                gst_percentage=parseFloat(thisObj.find('.item_id option:selected').attr('tax_percentage'));
                if(!gst_percentage){ 
                    gst_rate=0;
                }else{ 
                    gst_rate=round(round(taxable_value*gst_percentage)/100,2);
                    gst_rate1=round((gst_rate/2),2);
                    gst_rate=round((gst_rate1*2),2);
                }
                var net_mount=gst_rate+taxable_value;
                var curRate=net_mount/quantity;
                thisObj.find('.taxable_value').val(round(taxable_value,2));
                thisObj.find('.gst_value').val(round(gst_rate,2));
                thisObj.find('.purchase_rate').val(round(curRate,2));
                thisObj.find('.net_amount').val(round(net_mount,2));
            }else{
                var quantity=parseFloat(thisObj.find('.quantity').val());
                if(!quantity){ quantity=0; }
                var rate=parseFloat(thisObj.find('.rate').val());
                if(!rate){ rate=0; }
                amount=rate*quantity;
                thisObj.find('.amount').val(round(amount,2));
                
                taxable_value=amount;
                gst_percentage=parseFloat(thisObj.find('.item_id option:selected').attr('tax_percentage'));
                if(!gst_percentage){ 
                    gst_rate=0;
                }else{ 
                    var x=100+gst_percentage;
                    gst_rate=(round((taxable_value*gst_percentage)/x,2));
                    gst_rate1=round((gst_rate/2),2);
                    gst_rate=round((gst_rate1*2),2);
                } 
                taxable_value=taxable_value-gst_rate;
                thisObj.find('.taxable_value').val(round(taxable_value,2));
                var net_mount=gst_rate+taxable_value; 
                var curRate=net_mount/quantity;
                thisObj.find('.gst_value').val(round(gst_rate,2));
                thisObj.find('.purchase_rate').val(round(curRate,2));
                thisObj.find('.net_amount').val(round(net_mount,2));
            }
        }
         
        $(document).on('keyup','.total',function(){
            var thisObj= $(this).closest('tr');
            calculate(thisObj);
        });
        $(document).on('click','.add_row',function(){ 
            add_row();
        });
        $(document).on('change','.gst_type',function(){
            var thisObj= $(this).closest('tr');
            calculate(thisObj);
        });
        add_row();
        function add_row()
        { 
            var tr=$('#sample_table tbody tr.main_tr').clone();
            $('#main_table tbody#main_tbody').append(tr);
            $('#main_table tbody#main_tbody tr.main_tr').last().find('.item_id').selectpicker();
            //$('#main_table tbody#main_tbody tr.main_tr').last().find('.gst_type').selectpicker();
			$('.temp').datepicker();
            rename_first_rows();
        }
        function rename_first_rows()
        {
            var i=0;
            $('#main_table tbody#main_tbody tr.main_tr').each(function()
            {               
                $(this).find('td:nth-child(1)').html(++i); 
            });
        }
        
        $(document).on('submit','#jvalidate',function(e){
            e.preventDefault();
            $('.submit').attr('disabled','disabled');
            $('.submit').text('Submiting...');
            var total_purchase=0;
            var net_mount=0;
            $('#main_table tbody#main_tbody tr.main_tr').each(function(){
                net_mount = $(this).find('.net_amount').val();
                total_purchase=total_purchase+round(net_mount,2);
            });
            $('input[name=total_purchase_rate]').val(round(total_purchase,2));
           
            var urlgrn = '".$this->Url->build(['action'=>'addGrn.json'])."';
                
                var vendor_ledger_id  = $('select[name=vendor_ledger_id]').val();
                var transaction_date   =$('input[name=transaction_date]').val();
                var total_purchase_rate= $('input[name=total_purchase_rate]').val();
                var reference_no= $('input[name=reference_no]').val();
                $.ajax({
                    url: urlgrn,
                    type: 'get',
                    dataType: 'json',
                    data: {vendor_ledger_id:vendor_ledger_id,transaction_date:transaction_date,total_purchase_rate:total_purchase_rate,reference_no:reference_no},
                    success: function(result)
                    {
                        
                        var obj = JSON.parse(JSON.stringify(result));
                        var grn_id = obj.response;
                        var url = '".$this->Url->build(['action'=>'addGrnRow.json'])."';
                        var i=0;
                        $('#main_table tbody#main_tbody tr.main_tr').each(function()
                        {
                            $(this).find('.item_id').attr({name:'grn_rows['+i+'][item_id]', id:'grn_rows-'+i+'-item_id'});
                             $(this).find('.unit_variation_id').attr({name:'grn_rows['+i+'][unit_variation_id]', id:'grn_rows-'+i+'-unit_variation_id'});
                            $(this).find('.quantity').attr({name:'grn_rows['+i+'][quantity]', id:'grn_rows-'+i+'-quantity'});
                            $(this).find('.amount').attr({name:'grn_rows['+i+'][amount]', id:'grn_rows-'+i+'-amount'});
                            $(this).find('.taxable_value').attr({name:'grn_rows['+i+'][taxable_value]', id:'grn_rows-'+i+'-taxable_value'});
                            $(this).find('.rate').attr({name:'grn_rows['+i+'][rate]', id:'grn_rows-'+i+'-rate'});
                            
                            
                            $(this).find('.purchase_rate').attr({name:'grn_rows['+i+'][purchase_rate]', id:'grn_rows-'+i+'-purchase_rate'});
                        
                             $(this).find('.net_amount').attr({name:'grn_rows['+i+'][net_amount]', id:'grn_rows-'+i+'-net_amount'});

                             $(this).find('.gst_value').attr({name:'grn_rows['+i+'][gst_value]', id:'grn_rows-'+i+'-gst_value'});
                             
                            
                             $(this).find('.gst_type').attr({name:'grn_rows['+i+'][gst_type]', id:'grn_rows-'+i+'-gst_type'});
                             
                             $(this).find('.expiry_date').datepicker().attr({name:'grn_rows['+i+'][expiry_date]', id:'grn_rows-'+i+'-expiry_date'});
                            
                            
                           
                            var item_id = $('#grn_rows-'+i+'-item_id').val();
                            var unit_variation_id = $('#grn_rows-'+i+'-unit_variation_id').val();
                            var quantity = $('#grn_rows-'+i+'-quantity').val();
                            var amount = $('#grn_rows-'+i+'-amount').val();
                            var taxable_value = $('#grn_rows-'+i+'-taxable_value').val();
                            var gst_value = $('#grn_rows-'+i+'-gst_value').val();
                            var rate = $('#grn_rows-'+i+'-rate').val();
                            var purchase_rate = $('#grn_rows-'+i+'-purchase_rate').val();
                            var net_amount = $('#grn_rows-'+i+'-net_amount').val();
                            var gst_type = $('#grn_rows-'+i+'-gst_type').val();
                            var expiry_date = $('#grn_rows-'+i+'-expiry_date').val();
                            
                            
                            $.ajax({
                                url: url,
                                type: 'get',
                                dataType: 'json',
                                data: {item_id:item_id,unit_variation_id:unit_variation_id,quantity:quantity,amount:amount,taxable_value:taxable_value,rate:rate,purchase_rate:purchase_rate,net_amount:net_amount,gst_type:gst_type,expiry_date:expiry_date,grn_id:grn_id,gst_value:gst_value},
                                success: function(result)
                                {
                                    //var obj = JSON.parse(JSON.stringify(result));
                                    //console.log(obj.response);
                                },
                                error: function (XMLHttpRequest, textStatus, errorThrown) {
                                    console.log(textStatus);
                                }
                            }); 
                            i++;
                        }).promise().done(function () { 
                            setTimeout(function(){ redirectpage(); }, 3000);
                        });
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        console.log(errorThrown);
                        $('.submit').removeAttr('disabled');
                        $('.submit').text('Submit');
                    }
                }); 
            
            
        });
        function redirectpage()
        {
            window.location.href = '".$this->Url->build(["controller" => "Grns", "action" => "index"], true)."';
        }
        var csrf = '".json_encode($this->request->getParam('_csrfToken'))."';
        $.ajaxSetup({
            headers: { 'X-CSRF-Token': csrf },
            error: function(){}
        });
    }); 
    
    
";
echo $this->Html->scriptBlock($js, array('block' => 'scriptBottom'));       
?>
