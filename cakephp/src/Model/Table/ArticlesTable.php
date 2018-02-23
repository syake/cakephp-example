<?php
namespace App\Model\Table;

/* use ArrayObject; */
/* use Cake\Event\Event; */
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Articles Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Projects
 * @property \Cake\ORM\Association\BelongsTo $Authors
 * @property \Cake\ORM\Association\HasMany $Sections
 *
 * @method \App\Model\Entity\Article get($primaryKey, $options = [])
 * @method \App\Model\Entity\Article newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Article[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Article|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Article patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Article[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Article findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ArticlesTable extends Table
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

        $this->setTable('articles');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Projects', [
            'foreignKey' => 'project_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'author_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('u', [
            'foreignKey' => 'author_id',
            'className' => 'Users',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Sections', [
            'foreignKey' => 'article_id',
            'dependent' => true
        ]);
        $this->hasMany('Points', [
            'foreignKey' => 'article_id',
            'className' => 'Sections',
            'conditions' => ['tag' => 'point'],
            'sort' => ['item_order' => 'ASC']
        ]);
        $this->hasMany('Items', [
            'foreignKey' => 'article_id',
            'className' => 'Sections',
            'conditions' => ['tag' => 'item'],
            'sort' => ['item_order' => 'ASC']
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
            ->requirePresence('status', 'create')
            ->allowEmpty('status');

        $validator
            ->allowEmpty('title');

        $validator
            ->allowEmpty('content');

        $validator
            ->allowEmpty('header_image');

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
        $rules->add($rules->existsIn(['project_id'], 'Projects'));
        $rules->add($rules->existsIn(['author_id'], 'Users'));

        return $rules;
    }

    public function findView(Query $query, array $options)
    {
        return $query->where($options)
            ->limit(1)
            ->contain('Projects')
            ->contain(['Points' => function($q){
                    return $q
                        ->where(['visible' => 1])
                        ->order(['item_order' => 'ASC'])
                        ->limit(6);
                }
            ])
            ->contain(['Items' => function($q){
                    return $q
                        ->where(['visible' => 1])
                        ->order(['item_order' => 'ASC'])
                        ->limit(6);
                }
            ])
            ->first();
    }
}
