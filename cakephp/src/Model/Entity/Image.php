<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Image Entity
 *
 * @property string $name
 * @property string|resource $data
 * @property string $mime_type
 * @property int $article_id
 * @property \Cake\I18n\FrozenTime $created
 *
 * @property \App\Model\Entity\Article $article
 */
class Image extends Entity
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
        'mime_type' => true,
        'article_id' => true,
        'created' => true,
        'article' => true
    ];
}
