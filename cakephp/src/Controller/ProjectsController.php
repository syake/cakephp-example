<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use RuntimeException;

/**
 * Projects Controller
 *
 * @property \App\Model\Table\ProjectsTable $Projects
 *
 * @method \App\Model\Entity\Post[] paginate($object = null, array $settings = [])
 */
class ProjectsController extends AuthController
{
    private static $assets_path = 'assets';
    
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

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
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
            $post = $this->Articles->find('all', [
                'conditions' => [
                    'project_id' => $project_id,
                    'status' => 'publish'
                ],
                'limit' => 1,
                'contain' => ['Sections']
            ])->first();
        } else {
            $post = null;
        }
        
        if ($post == null) {
            return $this->redirect(['controller' => 'Pages', 'action' => 'display']);
        }
        
        $this->set(compact('post'));
        $this->set('_serialize', ['post']);
    }
    
    /**
     * View method
     *
     * @return \Cake\Http\Response|null
     */
    public function view($id = null)
    {
        $this->viewBuilder()->layout('post');
        $post = $this->Articles->get($id, [
            'contain' => ['Sections']
        ]);
        
        if ($post == null) {
            // error
        }
        
        $this->set(compact('post'));
        $this->set('_serialize', ['post']);
        $this->render('index');
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $project = $this->Projects->newEntity();
        if ($this->request->is('post')) {
            $user_id = $this->user_id;
            $uuid = $this->createUuid();
            $data = [
                'uuid' => $uuid,
                'users' => [
                    [
                        'id' => $user_id,
                        '_joinData' => [
                            'role' => 'admin'
                        ]
                    ]
                ]
            ];
            
            // articles
            $article = $this->request->getData();
            
            // upload
            $folder_path = WWW_ROOT . self::$assets_path . DS . $uuid;
            $article = $this->upload($article, $folder_path);
            
            // articles  marge
            $article = array_merge($article, [
                'author_id' => $user_id,
                'status' => 'publish',
            ]);
            $data['articles'] = [$article];
            
            // status
            if ($article['publish'] == 1) {
                $data['status'] = 1;
                unset($article['publish']);
            }
            
            $project = $this->Projects->patchEntity($project, $data, ['associated' => ['Users', 'Articles']]);
            if ($this->Projects->save($project)) {
                $this->Flash->success(__('The post has been saved.'));

                return $this->redirect(['controller' => 'Users', 'action' => 'index']);
            } else {
                $this->Flash->error(__('The post could not be saved. Please, try again.'));
            }
        }
        
        $post = $this->Articles->newEntity();
        $this->set(compact('post'));
        $this->set('_serialize', ['post']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Project id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $post = $this->Articles->get($id, [
            'contain' => ['Sections', 'Projects', 'Projects.Users']
        ]);
        $project = $post->project;
        $folder_url = self::$assets_path . DS . $project->uuid;
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            $folder_path = WWW_ROOT . $folder_url;
            
            // upload files
            $data = $this->upload($data, $folder_path, $id);
            
            $post = $this->Articles->patchEntity($post, $data);
            if ($this->Articles->save($post)) {
                $this->Flash->success(__('The post has been saved.'));
            } else {
                $this->Flash->error(__('The post could not be saved. Please, try again.'));
            }
        }
        
        // image absolute path
        $image_path = DS . $folder_url . DS;
        
        // user admin
        $is_admin = false;
        $users = $project->users;
        $user_id = $this->user_id;
        foreach ($users as $user) {
            if (($user->id == $user_id) && ($user->_joinData->role == 'admin')) {
                $is_admin = true;
                break;
            }
        }
        
        $this->set(compact('post', 'project', 'image_path', 'is_admin'));
        $this->set('_serialize', ['post']);
    }

    /**
     * Upload method
     *
     * @param array $data getData
     * @param string $folder_path folder path for image
     * @param string|null $id Project id.
     * @return $data
     */
    private function upload($data, $folder_path, $id = null)
    {
        $image_keys = ['header_image'];
        foreach ($image_keys as $key) {
            // delete files
            $temp_key = $key . '_temp';
            if (isset($data[$temp_key]) && ($data[$temp_key] == 0)) {
                $data[$key] = null;
            }
            unset($data[$temp_key]);
            
            // upload files
            if (isset($data[$key]) && ($data[$key] != null)) {
                if (is_array($data[$key])) {
                    $file = $data[$key][0];
                } else {
                    $file = $data[$key];
                }
                if (isset($file['name']) && !empty($file['name'])) {
                    $base_filename = $file['name'];
                    $ext = substr($base_filename, strrpos($base_filename, '.') + 1);
                    if ($id != null) {
                        $filename = $key . '-' . $id . '.' . $ext;
                    } else {
                        $filename = $key . '.' . $ext;
                    }
                    try {
                        $success = $this->uploadFile($folder_path, $file, ['name' => $filename]);
                        if ($success) {
                            $data[$key] = $filename;
                        }
                    } catch (RuntimeException $e) {
                        $post->setError($key, $e->getMessage());
                        unset($data[$key]);
                    }
                } else {
                    unset($data[$key]);
                }
            }
        }
        return $data;
    }

    /**
     * Setup method
     *
     * @param string|null $id Project id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function setup($id = null)
    {
        $project = $this->Projects->get($id, [
            'contain' => ['Users']
        ]);
        
        $user_id = $this->user_id;
        if ($project->hasAdmin($user_id) == false) {
            return $this->redirect(['controller' => 'Users', 'action' => 'index']);
        }
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            $is_error = false;
            $flash_key = 'flash';
            
            // join users
            $username = $this->request->data('users._username');
            if ($username != null) {
                $is_error = true;
                $flash_key = 'users';
                
                $user_id = $this->Users->find('list', [
                    'conditions' => ['username' => $username],
                    'limit' => 1
                ])->first();
                if ($user_id != null) {
                    $user_datas = [];
                    
                    // current join users
                    $is_duplicate = false;
                    $users = $project->users;
                    foreach($users as $user) {
                        if ($user_id == $user->id) {
                            $is_duplicate = true;
                        }
                        array_push($user_datas, ['id' => $user->id]);
                    }
                    
                    // add join user
                    if ($is_duplicate == false) {
                        $user_data = [
                            'id' => $user_id,
                            '_joinData' => [
                                'role' => 'author'
                            ]
                        ];
                        array_push($user_datas, $user_data);
                        $data['users'] = $user_datas;
                        $is_error = false;
                    }
                }
            }
            
            if ($is_error == false) {
                $project = $this->Projects->patchEntity($project, $data, ['associated' => ['Users']]);
                if ($this->Projects->save($project)) {
                    $this->Flash->success(__('The project has been saved.'), ['key' => $flash_key]);
                } else {
                    $this->Flash->error(__('The project could not be saved. Please, try again.'), ['key' => $flash_key]);
                }
            } else {
                $this->Flash->error(__('You cannot add a project as a member.'), ['key' => $flash_key]);
            }
        }
        
        $users = $project->users;
        $this->set(compact('project', 'users'));
        $this->set('_serialize', ['project']);
    }
    
    /**
     * Unjoin method
     *
     * @param string|null $id Project id.
     * @param string|null $user_id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function unjoin($id, $user_id)
    {
        $this->request->allowMethod(['post']);
        $post = $this->Projects->get($id, [
            'contain' => ['Users']
        ]);
        
        if ($post->hasAdmin($this->user_id) == false) {
            return $this->redirect($this->referer(), 303);
        }
        
        $data = $this->request->getData();
        $data['users'] = [];
        
        // current join users
        $users = $post->users;
        foreach($users as $user) {
            if ($user_id == $user->id) {
                continue;
            }
            array_push($data['users'], ['id' => $user->id]);
        }
        
        $post = $this->Projects->patchEntity($post, $data, ['associated' => ['Users']]);
        if ($this->Projects->save($post)) {
            $this->Flash->success(__('The post has been saved.'), ['key' => 'users']);
        } else {
            $this->Flash->error(__('The post could not be saved. Please, try again.'), ['key' => 'users']);
        }
        return $this->redirect($this->referer());
    }

    /**
     * Delete method
     *
     * @param string|null $id Project id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $project = $this->Projects->get($id);
        
        // assets folder delete
        $folder_path = WWW_ROOT . self::$assets_path . DS . $project->uuid;
        $folder = new Folder($folder_path);
        $folder->delete();
        
        if ($this->Projects->delete($project)) {
            $this->Flash->success(__('The post has been deleted.'));
        } else {
            $this->Flash->error(__('The post could not be deleted. Please, try again.'));
        }

        return $this->redirect(['controller' => 'Users', 'action' => 'index']);
    }

    /**
     * Create unique id
     * 
     * @return int
     */
    private function createUuid(){
        $max = 10 ** 6;
        if (function_exists('random_int')) {
            $uuid = random_int(1, ($max - 1));
        } else {
            $uuid = mt_rand(1, ($max - 1));
        }
        $uuid += (rand(1, 9) * $max);
        return $uuid;
    }
}
