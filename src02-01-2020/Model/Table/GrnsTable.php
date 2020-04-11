<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Grns Model
 *
 * @property \App\Model\Table\SellersTable|\Cake\ORM\Association\BelongsTo $Sellers
 * @property |\Cake\ORM\Association\BelongsTo $SuperAdmins
 * @property |\Cake\ORM\Association\BelongsTo $Cities
 * @property \App\Model\Table\LocationsTable|\Cake\ORM\Association\BelongsTo $Locations
 * @property \App\Model\Table\OrdersTable|\Cake\ORM\Association\BelongsTo $Orders
 * @property \App\Model\Table\GrnRowsTable|\Cake\ORM\Association\HasMany $GrnRows
 * @property \App\Model\Table\ItemLedgersTable|\Cake\ORM\Association\HasMany $ItemLedgers
 *
 * @method \App\Model\Entity\Grn get($primaryKey, $options = [])
 * @method \App\Model\Entity\Grn newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Grn[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Grn|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Grn patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Grn[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Grn findOrCreate($search, callable $callback = null, $options = [])
 */
class GrnsTable extends Table
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

        $this->setTable('grns');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Sellers', [
            'foreignKey' => 'seller_id'
        ]);
        $this->belongsTo('SuperAdmins', [
            'foreignKey' => 'super_admin_id'
        ]);
        $this->belongsTo('Cities', [
            'foreignKey' => 'city_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Locations', [
            'foreignKey' => 'location_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Orders', [
            'foreignKey' => 'order_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('GrnRows', [
            'foreignKey' => 'grn_id',
            'saveStrategy' => 'replace'
        ]);
		$this->hasMany('StockTransferVouchers', [
            'foreignKey' => 'grn_id'
        ]);
        
        /*$this->hasMany('ItemLedgers', [
            'foreignKey' => 'item_ledger_id',
            'joinType' => 'INNER',
            'saveStrategy' => 'replace'
        ]);*/
        $this->hasMany('ItemLedgers', [
            'foreignKey' => 'grn_id'
        ]);
        $this->belongsTo('VendorLedgers', [
            'className' => 'Ledgers',
            'foreignKey' => 'vendor_ledger_id',
            'joinType' => 'LEFT'
        ]);
         $this->belongsTo('Units');
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

        /*$validator
            ->scalar('grn_no')
            ->maxLength('grn_no', 100)
            ->requirePresence('grn_no', 'create')
            ->notEmpty('grn_no');*/

        $validator
            ->date('transaction_date')
            ->requirePresence('transaction_date', 'create')
            ->notEmpty('transaction_date');

        /*$validator
            ->scalar('reference_no')
            ->maxLength('reference_no', 100)
            ->allowEmpty('reference_no');

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

        $validator
            ->dateTime('created_on')
            ->requirePresence('created_on', 'create')
            ->notEmpty('created_on');

        $validator
            ->scalar('status')
            ->maxLength('status', 20)
            ->requirePresence('status', 'create')
            ->notEmpty('status');*/

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
        $rules->add($rules->existsIn(['seller_id'], 'Sellers'));
        $rules->add($rules->existsIn(['super_admin_id'], 'SuperAdmins'));
        $rules->add($rules->existsIn(['city_id'], 'Cities'));
        $rules->add($rules->existsIn(['location_id'], 'Locations'));
        $rules->add($rules->existsIn(['order_id'], 'Orders'));

        return $rules;
    }
}
