<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Notify Entity
 *
 * @property int $id
 * @property int $customer_id
 * @property int $item_variation_id
 * @property string $send_flag
 *
 * @property \App\Model\Entity\Customer $customer
 * @property \App\Model\Entity\ItemVariation $item_variation
 */
class Notify extends Entity
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
        'item_variation_id' => true,
        'send_flag' => true,
        'customer' => true,
        'item_variation' => true
    ];
}
