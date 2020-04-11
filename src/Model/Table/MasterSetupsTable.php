<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MasterSetups Model
 *
 * @property \App\Model\Table\CitiesTable|\Cake\ORM\Association\BelongsTo $Cities
 *
 * @method \App\Model\Entity\MasterSetup get($primaryKey, $options = [])
 * @method \App\Model\Entity\MasterSetup newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\MasterSetup[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MasterSetup|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MasterSetup patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\MasterSetup[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\MasterSetup findOrCreate($search, callable $callback = null, $options = [])
 */
class MasterSetupsTable extends Table
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

        $this->setTable('master_setups');
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
            ->integer('cash_back_slot')
            ->requirePresence('cash_back_slot', 'create')
            ->notEmpty('cash_back_slot');

        $validator
            ->decimal('online_amount_limit')
            ->requirePresence('online_amount_limit', 'create')
            ->notEmpty('online_amount_limit');

        $validator
            ->integer('cancel_order_limit')
            ->requirePresence('cancel_order_limit', 'create')
            ->notEmpty('cancel_order_limit');

        $validator
            ->integer('days')
            ->requirePresence('days', 'create')
            ->notEmpty('days');

        $validator
            ->integer('wallet_withdrawl_charge_per')
            ->requirePresence('wallet_withdrawl_charge_per', 'create')
            ->notEmpty('wallet_withdrawl_charge_per');

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
