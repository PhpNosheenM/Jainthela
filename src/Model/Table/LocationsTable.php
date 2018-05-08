<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Locations Model
 *
 * @property \App\Model\Table\CitiesTable|\Cake\ORM\Association\BelongsTo $Cities
 * @property \App\Model\Table\AccountingEntriesTable|\Cake\ORM\Association\HasMany $AccountingEntries
 * @property \App\Model\Table\AdminsTable|\Cake\ORM\Association\HasMany $Admins
 * @property |\Cake\ORM\Association\HasMany $ContraVouchers
 * @property \App\Model\Table\CreditNotesTable|\Cake\ORM\Association\HasMany $CreditNotes
 * @property \App\Model\Table\CustomerAddressesTable|\Cake\ORM\Association\HasMany $CustomerAddresses
 * @property \App\Model\Table\DebitNotesTable|\Cake\ORM\Association\HasMany $DebitNotes
 * @property \App\Model\Table\DriversTable|\Cake\ORM\Association\HasMany $Drivers
 * @property \App\Model\Table\GrnsTable|\Cake\ORM\Association\HasMany $Grns
 * @property \App\Model\Table\GstFiguresTable|\Cake\ORM\Association\HasMany $GstFigures
 * @property |\Cake\ORM\Association\HasMany $ItemLedgers
 * @property \App\Model\Table\JournalVouchersTable|\Cake\ORM\Association\HasMany $JournalVouchers
 * @property \App\Model\Table\OrdersTable|\Cake\ORM\Association\HasMany $Orders
 * @property \App\Model\Table\PaymentsTable|\Cake\ORM\Association\HasMany $Payments
 * @property \App\Model\Table\PurchaseInvoicesTable|\Cake\ORM\Association\HasMany $PurchaseInvoices
 * @property \App\Model\Table\PurchaseReturnsTable|\Cake\ORM\Association\HasMany $PurchaseReturns
 * @property \App\Model\Table\PurchaseVouchersTable|\Cake\ORM\Association\HasMany $PurchaseVouchers
 * @property \App\Model\Table\ReceiptsTable|\Cake\ORM\Association\HasMany $Receipts
 * @property \App\Model\Table\ReferenceDetailsTable|\Cake\ORM\Association\HasMany $ReferenceDetails
 * @property \App\Model\Table\SaleReturnsTable|\Cake\ORM\Association\HasMany $SaleReturns
 * @property \App\Model\Table\SalesInvoicesTable|\Cake\ORM\Association\HasMany $SalesInvoices
 * @property \App\Model\Table\SalesVouchersTable|\Cake\ORM\Association\HasMany $SalesVouchers
 * @property |\Cake\ORM\Association\HasMany $SellerRequests
 * @property |\Cake\ORM\Association\HasMany $Sellers
 * @property \App\Model\Table\SuppliersTable|\Cake\ORM\Association\HasMany $Suppliers
 *
 * @method \App\Model\Entity\Location get($primaryKey, $options = [])
 * @method \App\Model\Entity\Location newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Location[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Location|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Location patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Location[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Location findOrCreate($search, callable $callback = null, $options = [])
 */
class LocationsTable extends Table
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

        $this->setTable('locations');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Cities', [
            'foreignKey' => 'city_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('AccountingEntries', [
            'foreignKey' => 'location_id'
        ]);
        $this->hasMany('Admins', [
            'foreignKey' => 'location_id'
        ]);
        $this->hasMany('ContraVouchers', [
            'foreignKey' => 'location_id'
        ]);
        $this->hasMany('CreditNotes', [
            'foreignKey' => 'location_id'
        ]);
        $this->hasMany('CustomerAddresses', [
            'foreignKey' => 'location_id'
        ]);
        $this->hasMany('DebitNotes', [
            'foreignKey' => 'location_id'
        ]);
        $this->hasMany('Drivers', [
            'foreignKey' => 'location_id'
        ]);
        $this->hasMany('Grns', [
            'foreignKey' => 'location_id'
        ]);
        $this->hasMany('GstFigures', [
            'foreignKey' => 'location_id'
        ]);
        $this->hasMany('ItemLedgers', [
            'foreignKey' => 'location_id'
        ]);
        $this->hasMany('JournalVouchers', [
            'foreignKey' => 'location_id'
        ]);
        $this->hasMany('Orders', [
            'foreignKey' => 'location_id'
        ]);
        $this->hasMany('Payments', [
            'foreignKey' => 'location_id'
        ]);
        $this->hasMany('PurchaseInvoices', [
            'foreignKey' => 'location_id'
        ]);
        $this->hasMany('PurchaseReturns', [
            'foreignKey' => 'location_id'
        ]);
        $this->hasMany('PurchaseVouchers', [
            'foreignKey' => 'location_id'
        ]);
        $this->hasMany('Receipts', [
            'foreignKey' => 'location_id'
        ]);
        $this->hasMany('ReferenceDetails', [
            'foreignKey' => 'location_id'
        ]);
        $this->hasMany('SaleReturns', [
            'foreignKey' => 'location_id'
        ]);
        $this->hasMany('SalesInvoices', [
            'foreignKey' => 'location_id'
        ]);
        $this->hasMany('SalesVouchers', [
            'foreignKey' => 'location_id'
        ]);
        $this->hasMany('SellerRequests', [
            'foreignKey' => 'location_id'
        ]);
        $this->hasMany('Sellers', [
            'foreignKey' => 'location_id'
        ]);
        $this->hasMany('Suppliers', [
            'foreignKey' => 'location_id'
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
            ->maxLength('name', 50)
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->scalar('alise')
            ->maxLength('alise', 100)
            ->requirePresence('alise', 'create')
            ->notEmpty('alise');

        $validator
            ->scalar('latitude')
            ->maxLength('latitude', 50)
            ->requirePresence('latitude', 'create')
            ->notEmpty('latitude');

        $validator
            ->scalar('longitude')
            ->maxLength('longitude', 50)
            ->requirePresence('longitude', 'create')
            ->notEmpty('longitude');

     /*    $validator
            ->integer('created_on')
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

      /*   $validator
            ->date('financial_year_begins_from')
            ->requirePresence('financial_year_begins_from', 'create')
            ->notEmpty('financial_year_begins_from');

        $validator
            ->date('financial_year_valid_to')
            ->requirePresence('financial_year_valid_to', 'create')
            ->notEmpty('financial_year_valid_to');

        $validator
            ->date('books_beginning_from')
            ->requirePresence('books_beginning_from', 'create')
            ->notEmpty('books_beginning_from'); */

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
