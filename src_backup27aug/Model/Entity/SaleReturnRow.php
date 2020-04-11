<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * SaleReturnRow Entity
 *
 * @property int $id
 * @property int $sale_return_id
 * @property int $item_variation_id
 * @property float $return_quantity
 * @property float $rate
 * @property float $amount
 * @property float $taxable_value
 * @property float $gst_percentage
 * @property int $gst_figure_id
 * @property float $gst_value
 * @property float $net_amount
 * @property int $order_detail_id
 *
 * @property \App\Model\Entity\SaleReturn $sale_return
 * @property \App\Model\Entity\ItemVariation $item_variation
 * @property \App\Model\Entity\GstFigure $gst_figure
 * @property \App\Model\Entity\OrderDetail $order_detail
 * @property \App\Model\Entity\ItemLedger[] $item_ledgers
 */
class SaleReturnRow extends Entity
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
        'sale_return_id' => true,
        'item_variation_id' => true,
        'return_quantity' => true,
        'rate' => true,
        'amount' => true,
        'taxable_value' => true,
        'gst_percentage' => true,
        'gst_figure_id' => true,
        'gst_value' => true,
        'net_amount' => true,
        'order_detail_id' => true,
        'sale_return' => true,
        'item_variation' => true,
        'gst_figure' => true,
        'order_detail' => true,
        'item_ledgers' => true
    ];
}
