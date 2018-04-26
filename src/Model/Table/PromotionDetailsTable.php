<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PromotionDetails Model
 *
 * @property \App\Model\Table\PromotionsTable|\Cake\ORM\Association\BelongsTo $Promotions
 * @property \App\Model\Table\CategoriesTable|\Cake\ORM\Association\BelongsTo $Categories
 * @property \App\Model\Table\ItemsTable|\Cake\ORM\Association\BelongsTo $Items
 * @property \App\Model\Table\GetItemsTable|\Cake\ORM\Association\BelongsTo $GetItems
 * @property \App\Model\Table\OrdersTable|\Cake\ORM\Association\HasMany $Orders
 *
 * @method \App\Model\Entity\PromotionDetail get($primaryKey, $options = [])
 * @method \App\Model\Entity\PromotionDetail newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PromotionDetail[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PromotionDetail|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PromotionDetail patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PromotionDetail[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PromotionDetail findOrCreate($search, callable $callback = null, $options = [])
 */
class PromotionDetailsTable extends Table
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

        $this->setTable('promotion_details');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Promotions', [
            'foreignKey' => 'promotion_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Categories', [
            'foreignKey' => 'category_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Items', [
            'foreignKey' => 'item_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('GetItems', [
            'foreignKey' => 'get_item_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Orders', [
            'foreignKey' => 'promotion_detail_id'
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
            ->decimal('discount_in_percentage')
            ->requirePresence('discount_in_percentage', 'create')
            ->notEmpty('discount_in_percentage');

        $validator
            ->decimal('discount_in_amount')
            ->requirePresence('discount_in_amount', 'create')
            ->notEmpty('discount_in_amount');

        $validator
            ->decimal('discount_of_max_amount')
            ->requirePresence('discount_of_max_amount', 'create')
            ->notEmpty('discount_of_max_amount');

        $validator
            ->scalar('coupan_name')
            ->maxLength('coupan_name', 100)
            ->requirePresence('coupan_name', 'create')
            ->notEmpty('coupan_name');

        $validator
            ->integer('coupan_code')
            ->requirePresence('coupan_code', 'create')
            ->notEmpty('coupan_code');

        $validator
            ->decimal('buy_quntity')
            ->requirePresence('buy_quntity', 'create')
            ->notEmpty('buy_quntity');

        $validator
            ->decimal('get_quntity')
            ->requirePresence('get_quntity', 'create')
            ->notEmpty('get_quntity');

        $validator
            ->scalar('in_wallet')
            ->maxLength('in_wallet', 10)
            ->requirePresence('in_wallet', 'create')
            ->notEmpty('in_wallet');

        $validator
            ->scalar('is_free_shipping')
            ->maxLength('is_free_shipping', 10)
            ->requirePresence('is_free_shipping', 'create')
            ->notEmpty('is_free_shipping');

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
        $rules->add($rules->existsIn(['promotion_id'], 'Promotions'));
        $rules->add($rules->existsIn(['category_id'], 'Categories'));
        $rules->add($rules->existsIn(['item_id'], 'Items'));
        $rules->add($rules->existsIn(['get_item_id'], 'GetItems'));

        return $rules;
    }
}
