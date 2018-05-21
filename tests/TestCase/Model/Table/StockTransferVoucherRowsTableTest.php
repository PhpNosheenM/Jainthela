<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\StockTransferVoucherRowsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\StockTransferVoucherRowsTable Test Case
 */
class StockTransferVoucherRowsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\StockTransferVoucherRowsTable
     */
    public $StockTransferVoucherRows;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.stock_transfer_voucher_rows',
        'app.stock_transfer_vouchers',
        'app.grns',
        'app.sellers',
        'app.cities',
        'app.accounting_groups',
        'app.nature_of_groups',
        'app.ledgers',
        'app.locations',
        'app.financial_years',
        'app.accounting_entries',
        'app.purchase_invoices',
        'app.gst_figures',
        'app.sale_return_rows',
        'app.sales_invoice_rows',
        'app.items',
        'app.filters',
        'app.categories',
        'app.promotion_details',
        'app.promotions',
        'app.admins',
        'app.roles',
        'app.combo_offers',
        'app.carts',
        'app.customers',
        'app.reference_details',
        'app.suppliers',
        'app.vendors',
        'app.vendor_details',
        'app.receipts',
        'app.sales_invoices',
        'app.receipt_rows',
        'app.ref_receipts',
        'app.payment_rows',
        'app.payments',
        'app.ref_payments',
        'app.contra_voucher_rows',
        'app.contra_vouchers',
        'app.credit_notes',
        'app.credit_note_rows',
        'app.item_ledgers',
        'app.item_variations',
        'app.unit_variations',
        'app.units',
        'app.combo_offer_details',
        'app.item_variation_masters',
        'app.seller_items',
        'app.brands',
        'app.seller_item_variations',
        'app.order_details',
        'app.orders',
        'app.drivers',
        'app.customer_addresses',
        'app.delivery_charges',
        'app.delivery_times',
        'app.cancel_reasons',
        'app.wallets',
        'app.plans',
        'app.return_orders',
        'app.orders_left',
        'app.seller_ledgers',
        'app.debit_note_rows',
        'app.journal_voucher_rows',
        'app.journal_vouchers',
        'app.purchase_voucher_rows',
        'app.sales_voucher_rows',
        'app.party_ledgers',
        'app.plans_left',
        'app.promotions_left',
        'app.sale_returns',
        'app.purchase_invoice_rows',
        'app.purchase_return_rows',
        'app.purchase_returns',
        'app.debit_notes',
        'app.app_notification_customers',
        'app.item_review_ratings',
        'app.bulk_booking_leads',
        'app.bulk_booking_lead_rows',
        'app.feedbacks',
        'app.seller_ratings',
        'app.verify_otps',
        'app.delivery_dates',
        'app.wish_lists',
        'app.wish_list_items',
        'app.get_items',
        'app.app_notifications',
        'app.grn_rows',
        'app.left_item_review_ratings',
        'app.average_review_ratings',
        'app.items_variations',
        'app.items_variations_data',
        'app.home_screens',
        'app.banners',
        'app.api_versions',
        'app.express_deliveries',
        'app.purchase_ledgers',
        'app.purchase_vouchers',
        'app.sales_vouchers',
        'app.seller_requests',
        'app.seller_request_rows',
        'app.states',
        'app.company_details',
        'app.supplier_areas',
        'app.history_item_variations',
        'app.seller_details',
        'app.super_admins',
        'app.companies',
        'app.vendor_ledgers'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('StockTransferVoucherRows') ? [] : ['className' => StockTransferVoucherRowsTable::class];
        $this->StockTransferVoucherRows = TableRegistry::get('StockTransferVoucherRows', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->StockTransferVoucherRows);

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
