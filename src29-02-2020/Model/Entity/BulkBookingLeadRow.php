<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * BulkBookingLeadRow Entity
 *
 * @property int $id
 * @property int $bulk_booking_lead_id
 * @property string $image_name
 *
 * @property \App\Model\Entity\BulkBookingLead $bulk_booking_lead
 */
class BulkBookingLeadRow extends Entity
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
        'bulk_booking_lead_id' => true,
        'image_name' => true,
        'bulk_booking_lead' => true
    ];
}
