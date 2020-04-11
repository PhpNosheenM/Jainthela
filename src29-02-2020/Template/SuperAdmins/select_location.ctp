<?= $this->Form->select('location_id',$Locations,['empty'=>'--Select Location--','class'=>'form-control location_id' ,'label'=>false]) ?>
</div>



<div class="col-md-12">
<?= $this->Form->select('finencial_year_id',$financial_year,['class'=>'form-control finencial_year_id ' ,'label'=>false,'required']) ?>
