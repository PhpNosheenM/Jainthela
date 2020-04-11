<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OldCustomers Model
 *
 * @property \App\Model\Table\CustomerAddressesTable|\Cake\ORM\Association\BelongsTo $CustomerAddresses
 *
 * @method \App\Model\Entity\OldCustomer get($primaryKey, $options = [])
 * @method \App\Model\Entity\OldCustomer newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\OldCustomer[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\OldCustomer|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OldCustomer patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\OldCustomer[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\OldCustomer findOrCreate($search, callable $callback = null, $options = [])
 */
class OldCustomersTable extends Table
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

        $this->setTable('old_customers');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');
		
		$this->hasMany('OldCustomer', [
            'className' => 'OldCustomerAddresses',
            'foreignKey' => 'customer_id',
            'joinType' => 'LEFT'
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
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->scalar('mobile')
            ->maxLength('mobile', 10)
            ->requirePresence('mobile', 'create')
            ->notEmpty('mobile');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmpty('email');

        $validator
            ->scalar('referral_code')
            ->maxLength('referral_code', 50)
            ->requirePresence('referral_code', 'create')
            ->notEmpty('referral_code');

        $validator
            ->decimal('bulk_booking_discount_percent')
            ->requirePresence('bulk_booking_discount_percent', 'create')
            ->notEmpty('bulk_booking_discount_percent');

        $validator
            ->scalar('otp')
            ->maxLength('otp', 255)
            ->requirePresence('otp', 'create')
            ->notEmpty('otp');

        $validator
            ->scalar('notification_key')
            ->maxLength('notification_key', 2000)
            ->requirePresence('notification_key', 'create')
            ->notEmpty('notification_key');

        $validator
            ->scalar('device_token')
            ->maxLength('device_token', 2000)
            ->requirePresence('device_token', 'create')
            ->notEmpty('device_token');

        $validator
            ->scalar('lattitude')
            ->maxLength('lattitude', 255)
            ->requirePresence('lattitude', 'create')
            ->notEmpty('lattitude');

        $validator
            ->scalar('longitude')
            ->maxLength('longitude', 255)
            ->requirePresence('longitude', 'create')
            ->notEmpty('longitude');

        $validator
            ->scalar('status')
            ->maxLength('status', 255)
            ->requirePresence('status', 'create')
            ->notEmpty('status');

        $validator
            ->scalar('first_time_win_status')
            ->maxLength('first_time_win_status', 3)
            ->requirePresence('first_time_win_status', 'create')
            ->notEmpty('first_time_win_status');

        $validator
            ->scalar('new_scheme')
            ->maxLength('new_scheme', 10)
            ->requirePresence('new_scheme', 'create')
            ->notEmpty('new_scheme');

        $validator
            ->date('created_on')
            ->requirePresence('created_on', 'create')
            ->notEmpty('created_on');

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
        //$rules->add($rules->isUnique(['email']));
        //$rules->add($rules->existsIn(['customer_address_id'], 'CustomerAddresses'));

        return $rules;
    }
}
