<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PurchaseOrderRows Model
 *
 * @property \App\Model\Table\PurchaseOrdersTable|\Cake\ORM\Association\BelongsTo $PurchaseOrders
 * @property \App\Model\Table\ItemsTable|\Cake\ORM\Association\BelongsTo $Items
 * @property \App\Model\Table\ItemVariationsTable|\Cake\ORM\Association\BelongsTo $ItemVariations
 * @property \App\Model\Table\UnitVariationsTable|\Cake\ORM\Association\BelongsTo $UnitVariations
 *
 * @method \App\Model\Entity\PurchaseOrderRow get($primaryKey, $options = [])
 * @method \App\Model\Entity\PurchaseOrderRow newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PurchaseOrderRow[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PurchaseOrderRow|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PurchaseOrderRow patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PurchaseOrderRow[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PurchaseOrderRow findOrCreate($search, callable $callback = null, $options = [])
 */
class PurchaseOrderRowsTable extends Table
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

        $this->setTable('purchase_order_rows');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('PurchaseOrders', [
            'foreignKey' => 'purchase_order_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Items', [
            'foreignKey' => 'item_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('ItemVariations', [
            'foreignKey' => 'item_variation_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('UnitVariations', [
            'foreignKey' => 'unit_variation_id',
            'joinType' => 'INNER'
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
            ->decimal('quantity')
            ->requirePresence('quantity', 'create')
            ->notEmpty('quantity');

        $validator
            ->decimal('rate')
            ->requirePresence('rate', 'create')
            ->notEmpty('rate');

        $validator
            ->decimal('net_amount')
            ->requirePresence('net_amount', 'create')
            ->notEmpty('net_amount');

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
        $rules->add($rules->existsIn(['purchase_order_id'], 'PurchaseOrders'));
        $rules->add($rules->existsIn(['item_id'], 'Items'));
        $rules->add($rules->existsIn(['item_variation_id'], 'ItemVariations'));
        $rules->add($rules->existsIn(['unit_variation_id'], 'UnitVariations'));

        return $rules;
    }
}
