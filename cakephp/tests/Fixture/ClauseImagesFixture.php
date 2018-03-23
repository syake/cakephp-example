<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ClauseImagesFixture
 *
 */
class ClauseImagesFixture extends TestFixture
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
        'image_file' => ['type' => 'binary', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'mime_type' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'clause_order' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['article_id', 'section_id', 'clause_id'], 'length' => []],
            'fk_clause_images_sections1' => ['type' => 'foreign', 'columns' => ['article_id', 'section_id'], 'references' => ['sections', '1' => ['article_id', 'section_id']], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
            'image_name' => 'Lorem ipsum dolor sit amet',
            'image_file' => 'Lorem ipsum dolor sit amet',
            'mime_type' => 'Lorem ipsum dolor sit amet',
            'clause_order' => 1
        ],
    ];
}
