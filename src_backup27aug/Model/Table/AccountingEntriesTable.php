<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AccountingEntries Model
 *
 * @property \App\Model\Table\LedgersTable|\Cake\ORM\Association\BelongsTo $Ledgers
 * @property \App\Model\Table\LocationsTable|\Cake\ORM\Association\BelongsTo $Locations
 * @property \App\Model\Table\CitiesTable|\Cake\ORM\Association\BelongsTo $Cities
 * @property \App\Model\Table\PurchaseVouchersTable|\Cake\ORM\Association\BelongsTo $PurchaseVouchers
 * @property \App\Model\Table\PurchaseVoucherRowsTable|\Cake\ORM\Association\BelongsTo $PurchaseVoucherRows
 * @property \App\Model\Table\SalesInvoicesTable|\Cake\ORM\Association\BelongsTo $SalesInvoices
 * @property \App\Model\Table\SaleReturnsTable|\Cake\ORM\Association\BelongsTo $SaleReturns
 * @property \App\Model\Table\PurchaseInvoicesTable|\Cake\ORM\Association\BelongsTo $PurchaseInvoices
 * @property \App\Model\Table\PurchaseReturnsTable|\Cake\ORM\Association\BelongsTo $PurchaseReturns
 * @property \App\Model\Table\ReceiptsTable|\Cake\ORM\Association\BelongsTo $Receipts
 * @property \App\Model\Table\ReceiptRowsTable|\Cake\ORM\Association\BelongsTo $ReceiptRows
 * @property \App\Model\Table\PaymentsTable|\Cake\ORM\Association\BelongsTo $Payments
 * @property \App\Model\Table\PaymentRowsTable|\Cake\ORM\Association\BelongsTo $PaymentRows
 * @property \App\Model\Table\CreditNotesTable|\Cake\ORM\Association\BelongsTo $CreditNotes
 * @property \App\Model\Table\CreditNoteRowsTable|\Cake\ORM\Association\BelongsTo $CreditNoteRows
 * @property \App\Model\Table\DebitNotesTable|\Cake\ORM\Association\BelongsTo $DebitNotes
 * @property \App\Model\Table\DebitNoteRowsTable|\Cake\ORM\Association\BelongsTo $DebitNoteRows
 * @property \App\Model\Table\SalesVouchersTable|\Cake\ORM\Association\BelongsTo $SalesVouchers
 * @property \App\Model\Table\SalesVoucherRowsTable|\Cake\ORM\Association\BelongsTo $SalesVoucherRows
 * @property \App\Model\Table\JournalVouchersTable|\Cake\ORM\Association\BelongsTo $JournalVouchers
 * @property \App\Model\Table\JournalVoucherRowsTable|\Cake\ORM\Association\BelongsTo $JournalVoucherRows
 * @property \App\Model\Table\ContraVouchersTable|\Cake\ORM\Association\BelongsTo $ContraVouchers
 * @property \App\Model\Table\ContraVoucherRowsTable|\Cake\ORM\Association\BelongsTo $ContraVoucherRows
 *
 * @method \App\Model\Entity\AccountingEntry get($primaryKey, $options = [])
 * @method \App\Model\Entity\AccountingEntry newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\AccountingEntry[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AccountingEntry|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AccountingEntry patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\AccountingEntry[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\AccountingEntry findOrCreate($search, callable $callback = null, $options = [])
 */
class AccountingEntriesTable extends Table
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

        $this->setTable('accounting_entries');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Ledgers', [
            'foreignKey' => 'ledger_id',
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
		
		 $this->belongsTo('PurchaseInvoices', [
            'foreignKey' => 'purchase_invoice_id'
        ]);
		
		 $this->belongsTo('Payments', [
            'foreignKey' => 'payment_id'
        ]);
		$this->belongsTo('Orders', [
            'foreignKey' => 'order_id'
        ]);
         $this->belongsTo('PurchaseVouchers', [
            'foreignKey' => 'purchase_voucher_id'
        ]);
        $this->belongsTo('PurchaseVoucherRows', [
            'foreignKey' => 'purchase_voucher_row_id'
        ]);
        $this->belongsTo('SalesInvoices', [
            'foreignKey' => 'sales_invoice_id',
            'joinType' => 'INNER'
        ]);
		 $this->belongsTo('Invoices', [
            'foreignKey' => 'invoice_id',
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
        $this->belongsTo('Receipts', [
            'foreignKey' => 'receipt_id'
        ]);
        $this->belongsTo('ReceiptRows', [
            'foreignKey' => 'receipt_row_id'
        ]);
        $this->belongsTo('Payments', [
            'foreignKey' => 'payment_id'
        ]);
        $this->belongsTo('PaymentRows', [
            'foreignKey' => 'payment_row_id'
        ]);
        $this->belongsTo('CreditNotes', [
            'foreignKey' => 'credit_note_id'
        ]);
        $this->belongsTo('CreditNoteRows', [
            'foreignKey' => 'credit_note_row_id'
        ]);
        $this->belongsTo('DebitNotes', [
            'foreignKey' => 'debit_note_id'
        ]);
        $this->belongsTo('DebitNoteRows', [
            'foreignKey' => 'debit_note_row_id'
        ]);
        $this->belongsTo('SalesVouchers', [
            'foreignKey' => 'sales_voucher_id'
        ]);
        $this->belongsTo('SalesVoucherRows', [
            'foreignKey' => 'sales_voucher_row_id'
        ]);
        $this->belongsTo('JournalVouchers', [
            'foreignKey' => 'journal_voucher_id'
        ]);
        $this->belongsTo('JournalVoucherRows', [
            'foreignKey' => 'journal_voucher_row_id'
        ]);
        $this->belongsTo('ContraVouchers', [
            'foreignKey' => 'contra_voucher_id'
        ]);
        $this->belongsTo('ContraVoucherRows', [
            'foreignKey' => 'contra_voucher_row_id'
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
            ->decimal('debit')
            ->allowEmpty('debit');

        $validator
            ->decimal('credit')
            ->allowEmpty('credit');

        $validator
            ->date('transaction_date')
            ->requirePresence('transaction_date', 'create')
            ->notEmpty('transaction_date');

        $validator
            ->scalar('is_opening_balance')
            ->maxLength('is_opening_balance', 10)
            ->allowEmpty('is_opening_balance');

        $validator
            ->date('reconciliation_date')
            ->allowEmpty('reconciliation_date');

        $validator
            ->scalar('entry_from')
            ->maxLength('entry_from', 11)
            ->requirePresence('entry_from', 'create')
            ->notEmpty('entry_from');

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
        /* $rules->add($rules->existsIn(['ledger_id'], 'Ledgers'));
        $rules->add($rules->existsIn(['location_id'], 'Locations'));
        $rules->add($rules->existsIn(['city_id'], 'Cities'));
        $rules->add($rules->existsIn(['purchase_voucher_id'], 'PurchaseVouchers'));
        $rules->add($rules->existsIn(['purchase_voucher_row_id'], 'PurchaseVoucherRows'));
        $rules->add($rules->existsIn(['sales_invoice_id'], 'SalesInvoices'));
        $rules->add($rules->existsIn(['sale_return_id'], 'SaleReturns'));
        $rules->add($rules->existsIn(['purchase_invoice_id'], 'PurchaseInvoices'));
        $rules->add($rules->existsIn(['purchase_return_id'], 'PurchaseReturns'));
        $rules->add($rules->existsIn(['receipt_id'], 'Receipts'));
        $rules->add($rules->existsIn(['receipt_row_id'], 'ReceiptRows'));
        $rules->add($rules->existsIn(['payment_id'], 'Payments'));
        $rules->add($rules->existsIn(['payment_row_id'], 'PaymentRows'));
        $rules->add($rules->existsIn(['credit_note_id'], 'CreditNotes'));
        $rules->add($rules->existsIn(['credit_note_row_id'], 'CreditNoteRows'));
        $rules->add($rules->existsIn(['debit_note_id'], 'DebitNotes'));
        $rules->add($rules->existsIn(['debit_note_row_id'], 'DebitNoteRows'));
        $rules->add($rules->existsIn(['sales_voucher_id'], 'SalesVouchers'));
        $rules->add($rules->existsIn(['sales_voucher_row_id'], 'SalesVoucherRows'));
        $rules->add($rules->existsIn(['journal_voucher_id'], 'JournalVouchers'));
        $rules->add($rules->existsIn(['journal_voucher_row_id'], 'JournalVoucherRows'));
        $rules->add($rules->existsIn(['contra_voucher_id'], 'ContraVouchers'));
        $rules->add($rules->existsIn(['contra_voucher_row_id'], 'ContraVoucherRows'));
 */
        return $rules;
    }
}
