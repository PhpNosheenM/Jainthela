<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}
</style>
<?php $this->set('title', 'Brand'); ?>
<div class="content-frame">
	<!-- START CONTENT FRAME TOP -->
	<div class="content-frame-top">
		<div class="page-title">
			<h2> Brands</h2>
		</div>
		<div class="pull-right">
			<?php  if(($status=='Deactive') || ($status=='deactive')){
						$class1="btn btn-default";
						$class2="btn btn-xs blue";
					}else{
						$class1="btn btn-xs blue";
						$class2="btn btn-default";
					}
			 ?>
				<?php echo $this->Html->link('All',['controller'=>'Brands','action' => 'index?status=active'],['escape'=>false,'class'=>$class1]); ?>
				<?php echo $this->Html->link('Archive',['controller'=>'Brands','action' => 'index?status=Deactive'],['escape'=>false,'class'=>$class2]); ?>&nbsp;
		</div>
	</div>
	<!-- END CONTENT FRAME TOP -->
	
	<!-- START CONTENT FRAME LEFT -->
	<div class="content-frame-left">
		<div class="panel panel-default">

			<div class="panel-heading">
				<h3 class="panel-title">ADD BRANDS</h3>
			</div>
			<?= $this->Form->create($brand,['id'=>"jvalidate",'type'=>'file']) ?>
			<?php $js=''; ?>
				<div class="panel-body">
					<div class="form-group">
						<label>Brand Name</label>
						<?= $this->Form->control('name',['class'=>'form-control','placeholder'=>'Brand Name','label'=>false]) ?>
					</div>
					<div class="form-group">
						<label>Status</label>
						<?php $options['Active'] = 'Active'; ?>
						<?php $options['Deactive'] = 'Deactive'; ?>
						<?= $this->Form->select('status',$options,['class'=>'form-control select','label'=>false]) ?>
					</div>
					<div class="form-group" id="web_image_data">
							     <label>Brand Image</label> 
									<?php
										$required=true;
										$keyname = $brand->brand_image_web;
										 
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
										<?= $this->Form->control('brand_image',['type'=>'file','label'=>false,'id' => 'brand_image','data-show-upload'=>false, 'data-show-caption'=>false, 'required'=>$required]) ?>
										<label id="banner_image-error" class="error" for="banner_image"></label>
										<?php  
										if($info)
										{
											$result=$awsFileLoad->getObjectFile($keyname);
											
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
				</div>
				<div class="panel-footer">
					<center>
						<?= $this->Form->button(__('Submit'),['class'=>'btn btn-primary']) ?>
					</center>
				</div>
			<?= $this->Form->end() ?>
		</div>
	</div>
	<!-- END CONTENT FRAME LEFT -->
	
	<!-- START CONTENT FRAME BODY -->
	<div class="content-frame-body">
		
		<div class="panel panel-default">
			 <div class="panel-heading">
				<h3 class="panel-title">LIST BRANDS</h3>
				 <div class="pull-right">
					<div class="pull-left">
							
					</div> 	   
				 </div> 
				</div>	
			<div class="panel-body">
			
				<?php $page_no=$this->Paginator->current('Brands'); $page_no=($page_no-1)*20; ?>
				<div class="table-responsive">
				
				<table class="table datatable">
					<thead>
						<tr>
							<th><?= ('SN.') ?></th>
							<th><?= ('Brand Name') ?></th>
							<th><?= ('Status') ?></th>
							
							<th scope="col" class="actions"><?= __('Actions') ?></th>
						</tr>
					</thead>
					<tbody>                                            
						<?php 
						$i = $paginate_limit*($this->Paginator->counter('{{page}}')-1);
						foreach ($brands as $brand): 
						$brand_id = $EncryptingDecrypting->encryptData($brand->id);
						?>
						<tr>
							<td><?= $this->Number->format(++$i) ?></td>
							<td><?= h($brand->name) ?></td>
							<td>
								<?php if($brand->status=="Active"){ ?>
									<?= h($brand->status) ?>
								<?php }else{ ?>
								<?= $this->Form->postLink('<span class="fa">'.$brand->status.'</span>', ['action' => 'active', $brand_id], ['class'=>'btn btn-danger  btn-sm','confirm' => __('Are you sure you want to Active?'),'escape'=>false]) ?>
								<?php } ?>
							</td>
							<td class="actions">
								<?php
									$brand_id = $EncryptingDecrypting->encryptData($brand->id);
								?>
								<?= $this->Html->link(__('<span class="fa fa-pencil"></span>'), ['action' => 'index', $brand_id],['class'=>'btn btn-primary  btn-condensed btn-sm','escape'=>false]) ?>
								<?php if(@$stock[@$brand->id] > 0){ ?> 
								<?php }else{ 
								if($brand->status=="Active"){
								?> 
								<?= $this->Form->postLink('<span class="fa fa-remove"></span>', ['action' => 'delete', $brand_id], ['class'=>'btn btn-danger btn-condensed btn-sm','confirm' => __('Are you sure you want to delete?'),'escape'=>false]) ?>
								<?php } }?> 
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
	<!-- END CONTENT FRAME BODY -->
</div>
<!-- END CONTENT FRAME -->
<?= $this->Html->script('plugins/fileinput/fileinput.min.js',['block'=>'jsFileInput']) ?>
<?= $this->Html->script('plugins/bootstrap/bootstrap-select.js',['block'=>'jsSelect']) ?>
<?= $this->Html->script('plugins/jquery-validation/jquery.validate.js',['block'=>'jsValidate']) ?>
<?php
   $js.='var jvalidate = $("#jvalidate").validate({
		ignore: [],
		rules: {                                            
				unit_name: {
						required: true,
				},
				longname: {
						required: true,
				},
				shortname: {
						required: true,
				},
			   
			}                                        
		});
		$("#brand_image").fileinput({
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
