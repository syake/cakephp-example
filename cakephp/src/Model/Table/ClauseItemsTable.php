<?php
namespace App\Model\Table;

use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ClauseItems Model
 *
 * @property \App\Model\Table\ArticlesTable|\Cake\ORM\Association\BelongsTo $Articles
 * @property \App\Model\Table\SectionsTable|\Cake\ORM\Association\BelongsTo $Sections
 * @property \App\Model\Table\ClausesTable|\Cake\ORM\Association\BelongsTo $Clauses
 *
 * @method \App\Model\Entity\ClauseItem get($primaryKey, $options = [])
 * @method \App\Model\Entity\ClauseItem newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ClauseItem[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ClauseItem|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ClauseItem patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ClauseItem[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ClauseItem findOrCreate($search, callable $callback = null, $options = [])
 */
class ClauseItemsTable extends Table
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

        $this->setTable('clause_items');
        $this->setDisplayField('clause_id');
        $this->setPrimaryKey(['article_id', 'section_id', 'clause_id']);

        $this->belongsTo('Sections', [
            'foreignKey' => ['article_id', 'section_id'],
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
            $ret = $query->select(['max_id' => $query->func()->max('clause_id')])->first();
            $entity->set('clause_id', $ret['max_id'] + 1);
        }
    }
}
