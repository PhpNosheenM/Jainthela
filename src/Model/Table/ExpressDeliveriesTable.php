<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ExpressDeliveries Model
 *
 * @method \App\Model\Entity\ExpressDelivery get($primaryKey, $options = [])
 * @method \App\Model\Entity\ExpressDelivery newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ExpressDelivery[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ExpressDelivery|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ExpressDelivery patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ExpressDelivery[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ExpressDelivery findOrCreate($search, callable $callback = null, $options = [])
 */
class ExpressDeliveriesTable extends Table
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

        $this->setTable('express_deliveries');
        $this->setDisplayField('title');
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
            ->scalar('title')
            ->maxLength('title', 200)
            ->requirePresence('title', 'create')
            ->notEmpty('title');

        $validator
            ->scalar('icon')
            ->maxLength('icon', 50)
            ->requirePresence('icon', 'create')
            ->notEmpty('icon');

        $validator
            ->scalar('content_data')
            ->requirePresence('content_data', 'create')
            ->notEmpty('content_data');

        $validator
            ->scalar('status')
            ->maxLength('status', 10)
            ->requirePresence('status', 'create')
            ->notEmpty('status');

        return $validator;
    }
}
