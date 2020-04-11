<?php
namespace App\Model\Table;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Utility\Text;
use Cake\Event\Event;
/**
 * Sellers Model
 *
 * @property |\Cake\ORM\Association\BelongsTo $Cities
 * @property \App\Model\Table\LocationsTable|\Cake\ORM\Association\BelongsTo $Locations
 * @property \App\Model\Table\BannersTable|\Cake\ORM\Association\HasMany $Banners
 * @property \App\Model\Table\GrnsTable|\Cake\ORM\Association\HasMany $Grns
 * @property \App\Model\Table\HistoryItemVariationsTable|\Cake\ORM\Association\HasMany $HistoryItemVariations
 * @property \App\Model\Table\ItemLedgersTable|\Cake\ORM\Association\HasMany $ItemLedgers
 * @property \App\Model\Table\ItemVariationsTable|\Cake\ORM\Association\HasMany $ItemVariations
 * @property \App\Model\Table\ItemsTable|\Cake\ORM\Association\HasMany $Items
 * @property \App\Model\Table\LedgersTable|\Cake\ORM\Association\HasMany $Ledgers
 * @property \App\Model\Table\ReferenceDetailsTable|\Cake\ORM\Association\HasMany $ReferenceDetails
 * @property |\Cake\ORM\Association\HasMany $SellerDetails
 * @property \App\Model\Table\SellerItemsTable|\Cake\ORM\Association\HasMany $SellerItems
 * @property \App\Model\Table\SellerRatingsTable|\Cake\ORM\Association\HasMany $SellerRatings
 * @property \App\Model\Table\SellerRequestsTable|\Cake\ORM\Association\HasMany $SellerRequests
 *
 * @method \App\Model\Entity\Seller get($primaryKey, $options = [])
 * @method \App\Model\Entity\Seller newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Seller[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Seller|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Seller patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Seller[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Seller findOrCreate($search, callable $callback = null, $options = [])
 */
class SellersTable extends Table
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

        $this->setTable('sellers');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');
 
        $this->belongsTo('Cities', [
            'foreignKey' => 'city_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Locations', [
            'foreignKey' => 'location_id',
            'joinType' => 'INNER'
        ]);
		$this->belongsTo('Drivers', [
            'foreignKey' => 'seller_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Banners', [
            'foreignKey' => 'seller_id'
        ]);
        $this->hasMany('Grns', [
            'foreignKey' => 'seller_id'
        ]);
        $this->hasMany('HistoryItemVariations', [
            'foreignKey' => 'seller_id'
        ]);
        $this->hasMany('ItemLedgers', [
            'foreignKey' => 'seller_id'
        ]);
        $this->hasMany('ItemVariations', [
            'foreignKey' => 'seller_id'
        ]);
        $this->hasMany('Items', [
            'foreignKey' => 'seller_id'
        ]);
        $this->hasMany('Ledgers', [
            'foreignKey' => 'seller_id'
        ]);
        $this->hasMany('ReferenceDetails', [
            'foreignKey' => 'seller_id',
			'saveStrategy'=>'replace'
        ]);
        $this->hasMany('SellerDetails', [
            'foreignKey' => 'seller_id',
			'saveStrategy'=>'replace'
        ]);
        $this->hasMany('SellerItems', [
            'foreignKey' => 'seller_id'
        ]);
        $this->hasMany('SellerRatings', [
            'foreignKey' => 'seller_id'
        ]);
        $this->hasMany('SellerRequests', [
            'foreignKey' => 'seller_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
	public function validationPassword(Validator $validator )
    {
		$validator
            ->add('old_password','custom',[
                'rule'=>  function($value, $context){
                    $user = $this->get($context['data']['id']);
                    if ($user) {
                        if ((new DefaultPasswordHasher)->check($value, $user->password)) {
                            return true;
                        }
                    }
                    return false;
                },
                'message'=>'The old password does not match the current password!',
            ])
            ->notEmpty('old_password');
			return $validator;
	}
	
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 100)
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->scalar('username')
            ->maxLength('username', 100)
            ->requirePresence('username', 'create')
            ->notEmpty('username');

        $validator
            ->scalar('password')
            ->maxLength('password', 255)
            ->requirePresence('password', 'create')
            ->notEmpty('password');
 /*
        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmpty('email');

        $validator
            ->scalar('mobile_no')
            ->maxLength('mobile_no', 20)
            ->requirePresence('mobile_no', 'create')
            ->notEmpty('mobile_no');

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
            ->scalar('gstin')
            ->maxLength('gstin', 50)
            ->requirePresence('gstin', 'create')
            ->notEmpty('gstin');

        $validator
            ->scalar('pan')
            ->maxLength('pan', 50)
            ->requirePresence('pan', 'create')
            ->notEmpty('pan');

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
            ->scalar('firm_email')
            ->maxLength('firm_email', 200)
            ->requirePresence('firm_email', 'create')
            ->notEmpty('firm_email');

        $validator
            ->scalar('firm_contact')
            ->maxLength('firm_contact', 200)
            ->requirePresence('firm_contact', 'create')
            ->notEmpty('firm_contact');

        $validator
            ->scalar('firm_pincode')
            ->maxLength('firm_pincode', 200)
            ->requirePresence('firm_pincode', 'create')
            ->notEmpty('firm_pincode');

        $validator
            ->date('registration_date')
            ->requirePresence('registration_date', 'create')
            ->notEmpty('registration_date');

        $validator
            ->date('termination_date')
            ->requirePresence('termination_date', 'create')
            ->notEmpty('termination_date');

        $validator
            ->scalar('termination_reason')
            ->requirePresence('termination_reason', 'create')
            ->notEmpty('termination_reason');

        $validator
            ->scalar('breif_decription')
            ->requirePresence('breif_decription', 'create')
            ->notEmpty('breif_decription');

        $validator
            ->scalar('passkey')
            ->requirePresence('passkey', 'create')
            ->notEmpty('passkey');

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
            ->scalar('status')
            ->maxLength('status', 10)
            ->requirePresence('status', 'create')
            ->notEmpty('status');

        $validator
            ->scalar('bill_to_bill_accounting')
            ->maxLength('bill_to_bill_accounting', 10)
            ->requirePresence('bill_to_bill_accounting', 'create')
            ->notEmpty('bill_to_bill_accounting');

        $validator
            ->decimal('opening_balance_value')
            ->requirePresence('opening_balance_value', 'create')
            ->notEmpty('opening_balance_value');

        $validator
            ->scalar('debit_credit')
            ->maxLength('debit_credit', 10)
            ->requirePresence('debit_credit', 'create')
            ->notEmpty('debit_credit');

        $validator
            ->scalar('saller_image')
            ->maxLength('saller_image', 100)
            ->requirePresence('saller_image', 'create')
            ->notEmpty('saller_image');
 */
        return $validator;
    }
    public function findAuth(\Cake\ORM\Query $query, array $options)
    {
        $query
            ->where(['Sellers.status' => 'Active']);

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
        $rules->add($rules->isUnique(['username']));
        $rules->add($rules->isUnique(['email']));
        $rules->add($rules->existsIn(['city_id'], 'Cities'));
        $rules->add($rules->existsIn(['location_id'], 'Locations'));

        return $rules;
    }
}
