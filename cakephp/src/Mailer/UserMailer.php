<?php
namespace App\Mailer;

use Cake\Mailer\Email;
use Cake\Mailer\Mailer;

/**
 * User mailer.
 */
class UserMailer extends Mailer
{

    /**
     * Mailer's name.
     *
     * @var string
     */
    static public $name = 'User';
    
    public function welcome($user)
    {
        $this->profile('default')
            ->to($user->email)
            ->subject('Welcome')
            ->layout('default');
        
        $this->viewVars([
          'user' => $user,
          'title' => 'CakePHPテスト用サービス',
          'info' => 'info@localhost',
          'url' => 'https://*****',
        ]);
    }
    
    public function resetPassword($user)
    {
        
    }
}
