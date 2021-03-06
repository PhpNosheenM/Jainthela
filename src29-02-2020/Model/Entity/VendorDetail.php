<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * VendorDetail Entity
 *
 * @property int $id
 * @property int $vendor_id
 * @property string $contact_person
 * @property string $contact_no
 * @property string $contact_email
 *
 * @property \App\Model\Entity\Vendor $vendor
 */
class VendorDetail extends Entity
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
        'vendor_id' => true,
        'contact_person' => true,
        'contact_no' => true,
        'contact_email' => true,
        'vendor' => true
    ];
}
