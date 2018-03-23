<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ClauseItemsFixture
 *
 */
class ClauseItemsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'article_id' => ['type' => 'biginteger', 'length' => 20, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'section_id' => ['type' => 'biginteger', 'length' => 20, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'clause_id' => ['type' => 'biginteger', 'length' => 20, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'image_name' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        '_indexes' => [
            'fk_clause_items_images1_idx' => ['type' => 'index', 'columns' => ['image_name'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['article_id', 'section_id', 'clause_id'], 'length' => []],
            'fk_clause_items_images1' => ['type' => 'foreign', 'columns' => ['image_name'], 'references' => ['images', 'name'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_clause_items_sections1' => ['type' => 'foreign', 'columns' => ['article_id', 'section_id'], 'references' => ['sections', '1' => ['article_id', 'section_id']], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
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
            'section_id' => 1,
            'clause_id' => 1,
            'image_name' => 'Lorem ipsum dolor sit amet'
        ],
    ];
}
