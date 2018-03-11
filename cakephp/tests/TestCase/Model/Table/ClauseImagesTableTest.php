<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ClauseImagesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ClauseImagesTable Test Case
 */
class ClauseImagesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ClauseImagesTable
     */
    public $ClauseImages;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.clause_images',
        'app.sections',
        'app.articles',
        'app.projects',
        'app.users',
        'app.projects_users',
        'app.u',
        'app.points',
        'app.items'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('ClauseImages') ? [] : ['className' => ClauseImagesTable::class];
        $this->ClauseImages = TableRegistry::get('ClauseImages', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ClauseImages);

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
