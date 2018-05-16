<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ItemVariationMasters Model
 *
 * @property \App\Model\Table\ItemsTable|\Cake\ORM\Association\BelongsTo $Items
 * @property \App\Model\Table\UnitVariationsTable|\Cake\ORM\Association\BelongsTo $UnitVariations
 *
 * @method \App\Model\Entity\ItemVariationMaster get($primaryKey, $options = [])
 * @method \App\Model\Entity\ItemVariationMaster newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ItemVariationMaster[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ItemVariationMaster|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ItemVariationMaster patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ItemVariationMaster[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ItemVariationMaster findOrCreate($search, callable $callback = null, $options = [])
 */
class ItemVariationMastersTable extends Table
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

        $this->setTable('item_variation_masters');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Items', [
            'foreignKey' => 'item_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('UnitVariations', [
            'foreignKey' => 'unit_variation_id',
            'joinType' => 'INNER'
        ]);
		$this->belongsTo('SellerItems', [
			'bindingKey'=>'item_id',
			'foreignKey'=>'item_id'
        ]);
		
		 $this->hasMany('ItemVariations', [
            'foreignKey' => 'item_variation_master_id',
			'saveStrategy' =>'replace'
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
            ->dateTime('created_on')
            ->requirePresence('created_on', 'create')
            ->notEmpty('created_on');

        $validator
            ->dateTime('edited_on')
            ->requirePresence('edited_on', 'create')
            ->notEmpty('edited_on');

        $validator
            ->integer('created_by')
            ->requirePresence('created_by', 'create')
            ->notEmpty('created_by');

        $validator
            ->integer('edited_by')
            ->requirePresence('edited_by', 'create')
            ->notEmpty('edited_by');

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
        $rules->add($rules->existsIn(['item_id'], 'Items'));
        $rules->add($rules->existsIn(['unit_variation_id'], 'UnitVariations'));

        return $rules;
    }
}
