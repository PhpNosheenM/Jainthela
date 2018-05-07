<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * VendorDetails Model
 *
 * @property \App\Model\Table\VendorsTable|\Cake\ORM\Association\BelongsTo $Vendors
 *
 * @method \App\Model\Entity\VendorDetail get($primaryKey, $options = [])
 * @method \App\Model\Entity\VendorDetail newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\VendorDetail[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\VendorDetail|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\VendorDetail patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\VendorDetail[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\VendorDetail findOrCreate($search, callable $callback = null, $options = [])
 */
class VendorDetailsTable extends Table
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

        $this->setTable('vendor_details');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Vendors', [
            'foreignKey' => 'vendor_id',
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
            ->scalar('contact_person')
            ->maxLength('contact_person', 200)
            ->requirePresence('contact_person', 'create')
            ->notEmpty('contact_person');

      /*   $validator
            ->scalar('contact_no')
            ->maxLength('contact_no', 10)
            ->requirePresence('contact_no', 'create')
            ->notEmpty('contact_no');

        $validator
            ->scalar('contact_email')
            ->maxLength('contact_email', 200)
            ->requirePresence('contact_email', 'create')
            ->notEmpty('contact_email'); */

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
        $rules->add($rules->existsIn(['vendor_id'], 'Vendors'));

        return $rules;
    }
}
