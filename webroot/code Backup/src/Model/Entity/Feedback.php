<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Feedback Entity
 *
 * @property int $id
 * @property int $customer_id
 * @property int $city_id
 * @property string $name
 * @property string $email
 * @property string $mobile_no
 * @property string $comment
 * @property \Cake\I18n\FrozenTime $created_on
 *
 * @property \App\Model\Entity\Customer $customer
 * @property \App\Model\Entity\City $city
 */
class Feedback extends Entity
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
        'customer_id' => true,
        'city_id' => true,
        'name' => true,
        'email' => true,
        'mobile_no' => true,
        'comment' => true,
        'created_on' => true,
        'customer' => true,
        'city' => true
    ];
}
