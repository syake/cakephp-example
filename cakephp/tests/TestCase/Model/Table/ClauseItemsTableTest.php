<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ClauseItemsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ClauseItemsTable Test Case
 */
class ClauseItemsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ClauseItemsTable
     */
    public $ClauseItems;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.clause_items',
        'app.articles',
        'app.projects',
        'app.users',
        'app.projects_users',
        'app.authors',
        'app.sections',
        'app.images',
        'app.clauses'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('ClauseItems') ? [] : ['className' => ClauseItemsTable::class];
        $this->ClauseItems = TableRegistry::get('ClauseItems', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ClauseItems);

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
