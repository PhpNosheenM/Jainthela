<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ItemReviewRating Entity
 *
 * @property int $id
 * @property int $item_id
 * @property int $customer_id
 * @property float $rating
 * @property string $comment
 * @property int $status
 *
 * @property \App\Model\Entity\Item $item
 * @property \App\Model\Entity\Customer $customer
 */
class ItemReviewRating extends Entity
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
        'customer_id' => true,
        'seller_id' => true,
        'rating' => true,
        'comment' => true,
        'status' => true,
        'seller' => true,
        'item' => true,
        'customer' => true
    ];
}
