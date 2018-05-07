<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * BulkBookingLeadRows Model
 *
 * @property \App\Model\Table\BulkBookingLeadsTable|\Cake\ORM\Association\BelongsTo $BulkBookingLeads
 *
 * @method \App\Model\Entity\BulkBookingLeadRow get($primaryKey, $options = [])
 * @method \App\Model\Entity\BulkBookingLeadRow newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\BulkBookingLeadRow[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\BulkBookingLeadRow|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\BulkBookingLeadRow patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\BulkBookingLeadRow[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\BulkBookingLeadRow findOrCreate($search, callable $callback = null, $options = [])
 */
class BulkBookingLeadRowsTable extends Table
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

        $this->setTable('bulk_booking_lead_rows');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('BulkBookingLeads', [
            'foreignKey' => 'bulk_booking_lead_id',
            'joinType' => 'INNER'
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
            //->scalar('image_name')
           // ->maxLength('image_name', 50)
            ->requirePresence('image_name', 'create')
            ->notEmpty('image_name');

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
        $rules->add($rules->existsIn(['bulk_booking_lead_id'], 'BulkBookingLeads'));

        return $rules;
    }
}
