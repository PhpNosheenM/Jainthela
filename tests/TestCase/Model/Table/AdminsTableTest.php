<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AdminsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AdminsTable Test Case
 */
class AdminsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\AdminsTable
     */
    public $Admins;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.admins',
        'app.locations',
        'app.cities',
        'app.states',
        'app.app_notifications',
        'app.banners',
        'app.bulk_booking_leads',
        'app.carts',
        'app.categories',
        'app.combo_offers',
        'app.company_details',
        'app.customer_addresses',
        'app.customers',
        'app.delivery_charges',
        'app.delivery_times',
        'app.items',
        'app.plans',
        'app.promotions',
        'app.roles',
        'app.sellers',
        'app.supplier_areas',
        'app.accounting_entries',
        'app.accounting_groups',
        'app.credit_notes',
        'app.debit_notes',
        'app.drivers',
        'app.grns',
        'app.gst_figures',
        'app.journal_vouchers',
        'app.orders',
        'app.payments',
        'app.purchase_invoices',
        'app.purchase_returns',
        'app.purchase_vouchers',
        'app.receipts',
        'app.reference_details',
        'app.sale_returns',
        'app.sales_invoices',
        'app.sales_vouchers',
        'app.suppliers',
        'app.feedbacks',
        'app.units'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Admins') ? [] : ['className' => AdminsTable::class];
        $this->Admins = TableRegistry::get('Admins', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Admins);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
