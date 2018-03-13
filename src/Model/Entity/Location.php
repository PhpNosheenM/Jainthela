<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Location Entity
 *
 * @property int $id
 * @property int $city_id
 * @property string $name
 * @property string $latitude
 * @property string $longitude
 * @property int $created_on
 * @property int $created_by
 * @property int $status
 *
 * @property \App\Model\Entity\City $city
 * @property \App\Model\Entity\AccountingEntry[] $accounting_entries
 * @property \App\Model\Entity\AccountingGroup[] $accounting_groups
 * @property \App\Model\Entity\Admin[] $admins
 * @property \App\Model\Entity\CreditNote[] $credit_notes
 * @property \App\Model\Entity\CustomerAddress[] $customer_addresses
 * @property \App\Model\Entity\DebitNote[] $debit_notes
 * @property \App\Model\Entity\Driver[] $drivers
 * @property \App\Model\Entity\Grn[] $grns
 * @property \App\Model\Entity\GstFigure[] $gst_figures
 * @property \App\Model\Entity\JournalVoucher[] $journal_vouchers
 * @property \App\Model\Entity\Order[] $orders
 * @property \App\Model\Entity\Payment[] $payments
 * @property \App\Model\Entity\PurchaseInvoice[] $purchase_invoices
 * @property \App\Model\Entity\PurchaseReturn[] $purchase_returns
 * @property \App\Model\Entity\PurchaseVoucher[] $purchase_vouchers
 * @property \App\Model\Entity\Receipt[] $receipts
 * @property \App\Model\Entity\ReferenceDetail[] $reference_details
 * @property \App\Model\Entity\SaleReturn[] $sale_returns
 * @property \App\Model\Entity\SalesInvoice[] $sales_invoices
 * @property \App\Model\Entity\SalesVoucher[] $sales_vouchers
 * @property \App\Model\Entity\Supplier[] $suppliers
 */
class Location extends Entity
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
        'city_id' => true,
        'name' => true,
        'latitude' => true,
        'longitude' => true,
        'created_on' => true,
        'created_by' => true,
        'status' => true,
        'city' => true,
        'accounting_entries' => true,
        'accounting_groups' => true,
        'admins' => true,
        'financial_year_begins_from' => true,
        'books_beginning_from' => true,
        'financial_year_valid_to' => true,
        'credit_notes' => true,
        'customer_addresses' => true,
        'debit_notes' => true,
        'drivers' => true,
        'grns' => true,
        'gst_figures' => true,
        'journal_vouchers' => true,
        'orders' => true,
        'payments' => true,
        'purchase_invoices' => true,
        'purchase_returns' => true,
        'purchase_vouchers' => true,
        'receipts' => true,
        'reference_details' => true,
        'sale_returns' => true,
        'sales_invoices' => true,
        'sales_vouchers' => true,
        'suppliers' => true
    ];
}
