<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OldCustomersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OldCustomersTable Test Case
 */
class OldCustomersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\OldCustomersTable
     */
    public $OldCustomers;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.old_customers',
        'app.customer_addresses',
        'app.landmarks',
        'app.cities',
        'app.accounting_groups',
        'app.nature_of_groups',
        'app.ledgers',
        'app.locations',
        'app.financial_years',
        'app.accounting_entries',
        'app.purchase_invoices',
        'app.grns',
        'app.sellers',
        'app.drivers',
        'app.orders',
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
        'app.items',
        'app.filters',
        'app.categories',
        'app.promotion_details',
        'app.promotions',
        'app.admins',
        'app.roles',
        'app.combo_offers',
        'app.notifies',
        'app.item_variations',
        'app.items_datas',
        'app.gst_figures',
        'app.sale_return_rows',
        'app.sale_returns',
        'app.seller_ledgers',
        'app.debit_note_rows',
        'app.debit_notes',
        'app.journal_voucher_rows',
        'app.journal_vouchers',
        'app.purchase_voucher_rows',
        'app.purchase_vouchers',
        'app.sales_voucher_rows',
        'app.customer_data',
        'app.app_notification_customers',
        'app.app_notifications',
        'app.wish_lists',
        'app.wish_list_items',
        'app.app_notification_tokens',
        'app.item_review_ratings',
        'app.bulk_booking_leads',
        'app.bulk_booking_lead_rows',
        'app.feedbacks',
        'app.seller_ratings',
        'app.wallets',
        'app.plans',
        'app.return_orders',
        'app.orders_left',
        'app.invoices',
        'app.party_ledgers',
        'app.vendor_data',
        'app.seller_data',
        'app.banners',
        'app.history_item_variations',
        'app.seller_details',
        'app.seller_items',
        'app.item_variation_masters',
        'app.unit_variations',
        'app.units',
        'app.combo_offer_details',
        'app.units_left',
        'app.brands',
        'app.item_rating',
        'app.seller_item_variations',
        'app.seller_requests',
        'app.seller_request_rows',
        'app.customer_addresses_left',
        'app.delivery_charges',
        'app.delivery_times',
        'app.cancel_reasons',
        'app.invoice_rows',
        'app.order_details',
        'app.order_payment_histories',
        'app.companies',
        'app.challans',
        'app.routes',
        'app.route_details',
        'app.challan_rows',
        'app.promotion_details_left',
        'app.customer_promotions',
        'app.get_items',
        'app.sales_orders',
        'app.bulk_order_performas',
        'app.bulk_order_performa_rows',
        'app.sales_ledgers',
        'app.sales_order_rows',
        'app.master_setups',
        'app.plans_left',
        'app.promotions_left',
        'app.verify_otps',
        'app.customer_memberships',
        'app.sales_invoice_rows',
        'app.gst_figures_data',
        'app.grn_rows',
        'app.purchase_invoice_rows',
        'app.item_variations_data',
        'app.unit_variations_left',
        'app.sellers_data',
        'app.purchase_return_rows',
        'app.purchase_returns',
        'app.purchase_ledgers',
        'app.default_units',
        'app.left_item_review_ratings',
        'app.average_review_ratings',
        'app.items_variations',
        'app.items_variations_data',
        'app.home_screens',
        'app.api_versions',
        'app.express_deliveries',
        'app.combo_review_ratings',
        'app.left_combo_review_ratings',
        'app.combo_offers_data',
        'app.delivery_dates',
        'app.super_admins',
        'app.stock_transfer_vouchers',
        'app.stock_transfer_voucher_rows',
        'app.vendor_ledgers',
        'app.sales_vouchers',
        'app.states',
        'app.company_details',
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
        $config = TableRegistry::exists('OldCustomers') ? [] : ['className' => OldCustomersTable::class];
        $this->OldCustomers = TableRegistry::get('OldCustomers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->OldCustomers);

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
