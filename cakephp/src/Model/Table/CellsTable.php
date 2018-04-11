<?php
namespace App\Model\Table;

use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Cells Model
 *
 * @property \App\Model\Table\ArticlesTable|\Cake\ORM\Association\BelongsTo $Articles
 * @property \App\Model\Table\SectionsTable|\Cake\ORM\Association\BelongsTo $Sections
 *
 * @method \App\Model\Entity\Cell get($primaryKey, $options = [])
 * @method \App\Model\Entity\Cell newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Cell[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Cell|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Cell patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Cell[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Cell findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CellsTable extends Table
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

        $this->setTable('cells');
        $this->setDisplayField('title');
        $this->setPrimaryKey(['article_id', 'section_id', 'id']);

        $this->addBehavior('Timestamp');

        $this->belongsTo('Sections', [
            'foreignKey' => ['article_id', 'id'],
            'bindingKey' => ['article_id', 'section_id'],
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Images', [
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
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('title')
            ->maxLength('title', 64)
            ->allowEmpty('title');

        $validator
            ->scalar('description')
            ->allowEmpty('description');

        $validator
            ->scalar('image_name')
            ->maxLength('image_name', 255)
            ->allowEmpty('image_name');

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
        $rules->add($rules->existsIn(['article_id', 'section_id'], 'Sections'));
        $rules->add($rules->existsIn(['image_name'], 'Images'));

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
        if ($entity->isNew()) {
            $query = $this->find()->where(['article_id' => $entity->article_id, 'section_id' => $entity->section_id]);
            $ret = $query->select(['max_id' => $query->func()->max('id')])->first();
            $entity->set('id', $ret['max_id'] + 1);
        }
    }
}
