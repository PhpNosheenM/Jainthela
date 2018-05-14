<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\GrnsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\GrnsTable Test Case
 */
class GrnsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\GrnsTable
     */
    public $Grns;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.grns',
        'app.locations',
        'app.cities',
        'app.states',
        'app.app_notifications',
        'app.banners',
        'app.categories',
        'app.items',
        'app.filters',
        'app.gst_figures',
        'app.ledgers',
        'app.accounting_groups',
        'app.nature_of_groups',
        'app.suppliers',
        'app.reference_details',
        'app.customers',
        'app.app_notification_customers',
        'app.item_review_ratings',
        'app.sellers',
        'app.history_item_variations',
        'app.item_ledgers',
        'app.item_variations',
        'app.unit_variations',
        'app.units',
        'app.combo_offer_details',
        'app.combo_offers',
        'app.admins',
        'app.roles',
        'app.feedbacks',
        'app.plans',
        'app.wallets',
        'app.orders',
        'app.carts',
        'app.delivery_charges',
        'app.delivery_dates',
        'app.delivery_times',
        'app.wish_lists',
        'app.wish_list_items',
        'app.accounting_entries',
        'app.purchase_invoices',
        'app.seller_ledgers',
        'app.credit_note_rows',
        'app.debit_note_rows',
        'app.journal_voucher_rows',
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
        'app.purchase_invoice_rows',
        'app.purchase_return_rows',
        'app.purchase_returns',
        'app.drivers',
        'app.customer_addresses',
        'app.promotion_details',
        'app.promotions',
        'app.get_items',
        'app.cancel_reasons',
        'app.order_details',
        'app.return_orders',
        'app.orders_left',
        'app.plans_left',
        'app.promotions_left',
        'app.item_variation_masters',
        'app.seller_items',
        'app.seller_item_variations',
        'app.sales_invoice_rows',
        'app.credit_notes',
        'app.sale_returns',
        'app.sale_return_rows',
        'app.seller_details',
        'app.seller_ratings',
        'app.seller_requests',
        'app.seller_request_rows',
        'app.bulk_booking_leads',
        'app.bulk_booking_lead_rows',
        'app.verify_otps',
        'app.debit_notes',
        'app.brands',
        'app.grn_rows',
        'app.left_item_review_ratings',
        'app.average_review_ratings',
        'app.items_variations',
        'app.home_screens',
        'app.api_versions',
        'app.express_deliveries',
        'app.item_active',
        'app.company_details',
        'app.supplier_areas',
        'app.contra_vouchers',
        'app.journal_vouchers',
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
        $config = TableRegistry::exists('Grns') ? [] : ['className' => GrnsTable::class];
        $this->Grns = TableRegistry::get('Grns', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Grns);

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
