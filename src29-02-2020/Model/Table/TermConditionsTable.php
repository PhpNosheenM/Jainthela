<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TermConditions Model
 *
 * @method \App\Model\Entity\TermCondition get($primaryKey, $options = [])
 * @method \App\Model\Entity\TermCondition newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TermCondition[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TermCondition|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TermCondition patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TermCondition[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TermCondition findOrCreate($search, callable $callback = null, $options = [])
 */
class TermConditionsTable extends Table
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

        $this->setTable('term_conditions');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        $this->belongsTo('CompanyDetails');
        $this->belongsTo('SupplierAreas');
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
            ->scalar('term_name')
            ->maxLength('term_name', 50)
            ->requirePresence('term_name', 'create')
            ->notEmpty('term_name');

        $validator
            ->scalar('term')
            ->requirePresence('term', 'create')
            ->notEmpty('term');

        $validator
            ->requirePresence('status', 'create')
            ->notEmpty('status');

        return $validator;
    }
}
