<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DeliveryDates Model
 *
 * @property |\Cake\ORM\Association\BelongsTo $Cities
 *
 * @method \App\Model\Entity\DeliveryDate get($primaryKey, $options = [])
 * @method \App\Model\Entity\DeliveryDate newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\DeliveryDate[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DeliveryDate|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DeliveryDate patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DeliveryDate[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\DeliveryDate findOrCreate($search, callable $callback = null, $options = [])
 */
class DeliveryDatesTable extends Table
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

        $this->setTable('delivery_dates');
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
            ->scalar('same_day')
            ->maxLength('same_day', 10)
            ->requirePresence('same_day', 'create')
            ->notEmpty('same_day');

        $validator
            ->integer('next_day')
            ->requirePresence('next_day', 'create')
            ->notEmpty('next_day');

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

        return $rules;
    }
}
