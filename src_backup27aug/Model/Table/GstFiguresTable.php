<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * GstFigures Model
 *
 * @property \App\Model\Table\LocationsTable|\Cake\ORM\Association\BelongsTo $Locations
 * @property \App\Model\Table\LedgersTable|\Cake\ORM\Association\HasMany $Ledgers
 * @property \App\Model\Table\SaleReturnRowsTable|\Cake\ORM\Association\HasMany $SaleReturnRows
 * @property \App\Model\Table\SalesInvoiceRowsTable|\Cake\ORM\Association\HasMany $SalesInvoiceRows
 *
 * @method \App\Model\Entity\GstFigure get($primaryKey, $options = [])
 * @method \App\Model\Entity\GstFigure newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\GstFigure[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\GstFigure|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\GstFigure patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\GstFigure[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\GstFigure findOrCreate($search, callable $callback = null, $options = [])
 */
class GstFiguresTable extends Table
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

        $this->setTable('gst_figures');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Locations', [
            'foreignKey' => 'location_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Ledgers', [
            'foreignKey' => 'gst_figure_id'
        ]);
        $this->hasMany('SaleReturnRows', [
            'foreignKey' => 'gst_figure_id'
        ]);
        $this->hasMany('SalesInvoiceRows', [
            'foreignKey' => 'gst_figure_id'
        ]);
		$this->hasMany('Items', [
            'foreignKey' => 'gst_figure_id'
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
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->decimal('tax_percentage')
            ->requirePresence('tax_percentage', 'create')
            ->notEmpty('tax_percentage');

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
        //$rules->add($rules->existsIn(['location_id'], 'Locations'));

        return $rules;
    }
}
