<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Article Entity
 *
 * @property int $id
 * @property int $project_id
 * @property int $author_id
 * @property int $status
 * @property string $title
 * @property string $content
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Project $project
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\User $author
 * @property \App\Model\Entity\Section[] $sections
 * @property \App\Model\Entity\ClauseImage[] $clause_images
 */
class Article extends Entity
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
        'project_id' => true,
        'author_id' => true,
        'status' => true,
        'title' => true,
        'content' => true,
        'created' => true,
        'modified' => true,
        'project' => true,
        'user' => true,
        'author' => true,
        'sections' => true,
        'clause_images' => true
    ];
}
