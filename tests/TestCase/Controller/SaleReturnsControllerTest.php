<?php
namespace App\Test\TestCase\Controller;

use App\Controller\SaleReturnsController;
use Cake\TestSuite\IntegrationTestCase;

/**
 * App\Controller\SaleReturnsController Test Case
 */
class SaleReturnsControllerTest extends IntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.sale_returns',
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
        'app.banners',
        'app.categories',
        'app.items',
        'app.filters',
        'app.gst_figures',
        'app.sale_return_rows',
        'app.sales_invoice_rows',
        'app.brands',
        'app.admins',
        'app.roles',
        'app.combo_offers',
        'app.carts',
        'app.item_variations',
        'app.items_datas',
        'app.item_ledgers',
        'app.sales_invoices',
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
        'app.journal_voucher_rows',
        'app.journal_vouchers',
        'app.purchase_returns',
        'app.purchase_invoice_rows',
        'app.purchase_return_rows',
        'app.unit_variations',
        'app.units',
        'app.combo_offer_details',
        'app.item_variation_masters',
        'app.seller_items',
        'app.seller_item_variations',
        'app.app_notifications',
        'app.wish_lists',
        'app.wish_list_items',
        'app.app_notification_customers',
        'app.grn_rows',
        'app.promotion_details',
        'app.promotions',
        'app.wallets',
        'app.orders',
        'app.drivers',
        'app.customer_addresses',
        'app.delivery_charges',
        'app.delivery_times',
        'app.cancel_reasons',
        'app.order_details',
        'app.seller_ledgers',
        'app.party_ledgers',
        'app.sales_orders',
        'app.sales_ledgers',
        'app.sales_order_rows',
        'app.plans',
        'app.return_orders',
        'app.orders_left',
        'app.plans_left',
        'app.promotions_left',
        'app.get_items',
        'app.left_item_review_ratings',
        'app.average_review_ratings',
        'app.item_review_ratings',
        'app.items_variations',
        'app.items_variations_data',
        'app.home_screens',
        'app.api_versions',
        'app.express_deliveries',
        'app.combo_offers_data',
        'app.item_variations_data',
        'app.delivery_dates',
        'app.feedbacks',
        'app.history_item_variations',
        'app.seller_details',
        'app.seller_ratings',
        'app.seller_requests',
        'app.seller_request_rows',
        'app.super_admins',
        'app.companies',
        'app.vendor_ledgers',
        'app.purchase_ledgers',
        'app.purchase_vouchers',
        'app.sales_vouchers',
        'app.states',
        'app.bulk_booking_leads',
        'app.bulk_booking_lead_rows',
        'app.company_details',
        'app.supplier_areas',
        'app.verify_otps'
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
