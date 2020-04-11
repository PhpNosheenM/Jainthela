<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Receipts Model
 *
 * @property \App\Model\Table\LocationsTable|\Cake\ORM\Association\BelongsTo $Locations
 * @property \App\Model\Table\SalesInvoicesTable|\Cake\ORM\Association\BelongsTo $SalesInvoices
 * @property \App\Model\Table\AccountingEntriesTable|\Cake\ORM\Association\HasMany $AccountingEntries
 * @property \App\Model\Table\ReceiptRowsTable|\Cake\ORM\Association\HasMany $ReceiptRows
 * @property \App\Model\Table\ReferenceDetailsTable|\Cake\ORM\Association\HasMany $ReferenceDetails
 *
 * @method \App\Model\Entity\Receipt get($primaryKey, $options = [])
 * @method \App\Model\Entity\Receipt newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Receipt[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Receipt|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Receipt patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Receipt[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Receipt findOrCreate($search, callable $callback = null, $options = [])
 */
class ReceiptsTable extends Table
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

        $this->setTable('receipts');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Locations', [
            'foreignKey' => 'location_id',
            'joinType' => 'INNER'
        ]);
		
        $this->belongsTo('Cities', [
            'foreignKey' => 'city_id',
            'joinType' => 'INNER'
        ]);
		
		$this->belongsTo('FinancialYears', [
            'foreignKey' => 'financial_year_id',
            'joinType' => 'INNER'
        ]);
		
        $this->belongsTo('Wallets');
        $this->belongsTo('SalesInvoices', [
            'foreignKey' => 'sales_invoice_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('AccountingEntries', [
            'foreignKey' => 'receipt_id',
			'saveStrategy'=>'replace'
        ]);
        $this->hasMany('ReceiptRows', [
            'foreignKey' => 'receipt_id',
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
		/*
        $validator
            ->date('transaction_date')
            ->requirePresence('transaction_date', 'create')
            ->notEmpty('transaction_date');

        $validator
            ->scalar('narration')
            ->requirePresence('narration', 'create')
            ->notEmpty('narration');

        $validator
            ->decimal('voucher_amount')
            ->requirePresence('voucher_amount', 'create')
            ->notEmpty('voucher_amount');

        $validator
            ->decimal('amount')
            ->requirePresence('amount', 'create')
            ->notEmpty('amount');
		*/
       

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
        $rules->add($rules->existsIn(['location_id'], 'Locations'));
        //$rules->add($rules->existsIn(['sales_invoice_id'], 'SalesInvoices'));

        return $rules;
    }
}
