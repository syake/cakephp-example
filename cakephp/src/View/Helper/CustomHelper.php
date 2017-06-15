<?php
namespace App\View\Helper;
use Cake\View\Helper;

class CustomHelper extends Helper
{
    /**
     * Other helpers used by CustomHelper
     *
     * @var array
     */
    public $helpers = ['Form','Html'];
    
    public function upload($name, $options = array()) {
        $options = array_merge([
            'indent' => 0,
            't' => '',
            'help' => null,
            'remove' => __('Remove Image'),
            'default' => ''
        ], $options);
        $indent = $options['indent'];
        $t = $options['t'];
        
        $t0 = '';
        for ($i = 0; $i < $indent; $i++) {
            $t0 .= $t;
        }
        
        $id = str_replace('.', '_', $name);
        $input_id = $id . '_input';
        $result = '<div class="upload js-upload" id="' . $id . '"';
        if (!empty($options['default'])) {
            $result .= ' data-default="' . $options['default'] . '"';
        }
        $result .= '>' . PHP_EOL;
        $result .= $t0 . "{$t}" . '<div class="upload-empty">' . PHP_EOL;
        $result .= $t0 . "{$t}{$t}" . '<div class="upload-empty-container">' . PHP_EOL;
        $result .= $t0 . "{$t}{$t}{$t}" . '<div class="upload-empty-inner">' . PHP_EOL;
        $result .= $t0 . "{$t}{$t}{$t}{$t}" . '<label for="' . $input_id . '">' . PHP_EOL;
        $result .= $t0 . "{$t}{$t}{$t}{$t}{$t}" . $this->Form->hidden("{$name}_temp", ['class' => 'temp', 'value' => 0]) . PHP_EOL;
        $result .= $t0 . "{$t}{$t}{$t}{$t}{$t}" . $this->Form->button(__('Select file'), ['type' => 'button']) . PHP_EOL;
        $result .= $t0 . "{$t}{$t}{$t}{$t}{$t}" . $this->Form->file("{$name}[]", ['class' => 'file', 'id' => $input_id, 'data-id' => $id]) . PHP_EOL;
        $result .= $t0 . "{$t}{$t}{$t}{$t}" . '</label>' . PHP_EOL;
        $result .= $t0 . "{$t}{$t}{$t}" . '</div>' . PHP_EOL;
        $result .= $t0 . "{$t}{$t}" . '</div>' . PHP_EOL;
        $result .= $t0 . "{$t}" . '</div>' . PHP_EOL;
        $result .= $t0 . '</div>' . PHP_EOL;
        $result .= $t0 . $this->Form->error("{$id}");
        if (($options['indent'] != null) && !empty($options['indent'])) {
            $result .= '<p class="upload-help">' . $options['help'] . '</p>' . PHP_EOL;
        }
        $result .= $t0 . $this->Html->link($options['remove'], '#', ['class' => 'js-upload-delete', 'data-target' => "#{$id}"]);
        return $result;
    }
}
