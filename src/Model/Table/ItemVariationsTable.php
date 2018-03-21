<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ItemVariations Model
 *
 * @property \App\Model\Table\ItemsTable|\Cake\ORM\Association\BelongsTo $Items
 * @property \App\Model\Table\UnitsTable|\Cake\ORM\Association\BelongsTo $Units
 * @property \App\Model\Table\OrderDetailsTable|\Cake\ORM\Association\HasMany $OrderDetails
 *
 * @method \App\Model\Entity\ItemVariation get($primaryKey, $options = [])
 * @method \App\Model\Entity\ItemVariation newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ItemVariation[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ItemVariation|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ItemVariation patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ItemVariation[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ItemVariation findOrCreate($search, callable $callback = null, $options = [])
 */
class ItemVariationsTable extends Table
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

        $this->setTable('item_variations');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Items', [
            'foreignKey' => 'item_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('UnitVariations', [
            'foreignKey' => 'unit_variation_id',
            'joinType' => 'INNER'
        ]);
		
        $this->hasMany('OrderDetails', [
            'foreignKey' => 'item_variation_id'
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
		/*
        $validator
            ->decimal('quantity_factor')
            ->requirePresence('quantity_factor', 'create')
            ->notEmpty('quantity_factor');

        $validator
            ->decimal('print_quantity')
            ->requirePresence('print_quantity', 'create')
            ->notEmpty('print_quantity');

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
            ->decimal('maximum_quantity_purchase')
            ->requirePresence('maximum_quantity_purchase', 'create')
            ->notEmpty('maximum_quantity_purchase');

        $validator
            ->requirePresence('out_of_stock', 'create')
            ->notEmpty('out_of_stock');

        $validator
            ->scalar('ready_to_sale')
            ->maxLength('ready_to_sale', 10)
            ->requirePresence('ready_to_sale', 'create')
            ->notEmpty('ready_to_sale');

        $validator
            ->dateTime('created_on')
            ->requirePresence('created_on', 'create')
            ->notEmpty('created_on');

        $validator
            ->scalar('status')
            ->maxLength('status', 10)
            ->requirePresence('status', 'create')
            ->notEmpty('status');
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
        $rules->add($rules->existsIn(['item_id'], 'Items'));
        $rules->add($rules->existsIn(['unit_id'], 'Units'));

        return $rules;
    }
}
