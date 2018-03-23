<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ClauseItem Entity
 *
 * @property int $article_id
 * @property int $section_id
 * @property int $clause_id
 * @property string $image_name
 *
 * @property \App\Model\Entity\Article $article
 * @property \App\Model\Entity\Section $section
 * @property \App\Model\Entity\Clause $clause
 */
class ClauseItem extends Entity
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
        'image_name' => true,
        'section' => true
    ];
}
