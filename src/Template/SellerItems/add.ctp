<?php $this->set('title', 'Seller Item'); ?>
    
<div class="page-content-wrap">
	<div class="row">
		<div class="col-md-12">
		<?= $this->Form->create($sellerItem,['id'=>"jvalidate",'class'=>"form-horizontal"]) ?>  
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong>Seller Item</strong></h3>
				</div>
				<div class="panel-body">   			
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
							<div class="col-md-3">   
								<label class="control-label">Seller Name</label>
								    <?= $this->Form->select('seller_id',$sellers,['class'=>'form-control select seller_change','label'=>false, 'data-live-search'=>true,'empty'=>'--Select--']) ?>
							</div>
							</div>
							<div class="form-group">
								<div class="col-md-12" >    
									<div class="panel-group accordion accordion-dc" id="attach">
									
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="panel-footer">
					<center>
						<?= $this->Form->button(__('Submit'),['class'=>'btn btn-primary']) ?>
					</center>
				</div>
			</div>
			
						
			
			<?= $this->Form->end() ?>
		</div>
	</div>                    	
</div>
<?= $this->Html->script('plugins/bootstrap/bootstrap-select.js',['block'=>'jsSelect']) ?>
<?php
$js='
		$(document).on("change",".check_all",function(){ 
			if($(this).is(":checked"))
			{
				$(this).closest(".panel").find("input[type=checkbox]").prop("checked",true);
				$(this).closest(".panel").find("input[type=text]").prop("disabled",false);
			}
			else
			{
				$(this).closest(".panel").find("input[type=checkbox]").prop("checked",false);
				$(this).closest(".panel").find("input[type=text]").prop("disabled",true);
			}
		});
		$(document).on("change",".single_item",function(){ 
			var item_id = $(this).val();
			if($(this).is(":checked"))
			{
				$(this).closest("div").find("input[item_id="+item_id+"]").prop("disabled",false);
			}
			else
			{
				$(this).closest("div").find("input[item_id="+item_id+"]").prop("disabled",true);
			}
		});
		$(document).on("keyup",".commission_all",function(){
			$(this).closest(".panel").find("input[type=text]").val($(this).val());
		});
		$(document).on("change",".seller_change",function(){
			var seller_id =$(this).val(); 
			if(seller_id!="")
			{
				$("#attach").html("<b> Loading... </b>");	
				var url =   "'.$this->Url->build(["controller"=>"SellerItems","action"=>"getSellerItems"]).'";
				url =   url+"?id="+seller_id;	
				var js =  "'.$this->Url->build(["controller"=>"/js/accordion.js"]).'";
				$.ajax({
								url: url,
				}).done(function(response){ 
							   $("#attach").html(response);
							   $(".panel-body").show();
							   $.getScript(js);
				});
			}else{$("#attach").html(" ");}
			
		});
';
echo $this->Html->scriptBlock($js, array('block' => 'scriptBottom')); 	
?>
