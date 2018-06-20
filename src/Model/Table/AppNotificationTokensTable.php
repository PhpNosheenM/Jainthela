<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AppNotificationTokens Model
 *
 * @method \App\Model\Entity\AppNotificationToken get($primaryKey, $options = [])
 * @method \App\Model\Entity\AppNotificationToken newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\AppNotificationToken[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AppNotificationToken|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AppNotificationToken patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\AppNotificationToken[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\AppNotificationToken findOrCreate($search, callable $callback = null, $options = [])
 */
class AppNotificationTokensTable extends Table
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

        $this->setTable('app_notification_tokens');
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
        /* $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('web_token')
            ->requirePresence('web_token', 'create')
            ->notEmpty('web_token');

        $validator
            ->scalar('app_token')
            ->requirePresence('app_token', 'create')
            ->notEmpty('app_token');

        $validator
            ->scalar('status')
            ->maxLength('status', 10)
            ->requirePresence('status', 'create')
            ->notEmpty('status'); */

        return $validator;
    }
}
