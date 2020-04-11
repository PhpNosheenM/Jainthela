<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * InvoiceRow Entity
 *
 * @property int $id
 * @property int $invoice_id
 * @property int $order_detail_id
 * @property int $item_id
 * @property int $item_variation_id
 * @property int $combo_offer_id
 * @property float $quantity
 * @property float $actual_quantity
 * @property float $rate
 * @property float $amount
 * @property float $discount_percent
 * @property float $discount_amount
 * @property float $promo_percent
 * @property float $promo_amount
 * @property float $taxable_value
 * @property float $gst_percentage
 * @property int $gst_figure_id
 * @property float $gst_value
 * @property float $net_amount
 * @property string $is_item_cancel
 *
 * @property \App\Model\Entity\Invoice $invoice
 * @property \App\Model\Entity\OrderDetail $order_detail
 * @property \App\Model\Entity\Item $item
 * @property \App\Model\Entity\ItemVariation $item_variation
 * @property \App\Model\Entity\ComboOffer $combo_offer
 * @property \App\Model\Entity\GstFigure $gst_figure
 */
class InvoiceRow extends Entity
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
        'invoice_id' => true,
        'order_detail_id' => true,
        'item_id' => true,
        'item_variation_id' => true,
        'combo_offer_id' => true,
        'quantity' => true,
        'actual_quantity' => true,
        'rate' => true,
        'amount' => true,
        'discount_percent' => true,
        'discount_amount' => true,
        'promo_percent' => true,
        'promo_amount' => true,
        'taxable_value' => true,
        'gst_percentage' => true,
        'gst_figure_id' => true,
        'gst_value' => true,
        'net_amount' => true,
        'is_item_cancel' => true,
        'invoice' => true,
        'order_detail' => true,
        'item' => true,
        'item_variation' => true,
        'combo_offer' => true,
        'gst_figure' => true
    ];
}
