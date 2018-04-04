<?php
namespace App\Model\Table;

use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Mainvisuals Model
 *
 * @property \App\Model\Table\ArticlesTable|\Cake\ORM\Association\BelongsTo $Articles
 *
 * @method \App\Model\Entity\Mainvisual get($primaryKey, $options = [])
 * @method \App\Model\Entity\Mainvisual newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Mainvisual[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Mainvisual|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Mainvisual patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Mainvisual[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Mainvisual findOrCreate($search, callable $callback = null, $options = [])
 */
class MainvisualsTable extends Table
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

        $this->setTable('mainvisuals');
        $this->setDisplayField('image_name');
        $this->setPrimaryKey(['article_id', 'id']);

        $this->belongsTo('Articles', [
            'foreignKey' => 'article_id',
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
            ->scalar('image_name')
            ->maxLength('image_name', 255)
            ->allowEmpty('image_name');

        $validator
            ->scalar('link_url')
            ->maxLength('link_url', 255)
            ->allowEmpty('link_url');

        $validator
            ->scalar('link_target')
            ->maxLength('link_target', 45)
            ->allowEmpty('link_target');

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
        if ($entity->isNew()) {
            $query = $this->find()->where(['article_id' => $entity->article_id]);
            $ret = $query->select(['max_id' => $query->func()->max('id')])->first();
            $entity->set('id', $ret['max_id'] + 1);
        }
    }
}
