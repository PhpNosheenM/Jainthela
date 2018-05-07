<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Menu Entity
 *
 * @property int $id
 * @property string $name
 * @property string $icon
 * @property string $controller
 * @property string $action
 * @property int $parent_id
 * @property int $lft
 * @property int $rght
 * @property int $preference
 * @property int $status
 *
 * @property \App\Model\Entity\Menu $parent_menu
 * @property \App\Model\Entity\Menu[] $child_menus
 */
class Menu extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'name' => true,
        'icon' => true,
        'controller' => true,
        'action' => true,
        'parent_id' => true,
        'lft' => true,
        'rght' => true,
        'preference' => true,
        'status' => true,
        'parent_menu' => true,
        'child_menus' => true
    ];
}
