<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ItemVariationsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ItemVariationsTable Test Case
 */
class ItemVariationsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ItemVariationsTable
     */
    public $ItemVariations;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.item_variations',
        'app.items',
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
        'app.locations',
        'app.accounting_entries',
        'app.accounting_groups',
        'app.admins',
        'app.roles',
        'app.plans',
        'app.promotions',
        'app.units',
        'app.combo_offer_details',
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
        'app.seller_items',
        'app.supplier_areas',
        'app.promotion_details',
        'app.brands',
        'app.grn_rows',
        'app.purchase_invoice_rows',
        'app.purchase_return_rows',
        'app.sale_return_rows',
        'app.sales_invoice_rows',
        'app.order_details'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('ItemVariations') ? [] : ['className' => ItemVariationsTable::class];
        $this->ItemVariations = TableRegistry::get('ItemVariations', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ItemVariations);

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
