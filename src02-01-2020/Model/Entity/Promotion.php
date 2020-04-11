<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Promotion Entity
 *
 * @property int $id
 * @property int $admin_id
 * @property int $city_id
 * @property string $offer_name
 * @property string $description
 * @property \Cake\I18n\FrozenTime $start_date
 * @property \Cake\I18n\FrozenTime $end_date
 * @property \Cake\I18n\FrozenTime $created_on
 * @property string $status
 *
 * @property \App\Model\Entity\Admin $admin
 * @property \App\Model\Entity\City $city
 * @property \App\Model\Entity\PromotionDetail[] $promotion_details
 * @property \App\Model\Entity\Wallet[] $wallets
 */
class Promotion extends Entity
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
        'offer_name' => true,
        'description' => true,
        'start_date' => true,
        'end_date' => true,
        'created_on' => true,
        'status' => true,
        'admin' => true,
        'city' => true,
        'promotion_details' => true,
        'wallets' => true
    ];
}
