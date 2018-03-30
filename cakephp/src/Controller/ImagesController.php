<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Datasource\ConnectionManager;
use Cake\Datasource\EntityInterface;
use Cake\Filesystem\Folder;
use Cake\Network\Exception\NotFoundException;
use Cake\ORM\TableRegistry;
use Exception;

/**
 * Images Controller
 *
 * @property \App\Model\Table\ImagesTable $Images
 *
 * @method \App\Model\Entity\Image[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ImagesController extends AppController
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
        $this->viewBuilder()->autoLayout(false);
        $this->autoRender = false;
    }

    /**
     * View method
     *
     * @param string|null $id Image id.
     * @param int|null $width
     * @param int|null $height
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null, $width = null, $height = null)
    {
        try {
            $image = $this->Images->get($id);
            $this->response->type($image->mime_type);
            if (($width !== NULL) && ($height !== NULL)) {
                $cache = $this->trimming($image, $width, $height);
                $this->response->body(file_get_contents($cache));
            } else {
                $ret = $image->data;
                $this->response->body(stream_get_contents($ret));
            }
        } catch(Exception $e) {
            throw new NotFoundException();
        }
    }

    /**
     * Triming method
     *
     * @param \Cake\Datasource\EntityInterface $image
     * @param int|null $width
     * @param int|null $height
     * @return image file String on success, FALSE on errors.
     */
    protected function trimming(EntityInterface $image, Int $width, Int $height)
    {
        $im = imagecreatefromstring(stream_get_contents($image->data));
        if ($im !== false) {
            $folder = new Folder(CACHE . 'posts' . DS . $image->name, true, 0755);
            $cache = $folder->path . DS . "{$width}-{$height}";
            if (file_exists($cache) !== false) {
                return $cache;
            }
            // trimming
            $bin_w = imagesx($im);
            $bin_h = imagesy($im);
            $bin_ratio = $bin_w / $bin_h;
            $ratio = $width / $height;
            if ($bin_ratio > $ratio) {
                // landscape orientation
                $bin_w2 = floor($bin_h * $ratio);
                $bin_x = floor(($bin_w - $bin_w2) / 2);
                $bin_y = 0;
                $bin_w = $bin_w2;
            } else {
                // portrait orientation
                $bin_h2 = floor($bin_w / $ratio);
                $bin_x = 0;
                $bin_y = floor(($bin_h - $bin_h2) / 2);
                $bin_h = $bin_h2;
            }

            $dst = imagecreatetruecolor($width, $height);
            switch ($image->mime_type) {
                case 'image/jpeg':
                    imagecopyresampled($dst, $im, 0, 0, $bin_x, $bin_y, $width, $height, $bin_w, $bin_h);
                    imagejpeg($dst, $cache, 100);
                    break;
                case 'image/png':
                    imagealphablending($dst, false);
                    $transparent = imagecolorallocatealpha($dst, 0, 0, 0, 127);
                    imagefill($dst, 0, 0, $transparent);
                    imagesavealpha($dst, true);
                    imagecopyresampled($dst, $im, 0, 0, $bin_x, $bin_y, $width, $height, $bin_w, $bin_h);
                    imagepng($dst, $cache);
                    break;
                case 'image/gif':
                    $transparent1 = imagecolortransparent($im);
                    if ($transparent1 >= 0) {
                        $index = imagecolorsforindex($im, $transparent1);
                        $transparent2 = imagecolorallocate($dst, $index['red'], $index['green'], $index['blue']);
                        imagefill($dst, 0, 0, $transparent2);
                        imagecolortransparent($dst, $transparent2);
                    }
                    imagecopyresampled($dst, $im, 0, 0, $bin_x, $bin_y, $width, $height, $bin_w, $bin_h);
                    imagegif($dst, $cache);
                    break;
                default:
                    $cache = false;
            }
        }
        if ($cache) {
            return $cache;
        }
        return false;
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function upload()
    {
        $image = $this->Images->newEntity();
        if ($this->request->is('post')) {
            $connection = ConnectionManager::get('default');
            $connection->begin();
            try {
                $image = $this->Images->patchEntity($image, $this->request->getData());
                if ($this->Images->save($image)) {
                    $this->response->body($image->name);
                }
                $this->Images->connection()->commit();
            } catch(Exception $e) {
                debug($e);
                $connection->rollback();
            }
        }
    }

    /**
     * Delete method
     *
     * @param string|null $id Image id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $image = $this->Images->get($id);
        if ($this->Images->delete($image)) {
            $this->Flash->success(__('The image has been deleted.'));
        } else {
            $this->Flash->error(__('The image could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
