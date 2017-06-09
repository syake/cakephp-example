<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PostsUsersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PostsUsersTable Test Case
 */
class PostsUsersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\PostsUsersTable
     */
    public $PostsUsers;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.posts_users',
        'app.posts',
        'app.articles',
        'app.projects',
        'app.users',
        'app.projects_users',
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
        $config = TableRegistry::exists('PostsUsers') ? [] : ['className' => 'App\Model\Table\PostsUsersTable'];
        $this->PostsUsers = TableRegistry::get('PostsUsers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PostsUsers);

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
