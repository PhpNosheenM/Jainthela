<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Challans Model
 *
 * @property \App\Model\Table\OrdersTable|\Cake\ORM\Association\BelongsTo $Orders
 * @property \App\Model\Table\LocationsTable|\Cake\ORM\Association\BelongsTo $Locations
 * @property \App\Model\Table\SellersTable|\Cake\ORM\Association\BelongsTo $Sellers
 * @property \App\Model\Table\FinancialYearsTable|\Cake\ORM\Association\BelongsTo $FinancialYears
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
 * @property \App\Model\Table\ChallanRowsTable|\Cake\ORM\Association\HasMany $ChallanRows
 *
 * @method \App\Model\Entity\Challan get($primaryKey, $options = [])
 * @method \App\Model\Entity\Challan newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Challan[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Challan|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Challan patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Challan[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Challan findOrCreate($search, callable $callback = null, $options = [])
 */
class ChallansTable extends Table
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

        $this->setTable('challans');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Companies');
        $this->belongsTo('Orders', [
            'foreignKey' => 'order_id',
            'joinType' => 'INNER'
        ]);
		$this->belongsTo('Invoices', [
            'foreignKey' => 'invoice_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Locations', [
            'foreignKey' => 'location_id',
            'joinType' => 'LEFT'
        ]);
        $this->belongsTo('Sellers', [
            'foreignKey' => 'seller_id'
        ]);
        $this->belongsTo('FinancialYears', [
            'foreignKey' => 'financial_year_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Cities', [
            'foreignKey' => 'city_id',
            'joinType' => 'INNER'
        ]);
       	$this->belongsTo('SellerLedgers', [
            'className' => 'Ledgers',
            'foreignKey' => 'sales_ledger_id',
            'joinType' => 'LEFT'
        ]);
		
		$this->belongsTo('PartyLedgers', [
            'className' => 'Ledgers',
            'foreignKey' => 'party_ledger_id',
            'joinType' => 'LEFT'
        ]);
        $this->belongsTo('Wallets');
		
        $this->belongsTo('Customers', [
            'foreignKey' => 'customer_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Drivers', [
            'foreignKey' => 'driver_id',
            'joinType' => 'LEFT'
        ]);
		 $this->belongsTo('JournalVouchers', [
            'foreignKey' => 'journal_voucher_id',
            'joinType' => 'INNER'
        ]);
		
		$this->belongsTo('PurchaseVouchers', [
            'foreignKey' => 'purchase_voucher_id',
            'joinType' => 'INNER'
        ]);
		
		 $this->belongsTo('AccountingGroups', [
            'foreignKey' => 'accounting_group_id',
            'joinType' => 'LEFT'
        ]);
		
        $this->belongsTo('CustomerAddresses', [
            'foreignKey' => 'customer_address_id',
            'joinType' => 'INNER'
        ]);
		$this->belongsTo('CustomerAddressesLeft', [
            'className' =>'CustomerAddresses',
            'foreignKey' => 'customer_address_id',
            'joinType' => 'LEFT'
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
		
		$this->belongsTo('Routes', [
            'foreignKey' => 'route_id',
            'joinType' => 'INNER'
        ]);
		
       $this->hasMany('ChallanRows', [
            'foreignKey' => 'challan_id',
			'saveStrategy'=>'replace',
			'dependent'=>true,
			'casecadeCallbacks'=>true
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
            ->scalar('seller_name')
            ->maxLength('seller_name', 50)
            ->allowEmpty('seller_name');

        $validator
            ->scalar('address')
            ->requirePresence('address', 'create')
            ->notEmpty('address');

        $validator
            ->scalar('invoice_no')
            ->maxLength('invoice_no', 100)
            ->requirePresence('invoice_no', 'create')
            ->notEmpty('invoice_no');

        $validator
            ->integer('voucher_no')
            ->requirePresence('voucher_no', 'create')
            ->notEmpty('voucher_no');

        $validator
            ->scalar('ccavvenue_tracking_no')
            ->maxLength('ccavvenue_tracking_no', 200)
            ->requirePresence('ccavvenue_tracking_no', 'create')
            ->notEmpty('ccavvenue_tracking_no');

        $validator
            ->decimal('amount_from_wallet')
            ->requirePresence('amount_from_wallet', 'create')
            ->notEmpty('amount_from_wallet');

        $validator
            ->decimal('total_amount')
            ->requirePresence('total_amount', 'create')
            ->notEmpty('total_amount');

        $validator
            ->decimal('discount_percent')
            ->requirePresence('discount_percent', 'create')
            ->notEmpty('discount_percent');

        $validator
            ->decimal('discount_amount')
            ->requirePresence('discount_amount', 'create')
            ->notEmpty('discount_amount');

        $validator
            ->decimal('total_gst')
            ->requirePresence('total_gst', 'create')
            ->notEmpty('total_gst');

        $validator
            ->decimal('grand_total')
            ->requirePresence('grand_total', 'create')
            ->notEmpty('grand_total');

        $validator
            ->decimal('round_off')
            ->requirePresence('round_off', 'create')
            ->notEmpty('round_off');

        $validator
            ->decimal('pay_amount')
            ->requirePresence('pay_amount', 'create')
            ->notEmpty('pay_amount');

        $validator
            ->decimal('due_amount')
            ->requirePresence('due_amount', 'create')
            ->notEmpty('due_amount');

        $validator
            ->decimal('online_amount')
            ->requirePresence('online_amount', 'create')
            ->notEmpty('online_amount');

        $validator
            ->scalar('delivery_charge_amount')
            ->maxLength('delivery_charge_amount', 20)
            ->requirePresence('delivery_charge_amount', 'create')
            ->notEmpty('delivery_charge_amount');

        $validator
            ->scalar('order_type')
            ->maxLength('order_type', 50)
            ->requirePresence('order_type', 'create')
            ->notEmpty('order_type');

        $validator
            ->date('delivery_date')
            ->requirePresence('delivery_date', 'create')
            ->notEmpty('delivery_date');

        $validator
            ->scalar('delivery_time_sloat')
            ->maxLength('delivery_time_sloat', 255)
            ->requirePresence('delivery_time_sloat', 'create')
            ->notEmpty('delivery_time_sloat');

        $validator
            ->scalar('order_status')
            ->maxLength('order_status', 30)
            ->requirePresence('order_status', 'create')
            ->notEmpty('order_status');

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
            ->date('order_date')
            ->requirePresence('order_date', 'create')
            ->notEmpty('order_date');

        $validator
            ->scalar('payment_status')
            ->maxLength('payment_status', 30)
            ->requirePresence('payment_status', 'create')
            ->notEmpty('payment_status');

        $validator
            ->scalar('order_from')
            ->maxLength('order_from', 30)
            ->requirePresence('order_from', 'create')
            ->notEmpty('order_from');

        $validator
            ->scalar('narration')
            ->requirePresence('narration', 'create')
            ->notEmpty('narration');

        $validator
            ->dateTime('packing_on')
            ->requirePresence('packing_on', 'create')
            ->notEmpty('packing_on');

        $validator
            ->scalar('packing_flag')
            ->maxLength('packing_flag', 10)
            ->requirePresence('packing_flag', 'create')
            ->notEmpty('packing_flag');

        $validator
            ->dateTime('dispatch_on')
            ->requirePresence('dispatch_on', 'create')
            ->notEmpty('dispatch_on');

        $validator
            ->scalar('dispatch_flag')
            ->maxLength('dispatch_flag', 10)
            ->requirePresence('dispatch_flag', 'create')
            ->notEmpty('dispatch_flag');

        $validator
            ->scalar('otp')
            ->maxLength('otp', 10)
            ->requirePresence('otp', 'create')
            ->notEmpty('otp');

        $validator
            ->scalar('otp_confirmation')
            ->maxLength('otp_confirmation', 10)
            ->requirePresence('otp_confirmation', 'create')
            ->notEmpty('otp_confirmation');

        $validator
            ->scalar('not_received')
            ->maxLength('not_received', 10)
            ->requirePresence('not_received', 'create')
            ->notEmpty('not_received');

        $validator
            ->decimal('online_return_amount')
            ->requirePresence('online_return_amount', 'create')
            ->notEmpty('online_return_amount');

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
       

        return $rules;
    }
}
