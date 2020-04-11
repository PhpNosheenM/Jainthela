<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AppNotificationCustomer Entity
 *
 * @property int $id
 * @property int $app_notification_id
 * @property int $customer_id
 * @property int $sent
 * @property \Cake\I18n\FrozenTime $send_on
 *
 * @property \App\Model\Entity\AppNotification $app_notification
 * @property \App\Model\Entity\Customer $customer
 */
class AppNotificationCustomer extends Entity
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
        'app_notification_id' => true,
        'customer_id' => true,
        'sent' => true,
        'send_on' => true,
        'app_notification' => true,
        'customer' => true
    ];
}
