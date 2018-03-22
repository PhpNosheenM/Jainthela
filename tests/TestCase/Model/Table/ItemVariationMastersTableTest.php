<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ItemVariationMastersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ItemVariationMastersTable Test Case
 */
class ItemVariationMastersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ItemVariationMastersTable
     */
    public $ItemVariationMasters;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.item_variation_masters',
        'app.items',
        'app.categories',
        'app.cities',
        'app.states',
        'app.app_notifications',
        'app.banners',
        'app.bulk_booking_leads',
        'app.carts',
        'app.combo_offers',
        'app.company_details',
        'app.customer_addresses',
        'app.customers',
        'app.app_notification_customers',
        'app.feedbacks',
        'app.ledgers',
        'app.accounting_groups',
        'app.nature_of_groups',
        'app.locations',
        'app.financial_years',
        'app.gst_figures',
        'app.sale_return_rows',
        'app.sales_invoice_rows',
        'app.accounting_entries',
        'app.admins',
        'app.roles',
        'app.plans',
        'app.promotions',
        'app.units',
        'app.combo_offer_details',
        'app.item_variations',
        'app.unit_variations',
        'app.order_details',
        'app.credit_notes',
        'app.debit_notes',
        'app.drivers',
        'app.grns',
        'app.journal_vouchers',
        'app.orders',
        'app.payments',
        'app.purchase_invoices',
        'app.sellers',
        'app.seller_items',
        'app.seller_ratings',
        'app.reference_details',
        'app.suppliers',
        'app.receipts',
        'app.receipt_rows',
        'app.payment_rows',
        'app.credit_note_rows',
        'app.debit_note_rows',
        'app.sales_voucher_rows',
        'app.purchase_voucher_rows',
        'app.journal_voucher_rows',
        'app.sale_returns',
        'app.purchase_returns',
        'app.sales_invoices',
        'app.seller_ledgers',
        'app.purchase_ledgers',
        'app.item_ledgers',
        'app.purchase_invoice_rows',
        'app.item_gst_figures',
        'app.purchase_return_rows',
        'app.purchase_vouchers',
        'app.sales_vouchers',
        'app.wallets',
        'app.delivery_charges',
        'app.delivery_times',
        'app.supplier_areas',
        'app.promotion_details',
        'app.item_active',
        'app.brands',
        'app.grn_rows',
        'app.items_variations',
        'app.home_screens',
        'app.express_deliveries'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('ItemVariationMasters') ? [] : ['className' => ItemVariationMastersTable::class];
        $this->ItemVariationMasters = TableRegistry::get('ItemVariationMasters', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ItemVariationMasters);

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