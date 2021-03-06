<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Plan Entity
 *
 * @property int $id
 * @property int $admin_id
 * @property int $city_id
 * @property string $name
 * @property float $amount
 * @property float $benifit_per
 * @property float $total_amount
 * @property \Cake\I18n\FrozenTime $created_on
 * @property int $status
 *
 * @property \App\Model\Entity\Admin $admin
 * @property \App\Model\Entity\City $city
 * @property \App\Model\Entity\Wallet[] $wallets
 */
class Plan extends Entity
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
        'admin_id' => true,
        'city_id' => true,
        'name' => true,
        'no_of_days' => true,
        'start_date' => true,
        'end_date' => true,
        'amount' => true,
        'benifit_per' => true,
        'total_amount' => true,
        'created_on' => true,
        'plan_type' => true,
        'status' => true,
        'admin' => true,
        'city' => true,
        'wallets' => true
    ];
}
