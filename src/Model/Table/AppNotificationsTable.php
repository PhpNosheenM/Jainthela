<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AppNotifications Model
 *
 * @property \App\Model\Table\CitiesTable|\Cake\ORM\Association\BelongsTo $Cities
 * @property \App\Model\Table\LocationsTable|\Cake\ORM\Association\BelongsTo $Locations
 * @property \App\Model\Table\ItemsTable|\Cake\ORM\Association\BelongsTo $Items
 * @property \App\Model\Table\ItemVariationsTable|\Cake\ORM\Association\BelongsTo $ItemVariations
 * @property \App\Model\Table\ComboOffersTable|\Cake\ORM\Association\BelongsTo $ComboOffers
 * @property \App\Model\Table\WishListsTable|\Cake\ORM\Association\BelongsTo $WishLists
 * @property \App\Model\Table\CategoriesTable|\Cake\ORM\Association\BelongsTo $Categories
 * @property \App\Model\Table\AppNotificationCustomersTable|\Cake\ORM\Association\HasMany $AppNotificationCustomers
 *
 * @method \App\Model\Entity\AppNotification get($primaryKey, $options = [])
 * @method \App\Model\Entity\AppNotification newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\AppNotification[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AppNotification|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AppNotification patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\AppNotification[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\AppNotification findOrCreate($search, callable $callback = null, $options = [])
 */
class AppNotificationsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('app_notifications');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Cities', [
            'foreignKey' => 'city_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Locations', [
            'foreignKey' => 'location_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Items', [
            'foreignKey' => 'item_id',
            'joinType' => 'INNER'
        ]);
		 $this->belongsTo('Customers', [
            'foreignKey' => 'customer_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('ItemVariations', [
            'foreignKey' => 'item_variation_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('ComboOffers', [
            'foreignKey' => 'combo_offer_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('WishLists', [
            'foreignKey' => 'wish_list_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Categories', [
            'foreignKey' => 'category_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('AppNotificationCustomers', [
            'foreignKey' => 'app_notification_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('message')
            ->requirePresence('message', 'create')
            ->notEmpty('message');

       /*  $validator
            ->scalar('image_web')
            ->maxLength('image_web', 255)
            ->requirePresence('image_web', 'create')
            ->notEmpty('image_web');

        $validator
            ->scalar('image_app')
            ->maxLength('image_app', 255)
            ->requirePresence('image_app', 'create')
            ->notEmpty('image_app');
 
        $validator
            ->scalar('app_link')
            ->maxLength('app_link', 255)
            ->requirePresence('app_link', 'create')
            ->notEmpty('app_link');
*/
        $validator
            ->scalar('screen_type')
            ->maxLength('screen_type', 255)
            ->requirePresence('screen_type', 'create')
            ->notEmpty('screen_type');

     /*    $validator
            ->integer('created_by')
            ->requirePresence('created_by', 'create')
            ->notEmpty('created_by');

        $validator
            ->dateTime('created_on')
            ->requirePresence('created_on', 'create')
            ->notEmpty('created_on'); */

       /*  $validator
            ->integer('edited_by')
            ->requirePresence('edited_by', 'create')
            ->notEmpty('edited_by');

        $validator
            ->dateTime('edited_on')
            ->requirePresence('edited_on', 'create')
            ->notEmpty('edited_on'); */

        $validator
            ->requirePresence('status', 'create')
            ->notEmpty('status');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['city_id'], 'Cities'));
        $rules->add($rules->existsIn(['customer_id'], 'Customers'));
        $rules->add($rules->existsIn(['location_id'], 'Locations'));
        $rules->add($rules->existsIn(['item_id'], 'Items'));
        $rules->add($rules->existsIn(['item_variation_id'], 'ItemVariations'));
        $rules->add($rules->existsIn(['combo_offer_id'], 'ComboOffers'));
        //$rules->add($rules->existsIn(['wish_list_id'], 'WishLists'));
        $rules->add($rules->existsIn(['category_id'], 'Categories'));

        return $rules;
    }
}
