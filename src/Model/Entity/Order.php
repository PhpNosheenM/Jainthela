<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Order Entity
 *
 * @property int $id
 * @property int $location_id
 * @property int $customer_id
 * @property int $driver_id
 * @property int $customer_address_id
 * @property int $promotion_detail_id
 * @property string $order_no
 * @property string $ccavvenue_tracking_no
 * @property float $amount_from_wallet
 * @property float $total_amount
 * @property float $discount_percent
 * @property float $total_gst
 * @property float $grand_total
 * @property float $pay_amount
 * @property float $online_amount
 * @property int $delivery_charge_id
 * @property string $order_type
 * @property \Cake\I18n\FrozenTime $delivery_date
 * @property int $delivery_time_id
 * @property string $order_status
 * @property int $cancel_reason_id
 * @property \Cake\I18n\FrozenTime $order_date
 * @property string $payment_status
 * @property string $order_from
 *
 * @property \App\Model\Entity\Location $location
 * @property \App\Model\Entity\Customer $customer
 * @property \App\Model\Entity\Driver $driver
 * @property \App\Model\Entity\CustomerAddress $customer_address
 * @property \App\Model\Entity\PromotionDetail $promotion_detail
 * @property \App\Model\Entity\DeliveryCharge $delivery_charge
 * @property \App\Model\Entity\DeliveryTime $delivery_time
 * @property \App\Model\Entity\CancelReason $cancel_reason
 * @property \App\Model\Entity\OrderDetail[] $order_details
 * @property \App\Model\Entity\Wallet[] $wallets
 */
class Order extends Entity
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
        'customer_id' => true,
        'party_ledger_id' => true,
        'transaction_date' => true,
        'sales_ledger_id' => true,
        'narration' => true,
        'driver_id' => true,
        'customer_address_id' => true,
        'promotion_detail_id' => true,
        'order_no' => true,
        'ccavvenue_tracking_no' => true,
        'amount_from_wallet' => true,
        'total_amount' => true,
        'discount_percent' => true,
        'total_gst' => true,
        'grand_total' => true,
        'pay_amount' => true,
        'online_amount' => true,
        'delivery_charge_id' => true,
        'order_type' => true,
        'delivery_date' => true,
        'delivery_time_id' => true,
        'order_status' => true,
        'cancel_reason_id' => true,
        'total_taxable_value' => true,
        'order_date' => true,
        'payment_status' => true,
        'order_from' => true,
        'location' => true,
        'customer' => true,
        'driver' => true,
        'customer_address' => true,
        'promotion_detail' => true,
        'delivery_charge' => true,
        'delivery_time' => true,
        'cancel_reason' => true,
        'order_details' => true,
        'wallets' => true,
        'delivery_charge_amount' => true
    ];
}
