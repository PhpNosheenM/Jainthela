                <div class="content-frame">
                    
                    <!-- START CONTENT FRAME TOP -->
                    <div class="content-frame-top">                        
                        <div class="page-title">                    
                            <h2><span class="fa fa-arrow-circle-o-left"></span> Units</h2>
                        </div>                                      
                        <div class="pull-right">
                            <button class="btn btn-default content-frame-left-toggle"><span class="fa fa-bars"></span></button>
                        </div>                        
                    </div>
                    <!-- END CONTENT FRAME TOP -->
                    
                    <!-- START CONTENT FRAME LEFT -->
                    <div class="content-frame-left">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <?= $this->Form->create($unit) ?>
									<div class="form-group">
										<label>Unit Name</label>
										<?= $this->Form->control('unit_name',['class'=>'form-control','placeholder'=>'Unit Name','label'=>false,'required'=>'required']) ?>
                                    </div>
									<div class="form-group">
										<label>Long Name</label>
										<?= $this->Form->control('longname',['class'=>'form-control','placeholder'=>'Long Name','label'=>false,'required'=>'required']) ?>
									</div>
									<div class="form-group">
										<label>Short Name</label>
										<?= $this->Form->control('shortname',['class'=>'form-control','placeholder'=>'Short Name','label'=>false,'required'=>'required']) ?>
                                    </div>
							</div>
							<div class="panel-footer">
								<div class="col-md-offset-3 col-md-4">
								<?= $this->Form->button(__('Submit'),['class'=>'btn btn-primary']) ?>
								</div>
							</div>
                        </div>
                    </div>
                    <!-- END CONTENT FRAME LEFT -->
                    
                    <!-- START CONTENT FRAME BODY -->
                    <div class="content-frame-body">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <h3>Responsive Body</h3>
                                This is responsive frame body. Can be used for all elements of template.
                            </div>
                        </div>
                    </div>
                    <!-- END CONTENT FRAME BODY -->
                </div>
                <!-- END CONTENT FRAME -->
                