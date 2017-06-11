<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;

/**
 * Admin Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[] paginate($object = null, array $settings = [])
 */
class AuthController extends AppController
{
    protected $user_id = null;
    
    public $helpers = [
        'Form' => [
            'className' => 'Bootstrap.Form',
            'templates' => [
                'nestingLabel' => '{{hidden}}<label class="custom-control custom-radio"{{attrs}}>{{input}}{{text}}</label>',
                'radioWrapper' => '{{label}}',
                'radio' => '<input type="radio" name="{{name}}" value="{{value}}" class="custom-control-input"{{attrs}}><span class="custom-control-indicator"></span><span class="custom-control-description">{{text}}</span>',
                'checkboxWrapper' => '{{label}}',
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
            'loginRedirect' => [
                'controller' => 'Users',
                'action' => 'index',
                'prefix' => false
            ],
            'logoutRedirect' => [
                'controller' => 'Users',
                'action' => 'login',
                'prefix' => false
            ]
        ]);
        
        $this->Users = TableRegistry::get('Users');
        $this->Posts = TableRegistry::get('Posts');
        $this->Articles = TableRegistry::get('Articles');
    }

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        
        $this->viewBuilder()->layout('admin');
        $this->set('header', 'Users/header');
        $this->set('style', 'index');
    }

    public function isAuthorized($user = null)
    {
        if ($user != null) {
            $user_id = $user['id'];
            if ($this->Users->exists(['id' => $user_id])) {
                $user_name = $user['nickname'];
                if (($user_name == null) || empty($user_name)) {
                    $user_name = $user['username'];
                }
                $this->set(compact('user_name', 'user_id'));
                $this->user_id = $user_id;
                return true;
            }
        }
        return false;
    }
}
