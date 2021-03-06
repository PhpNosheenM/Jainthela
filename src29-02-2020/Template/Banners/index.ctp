<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}

</style><?php $this->set('title', 'Banner'); ?>
<div class="page-content-wrap">
        <div class="page-title">                    
			<h2> Banner</h2>
		</div>
	<div class="row">
				<div class="col-md-4">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">ADD BANNER</h3>
						</div>
						<?= $this->Form->create($banner,['id'=>"jvalidate",'type'=>'file']) ?>
						<?php $js=''; ?>
						<div class="panel-body">
						    <div class="form-group">
									<label>Name</label>
									<?= $this->Form->control('name',['class'=>'form-control','placeholder'=>'Name','label'=>false]) ?>
									<span class="help-block"></span>
					        </div>
							<div class="form-group">
									<label>Link Name</label>
									<?php
										$options1['product_description'] = 'Product Description';
										$options1['combo_description'] = 'Combo Description';
										$options1['category_wise'] = 'Product listing Category Wise';
										$options1['item_wise'] = 'Product listing Item Wise';
										$options1['category_wise_combo'] = 'Combo listing Category Wise';
										$options1['item_wise_combo'] = 'Combo listing Item Wise';
										$options1['refer'] = 'Refer And Earn';
										$options1['wallet'] = 'Wallet Plans';
										$options1['bulk_booking'] = 'Bulk Booking';
										$options1['order'] = 'Order Detail';
										$options1['cart'] = 'Cart Listing';
										$options1['store'] = 'Store listing';
										$options1['store_item_wise'] = 'Store Item listing';
										$options1['webview_html'] = 'Webview Html';
										$options1['webview_url'] = 'Webview Url'; 
									?>
									<?= $this->Form->select('link_name',$options1,['empty'=>'Select Link Name','class'=>'form-control select','label'=>false]) ?>
									<?php //$this->Form->control('link_name',['class'=>'form-control','placeholder'=>'Link Name','label'=>false]) ?>
									<span class="help-block"></span>
					        </div>
									<div class="form-group">
                                        <div class="col-md-4">
                                            <label class="check"><input type="radio" id="cat" value="1" class="iradio" name="iradio" checked="checked" /> Category</label>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="check"><input type="radio" id="itm"  value="2"  class="iradio" name="iradio"/> Item</label>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="check"><input type="radio" id="slr"  value="3" class="iradio" name="iradio"/> Seller</label>
                                        </div>
										<div class="col-md-4">
                                            <label class="check"><input type="radio" id="cmbo"  value="4" class="iradio" name="iradio"/> Combo</label>
                                        </div>
										<div class="col-md-4">
                                            <label class="check"><input type="radio" id="vrtn"  value="5" class="iradio" name="iradio"/> Item Variation</label>
                                        </div>
                                    </div>
									<br>
									<br>
									<br>
									<br>
									<div class="form-group" id="cat_id" >
										<label>Category</label>
										<?= $this->Form->select('category_id',$categories,['id'=>'category_id','empty'=>'Select Categories','class'=>'form-control select','label'=>false]) ?>
										<?php //$this->Form->control('link_name',['class'=>'form-control','placeholder'=>'Link Name','label'=>false]) ?>
										<span class="help-block"></span>
									</div>
									<div class="form-group" id="itm_id" style="display:none !important;">
										<label>Item</label>
										<?= $this->Form->select('item_id',$Items,['id'=>'item_id','empty'=>'Select Items','class'=>'form-control select','label'=>false]) ?>
										<?php //$this->Form->control('link_name',['class'=>'form-control','placeholder'=>'Link Name','label'=>false]) ?>
										<span class="help-block"></span>
									</div>
									<div class="form-group" id="slr_id" style="display:none !important;">
										<label>Seller</label>
										<?= $this->Form->select('seller_id',$Sellers,['id'=>'seller_id','empty'=>'Select Sellers','class'=>'form-control select','label'=>false]) ?>
										<?php //$this->Form->control('link_name',['class'=>'form-control','placeholder'=>'Link Name','label'=>false]) ?>
										<span class="help-block"></span>
									</div>
									<div class="form-group" id="combo_id" style="display:none !important;">
										<label>Combo Offers</label>
										<?= $this->Form->select('combo_offer_id',$ComboOffers,['id'=>'combo_offer_id','empty'=>'Select Combo Offers','class'=>'form-control select','label'=>false]) ?>
										<?php //$this->Form->control('link_name',['class'=>'form-control','placeholder'=>'Link Name','label'=>false]) ?>
										<span class="help-block"></span>
									</div>
									<div class="form-group" id="var_id" style="display:none !important;">
										<label>Item Variation</label>
										<?= $this->Form->select('variation_id',$variation_options,['id'=>'variation_id','empty'=>'Select Item Variation','class'=>'form-control select','label'=>false]) ?>
										<?php  //$this->Form->control('link_name',['class'=>'form-control','placeholder'=>'Link Name','label'=>false]) ?>
										<span class="help-block"></span>
									</div>
							<div class="form-group" id="web_image_data">
							     <label>Banner Image</label>
									<?php
										$required=true;
										$keyname = $banner->banner_image_web;
										 
										if(!empty($keyname))
										{
											 $info = $awsFileLoad->doesObjectExistFile($keyname);
										}
										else
										{
											$info='';
										}
										if($info)
										{
											$required=false;
										}
									?>
										<?= $this->Form->control('banner_images',['type'=>'file','label'=>false,'id' => 'banner_image','data-show-upload'=>false, 'data-show-caption'=>false, 'required'=>$required]) ?>
										<label id="banner_image-error" class="error" for="banner_image"></label>
										<?php
										if($info)
										{
											$result=$awsFileLoad->getObjectFile($keyname);
											$app_image_view='<img src="data:'.$result['ContentType'].';base64,'.base64_encode($result['Body']).'" alt="" style="width: auto; height: 160px;" class="file-preview-image"/>';
											
											$js.=' $( document ).ready(function() {
														$("#web_image_data").find("div.file-input-new").removeClass("file-input-new");
														$("#web_image_data").find("div.file-preview-thumbnails").html("<div data-template=image class=file-preview-frame><div class=kv-file-content><img src=data:'.$result['ContentType'].';base64,'.base64_encode($result['Body']).'></div></div>");
														$("#web_image_data").find("div.file-preview-frame").addClass("file-preview-frame krajee-default  kv-preview-thumb");
													
														$("#web_image_data").find("img").addClass("file-preview-image kv-preview-data rotate-1");
													});
											';
										}
									?>
							</div>
							 
							 
							<?php 
							if(!empty($updt_id)){
								$last_date=date('d-m-Y', strtotime($banner->last_date));
							}else if(empty($updt_id)){
								$last_date=date('d-m-Y');
							}
							?>
							
							<div class="form-group">
							
								<label>Last Display Date</label>               
								<?= $this->Form->control('last_date',['class'=>'form-control datepicker','placeholder'=>'Last Date','label'=>false,'type'=>'text','data-date-format' => 'dd-mm-yyyy','value'=>$last_date]) ?>
							</div>
						
							<div class="form-group">
								<label>Status</label>
								<?php $options['Active'] = 'Active'; ?>
								<?php $options['Deactive'] = 'Deactive'; ?>
								<?= $this->Form->select('status',$options,['class'=>'form-control select','label'=>false]) ?>
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
				
	            <div class="col-md-8">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">LIST Banner</h3>
						<div class="pull-right">
						<div class="pull-left">
						
							<?= $this->Form->create('Search',['type'=>'GET']) ?>
							<?= $this->Html->link(__(' Add New'), ['action' => 'index'],['style'=>'margin-top:-30px !important;','class'=>'btn btn-success','escape'=>false]) ?>
							
								<div class="form-group" style="display:inline-table;width:500px;">
									<div class="input-group">
										<div class="input-group-addon">
											<span class="fa fa-search"></span>
										</div>
										<?= $this->Form->control('search',['class'=>'form-control','placeholder'=>'Search...','label'=>false]) ?>
										<div class="input-group-btn">
											<?= $this->Form->button(__('Search'),['class'=>'btn btn-primary']) ?>
										</div>
									</div>
								</div>
							<?= $this->Form->end() ?>
						</div> 
						</div>
					</div>
				<div class="panel-body">
						<?php $page_no=$this->Paginator->current('banners'); $page_no=($page_no-1)*20; ?>
						<div class="table-responsive">
                            <table class="table table-bordered">
								<thead>
									<tr>
										<th><?= ('SN.') ?></th>
										<th><?= ('Image') ?></th>
										<th><?= ('Name') ?></th>
										<th><?= ('Link Name') ?></th>
										<th><?= ('Last Date') ?></th>
										<th><?= ('Status') ?></th>
										<th scope="col" class="actions"><?= __('Actions') ?></th>
									</tr>
								</thead>
								<tbody>                                            
								<?php $i = $paginate_limit*($this->Paginator->counter('{{page}}')-1); ?>
								
								  <?php foreach ($banners as $banner): ?>
								<tr>
									<td><?= $this->Number->format(++$i) ?></td>
									<td>
										<?php $result=$awsFileLoad->getObjectFile($banner->banner_image_web);
											echo $app_image_view='<img src="data:'.$result['ContentType'].';base64,'.base64_encode($result['Body']).'" alt="" style="width: auto; height: 50px;" class="file-preview-image"/>'; ?>
									</td>
									<td><?= h($banner->name) ?></td>
									<td><?= h($banner->link_name) ?></td>
									<td><?= h(date('d-M-Y', strtotime($banner->last_date))) ?></td>
									<td><?= h($banner->status) ?></td>
									
									<td class="actions">
										<?php
											$banner_id = $EncryptingDecrypting->encryptData($banner->id);
										?>
										<?= $this->Html->link(__('<span class="fa fa-pencil"></span>'), ['action' => 'index',$banner_id],['class'=>'btn btn-primary  btn-condensed btn-sm','escape'=>false]) ?>
										<?= $this->Form->postLink('<span class="fa fa-remove"></span>', ['action' => 'delete', $banner_id], ['class'=>'btn btn-danger btn-condensed btn-sm','confirm' => __('Are you sure you want to delete?'),'escape'=>false]) ?>
									
									</td>
								</tr>
								<?php endforeach; ?>
								</tbody>
							</table>
				        </div>
			    </div>
				<div class="panel-footer">
					<div class="paginator pull-right">
						<ul class="pagination">
							<?= $this->Paginator->first(__('First')) ?>
							<?= $this->Paginator->prev(__('Previous')) ?>
							<?= $this->Paginator->numbers() ?>
							<?= $this->Paginator->next(__('Next')) ?>
							<?= $this->Paginator->last(__('Last')) ?>
						</ul>
						<p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
					</div>
				</div>
			</div>		
		</div>
	</div>
