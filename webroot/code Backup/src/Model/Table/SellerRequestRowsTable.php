<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SellerRequestRows Model
 *
 * @property \App\Model\Table\SellerRequestsTable|\Cake\ORM\Association\BelongsTo $SellerRequests
 * @property \App\Model\Table\ItemsTable|\Cake\ORM\Association\BelongsTo $Items
 * @property \App\Model\Table\ItemVariationsTable|\Cake\ORM\Association\BelongsTo $ItemVariations
 *
 * @method \App\Model\Entity\SellerRequestRow get($primaryKey, $options = [])
 * @method \App\Model\Entity\SellerRequestRow newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\SellerRequestRow[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SellerRequestRow|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SellerRequestRow patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\SellerRequestRow[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\SellerRequestRow findOrCreate($search, callable $callback = null, $options = [])
 */
class SellerRequestRowsTable extends Table
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

        $this->setTable('seller_request_rows');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('SellerRequests', [
            'foreignKey' => 'seller_request_id',
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
            ->decimal('taxable_value')
            ->requirePresence('taxable_value', 'create')
            ->notEmpty('taxable_value');

        $validator
            ->decimal('net_amount')
            ->requirePresence('net_amount', 'create')
            ->notEmpty('net_amount');

        $validator
            ->integer('gst_percentage')
            ->requirePresence('gst_percentage', 'create')
            ->notEmpty('gst_percentage');

        $validator
            ->decimal('gst_value')
            ->requirePresence('gst_value', 'create')
            ->notEmpty('gst_value');

        $validator
            ->decimal('purchase_rate')
            ->requirePresence('purchase_rate', 'create')
            ->notEmpty('purchase_rate');

        $validator
            ->decimal('sales_rate')
            ->requirePresence('sales_rate', 'create')
            ->notEmpty('sales_rate');

        $validator
            ->scalar('gst_type')
            ->maxLength('gst_type', 100)
            ->requirePresence('gst_type', 'create')
            ->notEmpty('gst_type');

        $validator
            ->decimal('mrp')
            ->requirePresence('mrp', 'create')
            ->notEmpty('mrp');

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
        $rules->add($rules->existsIn(['seller_request_id'], 'SellerRequests'));
        $rules->add($rules->existsIn(['item_id'], 'Items'));
        $rules->add($rules->existsIn(['item_variation_id'], 'ItemVariations'));

        return $rules;
    }
}
