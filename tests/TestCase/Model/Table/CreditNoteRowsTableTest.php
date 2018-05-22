<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CreditNoteRowsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CreditNoteRowsTable Test Case
 */
class CreditNoteRowsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CreditNoteRowsTable
     */
    public $CreditNoteRows;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.credit_note_rows',
        'app.credit_notes',
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
        'app.item_review_ratings',
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
        'app.unit_variations',
        'app.units',
        'app.combo_offer_details',
        'app.sellers',
        'app.banners',
        'app.grns',
        'app.super_admins',
        'app.companies',
        'app.orders',
        'app.gst_figures',
        'app.sale_return_rows',
        'app.sales_invoice_rows',
        'app.accounting_entries',
        'app.purchase_invoices',
        'app.seller_ledgers',
        'app.debit_note_rows',
        'app.journal_voucher_rows',
        'app.journal_vouchers',
        'app.payment_rows',
        'app.payments',
        'app.ref_payments',
        'app.purchase_voucher_rows',
        'app.receipt_rows',
        'app.receipts',
        'app.sales_invoices',
        'app.ref_receipts',
        'app.sales_voucher_rows',
        'app.purchase_ledgers',
        'app.item_ledgers',
        'app.sale_returns',
        'app.purchase_invoice_rows',
        'app.purchase_return_rows',
        'app.purchase_returns',
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
        'app.plans_left',
        'app.promotions_left',
        'app.grn_rows',
        'app.vendor_ledgers',
        'app.history_item_variations',
        'app.seller_details',
        'app.seller_items',
        'app.item_variation_masters',
        'app.seller_item_variations',
        'app.seller_ratings',
        'app.seller_requests',
        'app.seller_request_rows',
        'app.delivery_dates',
        'app.wish_lists',
        'app.wish_list_items',
        'app.feedbacks',
        'app.get_items',
        'app.brands',
        'app.app_notifications',
        'app.left_item_review_ratings',
        'app.average_review_ratings',
        'app.items_variations',
        'app.items_variations_data',
        'app.home_screens',
        'app.api_versions',
        'app.express_deliveries',
        'app.bulk_booking_leads',
        'app.bulk_booking_lead_rows',
        'app.verify_otps',
        'app.suppliers',
        'app.contra_voucher_rows',
        'app.contra_vouchers',
        'app.debit_notes',
        'app.vendor_details',
        'app.states',
        'app.company_details',
        'app.supplier_areas',
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
        $config = TableRegistry::exists('CreditNoteRows') ? [] : ['className' => CreditNoteRowsTable::class];
        $this->CreditNoteRows = TableRegistry::get('CreditNoteRows', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CreditNoteRows);

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
