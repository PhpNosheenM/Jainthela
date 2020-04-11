<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * VerifyOtps Model
 *
 * @method \App\Model\Entity\VerifyOtp get($primaryKey, $options = [])
 * @method \App\Model\Entity\VerifyOtp newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\VerifyOtp[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\VerifyOtp|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\VerifyOtp patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\VerifyOtp[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\VerifyOtp findOrCreate($search, callable $callback = null, $options = [])
 */
class VerifyOtpsTable extends Table
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

        $this->setTable('verify_otps');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
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
            ->scalar('mobile')
            ->maxLength('mobile', 15)
            ->requirePresence('mobile', 'create')
            ->notEmpty('mobile');

        $validator
            ->scalar('opt')
            ->maxLength('opt', 6)
            ->requirePresence('opt', 'create')
            ->notEmpty('opt');

        $validator
            ->integer('status')
            ->requirePresence('status', 'create')
            ->notEmpty('status');

        return $validator;
    }
}
