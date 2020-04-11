<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ItemHistory Entity
 *
 * @property int $id
 * @property int $item_id
 * @property string $status
 * @property \Cake\I18n\FrozenDate $created_on
 * @property \Cake\I18n\FrozenTime $created_time
 *
 * @property \App\Model\Entity\Item $item
 */
class ItemHistory extends Entity
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
        'item_id' => true,
        'status' => true,
        'created_on' => true,
        'created_time' => true,
        'item' => true
    ];
}
