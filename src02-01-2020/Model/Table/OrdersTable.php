<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Orders Model
 *
 * @property \App\Model\Table\LocationsTable|\Cake\ORM\Association\BelongsTo $Locations
 * @property \App\Model\Table\CustomersTable|\Cake\ORM\Association\BelongsTo $Customers
 * @property \App\Model\Table\DriversTable|\Cake\ORM\Association\BelongsTo $Drivers
 * @property \App\Model\Table\CustomerAddressesTable|\Cake\ORM\Association\BelongsTo $CustomerAddresses
 * @property \App\Model\Table\PromotionDetailsTable|\Cake\ORM\Association\BelongsTo $PromotionDetails
 * @property \App\Model\Table\DeliveryChargesTable|\Cake\ORM\Association\BelongsTo $DeliveryCharges
 * @property \App\Model\Table\DeliveryTimesTable|\Cake\ORM\Association\BelongsTo $DeliveryTimes
 * @property \App\Model\Table\CancelReasonsTable|\Cake\ORM\Association\BelongsTo $CancelReasons
 * @property \App\Model\Table\OrderDetailsTable|\Cake\ORM\Association\HasMany $OrderDetails
 * @property \App\Model\Table\WalletsTable|\Cake\ORM\Association\HasMany $Wallets
 *
 * @method \App\Model\Entity\Order get($primaryKey, $options = [])
 * @method \App\Model\Entity\Order newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Order[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Order|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Order patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Order[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Order findOrCreate($search, callable $callback = null, $options = [])
 */
class OrdersTable extends Table
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

        $this->setTable('orders');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Carts');
        $this->belongsTo('Items');
        $this->belongsTo('GstFigures');
        $this->belongsTo('AccountingEntries');
        $this->belongsTo('AccountingGroups');
        $this->belongsTo('Categories');

        $this->belongsTo('Locations', [
            'foreignKey' => 'location_id',
            'joinType' => 'LEFT'
        ]);
		$this->belongsTo('FinancialYears', [
            'foreignKey' => 'financial_year_id',
            'joinType' => 'INNER'
        ]);
		$this->belongsTo('Invoices', [
            'foreignKey' => 'order_id',
            'joinType' => 'INNER'
        ]);
		$this->belongsTo('Cities', [
            'foreignKey' => 'city_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Customers', [
            'foreignKey' => 'customer_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Drivers', [
            'foreignKey' => 'driver_id',
            'joinType' => 'LEFT'
        ]);
		 $this->belongsTo('Challans', [
            'foreignKey' => 'challan_id',
            'joinType' => 'LEFT'
        ]);
		$this->belongsTo('Ledgers', [
            'foreignKey' => 'ledger_id',
            'joinType' => 'INNER'
        ]);
		$this->belongsTo('Grns', [
            'foreignKey' => 'grn_id',
            'joinType' => 'INNER'
        ]);
		$this->belongsTo('PurchaseInvoices', [
            'foreignKey' => 'purchase_invoice_id',
            'joinType' => 'INNER'
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
		
		$this->belongsTo('PromotionDetailsLeft', [
            'className' =>'PromotionDetails',
            'foreignKey' => 'promotion_detail_id',
            'joinType' => 'LEFT'
        ]);
		
		$this->belongsTo('Sellers', [
            'foreignKey' => 'seller_id',
            'joinType' => 'LEFT'
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
		$this->belongsTo('OrderPaymentHistories', [
            'foreignKey' => 'order_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('OrderDetails', [
            'foreignKey' => 'order_id'
        ]);
		$this->hasMany('ReferenceDetails', [
            'foreignKey' => 'order_id',
			'saveStretegy'=>'replace'
        ]);
        $this->hasMany('Wallets', [
            'foreignKey' => 'order_id'
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
		
		$this->belongsTo('JournalVouchers', [
            'foreignKey' => 'journal_voucher_id',
            'joinType' => 'INNER'
        ]);
		
		
		
		$this->belongsTo('SalesOrders');
		$this->belongsTo('Companies');
		$this->belongsTo('MasterSetups');
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
            ->scalar('order_no')
            ->maxLength('order_no', 100)
            ->requirePresence('order_no', 'create')
            ->notEmpty('order_no');



        /* $validator
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
            ->decimal('total_gst')
            ->requirePresence('total_gst', 'create')
            ->notEmpty('total_gst');

        $validator
            ->decimal('grand_total')
            ->requirePresence('grand_total', 'create')
            ->notEmpty('grand_total');

        $validator
            ->decimal('pay_amount')
            ->requirePresence('pay_amount', 'create')
            ->notEmpty('pay_amount');

        $validator
            ->decimal('online_amount')
            ->requirePresence('online_amount', 'create')
            ->notEmpty('online_amount');

        $validator
            ->scalar('order_type')
            ->maxLength('order_type', 50)
            ->requirePresence('order_type', 'create')
            ->notEmpty('order_type');

        $validator
            ->scalar('order_status')
            ->maxLength('order_status', 30)
            ->requirePresence('order_status', 'create')
            ->notEmpty('order_status');

        $validator
            ->dateTime('order_date')
            ->requirePresence('order_date', 'create')
            ->notEmpty('order_date');

        $validator
            ->scalar('order_from')
            ->maxLength('order_from', 30)
            ->requirePresence('order_from', 'create')
            ->notEmpty('order_from'); */

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
		//$rules->add($rules->existsIn(['customer_id'], 'Customers'));
        /* $rules->add($rules->existsIn(['location_id'], 'Locations'));
        
        $rules->add($rules->existsIn(['driver_id'], 'Drivers'));
        $rules->add($rules->existsIn(['customer_address_id'], 'CustomerAddresses'));
        $rules->add($rules->existsIn(['promotion_detail_id'], 'PromotionDetails'));
        $rules->add($rules->existsIn(['delivery_charge_id'], 'DeliveryCharges'));
        $rules->add($rules->existsIn(['delivery_time_id'], 'DeliveryTimes'));
        $rules->add($rules->existsIn(['cancel_reason_id'], 'CancelReasons')); */

        return $rules;
    }
}
