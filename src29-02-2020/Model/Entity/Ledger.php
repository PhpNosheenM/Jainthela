<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Ledger Entity
 *
 * @property int $id
 * @property string $name
 * @property int $accounting_group_id
 * @property bool $freeze
 * @property int $location_id
 * @property int $supplier_id
 * @property int $customer_id
 * @property float $tax_percentage
 * @property string $gst_type
 * @property string $input_output
 * @property int $gst_figure_id
 * @property string $bill_to_bill_accounting
 * @property int $round_off
 * @property int $cash
 * @property int $flag
 * @property int $default_credit_days
 *
 * @property \App\Model\Entity\AccountingGroup $accounting_group
 * @property \App\Model\Entity\Location $location
 * @property \App\Model\Entity\Supplier $supplier
 * @property \App\Model\Entity\Customer $customer
 * @property \App\Model\Entity\GstFigure $gst_figure
 * @property \App\Model\Entity\AccountingEntry[] $accounting_entries
 * @property \App\Model\Entity\CreditNoteRow[] $credit_note_rows
 * @property \App\Model\Entity\DebitNoteRow[] $debit_note_rows
 * @property \App\Model\Entity\JournalVoucherRow[] $journal_voucher_rows
 * @property \App\Model\Entity\PaymentRow[] $payment_rows
 * @property \App\Model\Entity\PurchaseVoucherRow[] $purchase_voucher_rows
 * @property \App\Model\Entity\ReceiptRow[] $receipt_rows
 * @property \App\Model\Entity\ReferenceDetail[] $reference_details
 * @property \App\Model\Entity\SalesVoucherRow[] $sales_voucher_rows
 */
class Ledger extends Entity
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
        'accounting_group_id' => true,
        'freeze' => true,
        'location_id' => true,
        'supplier_id' => true,
        'customer_id' => true,
        'tax_percentage' => true,
        'gst_type' => true,
        'input_output' => true,
        'gst_figure_id' => true,
        'bill_to_bill_accounting' => true,
        'round_off' => true,
        'cash' => true,
        'flag' => true,
        'default_credit_days' => true,
        'accounting_group' => true,
        'location' => true,
        'supplier' => true,
        'customer' => true,
        'gst_figure' => true,
        'accounting_entries' => true,
        'credit_note_rows' => true,
        'debit_note_rows' => true,
        'journal_voucher_rows' => true,
        'payment_rows' => true,
        'purchase_voucher_rows' => true,
        'receipt_rows' => true,
        'reference_details' => true,
        'sales_voucher_rows' => true
    ];
}
