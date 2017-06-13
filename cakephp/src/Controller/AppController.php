<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use RuntimeException;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
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

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');

        /*
         * Enable the following components for recommended CakePHP security settings.
         * see http://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');
        //$this->loadComponent('Csrf');
    }

    /**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return \Cake\Network\Response|null|void
     */
    public function beforeRender(Event $event)
    {
        if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }
    }

    /**
     * upload file to the server
     * 
     * @param string $folder_path the folder to upload the file e.g. 'img/file'
     * @param array $file the file containing the form file
     * @param array $options [limit, filename]
     * @return array  will return an array with the success of each file upload
     * @throws \RuntimeException
     */
    protected function uploadFile(String $folder_path, Array $file, Array $options = [])
    {
        $options = array_merge([
            'limit' => 1024 * 1024,
            'name' => null
        ], $options);
        
        switch ($file['error']) {
            case 0:
                // list of permitted file types, this is only images but documents can be added
                $has_type = false;
                $permitted = ['image/gif', 'image/jpeg', 'image/pjpeg', 'image/png'];
                foreach ($permitted as $type) {
                    if($type == $file['type']) {
                        $has_type = true;
                        break;
                    }
                }
                if ($has_type == false) {
                    // unacceptable file type
                    throw new RuntimeException(__('This file cannot be uploaded. Acceptable file types: gif, jpg, png.'));
                }
                
                // file size
                $file_info = new File($file["tmp_name"], false);
                if ($file_info->size() > $options['limit']) {
                    if ($options['limit'] < pow(1024, 2)) {
                        $size = (round($options['limit'] / 1024)) . 'KB';
                    } else {
                        $size = (round($options['limit'] / pow(1024, 2))) . 'MB';
                    }
                    throw new RuntimeException(__('Exceeded filesize limit. (max size is {0})', [$size]));
                }
                
                break;
            case 3:
                // an error occured
                throw new RuntimeException(__('Error uploading this file. Please try again.'));
                break;
            case 4:
                // no file was selected for upload
                throw new RuntimeException(__('No file Selected.'));
                break;
            default:
                // an error occured
                throw new RuntimeException(__('System error uploading this file. Contact webmaster.'));
                break;
        }
        
        // check already exists
        
        // setup dir names absolute and relative. and create the folder.
        $folder = new Folder($folder_path, true, 0755);
        
        // replace spaces with underscores
        $filename = $options['name'];
        if ($filename == null) {
            $filename = str_replace(' ', '_', $file['name']);
        }
        
        $url = $folder->path . DS . $filename;
        $success = move_uploaded_file($file['tmp_name'], $url);
        return $success;
    }
}
