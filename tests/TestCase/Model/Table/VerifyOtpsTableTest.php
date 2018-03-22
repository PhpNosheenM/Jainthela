<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\VerifyOtpsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\VerifyOtpsTable Test Case
 */
class VerifyOtpsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\VerifyOtpsTable
     */
    public $VerifyOtps;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
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
        $config = TableRegistry::exists('VerifyOtps') ? [] : ['className' => VerifyOtpsTable::class];
        $this->VerifyOtps = TableRegistry::get('VerifyOtps', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->VerifyOtps);

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
