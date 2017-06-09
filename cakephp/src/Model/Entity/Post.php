<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * Post Entity
 *
 * @property int $id
 * @property int $uuid
 * @property bool $publish
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Article[] $articles
 * @property \App\Model\Entity\User[] $users
 */
class Post extends Entity
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
        '*' => true,
        'id' => false
    ];

    protected function _getArticle()
    {
        if ($this->articles == null) {
            return '';
        }
        return $this->articles[0];
    }
    
    protected function _setArticle($value)
    {
        if ($this->articles != null) {
            $this->articles[0] = $value;
        }
    }
    
    protected function _getTitle()
    {
        if ($this->article == null) {
            return '';
        }
        return $this->article->title;
    }

    protected function _getContent()
    {
        if ($this->article == null) {
            return '';
        }
        return $this->article->content;
    }

    protected function _getAuthor()
    {
        if ($this->article == null) {
            return '';
        }
        $this->Users = TableRegistry::get('Users');
        $user = $this->Users->get($this->article->author_id);
        return $user->username;
    }
}
