<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CustomerMembership Entity
 *
 * @property int $id
 * @property int $customer_id
 * @property int $city_id
 * @property int $plan_id
 * @property float $amount
 * @property float $discount_percentage
 * @property \Cake\I18n\FrozenDate $start_date
 * @property \Cake\I18n\FrozenDate $end_date
 * @property \Cake\I18n\FrozenTime $created_on
 *
 * @property \App\Model\Entity\Customer $customer
 * @property \App\Model\Entity\City $city
 * @property \App\Model\Entity\Plan $plan
 */
class CustomerMembership extends Entity
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
        '*' => true,
		'id'=> false
    ];
}
