<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DeliveryDatesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DeliveryDatesTable Test Case
 */
class DeliveryDatesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\DeliveryDatesTable
     */
    public $DeliveryDates;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.delivery_dates'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('DeliveryDates') ? [] : ['className' => DeliveryDatesTable::class];
        $this->DeliveryDates = TableRegistry::get('DeliveryDates', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DeliveryDates);

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
