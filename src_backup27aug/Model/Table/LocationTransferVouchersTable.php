<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LocationTransferVouchers Model
 *
 * @property \App\Model\Table\FinancialYearsTable|\Cake\ORM\Association\BelongsTo $FinancialYears
 * @property \App\Model\Table\CitiesTable|\Cake\ORM\Association\BelongsTo $Cities
 * @property \App\Model\Table\LocationOutsTable|\Cake\ORM\Association\BelongsTo $LocationOuts
 * @property \App\Model\Table\LocationInsTable|\Cake\ORM\Association\BelongsTo $LocationIns
 * @property \App\Model\Table\LocationTransferVoucherRowsTable|\Cake\ORM\Association\HasMany $LocationTransferVoucherRows
 *
 * @method \App\Model\Entity\LocationTransferVoucher get($primaryKey, $options = [])
 * @method \App\Model\Entity\LocationTransferVoucher newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\LocationTransferVoucher[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\LocationTransferVoucher|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LocationTransferVoucher patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\LocationTransferVoucher[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\LocationTransferVoucher findOrCreate($search, callable $callback = null, $options = [])
 */
class LocationTransferVouchersTable extends Table
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

        $this->setTable('location_transfer_vouchers');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('FinancialYears', [
            'foreignKey' => 'financial_year_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Cities', [
            'foreignKey' => 'city_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('LocationOuts', [
			'className' => 'Locations',
            'foreignKey' => 'location_out_id',
            'joinType' => 'INNER'
        ]);
		 
        $this->belongsTo('LocationIns', [
			'className' => 'Locations',
            'foreignKey' => 'location_in_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('LocationTransferVoucherRows', [
            'foreignKey' => 'location_transfer_voucher_id'
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
            ->scalar('voucher_no')
            ->maxLength('voucher_no', 20)
            ->requirePresence('voucher_no', 'create')
            ->notEmpty('voucher_no');


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
        $rules->add($rules->existsIn(['financial_year_id'], 'FinancialYears'));
        $rules->add($rules->existsIn(['city_id'], 'Cities'));
        $rules->add($rules->existsIn(['location_out_id'], 'LocationOuts'));
        $rules->add($rules->existsIn(['location_in_id'], 'LocationIns'));

        return $rules;
    }
}
