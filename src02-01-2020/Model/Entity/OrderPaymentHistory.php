<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * OrderPaymentHistory Entity
 *
 * @property int $id
 * @property int $order_id
 * @property int $invoice_id
 * @property float $online_amount
 * @property float $cod_amount
 * @property float $wallet_amount
 * @property float $total
 * @property float $wallet_return
 * @property string $entry_from
 *
 * @property \App\Model\Entity\Order $order
 * @property \App\Model\Entity\Invoice $invoice
 */
class OrderPaymentHistory extends Entity
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
        'order_id' => true,
        'invoice_id' => true,
        'online_amount' => true,
        'cod_amount' => true,
        'wallet_amount' => true,
        'total' => true,
        'wallet_return' => true,
        'entry_from' => true,
        'order' => true,
        'invoice' => true
    ];
}
