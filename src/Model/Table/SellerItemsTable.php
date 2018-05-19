<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SellerItems Model
 *
 * @property \App\Model\Table\ItemsTable|\Cake\ORM\Association\BelongsTo $Items
 * @property \App\Model\Table\CategoriesTable|\Cake\ORM\Association\BelongsTo $Categories
 * @property \App\Model\Table\SellersTable|\Cake\ORM\Association\BelongsTo $Sellers
 * @property \App\Model\Table\SellerItemVariationsTable|\Cake\ORM\Association\HasMany $SellerItemVariations
 *
 * @method \App\Model\Entity\SellerItem get($primaryKey, $options = [])
 * @method \App\Model\Entity\SellerItem newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\SellerItem[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SellerItem|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SellerItem patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\SellerItem[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\SellerItem findOrCreate($search, callable $callback = null, $options = [])
 */
class SellerItemsTable extends Table
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

        $this->setTable('seller_items');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Items', [
            'foreignKey' => 'item_id',
            'joinType' => 'INNER'
        ]);
		
        //$this->belongsTo('ItemVariations');
        $this->belongsTo('ItemVariationMasters');

		$this->belongsTo('Brands');
		$this->belongsTo('Cities');
		
        $this->belongsTo('Categories', [
            'foreignKey' => 'category_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Sellers', [
            'foreignKey' => 'seller_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('SellerItemVariations', [
            'foreignKey' => 'seller_item_id'
        ]);
		$this->hasMany('ItemVariations', [
            'foreignKey' => 'seller_item_id'
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

       /*  $validator
            ->dateTime('created_on')
            ->requirePresence('created_on', 'create')
            ->notEmpty('created_on');

        $validator
            ->integer('created_by')
            ->requirePresence('created_by', 'create')
            ->notEmpty('created_by');

        $validator
            ->decimal('commission_percentage')
            ->requirePresence('commission_percentage', 'create')
            ->notEmpty('commission_percentage');
 */
       /*  $validator
            ->dateTime('commission_created_on')
            ->requirePresence('commission_created_on', 'create')
            ->notEmpty('commission_created_on');

        $validator
            ->dateTime('expiry_on_date')
            ->requirePresence('expiry_on_date', 'create')
            ->notEmpty('expiry_on_date');

        $validator
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
        $rules->add($rules->existsIn(['item_id'], 'Items'));
        $rules->add($rules->existsIn(['category_id'], 'Categories'));
        $rules->add($rules->existsIn(['seller_id'], 'Sellers'));

        return $rules;
    }
	/* public function beforeSave($event, $entity, $options)
	{exit;
		if ($entity->tag_string) {
			$entity->tags = $this->_buildTags($entity->tag_string);
		}
	} */
}
