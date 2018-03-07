<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Units Model
 *
 * @property \App\Model\Table\ComboOfferDetailsTable|\Cake\ORM\Association\HasMany $ComboOfferDetails
 * @property \App\Model\Table\ItemVariationsTable|\Cake\ORM\Association\HasMany $ItemVariations
 *
 * @method \App\Model\Entity\Unit get($primaryKey, $options = [])
 * @method \App\Model\Entity\Unit newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Unit[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Unit|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Unit patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Unit[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Unit findOrCreate($search, callable $callback = null, $options = [])
 */
class UnitsTable extends Table
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

        $this->setTable('units');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->hasMany('ComboOfferDetails', [
            'foreignKey' => 'unit_id'
        ]);
        $this->hasMany('ItemVariations', [
            'foreignKey' => 'unit_id'
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
            ->scalar('longname')
            ->maxLength('longname', 100)
            ->requirePresence('longname', 'create')
            ->notEmpty('longname');

        $validator
            ->scalar('shortname')
            ->maxLength('shortname', 50)
            ->requirePresence('shortname', 'create')
            ->notEmpty('shortname');

        $validator
            ->scalar('unit_name')
            ->maxLength('unit_name', 50)
            ->requirePresence('unit_name', 'create')
            ->notEmpty('unit_name');

        $validator
            ->integer('created_by')
            ->requirePresence('created_by', 'create')
            ->notEmpty('created_by');

        $validator
            ->dateTime('created_on')
            ->requirePresence('created_on', 'create')
            ->notEmpty('created_on');

        $validator
            ->requirePresence('status', 'create')
            ->notEmpty('status');

        return $validator;
    }
}
