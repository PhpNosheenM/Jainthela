<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PurchaseVoucherRows Model
 *
 * @property \App\Model\Table\PurchaseVouchersTable|\Cake\ORM\Association\BelongsTo $PurchaseVouchers
 * @property \App\Model\Table\LedgersTable|\Cake\ORM\Association\BelongsTo $Ledgers
 * @property \App\Model\Table\AccountingEntriesTable|\Cake\ORM\Association\HasMany $AccountingEntries
 * @property \App\Model\Table\ReferenceDetailsTable|\Cake\ORM\Association\HasMany $ReferenceDetails
 *
 * @method \App\Model\Entity\PurchaseVoucherRow get($primaryKey, $options = [])
 * @method \App\Model\Entity\PurchaseVoucherRow newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PurchaseVoucherRow[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PurchaseVoucherRow|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PurchaseVoucherRow patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PurchaseVoucherRow[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PurchaseVoucherRow findOrCreate($search, callable $callback = null, $options = [])
 */
class PurchaseVoucherRowsTable extends Table
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

        $this->setTable('purchase_voucher_rows');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('PurchaseVouchers', [
            'foreignKey' => 'purchase_voucher_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Ledgers', [
            'foreignKey' => 'ledger_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('AccountingEntries', [
            'foreignKey' => 'purchase_voucher_row_id'
        ]);
        $this->hasMany('ReferenceDetails', [
            'foreignKey' => 'purchase_voucher_row_id'
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
            ->scalar('cr_dr')
            ->maxLength('cr_dr', 10)
            ->requirePresence('cr_dr', 'create')
            ->notEmpty('cr_dr');

        $validator
            ->decimal('debit')
            ->allowEmpty('debit');

        $validator
            ->decimal('credit')
            ->allowEmpty('credit');

        /* $validator
            ->scalar('mode_of_payment')
            ->maxLength('mode_of_payment', 30)
            ->requirePresence('mode_of_payment', 'create')
            ->notEmpty('mode_of_payment');

        $validator
            ->scalar('cheque_no')
            ->maxLength('cheque_no', 255)
            ->requirePresence('cheque_no', 'create')
            ->notEmpty('cheque_no');

        $validator
            ->date('cheque_date')
            ->allowEmpty('cheque_date'); */

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
        $rules->add($rules->existsIn(['purchase_voucher_id'], 'PurchaseVouchers'));
        $rules->add($rules->existsIn(['ledger_id'], 'Ledgers'));

        return $rules;
    }
}
