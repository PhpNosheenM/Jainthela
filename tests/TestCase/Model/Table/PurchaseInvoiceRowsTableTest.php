<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PurchaseInvoiceRowsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PurchaseInvoiceRowsTable Test Case
 */
class PurchaseInvoiceRowsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\PurchaseInvoiceRowsTable
     */
    public $PurchaseInvoiceRows;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.purchase_invoice_rows',
        'app.purchase_invoices',
        'app.locations',
        'app.cities',
        'app.states',
        'app.app_notifications',
        'app.banners',
        'app.bulk_booking_leads',
        'app.carts',
        'app.categories',
        'app.items',
        'app.brands',
        'app.admins',
        'app.roles',
        'app.combo_offers',
        'app.feedbacks',
        'app.plans',
        'app.promotions',
        'app.units',
        'app.combo_offer_details',
        'app.item_variations',
        'app.order_details',
        'app.sellers',
        'app.seller_items',
        'app.seller_ratings',
        'app.ledgers',
        'app.accounting_groups',
        'app.nature_of_groups',
        'app.suppliers',
        'app.reference_details',
        'app.customers',
        'app.app_notification_customers',
        'app.customer_addresses',
        'app.orders',
        'app.sale_returns',
        'app.sales_invoices',
        'app.wallets',
        'app.receipts',
        'app.receipt_rows',
        'app.payment_rows',
        'app.credit_notes',
        'app.credit_note_rows',
        'app.debit_notes',
        'app.debit_note_rows',
        'app.sales_voucher_rows',
        'app.purchase_voucher_rows',
        'app.journal_voucher_rows',
        'app.purchase_returns',
        'app.gst_figures',
        'app.sale_return_rows',
        'app.sales_invoice_rows',
        'app.accounting_entries',
        'app.grn_rows',
        'app.promotion_details',
        'app.purchase_return_rows',
        'app.items_variations',
        'app.home_screens',
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
        'app.sales_vouchers',
        'app.seller_ledgers',
        'app.purchase_ledgers',
        'app.item_ledgers',
        'app.item_gst_figures'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('PurchaseInvoiceRows') ? [] : ['className' => PurchaseInvoiceRowsTable::class];
        $this->PurchaseInvoiceRows = TableRegistry::get('PurchaseInvoiceRows', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PurchaseInvoiceRows);

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
