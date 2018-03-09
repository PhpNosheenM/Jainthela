<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SellersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SellersTable Test Case
 */
class SellersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\SellersTable
     */
    public $Sellers;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.sellers',
        'app.cities',
        'app.states',
        'app.app_notifications',
        'app.banners',
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
        'app.delivery_charges',
        'app.delivery_times',
        'app.locations',
        'app.accounting_entries',
        'app.accounting_groups',
        'app.admins',
        'app.roles',
        'app.feedbacks',
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
        'app.supplier_areas',
        'app.seller_ratings'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Sellers') ? [] : ['className' => SellersTable::class];
        $this->Sellers = TableRegistry::get('Sellers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Sellers);

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
