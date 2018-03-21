<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CompanyDetails Model
 *
 * @property \App\Model\Table\CitiesTable|\Cake\ORM\Association\BelongsTo $Cities
 *
 * @method \App\Model\Entity\CompanyDetail get($primaryKey, $options = [])
 * @method \App\Model\Entity\CompanyDetail newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CompanyDetail[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CompanyDetail|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CompanyDetail patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CompanyDetail[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CompanyDetail findOrCreate($search, callable $callback = null, $options = [])
 */
class CompanyDetailsTable extends Table
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

        $this->setTable('company_details');
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
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmpty('email');

        $validator
            ->scalar('web')
            ->maxLength('web', 100)
            ->requirePresence('web', 'create')
            ->notEmpty('web');

        $validator
            ->scalar('mobile')
            ->maxLength('mobile', 15)
            ->requirePresence('mobile', 'create')
            ->notEmpty('mobile');

        $validator
            ->scalar('address')
            ->requirePresence('address', 'create')
            ->notEmpty('address');

        $validator
            ->requirePresence('flag', 'create')
            ->notEmpty('flag');

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
        $rules->add($rules->isUnique(['email']));
        $rules->add($rules->existsIn(['city_id'], 'Cities'));

        return $rules;
    }
}
