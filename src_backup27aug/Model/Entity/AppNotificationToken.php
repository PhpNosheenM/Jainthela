<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AppNotificationToken Entity
 *
 * @property int $id
 * @property string $web_token
 * @property string $app_token
 * @property string $status
 */
class AppNotificationToken extends Entity
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
        'web_token' => true,
        'app_token' => true,
        'ciy_id' => true,
        'status' => true
    ];
}
