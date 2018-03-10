<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Item Entity
 *
 * @property int $id
 * @property int $category_id
 * @property int $brand_id
 * @property int $admin_id
 * @property int $seller_id
 * @property int $city_id
 * @property string $name
 * @property string $description
 * @property float $minimum_stock
 * @property float $next_day_requirement
 * @property string $request_for_sample
 * @property string $default_grade
 * @property float $tax
 * @property \Cake\I18n\FrozenTime $created_on
 * @property \Cake\I18n\FrozenTime $edited_on
 * @property string $approve
 * @property string $status
 * @property string $app_image
 * @property string $web_image
 * @property string $alias_name
 * @property string $out_of_stock
 * @property string $ready_to_sale
 *
 * @property \App\Model\Entity\Category $category
 * @property \App\Model\Entity\Brand $brand
 * @property \App\Model\Entity\Admin $admin
 * @property \App\Model\Entity\Seller $seller
 * @property \App\Model\Entity\City $city
 * @property \App\Model\Entity\AppNotification[] $app_notifications
 * @property \App\Model\Entity\Cart[] $carts
 * @property \App\Model\Entity\ComboOfferDetail[] $combo_offer_details
 * @property \App\Model\Entity\GrnRow[] $grn_rows
 * @property \App\Model\Entity\ItemVariation[] $item_variations
 * @property \App\Model\Entity\PromotionDetail[] $promotion_details
 * @property \App\Model\Entity\PurchaseInvoiceRow[] $purchase_invoice_rows
 * @property \App\Model\Entity\PurchaseReturnRow[] $purchase_return_rows
 * @property \App\Model\Entity\SaleReturnRow[] $sale_return_rows
 * @property \App\Model\Entity\SalesInvoiceRow[] $sales_invoice_rows
 * @property \App\Model\Entity\SellerItem[] $seller_items
 */
class Item extends Entity
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
        'category_id' => true,
        'brand_id' => true,
        'admin_id' => true,
        'seller_id' => true,
        'city_id' => true,
        'name' => true,
        'description' => true,
        'minimum_stock' => true,
        'next_day_requirement' => true,
        'request_for_sample' => true,
        'default_grade' => true,
        'tax' => true,
        'created_on' => true,
        'edited_on' => true,
        'approve' => true,
        'status' => true,
        'app_image' => true,
        'web_image' => true,
        'alias_name' => true,
        'out_of_stock' => true,
        'ready_to_sale' => true,
        'category' => true,
        'brand' => true,
        'admin' => true,
        'seller' => true,
        'city' => true,
        'app_notifications' => true,
        'carts' => true,
        'combo_offer_details' => true,
        'grn_rows' => true,
        'item_variations' => true,
        'promotion_details' => true,
        'purchase_invoice_rows' => true,
        'purchase_return_rows' => true,
        'sale_return_rows' => true,
        'sales_invoice_rows' => true,
        'seller_items' => true
    ];
}
