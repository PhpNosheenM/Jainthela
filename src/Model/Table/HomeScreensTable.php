<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * HomeScreens Model
 *
 * @property \App\Model\Table\CategoriesTable|\Cake\ORM\Association\BelongsTo $Categories
 *
 * @method \App\Model\Entity\HomeScreen get($primaryKey, $options = [])
 * @method \App\Model\Entity\HomeScreen newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\HomeScreen[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\HomeScreen|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\HomeScreen patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\HomeScreen[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\HomeScreen findOrCreate($search, callable $callback = null, $options = [])
 */
class HomeScreensTable extends Table
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

        $this->setTable('home_screens');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');
        $this->belongsTo('Carts');
        $this->belongsTo('Banners');
		$this->belongsTo('Brands');
		$this->belongsTo('ApiVersions');
		$this->belongsTo('ExpressDeliveries');
		$this->belongsTo('ComboOffers');
		
        $this->belongsTo('Categories', [
            'foreignKey' => 'category_id',
            'joinType' => 'INNER'
        ]);
		
		$this->hasMany('SellerItems', [
			'foreignKey' => 'category_id'
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
            ->scalar('title')
            ->maxLength('title', 200)
            ->requirePresence('title', 'create')
            ->notEmpty('title');

        $validator
            ->scalar('layout')
            ->maxLength('layout', 50)
            ->requirePresence('layout', 'create')
            ->notEmpty('layout');

        $validator
            ->scalar('section_show')
            ->maxLength('section_show', 10)
            ->requirePresence('section_show', 'create')
            ->notEmpty('section_show');

        $validator
            ->integer('preference')
            ->requirePresence('preference', 'create')
            ->notEmpty('preference');

        $validator
            ->scalar('screen_type')
            ->maxLength('screen_type', 15)
            ->requirePresence('screen_type', 'create')
            ->notEmpty('screen_type');

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

        return $rules;
    }
}
