<?php
namespace App\Model\Entity;
use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;

/**
 * Customer Entity
 *
 * @property int $id
 * @property int $city_id
 * @property string $name
 * @property string $email
 * @property string $username
 * @property string $password
 * @property string $latitude
 * @property string $longitude
 * @property string $device_id_name
 * @property string $device_token
 * @property string $referral_code
 * @property float $discount_in_percentage
 * @property string $otp
 * @property int $timeout
 * @property \Cake\I18n\FrozenTime $created_on
 * @property int $created_by
 * @property int $active
 * @property string $gstin
 * @property string $gstin_holder_name
 * @property string $gstin_holder_address
 * @property string $firm_name
 * @property string $firm_address
 * @property \Cake\I18n\FrozenTime $discount_created_on
 * @property \Cake\I18n\FrozenTime $discount_expiry
 *
 * @property \App\Model\Entity\City $city
 * @property \App\Model\Entity\AppNotificationCustomer[] $app_notification_customers
 * @property \App\Model\Entity\BulkBookingLead[] $bulk_booking_leads
 * @property \App\Model\Entity\Cart[] $carts
 * @property \App\Model\Entity\CustomerAddress[] $customer_addresses
 * @property \App\Model\Entity\Feedback[] $feedbacks
 * @property \App\Model\Entity\Ledger[] $ledgers
 * @property \App\Model\Entity\Order[] $orders
 * @property \App\Model\Entity\ReferenceDetail[] $reference_details
 * @property \App\Model\Entity\SaleReturn[] $sale_returns
 * @property \App\Model\Entity\SalesInvoice[] $sales_invoices
 * @property \App\Model\Entity\SellerRating[] $seller_ratings
 * @property \App\Model\Entity\Wallet[] $wallets
 */
class Customer extends Entity
{
	protected function _setPassword($password)
    {
        return (new DefaultPasswordHasher)->hash($password);
    }

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
        'name' => true,
        'city_count' => true,
        'customer_no' => true,
		'default_credit_days' => true,
        'email' => true,
        'username' => true,
        'password' => true,
        'latitude' => true,
        'longitude' => true,
        'device_id' => true,
        'fcm_token' => true,
		'device_token' => true,
        'referral_code' => true,
        'discount_in_percentage' => true,
        'otp' => true,
        'timeout' => true,
        'created_on' => true,
        'created_by' => true,
		'status' => true,
        'active' => true,
        'gstin' => true,
        'gstin_holder_name' => true,
        'gstin_holder_address' => true,
        'firm_name' => true,
        'firm_address' => true,
        'discount_created_on' => true,
        'discount_expiry' => true,
        'city' => true,
        'app_notification_customers' => true,
        'bulk_booking_leads' => true,
        'carts' => true,
        'customer_addresses' => true,
        'feedbacks' => true,
        'ledgers' => true,
        'orders' => true,
        'reference_details' => true,
        'sale_returns' => true,
        'sales_invoices' => true,
        'seller_ratings' => true,
        'opening_balance_value' => true,
        'bill_to_bill_accounting' => true,
        'debit_credit' => true,
        'wallets' => true,
        'membership_discount' => true,
        'start_date' => true,
        'end_date' => true,
        'cancel_order_count' => true,
		'shipping_price' => true,
		'is_shipping_price' => true,
        'is_free_shipping' => true,
		'social' => true,
		'social_id'=> true
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password'
    ];
}
