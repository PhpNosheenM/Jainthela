<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Customers Model
 *
 * @property \App\Model\Table\CitiesTable|\Cake\ORM\Association\BelongsTo $Cities
 * @property \App\Model\Table\AppNotificationCustomersTable|\Cake\ORM\Association\HasMany $AppNotificationCustomers
 * @property \App\Model\Table\BulkBookingLeadsTable|\Cake\ORM\Association\HasMany $BulkBookingLeads
 * @property \App\Model\Table\CartsTable|\Cake\ORM\Association\HasMany $Carts
 * @property \App\Model\Table\CustomerAddressesTable|\Cake\ORM\Association\HasMany $CustomerAddresses
 * @property \App\Model\Table\FeedbacksTable|\Cake\ORM\Association\HasMany $Feedbacks
 * @property \App\Model\Table\LedgersTable|\Cake\ORM\Association\HasMany $Ledgers
 * @property \App\Model\Table\OrdersTable|\Cake\ORM\Association\HasMany $Orders
 * @property \App\Model\Table\ReferenceDetailsTable|\Cake\ORM\Association\HasMany $ReferenceDetails
 * @property \App\Model\Table\SaleReturnsTable|\Cake\ORM\Association\HasMany $SaleReturns
 * @property \App\Model\Table\SalesInvoicesTable|\Cake\ORM\Association\HasMany $SalesInvoices
 * @property \App\Model\Table\SellerRatingsTable|\Cake\ORM\Association\HasMany $SellerRatings
 * @property \App\Model\Table\WalletsTable|\Cake\ORM\Association\HasMany $Wallets
 *
 * @method \App\Model\Entity\Customer get($primaryKey, $options = [])
 * @method \App\Model\Entity\Customer newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Customer[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Customer|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Customer patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Customer[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Customer findOrCreate($search, callable $callback = null, $options = [])
 */
class CustomersTable extends Table
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

        $this->setTable('customers');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Cities', [
            'foreignKey' => 'city_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('AppNotificationCustomers', [
            'foreignKey' => 'customer_id'
        ]);
        $this->hasMany('BulkBookingLeads', [
            'foreignKey' => 'customer_id'
        ]);
        $this->hasMany('Carts', [
            'foreignKey' => 'customer_id'
        ]);
        $this->hasMany('CustomerAddresses', [
            'foreignKey' => 'customer_id'
        ]);
        $this->hasMany('Feedbacks', [
            'foreignKey' => 'customer_id'
        ]);
        $this->hasMany('Ledgers', [
            'foreignKey' => 'customer_id'
        ]);
        $this->hasMany('Orders', [
            'foreignKey' => 'customer_id'
        ]);
        $this->hasMany('ReferenceDetails', [
            'foreignKey' => 'customer_id'
        ]);
        $this->hasMany('SaleReturns', [
            'foreignKey' => 'customer_id'
        ]);
        $this->hasMany('SalesInvoices', [
            'foreignKey' => 'customer_id'
        ]);
        $this->hasMany('SellerRatings', [
            'foreignKey' => 'customer_id'
        ]);
        $this->hasMany('Wallets', [
            'foreignKey' => 'customer_id'
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

       /*  $validator
            ->scalar('name')
            ->maxLength('name', 100)
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmpty('email');

        $validator
            ->scalar('username')
            ->maxLength('username', 20)
            ->requirePresence('username', 'create')
            ->notEmpty('username')
            ->add('username', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('password')
            ->maxLength('password', 300)
            ->requirePresence('password', 'create')
            ->notEmpty('password');

        $validator
            ->scalar('latitude')
            ->maxLength('latitude', 50)
            ->requirePresence('latitude', 'create')
            ->notEmpty('latitude');

        $validator
            ->scalar('longitude')
            ->maxLength('longitude', 50)
            ->requirePresence('longitude', 'create')
            ->notEmpty('longitude');

        $validator
            ->scalar('device_id_name')
            ->requirePresence('device_id_name', 'create')
            ->notEmpty('device_id_name');

        $validator
            ->scalar('device_token')
            ->requirePresence('device_token', 'create')
            ->notEmpty('device_token');

        $validator
            ->scalar('referral_code')
            ->maxLength('referral_code', 100)
            ->requirePresence('referral_code', 'create')
            ->notEmpty('referral_code');

        $validator
            ->decimal('discount_in_percentage')
            ->requirePresence('discount_in_percentage', 'create')
            ->notEmpty('discount_in_percentage');

        $validator
            ->scalar('otp')
            ->maxLength('otp', 10)
            ->requirePresence('otp', 'create')
            ->notEmpty('otp');

        $validator
            ->requirePresence('timeout', 'create')
            ->notEmpty('timeout');

        $validator
            ->dateTime('created_on')
            ->requirePresence('created_on', 'create')
            ->notEmpty('created_on');

        $validator
            ->integer('created_by')
            ->requirePresence('created_by', 'create')
            ->notEmpty('created_by');

        $validator
            ->integer('active')
            ->requirePresence('active', 'create')
            ->notEmpty('active');

        $validator
            ->scalar('gstin')
            ->maxLength('gstin', 100)
            ->requirePresence('gstin', 'create')
            ->notEmpty('gstin');

        $validator
            ->scalar('gstin_holder_name')
            ->maxLength('gstin_holder_name', 100)
            ->requirePresence('gstin_holder_name', 'create')
            ->notEmpty('gstin_holder_name');

        $validator
            ->scalar('gstin_holder_address')
            ->requirePresence('gstin_holder_address', 'create')
            ->notEmpty('gstin_holder_address');

        $validator
            ->scalar('firm_name')
            ->maxLength('firm_name', 100)
            ->requirePresence('firm_name', 'create')
            ->notEmpty('firm_name');

        $validator
            ->scalar('firm_address')
            ->requirePresence('firm_address', 'create')
            ->notEmpty('firm_address');

        $validator
            ->dateTime('discount_created_on')
            ->requirePresence('discount_created_on', 'create')
            ->notEmpty('discount_created_on');

        $validator
            ->dateTime('discount_expiry')
            ->requirePresence('discount_expiry', 'create')
            ->notEmpty('discount_expiry'); */

        return $validator;
    }
public function findAuth(\Cake\ORM\Query $query, array $options)
	{
		$query
			->where(['Customers.active' => 1]);

		return $query;
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
        $rules->add($rules->isUnique(['username']));
        $rules->add($rules->existsIn(['city_id'], 'Cities'));

        return $rules;
    }
}
