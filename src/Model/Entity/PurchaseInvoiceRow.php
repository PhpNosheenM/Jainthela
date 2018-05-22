<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PurchaseInvoiceRow Entity
 *
 * @property int $id
 * @property int $purchase_invoice_id
 * @property int $item_id
 * @property int $item_variation_id
 * @property float $quantity
 * @property float $rate
 * @property float $discount_percentage
 * @property float $discount_amount
 * @property float $taxable_value
 * @property float $net_amount
 * @property int $item_gst_figure_id
 * @property int $gst_percentage
 * @property float $gst_value
 * @property float $round_off
 *
 * @property \App\Model\Entity\PurchaseInvoice $purchase_invoice
 * @property \App\Model\Entity\Item $item
 * @property \App\Model\Entity\ItemVariation $item_variation
 * @property \App\Model\Entity\ItemGstFigure $item_gst_figure
 * @property \App\Model\Entity\ItemLedger[] $item_ledgers
 * @property \App\Model\Entity\PurchaseReturnRow[] $purchase_return_rows
 */
class PurchaseInvoiceRow extends Entity
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
        'purchase_invoice_id' => true,
        'item_id' => true,
        'item_variation_id' => true,
        'unit_variation_id' => true,
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
        'purchase_rate' => true,
        'sales_rate' => true,
        'gst_type' => true,
        'mrp' => true,
        'item' => true,
        'item_variation' => true,
        'item_ledgers' => true,
        'purchase_return_rows' => true
    ];
}
