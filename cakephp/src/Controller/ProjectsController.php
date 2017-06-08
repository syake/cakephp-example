<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Projects Controller
 *
 * @property \App\Model\Table\ProjectsTable $Projects
 *
 * @method \App\Model\Entity\Project[] paginate($object = null, array $settings = [])
 */
class ProjectsController extends AdminController
{
/*
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['display']);
    }
*/

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        return $this->redirect(['controller' => 'users', 'action' => 'index']);
    }

    /**
     * Display method
     *
     * @param string|null $id Project id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function display($id = null)
    {
        $this->viewBuilder()->layout('default');
        $uuid = $this->request->id;
        $project = $this->Projects->find('all', [
            'conditions' => ['uuid' => $uuid],
            'contain' => ['Articles']
        ])->first();
        
        $this->set('project', $project);
        $this->set('_serialize', ['project']);
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
            
            
            $data = $this->request->getData();
            $data['uuid'] = $this->createUuid();
            
            // join users
            $user_id = $this->request->getData('users._id');
            if ($user_id != null) {
                $data['users'] = [
                    [
                        'id' => $user_id,
                        '_joinData' => [
                            'role' => 'admin'
                        ]
                    ]
                ];
            }
            
            // article
/*
            $article = $this->Articles->newEntity();
            if ($this->Articles->save($article)) {
                $data['article_id'] = $article->id;
            } else {
                $this->Flash->error(__('The article could not be saved. Please, try again.'));
            }
*/
            
            $project = $this->Projects->patchEntity($project, $data, ['associated' => ['Users']]);
            if ($this->Projects->save($project)) {
                $this->Flash->success(__('The project has been saved.'));

                return $this->redirect(['controller' => 'users', 'action' => 'index']);
            } else {
                $this->Flash->error(__('The project could not be saved. Please, try again.'));
            }
        }
        $users = $this->Projects->Users->find('list', ['limit' => 200]);
        $this->set(compact('project', 'users'));
        $this->set('_serialize', ['project']);
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
            'contain' => ['Users', 'Articles']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            $has_error = false;
            
            // join users
            $username = $this->request->getData('users._username');
            if ($username != null) {
                $user_id = $this->Users->find('list', [
                    'conditions' => ['username' => $username]
                ])->first();
                if ($user_id != null) {
                    $data['users'] = [];
                    $request_user_ids = $this->request->getData('users._ids');
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
                    } else {
                        $this->Flash->error(__('You cannot add a project as a member.'));
                        $has_error = true;
                    }
                } else {
                    $this->Flash->error(__('You cannot add a project as a member.'));
                    $has_error = true;
                }
            }
            
            if ($has_error == false) {
                $project = $this->Projects->patchEntity($project, $data, ['associated' => ['Users']]);
                if ($this->Projects->save($project)) {
                    $this->Flash->success(__('The project has been saved.'));
                } else {
                    $this->Flash->error(__('The project could not be saved. Please, try again.'));
                }
            }
        }
        $users = $project->users;
        $article = $project->articles[0];
        $this->set(compact('project', 'users', 'article'));
        $this->set('_serialize', ['project']);
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
        if ($this->Projects->delete($project)) {
            $this->Flash->success(__('The project has been deleted.'));
        } else {
            $this->Flash->error(__('The project could not be deleted. Please, try again.'));
        }

        return $this->redirect(['controller' => 'Users', 'action' => 'index']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    private function addArticle()
    {
        $article = $this->Articles->newEntity();
        if ($this->request->is('post')) {
            $article = $this->Articles->patchEntity($article, $this->request->getData());
            if ($this->Articles->save($article)) {
                $this->Flash->success(__('The article has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The article could not be saved. Please, try again.'));
        }
        $this->set(compact('article'));
        $this->set('_serialize', ['article']);
    }

    /**
     * Create unique id
     * 
     * @return int
     */
    private function createUuid(){
        if (function_exists('random_int')) {
            $uuid = random_int(1, 999999999);
        } else {
            $uuid = mt_rand(1, 999999999);
        }
        $uuid += (rand(1, 9) * 1000000000);
        return $uuid;
    }
}
