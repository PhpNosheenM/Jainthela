<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AppMenus Model
 *
 * @property \App\Model\Table\CitiesTable|\Cake\ORM\Association\BelongsTo $Cities
 * @property \App\Model\Table\AppMenusTable|\Cake\ORM\Association\BelongsTo $ParentAppMenus
 * @property \App\Model\Table\AppMenusTable|\Cake\ORM\Association\HasMany $ChildAppMenus
 *
 * @method \App\Model\Entity\AppMenu get($primaryKey, $options = [])
 * @method \App\Model\Entity\AppMenu newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\AppMenu[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AppMenu|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AppMenu patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\AppMenu[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\AppMenu findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TreeBehavior
 */
class AppMenusTable extends Table
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

        $this->setTable('app_menus');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Tree');

        $this->belongsTo('Cities', [
            'foreignKey' => 'city_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('ParentAppMenus', [
            'className' => 'AppMenus',
            'foreignKey' => 'parent_id'
        ]);
        $this->hasMany('ChildAppMenus', [
            'className' => 'AppMenus',
            'foreignKey' => 'parent_id'
        ]);
		
		 $this->belongsTo('Categories');
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
            ->requirePresence('status', 'create')
            ->notEmpty('status');

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
        $rules->add($rules->existsIn(['parent_id'], 'ParentAppMenus'));

        return $rules;
    }
}
