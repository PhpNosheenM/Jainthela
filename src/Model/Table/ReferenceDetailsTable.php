<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ReferenceDetails Model
 *
 * @property \App\Model\Table\CustomersTable|\Cake\ORM\Association\BelongsTo $Customers
 * @property \App\Model\Table\SuppliersTable|\Cake\ORM\Association\BelongsTo $Suppliers
 * @property \App\Model\Table\LocationsTable|\Cake\ORM\Association\BelongsTo $Locations
 * @property \App\Model\Table\LedgersTable|\Cake\ORM\Association\BelongsTo $Ledgers
 * @property \App\Model\Table\ReceiptsTable|\Cake\ORM\Association\BelongsTo $Receipts
 * @property \App\Model\Table\ReceiptRowsTable|\Cake\ORM\Association\BelongsTo $ReceiptRows
 * @property \App\Model\Table\PaymentRowsTable|\Cake\ORM\Association\BelongsTo $PaymentRows
 * @property \App\Model\Table\CreditNotesTable|\Cake\ORM\Association\BelongsTo $CreditNotes
 * @property \App\Model\Table\CreditNoteRowsTable|\Cake\ORM\Association\BelongsTo $CreditNoteRows
 * @property \App\Model\Table\DebitNotesTable|\Cake\ORM\Association\BelongsTo $DebitNotes
 * @property \App\Model\Table\DebitNoteRowsTable|\Cake\ORM\Association\BelongsTo $DebitNoteRows
 * @property \App\Model\Table\SalesVoucherRowsTable|\Cake\ORM\Association\BelongsTo $SalesVoucherRows
 * @property \App\Model\Table\PurchaseVoucherRowsTable|\Cake\ORM\Association\BelongsTo $PurchaseVoucherRows
 * @property \App\Model\Table\JournalVoucherRowsTable|\Cake\ORM\Association\BelongsTo $JournalVoucherRows
 * @property \App\Model\Table\SaleReturnsTable|\Cake\ORM\Association\BelongsTo $SaleReturns
 * @property \App\Model\Table\PurchaseInvoicesTable|\Cake\ORM\Association\BelongsTo $PurchaseInvoices
 * @property \App\Model\Table\PurchaseReturnsTable|\Cake\ORM\Association\BelongsTo $PurchaseReturns
 * @property \App\Model\Table\SalesInvoicesTable|\Cake\ORM\Association\BelongsTo $SalesInvoices
 *
 * @method \App\Model\Entity\ReferenceDetail get($primaryKey, $options = [])
 * @method \App\Model\Entity\ReferenceDetail newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ReferenceDetail[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ReferenceDetail|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ReferenceDetail patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ReferenceDetail[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ReferenceDetail findOrCreate($search, callable $callback = null, $options = [])
 */
class ReferenceDetailsTable extends Table
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

        $this->setTable('reference_details');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Customers', [
            'foreignKey' => 'customer_id'
        ]);
        $this->belongsTo('Suppliers', [
            'foreignKey' => 'supplier_id'
        ]);
        $this->belongsTo('Locations', [
            'foreignKey' => 'location_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Ledgers', [
            'foreignKey' => 'ledger_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Receipts', [
            'foreignKey' => 'receipt_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('ReceiptRows', [
            'foreignKey' => 'receipt_row_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('PaymentRows', [
            'foreignKey' => 'payment_row_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('CreditNotes', [
            'foreignKey' => 'credit_note_id'
        ]);
        $this->belongsTo('CreditNoteRows', [
            'foreignKey' => 'credit_note_row_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('DebitNotes', [
            'foreignKey' => 'debit_note_id'
        ]);
        $this->belongsTo('DebitNoteRows', [
            'foreignKey' => 'debit_note_row_id'
        ]);
        $this->belongsTo('SalesVoucherRows', [
            'foreignKey' => 'sales_voucher_row_id'
        ]);
        $this->belongsTo('PurchaseVoucherRows', [
            'foreignKey' => 'purchase_voucher_row_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('JournalVoucherRows', [
            'foreignKey' => 'journal_voucher_row_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('SaleReturns', [
            'foreignKey' => 'sale_return_id'
        ]);
        $this->belongsTo('PurchaseInvoices', [
            'foreignKey' => 'purchase_invoice_id'
        ]);
        $this->belongsTo('PurchaseReturns', [
            'foreignKey' => 'purchase_return_id'
        ]);
        $this->belongsTo('SalesInvoices', [
            'foreignKey' => 'sales_invoice_id'
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
		/*
        $validator
            ->date('transaction_date')
            ->allowEmpty('transaction_date');

        $validator
            ->scalar('type')
            ->maxLength('type', 30)
            ->requirePresence('type', 'create')
            ->notEmpty('type');

        $validator
            ->scalar('ref_name')
            ->maxLength('ref_name', 255)
            ->requirePresence('ref_name', 'create')
            ->notEmpty('ref_name');

         $validator
            ->scalar('opening_balance')
            ->maxLength('opening_balance', 10)
            ->allowEmpty('opening_balance');

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
      /*  $rules->add($rules->existsIn(['customer_id'], 'Customers'));
        $rules->add($rules->existsIn(['supplier_id'], 'Suppliers'));
        $rules->add($rules->existsIn(['location_id'], 'Locations'));
        $rules->add($rules->existsIn(['ledger_id'], 'Ledgers'));
        $rules->add($rules->existsIn(['receipt_id'], 'Receipts'));
        $rules->add($rules->existsIn(['receipt_row_id'], 'ReceiptRows'));
        $rules->add($rules->existsIn(['payment_row_id'], 'PaymentRows'));
        $rules->add($rules->existsIn(['credit_note_id'], 'CreditNotes'));
        $rules->add($rules->existsIn(['credit_note_row_id'], 'CreditNoteRows'));
        $rules->add($rules->existsIn(['debit_note_id'], 'DebitNotes'));
        $rules->add($rules->existsIn(['debit_note_row_id'], 'DebitNoteRows'));
        $rules->add($rules->existsIn(['sales_voucher_row_id'], 'SalesVoucherRows'));
        $rules->add($rules->existsIn(['purchase_voucher_row_id'], 'PurchaseVoucherRows'));
        $rules->add($rules->existsIn(['journal_voucher_row_id'], 'JournalVoucherRows'));
        $rules->add($rules->existsIn(['sale_return_id'], 'SaleReturns'));
        $rules->add($rules->existsIn(['purchase_invoice_id'], 'PurchaseInvoices'));
        $rules->add($rules->existsIn(['purchase_return_id'], 'PurchaseReturns'));
        $rules->add($rules->existsIn(['sales_invoice_id'], 'SalesInvoices'));
		*/
        return $rules;
    }
}
