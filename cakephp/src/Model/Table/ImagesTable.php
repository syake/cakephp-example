<?php
namespace App\Model\Table;

use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Images Model
 *
 * @property \App\Model\Table\ArticlesTable|\Cake\ORM\Association\BelongsTo $Articles
 *
 * @method \App\Model\Entity\Image get($primaryKey, $options = [])
 * @method \App\Model\Entity\Image newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Image[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Image|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Image patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Image[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Image findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ImagesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('images');
        $this->setDisplayField('name');
        $this->setPrimaryKey('name');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Articles', [
            'foreignKey' => 'article_id'
        ]);
        $this->hasOne('Cells', [
            'foreignKey' => 'image_name',
            'joinType' => 'INNER'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->allowEmpty('name', 'create')
            ->add('name', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->allowEmpty('data');

        $validator
            ->scalar('mime_type')
            ->maxLength('mime_type', 255)
            ->allowEmpty('mime_type');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['name']));
        $rules->add($rules->existsIn(['article_id'], 'Articles'));

        return $rules;
    }

    /**
     * Before save listener.
     *
     * @param \Cake\Event\Event $event The beforeSave event that was fired
     * @param \Cake\Datasource\EntityInterface $entity The entity that is going to be saved
     * @return void
     */
    public function beforeSave(Event $event, EntityInterface $entity)
    {
        if ($entity->data['error'] === UPLOAD_ERR_OK) {
            $file = $entity->data;
            $entity->mime_type = $file['type'];
            $entity->name = uniqid();
            $max_width = $entity->max_width ?: 1080;
            $max_height = $entity->max_height ?: 1080;
            $entity->data = $this->_buildBlob($file, $max_width, $max_height);
        } else {
            unset($entity->data);
        }
    }
    /**
     * Create blob data from file or URL
     *
     * @param array $file the file containing the form file
     * @param int $min_width
     * @param int $min_height
     * @return image resource identifier on success, FALSE on errors.
     */
    protected function _buildBlob($file, Int $min_width = 0, Int $min_height = 0)
    {
        $ret = file_get_contents($file['tmp_name']);
        if ($ret === false) {
            throw new RuntimeException('Can not get thumbnail image.');
        }
        // resize - aspect ratio fixed
        if ($min_width > 0 && $min_height > 0) {
            $cache = CACHE . uniqid();
            list($bin_w, $bin_h, $image_type) = getimagesize($file['tmp_name']);
            $ratio = $bin_w / $bin_h;
            if ($bin_w > $bin_h) {
                // landscape orientation
                $width = $min_width;
                $height = $min_width / $ratio;
            } else {
                // portrait orientation
                $width = $min_height * $ratio;
                $height = $min_height;
            }
            $dst = imagecreatetruecolor($width, $height);
            switch ($image_type) {
                case IMAGETYPE_JPEG:
                    $src = imagecreatefromjpeg($file['tmp_name']);
                    imagecopyresampled($dst, $src, 0, 0, 0, 0, $width, $height, $bin_w, $bin_h);
                    imagejpeg($dst, $cache, 100);
                    break;
               case IMAGETYPE_PNG:
                    $src = imagecreatefrompng($file['tmp_name']);
                    imagealphablending($dst, false);
                    imagesavealpha($dst, true);
                    imagecopyresampled($dst, $src, 0, 0, 0, 0, $width, $height, $bin_w, $bin_h);
                    imagepng($dst, $cache);
                    break;
               case IMAGETYPE_GIF:
                    $src = imagecreatefromgif($file['tmp_name']);
                    $transparent1 = imagecolortransparent($src);
                    if ($transparent1 >= 0) {
                        $index = imagecolorsforindex($src, $transparent1);
                        $transparent2 = imagecolorallocate($dst, $index['red'], $index['green'], $index['blue']);
                        imagefill($dst, 0, 0, $transparent2);
                        imagecolortransparent($dst, $transparent2);
                    }
                    imagecopyresampled($dst, $src, 0, 0, 0, 0, $width, $height, $bin_w, $bin_h);
                    imagegif($dst, $cache);
                    break;
                default:
                    $cache = false;
                    break;
            }
            if ($cache) {
                $ret = file_get_contents($cache);
                unlink($cache);
            }
            imagedestroy($dst);
        }

        return $ret;
    }
}
