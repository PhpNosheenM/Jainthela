<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * InvoiceRows Model
 *
 * @property \App\Model\Table\InvoicesTable|\Cake\ORM\Association\BelongsTo $Invoices
 * @property \App\Model\Table\OrderDetailsTable|\Cake\ORM\Association\BelongsTo $OrderDetails
 * @property \App\Model\Table\ItemsTable|\Cake\ORM\Association\BelongsTo $Items
 * @property \App\Model\Table\ItemVariationsTable|\Cake\ORM\Association\BelongsTo $ItemVariations
 * @property \App\Model\Table\ComboOffersTable|\Cake\ORM\Association\BelongsTo $ComboOffers
 * @property \App\Model\Table\GstFiguresTable|\Cake\ORM\Association\BelongsTo $GstFigures
 *
 * @method \App\Model\Entity\InvoiceRow get($primaryKey, $options = [])
 * @method \App\Model\Entity\InvoiceRow newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\InvoiceRow[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\InvoiceRow|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\InvoiceRow patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\InvoiceRow[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\InvoiceRow findOrCreate($search, callable $callback = null, $options = [])
 */
class InvoiceRowsTable extends Table
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

        $this->setTable('invoice_rows');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Invoices', [
            'foreignKey' => 'invoice_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('OrderDetails', [
            'foreignKey' => 'order_detail_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Items', [
            'foreignKey' => 'item_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('ItemVariations', [
            'foreignKey' => 'item_variation_id'
        ]);
        $this->belongsTo('ComboOffers', [
            'foreignKey' => 'combo_offer_id'
        ]);
        $this->belongsTo('GstFigures', [
            'foreignKey' => 'gst_figure_id',
            'joinType' => 'INNER'
        ]);
		$this->belongsTo('ItemLedgers', [
            'foreignKey' => 'item_ledger_id',
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

        $validator
            ->decimal('quantity')
            ->requirePresence('quantity', 'create')
            ->notEmpty('quantity');

        $validator
            ->decimal('actual_quantity')
            ->requirePresence('actual_quantity', 'create')
            ->notEmpty('actual_quantity');

        $validator
            ->decimal('rate')
            ->requirePresence('rate', 'create')
            ->notEmpty('rate');

        $validator
            ->decimal('amount')
            ->requirePresence('amount', 'create')
            ->notEmpty('amount');

        $validator
            ->decimal('discount_percent')
            ->requirePresence('discount_percent', 'create')
            ->notEmpty('discount_percent');

        $validator
            ->decimal('discount_amount')
            ->requirePresence('discount_amount', 'create')
            ->notEmpty('discount_amount');

        $validator
            ->decimal('promo_percent')
            ->requirePresence('promo_percent', 'create')
            ->notEmpty('promo_percent');

        $validator
            ->decimal('promo_amount')
            ->requirePresence('promo_amount', 'create')
            ->notEmpty('promo_amount');

        $validator
            ->decimal('taxable_value')
            ->requirePresence('taxable_value', 'create')
            ->notEmpty('taxable_value');

        $validator
            ->decimal('gst_percentage')
            ->requirePresence('gst_percentage', 'create')
            ->notEmpty('gst_percentage');

        $validator
            ->decimal('gst_value')
            ->requirePresence('gst_value', 'create')
            ->notEmpty('gst_value');

        $validator
            ->decimal('net_amount')
            ->requirePresence('net_amount', 'create')
            ->notEmpty('net_amount');

        $validator
            ->scalar('is_item_cancel')
            ->maxLength('is_item_cancel', 5)
            ->requirePresence('is_item_cancel', 'create')
            ->notEmpty('is_item_cancel');

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
        $rules->add($rules->existsIn(['invoice_id'], 'Invoices'));
        $rules->add($rules->existsIn(['order_detail_id'], 'OrderDetails'));
        $rules->add($rules->existsIn(['item_id'], 'Items'));
        $rules->add($rules->existsIn(['item_variation_id'], 'ItemVariations'));
       // $rules->add($rules->existsIn(['combo_offer_id'], 'ComboOffers'));
        $rules->add($rules->existsIn(['gst_figure_id'], 'GstFigures'));

        return $rules;
    }
}
