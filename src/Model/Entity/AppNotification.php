<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AppNotification Entity
 *
 * @property int $id
 * @property int $city_id
 * @property int $location_id
 * @property string $message
 * @property string $image_web
 * @property string $image_app
 * @property string $app_link
 * @property int $item_id
 * @property int $item_variation_id
 * @property int $combo_offer_id
 * @property int $wish_list_id
 * @property int $category_id
 * @property string $screen_type
 * @property int $created_by
 * @property \Cake\I18n\FrozenTime $created_on
 * @property int $edited_by
 * @property \Cake\I18n\FrozenTime $edited_on
 * @property int $status
 *
 * @property \App\Model\Entity\City $city
 * @property \App\Model\Entity\Location $location
 * @property \App\Model\Entity\Item $item
 * @property \App\Model\Entity\ItemVariation $item_variation
 * @property \App\Model\Entity\ComboOffer $combo_offer
 * @property \App\Model\Entity\WishList $wish_list
 * @property \App\Model\Entity\Category $category
 * @property \App\Model\Entity\AppNotificationCustomer[] $app_notification_customers
 */
class AppNotification extends Entity
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
        'location_id' => true,
        'message' => true,
        'image_web' => true,
        'image_app' => true,
        'app_link' => true,
        'item_id' => true,
        'item_variation_id' => true,
        'combo_offer_id' => true,
        'wish_list_id' => true,
        'category_id' => true,
        'screen_type' => true,
        'created_by' => true,
        'created_on' => true,
        'edited_by' => true,
        'edited_on' => true,
        'status' => true,
        'city' => true,
        'location' => true,
        'item' => true,
        'item_variation' => true,
        'combo_offer' => true,
        'wish_list' => true,
        'category' => true,
        'app_notification_customers' => true
    ];
}
