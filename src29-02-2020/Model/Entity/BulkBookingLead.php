<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * BulkBookingLead Entity
 *
 * @property int $id
 * @property int $city_id
 * @property int $customer_id
 * @property int $lead_no
 * @property string $name
 * @property string $mobile
 * @property string $lead_description
 * @property \Cake\I18n\FrozenDate $delivery_date
 * @property string $delivery_time
 * @property \Cake\I18n\FrozenTime $created_on
 * @property string $status
 * @property string $reason
 *
 * @property \App\Model\Entity\City $city
 * @property \App\Model\Entity\Customer $customer
 * @property \App\Model\Entity\BulkBookingLeadRow[] $bulk_booking_lead_rows
 */
class BulkBookingLead extends Entity
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
        'city_id' => true,
        'customer_id' => true,
        'lead_no' => true,
        'name' => true,
        'mobile' => true,
        'lead_description' => true,
        'delivery_date' => true,
        'delivery_time' => true,
        'created_on' => true,
        'status' => true,
        'reason' => true,
        'city' => true,
        'customer' => true,
        'bulk_booking_lead_rows' => true
    ];
}
