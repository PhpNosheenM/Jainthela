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
   function categories($array) {

    if (count($array)) {
            echo "\n<ul>\n";
        foreach ($array as $vals) {

                    echo "<li id=\"".$vals['id']."\">".$vals['name'];
                    if (count($vals['children'])) {
                            $this->RecursiveCategories->categories($vals['children']);
                    }
                    echo "</li>\n";
        }
            echo "</ul>\n";
    }
   }


}
