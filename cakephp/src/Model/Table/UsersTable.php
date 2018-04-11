<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \App\Model\Table\ProjectsTable|\Cake\ORM\Association\BelongsToMany $Projects
 *
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UsersTable extends Table
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

        $this->setTable('users');
        $this->setDisplayField('username');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsToMany('Projects', [
            'foreignKey' => 'user_id',
            'targetForeignKey' => 'project_id',
            'joinTable' => 'projects_users',
            'dependent' => true
        ]);
        $this->hasMany('Articles', [
            'foreignKey' => 'author_id',
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
            ->maxLength('username', 50, __('Please enter no more than 50 characters.'))
            ->add('username', [
                'alphaNumeric' => [
                    'rule' => function ($value) {
                        return (preg_match('/^[0-9a-zA-Z][0-9a-zA-Z-]*$/i', $value) === 1);
                    },
                    'message' => __('This name may only contain alphanumeric characters or single hyphens, and cannot begin or end with a hyphen.')
                ],
                'unique' => [
                    'rule' => 'validateUnique',
                    'provider' => 'table',
                    'message' => __('This name is already used.')
                ]
            ])
            ->requirePresence('username', 'create')
            ->notEmpty('username', __('A username is required'));

        $validator
            ->email('email', false, __('Email is invalid or already taken'))
            ->ascii('email', __('Email is invalid or already taken'))
            ->requirePresence('email', 'create')
            ->notEmpty('email', __('A email is required'));

        $validator
            ->scalar('password')
            ->minLength('password', 4, __('Password is too short (minimum is 4 characters)'))
            ->maxLength('password', 255)
            ->requirePresence('password', 'create')
            ->notEmpty('password', __('A password is required'));

        $validator
            ->scalar('nickname')
            ->maxLength('nickname', 255)
            ->allowEmpty('nickname');

        $validator
            ->boolean('enable')
            ->allowEmpty('enable');

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
        $rules->add($rules->isUnique(['username']));
        $rules->add($rules->isUnique(['email']));

        return $rules;
    }
}
