<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * WishListItems Model
 *
 * @property \App\Model\Table\WishListsTable|\Cake\ORM\Association\BelongsTo $WishLists
 * @property \App\Model\Table\ItemsTable|\Cake\ORM\Association\BelongsTo $Items
 * @property \App\Model\Table\ItemVariationsTable|\Cake\ORM\Association\BelongsTo $ItemVariations
 *
 * @method \App\Model\Entity\WishListItem get($primaryKey, $options = [])
 * @method \App\Model\Entity\WishListItem newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\WishListItem[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\WishListItem|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\WishListItem patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\WishListItem[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\WishListItem findOrCreate($search, callable $callback = null, $options = [])
 */
class WishListItemsTable extends Table
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

        $this->setTable('wish_list_items');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('WishLists', [
            'foreignKey' => 'wish_list_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Items', [
            'foreignKey' => 'item_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('ItemVariations', [
            'foreignKey' => 'item_variation_id',
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
        $rules->add($rules->existsIn(['wish_list_id'], 'WishLists'));
    //    $rules->add($rules->existsIn(['item_id'], 'Items'));
    //    $rules->add($rules->existsIn(['item_variation_id'], 'ItemVariations'));

        return $rules;
    }
}
