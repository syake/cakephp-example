<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Posts Controller
 *
 * @property \App\Model\Table\PostsTable $Posts
 *
 * @method \App\Model\Entity\Post[] paginate($object = null, array $settings = [])
 */
class PostsController extends AdminController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->viewBuilder()->layout('post');
        $uuid = $this->request->id;
        $post = $this->Posts->find('all', [
            'conditions' => ['uuid' => $uuid],
            'contain' => ['Articles']
        ])->first();
        
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
        $post = $this->Posts->newEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $data['uuid'] = $this->createUuid();
            
            $user_id = $this->request->getData('users._id');
            if ($user_id != null) {
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
                if (isset($data['articles']) && (count($data['articles']) > 0)) {
                    $article_data = $data['articles'][0];
                    $article_data['author_id'] = $user_id;
                    $article_data['status'] = 'publish';
                    $data['articles'][0] = $article_data;
                }
            }
            
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
     * Edit method
     *
     * @param string|null $id Post id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $post = $this->Posts->get($id, [
            'contain' => ['Users', 'Articles']
        ]);
        $article = $this->Posts->Articles->find('all', [
            'conditions' => [
                'post_id' => $post->id,
                'status' => 'publish'
            ]
        ])->first();
        if ($this->request->is(['patch', 'post', 'put'])) {
            if ($this->request->data('article') == 'update') {
                $article = $this->updateArticle($article);
            } else {
                $post = $this->updatePost($post);
            }
        }
        $users = $post->users;
        
        $user_id = $this->Session->read('Auth.User.id');
        $is_admin = false;
        foreach ($users as $user) {
            if (($user->id == $user_id) && ($user->_joinData->role == 'admin')) {
                $is_admin = true;
                break;
            }
        }
        
        $this->set(compact('post', 'article', 'users', 'is_admin'));
        $this->set('_serialize', ['post']);
    }

    private function updatePost($post)
    {
        $data = $this->request->getData();
        $flash_key = 'flash';
        
        // join users
        $has_error = false;
        if ($this->request->data('users._ids')) {
            $flash_key = 'users';
            $has_error = true;
            
            $username = $this->request->data('users._username');
            if ($username != null) {
                $user_id = $this->Users->find('list', [
                    'conditions' => ['username' => $username]
                ])->first();
                if ($user_id != null) {
                    $data['users'] = [];
                    $request_user_ids = $this->request->data('users._ids');
                    if ($request_user_ids != null) {
                        foreach ($request_user_ids as $request_user_id) {
                            array_push($data['users'], ['id' => $request_user_id]);
                        }
                    }
                    if (!in_array($user_id, $request_user_ids)) {
                        $user_data = [
                            'id' => $user_id,
                            '_joinData' => [
                                'role' => 'author'
                            ]
                        ];
                        array_push($data['users'], $user_data);
                        $has_error = false;
                    }
                }
            }
        }
        
        if ($has_error == false) {
            $post = $this->Posts->patchEntity($post, $data, ['associated' => ['Users']]);
            if ($this->Posts->save($post)) {
                $this->Flash->success(__('The post has been saved.'), ['key' => $flash_key]);
            } else {
                $this->Flash->error(__('The post could not be saved. Please, try again.'), ['key' => $flash_key]);
            }
        } else {
            $this->Flash->error(__('You cannot add a post as a member.'), ['key' => $flash_key]);
        }
        return $post;
    }

    private function updateArticle($article)
    {
        $data = $this->request->getData();
        $article = $this->Articles->patchEntity($article, $data);
        if ($this->Articles->save($article)) {
            $this->Flash->success(__('The post has been saved.'), ['key' => 'article']);
        } else {
            $this->Flash->error(__('The post could not be saved. Please, try again.'), ['key' => 'article']);
        }
        return $article;
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
