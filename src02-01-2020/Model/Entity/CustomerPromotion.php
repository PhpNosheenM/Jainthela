<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CustomerPromotion Entity
 *
 * @property int $id
 * @property int $city_id
 * @property int $location_id
 * @property int $customer_id
 * @property int $promotion_id
 * @property int $promotion_detail_id
 * @property \Cake\I18n\FrozenDate $start_date
 * @property \Cake\I18n\FrozenDate $end_date
 * @property string $status
 *
 * @property \App\Model\Entity\City $city
 * @property \App\Model\Entity\Location $location
 * @property \App\Model\Entity\Customer $customer
 * @property \App\Model\Entity\Promotion $promotion
 * @property \App\Model\Entity\PromotionDetail $promotion_detail
 */
class CustomerPromotion extends Entity
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
        'location_id' => true,
        'customer_id' => true,
        'promotion_id' => true,
        'promotion_detail_id' => true,
        'start_date' => true,
        'end_date' => true,
        'status' => true,
        'city' => true,
        'location' => true,
        'customer' => true,
        'promotion' => true,
        'promotion_detail' => true
    ];
}
