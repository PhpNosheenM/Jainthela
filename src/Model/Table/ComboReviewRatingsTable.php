<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ComboReviewRatings Model
 *
 * @property \App\Model\Table\ComboOffersTable|\Cake\ORM\Association\BelongsTo $ComboOffers
 *
 * @method \App\Model\Entity\ComboReviewRating get($primaryKey, $options = [])
 * @method \App\Model\Entity\ComboReviewRating newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ComboReviewRating[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ComboReviewRating|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ComboReviewRating patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ComboReviewRating[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ComboReviewRating findOrCreate($search, callable $callback = null, $options = [])
 */
class ComboReviewRatingsTable extends Table
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

        $this->setTable('combo_review_ratings');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('ComboOffers', [
            'foreignKey' => 'combo_offer_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Customers');
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
            ->decimal('rating')
            ->requirePresence('rating', 'create')
            ->notEmpty('rating');

        $validator
            ->scalar('comment')
            ->requirePresence('comment', 'create')
            ->notEmpty('comment');

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

        return $rules;
    }
}
