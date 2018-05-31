<?php
namespace App\Test\TestCase\Controller;

use App\Controller\SalesOrdersController;
use Cake\TestSuite\IntegrationTestCase;

/**
 * App\Controller\SalesOrdersController Test Case
 */
class SalesOrdersControllerTest extends IntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.sales_orders',
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
        'app.purchase_invoices',
        'app.grns',
        'app.sellers',
        'app.banners',
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
        'app.item_variation_masters',
        'app.seller_items',
        'app.brands',
        'app.seller_item_variations',
        'app.order_details',
        'app.orders',
        'app.gst_figures',
        'app.sale_return_rows',
        'app.sales_invoice_rows',
        'app.accounting_entries',
        'app.payments',
        'app.payment_rows',
        'app.ref_payments',
        'app.purchase_vouchers',
        'app.purchase_voucher_rows',
        'app.sales_invoices',
        'app.sale_returns',
        'app.purchase_returns',
        'app.receipts',
        'app.receipt_rows',
        'app.ref_receipts',
        'app.credit_notes',
        'app.credit_note_rows',
        'app.item_ledgers',
        'app.purchase_invoice_rows',
        'app.purchase_return_rows',
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
        'app.wallets',
        'app.plans',
        'app.return_orders',
        'app.orders_left',
        'app.seller_ledgers',
        'app.party_ledgers',
        'app.plans_left',
        'app.promotions_left',
        'app.delivery_dates',
        'app.wish_lists',
        'app.wish_list_items',
        'app.feedbacks',
        'app.get_items',
        'app.history_item_variations',
        'app.seller_details',
        'app.seller_ratings',
        'app.seller_requests',
        'app.seller_request_rows',
        'app.super_admins',
        'app.companies',
        'app.grn_rows',
        'app.vendor_ledgers',
        'app.purchase_ledgers',
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
        'app.vendor_details',
        'app.states',
        'app.company_details',
        'app.supplier_areas',
        'app.sales_ledgers',
        'app.sales_order_rows'
    ];

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
