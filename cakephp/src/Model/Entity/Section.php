<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Section Entity
 *
 * @property int $article_id
 * @property int $section_id
 * @property string $section_title
 * @property int $section_order
 *
 * @property \App\Model\Entity\Article $article
 * @property \App\Model\Entity\Image[] $images
 */
class Section extends Entity
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
        'section_title' => true,
        'section_order' => true,
        'article' => true,
        'items' => true
    ];
}
