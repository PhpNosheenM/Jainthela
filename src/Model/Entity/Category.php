<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Category Entity
 *
 * @property int $id
 * @property string $name
 * @property int $parent_id
 * @property int $lft
 * @property int $rght
 * @property int $city_id
 * @property \Cake\I18n\FrozenTime $created_on
 * @property int $created_by
 * @property \Cake\I18n\FrozenTime $edited_on
 * @property int $edited_by
 * @property string $status
 *
 * @property \App\Model\Entity\Category $parent_category
 * @property \App\Model\Entity\City $city
 * @property \App\Model\Entity\Category[] $child_categories
 * @property \App\Model\Entity\Item[] $items
 * @property \App\Model\Entity\PromotionDetail[] $promotion_details
 * @property \App\Model\Entity\SellerItem[] $seller_items
 */
class Category extends Entity
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
        'parent_id' => true,
        'lft' => true,
        'rght' => true,
        'city_id' => true,
        'created_on' => true,
        'created_by' => true,
        'edited_on' => true,
        'edited_by' => true,
        'status' => true,
        'parent_category' => true,
        'city' => true,
        'child_categories' => true,
        'items' => true,
        'section_show' => true,
        'promotion_details' => true,
        'seller_items' => true
    ];
}
