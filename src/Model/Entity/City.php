<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * City Entity
 *
 * @property int $id
 * @property int $state_id
 * @property string $name
 * @property \Cake\I18n\FrozenTime $created_on
 * @property int $created_by
 * @property int $status
 *
 * @property \App\Model\Entity\State $state
 * @property \App\Model\Entity\AppNotification[] $app_notifications
 * @property \App\Model\Entity\Banner[] $banners
 * @property \App\Model\Entity\BulkBookingLead[] $bulk_booking_leads
 * @property \App\Model\Entity\Cart[] $carts
 * @property \App\Model\Entity\Category[] $categories
 * @property \App\Model\Entity\ComboOffer[] $combo_offers
 * @property \App\Model\Entity\CompanyDetail[] $company_details
 * @property \App\Model\Entity\CustomerAddress[] $customer_addresses
 * @property \App\Model\Entity\Customer[] $customers
 * @property \App\Model\Entity\DeliveryCharge[] $delivery_charges
 * @property \App\Model\Entity\DeliveryTime[] $delivery_times
 * @property \App\Model\Entity\Item[] $items
 * @property \App\Model\Entity\Location[] $locations
 * @property \App\Model\Entity\Plan[] $plans
 * @property \App\Model\Entity\Promotion[] $promotions
 * @property \App\Model\Entity\Role[] $roles
 * @property \App\Model\Entity\Seller[] $sellers
 * @property \App\Model\Entity\SupplierArea[] $supplier_areas
 */
class City extends Entity
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
        'state_id' => true,
        'name' => true,
        'created_on' => true,
        'created_by' => true,
        'status' => true,
        'state' => true,
        'app_notifications' => true,
        'banners' => true,
        'bulk_booking_leads' => true,
        'carts' => true,
        'categories' => true,
        'combo_offers' => true,
        'company_details' => true,
        'customer_addresses' => true,
        'customers' => true,
        'delivery_charges' => true,
        'delivery_times' => true,
        'items' => true,
        'locations' => true,
        'plans' => true,
        'promotions' => true,
        'roles' => true,
        'sellers' => true,
        'supplier_areas' => true
    ];
}
