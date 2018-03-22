<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ReceiptsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ReceiptsTable Test Case
 */
class ReceiptsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ReceiptsTable
     */
    public $Receipts;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.receipts',
        'app.locations',
        'app.cities',
        'app.states',
        'app.app_notifications',
        'app.banners',
        'app.bulk_booking_leads',
        'app.carts',
        'app.categories',
        'app.items',
        'app.gst_figures',
        'app.ledgers',
        'app.accounting_groups',
        'app.nature_of_groups',
        'app.suppliers',
        'app.reference_details',
        'app.customers',
        'app.app_notification_customers',
        'app.customer_addresses',
        'app.orders',
        'app.feedbacks',
        'app.sale_returns',
        'app.sales_invoices',
        'app.seller_ratings',
        'app.wallets',
        'app.plans',
        'app.admins',
        'app.roles',
        'app.combo_offers',
        'app.promotions',
        'app.units',
        'app.combo_offer_details',
        'app.item_variations',
        'app.unit_variations',
        'app.order_details',
        'app.return_orders',
        'app.orders_left',
        'app.plans_left',
        'app.promotions_left',
        'app.receipt_rows',
        'app.payment_rows',
        'app.credit_notes',
        'app.credit_note_rows',
        'app.debit_notes',
        'app.debit_note_rows',
        'app.sales_voucher_rows',
        'app.purchase_voucher_rows',
        'app.journal_voucher_rows',
        'app.purchase_invoices',
        'app.sellers',
        'app.seller_items',
        'app.seller_item_variations',
        'app.seller_ledgers',
        'app.accounting_entries',
        'app.purchase_ledgers',
        'app.item_ledgers',
        'app.purchase_invoice_rows',
        'app.item_gst_figures',
        'app.purchase_return_rows',
        'app.purchase_returns',
        'app.sale_return_rows',
        'app.sales_invoice_rows',
        'app.brands',
        'app.grn_rows',
        'app.item_variation_masters',
        'app.promotion_details',
        'app.items_variations',
        'app.home_screens',
        'app.api_versions',
        'app.express_deliveries',
        'app.item_active',
        'app.company_details',
        'app.delivery_charges',
        'app.delivery_times',
        'app.supplier_areas',
        'app.financial_years',
        'app.drivers',
        'app.grns',
        'app.journal_vouchers',
        'app.payments',
        'app.purchase_vouchers',
        'app.sales_vouchers'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Receipts') ? [] : ['className' => ReceiptsTable::class];
        $this->Receipts = TableRegistry::get('Receipts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Receipts);

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
