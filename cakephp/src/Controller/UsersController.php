<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[] paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    public $paginate = [
        'limit' => 5,
        'order' => [
            'id' => 'DESC'
        ]
    ];

    public $helpers = [
        'Paginator' => [
            'templates' => [
                'first' => '<li class="page-item first"><a href="{{url}}" class="page-link" aria-label="Previous"><span aria-hidden="true">&laquo;</span><span class="sr-only">Previous</span></a></li>',
                'last' => '<li class="page-item last"><a href="{{url}}" class="page-link" aria-label="Next"><span aria-hidden="true">&raquo;</span><span class="sr-only">Next</span></a></li>',
                'number' => '<li class="page-item"><a href="{{url}}" class="page-link">{{text}}</a></li>',
                'current' => '<li class="page-item active"><a href="" class="page-link">{{text}}</a></li>',
                'sortAsc' => '<a class="asc" href="{{url}}">{{text}}<i class="fa fa-sort-asc" aria-hidden="true"></i></a>',
                'sortDesc' => '<a class="desc" href="{{url}}">{{text}}<i class="fa fa-sort-desc" aria-hidden="true"></i></a>'
            ]
        ]
    ];

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Auth', [
            'authorize' => 'Controller',
            'loginAction' => [
                'controller' => 'Users',
                'action' => 'login',
            ],
            'loginRedirect' => [
                'controller' => 'Users',
                'action' => 'index'
            ]
        ]);
        
        $this->viewBuilder()->layout('users');
        $this->set('header', 'Users/header');
        $this->set('style', 'index');
        
        $this->Session = $this->request->session();
        $id = $this->Session->read('Auth.User.id');
        $user = $this->Users->get($id);
        $screen_name = $user->nickname;
        if (($screen_name == null) || empty($screen_name)) {
            $screen_name = $user->username;
        }
        $this->set('user_name', $screen_name);
        $this->set('user_role', $user->role);
        $this->set('user_id', $id);
    }

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['add', 'logout']);
    }

    public function isAuthorized($user = null)
    {
        $action = $this->request->params['action'];
        if (in_array($action, ['lookup', 'delete'])) {
            if (isset($user['role']) && $user['role'] === 'admin') {
                return true;
            }
            return false;
        }
        return true;
    }

    public function index()
    {
        
    }

    /**
     * Rookup method
     *
     * @return \Cake\Http\Response|null
     */
    public function lookup()
    {
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
        $this->set('_serialize', ['users']);
        
        $this->set('topicpath_title', 'Home');
        $this->set('topicpath_link', '/users');
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->find('all', ['contitions' => ['role' => 'admin']])) {
                $user->set('role', 'invalid');
            } else {
                $user->set('role', 'admin');
            }
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                $this->Auth->setUser($user);

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
        
        $this->set('header', 'Users/header_add');
        $this->set('style', 'add');
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $is_profile = false;
        $current_id = $id;
        $user_id = $this->Session->read('Auth.User.id');
        if ($this->Session->read('Auth.User.role') == 'admin') {
            if (($id == null) || ($id == $user_id)) {
                $current_id = $user_id;
                $is_profile = true;
            }
        } else {
            $current_id = $user_id;
            $is_profile = true;
        }
        
        $user = $this->Users->get($current_id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
        
        if ($id == null) {
            $this->set('topicpath_title', 'Home');
            $this->set('topicpath_link', '/users');
        } else {
            $this->set('topicpath_title', 'List Users');
            $this->set('topicpath_link', '/users/lookup');
        }
        
        if (!$is_profile) {
            $this->render('edit_admin');
        }
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'lookup']);
    }

    public function login()
    {
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error(__('Invalid username or password, try again'));
        }
        
        $this->set('header', 'Users/header_login');
        $this->set('style', 'login');
    }

    public function logout()
    {
        $this->request->session()->destroy();
        return $this->redirect($this->Auth->logout());
    }
}
