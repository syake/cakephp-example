<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use \Exception;

/**
 * Admin Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[] paginate($object = null, array $settings = [])
 */
class AdminController extends AppController
{
    public $helpers = [
        'Form' => [
            'className' => 'Bootstrap.Form',
            'templates' => [
/*                 'formGroup' => '{{label}}<div class="radio-group">{{input}}</div>', */
                
                
                'nestingLabel' => '{{hidden}}<label class="custom-control custom-radio"{{attrs}}>{{input}}{{text}}</label>',
                'radioWrapper' => '{{label}}',
                'radio' => '<input type="radio" name="{{name}}" value="{{value}}" class="custom-control-input"{{attrs}}><span class="custom-control-indicator"></span><span class="custom-control-description">{{text}}</span>',
                'checkboxWrapper' => '{{label}}',
                'checkbox' => '<input type="checkbox" name="{{name}}" value="{{value}}" class="custom-control-input"{{attrs}}><span class="custom-control-indicator"></span><span class="custom-control-description">{{text}}</span>'
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
            ],
            'loginRedirect' => [
                'controller' => 'Users',
                'action' => 'index'
            ]
        ]);
        
        $this->Users = TableRegistry::get('Users');
        $this->Posts = TableRegistry::get('Posts');
        $this->PostsUsers = TableRegistry::get('PostsUsers');
        $this->Articles = TableRegistry::get('Articles');
        
        $this->viewBuilder()->layout('admin');
        $this->set('header', 'Admin/header');
        $this->set('style', 'index');
        
        $user_name = null;
        $user_id = null;
        $this->Session = $this->request->session();
        if ($this->Session->check('Auth.User')) {
            $user_id = $this->Session->read('Auth.User.id');
            $user = $this->Users->get($user_id);
            $user_name = $user->nickname;
            if (($user_name == null) || empty($user_name)) {
                $user_name = $user->username;
            }
        }
        $this->set(compact('user_name', 'user_id'));
    }

    public function isAuthorized($user = null)
    {
        return true;
    }
}
