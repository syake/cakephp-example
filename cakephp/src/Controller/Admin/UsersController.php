<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[] paginate($object = null, array $settings = [])
 */
class UsersController extends \App\Controller\AuthController
{
    public $paginate = [
        'limit' => 10,
        'order' => [
            'id' => 'DESC'
        ]
    ];

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->set('header', 'Users/header_admin');
    }

    public function isAuthorized($user = null)
    {
        if ($user != null) {
            if ($user['role'] == 'admin') {
                return parent::isAuthorized($user);
            }
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
        $query = $this->Users->find()->contain(['Projects']);
        $users = $this->paginate($query);
        
        $this->set(compact('users'));
        $this->set('_serialize', ['users']);
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
        if ($id == $this->user_id) {
            return $this->redirect(['controller' => 'Users', 'action' => 'edit', 'prefix' => false, $id], 303);
        }
        
        if ($this->request->data('_password')) {
            $flash_key = 'password';
        } else {
            $flash_key = 'flash';
        }
        
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'), ['key' => $flash_key]);
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'), ['key' => $flash_key]);
            }
        }
        
        $this->set('referer', 'users');
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Activate method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function activate($id = null)
    {
        $this->request->allowMethod(['post']);
        $user = $this->Users->get($id);
        $user->set('status',1);
        if ($this->Users->save($user)) {
            $this->Flash->success(__('The user has been changed.'));
        } else {
            $this->Flash->error(__('The user could not be changed. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Deactivate method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function deactivate($id = null)
    {
        $this->request->allowMethod(['post']);
        $user = $this->Users->get($id);
        $user->set('status',0);
        if ($this->Users->save($user)) {
            $this->Flash->success(__('The user has been changed.'));
        } else {
            $this->Flash->error(__('The user could not be changed. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
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

        return $this->redirect(['action' => 'index']);
    }
}
