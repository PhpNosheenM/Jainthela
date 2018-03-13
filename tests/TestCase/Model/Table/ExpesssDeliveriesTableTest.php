<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ExpesssDeliveriesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ExpesssDeliveriesTable Test Case
 */
class ExpesssDeliveriesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ExpesssDeliveriesTable
     */
    public $ExpesssDeliveries;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.expesss_deliveries'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('ExpesssDeliveries') ? [] : ['className' => ExpesssDeliveriesTable::class];
        $this->ExpesssDeliveries = TableRegistry::get('ExpesssDeliveries', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ExpesssDeliveries);

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
}
