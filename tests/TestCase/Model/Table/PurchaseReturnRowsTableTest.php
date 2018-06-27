<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PurchaseReturnRowsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PurchaseReturnRowsTable Test Case
 */
class PurchaseReturnRowsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\PurchaseReturnRowsTable
     */
    public $PurchaseReturnRows;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.purchase_return_rows',
        'app.purchase_returns',
        'app.purchase_invoices',
        'app.locations',
        'app.financial_years',
        'app.cities',
        'app.accounting_groups',
        'app.nature_of_groups',
        'app.ledgers',
        'app.vendors',
        'app.reference_details',
        'app.customers',
        'app.app_notification_customers',
        'app.app_notifications',
        'app.items',
        'app.filters',
        'app.categories',
        'app.promotion_details',
        'app.promotions',
        'app.admins',
        'app.roles',
        'app.combo_offers',
        'app.carts',
        'app.item_variations',
        'app.items_datas',
        'app.gst_figures',
        'app.sale_return_rows',
        'app.sale_returns',
        'app.seller_ledgers',
        'app.sellers',
        'app.banners',
        'app.grns',
        'app.super_admins',
        'app.companies',
        'app.orders',
        'app.accounting_entries',
        'app.payments',
        'app.payment_rows',
        'app.ref_payments',
        'app.purchase_vouchers',
        'app.purchase_voucher_rows',
        'app.sales_invoices',
        'app.receipts',
        'app.receipt_rows',
        'app.ref_receipts',
        'app.credit_notes',
        'app.credit_note_rows',
        'app.item_ledgers',
        'app.sales_invoice_rows',
        'app.purchase_invoice_rows',
        'app.unit_variations',
        'app.units',
        'app.combo_offer_details',
        'app.debit_notes',
        'app.debit_note_rows',
        'app.sales_vouchers',
        'app.sales_voucher_rows',
        'app.journal_vouchers',
        'app.journal_voucher_rows',
        'app.contra_vouchers',
        'app.contra_voucher_rows',
        'app.drivers',
        'app.customer_addresses',
        'app.delivery_charges',
        'app.delivery_times',
        'app.cancel_reasons',
        'app.order_details',
        'app.wallets',
        'app.plans',
        'app.return_orders',
        'app.orders_left',
        'app.party_ledgers',
        'app.customer_data',
        'app.item_review_ratings',
        'app.bulk_booking_leads',
        'app.bulk_booking_lead_rows',
        'app.feedbacks',
        'app.seller_ratings',
        'app.verify_otps',
        'app.vendor_data',
        'app.vendor_details',
        'app.seller_data',
        'app.history_item_variations',
        'app.seller_details',
        'app.seller_items',
        'app.item_variation_masters',
        'app.brands',
        'app.seller_item_variations',
        'app.seller_requests',
        'app.seller_request_rows',
        'app.sales_orders',
        'app.sales_ledgers',
        'app.sales_order_rows',
        'app.plans_left',
        'app.promotions_left',
        'app.grn_rows',
        'app.vendor_ledgers',
        'app.left_item_review_ratings',
        'app.average_review_ratings',
        'app.items_variations',
        'app.items_variations_data',
        'app.wish_lists',
        'app.wish_list_items',
        'app.home_screens',
        'app.api_versions',
        'app.express_deliveries',
        'app.combo_offers_data',
        'app.item_variations_data',
        'app.delivery_dates',
        'app.get_items',
        'app.app_notification_tokens',
        'app.suppliers',
        'app.states',
        'app.company_details',
        'app.supplier_areas',
        'app.purchase_ledgers'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('PurchaseReturnRows') ? [] : ['className' => PurchaseReturnRowsTable::class];
        $this->PurchaseReturnRows = TableRegistry::get('PurchaseReturnRows', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PurchaseReturnRows);

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
