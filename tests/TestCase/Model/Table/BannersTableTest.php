<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BannersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BannersTable Test Case
 */
class BannersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\BannersTable
     */
    public $Banners;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.banners',
        'app.cities',
        'app.states',
        'app.app_notifications',
        'app.bulk_booking_leads',
        'app.carts',
        'app.categories',
        'app.items',
        'app.promotion_details',
        'app.seller_items',
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
        'app.locations',
        'app.accounting_entries',
        'app.accounting_groups',
        'app.admins',
        'app.roles',
        'app.plans',
        'app.promotions',
        'app.units',
        'app.combo_offer_details',
        'app.item_variations',
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
        'app.sellers',
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
        $config = TableRegistry::exists('Banners') ? [] : ['className' => BannersTable::class];
        $this->Banners = TableRegistry::get('Banners', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Banners);

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