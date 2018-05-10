<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Event\Event;
use ArrayObject;
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
            'foreignKey' => 'customer_id',
			'saveStrategy'=>'replace'
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
		$this->belongsTo('VerifyOtps');
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
            ->notEmpty('email')
            ->add('email', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

		$validator
			->scalar('username')
			->maxLength('username', 20)
			->requirePresence('username', 'create')
			->notEmpty('username')
			->add('username', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);
        
		return $validator;
    }

	public function beforeMarshal(Event $event, ArrayObject $data)
    {
        @$data['discount_created_on'] = trim(date('Y-m-d',strtotime(@$data['discount_created_on'])));
		 @$data['discount_expiry'] = trim(date('Y-m-d',strtotime(@$data['discount_expiry'])));
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

        return $rules;
    }
}
