<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AccountingGroup Entity
 *
 * @property int $id
 * @property int $nature_of_group_id
 * @property string $name
 * @property int $parent_id
 * @property int $lft
 * @property int $rght
 * @property int $location_id
 * @property bool $customer
 * @property bool $supplier
 * @property bool $purchase_voucher_first_ledger
 * @property bool $purchase_voucher_purchase_ledger
 * @property bool $purchase_voucher_all_ledger
 * @property int $sale_invoice_party
 * @property int $sale_invoice_sales_account
 * @property int $credit_note_party
 * @property int $credit_note_sales_account
 * @property int $bank
 * @property bool $cash
 * @property bool $purchase_invoice_purchase_account
 * @property bool $purchase_invoice_party
 * @property bool $receipt_ledger
 * @property bool $payment_ledger
 * @property bool $credit_note_first_row
 * @property bool $credit_note_all_row
 * @property bool $debit_note_first_row
 * @property bool $debit_note_all_row
 * @property bool $sales_voucher_first_ledger
 * @property bool $sales_voucher_sales_ledger
 * @property bool $sales_voucher_all_ledger
 * @property bool $journal_voucher_ledger
 * @property bool $contra_voucher_ledger
 *
 * @property \App\Model\Entity\NatureOfGroup $nature_of_group
 * @property \App\Model\Entity\ParentAccountingGroup $parent_accounting_group
 * @property \App\Model\Entity\Location $location
 * @property \App\Model\Entity\ChildAccountingGroup[] $child_accounting_groups
 * @property \App\Model\Entity\Ledger[] $ledgers
 */
class AccountingGroup extends Entity
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
        'nature_of_group_id' => true,
        'name' => true,
        'parent_id' => true,
        'lft' => true,
        'rght' => true,
        'location_id' => true,
        'customer' => true,
        'supplier' => true,
        'purchase_voucher_first_ledger' => true,
        'purchase_voucher_purchase_ledger' => true,
        'purchase_voucher_all_ledger' => true,
        'sale_invoice_party' => true,
        'sale_invoice_sales_account' => true,
        'credit_note_party' => true,
        'credit_note_sales_account' => true,
        'bank' => true,
        'cash' => true,
        'purchase_invoice_purchase_account' => true,
        'purchase_invoice_party' => true,
        'receipt_ledger' => true,
        'payment_ledger' => true,
        'credit_note_first_row' => true,
        'credit_note_all_row' => true,
        'debit_note_first_row' => true,
        'debit_note_all_row' => true,
        'sales_voucher_first_ledger' => true,
        'sales_voucher_sales_ledger' => true,
        'sales_voucher_all_ledger' => true,
        'journal_voucher_ledger' => true,
        'contra_voucher_ledger' => true,
        'nature_of_group' => true,
        'parent_accounting_group' => true,
        'location' => true,
        'child_accounting_groups' => true,
        'ledgers' => true
    ];
}
