<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ItemLedger Entity
 *
 * @property int $id
 * @property int $item_id
 * @property int $item_variation_id
 * @property \Cake\I18n\FrozenDate $transaction_date
 * @property float $quantity
 * @property float $rate
 * @property float $amount
 * @property string $status
 * @property string $is_opening_balance
 * @property float $sale_rate
 * @property float $purchase_rate
 * @property int $sales_invoice_id
 * @property int $sales_invoice_row_id
 * @property int $location_id
 * @property int $credit_note_id
 * @property int $credit_note_row_id
 * @property int $sale_return_id
 * @property int $sale_return_row_id
 * @property int $purchase_invoice_id
 * @property int $purchase_invoice_row_id
 * @property int $purchase_return_id
 * @property int $purchase_return_row_id
 * @property int $city_id
 * @property string $entry_from
 *
 * @property \App\Model\Entity\Item $item
 * @property \App\Model\Entity\ItemVariation $item_variation
 * @property \App\Model\Entity\SalesInvoice $sales_invoice
 * @property \App\Model\Entity\SalesInvoiceRow $sales_invoice_row
 * @property \App\Model\Entity\Location $location
 * @property \App\Model\Entity\CreditNote $credit_note
 * @property \App\Model\Entity\CreditNoteRow $credit_note_row
 * @property \App\Model\Entity\SaleReturn $sale_return
 * @property \App\Model\Entity\SaleReturnRow $sale_return_row
 * @property \App\Model\Entity\PurchaseInvoice $purchase_invoice
 * @property \App\Model\Entity\PurchaseInvoiceRow $purchase_invoice_row
 * @property \App\Model\Entity\PurchaseReturn $purchase_return
 * @property \App\Model\Entity\PurchaseReturnRow $purchase_return_row
 * @property \App\Model\Entity\City $city
 */
class ItemLedger extends Entity
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
        'item_id' => true,
        'item_variation_id' => true,
        'transaction_date' => true,
        'quantity' => true,
        'rate' => true,
        'amount' => true,
        'status' => true,
        'is_opening_balance' => true,
        'sale_rate' => true,
        'purchase_rate' => true,
        'sales_invoice_id' => true,
        'sales_invoice_row_id' => true,
        'location_id' => true,
        'credit_note_id' => true,
        'credit_note_row_id' => true,
        'sale_return_id' => true,
        'sale_return_row_id' => true,
        'purchase_invoice_id' => true,
        'purchase_invoice_row_id' => true,
        'purchase_return_id' => true,
        'purchase_return_row_id' => true,
        'city_id' => true,
        'entry_from' => true,
        'item' => true,
        'item_variation' => true,
        'sales_invoice' => true,
        'sales_invoice_row' => true,
        'location' => true,
        'credit_note' => true,
        'credit_note_row' => true,
        'sale_return' => true,
        'sale_return_row' => true,
        'purchase_invoice' => true,
        'purchase_invoice_row' => true,
        'purchase_return' => true,
        'purchase_return_row' => true,
        'city' => true
    ];
}
