<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ComboOffer Entity
 *
 * @property int $id
 * @property int $city_id
 * @property int $admin_id
 * @property string $name
 * @property float $print_rate
 * @property float $discount_per
 * @property float $sales_rate
 * @property float $quantity_factor
 * @property float $print_quantity
 * @property float $maximum_quantity_purchase
 * @property \Cake\I18n\FrozenTime $start_date
 * @property \Cake\I18n\FrozenTime $end_date
 * @property int $stock_in_quantity
 * @property int $stock_out_quantity
 * @property \Cake\I18n\FrozenTime $created_on
 * @property \Cake\I18n\FrozenTime $edited_on
 * @property string $ready_to_sale
 * @property string $status
 * @property string $combo_offer_image
 *
 * @property \App\Model\Entity\City $city
 * @property \App\Model\Entity\Admin $admin
 * @property \App\Model\Entity\Cart[] $carts
 * @property \App\Model\Entity\ComboOfferDetail[] $combo_offer_details
 * @property \App\Model\Entity\OrderDetail[] $order_details
 */
class ComboOffer extends Entity
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
        'admin_id' => true,
        'name' => true,
        'print_rate' => true,
        'discount_per' => true,
        'sales_rate' => true,
        'quantity_factor' => true,
        'print_quantity' => true,
        'maximum_quantity_purchase' => true,
        'start_date' => true,
        'end_date' => true,
        'stock_in_quantity' => true,
        'stock_out_quantity' => true,
        'created_on' => true,
        'edited_on' => true,
        'ready_to_sale' => true,
        'status' => true,
        'combo_offer_image' => true,
        'city' => true,
        'admin' => true,
        'carts' => true,
        'combo_offer_details' => true,
        'order_details' => true
    ];
}
