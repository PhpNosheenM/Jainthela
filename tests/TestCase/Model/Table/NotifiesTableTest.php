<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\NotifiesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\NotifiesTable Test Case
 */
class NotifiesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\NotifiesTable
     */
    public $Notifies;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.notifies',
        'app.customers',
        'app.cities',
        'app.states',
        'app.app_notifications',
        'app.banners',
        'app.bulk_booking_leads',
        'app.bulk_booking_lead_rows',
        'app.carts',
        'app.item_variations',
        'app.items',
        'app.filters',
        'app.categories',
        'app.promotion_details',
        'app.promotions',
        'app.admins',
        'app.locations',
        'app.accounting_groups',
        'app.nature_of_groups',
        'app.ledgers',
        'app.suppliers',
        'app.reference_details',
        'app.receipts',
        'app.sales_invoices',
        'app.accounting_entries',
        'app.purchase_invoices',
        'app.gst_figures',
        'app.sale_return_rows',
        'app.sales_invoice_rows',
        'app.sellers',
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
        'app.drivers',
        'app.grns',
        'app.grn_rows',
        'app.item_ledgers',
        'app.credit_notes',
        'app.credit_note_rows',
        'app.sale_returns',
        'app.purchase_invoice_rows',
        'app.purchase_return_rows',
        'app.purchase_returns',
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
        'app.seller_ratings',
        'app.seller_ledgers',
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
        'app.debit_notes',
        'app.financial_years',
        'app.journal_vouchers',
        'app.purchase_vouchers',
        'app.sales_vouchers',
        'app.roles',
        'app.feedbacks',
        'app.get_items',
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
        'app.company_details',
        'app.supplier_areas',
        'app.app_notification_customers',
        'app.verify_otps'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Notifies') ? [] : ['className' => NotifiesTable::class];
        $this->Notifies = TableRegistry::get('Notifies', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Notifies);

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
