<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         3.0.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace Cake\View\Helper;
use Cake\View\Helper;
use UnexpectedValueException;
use Cake\View\Helper\FormHelper;
/**
 * FlashHelper class to render flash messages.
 *
 * After setting messages in your controllers with FlashComponent, you can use
 * this class to output your flash messages in your views.
 */
class RecursiveCategoriesHelper extends Helper
{
    function categoryItems($array) {
	   
		$html = new FormHelper(new \Cake\View\View());
		if (count($array)) {
			   
			foreach ($array as $vals) {
				
				echo '<div class="panel panel-primary">
						<div class="panel-heading">
							<h4 class="panel-title" style="width: 100%;">
								<input type="checkbox" class="check_all">
								<a href="#accOneColOne'.$vals['id'].'">
									'.$vals['name'].' <i class="fa fa-angle-down"></i>
								</a>';
								echo $html->control('commission_all', ['templates' => ['inputContainer'=>'{{content}}'],'label' => false,'type'=>'text','placeholder'=>'Commission in %','class'=>'form-control col-sm-3 commission_all','style'=>'display:inline !important;width: 122px;float:none;']);
						echo	'</h4>
						</div>';
				if (count($vals['children'])) {
					echo '<div class="panel-body" id="accOneColOne'.$vals['id'].'"  style="margin-left:20px; display:none;">';
						$this->categoryItems($vals['children']);
					echo '</div>';
				}
				else
				{
					echo '<div class="panel-body" id="accOneColOne'.$vals['id'].'" style="margin-left:20px; display:none;">';
					$i=0;
						foreach($vals['items'] as $item)
						{ 
						    if(!empty($item->seller_items[0]->commission_percentage))
							{
								$chk ="checked"; $disabled="";
							}else{$chk ="";$disabled="disabled";}
							echo '<input name="category_ids[]" type="hidden"  value="'.$item['category_id'].'" >';
							echo '<label><input name="item_ids[]" type="checkbox"  value="'.$item['id'].'" class="single_item" '.$chk.'>&nbsp;&nbsp;'.$item['name'].'</label>';
							echo $html->control('commissions[]', ['templates' => ['inputContainer'=>'{{content}}'],'label' => false,'type'=>'text','placeholder'=>'Commission in %','class'=>'form-control','style'=>'display:inline !important;width: 122px;float:none;margin: 1%;',$disabled,'item_id'=>$item['id'],'value'=>@$item->seller_items[0]->commission_percentage]);
							echo '<br/>';
						}
						
					echo '</div>';
				}
				
				echo '</div>';  
			}
			   
		}
    }
	function categoryItemVariations($array,$arraySec) {
	    $i=0;
	    $status[] =['value'=>'No','text'=>'No'];
		$status[] =['value'=>'Yes','text'=>'Yes'];
		$html = new FormHelper(new \Cake\View\View());
		if (count($array)) {
			
			
			foreach ($array as $vals) {
				
				echo '<div class="panel panel-primary">
						<div class="panel-heading">
							<h4 class="panel-title" style="width: 100%;">
								<input type="checkbox" class="check_all">
								<a href="#accOneColOne'.$vals['id'].'">
									'.$vals['name'].'
								</a>';
						echo	'</h4>
						</div>';
				if (count($vals['children'])) { 
					echo '<div class="panel-body" id="accOneColOne'.$vals['id'].'">';
						$this->categoryItemVariations($vals['children'],$arraySec);
					echo '</div>';
				}
				else
				{
					echo '<div class="panel-body" id="accOneColOne'.$vals['id'].'" style="margin-left:20px;">';
						
						foreach($vals['items'] as $item)
						{   $checked="";$style="";
							foreach($item['item_variation_masters'] as $item_variation_master)
							{ 
								if(!empty($item_variation_master->item_variations[0]))
								{
									$checked="checked";$style="display:block";
								}else{$checked="";$style="display:none;";}
							}

							echo '<div class="item_variation">
									<div class="">
										<h4 class="panel-title" style="width: 100%;">
											<input type="checkbox" class="check_all_item" value="'.$item['id'].'" '.$checked.'>
											<a href="#itemshow'.$item['id'].'">
												'.$item['name'].'
											</a>';
									echo	'</h4>
									</div>';
							
							echo '<div class="panel-body" id="itemshow'.$item['id'].'" style="padding: 0px !important;;padding-right: 1% !important;'.$style.'" >';
							//echo '<div style="overflow:scroll;"><div class="table-responsive">';
							echo '<table class="table table-bordered main_tbl" >
							<thead>
							<tr>
								<th></th>
								<th>Maximum Quantity Purchase</th>
								<th>Current Stock</th>
								<th>Add Stock</th>
								<th>MRP</th>
								<th>Sales Rate</th>
								<th>Read To Sale</th>
							</tr>
							</thead>
							<tbody>';
							
							foreach($item['item_variation_masters'] as $item_variation_master)
							{  
								if(!empty($item_variation_master->item_variations[0]))
								{
									$chk="checked";$disabled=''; $style='display:none;';
								}
								else
								{
									$chk="";$disabled='disabled';$style='';
								}
								echo '<tr>';
								echo '<td style="width:10%">';
								echo '<input name="'.$item_variation_master['id'].'[item_id]" type="checkbox"  value="'.$item['id'].'" class="entity_variation entity_variation'.$item_variation_master['unit_variation']['id'].'"  style="display:none;" '.$chk.'>';

								echo '<input name="'.$item_variation_master['id'].'[item_variation_master_id]" type="textbox"  value="'.$item_variation_master['id'].'" class="entity_maximum entity_maximum'.$item_variation_master['unit_variation']['id'].'" '.$disabled.' style="display:none;>';
								if($style=='')
								{
									$class='single_item variation'.$item['id'];
								}else{$class='';}
								echo '<label style="margin-left:30px;"><input name="'.$item_variation_master['id'].'[unit_variation_id]" type="checkbox"   value="'.$item_variation_master['unit_variation']['id'].'" class="'.$class.'" '.$disabled.'" '.$chk.' style="'.$style.'">&nbsp;&nbsp;'.$item_variation_master['unit_variation']['quantity_variation'].' '.$item_variation_master['unit_variation']['unit']['longname'].'</label>';
								echo '</td><td style="width:20%">';
								echo $html->control($item_variation_master['id'].'[maximum_quantity_purchase]', ['templates' => ['inputContainer'=>'{{content}}'],'label' => false,'type'=>'text','placeholder'=>'Maximum Quantity Purchase','class'=>'form-control entity_maximum entity_maximum'.$item_variation_master['unit_variation']['id'],'style'=>'display:inline !important;float:none;',$disabled,'value'=>@$item_variation_master->item_variations[0]->maximum_quantity_purchase,'required']);
								echo '</td><td style="width:10%">';
								echo $html->control($item_variation_master['id'].'[current_stock]', ['templates' => ['inputContainer'=>'{{content}}'],'label' => false,'type'=>'text','placeholder'=>'Current Stock','class'=>'form-control cStock  entity_maximum entity_maximum'.$item_variation_master['unit_variation']['id'],'style'=>'display:inline !important;float:none;',$disabled,'value'=>@$item_variation_master->item_variations[0]->current_stock,'required','readonly']);
								echo '</td><td style="width:10%">';
								echo $html->control($item_variation_master['id'].'[add_stock]', ['templates' => ['inputContainer'=>'{{content}}'],'label' => false,'type'=>'text','placeholder'=>'Add Stock','class'=>'form-control addStock entity_maximum entity_maximum'.$item_variation_master['unit_variation']['id'],'style'=>'display:inline !important;float:none;',$disabled,'value'=>@$item_variation_master->item_variations[0]->add_stock]);
								echo '</td><td style="width:12%">';
								echo $html->control($item_variation_master['id'].'[mrp]', ['templates' => ['inputContainer'=>'{{content}}'],'label' => false,'type'=>'text','placeholder'=>'MRP','class'=>'form-control mrp calc entity_maximum entity_maximum'.$item_variation_master['unit_variation']['id'],'style'=>'display:inline !important;float:none;',$disabled,'value'=>@$item_variation_master->item_variations[0]->mrp,'required']);
								echo '</td><td style="width:13%">';
								echo $html->control($item_variation_master['id'].'[sales_rate]', ['templates' => ['inputContainer'=>'{{content}}'],'label' => false,'type'=>'text','placeholder'=>'Sales Rate','class'=>'form-control sales_rate calc entity_maximum entity_maximum'.$item_variation_master['unit_variation']['id'],'style'=>'display:inline !important;float:none;',$disabled,'value'=>@$item_variation_master->item_variations[0]->sales_rate,'required']);
								
								echo '<input name="'.$item_variation_master['id'].'[commissions]" type="hidden"  value="'.@$arraySec[@$item->id].'" class="entity_maximum entity_maximum'.$item_variation_master['unit_variation']['id'].'" id="commission">';
								
								echo $html->control($item_variation_master['id'].'[purchase_rate]', ['templates' => ['inputContainer'=>'{{content}}'],'label' => false,'type'=>'hidden','placeholder'=>'Rate','class'=>'form-control entity_maximum  purchase_rate entity_maximum '.$item_variation_master['unit_variation']['id'],'style'=>'float:none;',$disabled,'value'=>@$item_variation_master->item_variations[0]->purchase_rate]);
								echo '</td><td style="width:15%">';
								echo $html->select($item_variation_master['id'].'[ready_to_sale]',$status,['class'=>'form-control entity_maximum entity_maximum'.$item_variation_master['unit_variation']['id'],'label'=>false,$disabled,'style'=>'display:inline !important;float:none;','placeholder'=>'Select...','label'=>false,'value'=>@$item_variation_master->item_variations[0]->ready_to_sale,'style'=>'display:inline !important;float:none;']);
								
								echo '</td>';
								echo '</tr>';
								$i++;
							}
							echo '</tbody></table>';
							echo '</div>';
							echo '</div>';
							
						}
						
					echo '</div>';
				}
				
				echo '</div>';  
			}
			   
		}
    }
	
	
	function categoryItemVariationsOption($array,$status=null) {
	    
		$html = new FormHelper(new \Cake\View\View());
		if (count($array)) {
			
			foreach ($array as $vals) {
				if($status==1)
				{
					echo '<optgroup label="&nbsp;&nbsp;'.$vals['name'].'">';
				}
				else
				{
					echo '<optgroup label="'.$vals['name'].'">';
				}
				if (count($vals['children'])) { 
						$this->categoryItemVariationsOption($vals['children'],1);
				}
				else
				{
					foreach($vals['items'] as $item)
						{   
							echo '<option value="'.$item['id'].'">'.$item['name'].'</option>';
						}
				}
				
				echo '</optgroup>';  
			}
			   
		}
    }
}

                                    
                                     
