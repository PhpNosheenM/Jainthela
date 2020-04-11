<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}

</style><?php $this->set('title', 'Home Screens'); ?>
<div class="page-content-wrap">
        <div class="page-title">                    
			<h2><span class="fa fa-arrow-circle-o-left"></span> Home Screens</h2>
		</div>
	<div class="row">
				<div class="col-md-4">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">ADD Home Screens</h3>
						</div>
						<?= $this->Form->create($homeScreen,['id'=>"jvalidate",'type'=>'file']) ?>
						<?php $js=''; ?>
						<div class="panel-body">
						    <div class="form-group">
									<label>Title</label>
									<?= $this->Form->control('title',['class'=>'form-control','placeholder'=>'Name','label'=>false]) ?>
									<span class="help-block"></span>
					        </div>
							<div class="form-group">
									<label>Layout</label>
									<?php
										$options2['banner'] = 'Banner';
										$options2['circle'] = 'Circle';
										$options2['combo_offer'] = 'Combo Offer';
										$options2['horizontal'] = 'Horizontal';
										$options2['rectangle'] = 'Rectangle';
										$options2['store directory'] = 'Store Directory';
										$options2['Single Image & two Item'] = 'Single Image & two Item';
										$options2['tie up'] = 'tie up';
									?>
									<?= $this->Form->select('layout',$options2,['empty'=>'Select Layout','class'=>'form-control select','label'=>false]) ?>
									<span class="help-block"></span>
					        </div>
							<div class="form-group">
									<label>Categories</label>
									<?= $this->Form->select('category_id',$categories,['empty'=>'Select Categories','class'=>'form-control select','label'=>false]) ?>
									<span class="help-block"></span>
					        </div>
							<div class="form-group">
									<label>Screen Type</label>
									<?php
										$options3['Home'] = 'Home';
										$options3['Product Detail'] = 'Product Detail';
										?>
									<?= $this->Form->select('screen_type',$options3,['empty'=>'Select Screen Type','class'=>'form-control select','label'=>false]) ?>
									<span class="help-block"></span>
					        </div>
							<div class="form-group">
									<label>Model Name</label>
									<?php
										$options4['ExpressDeliveries'] = 'Express Deliveries';
										$options4['Brands'] = 'Brands';
										$options4['Category'] = 'Category';
										$options4['Items'] = 'Items';
										$options4['Banners'] = 'Banners';
										$options4['SubCategory'] = 'Sub Category';
										$options4['MainCategory'] = 'Main Category';
										$options4['Combooffer'] = 'Combo Offer';
										$options4['Categorytwoitem'] = 'Category Two Item';
										?>
									<?= $this->Form->select('model_name',$options4,['empty'=>'Select Model Name','class'=>'form-control select','label'=>false]) ?>
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
							<div class="form-group" id="web_image_data">
							     <label>Image</label> 
									<?php
										$required=true;
										$keyname = $homeScreen->image;
										 
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
										<?= $this->Form->control('image',['type'=>'file','label'=>false,'id' => 'banner_image','data-show-upload'=>false, 'data-show-caption'=>false, 'required'=>$required]) ?>
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
							 <div class="form-group">
									<label>Preference App</label>
									<?= $this->Form->control('preference',['class'=>'form-control','placeholder'=>'Preference App','label'=>false]) ?>
									<span class="help-block"></span>
					        </div>
							 <div class="form-group">
									<label>Preference Web</label>
									<?= $this->Form->control('web_preference',['type'=>'number','class'=>'form-control','placeholder'=>'Preference Web','label'=>false]) ?>
									<span class="help-block"></span>
					        </div>
							<div class="form-group">
								<label>Section Show</label>
								<?php $options['Yes'] = 'Yes'; ?>
								<?php $options['No'] = 'No'; ?>
								<?= $this->Form->select('section_show',$options,['class'=>'form-control select','label'=>false]) ?>
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
						<h3 class="panel-title">LIST Home Screens</h3>
						<div class="pull-right">
						<div class="pull-left">
							<?= $this->Form->create('Search',['type'=>'GET']) ?>
							<?= $this->Html->link(__('<span class="fa fa-plus"></span> Add New'), ['action' => 'index'],['style'=>'margin-top:-30px !important;','class'=>'btn btn-success','escape'=>false]) ?>
								<div class="form-group" style="display:inline-table">
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
										<th><?= ('Title') ?></th>
										<th><?= ('Layout') ?></th>
										<th><?= ('Category') ?></th>
										<th><?= ('Screen Type') ?></th>
										<th><?= ('Model Name') ?></th>
										<th><?= ('Link Name') ?></th>
										<th><?= ('Preference App') ?></th>
										<th><?= ('Preference Web') ?></th>
										<th><?= ('Section Show') ?></th>
										<th scope="col" class="actions"><?= __('Actions') ?></th>
									</tr>
								</thead>
								<tbody>                                            
								<?php $i = $paginate_limit*($this->Paginator->counter('{{page}}')-1); ?>
								
								  <?php foreach ($homeScreens as $data): ?>
								<tr>
									<td><?= $this->Number->format(++$i) ?></td>
									<td><?= h($data->title) ?></td>
									<td><?= h($data->layout) ?></td>
									<td><?= h(@$data->category->name) ?></td>
									<td><?= h($data->screen_type) ?></td>
									<td><?= h($data->model_name) ?></td>
									<td><?= h($data->link_name) ?></td>
									<td><?= h($data->preference) ?></td>
									<td><?= h($data->web_preference) ?></td>
									<td><?= h($data->section_show) ?></td>
									
									<td class="actions">
										<?php
											$data_id = $EncryptingDecrypting->encryptData($data->id);
										?>
										<?= $this->Html->link(__('<span class="fa fa-pencil"></span>'), ['action' => 'index',$data_id],['class'=>'btn btn-primary  btn-condensed btn-sm','escape'=>false]) ?>
										<?= $this->Form->postLink('<span class="fa fa-remove"></span>', ['action' => 'delete', $data_id], ['class'=>'btn btn-danger btn-condensed btn-sm','confirm' => __('Are you sure you want to delete?'),'escape'=>false]) ?>
									
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
		}); 
		
		
		$(document).on("click", ".fileinput-remove-button", function(){
			$(this).closest("div.file-input").find("input[type=file]").attr("required",true);
		});
		';  
echo $this->Html->scriptBlock($js, array('block' => 'scriptBottom')); 		
?>
