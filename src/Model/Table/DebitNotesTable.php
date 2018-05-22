<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DebitNotes Model
 *
 * @property \App\Model\Table\LocationsTable|\Cake\ORM\Association\BelongsTo $Locations
 * @property \App\Model\Table\CitiesTable|\Cake\ORM\Association\BelongsTo $Cities
 * @property \App\Model\Table\AccountingEntriesTable|\Cake\ORM\Association\HasMany $AccountingEntries
 * @property \App\Model\Table\DebitNoteRowsTable|\Cake\ORM\Association\HasMany $DebitNoteRows
 * @property \App\Model\Table\ReferenceDetailsTable|\Cake\ORM\Association\HasMany $ReferenceDetails
 *
 * @method \App\Model\Entity\DebitNote get($primaryKey, $options = [])
 * @method \App\Model\Entity\DebitNote newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\DebitNote[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DebitNote|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DebitNote patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DebitNote[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\DebitNote findOrCreate($search, callable $callback = null, $options = [])
 */
class DebitNotesTable extends Table
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

        $this->setTable('debit_notes');
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
        $this->hasMany('AccountingEntries', [
            'foreignKey' => 'debit_note_id'
        ]);
        $this->hasMany('DebitNoteRows', [
            'foreignKey' => 'debit_note_id'
        ]);
        $this->hasMany('ReferenceDetails', [
            'foreignKey' => 'debit_note_id'
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
            ->decimal('total_credit_amount')
            ->requirePresence('total_credit_amount', 'create')
            ->notEmpty('total_credit_amount');

        $validator
            ->decimal('total_debit_amount')
            ->requirePresence('total_debit_amount', 'create')
            ->notEmpty('total_debit_amount');

        $validator
            ->date('transaction_date')
            ->requirePresence('transaction_date', 'create')
            ->notEmpty('transaction_date');

        $validator
            ->scalar('narration')
            ->requirePresence('narration', 'create')
            ->notEmpty('narration');
/* 
        $validator
            ->scalar('status')
            ->maxLength('status', 10)
            ->requirePresence('status', 'create')
            ->notEmpty('status'); */

        $validator
            ->integer('created_by')
            ->requirePresence('created_by', 'create')
            ->notEmpty('created_by');

   /*      $validator
            ->dateTime('created_on')
            ->requirePresence('created_on', 'create')
            ->notEmpty('created_on'); */

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
        $rules->add($rules->existsIn(['location_id'], 'Locations'));
        $rules->add($rules->existsIn(['city_id'], 'Cities'));

        return $rules;
    }
}
