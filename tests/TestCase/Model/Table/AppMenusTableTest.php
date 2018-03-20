<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AppMenusTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AppMenusTable Test Case
 */
class AppMenusTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\AppMenusTable
     */
    public $AppMenus;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.app_menus'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('AppMenus') ? [] : ['className' => AppMenusTable::class];
        $this->AppMenus = TableRegistry::get('AppMenus', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->AppMenus);

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
