<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}
.file-preview-image
{
	width: 100% !important;
	height:160px !important;
}
.file-preview-frame
{
	display: contents;
	float:none !important;
}
.kv-file-zoom
{
	display:none;
}
</style>
<?php $this->set('title', 'Category'); ?>
<div class="page-content-wrap">
        <div class="page-title">                    
			<h2> Category</h2>
		
		<div class="pull-right">
			<?php  if(($status=='Deactive') || ($status=='deactive')){
						$class1="btn btn-default";
						$class2="btn btn-xs blue";
					}else{
						$class1="btn btn-xs blue";
						$class2="btn btn-default";
					}
			 ?>
				<?php echo $this->Html->link('All',['controller'=>'Categories','action' => 'index?status=active'],['escape'=>false,'class'=>$class1]); ?>
				<?php echo $this->Html->link('Archive',['controller'=>'Categories','action' => 'index?status=Deactive'],['escape'=>false,'class'=>$class2]); ?>&nbsp;
		</div>
	</div>	
	<div class="row">
				<div class="col-md-4">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">ADD Category</h3>
						</div>
			<?= $this->Form->create($category,['id'=>'jvalidate','type'=>'file']) ?>
				<?php $js=''; ?>
				<div class="panel-body">
					<div class="form-group">
						<label>Category Name</label>
						<?= $this->Form->control('name',['class'=>'form-control','placeholder'=>'Category Name','label'=>false]) ?>
						<span class="help-block"></span>
					</div>
					<div class="form-group">
						<label>Parent Category</label>
						<?= $this->Form->select('parent_id',$parentCategories,['class'=>'form-control select','label'=>false,'empty' => '--Select--','data-live-search'=>true]) ?>
					</div>
					
					<div class="form-group" id="web_image_data">
						<label>Category Image</label> 
						<?php
							$required=true;
							$keyname = $category->category_image_web;
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
						<?= $this->Form->control('category_image',['type'=>'file','label'=>false,'id' => 'category_image','data-show-upload'=>false, 'data-show-caption'=>false, 'required'=>$required]) ?>
						<label id="category_image-error" class="error" for="category_image"></label>
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
					<div class="form-group">
						<label>Show Section</label>
						<?php $options['No'] = 'No'; ?>
						<?php $options['Yes'] = 'Yes'; ?>
						<?= $this->Form->select('section_show',$options,['class'=>'form-control select','label'=>false]) ?>
					</div>
					<div class="form-group">
						<label>Status</label>
						<?php unset($options); $options['Active'] = 'Active'; ?>
						<?php $options['Deactive'] = 'Deactive'; ?>
						<?= $this->Form->select('status',$options,['class'=>'form-control select','label'=>false]) ?>
					</div>
				</div>
				<div class="panel-footer">
					<div class="col-md-offset-3 col-md-4">
						<?= $this->Form->button(__('Submit'),['class'=>'btn btn-primary']) ?>
					</div>
				</div>
			<?= $this->Form->end() ?>
		</div>
	</div>
	<!-- END CONTENT FRAME LEFT -->

	<!-- START CONTENT FRAME BODY -->
	<div class="col-md-8">
		<div class="panel panel-default">
			  <div class="panel-heading">
				<h3 class="panel-title">LIST Category</h3>
				 <div class="pull-right">
					<div class="pull-left">
							
					</div> 	   
				 </div> 
				</div>	
				<div class="content-frame-body">
					<div class="panel panel-default">
						<div class="panel-body">
							<div class="table-responsive">
							<table class="table datatable">
								<thead>
									<tr>
										<th><?= ('SN.') ?></th>
										<th><?= ('Category Name') ?></th>
										<th><?= ('Parent Category') ?></th>
										<th><?= ('Status') ?></th>
										
										<th scope="col" class="actions"><?= __('Actions') ?></th>
									</tr>
								</thead>
								<tbody>                                            
									<?php $i = $paginate_limit*($this->Paginator->counter('{{page}}')-1); 
									foreach ($categories as $category):
										$category_id = $EncryptingDecrypting->encryptData($category->id);
									?>
									<tr>
										<td><?= $this->Number->format(++$i) ?></td>
										<td><?= h($category->name) ?></td>
										<td><?= $category->has('parent_category') ? h($category->parent_category->name) : '-'  ?></td>
										<td>
										<?php if($category->status=="Active"){ ?>
											<?= h($category->status) ?>
										<?php }else{ ?>
										<?= $this->Form->postLink('<span class="fa">'.$category->status.'</span>', ['action' => 'active', $category_id], ['class'=>'btn btn-danger  btn-sm','confirm' => __('Are you sure you want to Active?'),'escape'=>false]) ?>
										<?php } ?>
										</td>
										<td class="actions">
											<?php
												$category_id = $EncryptingDecrypting->encryptData($category->id);
											?>
											
											<?= $this->Html->link(__('<span class="fa fa-pencil"></span>'), ['action' => 'index', $category_id],['class'=>'btn btn-primary  btn-condensed btn-sm','escape'=>false]) ?>
											<?php if($category->status=="Active"){ ?>
											<?= $this->Form->postLink('<span class="fa fa-remove"></span>', ['action' => 'delete', $category_id], ['class'=>'btn btn-danger btn-condensed btn-sm','confirm' => __('Are you sure you want to delete?'),'escape'=>false]) ?>
											<?php } ?>
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
		
		$("#category_image").fileinput({
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
