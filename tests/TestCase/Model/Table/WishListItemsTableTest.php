<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\WishListItemsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\WishListItemsTable Test Case
 */
class WishListItemsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\WishListItemsTable
     */
    public $WishListItems;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.wish_list_items',
        'app.wish_lists',
        'app.customers',
        'app.cities',
        'app.states',
        'app.app_notifications',
        'app.banners',
        'app.bulk_booking_leads',
        'app.carts',
        'app.categories',
        'app.items',
        'app.gst_figures',
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
        'app.admins',
        'app.roles',
        'app.combo_offers',
        'app.feedbacks',
        'app.plans',
        'app.wallets',
        'app.orders',
        'app.promotions',
        'app.return_orders',
        'app.orders_left',
        'app.plans_left',
        'app.promotions_left',
        'app.customer_addresses',
        'app.drivers',
        'app.grns',
        'app.journal_vouchers',
        'app.payments',
        'app.purchase_vouchers',
        'app.sales_vouchers',
        'app.sale_return_rows',
        'app.sales_invoice_rows',
        'app.brands',
        'app.grn_rows',
        'app.item_variation_masters',
        'app.promotion_details',
        'app.left_item_review_ratings',
        'app.average_review_ratings',
        'app.item_review_ratings',
        'app.items_variations',
        'app.home_screens',
        'app.api_versions',
        'app.express_deliveries',
        'app.item_active',
        'app.company_details',
        'app.delivery_charges',
        'app.delivery_times',
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
        $config = TableRegistry::exists('WishListItems') ? [] : ['className' => WishListItemsTable::class];
        $this->WishListItems = TableRegistry::get('WishListItems', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->WishListItems);

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
