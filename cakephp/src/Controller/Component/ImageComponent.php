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
        'size' => [
            'min_width' => 1024,
            'min_height' => 1024
        ]
    ];
    
    /**
     * upload file to the server
     * 
     * @param string $folder_path the folder to upload the file e.g. 'img/file'
     * @param array $file the file containing the form file
     * @param array $options [limit, name, namerule, resize]
     * @return array  will return an array with the success of each file upload
     * @throws \RuntimeException
     */
    public function upload($folder_path, &$file, $options = [])
    {
        extract($options = array_merge([
            'limit' => $this->_config['limit'],
            'name' => null,
            'namerule' => $this->_config['namerule'],
            'size' => $this->_config['size']
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
                if (($file_info->size() > $limit) && ($size == null)) {
                    if ($limit < pow(1024, 2)) {
                        $size_n = (round($limit / 1024)) . 'KB';
                    } else {
                        $size_n = (round($limit / pow(1024, 2))) . 'MB';
                    }
                    throw new RuntimeException(__('Exceeded filesize limit. (max size is {0})', [$size_n]));
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
        
        $success = false;
        $url = $folder->path . DS . $filename;
        if ($size != null) {
            if (isset($size['min_width']) && isset($size['min_height'])) {
                $success = $this->reduce($file['tmp_name'], $size['min_width'], $size['min_height'], $url);
            }
        }
        
        if ($success == false) {
            $success = move_uploaded_file($file['tmp_name'], $url);
        }
        
        if ($success && ($size != null)) {
            if (isset($size['width']) && isset($size['height'])) {
                $resize_name = $this->resize($url, $size['width'], $size['height']);
                if ($resize_name != null) {
                    $file['name'] = $resize_name;
                }
            }
        }
        return $success;
    }

    /**
     * resize image - aspect ratio fixed
     * 
     * @param string $file path to the image.
     * @param int $min_width
     * @param int $min_height
     * @param string $new_file
     */
    public function reduce(String $src_name, Int $min_width, Int $min_height, String $dst_name = null)
    {
        $src_image = $this->create($src_name);
        if (!$src_image) {
            return false;
        }
        
        $src_w = imagesx($src_image);
        $src_h = imagesy($src_image);
        if (($src_w < $min_width) && ($src_h < $min_height)) {
            return false;
        }
        
        $ratio = $src_w / $src_h;
        if ($src_w > $src_h) {
            // landscape orientation
            $dst_w = $min_width;
            $dst_h = $min_width / $ratio;
        } else {
            // portrait orientation
            $dst_w = $min_height * $ratio;
            $dst_h = $min_height;
        }
        
        $this->_resize($src_image, 0, 0, 0, 0, $dst_w, $dst_h, $src_w, $src_h, $src_name, $dst_name);
        imagedestroy($src_image);
        return true;
    }

    /**
     * resize image
     * 
     * @param string $file path to the image.
     * @param int $width
     * @param int $height
     * @return string new filename
     */
    public function resize(String $src_name, Int $width, Int $height)
    {
        if (($width == 0) || ($height == 0)) {
            return false;
        }
        
        $src_image = $this->create($src_name);
        if (!$src_image) {
            return false;
        }
        
        $info = pathinfo($src_name);
        $filename = $info['filename'] . "-{$width}x{$height}." . $info['extension'];
        $dst_name = $info['dirname'] . "/{$filename}";
        
        $dst_w = $width;
        $dst_h = $height;
        $src_w = imagesx($src_image);
        $src_h = imagesy($src_image);
        $src_ratio = $src_w / $src_h;
        $dst_ratio = $dst_w / $dst_h;
        if ($src_ratio > $dst_ratio) {
            // landscape orientation
            $src_w2 = floor($src_h * $dst_ratio);
            $src_x = floor(($src_w - $src_w2) / 2);
            $src_y = 0;
            $src_w = $src_w2;
        } else {
            // portrait orientation
            $src_h2 = floor($src_w / $dst_ratio);
            $src_x = 0;
            $src_y = floor(($src_h - $src_h2) / 2);
            $src_h = $src_h2;
        }
        
        $this->_resize($src_image, 0, 0, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h, $src_name, $dst_name);
        imagedestroy($src_image);
        return $filename;
    }

    /**
     * Create a new image from file or URL
     * 
     * @param string $filename path to the image.
     * @return image resource identifier on success, FALSE on errors.
     */
    private function create(String $filename)
    {
        $image_type = exif_imagetype($filename);
        switch ($image_type) {
            case IMAGETYPE_JPEG:
                $image = imagecreatefromjpeg($filename);
                break;
           case IMAGETYPE_PNG:
                $image = imagecreatefrompng($filename);
                break;
           case IMAGETYPE_GIF:
                $image = imagecreatefromgif($filename);
                break;
            default:
                $image = false;
                break;
        }
        return $image;
    }

    /**
     * Reisze
     * 
     * @param resource $src_image
     * @param int $dst_x
     * @param int $dst_y
     * @param int $src_x
     * @param int $src_y
     * @param int $dst_w
     * @param int $dst_h
     * @param int $src_w
     * @param int $src_h
     * @param string $src_name
     * @param string $dst_name
     */
    private function _resize($src_image, Int $dst_x, Int $dst_y, Int $src_x, Int $src_y, Int $dst_w, Int $dst_h, Int $src_w, Int $src_h, String $src_name, String $dst_name = null)
    {
        $dst_image = imagecreatetruecolor($dst_w, $dst_h);
        
        $image_type = exif_imagetype($src_name);
        switch ($image_type) {
           case IMAGETYPE_PNG:
                imagealphablending($dst_image, false);
                $transparent = imagecolorallocatealpha($dst_image, 0, 0, 0, 127);
                imagefill($dst_image, 0, 0, $transparent);
                imagesavealpha($dst_image, true);
                break;
           case IMAGETYPE_GIF:
                $transparent1 = imagecolortransparent($src_image);
                if ($transparent1 >= 0) {
                    $index = imagecolorsforindex($src_image, $transparent1);
                    $transparent2 = imagecolorallocate($dst_image, $index['red'], $index['green'], $index['blue']);
                    imagefill($dst_image, 0, 0, $transparent2);
                    imagecolortransparent($dst_image, $transparent2);
                }
                break;
            default:
                break;
        }
        imagecopyresampled($dst_image, $src_image, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);
        
        if ($dst_name == null) {
            $dst_name = $src_name;
        }
        switch ($image_type) {
            case IMAGETYPE_JPEG:
                imagejpeg($dst_image, $dst_name, 100);
                break;
            case IMAGETYPE_PNG:
                imagepng($dst_image, $dst_name);
                break;
            case IMAGETYPE_GIF:
                imagegif($dst_image, $dst_name);
                break;
            default:
                break;
        }
        
        imagedestroy($dst_image);
    }
}
