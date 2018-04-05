<?php
namespace App\Controller;

use Cake\ORM\Query;
use App\Controller\AppController;
use Cake\Datasource\ConnectionManager;
use Cake\Event\Event;
use Cake\Filesystem\Folder;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\RecordNotFoundException;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use Exception;
use RuntimeException;

/**
 * Posts Controller
 *
 * @property \App\Model\Table\ArticlesTable $Articles
 *
 * @method \App\Model\Entity\Post[] paginate($object = null, array $settings = [])
 */
class PostsController extends AuthController
{
    public $helpers = ['Custom'];
    public $paginate = [
        'limit' => 10,
        'sortWhitelist' => [
            'id',
            'status',
            'Articles.title',
            'Articles.modified'
        ]
    ];

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
        $this->Projects = TableRegistry::get('Projects');
        $this->Articles = TableRegistry::get('Articles');
        $this->Images = TableRegistry::get('Images');

        $this->loadComponent('Image', [
            'namerule' => 'sha1',
            'size' => [
                'min_width' => 1024,
                'min_height' => 1024
            ]
        ]);
    }

    /**
     * Called before the controller action. You can use this method to configure and customize components
     * or perform logic that needs to happen before each controller action.
     *
     * @param \Cake\Event\Event $event An Event instance
     * @return \Cake\Http\Response|null
     */
/*
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['index']);
    }
*/

    public function isAuthorized($user = null)
    {
        if ($this->user->enable == 1) {
            return true;
        }
        return false;
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $query = $this->Projects->find('posts', ['user_id' => $this->user->id]);
        $posts = $this->paginate($query);
        $this->set(compact('posts'));
        $this->set('_serialize', ['posts']);
    }

    /**
     * Display method
     *
     * @param string|null $id Article id.
     * @return \Cake\Http\Response|null
     */
    public function display($id = null)
    {
        $this->viewBuilder()->setLayout('post');
        $uuid = $this->request->id;
        $project_id = $this->Projects->find('list', [
            'conditions' => [
                'uuid' => $uuid,
                'status' => 1
            ],
            'valueField' => 'id',
            'limit' => 1
        ]);

        if ($project_id != null) {
            $post = $this->Articles->find('view', ['Articles.project_id' => $project_id]);
        } else {
            $post = null;
        }

        if ($post == null) {
            return $this->redirect(['controller' => 'Pages', 'action' => 'display']);
        }
        $filepath = DS . ASSETS_PATH . DS . $uuid . DS;
        $post->setFilepath($filepath);

        $this->set(compact('post'));
        $this->set('_serialize', ['post']);
        $this->render('view');
    }

    /**
     * View method
     *
     * @param string|null $id Article id.
     * @return \Cake\Http\Response|null
     */
    public function view($id = null)
    {
        if ($this->request->is(['patch', 'post', 'put'])) {
            $post = $this->Articles->get($id, [
                'contain' => [
                    'Mainvisuals',
                    'Sections',
                    'Sections.Cells',
                ]
            ]);
            $post = $this->Articles->patchEntity($post, $this->request->getData(), [
                'validate' => false,
                'associated' => [
                    'Mainvisuals',
                    'Sections',
                    'Sections.Cells'
                ]
            ]);
        } else {
            throw new RecordNotFoundException();
        }
        $this->set('post', $post);
        $this->viewBuilder()->setLayout(false);
        $this->render('/Posts/view');
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->user;
        $user->_joinData = new Entity(['role' => 'admin'], ['markNew' => true]);
        $post = $this->Articles->newEntity([
            'title' => 'Welcome to my page',
            'description' => 'コンテンツ内容です',
            'author_id' => $this->user->id,
            'project' => [
                'users' => [$user]
            ]
        ]);
        if ($this->request->is('post')) {
            $post = $this->Articles->patchEntity($post, $this->request->getData(), [
                'associated' => [
                    'Projects',
                    'Mainvisuals',
                    'Sections',
                    'Sections.Cells',
                ]
            ]);
            if ($this->save($post)) {
                return $this->redirect(['action' => 'edit', $post->id]);
            }
        }

        $this->set(compact('post'));
        $this->set('_serialize', ['post']);
        $this->viewBuilder()->setLayout('admin_editor');
        $this->render('/Posts/editor');
    }

    /**
     * Edit method
     *
     * @param string|null $id Article id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user_id = $this->user->id;
        $post = $this->Articles->find()
            ->matching('Projects.Users', function(Query $q) use ($user_id) {
                return $q->where([
                    'Users.id' => $user_id
                ]);
            })
            ->where(['Articles.id' => $id])
            ->contain([
                'Projects',
                'Mainvisuals',
                'Sections',
                'Sections.Cells'
            ])
            ->enableAutoFields(true)
            ->first();

        if ($post == NULL) {
            throw new ForbiddenException();
        }
        if ($this->request->is(['patch', 'post', 'put'])) {
            $post = $this->Articles->patchEntity($post, $this->request->getData(), [
                'associated' => [
                    'Mainvisuals',
                    'Sections',
                    'Sections.Cells'
                ]
            ]);
            $post->set('author_id', $this->user->id);
            if ($this->save($post)) {
                return $this->redirect(['action' => 'edit', $post->id]);
            }
        }

        $this->set(compact('post'));
        $this->set('_serialize', ['post']);
        $this->viewBuilder()->setLayout('admin_editor');
        $this->render('/Posts/editor');

        // Image filter
        $this->filter($post->project->id);
    }

    /**
     * Save method
     *
     * @param Model\Entity\Article $post
     * @return bool
     */
    protected function save($post)
    {
        $connection = ConnectionManager::get('default');
        $connection->begin();
        try {
            if ($success = $this->Articles->save($post, [
                'associated' => [
                    'Projects',
                    'Projects.Users',
                    'Mainvisuals',
                    'Sections',
                    'Sections.Cells'
                ]
            ])) {
                $this->Flash->success(__('The post has been saved.'));
            } else {
                $this->log(print_r($post->errors(),true), LOG_DEBUG);
                debug($post->errors());
                $this->Flash->error(__('The post could not be saved. Please, try again.'));
            }
            $this->Articles->connection()->commit();
            if ($success) {
                return true;
            }
        } catch(Exception $e) {
            $this->Flash->error($e);
            debug($e);
            $connection->rollback();
        }
        return false;
    }

    /**
     * Filter method
     *
     * @param string|null $id Project id.
     */
    protected function filter($id)
    {
        $images = $this->Images->find('list')
            ->where(['Images.project_id' => $id])
            ->notMatching('Cells')
            ->notMatching('Mainvisuals')
            ->toArray();

        if (count($images) > 0) {
            $names = array_values($images);
            $conditions = ['OR' => []];
            foreach ($names as $name) {
                $conditions['OR'][] = ['name' => $name];
            }
            $connection = ConnectionManager::get('default');
            $connection->begin();
            try {
                if ($this->Images->deleteAll($conditions)) {
                    // The image has been deleted.
                    foreach ($names as $name) {
                        $folder = new Folder(CACHE . 'posts' . DS . $name);
                        $folder->delete();
                    }
                }
                $this->Images->connection()->commit();
            } catch(Exception $e) {
                debug($e);
                $connection->rollback();
            }
        }
    }

    /**
     * Delete method
     *
     * @param string|null $id Article id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $post = $this->Articles->get($id);
        if ($this->Articles->delete($post)) {
            $this->Flash->success(__('The post has been deleted.'));
        } else {
            $this->Flash->error(__('The post could not be deleted. Please, try again.'));
        }

        return $this->redirect(['controller' => 'Projects', 'action' => 'index']);
    }
}
