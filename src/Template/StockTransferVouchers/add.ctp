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
                                                </tr>
                                            </thead>
                                            <tbody id='main_tbody' class="tab">
                                            <?php
                                            $i=0;
                                            foreach($grns->grn_rows as $grn_row){
                                              $grn_row->total_quantity=$grn_row->total_quantity-$grn_row->return_quantity;
                                                ?>

                                                <tr class="main_tr" class="tab">
                                                    <td width="7%" align="center"><?= $i+1 ?></td>
                                                    <td width="25%">
                                                        <?php 
                                                        echo $this->Form->select('grn_rows_id',[$grn_row->id=>$grn_row->item->name.' '.$grn_row->unit_variation->quantity_variation.' '.$grn_row->unit_variation->unit->shortname], ['label' => false,'class' => 'form-control grn_rows_id','required'=>'required']); ?>
                                                        <span class="itemQty" style="color:red ;font-size:10px;">current stock is <?php 
														echo $convert_qty= $grn_row->total_quantity * $grn_row->unit_variation->convert_unit_qty ; ?> <?= ' '.$grn_row->unit_variation->unit->shortname ?> </span>
                                                         <?php echo $this->Form->input('item_quantity', ['label' => false,'class' => 'form-control  rightAligntextClass numberOnly item_quantity hide','placeholder'=>'Quantity','value'=>$convert_qty]); ?>
                                                        </td>
                                                    
                                                    <td width="70%" >
                                                        <table class="item_variation">
                                                            <?php
                                                             $itemOptions=[];
                                                             unset($itemOptions);
                                                            foreach($grn_row->item->item_variations as $item_variation){ 
                                                                    $purchase_rate=($item_variation->unit_variation->convert_unit_qty/$grn_row->unit_variation->convert_unit_qty)*$grn_row->purchase_rate;
                                                                    $itemOptions[]=['value'=>$item_variation->id,'text'=>$item_variation->unit_variation->quantity_variation.' '.$item_variation->unit_variation->unit->shortname,'convert_qty'=>$item_variation->unit_variation->convert_unit_qty,'purchase_rate'=>$purchase_rate,'unit_variation_id'=>$item_variation->unit_variation->id];
                                                            }

                                                                ?>
                                                            <thead style="display: none;">
                                                                 <tr>
                                                                <td>
                                                                <?php 
                                                                     echo $this->Form->select('item_variation_id',$itemOptions, ['label' => false,'class' => 'form-control item_variation','required'=>true,'disabled'=>true]); ?>
                                                               <?php 
                                                        echo $this->Form->select('grn_row_id',[$grn_row->id=>$grn_row->item->name.' '.$grn_row->unit_variation->quantity_variation.' '.$grn_row->unit_variation->unit->shortname], ['label' => false,'class' => 'form-control grn_row_id hide','required'=>'required','disabled'=>true]); ?>
                                                                <?php echo $this->Form->input('item_id', ['label' => false,'class' => 'form-control  rightAligntextClass numberOnly item_id hide','type'=>'text','placeholder'=>'Item Id','value'=>$grn_row->item_id,'disabled'=>true]); ?>
                                                                <?php echo $this->Form->input('unit_variation_id', ['label' => false,'class' => 'form-control  rightAligntextClass numberOnly unit_variation_id hide','placeholder'=>'unit_variation_id','type'=>'text','value'=>$grn_row->unit_variation_id,'disabled'=>true]); ?>
                                                                <?php echo $this->Form->input('purchase_rate', ['label' => false,'class' => 'form-control  rightAligntextClass numberOnly purchase_rate hide','placeholder'=>'purchase_rate','type'=>'text','disabled'=>true]); ?>
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
                                                                      <?php 
                                                                    echo $this->Form->select('grn_row_id',[$grn_row->id=>$grn_row->item->name.' '.$grn_row->unit_variation->quantity_variation.' '.$grn_row->unit_variation->unit->shortname], ['label' => false,'class' => 'form-control grn_row_id hide','required'=>'required']); ?>
                                                                      <?php echo $this->Form->input('item_id', ['label' => false,'class' => 'form-control  rightAligntextClass numberOnly item_id hide','type'=>'text','placeholder'=>'Item Id','value'=>$grn_row->item_id]); ?>
                                                                <?php echo $this->Form->input('unit_variation_id', ['label' => false,'class' => 'form-control  rightAligntextClass numberOnly unit_variation_id hide','placeholder'=>'unit_variation_id','type'=>'text','value'=>$grn_row->unit_variation_id]); ?>
                                                                 <?php echo $this->Form->input('purchase_rate', ['label' => false,'class' => 'form-control  rightAligntextClass numberOnly purchase_rate hide','placeholder'=>'purchase_rate','type'=>'text','disabled'=>true]); ?>
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
                                                                    <td>Total Quantity</td>
                                                                    <td> <?php echo $this->Form->input('total_quantity_transfer', ['label' => false,'class' => 'form-control input-sm rightAligntextClass numberOnly total_quantity_transfer','placeholder'=>'Total Quantity','readonly'=>true]); ?></td>
                                                                    <td  colspan="2"></td>
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                        
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

<?= $this->Html->script('plugins/bootstrap/bootstrap-datepicker.js',['block'=>'jsDatePicker']) ?>
<?= $this->Html->script('plugins/bootstrap/bootstrap-select.js',['block'=>'jsSelect']) ?>
<?php
    $js="
    $(document).ready(function() {
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
            var variation_stock=0;
            var item_quantity =parseFloat($(this).closest('table').closest('tr.main_tr').find('td:eq(1) input.item_quantity').val());
             $(this).closest('tbody').find('tr').each(function(){ 
                var convert_qty = parseFloat($(this).find('td:eq(0) select option:selected').attr('convert_qty'));
                var quantity = parseFloat($(this).find('td:eq(1) input').val());
                variation_stock += round(convert_qty*quantity,2);
            });
            if(variation_stock > item_quantity)
            {
                alert('Error: Stock is going in minus. Please Check?');
                $(this).val(
                    function(index, value){
                        return value.substr(0, value.length - 1);
                });
            }
            else
            {
                $(this).closest('table').find('tfoot input.total_quantity_transfer').val(variation_stock)
            }
           
        });

        $(document).on('change','select.item_variation',function(){ 

              var purchase_rate =  parseFloat($(this).closest('td').find('select.item_variation option:selected').attr('purchase_rate'));
              var unt_variation_id =  parseFloat($(this).closest('td').find('select.item_variation option:selected').attr('unit_variation_id'));
			  
			 $(this).closest('tr').find('.unit_variation_id').val(unt_variation_id);
             $(this).closest('td').find('input.purchase_rate').val(purchase_rate);
             $(this).closest('tr').find('td:eq(1) input').trigger('keyup');
        });

        function rename_rows()
        {
            var i=0;
            var j=0;
            $('#main_table tbody#main_tbody tr.main_tr').each(function(){ 
                $(this).find('td:eq(0)').html(j+1);
               $(this).find('td:eq(1) select.grn_rows_id').attr({name:'grn_rows['+j+'][grn_row_id]',id:'grn_rows-'+j+'-grn_row_id'});
               $(this).find('td:eq(1) input.item_quantity').attr({name:'grn_rows['+j+'][quantity]',id:'grn_rows-'+j+'-quantity'});

                $(this).find('td:eq(2)').find('table.item_variation >tbody >tr').each(function(){
                        $(this).find('td:eq(0) select.item_variation').attr({name:'stock_transfer_voucher_rows['+i+'][item_variation_id]', id:'stock_transfer_voucher_rows-'+i+'-item_variation_id'}).prop('disabled',false);
                         $(this).find('td:eq(0) select.grn_row_id').attr({name:'stock_transfer_voucher_rows['+i+'][grn_row_id]', id:'stock_transfer_voucher_rows-'+i+'-grn_row_id'}).prop('disabled',false);
                         $(this).find('td:eq(0) input.item_id').attr({name:'stock_transfer_voucher_rows['+i+'][item_id]', id:'stock_transfer_voucher_rows-'+i+'-item_id'}).prop('disabled',false);
                          $(this).find('td:eq(0) input.unit_variation_id').attr({name:'stock_transfer_voucher_rows['+i+'][unit_variation_id]', id:'stock_transfer_voucher_rows-'+i+'-unit_variation_id'}).prop('disabled',false);
                           $(this).find('td:eq(0) input.purchase_rate').attr({name:'stock_transfer_voucher_rows['+i+'][purchase_rate]', id:'stock_transfer_voucher_rows-'+i+'-purchase_rate'}).prop('disabled',false);
                            
                            var purchase_rate = parseFloat($(this).find('td:eq(0) select.item_variation option:selected').attr('purchase_rate'));
                             $(this).find('td:eq(0) input.purchase_rate').val(purchase_rate);

                        $(this).find('td:eq(1) input').attr({name:'stock_transfer_voucher_rows['+i+'][quantity]', id:'stock_transfer_voucher_rows-'+i+'-quantity'}).prop('disabled',false);
                        $(this).find('td:eq(1) input').trigger('keyup');
                        $(this).find('td:eq(2) input').attr({name:'stock_transfer_voucher_rows['+i+'][sales_rate]', id:'stock_transfer_voucher_rows-'+i+'-sales_rate'}).prop('disabled',false);
                        i++;
                    });
                    $(this).find('td:eq(2)').find('table.item_variation >tfoot >tr').each(function(){
                              $(this).find('td:eq(1) input.total_quantity_transfer').attr({name:'grn_rows['+j+'][transfer_quantity]', id:'grn_rows-'+j+'-transfer_quantity'}).prop('disabled',false);
                        });
                    
                j++;
                
            });
        }

        
    });

    function checkValidation() 
    {  
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