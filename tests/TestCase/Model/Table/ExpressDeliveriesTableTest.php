<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ExpressDeliveriesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ExpressDeliveriesTable Test Case
 */
class ExpressDeliveriesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ExpressDeliveriesTable
     */
    public $ExpressDeliveries;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
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
        $config = TableRegistry::exists('ExpressDeliveries') ? [] : ['className' => ExpressDeliveriesTable::class];
        $this->ExpressDeliveries = TableRegistry::get('ExpressDeliveries', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ExpressDeliveries);

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
