<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;


/**
 * ItemLedgers Model
 *
 * @property \App\Model\Table\ItemsTable|\Cake\ORM\Association\BelongsTo $Items
 * @property \App\Model\Table\ItemVariationsTable|\Cake\ORM\Association\BelongsTo $ItemVariations
 * @property \App\Model\Table\SalesInvoicesTable|\Cake\ORM\Association\BelongsTo $SalesInvoices
 * @property \App\Model\Table\SalesInvoiceRowsTable|\Cake\ORM\Association\BelongsTo $SalesInvoiceRows
 * @property \App\Model\Table\LocationsTable|\Cake\ORM\Association\BelongsTo $Locations
 * @property \App\Model\Table\CreditNotesTable|\Cake\ORM\Association\BelongsTo $CreditNotes
 * @property \App\Model\Table\CreditNoteRowsTable|\Cake\ORM\Association\BelongsTo $CreditNoteRows
 * @property \App\Model\Table\SaleReturnsTable|\Cake\ORM\Association\BelongsTo $SaleReturns
 * @property \App\Model\Table\SaleReturnRowsTable|\Cake\ORM\Association\BelongsTo $SaleReturnRows
 * @property \App\Model\Table\PurchaseInvoicesTable|\Cake\ORM\Association\BelongsTo $PurchaseInvoices
 * @property \App\Model\Table\PurchaseInvoiceRowsTable|\Cake\ORM\Association\BelongsTo $PurchaseInvoiceRows
 * @property \App\Model\Table\PurchaseReturnsTable|\Cake\ORM\Association\BelongsTo $PurchaseReturns
 * @property \App\Model\Table\PurchaseReturnRowsTable|\Cake\ORM\Association\BelongsTo $PurchaseReturnRows
 * @property \App\Model\Table\CitiesTable|\Cake\ORM\Association\BelongsTo $Cities
 *
 * @method \App\Model\Entity\ItemLedger get($primaryKey, $options = [])
 * @method \App\Model\Entity\ItemLedger newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ItemLedger[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ItemLedger|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ItemLedger patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ItemLedger[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ItemLedger findOrCreate($search, callable $callback = null, $options = [])
 */
class ItemLedgersTable extends Table
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

        $this->setTable('item_ledgers');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Items', [
            'foreignKey' => 'item_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('ItemVariations', [
            'foreignKey' => 'item_variation_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('SalesInvoices', [
            'foreignKey' => 'sales_invoice_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('SalesInvoiceRows', [
            'foreignKey' => 'sales_invoice_row_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Locations', [
            'foreignKey' => 'location_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('CreditNotes', [
            'foreignKey' => 'credit_note_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('CreditNoteRows', [
            'foreignKey' => 'credit_note_row_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('SaleReturns', [
            'foreignKey' => 'sale_return_id'
        ]);
        $this->belongsTo('SaleReturnRows', [
            'foreignKey' => 'sale_return_row_id'
        ]);
        $this->belongsTo('PurchaseInvoices', [
            'foreignKey' => 'purchase_invoice_id'
        ]);
        $this->belongsTo('PurchaseInvoiceRows', [
            'foreignKey' => 'purchase_invoice_row_id'
        ]);
        $this->belongsTo('PurchaseReturns', [
            'foreignKey' => 'purchase_return_id'
        ]);
        $this->belongsTo('PurchaseReturnRows', [
            'foreignKey' => 'purchase_return_row_id'
        ]);
        $this->belongsTo('Cities', [
            'foreignKey' => 'city_id',
            'joinType' => 'INNER'
        ]);
		$this->belongsTo('UnitVariations', [
            'foreignKey' => 'unit_variation_id',
            'joinType' => 'INNER'
        ]);
		
		$this->belongsTo('Invoices', [
            'foreignKey' => 'invoice_id',
			'joinType' => 'LEFT'
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
            ->decimal('quantity')
            ->requirePresence('quantity', 'create')
            ->notEmpty('quantity');

        $validator
            ->decimal('rate')
            ->requirePresence('rate', 'create')
            ->notEmpty('rate');

        $validator
            ->decimal('amount')
            ->requirePresence('amount', 'create')
            ->notEmpty('amount');

        $validator
            ->scalar('status')
            ->maxLength('status', 10)
            ->requirePresence('status', 'create')
            ->notEmpty('status');

        $validator
            ->scalar('is_opening_balance')
            ->maxLength('is_opening_balance', 10)
            ->allowEmpty('is_opening_balance');

        $validator
            ->decimal('sale_rate')
            ->allowEmpty('sale_rate');

        $validator
            ->decimal('purchase_rate')
            ->requirePresence('purchase_rate', 'create')
            ->notEmpty('purchase_rate');

        $validator
            ->scalar('entry_from')
            ->maxLength('entry_from', 10)
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
        $rules->add($rules->existsIn(['item_id'], 'Items'));
        //$rules->add($rules->existsIn(['item_variation_id'], 'ItemVariations'));
        $rules->add($rules->existsIn(['sales_invoice_id'], 'SalesInvoices'));
        $rules->add($rules->existsIn(['sales_invoice_row_id'], 'SalesInvoiceRows'));
        $rules->add($rules->existsIn(['location_id'], 'Locations'));
        $rules->add($rules->existsIn(['credit_note_id'], 'CreditNotes'));
        $rules->add($rules->existsIn(['credit_note_row_id'], 'CreditNoteRows'));
        $rules->add($rules->existsIn(['sale_return_id'], 'SaleReturns'));
        $rules->add($rules->existsIn(['sale_return_row_id'], 'SaleReturnRows'));
        $rules->add($rules->existsIn(['purchase_invoice_id'], 'PurchaseInvoices'));
        $rules->add($rules->existsIn(['purchase_invoice_row_id'], 'PurchaseInvoiceRows'));
        $rules->add($rules->existsIn(['purchase_return_id'], 'PurchaseReturns'));
        $rules->add($rules->existsIn(['purchase_return_row_id'], 'PurchaseReturnRows'));
        $rules->add($rules->existsIn(['city_id'], 'Cities'));

        return $rules;
    }
}
