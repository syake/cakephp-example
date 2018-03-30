<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CellsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CellsTable Test Case
 */
class CellsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CellsTable
     */
    public $Cells;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.cells',
        'app.articles',
        'app.projects',
        'app.users',
        'app.projects_users',
        'app.images',
        'app.mainvisuals',
        'app.sections'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Cells') ? [] : ['className' => CellsTable::class];
        $this->Cells = TableRegistry::get('Cells', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Cells);

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
