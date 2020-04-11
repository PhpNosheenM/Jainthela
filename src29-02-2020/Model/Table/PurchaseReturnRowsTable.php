<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PurchaseReturnRows Model
 *
 * @property \App\Model\Table\PurchaseReturnsTable|\Cake\ORM\Association\BelongsTo $PurchaseReturns
 * @property \App\Model\Table\PurchaseInvoiceRowsTable|\Cake\ORM\Association\BelongsTo $PurchaseInvoiceRows
 * @property \App\Model\Table\ItemsTable|\Cake\ORM\Association\BelongsTo $Items
 * @property \App\Model\Table\ItemVariationsTable|\Cake\ORM\Association\BelongsTo $ItemVariations
 * @property \App\Model\Table\ItemLedgersTable|\Cake\ORM\Association\HasMany $ItemLedgers
 *
 * @method \App\Model\Entity\PurchaseReturnRow get($primaryKey, $options = [])
 * @method \App\Model\Entity\PurchaseReturnRow newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PurchaseReturnRow[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PurchaseReturnRow|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PurchaseReturnRow patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PurchaseReturnRow[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PurchaseReturnRow findOrCreate($search, callable $callback = null, $options = [])
 */
class PurchaseReturnRowsTable extends Table
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

        $this->setTable('purchase_return_rows');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('PurchaseReturns', [
            'foreignKey' => 'purchase_return_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('PurchaseInvoiceRows', [
            'foreignKey' => 'purchase_invoice_row_id',
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
		$this->belongsTo('UnitVariations', [
            'foreignKey' => 'unit_variation_id',
            'joinType' => 'INNER'
        ]);
		$this->belongsTo('GstFigures', [
            'foreignKey' => 'gst_figure_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('ItemLedgers', [
            'foreignKey' => 'purchase_return_row_id'
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
            ->decimal('rate')
            ->requirePresence('rate', 'create')
            ->notEmpty('rate');

        $validator
            ->decimal('discount_percentage')
            ->allowEmpty('discount_percentage');

        $validator
            ->decimal('discount_amount')
            ->allowEmpty('discount_amount');

        $validator
            ->decimal('taxable_value')
            ->requirePresence('taxable_value', 'create')
            ->notEmpty('taxable_value');

        $validator
            ->decimal('net_amount')
            ->requirePresence('net_amount', 'create')
            ->notEmpty('net_amount');

        
        $validator
            ->decimal('gst_value')
            ->requirePresence('gst_value', 'create')
            ->notEmpty('gst_value');

        $validator
            ->decimal('round_off')
            ->allowEmpty('round_off');

      
        $validator
            ->decimal('sales_rate')
            ->allowEmpty('sales_rate');

      

       

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
        $rules->add($rules->existsIn(['purchase_return_id'], 'PurchaseReturns'));
        $rules->add($rules->existsIn(['purchase_invoice_row_id'], 'PurchaseInvoiceRows'));
        $rules->add($rules->existsIn(['item_id'], 'Items'));
        $rules->add($rules->existsIn(['item_variation_id'], 'ItemVariations'));

        return $rules;
    }
}
