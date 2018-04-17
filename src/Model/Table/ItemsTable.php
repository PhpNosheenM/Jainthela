<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Items Model
 *
 * @property \App\Model\Table\CategoriesTable|\Cake\ORM\Association\BelongsTo $Categories
 * @property \App\Model\Table\BrandsTable|\Cake\ORM\Association\BelongsTo $Brands
 * @property \App\Model\Table\AdminsTable|\Cake\ORM\Association\BelongsTo $Admins
 * @property \App\Model\Table\SellersTable|\Cake\ORM\Association\BelongsTo $Sellers
 * @property \App\Model\Table\CitiesTable|\Cake\ORM\Association\BelongsTo $Cities
 * @property \App\Model\Table\AppNotificationsTable|\Cake\ORM\Association\HasMany $AppNotifications
 * @property \App\Model\Table\CartsTable|\Cake\ORM\Association\HasMany $Carts
 * @property \App\Model\Table\ComboOfferDetailsTable|\Cake\ORM\Association\HasMany $ComboOfferDetails
 * @property \App\Model\Table\GrnRowsTable|\Cake\ORM\Association\HasMany $GrnRows
 * @property \App\Model\Table\ItemVariationsTable|\Cake\ORM\Association\HasMany $ItemVariations
 * @property \App\Model\Table\PromotionDetailsTable|\Cake\ORM\Association\HasMany $PromotionDetails
 * @property \App\Model\Table\PurchaseInvoiceRowsTable|\Cake\ORM\Association\HasMany $PurchaseInvoiceRows
 * @property \App\Model\Table\PurchaseReturnRowsTable|\Cake\ORM\Association\HasMany $PurchaseReturnRows
 * @property \App\Model\Table\SaleReturnRowsTable|\Cake\ORM\Association\HasMany $SaleReturnRows
 * @property \App\Model\Table\SalesInvoiceRowsTable|\Cake\ORM\Association\HasMany $SalesInvoiceRows
 * @property \App\Model\Table\SellerItemsTable|\Cake\ORM\Association\HasMany $SellerItems
 *
 * @method \App\Model\Entity\Item get($primaryKey, $options = [])
 * @method \App\Model\Entity\Item newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Item[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Item|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Item patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Item[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Item findOrCreate($search, callable $callback = null, $options = [])
 */
class ItemsTable extends Table
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

        $this->setTable('items');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

          $this->belongsTo('Filters');

        $this->belongsTo('Categories', [
            'foreignKey' => 'category_id',
            'joinType' => 'INNER'
        ])->setConditions(['Categories.status' => 'Active']);

		$this->belongsTo('GstFigures', [
            'foreignKey' => 'gst_figure_id',
            'joinType' => 'INNER'
        ]);

        $this->belongsTo('Brands', [
            'foreignKey' => 'brand_id',
            'joinType' => 'Left'
        ]);

        $this->belongsTo('Admins', [
            'foreignKey' => 'admin_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Sellers', [
            'foreignKey' => 'seller_id',
            'joinType' => 'INNER'
        ]);

        $this->belongsTo('Locations', [
            'foreignKey' => 'location_id',
            'joinType' => 'INNER'
        ]);
		$this->belongsTo('ItemLedgers', [
            'foreignKey' => 'item_id',
            'joinType' => 'INNER'
        ]);
		$this->belongsTo('Cities', [
            'foreignKey' => 'city_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('AppNotifications', [
            'foreignKey' => 'item_id'
        ]);
        $this->hasMany('Carts', [
            'foreignKey' => 'item_id'
        ]);
        $this->hasMany('ComboOfferDetails', [
            'foreignKey' => 'item_id'
        ]);
        $this->hasMany('GrnRows', [
            'foreignKey' => 'item_id'
        ]);
		 $this->belongsToMany('UnitVariations', [
            'foreignKey' => 'item_id',
			'targetForeignKey'=>'unit_variation_id',
            'joinTable' => 'item_variation_masters'
        ])->setConditions(['UnitVariations.status' => 'Active']);
        $this->hasMany('ItemVariationMasters', [
            'foreignKey' => 'item_id',
			       'saveStrategy'=>'replace'
        ]);

		 $this->hasMany('ItemVariations', [
            'foreignKey' => 'item_id',
			'saveStrategy'=>'replace'
        ]);

		$this->hasMany('PromotionDetails', [
            'foreignKey' => 'item_id'
        ]);
        $this->hasMany('PurchaseInvoiceRows', [
            'foreignKey' => 'item_id'
        ]);
        $this->hasMany('PurchaseReturnRows', [
            'foreignKey' => 'item_id'
        ]);
        $this->hasMany('SaleReturnRows', [
            'foreignKey' => 'item_id'
        ]);
        $this->hasMany('SalesInvoiceRows', [
            'foreignKey' => 'item_id'
        ]);
     /*    $this->hasMany('SellerItems', [
            'foreignKey' => 'item_id'
        ]); */
		$this->hasMany('SellerItems')
            ->setForeignKey('item_id')
            ->setJoinType('INNER');

        $this->hasMany('LeftItemReviewRatings', [
            'className'  =>'ItemReviewRatings',
            'foreignKey' => 'item_id',
            'joinType' => 'Left'
        ])->setConditions(['LeftItemReviewRatings.status'=>'0']);

        $this->hasMany('AverageReviewRatings', [
            'className'  =>'ItemReviewRatings',
            'foreignKey' => 'item_id',
            'joinType' => 'Left'
        ])->setConditions(['AverageReviewRatings.status'=>'0']);

        $this->hasMany('ItemReviewRatings', [
              'foreignKey' => 'item_id'
        ])->setConditions(['ItemReviewRatings.status'=>'0']);

		  $this->hasMany('ItemsVariations', [
            'className' => 'ItemVariations',
			      'foreignKey' => 'item_id'
        ])->setConditions(['ItemsVariations.section_show'=>'Yes']);

        // HomeScreen Model used in Item (product detail) api

        $this->belongsTo('WishLists', [
            'foreignKey' => 'item_id',
            'joinType' => 'INNER'
        ]);

		    $this->belongsTo('WishListItems', [
            'foreignKey' => 'item_id',
            'joinType' => 'INNER'
        ]);

        $this->belongsTo('HomeScreens');

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
		/*
        $validator
            ->scalar('name')
            ->maxLength('name', 50)
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->scalar('description')
            ->requirePresence('description', 'create')
            ->notEmpty('description');

        $validator
            ->decimal('minimum_stock')
            ->requirePresence('minimum_stock', 'create')
            ->notEmpty('minimum_stock');

        $validator
            ->decimal('next_day_requirement')
            ->requirePresence('next_day_requirement', 'create')
            ->notEmpty('next_day_requirement');

        $validator
            ->scalar('request_for_sample')
            ->maxLength('request_for_sample', 10)
            ->requirePresence('request_for_sample', 'create')
            ->notEmpty('request_for_sample');

        $validator
            ->scalar('default_grade')
            ->maxLength('default_grade', 20)
            ->requirePresence('default_grade', 'create')
            ->notEmpty('default_grade');

        $validator
            ->decimal('tax')
            ->requirePresence('tax', 'create')
            ->notEmpty('tax');

        $validator
            ->dateTime('created_on')
            ->requirePresence('created_on', 'create')
            ->notEmpty('created_on');

        $validator
            ->dateTime('edited_on')
            ->requirePresence('edited_on', 'create')
            ->notEmpty('edited_on');

        $validator
            ->scalar('approve')
            ->maxLength('approve', 15)
            ->requirePresence('approve', 'create')
            ->notEmpty('approve');

        $validator
            ->scalar('status')
            ->maxLength('status', 10)
            ->requirePresence('status', 'create')
            ->notEmpty('status');

        $validator
            ->scalar('app_image')
            ->maxLength('app_image', 50)
            ->requirePresence('app_image', 'create')
            ->notEmpty('app_image');

        $validator
            ->scalar('web_image')
            ->maxLength('web_image', 50)
            ->requirePresence('web_image', 'create')
            ->notEmpty('web_image');

        $validator
            ->scalar('alias_name')
            ->maxLength('alias_name', 50)
            ->requirePresence('alias_name', 'create')
            ->notEmpty('alias_name');

        $validator
            ->scalar('out_of_stock')
            ->maxLength('out_of_stock', 3)
            ->requirePresence('out_of_stock', 'create')
            ->notEmpty('out_of_stock');

        $validator
            ->scalar('ready_to_sale')
            ->maxLength('ready_to_sale', 5)
            ->requirePresence('ready_to_sale', 'create')
            ->notEmpty('ready_to_sale');

		*/
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
        $rules->add($rules->existsIn(['category_id'], 'Categories'));
       // $rules->add($rules->existsIn(['brand_id'], 'Brands'));
        //$rules->add($rules->existsIn(['admin_id'], 'Admins'));
       // $rules->add($rules->existsIn(['seller_id'], 'Sellers'));
        $rules->add($rules->existsIn(['city_id'], 'Cities'));

        return $rules;
    }
}
