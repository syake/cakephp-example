<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use Exception;

/**
 * Admin Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[] paginate($object = null, array $settings = [])
 */
class AuthController extends AppController
{
    protected $user = null;

    public $helpers = [
        'Form' => [
            'className' => 'Bootstrap.Form',
            'templates' => [
                'radioWrapper' => '{{label}}',
                'radio' => '<input type="radio" name="{{name}}" value="{{value}}" class="custom-control-input"{{attrs}}><span class="custom-control-indicator"></span><span class="custom-control-description">{{text}}</span>',
                'checkbox' => '<input type="checkbox" name="{{name}}" value="{{value}}" class="custom-control-input"{{attrs}}><span class="custom-control-indicator"></span><span class="custom-control-description">{{text}}</span>',
                'helpBlock' => '<small class="form-text text-muted">{{content}}</small>'
            ]
        ],
        'Html' => [
           'className' => 'Bootstrap.Html'
        ],
        'Modal' => [
           'className' => 'Bootstrap.Modal'
        ],
        'Navbar' => [
            'className' => 'Bootstrap.Navbar'
        ],
        'Paginator' => [
            'className' => 'Bootstrap.Paginator'
        ],
        'Panel' => [
            'className' => 'Bootstrap.Panel'
        ],
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
        $this->loadComponent('Auth', [
            'authorize' => 'Controller',
            'loginAction' => [
                'controller' => 'Users',
                'action' => 'login',
                'prefix' => false
            ],
            'loginRedirect' => '/',
            'logoutRedirect' => [
                'controller' => 'Users',
                'action' => 'login',
                'prefix' => false
            ]
        ]);

        $this->Users = TableRegistry::get('Users');
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

        $this->viewBuilder()->layout('logging_off');

        $user_id = $this->Auth->user('id');
        if ($user_id != null) {
            try {
                $user = $this->Users->get($user_id);
                $this->user = $user;
            } catch(Exception $e) {
                $this->request->session()->destroy();
                throw new ForbiddenException();
            }
            $this->viewBuilder()->layout('admin');
        }
    }

    public function isAuthorized($user = null)
    {
        return true;
    }

    /**
     * Called after the controller action is run, but before the view is rendered. You can use this method
     * to perform logic or set view variables that are required on every request.
     *
     * @param \Cake\Event\Event $event An Event instance
     * @return \Cake\Http\Response|null
     */
    public function beforeRender(Event $event)
    {
        parent::beforeRender($event);

        $user_id = $this->Auth->user('id');
        $user_name = $this->Auth->user('nickname');
        if (($user_name == null) || empty($user_name)) {
            $user_name = $this->Auth->user('username');
        }
        $this->set(compact('user_id', 'user_name'));
    }
}
