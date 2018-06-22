<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AppNotificationTokensTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AppNotificationTokensTable Test Case
 */
class AppNotificationTokensTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\AppNotificationTokensTable
     */
    public $AppNotificationTokens;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.app_notification_tokens'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('AppNotificationTokens') ? [] : ['className' => AppNotificationTokensTable::class];
        $this->AppNotificationTokens = TableRegistry::get('AppNotificationTokens', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->AppNotificationTokens);

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
