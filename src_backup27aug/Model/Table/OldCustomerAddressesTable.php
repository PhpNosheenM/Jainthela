<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OldCustomerAddresses Model
 *
 * @property \App\Model\Table\CustomersTable|\Cake\ORM\Association\BelongsTo $Customers
 *
 * @method \App\Model\Entity\OldCustomerAddress get($primaryKey, $options = [])
 * @method \App\Model\Entity\OldCustomerAddress newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\OldCustomerAddress[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\OldCustomerAddress|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OldCustomerAddress patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\OldCustomerAddress[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\OldCustomerAddress findOrCreate($search, callable $callback = null, $options = [])
 */
class OldCustomerAddressesTable extends Table
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

        $this->setTable('old_customer_addresses');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Customers', [
            'foreignKey' => 'customer_id',
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
            ->scalar('name')
            ->maxLength('name', 150)
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->scalar('mobile')
            ->maxLength('mobile', 10)
            ->requirePresence('mobile', 'create')
            ->notEmpty('mobile');

        $validator
            ->scalar('house_no')
            ->maxLength('house_no', 255)
            ->requirePresence('house_no', 'create')
            ->notEmpty('house_no');

        $validator
            ->scalar('landmark')
            ->requirePresence('landmark', 'create')
            ->notEmpty('landmark');

        $validator
            ->scalar('address')
            ->requirePresence('address', 'create')
            ->notEmpty('address');

        $validator
            ->scalar('locality')
            ->maxLength('locality', 255)
            ->requirePresence('locality', 'create')
            ->notEmpty('locality');

        $validator
            ->requirePresence('default_address', 'create')
            ->notEmpty('default_address');

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
        $rules->add($rules->existsIn(['customer_id'], 'Customers'));

        return $rules;
    }
}
