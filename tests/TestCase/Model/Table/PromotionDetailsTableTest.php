<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PromotionDetailsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PromotionDetailsTable Test Case
 */
class PromotionDetailsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\PromotionDetailsTable
     */
    public $PromotionDetails;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.promotion_details',
        'app.promotions',
        'app.admins',
        'app.locations',
        'app.cities',
        'app.states',
        'app.app_notifications',
        'app.banners',
        'app.bulk_booking_leads',
        'app.customers',
        'app.app_notification_customers',
        'app.carts',
        'app.item_variations',
        'app.items',
        'app.filters',
        'app.categories',
        'app.seller_items',
        'app.item_variation_masters',
        'app.unit_variations',
        'app.units',
        'app.combo_offer_details',
        'app.combo_offers',
        'app.wish_list_items',
        'app.wish_lists',
        'app.order_details',
        'app.orders',
        'app.gst_figures',
        'app.ledgers',
        'app.accounting_groups',
        'app.nature_of_groups',
        'app.suppliers',
        'app.reference_details',
        'app.receipts',
        'app.sales_invoices',
        'app.accounting_entries',
        'app.purchase_invoices',
        'app.sellers',
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
        'app.sales_invoice_rows',
        'app.credit_notes',
        'app.sale_returns',
        'app.sale_return_rows',
        'app.purchase_invoice_rows',
        'app.purchase_return_rows',
        'app.purchase_returns',
        'app.debit_notes',
        'app.drivers',
        'app.grns',
        'app.grn_rows',
        'app.customer_addresses',
        'app.delivery_charges',
        'app.delivery_times',
        'app.cancel_reasons',
        'app.wallets',
        'app.plans',
        'app.return_orders',
        'app.orders_left',
        'app.plans_left',
        'app.promotions_left',
        'app.seller_item_variations',
        'app.item_active',
        'app.brands',
        'app.left_item_review_ratings',
        'app.average_review_ratings',
        'app.item_review_ratings',
        'app.items_variations',
        'app.home_screens',
        'app.api_versions',
        'app.express_deliveries',
        'app.delivery_dates',
        'app.feedbacks',
        'app.verify_otps',
        'app.bulk_booking_lead_rows',
        'app.company_details',
        'app.roles',
        'app.supplier_areas',
        'app.financial_years',
        'app.journal_vouchers',
        'app.purchase_vouchers',
        'app.sales_vouchers',
        'app.get_items'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('PromotionDetails') ? [] : ['className' => PromotionDetailsTable::class];
        $this->PromotionDetails = TableRegistry::get('PromotionDetails', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PromotionDetails);

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
