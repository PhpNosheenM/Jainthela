<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ComboOffers Model
 *
 * @property \App\Model\Table\CitiesTable|\Cake\ORM\Association\BelongsTo $Cities
 * @property \App\Model\Table\AdminsTable|\Cake\ORM\Association\BelongsTo $Admins
 * @property \App\Model\Table\CartsTable|\Cake\ORM\Association\HasMany $Carts
 * @property \App\Model\Table\ComboOfferDetailsTable|\Cake\ORM\Association\HasMany $ComboOfferDetails
 * @property \App\Model\Table\OrderDetailsTable|\Cake\ORM\Association\HasMany $OrderDetails
 *
 * @method \App\Model\Entity\ComboOffer get($primaryKey, $options = [])
 * @method \App\Model\Entity\ComboOffer newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ComboOffer[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ComboOffer|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ComboOffer patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ComboOffer[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ComboOffer findOrCreate($search, callable $callback = null, $options = [])
 */
class ComboOffersTable extends Table
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

        $this->setTable('combo_offers');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Cities', [
            'foreignKey' => 'city_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Admins', [
            'foreignKey' => 'admin_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Carts', [
            'foreignKey' => 'combo_offer_id'
        ]);
        $this->hasMany('ComboOfferDetails', [
            'foreignKey' => 'combo_offer_id'
        ]);
        $this->hasMany('OrderDetails', [
            'foreignKey' => 'combo_offer_id'
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
<<<<<<< HEAD
		/*
=======

>>>>>>> 0c846ee17fee5c591edddce04558bbd09e9e0e5c
        $validator
            ->scalar('name')
            ->maxLength('name', 100)
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->decimal('print_rate')
            ->requirePresence('print_rate', 'create')
            ->notEmpty('print_rate');

        $validator
            ->decimal('discount_per')
            ->requirePresence('discount_per', 'create')
            ->notEmpty('discount_per');

        $validator
            ->decimal('sales_rate')
            ->requirePresence('sales_rate', 'create')
            ->notEmpty('sales_rate');

        $validator
            ->decimal('quantity_factor')
            ->requirePresence('quantity_factor', 'create')
            ->notEmpty('quantity_factor');

        $validator
            ->decimal('print_quantity')
            ->requirePresence('print_quantity', 'create')
            ->notEmpty('print_quantity');

        $validator
            ->decimal('maximum_quantity_purchase')
            ->requirePresence('maximum_quantity_purchase', 'create')
            ->notEmpty('maximum_quantity_purchase');

        $validator
            ->dateTime('start_date')
            ->requirePresence('start_date', 'create')
            ->notEmpty('start_date');

        $validator
            ->dateTime('end_date')
            ->requirePresence('end_date', 'create')
            ->notEmpty('end_date');

        $validator
            ->integer('stock_in_quantity')
            ->requirePresence('stock_in_quantity', 'create')
            ->notEmpty('stock_in_quantity');

        $validator
            ->integer('stock_out_quantity')
            ->requirePresence('stock_out_quantity', 'create')
            ->notEmpty('stock_out_quantity');

        $validator
            ->dateTime('created_on')
            ->requirePresence('created_on', 'create')
            ->notEmpty('created_on');

        $validator
            ->dateTime('edited_on')
            ->requirePresence('edited_on', 'create')
            ->notEmpty('edited_on');

        $validator
            ->scalar('ready_to_sale')
            ->maxLength('ready_to_sale', 10)
            ->requirePresence('ready_to_sale', 'create')
            ->notEmpty('ready_to_sale');

        $validator
            ->scalar('status')
            ->maxLength('status', 10)
            ->requirePresence('status', 'create')
            ->notEmpty('status');

        $validator
            ->scalar('combo_offer_image')
            ->maxLength('combo_offer_image', 150)
            ->requirePresence('combo_offer_image', 'create')
            ->notEmpty('combo_offer_image');

        $validator
            ->scalar('description')
            ->requirePresence('description', 'create')
            ->notEmpty('description');
		*/
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
        $rules->add($rules->existsIn(['admin_id'], 'Admins'));

        return $rules;
    }
}
