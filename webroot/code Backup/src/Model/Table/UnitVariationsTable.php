<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * UnitVariations Model
 *
 * @property \App\Model\Table\UnitsTable|\Cake\ORM\Association\BelongsTo $Units
 *
 * @method \App\Model\Entity\UnitVariation get($primaryKey, $options = [])
 * @method \App\Model\Entity\UnitVariation newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\UnitVariation[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\UnitVariation|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\UnitVariation patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\UnitVariation[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\UnitVariation findOrCreate($search, callable $callback = null, $options = [])
 */
class UnitVariationsTable extends Table
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

        $this->setTable('unit_variations');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Units', [
            'foreignKey' => 'unit_id',
            'joinType' => 'INNER'
        ])->setConditions(['Units.status' => 'Active']);
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
            ->integer('quantity_variation')
            ->requirePresence('quantity_variation', 'create')
            ->notEmpty('quantity_variation');

        $validator
            ->decimal('convert_unit_qty')
            ->requirePresence('convert_unit_qty', 'create')
            ->notEmpty('convert_unit_qty');

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
        $rules->add($rules->existsIn(['unit_id'], 'Units'));

        return $rules;
    }
}
