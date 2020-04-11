<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Event\Event;
use ArrayObject;

/**
 * Promotions Model
 *
 * @property \App\Model\Table\AdminsTable|\Cake\ORM\Association\BelongsTo $Admins
 * @property \App\Model\Table\CitiesTable|\Cake\ORM\Association\BelongsTo $Cities
 * @property \App\Model\Table\PromotionDetailsTable|\Cake\ORM\Association\HasMany $PromotionDetails
 * @property \App\Model\Table\WalletsTable|\Cake\ORM\Association\HasMany $Wallets
 *
 * @method \App\Model\Entity\Promotion get($primaryKey, $options = [])
 * @method \App\Model\Entity\Promotion newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Promotion[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Promotion|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Promotion patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Promotion[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Promotion findOrCreate($search, callable $callback = null, $options = [])
 */
class PromotionsTable extends Table
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

        $this->setTable('promotions');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Admins', [
            'foreignKey' => 'admin_id',
            'joinType' => 'LEFT'
        ]);
        $this->belongsTo('Cities', [
            'foreignKey' => 'city_id',
            'joinType' => 'INNER'
        ]);

		$this->belongsTo('Carts');
		
		//$this->belongsTo('CustomerPromotions');
		
        $this->hasMany('PromotionDetails', [
            'foreignKey' => 'promotion_id',
			'dependent' => true,
			'cascadeCallbacks' => true,
			'saveStrategy' => 'replace'
        ]);

        $this->hasMany('CustomerPromotions', [
            'foreignKey' => 'promotion_id',
            'joinType' => 'LEFT'
        ]);
		
        $this->hasMany('Wallets', [
            'foreignKey' => 'promotion_id'
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
            ->scalar('offer_name')
            ->maxLength('offer_name', 100)
            ->requirePresence('offer_name', 'create')
            ->notEmpty('offer_name');

        

        return $validator;
    }
	
	public function beforeMarshal(Event $event, ArrayObject $data)
    {
        if(!empty($data['start_date']))
		{
			$data['start_date'] = date('Y-m-d',strtotime($data['start_date'])); 
		}
		if(!empty($data['end_date']))
		{
			$data['end_date'] = date('Y-m-d',strtotime($data['end_date'])); 
		}
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
        //$rules->add($rules->existsIn(['admin_id'], 'Admins'));
        $rules->add($rules->existsIn(['city_id'], 'Cities'));

        return $rules;
    }
}
