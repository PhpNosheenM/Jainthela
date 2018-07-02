<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Event\Event;
use ArrayObject;

/**
 * PurchaseReturns Model
 *
 * @property \App\Model\Table\PurchaseInvoicesTable|\Cake\ORM\Association\BelongsTo $PurchaseInvoices
 * @property \App\Model\Table\FinancialYearsTable|\Cake\ORM\Association\BelongsTo $FinancialYears
 * @property \App\Model\Table\LocationsTable|\Cake\ORM\Association\BelongsTo $Locations
 * @property \App\Model\Table\SellerLedgersTable|\Cake\ORM\Association\BelongsTo $SellerLedgers
 * @property \App\Model\Table\PurchaseLedgersTable|\Cake\ORM\Association\BelongsTo $PurchaseLedgers
 * @property \App\Model\Table\CitiesTable|\Cake\ORM\Association\BelongsTo $Cities
 * @property \App\Model\Table\AccountingEntriesTable|\Cake\ORM\Association\HasMany $AccountingEntries
 * @property \App\Model\Table\ItemLedgersTable|\Cake\ORM\Association\HasMany $ItemLedgers
 * @property \App\Model\Table\PurchaseReturnRowsTable|\Cake\ORM\Association\HasMany $PurchaseReturnRows
 * @property \App\Model\Table\ReferenceDetailsTable|\Cake\ORM\Association\HasMany $ReferenceDetails
 *
 * @method \App\Model\Entity\PurchaseReturn get($primaryKey, $options = [])
 * @method \App\Model\Entity\PurchaseReturn newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PurchaseReturn[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PurchaseReturn|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PurchaseReturn patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PurchaseReturn[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PurchaseReturn findOrCreate($search, callable $callback = null, $options = [])
 */
class PurchaseReturnsTable extends Table
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

        $this->setTable('purchase_returns');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('PurchaseInvoices', [
            'foreignKey' => 'purchase_invoice_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('FinancialYears', [
            'foreignKey' => 'financial_year_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Locations', [
            'foreignKey' => 'location_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('SellerLedgers', [
			'className' => 'Ledgers',
            'foreignKey' => 'seller_ledger_id',
            'joinType' => 'LEFT'
        ]);
		
		 $this->belongsTo('PurchaseLedgers', [
			'className' => 'Ledgers',
            'foreignKey' => 'purchase_ledger_id',
            'joinType' => 'LEFT'
        ]);
		 $this->belongsTo('Ledgers', [
            'foreignKey' => 'ledger_id',
            'joinType' => 'INNER'
        ]);
        
        $this->belongsTo('Cities', [
            'foreignKey' => 'city_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('AccountingEntries', [
            'foreignKey' => 'purchase_return_id'
        ]);
        $this->hasMany('ItemLedgers', [
            'foreignKey' => 'purchase_return_id'
        ]);
        $this->hasMany('PurchaseReturnRows', [
            'foreignKey' => 'purchase_return_id'
        ]);
        $this->hasMany('ReferenceDetails', [
            'foreignKey' => 'purchase_return_id'
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
            ->date('transaction_date')
            ->requirePresence('transaction_date', 'create')
            ->notEmpty('transaction_date');

        $validator
            ->scalar('narration')
            ->requirePresence('narration', 'create')
            ->notEmpty('narration');

        $validator
            ->decimal('total_taxable_value')
            ->requirePresence('total_taxable_value', 'create')
            ->notEmpty('total_taxable_value');

        $validator
            ->decimal('total_gst')
            ->requirePresence('total_gst', 'create')
            ->notEmpty('total_gst');

        $validator
            ->decimal('total_amount')
            ->requirePresence('total_amount', 'create')
            ->notEmpty('total_amount');

        /* $validator
            ->scalar('entry_from')
            ->maxLength('entry_from', 10)
            ->requirePresence('entry_from', 'create')
            ->notEmpty('entry_from');

        $validator
            ->integer('created_by')
            ->requirePresence('created_by', 'create')
            ->notEmpty('created_by');

        $validator
            ->integer('edited_by')
            ->requirePresence('edited_by', 'create')
            ->notEmpty('edited_by');

        $validator
            ->dateTime('created_on')
            ->requirePresence('created_on', 'create')
            ->notEmpty('created_on');

        $validator
            ->dateTime('edited_on')
            ->requirePresence('edited_on', 'create')
            ->notEmpty('edited_on');

        $validator
            ->scalar('status')
            ->maxLength('status', 10)
            ->requirePresence('status', 'create')
            ->notEmpty('status'); */

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
	/*  public function beforeSave($event, $entity, $options) {
		$entity->transaction_date = date('Y-m-d', strtotime($entity->transaction_date));
	} */
	 
	public function beforeMarshal(Event $event, ArrayObject $data, ArrayObject $options)
	{
		if (isset($data['transaction_date'])) {
			$data['transaction_date'] =date('Y-m-d', strtotime($data['transaction_date']));
		}
	}
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['purchase_invoice_id'], 'PurchaseInvoices'));
        $rules->add($rules->existsIn(['financial_year_id'], 'FinancialYears'));
        $rules->add($rules->existsIn(['location_id'], 'Locations'));
        $rules->add($rules->existsIn(['seller_ledger_id'], 'SellerLedgers'));
        $rules->add($rules->existsIn(['purchase_ledger_id'], 'PurchaseLedgers'));
        $rules->add($rules->existsIn(['city_id'], 'Cities'));

        return $rules;
    }
}
