<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
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
        $this->loadComponent('Image', [
            'namerule' => 'sha1'
        ]);
    }

    /**
     * Called before the controller action. You can use this method to configure and customize components
     * or perform logic that needs to happen before each controller action.
     *
     * @param \Cake\Event\Event $event An Event instance
     * @return \Cake\Http\Response|null
     */
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['index']);
    }

    public function isAuthorized($user = null)
    {
        if ($user['enable'] == 1) {
            return true;
        }
        return false;
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
        $this->viewBuilder()->layout('post');
        
        $post = $this->Articles->find('view', ['Articles.id' => $id]);
        if ($post == null) {
            // error
        }
        $filepath = DS . ASSETS_PATH . DS . $post->project->uuid . DS;
        $post->setFilepath($filepath);
        
        $this->set(compact('post'));
        $this->set('_serialize', ['post']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $post = $this->Articles->newEntity([
            'points' => [
                ['tag' => 'point', 'item_order' => 0],
                ['tag' => 'point', 'item_order' => 1],
                ['tag' => 'point', 'item_order' => 2]
            ],
            'items' => [
                ['tag' => 'item', 'item_order' => 0],
                ['tag' => 'item', 'item_order' => 1],
                ['tag' => 'item', 'item_order' => 2]
            ]
        ]);
        
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $login_user_id = $this->Auth->user('id');
            
            if (isset($data['project_id']) != null) {
                $uuid = $this->Projects->find('list', [
                        'conditions' => [
                            'Projects.id' => $data['project_id']
                        ],
                        'valueField' => 'uuid',
                    ])
                    ->limit(1)
                    ->first();
            } else {
                // new projects
                $uuid = $this->Projects::uuid();
                $project = ['uuid' => $uuid];
                // publish
                if (isset($data['publish']) && ($data['publish'] == 1)) {
                    $project['status'] = 1;
                }
                // users join
                $project['users'] = [
                    [
                        'id' => $login_user_id,
                        '_joinData' => [
                            'role' => 'admin'
                        ]
                    ]
                ];
                $data['project'] = $project;
            }
            
            // default
            $data['author_id'] = $login_user_id;
            $data['status'] = 'publish';
            unset($data['publish']);
            
            // upload files
            $folder_path = WWW_ROOT . ASSETS_PATH . DS . $uuid;
            $this->uploads($data, $folder_path, $post);
            
            $post = $this->Articles->patchEntity($post, $data, ['associated' => ['Projects.Users', 'Points', 'Items']]);
            if ($this->Articles->save($post)) {
                $this->Flash->success(__('The post has been saved.'));

                return $this->redirect(['controller' => 'Posts', 'action' => 'edit', $post->id]);
            } else {
                $this->Flash->error(__('The post could not be saved. Please, try again.'));
            }
        }
        
        $this->set(compact('post'));
        $this->set('_serialize', ['post']);
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
        $post = $this->Articles->get($id, [
            'contain' => [
                'Projects',
                'Projects.Users',
                'Points' => function($q){
                    return $q->order(['item_order' => 'ASC'])->limit(6);
                },
                'Items' => function($q){
                    return $q->order(['item_order' => 'ASC'])->limit(6);
                }
            ]
        ]);
        $project = $post->project;
        $filepath = DS . ASSETS_PATH . DS . $project->uuid . DS;
        $post->setFilepath($filepath);
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            
            // upload files
            $folder_path = WWW_ROOT . ASSETS_PATH . DS . $project->uuid;
            $this->uploads($data, $folder_path, $post);
            
            $post = $this->Articles->patchEntity($post, $data);
            if ($this->Articles->save($post)) {
                $this->Flash->success(__('The post has been saved.'));
            } else {
                $this->Flash->error(__('The post could not be saved. Please, try again.'));
            }
        }
        
        // user admin
        $is_admin = false;
        $users = $project->users;
        $login_user_id = $this->Auth->user('id');
        foreach ($users as $user) {
            if (($user->id == $login_user_id) && ($user->_joinData->role == 'admin')) {
                $is_admin = true;
                break;
            }
        }
        
        $this->set(compact('post', 'project', 'is_admin'));
        $this->set('_serialize', ['post']);
    }
    
    /**
     * Uploads method
     *
     * @param array $data getData
     * @param string $folder_path folder path for image
     * @param Model\Entity\Article $post
     * @return $data
     */
    private function uploads(&$data, $folder_path, $post)
    {
        foreach ($data as $key => $dat) {
            if (!is_array($dat)) {
                continue;
            }
            if (array_values($dat) === $dat) {
                foreach ($dat as $i => $da) {
                    foreach ($da as $k => $d) {
                        if (isset($d['tmp_name'])) {
                            $disable_key = $k . '_disable';
                            if (isset($da[$disable_key]) && $da[$disable_key] == 1) {
                                unset($data[$key][$i][$k]);
                            } else if (empty($d['name'])) {
                                $data[$key][$i][$k] = null;
                            } else {
                                try {
                                    $success = $this->Image->uploadFile($folder_path, $d);
                                    if ($success) {
                                        $data[$key][$i][$k] = $d['name'];
                                    }
                                } catch (RuntimeException $e) {
                                    $id = $key . '_' . $i . '_' . $k;
                                    $post->setError($id, $e->getMessage());
                                }
                            }
                        }
                    }
                }
            } else if (isset($dat['tmp_name'])) {
                $disable_key = $key . '_disable';
                if (isset($data[$disable_key]) && $data[$disable_key] == 1) {
                    unset($data[$key]);
                } else if (empty($dat['name'])) {
                    $data[$key] = null;
                } else {
                    try {
                        $success = $this->Image->uploadFile($folder_path, $dat);
                        if ($success) {
                            $data[$key] = $dat['name'];
                        }
                    } catch (RuntimeException $e) {
                        $post->setError($key, $e->getMessage());
                    }
                }
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
