<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Cities Model
 *
 * @property \App\Model\Table\StatesTable|\Cake\ORM\Association\BelongsTo $States
 * @property \App\Model\Table\AppNotificationsTable|\Cake\ORM\Association\HasMany $AppNotifications
 * @property \App\Model\Table\BannersTable|\Cake\ORM\Association\HasMany $Banners
 * @property \App\Model\Table\BulkBookingLeadsTable|\Cake\ORM\Association\HasMany $BulkBookingLeads
 * @property \App\Model\Table\CartsTable|\Cake\ORM\Association\HasMany $Carts
 * @property \App\Model\Table\CategoriesTable|\Cake\ORM\Association\HasMany $Categories
 * @property \App\Model\Table\ComboOffersTable|\Cake\ORM\Association\HasMany $ComboOffers
 * @property \App\Model\Table\CompanyDetailsTable|\Cake\ORM\Association\HasMany $CompanyDetails
 * @property \App\Model\Table\CustomerAddressesTable|\Cake\ORM\Association\HasMany $CustomerAddresses
 * @property \App\Model\Table\CustomersTable|\Cake\ORM\Association\HasMany $Customers
 * @property \App\Model\Table\DeliveryChargesTable|\Cake\ORM\Association\HasMany $DeliveryCharges
 * @property \App\Model\Table\DeliveryTimesTable|\Cake\ORM\Association\HasMany $DeliveryTimes
 * @property \App\Model\Table\ItemsTable|\Cake\ORM\Association\HasMany $Items
 * @property \App\Model\Table\LocationsTable|\Cake\ORM\Association\HasMany $Locations
 * @property \App\Model\Table\PlansTable|\Cake\ORM\Association\HasMany $Plans
 * @property \App\Model\Table\PromotionsTable|\Cake\ORM\Association\HasMany $Promotions
 * @property \App\Model\Table\RolesTable|\Cake\ORM\Association\HasMany $Roles
 * @property \App\Model\Table\SellersTable|\Cake\ORM\Association\HasMany $Sellers
 * @property \App\Model\Table\SupplierAreasTable|\Cake\ORM\Association\HasMany $SupplierAreas
 *
 * @method \App\Model\Entity\City get($primaryKey, $options = [])
 * @method \App\Model\Entity\City newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\City[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\City|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\City patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\City[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\City findOrCreate($search, callable $callback = null, $options = [])
 */
class CitiesTable extends Table
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

        $this->setTable('cities');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('States', [
            'foreignKey' => 'state_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('AppNotifications', [
            'foreignKey' => 'city_id'
        ]);
        $this->hasMany('Banners', [
            'foreignKey' => 'city_id'
        ]);
        $this->hasMany('BulkBookingLeads', [
            'foreignKey' => 'city_id'
        ]);
        $this->hasMany('Carts', [
            'foreignKey' => 'city_id'
        ]);
        $this->hasMany('Categories', [
            'foreignKey' => 'city_id'
        ]);
        $this->hasMany('ComboOffers', [
            'foreignKey' => 'city_id'
        ]);
        $this->hasMany('CompanyDetails', [
            'foreignKey' => 'city_id'
        ]);
        $this->hasMany('CustomerAddresses', [
            'foreignKey' => 'city_id'
        ]);
        $this->hasMany('Customers', [
            'foreignKey' => 'city_id'
        ]);
        $this->hasMany('DeliveryCharges', [
            'foreignKey' => 'city_id'
        ]);
        $this->hasMany('DeliveryTimes', [
            'foreignKey' => 'city_id'
        ]);
        $this->hasMany('Items', [
            'foreignKey' => 'city_id'
        ]);
        $this->hasMany('Locations', [
            'foreignKey' => 'city_id'
        ]);
        $this->hasMany('Plans', [
            'foreignKey' => 'city_id'
        ]);
        $this->hasMany('Promotions', [
            'foreignKey' => 'city_id'
        ]);
        $this->hasMany('Roles', [
            'foreignKey' => 'city_id'
        ]);
        $this->hasMany('Sellers', [
            'foreignKey' => 'city_id'
        ]);
        $this->hasMany('SupplierAreas', [
            'foreignKey' => 'city_id'
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
        $rules->add($rules->existsIn(['state_id'], 'States'));

        return $rules;
    }
}
