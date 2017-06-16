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
 * @method \App\Model\Entity\Project[] paginate($object = null, array $settings = [])
 */
class ProjectsController extends AuthController
{
    public $helpers = ['Custom'];
    public $paginate = [
        'limit' => 5,
        'order' => [
            'id' => 'DESC'
        ]
    ];

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $id = $this->user_id;
        $projects = $this->Users->get($id, [
            'contain' => ['Projects', 'Projects.Articles', 'Projects.Users']
        ])->projects;
        
        $this->set(compact('projects'));
        $this->set('_serialize', ['projects']);
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
        $project = $this->Projects->get($id, [
            'contain' => ['Users']
        ]);
        
        $user_id = $this->user_id;
        if ($project->hasAdmin($user_id) == false) {
            return $this->redirect(['controller' => 'Projects', 'action' => 'index']);
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
        $project = $this->Projects->get($id, [
            'contain' => ['Users']
        ]);
        
        if ($project->hasAdmin($this->user_id) == false) {
            return $this->redirect($this->referer(), 303);
        }
        
        $data = $this->request->getData();
        $data['users'] = [];
        
        // current join users
        $users = $project->users;
        foreach($users as $user) {
            if ($user_id == $user->id) {
                continue;
            }
            array_push($data['users'], ['id' => $user->id]);
        }
        
        $project = $this->Projects->patchEntity($project, $data, ['associated' => ['Users']]);
        if ($this->Projects->save($project)) {
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
        $folder_path = WWW_ROOT . ASSETS_PATH . DS . $project->uuid;
        $folder = new Folder($folder_path);
        $folder->delete();
        
        if ($this->Projects->delete($project)) {
            $this->Flash->success(__('The post has been deleted.'));
        } else {
            $this->Flash->error(__('The post could not be deleted. Please, try again.'));
        }

        return $this->redirect(['controller' => 'Projects', 'action' => 'index']);
    }
}
