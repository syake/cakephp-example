<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Mailer\MailerAwareTrait;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[] paginate($object = null, array $settings = [])
 */
class UsersController extends AuthController
{
    use MailerAwareTrait;

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
        $this->Auth->allow(['add', 'login', 'logout']);

        if ($this->user != NULL) {
            $action = $this->request->params['action'];
            if (in_array($action, ['add', 'login'])) {
//                 var_dump($this->user);
//                 return $this->redirect('/');
            }
        }
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
            if ($this->Users->find('list', ['conditions' => ['enable' => 1]])->first() == null) {
                $user->set('enable', 1);
            }

            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                $this->Auth->setUser($user);
                $this->getMailer('User')->send('welcome', [$user]);

                return $this->redirect('/');
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
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
        if ($this->request->data('_password')) {
            $flash_key = 'password';
        } else if ($this->request->data('_email')) {
            $flash_key = 'email';
        } else {
            $flash_key = 'flash';
        }

        $login_user_id = $this->Auth->user('id');
        $user = $this->Users->get($login_user_id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'), ['key' => $flash_key]);
                $this->Auth->setUser($user);
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'), ['key' => $flash_key]);
            }
        }

        if (($id != null) && ($user['role'] == 'admin')) {
            $this->set('referer', 'users');
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    public function login()
    {
        $this->viewBuilder()->layout('login');
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error(__('Invalid username or password, try again'));
        }
        $this->render('/Users/login');
    }

    public function logout()
    {
        $this->request->session()->destroy();
        return $this->redirect($this->Auth->logout());
    }
}
