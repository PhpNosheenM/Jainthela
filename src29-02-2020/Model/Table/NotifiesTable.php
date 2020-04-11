<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Notifies Model
 *
 * @property \App\Model\Table\CustomersTable|\Cake\ORM\Association\BelongsTo $Customers
 * @property \App\Model\Table\ItemVariationsTable|\Cake\ORM\Association\BelongsTo $ItemVariations
 * @property |\Cake\ORM\Association\BelongsTo $Items
 * @property |\Cake\ORM\Association\BelongsTo $ComboOffers
 *
 * @method \App\Model\Entity\Notify get($primaryKey, $options = [])
 * @method \App\Model\Entity\Notify newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Notify[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Notify|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Notify patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Notify[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Notify findOrCreate($search, callable $callback = null, $options = [])
 */
class NotifiesTable extends Table
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

        $this->setTable('notifies');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Customers', [
            'foreignKey' => 'customer_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('ItemVariations', [
            'foreignKey' => 'item_variation_id',
            'joinType' => 'LEFT'
        ]);
        $this->belongsTo('Items', [
            'foreignKey' => 'item_id',
            'joinType' => 'LEFT'
        ]);
        $this->belongsTo('ComboOffers', [
            'foreignKey' => 'combo_offer_id',
            'joinType' => 'LEFT'
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
        $rules->add($rules->existsIn(['customer_id'], 'Customers'));
        //$rules->add($rules->existsIn(['item_variation_id'], 'ItemVariations'));
        //$rules->add($rules->existsIn(['item_id'], 'Items'));
        //$rules->add($rules->existsIn(['combo_offer_id'], 'ComboOffers'));

        return $rules;
    }
}
