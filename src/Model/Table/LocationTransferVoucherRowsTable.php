<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LocationTransferVoucherRows Model
 *
 * @property \App\Model\Table\ItemsTable|\Cake\ORM\Association\BelongsTo $Items
 * @property \App\Model\Table\LocationTransferVouchersTable|\Cake\ORM\Association\BelongsTo $LocationTransferVouchers
 * @property \App\Model\Table\ItemVariationsTable|\Cake\ORM\Association\BelongsTo $ItemVariations
 * @property \App\Model\Table\UnitVariationsTable|\Cake\ORM\Association\BelongsTo $UnitVariations
 *
 * @method \App\Model\Entity\LocationTransferVoucherRow get($primaryKey, $options = [])
 * @method \App\Model\Entity\LocationTransferVoucherRow newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\LocationTransferVoucherRow[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\LocationTransferVoucherRow|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LocationTransferVoucherRow patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\LocationTransferVoucherRow[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\LocationTransferVoucherRow findOrCreate($search, callable $callback = null, $options = [])
 */
class LocationTransferVoucherRowsTable extends Table
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

        $this->setTable('location_transfer_voucher_rows');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Items', [
            'foreignKey' => 'item_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('LocationTransferVouchers', [
            'foreignKey' => 'location_transfer_voucher_id',
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
        $rules->add($rules->existsIn(['location_transfer_voucher_id'], 'LocationTransferVouchers'));
        $rules->add($rules->existsIn(['item_variation_id'], 'ItemVariations'));
        $rules->add($rules->existsIn(['unit_variation_id'], 'UnitVariations'));

        return $rules;
    }
}
