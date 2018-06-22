<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * SaleReturn Entity
 *
 * @property int $id
 * @property int $voucher_no
 * @property \Cake\I18n\FrozenDate $transaction_date
 * @property int $customer_id
 * @property float $amount_before_tax
 * @property float $total_cgst
 * @property float $total_sgst
 * @property float $total_igst
 * @property float $amount_after_tax
 * @property float $round_off
 * @property int $sales_ledger_id
 * @property int $party_ledger_id
 * @property int $location_id
 * @property int $city_id
 * @property int $order_id
 * @property string $status
 *
 * @property \App\Model\Entity\Customer $customer
 * @property \App\Model\Entity\SalesLedger $sales_ledger
 * @property \App\Model\Entity\PartyLedger $party_ledger
 * @property \App\Model\Entity\Location $location
 * @property \App\Model\Entity\City $city
 * @property \App\Model\Entity\Order $order
 * @property \App\Model\Entity\AccountingEntry[] $accounting_entries
 * @property \App\Model\Entity\ItemLedger[] $item_ledgers
 * @property \App\Model\Entity\ReferenceDetail[] $reference_details
 * @property \App\Model\Entity\SaleReturnRow[] $sale_return_rows
 */
class SaleReturn extends Entity
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
        'voucher_no' => true,
        'transaction_date' => true,
        'customer_id' => true,
        'amount_before_tax' => true,
        'total_cgst' => true,
        'total_sgst' => true,
        'total_igst' => true,
        'amount_after_tax' => true,
        'round_off' => true,
        'sales_ledger_id' => true,
        'party_ledger_id' => true,
        'location_id' => true,
        'city_id' => true,
        'order_id' => true,
        'status' => true,
        'customer' => true,
        'sales_ledger' => true,
        'party_ledger' => true,
        'location' => true,
        'city' => true,
        'order' => true,
        'accounting_entries' => true,
        'item_ledgers' => true,
        'reference_details' => true,
        'sale_return_rows' => true
    ];
}
