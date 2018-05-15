<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AccountingGroups Model
 *
 * @property \App\Model\Table\NatureOfGroupsTable|\Cake\ORM\Association\BelongsTo $NatureOfGroups
 * @property \App\Model\Table\AccountingGroupsTable|\Cake\ORM\Association\BelongsTo $ParentAccountingGroups
 * @property \App\Model\Table\LocationsTable|\Cake\ORM\Association\BelongsTo $Locations
 * @property \App\Model\Table\AccountingGroupsTable|\Cake\ORM\Association\HasMany $ChildAccountingGroups
 * @property \App\Model\Table\LedgersTable|\Cake\ORM\Association\HasMany $Ledgers
 *
 * @method \App\Model\Entity\AccountingGroup get($primaryKey, $options = [])
 * @method \App\Model\Entity\AccountingGroup newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\AccountingGroup[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AccountingGroup|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AccountingGroup patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\AccountingGroup[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\AccountingGroup findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TreeBehavior
 */
class AccountingGroupsTable extends Table
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

        $this->setTable('accounting_groups');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Tree');

        $this->belongsTo('NatureOfGroups', [
            'foreignKey' => 'nature_of_group_id'
        ]);
        $this->belongsTo('ParentAccountingGroups', [
            'className' => 'AccountingGroups',
            'foreignKey' => 'parent_id'
        ]);
        $this->belongsTo('Cities', [
            'foreignKey' => 'city_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('ChildAccountingGroups', [
            'className' => 'AccountingGroups',
            'foreignKey' => 'parent_id'
        ]);
        $this->hasMany('Ledgers', [
            'foreignKey' => 'accounting_group_id'
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
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->boolean('customer')
            ->allowEmpty('customer');

        $validator
            ->boolean('supplier')
            ->allowEmpty('supplier');

        $validator
            ->boolean('purchase_voucher_first_ledger')
            ->allowEmpty('purchase_voucher_first_ledger');

        $validator
            ->boolean('purchase_voucher_purchase_ledger')
            ->allowEmpty('purchase_voucher_purchase_ledger');

        $validator
            ->boolean('purchase_voucher_all_ledger')
            ->allowEmpty('purchase_voucher_all_ledger');

        $validator
            ->allowEmpty('sale_invoice_party');

        $validator
            ->allowEmpty('sale_invoice_sales_account');

        $validator
            ->integer('credit_note_party')
            ->allowEmpty('credit_note_party');

        $validator
            ->integer('credit_note_sales_account')
            ->allowEmpty('credit_note_sales_account');

       /*  $validator
            ->integer('bank')
            ->requirePresence('bank', 'create')
            ->notEmpty('bank'); */

        $validator
            ->boolean('cash')
            ->allowEmpty('cash');

        $validator
            ->boolean('purchase_invoice_purchase_account')
            ->allowEmpty('purchase_invoice_purchase_account');

        $validator
            ->boolean('purchase_invoice_party')
            ->allowEmpty('purchase_invoice_party');

        $validator
            ->boolean('receipt_ledger')
            ->allowEmpty('receipt_ledger');

        $validator
            ->boolean('payment_ledger')
            ->allowEmpty('payment_ledger');

        $validator
            ->boolean('credit_note_first_row')
            ->allowEmpty('credit_note_first_row');

        $validator
            ->boolean('credit_note_all_row')
            ->allowEmpty('credit_note_all_row');

        $validator
            ->boolean('debit_note_first_row')
            ->allowEmpty('debit_note_first_row');

        $validator
            ->boolean('debit_note_all_row')
            ->allowEmpty('debit_note_all_row');

        $validator
            ->boolean('sales_voucher_first_ledger')
            ->allowEmpty('sales_voucher_first_ledger');

        $validator
            ->boolean('sales_voucher_sales_ledger')
            ->allowEmpty('sales_voucher_sales_ledger');

        $validator
            ->boolean('sales_voucher_all_ledger')
            ->allowEmpty('sales_voucher_all_ledger');

        $validator
            ->boolean('journal_voucher_ledger')
            ->allowEmpty('journal_voucher_ledger');

        $validator
            ->boolean('contra_voucher_ledger')
            ->allowEmpty('contra_voucher_ledger');

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
        $rules->add($rules->existsIn(['nature_of_group_id'], 'NatureOfGroups'));
        $rules->add($rules->existsIn(['parent_id'], 'ParentAccountingGroups'));
       // $rules->add($rules->existsIn(['location_id'], 'Locations'));

        return $rules;
    }
}
