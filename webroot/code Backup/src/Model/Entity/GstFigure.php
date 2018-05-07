<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * GstFigure Entity
 *
 * @property int $id
 * @property string $name
 * @property int $location_id
 * @property float $tax_percentage
 *
 * @property \App\Model\Entity\Location $location
 * @property \App\Model\Entity\Ledger[] $ledgers
 * @property \App\Model\Entity\SaleReturnRow[] $sale_return_rows
 * @property \App\Model\Entity\SalesInvoiceRow[] $sales_invoice_rows
 */
class GstFigure extends Entity
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
        'name' => true,
        'location_id' => true,
        'tax_percentage' => true,
        'location' => true,
        'ledgers' => true,
        'sale_return_rows' => true,
        'sales_invoice_rows' => true
    ];
}
