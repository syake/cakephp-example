<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ClauseImage Entity
 *
 * @property int $article_id
 * @property int $section_id
 * @property int $clause_id
 * @property string $image_name
 * @property string|resource $image_file
 * @property string $mime_type
 * @property int $clause_order
 *
 * @property \App\Model\Entity\Article $article
 * @property \App\Model\Entity\Section $section
 * @property \App\Model\Entity\Clause $clause
 */
class ClauseImage extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'name' => true,
        'data' => true,
        'mime_type' => true,
        'clause_order' => true,
        'section' => true
    ];
}
