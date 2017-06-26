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
        'namerule' => null,
        'resize' => [
            'min_width' => 1024,
            'min_height' => 1024
        ]
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
    public function upload($folder_path, &$file, $options = [])
    {
        extract($options = array_merge([
            'limit' => $this->_config['limit'],
            'name' => null,
            'namerule' => $this->_config['namerule'],
            'resize' => $this->_config['resize']
        ], $options));
        
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
                if (($file_info->size() > $limit) && ($resize == null)) {
                    if ($limit < pow(1024, 2)) {
                        $size = (round($limit / 1024)) . 'KB';
                    } else {
                        $size = (round($limit / pow(1024, 2))) . 'MB';
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
        
        if ($resize != null) {
            $this->resize($file['tmp_name'], $resize['min_width'], $resize['min_height']);
        }
        
        // create filename
        if ($name != null) {
            $filename = $name;
        } else if ($namerule != null) {
            $ext = substr($file['name'], strrpos($file['name'], '.') + 1);
            $filename = hash_file($namerule, $file['tmp_name']) . ".{$ext}";
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

    /**
     * resize image
     * 
     * @param string $file the file e.g. 'img/file'
     * @param int $min_width
     * @param int $min_height
     */
    public function resize($file, $min_width = 1024, $min_height = 1024)
    {
        $image_type = exif_imagetype($file);
        switch ($image_type) {
            case IMAGETYPE_JPEG:
                $image = imagecreatefromjpeg($file);
                break;
           case IMAGETYPE_PNG:
                $image = imagecreatefrompng($file);
                break;
           case IMAGETYPE_GIF:
                $image = imagecreatefromgif($file);
                break;
            default:
                return;
                break;
        }
        
        $width = imagesx($image);
        $height = imagesy($image);
        if (($width < $min_width) && ($height < $min_height)) {
            return;
        }
        
        $ratio = $width / $height;
        if ($width > $height) {
            $new_width = $min_width;
            $new_height = $min_width / $ratio;
        } else {
            $new_width = $min_height * $ratio;
            $new_height = $min_height;
        }
        
        $new_image = imagecreatetruecolor($new_width, $new_height);
        switch ($image_type) {
           case IMAGETYPE_PNG:
                imagealphablending($new_image, false);
                $transparent = imagecolorallocatealpha($new_image, 0, 0, 0, 127);
                imagefill($new_image, 0, 0, $transparent);
                imagesavealpha($new_image, true);
                break;
           case IMAGETYPE_GIF:
                $transparent1 = imagecolortransparent($image);
                if ($transparent1 >= 0) {
                    $index = imagecolorsforindex($image, $transparent1);
                    $transparent2 = imagecolorallocate($new_image, $index['red'], $index['green'], $index['blue']);
                    imagefill($new_image, 0, 0, $transparent2);
                    imagecolortransparent($new_image, $transparent2);
                }
                break;
            default:
                break;
        }
        imagecopyresized($new_image, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
        
        switch ($image_type) {
            case IMAGETYPE_JPEG:
                imagejpeg($new_image, $file, 100);
                break;
           case IMAGETYPE_PNG:
                imagepng($new_image, $file);
                break;
           case IMAGETYPE_GIF:
                imagegif($new_image, $file);
                break;
            default:
                break;
        }
        
        imagedestroy($image);
        imagedestroy($new_image);
    }
}
