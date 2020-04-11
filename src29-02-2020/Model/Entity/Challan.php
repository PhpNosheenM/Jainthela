<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Challan Entity
 *
 * @property int $id
 * @property int $order_id
 * @property int $location_id
 * @property int $seller_id
 * @property string $seller_name
 * @property int $financial_year_id
 * @property int $city_id
 * @property int $sales_ledger_id
 * @property int $party_ledger_id
 * @property int $customer_id
 * @property int $driver_id
 * @property int $customer_address_id
 * @property string $address
 * @property int $promotion_detail_id
 * @property string $invoice_no
 * @property int $voucher_no
 * @property string $ccavvenue_tracking_no
 * @property float $amount_from_wallet
 * @property float $total_amount
 * @property float $discount_percent
 * @property float $discount_amount
 * @property float $total_gst
 * @property float $grand_total
 * @property float $round_off
 * @property float $pay_amount
 * @property float $due_amount
 * @property float $online_amount
 * @property int $delivery_charge_id
 * @property string $delivery_charge_amount
 * @property string $order_type
 * @property \Cake\I18n\FrozenDate $delivery_date
 * @property string $delivery_time_sloat
 * @property int $delivery_time_id
 * @property string $order_status
 * @property int $cancel_reason_id
 * @property string $cancel_reason_other
 * @property \Cake\I18n\FrozenDate $cancel_date
 * @property \Cake\I18n\FrozenDate $transaction_date
 * @property \Cake\I18n\FrozenDate $order_date
 * @property string $payment_status
 * @property string $order_from
 * @property string $narration
 * @property \Cake\I18n\FrozenTime $packing_on
 * @property string $packing_flag
 * @property \Cake\I18n\FrozenTime $dispatch_on
 * @property string $dispatch_flag
 * @property string $otp
 * @property string $otp_confirmation
 * @property string $not_received
 * @property float $online_return_amount
 *
 * @property \App\Model\Entity\Order $order
 * @property \App\Model\Entity\Location $location
 * @property \App\Model\Entity\Seller $seller
 * @property \App\Model\Entity\FinancialYear $financial_year
 * @property \App\Model\Entity\City $city
 * @property \App\Model\Entity\SalesLedger $sales_ledger
 * @property \App\Model\Entity\PartyLedger $party_ledger
 * @property \App\Model\Entity\Customer $customer
 * @property \App\Model\Entity\Driver $driver
 * @property \App\Model\Entity\CustomerAddress $customer_address
 * @property \App\Model\Entity\PromotionDetail $promotion_detail
 * @property \App\Model\Entity\DeliveryCharge $delivery_charge
 * @property \App\Model\Entity\DeliveryTime $delivery_time
 * @property \App\Model\Entity\CancelReason $cancel_reason
 * @property \App\Model\Entity\ChallanRow[] $challan_rows
 */
class Challan extends Entity
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
        'order_id' => true,
        'where_challan' => true,
        'location_id' => true,
        'seller_id' => true,
        'seller_name' => true,
        'financial_year_id' => true,
        'city_id' => true,
        'sales_ledger_id' => true,
        'party_ledger_id' => true,
        'customer_id' => true,
        'driver_id' => true,
        'customer_address_id' => true,
        'address' => true,
        'promotion_detail_id' => true,
        'invoice_no' => true,
        'voucher_no' => true,
        'ccavvenue_tracking_no' => true,
        'amount_from_wallet' => true,
        'total_amount' => true,
        'discount_percent' => true,
        'discount_amount' => true,
        'cancel_time' => true,
        'cancel_from' => true,
        'total_gst' => true,
        'grand_total' => true,
        'round_off' => true,
        'pay_amount' => true,
        'due_amount' => true,
        'online_amount' => true,
        'delivery_charge_id' => true,
        'delivery_charge_amount' => true,
        'order_type' => true,
        'delivery_date' => true,
        'delivery_time_sloat' => true,
        'delivery_time_id' => true,
        'order_status' => true,
        'cancel_reason_id' => true,
        'cancel_reason_other' => true,
        'cancel_date' => true,
        'transaction_date' => true,
        'order_date' => true,
        'payment_status' => true,
        'order_from' => true,
        'narration' => true,
        'packing_on' => true,
        'packing_flag' => true,
        'dispatch_on' => true,
        'dispatch_flag' => true,
        'otp' => true,
        'otp_confirmation' => true,
        'not_received' => true,
        'online_return_amount' => true,
        'order' => true,
        'location' => true,
        'seller' => true,
        'financial_year' => true,
        'city' => true,
        'sales_ledger' => true,
        'party_ledger' => true,
        'customer' => true,
        'driver' => true,
        'customer_address' => true,
        'promotion_detail' => true,
        'delivery_charge' => true,
        'delivery_time' => true,
        'cancel_reason' => true,
		'old_pay_amount' => true,
        'challan_rows' => true
    ];
}
