<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * VerifyOtp Entity
 *
 * @property int $id
 * @property string $mobile
 * @property string $opt
 * @property int $status
 */
class VerifyOtp extends Entity
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
        'mobile' => true,
        'opt' => true,
        'status' => true
    ];
}
