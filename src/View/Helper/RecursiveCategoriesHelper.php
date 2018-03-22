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

/**
 * FlashHelper class to render flash messages.
 *
 * After setting messages in your controllers with FlashComponent, you can use
 * this class to output your flash messages in your views.
 */
class RecursiveCategoriesHelper extends Helper
{
   function categoryItems($array) {
		
    if (count($array)) {
           
        foreach ($array as $vals) {
			
			echo '<div class="panel panel-primary">
					<div class="panel-heading">
						<h4 class="panel-title">
							<input type="checkbox" class="check_all">
							<a href="#accOneColOne'.$vals['id'].'">
								'.$vals['name'].'
							</a>
						</h4>
					</div>';
			if (count($vals['children'])) {
				echo '<div class="panel-body" id="accOneColOne'.$vals['id'].'">';
					$this->categoryItems($vals['children']);
				echo '</div>';
			}
			else
			{
				echo '<div class="panel-body" id="accOneColOne'.$vals['id'].'" style="margin-left:20px;">';
					foreach($vals['items'] as $item)
					{
						echo '<label><input type="checkbox">&nbsp;&nbsp;'.$item['name'].'</label>';
						echo '<br/>';
					}
				echo '</div>';
			}
            
            echo '</div>';  
        }
           
    }
   }


}

                                    
                                     
