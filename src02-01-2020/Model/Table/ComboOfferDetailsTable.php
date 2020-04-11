<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ComboOfferDetails Model
 *
 * @property \App\Model\Table\ComboOffersTable|\Cake\ORM\Association\BelongsTo $ComboOffers
 * @property \App\Model\Table\ItemVariationsTable|\Cake\ORM\Association\BelongsTo $ItemVariations
 * @property \App\Model\Table\UnitsTable|\Cake\ORM\Association\BelongsTo $Units
 *
 * @method \App\Model\Entity\ComboOfferDetail get($primaryKey, $options = [])
 * @method \App\Model\Entity\ComboOfferDetail newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ComboOfferDetail[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ComboOfferDetail|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ComboOfferDetail patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ComboOfferDetail[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ComboOfferDetail findOrCreate($search, callable $callback = null, $options = [])
 */
class ComboOfferDetailsTable extends Table
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

        $this->setTable('combo_offer_details');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('ComboOffers', [
            'foreignKey' => 'combo_offer_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('ItemVariations', [
            'foreignKey' => 'item_variation_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Units', [
            'foreignKey' => 'unit_id',
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
		/*
        $validator
            ->decimal('quantity')
            ->requirePresence('quantity', 'create')
            ->notEmpty('quantity');

        $validator
            ->decimal('rate')
            ->requirePresence('rate', 'create')
            ->notEmpty('rate');

        $validator
            ->decimal('amount')
            ->requirePresence('amount', 'create')
            ->notEmpty('amount');
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
        $rules->add($rules->existsIn(['combo_offer_id'], 'ComboOffers'));
        $rules->add($rules->existsIn(['item_variation_id'], 'ItemVariations'));
        $rules->add($rules->existsIn(['unit_id'], 'Units'));

        return $rules;
    }
}