</div>
<!-- END CONTENT FRAME -->
<?= $this->Html->script('plugins/bootstrap/bootstrap-datepicker.js',['block'=>'jsDatePicker']) ?>
<?= $this->Html->script('plugins/fileinput/fileinput.min.js',['block'=>'jsFileInput']) ?>
<?= $this->Html->script('plugins/bootstrap/bootstrap-select.js',['block'=>'jsSelect']) ?>
<?= $this->Html->script('plugins/jquery-validation/jquery.validate.js',['block'=>'jsValidate']) ?>
<?php
   $js.='var jvalidate = $("#jvalidate").validate({
		ignore: [],
		rules: {                                            
				name: {
						required: true,
				},
				
			}                                        
		});
		
		$("#banner_image").fileinput({
            showUpload: false,
            showCaption: false,
            showCancel: false,
            browseClass: "btn btn-danger",
			allowedFileExtensions: ["jpeg", "jpg", "png"],
			maxFileSize: 1024,
		}).after({
			
		}); 
		
		
		$(document).on("click", ".fileinput-remove-button", function(){
			$(this).closest("div.file-input").find("input[type=file]").attr("required",true);
		});
		
		$(document).on("change", "#variation_id", function(){
			var vari=$("option:selected", this).val();
			var dummy_category_id=$("option:selected", this).attr("category_id");
			var dummy_item_id=$("option:selected", this).attr("item_id");
				$("#category_id").selectpicker("val",dummy_category_id);
				$("#item_id").selectpicker("val",dummy_item_id);
		});
		
		$(document).on("click", ".iradio", function(){
			var radio_value=$("input[name=iradio]:checked").val(); 
			if(radio_value==1){
				$("#cat_id").show();
				$("#itm_id").hide();
				$("#slr_id").hide();
				$("#combo_id").hide();
				$("#var_id").hide();
				 
				$("#item_id").selectpicker("val","");
				$("#seller_id").selectpicker("val","");
				$("#combo_offer_id").selectpicker("val","");
				$("#variation_id").selectpicker("val","");
			}
			else if(radio_value==2){
				$("#cat_id").hide();
				$("#itm_id").show();
				$("#slr_id").hide();
				$("#combo_id").hide();
				$("#var_id").hide();
				
				$("#category_id").selectpicker("val","");
				$("#seller_id").selectpicker("val","");
				$("#combo_offer_id").selectpicker("val","");
				$("#variation_id").selectpicker("val","");
			}
			else if(radio_value==3){
				$("#cat_id").hide();
				$("#itm_id").hide();
				$("#slr_id").show();
				$("#combo_id").hide();
				$("#var_id").hide();
				
				$("#category_id").selectpicker("val","");
				$("#item_id").selectpicker("val","");
				$("#combo_offer_id").selectpicker("val","");
				$("#variation_id").selectpicker("val","");
			}
			else if(radio_value==4){
				$("#cat_id").hide();
				$("#itm_id").hide();
				$("#slr_id").hide();
				$("#combo_id").show();
				$("#var_id").hide();
				
				$("#category_id").selectpicker("val","");
				$("#item_id").selectpicker("val","");
				$("#seller_id").selectpicker("val","");
				$("#variation_id").selectpicker("val","");
			}
			else if(radio_value==5){
				$("#cat_id").hide();
				$("#itm_id").hide();
				$("#slr_id").hide();
				$("#combo_id").hide();
				$("#var_id").show();
				
				var dummy_category_id=$("#variation_id option:selected").attr("category_id");
			    var dummy_item_id=$("#variation_id option:selected").attr("item_id");
 				$("#category_id").selectpicker("val",dummy_category_id);
				$("#item_id").selectpicker("val",dummy_item_id);
				$("#seller_id").selectpicker("val","");
				$("#variation_id").selectpicker("val","");
			}
		});
		';  
echo $this->Html->scriptBlock($js, array('block' => 'scriptBottom')); 		
?>
