<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AccountingEntriesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AccountingEntriesTable Test Case
 */
class AccountingEntriesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\AccountingEntriesTable
     */
    public $AccountingEntries;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.accounting_entries',
        'app.ledgers',
        'app.accounting_groups',
        'app.nature_of_groups',
        'app.locations',
        'app.cities',
        'app.states',
        'app.app_notifications',
        'app.banners',
        'app.bulk_booking_leads',
        'app.carts',
        'app.categories',
        'app.items',
        'app.gst_figures',
        'app.sale_return_rows',
        'app.sales_invoice_rows',
        'app.brands',
        'app.admins',
        'app.roles',
        'app.combo_offers',
        'app.feedbacks',
        'app.customers',
        'app.app_notification_customers',
        'app.customer_addresses',
        'app.orders',
        'app.reference_details',
        'app.suppliers',
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
        'app.sale_returns',
        'app.purchase_invoices',
        'app.sellers',
        'app.seller_items',
        'app.seller_item_variations',
        'app.seller_ratings',
        'app.seller_ledgers',
        'app.purchase_ledgers',
        'app.item_ledgers',
        'app.item_variations',
        'app.unit_variations',
        'app.units',
        'app.combo_offer_details',
        'app.order_details',
        'app.sales_invoices',
        'app.purchase_invoice_rows',
        'app.purchase_return_rows',
        'app.purchase_returns',
        'app.wallets',
        'app.plans',
        'app.promotions',
        'app.return_orders',
        'app.grn_rows',
        'app.item_variation_masters',
        'app.promotion_details',
        'app.items_variations',
        'app.home_screens',
        'app.api_versions',
        'app.express_deliveries',
        'app.item_active',
        'app.company_details',
        'app.delivery_charges',
        'app.delivery_times',
        'app.supplier_areas',
        'app.financial_years',
        'app.drivers',
        'app.grns',
        'app.journal_vouchers',
        'app.payments',
        'app.purchase_vouchers',
        'app.sales_vouchers',
        'app.contra_vouchers',
        'app.contra_voucher_rows'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('AccountingEntries') ? [] : ['className' => AccountingEntriesTable::class];
        $this->AccountingEntries = TableRegistry::get('AccountingEntries', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->AccountingEntries);

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
