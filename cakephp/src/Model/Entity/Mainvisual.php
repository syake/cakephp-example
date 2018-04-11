<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Mainvisual Entity
 *
 * @property int $article_id
 * @property int $id
 * @property string $image_name
 * @property string $title
 * @property string $description
 *
 * @property \App\Model\Entity\Article $article
 */
class Mainvisual extends Entity
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
        'title' => true,
        'description' => true,
        'article' => true
    ];
}
