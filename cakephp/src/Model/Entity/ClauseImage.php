<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ClauseImage Entity
 *
 * @property int $id
 * @property int $section_id
 * @property int $article_id
 * @property string|resource $data
 * @property string $mime
 * @property int $menu_order
 *
 * @property \App\Model\Entity\Section $section
 * @property \App\Model\Entity\Article $article
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
        'data' => true,
        'mime' => true,
        'menu_order' => true,
        'section' => true,
        'article' => true
    ];
}
