<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use \Exception;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[] paginate($object = null, array $settings = [])
 */
class UsersController extends AdminController
{
    public $paginate = [
        'limit' => 5,
        'order' => [
            'id' => 'DESC'
        ]
    ];

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
        return parent::isAuthorized($user);
    }

    public function index()
    {
        $id = $this->Session->read('Auth.User.id');
        $user = $this->Users->get($id, [
            'contain' => ['Projects']
        ]);
        $projects = $user->projects;
        if (count($projects) > 0) {
            $has_project = true;
        } else {
            $has_project = false;
        }
        
        $this->set(compact('projects', 'has_project'));
        $this->set('_serialize', ['projects']);
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
            if ($this->Users->find('all', ['conditions' => ['role' => 'admin']])) {
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
        $this->set('header', 'Admin/header_add');
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
        if ($this->Session->read('Auth.User.role') == 'admin') {
            $this->setAction('editAdmin', $id);
            return;
        }
        
        $id = $this->Session->read('Auth.User.id');
        $user = $this->Users->get($id, [
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
        $this->set('backto_list', false);
    }

    public function editAdmin($id = null){
        $user_id = $this->Session->read('Auth.User.id');
        if (($id == null) || ($id == $user_id)) {
            $current_id = $user_id;
            $is_profile = true;
        } else {
            $current_id = $id;
            $is_profile = false;
        }
        
        if ($this->Users->exists(['id' => $current_id]) == false) {
            return $this->redirect(['action' => 'lookup']);
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
        if ($is_profile) {
            if ($id == null) {
                $this->set('backto_list', false);
            } else {
                $this->set('backto_list', true);
            }
            $this->render('edit');
        } else {
            $this->render('edit_user');
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
        
        $this->set('header', 'Admin/header_login');
        $this->set('style', 'login');
    }

    public function logout()
    {
        $this->request->session()->destroy();
        return $this->redirect($this->Auth->logout());
    }
}
