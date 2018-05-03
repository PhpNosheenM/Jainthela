<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Banner Entity
 *
 * @property int $id
 * @property int $city_id
 * @property string $link_name
 * @property string $name
 * @property string $banner_image
 * @property \Cake\I18n\FrozenTime $created_on
 * @property string $status
 *
 * @property \App\Model\Entity\City $city
 */
class Banner extends Entity
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
        'city_id' => true,
        'link_name' => true,
        'name' => true,
        'banner_image' => true,
        'created_on' => true,
        'status' => true,
        'category_id' => true,
        'item_id' => true,
        'seller_id' => true,
        'combo_offer_id' => true,
        'city' => true
    ];
}
