<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OldCustomerAddressesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OldCustomerAddressesTable Test Case
 */
class OldCustomerAddressesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\OldCustomerAddressesTable
     */
    public $OldCustomerAddresses;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.old_customer_addresses',
        'app.customers',
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
        'app.item_variations',
        'app.items',
        'app.filters',
        'app.categories',
        'app.promotion_details',
        'app.promotions',
        'app.admins',
        'app.roles',
        'app.combo_offers',
        'app.notifies',
        'app.combo_review_ratings',
        'app.combo_offer_details',
        'app.units',
        'app.unit_variations',
        'app.units_left',
        'app.wish_list_items',
        'app.wish_lists',
        'app.left_combo_review_ratings',
        'app.order_details',
        'app.item_ledgers',
        'app.sales_invoices',
        'app.sales_invoice_rows',
        'app.credit_notes',
        'app.credit_note_rows',
        'app.reference_details',
        'app.suppliers',
        'app.vendors',
        'app.vendor_details',
        'app.receipts',
        'app.receipt_rows',
        'app.ref_receipts',
        'app.payment_rows',
        'app.payments',
        'app.ref_payments',
        'app.contra_voucher_rows',
        'app.contra_vouchers',
        'app.debit_notes',
        'app.debit_note_rows',
        'app.sales_voucher_rows',
        'app.purchase_voucher_rows',
        'app.purchase_vouchers',
        'app.journal_voucher_rows',
        'app.journal_vouchers',
        'app.sale_returns',
        'app.seller_ledgers',
        'app.gst_figures',
        'app.sale_return_rows',
        'app.customer_data',
        'app.landmarks',
        'app.routes',
        'app.route_details',
        'app.app_notification_customers',
        'app.app_notifications',
        'app.app_notification_tokens',
        'app.item_review_ratings',
        'app.bulk_booking_leads',
        'app.bulk_booking_lead_rows',
        'app.customer_addresses',
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
        'app.order_payment_histories',
        'app.companies',
        'app.challans',
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
        'app.purchase_returns',
        'app.purchase_ledgers',
        'app.purchase_return_rows',
        'app.purchase_invoice_rows',
        'app.grn_rows',
        'app.item_variations_data',
        'app.items_datas',
        'app.gst_figures_data',
        'app.default_units',
        'app.left_item_review_ratings',
        'app.average_review_ratings',
        'app.items_variations',
        'app.unit_variations_left',
        'app.sellers_data',
        'app.items_variations_data',
        'app.home_screens',
        'app.api_versions',
        'app.express_deliveries',
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
        $config = TableRegistry::exists('OldCustomerAddresses') ? [] : ['className' => OldCustomerAddressesTable::class];
        $this->OldCustomerAddresses = TableRegistry::get('OldCustomerAddresses', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->OldCustomerAddresses);

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
