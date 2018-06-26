<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Event\Event;
use ArrayObject;

/**
 * PurchaseInvoices Model
 *
 * @property \App\Model\Table\LocationsTable|\Cake\ORM\Association\BelongsTo $Locations
 * @property \App\Model\Table\SellerLedgersTable|\Cake\ORM\Association\BelongsTo $SellerLedgers
 * @property \App\Model\Table\PurchaseLedgersTable|\Cake\ORM\Association\BelongsTo $PurchaseLedgers
 * @property \App\Model\Table\CitiesTable|\Cake\ORM\Association\BelongsTo $Cities
 * @property \App\Model\Table\AccountingEntriesTable|\Cake\ORM\Association\HasMany $AccountingEntries
 * @property \App\Model\Table\ItemLedgersTable|\Cake\ORM\Association\HasMany $ItemLedgers
 * @property \App\Model\Table\PurchaseInvoiceRowsTable|\Cake\ORM\Association\HasMany $PurchaseInvoiceRows
 * @property \App\Model\Table\PurchaseReturnsTable|\Cake\ORM\Association\HasMany $PurchaseReturns
 * @property \App\Model\Table\ReferenceDetailsTable|\Cake\ORM\Association\HasMany $ReferenceDetails
 *
 * @method \App\Model\Entity\PurchaseInvoice get($primaryKey, $options = [])
 * @method \App\Model\Entity\PurchaseInvoice newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PurchaseInvoice[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PurchaseInvoice|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PurchaseInvoice patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PurchaseInvoice[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PurchaseInvoice findOrCreate($search, callable $callback = null, $options = [])
 */
class PurchaseInvoicesTable extends Table
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

        $this->setTable('purchase_invoices');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Locations', [
            'foreignKey' => 'location_id',
            'joinType' => 'INNER'
        ]);
		$this->belongsTo('Grns', [
            'foreignKey' => 'grn_id',
            'joinType' => 'INNER'
        ]);
       
		$this->belongsTo('GstFigures');
		$this->belongsTo('Items');
		$this->belongsTo('Units');
		$this->belongsTo('Sellers');
		$this->belongsTo('SellerLedgers', [
			'className' => 'Ledgers',
            'foreignKey' => 'seller_ledger_id',
            'joinType' => 'LEFT'
        ]);
		/* $this->belongsTo('PartyLedgers', [
            'className' => 'Ledgers',
            'foreignKey' => 'party_ledger_id',
            'joinType' => 'LEFT'
        ]);
		 */
		 $this->belongsTo('PurchaseLedgers', [
			'className' => 'Ledgers',
            'foreignKey' => 'purchase_ledger_id',
            'joinType' => 'LEFT'
        ]);
        $this->belongsTo('AccountingGroups', [
            'foreignKey' => 'accounting_group_id',
            'joinType' => 'LEFT'
        ]);
		$this->belongsTo('Cities', [
            'foreignKey' => 'city_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('AccountingEntries', [
            'foreignKey' => 'purchase_invoice_id'
        ]);
        $this->hasMany('ItemLedgers', [
            'foreignKey' => 'item_ledger_id'
        ]);
        $this->hasMany('PurchaseInvoiceRows', [
            'foreignKey' => 'purchase_invoice_id'
        ]);
        $this->hasMany('PurchaseReturns', [
            'foreignKey' => 'purchase_invoice_id'
        ]);
        $this->hasMany('ReferenceDetails', [
            'foreignKey' => 'purchase_invoice_id'
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
            ->scalar('narration')
            ->requirePresence('narration', 'create')
            ->notEmpty('narration');

        
        $validator
            ->integer('created_by')
            ->requirePresence('created_by', 'create')
            ->notEmpty('created_by');

        $validator
            ->dateTime('created_on')
            ->requirePresence('created_on', 'create')
            ->notEmpty('created_on');

       

        return $validator;
    }
	

	
	public function beforeMarshal(Event $event, ArrayObject $data, ArrayObject $options)
{
    if (isset($data['transaction_date'])) {
        $data['transaction_date'] = date('Y-m-d', strtotime($data['transaction_date']));
    }
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
        $rules->add($rules->existsIn(['seller_ledger_id'], 'SellerLedgers'));
        $rules->add($rules->existsIn(['purchase_ledger_id'], 'PurchaseLedgers'));
        $rules->add($rules->existsIn(['city_id'], 'Cities'));

        return $rules;
    }
}
