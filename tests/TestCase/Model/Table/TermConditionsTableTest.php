<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TermConditionsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TermConditionsTable Test Case
 */
class TermConditionsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\TermConditionsTable
     */
    public $TermConditions;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.term_conditions'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('TermConditions') ? [] : ['className' => TermConditionsTable::class];
        $this->TermConditions = TableRegistry::get('TermConditions', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TermConditions);

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
