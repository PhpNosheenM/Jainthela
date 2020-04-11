<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PurchaseVouchers Model
 *
 * @property \App\Model\Table\FinancialYearsTable|\Cake\ORM\Association\BelongsTo $FinancialYears
 * @property \App\Model\Table\CitiesTable|\Cake\ORM\Association\BelongsTo $Cities
 * @property \App\Model\Table\AccountingEntriesTable|\Cake\ORM\Association\HasMany $AccountingEntries
 * @property \App\Model\Table\PurchaseVoucherRowsTable|\Cake\ORM\Association\HasMany $PurchaseVoucherRows
 *
 * @method \App\Model\Entity\PurchaseVoucher get($primaryKey, $options = [])
 * @method \App\Model\Entity\PurchaseVoucher newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PurchaseVoucher[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PurchaseVoucher|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PurchaseVoucher patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PurchaseVoucher[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PurchaseVoucher findOrCreate($search, callable $callback = null, $options = [])
 */
class PurchaseVouchersTable extends Table
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

        $this->setTable('purchase_vouchers');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('FinancialYears', [
            'foreignKey' => 'financial_year_id',
            'joinType' => 'INNER'
        ]);
		
		 $this->belongsTo('Locations', [
            'foreignKey' => 'location_id',
            'joinType' => 'INNER'
        ]);
		
        $this->belongsTo('Cities', [
            'foreignKey' => 'city_id',
            'joinType' => 'INNER'
        ]);
		
		 $this->belongsTo('SalesInvoices', [
            'foreignKey' => 'sales_invoice_id',
            'joinType' => 'INNER'
        ]);
		
        $this->hasMany('AccountingEntries', [
            'foreignKey' => 'purchase_voucher_id',
			'saveStrategy'=>'replace'
        ]);
		
        $this->hasMany('PurchaseVoucherRows', [
            'foreignKey' => 'purchase_voucher_id',
			'saveStrategy'=>'replace'
        ]);
		
		 $this->hasMany('ReferenceDetails', [
            'foreignKey' => 'receipt_id',
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
            ->integer('voucher_no')
            ->requirePresence('voucher_no', 'create')
            ->notEmpty('voucher_no');

        $validator
            ->date('transaction_date')
            ->requirePresence('transaction_date', 'create')
            ->notEmpty('transaction_date');

        $validator
            ->scalar('seller_invoice_no')
            ->maxLength('seller_invoice_no', 50)
            ->requirePresence('seller_invoice_no', 'create')
            ->notEmpty('seller_invoice_no');

        $validator
            ->date('seller_invoice_date')
            ->requirePresence('seller_invoice_date', 'create')
            ->notEmpty('seller_invoice_date');

        $validator
            ->scalar('narration')
            ->maxLength('narration', 100)
            ->requirePresence('narration', 'create')
            ->notEmpty('narration');

       /*  $validator
            ->date('created_on')
            ->requirePresence('created_on', 'create')
            ->notEmpty('created_on');
		*/
        $validator
            ->integer('created_by')
            ->requirePresence('created_by', 'create')
            ->notEmpty('created_by');

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
        $rules->add($rules->existsIn(['financial_year_id'], 'FinancialYears'));
        $rules->add($rules->existsIn(['city_id'], 'Cities'));

        return $rules;
    }
}
