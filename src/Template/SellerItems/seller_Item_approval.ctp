<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}
</style>
<?php $this->set('title', 'Seller Item Approve'); ?>
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
	<div class="row">
		<div class="col-md-12">
		<?= $this->Form->create($sellerItemApproval,['id'=>"jvalidate"]) ?>  
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong> Seller Item Approve</strong></h3>
				</div>
			
				<div class="panel-body">    
					<div class="row">
						<div class="col-md-3">
							<div class="form-group">
								<label class="control-label">Seller</label>
									<?= $this->Form->select('seller_id',$sellers,['class'=>'form-control select seller_change', 'data-live-search'=>true, 'label'=>false,'empty'=>'--Select--']) ?>
							</div>
						</div>
					</div>
				</div>
				<div class="panel-body">    
					<div class="row">
						<div class="table-responsive">
							
						</div>
					</div>
				</div>
				<div class="panel-footer show_hide" style="display:none;">
					<center>
						<?= $this->Form->button(__('Submit'),['class'=>'btn btn-primary']) ?>
					</center>
				</div>
			
			<?= $this->Form->end() ?>
		</div>
	</div>                    	
</div>

<?= $this->Html->script('plugins/bootstrap/bootstrap-datepicker.js',['block'=>'jsDatePicker']) ?>
<?= $this->Html->script('plugins/bootstrap/bootstrap-select.js',['block'=>'jsSelect']) ?>
<?= $this->Html->script('plugins/jquery-validation/jquery.validate.js',['block'=>'jsValidate']) ?>

<?php
   $js='var jvalidate = $("#jvalidate").validate({
		ignore: [],
			rules: {                                            
					name: {
							required: true,
					},
					
					email: {
							required: true,
					},
					username: {
							required: true,
					},
					
			}	                                  
		});
		
		$(document).on("change",".seller_change",function(){
			var seller_id = $(this).val(); 
			if(seller_id!="")
			{
				
				var url =   "'.$this->Url->build(["controller"=>"SellerItems","action"=>"getItemVariationDetail"]).'"
				url =   url+"?seller_id="+seller_id;	
				$(".table-responsive").html("<b> Loading... </b>");	
				$.ajax({
						url: url,
				}).done(function(response){ 
							 $(".table-responsive").html(response);  
				});
				$(".show_hide").show();
			}
			else
			{
				$(".show_hide").hide();
			}
		});
		
		
		
	
		';  
echo $this->Html->scriptBlock($js, array('block' => 'scriptBottom')); 		
?>