<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CancelReason Entity
 *
 * @property int $id
 * @property string $reason
 * @property \Cake\I18n\FrozenTime $created_on
 * @property int $created_by
 *
 * @property \App\Model\Entity\Order[] $orders
 */
class CancelReason extends Entity
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
        'reason' => true,
        'created_on' => true,
        'created_by' => true,
        'orders' => true,
		'status' => true
    ];
}
