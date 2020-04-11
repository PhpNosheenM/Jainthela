<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * BulkOrderPerformaRows Model
 *
 * @property \App\Model\Table\BulkOrderPerformasTable|\Cake\ORM\Association\BelongsTo $BulkOrderPerformas
 * @property \App\Model\Table\CategoriesTable|\Cake\ORM\Association\BelongsTo $Categories
 * @property \App\Model\Table\BrandsTable|\Cake\ORM\Association\BelongsTo $Brands
 * @property \App\Model\Table\ItemsTable|\Cake\ORM\Association\BelongsTo $Items
 *
 * @method \App\Model\Entity\BulkOrderPerformaRow get($primaryKey, $options = [])
 * @method \App\Model\Entity\BulkOrderPerformaRow newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\BulkOrderPerformaRow[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\BulkOrderPerformaRow|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\BulkOrderPerformaRow patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\BulkOrderPerformaRow[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\BulkOrderPerformaRow findOrCreate($search, callable $callback = null, $options = [])
 */
class BulkOrderPerformaRowsTable extends Table
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

        $this->setTable('bulk_order_performa_rows');
		$this->setPrimaryKey('id');

        $this->belongsTo('BulkOrderPerformas', [
            'foreignKey' => 'bulk_order_performa_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Categories', [
            'foreignKey' => 'category_id'
        ]);
        $this->belongsTo('Brands', [
            'foreignKey' => 'brand_id'
        ]);
        $this->belongsTo('Items', [
            'foreignKey' => 'item_id',
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
            ->requirePresence('id', 'create')
            ->notEmpty('id');

        $validator
            ->integer('quantity')
            ->requirePresence('quantity', 'create')
            ->notEmpty('quantity');

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
        $rules->add($rules->existsIn(['bulk_order_performa_id'], 'BulkOrderPerformas'));
       // $rules->add($rules->existsIn(['category_id'], 'Categories'));
       // $rules->add($rules->existsIn(['brand_id'], 'Brands'));
        $rules->add($rules->existsIn(['item_id'], 'Items'));

        return $rules;
    }
}
