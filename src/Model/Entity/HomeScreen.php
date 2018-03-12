<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * HomeScreen Entity
 *
 * @property int $id
 * @property string $title
 * @property string $layout
 * @property string $section_show
 * @property int $preference
 * @property int $category_id
 * @property string $screen_type
 *
 * @property \App\Model\Entity\Category $category
 */
class HomeScreen extends Entity
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
        'title' => true,
        'layout' => true,
        'section_show' => true,
        'preference' => true,
        'category_id' => true,
        'screen_type' => true,
        'category' => true
    ];
}
