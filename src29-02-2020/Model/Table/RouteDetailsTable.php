<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RouteDetails Model
 *
 * @property \App\Model\Table\RoutesTable|\Cake\ORM\Association\BelongsTo $Routes
 * @property \App\Model\Table\LandmarksTable|\Cake\ORM\Association\BelongsTo $Landmarks
 *
 * @method \App\Model\Entity\RouteDetail get($primaryKey, $options = [])
 * @method \App\Model\Entity\RouteDetail newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\RouteDetail[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\RouteDetail|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RouteDetail patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\RouteDetail[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\RouteDetail findOrCreate($search, callable $callback = null, $options = [])
 */
class RouteDetailsTable extends Table
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

        $this->setTable('route_details');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Routes', [
            'foreignKey' => 'route_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Landmarks', [
            'foreignKey' => 'landmark_id',
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
            ->integer('priority')
            ->requirePresence('priority', 'create')
            ->notEmpty('priority');

      /*   $validator
            ->scalar('status')
            ->maxLength('status', 10)
            ->requirePresence('status', 'create')
            ->notEmpty('status'); */

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
        $rules->add($rules->existsIn(['route_id'], 'Routes'));
        $rules->add($rules->existsIn(['landmark_id'], 'Landmarks'));

        return $rules;
    }
}
