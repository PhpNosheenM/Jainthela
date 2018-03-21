<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CompanyDetailsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CompanyDetailsTable Test Case
 */
class CompanyDetailsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CompanyDetailsTable
     */
    public $CompanyDetails;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.company_details',
        'app.cities',
        'app.states',
        'app.app_notifications',
        'app.banners',
        'app.bulk_booking_leads',
        'app.carts',
        'app.categories',
        'app.items',
        'app.brands',
        'app.admins',
        'app.locations',
        'app.accounting_groups',
        'app.nature_of_groups',
        'app.ledgers',
        'app.suppliers',
        'app.reference_details',
        'app.customers',
        'app.app_notification_customers',
        'app.customer_addresses',
        'app.orders',
        'app.feedbacks',
        'app.sale_returns',
        'app.sales_invoices',
        'app.seller_ratings',
        'app.wallets',
        'app.plans',
        'app.promotions',
        'app.return_orders',
        'app.receipts',
        'app.receipt_rows',
        'app.payment_rows',
        'app.credit_notes',
        'app.credit_note_rows',
        'app.debit_notes',
        'app.debit_note_rows',
        'app.sales_voucher_rows',
        'app.purchase_voucher_rows',
        'app.journal_voucher_rows',
        'app.purchase_invoices',
        'app.gst_figures',
        'app.sale_return_rows',
        'app.sales_invoice_rows',
        'app.sellers',
        'app.seller_items',
        'app.seller_ledgers',
        'app.accounting_entries',
        'app.purchase_ledgers',
        'app.item_ledgers',
        'app.purchase_invoice_rows',
        'app.item_variations',
        'app.unit_variations',
        'app.units',
        'app.combo_offer_details',
        'app.order_details',
        'app.item_gst_figures',
        'app.purchase_return_rows',
        'app.purchase_returns',
        'app.financial_years',
        'app.drivers',
        'app.grns',
        'app.journal_vouchers',
        'app.payments',
        'app.purchase_vouchers',
        'app.sales_vouchers',
        'app.roles',
        'app.combo_offers',
        'app.grn_rows',
        'app.promotion_details',
        'app.items_variations',
        'app.home_screens',
        'app.express_deliveries',
        'app.item_active',
        'app.delivery_charges',
        'app.delivery_times',
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
        $config = TableRegistry::exists('CompanyDetails') ? [] : ['className' => CompanyDetailsTable::class];
        $this->CompanyDetails = TableRegistry::get('CompanyDetails', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CompanyDetails);

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
