<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * BulkBookingLeads Model
 *
 * @property \App\Model\Table\CitiesTable|\Cake\ORM\Association\BelongsTo $Cities
 * @property \App\Model\Table\CustomersTable|\Cake\ORM\Association\BelongsTo $Customers
 * @property \App\Model\Table\BulkBookingLeadRowsTable|\Cake\ORM\Association\HasMany $BulkBookingLeadRows
 *
 * @method \App\Model\Entity\BulkBookingLead get($primaryKey, $options = [])
 * @method \App\Model\Entity\BulkBookingLead newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\BulkBookingLead[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\BulkBookingLead|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\BulkBookingLead patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\BulkBookingLead[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\BulkBookingLead findOrCreate($search, callable $callback = null, $options = [])
 */
class BulkBookingLeadsTable extends Table
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

        $this->setTable('bulk_booking_leads');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Cities', [
            'foreignKey' => 'city_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Customers', [
            'foreignKey' => 'customer_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('BulkBookingLeadRows', [
            'foreignKey' => 'bulk_booking_lead_id'
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
/* 
        $validator
            ->integer('lead_no')
            ->requirePresence('lead_no', 'create')
            ->notEmpty('lead_no'); */

        $validator
            ->scalar('name')
            ->maxLength('name', 50)
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->scalar('mobile')
            ->maxLength('mobile', 20)
            ->requirePresence('mobile', 'create')
            ->notEmpty('mobile');

        $validator
            ->scalar('lead_description')
            ->requirePresence('lead_description', 'create')
            ->notEmpty('lead_description');

        $validator
            ->date('delivery_date')
            ->requirePresence('delivery_date', 'create')
            ->notEmpty('delivery_date');

        $validator
            ->scalar('delivery_time')
            ->maxLength('delivery_time', 20)
            ->requirePresence('delivery_time', 'create')
            ->notEmpty('delivery_time');

       /*  $validator
            ->dateTime('created_on')
            ->requirePresence('created_on', 'create')
            ->notEmpty('created_on');

        $validator
            ->scalar('status')
            ->maxLength('status', 10)
            ->requirePresence('status', 'create')
            ->notEmpty('status');

        $validator
            ->scalar('reason')
            ->requirePresence('reason', 'create')
            ->notEmpty('reason'); */

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
        $rules->add($rules->existsIn(['city_id'], 'Cities'));
        $rules->add($rules->existsIn(['customer_id'], 'Customers'));

        return $rules;
    }
}
