<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CancelReasons Model
 *
 * @property \App\Model\Table\OrdersTable|\Cake\ORM\Association\HasMany $Orders
 *
 * @method \App\Model\Entity\CancelReason get($primaryKey, $options = [])
 * @method \App\Model\Entity\CancelReason newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CancelReason[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CancelReason|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CancelReason patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CancelReason[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CancelReason findOrCreate($search, callable $callback = null, $options = [])
 */
class CancelReasonsTable extends Table
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

        $this->setTable('cancel_reasons');
        $this->setDisplayField('reason');
        $this->setPrimaryKey('id');

        $this->hasMany('Orders', [
            'foreignKey' => 'cancel_reason_id'
        ]);
		
		$this->belongsTo('Cities');
		
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
            ->scalar('reason')
            ->requirePresence('reason', 'create')
            ->notEmpty('reason');
/* 
        $validator
            ->dateTime('created_on')
            ->requirePresence('created_on', 'create')
            ->notEmpty('created_on');

        $validator
            ->integer('created_by')
            ->requirePresence('created_by', 'create')
            ->notEmpty('created_by'); */

        return $validator;
    }
}
