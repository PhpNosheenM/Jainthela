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
									'.$vals['name'].'
								</a>';
								echo $html->control('commission_all', ['templates' => ['inputContainer'=>'{{content}}'],'label' => false,'type'=>'text','placeholder'=>'Commission in %','class'=>'form-control col-sm-3 commission_all','style'=>'display:inline !important;width: 15%;float:none;']);
						echo	'</h4>
						</div>';
				if (count($vals['children'])) {
					echo '<div class="panel-body" id="accOneColOne'.$vals['id'].'">';
						$this->categoryItems($vals['children']);
					echo '</div>';
				}
				else
				{
					echo '<div class="panel-body" id="accOneColOne'.$vals['id'].'" style="margin-left:20px;">';
					$i=0;
						foreach($vals['items'] as $item)
						{ 
						    if(!empty($item->seller_items[0]->commission_percentage))
							{
								$chk ="checked"; $disabled="";
							}else{$chk ="";$disabled="disabled";}
							echo '<label><input name="item_ids[]" type="checkbox"  value="'.$item['id'].'" class="single_item" '.$chk.'>&nbsp;&nbsp;'.$item['name'].'</label>';
							echo $html->control('commissions[]', ['templates' => ['inputContainer'=>'{{content}}'],'label' => false,'type'=>'text','placeholder'=>'Commission in %','class'=>'form-control','style'=>'display:inline !important;width: 15%;float:none;margin: 1%;',$disabled,'item_id'=>$item['id'],'value'=>@$item->seller_items[0]->commission_percentage]);
							echo '<br/>';
						}
						
					echo '</div>';
				}
				
				echo '</div>';  
			}
			   
		}
    }
	function categoryItemVariations($array) {
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
						$this->categoryItemVariations($vals['children']);
					echo '</div>';
				}
				else
				{
					echo '<div class="panel-body" id="accOneColOne'.$vals['id'].'" style="margin-left:20px;">';
						
						foreach($vals['items'] as $item)
						{   $checked="";$style="";
							foreach($item['item_variation_masters'] as $item_variation_master)
							{ 
								if(!empty($item_variation_master->item_variations[0]->maximum_quantity_purchase))
								{
									$checked="checked";$style="display:block";
								}
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
							echo '<div style="overflow:scroll;"><div class="table-responsive">';
							echo '<table class="table table-bordered main_tbl" >
							<thead>
							<tr>
								<th></th>
								<th>Maximum Quantity Purchase</th>
								<th>Current Stock</th>
								<th>Purchase Rate</th>
								<th>Print Rate</th>
								<th>Discount (%)</th>
								<th>Commission</th>
								<th>Sales Rate</th>
								<th>MRP</th>
								<th>Read To Sale</th>
								<th>Section Show</th>
							</tr>
							</thead>
							<tbody>';
							foreach($item['item_variation_masters'] as $item_variation_master)
							{  
								if(!empty($item_variation_master->item_variations[0]->maximum_quantity_purchase))
								{
									$chk="checked";$disabled='';
								}
								else
								{
									$chk="";$disabled='disabled';
								}
								echo '<tr>';
								echo '<td style="width:25%"><div style="width:80px;">';
								echo '<input name="'.$i.'[item_id]" type="checkbox"  value="'.$item['id'].'" class="entity_variation'.$item_variation_master['unit_variation']['id'].'" style="display:none;" '.$chk.'>';

								echo '<input name="'.$i.'[item_variation_master_id]" type="textbox"  value="'.$item_variation_master['id'].'" class="entity_maximum entity_maximum'.$item_variation_master['unit_variation']['id'].'" '.$disabled.' style="display:none;>';

								echo '<label style="margin-left:30px;"><input name="'.$i.'[unit_variation_id]" type="checkbox"   value="'.$item_variation_master['unit_variation']['id'].'" class="single_item variation'.$item['id'].'" '.$disabled.'" '.$chk.' >&nbsp;&nbsp;'.$item_variation_master['unit_variation']['quantity_variation'].' '.$item_variation_master['unit_variation']['unit']['longname'].'</label>';
								echo '</div></td><td>';
								echo $html->control($i.'[maximum_quantity_purchase]', ['templates' => ['inputContainer'=>'{{content}}'],'label' => false,'type'=>'text','placeholder'=>'Maximum Quantity Purchase','class'=>'form-control entity_maximum entity_maximum'.$item_variation_master['unit_variation']['id'],'style'=>'display:inline !important;float:none;width:180px;',$disabled,'value'=>@$item_variation_master->item_variations[0]->maximum_quantity_purchase]);
								echo '</td><td>';
								echo $html->control($i.'[current_stock]', ['templates' => ['inputContainer'=>'{{content}}'],'label' => false,'type'=>'text','placeholder'=>'Current Stock','class'=>'form-control entity_maximum entity_maximum'.$item_variation_master['unit_variation']['id'],'style'=>'display:inline !important;float:none;width:95px;',$disabled,'value'=>@$item_variation_master->item_variations[0]->current_stock]);
								echo '</td><td>';
								echo $html->control($i.'[purchase_rate]', ['templates' => ['inputContainer'=>'{{content}}'],'label' => false,'type'=>'text','placeholder'=>'Purchase Rate','class'=>'form-control entity_maximum entity_maximum'.$item_variation_master['unit_variation']['id'],'style'=>'display:inline !important;float:none;width:90px;',$disabled,'value'=>@$item_variation_master->item_variations[0]->current_stock]);
								echo '</td><td>';
								echo $html->control($i.'[print_rate]', ['templates' => ['inputContainer'=>'{{content}}'],'label' => false,'type'=>'text','placeholder'=>'Print Rate','class'=>'form-control entity_maximum entity_maximum'.$item_variation_master['unit_variation']['id'],'style'=>'display:inline !important;width:80px;float:none;',$disabled,'value'=>@$item_variation_master->item_variations[0]->current_stock]);
								echo '</td><td>';
								echo $html->control($i.'[discount_per]', ['templates' => ['inputContainer'=>'{{content}}'],'label' => false,'type'=>'text','placeholder'=>'Discount %','class'=>'form-control entity_maximum entity_maximum'.$item_variation_master['unit_variation']['id'],'style'=>'display:inline !important;float:none;width:75px;',$disabled,'value'=>@$item_variation_master->item_variations[0]->current_stock]);
								echo '</td><td>';
								echo $html->control($i.'[commission]', ['templates' => ['inputContainer'=>'{{content}}'],'label' => false,'type'=>'text','placeholder'=>'Commission','class'=>'form-control entity_maximum entity_maximum'.$item_variation_master['unit_variation']['id'],'style'=>'display:inline !important;float:none;width:85px;',$disabled,'value'=>@$item_variation_master->item_variations[0]->current_stock]);
								echo '</td><td>';
								echo $html->control($i.'[sales_rate]', ['templates' => ['inputContainer'=>'{{content}}'],'label' => false,'type'=>'text','placeholder'=>'Sales Rate','class'=>'form-control entity_maximum entity_maximum'.$item_variation_master['unit_variation']['id'],'style'=>'display:inline !important;float:none;width:75px;',$disabled,'value'=>@$item_variation_master->item_variations[0]->current_stock]);
								echo '</td><td>';
								echo $html->control($i.'[mrp]', ['templates' => ['inputContainer'=>'{{content}}'],'label' => false,'type'=>'text','placeholder'=>'MRP','class'=>'form-control entity_maximum entity_maximum'.$item_variation_master['unit_variation']['id'],'style'=>'display:inline !important;width:60px;float:none;',$disabled,'value'=>@$item_variation_master->item_variations[0]->current_stock]);
								echo '</td><td>';
								
								echo $html->select($i.'[ready_to_sale]',$status,['class'=>'form-control entity_maximum entity_maximum'.$item_variation_master['unit_variation']['id'],'label'=>false,$disabled,'style'=>'display:inline !important;width:150px;float:none;','placeholder'=>'Select...','label'=>false,'value'=>@$section_show->item_variations[0]->ready_to_sale,'style'=>'display:inline !important;width:85px;float:none;']);
								echo '</td><td>';
								echo $html->select($i.'[section_show]',$status,['class'=>'form-control entity_maximum entity_maximum'.$item_variation_master['unit_variation']['id'],'label'=>false,$disabled,'style'=>'display:inline !important;width:150px;float:none;','placeholder'=>'Select...','label'=>false,'value'=>@$section_show->item_variations[0]->section_show,'style'=>'display:inline !important;width:85px;float:none;']);
								echo '</td>';
								echo '</tr>';
								$i++;
							}
							echo '</tbody></table></div></div>';
							echo '</div>';
							echo '</div>';
							
						}
						
					echo '</div>';
				}
				
				echo '</div>';  
			}
			   
		}
    }

}

                                    
                                     
