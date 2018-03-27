<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SellerRequests Model
 *
 * @property \App\Model\Table\SellersTable|\Cake\ORM\Association\BelongsTo $Sellers
 * @property \App\Model\Table\LocationsTable|\Cake\ORM\Association\BelongsTo $Locations
 * @property \App\Model\Table\SellerRequestRowsTable|\Cake\ORM\Association\HasMany $SellerRequestRows
 *
 * @method \App\Model\Entity\SellerRequest get($primaryKey, $options = [])
 * @method \App\Model\Entity\SellerRequest newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\SellerRequest[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SellerRequest|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SellerRequest patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\SellerRequest[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\SellerRequest findOrCreate($search, callable $callback = null, $options = [])
 */
class SellerRequestsTable extends Table
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

        $this->setTable('seller_requests');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Sellers', [
            'foreignKey' => 'seller_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Locations', [
            'foreignKey' => 'location_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('SellerRequestRows', [
            'foreignKey' => 'seller_request_id'
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
            ->scalar('status')
            ->maxLength('status', 20)
            ->requirePresence('status', 'create')
            ->notEmpty('status');

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
        $rules->add($rules->existsIn(['location_id'], 'Locations'));

        return $rules;
    }
}
