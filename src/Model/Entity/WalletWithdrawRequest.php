<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * WalletWithdrawRequest Entity
 *
 * @property int $id
 * @property int $city_id
 * @property int $customer_id
 * @property float $amount
 * @property \Cake\I18n\FrozenDate $request_date
 * @property string $status
 *
 * @property \App\Model\Entity\City $city
 * @property \App\Model\Entity\Customer $customer
 */
class WalletWithdrawRequest extends Entity
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
        'customer_id' => true,
        'ledger_id' => true,
        'account_holder_name' => true,
        'amount' => true,
        'request_date' => true,
        'completed_on' => true,
        'status' => true,
        'city' => true,
		'account_no'=>true,
		'ifsc_code'=>true,
		'bank_name'=>true
    ];
}
