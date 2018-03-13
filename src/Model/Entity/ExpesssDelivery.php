<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ExpesssDelivery Entity
 *
 * @property int $id
 * @property string $title
 * @property string $icon
 * @property string $content_data
 * @property string $status
 */
class ExpesssDelivery extends Entity
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
        'title' => true,
        'icon' => true,
        'content_data' => true,
        'status' => true
    ];
}
