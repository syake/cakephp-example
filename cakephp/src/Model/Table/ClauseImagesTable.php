<?php
namespace App\Model\Table;

use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ClauseImages Model
 *
 * @property \App\Model\Table\ArticlesTable|\Cake\ORM\Association\BelongsTo $Articles
 * @property \App\Model\Table\SectionsTable|\Cake\ORM\Association\BelongsTo $Sections
 * @property \App\Model\Table\ClausesTable|\Cake\ORM\Association\BelongsTo $Clauses
 *
 * @method \App\Model\Entity\ClauseImage get($primaryKey, $options = [])
 * @method \App\Model\Entity\ClauseImage newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ClauseImage[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ClauseImage|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ClauseImage patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ClauseImage[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ClauseImage findOrCreate($search, callable $callback = null, $options = [])
 */
class ClauseImagesTable extends Table
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

        $this->setTable('clause_images');
        $this->setDisplayField('name');
        $this->setPrimaryKey(['article_id', 'section_id', 'clause_id']);

        $this->belongsTo('Articles', [
            'foreignKey' => 'article_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Sections', [
            'foreignKey' => ['article_id', 'section_id'],
            'bindingKey' => ['article_id', 'section_id'],
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
            ->allowEmpty('name');

        $validator
            ->allowEmpty('data');

        $validator
            ->scalar('mime_type')
            ->maxLength('mime_type', 255)
            ->allowEmpty('mime_type');

        $validator
            ->integer('clause_order')
            ->allowEmpty('clause_order');

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
            $ret = $query->select(['max_id' => $query->func()->max('clause_id')])->first();
            $entity->set('clause_id', $ret['max_id'] + 1);
        }
    }
}
