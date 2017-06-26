<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use RuntimeException;

/**
 * Image component
 */
class ImageComponent extends Component
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [
        'limit' => 1024 * 1024,
        'namerule' => null
    ];
    
    /**
     * upload file to the server
     * 
     * @param string $folder_path the folder to upload the file e.g. 'img/file'
     * @param array $file the file containing the form file
     * @param array $options [limit, filename]
     * @return array  will return an array with the success of each file upload
     * @throws \RuntimeException
     */
    public function uploadFile($folder_path, &$file, $options = [])
    {
        $options = array_merge([
            'limit' => $this->_config['limit'],
            'name' => null,
            'namerule' => $this->_config['namerule']
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
        
        // create filename
        if ($options['name'] != null) {
            $filename = $options['name'];
        } else if ($options['namerule'] != null) {
            $ext = substr($file['name'], strrpos($file['name'], '.') + 1);
            $filename = hash_file($options['namerule'], $file['tmp_name']) . ".{$ext}";
        } else {
            $filename = $file['name'];
        }
        
        // replace spaces with underscores
        $filename = str_replace(' ', '_', $filename);
        $file['name'] = $filename;
        
        $url = $folder->path . DS . $filename;
        $success = move_uploaded_file($file['tmp_name'], $url);
        return $success;
    }
}
