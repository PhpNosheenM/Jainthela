<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Admins Model
 *
 * @property \App\Model\Table\LocationsTable|\Cake\ORM\Association\BelongsTo $Locations
 * @property \App\Model\Table\RolesTable|\Cake\ORM\Association\BelongsTo $Roles
 * @property \App\Model\Table\ComboOffersTable|\Cake\ORM\Association\HasMany $ComboOffers
 * @property \App\Model\Table\FeedbacksTable|\Cake\ORM\Association\HasMany $Feedbacks
 * @property \App\Model\Table\ItemsTable|\Cake\ORM\Association\HasMany $Items
 * @property \App\Model\Table\PlansTable|\Cake\ORM\Association\HasMany $Plans
 * @property \App\Model\Table\PromotionsTable|\Cake\ORM\Association\HasMany $Promotions
 * @property \App\Model\Table\UnitsTable|\Cake\ORM\Association\HasMany $Units
 *
 * @method \App\Model\Entity\Admin get($primaryKey, $options = [])
 * @method \App\Model\Entity\Admin newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Admin[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Admin|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Admin patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Admin[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Admin findOrCreate($search, callable $callback = null, $options = [])
 */
class AdminsTable extends Table
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

        $this->setTable('admins');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Locations', [
            'foreignKey' => 'location_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Roles', [
            'foreignKey' => 'role_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('ComboOffers', [
            'foreignKey' => 'admin_id'
        ]);
        $this->hasMany('Feedbacks', [
            'foreignKey' => 'admin_id'
        ]);
        $this->hasMany('Items', [
            'foreignKey' => 'admin_id'
        ]);
        $this->hasMany('Plans', [
            'foreignKey' => 'admin_id'
        ]);
        $this->hasMany('Promotions', [
            'foreignKey' => 'admin_id'
        ]);
        $this->hasMany('Units', [
            'foreignKey' => 'admin_id'
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
            ->maxLength('name', 50)
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->scalar('username')
            ->maxLength('username', 100)
            ->requirePresence('username', 'create')
            ->notEmpty('username');

        $validator
            ->scalar('password')
            ->maxLength('password', 255)
            ->requirePresence('password', 'create')
            ->notEmpty('password');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmpty('email');

        $validator
            ->scalar('mobile_no')
            ->maxLength('mobile_no', 30)
            ->requirePresence('mobile_no', 'create')
            ->notEmpty('mobile_no');
/* 
        $validator
            ->dateTime('created_on')
            ->requirePresence('created_on', 'create')
            ->notEmpty('created_on');
 */
        $validator
            ->integer('created_by')
            ->requirePresence('created_by', 'create')
            ->notEmpty('created_by');
/* 
        $validator
            ->scalar('passkey')
            ->requirePresence('passkey', 'create')
            ->notEmpty('passkey');

        $validator
            ->requirePresence('timeout', 'create')
            ->notEmpty('timeout');
 */
        $validator
            ->requirePresence('status', 'create')
            ->notEmpty('status');

        return $validator;
    }
	public function findAuth(\Cake\ORM\Query $query, array $options)
	{
		$query
			->where(['Admins.status' => 'Active']);

		return $query;
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
        $rules->add($rules->isUnique(['username']));
        $rules->add($rules->isUnique(['email']));
        $rules->add($rules->existsIn(['location_id'], 'Locations'));
        $rules->add($rules->existsIn(['role_id'], 'Roles'));

        return $rules;
    }
}
