<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Ledgers Model
 *
 * @property \App\Model\Table\AccountingGroupsTable|\Cake\ORM\Association\BelongsTo $AccountingGroups
 * @property \App\Model\Table\LocationsTable|\Cake\ORM\Association\BelongsTo $Locations
 * @property \App\Model\Table\SuppliersTable|\Cake\ORM\Association\BelongsTo $Suppliers
 * @property \App\Model\Table\CustomersTable|\Cake\ORM\Association\BelongsTo $Customers
 * @property \App\Model\Table\GstFiguresTable|\Cake\ORM\Association\BelongsTo $GstFigures
 * @property \App\Model\Table\AccountingEntriesTable|\Cake\ORM\Association\HasMany $AccountingEntries
 * @property \App\Model\Table\CreditNoteRowsTable|\Cake\ORM\Association\HasMany $CreditNoteRows
 * @property \App\Model\Table\DebitNoteRowsTable|\Cake\ORM\Association\HasMany $DebitNoteRows
 * @property \App\Model\Table\JournalVoucherRowsTable|\Cake\ORM\Association\HasMany $JournalVoucherRows
 * @property \App\Model\Table\PaymentRowsTable|\Cake\ORM\Association\HasMany $PaymentRows
 * @property \App\Model\Table\PurchaseVoucherRowsTable|\Cake\ORM\Association\HasMany $PurchaseVoucherRows
 * @property \App\Model\Table\ReceiptRowsTable|\Cake\ORM\Association\HasMany $ReceiptRows
 * @property \App\Model\Table\ReferenceDetailsTable|\Cake\ORM\Association\HasMany $ReferenceDetails
 * @property \App\Model\Table\SalesVoucherRowsTable|\Cake\ORM\Association\HasMany $SalesVoucherRows
 *
 * @method \App\Model\Entity\Ledger get($primaryKey, $options = [])
 * @method \App\Model\Entity\Ledger newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Ledger[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Ledger|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Ledger patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Ledger[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Ledger findOrCreate($search, callable $callback = null, $options = [])
 */
class LedgersTable extends Table
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

        $this->setTable('ledgers');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('AccountingGroups', [
            'foreignKey' => 'accounting_group_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Locations', [
            'foreignKey' => 'location_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Vendors', [
            'foreignKey' => 'vendor_id',
            'joinType' => 'INNER'
        ]);
		
		$this->belongsTo('Sellers', [
            'foreignKey' => 'seller_id',
            'joinType' => 'LEFT'
        ]);
        $this->belongsTo('Customers', [
            'foreignKey' => 'customer_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('GstFigures', [
            'foreignKey' => 'gst_figure_id'
        ]);
        $this->hasMany('AccountingEntries', [
            'foreignKey' => 'ledger_id'
        ]);
        $this->hasMany('CreditNoteRows', [
            'foreignKey' => 'ledger_id'
        ]);
        $this->hasMany('DebitNoteRows', [
            'foreignKey' => 'ledger_id'
        ]);
        $this->hasMany('JournalVoucherRows', [
            'foreignKey' => 'ledger_id'
        ]);
        $this->hasMany('PaymentRows', [
            'foreignKey' => 'ledger_id'
        ]);
        $this->hasMany('PurchaseVoucherRows', [
            'foreignKey' => 'ledger_id'
        ]);
        $this->hasMany('ReceiptRows', [
            'foreignKey' => 'ledger_id'
        ]);
        $this->hasMany('ReferenceDetails', [
            'foreignKey' => 'ledger_id'
        ]);
        $this->hasMany('SalesVoucherRows', [
            'foreignKey' => 'ledger_id'
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
            ->boolean('freeze')
            ->requirePresence('freeze', 'create')
            ->notEmpty('freeze');

        $validator
            ->decimal('tax_percentage')
            ->requirePresence('tax_percentage', 'create')
            ->notEmpty('tax_percentage');

        $validator
            ->scalar('gst_type')
            ->maxLength('gst_type', 10)
            ->allowEmpty('gst_type');

        $validator
            ->scalar('input_output')
            ->maxLength('input_output', 10)
            ->allowEmpty('input_output');

        $validator
            ->scalar('bill_to_bill_accounting')
            ->maxLength('bill_to_bill_accounting', 10)
            ->requirePresence('bill_to_bill_accounting', 'create')
            ->notEmpty('bill_to_bill_accounting');

        $validator
            ->integer('round_off')
            ->requirePresence('round_off', 'create')
            ->notEmpty('round_off');

        $validator
            ->integer('cash')
            ->requirePresence('cash', 'create')
            ->notEmpty('cash');

        $validator
            ->integer('flag')
            ->requirePresence('flag', 'create')
            ->notEmpty('flag');

        $validator
            ->integer('default_credit_days')
            ->requirePresence('default_credit_days', 'create')
            ->notEmpty('default_credit_days');

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
        $rules->add($rules->existsIn(['accounting_group_id'], 'AccountingGroups'));
        $rules->add($rules->existsIn(['location_id'], 'Locations'));
        //$rules->add($rules->existsIn(['supplier_id'], 'Suppliers'));
        $rules->add($rules->existsIn(['customer_id'], 'Customers'));
        $rules->add($rules->existsIn(['gst_figure_id'], 'GstFigures'));

        return $rules;
    }
}
