<?php
namespace App\Test\TestCase\Controller;

use App\Controller\ComboOffersController;
use Cake\TestSuite\IntegrationTestCase;

/**
 * App\Controller\ComboOffersController Test Case
 */
class ComboOffersControllerTest extends IntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.combo_offers',
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
        'app.receipt_rows',
        'app.ref_receipts',
        'app.payment_rows',
<<<<<<< HEAD
        'app.payments',
        'app.ref_payments',
=======
>>>>>>> 0c846ee17fee5c591edddce04558bbd09e9e0e5c
        'app.credit_notes',
        'app.credit_note_rows',
        'app.debit_notes',
        'app.debit_note_rows',
        'app.sales_voucher_rows',
        'app.purchase_voucher_rows',
        'app.journal_voucher_rows',
        'app.sale_returns',
        'app.purchase_invoices',
        'app.gst_figures',
        'app.sale_return_rows',
        'app.sales_invoice_rows',
        'app.items',
        'app.categories',
        'app.promotion_details',
        'app.seller_items',
        'app.item_variations',
        'app.unit_variations',
        'app.units',
        'app.combo_offer_details',
        'app.item_variation_masters',
        'app.item_active',
        'app.brands',
        'app.admins',
        'app.roles',
        'app.feedbacks',
        'app.plans',
        'app.wallets',
        'app.orders',
<<<<<<< HEAD
        'app.drivers',
        'app.delivery_charges',
        'app.delivery_times',
        'app.cancel_reasons',
        'app.order_details',
=======
>>>>>>> 0c846ee17fee5c591edddce04558bbd09e9e0e5c
        'app.promotions',
        'app.return_orders',
        'app.orders_left',
        'app.plans_left',
        'app.promotions_left',
        'app.sellers',
        'app.seller_ratings',
<<<<<<< HEAD
        'app.item_ledgers',
        'app.purchase_invoice_rows',
        'app.purchase_return_rows',
        'app.purchase_returns',
        'app.grn_rows',
=======
        'app.grn_rows',
        'app.purchase_invoice_rows',
        'app.item_gst_figures',
        'app.item_ledgers',
        'app.purchase_return_rows',
>>>>>>> 0c846ee17fee5c591edddce04558bbd09e9e0e5c
        'app.left_item_review_ratings',
        'app.average_review_ratings',
        'app.item_review_ratings',
        'app.items_variations',
<<<<<<< HEAD
=======
        'app.order_details',
>>>>>>> 0c846ee17fee5c591edddce04558bbd09e9e0e5c
        'app.wish_lists',
        'app.wish_list_items',
        'app.home_screens',
        'app.api_versions',
        'app.express_deliveries',
        'app.seller_item_variations',
        'app.seller_ledgers',
        'app.purchase_ledgers',
<<<<<<< HEAD
        'app.financial_years',
        'app.grns',
        'app.journal_vouchers',
=======
        'app.purchase_returns',
        'app.financial_years',
        'app.drivers',
        'app.grns',
        'app.journal_vouchers',
        'app.payments',
>>>>>>> 0c846ee17fee5c591edddce04558bbd09e9e0e5c
        'app.purchase_vouchers',
        'app.sales_vouchers',
        'app.verify_otps',
        'app.company_details',
<<<<<<< HEAD
=======
        'app.delivery_charges',
        'app.delivery_times',
>>>>>>> 0c846ee17fee5c591edddce04558bbd09e9e0e5c
        'app.supplier_areas'
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
