<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProjectsUsersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProjectsUsersTable Test Case
 */
class ProjectsUsersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ProjectsUsersTable
     */
    public $ProjectsUsers;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.projects_users',
        'app.projects',
        'app.articles',
        'app.users',
        'app.cells',
        'app.sections',
        'app.images',
        'app.mainvisuals'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('ProjectsUsers') ? [] : ['className' => ProjectsUsersTable::class];
        $this->ProjectsUsers = TableRegistry::get('ProjectsUsers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ProjectsUsers);

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
