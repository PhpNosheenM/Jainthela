<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Filters Model
 *
 * @method \App\Model\Entity\Filter get($primaryKey, $options = [])
 * @method \App\Model\Entity\Filter newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Filter[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Filter|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Filter patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Filter[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Filter findOrCreate($search, callable $callback = null, $options = [])
 */
class FiltersTable extends Table
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

        $this->setTable('filters');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');
        
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
            ->scalar('name')
            ->maxLength('name', 30)
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->requirePresence('status', 'create')
            ->notEmpty('status');

        return $validator;
    }
}
