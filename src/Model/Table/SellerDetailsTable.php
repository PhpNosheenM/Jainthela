<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SellerDetails Model
 *
 * @property \App\Model\Table\SellersTable|\Cake\ORM\Association\BelongsTo $Sellers
 *
 * @method \App\Model\Entity\SellerDetail get($primaryKey, $options = [])
 * @method \App\Model\Entity\SellerDetail newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\SellerDetail[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SellerDetail|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SellerDetail patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\SellerDetail[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\SellerDetail findOrCreate($search, callable $callback = null, $options = [])
 */
class SellerDetailsTable extends Table
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

        $this->setTable('seller_details');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Sellers', [
            'foreignKey' => 'seller_id',
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

        $validator
            ->scalar('contact_no')
            ->maxLength('contact_no', 200)
            ->requirePresence('contact_no', 'create')
            ->notEmpty('contact_no');
/* 
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
        $rules->add($rules->existsIn(['seller_id'], 'Sellers'));

        return $rules;
    }
}
