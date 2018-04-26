<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}

</style><?php $this->set('title', 'Express Deliveries'); ?>
<div class="page-content-wrap">
        <div class="page-title">                    
			<h2><span class="fa fa-arrow-circle-o-left"></span> Express Deliveries</h2>
		</div> 
	<div class="row">
				<div class="col-md-4">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">ADD Express Deliveries</h3>
						</div>
						<?= $this->Form->create($expressDeliverie,['id'=>"jvalidate",'type'=>'file']) ?>
						<?php $js=''; ?>
						<div class="panel-body">
						    <div class="form-group">
									<label>Title</label>
									<?= $this->Form->control('title',['class'=>'form-control','placeholder'=>'Title','label'=>false]) ?>
									<span class="help-block"></span>
					        </div>
							<div class="form-group">
									<label>Contain</label>
									<?= $this->Form->control('content_data',['class'=>'form-control','placeholder'=>'Content Data','label'=>false]) ?>
									<span class="help-block"></span>
					        </div>
							<div class="form-group" id="web_image_data">
							     <label>Express Deliveries Image</label> 
									<?php
										$required=true;
										$keyname = $expressDeliverie->icon_web;
										 
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
										<?= $this->Form->control('icon',['type'=>'file','label'=>false,'id' => 'banner_image','data-show-upload'=>false, 'data-show-caption'=>false, 'required'=>$required]) ?>
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
						<h3 class="panel-title">LIST Express Deliveries</h3>
						<div class="pull-right">
						<div class="pull-left">
							<?= $this->Form->create('Search',['type'=>'GET']) ?>
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
										<th><?= ('Content Data') ?></th>
										<th><?= ('Status') ?></th>
										<th scope="col" class="actions"><?= __('Actions') ?></th>
									</tr>
								</thead>
								<tbody>                                            
								<?php $i = $paginate_limit*($this->Paginator->counter('{{page}}')-1); ?>
								
								  <?php foreach ($expressDeliveries as $data): ?>
								<tr>
									<td><?= $this->Number->format(++$i) ?></td>
									<td><?= h($data->title) ?></td>
									<td><?= h($data->content_data) ?></td>
									<td><?= h($data->status) ?></td>
									
									<td class="actions">
										<?= $this->Html->link(__('<span class="fa fa-pencil"></span>'), ['action' => 'index',$data->id],['class'=>'btn btn-primary  btn-condensed btn-sm','escape'=>false]) ?>
										<?= $this->Form->postLink('<span class="fa fa-remove"></span>', ['action' => 'delete', $data->id], ['class'=>'btn btn-danger btn-condensed btn-sm','confirm' => __('Are you sure you want to delete?', $data->id),'escape'=>false]) ?>
									
									</td>
								</tr>
								<?php endforeach; ?>
								</tbody>
							</table>
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
			allowedFileExtensions: ["jpg", "png"],
			maxFileSize: 1024,
		}); 
		
		
		$(document).on("click", ".fileinput-remove-button", function(){
			$(this).closest("div.file-input").find("input[type=file]").attr("required",true);
		});
		';  
echo $this->Html->scriptBlock($js, array('block' => 'scriptBottom')); 		
?>
