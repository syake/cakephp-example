<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * MainvisualsFixture
 *
 */
class MainvisualsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'article_id' => ['type' => 'biginteger', 'length' => 20, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'id' => ['type' => 'biginteger', 'length' => 20, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'image_name' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'link_url' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'link_target' => ['type' => 'string', 'length' => 45, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        '_indexes' => [
            'fk_mainvisuals_images1_idx' => ['type' => 'index', 'columns' => ['image_name'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['article_id', 'id'], 'length' => []],
            'fk_mainvisuals_articles1' => ['type' => 'foreign', 'columns' => ['article_id'], 'references' => ['articles', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_mainvisuals_images1' => ['type' => 'foreign', 'columns' => ['image_name'], 'references' => ['images', 'name'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'article_id' => 1,
            'id' => 1,
            'image_name' => 'Lorem ipsum dolor sit amet',
            'link_url' => 'Lorem ipsum dolor sit amet',
            'link_target' => 'Lorem ipsum dolor sit amet'
        ],
    ];
}
