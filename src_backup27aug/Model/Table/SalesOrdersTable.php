<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SalesOrders Model
 *
 * @property \App\Model\Table\LocationsTable|\Cake\ORM\Association\BelongsTo $Locations
 * @property \App\Model\Table\CitiesTable|\Cake\ORM\Association\BelongsTo $Cities
 * @property \App\Model\Table\SalesLedgersTable|\Cake\ORM\Association\BelongsTo $SalesLedgers
 * @property \App\Model\Table\PartyLedgersTable|\Cake\ORM\Association\BelongsTo $PartyLedgers
 * @property \App\Model\Table\CustomersTable|\Cake\ORM\Association\BelongsTo $Customers
 * @property \App\Model\Table\DriversTable|\Cake\ORM\Association\BelongsTo $Drivers
 * @property \App\Model\Table\CustomerAddressesTable|\Cake\ORM\Association\BelongsTo $CustomerAddresses
 * @property \App\Model\Table\PromotionDetailsTable|\Cake\ORM\Association\BelongsTo $PromotionDetails
 * @property \App\Model\Table\DeliveryChargesTable|\Cake\ORM\Association\BelongsTo $DeliveryCharges
 * @property \App\Model\Table\DeliveryTimesTable|\Cake\ORM\Association\BelongsTo $DeliveryTimes
 * @property \App\Model\Table\CancelReasonsTable|\Cake\ORM\Association\BelongsTo $CancelReasons
 * @property \App\Model\Table\SalesOrderRowsTable|\Cake\ORM\Association\HasMany $SalesOrderRows
 *
 * @method \App\Model\Entity\SalesOrder get($primaryKey, $options = [])
 * @method \App\Model\Entity\SalesOrder newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\SalesOrder[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SalesOrder|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SalesOrder patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\SalesOrder[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\SalesOrder findOrCreate($search, callable $callback = null, $options = [])
 */
class SalesOrdersTable extends Table
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

        $this->setTable('sales_orders');
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
		
		$this->belongsTo('BulkOrderPerformas', [
            'foreignKey' => 'bulk_order_performa_id',
            'joinType' => 'INNER'
        ]);
       $this->belongsTo('SalesLedgers', [
            'foreignKey' => 'sales_ledger_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('PartyLedgers', [
            'foreignKey' => 'party_ledger_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Customers', [
            'foreignKey' => 'customer_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Drivers', [
            'foreignKey' => 'driver_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('CustomerAddresses', [
            'foreignKey' => 'customer_address_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('PromotionDetails', [
            'foreignKey' => 'promotion_detail_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('DeliveryCharges', [
            'foreignKey' => 'delivery_charge_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('DeliveryTimes', [
            'foreignKey' => 'delivery_time_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('CancelReasons', [
            'foreignKey' => 'cancel_reason_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('SalesOrderRows', [
            'foreignKey' => 'sales_order_id'
        ]);
		
		 $this->belongsTo('SellerLedgers', [
            'className' => 'Ledgers',
            'foreignKey' => 'sales_ledger_id',
            'joinType' => 'LEFT'
        ]);
		
		 $this->belongsTo('Items');
		 $this->belongsTo('GstFigures');
		 $this->belongsTo('AccountingGroups');
		 $this->belongsTo('Ledgers');
		 $this->belongsTo('Companies');
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
            ->scalar('sales_order_no')
            ->maxLength('sales_order_no', 100)
            ->requirePresence('sales_order_no', 'create')
            ->notEmpty('sales_order_no');

        $validator
            ->integer('voucher_no')
            ->requirePresence('voucher_no', 'create')
            ->notEmpty('voucher_no');
/* 
        $validator
            ->scalar('ccavvenue_tracking_no')
            ->maxLength('ccavvenue_tracking_no', 200)
            ->requirePresence('ccavvenue_tracking_no', 'create')
            ->notEmpty('ccavvenue_tracking_no');

        $validator
            ->decimal('amount_from_wallet')
            ->requirePresence('amount_from_wallet', 'create')
            ->notEmpty('amount_from_wallet');
 */
        $validator
            ->decimal('total_amount')
            ->requirePresence('total_amount', 'create')
            ->notEmpty('total_amount');
/* 
        $validator
            ->decimal('discount_percent')
            ->requirePresence('discount_percent', 'create')
            ->notEmpty('discount_percent');
 */
        $validator
            ->decimal('total_gst')
            ->requirePresence('total_gst', 'create')
            ->notEmpty('total_gst');

        $validator
            ->decimal('grand_total')
            ->requirePresence('grand_total', 'create')
            ->notEmpty('grand_total');
/* 
        $validator
            ->decimal('pay_amount')
            ->requirePresence('pay_amount', 'create')
            ->notEmpty('pay_amount');

        $validator
            ->decimal('online_amount')
            ->requirePresence('online_amount', 'create')
            ->notEmpty('online_amount');

        $validator
            ->scalar('sales_order_type')
            ->maxLength('sales_order_type', 50)
            ->requirePresence('sales_order_type', 'create')
            ->notEmpty('sales_order_type');

        $validator
            ->dateTime('delivery_date')
            ->requirePresence('delivery_date', 'create')
            ->notEmpty('delivery_date');

        $validator
            ->scalar('sales_order_status')
            ->maxLength('sales_order_status', 30)
            ->requirePresence('sales_order_status', 'create')
            ->notEmpty('sales_order_status');

        $validator
            ->scalar('cancel_reason_other')
            ->requirePresence('cancel_reason_other', 'create')
            ->notEmpty('cancel_reason_other');

        $validator
            ->date('cancel_date')
            ->requirePresence('cancel_date', 'create')
            ->notEmpty('cancel_date');

        $validator
            ->date('transaction_date')
            ->requirePresence('transaction_date', 'create')
            ->notEmpty('transaction_date');

        $validator
            ->dateTime('sales_order_date')
            ->requirePresence('sales_order_date', 'create')
            ->notEmpty('sales_order_date');

        $validator
            ->scalar('payment_status')
            ->maxLength('payment_status', 30)
            ->requirePresence('payment_status', 'create')
            ->notEmpty('payment_status');

        $validator
            ->scalar('sales_order_from')
            ->maxLength('sales_order_from', 30)
            ->requirePresence('sales_order_from', 'create')
            ->notEmpty('sales_order_from'); */

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
       // $rules->add($rules->existsIn(['location_id'], 'Locations'));
        $rules->add($rules->existsIn(['city_id'], 'Cities'));
        //$rules->add($rules->existsIn(['sales_ledger_id'], 'SalesLedgers'));
        //$rules->add($rules->existsIn(['party_ledger_id'], 'PartyLedgers'));
        $rules->add($rules->existsIn(['customer_id'], 'Customers'));
        $rules->add($rules->existsIn(['driver_id'], 'Drivers'));
        $rules->add($rules->existsIn(['customer_address_id'], 'CustomerAddresses'));
        $rules->add($rules->existsIn(['promotion_detail_id'], 'PromotionDetails'));
        $rules->add($rules->existsIn(['delivery_charge_id'], 'DeliveryCharges'));
        $rules->add($rules->existsIn(['delivery_time_id'], 'DeliveryTimes'));
        $rules->add($rules->existsIn(['cancel_reason_id'], 'CancelReasons'));

        return $rules;
    }
}
