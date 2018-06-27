<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PurchaseReturnRow Entity
 *
 * @property int $id
 * @property int $purchase_return_id
 * @property int $purchase_invoice_row_id
 * @property int $item_id
 * @property int $item_variation_id
 * @property float $quantity
 * @property float $rate
 * @property float $discount_percentage
 * @property float $discount_amount
 * @property float $taxable_value
 * @property float $net_amount
 * @property int $gst_percentage
 * @property float $gst_value
 * @property float $round_off
 * @property float $purchase_rate
 * @property float $sales_rate
 * @property string $gst_type
 * @property float $mrp
 *
 * @property \App\Model\Entity\PurchaseReturn $purchase_return
 * @property \App\Model\Entity\PurchaseInvoiceRow $purchase_invoice_row
 * @property \App\Model\Entity\Item $item
 * @property \App\Model\Entity\ItemVariation $item_variation
 * @property \App\Model\Entity\ItemLedger[] $item_ledgers
 */
class PurchaseReturnRow extends Entity
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
        'purchase_return_id' => true,
        'purchase_invoice_row_id' => true,
        'item_id' => true,
        'item_variation_id' => true,
        'quantity' => true,
        'rate' => true,
        'discount_percentage' => true,
        'discount_amount' => true,
        'taxable_value' => true,
        'net_amount' => true,
        'gst_percentage' => true,
        'gst_value' => true,
        'round_off' => true,
        'purchase_rate' => true,
        'sales_rate' => true,
        'gst_type' => true,
        'mrp' => true,
        'purchase_return' => true,
        'purchase_invoice_row' => true,
        'item' => true,
        'item_variation' => true,
        'item_ledgers' => true
    ];
}
