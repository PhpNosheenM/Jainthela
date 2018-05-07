<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Vendors Model
 *
 * @property \App\Model\Table\CitiesTable|\Cake\ORM\Association\BelongsTo $Cities
 * @property \App\Model\Table\LedgersTable|\Cake\ORM\Association\HasMany $Ledgers
 * @property \App\Model\Table\VendorDetailsTable|\Cake\ORM\Association\HasMany $VendorDetails
 *
 * @method \App\Model\Entity\Vendor get($primaryKey, $options = [])
 * @method \App\Model\Entity\Vendor newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Vendor[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Vendor|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Vendor patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Vendor[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Vendor findOrCreate($search, callable $callback = null, $options = [])
 */
class VendorsTable extends Table
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

        $this->setTable('vendors');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

		 
        $this->belongsTo('Cities', [
            'foreignKey' => 'city_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Ledgers', [
            'foreignKey' => 'vendor_id'
        ]);
        $this->hasMany('VendorDetails', [
            'foreignKey' => 'vendor_id',
			'saveStrategy'=>'replace'
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
            ->maxLength('name', 100)
            ->requirePresence('name', 'create')
            ->notEmpty('name');

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

      /*   $validator
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
            ->dateTime('created_on')
            ->requirePresence('created_on', 'create')
            ->notEmpty('created_on');

        $validator
            ->integer('created_by')
            ->requirePresence('created_by', 'create')
            ->notEmpty('created_by');

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
 */
        $validator
            ->scalar('status')
            ->maxLength('status', 10)
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
