<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ClauseImages Model
 *
 * @property \App\Model\Table\SectionsTable|\Cake\ORM\Association\BelongsTo $Sections
 * @property \App\Model\Table\ArticlesTable|\Cake\ORM\Association\BelongsTo $Articles
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
        $this->setDisplayField('id');
        $this->setPrimaryKey(['id', 'section_id', 'article_id']);

        $this->belongsTo('Sections', [
            'foreignKey' => 'section_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Articles', [
            'foreignKey' => 'article_id',
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
            ->requirePresence('data', 'create')
            ->notEmpty('data');

        $validator
            ->scalar('mime')
            ->maxLength('mime', 255)
            ->requirePresence('mime', 'create')
            ->notEmpty('mime');

        $validator
            ->integer('menu_order')
            ->allowEmpty('menu_order');

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
        $rules->add($rules->existsIn(['section_id'], 'Sections'));
        $rules->add($rules->existsIn(['article_id'], 'Articles'));

        return $rules;
    }
}
