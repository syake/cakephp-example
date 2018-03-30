<?php
namespace App\Model\Table;

use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Projects Model
 *
 * @property \App\Model\Table\ArticlesTable|\Cake\ORM\Association\HasMany $Articles
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsToMany $Users
 *
 * @method \App\Model\Entity\Project get($primaryKey, $options = [])
 * @method \App\Model\Entity\Project newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Project[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Project|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Project patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Project[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Project findOrCreate($search, callable $callback = null, $options = [])
 */
class ProjectsTable extends Table
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

        $this->setTable('projects');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Articles', [
            'foreignKey' => 'project_id',
            'dependent' => true,
            'cascadeCallbacks' => true
        ]);
        $this->belongsToMany('Users', [
            'foreignKey' => 'project_id',
            'targetForeignKey' => 'user_id',
            'joinTable' => 'projects_users'
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
            ->scalar('name')
            ->maxLength('name', 32)
            ->allowEmpty('name')
            ->add('name', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

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
            if (empty($entity->name)) {
                $entity->set('name', $this->_createName());
            }
        }
    }

    /**
     * Create unique id
     *
     * @return int
     */
    private function _createName($d = 7)
    {
        $max = 10 ** ($d - 1);
        if (function_exists('random_int')) {
            $uuid = random_int(1, ($max - 1));
        } else {
            $uuid = mt_rand(1, ($max - 1));
        }
        $uuid += (rand(1, 9) * $max);
        return $uuid;
    }

    public function findPosts(Query $query, array $options)
    {
        return $query
            ->matching('Users', function(Query $q) use ($options) {
                return $q->where([
                    'Users.id' => $options['user_id']
                ]);
            })
            ->innerJoinWith('Articles', function(Query $q) {
                return $q
                    ->where([
                        'OR' => [
                            ['Articles.status' => 1],
                            ['Articles.status' => 0]
                        ]
                    ])
                    ->leftJoinWith('Authors', function(Query $q2) {
                        return $q2->select(['username']);
                    })
                    ->select(['id', 'title', 'modified', 'author' => 'Authors.username']);
            })
            ->group(['Projects.id'])
            ->select([
                'project_id' => 'Projects.id',
                'name' => 'Projects.name',
                'id' => 'Articles.id',
                'title' => 'Articles.title',
                'status' => 'Articles.status',
                'modified' => 'Articles.modified',
                'author' => 'Articles.author'
            ])
            ->enableAutoFields(false);
    }
}
