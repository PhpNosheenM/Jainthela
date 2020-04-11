<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Event\Event;
use ArrayObject;

/**
 * GrnRows Model
 *
 * @property \App\Model\Table\GrnRowsTable|\Cake\ORM\Association\BelongsTo $GrnRows
 * @property \App\Model\Table\ItemsTable|\Cake\ORM\Association\BelongsTo $Items
 * @property \App\Model\Table\ItemVariationsTable|\Cake\ORM\Association\BelongsTo $ItemVariations
 * @property \App\Model\Table\GrnRowsTable|\Cake\ORM\Association\HasMany $GrnRows
 *
 * @method \App\Model\Entity\GrnRow get($primaryKey, $options = [])
 * @method \App\Model\Entity\GrnRow newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\GrnRow[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\GrnRow|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\GrnRow patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\GrnRow[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\GrnRow findOrCreate($search, callable $callback = null, $options = [])
 */
class GrnRowsTable extends Table
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

        $this->setTable('grn_rows');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Grns', [
            'foreignKey' => 'grn_id',
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
            'joinType' => 'LEFT'
        ]);
        $this->hasMany('GrnRows', [
            'foreignKey' => 'grn_row_id'
        ]);
		
		$this->hasMany('ItemLedgers', [
            'foreignKey' => 'item_ledger_id'
        ]);
        $this->belongsTo('Ledgers');
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

       /* $validator
            ->decimal('rate')
            ->requirePresence('rate', 'create')
            ->notEmpty('rate');

        $validator
            ->decimal('taxable_value')
            ->requirePresence('taxable_value', 'create')
            ->notEmpty('taxable_value');

        $validator
            ->decimal('net_amount')
            ->requirePresence('net_amount', 'create')
            ->notEmpty('net_amount');

        $validator
            ->integer('gst_percentage')
            ->requirePresence('gst_percentage', 'create')
            ->notEmpty('gst_percentage');

        $validator
            ->decimal('gst_value')
            ->requirePresence('gst_value', 'create')
            ->notEmpty('gst_value');
*/
        $validator
            ->decimal('purchase_rate')
            ->requirePresence('purchase_rate', 'create')
            ->notEmpty('purchase_rate');

    /*    $validator
            ->decimal('sales_rate')
            ->requirePresence('sales_rate', 'create')
            ->notEmpty('sales_rate');*/

     /*   $validator
            ->scalar('gst_type')
            ->maxLength('gst_type', 100)
            ->requirePresence('gst_type', 'create')
            ->notEmpty('gst_type');

        $validator
            ->decimal('mrp')
            ->requirePresence('mrp', 'create')
            ->notEmpty('mrp');
*/
        return $validator;
    }

	public function beforeMarshal(Event $event, ArrayObject $data, ArrayObject $options)
	{
		if (isset($data['expiry_date'])) {
			$data['expiry_date'] = date('Y-m-d', strtotime($data['expiry_date']));
			//pr($data['expiry_date']); exit;
			//$data['username'] = mb_strtolower($data['username']);
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
        $rules->add($rules->existsIn(['grn_row_id'], 'GrnRows'));
        $rules->add($rules->existsIn(['item_id'], 'Items'));
        $rules->add($rules->existsIn(['item_variation_id'], 'ItemVariations'));

        return $rules;
    }
}
