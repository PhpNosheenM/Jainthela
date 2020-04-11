<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * BulkBookingNumbers Model
 *
 * @property \App\Model\Table\CitiesTable|\Cake\ORM\Association\BelongsTo $Cities
 *
 * @method \App\Model\Entity\BulkBookingNumber get($primaryKey, $options = [])
 * @method \App\Model\Entity\BulkBookingNumber newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\BulkBookingNumber[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\BulkBookingNumber|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\BulkBookingNumber patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\BulkBookingNumber[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\BulkBookingNumber findOrCreate($search, callable $callback = null, $options = [])
 */
class BulkBookingNumbersTable extends Table
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

        $this->setTable('bulk_booking_numbers');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Cities', [
            'foreignKey' => 'city_id',
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
            ->scalar('mobile_no')
            ->maxLength('mobile_no', 10)
            ->requirePresence('mobile_no', 'create')
            ->notEmpty('mobile_no');

        $validator
            ->scalar('status')
            ->maxLength('status', 15)
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

        return $rules;
    }
}
