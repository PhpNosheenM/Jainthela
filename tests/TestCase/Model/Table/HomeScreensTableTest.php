<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\HomeScreensTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\HomeScreensTable Test Case
 */
class HomeScreensTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\HomeScreensTable
     */
    public $HomeScreens;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.home_screens',
        'app.categories',
        'app.cities',
        'app.states',
        'app.app_notifications',
        'app.banners',
        'app.bulk_booking_leads',
        'app.carts',
        'app.combo_offers',
        'app.company_details',
        'app.customer_addresses',
        'app.customers',
        'app.app_notification_customers',
        'app.feedbacks',
        'app.ledgers',
        'app.orders',
        'app.reference_details',
        'app.sale_returns',
        'app.sales_invoices',
        'app.seller_ratings',
        'app.wallets',
        'app.delivery_charges',
        'app.delivery_times',
        'app.items',
        'app.brands',
        'app.admins',
        'app.locations',
        'app.accounting_entries',
        'app.accounting_groups',
        'app.credit_notes',
        'app.debit_notes',
        'app.drivers',
        'app.grns',
        'app.gst_figures',
        'app.journal_vouchers',
        'app.payments',
        'app.purchase_invoices',
        'app.purchase_returns',
        'app.purchase_vouchers',
        'app.receipts',
        'app.sales_vouchers',
        'app.suppliers',
        'app.roles',
        'app.plans',
        'app.promotions',
        'app.units',
        'app.combo_offer_details',
        'app.item_variations',
        'app.order_details',
        'app.sellers',
        'app.seller_items',
        'app.grn_rows',
        'app.promotion_details',
        'app.purchase_invoice_rows',
        'app.purchase_return_rows',
        'app.sale_return_rows',
        'app.sales_invoice_rows',
        'app.supplier_areas'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('HomeScreens') ? [] : ['className' => HomeScreensTable::class];
        $this->HomeScreens = TableRegistry::get('HomeScreens', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->HomeScreens);

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
