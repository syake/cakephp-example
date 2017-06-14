<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * Article Entity
 *
 * @property int $id
 * @property int $project_id
 * @property int $author_id
 * @property string $status
 * @property string $title
 * @property string $content
 * @property string $header_image
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Project $project
 * @property \App\Model\Entity\Author $author
 * @property \App\Model\Entity\Section[] $sections
 */
class Article extends Entity
{
    private static $assets_path = 'assets';
    protected $_virtual = ['filepath'];

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
        '*' => true,
        'id' => false
    ];

    protected function _getAuthor()
    {
        $this->Users = TableRegistry::get('Users');
        $username = $this->Users->find('list', [
            'conditions' => ['id' => $this->author_id],
            'valueField' => 'username',
            'limit' => 1
        ])->first();
        return $username;
    }
    
    protected function _getHeaderImagePath()
    {
        $image = $this->header_image;
        if (empty($image)) {
            return '';
        }
        if ($this->filepath == null) {
            return $image;
        }
        return $this->filepath . $image;
    }

    public function init($uuid)
    {
        $filepath = DS . self::$assets_path . DS . $uuid . DS;
        $this->filepath = $filepath;
        $table_datas = [$this->sections, $this->points, $this->items];
        foreach ($table_datas as $table) {
            if ($table == null) {
                continue;
            }
            foreach ($table as $entity) {
                if ($entity != null) {
                    $entity->filepath = $filepath;
                }
            }
        }
    }
}
