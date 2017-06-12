<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Posts Controller
 *
 * @property \App\Model\Table\PostsTable $Posts
 *
 * @method \App\Model\Entity\Post[] paginate($object = null, array $settings = [])
 */
class PostsController extends AuthController
{
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
        $this->viewBuilder()->layout('post');
        $uuid = $this->request->id;
        $post_id = $this->Posts->find('list', [
            'conditions' => ['uuid' => $uuid],
            'valueField' => 'id',
            'limit' => 1
        ])->first();
        $post = $this->Articles->find('all', [
            'conditions' => [
                'post_id' => $post_id,
                'status' => 'status'
            ],
            'contain' => ['Sections']
        ])->first();
        
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
        $post = $this->Posts->newEntity();
        if ($this->request->is('post')) {
            $user_id = $this->user_id;
            $data = $this->request->getData();
            $data['uuid'] = $this->createUuid();
            
            // join users
            $data['users'] = [
                [
                    'id' => $user_id,
                    '_joinData' => [
                        'role' => 'admin'
                    ]
                ]
            ];
            
            // articles  marge
            $data['articles'] = [
                [
                  'title' => $data['title'],
                  'content' => $data['content'],
                  'author_id' => $user_id,
                  'status' => 'publish',
                ]
            ];
            
            $post = $this->Posts->patchEntity($post, $data, ['associated' => ['Users', 'Articles']]);
            if ($this->Posts->save($post)) {
                $this->Flash->success(__('The post has been saved.'));

                return $this->redirect(['controller' => 'users', 'action' => 'index']);
            } else {
                $this->Flash->error(__('The post could not be saved. Please, try again.'));
            }
        }
        $users = $this->Posts->Users->find('list', ['limit' => 200]);
        $this->set(compact('post', 'users'));
        $this->set('_serialize', ['post']);
    }

    /**
     * Setup method
     *
     * @param string|null $id Post id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function setup($id = null)
    {
        $post = $this->Posts->get($id, [
            'contain' => ['Users']
        ]);
        
        $user_id = $this->user_id;
        if ($post->hasAdmin($user_id) == false) {
            return $this->redirect(['controller' => 'Users', 'action' => 'index']);
        }
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            $flash_key = 'flash';
            $is_duplicate = false;
            
            // join users
            $username = $this->request->data('users._username');
            if ($username != null) {
                $flash_key = 'users';
                
                $user_id = $this->Users->find('list', [
                    'conditions' => ['username' => $username],
                    'limit' => 1
                ])->first();
                if ($user_id != null) {
                    $data['users'] = [];
                    
                    // current join users
                    $users = $post->users;
                    foreach($users as $user) {
                        if ($user_id == $user->id) {
                            $is_duplicate = true;
                        }
                        array_push($data['users'], ['id' => $user->id]);
                    }
                    
                    // add join user
                    if ($is_duplicate == false) {
                        $user_data = [
                            'id' => $user_id,
                            '_joinData' => [
                                'role' => 'author'
                            ]
                        ];
                        array_push($data['users'], $user_data);
                    }
                }
            }
            
            if ($is_duplicate == false) {
                $post = $this->Posts->patchEntity($post, $data, ['associated' => ['Users']]);
                if ($this->Posts->save($post)) {
                    $this->Flash->success(__('The post has been saved.'), ['key' => $flash_key]);
                } else {
                    $this->Flash->error(__('The post could not be saved. Please, try again.'), ['key' => $flash_key]);
                }
            } else {
                $this->Flash->error(__('You cannot add a post as a member.'), ['key' => $flash_key]);
            }
        }
        
        $users = $post->users;
        $this->set(compact('post', 'users'));
        $this->set('_serialize', ['post']);
    }
    
    public function unjoin($id, $user_id)
    {
        $this->request->allowMethod(['post']);
        $post = $this->Posts->get($id, [
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
        
        $post = $this->Posts->patchEntity($post, $data, ['associated' => ['Users']]);
        if ($this->Posts->save($post)) {
            $this->Flash->success(__('The post has been saved.'), ['key' => 'users']);
        } else {
            $this->Flash->error(__('The post could not be saved. Please, try again.'), ['key' => 'users']);
        }
        return $this->redirect($this->referer());
    }

    /**
     * Edit method
     *
     * @param string|null $id Post id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $article = $this->Articles->get($id, [
            'contain' => ['Sections', 'Posts', 'Posts.Users']
        ]);
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            $article = $this->Articles->patchEntity($article, $data);
            if ($this->Articles->save($article)) {
                $this->Flash->success(__('The post has been saved.'));
            } else {
                $this->Flash->error(__('The post could not be saved. Please, try again.'));
            }
        }
        
        $post = $article->post;
        $users = $post->users;
        
        $is_admin = false;
        $user_id = $this->user_id;
        foreach ($users as $user) {
            if (($user->id == $user_id) && ($user->_joinData->role == 'admin')) {
                $is_admin = true;
                break;
            }
        }
        
        $this->set(compact('post', 'article', 'is_admin'));
        $this->set('_serialize', ['post']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Post id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $post = $this->Posts->get($id);
        if ($this->Posts->delete($post)) {
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
