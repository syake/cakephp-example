<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Cell Entity
 *
 * @property int $article_id
 * @property int $section_id
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $image_name
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Article $article
 * @property \App\Model\Entity\Section $section
 */
class Cell extends Entity
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
        'title' => true,
        'description' => true,
        'image_name' => true,
        'created' => true,
        'modified' => true,
        'section' => true,
        'image' => true
    ];
}
