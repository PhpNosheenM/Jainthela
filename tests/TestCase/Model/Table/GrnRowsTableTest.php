<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\GrnRowsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\GrnRowsTable Test Case
 */
class GrnRowsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\GrnRowsTable
     */
    public $GrnRows;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.grn_rows',
        'app.items',
        'app.categories',
        'app.cities',
        'app.states',
        'app.app_notifications',
        'app.banners',
        'app.bulk_booking_leads',
        'app.carts',
        'app.customers',
        'app.app_notification_customers',
        'app.customer_addresses',
        'app.locations',
        'app.accounting_groups',
        'app.nature_of_groups',
        'app.ledgers',
        'app.suppliers',
        'app.reference_details',
        'app.receipts',
        'app.sales_invoices',
        'app.accounting_entries',
        'app.purchase_invoices',
        'app.gst_figures',
        'app.sale_return_rows',
        'app.sales_invoice_rows',
        'app.sellers',
        'app.seller_items',
        'app.item_variations',
        'app.unit_variations',
        'app.units',
        'app.combo_offer_details',
        'app.combo_offers',
        'app.admins',
        'app.roles',
        'app.feedbacks',
        'app.plans',
        'app.wallets',
        'app.orders',
        'app.drivers',
        'app.grns',
        'app.promotion_details',
        'app.delivery_charges',
        'app.delivery_times',
        'app.cancel_reasons',
        'app.order_details',
        'app.promotions',
        'app.return_orders',
        'app.orders_left',
        'app.plans_left',
        'app.promotions_left',
        'app.item_variation_masters',
        'app.seller_item_variations',
        'app.seller_ratings',
        'app.seller_ledgers',
        'app.credit_note_rows',
        'app.debit_note_rows',
        'app.journal_voucher_rows',
        'app.payment_rows',
        'app.payments',
        'app.ref_payments',
        'app.purchase_voucher_rows',
        'app.receipt_rows',
        'app.ref_receipts',
        'app.sales_voucher_rows',
        'app.purchase_ledgers',
        'app.item_ledgers',
        'app.credit_notes',
        'app.sale_returns',
        'app.purchase_invoice_rows',
        'app.purchase_return_rows',
        'app.purchase_returns',
        'app.debit_notes',
        'app.financial_years',
        'app.journal_vouchers',
        'app.purchase_vouchers',
        'app.sales_vouchers',
        'app.verify_otps',
        'app.delivery_dates',
        'app.company_details',
        'app.supplier_areas',
        'app.item_active',
        'app.brands',
        'app.left_item_review_ratings',
        'app.average_review_ratings',
        'app.item_review_ratings',
        'app.items_variations',
        'app.wish_lists',
        'app.wish_list_items',
        'app.home_screens',
        'app.api_versions',
        'app.express_deliveries'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('GrnRows') ? [] : ['className' => GrnRowsTable::class];
        $this->GrnRows = TableRegistry::get('GrnRows', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->GrnRows);

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
