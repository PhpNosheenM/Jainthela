<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OrderPaymentHistories Model
 *
 * @property \App\Model\Table\OrdersTable|\Cake\ORM\Association\BelongsTo $Orders
 * @property \App\Model\Table\InvoicesTable|\Cake\ORM\Association\BelongsTo $Invoices
 *
 * @method \App\Model\Entity\OrderPaymentHistory get($primaryKey, $options = [])
 * @method \App\Model\Entity\OrderPaymentHistory newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\OrderPaymentHistory[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\OrderPaymentHistory|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OrderPaymentHistory patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\OrderPaymentHistory[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\OrderPaymentHistory findOrCreate($search, callable $callback = null, $options = [])
 */
class OrderPaymentHistoriesTable extends Table
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

        $this->setTable('order_payment_histories');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Orders', [
            'foreignKey' => 'order_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Invoices', [
            'foreignKey' => 'invoice_id'
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
            ->decimal('online_amount')
            ->allowEmpty('online_amount');

        $validator
            ->decimal('cod_amount')
            ->allowEmpty('cod_amount');

        $validator
            ->decimal('wallet_amount')
            ->allowEmpty('wallet_amount');

        $validator
            ->decimal('total')
            ->requirePresence('total', 'create')
            ->notEmpty('total');

        $validator
            ->decimal('wallet_return')
            ->allowEmpty('wallet_return');

        $validator
            ->scalar('entry_from')
            ->maxLength('entry_from', 20)
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
        $rules->add($rules->existsIn(['order_id'], 'Orders'));
        $rules->add($rules->existsIn(['invoice_id'], 'Invoices'));

        return $rules;
    }
}
